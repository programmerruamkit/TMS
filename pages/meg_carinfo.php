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
        <!--<link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">-->
        <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../dist/css/buttons.dataTables.min.css" rel="stylesheet">
        
       
        <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet">
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
                    if ($_GET['type'] == "infoamata") {
                        ?>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                        <a href="meg_car.php?type=<?= $_GET['type'] ?>">จัดการรถ</a> / ทะเบียน : <?= $result_info['VEHICLEREGISNUMBER'] ?>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row" >
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>เลขทะเบียนรถ</label>
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
                                                    <font style="color: red">* </font><label>ซีรีส์/รุ่น</label>
                                                    <input class="form-control"  id="txt_series_model" name="txt_series_model" value="<?= $result_info['SERIES'] ?>">
                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ชื่อรถ (ไทย)</label>
                                                    <input class="form-control"  id="txt_carnameth" name="txt_carnameth" value="<?= $result_info['THAINAME'] ?>">
                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ชื่อรถ (อังกฤษ)</label>
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
                                                    <font style="color: red">* </font><label>แรงม้า</label>
                                                    <input class="form-control"  id="txt_horse" name="txt_horse" onKeyUp="if (isNaN(this.value)) {
                                                                alert('กรุณากรอกตัวเลข');
                                                                this.value = '';
                                                            }" value="<?= $result_info['HORSEPOWER'] ?>">

                                                </div>

                                            </div>
                                            <div class="col-lg-1">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>CC</label>
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
                                                    <font style="color: red">* </font><label>เลขเครื่องยนต์</label>
                                                    <input class="form-control"  id="txt_machine" name="txt_machine" value="<?= $result_info['MACHINENUMBER'] ?>">
                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>เลขตัวถัง</label>
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
                                                    <font style="color: red">* </font><label>น้ำหนักรถ (กิโลกรัม)</label>
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
                                                    <font style="color: red">* </font><label>น้ำหนักบรรทุกสูงสุด</label>
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
                                                    <font style="color: red">* </font><label>ซื้อรถที่ใหน</label>
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
                                                    <font style="color: red">* </font><label>ราคารถ</label>
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
                                                    <font style="color: red">* </font><label>ต่อโครงสร้างที่ใหน</label>
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
                                                    <font style="color: red">* </font><label>ราคา</label>
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
                                                    <font style="color: red">* </font><label>อุปกรณ์เฉพาะ</label>
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
                                                    <font style="color: red">* </font><label>สถานะ</label>
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
                                    <!-- /.panel-body -->
                                </div>
                                <!-- /.panel -->
                            </div>
                            <!-- /.col-lg-12 -->
                        </div>





                        <?php
                    }

                    if ($_GET['type'] == "infogetway") {
                        ?>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                        <a href="meg_car.php?type=<?= $_GET['type'] ?>">จัดการรถ</a> / <a href="meg_car.php?type=<?= $_GET['type'] ?>&vehicleinfoid=<?= $result_info['VEHICLEINFOID'] ?>"><?php
                                            if ($result_info['VEHICLEINFOID'] == "") {
                                                echo "";
                                            } else {
                                                ?>ทะเบียน : <?= $result_info['VEHICLEREGISNUMBER'] ?><?php } ?></a>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row" >
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>เลขทะเบียนรถ</label>
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
                                                            array('select_vehicletypegetway', SQLSRV_PARAM_IN)
                                                        );
                                                        $query_seCartype = sqlsrv_query($conn, $sql_seCartype, $params_seCartype);
                                                        while ($result_seCartype = sqlsrv_fetch_array($query_seCartype, SQLSRV_FETCH_ASSOC)) {
                                                            $selected2 = "";
                                                            if ($result_info['VEHICLETYPECODE'] == $result_seCartype['VEHICLETYPECODE']) {
                                                                $selected2 = 'selected';
                                                            }
                                                            ?>

                                                            <option value="<?= $result_seCartype['VEHICLETYPECODE'] ?>" <?= $selected2 ?>><?= $result_seCartype['VEHICLETYPECODE'] ?></option>
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
                                                    <font style="color: red">* </font><label>ซีรีส์/รุ่น</label>
                                                    <input class="form-control"  id="txt_series_model" name="txt_series_model" value="<?= $result_info['SERIES'] ?>">
                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ชื่อรถ (ไทย)</label>
                                                    <input class="form-control"  id="txt_carnameth" name="txt_carnameth" value="<?= $result_info['THAINAME'] ?>">
                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ชื่อรถ (อังกฤษ)</label>
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
                                                    <font style="color: red">* </font><label>แรงม้า</label>
                                                    <input class="form-control"  id="txt_horse" name="txt_horse" onKeyUp="if (isNaN(this.value)) {
                                                                alert('กรุณากรอกตัวเลข');
                                                                this.value = '';
                                                            }" value="<?= $result_info['HORSEPOWER'] ?>">

                                                </div>

                                            </div>
                                            <div class="col-lg-1">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>CC</label>
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
                                                    <font style="color: red">* </font><label>เลขเครื่องยนต์</label>
                                                    <input class="form-control"  id="txt_machine" name="txt_machine" value="<?= $result_info['MACHINENUMBER'] ?>">
                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>เลขตัวถัง</label>
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
                                                    <font style="color: red">* </font><label>น้ำหนักรถ (กิโลกรัม)</label>
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
                                                    <font style="color: red">* </font><label>น้ำหนักบรรทุกสูงสุด</label>
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
                                                    <font style="color: red">* </font><label>ซื้อรถที่ใหน</label>
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
                                                    <font style="color: red">* </font><label>ราคารถ</label>
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
                                                    <font style="color: red">* </font><label>ต่อโครงสร้างที่ใหน</label>
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
                                                    <font style="color: red">* </font><label>ราคา</label>
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
                                                    <font style="color: red">* </font><label>อุปกรณ์เฉพาะ</label>
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
                                                    <font style="color: red">* </font><label>สถานะ</label>
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
                                    <!-- /.panel-body -->
                                </div>
                                <!-- /.panel -->
                            </div>
                            <!-- /.col-lg-12 -->
                        </div>





                        <?php
                    }
                    if ($_GET['type'] == "history") {
                        include '../pages/meg_cardata.php';
                        ?>
                        <div class="row">
                            <?php
                            if ($_GET['vehiclechangehistoryid'] != "") {
                                $condition1 = " AND a.VEHICLEINFOID = " . $_GET['vehicleinfoid'] . " AND a.VEHICLECHANGEHISTORYID =" . $_GET['vehiclechangehistoryid'];
                                $sql_seVehiclechangehistory = "{call megVehiclechangehistory_v2(?,?)}";
                                $params_seVehiclechangehistory = array(
                                    array('select_vehiclechangehistory', SQLSRV_PARAM_IN),
                                    array($condition1, SQLSRV_PARAM_IN)
                                );
                                $query_seVehiclechangehistory = sqlsrv_query($conn, $sql_seVehiclechangehistory, $params_seVehiclechangehistory);
                                $result_seVehiclechangehistory = sqlsrv_fetch_array($query_seVehiclechangehistory, SQLSRV_FETCH_ASSOC);
                            }
                            ?>
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                        ข้อมูลประวัติการเปลี่ยน
                                    </div>
                                    <div class="panel-body">
                                        <div class="row" >
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>อะไหล่สำรอง/ประเภท</label>

                                                    <select  class="form-control" id="cb_chengevchangtypescode" name="cb_chengevchangtypescode">
                                                        <option value="">เลือกอะไหล่สำรอง/ประเภท</option>
                                                        <?php
                                                        $sql_seSpareparts = "{call megVehiclespareparts_v2(?,?)}";
                                                        $params_seSpareparts = array(
                                                            array('select_vehiclespareparts', SQLSRV_PARAM_IN),
                                                            array('', SQLSRV_PARAM_IN)
                                                        );
                                                        $query_seSpareparts = sqlsrv_query($conn, $sql_seSpareparts, $params_seSpareparts);
                                                        while ($result_seSpareparts = sqlsrv_fetch_array($query_seSpareparts, SQLSRV_FETCH_ASSOC)) {
                                                            $selected1 = "";
                                                            if ($result_seVehiclechangehistory['VCHANGETYPESCODE'] == $result_seSpareparts['VEHICLESPAREPARTSID']) {
                                                                $selected1 = "selected";
                                                            }
                                                            ?>

                                                            <option value="<?= $result_seSpareparts['VEHICLESPAREPARTSID'] ?>"<?= $selected1 ?>><?= $result_seSpareparts['DESCRIPTION'] ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>วันที่เปลี่ยนอะไหล่</label>
                                                    <input class="form-control dateen" style="background-color: #f080802e"  readonly=""  id="txt_changedate" name="txt_changedate" value="<?= $result_seVehiclechangehistory['CHANGEDATE'] ?>">
                                                </div>

                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ราคา/ค่าใช้จ่าย (บาท)</label>
                                                    <input class="form-control"  id="txt_changecost" name="txt_changecost" onKeyUp="if (isNaN(this.value)) {
                                                                alert('กรุณากรอกตัวเลข');
                                                                this.value = '';
                                                            }" value="<?= $result_seVehiclechangehistory['CHANGECOST'] ?>">
                                                </div>

                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ผู้ดำเนิการ</label>
                                                    <input class="form-control"  id="txt_chengewhoprocess" name="txt_chengewhoprocess" value="<?= $result_seVehiclechangehistory['WHOPROCESS'] ?>">
                                                </div>

                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>สถานะ</label>
                                                    <select  class="form-control" id="cb_changstatus" name="cb_changstatus">
                                                        <option value="">เลือกสถานะ</option>
                                                        <?php
                                                        $selected = "SELECTED";

                                                        switch ($result_seVehiclechangehistory['ACTIVESTATUS']) {
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
                                                    <font style="color: red">* </font><label>อะไหล่สำรองในปัจจุบัน</label>
                                                    <textarea class="form-control" autocomplete="off" rows="3" id="txt_chengecurrentspareparts" name="txt_chengecurrentspareparts"><?= $result_seVehiclechangehistory['CURRENTSPAREPARTS'] ?></textarea>
                                                </div>

                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>เปลี่ยนอะไหล่</label>
                                                    <textarea class="form-control" autocomplete="off" rows="3" id="txt_chengeto" name="txt_chengeto"><?= $result_seVehiclechangehistory['CHANGETO'] ?></textarea>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="row" >
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>สถานที่</label>
                                                    <textarea class="form-control" autocomplete="off" rows="3" id="txt_changeplace" name="txt_changeplace"><?= $result_seVehiclechangehistory['PLACE'] ?></textarea>
                                                </div>

                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>หมายเหตุ</label>
                                                    <textarea class="form-control" autocomplete="off" rows="3" id="txt_chengremark" name="txt_chengremark"><?= $result_seVehiclechangehistory['REMARK'] ?></textarea>
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

                    if ($_GET['type'] == "insured") {

                        if ($_GET['vehicleinsuredid'] != "") {
                            $condition1 = " AND a.VEHICLEINFOID = " . $_GET['vehicleinfoid'] . " AND a.VEHICLEINSUREDID =" . $_GET['vehicleinsuredid'];
                            $sql_seVehicleinsured = "{call megVehicleinsured_v2(?,?)}";
                            $params_seVehicleinsured = array(
                                array('select_vehicleinsured', SQLSRV_PARAM_IN),
                                array($condition1, SQLSRV_PARAM_IN)
                            );
                            $query_seVehicleinsured = sqlsrv_query($conn, $sql_seVehicleinsured, $params_seVehicleinsured);
                            $result_seVehicleinsured = sqlsrv_fetch_array($query_seVehicleinsured, SQLSRV_FETCH_ASSOC);
                        }
                        include '../pages/meg_cardata.php';
                        ?>


                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                        ข้อมูลการทำประกันภัย
                                    </div>
                                    <div class="panel-body">

                                        <div class="row" >
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>เลขกรมธรรม์</label>
                                                    <input class="form-control"  id="txt_insuredpolicy" name="txt_insuredpolicy" onKeyUp="if (isNaN(this.value)) {
                                                                alert('กรุณากรอกตัวเลข');
                                                                this.value = '';
                                                            }" value="<?= $result_seVehicleinsured['POLICYNUMBER'] ?>">
                                                </div>

                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>กลุ่มประกันภัย</label>
                                                    <select  class="form-control" id="cb_insuredgroup" name="cb_insuredgroup">
                                                        <option value="">เลือกกลุ่มประกันภัย</option>
                                                        <?php
                                                        switch ($result_seVehicleinsured['INSUREDGROUP']) {
                                                            case 1: {
                                                                    ?>

                                                                    <option value="1" selected="">ภาคสมัครใจ</option>
                                                                    <option value="2">ภาคบังคับ</option>
                                                                    <?php
                                                                }
                                                                break;
                                                            case 2: {
                                                                    ?>
                                                                    <option value="1" >ภาคสมัครใจ</option>
                                                                    <option value="2" selected="">ภาคบังคับ</option>
                                                                    <?php
                                                                }
                                                                break;
                                                            default : {
                                                                    ?>
                                                                    <option value="1" >ภาคสมัครใจ</option>
                                                                    <option value="2" >ภาคบังคับ</option>
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
                                                    <font style="color: red">* </font><label>ประเภทประกันภัย</label>
                                                    <select  class="form-control" id="cb_insuredtype" name="cb_insuredtype">
                                                        <option value="">เลือกประเภทประกันภัย</option>
                                                        <?php
                                                        switch ($result_seVehicleinsured['INSUREDTYPE']) {
                                                            case '1' : {
                                                                    ?>
                                                                    <option value="1" selected="">ประกันภัยชั้น 1</option>
                                                                    <option value="2">ประกันภัยชั้น 2</option>
                                                                    <option value="3">ประกันภัยชั้น 3</option>
                                                                    <option value="2+">ประกันภัยชั้น 2+</option>
                                                                    <option value="3+">ประกันภัยชั้น 3+</option>
                                                                    <?php
                                                                }
                                                                break;
                                                            case '2' : {
                                                                    ?>
                                                                    <option value="1">ประกันภัยชั้น 1</option>
                                                                    <option value="2" selected="">ประกันภัยชั้น 2</option>
                                                                    <option value="3">ประกันภัยชั้น 3</option>
                                                                    <option value="2+">ประกันภัยชั้น 2+</option>
                                                                    <option value="3+">ประกันภัยชั้น 3+</option>
                                                                    <?php
                                                                }
                                                                break;
                                                            case '3' : {
                                                                    ?>
                                                                    <option value="1">ประกันภัยชั้น 1</option>
                                                                    <option value="2">ประกันภัยชั้น 2</option>
                                                                    <option value="3" selected="">ประกันภัยชั้น 3</option>
                                                                    <option value="2+">ประกันภัยชั้น 2+</option>
                                                                    <option value="3+">ประกันภัยชั้น 3+</option>
                                                                    <?php
                                                                }
                                                                break;
                                                            case '2+' : {
                                                                    ?>
                                                                    <option value="1">ประกันภัยชั้น 1</option>
                                                                    <option value="2">ประกันภัยชั้น 2</option>
                                                                    <option value="3">ประกันภัยชั้น 3</option>
                                                                    <option value="2+" selected="">ประกันภัยชั้น 2+</option>
                                                                    <option value="3+">ประกันภัยชั้น 3+</option>
                                                                    <?php
                                                                }
                                                                break;
                                                            case '3+' : {
                                                                    ?>
                                                                    <option value="1">ประกันภัยชั้น 1</option>
                                                                    <option value="2">ประกันภัยชั้น 2</option>
                                                                    <option value="3">ประกันภัยชั้น 3</option>
                                                                    <option value="2+">ประกันภัยชั้น 2+</option>
                                                                    <option value="3+" selected="">ประกันภัยชั้น 3+</option>
                                                                    <?php
                                                                }
                                                                break;
                                                            default : {
                                                                    ?>
                                                                    <option value="1">ประกันภัยชั้น 1</option>
                                                                    <option value="2">ประกันภัยชั้น 2</option>
                                                                    <option value="3">ประกันภัยชั้น 3</option>
                                                                    <option value="2+">ประกันภัยชั้น 2+</option>
                                                                    <option value="3+">ประกันภัยชั้น 3+</option>
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
                                                    <font style="color: red">* </font><label>เบี้ยประกันภัย</label>
                                                    <input class="form-control"  id="txt_insured" name="txt_insured" onKeyUp="if (isNaN(this.value)) {
                                                                alert('กรุณากรอกตัวเลข');
                                                                this.value = '';
                                                            }" value="<?= $result_seVehicleinsured['PRICETOTAL'] ?>">
                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>วงเงินความคุ้มครองสูงสุด</label>
                                                    <input class="form-control"  id="txt_insuredcover" name="txt_insuredcover" onKeyUp="if (isNaN(this.value)) {
                                                                alert('กรุณากรอกตัวเลข');
                                                                this.value = '';
                                                            }" value="<?= $result_seVehicleinsured['SUMINSURED'] ?>">
                                                </div>

                                            </div>



                                        </div>
                                        <div class="row" >

                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ชื่อบริษัทผู้เอาประกันภัย</label>

                                                    <select  class="form-control" id="cb_insuredname" name="cb_insuredname" >
                                                        <option value="">เลือกบริษัทผู้เอาประกันภัย</option>
                                                        <?php
                                                        $sql_seCompany = "{call megCompany_v2(?)}";
                                                        $params_seCompany = array(
                                                            array('select_company', SQLSRV_PARAM_IN)
                                                        );
                                                        $query_seCompany = sqlsrv_query($conn, $sql_seCompany, $params_seCompany);
                                                        while ($result_seCompany = sqlsrv_fetch_array($query_seCompany, SQLSRV_FETCH_ASSOC)) {
                                                            $selected1 = "";
                                                            if ($result_seVehicleinsured['INSUREDNAME'] == $result_seCompany['COMPANYCODE']) {
                                                                $selected1 = 'selected';
                                                            }
                                                            ?>
                                                            <option value="<?= $result_seCompany['COMPANYCODE'] ?>" <?= $selected1 ?>><?= $result_seCompany['THAINAME'] ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ชื่อนายหน้าประกันภัย</label>
                                                    <input class="form-control"  id="txt_insuredbroker" name="txt_insuredbroker" value="<?= $result_seVehicleinsured['BROKERNAME'] ?>">
                                                </div>

                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ชื่อบริษัทประกันภัย</label>
                                                    <input class="form-control"  id="txt_insuredcompany" name="txt_insuredcompany" value="<?= $result_seVehicleinsured['INSUREDCOMPANY'] ?>">

                                                </div>

                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>วันที่เริ่มคุ้มครอง</label>
                                                    <input class="form-control dateen" style="background-color: #f080802e"  readonly="" id="txt_startdatecover" name="txt_startdatecover" value="<?= $result_seVehicleinsured['STARTDATE'] ?>">
                                                </div>

                                            </div>

                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>วันที่สิ้นสุดความคุ้มครอง</label>
                                                    <input class="form-control dateen" style="background-color: #f080802e"  readonly=""  id="txt_enddatecover" name="txt_enddatecover" value="<?= $result_seVehicleinsured['EXPIREDDATE'] ?>">
                                                </div>

                                            </div>



                                        </div>

                                        <div class="row" >


                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>หมายเหตุ</label>
                                                    <textarea class="form-control" autocomplete="off" rows="3" id="txt_insuredremark" name="txt_insuredremark"><?= $result_seVehicleinsured['REMARK'] ?></textarea>
                                                </div>

                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>สถานะ</label>
                                                    <select  class="form-control" id="cb_insuredstatus" name="cb_insuredstatus" >
                                                        <option value="">เลือกสถานะ</option>
                                                        <?php
                                                        $selected = "SELECTED";

                                                        switch ($result_seVehicleinsured['ACTIVESTATUS']) {
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
                    if ($_GET['type'] == "maintenance") {
                        include '../pages/meg_cardata.php';
                        ?>

                        <div class="row">
                            <?php
                            if ($_GET['vehiclemaintenanceid'] != "") {
                                $condition1 = " AND a.VEHICLEINFOID = " . $_GET['vehicleinfoid'] . " AND a.VEHICLEMAINTENANCEID = " . $_GET['vehiclemaintenanceid'];
                                $sql_seVehiclemaintenance = "{call megVehiclemaintenance_v2(?,?)}";
                                $params_seVehiclemaintenance = array(
                                    array('select_vehiclemaintenance', SQLSRV_PARAM_IN),
                                    array($condition1, SQLSRV_PARAM_IN)
                                );
                                $query_seVehiclemaintenance = sqlsrv_query($conn, $sql_seVehiclemaintenance, $params_seVehiclemaintenance);
                                $result_seVehiclemaintenance = sqlsrv_fetch_array($query_seVehiclemaintenance, SQLSRV_FETCH_ASSOC);
                            }
                            ?>
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                        ข้อมูลการซ่อมบำรุง
                                    </div>
                                    <div class="panel-body">
                                        <div class="row" >
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>วันที่เริ่มซ่อม</label>
                                                    <input class="form-control dateen" style="background-color: #f080802e"  readonly=""  id="txt_maintenancedate" name="txt_maintenancedate" value="<?= $result_seVehiclemaintenance['MAINTENANCEDATE'] ?>">
                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>วันที่ซ่อมเสร็จ</label>
                                                    <input class="form-control dateen" style="background-color: #f080802e"  readonly=""  id="txt_maintenancecompletedate" name="txt_maintenancecompletedate" value="<?= $result_seVehiclemaintenance['COMPLETEDATE'] ?>" >
                                                </div>

                                            </div>



                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ราคา (บาท)</label>
                                                    <input class="form-control"  id="txt_maintenanceprice" name="txt_maintenanceprice" onKeyUp="if (isNaN(this.value)) {
                                                                alert('กรุณากรอกตัวเลข');
                                                                this.value = '';
                                                            }" value="<?= $result_seVehiclemaintenance['PRICE'] ?>"> 
                                                </div>

                                            </div>

                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ผู้ดำเนินการ</label>
                                                    <input class="form-control"  id="txt_maintenancewhoprocess" name="txt_maintenancewhoprocess" value="<?= $result_seVehiclemaintenance['WHOPROCESS'] ?>">
                                                </div>

                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>สถานะ</label>
                                                    <select  class="form-control" id="cb_maintenancestatus" name="cb_maintenancestatus">
                                                        <option value="">เลือกสถานะ</option>
                                                        <?php
                                                        $selected = "SELECTED";

                                                        switch ($result_seVehiclemaintenance['ACTIVESTATUS']) {
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
                                                    <font style="color: red">* </font><label>รายละเอียดการซ่อม</label>
                                                    <textarea class="form-control" autocomplete="off" rows="3" id="txt_maintenancedescription" name="txt_maintenancedescription"><?= $result_seVehiclemaintenance['MAINTENANCETYPE'] ?></textarea>
                                                </div>

                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>สถานที่</label>
                                                    <textarea class="form-control" autocomplete="off" rows="3" id="txt_maintenanceplace" name="txt_maintenanceplace"><?= $result_seVehiclemaintenance['PLACE'] ?></textarea>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row" >

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>หมายเหตุ</label>
                                                    <textarea class="form-control" autocomplete="off" rows="3" id="txt_maintenanceremark" name="txt_maintenanceremark"><?= $result_seVehiclemaintenance['REMARK'] ?></textarea>
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
                    if ($_GET['type'] == "repair") {
                        include '../pages/meg_cardata.php';
                        ?>


                        <div class="row">
                            <?php
                            if ($_GET['vehiclerepairid'] != "") {
                                $condition1 = " AND a.VEHICLEINFOID = " . $_GET['vehicleinfoid'] . " AND a.VEHICLEREPAIRID = " . $_GET['vehiclerepairid'];
                                $sql_seVehiclerepair = "{call megVehiclerepair_v2(?,?)}";
                                $params_seVehiclerepair = array(
                                    array('select_vehiclerepair', SQLSRV_PARAM_IN),
                                    array($condition1, SQLSRV_PARAM_IN)
                                );
                                $query_seVehiclerepair = sqlsrv_query($conn, $sql_seVehiclerepair, $params_seVehiclerepair);
                                $result_seVehiclerepair = sqlsrv_fetch_array($query_seVehiclerepair, SQLSRV_FETCH_ASSOC);
                            }
                            ?>
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                        ข้อมูลการซ่อมแซม
                                    </div>
                                    <div class="panel-body">
                                        <div class="row" >
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ประเภทการซ่อมแซม</label>

                                                    <select  class="form-control" id="cb_repairtypecode" name="cb_repairtypecode">
                                                        <option value="">เลือกประเภทการซ่อมแซม</option>
                                                        <?php
                                                        $sql_seVehiclerepairtype = "{call megVehiclerepairtype_v2(?,?)}";
                                                        $params_seVehiclerepairtype = array(
                                                            array('select_vehiclerepairtype', SQLSRV_PARAM_IN),
                                                            array('', SQLSRV_PARAM_IN)
                                                        );
                                                        $query_seVehiclerepairtype = sqlsrv_query($conn, $sql_seVehiclerepairtype, $params_seVehiclerepairtype);
                                                        while ($result_seVehiclerepairtype = sqlsrv_fetch_array($query_seVehiclerepairtype, SQLSRV_FETCH_ASSOC)) {
                                                            $selected = "";
                                                            if ($result_seVehiclerepair['REPAIRTYPECODE'] == $result_seVehiclerepairtype['REPAIRTYPECODE']) {
                                                                $selected = "selected";
                                                            }
                                                            ?>
                                                            <option value="<?= $result_seVehiclerepairtype['REPAIRTYPECODE'] ?>" <?= $selected ?>><?= $result_seVehiclerepairtype['REPAIRTYPEDESC'] ?></option>  
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ลำดับการซ่อมแซม</label>
                                                    <input class="form-control"  id="txt_repairnumber" name="txt_repairnumber" value="<?= $result_seVehiclerepair['GARAGEREPAIRNUMBER'] ?>">
                                                </div>

                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ชื่ออู่/ที่อยู่</label>
                                                    <input class="form-control"  id="txt_repairgaragename" name="txt_repairgaragename" value="<?= $result_seVehiclerepair['GARAGENAME'] ?>">
                                                </div>

                                            </div>

                                        </div>

                                        <div class="row" >

                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>วันที่เริ่มซ่อม</label>
                                                    <input class="form-control dateen" style="background-color: #f080802e"  readonly=""  id="txt_repairstartdate" name="txt_repairstartdate" value="<?= $result_seVehiclerepair['STARTDATE'] ?>"> 
                                                </div>

                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>วันที่กำหนดซ่อมเสร็จ</label>
                                                    <input class="form-control dateen" style="background-color: #f080802e"  readonly=""  id="txt_repairenddate" name="txt_repairenddate" value="<?= $result_seVehiclerepair['ENDDATE'] ?>">
                                                </div>

                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>วันที่ซ่อมเสร็จ</label>
                                                    <input class="form-control dateen"  id="txt_repairactualenddate" name="txt_repairactualenddate" value="<?= $result_seVehiclerepair['ACTUALENDDATE'] ?>">
                                                </div>

                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ราคา (บาท)</label>
                                                    <input class="form-control"  id="txt_repairtotalamount" name="txt_repairtotalamount" onKeyUp="if (isNaN(this.value)) {
                                                                alert('กรุณากรอกตัวเลข');
                                                                this.value = '';
                                                            }" value="<?= $result_seVehiclerepair['TOTALAMOUNT'] ?>">
                                                </div>


                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ผู้ดำเนินการ</label>
                                                    <input class="form-control"  id="txt_repairwhoprocess" name="txt_repairwhoprocess" value="<?= $result_seVehiclerepair['WHOPROCESS'] ?>">
                                                </div>

                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>สถานะ</label>
                                                    <select  class="form-control" id="cb_repairstatus" name="cb_repairstatus">
                                                        <option value="">เลือกสถานะ</option>
                                                        <?php
                                                        $selected = "SELECTED";

                                                        switch ($result_seVehiclerepair['ACTIVESTATUS']) {
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
                                                    <font style="color: red">* </font><label>สาเหตุ</label>
                                                    <textarea class="form-control" autocomplete="off" rows="3" id="txt_repairresson" name="txt_repairresson"><?= $result_seVehiclerepair['REASON'] ?></textarea>
                                                </div>

                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>รายละเอียดการซ่อมแซม</label>
                                                    <textarea class="form-control" autocomplete="off" rows="3" id="txt_repairdetail" name="txt_repairdetail"><?= $result_seVehiclerepair['REPAIRDETAIL'] ?></textarea>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row" >

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>หมายเหตุ</label>
                                                    <textarea class="form-control" autocomplete="off" rows="3" id="txt_repairremark" name="txt_repairremark"><?= $result_seVehiclerepair['REMARK'] ?></textarea>
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
                    if ($_GET['type'] == "tax") {
                        include '../pages/meg_cardata.php';

                        if ($_GET['vehicletaxid'] != "") {
                            $condition1 = " AND a.VEHICLEINFOID = " . $_GET['vehicleinfoid'] . " AND a.VEHICLETAXID = " . $_GET['vehicletaxid'];
                            $sql_seVehicletax = "{call megVehicletax_v2(?,?)}";
                            $params_seVehicletax = array(
                                array('select_vehicletax', SQLSRV_PARAM_IN),
                                array($condition1, SQLSRV_PARAM_IN)
                            );
                            $query_seVehicletax = sqlsrv_query($conn, $sql_seVehicletax, $params_seVehicletax);
                            $result_seVehicletax = sqlsrv_fetch_array($query_seVehicletax, SQLSRV_FETCH_ASSOC);
                        }
                        ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                        ข้อมูลการเสียภาษี
                                    </div>
                                    <div class="panel-body">
                                        <div class="row" >
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>วันที่เริ่มเสียภาษี</label>
                                                    <input class="form-control dateen" style="background-color: #f080802e"  readonly=""  id="txt_taxdate" name="txt_taxdate" value="<?= $result_seVehicletax['TAXDATE'] ?>">
                                                </div>

                                            </div>

                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>วันที่หมดอายุ</label>
                                                    <input class="form-control dateen" style="background-color: #f080802e"  readonly="" id="txt_taxexpiredate" name="txt_taxexpiredate" value="<?= $result_seVehicletax['EXPIREDDATE'] ?>">
                                                </div>

                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ราคา (ราคา)</label>
                                                    <input class="form-control"  id="txt_taxprice" name="txt_taxprice" onKeyUp="if (isNaN(this.value)) {
                                                                alert('กรุณากรอกตัวเลข');
                                                                this.value = '';
                                                            }" value="<?= $result_seVehicletax['PRICE'] ?>">
                                                </div>

                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ค่าธรรมเนียม</label>
                                                    <input class="form-control"  id="txt_taxservicefee" name="txt_taxservicefee" onKeyUp="if (isNaN(this.value)) {
                                                                alert('กรุณากรอกตัวเลข');
                                                                this.value = '';
                                                            }" value="<?= $result_seVehicletax['SERVICEFEE'] ?>">
                                                </div>

                                            </div>

                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ผู้ดำเนินการ</label>
                                                    <input class="form-control"  id="txt_taxwhoprocess" name="txt_taxwhoprocess" value="<?= $result_seVehicletax['WHOPROCESS'] ?>" >
                                                </div>

                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>สถานะ</label>
                                                    <select  class="form-control" id="cb_taxstatus" name="cb_taxstatus">
                                                        <option value="">เลือกสถานะ</option>
                                                        <?php
                                                        $selected = "SELECTED";

                                                        switch ($result_seVehicletax['ACTIVESTATUS']) {
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
                                                    <font style="color: red">* </font><label>สถานที่</label>
                                                    <textarea class="form-control" autocomplete="off" rows="3" id="txt_taxplace" name="txt_taxplace"><?= $result_seVehicletax['PLACE'] ?></textarea>
                                                </div>

                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>หมายเหตุ</label>
                                                    <textarea class="form-control" autocomplete="off" rows="3" id="txt_taxremark" name="txt_taxremark"><?= $result_seVehicletax['REMARK'] ?></textarea>
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
                    if ($_GET['type'] == "owner") {
                        include '../pages/meg_cardata.php';

                        if ($_GET['vehicleownerid'] != "") {
                            $condition1 = " AND a.VEHICLEINFOID = " . $_GET['vehicleinfoid'] . " AND a.VEHICLETRUCKOWNERID = " . $_GET['vehicleownerid'];
                            $sql_seVehicleowner = "{call megVehicleowner_v2(?,?)}";
                            $params_seVehicleowner = array(
                                array('select_vehicleowner', SQLSRV_PARAM_IN),
                                array($condition1, SQLSRV_PARAM_IN)
                            );
                            $query_seVehicleowner = sqlsrv_query($conn, $sql_seVehicleowner, $params_seVehicleowner);
                            $result_seVehicleowner = sqlsrv_fetch_array($query_seVehicleowner, SQLSRV_FETCH_ASSOC);
                        }
                        ?>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                        ข้อมูลผู้ขับขี่
                                    </div>
                                    <div class="panel-body">
                                        <div class="row" >
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>บริษัทเจ้าของรถ</label>
                                                    <input id="txt_vehicleownerid" style="display: none" name="txt_vehicleownerid" value="<?= $_GET['vehicleownerid'] ?>" >
                                                    <select  class="form-control" id="cb_ownercompany" name="cb_ownercompany">
                                                        <option value="">เลือกบริษัทเจ้าของรถ</option>
                                                        <?php
                                                        $sql_seCompany = "{call megCompany_v2(?)}";
                                                        $params_seCompany = array(
                                                            array('select_company', SQLSRV_PARAM_IN)
                                                        );
                                                        $query_seCompany = sqlsrv_query($conn, $sql_seCompany, $params_seCompany);
                                                        while ($result_seCompany = sqlsrv_fetch_array($query_seCompany, SQLSRV_FETCH_ASSOC)) {
                                                            $selected1 = "";
                                                            if ($result_seVehicleowner['OWNERCOMPANYCODE'] == $result_seCompany['COMPANYCODE']) {
                                                                $selected1 = 'selected';
                                                            }
                                                            ?>
                                                            <option value="<?= $result_seCompany['COMPANYCODE'] ?>" <?= $selected1 ?>><?= $result_seCompany['THAINAME'] ?></option>
                                                            <?php
                                                        }
                                                        ?>

                                                    </select>
                                                </div>

                                            </div>

                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>บริษัทที่ใช้รถ</label>

                                                    <select  class="form-control" id="cb_ownerprocesscompany" name="cb_ownerprocesscompany">
                                                        <option value="">เลือกบริษัทที่ใช้รถ</option>
                                                        <?php
                                                        $sql_seCompany1 = "{call megCompany_v2(?)}";
                                                        $params_seCompany1 = array(
                                                            array('select_company', SQLSRV_PARAM_IN)
                                                        );
                                                        $query_seCompany1 = sqlsrv_query($conn, $sql_seCompany1, $params_seCompany1);
                                                        while ($result_seCompany1 = sqlsrv_fetch_array($query_seCompany1, SQLSRV_FETCH_ASSOC)) {
                                                            $selected2 = "";
                                                            if ($result_seVehicleowner['POSSESSCOMPANYCODE'] == $result_seCompany1['COMPANYCODE']) {
                                                                $selected2 = 'selected';
                                                            }
                                                            ?>
                                                            <option value="<?= $result_seCompany1['COMPANYCODE'] ?>" <?= $selected2 ?>><?= $result_seCompany1['THAINAME'] ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>สถานะ</label>
                                                    <select  class="form-control" id="cb_ownerstatus" name="cb_ownerstatus">
                                                        <option value="">เลือกสถานะ</option>
                                                        <?php
                                                        $selected = "SELECTED";

                                                        switch ($result_seVehicleowner['ACTIVESTATUS']) {
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
                                                    <font style="color: red">* </font><label>ใช้ในสายงาน</label>
                                                    <textarea class="form-control" autocomplete="off" rows="3" id="txt_ownerproject" name="txt_ownerproject"><?= $result_seVehicleowner['PROJECTTOUSE'] ?></textarea>
                                                </div>

                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>หมายเหตุ</label>
                                                    <textarea class="form-control" autocomplete="off" rows="3" id="txt_ownerremark" name="txt_ownerremark"><?= $result_seVehicleowner['REMARK'] ?></textarea>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row" >
                                            <div id="dirverdef1">
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <font style="color: red">* </font><label>ผู้ขับขี่คนแรก</label>
                                                        <?php
                                                        //if ($_GET['meg'] != 'add') {
                                                        ?>
                                                         <!--   <input class="form-control" readonly="" style="background-color: #f080802e"  id="txt_owerfristdirver" name="txt_owerfristdirver" value="<?//= $result_seVehicleowner['FIRSTDRIVER'] ?>" >-->
                                                        <?php
                                                        //} else {
                                                        ?>
                                                        <input class="form-control"  id="txt_owerfristdirver" name="txt_owerfristdirver" value="<?= $result_seVehicleowner['FIRSTDRIVER'] ?>" >
                                                        <?php
                                                        // }
                                                        ?>

                                                    </div>

                                                </div>
                                                <!--<div class="col-lg-1">
                                                    <div class="form-group">
                                                        <label>แก้ไข</label><br>
                                                        <a href="#" onclick="edit_dirver1(document.getElementById('txt_owerfristdirver').value)" title="แก้ไขข้อมูล" type="button" class="btn btn-default  btn-circle"><span class="glyphicon glyphicon-wrench"></span></a>
                                                    </div>

                                                </div>-->
                                            </div>
                                            <div id="dirveredit1"></div>
                                            <div id="dirverdef2">
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <font style="color: red">* </font><label>ผู้ขับขี่คนที่สอง</label>
                                                        <?php
                                                        // if ($_GET['meg'] != 'add') {
                                                        ?>
                                                        <!--    <input class="form-control" readonly="" style="background-color: #f080802e"  id="txt_ownerseconddirver" name="txt_ownerseconddirver" value="<?//= $result_seVehicleowner['SECONDDRIVER'] ?>" >-->
                                                        <?php
                                                        // } else {
                                                        ?>
                                                        <input class="form-control"  id="txt_ownerseconddirver" name="txt_ownerseconddirver" value="<?= $result_seVehicleowner['SECONDDRIVER'] ?>" >
                                                        <?php
                                                        //}
                                                        ?>
                                                    </div>

                                                </div>
                                                <!--<div class="col-lg-1">
                                                    <div class="form-group">
                                                        <label>แก้ไข</label><br>
                                                        <a href="#" onclick="edit_dirver2(document.getElementById('txt_ownerseconddirver').value)" title="แก้ไขข้อมูล" type="button" class="btn btn-default  btn-circle"><span class="glyphicon glyphicon-wrench"></span></a>
                                                    </div>

                                                </div>-->
                                            </div>
                                            <div id="dirveredit2"></div>
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
                    if ($_GET['type'] == "purchase") {
                        include '../pages/meg_cardata.php';
                        if ($_GET['vehiclepurchaseid'] != "") {
                            $condition1 = " AND a.VEHICLEINFOID = " . $_GET['vehicleinfoid'] . " AND a.VEHICLEPURCHASEID = " . $_GET['vehiclepurchaseid'];
                            $sql_seVehiclepurchase = "{call megVehiclepurchase_v2(?,?)}";
                            $params_seVehiclepurchase = array(
                                array('select_vehiclepurchase', SQLSRV_PARAM_IN),
                                array($condition1, SQLSRV_PARAM_IN)
                            );
                            $query_seVehiclepurchase = sqlsrv_query($conn, $sql_seVehiclepurchase, $params_seVehiclepurchase);
                            $result_seVehiclepurchase = sqlsrv_fetch_array($query_seVehiclepurchase, SQLSRV_FETCH_ASSOC);
                        }
                        ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                        ข้อมูลการจัดซื้อ
                                    </div>
                                    <div class="panel-body">
                                        <div class="row" >
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ชื่อผู้ประกอบการ</label>
                                                    <select  class="form-control" id="cb_purchasesuppliercode" name="cb_purchasesuppliercode">
                                                        <option value="">เลือกชื่อผู้ประกอบการ</option>
                                                        <?php
                                                        $sql_seSupplier = "{call megSupplier_v2(?)}";
                                                        $params_seSupplier = array(
                                                            array('select_supplier', SQLSRV_PARAM_IN)
                                                        );
                                                        $query_seSupplier = sqlsrv_query($conn, $sql_seSupplier, $params_seSupplier);
                                                        while ($result_seSupplier = sqlsrv_fetch_array($query_seSupplier, SQLSRV_FETCH_ASSOC)) {
                                                            $selected1 = "";
                                                            if ($result_seVehiclepurchase['SUPPLIERCODE'] == $result_seSupplier['SUPPLIERCODE']) {
                                                                $selected1 = 'selected';
                                                            }
                                                            ?>
                                                            <option value="<?= $result_seSupplier['SUPPLIERCODE'] ?>" <?= $selected1 ?>><?= $result_seSupplier['THAINAME'] ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>

                                                </div>

                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ชื่อผู้เช่า</label>
                                                    <input class="form-control"   id="txt_purchaseleasingname" name="txt_purchaseleasingname" value="<?= $result_seVehiclepurchase['LEASINGNAME'] ?>" >
                                                </div>

                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>วันที่สั่งซื้อ</label>
                                                    <input class="form-control dateen" style="background-color: #f080802e"  readonly=""  id="txt_purchasedate" name="txt_purchasedate" value="<?= $result_seVehiclepurchase['PURCHASEDATE'] ?>">
                                                </div>

                                            </div>



                                        </div>
                                        <div class="row" >

                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ราคา (บาท)</label>
                                                    <input class="form-control"  id="txt_purchaseprice" name="txt_purchaseprice" onKeyUp="if (isNaN(this.value)) {
                                                                alert('กรุณากรอกตัวเลข');
                                                                this.value = '';
                                                            }" value="<?= $result_seVehiclepurchase['PEICE'] ?>">
                                                </div>

                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ดอกเบี้ย (%)</label>
                                                    <input class="form-control"  id="txt_purchaseinterestrate" name="txt_purchaseinterestrate" value="<?= $result_seVehiclepurchase['INTERESTRATE'] ?>">
                                                </div>


                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>เวลาชำระเงิน</label>
                                                    <input class="form-control"  id="txt_purchasepaymenttime" name="txt_purchasepaymenttime" value="<?= $result_seVehiclepurchase['PAYMENTTIMES'] ?>">
                                                </div>

                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>วันที่ (ชำระเงินครังแรก)</label>
                                                    <input class="form-control dateen" style="background-color: #f080802e"  readonly=""  id="txt_purchasefirstpaymentdate" name="txt_purchasefirstpaymentdate" value="<?= $result_seVehiclepurchase['FIRSTPAYMENTDATE'] ?>">
                                                </div>

                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>วันที่ (ชำระเงินครังสุดท้าย)</label>
                                                    <input class="form-control dateen" style="background-color: #f080802e"  readonly=""  id="txt_purchaselastpaymentdate" name="txt_purchaselastpaymentdate" value="<?= $result_seVehiclepurchase['LASTPAYMENTDATE'] ?>">
                                                </div>

                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>สถานะ</label>
                                                    <select  class="form-control" id="txt_purchasestatus" name="txt_purchasestatus">
                                                        <option value="">เลือกสถานะ</option>
                                                        <?php
                                                        $selected = "SELECTED";

                                                        switch ($result_seVehiclepurchase['ACTIVESTATUS']) {
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
                                                    <textarea class="form-control" autocomplete="off" rows="3" id="txt_purchaseremark" name="txt_purchaseremark"><?= $result_seVehiclepurchase['REMARK'] ?></textarea>
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
                                            <div class="col-lg-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <ul class="nav nav-pills">
                                                            <li class="active"><a href="#header-car" data-toggle="tab" aria-expanded="true">หัวรถ</a>
                                                            </li>
                                                            <li class=""><a href="#structure-car" data-toggle="tab" aria-expanded="false">โครงสร้าง</a>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                    <!-- /.panel-heading -->
                                                    <div class="panel-body">
                                                        <!-- Nav tabs -->


                                                        <!-- Tab panes -->
                                                        <div class="tab-content">
                                                            <div class="tab-pane fade active in" id="header-car">

                                                                <div class="row" >
                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <font style="color: red">* </font><label>ด้านหน้า</label>
                                                                            <div class="form-group">
                                                                                <input type="file" id="image_front" name="image_front" class="file" >
                                                                                <div class="input-group col-xs-12">
                                                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                                                                                    <input type="text" name="file_front" id="file_front" class="form-control input-lg" readonly=""  placeholder="Upload Image" value="<?= $result_seVehicleattribute['HEAD_FRONTIMAGE'] ?>">
                                                                                    <span class="input-group-btn">
                                                                                        <button class="browse btn btn-primary input-lg" type="button"><i class="glyphicon glyphicon-search"></i> Browse</button>
                                                                                    </span>
                                                                                </div>
                                                                                <iframe name="up_iframe" width="0" height="0" frameborder="0"></iframe>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-1 " style="width: 80px;">
                                                                        <div class="form-group" >
                                                                            <label>&emsp;&emsp;</label>
                                                                            <?php
                                                                            if ($result_seVehicleattribute['HEAD_FRONTIMAGE'] != "") {
                                                                                ?>
                                                                                <a  href="#" title="ขยายรูปภาพ"><img class="thumbnail img-responsive"  src="../image_vehicleattribute/<?= $result_seVehicleattribute['HEAD_FRONTIMAGE'] ?>">
                                                                                </a>
                                                                                <?php
                                                                            }
                                                                            ?>
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
                                                                            <input class="form-control"  id="front_width" name="front_width"  value="<?= $result_seVehicleattribute['HEAD_FRONTWIDTH'] ?>" >
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <div class="form-group">
                                                                            <font style="color: red">* </font><label>ยาว</label>
                                                                            <input class="form-control"  id="front_long" name="front_long" value="<?= $result_seVehicleattribute['HEAD_FRONTWIDTH'] ?>" >
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <div class="form-group">
                                                                            <font style="color: red">* </font><label>สูง</label>
                                                                            <input class="form-control"  id="front_high" name="front_high"  value="<?= $result_seVehicleattribute['HEAD_FRONTWIDTH'] ?>" >
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                                <div class="row" >
                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <font style="color: red">* </font><label>ด้านข้าง</label>
                                                                            <div class="form-group">
                                                                                <input type="file" id="image_side" name="image_side"  class="file" >
                                                                                <div class="input-group col-xs-12">
                                                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                                                                                    <input type="text" class="form-control input-lg" id="file_side" name="file_side" disabled placeholder="Upload Image" value="<?= $result_seVehicleattribute['HEAD_SIDEIMAGE'] ?>">
                                                                                    <span class="input-group-btn">
                                                                                        <button class="browse btn btn-primary input-lg" type="button"><i class="glyphicon glyphicon-search"></i> Browse</button>
                                                                                    </span>
                                                                                </div>
                                                                            </div>

                                                                        </div>

                                                                    </div>
                                                                    <div class="col-lg-1 " style="width: 80px;">
                                                                        <div class="form-group">
                                                                            <label>&emsp;&emsp;</label>
                                                                            <?php
                                                                            if ($result_seVehicleattribute['HEAD_SIDEIMAGE'] != "") {
                                                                                ?>
                                                                                <a  href="#" title="ขยายรูปภาพ"><img class="thumbnail img-responsive" src="../image_vehicleattribute/<?= $result_seVehicleattribute['HEAD_SIDEIMAGE'] ?>" >
                                                                                </a>
                                                                                <?php
                                                                            }
                                                                            ?>
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
                                                                            <input class="form-control" id="side_width"  name="side_width"  value="<?= $result_seVehicleattribute['HEAD_SIDEWIDTH'] ?>" >
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <div class="form-group">
                                                                            <font style="color: red">* </font><label>ยาว</label>
                                                                            <input class="form-control" id="side_long" name="side_long"   value="<?= $result_seVehicleattribute['HEAD_SIDELONG'] ?>" >
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <div class="form-group">
                                                                            <font style="color: red">* </font><label>สูง</label>
                                                                            <input class="form-control" id="side_high" name="side_high"  value="<?= $result_seVehicleattribute['HEAD_SIDEHIGH'] ?>" >
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                                <div class="row" >
                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <font style="color: red">* </font><label>ด้านหลัง</label>
                                                                            <div class="form-group">
                                                                                <input   class="file" type="file" id="image_back" name="image_back">
                                                                                <div class="input-group col-xs-12">
                                                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                                                                                    <input type="text" class="form-control input-lg"  id="file_back" name="file_back" disabled placeholder="Upload Image" value="<?= $result_seVehicleattribute['HEAD_BACKIMAGE'] ?>">
                                                                                    <span class="input-group-btn">
                                                                                        <button class="browse btn btn-primary input-lg" type="button"><i class="glyphicon glyphicon-search"></i> Browse</button>
                                                                                    </span>
                                                                                </div>
                                                                            </div>

                                                                        </div>

                                                                    </div>
                                                                    <div class="col-lg-1 " style="width: 80px;">
                                                                        <div class="form-group">
                                                                            <label>&emsp;&emsp;</label>
                                                                            <?php
                                                                            if ($result_seVehicleattribute['HEAD_BACKIMAGE'] != "") {
                                                                                ?>
                                                                                <a  href="#" title="ขยายรูปภาพ"><img class="thumbnail img-responsive" src="../image_vehicleattribute/<?= $result_seVehicleattribute['HEAD_BACKIMAGE'] ?>" >
                                                                                </a>
                                                                                <?php
                                                                            }
                                                                            ?>
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
                                                                            <input class="form-control" id="back_width" name="back_width"   value="<?= $result_seVehicleattribute['HEAD_BACKWIDTH'] ?>" >
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <div class="form-group">
                                                                            <font style="color: red">* </font><label>ยาว</label>
                                                                            <input class="form-control" id="back_long" name="back_long"   value="<?= $result_seVehicleattribute['HEAD_BACKTLONG'] ?>" >
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <div class="form-group">
                                                                            <font style="color: red">* </font><label>สูง</label>
                                                                            <input class="form-control" id="back_high" name="back_high"   value="<?= $result_seVehicleattribute['HEAD_BACKTHIGH'] ?>" >
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                                <div class="row" >
                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <font style="color: red">* </font><label>ด้านใน</label>
                                                                            <div class="form-group">
                                                                                <input  class="file" type="file" id="image_in" name="image_in">
                                                                                <div class="input-group col-xs-12">
                                                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                                                                                    <input type="text" id="file_in" name="file_in" class="form-control input-lg" disabled placeholder="Upload Image" value="<?= $result_seVehicleattribute['HEAD_INIMAGE'] ?>">
                                                                                    <span class="input-group-btn">
                                                                                        <button class="browse btn btn-primary input-lg" type="button"><i class="glyphicon glyphicon-search"></i> Browse</button>
                                                                                    </span>
                                                                                </div>
                                                                            </div>

                                                                        </div>

                                                                    </div>
                                                                    <div class="col-lg-1 " style="width: 80px;">
                                                                        <div class="form-group">
                                                                            <label>&emsp;&emsp;</label>
                                                                            <?php
                                                                            if ($result_seVehicleattribute['HEAD_INIMAGE'] != "") {
                                                                                ?>
                                                                                <a  href="#" title="ขยายรูปภาพ"><img class="thumbnail img-responsive" src="../image_vehicleattribute/<?= $result_seVehicleattribute['HEAD_INIMAGE'] ?>" >
                                                                                </a>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade" id="structure-car">

                                                                <div class="row" >
                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <font style="color: red">* </font><label>ด้านหน้า</label>
                                                                            <div class="form-group">
                                                                                <input type="file" id="struc_image_front" name="struc_image_front" class="file" >
                                                                                <div class="input-group col-xs-12">
                                                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                                                                                    <input type="text" name="struc_file_front" id="struc_file_front" class="form-control input-lg" readonly=""  placeholder="Upload Image" value="<?= $result_seVehicleattribute['STRUC_FRONTIMAGE'] ?>">
                                                                                    <span class="input-group-btn">
                                                                                        <button class="browse btn btn-primary input-lg" type="button"><i class="glyphicon glyphicon-search"></i> Browse</button>
                                                                                    </span>
                                                                                </div>
                                                                                <iframe name="up_iframe" width="0" height="0" frameborder="0"></iframe>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-1 " style="width: 80px;">
                                                                        <div class="form-group" >
                                                                            <label>&emsp;&emsp;</label>
                                                                            <?php
                                                                            if ($result_seVehicleattribute['STRUC_FRONTIMAGE'] != "") {
                                                                                ?>
                                                                                <a  href="#" title="ขยายรูปภาพ"><img class="thumbnail img-responsive"  src="../image_vehicleattribute/<?= $result_seVehicleattribute['STRUC_FRONTIMAGE'] ?>">
                                                                                </a>
                                                                                <?php
                                                                            }
                                                                            ?>

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
                                                                            <input class="form-control"  id="struc_front_width" name="struc_front_width"  value="<?= $result_seVehicleattribute['STRUC_FRONTWIDTH'] ?>" >
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <div class="form-group">
                                                                            <font style="color: red">* </font><label>ยาว</label>
                                                                            <input class="form-control"  id="struc_front_long" name="struc_front_long" value="<?= $result_seVehicleattribute['STRUC_FRONTLONG'] ?>" >
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <div class="form-group">
                                                                            <font style="color: red">* </font><label>สูง</label>
                                                                            <input class="form-control"  id="struc_front_high" name="struc_front_high"  value="<?= $result_seVehicleattribute['STRUC_FRONTHIGH'] ?>" >
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                                <div class="row" >
                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <font style="color: red">* </font><label>ด้านข้าง</label>
                                                                            <div class="form-group">
                                                                                <input type="file" id="struc_image_side" name="struc_image_side"  class="file" >
                                                                                <div class="input-group col-xs-12">
                                                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                                                                                    <input type="text" class="form-control input-lg" id="struc_file_side" name="struc_file_side" disabled placeholder="Upload Image" value="<?= $result_seVehicleattribute['STRUC_SIDEIMAGE'] ?>">
                                                                                    <span class="input-group-btn">
                                                                                        <button class="browse btn btn-primary input-lg" type="button"><i class="glyphicon glyphicon-search"></i> Browse</button>
                                                                                    </span>
                                                                                </div>
                                                                            </div>

                                                                        </div>

                                                                    </div>
                                                                    <div class="col-lg-1 " style="width: 80px;">
                                                                        <div class="form-group">
                                                                            <label>&emsp;&emsp;</label>
                                                                            <?php
                                                                            if ($result_seVehicleattribute['STRUC_SIDEIMAGE'] != "") {
                                                                                ?>
                                                                                <a  href="#" title="ขยายรูปภาพ"><img class="thumbnail img-responsive" src="../image_vehicleattribute/<?= $result_seVehicleattribute['STRUC_SIDEIMAGE'] ?>" >
                                                                                </a>
                                                                                <?php
                                                                            }
                                                                            ?>
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
                                                                            <input class="form-control" id="struc_side_width"  name="struc_side_width"  value="<?= $result_seVehicleattribute['STRUC_SIDEWIDTH'] ?>" >
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <div class="form-group">
                                                                            <font style="color: red">* </font><label>ยาว</label>
                                                                            <input class="form-control" id="struc_side_long" name="struc_side_long"   value="<?= $result_seVehicleattribute['STRUC_SIDELONG'] ?>" >
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <div class="form-group">
                                                                            <font style="color: red">* </font><label>สูง</label>
                                                                            <input class="form-control" id="struc_side_high" name="struc_side_high"  value="<?= $result_seVehicleattribute['STRUC_SIDEHIGH'] ?>" >
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                                <div class="row" >
                                                                    <div class="col-lg-4">
                                                                        <div class="form-group">
                                                                            <font style="color: red">* </font><label>ด้านหลัง</label>
                                                                            <div class="form-group">
                                                                                <input   class="file" type="file" id="struc_image_back" name="struc_image_back">
                                                                                <div class="input-group col-xs-12">
                                                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                                                                                    <input type="text" class="form-control input-lg"  id="struc_file_back" name="struc_file_back" disabled placeholder="Upload Image" value="<?= $result_seVehicleattribute['STRUC_BACKIMAGE'] ?>">
                                                                                    <span class="input-group-btn">
                                                                                        <button class="browse btn btn-primary input-lg" type="button"><i class="glyphicon glyphicon-search"></i> Browse</button>
                                                                                    </span>
                                                                                </div>
                                                                            </div>

                                                                        </div>

                                                                    </div>
                                                                    <div class="col-lg-1 " style="width: 80px;">
                                                                        <div class="form-group">
                                                                            <label>&emsp;&emsp;</label>
                                                                            <?php
                                                                            if ($result_seVehicleattribute['STRUC_BACKIMAGE'] != "") {
                                                                                ?>
                                                                                <a  href="#" title="ขยายรูปภาพ"><img class="thumbnail img-responsive" src="../image_vehicleattribute/<?= $result_seVehicleattribute['STRUC_BACKIMAGE'] ?>" >
                                                                                </a>
                                                                                <?php
                                                                            }
                                                                            ?>
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
                                                                            <input class="form-control" id="struc_back_width" name="struc_back_width"   value="<?= $result_seVehicleattribute['STRUC_BACKWIDTH'] ?>" >
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <div class="form-group">
                                                                            <font style="color: red">* </font><label>ยาว</label>
                                                                            <input class="form-control" id="struc_back_long" name="struc_back_long"   value="<?= $result_seVehicleattribute['STRUC_BACKTLONG'] ?>" >
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <div class="form-group">
                                                                            <font style="color: red">* </font><label>สูง</label>
                                                                            <input class="form-control" id="struc_back_high" name="struc_back_high"   value="<?= $result_seVehicleattribute['STRUC_BACKTHIGH'] ?>" >
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <!-- /.panel-body -->
                                                </div>
                                                <!-- /.panel -->
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

                            if ($_GET['type'] == "infoamata") {
                                ?>
                                <input type="button" onclick="save_vehicleinfo(<?= $_GET['vehicleinfoid'] ?>);" name="btnSend" id="btnSend" value="<?= $buttonname ?>" class="btn btn-primary">
                                <?php
                            }
                            if ($_GET['type'] == "infogetway") {
                                ?>
                                <input type="button" onclick="save_vehicleinfo(<?= $_GET['vehicleinfoid'] ?>);" name="btnSend" id="btnSend" value="<?= $buttonname ?>" class="btn btn-primary">
                                <?php
                            }

                            if ($_GET['type'] == "history") {
                                ?>
                                <input type="button" onclick="save_vehiclechangehistory('<?= $_GET['vehiclechangehistoryid'] ?>');" name="btnSend" id="btnSend" value="<?= $buttonname ?>" class="btn btn-primary">
                                <?php
                            }

                            if ($_GET['type'] == "insured") {
                                ?>
                                <input type="button" onclick="save_vehicleinsured('<?= $_GET['vehicleinsuredid'] ?>');" name="btnSend" id="btnSend" value="<?= $buttonname ?>" class="btn btn-primary">
                                <?php
                            }
                            if ($_GET['type'] == "maintenance") {
                                ?>
                                <input type="button" onclick="save_vehiclemaintenance(<?= $_GET['vehiclemaintenanceid'] ?>);" name="btnSend" id="btnSend" value="<?= $buttonname ?>" class="btn btn-primary">
                                <?php
                            }
                            if ($_GET['type'] == "repair") {
                                ?>
                                <input type="button" onclick="save_vehiclerepair('<?= $_GET['vehiclerepairid'] ?>');" name="btnSend" id="btnSend" value="<?= $buttonname ?>" class="btn btn-primary">
                                <?php
                            }
                            if ($_GET['type'] == "tax") {
                                ?>
                                <input type="button" onclick="save_vehicletax('<?= $_GET['vehicletaxid'] ?>');" name="btnSend" id="btnSend" value="<?= $buttonname ?>" class="btn btn-primary">
                                <?php
                            }
                            if ($_GET['type'] == "owner") {
                                ?>
                                <input type="button" onclick="save_vehicleowner('<?= $_GET['vehicleownerid'] ?>');" name="btnSend" id="btnSend" value="<?= $buttonname ?>" class="btn btn-primary">
                                <?php
                            }
                            if ($_GET['type'] == "purchase") {
                                ?>
                                <input type="button" onclick="save_vehiclepurchase('<?= $_GET['vehiclepurchaseid'] ?>');" name="btnSend" id="btnSend" value="<?= $buttonname ?>" class="btn btn-primary">
                                <?php
                            }
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
                    <!--<div class="row">

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

                                <button type="button" class="btn btn-default" onclick="select_stopwork();">ค้นหา <li class="fa fa-search"></li></button>&emsp;<button type="button" onclick="excel_stopwork()" class="btn btn-default">Excel <li class="fa fa-file-excel-o"></li></button>
                            </div>

                        </div>

                    </div>   -->
                    <?php
                    if ($_GET['type'] == "infoamata") {
                        ?>
                        <div class="row" >
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                        <font style="font-size: 16px"><b>รายการข้อมูลรถ</b></font>                            
                                    </div>
                                    <div class="panel-body">
                                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                            <div class="row">


                                                <div class="col-sm-12">
                                                    <div id="datade">
                                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>&nbsp;</th>
                                                                    <th>&nbsp;</th>
                                                                    <th>เลขทะเบียนรถ</th>
                                                                    <th>กลุ่มรถ</th>
                                                                    <th>ประเภทรถ</th>
                                                                    <th>ยี่ห้อรถ</th>
                                                                    <th>ประเภทเกียร์รถ</th>
                                                                    <th>สีรถ</th>
                                                                    <th>ซีรีส์/รุ่น</th>
                                                                    <th>ชื่อรถ (ไทย)</th>
                                                                    <th>ชื่อรถ (อังกฤษ)</th>
                                                                    <th>แรงม้า</th>
                                                                    <th>CC</th>
                                                                    <th>เลขเครื่องยนต์</th>
                                                                    <th>เลขตัวถัง</th>
                                                                    <th>ประเภทพลังงาน</th>
                                                                    <th>น้ำหนักรถ (กิโลกรัม)</th>
                                                                    <th>ประเภทเพลา</th>
                                                                    <th>ลูกสูบ</th>
                                                                    <th>น้ำหนักบรรทุกสูงสุด</th>
                                                                    <th>วันที่เพิ่มข้อมูล</th>
                                                                    <th>การใช้งาน (ปี)</th>

                                                                    <th>ซื้อรถที่ใหน</th>
                                                                    <th>วันที่ซื้อ</th>
                                                                    <th>ราคารถ</th>
                                                                    <th>เงื่อนไขการซื้อ</th>
                                                                    <th>ต่อโครงสร้างที่ใหน</th>
                                                                    <th>วันที่ต่อโครงสร้าง</th>
                                                                    <th>ราคา</th>
                                                                    <th>วันที่จดทะเบียนครั้งแรก</th>
                                                                    <th>อุปกรณ์เฉพาะ</th>


                                                                    <th>สถานะ</th>
                                                                    <th>หมายเหตุ</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                <?php
                                                                if ($_GET['vehicleinfoid'] != "") {
                                                                    ?>
                                                                    <tr class="odd gradeX">
                                                                        <td style="text-align: center">
                                                                            <button onclick="delete_vehicleinfo(<?= $result_info['VEHICLEINFOID'] ?>);" title="ลบข้อมูล" type="button" class="list-group-item"><span class="glyphicon glyphicon-remove"></span></button>
                                                                        </td>
                                                                        <td style="text-align: center">
                                                                            <a href='meg_carinfo.php?type=<?= $_GET['type'] ?>&vehicleinfoid=<?= $result_info['VEHICLEINFOID'] ?>&meg=edit' class='list-group-item'><span class="glyphicon glyphicon-wrench"></span></a>
                                                                        </td>
                                                                        <td><?= $result_info['VEHICLEREGISNUMBER'] ?></td>
                                                                        <td><?= $result_info['VEHICLEGROUPDESC'] ?></td>
                                                                        <td><?= $result_info['VEHICLETYPECODE'] ?></td>
                                                                        <td><?= $result_info['BRANDDESC'] ?></td>
                                                                        <td><?= $result_info['GEARTYPEDESC'] ?></td>
                                                                        <td><?= $result_info['COLORDESC'] ?></td>
                                                                        <td><?= $result_info['SERIES'] ?></td>
                                                                        <td><?= $result_info['THAINAME'] ?></td>
                                                                        <td><?= $result_info['ENGNAME'] ?></td>
                                                                        <td><?= $result_info['HORSEPOWER'] ?></td>
                                                                        <td><?= $result_info['CC'] ?></td>
                                                                        <td><?= $result_info['MACHINENUMBER'] ?></td>
                                                                        <td><?= $result_info['CHASSISNUMBER'] ?></td>
                                                                        <td><?= $result_info['ENERGY'] ?></td>
                                                                        <td><?= $result_info['WEIGHT'] ?></td>
                                                                        <td><?= $result_info['AXLETYPE'] ?></td>
                                                                        <td><?= $result_info['PISTON'] ?></td>
                                                                        <td><?= $result_info['MAXIMUMLOAD'] ?></td>
                                                                        <td><?= $result_info['DATEOFREGISTRATION'] ?></td>
                                                                        <td><?= $result_info['USED'] ?></td>


                                                                        <td><?= $result_info['VEHICLEBUYWHERE'] ?></td>
                                                                        <td><?= $result_info['VEHICLEBUYDATE'] ?></td>
                                                                        <td><?= $result_info['VEHICLEBUYPRICE'] ?></td>
                                                                        <td><?= $result_info['VEHICLEBUYCONDITION'] ?></td>
                                                                        <td><?= $result_info['VEHICLESTRUCTUREWHERE'] ?></td>
                                                                        <td><?= $result_info['VEHICLESTRUCTUREDATE'] ?></td>
                                                                        <td><?= $result_info['VEHICLESTRUCTUREPRICE'] ?></td>
                                                                        <td><?= $result_info['VEHICLEREGISTERDATE'] ?></td>
                                                                        <td><?= $result_info['VEHICLESPECIAL'] ?></td>



                                                                        <td><?php echo ($result_info['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>
                                                                        <td><?= $result_info['REMARK'] ?></td>



                                                                    </tr>
                                                                    <?php
                                                                } else {
                                                                     $condition1 = " AND (a.THAINAME NOT LIKE '%R-%' OR a.THAINAME NOT LIKE '%RA-%' OR a.THAINAME NOT LIKE '%RP-%'"; 
                                                                     $condition2 = " OR a.THAINAME NOT LIKE '%คลองเขื่อน%'  OR a.THAINAME NOT LIKE '%ด่านช้าง%'  OR a.THAINAME NOT LIKE '%สวนผึ้ง%' ";
                                                                     $condition3 = " OR a.ENGNAME NOT LIKE '%ดินแดง%' OR a.ENGNAME NOT LIKE '%อุทัยธานี%' OR a.ENGNAME NOT LIKE '%Kerry%'";
                                                                     $condition4 = " OR a.THAINAME NOT LIKE '%เขาชะเมา%' OR a.THAINAME NOT LIKE '%เฉลิมพระเกียรติ%' OR a.THAINAME NOT LIKE '%P35%' )";
                                                                     $sql_infolist = "{call megVehicleinfo_v2(?,?,?,?,?)}";
                                                                    $params_infolist = array(
                                                                        array('selectcond_vehicleinfo', SQLSRV_PARAM_IN),
                                                                        array($condition1, SQLSRV_PARAM_IN),
                                                                        array($condition2, SQLSRV_PARAM_IN),
                                                                        array($condition3, SQLSRV_PARAM_IN),
                                                                        array($condition4, SQLSRV_PARAM_IN)
                                                                    );

                                                                    $query_infolist = sqlsrv_query($conn, $sql_infolist, $params_infolist);
                                                                    while ($result_infolist = sqlsrv_fetch_array($query_infolist, SQLSRV_FETCH_ASSOC)) {
                                                                        ?>
                                                                        <tr class="odd gradeX">
                                                                            <td style="text-align: center">
                                                                            <button onclick="delete_vehicleinfo(<?= $result_infolist['VEHICLEINFOID'] ?>);" title="ลบข้อมูล" type="button" class="list-group-item"><span class="glyphicon glyphicon-remove"></span></button>
                                                                        </td>
                                                                        <td style="text-align: center">
                                                                            <a href='meg_carinfo.php?type=<?= $_GET['type'] ?>&vehicleinfoid=<?= $result_infolist['VEHICLEINFOID'] ?>&meg=edit' class='list-group-item'><span class="glyphicon glyphicon-wrench"></span></a>
                                                                        </td>
                                                                            <td><?= $result_infolist['VEHICLEREGISNUMBER'] ?></td>
                                                                            <td><?= $result_infolist['VEHICLEGROUPDESC'] ?></td>
                                                                            <td><?= $result_infolist['VEHICLETYPECODE'] ?></td>
                                                                            <td><?= $result_infolist['BRANDDESC'] ?></td>
                                                                            <td><?= $result_infolist['GEARTYPEDESC'] ?></td>
                                                                            <td><?= $result_infolist['COLORDESC'] ?></td>
                                                                            <td><?= $result_infolist['SERIES'] ?></td>
                                                                            <td><?= $result_infolist['THAINAME'] ?></td>
                                                                            <td><?= $result_infolist['ENGNAME'] ?></td>
                                                                            <td><?= $result_infolist['HORSEPOWER'] ?></td>
                                                                            <td><?= $result_infolist['CC'] ?></td>
                                                                            <td><?= $result_infolist['MACHINENUMBER'] ?></td>
                                                                            <td><?= $result_infolist['CHASSISNUMBER'] ?></td>
                                                                            <td><?= $result_infolist['ENERGY'] ?></td>
                                                                            <td><?= $result_infolist['WEIGHT'] ?></td>
                                                                            <td><?= $result_infolist['AXLETYPE'] ?></td>
                                                                            <td><?= $result_infolist['PISTON'] ?></td>
                                                                            <td><?= $result_infolist['MAXIMUMLOAD'] ?></td>
                                                                            <td><?= $result_infolist['DATEOFREGISTRATION'] ?></td>
                                                                            <td><?= $result_infolist['USED'] ?></td>


                                                                            <td><?= $result_infolist['VEHICLEBUYWHERE'] ?></td>
                                                                            <td><?= $result_infolist['VEHICLEBUYDATE'] ?></td>
                                                                            <td><?= $result_infolist['VEHICLEBUYPRICE'] ?></td>
                                                                            <td><?= $result_infolist['VEHICLEBUYCONDITION'] ?></td>
                                                                            <td><?= $result_infolist['VEHICLESTRUCTUREWHERE'] ?></td>
                                                                            <td><?= $result_infolist['VEHICLESTRUCTUREDATE'] ?></td>
                                                                            <td><?= $result_infolist['VEHICLESTRUCTUREPRICE'] ?></td>
                                                                            <td><?= $result_infolist['VEHICLEREGISTERDATE'] ?></td>
                                                                            <td><?= $result_infolist['VEHICLESPECIAL'] ?></td>



                                                                            <td><?php echo ($result_infolist['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>
                                                                            <td><?= $result_infolist['REMARK'] ?></td>



                                                                        </tr>
                                                                        <?php
                                                                    }
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

                    if ($_GET['type'] == "infogetway") {
                        ?>
                        <div class="row" >
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                        <font style="font-size: 16px"><b>รายการข้อมูลรถ</b></font>                            
                                    </div>
                                    <div class="panel-body">
                                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                            <div class="row">


                                                <div class="col-sm-12">
                                                    <div id="datade">
                                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>&nbsp;</th>
                                                                    <th>&nbsp;</th>
                                                                    <th>เลขทะเบียนรถ</th>
                                                                    <th>กลุ่มรถ</th>
                                                                    <th>ประเภทรถ</th>
                                                                    <th>ยี่ห้อรถ</th>
                                                                    <th>ประเภทเกียร์รถ</th>
                                                                    <th>สีรถ</th>
                                                                    <th>ซีรีส์/รุ่น</th>
                                                                    <th>ชื่อรถ (ไทย)</th>
                                                                    <th>ชื่อรถ (อังกฤษ)</th>
                                                                    <th>แรงม้า</th>
                                                                    <th>CC</th>
                                                                    <th>เลขเครื่องยนต์</th>
                                                                    <th>เลขตัวถัง</th>
                                                                    <th>ประเภทพลังงาน</th>
                                                                    <th>น้ำหนักรถ (กิโลกรัม)</th>
                                                                    <th>ประเภทเพลา</th>
                                                                    <th>ลูกสูบ</th>
                                                                    <th>น้ำหนักบรรทุกสูงสุด</th>
                                                                    <th>วันที่เพิ่มข้อมูล</th>
                                                                    <th>การใช้งาน (ปี)</th>
                                                                    <th>ซื้อรถที่ใหน</th>
                                                                    <th>วันที่ซื้อ</th>
                                                                    <th>ราคารถ</th>
                                                                    <th>เงื่อนไขการซื้อ</th>
                                                                    <th>ต่อโครงสร้างที่ใหน</th>
                                                                    <th>วันที่ต่อโครงสร้าง</th>
                                                                    <th>ราคา</th>
                                                                    <th>วันที่จดทะเบียนครั้งแรก</th>
                                                                    <th>อุปกรณ์เฉพาะ</th>
                                                                    <th>สถานะ</th>
                                                                    <th>หมายเหตุ</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                <?php
                                                                if ($_GET['vehicleinfoid'] != "" && $_GET['meg'] == 'edit') {
                                                                    ?>
                                                                    <tr class="odd gradeX">
                                                                        <td style="text-align: center">
                                                                            <button onclick="delete_vehicleinfo(<?= $result_info['VEHICLEINFOID'] ?>);" title="ลบข้อมูล" type="button" class="list-group-item"><span class="glyphicon glyphicon-remove"></span></button>
                                                                        </td>
                                                                        <td style="text-align: center">
                                                                            <a href='meg_carinfo.php?type=<?= $_GET['type'] ?>&vehicleinfoid=<?= $result_info['VEHICLEINFOID'] ?>&meg=edit' class='list-group-item'><span class="glyphicon glyphicon-wrench"></span></a>
                                                                        </td>
                                                                        <td><?= $result_info['VEHICLEREGISNUMBER'] ?></td>
                                                                        <td><?= $result_info['VEHICLEGROUPDESC'] ?></td>
                                                                        <td><?= $result_info['VEHICLETYPECODE'] ?></td>
                                                                        <td><?= $result_info['BRANDDESC'] ?></td>
                                                                        <td><?= $result_info['GEARTYPEDESC'] ?></td>
                                                                        <td><?= $result_info['COLORDESC'] ?></td>
                                                                        <td><?= $result_info['SERIES'] ?></td>
                                                                        <td><?= $result_info['THAINAME'] ?></td>
                                                                        <td><?= $result_info['ENGNAME'] ?></td>
                                                                        <td><?= $result_info['HORSEPOWER'] ?></td>
                                                                        <td><?= $result_info['CC'] ?></td>
                                                                        <td><?= $result_info['MACHINENUMBER'] ?></td>
                                                                        <td><?= $result_info['CHASSISNUMBER'] ?></td>
                                                                        <td><?= $result_info['ENERGY'] ?></td>
                                                                        <td><?= $result_info['WEIGHT'] ?></td>
                                                                        <td><?= $result_info['AXLETYPE'] ?></td>
                                                                        <td><?= $result_info['PISTON'] ?></td>
                                                                        <td><?= $result_info['MAXIMUMLOAD'] ?></td>
                                                                        <td><?= $result_info['DATEOFREGISTRATION'] ?></td>
                                                                        <td><?= $result_info['USED'] ?></td>
                                                                        <td><?= $result_info['VEHICLEBUYWHERE'] ?></td>
                                                                        <td><?= $result_info['VEHICLEBUYDATE'] ?></td>
                                                                        <td><?= $result_info['VEHICLEBUYPRICE'] ?></td>
                                                                        <td><?= $result_info['VEHICLEBUYCONDITION'] ?></td>
                                                                        <td><?= $result_info['VEHICLESTRUCTUREWHERE'] ?></td>
                                                                        <td><?= $result_info['VEHICLESTRUCTUREDATE'] ?></td>
                                                                        <td><?= $result_info['VEHICLESTRUCTUREPRICE'] ?></td>
                                                                        <td><?= $result_info['VEHICLEREGISTERDATE'] ?></td>
                                                                        <td><?= $result_info['VEHICLESPECIAL'] ?></td>
                                                                        <td><?php echo ($result_info['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>
                                                                        <td><?= $result_info['REMARK'] ?></td>
                                                                    </tr>
                                                                    <?php
                                                                } else {
                                                                     $condition1 = " AND (a.THAINAME  LIKE '%R-%' OR a.THAINAME  LIKE '%RA-%' OR a.THAINAME  LIKE '%RP-%' ";
                                                                     $condition2 = " OR a.ENGNAME LIKE '%ดินแดง%' OR a.THAINAME  LIKE '%อุทัยธานี%'  OR a.THAINAME  LIKE '%คลองเขื่อน%'";
                                                                     $condition3 = " OR a.THAINAME  LIKE '%ด่านช้าง%'  OR a.THAINAME  LIKE '%สวนผึ้ง%' OR a.ENGNAME = '-' OR a.ENGNAME LIKE '%Kerry%'";
                                                                     $condition4 = " OR a.THAINAME  LIKE '%เขาชะเมา%' OR a.THAINAME  LIKE '%เฉลิมพระเกียรติ%' OR a.THAINAME  LIKE '%P35%' )";
                                                                    $sql_infolist = "{call megVehicleinfo_v2(?,?,?,?,?)}";
                                                                    $params_infolist = array(
                                                                        array('selectcond_vehicleinfo', SQLSRV_PARAM_IN),
                                                                        array($condition1, SQLSRV_PARAM_IN),
                                                                        array($condition2, SQLSRV_PARAM_IN),
                                                                        array($condition3, SQLSRV_PARAM_IN),
                                                                        array($condition4, SQLSRV_PARAM_IN)
                                                                    );

                                                                    $query_infolist = sqlsrv_query($conn, $sql_infolist, $params_infolist);
                                                                    while ($result_infolist = sqlsrv_fetch_array($query_infolist, SQLSRV_FETCH_ASSOC)) {
                                                                        ?>
                                                                        <tr class="odd gradeX">
                                                                            <td style="text-align: center">
                                                                                <button onclick="delete_vehicleinfo(<?= $result_info['VEHICLEINFOID'] ?>);" title="ลบข้อมูล" type="button" class="list-group-item"><span class="glyphicon glyphicon-remove"></span></button>
                                                                            </td>
                                                                            <td style="text-align: center">
                                                                                <a href="meg_carinfo.php?type=<?= $_GET['type'] ?>&vehicleinfoid=<?= $result_infolist['VEHICLEINFOID'] ?>&meg=add" class="list-group-item"><span class="glyphicon glyphicon-wrench"></span></a>
                                                                            </td>
                                                                            <td><?= $result_infolist['VEHICLEREGISNUMBER'] ?></td>
                                                                            <td><?= $result_infolist['VEHICLEGROUPDESC'] ?></td>
                                                                            <td><?= $result_infolist['VEHICLETYPECODE'] ?></td>
                                                                            <td><?= $result_infolist['BRANDDESC'] ?></td>
                                                                            <td><?= $result_infolist['GEARTYPEDESC'] ?></td>
                                                                            <td><?= $result_infolist['COLORDESC'] ?></td>
                                                                            <td><?= $result_infolist['SERIES'] ?></td>
                                                                            <td><?= $result_infolist['THAINAME'] ?></td>
                                                                            <td><?= $result_infolist['ENGNAME'] ?></td>
                                                                            <td><?= $result_infolist['HORSEPOWER'] ?></td>
                                                                            <td><?= $result_infolist['CC'] ?></td>
                                                                            <td><?= $result_infolist['MACHINENUMBER'] ?></td>
                                                                            <td><?= $result_infolist['CHASSISNUMBER'] ?></td>
                                                                            <td><?= $result_infolist['ENERGY'] ?></td>
                                                                            <td><?= $result_infolist['WEIGHT'] ?></td>
                                                                            <td><?= $result_infolist['AXLETYPE'] ?></td>
                                                                            <td><?= $result_infolist['PISTON'] ?></td>
                                                                            <td><?= $result_infolist['MAXIMUMLOAD'] ?></td>
                                                                            <td><?= $result_infolist['DATEOFREGISTRATION'] ?></td>
                                                                            <td><?= $result_infolist['USED'] ?></td>
                                                                            <td><?= $result_infolist['VEHICLEBUYWHERE'] ?></td>
                                                                            <td><?= $result_infolist['VEHICLEBUYDATE'] ?></td>
                                                                            <td><?= $result_infolist['VEHICLEBUYPRICE'] ?></td>
                                                                            <td><?= $result_infolist['VEHICLEBUYCONDITION'] ?></td>
                                                                            <td><?= $result_infolist['VEHICLESTRUCTUREWHERE'] ?></td>
                                                                            <td><?= $result_infolist['VEHICLESTRUCTUREDATE'] ?></td>
                                                                            <td><?= $result_infolist['VEHICLESTRUCTUREPRICE'] ?></td>
                                                                            <td><?= $result_infolist['VEHICLEREGISTERDATE'] ?></td>
                                                                            <td><?= $result_infolist['VEHICLESPECIAL'] ?></td>
                                                                            <td><?php echo ($result_infolist['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>
                                                                            <td><?= $result_infolist['REMARK'] ?></td>



                                                                        </tr>
                                                                        <?php
                                                                    }
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

                    if ($_GET['type'] == "history") {
                        ?>
                        <div class="row" >
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                        <font style="font-size: 16px"><b>รายการข้อมูลประวัติการเปลี่ยน</b></font>                            
                                    </div>
                                    <div class="panel-body">
                                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                            <div class="row">


                                                <div class="col-sm-12">
                                                    <div id="datade">
                                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>อะไหล่สำรอง/ประเภท</th>
                                                                    <th>วันที่เปลี่ยนอะไหล่</th>
                                                                    <th>ราคา/ค่าใช้จ่าย (บาท)</th>
                                                                    <th>อะไหล่สำรองในปัจจุบัน</th>
                                                                    <th>เปลี่ยนอะไหล่</th>
                                                                    <th>สถานที่</th>
                                                                    <th>ผู้ดำเนิการ</th>
                                                                    <th>หมายเหตุ</th>
                                                                    <th>สถานะ</th>
                                                                    <th>จัดการ</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $condition1 = " AND a.VEHICLEINFOID = " . $_GET['vehicleinfoid'];
                                                                $sql_seVehiclechangehistorylist = "{call megVehiclechangehistory_v2(?,?)}";
                                                                $params_seVehiclechangehistorylist = array(
                                                                    array('select_vehiclechangehistory', SQLSRV_PARAM_IN),
                                                                    array($condition1, SQLSRV_PARAM_IN)
                                                                );
                                                                $query_seVehiclechangehistorylist = sqlsrv_query($conn, $sql_seVehiclechangehistorylist, $params_seVehiclechangehistorylist);
                                                                while ($result_seVehiclechangehistorylist = sqlsrv_fetch_array($query_seVehiclechangehistorylist, SQLSRV_FETCH_ASSOC)) {
                                                                    ?>
                                                                    <tr class="odd gradeX">
                                                                        <td><?= $result_seVehiclechangehistorylist['DESCRIPTION'] ?></td>
                                                                        <td><?= $result_seVehiclechangehistorylist['CHANGEDATE'] ?></td>
                                                                        <td><?= $result_seVehiclechangehistorylist['CHANGECOST'] ?></td>
                                                                        <td><?= $result_seVehiclechangehistorylist['CURRENTSPAREPARTS'] ?></td>
                                                                        <td><?= $result_seVehiclechangehistorylist['CHANGETO'] ?></td>
                                                                        <td><?= $result_seVehiclechangehistorylist['PLACE'] ?></td>
                                                                        <td><?= $result_seVehiclechangehistorylist['WHOPROCESS'] ?></td>
                                                                        <td><?= $result_seVehiclechangehistorylist['REMARK'] ?></td>
                                                                        <td><?php echo ($result_seVehiclechangehistorylist['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>
                                                                        <td style="text-align: center">
                                                                            <a href="meg_carinfo.php?type=<?= $_GET['type'] ?>&vehicleinfoid=<?= $_GET['vehicleinfoid'] ?>&vehiclechangehistoryid=<?= $result_seVehiclechangehistorylist['VEHICLECHANGEHISTORYID'] ?>&meg=edit" title="แก้ไขข้อมูล" type="button" class="btn btn-default  btn-circle"><span class="glyphicon glyphicon-wrench"></span></a>
                                                                            <button onclick="delete_vehiclechangehistory(<?= $result_seVehiclechangehistorylist['VEHICLECHANGEHISTORYID'] ?>);" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>

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

                    if ($_GET['type'] == "insured") {
                        ?>
                        <div class="row" >
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                        <font style="font-size: 16px"><b>รายการข้อมูลประวัติการทำประกันภัย</b></font>                            
                                    </div>
                                    <div class="panel-body">
                                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                            <div class="row">


                                                <div class="col-sm-12">
                                                    <div id="datade">
                                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>เลขกรมธรรม์</th>
                                                                    <th>กลุ่มประกันภัย</th>
                                                                    <th>ประเภทประกันภัย</th>
                                                                    <th>เบี้ยประกันภัย</th>
                                                                    <th>วงเงินความคุ้มครองสูงสุด</th>
                                                                    <th>วันที่เริ่มคุ้มครอง</th>
                                                                    <th>วันที่สิ้นสุดความคุ้มครอง</th>
                                                                    <th>ชื่อบริษัทผู้เอาประกันภัย</th>
                                                                    <th>ชื่อนายหน้าประกันภัย</th>
                                                                    <th>ชื่อบริษัทประกันภัย</th>
                                                                    <th>หมายเหตุ</th>
                                                                    <th>สถานะ</th>
                                                                    <th>จัดการ</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $condition1 = " AND a.VEHICLEINFOID = " . $_GET['vehicleinfoid'];
                                                                $sql_seVehicleinsuredlist = "{call megVehicleinsured_v2(?,?)}";
                                                                $params_seVehicleinsuredlist = array(
                                                                    array('select_vehicleinsured', SQLSRV_PARAM_IN),
                                                                    array($condition1, SQLSRV_PARAM_IN)
                                                                );
                                                                $query_seVehicleinsuredlist = sqlsrv_query($conn, $sql_seVehicleinsuredlist, $params_seVehicleinsuredlist);
                                                                while ($result_seVehicleinsuredlist = sqlsrv_fetch_array($query_seVehicleinsuredlist, SQLSRV_FETCH_ASSOC)) {
                                                                    ?>
                                                                    <tr class="odd gradeX">
                                                                        <td><?= $result_seVehicleinsuredlist['POLICYNUMBER'] ?></td>
                                                                        <td><?php echo ($result_seVehicleinsuredlist['INSUREDGROUP'] == "1") ? "ภาคสมัครใจ" : "ภาคบังคับ"; ?></td>
                                                                        <td>ประกันภัยชั้น <?= $result_seVehicleinsuredlist['INSUREDTYPE'] ?></td>
                                                                        <td><?= $result_seVehicleinsuredlist['PRICETOTAL'] ?></td>
                                                                        <td><?= $result_seVehicleinsuredlist['SUMINSURED'] ?></td>
                                                                        <td><?= $result_seVehicleinsuredlist['STARTDATE'] ?></td>
                                                                        <td><?= $result_seVehicleinsuredlist['EXPIREDDATE'] ?></td>
                                                                        <td><?= $result_seVehicleinsuredlist['INSUREDNAME'] ?></td>
                                                                        <td><?= $result_seVehicleinsuredlist['BROKERNAME'] ?></td>
                                                                        <td><?= $result_seVehicleinsuredlist['INSUREDCOMPANY'] ?></td>
                                                                        <td><?= $result_seVehicleinsuredlist['REMARK'] ?></td>
                                                                        <td><?php echo ($result_seVehicleinsuredlist['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>
                                                                        <td style="text-align: center">
                                                                            <a href="meg_carinfo.php?type=<?= $_GET['type'] ?>&vehicleinfoid=<?= $_GET['vehicleinfoid'] ?>&vehicleinsuredid=<?= $result_seVehicleinsuredlist['VEHICLEINSUREDID'] ?>&meg=edit" title="แก้ไขข้อมูล" type="button" class="btn btn-default  btn-circle"><span class="glyphicon glyphicon-wrench"></span></a>
                                                                            <button onclick="delete_vehicleinsured(<?= $result_seVehicleinsuredlist['VEHICLEINSUREDID'] ?>);" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>

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
                    if ($_GET['type'] == "maintenance") {
                        ?>
                        <div class="row" >
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                        <font style="font-size: 16px"><b>รายการข้อมูลประวัติการซ่อมบำรุง</b></font>                            
                                    </div>
                                    <div class="panel-body">
                                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                            <div class="row">


                                                <div class="col-sm-12">
                                                    <div id="datade">
                                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>วันที่เริ่มซ่อม</th>
                                                                    <th>วันที่ซ่อมเสร็จ</th>
                                                                    <th>ราคา (บาท)</th>
                                                                    <th>ผู้ดำเนินการ</th>
                                                                    <th>รายละเอียดการซ่อม</th>
                                                                    <th>สถานที่</th>
                                                                    <th>หมายเหตุ</th>
                                                                    <th>สถานะ</th>
                                                                    <th>จัดการ</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $condition1 = " AND a.VEHICLEINFOID = " . $_GET['vehicleinfoid'];
                                                                $sql_seVehiclemaintenancelist = "{call megVehiclemaintenance_v2(?,?)}";
                                                                $params_seVehiclemaintenancelist = array(
                                                                    array('select_vehiclemaintenance', SQLSRV_PARAM_IN),
                                                                    array($condition1, SQLSRV_PARAM_IN)
                                                                );
                                                                $query_seVehiclemaintenancelist = sqlsrv_query($conn, $sql_seVehiclemaintenancelist, $params_seVehiclemaintenancelist);
                                                                while ($result_seVehiclemaintenancelist = sqlsrv_fetch_array($query_seVehiclemaintenancelist, SQLSRV_FETCH_ASSOC)) {
                                                                    ?>
                                                                    <tr class="odd gradeX">
                                                                        <td><?= $result_seVehiclemaintenancelist['MAINTENANCEDATE'] ?></td>
                                                                        <td><?= $result_seVehiclemaintenancelist['COMPLETEDATE'] ?></td>
                                                                        <td><?= $result_seVehiclemaintenancelist['PRICE'] ?></td>
                                                                        <td><?= $result_seVehiclemaintenancelist['WHOPROCESS'] ?></td>
                                                                        <td><?= $result_seVehiclemaintenancelist['MAINTENANCETYPE'] ?></td>
                                                                        <td><?= $result_seVehiclemaintenancelist['PLACE'] ?></td>
                                                                        <td><?= $result_seVehiclemaintenancelist['REMARK'] ?></td>
                                                                        <td><?php echo ($result_seVehiclemaintenancelist['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>
                                                                        <td style="text-align: center">
                                                                            <a href="meg_carinfo.php?type=<?= $_GET['type'] ?>&vehicleinfoid=<?= $_GET['vehicleinfoid'] ?>&vehiclemaintenanceid=<?= $result_seVehiclemaintenancelist['VEHICLEMAINTENANCEID'] ?>&meg=edit" title="แก้ไขข้อมูล" type="button" class="btn btn-default  btn-circle"><span class="glyphicon glyphicon-wrench"></span></a>
                                                                            <button onclick="delete_vehiclemaintenance(<?= $result_seVehiclemaintenancelist['VEHICLEMAINTENANCEID'] ?>);" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>

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
                    if ($_GET['type'] == "repair") {
                        ?>
                        <div class="row" >
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                        <font style="font-size: 16px"><b>รายการข้อมูลประวัติการซ่อมแซม</b></font>                            
                                    </div>
                                    <div class="panel-body">
                                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                            <div class="row">


                                                <div class="col-sm-12">
                                                    <div id="datade">
                                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>ประเภทการซ่อมแซม</th>
                                                                    <th>ลำดับการซ่อมแซม</th>
                                                                    <th>ชื่ออู่/ที่อยู่</th>
                                                                    <th>วันที่เริ่มซ่อม</th>
                                                                    <th>วันที่กำหนดซ่อมเสร็จ</th>
                                                                    <th>วันที่ซ่อมเสร็จ</th>
                                                                    <th>ราคา (บาท)</th>
                                                                    <th>ผู้ดำเนินการ</th>
                                                                    <th>สาเหตุ</th>
                                                                    <th>รายละเอียดการซ่อมแซม</th>
                                                                    <th>หมายเหตุ</th>
                                                                    <th>สถานะ</th>
                                                                    <th>จัดการ</th>


                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $condition1 = " AND a.VEHICLEINFOID = " . $_GET['vehicleinfoid'];
                                                                $sql_seVehiclerepairlist = "{call megVehiclerepair_v2(?,?)}";
                                                                $params_seVehiclerepairlist = array(
                                                                    array('select_vehiclerepair', SQLSRV_PARAM_IN),
                                                                    array($condition1, SQLSRV_PARAM_IN)
                                                                );
                                                                $query_seVehiclerepairlist = sqlsrv_query($conn, $sql_seVehiclerepairlist, $params_seVehiclerepairlist);
                                                                while ($result_seVehiclerepairlist = sqlsrv_fetch_array($query_seVehiclerepairlist, SQLSRV_FETCH_ASSOC)) {
                                                                    ?>
                                                                    <tr class="odd gradeX">
                                                                        <td><?= $result_seVehiclerepairlist['REPAIRTYPECODE'] ?></td>
                                                                        <td><?= $result_seVehiclerepairlist['GARAGEREPAIRNUMBER'] ?></td>
                                                                        <td><?= $result_seVehiclerepairlist['GARAGENAME'] ?></td>
                                                                        <td><?= $result_seVehiclerepairlist['STARTDATE'] ?></td>
                                                                        <td><?= $result_seVehiclerepairlist['ENDDATE'] ?></td>
                                                                        <td><?= $result_seVehiclerepairlist['ACTUALENDDATE'] ?></td>
                                                                        <td><?= $result_seVehiclerepairlist['TOTALAMOUNT'] ?></td>
                                                                        <td><?= $result_seVehiclerepairlist['WHOPROCESS'] ?></td>
                                                                        <td><?= $result_seVehiclerepairlist['REASON'] ?></td>
                                                                        <td><?= $result_seVehiclerepairlist['REPAIRDETAIL'] ?></td>
                                                                        <td><?= $result_seVehiclerepairlist['REMARK'] ?></td>
                                                                        <td><?php echo ($result_seVehiclerepairlist['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>
                                                                        <td style="text-align: center">
                                                                            <a href="meg_carinfo.php?type=<?= $_GET['type'] ?>&vehicleinfoid=<?= $_GET['vehicleinfoid'] ?>&vehiclerepairid=<?= $result_seVehiclerepairlist['VEHICLEREPAIRID'] ?>&meg=edit" title="แก้ไขข้อมูล" type="button" class="btn btn-default  btn-circle"><span class="glyphicon glyphicon-wrench"></span></a>
                                                                            <button onclick="delete_vehiclerepair(<?= $result_seVehiclerepairlist['VEHICLEREPAIRID'] ?>);" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>

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
                    if ($_GET['type'] == "tax") {
                        ?>
                        <div class="row" >
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                        <font style="font-size: 16px"><b>รายการข้อมูลการเสียภาษี</b></font>                            
                                    </div>
                                    <div class="panel-body">
                                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                            <div class="row">


                                                <div class="col-sm-12">
                                                    <div id="datade">
                                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>วันที่เริ่มเสียภาษี</th>
                                                                    <th>วันที่หมดอายุ</th>
                                                                    <th>ราคา (ราคา)</th>
                                                                    <th>ค่าธรรมเนียม</th>
                                                                    <th>ผู้ดำเนินการ</th>
                                                                    <th>สถานที่</th>
                                                                    <th>หมายเหตุ</th>
                                                                    <th>สถานะ</th>
                                                                    <th>จัดการ</th>


                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $condition1 = " AND a.VEHICLEINFOID = " . $_GET['vehicleinfoid'];
                                                                $sql_seVehicletaxlist = "{call megVehicletax_v2(?,?)}";
                                                                $params_seVehicletaxlist = array(
                                                                    array('select_vehicletax', SQLSRV_PARAM_IN),
                                                                    array($condition1, SQLSRV_PARAM_IN)
                                                                );
                                                                $query_seVehicletaxlist = sqlsrv_query($conn, $sql_seVehicletaxlist, $params_seVehicletaxlist);
                                                                while ($result_seVehicletaxlist = sqlsrv_fetch_array($query_seVehicletaxlist, SQLSRV_FETCH_ASSOC)) {
                                                                    ?>
                                                                    <tr class="odd gradeX">
                                                                        <td><?= $result_seVehicletaxlist['TAXDATE'] ?></td>
                                                                        <td><?= $result_seVehicletaxlist['EXPIREDDATE'] ?></td>
                                                                        <td><?= $result_seVehicletaxlist['PRICE'] ?></td>
                                                                        <td><?= $result_seVehicletaxlist['SERVICEFEE'] ?></td>
                                                                        <td><?= $result_seVehicletaxlist['WHOPROCESS'] ?></td>
                                                                        <td><?= $result_seVehicletaxlist['PLACE'] ?></td>
                                                                        <td><?= $result_seVehicletaxlist['REMARK'] ?></td>
                                                                        <td><?php echo ($result_seVehicletaxlist['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>
                                                                        <td style="text-align: center">
                                                                            <a href="meg_carinfo.php?type=<?= $_GET['type'] ?>&vehicleinfoid=<?= $_GET['vehicleinfoid'] ?>&vehicletaxid=<?= $result_seVehicletaxlist['VEHICLETAXID'] ?>&meg=edit" title="แก้ไขข้อมูล" type="button" class="btn btn-default  btn-circle"><span class="glyphicon glyphicon-wrench"></span></a>
                                                                            <button onclick="delete_vehicletax(<?= $result_seVehicletaxlist['VEHICLETAXID'] ?>);" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>

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
                    if ($_GET['type'] == "owner") {
                        ?>
                        <div class="row" >
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                        <font style="font-size: 16px"><b>รายการข้อมูลผู้ขับขี่</b></font>                            
                                    </div>
                                    <div class="panel-body">
                                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                            <div class="row">


                                                <div class="col-sm-12">
                                                    <div id="datade">
                                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>บริษัทเจ้าของรถ</th>
                                                                    <th>บริษัทที่ใช้รถ</th>
                                                                    <th>ใช้ในสายงาน</th>
                                                                    <th>ผู้ขับขี่คนแรก</th>
                                                                    <th>ผู้ขับขี่คนที่สอง</th>
                                                                    <th>หมายเหตุ</th>
                                                                    <th>สถานะ</th>
                                                                    <th>จัดการ</th>


                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $condition1 = " AND a.VEHICLEINFOID = " . $_GET['vehicleinfoid'];
                                                                $sql_seVehicleownerlist = "{call megVehicleowner_v2(?,?)}";
                                                                $params_seVehicleownerlist = array(
                                                                    array('select_vehicleowner', SQLSRV_PARAM_IN),
                                                                    array($condition1, SQLSRV_PARAM_IN)
                                                                );
                                                                $query_seVehicleownerlist = sqlsrv_query($conn, $sql_seVehicleownerlist, $params_seVehicleownerlist);
                                                                while ($result_seVehicleownerlist = sqlsrv_fetch_array($query_seVehicleownerlist, SQLSRV_FETCH_ASSOC)) {
                                                                    ?>
                                                                    <tr class="odd gradeX">

                                                                        <td><?= $result_seVehicleownerlist['OWNERTHAINAME'] ?></td>
                                                                        <td><?= $result_seVehicleownerlist['POSSESSTHAINAME'] ?></td>
                                                                        <td><?= $result_seVehicleownerlist['PROJECTTOUSE'] ?></td>
                                                                        <td><?= $result_seVehicleownerlist['FIRSTDRIVER'] ?></td>
                                                                        <td><?= $result_seVehicleownerlist['SECONDDRIVER'] ?></td>
                                                                        <td><?= $result_seVehicleownerlist['REMARK'] ?></td>
                                                                        <td><?php echo ($result_seVehicleownerlist['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>
                                                                        <td style="text-align: center">
                                                                            <a href="meg_carinfo.php?type=<?= $_GET['type'] ?>&vehicleinfoid=<?= $_GET['vehicleinfoid'] ?>&vehicleownerid=<?= $result_seVehicleownerlist['VEHICLETRUCKOWNERID'] ?>&meg=edit" title="แก้ไขข้อมูล" type="button" class="btn btn-default  btn-circle"><span class="glyphicon glyphicon-wrench"></span></a>
                                                                            <button onclick="delete_vehicleowner(<?= $result_seVehicleownerlist['VEHICLETRUCKOWNERID'] ?>);" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>

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
                    if ($_GET['type'] == "purchase") {
                        ?>
                        <div class="row" >
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                        <font style="font-size: 16px"><b>รายการข้อมูลการจัดซื้อ</b></font>                            
                                    </div>
                                    <div class="panel-body">
                                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                            <div class="row">


                                                <div class="col-sm-12">
                                                    <div id="datade">
                                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>ชื่อผู้ประกอบการ</th>
                                                                    <th>ชื่อผู้เช่า</th>
                                                                    <th>วันที่สั่งซื้อ</th>
                                                                    <th>ราคา (บาท)</th>
                                                                    <th>ดอกเบี้ย (%)</th>
                                                                    <th>เวลาชำระเงิน</th>
                                                                    <th>วันที่ (ชำระเงินครังแรก)</th>
                                                                    <th>วันที่ (ชำระเงินครังสุดท้าย)</th>
                                                                    <th>หมายเหตุ</th>
                                                                    <th>สถานะ</th>
                                                                    <th>จัดการ</th>


                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $condition1 = " AND a.VEHICLEINFOID = " . $_GET['vehicleinfoid'];
                                                                $sql_seVehiclepurchaselist = "{call megVehiclepurchase_v2(?,?)}";
                                                                $params_seVehiclepurchaserlist = array(
                                                                    array('select_vehiclepurchase', SQLSRV_PARAM_IN),
                                                                    array($condition1, SQLSRV_PARAM_IN)
                                                                );
                                                                $query_seVehiclepurchaselist = sqlsrv_query($conn, $sql_seVehiclepurchaselist, $params_seVehiclepurchaserlist);
                                                                while ($result_seVehiclepurchaselist = sqlsrv_fetch_array($query_seVehiclepurchaselist, SQLSRV_FETCH_ASSOC)) {
                                                                    ?>
                                                                    <tr class="odd gradeX">
                                                                        <td><?= $result_seVehiclepurchaselist['THAINAME'] ?></td>
                                                                        <td><?= $result_seVehiclepurchaselist['LEASINGNAME'] ?></td>
                                                                        <td><?= $result_seVehiclepurchaselist['PURCHASEDATE'] ?></td>
                                                                        <td><?= $result_seVehiclepurchaselist['PEICE'] ?></td>
                                                                        <td><?= $result_seVehiclepurchaselist['INTERESTRATE'] ?></td>
                                                                        <td><?= $result_seVehiclepurchaselist['PAYMENTTIMES'] ?></td>
                                                                        <td><?= $result_seVehiclepurchaselist['FIRSTPAYMENTDATE'] ?></td>
                                                                        <td><?= $result_seVehiclepurchaselist['LASTPAYMENTDATE'] ?></td>
                                                                        <td><?= $result_seVehiclepurchaselist['REMARK'] ?></td>
                                                                        <td><?php echo ($result_seVehiclepurchaselist['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>
                                                                        <td style="text-align: center">
                                                                            <a href="meg_carinfo.php?type=<?= $_GET['type'] ?>&vehicleinfoid=<?= $_GET['vehicleinfoid'] ?>&vehiclepurchaseid=<?= $result_seVehiclepurchaselist['VEHICLEPURCHASEID'] ?>&meg=edit" title="แก้ไขข้อมูล" type="button" class="btn btn-default  btn-circle"><span class="glyphicon glyphicon-wrench"></span></a>
                                                                            <button onclick="delete_vehiclepurchase(<?= $result_seVehiclepurchaselist['VEHICLEPURCHASEID'] ?>);" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>

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
                    if ($_GET['type'] == "attribute") {
                        ?>
                        <div class="row" >
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                        <font style="font-size: 16px"><b>รายการข้อมูลรูป/ลักษณะ</b></font>                            
                                    </div>
                                    <div class="panel-body" >
                                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                            <div class="row">


                                                <div class="col-sm-12">
                                                    <div id="datade">
                                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>ด้านหน้า (หัวรถ)</th>
                                                                    <th>กว้าง (หัวรถด้านหน้า)</th>
                                                                    <th>ยาว (หัวรถด้านหน้า)</th>
                                                                    <th>สูง (หัวรถด้านหน้า)</th>
                                                                    <th>ด้านข้าง (หัวรถ)</th>
                                                                    <th>กว้าง (หัวรถด้านข้าง)</th>
                                                                    <th>ยาว (หัวรถด้านข้าง)</th>
                                                                    <th>สูง (หัวรถด้านข้าง)</th>
                                                                    <th>ด้านหลัง (หัวรถ)</th>
                                                                    <th>กว้าง (หัวรถด้านหลัง)</th>
                                                                    <th>ยาว (หัวรถด้านหลัง)</th>
                                                                    <th>สูง (หัวรถด้านหลัง)</th>
                                                                    <th>ด้านใน (หัวรถ)</th>
                                                                    <th>ด้านหน้า (โครงสร้าง)</th>
                                                                    <th>กว้าง (โครงสร้างด้านหน้า)</th>
                                                                    <th>ยาว (โครงสร้างด้านหน้า)</th>
                                                                    <th>สูง (โครงสร้างด้านหน้า)</th>
                                                                    <th>ด้านข้าง (โครงสร้าง)</th>
                                                                    <th>กว้าง (โครงสร้างด้านข้าง)</th>
                                                                    <th>ยาว (โครงสร้างด้านข้าง)</th>
                                                                    <th>สูง (โครงสร้างด้านข้าง)</th>
                                                                    <th>ด้านหลัง (โครงสร้าง)</th>
                                                                    <th>กว้าง (โครงสร้างด้านหลัง)</th>
                                                                    <th>ยาว (โครงสร้างด้านหลัง)</th>
                                                                    <th>สูง (โครงสร้างด้านหลัง)</th>
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
                                                                        <td><?= $result_seVehicleattributelist['HEAD_FRONTIMAGE'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['HEAD_FRONTWIDTH'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['HEAD_FRONTLONG'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['HEAD_FRONTHIGH'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['HEAD_SIDEIMAGE'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['HEAD_SIDEWIDTH'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['HEAD_SIDELONG'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['HEAD_SIDEHIGH'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['HEAD_BACKIMAGE'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['HEAD_BACKWIDTH'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['HEAD_BACKTLONG'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['HEAD_BACKTHIGH'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['HEAD_INIMAGE'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['STRUC_FRONTIMAGE'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['STRUC_FRONTWIDTH'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['STRUC_FRONTLONG'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['STRUC_FRONTHIGH'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['STRUC_SIDEIMAGE'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['STRUC_SIDEWIDTH'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['STRUC_SIDELONG'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['STRUC_SIDEHIGH'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['STRUC_BACKIMAGE'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['STRUC_BACKWIDTH'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['STRUC_BACKTLONG'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['STRUC_BACKTHIGH'] ?></td>
                                                                        <td><?= $result_seVehicleattributelist['REMARK'] ?></td>
                                                                        <td><?php echo ($result_seVehiclepurchaselist['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>
                                                                        <td style="text-align: center">
                                                                            <a href="meg_carinfo.php?type=<?= $_GET['type'] ?>&vehicleinfoid=<?= $_GET['vehicleinfoid'] ?>&vehicleattributeid=<?= $result_seVehicleattributelist['VEHICLEATTRIBUTEID'] ?>&meg=edit" title="แก้ไขข้อมูล" type="button" class="btn btn-default  btn-circle"><span class="glyphicon glyphicon-wrench"></span></a>
                                                                            <button onclick="delete_vehicleattribute(<?= $result_seVehicleattributelist['VEHICLEATTRIBUTEID'] ?>);" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>

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
                                                                                //responsive: true,
                                                                                scrollX: true,
                                                                                dom: 'Bfrtip',

                                                                                buttons: [

                                                                                    {
                                                                                        extend: 'excelHtml5',
                                                                                        exportOptions: {
                                                                                            columns: ':visible'
                                                                                        }
                                                                                    },
                                                                                            //'colvis'
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
            function show_remark(data)
            {
                if (data == '4L')
                {
                    document.getElementById('txt_inforemark').value = 'บรรทุกเฉพาะกิจ(บรรทุกรถยนต์)';
                }
                if (data == '8L')
                {
                    document.getElementById('txt_inforemark').value = '';
                }
                if (data == '10W')
                {
                    document.getElementById('txt_inforemark').value = 'บรรทุกเฉพาะกิจ';
                }
                if (data == '22W')
                {
                    document.getElementById('txt_inforemark').value = '';
                }
                if (data == 'Full trailer')
                {
                    document.getElementById('txt_inforemark').value = 'รถพ่วงบรรทุกรถยนต์';
                }

                if (data == 'Semi trailer')
                {
                    document.getElementById('txt_inforemark').value = 'ลากจูง';
                }

            }
            function chknull_vehicleinfo()
            {

                if (document.getElementById('txt_vehiclenumber').value == '')
                {
                    alert('เลขทะเบียนรถเป็นค่าว่าง !!!')
                    document.getElementById('txt_vehiclenumber').focus();
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
                } else if (document.getElementById('txt_weight').value == '')
                {
                    alert('น้ำหนักรถ (กิโลกรัม)เป็นค่าว่าง !!!')
                    document.getElementById('txt_weight').focus();
                    return false;
                } else if (document.getElementById('txt_maxload').value == '')
                {
                    alert('น้ำหนักบรรทุกสูงสุดเป็นค่าว่าง !!!')
                    document.getElementById('txt_maxload').focus();
                    return false;
                } else if (document.getElementById('txt_vehiclebuywhere').value == '')
                {
                    alert('ซื้อรถที่ใหนเป็นค่าว่าง !!!')
                    document.getElementById('txt_vehiclebuywhere').focus();
                    return false;
                } else if (document.getElementById('txt_vehiclebuyprice').value == '')
                {
                    alert('ราคารถเป็นค่าว่าง !!!')
                    document.getElementById('txt_vehiclebuyprice').focus();
                    return false;
                } else if (document.getElementById('txt_vehiclestructurewhere').value == '')
                {
                    alert('ต่อโครงสร้างที่ใหนเป็นค่าว่าง !!!')
                    document.getElementById('txt_vehiclestructurewhere').focus();
                    return false;
                } else if (document.getElementById('txt_vehiclestructuredprice').value == '')
                {
                    alert('ราคาเป็นค่าว่าง !!!')
                    document.getElementById('txt_vehiclestructuredprice').focus();
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
                    alert('ด้านหน้า(หัวรถ)เป็นค่าว่าง !!!')
                    document.getElementById('file_front').focus();
                    return false;
                } else if (document.getElementById('front_width').value == '')
                {
                    alert('กว้าง(หัวรถด้านหน้า)เป็นค่าว่าง !!!')
                    document.getElementById('front_width').focus();
                    return false;
                } else if (document.getElementById('front_long').value == '')
                {
                    alert('ยาว(หัวรถด้านหน้า)เป็นค่าว่าง !!!')
                    document.getElementById('front_long').focus();
                    return false;
                } else if (document.getElementById('front_high').value == '')
                {
                    alert('สูง(หัวรถด้านหน้า)เป็นค่าว่าง !!!')
                    document.getElementById('front_high').focus();
                    return false;
                } else if (document.getElementById('file_side').value == '')
                {
                    alert('ด้านข้าง(หัวรถ)เป็นค่าว่าง !!!')
                    document.getElementById('file_side').focus();
                    return false;
                } else if (document.getElementById('side_width').value == '')
                {
                    alert('กว้าง(หัวรถด้านข้าง)เป็นค่าว่าง !!!')
                    document.getElementById('side_width').focus();
                    return false;
                } else if (document.getElementById('side_long').value == '')
                {
                    alert('ยาว(หัวรถด้านข้าง)เป็นค่าว่าง !!!')
                    document.getElementById('side_long').focus();
                    return false;
                } else if (document.getElementById('side_high').value == '')
                {
                    alert('สูง(หัวรถด้านข้าง)เป็นค่าว่าง !!!')
                    document.getElementById('side_high').focus();
                    return false;
                } else if (document.getElementById('file_back').value == '')
                {
                    alert('ด้านหลัง(หัวรถ)เป็นค่าว่าง !!!')
                    document.getElementById('file_back').focus();
                    return false;
                } else if (document.getElementById('back_width').value == '')
                {
                    alert('กว้าง(หัวรถด้านหลัง)เป็นค่าว่าง !!!')
                    document.getElementById('back_width').focus();
                    return false;
                } else if (document.getElementById('back_long').value == '')
                {
                    alert('ยาว(หัวรถด้านหลัง)เป็นค่าว่าง !!!')
                    document.getElementById('back_long').focus();
                    return false;
                } else if (document.getElementById('back_high').value == '')
                {
                    alert('สูง(หัวรถด้านหลัง)เป็นค่าว่าง !!!')
                    document.getElementById('back_high').focus();
                    return false;
                }
                if (document.getElementById('struc_file_front').value == '')
                {
                    alert('ด้านหน้า(โครงสร้าง)เป็นค่าว่าง !!!')
                    document.getElementById('struc_file_front').focus();
                    return false;
                } else if (document.getElementById('struc_front_width').value == '')
                {
                    alert('กว้าง(โครงสร้างด้านหน้า)เป็นค่าว่าง !!!')
                    document.getElementById('struc_front_width').focus();
                    return false;
                } else if (document.getElementById('struc_front_long').value == '')
                {
                    alert('ยาว(โครงสร้างด้านหน้า)เป็นค่าว่าง !!!')
                    document.getElementById('struc_front_long').focus();
                    return false;
                } else if (document.getElementById('struc_front_high').value == '')
                {
                    alert('สูง(โครงสร้างด้านหน้า)เป็นค่าว่าง !!!')
                    document.getElementById('struc_front_high').focus();
                    return false;
                } else if (document.getElementById('struc_file_side').value == '')
                {
                    alert('ด้านข้าง(โครงสร้าง)เป็นค่าว่าง !!!')
                    document.getElementById('struc_file_side').focus();
                    return false;
                } else if (document.getElementById('struc_side_width').value == '')
                {
                    alert('กว้าง(โครงสร้างด้านข้าง)เป็นค่าว่าง !!!')
                    document.getElementById('struc_side_width').focus();
                    return false;
                } else if (document.getElementById('struc_side_long').value == '')
                {
                    alert('ยาว(โครงสร้างด้านข้าง)เป็นค่าว่าง !!!')
                    document.getElementById('struc_side_long').focus();
                    return false;
                } else if (document.getElementById('side_high').value == '')
                {
                    alert('สูง(โครงสร้างด้านข้าง)เป็นค่าว่าง !!!')
                    document.getElementById('struc_side_high').focus();
                    return false;
                } else if (document.getElementById('struc_file_back').value == '')
                {
                    alert('ด้านหลัง(โครงสร้าง)เป็นค่าว่าง !!!')
                    document.getElementById('struc_file_back').focus();
                    return false;
                } else if (document.getElementById('struc_back_width').value == '')
                {
                    alert('กว้าง(โครงสร้างด้านหลัง)เป็นค่าว่าง !!!')
                    document.getElementById('struc_back_width').focus();
                    return false;
                } else if (document.getElementById('struc_back_long').value == '')
                {
                    alert('ยาว(โครงสร้างด้านหลัง)เป็นค่าว่าง !!!')
                    document.getElementById('struc_back_long').focus();
                    return false;
                } else if (document.getElementById('struc_back_high').value == '')
                {
                    alert('สูง(โครงสร้างด้านหลัง)เป็นค่าว่าง !!!')
                    document.getElementById('struc_back_high').focus();
                    return false;
                } else if (document.getElementById('file_in').value == '')
                {
                    alert('ด้านใน(โครงสร้าง)เป็นค่าว่าง !!!')
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
                            txt_flg: "save_vehicleinfo", vehicleinfoid: vehicleinfoid, vehiclenumber: vehiclenumber, cargroup: cargroup, cartype: cartype, carbrand: carbrand, geartype: geartype, carcolor: carcolor, series_model: series_model, carnameth: carnameth, carnameen: carnameen, horse: horse, cc: cc, machine: machine, chassisnumber: chassisnumber, energy: energy, weight: weight, axle: axle, piston: piston, maxload: maxload, used: used, vehiclebuywhere: vehiclebuywhere, vehiclebuydate: vehiclebuydate, vehiclebuyprice: vehiclebuyprice, vehiclebuyconditon: vehiclebuyconditon, vehiclestructurewhere: vehiclestructurewhere, vehiclestructuredate: vehiclestructuredate, vehiclestructuredprice: vehiclestructuredprice, vehicleregisterdate: vehicleregisterdate, vehiclespecial: vehiclespecial, inforemark: inforemark, carstatus: carstatus
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

                var strucfront = document.getElementById('struc_file_front').value;
                var strucfrontwidth = document.getElementById('struc_front_width').value;
                var strucfrontlong = document.getElementById('struc_front_long').value;
                var strucfronthigh = document.getElementById('struc_front_high').value;
                var strucside = document.getElementById('struc_file_side').value;
                var strucsidewidth = document.getElementById('struc_side_width').value;
                var strucsidelong = document.getElementById('struc_side_long').value;
                var strucsidehigh = document.getElementById('struc_side_high').value;
                var strucfileback = document.getElementById('struc_file_back').value;
                var strucbackwidth = document.getElementById('struc_back_width').value;
                var strucbacklong = document.getElementById('struc_back_long').value;
                var strucbackhigh = document.getElementById('struc_back_high').value;

                var filein = document.getElementById('file_in').value;
                var txtattributeremark = document.getElementById('txt_attributeremark').value;
                var txtattributestatus = document.getElementById('txt_attributestatus').value;

                if (chknull_vehicleattribute())
                {
                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "save_vehicleattribute", vehicleattributeid: vehicleattributeid, vehicleinfoid: vehicleinfoid, front: front, frontwidth: frontwidth, frontlong: frontlong, fronthigh: fronthigh, side: side, sidewidth: sidewidth, sidelong: sidelong, sidehigh: sidehigh, fileback: fileback, backwidth: backwidth, backlong: backlong, backhigh: backhigh, strucfront: strucfront, strucfrontwidth: strucfrontwidth, strucfrontlong: strucfrontlong, strucfronthigh: strucfronthigh, strucside: strucside, strucsidewidth: strucsidewidth, strucsidelong: strucsidelong, strucsidehigh: strucsidehigh, strucfileback: strucfileback, strucbackwidth: strucbackwidth, strucbacklong: strucbacklong, strucbackhigh: strucbackhigh, filein: filein, txtattributeremark: txtattributeremark, txtattributestatus: txtattributestatus
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
            function delete_vehicleattribute(vehicleattributeid)
            {
                var confirmation = confirm("ต้องการลบข้อมูล ?");

                if (confirmation) {
                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "delete_vehicleattribute", vehicleattributeid: vehicleattributeid
                        },
                        success: function () {
                            alert('ลบข้อมูลเรียบร้อยแล้ว');
                            window.location.reload();
                        }
                    });
                }
            }
            function delete_vehicleinfo(vehicleinfoid)
            {
                var confirmation = confirm("ต้องการลบข้อมูล ?");

                if (confirmation) {
                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "delete_vehicleinfo", vehicleinfoid: vehicleinfoid
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
