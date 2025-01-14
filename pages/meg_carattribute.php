<!DOCTYPE html>
<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");


$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

if ($_GET['vehicleinfoid'] != "") {
    $conditioninfo = ' AND a.VEHICLEINFOID = ' . $_GET['vehicleinfoid'];
    $sql_info = "{call megVehicleinfo_v2(?,?)}";
    $params_info = array(
        array('select_vehicleinfo', SQLSRV_PARAM_IN),
        array($conditioninfo, SQLSRV_PARAM_IN)
    );
}
$query_info = sqlsrv_query($conn, $sql_info, $params_info);
$result_info = sqlsrv_fetch_array($query_info, SQLSRV_FETCH_ASSOC);
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
            .file {
                visibility: hidden;
                position: absolute;
            }

            .modal-dialog {width:600px;}
            .thumbnail {margin-bottom:6px;}

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


            <div id="page-wrapper">
                <p>&nbsp;</p>
                <form  name="saveform" id="saveform" method="post" action="update_data.php" target="up_iframe" enctype="multipart/form-data">
                    <input type="text" id="txt_vehicleinfoid" name="txt_vehicleinfoid" style="display: none" value="<?= $_GET['vehicleinfoid'] ?>">
                    <?php
                    if ($_GET['type'] == "attribute") {
                        include '../pages/meg_cardata.php';
                        if ($_GET['vehicleattributeid'] != "") {
                            $condition1 = " AND a.VEHICLEINFOID = " . $_GET['vehicleinfoid'] . " AND a.VEHICLEATTRIBUTEID = " . $_GET['vehicleattributeid'];
                            $sql_seVehicleattribute = "{call megVehicleattribute_v2(?,?)}";
                            $params_seVehicleattribute = array(
                                array('select_vehicleattribute', SQLSRV_PARAM_IN),
                                array($condition1, SQLSRV_PARAM_IN)
                            );
                            $query_seVehicleattribute = sqlsrv_query($conn, $sql_seVehicleattribute, $params_seVehicleattribute);
                            $result_seVehicleattribute = sqlsrv_fetch_array($query_seVehicleattribute, SQLSRV_FETCH_ASSOC);
                        }
                        ?>
                        <div tabindex="-1" class="modal fade" id="myModal" role="dialog" >
                            <div class="modal-dialog" >
                                <div class="modal-content" >

                                    <div class="modal-body" >

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                        ข้อมูลรูป/ลักษณะ
                                    </div>
                                    <div class="panel-body">
                                        <div class="row" >
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ด้านหน้า</label>
                                                    <div class="form-group">
                                                        <input type="file" id="image_front" name="image_front"  class="file" >
                                                        <div class="input-group col-xs-12">
                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                                                            <input type="text" class="form-control input-lg" id="file_front" name="file_front" readonly="" placeholder="Upload Image" value="<?= $result_seVehicleattribute['SIDEIMAGE'] ?>">
                                                            <span class="input-group-btn">
                                                                <button class="browse btn btn-primary input-lg" type="button"><p class="fa fa-search"></p> Browse</button>
                                                            </span>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>


                                           <div class="col-lg-1 ">
                                                <div class="form-group">
                                                    <label>&emsp;&emsp;&emsp;</label>
                                                    <a  href="#" ><img class="thumbnail img-responsive" src="../images/RKB9.jpg" >
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="col-lg-1 ">
                                                <div class="form-group">
                                                    <label>&emsp;&emsp;&emsp;</label>

                                                </div>
                                            </div>

                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>กว้าง</label>
                                                    <input class="form-control"  id="front_width" name="front_width"  value="<?= $result_seVehicleattribute['FRONTWIDTH'] ?>" >
                                                </div>

                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ยาว</label>
                                                    <input class="form-control"  id="front_long" name="front_long" value="<?= $result_seVehicleattribute['FRONTWIDTH'] ?>" >
                                                </div>

                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>สูง</label>
                                                    <input class="form-control"  id="front_high" name="front_high"  value="<?= $result_seVehicleattribute['FRONTWIDTH'] ?>" >
                                                </div>

                                            </div>

                                        </div>
                                        <div class="row" >
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ด้านข้าง</label>
                                                    <div class="form-group">
                                                        <input type="file" id="image_side" name="image_side" class="file" >
                                                        <div class="input-group col-xs-12">
                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                                                            <input type="text" class="form-control input-lg" id="file_side" name="file_side" disabled placeholder="Upload Image" value="<?= $result_seVehicleattribute['SIDEIMAGE'] ?>">
                                                            <span class="input-group-btn">
                                                                <button class="browse btn btn-primary input-lg" type="button"><p class="fa fa-search"></p> Browse</button>
                                                            </span>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="col-lg-1 ">
                                                <div class="form-group">
                                                    <label>&emsp;&emsp;&emsp;</label>
                                                    <a  href="#" ><img class="thumbnail img-responsive" src="../images/RKB9.jpg" >
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-1 ">
                                                <div class="form-group">
                                                    &nbsp;
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>กว้าง</label>
                                                    <input class="form-control" id="side_width"  name="side_width"  value="<?= $result_seVehicleattribute['SIDEWIDTH'] ?>" >
                                                </div>

                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ยาว</label>
                                                    <input class="form-control" id="side_long" name="side_long"   value="<?= $result_seVehicleattribute['SIDELONG'] ?>" >
                                                </div>

                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>สูง</label>
                                                    <input class="form-control" id="side_high" name="side_high"  value="<?= $result_seVehicleattribute['SIDEHIGH'] ?>" >
                                                </div>

                                            </div>

                                        </div>
                                        <div class="row" >
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ด้านหลัง</label>
                                                    <div class="form-group">
                                                        <input   class="file" name="image_back" id="image_back" type="file">
                                                        <div class="input-group col-xs-12">
                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                                                            <input type="text" class="form-control input-lg"  id="file_back" name="file_back" disabled placeholder="Upload Image" value="<?= $result_seVehicleattribute['BACKIMAGE'] ?>">
                                                            <span class="input-group-btn">
                                                                <button class="browse btn btn-primary input-lg" type="button"><p class="fa fa-search"></p></i> Browse</button>
                                                            </span>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="col-lg-1 ">
                                                <div class="form-group">
                                                    <label>&emsp;&emsp;&emsp;</label>
                                                    <a  href="#" ><img class="thumbnail img-responsive" src="../images/RKB9.jpg" >
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-1 ">
                                                <div class="form-group">
                                                    &nbsp;
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>กว้าง</label>
                                                    <input class="form-control" id="back_width" name="back_width"   value="<?= $result_seVehicleattribute['BACKWIDTH'] ?>" >
                                                </div>

                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ยาว</label>
                                                    <input class="form-control" id="back_long" name="back_long"   value="<?= $result_seVehicleattribute['BACKTLONG'] ?>" >
                                                </div>

                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>สูง</label>
                                                    <input class="form-control" id="back_high" name="back_high"   value="<?= $result_seVehicleattribute['BACKTHIGH'] ?>" >
                                                </div>

                                            </div>

                                        </div>
                                        <div class="row" >
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ด้านใน</label>
                                                    <div class="form-group">
                                                        <input  class="file" type="file" id="image_in" >
                                                        <div class="input-group col-xs-12">
                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                                                            <input type="text" id="file_in" name="file_in" class="form-control input-lg" disabled placeholder="Upload Image" value="<?= $result_seVehicleattribute['INIMAGE'] ?>">
                                                            <span class="input-group-btn">
                                                                <button class="browse btn btn-primary input-lg" type="button"><p class="fa fa-search"></p> Browse</button>
                                                            </span>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="col-lg-1 ">
                                                <div class="form-group">
                                                    <label>&emsp;&emsp;&emsp;</label>
                                                    <a  href="#" ><img class="thumbnail img-responsive" src="../images/RKB9.jpg" >
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" >
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>หมายเหตุ</label>
                                                    <textarea class="form-control" autocomplete="off" rows="3" id="txt_attributeremark" name="txt_attributeremark"><?= $result_seVehicleattribute['REMARK'] ?></textarea>
                                                </div>

                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>สถานะ</label>
                                                    <select  class="form-control" id="txt_attributestatus" name="txt_attributestatus">
                                                        <option value="">เลือกสถานะ</option>
                                                        <?php
                                                        $selected = "SELECTED";

                                                        switch ($result_seVehicleattribute['ACTIVESTATUS']) {
                                                            case '1': {
                                                                    ?>
                                                                    <option value = "0" >ไม่ใช้งาน</option>
                                                                    <option value = "1" <?= $selected ?>>ใช้งาน</option>
                                                                    <?php
                                                                }
                                                                break;
                                                            case '0': {
                                                                    ?>
                                                                    <option value = "0" <?= $selected ?>>ไม่ใช้งาน</option>
                                                                    <option value="1" >ใช้งาน</option>
                                                                    <?php
                                                                }
                                                                break;

                                                            default : {
                                                                    ?>
                                                                    <option value = "0">ไม่ใช้งาน</option>
                                                                    <option value="1" >ใช้งาน</option>
                                                                    <?php
                                                                }
                                                                break;
                                                        }
                                                        ?>
                                                    </select>
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




                        <?php
                    }
                    ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <?php
                            $buttonname = ($_GET['meg'] == 'add') ? "บันทึกข้อมูล" : "แก้ไขข้อมูล";


                            if ($_GET['type'] == "attribute") {
                                ?>
                            <input type="submit" onclick="save_vehicleattribute('<?= $_GET['vehicleattributeid'] ?>');" name="btnSend" id="btnSend" value="<?= $buttonname ?>" class="btn btn-primary">
                                <?php
                            }
                            ?>


                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-lg-12">
                            &nbsp;

                        </div>
                    </div>

                    <?php
                    if ($_GET['type'] == "attribute") {
                        ?>
                        <div class="row" >
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                        <font style="font-size: 16px"><b>รายการข้อมูลรูป/ลักษณะ</b></font>                            
                                    </div>
                                    <div class="panel-body">
                                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                            <div class="row">


                                                <div class="col-sm-12">
                                                    <div id="datade">
                                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>ด้านหน้า</th>
                                                                    <th>กว้าง (ด้านหน้า)</th>
                                                                    <th>ยาว (ด้านหน้า)</th>
                                                                    <th>สูง (ด้านหน้า)</th>
                                                                    <th>ด้านข้าง</th>
                                                                    <th>กว้าง (ด้านข้าง)</th>
                                                                    <th>ยาว (ด้านข้าง)</th>
                                                                    <th>สูง (ด้านข้าง)</th>
                                                                    <th>ด้านหลัง</th>
                                                                    <th>กว้าง (ด้านหลัง)</th>
                                                                    <th>ยาว (ด้านหลัง)</th>
                                                                    <th>สูง (ด้านหลัง)</th>
                                                                    <th>ด้านใน</th>
                                                                    <th>หมายเหตุ</th>
                                                                    <th>สถานะ</th>
                                                                    <th>จัดการ</th>


                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $condition1 = " AND a.VEHICLEINFOID = " . $_GET['vehicleinfoid'];
                                                                $sql_seVehicleattributelist = "{call megVehicleattribute_v2(?,?)}";
                                                                $params_seVehicleattributelist = array(
                                                                    array('select_vehicleattribute', SQLSRV_PARAM_IN),
                                                                    array($condition1, SQLSRV_PARAM_IN)
                                                                );
                                                                $query_seVehicleattributelist = sqlsrv_query($conn, $sql_seVehicleattributelist, $params_seVehicleattributelist);
                                                                while ($result_seVehicleattributelist = sqlsrv_fetch_array($query_seVehicleattributelist, SQLSRV_FETCH_ASSOC)) {
                                                                    ?>
                                                                    <tr class="odd gradeX">
                                                                        <td><?= $result_seVehicleattributelist['FRONTIMAGE'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['FRONTWIDTH'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['FRONTLONG'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['FRONTHIGH'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['SIDEIMAGE'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['SIDEWIDTH'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['SIDELONG'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['SIDEHIGH'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['BACKIMAGE'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['BACKWIDTH'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['BACKTLONG'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['BACKTHIGH'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['INIMAGE'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['REMARK'] ?></td>
                                                                        <td><?php echo ($result_seVehiclepurchaselist['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>
                                                                        <td style="text-align: center">
                                                                            <a href="meg_carattribute.php?type=<?= $_GET['type'] ?>&vehicleinfoid=<?= $_GET['vehicleinfoid'] ?>&vehicleattributeid=<?= $result_seVehicleattributelist['VEHICLEATTRIBUTEID'] ?>&meg=edit" title="แก้ไขข้อมูล" type="button" class="btn btn-default  btn-circle"><span class="glyphicon glyphicon-wrench"></span></a>
                                                                            <button onclick="delete_vehiclepurchase(<?= $result_seVehicleattributelist['VEHICLEATTRIBUTEID'] ?>);" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>

                                                                        </td>
                                                                    </tr>
                                                                    <?php
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
                        <?php
                    }
                    ?>
                </form>
            </div>
        </div>
        <script src="../vendor/jquery/jquery.min.js"></script>
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
        <script src="../dist/js/buttons.colVis.min.js"></script>
        <script src="../dist/js/jquery.autocomplete.js"></script>
        <script>

                                                                                $(document).ready(function () {
                                                                                    $('#dataTables-example').DataTable({
                                                                                        responsive: true,
                                                                                        dom: 'Bfrtip',
                                                                                        buttons: [

                                                                                            {
                                                                                                extend: 'excelHtml5',
                                                                                                exportOptions: {
                                                                                                    columns: ':visible'
                                                                                                }
                                                                                            },

                                                                                            'colvis'
                                                                                        ]
                                                                                    });
                                                                                });

        </script>
        <script type="text/javascript">
            $(function () {
                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                // กรณีใช้แบบ input
                $(".dateen").datetimepicker({
                    timepicker: false,
                    format: 'd/m/Y', // กำหนดรูปแบsบวันที่ ที่ใช้ เป็น 00-00-0000			
                    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                });
            });


        </script>
        <script type="text/javascript">
            function chknull_vehicleinfo()
            {

                if (document.getElementById('txt_vehiclenumber').value == '')
                {
                    alert('เลขทะเบียนรถเป็นค่าว่าง !!!')
                    document.getElementById('txt_vehiclenumber').focus();
                    return false;
                } else if (document.getElementById('cb_cargroup').value == '')
                {
                    alert('กลุ่มรถเป็นค่าว่าง !!!')
                    document.getElementById('cb_cargroup').focus();
                    return false;
                } else if (document.getElementById('cb_cartype').value == '')
                {
                    alert('ประเภทรถเป็นค่าว่าง !!!')
                    document.getElementById('cb_cartype').focus();
                    return false;
                } else if (document.getElementById('cb_carbrand').value == '')
                {
                    alert('ยี่ห้อรถเป็นค่าว่าง !!!')
                    document.getElementById('cb_carbrand').focus();
                    return false;
                } else if (document.getElementById('cb_geartype').value == '')
                {
                    alert('ประเภทเกียร์รถเป็นค่าว่าง !!!')
                    document.getElementById('cb_geartype').focus();
                    return false;
                } else if (document.getElementById('cb_carcolor').value == '')
                {
                    alert('สีรถเป็นค่าว่าง !!!')
                    document.getElementById('cb_carcolor').focus();
                    return false;
                } else if (document.getElementById('txt_series_model').value == '')
                {
                    alert('ซีรีส์/รุ่นเป็นค่าว่าง!!!')
                    document.getElementById('txt_series_model').focus();
                    return false;
                } else if (document.getElementById('txt_carnameth').value == '')
                {
                    alert('ชื่อรถ (ไทย)เป็นค่าว่าง !!!')
                    document.getElementById('txt_carnameth').focus();
                    return false;
                } else if (document.getElementById('txt_carnameen').value == '')
                {
                    alert('ชื่อรถ (อังกฤษ)เป็นค่าว่าง !!!')
                    document.getElementById('txt_carnameen').focus();
                    return false;
                } else if (document.getElementById('txt_horse').value == '')
                {
                    alert('แรงม้าเป็นค่าว่าง !!!')
                    document.getElementById('txt_horse').focus();
                    return false;
                } else if (document.getElementById('txt_cc').value == '')
                {
                    alert('CCเป็นค่าว่าง!!!')
                    document.getElementById('txt_cc').focus();
                    return false;
                } else if (document.getElementById('txt_machine').value == '')
                {
                    alert('เลขเครื่องยนต์เป็นค่าว่าง !!!')
                    document.getElementById('txt_machine').focus();
                    return false;
                } else if (document.getElementById('txt_chassisnumber').value == '')
                {
                    alert('เลขตัวถังเป็นค่าว่าง !!!')
                    document.getElementById('txt_chassisnumber').focus();
                    return false;
                } else if (document.getElementById('cb_energy').value == '')
                {
                    alert('ประเภทพลังงานเป็นค่าว่าง !!!')
                    document.getElementById('cb_energy').focus();
                    return false;
                } else if (document.getElementById('txt_weight').value == '')
                {
                    alert('น้ำหนักรถ (กิโลกรัม)เป็นค่าว่าง !!!')
                    document.getElementById('txt_weight').focus();
                    return false;
                } else if (document.getElementById('cb_axle').value == '')
                {
                    alert('ประเภทเพลาเป็นค่าว่าง!!!')
                    document.getElementById('cb_axle').focus();
                    return false;
                } else if (document.getElementById('cb_piston').value == '')
                {
                    alert('ลูกสูบเป็นค่าว่าง !!!')
                    document.getElementById('cb_piston').focus();
                    return false;
                } else if (document.getElementById('txt_maxload').value == '')
                {
                    alert('น้ำหนักบรรทุกสูงสุดเป็นค่าว่าง !!!')
                    document.getElementById('txt_maxload').focus();
                    return false;
                } else if (document.getElementById('cb_used').value == '')
                {
                    alert('การใช้งาน (ปี)เป็นค่าว่าง !!!')
                    document.getElementById('cb_used').focus();
                    return false;

                } else if (document.getElementById('txt_vehiclebuywhere').value == '')
                {
                    alert('ซื้อรถที่ใหนเป็นค่าว่าง !!!')
                    document.getElementById('txt_vehiclebuywhere').focus();
                    return false;
                } else if (document.getElementById('txt_vehiclebuydate').value == '')
                {
                    alert('วันที่ซื้อเป็นค่าว่าง !!!')
                    document.getElementById('txt_vehiclebuydate').focus();
                    return false;
                } else if (document.getElementById('txt_vehiclebuyprice').value == '')
                {
                    alert('ราคารถเป็นค่าว่าง !!!')
                    document.getElementById('txt_vehiclebuyprice').focus();
                    return false;
                } else if (document.getElementById('cb_vehiclebuyconditon').value == '')
                {
                    alert('เงื่อนไขการซื้อเป็นค่าว่าง !!!')
                    document.getElementById('cb_vehiclebuyconditon').focus();
                    return false;
                } else if (document.getElementById('txt_vehiclestructurewhere').value == '')
                {
                    alert('ต่อโครงสร้างที่ใหนเป็นค่าว่าง !!!')
                    document.getElementById('txt_vehiclestructurewhere').focus();
                    return false;
                } else if (document.getElementById('txt_vehiclestructuredate').value == '')
                {
                    alert('วันที่ต่อโครงสร้างเป็นค่าว่าง !!!')
                    document.getElementById('txt_vehiclestructuredate').focus();
                    return false;
                } else if (document.getElementById('txt_vehiclestructuredprice').value == '')
                {
                    alert('ราคาเป็นค่าว่าง !!!')
                    document.getElementById('txt_vehiclestructuredprice').focus();
                    return false;
                } else if (document.getElementById('txt_vehicleregisterdate').value == '')
                {
                    alert('วันที่จดทะเบียนครั้งแรกเป็นค่าว่าง !!!')
                    document.getElementById('txt_vehicleregisterdate').focus();
                    return false;
                } else if (document.getElementById('txt_vehiclespecial').value == '')
                {
                    alert('อุปกรณ์เฉพาะเป็นค่าว่าง !!!')
                    document.getElementById('txt_vehiclespecial').focus();
                    return false;
                } else if (document.getElementById('cb_carstatus').value == '')
                {
                    alert('สถานะเป็นค่าว่าง !!!')
                    document.getElementById('cb_carstatus').focus();
                    return false;
                } else
                {
                    return true;
                }
            }
            function chknull_vehiclechangehistory()
            {
                if (document.getElementById('cb_chengevchangtypescode').value == '')
                {
                    alert('อะไหล่สำรอง/ประเภทเป็นค่าว่าง !!!')
                    document.getElementById('cb_chengevchangtypescode').focus();
                    return false;
                } else if (document.getElementById('txt_changedate').value == '')
                {
                    alert('วันที่เปลี่ยนอะไหล่เป็นค่าว่าง !!!')
                    document.getElementById('txt_changedate').focus();
                    return false;
                } else if (document.getElementById('txt_changecost').value == '')
                {
                    alert('ราคา/ค่าใช้จ่าย (บาท)เป็นค่าว่าง !!!')
                    document.getElementById('txt_changecost').focus();
                    return false;
                } else if (document.getElementById('txt_chengewhoprocess').value == '')
                {
                    alert('ผู้ดำเนิการเป็นค่าว่าง !!!')
                    document.getElementById('txt_chengewhoprocess').focus();
                    return false;
                } else if (document.getElementById('cb_changstatus').value == '')
                {
                    alert('สถานะเป็นค่าว่าง !!!')
                    document.getElementById('cb_changstatus').focus();
                    return false;
                } else if (document.getElementById('txt_chengecurrentspareparts').value == '')
                {
                    alert('อะไหล่สำรองในปัจจุบันเป็นค่าว่าง !!!')
                    document.getElementById('txt_chengecurrentspareparts').focus();
                    return false;
                } else if (document.getElementById('txt_chengeto').value == '')
                {
                    alert('เปลี่ยนอะไหล่เป็นค่าว่าง !!!')
                    document.getElementById('txt_chengeto').focus();
                    return false;
                } else if (document.getElementById('txt_changeplace').value == '')
                {
                    alert('สถานที่เป็นค่าว่าง !!!')
                    document.getElementById('txt_changeplace').focus();
                    return false;
                } else
                {
                    return true;
                }
            }
            function chknull_vehicleinsured()
            {
                if (document.getElementById('txt_insuredpolicy').value == '')
                {
                    alert('เลขกรมธรรม์เป็นค่าว่าง !!!')
                    document.getElementById('txt_insuredpolicy').focus();
                    return false;
                } else if (document.getElementById('cb_insuredgroup').value == '')
                {
                    alert('กลุ่มประกันภัยเป็นค่าว่าง !!!')
                    document.getElementById('cb_insuredgroup').focus();
                    return false;
                } else if (document.getElementById('cb_insuredtype').value == '')
                {
                    alert('ประเภทประกันภัย !!!')
                    document.getElementById('cb_insuredtype').focus();
                    return false;
                } else if (document.getElementById('txt_insured').value == '')
                {
                    alert('เบี้ยประกันภัยเป็นค่าว่าง !!!')
                    document.getElementById('txt_insured').focus();
                    return false;
                } else if (document.getElementById('txt_insuredcover').value == '')
                {
                    alert('วงเงินความคุ้มครองสูงสุด !!!')
                    document.getElementById('txt_insuredcover').focus();
                    return false;
                } else if (document.getElementById('txt_startdatecover').value == '')
                {
                    alert('วันที่เริ่มคุ้มครองเป็นค่าว่าง !!!')
                    document.getElementById('txt_startdatecover').focus();
                    return false;
                } else if (document.getElementById('txt_enddatecover').value == '')
                {
                    alert('วันที่สิ้นสุดความคุ้มครองเป็นค่าว่าง !!!')
                    document.getElementById('txt_enddatecover').focus();
                    return false;
                } else if (document.getElementById('cb_insuredname').value == '')
                {
                    alert('ชื่อบริษัทผู้เอาประกันภัยเป็นค่าว่าง !!!')
                    document.getElementById('cb_insuredname').focus();
                    return false;
                } else if (document.getElementById('txt_insuredbroker').value == '')
                {
                    alert('ชื่อนายหน้าประกันภัยเป็นค่าว่าง !!!')
                    document.getElementById('txt_insuredbroker').focus();
                    return false;
                } else if (document.getElementById('txt_insuredcompany').value == '')
                {
                    alert('ชื่อบริษัทประกันภัยเป็นค่าว่าง !!!')
                    document.getElementById('txt_insuredcompany').focus();
                    return false;
                } else if (document.getElementById('cb_insuredstatus').value == '')
                {
                    alert('สถานะเป็นค่าว่าง !!!')
                    document.getElementById('cb_insuredstatus').focus();
                    return false;
                } else
                {
                    return true;
                }
            }
            function chknull_vehiclemaintenance()
            {
                if (document.getElementById('txt_maintenancedate').value == '')
                {
                    alert('วันที่เริ่มซ่อมเป็นค่าว่าง !!!')
                    document.getElementById('txt_maintenancedate').focus();
                    return false;
                } else if (document.getElementById('txt_maintenancecompletedate').value == '')
                {
                    alert('วันที่ซ่อมเสร็จเป็นค่าว่าง !!!')
                    document.getElementById('txt_maintenancecompletedate').focus();
                    return false;
                } else if (document.getElementById('txt_maintenanceprice').value == '')
                {
                    alert('ราคา (บาท)เป็นค่าว่าง !!!')
                    document.getElementById('txt_maintenanceprice').focus();
                    return false;
                } else if (document.getElementById('txt_maintenancewhoprocess').value == '')
                {
                    alert('ผู้ดำเนินการเป็นค่าว่าง !!!')
                    document.getElementById('txt_maintenancewhoprocess').focus();
                    return false;
                } else if (document.getElementById('cb_maintenancestatus').value == '')
                {
                    alert('สถานะเป็นค่าว่าง !!!')
                    document.getElementById('cb_maintenancestatus').focus();
                    return false;
                } else if (document.getElementById('txt_maintenancedescription').value == '')
                {
                    alert('รายละเอียดการซ่อมเป็นค่าว่าง !!!')
                    document.getElementById('txt_maintenancedescription').focus();
                    return false;
                } else if (document.getElementById('txt_maintenanceplace').value == '')
                {
                    alert('สถานที่เป็นค่าว่าง !!!')
                    document.getElementById('txt_maintenanceplace').focus();
                    return false;
                } else
                {
                    return true;
                }
            }
            function chknull_vehiclerepair()
            {
                if (document.getElementById('cb_repairtypecode').value == '')
                {
                    alert('ประเภทการซ่อมแซมเป็นค่าว่าง !!!')
                    document.getElementById('cb_repairtypecode').focus();
                    return false;
                } else if (document.getElementById('txt_repairnumber').value == '')
                {
                    alert('ลำดับการซ่อมแซมเป็นค่าว่าง !!!')
                    document.getElementById('txt_repairnumber').focus();
                    return false;
                } else if (document.getElementById('txt_repairgaragename').value == '')
                {
                    alert('ชื่ออู่/ที่อยู่เป็นค่าว่าง !!!')
                    document.getElementById('txt_repairgaragename').focus();
                    return false;
                } else if (document.getElementById('txt_repairstartdate').value == '')
                {
                    alert('วันที่เริ่มซ่อมเป็นค่าว่าง !!!')
                    document.getElementById('txt_repairstartdate').focus();
                    return false;
                } else if (document.getElementById('txt_repairenddate').value == '')
                {
                    alert('วันที่กำหนดซ่อมเสร็จเป็นค่าว่าง !!!')
                    document.getElementById('txt_repairenddate').focus();
                    return false;
                } else if (document.getElementById('txt_repairactualenddate').value == '')
                {
                    alert('วันที่ซ่อมเสร็จเป็นค่าว่าง !!!')
                    document.getElementById('txt_repairactualenddate').focus();
                    return false;
                } else if (document.getElementById('txt_repairtotalamount').value == '')
                {
                    alert('ราคา (บาท)เป็นค่าว่าง !!!')
                    document.getElementById('txt_repairtotalamount').focus();
                    return false;
                } else if (document.getElementById('txt_repairwhoprocess').value == '')
                {
                    alert('ผู้ดำเนินการเป็นค่าว่าง !!!')
                    document.getElementById('txt_repairwhoprocess').focus();
                    return false;
                } else if (document.getElementById('cb_repairstatus').value == '')
                {
                    alert('สถานะเป็นค่าว่าง !!!')
                    document.getElementById('cb_repairstatus').focus();
                    return false;
                } else if (document.getElementById('txt_repairresson').value == '')
                {
                    alert('สาเหตุเป็นค่าว่าง !!!')
                    document.getElementById('txt_repairresson').focus();
                    return false;
                } else if (document.getElementById('txt_repairdetail').value == '')
                {
                    alert('รายละเอียดการซ่อมแซมเป็นค่าว่าง !!!')
                    document.getElementById('txt_repairdetail').focus();
                    return false;
                } else
                {
                    return true;
                }
            }
            function chknull_vehicletax()
            {
                if (document.getElementById('txt_taxdate').value == '')
                {
                    alert('วันที่เริ่มเสียภาษีเป็นค่าว่าง !!!')
                    document.getElementById('txt_taxdate').focus();
                    return false;
                } else if (document.getElementById('txt_taxexpiredate').value == '')
                {
                    alert('วันที่หมดอายุเป็นค่าว่าง !!!')
                    document.getElementById('txt_taxexpiredate').focus();
                    return false;
                } else if (document.getElementById('txt_taxprice').value == '')
                {
                    alert('ราคา (ราคา)เป็นค่าว่าง !!!')
                    document.getElementById('txt_taxprice').focus();
                    return false;
                } else if (document.getElementById('txt_taxservicefee').value == '')
                {
                    alert('ค่าธรรมเนียมเป็นค่าว่าง !!!')
                    document.getElementById('txt_taxservicefee').focus();
                    return false;
                } else if (document.getElementById('txt_taxwhoprocess').value == '')
                {
                    alert('ผู้ดำเนินการเป็นค่าว่าง !!!')
                    document.getElementById('txt_taxwhoprocess').focus();
                    return false;
                } else if (document.getElementById('cb_taxstatus').value == '')
                {
                    alert('สถานะเป็นค่าว่าง !!!')
                    document.getElementById('cb_taxstatus').focus();
                    return false;
                } else if (document.getElementById('txt_taxplace').value == '')
                {
                    alert('สถานที่เป็นค่าว่าง !!!')
                    document.getElementById('txt_taxplace').focus();
                    return false;
                } else
                {
                    return true;
                }
            }
            function chknull_vehicleowner()
            {
                if (document.getElementById('cb_ownercompany').value == '')
                {
                    alert('บริษัทเจ้าของรถเป็นค่าว่าง !!!')
                    document.getElementById('cb_ownercompany').focus();
                    return false;
                } else if (document.getElementById('cb_ownerprocesscompany').value == '')
                {
                    alert('บริษัทที่ใช้รถเป็นค่าว่าง !!!')
                    document.getElementById('cb_ownerprocesscompany').focus();
                    return false;
                } else if (document.getElementById('cb_ownerstatus').value == '')
                {
                    alert('สถานะเป็นค่าว่าง !!!')
                    document.getElementById('cb_ownerstatus').focus();
                    return false;
                } else if (document.getElementById('txt_ownerproject').value == '')
                {
                    alert('ใช้ในสายงานเป็นค่าว่าง !!!')
                    document.getElementById('txt_ownerproject').focus();
                    return false;
                } else if (document.getElementById('txt_ownerremark').value == '')
                {
                    alert('หมายเหตุเป็นค่าว่าง !!!')
                    document.getElementById('txt_ownerremark').focus();
                    return false;
                } else if (document.getElementById('txt_owerfristdirver').value == '')
                {
                    alert('ผู้ขับขี่คนแรกเป็นค่าว่าง !!!')
                    document.getElementById('txt_owerfristdirver').focus();
                    return false;
                } else if (document.getElementById('txt_ownerseconddirver').value == '')
                {
                    alert('ผู้ขับขี่คนที่สองเป็นค่าว่าง !!!')
                    document.getElementById('txt_ownerseconddirver').focus();
                    return false;
                } else
                {
                    return true;
                }
            }
            function chknull_vehiclepurchase()
            {
                if (document.getElementById('cb_purchasesuppliercode').value == '')
                {
                    alert('ชื่อผู้ประกอบการเป็นค่าว่าง !!!')
                    document.getElementById('cb_purchasesuppliercode').focus();
                    return false;
                } else if (document.getElementById('txt_purchaseleasingname').value == '')
                {
                    alert('ชื่อผู้เช่าเป็นค่าว่าง !!!')
                    document.getElementById('txt_purchaseleasingname').focus();
                    return false;
                } else if (document.getElementById('txt_purchasedate').value == '')
                {
                    alert('วันที่สั่งซื้อเป็นค่าว่าง !!!')
                    document.getElementById('txt_purchasedate').focus();
                    return false;
                } else if (document.getElementById('txt_purchaseprice').value == '')
                {
                    alert('ราคา (บาท)เป็นค่าว่าง !!!')
                    document.getElementById('txt_purchaseprice').focus();
                    return false;
                } else if (document.getElementById('txt_purchaseinterestrate').value == '')
                {
                    alert('ดอกเบี้ย (%)เป็นค่าว่าง !!!')
                    document.getElementById('txt_purchaseinterestrate').focus();
                    return false;
                } else if (document.getElementById('txt_purchasepaymenttime').value == '')
                {
                    alert('เวลาชำระเงินเป็นค่าว่าง !!!')
                    document.getElementById('txt_purchasepaymenttime').focus();
                    return false;
                } else if (document.getElementById('txt_purchasefirstpaymentdate').value == '')
                {
                    alert('วันที่ (ชำระเงินครังแรก)เป็นค่าว่าง !!!')
                    document.getElementById('txt_purchasefirstpaymentdate').focus();
                    return false;
                } else if (document.getElementById('txt_purchaselastpaymentdate').value == '')
                {
                    alert('วันที่ (ชำระเงินครังสุดท้าย)เป็นค่าว่าง !!!')
                    document.getElementById('txt_purchaselastpaymentdate').focus();
                    return false;
                } else if (document.getElementById('txt_purchasestatus').value == '')
                {
                    alert('สถานะเป็นค่าว่าง !!!')
                    document.getElementById('txt_purchasestatus').focus();
                    return false;
                } else
                {
                    return true;
                }
            }

            function chknull_vehicleattribute()
            {
                if (document.getElementById('file_front').value == '')
                {
                    alert('ด้านหน้าเป็นค่าว่าง !!!')
                    document.getElementById('file_front').focus();
                    return false;
                } else if (document.getElementById('front_width').value == '')
                {
                    alert('กว้าง(ด้านหน้า)เป็นค่าว่าง !!!')
                    document.getElementById('front_width').focus();
                    return false;
                } else if (document.getElementById('front_long').value == '')
                {
                    alert('ยาว(ด้านหน้า)เป็นค่าว่าง !!!')
                    document.getElementById('front_long').focus();
                    return false;
                } else if (document.getElementById('front_high').value == '')
                {
                    alert('สูง(ด้านหน้า)เป็นค่าว่าง !!!')
                    document.getElementById('front_high').focus();
                    return false;
                } else if (document.getElementById('file_side').value == '')
                {
                    alert('ด้านข้างเป็นค่าว่าง !!!')
                    document.getElementById('file_side').focus();
                    return false;
                } else if (document.getElementById('side_width').value == '')
                {
                    alert('กว้าง(ด้านข้าง)เป็นค่าว่าง !!!')
                    document.getElementById('side_width').focus();
                    return false;
                } else if (document.getElementById('side_long').value == '')
                {
                    alert('ยาวเป็นค่าว่าง !!!')
                    document.getElementById('side_long').focus();
                    return false;
                } else if (document.getElementById('side_high').value == '')
                {
                    alert('สูง(ด้านข้าง)เป็นค่าว่าง !!!')
                    document.getElementById('side_high').focus();
                    return false;
                } else if (document.getElementById('file_back').value == '')
                {
                    alert('ด้านหลังเป็นค่าว่าง !!!')
                    document.getElementById('file_back').focus();
                    return false;
                } else if (document.getElementById('back_width').value == '')
                {
                    alert('กว้าง(ด้านหลัง)เป็นค่าว่าง !!!')
                    document.getElementById('back_width').focus();
                    return false;
                } else if (document.getElementById('back_long').value == '')
                {
                    alert('ยาว(ด้านหลัง)เป็นค่าว่าง !!!')
                    document.getElementById('back_long').focus();
                    return false;
                } else if (document.getElementById('back_high').value == '')
                {
                    alert('สูง(ด้านหลัง)เป็นค่าว่าง !!!')
                    document.getElementById('back_high').focus();
                    return false;
                } else if (document.getElementById('file_in').value == '')
                {
                    alert('ด้านในเป็นค่าว่าง !!!')
                    document.getElementById('file_in').focus();
                    return false;
                } else if (document.getElementById('txt_attributestatus').value == '')
                {
                    alert('สถานะเป็นค่าว่าง !!!')
                    document.getElementById('txt_attributestatus').focus();
                    return false;
                } else
                {
                    return true;
                }
            }
            function edit_dirver1(data)
            {

                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "edit_dirver1", data: data
                    },
                    success: function (response) {

                        document.getElementById("dirveredit1").innerHTML = response;
                        document.getElementById("dirverdef1").innerHTML = '';

                    }
                });


            }
            function edit_dirver2(data)
            {

                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "edit_dirver2", data: data
                    },
                    success: function (response) {

                        document.getElementById("dirveredit2").innerHTML = response;
                        document.getElementById("dirverdef2").innerHTML = '';

                    }
                });


            }

            function save_vehicleinfo(vehicleinfoid)
            {
                var vehiclenumber = document.getElementById('txt_vehiclenumber').value;
                var cargroup = document.getElementById('cb_cargroup').value;
                var cartype = document.getElementById('cb_cartype').value;
                var carbrand = document.getElementById('cb_carbrand').value;
                var geartype = document.getElementById('cb_geartype').value;
                var carcolor = document.getElementById('cb_carcolor').value;
                var series_model = document.getElementById('txt_series_model').value;
                var carnameth = document.getElementById('txt_carnameth').value;
                var carnameen = document.getElementById('txt_carnameen').value;
                var horse = document.getElementById('txt_horse').value;
                var cc = document.getElementById('txt_cc').value;
                var machine = document.getElementById('txt_machine').value;
                var chassisnumber = document.getElementById('txt_chassisnumber').value;
                var energy = document.getElementById('cb_energy').value;
                var weight = document.getElementById('txt_weight').value;
                var axle = document.getElementById('cb_axle').value;
                var piston = document.getElementById('cb_piston').value;
                var maxload = document.getElementById('txt_maxload').value;
                var used = document.getElementById('cb_used').value;
                var vehiclebuywhere = document.getElementById('txt_vehiclebuywhere').value;
                var vehiclebuydate = document.getElementById('txt_vehiclebuydate').value;
                var vehiclebuyprice = document.getElementById('txt_vehiclebuyprice').value;
                var vehiclebuyconditon = document.getElementById('cb_vehiclebuyconditon').value;
                var vehiclestructurewhere = document.getElementById('txt_vehiclestructurewhere').value;
                var vehiclestructuredate = document.getElementById('txt_vehiclestructuredate').value;
                var vehiclestructuredprice = document.getElementById('txt_vehiclestructuredprice').value;
                var vehicleregisterdate = document.getElementById('txt_vehicleregisterdate').value;
                var vehiclespecial = document.getElementById('txt_vehiclespecial').value;

                var carstatus = document.getElementById('cb_carstatus').value;
                var inforemark = document.getElementById('txt_inforemark').value;


                if (chknull_vehicleinfo())
                {

                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "save_vehicleinfo", vehicleinfoid: vehicleinfoid, vehiclenumber: vehiclenumber, cargroup: cargroup, cartype: cartype, carbrand: carbrand, geartype: geartype, carcolor: carcolor, series_model: series_model, carnameth: carnameth, carnameen: carnameen, horse: horse, cc: cc, machine: machine, chassisnumber: chassisnumber, energy: energy, weight: weight, axle: axle, piston: piston, maxload: maxload, used: used, vehiclebuywhere: vehiclebuywhere, vehiclebuydate: vehiclebuydate, vehiclebuyprice: vehiclebuyprice, vehiclebuyconditon: vehiclebuyconditon, vehiclestructurewhere: vehiclestructurewhere, vehiclestructuredate: vehiclestructuredate, vehiclestructuredprice: vehiclestructuredprice, vehicleregisterdate: vehicleregisterdate, vehiclespecial: vehiclespecial, carstatus: carstatus, inforemark: inforemark
                        },
                        success: function (response) {
                            alert(response);
                            window.location.reload();
                        }
                    });

                }
            }
            function save_vehiclechangehistory(vehiclechangehistoryid)
            {

                var vehicleinfoid = document.getElementById('txt_vehicleinfoid').value;
                var chengevchangtypescode = document.getElementById('cb_chengevchangtypescode').value;
                var changedate = document.getElementById('txt_changedate').value;
                var changecost = document.getElementById('txt_changecost').value;
                var chengewhoprocess = document.getElementById('txt_chengewhoprocess').value;
                var changstatus = document.getElementById('cb_changstatus').value;
                var chengecurrentspareparts = document.getElementById('txt_chengecurrentspareparts').value;
                var chengeto = document.getElementById('txt_chengeto').value;
                var changeplace = document.getElementById('txt_changeplace').value;
                var chengremark = document.getElementById('txt_chengremark').value;
                if (chknull_vehiclechangehistory())
                {

                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "save_vehiclechangehistory", vehiclechangehistoryid: vehiclechangehistoryid, vehicleinfoid: vehicleinfoid, chengevchangtypescode: chengevchangtypescode, changedate: changedate, changecost: changecost, chengewhoprocess: chengewhoprocess, changstatus: changstatus, chengecurrentspareparts: chengecurrentspareparts, chengeto: chengeto, changeplace: changeplace, chengremark: chengremark
                        },
                        success: function (response) {
                            alert(response);
                            window.location.reload();
                        }
                    });

                }

            }
            function save_vehicleinsured(vehicleinsuredid)
            {

                var vehicleinfoid = document.getElementById('txt_vehicleinfoid').value;
                var insuredpolicy = document.getElementById('txt_insuredpolicy').value;
                var insuredgroup = document.getElementById('cb_insuredgroup').value;
                var insuredtype = document.getElementById('cb_insuredtype').value;
                var insured = document.getElementById('txt_insured').value;
                var insuredcover = document.getElementById('txt_insuredcover').value;
                var startdatecover = document.getElementById('txt_startdatecover').value;
                var enddatecover = document.getElementById('txt_enddatecover').value;
                var insuredname = document.getElementById('cb_insuredname').value;
                var insuredbroker = document.getElementById('txt_insuredbroker').value;
                var insuredcompany = document.getElementById('txt_insuredcompany').value;
                var insuredstatus = document.getElementById('cb_insuredstatus').value;
                var insuredremark = document.getElementById('txt_insuredremark').value;

                if (chknull_vehicleinsured())
                {

                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "save_vehicleinsured", vehicleinsuredid: vehicleinsuredid, vehicleinfoid: vehicleinfoid, insuredpolicy: insuredpolicy, insuredgroup: insuredgroup, insuredtype: insuredtype, insured: insured, insuredcover: insuredcover, startdatecover: startdatecover, enddatecover: enddatecover, insuredname: insuredname, insuredbroker: insuredbroker, insuredcompany: insuredcompany, insuredstatus: insuredstatus, insuredremark: insuredremark
                        },
                        success: function (response) {
                            alert(response);
                            window.location.reload();
                        }
                    });

                }

            }
            function save_vehiclemaintenance(vehiclemaintenanceid)
            {

                var vehicleinfoid = document.getElementById('txt_vehicleinfoid').value;
                var maintenancedate = document.getElementById('txt_maintenancedate').value;
                var maintenancecompletedate = document.getElementById('txt_maintenancecompletedate').value;
                var maintenanceprice = document.getElementById('txt_maintenanceprice').value;
                var maintenancewhoprocess = document.getElementById('txt_maintenancewhoprocess').value;
                var maintenancestatus = document.getElementById('cb_maintenancestatus').value;
                var maintenancedescription = document.getElementById('txt_maintenancedescription').value;
                var maintenanceplace = document.getElementById('txt_maintenanceplace').value;
                var maintenanceremark = document.getElementById('txt_maintenanceremark').value;


                if (chknull_vehiclemaintenance())
                {

                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "save_vehiclemaintenance", vehiclemaintenanceid: vehiclemaintenanceid, vehicleinfoid: vehicleinfoid, maintenancedate: maintenancedate, maintenancecompletedate: maintenancecompletedate, maintenanceprice: maintenanceprice, maintenancewhoprocess: maintenancewhoprocess, maintenancestatus: maintenancestatus, maintenancedescription: maintenancedescription, maintenanceplace: maintenanceplace, maintenanceremark: maintenanceremark
                        },
                        success: function (response) {
                            alert(response);
                            window.location.reload();
                        }
                    });

                }

            }
            function save_vehiclerepair(vehiclerepairid)
            {
                var vehicleinfoid = document.getElementById('txt_vehicleinfoid').value;
                var repairtypecode = document.getElementById('cb_repairtypecode').value;
                var repairnumber = document.getElementById('txt_repairnumber').value;
                var repairgaragename = document.getElementById('txt_repairgaragename').value;
                var repairstartdate = document.getElementById('txt_repairstartdate').value;
                var repairenddate = document.getElementById('txt_repairenddate').value;
                var repairactualenddate = document.getElementById('txt_repairactualenddate').value;
                var repairtotalamount = document.getElementById('txt_repairtotalamount').value;
                var repairwhoprocess = document.getElementById('txt_repairwhoprocess').value;
                var repairstatus = document.getElementById('cb_repairstatus').value;
                var repairresson = document.getElementById('txt_repairresson').value;
                var repairdetail = document.getElementById('txt_repairdetail').value;
                var repairremark = document.getElementById('txt_repairremark').value;


                if (chknull_vehiclerepair())
                {
                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "save_vehiclerepair", vehiclerepairid: vehiclerepairid, vehicleinfoid: vehicleinfoid, repairtypecode: repairtypecode, repairnumber: repairnumber, repairnumber: repairnumber, repairgaragename: repairgaragename, repairstartdate: repairstartdate, repairenddate: repairenddate, repairactualenddate: repairactualenddate, repairtotalamount: repairtotalamount, repairwhoprocess: repairwhoprocess, repairstatus: repairstatus, repairresson: repairresson, repairdetail: repairdetail, repairremark: repairremark

                        },
                        success: function (response) {
                            alert(response);
                            window.location.reload();
                        }
                    });

                }

            }
            function save_vehicletax(vehicletaxid)
            {
                var vehicleinfoid = document.getElementById('txt_vehicleinfoid').value;
                var taxdate = document.getElementById('txt_taxdate').value;
                var taxexpiredate = document.getElementById('txt_taxexpiredate').value;
                var taxprice = document.getElementById('txt_taxprice').value;
                var taxservicefee = document.getElementById('txt_taxservicefee').value;
                var taxwhoprocess = document.getElementById('txt_taxwhoprocess').value;
                var taxstatus = document.getElementById('cb_taxstatus').value;
                var taxplace = document.getElementById('txt_taxplace').value;
                var taxremark = document.getElementById('txt_taxremark').value;


                if (chknull_vehicletax())
                {
                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "save_vehicletax", vehicletaxid: vehicletaxid, vehicleinfoid: vehicleinfoid, taxdate: taxdate, taxexpiredate: taxexpiredate, taxprice: taxprice, taxservicefee: taxservicefee, taxwhoprocess: taxwhoprocess, taxstatus: taxstatus, taxplace: taxplace, taxremark: taxremark
                        },
                        success: function (response) {
                            alert(response);
                            window.location.reload();
                        }
                    });

                }

            }
            function save_dirver(data, values)
            {

                var vehicleownerid = document.getElementById('txt_vehicleownerid').value;

                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "save_ownerdirver", vehicleownerid: vehicleownerid, firstdirver: data, values: values
                    },
                    success: function (response) {
                        alert(response);
                        window.location.reload();
                    }
                });
            }

            function save_vehicleowner(vehicleownerid)
            {
                var vehicleinfoid = document.getElementById('txt_vehicleinfoid').value;
                var ownercompany = document.getElementById('cb_ownercompany').value;
                var ownerprocesscompany = document.getElementById('cb_ownerprocesscompany').value;
                var ownerstatus = document.getElementById('cb_ownerstatus').value;
                var ownerproject = document.getElementById('txt_ownerproject').value;
                var ownerremark = document.getElementById('txt_ownerremark').value;
                var owerfristdirver = document.getElementById('txt_owerfristdirver').value;
                var ownerseconddirver = document.getElementById('txt_ownerseconddirver').value;


                if (chknull_vehicleowner())
                {
                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "save_vehicleowner", vehicleownerid: vehicleownerid, vehicleinfoid: vehicleinfoid, ownercompany: ownercompany, ownerprocesscompany: ownerprocesscompany, ownerstatus: ownerstatus, ownerproject: ownerproject, ownerremark: ownerremark, owerfristdirver: owerfristdirver, ownerseconddirver: ownerseconddirver
                        },
                        success: function (response) {
                            alert(response);
                            window.location.reload();
                        }
                    });

                }

            }
            function save_vehiclepurchase(vehiclepurchaseid)
            {
                var vehicleinfoid = document.getElementById('txt_vehicleinfoid').value;
                var purchasesuppliercode = document.getElementById('cb_purchasesuppliercode').value;
                var purchaseleasingname = document.getElementById('txt_purchaseleasingname').value;
                var purchasedate = document.getElementById('txt_purchasedate').value;
                var purchaseprice = document.getElementById('txt_purchaseprice').value;
                var purchaseinterestrate = document.getElementById('txt_purchaseinterestrate').value;
                var purchasefirstpaymentdate = document.getElementById('txt_purchasefirstpaymentdate').value;
                var purchasepaymenttime = document.getElementById('txt_purchasepaymenttime').value;
                var purchaselastpaymentdate = document.getElementById('txt_purchaselastpaymentdate').value;
                var purchasestatus = document.getElementById('txt_purchasestatus').value;
                var purchaseremark = document.getElementById('txt_purchaseremark').value;


                if (chknull_vehiclepurchase())
                {
                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "save_vehiclepurchase", vehiclepurchaseid: vehiclepurchaseid, vehicleinfoid: vehicleinfoid, purchasesuppliercode: purchasesuppliercode, purchaseleasingname: purchaseleasingname, purchasedate: purchasedate, purchaseprice: purchaseprice, purchaseinterestrate: purchaseinterestrate, purchasepaymenttime: purchasepaymenttime, purchasefirstpaymentdate: purchasefirstpaymentdate, purchaselastpaymentdate: purchaselastpaymentdate, purchasestatus: purchasestatus, purchaseremark: purchaseremark
                        },
                        success: function (response) {
                            alert(response);
                            window.location.reload();
                        }
                    });

                }

            }
            function save_vehicleattribute(vehicleattributeid)
            {
                var vehicleinfoid = document.getElementById('txt_vehicleinfoid').value;
                var front = document.getElementById('file_front').value;
                var frontwidth = document.getElementById('front_width').value;
                var frontlong = document.getElementById('front_long').value;
                var fronthigh = document.getElementById('front_high').value;
                var side = document.getElementById('file_side').value;
                var sidewidth = document.getElementById('side_width').value;
                var sidelong = document.getElementById('side_long').value;
                var sidehigh = document.getElementById('side_high').value;
                var fileback = document.getElementById('file_back').value;
                var backwidth = document.getElementById('back_width').value;
                var backlong = document.getElementById('back_long').value;
                var backhigh = document.getElementById('back_high').value;
                var filein = document.getElementById('file_in').value;
                var txtattributeremark = document.getElementById('txt_attributeremark').value;
                var txtattributestatus = document.getElementById('txt_attributestatus').value;

                if (chknull_vehicleattribute())
                {
                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "save_vehicleattribute", vehicleattributeid: vehicleattributeid, vehicleinfoid: vehicleinfoid, front: front, frontwidth: frontwidth, frontlong: frontlong, fronthigh: fronthigh, side: side, sidewidth: sidewidth, sidelong: sidelong, sidehigh: sidehigh, fileback: fileback, backwidth: backwidth, backlong: backlong, backhigh: backhigh, filein: filein, txtattributeremark: txtattributeremark, txtattributestatus: txtattributestatus
                        },
                        success: function (response) {
                            alert(response);
                            window.location.reload();
                        }
                    });

                }

            }
            function delete_vehiclechangehistory(vehiclechangehistoryid)
            {
                var confirmation = confirm("ต้องการลบข้อมูล ?");

                if (confirmation) {
                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "delete_vehiclechangehistory", vehiclechangehistoryid: vehiclechangehistoryid
                        },
                        success: function () {
                            alert('ลบข้อมูลเรียบร้อยแล้ว');
                            window.location.reload();
                        }
                    });
                }
            }
            function delete_vehicleinsured(vehicleinsuredid)
            {
                var confirmation = confirm("ต้องการลบข้อมูล ?");

                if (confirmation) {
                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "delete_vehicleinsured", vehicleinsuredid: vehicleinsuredid
                        },
                        success: function () {
                            alert('ลบข้อมูลเรียบร้อยแล้ว');
                            window.location.reload();
                        }
                    });
                }
            }
            function delete_vehiclemaintenance(vehiclemaintenanceid)
            {
                var confirmation = confirm("ต้องการลบข้อมูล ?");

                if (confirmation) {
                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "delete_vehiclemaintenance", vehiclemaintenanceid: vehiclemaintenanceid
                        },
                        success: function () {
                            alert('ลบข้อมูลเรียบร้อยแล้ว');
                            window.location.reload();
                        }
                    });
                }
            }
            function delete_vehiclerepair(vehiclerepairid)
            {
                var confirmation = confirm("ต้องการลบข้อมูล ?");

                if (confirmation) {
                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "delete_vehiclerepair", vehiclerepairid: vehiclerepairid
                        },
                        success: function () {
                            alert('ลบข้อมูลเรียบร้อยแล้ว');
                            window.location.reload();
                        }
                    });
                }
            }
            function delete_vehicletax(vehicletaxid)
            {
                var confirmation = confirm("ต้องการลบข้อมูล ?");

                if (confirmation) {
                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "delete_vehicletax", vehicletaxid: vehicletaxid
                        },
                        success: function () {
                            alert('ลบข้อมูลเรียบร้อยแล้ว');
                            window.location.reload();
                        }
                    });
                }
            }
            function delete_vehicleowner(vehicleownerid)
            {
                var confirmation = confirm("ต้องการลบข้อมูล ?");

                if (confirmation) {
                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "delete_vehicleowner", vehicleownerid: vehicleownerid
                        },
                        success: function () {
                            alert('ลบข้อมูลเรียบร้อยแล้ว');
                            window.location.reload();
                        }
                    });
                }
            }
            function delete_vehiclepurchase(vehiclepurchaseid)
            {
                var confirmation = confirm("ต้องการลบข้อมูล ?");

                if (confirmation) {
                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "delete_vehiclepurchase", vehiclepurchaseid: vehiclepurchaseid
                        },
                        success: function () {
                            alert('ลบข้อมูลเรียบร้อยแล้ว');
                            window.location.reload();
                        }
                    });
                }
            }
            $('#txt_purchasepaymenttime').datetimepicker({
                datepicker: false,
                format: 'H:i',
                mask: '29:59',
            });
        </script>
        <script type="text/javascript">

            var txt_chengewhoprocess = [
<?php
$Empname1 = "";
$sql_seEmpname1 = "{call megStopwork_v2(?,?)}";
$params_seEmpname1 = array(
    array('select_employee', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seEmpname1 = sqlsrv_query($conn, $sql_seEmpname1, $params_seEmpname1);
while ($result_seEmpname1 = sqlsrv_fetch_array($query_seEmpname1, SQLSRV_FETCH_ASSOC)) {
    $Empname1 .= "'" . $result_seEmpname1['NAME'] . "',";
}
echo rtrim($Empname1, ",");
?>
            ];

            $(function () {
                $("#txt_chengewhoprocess").autocomplete({
                    source: [txt_chengewhoprocess]
                });


            });


            var txt_maintenancewhoprocess = [
<?php
$Empname2 = "";
$sql_seEmpname2 = "{call megStopwork_v2(?,?)}";
$params_seEmpname2 = array(
    array('select_employee', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seEmpname2 = sqlsrv_query($conn, $sql_seEmpname2, $params_seEmpname2);
while ($result_seEmpname2 = sqlsrv_fetch_array($query_seEmpname2, SQLSRV_FETCH_ASSOC)) {
    $Empname2 .= "'" . $result_seEmpname2['NAME'] . "',";
}
echo rtrim($Empname2, ",");
?>
            ];

            $(function () {
                $("#txt_maintenancewhoprocess").autocomplete({
                    source: [txt_maintenancewhoprocess]
                });


            });
            var txt_repairwhoprocess = [
<?php
$Empname3 = "";
$sql_seEmpname3 = "{call megStopwork_v2(?,?)}";
$params_seEmpname3 = array(
    array('select_employee', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seEmpname3 = sqlsrv_query($conn, $sql_seEmpname3, $params_seEmpname3);
while ($result_seEmpname3 = sqlsrv_fetch_array($query_seEmpname3, SQLSRV_FETCH_ASSOC)) {
    $Empname3 .= "'" . $result_seEmpname3['NAME'] . "',";
}
echo rtrim($Empname3, ",");
?>
            ];

            $(function () {
                $("#txt_repairwhoprocess").autocomplete({
                    source: [txt_repairwhoprocess]
                });


            });
            var txt_taxwhoprocess = [
<?php
$Empname4 = "";
$sql_seEmpname4 = "{call megStopwork_v2(?,?)}";
$params_seEmpname4 = array(
    array('select_employee', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seEmpname4 = sqlsrv_query($conn, $sql_seEmpname4, $params_seEmpname4);
while ($result_seEmpname4 = sqlsrv_fetch_array($query_seEmpname4, SQLSRV_FETCH_ASSOC)) {
    $Empname4 .= "'" . $result_seEmpname4['NAME'] . "',";
}
echo rtrim($Empname4, ",");
?>
            ];

            $(function () {
                $("#txt_taxwhoprocess").autocomplete({
                    source: [txt_taxwhoprocess]
                });


            });
            var txt_owerfristdirver = [
<?php
$Empname5 = "";
$sql_seEmpname5 = "{call megStopwork_v2(?,?)}";
$params_seEmpname5 = array(
    array('select_employee', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seEmpname5 = sqlsrv_query($conn, $sql_seEmpname5, $params_seEmpname5);
while ($result_seEmpname5 = sqlsrv_fetch_array($query_seEmpname5, SQLSRV_FETCH_ASSOC)) {
    $Empname5 .= "'" . $result_seEmpname5['NAME'] . "',";
}
echo rtrim($Empname5, ",");
?>
            ];

            $(function () {
                $("#txt_owerfristdirver").autocomplete({
                    source: [txt_owerfristdirver]
                });


            });
            var txt_ownerseconddirver = [
<?php
$Empname6 = "";
$sql_seEmpname6 = "{call megStopwork_v2(?,?)}";
$params_seEmpname6 = array(
    array('select_employee', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seEmpname6 = sqlsrv_query($conn, $sql_seEmpname6, $params_seEmpname6);
while ($result_seEmpname6 = sqlsrv_fetch_array($query_seEmpname6, SQLSRV_FETCH_ASSOC)) {
    $Empname6 .= "'" . $result_seEmpname6['NAME'] . "',";
}
echo rtrim($Empname6, ",");
?>
            ];

            $(function () {
                $("#txt_ownerseconddirver").autocomplete({
                    source: [txt_ownerseconddirver]
                });


            });



            $(document).on('click', '.browse', function () {
                var file = $(this).parent().parent().parent().find('.file');
                file.trigger('click');
            });
            $(document).on('change', '.file', function () {
                $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
            });






            $(document).ready(function () {
                $('.thumbnail').click(function () {
                    $('.modal-body').empty();
                    var title = $(this).parent('a').attr("title");
                    $('.modal-title').html(title);
                    $($(this).parents('div').html()).appendTo('.modal-body');
                    $('#myModal').modal({show: true});
                });
            });
        </script>
        <script type="text/javascript">
            function setVal(dataVar) {
                $("#file_front").val(dataVar);
                $.post("update_data.php", $("#saveform").serialize(), function (gData) {
                    $("#saveform")[0].reset();
                    $("#ShowData").html(gData);
                });
            }
        </script>
    </body>

</html>
<?php
sqlsrv_close($conn);
?>
