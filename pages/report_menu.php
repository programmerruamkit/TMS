
<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

if ($_GET['menuid'] != "") {
    $condition1 = " AND a.MENUID = " . $_GET['menuid'];
    $sql_getMenu = "{call megMenu_v2(?,?)}";
    $params_getMenu = array(
        array('select_menu', SQLSRV_PARAM_IN),
        array($condition1, SQLSRV_PARAM_IN)
    );
    $query_getMenu = sqlsrv_query($conn, $sql_getMenu, $params_getMenu);
    $result_getMenu = sqlsrv_fetch_array($query_getMenu, SQLSRV_FETCH_ASSOC);
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
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
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

                        <h2 class="page-header"><i class="glyphicon glyphicon-th-list"></i>  
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
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color: #e7e7e7">

                                <?php
                                if ($_GET['type'] == "submenu") {
                                    echo "<a href='report_menu.php?type=menu'>เมนูหลัก</a> / " . $result_getMenu['MENUNAME'];
                                    $link = "<a href='report_menu.php?type=menu'>เมนูหลัก</a> / <a href='report_menu.php?type=submenu&menuid=" . $result_getMenu['MENUID'] . "'>" . $result_getMenu['MENUNAME'] . "</a>";
                                    $_SESSION["link"] = $link;
                                } else {
                                    echo "เมนูหลัก";
                                    $link = "<a href='report_menu.php?type=menu'>เมนูหลัก</a>";
                                    $_SESSION["link"] = $link;
                                }
                                ?>
                            </div>
                            <!-- /.panel-heading -->

                            <div class="panel-body">
                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                    <?php
                                    if ($_GET['type'] == "menu") {
                                        ?>
                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>ชื่อเมนู</th>
                                                    <th>หมายเหตุ</th>
                                                    <th>สถานะ</th>
                                                    <th style="text-align: center">ข้อมูลย่อย</th>
                                                    <th style="text-align: center"><a href="meg_menu.php?type=<?= $_GET['type'] ?>&meg=add"><li class="fa fa-plus-square"></li> เพิ่มเมนูหลัก</a></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql_seMenu = "{call megMenu_v2(?,?)}";
                                                $params_seMenu = array(
                                                    array('select_menu', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seMenu = sqlsrv_query($conn, $sql_seMenu, $params_seMenu);
                                                while ($result_seMenu = sqlsrv_fetch_array($query_seMenu, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <tr class="odd gradeX">
                                                        <td><?= $result_seMenu['MENUNAME'] ?></td>
                                                        <td><?= $result_seMenu['REMARK'] ?></td>
                                                        <td><?php echo ($result_seMenu['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>
                                                        <td style="text-align: center">
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                                                    <i class="fa fa-chevron-down"></i>
                                                                </button>
                                                                <ul class="dropdown-menu slidedown">

                                                                    <li>
                                                                        <a href="report_menu.php?type=submenu&menuid=<?= $result_seMenu['MENUID'] ?>">เพิ่มเมนูย่อย</a>
                                                                    </li>


                                                                </ul>
                                                            </div>


                                                        </td>
                                                        <td style="text-align: center">
                                                            <a href="meg_menu.php?type=<?= $_GET['type'] ?>&meg=edit&menuid=<?= $result_seMenu['MENUID'] ?>" title="แก้ไขข้อมูล" type="button" class="btn btn-default  btn-circle"><span class="glyphicon glyphicon-wrench"></span></a>
                                                            <button onclick="delete_menu(<?= $result_seMenu['MENUID'] ?>);" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                                        </td>


                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <?php
                                    }
                                    ?>

                                    <?php
                                    if ($_GET['type'] == "submenu") {
                                        ?>
                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                            <?php
                                            $condition1 = " AND MENUID =" . $_GET['menuid'];
                                            $sql_seSubmenu = "{call megSubmenu_v2(?,?)}";
                                            $params_seSubmenu = array(
                                                array('select_submenu', SQLSRV_PARAM_IN),
                                                array($condition1, SQLSRV_PARAM_IN)
                                            );
                                            $query_seSubmenu1 = sqlsrv_query($conn, $sql_seSubmenu, $params_seSubmenu);
                                            $result_seSubmenu1 = sqlsrv_fetch_array($query_seSubmenu1, SQLSRV_FETCH_ASSOC);
                                            ?>
                                            <thead>
                                                <tr>
                                                    <th>ชื่อเมนู</th>
                                                    <th>ลิ้งไฟล์</th>
                                                    <th>หมายเหตุ</th>
                                                    <th>สถานะ</th>
                                                    <th style="text-align: center"><a href="meg_menu.php?type=<?= $_GET['type'] ?>&meg=add&menuid=<?= $_GET['menuid'] ?>"><li class="fa fa-plus-square"></li> เพิ่มเมนูย่อย</a></th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query_seSubmenu = sqlsrv_query($conn, $sql_seSubmenu, $params_seSubmenu);
                                                while ($result_seSubmenu = sqlsrv_fetch_array($query_seSubmenu, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <tr class="odd gradeX">
                                                        <td><?= $result_seSubmenu['SUBMENUNAME'] ?></td>
                                                        <td><?= $result_seSubmenu['PATH'] ?></td>
                                                        <td><?= $result_seSubmenu['REMARK'] ?></td>
                                                        <td><?php echo ($result_seSubmenu['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>
                                                        <td style="text-align: center">
                                                            <a href="meg_menu.php?type=<?= $_GET['type'] ?>&meg=edit&menuid=<?= $result_seSubmenu['MENUID'] ?>&submenuid=<?= $result_seSubmenu['SUBMENUID'] ?>" title="แก้ไขข้อมูล" type="button" class="btn btn-default  btn-circle"><span class="glyphicon glyphicon-wrench"></span></a>
                                                            <button onclick="delete_submenu(<?= $result_seSubmenu['SUBMENUID'] ?>);" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>

                                                        </td>


                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
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

            <script>
                                                            $(document).ready(function () {
                                                                $('#dataTables-example').DataTable({
                                                                    responsive: true,
                                                                    order: [[0, "desc"]]
                                                                });
                                                            });
            </script>


    </body>
    <script>
        function delete_menu(val)
        {
            var confirmation = confirm("ต้องการลบข้อมูล ?");

            if (confirmation) {
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "delete_menu", menuid: val
                    },
                    success: function () {
                        alert('ลบข้อมูลเรียบร้อยแล้ว');
                        window.location.reload();
                    }
                });
            }
        }
    </script>
    <script>
        function delete_submenu(val)
        {
            var confirmation = confirm("ต้องการลบข้อมูล ?");

            if (confirmation) {
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "delete_submenu", submenuid: val
                    },
                    success: function () {
                        alert('ลบข้อมูลเรียบร้อยแล้ว');
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