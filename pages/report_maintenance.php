<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");


$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);
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
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">


        <link href="../dist/css/buttons.dataTables.min.css" rel="stylesheet">
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">

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


        <link href="style/style.css" rel="stylesheet" type="text/css">

    </head>

    <body >
        <div class="modal fade" id="modal_image" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div id="modalimage"></div>
            </div>
        </div>
        <div class="modal fade" id="modal_repair" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 80%">
                <div id="datamodal_sr"></div>
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
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="page-header"><i class="fa fa-file-text-o"></i> 
                            รายงานขอแจ้งซ่อม
                        </h2>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>


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
                        <div class="form-group">
                            <button type="button" class="btn btn-default" onclick="select_repair();">ค้นหา <li class="fa fa-search"></li></button>
                        </div>

                    </div>

                </div>
                <div class="row">

                    <div class="col-lg-6" >
                        <label>&nbsp;</label><br>
                        <!--<a href="#" onclick="pdf_chartstopwork();" class="btn btn-default">สถิติการขอหยุดรถ <li class="fa fa-print"></li></a>-->
                    </div>
                    <div class="col-lg-6" style="text-align: right">
                        <label>&nbsp;</label><br>
                        <a href="#" onclick="excel_repair3();" class="btn btn-default">รายงาน <li class="fa fa-file-excel-o"></li></a>
                        <a href="#" onclick="excel_repair2();" class="btn btn-default">รายงาน(Summary) <li class="fa fa-file-excel-o"></li></a>
                    </div>
                </div>
                <div class="row" >
                    <div class="col-lg-12">
                        &nbsp;

                    </div>
                </div>
                <div class="row">

                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                รายงานขอแจ้งซ่อม
                            </div>
                            <!-- /.panel-heading -->

                            <div class="panel-body">


                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
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
                                                            <button  class="btn btn-default btn-circle" data-toggle="modal"  data-target="#modal_repair"  onclick="select_modalrepair('<?= $result_seRepair['EMPLOYEEREPAIRID'] ?>')"><span class="glyphicon glyphicon-search"></span></button>
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

                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!--<script src="../vendor/jquery/jquery.min.js"></script>-->
        <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="../vendor/metisMenu/metisMenu.min.js"></script>
        <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
        <script src="../dist/js/sb-admin-2.js"></script>
        <script src="../js/jquery.datetimepicker.full.js"></script>

        <script src="../dist/js/jszip.min.js"></script>
        <script src="../dist/js/dataTables.buttons.min.js"></script>
        <script src="../dist/js/buttons.html5.min.js"></script>
        <script src="../dist/js/buttons.print.min.js"></script>
        <script src="../dist/js/bootstrap-select.js"></script>
        <script src="../dist/js/jquery.autocomplete.js"></script>
        <?php
        if ($_GET['companycode'] == 'RRC' || $_GET['companycode'] == 'RCC' || $_GET['companycode'] == 'RATC') {
            $car_amt = select_carautocomplate('megVehicleinfo_v2', 'selectcond_vehicleinfo', " AND a.THAINAME != '-' AND (a.ENGNAME  LIKE '%R-%' OR a.ENGNAME  LIKE '%RA-%'", " OR a.THAINAME LIKE '%ดินแดง%'  OR a.THAINAME  LIKE '%อุทัยธานี%'  OR a.THAINAME  LIKE '%คลองเขื่อน%'  ", " OR a.THAINAME LIKE '%RP-%' OR a.THAINAME  LIKE '%สวนผึ้ง%' OR a.THAINAME  LIKE '%ด่านช้าง%'", " OR a.ENGNAME LIKE '%Khao Chamao%' OR a.ENGNAME LIKE '%Kerry%' OR a.ENGNAME LIKE '%Chaloem Prakiat%')");
        } else {
            $car_amt = select_vehiclenumberautocomplate('megVehicleinfo_v2', 'select_vehicleinfo', '');
        }
        ?>
        <script>
             function excel_repair2()
            {
                var datestart = document.getElementById('txt_datestart').value;
                var dateend = document.getElementById('txt_dateend').value;

                window.open('excel_repair2.php?datestart=' + datestart + '&dateend=' + dateend, '_blank');
            }
                                                            function excel_repair3()
                                                            {
                                                                var datestart = document.getElementById('txt_datestart').value;
                                                                var dateend = document.getElementById('txt_dateend').value;

                                                                window.open('excel_repair3.php?datestart=' + datestart + '&dateend=' + dateend, '_blank');
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
                                                            //var txt_technician = [<?//= $emp_rtd ?>];

                                                            //$(function () {
                                                            //    $("#txt_technician").autocomplete({
                                                            //        source: [txt_technician]
                                                            //    });


                                                            //});
                                                            //var txt_empinform1 = [<?//= $emp_rtd ?>];

                                                            //$(function () {
                                                            //    $("#txt_empinform1").autocomplete({
                                                            //        source: [txt_empinform1]
                                                            //    });


                                                            // });
                                                            var txt_carname = [<?= $car_amt ?>];

                                                            $(function () {
                                                                $("#txt_carname").autocomplete({
                                                                    source: [txt_carname]
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
        </script>

        <script type="text/javascript">

            function chk_uploadbefore1()
            {

                document.getElementById('txt_chkbefore1').value = '1';
            }
            function chk_uploadaffter1()
            {
                document.getElementById('txt_chkaffter1').value = '1';
            }
            function save_repair(employeerepairid, type)
            {

                var employeerepairid = employeerepairid;
                //var txtempinform1 = document.getElementById('txt_empinform1').value;
                var txtempinform1 = '';
                var txtcarname = document.getElementById('txt_carname').value;
                var txtissue = document.getElementById('txt_issue').value;
                var txtremark1 = '';
                //var txttechnician = document.getElementById('txt_technician').value;
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
                        txt_flg: "save_repair", employeerepairid: employeerepairid, drivername: '',
                        vehiclename: txtcarname, tenko_infrom: '', tenko_issue: txtissue, tenko_beforeedit: tenkobeforeedit, tec_affteredit: tecaffteredit, tenko_remark: txtremark1,
                        tec_infrom: txtempinform1, tec_technician: txttechnician, tec_completed: txtcompleted, tec_cause: txtcause,
                        tec_edit: txtedit, tec_protect: txtprotect, tec_remark: txtremark2, repairstatus1: repairstatus1, repairstatus2: repairstatus2, remark: '', activestatus: '1', type: type
                        , txtcarusedate: 'txtcarusedate', ldproduct: 'ldproduct', ldruntype: ''
                    },
                    success: function (response) {
                        alert(response);
                        window.location.reload();
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
            function select_modalrepair(employeerepairid)
            {

                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "select_modalrepair", employeerepairid: employeerepairid
                    },
                    success: function (response) {



                        document.getElementById("datamodal_sr").innerHTML = response;


                        //var txt_technician = [<?//= $emp_rtd ?>];
                        // $(function () {
                        //   $("#txt_technician").autocomplete({
                        //       source: [txt_technician]
                        //   });

                        //});
                        //var txt_empinform1 = [<?//= $emp_rtd ?>];
                        //$(function () {
                        //   $("#txt_empinform1").autocomplete({
                        //       source: [txt_empinform1]
                        //   });


                        //});

                        var txt_carname = [<?= $car_amt ?>];
                        $(function () {
                            $("#txt_carname").autocomplete({
                                source: [txt_carname]
                            });


                        });

                        $(document).ready(function () {
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
            function select_repair()
            {


                var datestart = document.getElementById('txt_datestart').value;
                var dateend = document.getElementById('txt_dateend').value;

                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "select_repair2", datestart: datestart, dateend: dateend
                    },
                    success: function (response) {
                        if (response)
                        {
                            document.getElementById("datasr").innerHTML = response;
                            document.getElementById("datadef").innerHTML = "";
                        }
                        $(document).ready(function () {
                            $('#dataTables-example2').DataTable({
                                responsive: true,
                                "order": [[12, "desc"]]
                            });
                        });
                        //var txt_technician = [<?//= $emp_rtd ?>];

                        //$(function () {
                        //    $("#txt_technician").autocomplete({
                        //       source: [txt_technician]
                        //   });


                        //});
                        //var txt_empinform1 = [<?//= $emp_rtd ?>];
                        //$(function () {
                        //   $("#txt_empinform1").autocomplete({
                        //       source: [txt_empinform1]
                        //   });


                        //});

                        var txt_carname = [<?= $car_amt ?>];
                        $(function () {
                            $("#txt_carname").autocomplete({
                                source: [txt_carname]
                            });


                        });


                    }
                });
                //}

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

        </script>
        <script type="text/javascript">
            function pdf_repair1()
            {

                var datestart = document.getElementById('txt_datestart').value;
                var dateend = document.getElementById('txt_dateend').value;

                window.open('pdf_repair1.php?datestart=' + datestart + '&dateend=' + dateend, '_blank');


            }
            function gdatetodate()
            {
                document.getElementById('txt_gdateend').value = document.getElementById('txt_gdatestart').value;
            }
            function datetodate()
            {
                document.getElementById('txt_dateend').value = document.getElementById('txt_datestart').value;

            }

        </script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example2').DataTable({
                    responsive: true
                });
            });
        </script>

    </body>

</html>
<?php
sqlsrv_close($conn);
?>