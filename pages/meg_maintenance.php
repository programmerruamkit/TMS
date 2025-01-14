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
    array('select_employee', SQLSRV_PARAM_IN),
    array($conditionEHR, SQLSRV_PARAM_IN)
);
$query_seEHR = sqlsrv_query($conn, $sql_seEHR, $params_seEHR);
$result_seEHR = sqlsrv_fetch_array($query_seEHR, SQLSRV_FETCH_ASSOC);


                                     
            
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


                    if (!$('#txt_editaffter1').val()) //check empty input filed
                    {
                        $("#output2").html("Are you kidding me?");
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


            <?php
            $conditionEHR1 = " AND a.PersonID ='" . $_SESSION["EMPLOYEEID"] . "'";
            $sql_seEHR1 = "{call megEmployeeEHR_v2(?,?)}";
            $params_seEHR1 = array(
                array('select_employee', SQLSRV_PARAM_IN),
                array($conditionEHR1, SQLSRV_PARAM_IN)
            );
            $query_seEHR1 = sqlsrv_query($conn, $sql_seEHR1, $params_seEHR1);
            $result_seEHR1 = sqlsrv_fetch_array($query_seEHR1, SQLSRV_FETCH_ASSOC);

            $readonly_rtd = ($result_seEHR1['Company_Code'] != 'RTD') ? " disabled readonly style='background-color: #f080802e'" : "";
            $readonly_tenko = ($result_seEHR1['Company_Code'] == 'RTD') ? " disabled readonly style='background-color: #f080802e'" : "";
            ?>
            <div id="page-wrapper">
                <p>&nbsp;</p>

                <div id="datade_edit">
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #e7e7e7">
                                    <a href="meg_employee2.php">จัดการรับแจ้ง</a> / ข้อมูลการรับแจ้ง
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
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>ผู้รับแจ้งซ่อม</label>
                                                                        <input <?= $readonly_tenko ?>  class="form-control" type="text" id="txt_empinform1" name="txt_empinform1" value="">
                                                                        <input style="display: none"  name="txt_chkbefore1"  id="txt_chkbefore1" type="text" class="form-control"/>
                                                                        <input  style="display: none" name="txt_chkaffter1"  id="txt_chkaffter1" type="text" class="form-control"/>
                                                                    </div>

                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>ทะเบียนรถ</label>
                                                                        <input <?= $readonly_tenko ?> class="form-control" type="text" id="txt_carname" name="txt_carname"  value="" >

                                                                    </div>

                                                                </div>

                                                            </div>
                                                            <div class="row" >

                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <label>ปัญหา</label>
                                                                        <textarea <?= $readonly_tenko ?> class="form-control" autocomplete="off" rows="5" id="txt_issue" name="txt_issue" ></textarea>


                                                                    </div>

                                                                </div>

                                                            </div>
                                                            <div class="row" >

                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>สถานะการซ่อม</label>
                                                                        <select class="form-control" id="cb_repairstatus1" name="cb_repairstatus1" <?= $readonly_tenko ?>>
                                                                            <option   value ="">เลือกสถานะการซ่อม</option>
                                                                            <option   value ="แจ้งซ่อม">แจ้งซ่อม</option>
                                                                            <option   value ="ยกเลิกแจ้งซ่อม">ยกเลิกแจ้งซ่อม</option>

                                                                        </select>
                                                                    </div>

                                                                </div>
                                                                <form action="meg_imagebefore1.php" method="post" enctype="multipart/form-data" id="MyUploadForm1">
                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <label>ก่อนแก้ไข</label>
                                                                            <input  <?= $readonly_tenko ?> name="image_editbefore1"  id="txt_editbefore1" type="file" class="form-control"/>
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <div class="form-group">
                                                                            <label>&nbsp;</label><br>


                                                                            <input type="submit" <?= $readonly_tenko ?> id="submit-btn" value="Upload" onclick="chk_uploadbefore1()" class="btn btn-default"/>


                                                                        </div>

                                                                    </div>
                                                                </form>


                                                            </div>
                                                            <div class="row" style="height: 150px">

                                                                <div class="col-lg-12" id="output1"></div>

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
                                                        <label>เจ้าหน้าที่ ผู้รับแจ้งซ่อม : <?= ($result_seEHR1['Company_Code'] == 'RTD') ? $result_seEHR1['nameT'] : ''; ?></label>
                                                    </div>
                                                    <!-- /.panel-heading -->
                                                    <div class="panel-body" >

                                                        <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                            <div class="row" >

                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>ผู้รับแจ้งซ่อม</label>
                                                                        <input  class="form-control" style="background-color: #f080802e" disabled="" readonly=""  <?= $readonly_rtd ?> id="txt_empinform2" name="txt_empinform2"  value="" >

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
                                                                        <label>กำหนดเสร็จ</label>
                                                                        <input  class="form-control dateen" <?= $readonly_rtd ?> readonly="" id="txt_completed" name="txt_completed"  value="" >

                                                                    </div>

                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>สาเหตุ</label>
                                                                        <input class="form-control" <?= $readonly_rtd ?> id="txt_cause" name="txt_cause"  value="" >

                                                                    </div>

                                                                </div>

                                                            </div>
                                                            <div class="row" >


                                                            </div>
                                                            <div class="row" >
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>การแก้ไข</label>
                                                                        <input class="form-control" <?= $readonly_rtd ?> id="txt_edit" name="txt_edit"  value="">

                                                                    </div>

                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>การป้องกัน</label>
                                                                        <input class="form-control" <?= $readonly_rtd ?> id="txt_protect" name="txt_protect"  value="">

                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="row" >
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>สถานะการซ่อม</label>
                                                                        <select class="form-control" id="cb_repairstatus2" name="cb_repairstatus2" <?= $readonly_rtd ?>>
                                                                            <option   value ="">เลือกสถานะการซ่อม</option>
                                                                            <option   value ="กำลังซ่อม">กำลังซ่อม</option>
                                                                            <option   value ="ซ่อมเสร็จ">ซ่อมเสร็จ</option>
                                                                            <option   value ="ยกเลิกซ่อม">ยกเลิกซ่อม</option>

                                                                        </select>
                                                                    </div>

                                                                </div>
                                                                <form action="meg_imageaffter1.php" method="post" enctype="multipart/form-data" id="MyUploadForm2">
                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <label>หลังแก้ไข</label>
                                                                            <input <?= $readonly_rtd ?> class="form-control"  type="file" name="image_editaffter1"  id="txt_editaffter1" >

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <div class="form-group">
                                                                            <label>&nbsp;</label><br>


                                                                            <input type="submit" <?= $readonly_rtd ?> id="submit-btn" onclick="chk_uploadaffter1()" value="Upload" class="btn btn-default"/>


                                                                        </div>

                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="row" style="height: 150px">

                                                                <div class="col-lg-12" id="output2"></div>
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
                                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                                        ข้อมูลพนักงานขับรถ
                                                    </div>
                                                    <div class="panel-body" style="background-color: #f8f8f8">
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
                                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                                        ข้อมูลรถ
                                                    </div>
                                                    <div class="panel-body" style="background-color: #f8f8f8">
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
                                                <input type="button" onclick="save_repair('');" name="btnSend" id="btnSend" value="บันทึกข้อมูล" class="btn btn-primary">

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
                <div id="datasr_edit"></div>
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
                    <div class="col-lg-2">
                        <label>&nbsp;</label>
                        <div class="form-group">

                            <a href="#" onclick="pdf_repair1();" class="btn btn-default">พิมพ์ <li class="fa fa-print"></li></a>
                        </div>

                    </div>

                </div>   
                <div class="row" >
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color: #e7e7e7">
                                <font style="font-size: 16px"><b>ประวัติการแจ้งซ่อมของพนักงาน : <?= $result_seEHR['nameT'] ?></b></font>                            
                            </div>
                            <div class="panel-body">
                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                    <div class="row">


                                        <div class="col-sm-12">
                                            <div id="datadef">
                                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>ลำดับ</th>
                                                            <th>DRIVER</th>
                                                            <th>SECTION</th>
                                                            <th>ISSUE</th>
                                                            <th>จนท.TENKO</th>
                                                            <th>ก่อนแก้ไข</th>
                                                            <th>หลังแก้ไข</th>
                                                            <th>สาเหตุ</th>
                                                            <th>การแก้ไข</th>
                                                            <th>การป้องกัน</th>
                                                            <th>ช่างผู้รับผิดชอบ</th>
                                                            <th>ผู้รับแจ้งซ่อม</th>
                                                            <th>กำหนดเสร็จ</th>
                                                            <th>สถานะแจ้งซ่อม</th>
                                                            <th style="text-align: center">จัดการ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $i = 1;
                                                        $condRepair = " AND DRIVERCODE = '" . $_GET['employeeid'] . "'";
                                                        $sql_seRepair = "{call megRepair_v2(?,?)}";
                                                        $params_seRepair = array(
                                                            array('select_repair', SQLSRV_PARAM_IN),
                                                            array($condRepair, SQLSRV_PARAM_IN)
                                                        );


                                                        $query_seRepair = sqlsrv_query($conn, $sql_seRepair, $params_seRepair);
                                                        while ($result_seRepair = sqlsrv_fetch_array($query_seRepair, SQLSRV_FETCH_ASSOC)) {
                                                            ?>
                                                            <tr class="odd gradeX">
                                                                <td style="text-align: center"><?= $i ?></td>
                                                                <td><?= $result_seRepair['DRIVERNAME'] ?></td>
                                                                <td>-</td>
                                                                <td><?= $result_seRepair['TENKO_ISSUE'] ?></td>
                                                                <td><?= $result_seRepair['TENKO_INFROM'] ?></td>
                                                                <td><a href="#" data-toggle="modal"  data-target="#modal_image" onclick="modalimage('<?= $result_seRepair['TENKO_BEFOREEDIT'] ?>')"><?= $result_seRepair['TENKO_BEFOREEDIT'] ?></a></td>
                                                                <td><a href="#" data-toggle="modal"  data-target="#modal_image" onclick="modalimage('<?= $result_seRepair['TEC_AFFTEREDIT'] ?>')"><?= $result_seRepair['TEC_AFFTEREDIT'] ?></a></td>
                                                                <td><?= $result_seRepair['TEC_CAUSE'] ?></td>
                                                                <td><?= $result_seRepair['TEC_EDIT'] ?></td>
                                                                <td><?= $result_seRepair['TEC_PROTECT'] ?></td>
                                                                <td><?= $result_seRepair['TEC_TECHNICIAN'] ?></td>
                                                                <td><?= $result_seRepair['TEC_INFROM'] ?></td>
                                                                <td><?= $result_seRepair['TEC_COMPLETED'] ?></td>
                                                                <td><?= $result_seRepair['REPAIRSTATUS'] ?></td>

                                                                <td style="text-align: center">
                                                                    <button onclick="showupdate_repair('<?= $result_seRepair['EMPLOYEEREPAIRID'] ?>');" title="แก้ไขข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-wrench"></span></button>
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


        $emp_rtd = select_empautocomplate('megEmployeeEHR_v2', 'select_employee', " AND d.Company_Code  IN ('RTD')");
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
                                                                        function chk_uploadaffter1()
                                                                        {
                                                                            document.getElementById('txt_chkaffter1').value = '1';
                                                                        }
                                                                        $(document).ready(function () {
                                                                            $('#dataTables-example').DataTable({
                                                                                responsive: true,
                                                                                "order": [[12, "desc"]]
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
                                                                                    txt_flg: "select_repair", datestart: datestart, dateend: dateend,employeeid:'<?=$_GET['employeeid']?>'
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
                                                                                            "order": [[12, "desc"]]
                                                                                        });
                                                                                    });

                                                                                    var txt_technician = [<?= $emp_rtd ?>];
                                                                                    $(function () {
                                                                                        $("#txt_technician").autocomplete({
                                                                                            source: [txt_technician]
                                                                                        });


                                                                                    });

                                                                                    var txt_empinform1 = [<?= $emp_rtd ?>];
                                                                                    $(function () {
                                                                                        $("#txt_empinform1").autocomplete({
                                                                                            source: [txt_empinform1]
                                                                                        });


                                                                                    });

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

            var txt_empinform1 = [<?= $emp_rtd ?>];

            $(function () {
                $("#txt_empinform1").autocomplete({
                    source: [txt_empinform1]
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



                        var txt_empinform1 = [<?= $emp_rtd ?>];
                        $(function () {
                            $("#txt_empinform1").autocomplete({
                                source: [txt_empinform1]
                            });


                        });
                        var txt_carname = [<?= $vehiclenumber ?>];
                        $(function () {
                            $("#txt_carname").autocomplete({
                                source: [txt_carname]
                            });


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


                                if (!$('#txt_editaffter1').val()) //check empty input filed
                                {
                                    $("#output2").html("Are you kidding me?");
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

                        //function to format bites bit.ly/19yoIPO
                        function bytesToSize(bytes) {
                            var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
                            if (bytes == 0)
                                return '0 Bytes';
                            var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
                            return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
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
            function save_repair(employeerepairid,type)
            {
                var employeerepairid = employeerepairid;
                var txtempinform1 = document.getElementById('txt_empinform1').value;
                var txtcarname = document.getElementById('txt_carname').value;
                var txtissue = document.getElementById('txt_issue').value;
                var txtremark1 = '';
                var txttechnician = document.getElementById('txt_technician').value;
                var txtcompleted = document.getElementById('txt_completed').value;
                var txtcause = document.getElementById('txt_cause').value;
                var txtedit = document.getElementById('txt_edit').value;
                var txtprotect = document.getElementById('txt_protect').value;
                var repairstatus1 = document.getElementById('cb_repairstatus1').value;
                var repairstatus2 = document.getElementById('cb_repairstatus2').value;
                var txtremark2 = '';
                if (document.getElementById('txt_chkbefore1').value == '1')
                {
                    var tenkobeforeedit = document.getElementById('IMGBEFORE1').value;
                } else
                {
                    var tenkobeforeedit = '';
                }
                if (document.getElementById('txt_chkaffter1').value == '1')
                {
                    var tecaffteredit = document.getElementById('IMGAFFTER1').value;
                } else
                {
                    var tecaffteredit = '';
                }

                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "save_repair", employeerepairid: employeerepairid, drivername: '<?= $result_seEHR['nameT'] ?>',
                        vehiclename: txtcarname, tenko_infrom: '<?= ($result_seEHR1['Company_Code'] != 'RTD') ? $result_seEHR1['nameT'] : ''; ?>', tenko_issue: txtissue, tenko_beforeedit: tenkobeforeedit, tec_affteredit: tecaffteredit, tenko_remark: txtremark1,
                        tec_infrom: txtempinform1, tec_technician: txttechnician, tec_completed: txtcompleted, tec_cause: txtcause,
                        tec_edit: txtedit, tec_protect: txtprotect, tec_remark: txtremark2, repairstatus1: repairstatus1, repairstatus2: repairstatus2, remark: '', activestatus: '1',type:type
                    },
                    success: function (response) {
                        alert(response);
                        window.location.reload();
                    }
                });
            }

        </script>






    </body>

</html>
<?php
sqlsrv_close($conn);
?>