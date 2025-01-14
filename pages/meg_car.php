<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
?>

<html lang="en">
    <head
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

            <div id="page-wrapper">
                <p>&nbsp;</p>
                <?php
                if ($_GET['type'] == 'infoamata') {
                    $condition1 = ($_GET['vehicleinfoid'] != "") ? " AND a.VEHICLEINFOID = '" . $_GET['vehicleinfoid'] . "'" : " AND a.VEHICLETYPECODE = 'VT-1403-0078'";
                    $sql_seCar = "{call megVehicleinfo_v2(?,?)}";
                    $params_seCar = array(
                        array('select_vehicleinfo', SQLSRV_PARAM_IN),
                        array($condition1, SQLSRV_PARAM_IN)
                    );
                    $query_seCar1 = sqlsrv_query($conn, $sql_seCar, $params_seCar);
                    $result_seCar1 = sqlsrv_fetch_array($query_seCar1, SQLSRV_FETCH_ASSOC);
                    ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #e7e7e7">
                                    <a href="meg_car.php?type=infoamata">จัดการรถ</a> / <?php
                                    if ($_GET['vehicleinfoid'] == "") {
                                        echo "";
                                    } else {
                                        ?>ทะเบียน : <?= $result_seCar1['VEHICLEREGISNUMBER'] ?>
                                    <?php } ?>
                                </div>
                                <?php
                                if ($_GET['vehicleinfoid'] == "") {
                                    ?>
                                    <div class="panel-heading">
                                        <form  name="searchform" id="searchform" method="post">
                                            <div class="row" >
                                                <div class="col-md-3">
                                                    <select class="form-control"  id="cb_srtype" name="cb_srtype" onchange="select_car('<?php echo $_GET['type'] ?>');">

                                                        <?php
                                                        $sql_seComp = "{call megVehicletype_v2(?)}";
                                                        $params_seComp = array(
                                                            array('select_vehicletype', SQLSRV_PARAM_IN)
                                                        );
                                                        $query_seComp = sqlsrv_query($conn, $sql_seComp, $params_seComp);
                                                        while ($result_seComp = sqlsrv_fetch_array($query_seComp, SQLSRV_FETCH_ASSOC)) {
                                                            ?>
                                                            <option value = "<?= $result_seComp['VEHICLETYPECODE'] ?>"><?= $result_seComp['VEHICLETYPEDESC'] ?></option> 
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group input-group">

                                                        <input type="text"  name="txt_search"  id="txt_search" class="form-control" onkeyup="select_car('<?php echo $_GET['type'] ?>');" onkeypress="select_car('<?php echo $_GET['type'] ?>');">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default" id="btnSearch" type="button"><i class="fa fa-search"></i>
                                                            </button>
                                                        </span>
                                                    </div>

                                                </div>
                                               
                                               
                                             
                                                <div class="col-md-6">
                                                    <div class="form-group input-group " >
                                                        <a href="meg_carinfo.php?type=infoamata&meg=add" class="btn btn-outline btn-default"><span class="glyphicon glyphicon-plus"></span> เพิ่มรถ/แก้ไข</a>
                                                    </div>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                    <?php
                                }
                                ?>

                                <div class="panel-body">
                                    <div class="row" id="loading"></div>
                                    <div class="row" id="list-data">
                                        <?php
                                        $query_seCar = sqlsrv_query($conn, $sql_seCar, $params_seCar);
                                        while ($result_seCar = sqlsrv_fetch_array($query_seCar, SQLSRV_FETCH_ASSOC)) {
                                            ?>
                                            <div class="col-lg-3 col-md-3">
                                                <div class="panel" style="background-color: #FFF;color: #000;border-color:#ccc ">
                                                    <div class="panel-heading">
                                                        <div class="row">
                                                            <div class="col-xs-12" style="text-align: center">
                                                                <img src="../<?= $result_seCar['VEHICLETYPEIMAGE'] ?>" style="width: 150px;height: 75px;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel-footer">
                                                        <font style="font-size: 16px;color:#000 ">ทะเบียน : <?= $result_seCar['VEHICLEREGISNUMBER'] ?></font>

                                                        <span class="pull-right"> 
                                                            <?php
                                                            $condition1 = " AND b.MENUID = 6 AND e.EMPLOYEEID =" . $_SESSION["EMPLOYEEID"] . " AND c.SUBMENUNAME = 'ข้อมูลรถ (อมตะ)'";
                                                            $sql_seSubmenu = "{call megRolemenu_v2(?,?)}";
                                                            $params_seSubmenu = array(
                                                                array('show_submenu', SQLSRV_PARAM_IN),
                                                                array($condition1, SQLSRV_PARAM_IN)
                                                            );

                                                            $query_seSubmenu1 = sqlsrv_query($conn, $sql_seSubmenu, $params_seSubmenu);
                                                            $result_seSubmenu1 = sqlsrv_fetch_array($query_seSubmenu1, SQLSRV_FETCH_ASSOC);

                                                            if ($result_seSubmenu1['SUBMENUID'] != "") {
                                                                ?>
                                                                <a href="#" role="button" class="btn btn-default btn-circle" data-toggle="popover" title="" data-content="
                                                                <?php
                                                                $query_seSubmenu = sqlsrv_query($conn, $sql_seSubmenu, $params_seSubmenu);
                                                                while ($result_seSubmenu = sqlsrv_fetch_array($query_seSubmenu, SQLSRV_FETCH_ASSOC)) {
                                                                    ?>
                                                                       <a href='<?= $result_seSubmenu['PATH'] ?>&vehicleinfoid=<?= $result_srCar['VEHICLEINFOID'] ?>&meg=edit' class='list-group-item'><?= $result_seSubmenu['SUBMENUNAME'] ?></a><br>
                                                                       <?php
                                                                   }
                                                                   ?>
                                                                   "><i class="fa fa-list"></i></a>
                                                                   <?php
                                                               }
                                                               ?>

                                                        </span>

                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                        }
                                        ?>
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

                if ($_GET['type'] == 'infogetway') {
                    $condition1 = ($_GET['vehicleinfoid'] != "") ? " AND a.VEHICLEINFOID = '" . $_GET['vehicleinfoid'] . "'" : " AND a.VEHICLETYPECODE = 'VT-1403-0078'";
                    $sql_seCar = "{call megVehicleinfo_v2(?,?)}";
                    $params_seCar = array(
                        array('select_vehicleinfo', SQLSRV_PARAM_IN),
                        array($condition1, SQLSRV_PARAM_IN)
                    );
                    $query_seCar1 = sqlsrv_query($conn, $sql_seCar, $params_seCar);
                    $result_seCar1 = sqlsrv_fetch_array($query_seCar1, SQLSRV_FETCH_ASSOC);
                    ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #e7e7e7">
                                    <a href="meg_car.php?type=<?php echo $_GET['type'] ?>">จัดการรถ</a> / <?php
                                    if ($_GET['vehicleinfoid'] == "") {
                                        echo "";
                                    } else {
                                        ?>ทะเบียน : <?= $result_seCar1['VEHICLEREGISNUMBER'] ?>
                                    <?php } ?>
                                </div>
                                <?php
                                if ($_GET['vehicleinfoid'] == "") {
                                    ?>
                                    <div class="panel-heading">
                                        <form  name="searchform" id="searchform" method="post">
                                            <div class="row" >
                                                <div class="col-md-3">
                                                    <select class="form-control"  id="cb_srtype" name="cb_srtype" onchange="select_car('<?php echo $_GET['type'] ?>');">
                                                        <option value = "">เลือกประเภทรถ</option> 
                                                        <?php
                                                        $sql_seComp = "{call megVehicletype_v2(?)}";
                                                        $params_seComp = array(
                                                            array('select_vehicletypegetway', SQLSRV_PARAM_IN)
                                                        );
                                                        $query_seComp = sqlsrv_query($conn, $sql_seComp, $params_seComp);
                                                        while ($result_seComp = sqlsrv_fetch_array($query_seComp, SQLSRV_FETCH_ASSOC)) {
                                                            ?>
                                                            <option value = "<?= $result_seComp['VEHICLETYPECODE'] ?>"><?= $result_seComp['VEHICLETYPEDESC'] ?></option> 
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group input-group">

                                                        <input type="text"  name="txt_search"  id="txt_search" class="form-control" onkeyup="select_car('<?php echo $_GET['type'] ?>');" onkeypress="select_car('<?php echo $_GET['type'] ?>');">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default" id="btnSearch" type="button"><i class="fa fa-search"></i>
                                                            </button>
                                                        </span>
                                                    </div>

                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group input-group " >
                                                        <a href="meg_carinfo.php?type=infoamata&meg=add" class="btn btn-outline btn-default"><span class="glyphicon glyphicon-plus"></span> เพิ่มรถ/แก้ไข</a>
                                                    </div>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                    <?php
                                }
                                ?>

                                <div class="panel-body">
                                    <div class="row" id="loading"></div>
                                    <div class="row" id="list-data">
                                        <?php
                                        $query_seCar = sqlsrv_query($conn, $sql_seCar, $params_seCar);
                                        while ($result_seCar = sqlsrv_fetch_array($query_seCar, SQLSRV_FETCH_ASSOC)) {
                                            ?>
                                            <div class="col-lg-3 col-md-3">
                                                <div class="panel" style="background-color: #FFF;color: #000;border-color:#ccc ">
                                                    <div class="panel-heading">
                                                        <div class="row">
                                                            <div class="col-xs-12" style="text-align: center">
                                                                <img src="../<?= $result_seCar['VEHICLETYPEIMAGE'] ?>" style="width: 150px;height: 75px;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel-footer">
                                                        <font style="font-size: 16px;color:#000 ">ทะเบียน : <?= $result_seCar['VEHICLEREGISNUMBER'] ?></font>

                                                        <span class="pull-right"> 
                                                            <?php
                                                            $condition1 = " AND b.MENUID = 6 AND e.EMPLOYEEID =" . $_SESSION["EMPLOYEEID"] . " AND c.SUBMENUNAME = 'ข้อมูลรถ (เกตุเวย์)'";
                                                            $sql_seSubmenu = "{call megRolemenu_v2(?,?)}";
                                                            $params_seSubmenu = array(
                                                                array('show_submenu', SQLSRV_PARAM_IN),
                                                                array($condition1, SQLSRV_PARAM_IN)
                                                            );

                                                            $query_seSubmenu1 = sqlsrv_query($conn, $sql_seSubmenu, $params_seSubmenu);
                                                            $result_seSubmenu1 = sqlsrv_fetch_array($query_seSubmenu1, SQLSRV_FETCH_ASSOC);

                                                            if ($result_seSubmenu1['SUBMENUID'] != "") {
                                                                ?>
                                                                <div class="btn-group">
                                                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                                                        <i class="fa fa-chevron-down"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu slidedown">

                                                                        <li>

                                                                            <?php
                                                                            $query_seSubmenu = sqlsrv_query($conn, $sql_seSubmenu, $params_seSubmenu);
                                                                            while ($result_seSubmenu = sqlsrv_fetch_array($query_seSubmenu, SQLSRV_FETCH_ASSOC)) {
                                                                                ?>
                                                                                <a href='<?= $result_seSubmenu['PATH'] ?>&vehicleinfoid=<?= $result_srCar['VEHICLEINFOID'] ?>&meg=edit'><?= $result_seSubmenu['SUBMENUNAME'] ?></a>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </li>


                                                                    </ul>
                                                                </div>



                                                                <?php
                                                            }
                                                            ?>

                                                        </span>

                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                        }
                                        ?>
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
    <script type="text/javascript">
                                                    function select_car(type)
                                                    {

                                                        var srtype = document.getElementById("cb_srtype").value;
                                                        var search = document.getElementById("txt_search").value;


                                                        $.ajax({
                                                            type: 'post',
                                                            url: 'meg_searchcar.php',
                                                            data: {
                                                                srtype: srtype, search: search, type: type
                                                            },
                                                            success: function (response) {

                                                                if (response)
                                                                {
                                                                    document.getElementById("list-data").innerHTML = "";
                                                                    document.getElementById("loading").innerHTML = response;

                                                                }

                                                                $(function () {
                                                                    $('[data-toggle="popover"]').popover({
                                                                        html: true,
                                                                        content: function () {
                                                                            return $('#popover-content').html();
                                                                        }
                                                                    });
                                                                })

                                                            }
                                                        });

                                                    }

                                                    $(function () {
                                                        $('[data-toggle="popover"]').popover({
                                                            html: true,
                                                            content: function () {
                                                                return $('#popover-content').html();
                                                            }
                                                        });
                                                    })
    </script>
</html>
<?php
sqlsrv_close($conn);
?>