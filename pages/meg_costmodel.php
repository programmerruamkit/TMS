<!DOCTYPE html>
<?php
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
                <p>&nbsp;</p>
                <form  name="saveform" id="saveform" method="post">
                    <input type="text" id="txt_vehicleinfoid" name="txt_vehicleinfoid" style="display: none" value="<?= $_GET['vehicleinfoid'] ?>">
                    <?php
                    if ($_GET['type'] == "costmodel") {
                        if ($_GET['costmodelid'] != "") {
                            $condition1 = " AND a.VEHICLECOSTMODELID=" . $_GET['costmodelid'];
                            $sql_getCostmodel = "{call megVehiclecostmodel_v2(?,?)}";
                            $params_getCostmodel = array(
                                array('select_vehiclecostmodel', SQLSRV_PARAM_IN),
                                array($condition1, SQLSRV_PARAM_IN)
                            );
                        }
                        $query_getCostmodel = sqlsrv_query($conn, $sql_getCostmodel, $params_getCostmodel);
                        $result_getCostmodel = sqlsrv_fetch_array($query_getCostmodel, SQLSRV_FETCH_ASSOC);
                        
                        ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">

                                        <?php
                                        $meg = 'โมเดลต้นทุน';
                                        echo "<a href='report_company.php'>บริษัท</a> / <a href='report_customer.php?type=report&companyid=" . $_GET['companyid'] . "'>ลูกค้า</a>  / " . $meg;
                                        $link = "<a href='report_company.php?type=report'>บริษัท</a> / <a href='report_customer.php?type=report&companyid=" . $_GET['companyid'] . "'>ลูกค้า</a> ";
                                        $_SESSION["link"] = $link;
                                        ?>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row" >
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ชื่อโมเดล</label>
                                                    <input class = "form-control" id = "txt_modelname" name = "txt_modelname" value = "<?=$result_getCostmodel['MODELNAME']?>" >

                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>ประเภทรถ</label>
                                                    <select  class="form-control" id="cb_cartype" name="cb_cartype">
                                                        <option value="">เลือกประเภทรถ</option>
                                                        <?php
                                                        
                                                        $sql_seCartype = "{call megVehicletype_v2(?)}";
                                                        $params_seCartype = array(
                                                            array('select_vehicletype', SQLSRV_PARAM_IN)
                                                        );
                                                        $query_seCartype = sqlsrv_query($conn, $sql_seCartype, $params_seCartype);
                                                        while ($result_seCartype = sqlsrv_fetch_array($query_seCartype, SQLSRV_FETCH_ASSOC)) {
                                                            $selected2 = "";
                                                            if ($result_seCartype['VEHICLETYPECODE'] == $result_getCostmodel['CARTYPE']) {
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
                                            <div class="col-lg-3">
                                                <div class="form-group">

                                                    <font style="color: red">* </font><label>ประเภทพลังงาน</label>
                                                    <select  class="form-control" id="cb_oiltype" name="cb_oiltype">
                                                        <option value="">เลือกประเภทพลังงาน</option>
                                                        <?php
                                                        switch ($result_getCostmodel['OILTYPE']) {
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
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <font style="color: red">* </font><label>น้ำหนักบันทุก (ตัน)</label>
                                                    <input class = "form-control" id = "txt_load" name = "txt_load" value = "<?=$result_getCostmodel['CARLOAD']?>" >
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                                        อัตราการสิ้นเปลืองน้ำมัน
                                                    </div>
                                                    <div class="panel-body" style="background-color: #f8f8f8">
                                                        <div class="row" >
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <font style="color: red">* </font><label>รถเปล่า (ก.ม./ลิตร)</label>
                                                                    <input class = "form-control" id = "txt_carnull" name = "txt_carnull" value = "<?=$result_getCostmodel['CARNULL']?>" >
                                                                </div>

                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <font style="color: red">* </font><label>รถมีสินค้า (ก.ม./ลิตร)</label>
                                                                    <input class = "form-control" id = "txt_carnotnull" name = "txt_carnotnull" value = "<?=$result_getCostmodel['CARNOTNULL']?>" >
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
                                            <div class="col-lg-6">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                                        อัตราการสึกหรอ
                                                    </div>
                                                    <div class="panel-body" style="background-color: #f8f8f8">
                                                        <div class="row" >
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <font style="color: red">* </font><label>ยาง (Bath/km)</label>
                                                                    <input class = "form-control" id = "txt_rubber" name = "txt_rubber" value = "<?=$result_getCostmodel['CARRUBBER']?>" >
                                                                </div>

                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <font style="color: red">* </font><label>น้ำมันเครื่อง (Bath/km)</label>
                                                                    <input class = "form-control" id = "txt_engineoil" name = "txt_engineoil" value = "<?=$result_getCostmodel['CARENGINEOIL']?>" >
                                                                </div>

                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <font style="color: red">* </font><label>เบรค (Bath/km)</label>
                                                                    <input class = "form-control" id = "txt_brake" name = "txt_brake" value = "<?=$result_getCostmodel['CARBRAKE']?>" >
                                                                </div>

                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <font style="color: red">* </font><label>แบตเตอรี่ (Bath/km)</label>
                                                                    <input class = "form-control" id = "txt_battery" name = "txt_battery" value = "<?=$result_getCostmodel['CARBATTERY']?>" >
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
                                        <div class = "row" >
                                            <div class = "col-lg-6">
                                                <div class = "form-group">
                                                    <label>หมายเหตุ</label>
                                                    <textarea class = "form-control" autocomplete = "off" rows = "3" id = "txt_costmodelremark" name = "txt_costmodelremark"><?= $result_getCostmodel['REMARK'] ?></textarea>
                                                </div>

                                            </div>
                                            <div class = "col-lg-3">
                                                <div class = "form-group">
                                                    <font style = "color: red">* </font><label>สถานะ</label>
                                                    <select class = "form-control" id = "cb_costmodelstatus" name = "cb_costmodelstatus">
                                                        <option value = "">เลือกสถานะ</option>
                                                        <?php
                                                        $selected = "SELECTED";

                                                        switch ($result_getCostmodel['ACTIVESTATUS']) {
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

                            if ($_GET['type'] == "costmodel") {
                                ?>
                                <input type="button" onclick="save_costmodel(<?= $_GET['costmodelid'] ?>);" name="btnSend" id="btnSend" value="<?= $buttonname ?>" class="btn btn-primary">
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

                                <button type="button" class="btn btn-default" onclick="select_stopwork();">ค้นหา <li class="fa fa-search"></li></button>
                            </div>

                        </div>
                   
                    </div>   
 -->
                    <?php
                    if ($_GET['type'] == "costmodel") {
                        ?>
                        <div class="row" >
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                        <font style="font-size: 16px"><b>รายการข้อมูลโมเดลต้นทุน</b></font>                            
                                    </div>
                                    <div class="panel-body">
                                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                            <div class="row">


                                                <div class="col-sm-12">
                                                    <div id="datade">
                                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                            <thead>
                                                            <th rowspan="2" style="text-align: center">ชื่อโมเดล</th>
                                                            <th rowspan="2" style="text-align: center">ประเภทรถ</th>
                                                            <th rowspan="2" style="text-align: center">ประเภทพลังงาน</th>
                                                            <th rowspan="2" style="text-align: center">น้ำหนักบันทุก (ตัน)</th>
                                                            <th colspan="2" style="text-align: center">อัตราการสิ้นเปลืองน้ำมัน </th>
                                                            <th colspan="4" style="text-align: center">อัตราการสึกหรอ</th>
                                                            <th rowspan="2" style="text-align: center" >หมายเหตุ</th>
                                                            <th rowspan="2" style="text-align: center" >สถานะ</th>
                                                            <th rowspan="2" style="text-align: center">จัดการ</th>
                                                            <tr>
                                                                <th style="text-align: center">รถเปล่า (ก.ม./ลิตร)</th>
                                                                <th style="text-align: center">รถมีสินค้า (ก.ม./ลิตร)</th>
                                                                <th style="text-align: center">ยาง (Bath/km)</th>
                                                                <th style="text-align: center">น้ำมันเครื่อง (Bath/km)</th>
                                                                <th style="text-align: center">เบรค (Bath/km)</th>
                                                                <th style="text-align: center">แบตเตอรี่ (Bath/km)</th>
                                                            </tr>

                                                            </thead>

                                                            <tbody>
                                                                <?php
                                                                $sql_seCostmodel = "{call megVehiclecostmodel_v2(?,?)}";
                                                                $params_seCostmodel = array(
                                                                    array('select_vehiclecostmodel', SQLSRV_PARAM_IN),
                                                                    array('', SQLSRV_PARAM_IN)
                                                                );
                                                                $query_seCostmodel = sqlsrv_query($conn, $sql_seCostmodel, $params_seCostmodel);
                                                                while ($result_seCostmodel = sqlsrv_fetch_array($query_seCostmodel, SQLSRV_FETCH_ASSOC)) {
                                                                    ?>
                                                                    <tr class="odd gradeX">
                                                                        <td><?= $result_seCostmodel['MODELNAME'] ?></td>
                                                                        <td><?= $result_seCostmodel['VEHICLETYPEDESC'] ?></td>
                                                                        <td><?= $result_seCostmodel['OILTYPE'] ?></td>
                                                                        <td><?= $result_seCostmodel['CARLOAD'] ?></td>
                                                                        <td><?= $result_seCostmodel['CARNULL'] ?></td>
                                                                        <td><?= $result_seCostmodel['CARNOTNULL'] ?></td>
                                                                        <td><?= $result_seCostmodel['CARRUBBER'] ?></td>
                                                                        <td><?= $result_seCostmodel['CARENGINEOIL'] ?></td>
                                                                        <td><?= $result_seCostmodel['CARBRAKE'] ?></td>
                                                                        <td><?= $result_seCostmodel['CARBATTERY'] ?></td>
                                                                        <td><?= $result_seCostmodel['REMARK'] ?></td>
                                                                        <td><?php echo ($result_seCostmodel['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>
                                                                        <td style="text-align: center">
                                                                            <a href="meg_costmodel.php?type=costmodel&meg=add&companyid=<?=$_GET['companyid']?>&customerid=<?=$_GET['customerid']?>&costmodelid=<?= $result_seCostmodel['VEHICLECOSTMODELID'] ?>" title="แก้ไขข้อมูล" type="button" class="btn btn-default  btn-circle"><span class="glyphicon glyphicon-wrench"></span></a>
                                                                            <button onclick="delete_costmodel(<?= $result_seCostmodel['VEHICLECOSTMODELID'] ?>);" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>

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
        <!--<script src="../dist/js/buttons.colVis.min.js"></script>-->


        <script src="../dist/js/bootstrap-select.js"></script>
        <script src="../dist/js/jquery.autocomplete.js"></script>


        <script>

                                                                                $(document).ready(function () {
                                                                                    $('#dataTables-example').DataTable({
                                                                                        responsive: true,
                                                                                        /*dom: 'Bfrtip',
                                                                                         buttons: [
                                                                                         
                                                                                         {
                                                                                         extend: 'excelHtml5',
                                                                                         exportOptions: {
                                                                                         columns: ':visible'
                                                                                         }
                                                                                         },
                                                                                         
                                                                                         'colvis'
                                                                                         ]*/
                                                                                    });
                                                                                });

        </script>
        <script>
            function chknull_costmodel()
            {
                if (document.getElementById('txt_modelname').value == '')
                {
                    alert('ชื่อโมเดล เป็นค่าว่าง !!!')
                    document.getElementById('txt_modelname').focus();
                    return false;
                } else if (document.getElementById('cb_cartype').value == '')
                {
                    alert('ประเภทรถ เป็นค่าว่าง !!!')
                    document.getElementById('cb_cartype').focus();
                    return false;
                } else if (document.getElementById('cb_oiltype').value == '')
                {
                    alert('ประเภทเชื้อเพลิง เป็นค่าว่าง !!!')
                    document.getElementById('cb_oiltype').focus();
                    return false;
                } else if (document.getElementById('txt_load').value == '')
                {
                    alert('น้ำหนักบันทุก(ตัน) เป็นค่าว่าง !!!')
                    document.getElementById('txt_load').focus();
                    return false;
                } else if (document.getElementById('txt_carnull').value == '')
                {
                    alert('รถเปล่า(ก.ม./ลิตร) เป็นค่าว่าง !!!')
                    document.getElementById('txt_carnull').focus();
                    return false;
                } else if (document.getElementById('txt_carnotnull').value == '')
                {
                    alert('รถมีสินค้าก.ม./ลิตร) เป็นค่าว่าง !!!')
                    document.getElementById('txt_carnotnull').focus();
                    return false;
                } else if (document.getElementById('txt_rubber').value == '')
                {
                    alert('ยาง(Bath/km) เป็นค่าว่าง !!!')
                    document.getElementById('txt_rubber').focus();
                    return false;
                } else if (document.getElementById('txt_engineoil').value == '')
                {
                    alert('น้ำมันเครื่อง(Bath/km) เป็นค่าว่าง !!!')
                    document.getElementById('txt_engineoil').focus();
                    return false;
                } else if (document.getElementById('txt_brake').value == '')
                {
                    alert('เบรค(Bath/km) เป็นค่าว่าง !!!')
                    document.getElementById('txt_brake').focus();
                    return false;
                } else if (document.getElementById('txt_battery').value == '')
                {
                    alert('แบตเตอรี่(Bath/km) เป็นค่าว่าง !!!')
                    document.getElementById('txt_battery').focus();
                    return false;
                } else if (document.getElementById('cb_costmodelstatus').value == '')
                {
                    alert('สถานะ เป็นค่าว่าง !!!')
                    document.getElementById('cb_costmodelstatus').focus();
                    return false;
                } else
                {
                    return true;
                }
            }
            function save_costmodel(costmodelid)
            {
                var modelname = document.getElementById('txt_modelname').value;
                var cartype = document.getElementById('cb_cartype').value;
                var oiltype = document.getElementById('cb_oiltype').value;
                var load = document.getElementById('txt_load').value;
                var carnull = document.getElementById('txt_carnull').value;
                var carnotnull = document.getElementById('txt_carnotnull').value;
                var rubber = document.getElementById('txt_rubber').value;
                var engineoil = document.getElementById('txt_engineoil').value;
                var brake = document.getElementById('txt_brake').value;
                var battery = document.getElementById('txt_battery').value;
                var costmodelremark = document.getElementById('txt_costmodelremark').value;
                var costmodelstatus = document.getElementById('cb_costmodelstatus').value;


                if (chknull_costmodel())
                {
                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "save_vehiclecostmodel", costmodelid: costmodelid, modelname: modelname, cartype: cartype, oiltype: oiltype, load: load, carnull: carnull, carnotnull: carnotnull, rubber: rubber, engineoil: engineoil, brake: brake, battery: battery, costmodelremark: costmodelremark, costmodelstatus: costmodelstatus
                        },
                        success: function (response) {
                            alert(response);
                            window.location.reload();
                        }
                    });
                }
            }
            function delete_costmodel(costmodelid)
            {
                var confirmation = confirm("ต้องการลบข้อมูล ?");

                if (confirmation) {
                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "delete_vehiclecostmodel", costmodelid: costmodelid
                        },
                        success: function () {
                            alert('ลบข้อมูลเรียบร้อยแล้ว');
                            window.location.reload();
                        }
                    });
                }
            }
        </script>


    </body>

</html>
<?php
sqlsrv_close($conn);
?>
