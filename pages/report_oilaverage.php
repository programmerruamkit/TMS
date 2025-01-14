
<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
ini_set('max_execution_time', 300);
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
        <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
        <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

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

                        <h2 class="page-header">
                            <i class="glyphicon glyphicon-oil"></i>  
                            ข้อมูลค่าเฉลี่ยน้ำมัน


                        </h2>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">

                                <div class="row">
                                    <div class="col-lg-12">
                                        <?php
                                        echo "ข้อมูลค่าเฉลี่ยน้ำมัน";
                                        $link = "<a href='report_oilaverage.php'>ข้อมูลค่าเฉลี่ยน้ำมัน</a>";
                                        $_SESSION["link"] = $link;
                                        ?>
                                    </div>



                                </div>
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <!-- Nav tabs -->
                                <ul class="nav nav-pills">
                                    <li class="active">
                                        <a href="#tap_comp1" data-toggle="tab" aria-expanded="true">(RKR) - ร่วมกิจรุ่งเรือง (1993)</a>
                                    </li>

                                    <li>
                                        <a href="#tap_comp2" data-toggle="tab">(RKS) - ร่วมกิจรุ่งเรือง เซอร์วิส</a>
                                    </li>
                                    <li>
                                        <a href="#tap_comp3" data-toggle="tab">(RKL) - ร่วมกิจรุ่งเรือง โลจิสติคส์</a>
                                    </li>
                                    <li>
                                        <a href="#tap_comp4" data-toggle="tab">(RCC) - ร่วมกิจรุ่งเรือง คาร์ แคริเออร์</a>
                                    </li>
                                     <li>
                                        <a href="#tap_comp4_1" data-toggle="tab">(RCC) - ร่วมกิจรุ่งเรือง คาร์ แคริเออร์(SH)</a>
                                    </li>
                                    <li>
                                        <a href="#tap_comp5" data-toggle="tab">(RATC) - ร่วมกิจ ออโตโมทีฟ ทรานสปอร์ต</a>
                                    </li>
                                     <li>
                                        <a href="#tap_comp5_1" data-toggle="tab">(RATC) - ร่วมกิจ ออโตโมทีฟ ทรานสปอร์ต(SH)</a>
                                    </li>
                                    <li>
                                        <a href="#tap_comp6" data-toggle="tab">(RRC) - ร่วมกิจ รีไซเคิล แคริเออร์</a>
                                    </li>


                                </ul>
                                <div class="tab-content">
                                    <div class="row">
                                        <div class="col-md-12">&nbsp;</div>
                                    </div>
                                    <div class="tab-pane fade active in" id="tap_comp1">
                                        <div class="row">

                                            <div class="col-md-12">
                                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                    <thead>
                                                        <tr>

                                                            <th>ลูกค้า</th>
                                                              <th>ประเภทรถ</th>
                                                             <th>พื้นที่</th>
                                                            <th>ค่าเฉลี่ย</th>
                                                            <th>หมายเหตุ</th>
                                                            <th style="text-align: center">สถานะการใช้งาน</th>
                                                            <th style="text-align: center"><a href="meg_oilaverage.php?meg=add&companycode=RKR"><li class="fa fa-plus-square"></li> เพิ่มค่าเฉลี่ยน้ำมัน</a></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $condiCompanyrkr = " AND COMPANYCODE = 'RKR'";
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

                                                                <td><?= $result_seCompanyrkr['CUSTOMERCODE'] ?></td>
                                                                <td><?= $result_seCompanyrkr['VEHICLETYPE'] ?></td>
                                                                <td><?= $result_seCompanyrkr['LOCATION'] ?></td>
                                                                <td><?= $result_seCompanyrkr['OILAVERAGE'] ?></td>
                                                                <td><?= $result_seCompanyrkr['REMARK'] ?></td>
                                                                <td style="text-align: center"><?php echo ($result_seCompanyrkr['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>
                                                                <td style="text-align: center">
                                                                    <a href="meg_oilaverage.php?meg=edit&oilaverageid=<?= $result_seCompanyrkr['OILAVERAGEID'] ?>" title="แก้ไขข้อมูล" type="button" class="btn btn-default  btn-circle"><span class="glyphicon glyphicon-wrench"></span></a>
                                                                    <button onclick="delete_oilaverage(<?= $result_seCompanyrkr['OILAVERAGEID'] ?>);" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>

                                                                </td>
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
                                    <div class="tab-pane fad" id="tap_comp2">
                                        <div class="row">

                                            <div class="col-md-12">
                                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example2" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                    <thead>
                                                        <tr>

                                                            <th>ลูกค้า</th>
                                                            <th>ประเภทรถ</th>
                                                             <th>พื้นที่</th>
                                                            <th>ค่าเฉลี่ย</th>
                                                            <th>หมายเหตุ</th>
                                                            <th style="text-align: center">สถานะการใช้งาน</th>
                                                            <th style="text-align: center"><a href="meg_oilaverage.php?meg=add&companycode=RKS"><li class="fa fa-plus-square"></li> เพิ่มค่าเฉลี่ยน้ำมัน</a></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $condiCompanyrks = " AND COMPANYCODE = 'RKS'";
                                                        $sql_seCompanyrks = "{call megOilaverage_v2(?,?,?,?)}";
                                                        $params_seCompanyrks = array(
                                                            array('select_oilaverage', SQLSRV_PARAM_IN),
                                                            array($condiCompanyrks, SQLSRV_PARAM_IN),
                                                            array('', SQLSRV_PARAM_IN),
                                                            array('', SQLSRV_PARAM_IN)
                                                        );
                                                        $query_seCompanyrks = sqlsrv_query($conn, $sql_seCompanyrks, $params_seCompanyrks);
                                                        while ($result_seCompanyrks = sqlsrv_fetch_array($query_seCompanyrks, SQLSRV_FETCH_ASSOC)) {
                                                            ?>
                                                            <tr class="odd gradeX">

                                                                <td><?= $result_seCompanyrks['CUSTOMERCODE'] ?></td>
                                                                <td><?= $result_seCompanyrks['VEHICLETYPE'] ?></td>
                                                                <td><?= $result_seCompanyrks['LOCATION'] ?></td>
                                                                <td><?= $result_seCompanyrks['OILAVERAGE'] ?></td>
                                                                <td><?= $result_seCompanyrks['REMARK'] ?></td>
                                                                <td style="text-align: center"><?php echo ($result_seCompanyrks['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>
                                                                <td style="text-align: center">
                                                                    <a href="meg_oilaverage.php?meg=edit&oilaverageid=<?= $result_seCompanyrks['OILAVERAGEID'] ?>" title="แก้ไขข้อมูล" type="button" class="btn btn-default  btn-circle"><span class="glyphicon glyphicon-wrench"></span></a>
                                                                    <button onclick="delete_oilaverage(<?= $result_seCompanyrks['OILAVERAGEID'] ?>);" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>

                                                                </td>
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
                                    <div class="tab-pane fad" id="tap_comp3">
                                        <div class="row">

                                            <div class="col-md-12">
                                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example3" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                    <thead>
                                                        <tr>

                                                            <th>ลูกค้า</th>
                                                              <th>ประเภทรถ</th>
                                                            <th>พื้นที่</th>
                                                            <th>ค่าเฉลี่ย</th>
                                                            <th>หมายเหตุ</th>
                                                            <th style="text-align: center">สถานะการใช้งาน</th>
                                                            <th style="text-align: center"><a href="meg_oilaverage.php?meg=add&companycode=RKL"><li class="fa fa-plus-square"></li> เพิ่มค่าเฉลี่ยน้ำมัน</a></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $condiCompanyrkl = " AND COMPANYCODE = 'RKL'";
                                                        $sql_seCompanyrkl = "{call megOilaverage_v2(?,?,?,?)}";
                                                        $params_seCompanyrkl = array(
                                                            array('select_oilaverage', SQLSRV_PARAM_IN),
                                                            array($condiCompanyrkl, SQLSRV_PARAM_IN),
                                                            array('', SQLSRV_PARAM_IN),
                                                            array('', SQLSRV_PARAM_IN)
                                                        );
                                                        $query_seCompanyrkl = sqlsrv_query($conn, $sql_seCompanyrkl, $params_seCompanyrkl);
                                                        while ($result_seCompanyrkl = sqlsrv_fetch_array($query_seCompanyrkl, SQLSRV_FETCH_ASSOC)) {
                                                            ?>
                                                            <tr class="odd gradeX">

                                                                <td><?= $result_seCompanyrkl['CUSTOMERCODE'] ?></td>
                                                                <td><?= $result_seCompanyrkl['VEHICLETYPE'] ?></td>
                                                                <td><?= $result_seCompanyrkl['LOCATION'] ?></td>
                                                                <td><?= $result_seCompanyrkl['OILAVERAGE'] ?></td>
                                                                <td><?= $result_seCompanyrkl['REMARK'] ?></td>
                                                                <td style="text-align: center"><?php echo ($result_seCompanyrkl['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>
                                                                <td style="text-align: center">
                                                                    <a href="meg_oilaverage.php?meg=edit&oilaverageid=<?= $result_seCompanyrkl['OILAVERAGEID'] ?>" title="แก้ไขข้อมูล" type="button" class="btn btn-default  btn-circle"><span class="glyphicon glyphicon-wrench"></span></a>
                                                                    <button onclick="delete_oilaverage(<?= $result_seCompanyrkl['OILAVERAGEID'] ?>);" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>

                                                                </td>
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
                                    <div class="tab-pane fad" id="tap_comp4">
                                        <div class="row">

                                            <div class="col-md-12">
                                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example4" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                    <thead>
                                                        <tr>

                                                            <th>ลูกค้า</th>
                                                              <th>ประเภทรถ</th>
                                                             <th>พื้นที่</th>
                                                            <th>ค่าเฉลี่ย</th>
                                                            <th>หมายเหตุ</th>
                                                            <th style="text-align: center">สถานะการใช้งาน</th>
                                                            <th style="text-align: center"><a href="meg_oilaverage.php?meg=add&companycode=RCC"><li class="fa fa-plus-square"></li> เพิ่มค่าเฉลี่ยน้ำมัน</a></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $condiCompanyrcc = " AND COMPANYCODE = 'RCC'";
                                                        $sql_seCompanyrcc = "{call megOilaverage_v2(?,?,?,?)}";
                                                        $params_seCompanyrcc = array(
                                                            array('select_oilaverage', SQLSRV_PARAM_IN),
                                                            array($condiCompanyrcc, SQLSRV_PARAM_IN),
                                                            array('', SQLSRV_PARAM_IN),
                                                            array('', SQLSRV_PARAM_IN)
                                                        );
                                                        $query_seCompanyrcc = sqlsrv_query($conn, $sql_seCompanyrcc, $params_seCompanyrcc);
                                                        while ($result_seCompanyrcc = sqlsrv_fetch_array($query_seCompanyrcc, SQLSRV_FETCH_ASSOC)) {
                                                            ?>
                                                            <tr class="odd gradeX">

                                                                <td><?= $result_seCompanyrcc['CUSTOMERCODE'] ?></td>
                                                                <td><?= $result_seCompanyrcc['VEHICLETYPE'] ?></td>
                                                                <td><?= $result_seCompanyrcc['LOCATION'] ?></td>
                                                                <td><?= $result_seCompanyrcc['OILAVERAGE'] ?></td>
                                                                <td><?= $result_seCompanyrcc['REMARK'] ?></td>
                                                                <td style="text-align: center"><?php echo ($result_seCompanyrcc['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>
                                                                <td style="text-align: center">
                                                                    <a href="meg_oilaverage.php?meg=edit&oilaverageid=<?= $result_seCompanyrcc['OILAVERAGEID'] ?>" title="แก้ไขข้อมูล" type="button" class="btn btn-default  btn-circle"><span class="glyphicon glyphicon-wrench"></span></a>
                                                                    <button onclick="delete_oilaverage(<?= $result_seCompanyrcc['OILAVERAGEID'] ?>);" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>

                                                                </td>
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
                                    <div class="tab-pane fad" id="tap_comp4_1">
                                        <div class="row">

                                            <div class="col-md-12">
                                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example4_1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                    <thead>
                                                        <tr>

                                                            <th>ลูกค้า</th>
                                                              <th>ประเภทรถ</th>
                                                             <th>พื้นที่</th>
                                                            <th>ค่าเฉลี่ย</th>
                                                            <th>หมายเหตุ</th>
                                                            <th style="text-align: center">สถานะการใช้งาน</th>
                                                            <th style="text-align: center"><a href="meg_oilaverage.php?meg=add&companycode=RCC_SH"><li class="fa fa-plus-square"></li> เพิ่มค่าเฉลี่ยน้ำมัน</a></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $condiCompanyrcc_sh = " AND COMPANYCODE = 'RCC_SH'";
                                                        $sql_seCompanyrcc_sh = "{call megOilaverage_v2(?,?,?,?)}";
                                                        $params_seCompanyrcc_sh = array(
                                                            array('select_oilaverage', SQLSRV_PARAM_IN),
                                                            array($condiCompanyrcc_sh, SQLSRV_PARAM_IN),
                                                            array('', SQLSRV_PARAM_IN),
                                                            array('', SQLSRV_PARAM_IN)
                                                        );
                                                        $query_seCompanyrcc_sh = sqlsrv_query($conn, $sql_seCompanyrcc_sh, $params_seCompanyrcc_sh);
                                                        while ($result_seCompanyrcc_sh = sqlsrv_fetch_array($query_seCompanyrcc_sh, SQLSRV_FETCH_ASSOC)) {
                                                            ?>
                                                            <tr class="odd gradeX">

                                                                <td><?= $result_seCompanyrcc_sh['CUSTOMERCODE'] ?></td>
                                                                <td><?= $result_seCompanyrcc_sh['VEHICLETYPE'] ?></td>
                                                                <td><?= $result_seCompanyrcc_sh['LOCATION'] ?></td>
                                                                <td><?= $result_seCompanyrcc_sh['OILAVERAGE'] ?></td>
                                                                <td><?= $result_seCompanyrcc_sh['REMARK'] ?></td>
                                                                <td style="text-align: center"><?php echo ($result_seCompanyrcc_sh['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>
                                                                <td style="text-align: center">
                                                                    <a href="meg_oilaverage.php?meg=edit&oilaverageid=<?= $result_seCompanyrcc_sh['OILAVERAGEID'] ?>" title="แก้ไขข้อมูล" type="button" class="btn btn-default  btn-circle"><span class="glyphicon glyphicon-wrench"></span></a>
                                                                    <button onclick="delete_oilaverage(<?= $result_seCompanyrcc_sh['OILAVERAGEID'] ?>);" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>

                                                                </td>
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
                                    <div class="tab-pane fad" id="tap_comp5">
                                        <div class="row">

                                            <div class="col-md-12">
                                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example5" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                    <thead>
                                                        <tr>

                                                            <th>ลูกค้า</th>
                                                              <th>ประเภทรถ</th>
                                                            <th>พื้นที่</th>
                                                            <th>ค่าเฉลี่ย</th>
                                                            <th>หมายเหตุ</th>
                                                            <th style="text-align: center">สถานะการใช้งาน</th>
                                                            <th style="text-align: center"><a href="meg_oilaverage.php?meg=add&companycode=RATC"><li class="fa fa-plus-square"></li> เพิ่มค่าเฉลี่ยน้ำมัน</a></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $condiCompanyratc = " AND COMPANYCODE = 'RATC'";
                                                        $sql_seCompanyratc = "{call megOilaverage_v2(?,?,?,?)}";
                                                        $params_seCompanyratc = array(
                                                            array('select_oilaverage', SQLSRV_PARAM_IN),
                                                            array($condiCompanyratc, SQLSRV_PARAM_IN),
                                                            array('', SQLSRV_PARAM_IN),
                                                            array('', SQLSRV_PARAM_IN)
                                                        );
                                                        $query_seCompanyratc = sqlsrv_query($conn, $sql_seCompanyratc, $params_seCompanyratc);
                                                        while ($result_seCompanyratc = sqlsrv_fetch_array($query_seCompanyratc, SQLSRV_FETCH_ASSOC)) {
                                                            ?>
                                                            <tr class="odd gradeX">

                                                                <td><?= $result_seCompanyratc['CUSTOMERCODE'] ?></td>
                                                                <td><?= $result_seCompanyratc['VEHICLETYPE'] ?></td>
                                                                <td><?= $result_seCompanyratc['LOCATION'] ?></td>
                                                                <td><?= $result_seCompanyratc['OILAVERAGE'] ?></td>
                                                                <td><?= $result_seCompanyratc['REMARK'] ?></td>
                                                                <td style="text-align: center"><?php echo ($result_seCompanyratc['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>
                                                                <td style="text-align: center">
                                                                    <a href="meg_oilaverage.php?meg=edit&oilaverageid=<?= $result_seCompanyratc['OILAVERAGEID'] ?>" title="แก้ไขข้อมูล" type="button" class="btn btn-default  btn-circle"><span class="glyphicon glyphicon-wrench"></span></a>
                                                                    <button onclick="delete_oilaverage(<?= $result_seCompanyratc['OILAVERAGEID'] ?>);" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>

                                                                </td>
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
                                    <div class="tab-pane fad" id="tap_comp5_1">
                                        <div class="row">

                                            <div class="col-md-12">
                                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example5_1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                    <thead>
                                                        <tr>

                                                            <th>ลูกค้า</th>
                                                              <th>ประเภทรถ</th>
                                                             <th>พื้นที่</th>
                                                            <th>ค่าเฉลี่ย</th>
                                                            <th>หมายเหตุ</th>
                                                            <th style="text-align: center">สถานะการใช้งาน</th>
                                                            <th style="text-align: center"><a href="meg_oilaverage.php?meg=add&companycode=RATC_SH"><li class="fa fa-plus-square"></li> เพิ่มค่าเฉลี่ยน้ำมัน</a></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $condiCompanyratc_sh = " AND COMPANYCODE = 'RATC_SH'";
                                                        $sql_seCompanyratc_sh = "{call megOilaverage_v2(?,?,?,?)}";
                                                        $params_seCompanyratc_sh = array(
                                                            array('select_oilaverage', SQLSRV_PARAM_IN),
                                                            array($condiCompanyratc_sh, SQLSRV_PARAM_IN),
                                                            array('', SQLSRV_PARAM_IN),
                                                            array('', SQLSRV_PARAM_IN)
                                                        );
                                                        $query_seCompanyratc_sh = sqlsrv_query($conn, $sql_seCompanyratc_sh, $params_seCompanyratc_sh);
                                                        while ($result_seCompanyratc_sh = sqlsrv_fetch_array($query_seCompanyratc_sh, SQLSRV_FETCH_ASSOC)) {
                                                            ?>
                                                            <tr class="odd gradeX">

                                                                <td><?= $result_seCompanyratc_sh['CUSTOMERCODE'] ?></td>
                                                                <td><?= $result_seCompanyratc_sh['VEHICLETYPE'] ?></td>
                                                                <td><?= $result_seCompanyratc_sh['LOCATION'] ?></td>
                                                                <td><?= $result_seCompanyratc_sh['OILAVERAGE'] ?></td>
                                                                <td><?= $result_seCompanyratc_sh['REMARK'] ?></td>
                                                                <td style="text-align: center"><?php echo ($result_seCompanyratc_sh['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>
                                                                <td style="text-align: center">
                                                                    <a href="meg_oilaverage.php?meg=edit&oilaverageid=<?= $result_seCompanyratc_sh['OILAVERAGEID'] ?>" title="แก้ไขข้อมูล" type="button" class="btn btn-default  btn-circle"><span class="glyphicon glyphicon-wrench"></span></a>
                                                                    <button onclick="delete_oilaverage(<?= $result_seCompanyratc_sh['OILAVERAGEID'] ?>);" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>

                                                                </td>
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
                                    <div class="tab-pane fad" id="tap_comp6">
                                        <div class="row">

                                            <div class="col-md-12">
                                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example6" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                    <thead>
                                                        <tr>

                                                            <th>ลูกค้า</th>
                                                              <th>ประเภทรถ</th>
                                                            <th>พื้นที่</th>
                                                            <th>ค่าเฉลี่ย</th>
                                                            
                                                            <th>หมายเหตุ</th>
                                                            <th style="text-align: center">สถานะการใช้งาน</th>
                                                            <th style="text-align: center"><a href="meg_oilaverage.php?meg=add&companycode=RRC"><li class="fa fa-plus-square"></li> เพิ่มค่าเฉลี่ยน้ำมัน</a></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $condiCompanyrrc = " AND COMPANYCODE = 'RRC'";
                                                        $sql_seCompanyrrc = "{call megOilaverage_v2(?,?,?,?)}";
                                                        $params_seCompanyrrc = array(
                                                            array('select_oilaverage', SQLSRV_PARAM_IN),
                                                            array($condiCompanyrrc, SQLSRV_PARAM_IN),
                                                            array('', SQLSRV_PARAM_IN),
                                                            array('', SQLSRV_PARAM_IN)
                                                        );
                                                        $query_seCompanyrrc = sqlsrv_query($conn, $sql_seCompanyrrc, $params_seCompanyrrc);
                                                        while ($result_seCompanyrrc = sqlsrv_fetch_array($query_seCompanyrrc, SQLSRV_FETCH_ASSOC)) {
                                                            ?>
                                                            <tr class="odd gradeX">

                                                                <td><?= $result_seCompanyrrc['CUSTOMERCODE'] ?></td>
                                                                <td><?= $result_seCompanyrrc['VEHICLETYPE'] ?></td>
                                                                <td><?= $result_seCompanyrrc['LOCATION'] ?></td>
                                                                <td><?= $result_seCompanyrrc['OILAVERAGE'] ?></td>
                                                                <td><?= $result_seCompanyrrc['REMARK'] ?></td>
                                                                <td style="text-align: center"><?php echo ($result_seCompanyrrc['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>
                                                                <td style="text-align: center">
                                                                    <a href="meg_oilaverage.php?meg=edit&oilaverageid=<?= $result_seCompanyrrc['OILAVERAGEID'] ?>" title="แก้ไขข้อมูล" type="button" class="btn btn-default  btn-circle"><span class="glyphicon glyphicon-wrench"></span></a>
                                                                    <button onclick="delete_oilaverage(<?= $result_seCompanyrrc['OILAVERAGEID'] ?>);" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>

                                                                </td>
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
            <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
            <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
            <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
            <script src="../dist/js/sb-admin-2.js"></script>

            <script>
                                                                        $(document).ready(function () {
                                                                            $('#dataTables-example1').DataTable({
                                                                                responsive: true,
                                                                                order: [[0, "desc"]]
                                                                            });
                                                                            $('#dataTables-example2').DataTable({
                                                                                responsive: true,
                                                                                order: [[0, "desc"]]
                                                                            });
                                                                            $('#dataTables-example3').DataTable({
                                                                                responsive: true,
                                                                                order: [[0, "desc"]]
                                                                            });
                                                                            $('#dataTables-example4').DataTable({
                                                                                responsive: true,
                                                                                order: [[0, "desc"]]
                                                                            });
                                                                             $('#dataTables-example4_1').DataTable({
                                                                                responsive: true,
                                                                                order: [[0, "desc"]]
                                                                            });
                                                                            $('#dataTables-example5').DataTable({
                                                                                responsive: true,
                                                                                order: [[0, "desc"]]
                                                                            });
                                                                             $('#dataTables-example5_1').DataTable({
                                                                                responsive: true,
                                                                                order: [[0, "desc"]]
                                                                            });
                                                                            $('#dataTables-example6').DataTable({
                                                                                responsive: true,
                                                                                order: [[0, "desc"]]
                                                                            });
                                                                        });
            </script>


    </body>

    <script>


        function delete_oilaverage(val)
        {
            var confirmation = confirm("ต้องการลบข้อมูล ?");

            if (confirmation) {
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "delete_oilaverage", oilaverageid: val
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