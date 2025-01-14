<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");


$condiCompanyrkrs = " AND OILAVERAGEID = '" . $_GET['oilaverageid'] . "'";
$sql_seCompanyrkrs = "{call megOilaverage_v2(?,?,?,?)}";
$params_seCompanyrkrs = array(
    array('select_oilaverage', SQLSRV_PARAM_IN),
    array($condiCompanyrkrs, SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seCompanyrkrs = sqlsrv_query($conn, $sql_seCompanyrkrs, $params_seCompanyrkrs);
$result_seCompanyrkrs = sqlsrv_fetch_array($query_seCompanyrkrs, SQLSRV_FETCH_ASSOC);

if ($_GET['meg'] == "add") {
    $condComp = " AND Company_Code = '" . $_GET['companycode'] . "'";
    $company = $_GET['companycode'];
} else {
    $condComp = " AND Company_Code = '" . $result_seCompanyrkrs['COMPANYCODE'] . "'";
    $company = $result_seCompanyrkrs['COMPANYCODE'];
}
$sql_seComp = "{call megCompanyEHR_v2(?,?)}";
$params_seComp = array(
    array('select_company', SQLSRV_PARAM_IN),
    array($condComp, SQLSRV_PARAM_IN)
);
$query_seComp = sqlsrv_query($conn, $sql_seComp, $params_seComp);
$result_seComp = sqlsrv_fetch_array($query_seComp, SQLSRV_FETCH_ASSOC);


$buttonname = ($_GET['meg'] == 'edit') ? "แก้ไขข้อมูล" : "บันทึกข้อมูล";
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
                            <i class="glyphicon glyphicon-oil"></i>  
                            ค่าเฉลี่ยน้ำมัน


                        </h2>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color: #e7e7e7">
                                <div class="row" >
                                    <div class="col-lg-6">
                                        <?php
                                        $meg = ($_GET['meg'] == 'add') ? 'เพิ่มข้อมูล' : 'แก้ไขข้อมูล';

                                        echo $_SESSION["link"] . " / " . $meg;
                                        ?>
                                    </div>
                                    <div class="col-lg-6 text-right">
                                        <?= $result_seComp['Company_NameT'] ?>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">

                                <div class="row" >

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <font style="color: red">* </font><label>ลูกค้า</label>
                                            <select class="form-control" id="cb_customercode" name="cb_customercode">
                                                <option value ="-">เลือกลูกค้า</option>
                                                <?php
                                                $condCus = " AND COMPANYCODE = '" . $company . "'";


                                                $sql_seCus = "{call megCustomer_v2(?,?)}";
                                                $params_seCus = array(
                                                    array('select_customerall', SQLSRV_PARAM_IN),
                                                    array($condCus, SQLSRV_PARAM_IN)
                                                );
                                                $query_seCus = sqlsrv_query($conn, $sql_seCus, $params_seCus);
                                                while ($result_seCus = sqlsrv_fetch_array($query_seCus, SQLSRV_FETCH_ASSOC)) {
                                                    $selected = "";
                                                    if ($result_seCus['CUSTOMERCODE'] == $result_seCompanyrkrs['CUSTOMERCODE']) {
                                                        $selected = "selected";
                                                    }
                                                    ?>
                                                    <option value ="<?= $result_seCus['CUSTOMERCODE'] ?>" <?= $selected ?>><?= $result_seCus['NAMETH'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>

                                        </div>
                                    </div>
                                    <?php
                                    if ($company == 'RKR') {
                                        ?>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>ประเภทรภ</label>
                                                <select class="form-control" id="cb_vehicletype" name="cb_vehicletype">
                                                    <option value ="">เลือกประเภทรถ</option>
                                                    <?php
                                                    $condVehicletype = " AND COMPANYCODE = '" . $company . "'";


                                                    $sql_seVehicletype = "{call megOilaverage_v2(?,?)}";
                                                    $params_seVehicletype = array(
                                                        array('select_vehicletyperkr', SQLSRV_PARAM_IN),
                                                        array($condVehicletype, SQLSRV_PARAM_IN)
                                                    );
                                                    $query_seVehicletype = sqlsrv_query($conn, $sql_seVehicletype, $params_seVehicletype);
                                                    while ($result_seVehicletype = sqlsrv_fetch_array($query_seVehicletype, SQLSRV_FETCH_ASSOC)) {
                                                        $selected = "";
                                                        if ($result_seVehicletype['VEHICLETYPE'] == $result_seCompanyrkrs['VEHICLETYPE']) {
                                                            $selected = "selected";
                                                        }
                                                        ?>
                                                        <option value ="<?= $result_seVehicletype['VEHICLETYPE'] ?>" <?= $selected ?>><?= $result_seVehicletype['VEHICLETYPE'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                        </div>


                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>พื้นที่</label>
                                                <select class="form-control" id="cb_location" name="cb_location">
                                                    <option value ="">เลือกพื้นที่</option>
                                                    <option value="amata">อมตะ</option>
                                                        <option value="gateway">เกตุเวย์</option>
                                                </select>

                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($company == 'RKS') {
                                       
                                        ?>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>ประเภทรภ</label>
                                                <select class="form-control" id="cb_vehicletype" name="cb_vehicletype">
                                                    <option value ="">เลือกประเภทรถ</option>
                                                    <?php
                                                    $condVehicletype = " AND COMPANYCODE = '" . $company . "'";


                                                    $sql_seVehicletype = "{call megOilaverage_v2(?,?)}";
                                                    $params_seVehicletype = array(
                                                        array('select_vehicletyperks', SQLSRV_PARAM_IN),
                                                        array($condVehicletype, SQLSRV_PARAM_IN)
                                                    );
                                                    $query_seVehicletype = sqlsrv_query($conn, $sql_seVehicletype, $params_seVehicletype);
                                                    while ($result_seVehicletype = sqlsrv_fetch_array($query_seVehicletype, SQLSRV_FETCH_ASSOC)) {
                                                        $selected = "";
                                                        if ($result_seVehicletype['VEHICLETYPE'] == $result_seCompanyrkrs['VEHICLETYPE']) {
                                                            $selected = "selected";
                                                        }
                                                        ?>
                                                        <option value ="<?= $result_seVehicletype['VEHICLETYPE'] ?>" <?= $selected ?>><?= $result_seVehicletype['VEHICLETYPE'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                        </div>


                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>พื้นที่</label>
                                                <select class="form-control" id="cb_location" name="cb_location">
                                                    <option value ="">เลือกพื้นที่</option>
                                                    <option value="amata">อมตะ</option>
                                                        <option value="gateway">เกตุเวย์</option>
                                                </select>

                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($company == 'RKL') {
                                        ?>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>ประเภทรภ</label>
                                                <select class="form-control" id="cb_vehicletype" name="cb_vehicletype">
                                                    <option value ="">เลือกประเภทรถ</option>
                                                    <?php
                                                    $condVehicletype = " AND COMPANYCODE = '" . $company . "'";


                                                    $sql_seVehicletype = "{call megOilaverage_v2(?,?)}";
                                                    $params_seVehicletype = array(
                                                        array('select_vehicletyperkl', SQLSRV_PARAM_IN),
                                                        array($condVehicletype, SQLSRV_PARAM_IN)
                                                    );
                                                    $query_seVehicletype = sqlsrv_query($conn, $sql_seVehicletype, $params_seVehicletype);
                                                    while ($result_seVehicletype = sqlsrv_fetch_array($query_seVehicletype, SQLSRV_FETCH_ASSOC)) {
                                                        $selected = "";
                                                        if ($result_seVehicletype['VEHICLETYPE'] == $result_seCompanyrkrs['VEHICLETYPE']) {
                                                            $selected = "selected";
                                                        }
                                                        ?>
                                                        <option value ="<?= $result_seVehicletype['VEHICLETYPE'] ?>" <?= $selected ?>><?= $result_seVehicletype['VEHICLETYPE'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                        </div>


                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>พื้นที่</label>
                                                <select class="form-control" id="cb_location" name="cb_location">
                                                    <option value="">เลือกพื้นที่</option>
                                                    <option value="amata">อมตะ</option>
                                                        <option value="gateway">เกตุเวย์</option>
                                                </select>

                                            </div>
                                        </div>
                                        <?php
                                    }

                                    if ($company == 'RCC' || $company == 'RATC') {
                                        ?>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>ประเภทรภ</label>
                                                <select class="form-control" id="cb_vehicletype" name="cb_vehicletype" onchange="select_locationrrc()">
                                                    <?php
                                                    switch ($result_seCompanyrkrs['VEHICLETYPE']) {
                                                        case '4L': {
                                                                ?>
                                                                <option value ="">เลือกประเภทรถ</option>
                                                                <option value ="4L" selected="">4L</option>
                                                                <option value ="8L">8L</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '8L': {
                                                                ?>
                                                                <option value ="">เลือกประเภทรถ</option>
                                                                <option value ="4L">4L</option>
                                                                <option value ="8L" selected="">8L</option>
                                                                <?php
                                                            }
                                                            break;
                                                        default : {
                                                                ?>
                                                                <option value ="">เลือกประเภทรถ</option>
                                                                <option value ="4L">4L</option>
                                                                <option value ="8L">8L</option>
                                                                <?php
                                                            }
                                                            break;
                                                    }
                                                    ?>

                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div id="locationdef">
                                                <div class="form-group">
                                                    <label>พื้นที่</label>
                                                    <select class="form-control" id="cb_location" name="cb_location">
                                                        <option value="">เลือกพื้นที่</option>
                                                        <option value="amata">อมตะ</option>
                                                        <option value="gateway">เกตุเวย์</option>
                                                    </select>

                                                </div>
                                            </div>
                                            <div id="locationsr"></div>
                                        </div>
                                        <?php
                                    }

                                    if ($company == 'RCC_SH' || $company == 'RATC_SH') {
                                        ?>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>ประเภทรภ</label>
                                                <select class="form-control" id="cb_vehicletype" name="cb_vehicletype" onchange="select_locationrrcsh()">

                                                    <?php
                                                    switch ($result_seCompanyrkrs['VEHICLETYPE']) {
                                                        case '4L': {
                                                                ?>
                                                                <option value ="">เลือกประเภทรถ</option>
                                                                <option value ="4L" selected="">4L</option>
                                                                <option value ="8L">8L</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '8L': {
                                                                ?>
                                                                <option value ="">เลือกประเภทรถ</option>
                                                                <option value ="4L">4L</option>
                                                                <option value ="8L" selected="">8L</option>
                                                                <?php
                                                            }
                                                            break;
                                                        default : {
                                                                ?>
                                                                <option value ="">เลือกประเภทรถ</option>
                                                                <option value ="4L">4L</option>
                                                                <option value ="8L">8L</option>
                                                                <?php
                                                            }
                                                            break;
                                                    }
                                                    ?>

                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div id="locationdef">
                                                <div class="form-group">
                                                    <label>พื้นที่</label>
                                                    <select class="form-control" id="cb_location" name="cb_location">
                                                        <option value="">เลือกพื้นที่</option>
                                                        <option value="amata">อมตะ</option>
                                                        <option value="gateway">เกตุเวย์</option>

                                                    </select>

                                                </div>
                                            </div>
                                            <div id="locationsr"></div>
                                        </div>
                                        <?php
                                    }

                                    if ($company == 'RRC') {
                                        ?>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>ประเภทรภ</label>
                                                <select class="form-control" id="cb_vehicletype" name="cb_vehicletype">
                                                    <option value ="">เลือกประเภทรถ</option>
                                                    <?php
                                                    $condVehicletype = " AND COMPANYCODE = '" . $company . "'";


                                                    $sql_seVehicletype = "{call megOilaverage_v2(?,?)}";
                                                    $params_seVehicletype = array(
                                                        array('select_vehicletyperrc', SQLSRV_PARAM_IN),
                                                        array($condVehicletype, SQLSRV_PARAM_IN)
                                                    );
                                                    $query_seVehicletype = sqlsrv_query($conn, $sql_seVehicletype, $params_seVehicletype);
                                                    while ($result_seVehicletype = sqlsrv_fetch_array($query_seVehicletype, SQLSRV_FETCH_ASSOC)) {
                                                        $selected = "";
                                                        if ($result_seVehicletype['VEHICLETYPE'] == $result_seCompanyrkrs['VEHICLETYPE']) {
                                                            $selected = "selected";
                                                        }
                                                        ?>
                                                        <option value ="<?= $result_seVehicletype['VEHICLETYPE'] ?>" <?= $selected ?>><?= $result_seVehicletype['VEHICLETYPE'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                        </div>


                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>พื้นที่</label>
                                                <select class="form-control" id="cb_location" name="cb_location">
                                                    <option value="">เลือกพื้นที่</option>
                                                    <option value="amata">อมตะ</option>
                                                        <option value="gateway">เกตุเวย์</option>
                                                </select>

                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <font style="color: red">* </font><label>ค่าเฉลี่ย</label>
                                            <input class="form-control" type="text"   id="txt_average" name="txt_average" value="<?= $result_seCompanyrkrs['OILAVERAGE'] ?>">

                                        </div>
                                    </div>

                                </div>
                                <div class="row" >
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>หมายเหตุ</label> 
                                            <textarea class="form-control" autocomplete="off" rows="3" id="txt_remark" name="txt_remark" ><?= $result_seCompanyrkrs['REMARK'] ?></textarea>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">

                                        <input type="button"  name="btnSend" id="btnSend" onclick="save_oilaverage('<?= $result_seCompanyrkrs['OILAVERAGEID'] ?>')" value="<?= $buttonname ?>" class="btn btn-primary">




                                    </div>
                                    <div class="col-lg-12">&nbsp;</div>
                                </div>



                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">

                                <div class="row">
                                    <div class="col-lg-12">
                                        รายการข้อมูลราคาน้ำมัน
                                    </div>



                                </div>
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">



                                <div class="row">

                                    <div class="col-md-12">
                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>บริษัท</th>
                                                    <th>ลูกค้า</th>
                                                    <th>ค่าเฉลี่ย</th>
                                                    <th>ประเภทรถ</th>
                                                    <th>พื้นที่</th>
                                                    <th>หมายเหตุ</th>
                                                    <th style="text-align: center">สถานะ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($_GET['meg'] == 'add') {
                                                    $condiCompanyrkr = " AND COMPANYCODE = '" . $_GET['companycode'] . "'";
                                                } else {
                                                    $condiCompanyrkr = " AND OILAVERAGEID = '" . $_GET['oilaverageid'] . "'";
                                                }
                                                $sql_seCompanyrkr = "{call megOilaverage_v2(?,?,?,?)}";
                                                $params_seCompanyrkr = array(
                                                    array('select_oilaverage', SQLSRV_PARAM_IN),
                                                    array($condiCompanyrkr, SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seCompanyrkr = sqlsrv_query($conn, $sql_seCompanyrkr, $params_seCompanyrkr);
                                                while ($result_seCompanyrkr = sqlsrv_fetch_array($query_seCompanyrkr, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <tr class="odd gradeX">
                                                        <td><?= $result_seCompanyrkr['COMPANYCODE'] ?></td>
                                                        <td><?= $result_seCompanyrkr['CUSTOMERCODE'] ?></td>

                                                        <td><?= $result_seCompanyrkr['OILAVERAGE'] ?></td>
                                                        <td><?= $result_seCompanyrkr['VEHICLETYPE'] ?></td>
                                                        <td><?= $result_seCompanyrkr['LOCATION'] ?></td>
                                                        <td><?= $result_seCompanyrkr['REMARK'] ?></td>
                                                        <td style="text-align: center"><?php echo ($result_seCompanyrkr['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>

                                                    </tr>
                                                    <?php
                                                }
                                                ?>



                                            </tbody>


                                        </table>
                                    </div>

                                    <!-- /.panel-body -->
                                </div>



                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>

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

                                            $(function () {
                                                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                // กรณีใช้แบบ input
                                                $(".dateen").datetimepicker({
                                                    timepicker: false,
                                                    format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000			
                                                    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


                                                });
                                            });

                                            $(document).ready(function () {
                                                $('#dataTables-example1').DataTable({
                                                    responsive: true
                                                });
                                            });
                                            function chknull_oilaverage()
                                            {
                                                if (document.getElementById('cb_customercode').value == '')
                                                {
                                                    alert('ลูกค้า เป็นค่าว่าง !!!')
                                                    document.getElementById('cb_customercode').focus();
                                                    return false;
                                                } else if (document.getElementById('txt_average').value == '')
                                                {
                                                    alert('ค่าเฉลี่ย เป็นค่าว่าง !!!')
                                                    document.getElementById('txt_average').focus();
                                                    return false;
                                                } else
                                                {
                                                    return true;
                                                }
                                            }
                                            function save_oilaverage(oilaverageid)
                                            {


                                                var customercode = document.getElementById('cb_customercode').value;
                                                var vehicletype = document.getElementById('cb_vehicletype').value;
                                                var location = document.getElementById('cb_location').value;
                                                var average = document.getElementById('txt_average').value;
                                                var remark = document.getElementById('txt_remark').value;


                                                if (chknull_oilaverage())
                                                {
                                                    $.ajax({
                                                        type: 'post',
                                                        url: 'meg_data.php',
                                                        data: {
                                                            txt_flg: "save_oilaverage", oilaverageid: oilaverageid, company: '<?= $company ?>', customercode: customercode, vehicletype: vehicletype, location: location, average: average, remark: remark

                                                        },
                                                        success: function (response) {
                                                            alert(response);
                                                            window.location.reload();
                                                        }
                                                    });
                                                }
                                            }
                                            function select_locationrrc()
                                            {



                                                $.ajax({
                                                    type: 'post',
                                                    url: 'meg_data.php',
                                                    data: {
                                                        txt_flg: "select_locationrrc", vehicletype: document.getElementById('cb_vehicletype').value, location: '<?= $result_seCompanyrkrs['LOCATION'] ?>'

                                                    },
                                                    success: function (response) {
                                                        if (response)
                                                        {
                                                            document.getElementById("locationsr").innerHTML = response;
                                                            document.getElementById("locationdef").innerHTML = "";

                                                        }
                                                    }
                                                });

                                            }
                                            function select_locationrrcsh()
                                            {



                                                $.ajax({
                                                    type: 'post',
                                                    url: 'meg_data.php',
                                                    data: {
                                                        txt_flg: "select_locationrrcsh", vehicletype: document.getElementById('cb_vehicletype').value, location: '<?= $result_seCompanyrkrs['LOCATION'] ?>'

                                                    },
                                                    success: function (response) {
                                                        if (response)
                                                        {
                                                            document.getElementById("locationsr").innerHTML = response;
                                                            document.getElementById("locationdef").innerHTML = "";

                                                        }
                                                    }
                                                });

                                            }
        </script>


    </body>


</html>


<?php
sqlsrv_close($conn);
?>