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

        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">
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
                            <i class="glyphicon glyphicon-user"></i>  
                            <?php
                            switch ($_GET['type']) {
                                case "roleaccount": {
                                        echo "ข้อมูลผู้ใช้งาน";
                                    }
                                    break;
                                case "role": {
                                        echo "ข้อมูลสิทธิ์";
                                    }
                                    break;
                                case "rolemenu": {
                                        echo "ข้อมูลเมนู";
                                    }
                                    break;

                                case "password": {
                                        echo "แก้ไขรหัสผ่าน";
                                    }
                                    break;
                                default : {
                                        echo "ข้อมูลพนักงาน";
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
                                    if ($_GET['type'] == 'password') {

                                        if ($_GET['meg'] == 'edit') {
                                            $condition1 = " AND a.EMPLOYEEID ='" . $_SESSION["EMPLOYEEID"] . "' AND c.ROLENAME = '" . $_SESSION["ROLENAME"] . "'";
                                            $sql_sePassword = "{call megRoleaccount_v2(?,?)}";
                                            $params_sePassword = array(
                                                array('select_roleaccount', SQLSRV_PARAM_IN),
                                                array($condition1, SQLSRV_PARAM_IN)
                                            );
                                            $query_sePassword = sqlsrv_query($conn, $sql_sePassword, $params_sePassword);
                                            $result_sePassword = sqlsrv_fetch_array($query_sePassword, SQLSRV_FETCH_ASSOC);
                                        }
                                        ?>


                                        <div class="row" >
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>Username</label>
                                                    <input  class="form-control" style="background-color: #f080802e" readonly="" type="text" id="txt_username" name="txt_username" value="<?= $result_sePassword['USERNAME'] ?>">

                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>Password(เดิม)</label>
                                                    <input style="background-color: #f080802e" class="form-control" readonly=""  id="txt_passwordold" name="txt_passwordold"  value="<?= $result_sePassword['PASSWORD'] ?>" >
                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>Password(ใหม่)</label>
                                                    <input class="form-control"  id="txt_passwordnew" name="txt_passwordnew"  value="" >
                                                </div>

                                            </div>


                                        </div>



                                        <?php
                                    }
                                    if ($_GET['type'] == 'roleaccount') {
                                        if ($_GET['meg'] == 'edit') {
                                            $condition1 = " AND a.ACTIVESTATUS = 1 AND a.ROLEACCOUNTID =" . $_GET['roleaccountid'] . "";
                                            $sql_seAccount = "{call megRoleaccount_v2(?,?)}";
                                            $params_seAccount = array(
                                                array('select_roleaccount', SQLSRV_PARAM_IN),
                                                array($condition1, SQLSRV_PARAM_IN)
                                            );
                                            $query_seAccount = sqlsrv_query($conn, $sql_seAccount, $params_seAccount);
                                            $result_seAccount = sqlsrv_fetch_array($query_seAccount, SQLSRV_FETCH_ASSOC);
                                        }
                                        ?>
                                        <div class="row" >
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Username</label>
                                                    <input class="form-control" style="background-color: #f080802e" readonly="" type="text" id="txt_username" name="txt_username" value="<?= $result_seAccount['USERNAME'] ?>">
                                                    <input class="form-control" type="text" style="display: none"  id="txt_employeeid" name="txt_employeeid" value="<?= $_GET['employeeid'] ?>">

                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Password</label>
                                                    <input class="form-control" style="background-color: #f080802e" readonly=""  id="txt_password" name="txt_password"  value="<?= $result_seAccount['PASSWORD'] ?>" >

                                                </div>

                                            </div>
                                            <div class = "col-lg-3">
                                                <div class = "form-group">
                                                    <font style="color: red">* </font><label>สิทธิ์</label>
                                                    <select class="form-control" id="cb_premissions" name="cb_premissions">
                                                        <option value = "" >เลือกสิทธิ์</option>
                                                        <?php
                                                        $sql_seRole = "{call megRole_v2(?,?)}";
                                                        $params_seRole = array(
                                                            array('select_role', SQLSRV_PARAM_IN),
                                                            array('', SQLSRV_PARAM_IN)
                                                        );
                                                        $query_seRole = sqlsrv_query($conn, $sql_seRole, $params_seRole);
                                                        while ($result_seRole = sqlsrv_fetch_array($query_seRole, SQLSRV_FETCH_ASSOC)) {
                                                            $selected = "";
                                                            if ($result_seAccount['ROLEID'] == $result_seRole['ROLEID']) {
                                                                $selected = "SELECTED";
                                                            }
                                                            ?>
                                                            <option value = "<?= $result_seRole['ROLEID'] ?>" <?= $selected ?>><?= $result_seRole['ROLENAME'] ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class = "col-lg-3">
                                                <div class = "form-group">
                                                    <font style="color: red">* </font><label>สถานะ</label>
                                                    <select class="form-control" id="cb_activestatusaccount" name="cb_activestatusaccount">
                                                        <option value = "" >เลือกสถานะ</option>
                                                        <?php
                                                        if ($result_seAccount['ACTIVESTATUS'] == "1") {
                                                            $selected = "SELECTED";
                                                        }
                                                        switch ($result_seAccount['ACTIVESTATUS']) {
                                                            case '1': {
                                                                    ?>
                                                                    <option value = "0" >ไม่ใช้งาน</option>
                                                                    <option value = "1" <?= $selected ?>>ใช้งาน</option>
                                                                    <?php
                                                                }
                                                                break;
                                                            case '1': {
                                                                    ?>
                                                                    <option value = "0" <?= $selected ?>>ไม่ใช้งาน</option>
                                                                    <option value="1" >ใช้งาน</option>
                                                                    <?php
                                                                }
                                                                break;
                                                            default : {
                                                                    ?>
                                                                    <option value = "0" >ไม่ใช้งาน</option>
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
                                        <div class="row" >
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>หมายเหตุ</label>
                                                    <textarea class="form-control" autocomplete="off" rows="3" id="txt_remarkaccount" name="txt_remarkaccount" ><?= $result_seAccount['REMARK'] ?></textarea>

                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($_GET['type'] == 'role') {
                                        if ($_GET['meg'] == "edit") {
                                            $condition1 = " AND a.ROLEID =" . $_GET['roleid'] . "";
                                            $sql_seRole = "{call megRole_v2(?,?)}";
                                            $params_seRole = array(
                                                array('select_role', SQLSRV_PARAM_IN),
                                                array($condition1, SQLSRV_PARAM_IN)
                                            );
                                            $query_seRole = sqlsrv_query($conn, $sql_seRole, $params_seRole);
                                            $result_seRole = sqlsrv_fetch_array($query_seRole, SQLSRV_FETCH_ASSOC);
                                        }
                                        ?>
                                        <div class="row" >
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ชื่อสิทธิ์</label>
                                                    <input class="form-control" type="text"   id="txt_premissionsnamerole" name="txt_premissionsnamerole" value="<?= $result_seRole['ROLENAME'] ?>">

                                                </div>
                                            </div>

                                            <div class = "col-lg-3">
                                                <div class = "form-group">
                                                    <font style="color: red">* </font><label>สถานะ</label>
                                                    <select class="form-control" id="cb_activestatusrole" name="cb_activestatusrole">
                                                        <option value ="">เลือกสถานะ</option>
                                                        <?php
                                                        $selected = "SELECTED";

                                                        switch ($result_seRole['ACTIVESTATUS']) {
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
                                                                    <option value = "0" >ไม่ใช้งาน</option>
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
                                        <div class="row" >
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>หมายเหตุ</label>
                                                    <textarea class="form-control" autocomplete="off" rows="3" id="txt_remarkrole" name="txt_remarkrole" ><?= $result_seRole['REMARK'] ?></textarea>
                                                    <input class="form-control" type="text" style="display: none"  id="txt_roleid" name="txt_roleid" value="<?= $_GET['roleid'] ?>">

                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }

                                    if ($_GET['type'] == 'rolemenu') {

                                        if ($_GET['meg'] == "edit") {
                                            $condition1 = " AND a.ROLEID = " . $_GET['roleid'] . " AND a.ROLEMENUID = " . $_GET['rolemenuid'];
                                            $sql_seMenu = "{call megRolemenu_v2(?,?)}";
                                            $params_seMenu = array(
                                                array('select_rolemenu', SQLSRV_PARAM_IN),
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
                                                    <select onchange="select_submenu(this.value);" class="form-control" id="cb_mainmenu" name="cb_mainmenu">
                                                        <option   value ="">เลือกเมนูหลัก</option>
                                                        <?php
                                                        $sql_seMainmenu = "{call megMenu_v2(?,?)}";
                                                        $params_seMainmenu = array(
                                                            array('select_menu', SQLSRV_PARAM_IN),
                                                            array('', SQLSRV_PARAM_IN)
                                                        );
                                                        $query_seMainmenu = sqlsrv_query($conn, $sql_seMainmenu, $params_seMainmenu);
                                                        while ($result_seMainmenu = sqlsrv_fetch_array($query_seMainmenu, SQLSRV_FETCH_ASSOC)) {
                                                            $selected = "";
                                                            if ($result_seMainmenu["MENUID"] == $result_seMenu['MENUID']) {
                                                                $selected = "SELECTED";
                                                            }
                                                            ?>
                                                            <option value ="<?= $result_seMainmenu['MENUID'] ?>"<?= $selected ?>><?= $result_seMainmenu['MENUNAME'] ?></option>
                                                            <?php
                                                        }
                                                        ?>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>ชื่อเมนูย่อย</label>
                                                    <select class="form-control" id="cb_submenu" name="cb_submenu">
                                                        <?php
                                                        if ($result_seMenu['SUBMENUID'] != "") {

                                                            $sql_seSubmenu = "{call megSubmenu_v2(?,?)}";
                                                            $params_seSubmenu = array(
                                                                array('select_submenu', SQLSRV_PARAM_IN),
                                                                array('', SQLSRV_PARAM_IN)
                                                            );
                                                            $query_seSubmenu = sqlsrv_query($conn, $sql_seSubmenu, $params_seSubmenu);

                                                            while ($result_seSubmenu = sqlsrv_fetch_array($query_seSubmenu, SQLSRV_FETCH_ASSOC)) {
                                                                $selected = "";
                                                                if ($result_seSubmenu["SUBMENUID"] == $result_seMenu['SUBMENUID']) {
                                                                    $selected = "SELECTED";
                                                                }
                                                                ?>
                                                                <option value ="<?= $result_seSubmenu['SUBMENUID'] ?>" <?= $selected ?>><?= $result_seSubmenu['SUBMENUNAME'] ?></option>
                                                                <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <option value ="">เลือกเมนูย่อย</option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class = "col-lg-3">
                                                <div class = "form-group">
                                                    <font style="color: red">* </font><label>สถานะ</label>
                                                    <select class="form-control" id="cb_activestatusmenu" name="cb_activestatusmenu">
                                                        <option value = "" >เลือกสถานะ</option>
                                                        <?php
                                                        $selected = "SELECTED";

                                                        switch ($result_seMenu['ACTIVESTATUS']) {
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
                                        <div class="row" >
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>หมายเหตุ</label>
                                                    <textarea class="form-control" autocomplete="off" rows="3" id="txt_remarkmenu" name="txt_remarkmenu" ><?= $result_seMenu['REMARK'] ?></textarea>
                                                    <input class="form-control" type="text" style="display: none"  id="txt_roleid" name="txt_roleid" value="<?= $_GET['roleid'] ?>">
                                                    <input class="form-control" type="text" style="display: none"  id="txt_employeeid" name="txt_employeeid" value="<?= $_GET['employeeid'] ?>">
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
                    <input type="text" hidden id="txt_rolename" name="txt_rolename" value="<?= $_SESSION["ROLENAME"]?>"></input>
                    <div class="row">
                        <div class="col-lg-12">
                            <?php
                            $buttonname = ($_GET['meg'] == 'add') ? "บันทึกข้อมูล" : "แก้ไขข้อมูล";

                            if ($_GET['type'] == "roleaccount") {
                                ?>
                                <input type="button" onclick="save_roleaccount(<?= $_GET['rolemenuid'] ?>);" name="btnSend" id="btnSend" value="<?= $buttonname ?>" class="btn btn-primary">
                                <?php
                            }
                            if ($_GET['type'] == "role") {
                                ?>
                                <input type="button" onclick="save_role(<?= $_GET['roleid'] ?>);" name="btnSend" id="btnSend" value="<?= $buttonname ?>" class="btn btn-primary">
                                <?php
                            }
                            if ($_GET['type'] == "rolemenu") {
                                ?>
                                <input type="button" onclick="save_rolemenu(<?= $_GET['rolemenuid'] ?>);" name="btnSend" id="btnSend" value="<?= $buttonname ?>" class="btn btn-primary">
                                <?php
                            }

                            if ($_GET['type'] == "password") {
                                $condition1 = " AND c.ROLENAME = '" . $_SESSION["ROLENAME"] . "'";
                                $sql_seRoleaccount = "{call megRoleaccount_v2(?,?)}";
                                $params_seRoleaccount = array(
                                    array('select_roleaccount', SQLSRV_PARAM_IN),
                                    array($condition1, SQLSRV_PARAM_IN)
                                );
                                $query_seRoleaccount = sqlsrv_query($conn, $sql_seRoleaccount, $params_seRoleaccount);
                                $result_seRoleaccount = sqlsrv_fetch_array($query_seRoleaccount, SQLSRV_FETCH_ASSOC);
                                ?>
                                <input type="button" onclick="save_password(<?= $_SESSION["EMPLOYEEID"] ?>,<?= $result_seRoleaccount['ROLEID'] ?>)" name="btnSend" id="btnSend" value="<?= $buttonname ?>" class="btn btn-primary">
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
//$params_getDate = array(
//    array('select_getdate', SQLSRV_PARAM_IN)
//);
//$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
//$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);
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

                </div> -->  
                <?php
                if ($_GET['type'] == 'rolemenu') {
                    ?>
                    <div class="row" >
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #e7e7e7">
                                    <font style="font-size: 16px"><b>รายการข้อมูล : เมนู</b></font>                            
                                </div>
                                <div class="panel-body">
                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div id="datade">
                                                    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th>ชื่อเมนูหลัก</th>
                                                                <th>ชื่อเมนูย่อย</th>
                                                                <th>สิทธิ์</th>
                                                                <th>หมายเหตุ</th>
                                                                <th>สถานะการใช้งาน</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $condition1 = ($_GET['rolemenuid'] != "") ? " AND a.ROLEID = " . $_GET['roleid'] . " AND a.ROLEMENUID = " . $_GET['rolemenuid'] : " AND a.ROLEID = " . $_GET['roleid'];
                                                            ;
                                                            $sql_seMenu = "{call megRolemenu_v2(?,?)}";
                                                            $params_seMenu = array(
                                                                array('select_rolemenu', SQLSRV_PARAM_IN),
                                                                array($condition1, SQLSRV_PARAM_IN)
                                                            );
                                                            $query_seMenu = sqlsrv_query($conn, $sql_seMenu, $params_seMenu);
                                                            while ($result_seMenu = sqlsrv_fetch_array($query_seMenu, SQLSRV_FETCH_ASSOC)) {
                                                                ?>
                                                                <tr class="odd gradeX">
                                                                    <td><?= $result_seMenu['MENUNAME'] ?></td>
                                                                    <td><?= $result_seMenu['SUBMENUNAME'] ?></td>
                                                                    <td><?= $result_seMenu['PERMISSIONS'] ?></td>
                                                                    <td><?= $result_seMenu['REMARK'] ?></td>
                                                                    <td><?php echo ($result_seMenu['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>

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

                if ($_GET['type'] == 'role') {
                    ?>
                    <div class="row" >
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #e7e7e7">
                                    <font style="font-size: 16px"><b>รายการข้อมูล : สิทธิ์</b></font>                            
                                </div>
                                <div class="panel-body">
                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div id="datade">
                                                    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th>ชื่อสิทธิ์</th>
                                                                <th>หมายเหตุ</th>
                                                                <th>สถานะการใช้งาน</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $condition1 = ($_GET['roleid'] != "") ? " AND a.ROLEID = " . $_GET['roleid'] : "";
                                                            $sql_seRole = "{call megRole_v2(?,?)}";
                                                            $params_seRole = array(
                                                                array('select_role', SQLSRV_PARAM_IN),
                                                                array($condition1, SQLSRV_PARAM_IN)
                                                            );
                                                            $query_seRole = sqlsrv_query($conn, $sql_seRole, $params_seRole);
                                                            while ($result_seRole = sqlsrv_fetch_array($query_seRole, SQLSRV_FETCH_ASSOC)) {
                                                                ?>
                                                                <tr class="odd gradeX">
                                                                    <td><?= $result_seRole['ROLENAME'] ?></td>
                                                                    <td><?= $result_seRole['REMARK'] ?></td>
                                                                    <td><?php echo ($result_seRole['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>

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

                if ($_GET['type'] == 'roleaccount') {
                    ?>
                    <div class="row" >
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #e7e7e7">
                                    <font style="font-size: 16px"><b>รายการข้อมูล : ผู้ใช้งานระบบ</b></font>                            
                                </div>
                                <div class="panel-body">
                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div id="datade">
                                                    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th>รหัสพนักงาน</th>
                                                                <th>ชื่อ-นามสกุล</th>
                                                                <th>Username</th>
                                                                <th>Password</th>
                                                                <th>Password</th>
                                                                <th>สิทธิ์</th>
                                                                <th>หมายเหตุ</th>
                                                                <th>สถานะการใช้งาน</th>
                                                                <th>จัดการ</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $condition1 = ($_GET['roleaccountid'] != "") ? " AND a.ACTIVESTATUS = 1 AND a.ROLEACCOUNTID = " . $_GET['roleaccountid'] : " AND a.ACTIVESTATUS = 1  AND a.EMPLOYEEID = " . $_GET['employeeid'];

                                                            $sql_seAccount = "{call megRoleaccount_v2(?,?)}";
                                                            $params_seAccount = array(
                                                                array('select_grouproleaccount', SQLSRV_PARAM_IN),
                                                                array($condition1, SQLSRV_PARAM_IN)
                                                            );
                                                            $query_seAccount = sqlsrv_query($conn, $sql_seAccount, $params_seAccount);
                                                            while ($result_seAccount = sqlsrv_fetch_array($query_seAccount, SQLSRV_FETCH_ASSOC)) {
                                                                ?>
                                                                <tr >
                                                                    <td><?= $result_seAccount['PersonCode'] ?></td>
                                                                    <td><?= $result_seAccount['EMPLOYEENAME'] ?></td>
                                                                    <td><?= $result_seAccount['USERNAME'] ?></td>
                                                                    <td><?= $result_seAccount['PASSWORD'] ?></td>
                                                                    <td style="text-align: center"><input type="text" class="form-control" id="txt_password" onchange="edit_password(this.value, '<?=$result_seAccount['ROLEACCOUNTID']?>')" value="<?= $result_seAccount['PASSWORD'] ?>"></td>
                                                                    <td><?= $result_seAccount['ROLENAME'] ?></td>
                                                                    <td><?= $result_seAccount['REMARK'] ?></td>
                                                                    <td><?php echo ($result_seAccount['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>
                                                                    <td style="text-align: center">
                                                                        <button onclick="delete_roleaccount(<?= $result_seAccount['ROLEACCOUNTID'] ?>);" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>

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
                if ($_GET['type'] == 'password') {
                    ?>
                    <div class="row" >
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #e7e7e7">
                                    <font style="font-size: 16px"><b>รายการข้อมูล : แก้ไขรหัสผ่าน</b></font>                            
                                </div>
                                <div class="panel-body">
                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                        <div class="row">
                                            <div class="col-sm-12">

                                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>รหัสพนักงาน</th>
                                                            <th>ชื่อ-นามสกุล</th>
                                                            <th>Username</th>
                                                            <th>Password</th>
                                                            <th>หมายเหตุ</th>
                                                            <th>สถานะการใช้งาน</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $condition1 = " AND a.EMPLOYEEID =" . $_SESSION["EMPLOYEEID"] . " AND c.ROLENAME = '" . $_SESSION["ROLENAME"] . "'";
                                                        $sql_sePasssword = "{call megRoleaccount_v2(?,?)}";
                                                        $params_sePasssword = array(
                                                            array('select_grouproleaccount', SQLSRV_PARAM_IN),
                                                            array($condition1, SQLSRV_PARAM_IN)
                                                        );
                                                        $query_sePasssword = sqlsrv_query($conn, $sql_sePasssword, $params_sePasssword);
                                                        while ($result_sePasssword = sqlsrv_fetch_array($query_sePasssword, SQLSRV_FETCH_ASSOC)) {
                                                            ?>
                                                            <tr class="odd gradeX">
                                                                <td><?= $result_sePasssword['PersonCode'] ?></td>
                                                                <td><?= $result_sePasssword['EMPLOYEENAME'] ?></td>
                                                                <td><?= $result_sePasssword['USERNAME'] ?></td>
                                                                <td><?= $result_sePasssword['PASSWORD'] ?></td>
                                                                <td><?= $result_sePasssword['REMARK'] ?></td>
                                                                <td><?php echo ($result_sePasssword['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>
                                                    </tbody>


                                                </table>



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


        <script src="../dist/js/bootstrap-select.js"></script>
        <script type="text/javascript">
            $('.selectpicker').on('changed.bs.select', function () {
                document.getElementById('txt_comp').value = $(this).val();

            });
        </script>


    </body>
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
        $(document).ready(function () {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });
    </script>
    <script>
        function datetodate()
        {
            document.getElementById('txt_dateend').value = document.getElementById('txt_datestart').value;
        }

        function chknull_roleaccount()
        {
            if (document.getElementById('cb_activestatusaccount').value == '')
            {
                alert('สถานะ เป็นค่าว่าง !!!')
                document.getElementById('cb_activestatusaccount').focus();
                return false;
            } else
            {
                return true;
            }
        }

        function chknull_role()
        {
            if (document.getElementById('txt_premissionsnamerole').value == '')
            {
                alert('ชื่อสิทธิ์ เป็นค่าว่าง !!!')
                document.getElementById('txt_premissionsnamerole').focus();
                return false;
            } else if (document.getElementById('cb_activestatusrole').value == '')
            {
                alert('สถานะ เป็นค่าว่าง !!!')
                document.getElementById('cb_activestatusrole').focus();
                return false;
            } else
            {
                return true;
            }
        }
        function chknull_rolemenu()
        {
            if (document.getElementById('cb_mainmenu').value == '')
            {
                alert('ชื่อเมนู เป็นค่าว่าง !!!')
                document.getElementById('cb_mainmenu').focus();
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
        function chknull_password()
        {
            if (document.getElementById('txt_passwordnew').value == '')
            {
                alert('Password(ใหม่) เป็นค่าว่าง !!!')
                document.getElementById('txt_passwordnew').focus();
                return false;
            } else
            {
                return true;
            }
        }
        function select_submenu(menuid)
        {
            $.ajax({
                type: 'post',
                url: 'meg_data.php',
                data: {
                    txt_flg: "select_submenu", menuid: menuid

                },
                success: function (response) {

                    document.getElementById("cb_submenu").innerHTML = response;

                }
            });

        }
        function edit_password(editvalue,roleid)
        {
            // alert(editvalue);
            // alert(roleid);

            $.ajax({
                type: 'post',
                url: 'meg_data2.php',
                data: {
                    txt_flg: "edit_password", editvalue: editvalue,roleid: roleid

                },
                success: function (response) {

                    alert("แก้ไขข้อมูลรหัสผ่านเรียบร้อยแล้ว!!");
                    window.location.reload();

                }
            });

        }
        function save_roleaccount(roleaccountid)
        {

            var roleid = document.getElementById('cb_premissions').value;
            var username = document.getElementById('txt_username').value;
            var employeeid = document.getElementById('txt_employeeid').value;
            var activestatusaccount = document.getElementById('cb_activestatusaccount').value;
            var remarkaccount = document.getElementById('txt_remarkaccount').value;

            var rolename = document.getElementById('txt_rolename').value;

            if (rolename == 'ADMIN') {
                if (chknull_roleaccount())
                    {
                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_roleaccount", roleaccountid: roleaccountid, roleid: roleid, username: '', password: '', employeeid: employeeid, remarkaccount: remarkaccount, activestatusaccount: activestatusaccount

                            },
                            success: function (response) {
                                alert(response);
                                window.location.reload();
                            }
                        });
                    } 
            }else{
                alert('ไม่ได้รับอนุญาตให้เพิ่มสิทธิ์ ไม่สามารถเพิ่มสิทธิ์ ADMIN ได้!!!');
            }
            
        }
        function save_password(employeeid, roleid)
        {

            var passwordnew = document.getElementById('txt_passwordnew').value;

            if (chknull_password())
            {
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "save_password", employeeid: employeeid, roleid: roleid, passwordnew: passwordnew

                    },
                    success: function (response) {
                        alert(response);
                        window.location.reload();
                    }
                });
            }
        }
        function save_role(roleid)
        {
            var premissionsnamerole = document.getElementById('txt_premissionsnamerole').value;
            var remarkrole = document.getElementById('txt_remarkrole').value;
            var activestatusrole = document.getElementById('cb_activestatusrole').value;


            if (chknull_role())
            {
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "save_role", roleid: roleid, premissionsnamerole: premissionsnamerole, remarkrole: remarkrole, activestatusrole: activestatusrole

                    },
                    success: function (response) {
                        alert(response);
                        window.location.reload();
                    }
                });
            }
        }
        function delete_roleaccount(val)
        {
            var confirmation = confirm("ต้องการลบข้อมูล ?");

            if (confirmation) {
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "delete_roleaccount", roleaccountid: val
                    },
                    success: function () {
                        alert('ลบข้อมูลเรียบร้อยแล้ว');
                        window.location.reload();
                    }
                });
            }
        }
        function save_rolemenu(rolemenuid)
        {
            var premissions = "", premissionswrite = "", premissionsdel = "", premissionsread = "", premissionsmenu = "";

            var res = premissions.concat(premissionswrite, premissionsdel, premissionsread, premissionsmenu);
            var n = res.length;
            premissions = res.substring(0, n - 1);

            var roleid = document.getElementById('txt_roleid').value;
            var mainmenu = document.getElementById('cb_mainmenu').value;
            var submenu = document.getElementById('cb_submenu').value;
            var remarkmenu = document.getElementById('txt_remarkmenu').value;
            var activestatusmenu = document.getElementById('cb_activestatusmenu').value;



            if (chknull_rolemenu())
            {
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "save_rolemenu", rolemenuid: rolemenuid, roleid: roleid, mainmenu: mainmenu, submenu: submenu, premissions: premissions, remarkmenu: remarkmenu, activestatusmenu: activestatusmenu
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