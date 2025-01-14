
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
    $query_info = sqlsrv_query($conn, $sql_info, $params_info);
    $result_info = sqlsrv_fetch_array($query_info, SQLSRV_FETCH_ASSOC);
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">

    </head>

    <body>
        <div id="wrapper">

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

            <div id="page-wrapper" >
                <div class="row">
                    <div class="col-md-12">&nbsp;</div>
                </div>

                <div class="tab-content">
                    <div class="row">
                        <div class="col-md-12">&nbsp;</div>
                    </div>


                    <!-- /.row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #e7e7e7">
                                    <a href='index2.php'>หน้าแรก</a> / <a href='report_vehiclrinfogateway.php'>ข้อมูลรถพื้นที่เกตุเวย์</a> / <?= $result_info['VEHICLEREGISNUMBER'] ?> 
                                </div>
                                <div class="panel-body">
                                    <div class="row" >
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>เลขทะเบียนรถ</label>
                                                <input class="form-control"  id="txt_vehiclenumber" name="txt_vehiclenumber" value="<?= $result_info['VEHICLEREGISNUMBER'] ?>">
                                            </div>

                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>กลุ่มรถ</label>
                                                <select  class="form-control" id="cb_cargroup" name="cb_cargroup">
                                                    <option value="">เลือกกลุ่มรถ</option>
                                                    <?php
                                                    $sql_seCargroup = "{call megVehiclegroup_v2(?)}";
                                                    $params_seCargroup = array(
                                                        array('select_vehiclegroup', SQLSRV_PARAM_IN)
                                                    );
                                                    $query_seCargroup = sqlsrv_query($conn, $sql_seCargroup, $params_seCargroup);
                                                    while ($result_seCargroup = sqlsrv_fetch_array($query_seCargroup, SQLSRV_FETCH_ASSOC)) {
                                                        $selected1 = "";
                                                        if ($result_info['VEHICLEGROUPCODE'] == $result_seCargroup['VEHICLEGROUPCODE']) {
                                                            $selected1 = "selected";
                                                        }
                                                        ?>
                                                        <option value="<?= $result_seCargroup['VEHICLEGROUPCODE'] ?>" <?= $selected1 ?>><?= $result_seCargroup['VEHICLEGROUPDESC'] ?></option>
                                                        <?php
                                                    }
                                                    ?>


                                                </select>
                                            </div>

                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>ประเภทรถ</label>
                                                <select  class="form-control" id="cb_cartype" name="cb_cartype" onchange="show_remark(this.value)">
                                                    <option value="">เลือกประเภทรถ</option>
                                                    <?php
                                                    $sql_seCartype = "{call megVehicletype_v2(?)}";
                                                    $params_seCartype = array(
                                                        array('select_vehicletype', SQLSRV_PARAM_IN)
                                                    );
                                                    $query_seCartype = sqlsrv_query($conn, $sql_seCartype, $params_seCartype);
                                                    while ($result_seCartype = sqlsrv_fetch_array($query_seCartype, SQLSRV_FETCH_ASSOC)) {
                                                        $selected2 = "";
                                                        if ($result_info['VEHICLETYPECODE'] == $result_seCartype['VEHICLETYPECODE']) {
                                                            $selected2 = 'selected';
                                                        }
                                                        ?>

                                                        <option value="<?= $result_seCartype['VEHICLETYPECODE'] ?>" <?= $selected2 ?>><?= $result_seCartype['VEHICLETYPEDESC'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>ยี่ห้อรถ</label>
                                                <select  class="form-control" id="cb_carbrand" name="cb_carbrand">
                                                    <option value="">เลือกยี่ห้อรถ</option>
                                                    <?php
                                                    $sql_seCarbrand = "{call megVehiclebrand_v2(?)}";
                                                    $params_seCarbrand = array(
                                                        array('select_vehiclebrand', SQLSRV_PARAM_IN)
                                                    );
                                                    $query_seCarbrand = sqlsrv_query($conn, $sql_seCarbrand, $params_seCarbrand);
                                                    while ($result_seCarbrand = sqlsrv_fetch_array($query_seCarbrand, SQLSRV_FETCH_ASSOC)) {
                                                        $selected3 = "";
                                                        if ($result_info['BRANDCODE'] == $result_seCarbrand['BRANDCODE']) {
                                                            $selected3 = 'selected';
                                                        }
                                                        ?>

                                                        <option value="<?= $result_seCarbrand['BRANDCODE'] ?>" <?= $selected3 ?>><?= $result_seCarbrand['BRANDDESC'] ?></option>
                                                        <?php
                                                    }
                                                    ?>


                                                </select>
                                            </div>

                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>ประเภทเกียร์รถ</label>
                                                <select  class="form-control" id="cb_geartype" name="cb_geartype">
                                                    <option value="">เลือกประเภทเกียร์รถ</option>

                                                    <?php
                                                    $sql_seGeartype = "{call megVehiclegear_v2(?)}";
                                                    $params_seGeartype = array(
                                                        array('select_vehiclegear', SQLSRV_PARAM_IN)
                                                    );
                                                    $query_seGeartype = sqlsrv_query($conn, $sql_seGeartype, $params_seGeartype);
                                                    while ($result_seGeartype = sqlsrv_fetch_array($query_seGeartype, SQLSRV_FETCH_ASSOC)) {
                                                        $selected4 = "";
                                                        if ($result_info['GEARTYPECODE'] == $result_seGeartype['GEARTYPECODE']) {
                                                            $selected4 = "selected";
                                                        }
                                                        ?>
                                                        <option value="<?= $result_seGeartype['GEARTYPECODE'] ?>"<?= $selected4 ?>><?= $result_seGeartype['GEARTYPEDESC'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>สีรถ</label>
                                                <select  class="form-control" id="cb_carcolor" name="cb_carcolor">
                                                    <option value="">เลือกสีรถ</option>
                                                    <?php
                                                    $sql_seCarcolor = "{call megVehiclecolor_v2(?)}";
                                                    $params_seCarcolor = array(
                                                        array('select_vehiclecolor', SQLSRV_PARAM_IN)
                                                    );
                                                    $query_seCarcolor = sqlsrv_query($conn, $sql_seCarcolor, $params_seCarcolor);
                                                    while ($result_seCarcolor = sqlsrv_fetch_array($query_seCarcolor, SQLSRV_FETCH_ASSOC)) {
                                                        $selected5 = "";
                                                        if ($result_info['COLORCODE'] == $result_seCarcolor['COLORCODE']) {
                                                            $selected5 = 'selected';
                                                        }
                                                        ?>

                                                        <option value="<?= $result_seCarcolor['COLORCODE'] ?>"<?= $selected5 ?>><?= $result_seCarcolor['COLORDESC'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                        </div>

                                    </div>


                                    <div class="row" >


                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>ซีรีส์/รุ่น</label>
                                                <input class="form-control"  id="txt_series_model" name="txt_series_model" value="<?= $result_info['SERIES'] ?>">
                                            </div>

                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>ชื่อรถ (ไทย)</label>
                                                <input class="form-control"  id="txt_carnameth" name="txt_carnameth" value="<?= $result_info['THAINAME'] ?>">
                                            </div>

                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>ชื่อรถ (อังกฤษ)</label>
                                                <input class="form-control"  id="txt_carnameen" name="txt_carnameen" value="<?= $result_info['ENGNAME'] ?>">
                                            </div>

                                        </div>
                                        <div class="col-lg-1">
                                            <div class="form-group">
                                                &nbsp;
                                            </div>

                                        </div>
                                        <div class="col-lg-1">
                                            <div class="form-group">
                                                <label>แรงม้า</label>
                                                <input class="form-control"  id="txt_horse" name="txt_horse" onKeyUp="if (isNaN(this.value)) {
                                                            alert('กรุณากรอกตัวเลข');
                                                            this.value = '';
                                                        }" value="<?= $result_info['HORSEPOWER'] ?>">

                                            </div>

                                        </div>
                                        <div class="col-lg-1">
                                            <div class="form-group">
                                                <label>CC</label>
                                                <input class="form-control"  id="txt_cc" name="txt_cc" onKeyUp="if (isNaN(this.value)) {
                                                            alert('กรุณากรอกตัวเลข');
                                                            this.value = '';
                                                        }" value="<?= $result_info['CC'] ?>">

                                            </div>

                                        </div>



                                    </div>
                                    <div class="row" >


                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>เลขเครื่องยนต์</label>
                                                <input class="form-control"  id="txt_machine" name="txt_machine" value="<?= $result_info['MACHINENUMBER'] ?>">
                                            </div>

                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>เลขตัวถัง</label>
                                                <input class="form-control"  id="txt_chassisnumber" name="txt_chassisnumber" value="<?= $result_info['CHASSISNUMBER'] ?>">
                                            </div>

                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>ประเภทพลังงาน</label>
                                                <select  class="form-control" id="cb_energy" name="cb_energy">
                                                    <option value="">เลือกประเภทพลังงาน</option>
                                                    <?php
                                                    switch ($result_info['ENERGY']) {
                                                        case 'ดีเซล': {
                                                                ?>
                                                                <option value="ดีเซล" selected="">ดีเซล</option>
                                                                <option value="เบนซิน">เบนซิน</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case 'เบนซิน': {
                                                                ?>
                                                                <option value="ดีเซล">ดีเซล</option>
                                                                <option value="เบนซิน" selected="">เบนซิน</option>
                                                                <?php
                                                            }
                                                            break;
                                                        default : {
                                                                ?>
                                                                <option value="ดีเซล">ดีเซล</option>
                                                                <option value="เบนซิน">เบนซิน</option>
                                                                <?php
                                                            }
                                                            break;
                                                    }
                                                    ?>
                                                </select>


                                            </div>

                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>น้ำหนักรถ (กิโลกรัม)</label>
                                                <input class="form-control"  id="txt_weight" name="txt_weight" onKeyUp="if (isNaN(this.value)) {
                                                            alert('กรุณากรอกตัวเลข');
                                                            this.value = '';
                                                        }" value="<?= $result_info['WEIGHT'] ?>">
                                            </div>

                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>ประเภทเพลา</label>

                                                <select  class="form-control" id="cb_axle" name="cb_axle">
                                                    <option value="" >เลือกประเภทเพลา</option>

                                                    <?php
                                                    switch ($result_info['AXLETYPE']) {
                                                        case '1': {
                                                                ?>
                                                                <option value="1" selected="">1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '2': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" selected="">2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '3': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" selected="">3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '4': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" selected="">4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '5': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" selected="">5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '6': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" selected="">6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '7': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" selected="">7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '8': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" selected="">8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '9': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" selected="">9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '10': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" selected="">10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        default : {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10">10</option>
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


                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>ลูกสูบ</label>

                                                <select  class="form-control" id="cb_piston" name="cb_piston">
                                                    <option value="">เลือกลูกสูบ</option>
                                                    <?php
                                                    switch ($result_info['PISTON']) {
                                                        case '1': {
                                                                ?>
                                                                <option value="1" selected="">1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '2': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" selected="">2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '3': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" selected="">3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '4': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" selected="">4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '5': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" selected="">5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '6': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" selected="">6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '7': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" selected="">7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '8': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" selected="">8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '9': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" selected="">9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '10': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" selected="">10</option>
                                                                <?php
                                                            }
                                                            break;
                                                        default : {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <?php
                                                            }
                                                            break;
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>น้ำหนักบรรทุกสูงสุด</label>
                                                <input class="form-control"  id="txt_maxload" name="txt_maxload" onKeyUp="if (isNaN(this.value)) {
                                                            alert('กรุณากรอกตัวเลข');
                                                            this.value = '';
                                                        }" value="<?= $result_info['MAXIMUMLOAD'] ?>">
                                            </div>

                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>การใช้งาน (ปี)</label>

                                                <select  class="form-control" id="cb_used" name="cb_used">
                                                    <option value="">เลือกการใช้งาน (ปี)</option>
                                                    <?php
                                                    switch ($result_info['USED']) {
                                                        case '1': {
                                                                ?>
                                                                <option value="1" selected="">1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '2': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" selected="">2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '3': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" selected="">3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="10" >11</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '4': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" selected="">4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="10" >11</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '5': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" selected="">5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '6': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" selected="">6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '7': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" selected="">7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '8': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" selected="">8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '9': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" selected="">9</option>
                                                                <option value="10" >10</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '10': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" selected="">10</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '11': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="11" selected="">11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '12': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="10" >11</option>
                                                                <option value="12" selected="">12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '13': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" selected="">13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }

                                                            break;
                                                        case '14': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" selected="">14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '15': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" selected="">15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '16': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" selected="">16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '17': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" selected="">17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '18': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '19': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" selected="">19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '20': {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" selected="">20</option>
                                                                <?php
                                                            }
                                                            break;
                                                        default : {
                                                                ?>
                                                                <option value="1" >1</option>
                                                                <option value="2" >2</option>
                                                                <option value="3" >3</option>
                                                                <option value="4" >4</option>
                                                                <option value="5" >5</option>
                                                                <option value="6" >6</option>
                                                                <option value="7" >7</option>
                                                                <option value="8" >8</option>
                                                                <option value="9" >9</option>
                                                                <option value="10" >10</option>
                                                                <option value="11" >11</option>
                                                                <option value="12" >12</option>
                                                                <option value="13" >13</option>
                                                                <option value="14" >14</option>
                                                                <option value="15" >15</option>
                                                                <option value="16" >16</option>
                                                                <option value="17" >17</option>
                                                                <option value="18" >18</option>
                                                                <option value="19" >19</option>
                                                                <option value="20" >20</option>
                                                                <?php
                                                            }
                                                            break;
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>ซื้อรถที่ใหน</label>
                                                <input class="form-control"  id="txt_vehiclebuywhere" name="txt_vehiclebuywhere"  value="<?= $result_info['VEHICLEBUYWHERE'] ?>">
                                            </div>

                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>วันที่ซื้อ</label>
                                                <input class="form-control dateen"    id="txt_vehiclebuydate" name="txt_vehiclebuydate"  value="<?= $result_info['VEHICLEBUYDATE'] ?>">
                                            </div>

                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>ราคารถ</label>
                                                <input class="form-control" onKeyUp="if (isNaN(this.value)) {
                                                            alert('กรุณากรอกตัวเลข');
                                                            this.value = '';
                                                        }" id="txt_vehiclebuyprice" name="txt_vehiclebuyprice"  value="<?= $result_info['VEHICLEBUYPRICE'] ?>">
                                            </div>

                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>เงื่อนไขการซื้อ</label>
                                                <select  class="form-control" id="cb_vehiclebuyconditon" name="cb_vehiclebuyconditon">
                                                    <option value="">เลือกเงื่อนไขการซื้อ</option>
                                                    <?php
                                                    switch ($result_info['VEHICLEBUYCONDITION']) {
                                                        case 'สด': {
                                                                ?>
                                                                <option value = "สด" selected="">สด</option>
                                                                <option value = "ผ่อน" >ผ่อน</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case 'ผ่อน': {
                                                                ?>
                                                                <option value = "สด" >สด</option>
                                                                <option value = "ผ่อน" selected="">ผ่อน</option>
                                                                <?php
                                                            }
                                                            break;
                                                        default : {
                                                                ?>
                                                                <option value = "สด" >สด</option>
                                                                <option value = "ผ่อน" >ผ่อน</option>
                                                                <?php
                                                            }
                                                            break;
                                                    }
                                                    ?>


                                                </select>
                                            </div>

                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>ต่อโครงสร้างที่ใหน</label>
                                                <input class="form-control"  id="txt_vehiclestructurewhere" name="txt_vehiclestructurewhere"  value="<?= $result_info['VEHICLESTRUCTUREWHERE'] ?>">
                                            </div>

                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>วันที่ต่อโครงสร้าง</label>
                                                <input class="form-control dateen"   id="txt_vehiclestructuredate" name="txt_vehiclestructuredate"  value="<?= $result_info['VEHICLESTRUCTUREDATE'] ?>">
                                            </div>

                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>ราคา</label>
                                                <input class="form-control" onKeyUp="if (isNaN(this.value)) {
                                                            alert('กรุณากรอกตัวเลข');
                                                            this.value = '';
                                                        }" id="txt_vehiclestructuredprice" name="txt_vehiclestructuredprice"  value="<?= $result_info['VEHICLESTRUCTUREPRICE'] ?>">
                                            </div>

                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>วันที่จดทะเบียนครั้งแรก</label>
                                                <input class="form-control dateen"  id="txt_vehicleregisterdate" name="txt_vehicleregisterdate"  value="<?= $result_info['VEHICLEREGISTERDATE'] ?>">
                                            </div>

                                        </div>




                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>อุปกรณ์เฉพาะ</label>
                                                <textarea class="form-control" autocomplete="off" rows="3" id="txt_vehiclespecial" name="txt_vehiclespecial"><?= $result_info['VEHICLESPECIAL'] ?></textarea>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row" >

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>หมายเหตุ</label>
                                                <textarea class="form-control" autocomplete="off" rows="3" id="txt_inforemark" name="txt_inforemark"><?= $result_info['REMARK'] ?></textarea>
                                            </div>

                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>สถานะ</label>
                                                <select  class="form-control" id="cb_carstatus" name="cb_carstatus">
                                                    <option value="">เลือกสถานะ</option>
                                                    <?php
                                                    $selected = "SELECTED";

                                                    switch ($result_info['ACTIVESTATUS']) {
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
                                <div class="modal-footer">
                                    <div class="row" >
                                        <div class="col-lg-12">
                                            <?php
                                            $buttonname = ($_GET['meg'] == 'add') ? "บันทึกข้อมูล" : "แก้ไขข้อมูล";
                                            ?>
                                            <input type="button" onclick="save_vehicleinfo('<?= $_GET['vehicleinfoid'] ?>');" name="btnSend" id="btnSend" value="<?= $buttonname ?>" class="btn btn-primary">
                                        </div>
                                    </div>
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>



                </div>
            </div>

            <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
            <script src="../vendor/metisMenu/metisMenu.min.js"></script>
            <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
            <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
            <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
            <script src="../dist/js/sb-admin-2.js"></script>
            <script src="../js/jquery.datetimepicker.full.js"></script>
            <script src="../dist/js/jquery.autocomplete.js"></script>
            <script src="../dist/js/bootstrap-select.js"></script>


    </body>
    <script>


                                                $(document).ready(function () {
                                                    $('#dataTables-example').DataTable({
                                                        order: [[0, "desc"]],
                                                        scrollX: true,
                                                        scrollY: '500px',
                                                    });
                                                });

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




                                                    $.ajax({
                                                        type: 'post',
                                                        url: 'meg_data.php',
                                                        data: {
                                                            txt_flg: "save_vehicleinfo", vehicleinfoid: vehicleinfoid, vehiclenumber: vehiclenumber, cargroup: cargroup, cartype: cartype, carbrand: carbrand, geartype: geartype, carcolor: carcolor, series_model: series_model, carnameth: carnameth, carnameen: carnameen, horse: horse, cc: cc, machine: machine, chassisnumber: chassisnumber, energy: energy, weight: weight, axle: axle, piston: piston, maxload: maxload, used: used, vehiclebuywhere: vehiclebuywhere, vehiclebuydate: vehiclebuydate, vehiclebuyprice: vehiclebuyprice, vehiclebuyconditon: vehiclebuyconditon, vehiclestructurewhere: vehiclestructurewhere, vehiclestructuredate: vehiclestructuredate, vehiclestructuredprice: vehiclestructuredprice, vehicleregisterdate: vehicleregisterdate, vehiclespecial: vehiclespecial, inforemark: inforemark, carstatus: carstatus
                                                        },
                                                        success: function (response) {
                                                            alert(response);
                                                            window.location.reload();
                                                        }
                                                    });


                                                }
    </script>
</html>
<?php
sqlsrv_close($conn);
?>
