<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
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
                <div class="row" >
                    <div class="col-lg-12">

                        <h2 class="page-header">
                            <i class="glyphicon glyphicon-th-list"></i>
                            <?php
                            switch ($_GET['type']) {
                                case "submenu": {
                                        echo "เมนูย่อย";
                                    }
                                    break;

                                default : {
                                        echo "เมนูหลัก";
                                    }
                                    break;
                            }
                            ?>


                        </h2>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div id="datade_edit">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #e7e7e7">
                                    <?php
                                    $meg = ($_GET['meg'] == 'add') ? 'เพิ่มข้อมูล' : 'แก้ไขข้อมูล';
                                    echo $_SESSION["link"] . " / " . $meg;
                                    ?>
                                </div>
                                <div class="panel-body">
                                    <?php

                                    if ($_GET['type'] == 'menu') {
                                        if ($_GET['meg'] == "edit") {
                                            $condition1 = ($_GET['menuid'] != "") ? " AND a.MENUID = " . $_GET['menuid'] : "";
                                            $sql_seMenu = "{call megMenu_v2(?,?)}";
                                            $params_seMenu = array(
                                                array('select_menu', SQLSRV_PARAM_IN),
                                                array($condition1, SQLSRV_PARAM_IN)
                                            );
                                            $query_seMenu = sqlsrv_query($conn, $sql_seMenu, $params_seMenu);
                                            $result_seMenu = sqlsrv_fetch_array($query_seMenu, SQLSRV_FETCH_ASSOC);
                                        }
                                        ?>
                                        <div class="row" >
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ชื่อเมนู</label>
                                                    <input class="form-control" type="text" id="txt_menuname" name="txt_menuname" value="<?= $result_seMenu['MENUNAME'] ?>">

                                                </div>
                                            </div>

                                            <div class = "col-lg-3">
                                                <div class = "form-group">
                                                    <font style="color: red">* </font><label>สถานะ</label>
                                                    <select class="form-control" id="cb_activestatusmenu" name="cb_activestatusmenu">
                                                        <option value="">เลือกสถานะ</option>
                                                        <?php
                                                        switch ($result_seMenu['ACTIVESTATUS']) {
                                                            case '1': {
                                                                    ?>
                                                                    <option value="1" selected="">ใช้งาน</option>
                                                                    <option value="0">ไม่ใช้งาน</option>
                                                                    <?php
                                                                }
                                                                break;
                                                            case '0': {
                                                                    ?>
                                                                    <option value="1" >ใช้งาน</option>
                                                                    <option value="0" selected="">ไม่ใช้งาน</option>
                                                                    <?php
                                                                }
                                                                break;

                                                            default : {
                                                                    ?>
                                                                    <option value="1">ใช้งาน</option>
                                                                    <option value="0" >ไม่ใช้งาน</option>
                                                                    <?php
                                                                }
                                                                break;
                                                        }
                                                        ?>
                                                    </select>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" >
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>หมายเหตุ</label>
                                                    <textarea class="form-control" autocomplete="off" rows="3" id="txt_remarkmenu" name="txt_remarkmenu" ><?= $result_seMenu['REMARK'] ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($_GET['type'] == 'submenu') {
                                        if ($_GET['meg'] == "edit") {
                                            $condition1 = " AND a.SUBMENUID = " . $_GET['submenuid'];
                                            $sql_seSubmenu = "{call megSubmenu_v2(?,?)}";
                                            $params_seSubmenu = array(
                                                array('select_submenu', SQLSRV_PARAM_IN),
                                                array($condition1, SQLSRV_PARAM_IN)
                                            );
                                            $query_seSubmenu = sqlsrv_query($conn, $sql_seSubmenu, $params_seSubmenu);
                                            $result_seSubmenu = sqlsrv_fetch_array($query_seSubmenu, SQLSRV_FETCH_ASSOC);
                                        }
                                        ?>
                                        <div class="row" >
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ชื่อเมนูย่อย</label>
                                                    <input class="form-control" type="text" id="txt_submenuname" name="txt_submenuname" value="<?= $result_seSubmenu['SUBMENUNAME'] ?>">
                                                    <input class="form-control" style="display: none" type="text" id="txt_menuid" name="txt_menuid" value="<?= $_GET['menuid'] ?>">

                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ลิ้งไฟล์</label>
                                                    <input class="form-control" type="text" id="txt_submenupath" name="txt_submenupath" value="<?= $result_seSubmenu['PATH'] ?>">

                                                </div>
                                            </div>


                                            <div class = "col-lg-3">
                                                <div class = "form-group">
                                                    <font style="color: red">* </font><label>สถานะ</label>
                                                    <select class="form-control" id="cb_activestatussubmenu" name="cb_activestatussubmenu">
                                                        <option value="">เลือกสถานะ</option>
                                                        <?php
                                                        switch ($result_seSubmenu['ACTIVESTATUS']) {
                                                            case '1': {
                                                                    ?>
                                                                    <option value="1" selected="">ใช้งาน</option>
                                                                    <option value="0">ไม่ใช้งาน</option>
                                                                    <?php
                                                                }
                                                                break;
                                                            case '0': {
                                                                    ?>
                                                                    <option value="1" >ใช้งาน</option>
                                                                    <option value="0" selected="">ไม่ใช้งาน</option>
                                                                    <?php
                                                                }
                                                                break;

                                                            default : {
                                                                    ?>
                                                                    <option value="1">ใช้งาน</option>
                                                                    <option value="0" >ไม่ใช้งาน</option>
                                                                    <?php
                                                                }
                                                                break;
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" >
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>หมายเหตุ</label>
                                                    <textarea class="form-control" autocomplete="off" rows="3" id="txt_submenuremark" name="txt_submenuremark" ><?= $result_seSubmenu['REMARK'] ?></textarea>
                                                </div>
                                            </div>
                                         
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
                        <div class="col-lg-12">
                            <?php
                            $buttonname = ($_GET['meg'] == 'add') ? "บันทึกข้อมูล" : "แก้ไขข้อมูล";

                            if ($_GET['type'] == "menu") {
                                ?>
                                <input type="button" onclick="save_menu(<?= $_GET['menuid'] ?>);" name="btnSend" id="btnSend" value="<?= $buttonname ?>" class="btn btn-primary">
                                <?php
                            }
                            if ($_GET['type'] == "submenu") {
                                ?>
                                <input type="button" onclick="save_submenu(<?= $_GET['submenuid'] ?>);" name="btnSend" id="btnSend" value="<?= $buttonname ?>" class="btn btn-primary">
                                <?php
                            }
                            ?>


                        </div>
                    </div>
                </div>
                <div id="datasr_edit"></div>

                <div class="row" >
                    <div class="col-lg-12">
                        &nbsp;

                    </div>
                </div>
                <!--<div class="row">
                <?php
//$sql_getDate = "{call megStopwork_v2(?)}";
// $params_getDate = array(
//     array('select_getdate', SQLSRV_PARAM_IN)
//);
// $query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
// $result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);
                ?>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>ค้นหาตามช่วงวันที่</label>
                                <input class="form-control dateen"  id="txt_datestart" readonly="" onchange="datetodate();" style="background-color: #f080802e" name="txt_datestart" value="<?= $result_getDate['SYSDATE'] ?>" placeholder="วันที่เริ่มต้น">

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

                                <button type="button" class="btn btn-default" onclick="select_tenko();">ค้นหา <li class="fa fa-search"></li></button>&emsp;<button type="button" onclick="excel_tenko()" class="btn btn-default">Excel <li class="fa fa-file-excel-o"></li></button>
                            </div>

                        </div>

                    </div>   -->
                <?php
                if ($_GET['type'] == 'menu') {
                    ?>
                    <div class="row" >
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #e7e7e7">
                                    <font style="font-size: 16px"><b>ข้อมูล : เมนูหลัก</b></font>                            
                                </div>
                                <div class="panel-body">
                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div id="datade">
                                                    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th>ชื่อเมนู</th>
                                                                <th>หมายเหตุ</th>
                                                                <th>สถานะการใช้งาน</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $condition1 = ($_GET['meg'] != "edit") ? "" : " AND a.MENUID = " . $_GET['menuid'];
                                                            $sql_seMenu1 = "{call megMenu_v2(?,?)}";
                                                            $params_seMenu1 = array(
                                                                array('select_menu', SQLSRV_PARAM_IN),
                                                                array($condition1, SQLSRV_PARAM_IN)
                                                            );

                                                            $query_seMenu1 = sqlsrv_query($conn, $sql_seMenu1, $params_seMenu1);
                                                            while ($result_seMenu1 = sqlsrv_fetch_array($query_seMenu1, SQLSRV_FETCH_ASSOC)) {
                                                                ?>
                                                                <tr class="odd gradeX">
                                                                    <td><?= $result_seMenu1['MENUNAME'] ?></td>
                                                                    <td><?= $result_seMenu1['REMARK'] ?></td>
                                                                    <td><?= ($result_seMenu1['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>

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
                <?php
                if ($_GET['type'] == 'submenu') {
                    ?>
                    <div class="row" >
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #e7e7e7">
                                    <font style="font-size: 16px"><b>ข้อมูล : เมนูย่อย</b></font>                            
                                </div>
                                <div class="panel-body">
                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div id="datade">
                                                    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th>ชื่อเมนู</th>
                                                                <th>ลิ้งไฟล์</th>
                                                                <th>หมายเหตุ</th>
                                                                <th>สถานะการใช้งาน</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $condition1 = ($_GET['submenuid'] != "") ? " AND a.SUBMENUID = " . $_GET['submenuid'] : " AND a.MENUID = " . $_GET['menuid'];
                                                            $sql_seSubmenu = "{call megSubmenu_v2(?,?)}";
                                                            $params_seSubmenu = array(
                                                                array('select_submenu', SQLSRV_PARAM_IN),
                                                                array($condition1, SQLSRV_PARAM_IN)
                                                            );

                                                            $query_seSubmenu = sqlsrv_query($conn, $sql_seSubmenu, $params_seSubmenu);
                                                            while ($result_seSubmenu = sqlsrv_fetch_array($query_seSubmenu, SQLSRV_FETCH_ASSOC)) {
                                                                ?>
                                                                <tr class="odd gradeX">

                                                                    <td><?= $result_seSubmenu['SUBMENUNAME'] ?></td>
                                                                    <td><?= $result_seSubmenu['PATH'] ?></td>
                                                                    <td><?= $result_seSubmenu['REMARK'] ?></td>
                                                                    <td><?= ($result_seSubmenu['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>

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
        <script src="../dist/js/jquery.autocomplete.js"></script>

    </body>
    <script>
                                    $(document).ready(function () {
                                        $('#dataTables-example').DataTable({
                                            responsive: true
                                        });
                                    });
    </script>
    <script>
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
    <script>
        function chknull_menu()
        {
            if (document.getElementById('txt_menuname').value == '')
            {
                alert('ชื่อเมนู เป็นค่าว่าง !!!')
                document.getElementById('txt_menuname').focus();
                return false;
            } else if (document.getElementById('cb_activestatusmenu').value == '')
            {
                alert('สถานะ เป็นค่าว่าง !!!')
                document.getElementById('cb_activestatusmenu').focus();
                return false;
            } else
            {
                return true;
            }
        }
        function chknull_submenu()
        {
            if (document.getElementById('txt_submenuname').value == '')
            {
                alert('ชื่อเมนูย่อย เป็นค่าว่าง !!!')
                document.getElementById('txt_submenuname').focus();
                return false;
            } else if (document.getElementById('txt_submenupath').value == '')
            {
                alert('ลิ้งไฟล์ เป็นค่าว่าง !!!')
                document.getElementById('txt_submenupath').focus();
                return false;
            } else if (document.getElementById('cb_activestatussubmenu').value == '')
            {
                alert('สถานะ เป็นค่าว่าง !!!')
                document.getElementById('cb_activestatussubmenu').focus();
                return false;
            } else
            {
                return true;
            }
        }
        function datetodate()
        {
            document.getElementById('txt_dateend').value = document.getElementById('txt_datestart').value;
        }
        function save_menu(menuid)
        {
            var menuname = document.getElementById('txt_menuname').value;
            var activestatusmenu = document.getElementById('cb_activestatusmenu').value;
            var remarkmenu = document.getElementById('txt_remarkmenu').value;


            if (chknull_menu())
            {
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "save_menu", menuid: menuid, menuname: menuname, activestatusmenu: activestatusmenu, remarkmenu: remarkmenu
                    },
                    success: function (response) {
                        alert(response);
                        window.location.reload();
                    }
                });
            }
        }
        function trun_premissions(data)
        {
            if (document.getElementById(data).checked == true)
            {
                document.getElementById('txt_premissions').value += data + "|";
            }
            if (document.getElementById(data).checked == false)
            {
                document.getElementById('txt_premissions').value = document.getElementById('txt_premissions').value.replace(data + "|", "");
            }
        }
        function save_submenu(submenuid)
        {

            var menuid = document.getElementById('txt_menuid').value;
            var submenuname = document.getElementById('txt_submenuname').value;
            //var premissions = document.getElementById('txt_premissions').value;
            var submenupath = document.getElementById('txt_submenupath').value;
            var activestatussubmenu = document.getElementById('cb_activestatussubmenu').value;
            var submenuremark = document.getElementById('txt_submenuremark').value;

            if (chknull_submenu())
            {
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "save_submenu", submenuid: submenuid, menuid: menuid, submenuname: submenuname, submenupath: submenupath, activestatussubmenu: activestatussubmenu, submenuremark: submenuremark
                    },
                    success: function (response) {
                        alert(response);
                        window.location.reload();
                    }
                });
            }
        }


    </script>
</html>


<?php
sqlsrv_close($conn);
?>