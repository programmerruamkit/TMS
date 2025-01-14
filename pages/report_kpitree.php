
<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

if ($_GET['id1'] != "") {
    $condition1 = " AND a.MENUID = " . $_GET['id1'];
    $sql_getMenu = "{call megMenu_v2(?,?)}";
    $params_getMenu = array(
        array('select_menu', SQLSRV_PARAM_IN),
        array($condition1, SQLSRV_PARAM_IN)
    );
    $query_getMenu = sqlsrv_query($conn, $sql_getMenu, $params_getMenu);
    $result_getMenu = sqlsrv_fetch_array($query_getMenu, SQLSRV_FETCH_ASSOC);
}

$sql_seSystime = "{call megGetdate_v2(?)}";
$params_seSystime = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_seSystime = sqlsrv_query($conn, $sql_seSystime, $params_seSystime);
$result_seSystime = sqlsrv_fetch_array($query_seSystime, SQLSRV_FETCH_ASSOC);
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
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">


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



                <div class="modal fade" id="modal_addeyedetectorng" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document" style="width: 80%">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <h5 class="modal-title" id="title_copydiagram"><b>เพิ่ม NG  ประจำเดือน <?= $result_seSystime['MMYYY'] ?> (Eye Detector)</b></h5>

                                    </div>

                                </div>
                            </div>
                            <div class="modal-body">


                                <div class="row">
                                    <div class="col-lg-2" >
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button"  onclick="show_subaddeyedetectorng('1')"    value="วันที่ : 1" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 2" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 3" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 4" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 5" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 6" class="btn btn-danger"  >

                                        </div>

                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 7" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 8" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 9" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 10" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 11" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 12" class="btn btn-danger"   >

                                        </div>

                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 13" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 14" class="btn btn-danger"  >

                                        </div>

                                    </div>


                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 15" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 16" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 17" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 18" class="btn btn-danger"   >

                                        </div>

                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 19" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 20" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 21" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 22" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 23" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 24" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 25" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 26" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 27" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 28" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 29" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 30" class="btn btn-danger"   >

                                        </div>

                                    </div>



                                </div>
                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group">

                                            <input style="width: 100%;" type="button" value="วันที่ : 31" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                </div>


                            </div>
                            <div class="modal-footer">

                                <button type="button" class="btn btn-primary" data-dismiss="modal"><span class="fa fa-plus"></span> บันทึก</button>

                            </div>


                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modal_subaddeyedetectorng" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-modal-parent="#modal_addeyedetectorng">
                    <div class="modal-dialog" role="document" style="width: 60%">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <h5 class="modal-title" id="title_copydiagram"><b>เลือก JOB ที่เกิด (NG)</b></h5>
                                    </div>

                                </div>
                            </div>



                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div id="subaddeyedetectorng_def">
                                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleaddng" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center">วันที่/เวลา</th>
                                                        <th style="text-align: center">JOBNO</th>
                                                        <th style="text-align: center">ต้นทาง</th>
                                                        <th style="text-align: center">ปลายทาง</th>
                                                        <th style="text-align: center">พนักงาน(1)</th>
                                                        <th style="text-align: center">พนักงาน(2)</th>
                                                        <th style="text-align: center">จำนวน (NG)</th>

                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <tr>

                                                        <td style="text-align: center">
                                                            -
                                                        </td> 
                                                        <td style="text-align: center">
                                                            -
                                                        </td>
                                                        <td style="text-align: center">
                                                            -
                                                        </td>
                                                        <td style="text-align: center">
                                                            -
                                                        </td>
                                                        <td style="text-align: center">
                                                            -
                                                        </td>
                                                        <td style="text-align: center">
                                                            -
                                                        </td>
                                                        <td style="text-align: center">
                                                            <input type="text" class="form-control">
                                                        </td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div id="subaddeyedetectorng_sr"></div>

                                    </div>

                                </div>

                            </div>
                            <div class="modal-footer">

                                <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>

                            </div>




                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modal_addstopcallwaitng" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document" style="width: 60%">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <h5 class="modal-title" id="title_copydiagram"><b>เพิ่ม NG  ประจำเดือน <?= $result_seSystime['MMYYY'] ?> (Stop-Call-Wait หยุด-เรียก-รอ)</b></h5>

                                    </div>

                                </div>
                            </div>
                            <div class="modal-body">


                                <div class="row">
                                    <div class="col-lg-2" >
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button"   value="วันที่ : 1" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 2" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 3" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 4" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 5" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 6" class="btn btn-danger"  >

                                        </div>

                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 7" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 8" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 9" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 10" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 11" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 12" class="btn btn-danger"   >

                                        </div>

                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 13" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 14" class="btn btn-danger"  >

                                        </div>

                                    </div>


                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 15" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 16" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 17" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 18" class="btn btn-danger"   >

                                        </div>

                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 19" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 20" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 21" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 22" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 23" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 24" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 25" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 26" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 27" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 28" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 29" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 30" class="btn btn-danger"   >

                                        </div>

                                    </div>



                                </div>
                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group">

                                            <input style="width: 100%;" type="button" value="วันที่ : 31" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                </div>


                            </div>
                            <div class="modal-footer">

                                <button type="button" class="btn btn-primary" data-dismiss="modal"><span class="fa fa-plus"></span> บันทึก</button>

                            </div>


                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modal_adddriver4hrsandrest30minng" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document" style="width: 60%">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <h5 class="modal-title" id="title_copydiagram"><b>เพิ่ม NG  ประจำเดือน <?= $result_seSystime['MMYYY'] ?> (ขับ 4 ชม. พัก 30 นาที Driver 4 hrs and rest 30 min)</b></h5>

                                    </div>

                                </div>
                            </div>
                            <div class="modal-body">


                                <div class="row">
                                    <div class="col-lg-2" >
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button"   value="วันที่ : 1" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 2" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 3" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 4" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 5" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 6" class="btn btn-danger"  >

                                        </div>

                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 7" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 8" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 9" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 10" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 11" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 12" class="btn btn-danger"   >

                                        </div>

                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 13" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 14" class="btn btn-danger"  >

                                        </div>

                                    </div>


                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 15" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 16" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 17" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 18" class="btn btn-danger"   >

                                        </div>

                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 19" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 20" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 21" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 22" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 23" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 24" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 25" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 26" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 27" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 28" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 29" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 30" class="btn btn-danger"   >

                                        </div>

                                    </div>



                                </div>
                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group">

                                            <input style="width: 100%;" type="button" value="วันที่ : 31" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                </div>


                            </div>
                            <div class="modal-footer">

                                <button type="button" class="btn btn-primary" data-dismiss="modal"><span class="fa fa-plus"></span> บันทึก</button>

                            </div>


                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modal_adddriver6hrsandchangedriverng" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document" style="width: 60%">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <h5 class="modal-title" id="title_copydiagram"><b>เพิ่ม NG  ประจำเดือน <?= $result_seSystime['MMYYY'] ?> (ขับ 6 ชม. เปลี่ยนมือ Driver 6 hrs and change driver)</b></h5>

                                    </div>

                                </div>
                            </div>
                            <div class="modal-body">


                                <div class="row">
                                    <div class="col-lg-2" >
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button"   value="วันที่ : 1" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 2" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 3" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 4" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 5" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 6" class="btn btn-danger"  >

                                        </div>

                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 7" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 8" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 9" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 10" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 11" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 12" class="btn btn-danger"   >

                                        </div>

                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 13" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 14" class="btn btn-danger"  >

                                        </div>

                                    </div>


                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 15" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 16" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 17" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 18" class="btn btn-danger"   >

                                        </div>

                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 19" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 20" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 21" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 22" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 23" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 24" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 25" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 26" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 27" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 28" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 29" class="btn btn-danger"   >

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input style="width: 100%;" type="button" value="วันที่ : 30" class="btn btn-danger"   >

                                        </div>

                                    </div>



                                </div>
                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group">

                                            <input style="width: 100%;" type="button" value="วันที่ : 31" class="btn btn-danger"  >

                                        </div>

                                    </div>
                                </div>


                            </div>
                            <div class="modal-footer">

                                <button type="button" class="btn btn-primary" data-dismiss="modal"><span class="fa fa-plus"></span> บันทึก</button>

                            </div>


                        </div>
                    </div>
                </div>
                <div class="row" >
                    <div class="col-lg-12">

                        <h2 class="page-header"><i class="fa fa-file-text-o"></i>  
                            รายงาน KPI Tree

                        </h2>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="well">
                            <div class="row">


                                <div class="col-lg-2">

                                    <div class="form-group">
                                        <label>ค้นหาเดือน</label>
                                        <input class="form-control dateennom" readonly="" style="background-color: #f080802e" id="txt_datestart" name="txt_datestart" value="24/07/2020" placeholder="วันที่เริ่มต้น">

                                    </div>

                                </div>

                                <div class="col-lg-2">
                                    <label>&nbsp;</label>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-default" onclick="select_kpitree();">ค้นหา <li class="fa fa-search"></li></button>
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

                                <?php
                                echo "รายงาน KPI Tree";
                                ?>
                            </div>
                            <!-- /.panel-heading -->

                            <div class="panel-body">
                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                    <div id="datadef">
                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 90%">ชื่อรายงาน</th>
                                                    <th style="text-align: center">เพิ่ม NG</th>
                                                    <th style="text-align: center">พิมพ์</th>

                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <td>< สภาพร่างกาย Physical Condition(ก่อนทำงาน) > <?= $result_seSystime['MMYYY'] ?></td> 
                                                    <td style="text-align: center">
                                                        -
                                                    </td> 
                                                    <td style="text-align: center">
                                                        <a href="#" onclick="pdf_btn_eyedetector()" class="btn btn-default" title="PDF"><li class="fa fa-file-pdf-o fa-5"></li></a>
                                                        <!--<a href="#"  class="btn btn-default" title="Excel"><li class="fa fa-file-excel-o fa-5"></li></a>-->
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>< เวลาพักผ่อน Rest Time > <?= $result_seSystime['MMYYY'] ?></td> 
                                                    <td style="text-align: center">
                                                        -
                                                    </td>
                                                    <td style="text-align: center">
                                                        <a href="#" onclick="pdf_resttime()"  class="btn btn-default" title="PDF"><li class="fa fa-file-pdf-o fa-5"></li></a>
                                                        <!--<a href="#"  class="btn btn-default" title="Excel"><li class="fa fa-file-excel-o fa-5"></li></a>-->
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>< ความดันโลหิต Blood pressure > <?= $result_seSystime['MMYYY'] ?></td> 
                                                    <td style="text-align: center">
                                                        -
                                                    </td>
                                                    <td style="text-align: center">
                                                        <a href="#" onclick="pdf_driver6hrsandchangedriver()"  class="btn btn-default" title="PDF"><li class="fa fa-file-pdf-o fa-5"></li></a>
                                                        <!--<a href="#"  class="btn btn-default" title="Excel"><li class="fa fa-file-excel-o fa-5"></li></a>-->
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>< ความกระวนกระวาย Nervousness > <?= $result_seSystime['MMYYY'] ?></td> 
                                                    <td style="text-align: center">
                                                        -
                                                    </td>
                                                    <td style="text-align: center">
                                                        <a href="#" onclick="pdf_driver4hrsandrest30min()" class="btn btn-default" title="PDF"><li class="fa fa-file-pdf-o fa-5"></li></a>
                                                        <!--<a href="#"  class="btn btn-default" title="Excel"><li class="fa fa-file-excel-o fa-5"></li></a>-->
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>< อุณหภูมิร่างกาย Body temperature > <?= $result_seSystime['MMYYY'] ?></td> 
                                                    <td style="text-align: center">
                                                        -
                                                    </td>
                                                    <td style="text-align: center">
                                                        <a href="#" onclick="pdf_bodytemperature()"  class="btn btn-default" title="PDF"><li class="fa fa-file-pdf-o fa-5"></li></a>
                                                        <!--<a href="#"  class="btn btn-default" title="Excel"><li class="fa fa-file-excel-o fa-5"></li></a>-->
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>< แอลกอฮอล์ Alcohol(ก่อนทำงาน) > <?= $result_seSystime['MMYYY'] ?></td> 
                                                    <td style="text-align: center">
                                                        -
                                                    </td>
                                                    <td style="text-align: center">
                                                        <a href="#" onclick="pdf_alcohol()"  class="btn btn-default" title="PDF"><li class="fa fa-file-pdf-o fa-5"></li></a>
                                                        <!--<a href="#"  class="btn btn-default" title="Excel"><li class="fa fa-file-excel-o fa-5"></li></a>-->
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>< เวลานอน sleep hours > <?= $result_seSystime['MMYYY'] ?></td> 
                                                    <td style="text-align: center">
                                                        -
                                                    </td>
                                                    <td style="text-align: center">
                                                        <a href="#" onclick="pdf_sleephours()" class="btn btn-default" title="PDF"><li class="fa fa-file-pdf-o fa-5"></li></a>
                                                        <!--<a href="#"  class="btn btn-default" title="Excel"><li class="fa fa-file-excel-o fa-5"></li></a>-->
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>< ตรวจรถบรรทุก ประจำวัน Truck Readiness Check > <?= $result_seSystime['MMYYY'] ?></td> 
                                                    <td style="text-align: center">
                                                        <button class="form-control"><li class="fa fa-plus fa-5"></li></button>
                                                    </td>
                                                    <td style="text-align: center">
                                                        <a href="#"  class="btn btn-default" title="PDF"><li class="fa fa-file-pdf-o fa-5"></li></a>
                                                        <!--<a href="#"  class="btn btn-default" title="Excel"><li class="fa fa-file-excel-o fa-5"></li></a>-->
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>< แอลกอฮอล์ Alcohol(ระหว่างทำงาน) > <?= $result_seSystime['MMYYY'] ?></td> 
                                                    <td style="text-align: center">
                                                        <button class="form-control"><li class="fa fa-plus fa-5"></li></button>
                                                    </td>
                                                    <td style="text-align: center">
                                                        <a href="#"  class="btn btn-default" title="PDF"><li class="fa fa-file-pdf-o fa-5"></li></a>
                                                        <!--<a href="#"  class="btn btn-default" title="Excel"><li class="fa fa-file-excel-o fa-5"></li></a>-->
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>< สภาพร่างกาย Physical Condition(หลังทำงาน) > <?= $result_seSystime['MMYYY'] ?></td> 
                                                    <td style="text-align: center">
                                                        -
                                                    </td> 
                                                    <td style="text-align: center">
                                                        <a href="#" onclick="pdf_stopcallwait()" class="btn btn-default" title="PDF"><li class="fa fa-file-pdf-o fa-5"></li></a>
                                                        <!--<a href="#"  class="btn btn-default" title="Excel"><li class="fa fa-file-excel-o fa-5"></li></a>-->
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>< ทำงานคนเดียว ไม่เกิน 14 ชั่วโมง Working not over 14 hrs. > <?= $result_seSystime['MMYYY'] ?></td> 
                                                    <td style="text-align: center">
                                                        <button class="form-control"><li class="fa fa-plus fa-5"></li></button>
                                                    </td>
                                                    <td style="text-align: center">
                                                        <a href="#"  class="btn btn-default" title="PDF"><li class="fa fa-file-pdf-o fa-5"></li></a>
                                                        <!--<a href="#"  class="btn btn-default" title="Excel"><li class="fa fa-file-excel-o fa-5"></li></a>-->
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>< ขับ 4 ชม. พัก 30 นาที Driver 4 hrs and rest 30 min > <?= $result_seSystime['MMYYY'] ?></td> 
                                                    <td style="text-align: center">
                                                        <button class="form-control" data-toggle="modal"  data-target="#modal_adddriver4hrsandrest30minng"><li class="fa fa-plus fa-5"></li></button>
                                                    </td>
                                                    <td style="text-align: center">
                                                        <a href="#"  class="btn btn-default" title="PDF"><li class="fa fa-file-pdf-o fa-5"></li></a>
                                                        <!--<a href="#"  class="btn btn-default" title="Excel"><li class="fa fa-file-excel-o fa-5"></li></a>-->
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>< ขับ 6 ชม. เปลี่ยนมือ Driver 6 hrs and change driver > <?= $result_seSystime['MMYYY'] ?></td> 
                                                    <td style="text-align: center">
                                                        <button class="form-control" data-toggle="modal"  data-target="#modal_adddriver6hrsandchangedriverng"><li class="fa fa-plus fa-5"></li></button>
                                                    </td>
                                                    <td style="text-align: center">
                                                        <a href="#"  class="btn btn-default" title="PDF"><li class="fa fa-file-pdf-o fa-5"></li></a>
                                                        <!--<a href="#"  class="btn btn-default" title="Excel"><li class="fa fa-file-excel-o fa-5"></li></a>-->
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>< ขับขี่ความเร็วไม่เกิน 60 กิโลเมตร/ชั่วโมง Speed not over 60 km/hr. > <?= $result_seSystime['MMYYY'] ?></td> 
                                                    <td style="text-align: center">
                                                        <button class="form-control"><li class="fa fa-plus fa-5"></li></button>
                                                    </td>
                                                    <td style="text-align: center">
                                                        <a href="#"  class="btn btn-default" title="PDF"><li class="fa fa-file-pdf-o fa-5"></li></a>
                                                        <!--<a href="#"  class="btn btn-default" title="Excel"><li class="fa fa-file-excel-o fa-5"></li></a>-->
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>< Eye Detector > <?= $result_seSystime['MMYYY'] ?></td> 
                                                    <td style="text-align: center">
                                                        <button class="form-control" data-toggle="modal"  data-target="#modal_addeyedetectorng"><li class="fa fa-plus fa-5"></li></button>
                                                    </td>
                                                    <td style="text-align: center">
                                                        <a href="#"  class="btn btn-default" title="PDF"><li class="fa fa-file-pdf-o fa-5"></li></a>
                                                        <!--<a href="#"  class="btn btn-default" title="Excel"><li class="fa fa-file-excel-o fa-5"></li></a>-->
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>< ใช้ สมอลทอร์ค ขณะโทร Handsfree when phon > <?= $result_seSystime['MMYYY'] ?></td> 
                                                    <td style="text-align: center">
                                                        <button class="form-control"><li class="fa fa-plus fa-5"></li></button>
                                                    </td>
                                                    <td style="text-align: center">
                                                        <a href="#"  class="btn btn-default" title="PDF"><li class="fa fa-file-pdf-o fa-5"></li></a>
                                                        <!--<a href="#"  class="btn btn-default" title="Excel"><li class="fa fa-file-excel-o fa-5"></li></a>-->
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>< ไม่สูบบุหรี่ขณะขับรถ Not smoking > <?= $result_seSystime['MMYYY'] ?></td> 
                                                    <td style="text-align: center">
                                                        <button class="form-control"><li class="fa fa-plus fa-5"></li></button>
                                                    </td>
                                                    <td style="text-align: center">
                                                        <a href="#"  class="btn btn-default" title="PDF"><li class="fa fa-file-pdf-o fa-5"></li></a>
                                                        <!--<a href="#"  class="btn btn-default" title="Excel"><li class="fa fa-file-excel-o fa-5"></li></a>-->
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>< ง่วงขับรถ Feel Sleep > <?= $result_seSystime['MMYYY'] ?></td> 
                                                    <td style="text-align: center">
                                                        <button class="form-control"><li class="fa fa-plus fa-5"></li></button>
                                                    </td>
                                                    <td style="text-align: center">
                                                        <a href="#"  class="btn btn-default" title="PDF"><li class="fa fa-file-pdf-o fa-5"></li></a>
                                                        <!--<a href="#"  class="btn btn-default" title="Excel"><li class="fa fa-file-excel-o fa-5"></li></a>-->
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>< คาดเข็มขัดนิรภัย Safety belt > <?= $result_seSystime['MMYYY'] ?></td> 
                                                    <td style="text-align: center">
                                                        <button class="form-control"><li class="fa fa-plus fa-5"></li></button>
                                                    </td>
                                                    <td style="text-align: center">
                                                        <a href="#"  class="btn btn-default" title="PDF"><li class="fa fa-file-pdf-o fa-5"></li></a>
                                                        <!--<a href="#"  class="btn btn-default" title="Excel"><li class="fa fa-file-excel-o fa-5"></li></a>-->
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>< มาตฐานการทำงาน Activity SSA & Patrol check > <?= $result_seSystime['MMYYY'] ?></td> 
                                                    <td style="text-align: center">
                                                        <button class="form-control"><li class="fa fa-plus fa-5"></li></button>
                                                    </td>
                                                    <td style="text-align: center">
                                                        <a href="#"  class="btn btn-default" title="PDF"><li class="fa fa-file-pdf-o fa-5"></li></a>
                                                        <!--<a href="#"  class="btn btn-default" title="Excel"><li class="fa fa-file-excel-o fa-5"></li></a>-->
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>< Stop-Call-Wait หยุด-เรียก-รอ > <?= $result_seSystime['MMYYY'] ?></td> 
                                                    <td style="text-align: center">
                                                        <button class="form-control" data-toggle="modal"  data-target="#modal_addstopcallwaitng"><li class="fa fa-plus fa-5"></li></button>
                                                    </td>
                                                    <td style="text-align: center">
                                                        <a href="#"  class="btn btn-default" title="PDF"><li class="fa fa-file-pdf-o fa-5"></li></a>
                                                        <!--<a href="#"  class="btn btn-default" title="Excel"><li class="fa fa-file-excel-o fa-5"></li></a>-->
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>< อุปกรณ์ความปลอดภัย Safety equipment > <?= $result_seSystime['MMYYY'] ?></td> 
                                                    <td style="text-align: center">
                                                        <button class="form-control"><li class="fa fa-plus fa-5"></li></button>
                                                    </td>
                                                    <td style="text-align: center">
                                                        <a href="#"  class="btn btn-default" title="PDF"><li class="fa fa-file-pdf-o fa-5"></li></a>
                                                        <!--<a href="#"  class="btn btn-default" title="Excel"><li class="fa fa-file-excel-o fa-5"></li></a>-->
                                                    </td>
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
        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="../vendor/metisMenu/metisMenu.min.js"></script>
        <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
        <script src="../dist/js/sb-admin-2.js"></script>



        <script src="../js/jquery.datetimepicker.full.js"></script>


        <script>

                                                            function show_subaddeyedetectorng(dayng)
                                                            {
                                                                $("#modal_subaddeyedetectorng").modal();
                                                                $.ajax({
                                                                    type: 'post',
                                                                    url: 'meg_data.php',
                                                                    data: {
                                                                        txt_flg: "show_subaddeyedetectorng",area:'<?=$_GET['area']?>',dateng : dayng+'<?= $result_seSystime['MMYYY'] ?>'
                                                                    },
                                                                    success: function (rs) {
                                                                        document.getElementById("subaddeyedetectorng_def").innerHTML = "";
                                                                        document.getElementById("subaddeyedetectorng_sr").innerHTML = rs;
                                                                        
                                                                        $(document).ready(function () {
                                                                            $('#dataTables-exampleaddng').DataTable({
                                                                                responsive: true,
                                                                            });
                                                                        });
                                                                    }

                                                                });
                                                            }
                                                            function pdf_btn_eyedetector()
                                                            {
                                                                window.open('pdf_kpitree-btn_eyedetector.php?startdate=' + document.getElementById("txt_datestart").value + '&area=<?= $_GET['area'] ?>', '_blank');
                                                            }
                                                            function pdf_resttime()
                                                            {
                                                                window.open('pdf_kpitree-resttime.php?startdate=' + document.getElementById("txt_datestart").value + '&area=<?= $_GET['area'] ?>', '_blank');
                                                            }
                                                            function pdf_driver6hrsandchangedriver()
                                                            {
                                                                window.open('pdf_kpitree-driver6hrsandchangedriver.php?startdate=' + document.getElementById("txt_datestart").value + '&area=<?= $_GET['area'] ?>', '_blank');
                                                            }
                                                            function pdf_driver4hrsandrest30min()
                                                            {
                                                                window.open('pdf_kpitree-driver4hrsandrest30min.php?startdate=' + document.getElementById("txt_datestart").value + '&area=<?= $_GET['area'] ?>', '_blank');
                                                            }
                                                            function pdf_bodytemperature()
                                                            {
                                                                window.open('pdf_kpitree-bodytemperature.php?startdate=' + document.getElementById("txt_datestart").value + '&area=<?= $_GET['area'] ?>', '_blank');
                                                            }
                                                            function pdf_alcohol()
                                                            {
                                                                window.open('pdf_kpitree-alcohol.php?startdate=' + document.getElementById("txt_datestart").value + '&area=<?= $_GET['area'] ?>', '_blank');
                                                            }
                                                            function pdf_sleephours()
                                                            {
                                                                window.open('pdf_kpitree-sleephours.php?startdate=' + document.getElementById("txt_datestart").value + '&area=<?= $_GET['area'] ?>', '_blank');
                                                            }
                                                            function pdf_stopcallwait()
                                                            {
                                                                window.open('pdf_kpitree-stopcallwait.php?startdate=' + document.getElementById("txt_datestart").value + '&area=<?= $_GET['area'] ?>', '_blank');
                                                            }
                                                            function select_kpitree()
                                                            {
                                                                var startdate = document.getElementById("txt_datestart").value;

                                                                $.ajax({
                                                                    type: 'post',
                                                                    url: 'meg_data.php',
                                                                    data: {
                                                                        txt_flg: "select_kpitree", startdate: startdate
                                                                    },
                                                                    success: function (response) {
                                                                        if (response)
                                                                        {

                                                                            document.getElementById("datasr").innerHTML = response;
                                                                            document.getElementById("datadef").innerHTML = "";
                                                                        }
                                                                        $(document).ready(function () {
                                                                            $('#dataTables-example').DataTable({
                                                                                responsive: true
                                                                            });
                                                                        });
                                                                    }
                                                                });
                                                            }

                                                            $(function () {
                                                                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                // กรณีใช้แบบ input
                                                                $(".dateennom").datetimepicker({
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
                                                            $(document).ready(function () {
                                                                $('#dataTables-exampleaddng').DataTable({
                                                                    responsive: true,
                                                                });
                                                            });
        </script>


    </body>

</html>
<?php
sqlsrv_close($conn);
?>