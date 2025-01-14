<!DOCTYPE html>
<?php
session_start();
ini_set('max_execution_time', 300);
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if (!isset($_SESSION["USERNAME"]) || !isset($_SESSION["PASSWORD"])) {
    header("location:../pages/meg_login.php?data=3");
}
$sql_seSystime = "{call megGetdate_v2(?)}";
$params_seSystime = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_seSystime = sqlsrv_query($conn, $sql_seSystime, $params_seSystime);
$result_seSystime = sqlsrv_fetch_array($query_seSystime, SQLSRV_FETCH_ASSOC);

$condition1 = "  AND a.PersonID = '" . $_SESSION["EMPLOYEEID"] . "'";
$sql_seEmployee = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmployee = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);

$query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
$result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC);


$cus = "";
$selectgeneral = "";
$selectorganization = "";
$selectgmt = "";
$jobtype = "";
switch ($_GET['customer']) {
    case "c-general": {
            $cus = 'ลูกค้า (ทั่วไป)';
            $selectgeneral = "checked";
            $jobtype = "general";
        }
        break;
    case "c-tenko": {
            $cus = 'ลูกค้า (TENKO)';
            $selectorganization = "checked";
            $jobtype = "tenko";
        }
        break;
    case "c-planning": {
            $cus = 'ลูกค้า (PLANNING)';
            $selectorganization = "checked";
            $jobtype = "planning";
        }
        break;
    case "c-gmt": {
            $cus = 'ลูกค้า (GMT)';
            $selectgmt = "checked";
            $jobtype = "gmt";
        }
        break;
    default : {
            $cus = "";
        }
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
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">
        <link href="../dist/css/select2.min.css" rel="stylesheet">





        <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="js/jquery.form.min.js"></script>


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

            .fileUpload {
                position: relative;
                overflow: hidden;
                margin: 10px;
            }
            .fileUpload input.upload {
                position: absolute;
                top: 0;
                right: 0;
                margin: 0;
                padding: 0;
                font-size: 20px;
                cursor: pointer;
                opacity: 0;
                filter: alpha(opacity=0);
            }

        </style>
    </head>
    <body >

        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header" >
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index2.php"><font style="color: #000;font-size: 14px"><img src="../images/logo.ico" height="30"> <strong>E-Mantenance</strong></font></a>
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
        <input name="txt_vehicleinfopmid"  id="txt_vehicleinfopmid" type="text" style="display: none"/>

        <div class="modal fade" id="modal_updatevehicleinfopm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" style="width: 60%">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">

                        <h5 class="modal-title">แก้ไขรถนำซ่อม</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>ทะเบียน(หัว)</label>
                                    <input name="txt_vehiclenumber1"  id="txt_vehiclenumber1" type="text" class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>ชื่อรถ(หัว)</label>
                                    <input name="txt_vehiclename1"  id="txt_vehiclename1" type="text" class="form-control" readonly="" />
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>ทะเบียน(หาง)</label>
                                    <input name="txt_vehiclenumber"  id="txt_vehiclenumber" type="text" class="form-control" />
                                </div>
                            </div>


                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>ชื่อรถ(หาง)</label>
                                    <input name="txt_vehiclename2"  id="txt_vehiclename2" type="text" class="form-control" readonly="" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>ลูกค้า/สายงาน</label>
                                    <select  class="form-control" id="cb_customer" name="cb_customer">

                                        <?php
                                        $condCustomer1 = " AND AREA='" . $_GET['area'] . "'";
                                        $sql_seCustomer = "{call megVehicleinfopm_v2(?,?)}";
                                        $params_seCustomer = array(
                                            array('select_customerpm', SQLSRV_PARAM_IN),
                                            array($condCustomer1, SQLSRV_PARAM_IN)
                                        );
                                        $query_seCustomer = sqlsrv_query($conn, $sql_seCustomer, $params_seCustomer);
                                        while ($result_seCustomer = sqlsrv_fetch_array($query_seCustomer, SQLSRV_FETCH_ASSOC)) {
                                            ?>
                                            <option value="<?= $result_seCustomer['CUSTOMERCODE'] ?>"><?= $result_seCustomer['CUSTOMERCODE'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>

                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>ประเภทรถ</label>
                                    <select  class="form-control" id="cb_vehicletype" name="cb_vehicletype">

                                        <?php
                                        $condVehicletype1 = " AND AREA='" . $_GET['area'] . "'";
                                        $sql_seVehicletype = "{call megVehicleinfopm_v2(?,?)}";
                                        $params_seVehicletype = array(
                                            array('select_vehicletypepm', SQLSRV_PARAM_IN),
                                            array($condVehicletype1, SQLSRV_PARAM_IN)
                                        );
                                        $query_seVehicletype = sqlsrv_query($conn, $sql_seVehicletype, $params_seVehicletype);
                                        while ($result_seVehicletype = sqlsrv_fetch_array($query_seVehicletype, SQLSRV_FETCH_ASSOC)) {
                                            ?>
                                            <option value="<?= $result_seVehicletype['VEHICLETYPE'] ?>"><?= $result_seVehicletype['VEHICLETYPE'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>เลขไมล์ล่าสุด</label>
                                    <input name="txt_mileage"  id="txt_mileage" type="text" class="form-control"  readonly=""/>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>ผู้รับผิดชอบ</label>
                                    <input name="txt_responsible"   id="txt_responsible" type="text" class="form-control" />
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>กม./วัน</label>
                                    <input name="txt_kmofday"  id="txt_kmofday" type="text" class="form-control" />
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>วันที่ นัดรถเข้าซ่อม</label>
                                    <input name="txt_daterepair"  id="txt_daterepair" type="text" class="form-control datetimeen" readonly=""/>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>เวลา นัดรถเข้าซ่อม</label>
                                    <input name="txt_timerepair"  id="txt_timerepair" type="text" class="form-control timeen" />
                                </div>
                            </div>



                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="update_vehicleinfopm()" >บันทึก</button>
                    </div>

                </div>
            </div>
        </div>


        <div class="row" >
            <div class="col-lg-12">
                &nbsp;
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row" >
            <div class="col-lg-12">
                &nbsp;
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color: #e7e7e7">
                        <div class="row">
                            <div class="col-lg-6">
                                <?php
                                echo $link = "<a href='report_customerpm-1.php?area=" . $_GET['area'] . "'>ลูกค้า</a> / แผนการซ่อมบำรุง (แจ้งซ่อม) ";

                                $_SESSION["link"] = $link;
                                ?>
                            </div>
                            <div class="col-lg-6 text-right"><?= $cus ?></div>
                        </div>
                    </div>
                    <!-- /.panel-heading -->

                    <div class="panel-body">


                        <div class="row" >&nbsp;</div>
                        <div class="row">

                            <div class="col-lg-12" style="text-align: right">



                                <input class="btn btn-default" type="button" style="background-color: orange;border:solid 2px white" id="btn_srquotation" name="btn_srquotation" value=""> แจ้งซ่อม  
                                <input class="btn btn-default" type="button" style="background-color: red;border:solid 2px white" id="btn_srquotation" name="btn_srquotation" value=""> กำลังซ่อม

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#data1" data-toggle="tab" aria-expanded="true">ข้อมูลรถ (ทั้งหมด</a></li>
                                    <li class=""><a href="#data2" data-toggle="tab" aria-expanded="true">ข้อมูลรถ (แจ้งซ่อม)</a></li>

                                </ul>


                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <p>&nbsp;</p>


                                    <div class="tab-pane fade active in" id="data1">

                                        <div class="row" >
                                            <div class="col-lg-2" >
                                                <label>ลูกค้า / สายงาน :</label>

                                                <select  class="form-control" id="cb_customersr" name="cb_customersr">
                                                    <?php
                                                    if ($_GET['area'] == 'AMT') {
                                                        ?>
                                                        <option value="KUBOTA">KUBOTA</option> 
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <option value="RRC">RRC</option> 
                                                        <?php
                                                    }
                                                    ?>

                                                    <?php
                                                    $condRepaircus1 = " AND AREA='" . $_GET['area'] . "' AND CUSTOMERCODE != 'KUBOTA'";
                                                    $sql_seRepaircus = "{call megVehicleinfopm_v2(?,?)}";
                                                    $params_seRepaircus = array(
                                                        array('select_customerpm', SQLSRV_PARAM_IN),
                                                        array($condRepaircus1, SQLSRV_PARAM_IN)
                                                    );
                                                    $query_seRepaircus = sqlsrv_query($conn, $sql_seRepaircus, $params_seRepaircus);
                                                    while ($result_seRepaircus = sqlsrv_fetch_array($query_seRepaircus, SQLSRV_FETCH_ASSOC)) {
                                                        ?>
                                                        <option value="<?= $result_seRepaircus['CUSTOMERCODE'] ?>"><?= $result_seRepaircus['CUSTOMERCODE'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                    <option value="">เลือกทั้งหมด</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 " >
                                                <label>ประเภทรถ :</label>
                                                <select  class="form-control" id="cb_vehicletypesr" name="cb_vehicletypesr">

                                                    <?php
                                                    if ($_GET['area'] == 'AMT') {
                                                        ?>
                                                        <option value="Trailer">Trailer</option>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <option value="10W">10W</option>
                                                        <?php
                                                    }
                                                    ?>



                                                    <?php
                                                    $condRepairvehicletype1 = " AND AREA='" . $_GET['area'] . "' AND VEHICLETYPE != 'Trailer'";
                                                    $sql_seRepairvehicletype = "{call megVehicleinfopm_v2(?,?)}";
                                                    $params_seRepairvehicletype = array(
                                                        array('select_vehicletypepm', SQLSRV_PARAM_IN),
                                                        array($condRepairvehicletype1, SQLSRV_PARAM_IN)
                                                    );
                                                    $query_seRepairvehicletype = sqlsrv_query($conn, $sql_seRepairvehicletype, $params_seRepairvehicletype);
                                                    while ($result_seRepairvehicletype = sqlsrv_fetch_array($query_seRepairvehicletype, SQLSRV_FETCH_ASSOC)) {
                                                        ?>
                                                        <option value="<?= $result_seRepairvehicletype['VEHICLETYPE'] ?>"><?= $result_seRepairvehicletype['VEHICLETYPE'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                    <option value="">เลือกทั้งหมด</option>
                                                </select>
                                            </div>

                                            <div class="col-lg-1" >
                                                <label>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</label>
                                                <button type="button" class="btn btn-primary" onclick="select_vehicleinfopm()">ค้นหา</button>
                                            </div>
                                            <div class="col-lg-7">&nbsp;</div>




                                        </div>
                                        <div class="row" >&nbsp;</div>

                                        <div id="showdatadef">
                                            <div class="row">




                                                <div class="col-lg-12">
                                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                        <table  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example" style="width: 100%;">
                                                            <thead >
                                                                <tr>
                                                                    <th style="text-align: center;"><label style="width: 20px">ลำดับ</label></th>
                                                                    <th style="text-align: center;"><label style="width: 2px">ลบ</label></th>
                                                                    <th style="text-align: center;"><label style="width: 20px">แก้ไข</label></th>
                                                                    <th style="text-align: center;"><label style="width: 20px">ส่งแผน</label></th>
                                                                    <th style="text-align: center;"><label style="width: 20px">สายงาน</label></th>
                                                                    <th style="text-align: center;"><label style="width: 50px">ทะเบียน(หัว)</label></th>
                                                                    <th style="text-align: center;"><label style="width: 50px">ทะเบียน(หาง)</label></th>
                                                                    <th style="text-align: center;"><label style="width: 50px">ชื่อ(หัว)</label></th>
                                                                    <th style="text-align: center;"><label style="width: 50px">ชื่อ(หาง)</label></th>
                                                                    <th style="text-align: center;"><label style="width: 50px">ประเภทรถ</label></th>
                                                                    <th style="text-align: center;"><label style="width: 50px">เลขไมล์ล่าสุด</label></th>
                                                                    <th style="text-align: center;"><label style="width: 50px">เกินระยะ</label></th>
                                                                    <th style="text-align: center;"><label style="width: 50px">กม./วัน</label></th>
                                                                    <th style="text-align: center;"><label style="width: 50px">PM/วัน</label></th>


                                                                    <th style="text-align: center;"><label style="width: 50px">ครั้งต่อไป PM (เลขไมล์)</label></th>
                                                                    <th style="text-align: center;"><label style="width: 50px">Rank PM</label></th>
                                                                    <th style="text-align: center;"><label style="width: 50px">ใช้เวลาในการซ่อม</label></th>
                                                                    <th style="text-align: center;"><label style="width: 50px">วันที่นัดรถเข้าซ่อม</label></th>
                                                                    <th style="text-align: center;"><label style="width: 50px">เวลานัดรถเข้าซ่อม</label></th>




                                                                </tr>

                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $i = 1;
                                                                if ($_GET['area'] == 'AMT') {
                                                                    $condVehicleinfopm = " AND AREA='" . $_GET['area'] . "' AND a.[CUSTOMERCODE]='KUBOTA' AND a.[VEHICLETYPE]='Trailer'";
                                                                } else {
                                                                    $condVehicleinfopm = " AND AREA='" . $_GET['area'] . "' AND a.[CUSTOMERCODE]='RRC' AND a.[VEHICLETYPE]='10W'";
                                                                }

                                                                $sql_seVehicleinfopm = "{call megVehicleinfopm_v2(?,?)}";
                                                                $params_seVehicleinfopm = array(
                                                                    array('select_vehicleinfopm', SQLSRV_PARAM_IN),
                                                                    array($condVehicleinfopm, SQLSRV_PARAM_IN)
                                                                );
                                                                $query_seVehicleinfopm = sqlsrv_query($conn, $sql_seVehicleinfopm, $params_seVehicleinfopm);
                                                                while ($result_seVehicleinfopm = sqlsrv_fetch_array($query_seVehicleinfopm, SQLSRV_FETCH_ASSOC)) {

                                                                    if ($result_seVehicleinfopm['CUSTOMERCODE'] == 'STM') {

                                                                        $sql_seMileagenumbernext1 = "SELECT TOP 1 MILEAGENEXT FROM [dbo].[VEHICLEINFOPMSEND] WHERE VEHICLEREGISNUMBER1 = '" . $result_seVehicleinfopm['VEHICLEREGISNUMBER1'] . "'";
                                                                        $params_seMileagenumbernext1 = array();
                                                                        $query_seMileagenumbernext1 = sqlsrv_query($conn, $sql_seMileagenumbernext1, $params_seMileagenumbernext1);
                                                                        $result_seMileagenumbernext1 = sqlsrv_fetch_array($query_seMileagenumbernext1, SQLSRV_FETCH_ASSOC);

                                                                        $sql_seMileagenumbernext2 = "SELECT TOP 1 MILEAGENEXT FROM VEHICLEINFOPM WHERE VEHICLEREGISNUMBER1 = '" . $result_seVehicleinfopm['VEHICLEREGISNUMBER1'] . "'";
                                                                        $params_seMileagenumbernext2 = array();
                                                                        $query_seMileagenumbernext2 = sqlsrv_query($conn, $sql_seMileagenumbernext2, $params_seMileagenumbernext2);
                                                                        $result_seMileagenumbernext2 = sqlsrv_fetch_array($query_seMileagenumbernext2, SQLSRV_FETCH_ASSOC);

                                                                        if ($result_seMileagenumbernext1['MILEAGENEXT'] > 0) {
                                                                            $mileagenumbernext = $result_seMileagenumbernext1['MILEAGENEXT'];
                                                                        } else {
                                                                            $mileagenumbernext = $result_seMileagenumbernext2['MILEAGENEXT'];
                                                                        }




                                                                        $sql_seMileagenumberrank = "SELECT TOP 1 b.KM FROM [dbo].[REPAIRTIME] a INNER JOIN [dbo].[REPAIRCOST] b ON a.PM=b.PM WHERE b.KM='" . $mileagenumbernext . "'";
                                                                        $params_seMileagenumberrank = array();
                                                                        $query_seMileagenumberrank = sqlsrv_query($conn, $sql_seMileagenumberrank, $params_seMileagenumberrank);
                                                                        $result_seMileagenumberrank = sqlsrv_fetch_array($query_seMileagenumberrank, SQLSRV_FETCH_ASSOC);


                                                                        $sql_seRepairtime = "SELECT TOP 1 a.REPAIRTIME FROM [dbo].[REPAIRTIME] a INNER JOIN [dbo].[REPAIRCOST] b ON a.PM=b.PM WHERE b.KM='" . $mileagenumbernext . "' AND a.VEHICLETYPE='10W'";
                                                                        $params_seRepairtime = array();
                                                                        $query_seRepairtime = sqlsrv_query($conn, $sql_seRepairtime, $params_seRepairtime);
                                                                        $result_seRepairtime = sqlsrv_fetch_array($query_seRepairtime, SQLSRV_FETCH_ASSOC);


                                                                        if ($result_seVehicleinfopm['STATUS'] == 'แจ้งซ่อม') {
                                                                            $color = "style='background-color: orange;color: white' ";
                                                                        } else if ($result_seVehicleinfopm['STATUS'] == 'กำลังซ่อม') {
                                                                            $color = "style='background-color: red;color: white' ";
                                                                        } else {
                                                                            $color = "";
                                                                        }
                                                                        ?>

                                                                        <tr <?= $color ?>>

                                                                            <td style="text-align: center;" ><?= $i ?></td>
                                                                            <td style="text-align: center;"><a href="#"  onclick="delete_vehicleinfopm('<?= $result_seVehicleinfopm['VEHICLEINFOPMID'] ?>')"><span class="fa fa-times"></span></a></td>
                                                                            <td style="text-align: center;" ><a href="#"  onclick="modal_vehicleinfopm('<?= $result_seVehicleinfopm['VEHICLEINFOPMID'] ?>', '<?= $result_seVehicleinfopm['VEHICLEREGISNUMBER1'] ?>', '<?= $result_seVehicleinfopm['THAINAME'] ?>', '<?= $result_seVehicleinfopm['VEHICLEREGISNUMBER2'] ?>', '-', '<?= $result_seVehicleinfopm['CUSTOMERCODE'] ?>', '<?= $result_seVehicleinfopm['VEHICLETYPE'] ?>', '<?= number_format($result_seMileagenumber['MILEAGENUMBER']) ?>', '<?= $result_seVehicleinfopm['RESPONSIBLE'] ?>', '<?= $result_seVehicleinfopm['KMOFDAY'] ?>', '<?= $result_seVehicleinfopm['PMDAY'] ?>', '<?= $result_seVehicleinfopm['ASSIGNDATEIN'] ?>', '<?= $result_seVehicleinfopm['ASSIGNTIMEIN'] ?>')" ><span class="glyphicon glyphicon-wrench"></span></a></td>
                                                                            <td style="text-align: center;">
                                                                                <?php
                                                                                if ($result_seVehicleinfopm['STATUS'] == 'แจ้งซ่อม' || $result_seVehicleinfopm['STATUS'] == 'กำลังซ่อม') {
                                                                                    echo '-';
                                                                                } else {
                                                                                    ?>
                                                                                    <a href="#"  onclick="send_vehicleinfopm('<?= $result_seVehicleinfopm['VEHICLEINFOPMID'] ?>', '<?= $result_seMileagenumber['MILEAGENUMBER'] ?>')" ><span class="fa fa-plus"></span></a>
                                                                                    <?php
                                                                                }
                                                                                ?>

                                                                            </td>

                                                                            <td><?= $result_seVehicleinfopm['CUSTOMERCODE'] ?></td>
                                                                            <td><?= $result_seVehicleinfopm['VEHICLEREGISNUMBER1'] ?></td>
                                                                            <td><?= $result_seVehicleinfopm['VEHICLEREGISNUMBER2'] ?></td>
                                                                            <td><?= $result_seVehicleinfopm['THAINAME'] ?></td>
                                                                            <td>-</td>
                                                                            <td><?= $result_seVehicleinfopm['VEHICLETYPE'] ?></td>
                                                                            <td><?= number_format($mileagenumbernext) ?></td>
                                                                            <td>0</td>
                                                                            <td><?=$result_seVehicleinfopm['KMOFDAY']?></td>
                                                                            <td>0</td>

                                                                            <td><?= $mileagenumbernext+ 10000 ?></td>
                                                                            <td><?= $mileagenumbernext+ 10000 ?></td>
                                                                            <td><?= $result_seRepairtime['REPAIRTIME'] ?></td>
                                                                            <td><?= $result_seVehicleinfopm['ASSIGNDATEIN'] ?></td>
                                                                            <td><?= $result_seVehicleinfopm['ASSIGNTIMEIN'] ?></td>
                                                                        </tr>

                                                                        <?php
                                                                    } else {
                                                                        $sql_seMileagenumber = "SELECT TOP 1 MILEAGENUMBER FROM [61.91.5.110].RTMS.[dbo].[MILEAGE] 
                                                                        WHERE MILEAGETYPE='MILEAGEEND' AND VEHICLEREGISNUMBER='" . $result_seVehicleinfopm['VEHICLEREGISNUMBER1'] . "'
                                                                            AND CONVERT(DATETIME,CREATEDATE) = (SELECT TOP 1 CONVERT(DATETIME,CREATEDATE) FROM [61.91.5.110].RTMS.[dbo].[MILEAGE] WHERE MILEAGETYPE='MILEAGEEND' AND VEHICLEREGISNUMBER='" . $result_seVehicleinfopm['VEHICLEREGISNUMBER1'] . "' ORDER BY CREATEDATE DESC) ";
                                                                        $params_seMileagenumber = array();
                                                                        $query_seMileagenumber = sqlsrv_query($conn, $sql_seMileagenumber, $params_seMileagenumber);
                                                                        $result_seMileagenumber = sqlsrv_fetch_array($query_seMileagenumber, SQLSRV_FETCH_ASSOC);

                                                                        $sql_seMileagenumbernext = "SELECT TOP 1 CONVERT(INT,KM) AS 'KM' FROM [dbo].[REPAIRCOST] WHERE CONVERT(INT,KM) > " . $result_seMileagenumber['MILEAGENUMBER'] . " ORDER BY CONVERT(INT,KM) ASC";
                                                                        $params_seMileagenumbernext = array();
                                                                        $query_seMileagenumbernext = sqlsrv_query($conn, $sql_seMileagenumbernext, $params_seMileagenumbernext);
                                                                        $result_seMileagenumbernext = sqlsrv_fetch_array($query_seMileagenumbernext, SQLSRV_FETCH_ASSOC);

                                                                        $sql_seMileagenumberrank = "SELECT TOP 1 b.KM FROM [dbo].[REPAIRTIME] a INNER JOIN [dbo].[REPAIRCOST] b ON a.PM=b.PM WHERE b.KM='" . $result_seMileagenumbernext['KM'] . "'";
                                                                        $params_seMileagenumberrank = array();
                                                                        $query_seMileagenumberrank = sqlsrv_query($conn, $sql_seMileagenumberrank, $params_seMileagenumberrank);
                                                                        $result_seMileagenumberrank = sqlsrv_fetch_array($query_seMileagenumberrank, SQLSRV_FETCH_ASSOC);

                                                                        if ($result_seVehicleinfopm['VEHICLETYPE'] == 'Semi Trailer' || $result_seVehicleinfopm['VEHICLETYPE'] == 'Trailer' || $result_seVehicleinfopm['VEHICLETYPE'] == 'Trailer Flat Bad' || $result_seVehicleinfopm['VEHICLETYPE'] == 'เทรลเลอร์') {
                                                                            $sql_seRepairtime = "SELECT TOP 1 a.REPAIRTIME FROM [dbo].[REPAIRTIME] a INNER JOIN [dbo].[REPAIRCOST] b ON a.PM=b.PM WHERE b.KM='" . $result_seMileagenumbernext['KM'] . "' AND a.VEHICLETYPE='Trailer'";
                                                                            $params_seRepairtime = array();
                                                                            $query_seRepairtime = sqlsrv_query($conn, $sql_seRepairtime, $params_seRepairtime);
                                                                            $result_seRepairtime = sqlsrv_fetch_array($query_seRepairtime, SQLSRV_FETCH_ASSOC);
                                                                        } else {
                                                                            $sql_seRepairtime = "SELECT TOP 1 a.REPAIRTIME FROM [dbo].[REPAIRTIME] a INNER JOIN [dbo].[REPAIRCOST] b ON a.PM=b.PM WHERE b.KM='" . $result_seMileagenumbernext['KM'] . "' AND a.VEHICLETYPE='10W'";
                                                                            $params_seRepairtime = array();
                                                                            $query_seRepairtime = sqlsrv_query($conn, $sql_seRepairtime, $params_seRepairtime);
                                                                            $result_seRepairtime = sqlsrv_fetch_array($query_seRepairtime, SQLSRV_FETCH_ASSOC);
                                                                        }

                                                                        if ($result_seVehicleinfopm['STATUS'] == 'แจ้งซ่อม') {
                                                                            $color = "style='background-color: orange;color: white' ";
                                                                        } else if ($result_seVehicleinfopm['STATUS'] == 'กำลังซ่อม') {
                                                                            $color = "style='background-color: red;color: white' ";
                                                                        } else {
                                                                            $color = "";
                                                                        }
                                                                        ?>

                                                                        <tr <?= $color ?>>

                                                                            <td style="text-align: center;" ><?= $i ?></td>
                                                                            <td style="text-align: center;"><a href="#"  onclick="delete_vehicleinfopm('<?= $result_seVehicleinfopm['VEHICLEINFOPMID'] ?>')"><span class="fa fa-times"></span></a></td>
                                                                            <td style="text-align: center;" ><a href="#"  onclick="modal_vehicleinfopm('<?= $result_seVehicleinfopm['VEHICLEINFOPMID'] ?>', '<?= $result_seVehicleinfopm['VEHICLEREGISNUMBER1'] ?>', '<?= $result_seVehicleinfopm['THAINAME'] ?>', '<?= $result_seVehicleinfopm['VEHICLEREGISNUMBER2'] ?>', '-', '<?= $result_seVehicleinfopm['CUSTOMERCODE'] ?>', '<?= $result_seVehicleinfopm['VEHICLETYPE'] ?>', '<?= number_format($result_seMileagenumber['MILEAGENUMBER']) ?>', '<?= $result_seVehicleinfopm['RESPONSIBLE'] ?>', '<?= $result_seVehicleinfopm['KMOFDAY'] ?>', '<?= $result_seVehicleinfopm['PMDAY'] ?>', '<?= $result_seVehicleinfopm['ASSIGNDATEIN'] ?>', '<?= $result_seVehicleinfopm['ASSIGNTIMEIN'] ?>')" ><span class="glyphicon glyphicon-wrench"></span></a></td>
                                                                            <td style="text-align: center;">
                                                                                <?php
                                                                                if ($result_seVehicleinfopm['STATUS'] == 'แจ้งซ่อม' || $result_seVehicleinfopm['STATUS'] == 'กำลังซ่อม') {
                                                                                    echo '-';
                                                                                } else {
                                                                                    ?>
                                                                                    <a href="#"  onclick="send_vehicleinfopm('<?= $result_seVehicleinfopm['VEHICLEINFOPMID'] ?>', '<?= $result_seMileagenumber['MILEAGENUMBER'] ?>')" ><span class="fa fa-plus"></span></a>
                                                                                    <?php
                                                                                }
                                                                                ?>

                                                                            </td>

                                                                            <td><?= $result_seVehicleinfopm['CUSTOMERCODE'] ?></td>
                                                                            <td><?= $result_seVehicleinfopm['VEHICLEREGISNUMBER1'] ?></td>
                                                                            <td><?= $result_seVehicleinfopm['VEHICLEREGISNUMBER2'] ?></td>
                                                                            <td><?= $result_seVehicleinfopm['THAINAME'] ?></td>
                                                                            <td>-</td>
                                                                            <td><?= $result_seVehicleinfopm['VEHICLETYPE'] ?></td>
                                                                            <td><?= number_format($result_seMileagenumber['MILEAGENUMBER']) ?></td>
                                                                            <td><?= $result_seMileagenumber['MILEAGENUMBER'] - $result_seMileagenumbernext['KM'] ?></td>
                                                                            <td><?= $result_seVehicleinfopm['KMOFDAY'] ?></td>
                                                                            <td><?= number_format(($result_seMileagenumber['MILEAGENUMBER'] - $result_seMileagenumbernext['KM']) / $result_seVehicleinfopm['KMOFDAY']) ?></td>

                                                                            <td><?= $result_seMileagenumbernext['KM'] ?></td>
                                                                            <td><?= $result_seMileagenumberrank['KM'] ?></td>
                                                                            <td><?= $result_seRepairtime['REPAIRTIME'] ?></td>
                                                                            <td><?= $result_seVehicleinfopm['ASSIGNDATEIN'] ?></td>
                                                                            <td><?= $result_seVehicleinfopm['ASSIGNTIMEIN'] ?></td>
                                                                        </tr>


                                                                        <?php
                                                                    }

                                                                    $i++;
                                                                }
                                                                ?>
                                                            </tbody>

                                                        </table>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div id="showdatasr"></div>
                                    </div>

                                    <div class="tab-pane fade " id="data2">
                                        <div class="row">


                                            <div class="col-lg-2">วันที่เริ่มต้น
                                                <input type="text" value="<?= $result_seSystime['SYSDATE'] ?>" onchange="datetodate()" name="txt_datestartsr" readonly="" id="txt_datestartsr"  class="form-control dateen">
                                            </div>

                                            <div class="col-lg-2">วันที่สิ้นสุด
                                                <input type="text" value="<?= $result_seSystime['SYSDATE'] ?>" name="txt_dateendsr"  readonly="" id="txt_dateendsr" class="form-control dateen">
                                            </div>
                                            <div class="col-lg-1">
                                                <label>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</label>
                                                <button type="button" class="btn btn-primary" onclick="select_vehicleinfopmsend()">ค้นหา</button>
                                            </div>
                                        </div>
                                        <div class="row">&nbsp;</div>
                                        <div id="showdatasenddef">
                                            <div class="row">




                                                <div class="col-lg-12">
                                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                        <table  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example2" role="grid" aria-describedby="dataTables-example" style="width: 100%;">
                                                            <thead >
                                                                <tr>
                                                                    <th style="text-align: center;"><label style="width: 20px">ลำดับ</label></th>
                                                                    <th style="text-align: center;"><label style="width: 20px">สถานะ</label></th>
                                                                    <th style="text-align: center;"><label style="width: 120px">สายงาน</label></th>
                                                                    <th style="text-align: center;"><label style="width: 120px">ทะเบียน(หัว)</label></th>
                                                                    <th style="text-align: center;"><label style="width: 120px">ทะเบียน(หาง)</label></th>
                                                                    <th style="text-align: center;"><label style="width: 120px">ชื่อ(หัว)</label></th>
                                                                    <th style="text-align: center;"><label style="width: 120px">ชื่อ(หาง)</label></th>
                                                                    <th style="text-align: center;"><label style="width: 120px">ประเภทรถ</label></th>
                                                                    <th style="text-align: center;"><label style="width: 120px">เลขไมล์ล่าสุด</label></th>
                                                                    <th style="text-align: center;"><label style="width: 120px">เกินระยะ</label></th>
                                                                    <th style="text-align: center;"><label style="width: 120px">กม./วัน</label></th>
                                                                    <th style="text-align: center;"><label style="width: 120px">PM/วัน</label></th>
                                                                    <th style="text-align: center;"><label style="width: 120px">ครั้งต่อไป PM (เลขไมล์)</label></th>
                                                                    <th style="text-align: center;"><label style="width: 120px">Rank PM</label></th>
                                                                    <th style="text-align: center;"><label style="width: 120px">ใช้เวลาในการซ่อม</label></th>
                                                                    <th style="text-align: center;"><label style="width: 120px">วันที่นัดรถเข้าซ่อม</label></th>
                                                                    <th style="text-align: center;"><label style="width: 120px">เวลานัดรถเข้าซ่อม</label></th>




                                                                </tr>

                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $i = 1;

                                                                $cond1 = " AND (b.REPAIRSTATUS='แจ้งซ่อม' OR b.REPAIRSTATUS='กำลังซ่อม') AND a.[AREA]='" . $_GET['area'] . "'";
                                                                $cond2 = " AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $result_seSystime['SYSDATE'] . "',103) AND CONVERT(DATE,'" . $result_seSystime['SYSDATE'] . "',103)";
                                                                $sql_seVehicleinfosendpm = "{call megVehicleinfopmsend_v2(?,?,?)}";
                                                                $params_seVehicleinfosendpm = array(
                                                                    array('select_vehicleinfopmsend', SQLSRV_PARAM_IN),
                                                                    array($cond1, SQLSRV_PARAM_IN),
                                                                    array($cond2, SQLSRV_PARAM_IN)
                                                                );
                                                                $query_seVehicleinfosendpm = sqlsrv_query($conn, $sql_seVehicleinfosendpm, $params_seVehicleinfosendpm);
                                                                while ($result_seVehicleinfosendpm = sqlsrv_fetch_array($query_seVehicleinfosendpm, SQLSRV_FETCH_ASSOC)) {
                                                                    ?>

                                                                    <tr>

                                                                        <td style="text-align: center;" ><?= $i ?></td>
                                                                        <td style="text-align: center;"><?= $result_seVehicleinfosendpm['REPAIRSTATUS'] ?></td>
                                                                        <td><?= $result_seVehicleinfosendpm['CUSTOMERCODE'] ?></td>
                                                                        <td><?= $result_seVehicleinfosendpm['VEHICLEREGISNUMBER1'] ?></td>
                                                                        <td><?= $result_seVehicleinfosendpm['VEHICLEREGISNUMBER2'] ?></td>
                                                                        <td><?= $result_seVehicleinfosendpm['THAINAME'] ?></td>
                                                                        <td>-</td>
                                                                        <td><?= $result_seVehicleinfosendpm['VEHICLETYPE'] ?></td>
                                                                        <td><?= $result_seVehicleinfosendpm['RANKPMAC'] ?></td>
                                                                        <td><?= $result_seVehicleinfosendpm['RANKPMAC'] - $result_seVehicleinfosendpm['RANKPMNEXT'] ?></td>
                                                                        <td><?= $result_seVehicleinfosendpm['KMOFDAY'] ?></td>
                                                                        <td><?= number_format(($result_seVehicleinfosendpm['RANKPMAC'] - $result_seVehicleinfosendpm['RANKPMNEXT']) / $result_seVehicleinfosendpm['KMOFDAY'], 2) ?></td>
                                                                        <td><?= $result_seVehicleinfosendpm['RANKPMNEXT'] ?></td>
                                                                        <td><?= $result_seVehicleinfosendpm['RANKPM'] ?></td>
                                                                        <td><?= $result_seVehicleinfosendpm['REPAIRTIME'] ?></td>
                                                                        <td><?= $result_seVehicleinfosendpm['ASSIGNDATEIN'] ?></td>
                                                                        <td><?= $result_seVehicleinfosendpm['ASSIGNTIMEIN'] ?></td>
                                                                    </tr>
                                                                    <?php
                                                                    $i++;
                                                                }
                                                                ?>
                                                            </tbody>


                                                        </table>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div id="showdatasendsr"></div>
                                    </div>
                                </div>
                            </div>
                        </div>









                    </div>
                </div>
            </div>
        </div>









        <?php
        if ($_GET['area'] == 'GW') {
            $thainame = select_carautocomplate('megVehicleinfo_v2', 'selectcond_vehicleinfo', " AND a.THAINAME != '-' AND (a.ENGNAME  LIKE '%R-%' OR a.ENGNAME  LIKE '%RA-%'", " OR a.THAINAME LIKE '%ดินแดง%'  OR a.THAINAME  LIKE '%อุทัยธานี%'  OR a.THAINAME  LIKE '%คลองเขื่อน%'  ", " OR a.THAINAME LIKE '%RP-%' OR a.THAINAME  LIKE '%สวนผึ้ง%' OR a.THAINAME  LIKE '%ด่านช้าง%'", " OR a.ENGNAME LIKE '%Khao Chamao%' OR a.ENGNAME LIKE '%Kerry%' OR a.ENGNAME LIKE '%Chaloem Prakiat%' OR a.THAINAME LIKE '%แปลงยาว%' OR a.THAINAME LIKE '%สนามชัยเขต%' OR a.THAINAME LIKE '%วานรนิวาส%' OR a.THAINAME LIKE '%เฉลิมพระเกียรติ%')");
        } else {
            $thainame = select_vehiclenumberautocomplate('megVehicleinfo_v2', 'select_vehicleinfo', '');
        }
        $emp = select_empautocomplate();
        $comp = select_company();
        ?>
 <!--<script src="../vendor/jquery/jquery.min.js"></script>-->
        <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="../vendor/metisMenu/metisMenu.min.js"></script>
        <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
        <script src="../dist/js/sb-admin-2.js"></script>
        <script src="../js/jquery.datetimepicker.full.js"></script>
        <script src="../dist/js/jquery.autocomplete.js"></script>
        <script src="../dist/js/bootstrap-select.js"></script>
        <script src="../dist/js/select2.js"></script>



        <script src="../vendor/raphael/raphael.min.js"></script>

        <script src="../dist/js/jszip.min.js"></script>
        <script src="../dist/js/dataTables.buttons.min.js"></script>
        <script src="../dist/js/buttons.html5.min.js"></script>
        <script src="../dist/js/buttons.print.min.js"></script>

    </body>

    <script>function datetodate()
                                                    {
                                                        document.getElementById('txt_dateendsr').value = document.getElementById('txt_datestartsr').value;

                                                    }
                                                    function select_vehicleinfopmsend()
                                                    {


                                                        $.ajax({
                                                            type: 'post',
                                                            url: 'meg_data.php',
                                                            data: {
                                                                txt_flg: "select_vehicleinfopmsend",
                                                                datestart: document.getElementById('txt_datestartsr').value,
                                                                dateend: document.getElementById('txt_dateendsr').value,
                                                                area: '<?= $_GET['area'] ?>'
                                                            },
                                                            success: function (rs) {



                                                                document.getElementById("showdatasendsr").innerHTML = rs;
                                                                document.getElementById("showdatasenddef").innerHTML = "";

                                                                $(document).ready(function () {
                                                                    $('#dataTables-example2').DataTable({

                                                                        order: [[0, "asc"]],
                                                                        scrollX: true,
                                                                        scrollY: '500px',
                                                                    });
                                                                });




                                                            }
                                                        });
                                                    }

                                                    function select_vehicleinfopm()
                                                    {


                                                        $.ajax({
                                                            type: 'post',
                                                            url: 'meg_data.php',
                                                            data: {
                                                                txt_flg: "select_vehicleinfopm",
                                                                customercode: document.getElementById('cb_customersr').value,
                                                                vehicletype: document.getElementById('cb_vehicletypesr').value,
                                                                area: '<?= $_GET['area'] ?>'

                                                            },
                                                            success: function (rs) {



                                                                document.getElementById("showdatasr").innerHTML = rs;
                                                                document.getElementById("showdatadef").innerHTML = "";
                                                                $(document).ready(function () {
                                                                    $('#dataTables-example').DataTable({

                                                                        order: [[13, "desc"]],
                                                                        scrollX: true,
                                                                        paging: false
                                                                    });
                                                                });





                                                            }
                                                        });
                                                    }


                                                    function modal_vehicleinfopm(id, vehiclenumber1, vehiclename1, vehiclenumber, vehiclename2, customer, vehicletype, mileage, responsible, kmofday, datepm, daterepair, timerepair)
                                                    {

                                                        document.getElementById('txt_vehicleinfopmid').value = id;
                                                        document.getElementById('txt_vehiclenumber1').value = vehiclenumber1;
                                                        document.getElementById('txt_vehiclename1').value = vehiclename1;
                                                        document.getElementById('txt_vehiclenumber').value = vehiclenumber;
                                                        document.getElementById('txt_vehiclename2').value = vehiclename2;
                                                        document.getElementById('cb_customer').value = customer;
                                                        document.getElementById('cb_vehicletype').value = vehicletype;
                                                        document.getElementById('txt_mileage').value = mileage;
                                                        document.getElementById('txt_responsible').value = responsible;


                                                        document.getElementById('txt_kmofday').value = kmofday;

                                                        document.getElementById('txt_daterepair').value = daterepair;
                                                        document.getElementById('txt_timerepair').value = timerepair;


                                                        $("#modal_updatevehicleinfopm").modal()
                                                    }
                                                    function send_vehicleinfopm(id, mileage)
                                                    {

                                                        $.ajax({
                                                            type: 'post',
                                                            url: 'meg_data.php',
                                                            data: {
                                                                txt_flg: "insert_vehicleinfopm",
                                                                id: id, mileage: mileage, area: '<?= $_GET['area'] ?>'
                                                            },
                                                            success: function () {


                                                                select_vehicleinfopm();



                                                            }
                                                        });
                                                    }



                                                    function update_vehicleinfopm()
                                                    {

                                                        $.ajax({
                                                            type: 'post',
                                                            url: 'meg_data.php',
                                                            data: {
                                                                txt_flg: "update_vehicleinfopm",
                                                                id: document.getElementById('txt_vehicleinfopmid').value,
                                                                vehiclenumber1: document.getElementById('txt_vehiclenumber1').value,
                                                                vehiclename1: document.getElementById('txt_vehiclename1').value,
                                                                vehiclenumber: document.getElementById('txt_vehiclenumber').value,
                                                                vehiclename2: document.getElementById('txt_vehiclename2').value,
                                                                customer: document.getElementById('cb_customer').value,
                                                                vehicletype: document.getElementById('cb_vehicletype').value,
                                                                mileage: document.getElementById('txt_mileage').value,
                                                                responsible: document.getElementById('txt_responsible').value,
                                                                kmofday: document.getElementById('txt_kmofday').value,
                                                                datepm: '',
                                                                daterepair: document.getElementById('txt_daterepair').value,
                                                                timerepair: document.getElementById('txt_timerepair').value
                                                            },
                                                            success: function (rs) {

                                                                alert(rs);
                                                                select_vehicleinfopm();


                                                            }
                                                        });

                                                    }
                                                    function delete_vehicleinfopm(id)
                                                    {
                                                        var r = confirm("ต้องการลบข้อมูล ?");
                                                        if (r == true) {
                                                            $.ajax({
                                                                type: 'post',
                                                                url: 'meg_data.php',
                                                                data: {
                                                                    txt_flg: "delete_vehicleinfopm", id: id
                                                                },
                                                                success: function (rs) {

                                                                    alert(rs);
                                                                    select_vehicleinfopm();

                                                                }
                                                            });
                                                        }
                                                    }




                                                    $(function () {
                                                        $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                        // กรณีใช้แบบ input
                                                        $(".dateen").datetimepicker({
                                                            timepicker: true,
                                                            format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                                            lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                            timeFormat: "HH:mm"

                                                        });
                                                    });

                                                    $(function () {
                                                        $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                        // กรณีใช้แบบ input
                                                        $(".datetimeen").datetimepicker({
                                                            timepicker: false,
                                                            format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00 - 00 - 0000
                                                            lang: 'th',

                                                        }
                                                        );
                                                    });
                                                    $(function () {
                                                        $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ. // กรณีใช้แบบ input
                                                        $(".timeen").datetimepicker({
                                                            datepicker: false,
                                                            format: 'H:i',
                                                            //mask: '29:59',
                                                            lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                        });
                                                    });


                                                    $(document).ready(function () {
                                                        $('#dataTables-example').DataTable({

                                                            order: [[13, "desc"]],
                                                            scrollX: true,
                                                            paging: false
                                                        });
                                                    });

                                                    $(document).ready(function () {
                                                        $('#dataTables-example2').DataTable({

                                                            order: [[0, "asc"]],
                                                            scrollX: true,
                                                            scrollY: '500px',
                                                        });
                                                    });








    </script>
</html>
<?php
sqlsrv_close($conn);
?>
