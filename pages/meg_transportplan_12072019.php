<!DOCTYPE html>
<?php
session_start();
ini_set('max_execution_time', 300);
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$sql_seSystime = "{call megGetdate_v2(?)}";
$params_seSystime = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_seSystime = sqlsrv_query($conn, $sql_seSystime, $params_seSystime);
$result_seSystime = sqlsrv_fetch_array($query_seSystime, SQLSRV_FETCH_ASSOC);
$condish = ($_GET['pricetype'] == "1") ? " AND (a.REMARK = '' OR a.REMARK IS NULL)" : " AND a.REMARK != ''";
updatevehicletransportplan();



$run_jobno = create_jobno(substr($_GET['companycode'], 0, 3), 'GETDATE()');
$jobsm1 = '';
$jobsm2 = '';
$jobsm3 = '';
$jobsm4 = '';
$jobstu1 = '';
$jobstu2 = '';
$jobsw1 = '';
$jobsw2 = '';
$jobsth1 = '';
$jobsth2 = '';
$jobsf1 = '';
$jobsf2 = '';
$jobssat1 = '';
$jobssat2 = '';
$jobssun1 = '';
$jobssun2 = '';

$condComp = " AND Company_Code = '" . $_GET['companycode'] . "'";
$sql_seComp = "{call megCompanyEHR_v2(?,?)}";
$params_seComp = array(
    array('select_company', SQLSRV_PARAM_IN),
    array($condComp, SQLSRV_PARAM_IN)
);
$query_seComp = sqlsrv_query($conn, $sql_seComp, $params_seComp);
$result_seComp = sqlsrv_fetch_array($query_seComp, SQLSRV_FETCH_ASSOC);
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
                <a class="navbar-brand" href="index.html"><font style="color: #666"><img src="../images/logo.png" height="30"> <strong>กลุ่มร่วมกิจรุ่งเรือง</strong></font></a> 
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
        <input type="text" name="txt_copydiagramvehicletransportplanid" id="txt_copydiagramvehicletransportplanid" class="form-control" style="display: none">

        <div class="modal fade" id="modal_copydiagramupdrrc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 80%">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="row">
                            <div class="col-lg-5">
                                <h5 class="modal-title" id="title_copydiagram"><b>Update Diagram</b></h5>
                            </div>

                        </div>
                    </div> 
                    <div id="modalbodyupdatediagramrrcsr"></div>

                </div>
            </div>
        </div>
        <div class="modal fade" id="modal_copydiagramupd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 80%">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="row">
                            <div class="col-lg-5">
                                <h5 class="modal-title" id="title_copydiagram"><b>Update Diagram</b></h5>
                            </div>

                        </div>
                    </div> 



                    <div id="modalbodyupdatediagramrccsr"></div>





                </div>
            </div>
        </div>
        <div class="modal fade" id="modal_copydiagramupdrks" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 80%">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="row">
                            <div class="col-lg-5">
                                <h5 class="modal-title" id="title_copydiagram"><b>Update Diagram</b></h5>
                            </div>

                        </div>
                    </div> 
                    <div id="modalbodyupdatediagramrkssr"></div>

                </div>
            </div>
        </div>


        <div class="modal fade" id="modal_copyjob" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="title_copyjob">COPY JOB</h5>

                    </div>
                    <div class="modal-body">
                        <div class="row" >
                            <div class="col-lg-6">
                                <div class="form-group">

                                    <label>จำนวน (JOB) : </label>

                                    <input class="form-control" id="txt_startdatejobcopy" name="txt_startdatejobcopy" style="display: none"> 
                                    <input class="form-control" id="txt_rowsamount" name="txt_rowsamount" > 

                                </div>
                            </div>
                        </div>
                        <div class="row">&nbsp;</div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                        <button type="button" class="btn btn-primary" onclick="save_copyjob()">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_copydiagram" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 80%">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="row">
                            <div class="col-lg-5">
                                <h5 class="modal-title" id="title_copydiagram"><b>New Diagram</b></h5>
                            </div>
                            <div class="col-lg-1" style="text-align: right">
                                <font style="color: red">* </font><label>ช่วงวันที่</label> 
                            </div>
                            <div class="col-lg-3">
                                <input type="text" name="txt_copydiagramjobnomonday" id="txt_copydiagramjobnomonday" class="form-control" style="display: none">
                                <input type="text" name="txt_copydiagramjobnotuesday" id="txt_copydiagramjobnotuesday" class="form-control" style="display: none">
                                <input type="text" name="txt_copydiagramjobnowednesday" id="txt_copydiagramjobnowednesday" class="form-control" style="display: none">
                                <input type="text" name="txt_copydiagramjobnothursday" id="txt_copydiagramjobnothursday" class="form-control" style="display: none">
                                <input type="text" name="txt_copydiagramjobnofriday" id="txt_copydiagramjobnofriday" class="form-control" style="display: none">
                                <input type="text" name="txt_copydiagramjobnosaturday" id="txt_copydiagramjobnosaturday" class="form-control" style="display: none">
                                <input type="text" name="txt_copydiagramjobnosunday" id="txt_copydiagramjobnosunday" class="form-control" style="display: none">

                                <input type="text" name="txt_copydiagramdatestart"  readonly="" id="txt_copydiagramdatestart" onchange="add_dateweek(this.value)" class="form-control dateen" placeholder="วันที่เริ่มต้น...">
                            </div>
                            <div class="col-lg-3">
                                <input type="text" name="txt_copydiagramdateend" style="background-color: #f080802e"  disabled="" id="txt_copydiagramdateend" class="form-control dateen" placeholder="วันที่สิ้นสิ้นสุด...">
                            </div>
                        </div>
                    </div> 
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-lg-2">
                                <font style="color: red">* </font><label>พขร.(1) :</label>
                                <input type="text"  name="txt_copydiagramemployeename1" id="txt_copydiagramemployeename1" class="form-control">
                            </div>
                            <div class="col-lg-1">
                                <label>&nbsp;</label><br>

                                <button class="btn btn-secondary"  id="btn_checkdriver" onclick="select_checkdriversr('1')"  name="btn_checkdriver" data-toggle="modal"  data-target="#modal_checkdriver"><span class="fa fa-check"></span> พขร.(1)</button>
                            </div>

                            <div class="col-lg-2">
                                <label>พขร.(2) :</label> <!--<div id="div_jobendemp2">-</div >-->
                                <input type="text"  class="form-control" name="txt_copydiagramemployeename2" id="txt_copydiagramemployeename2">
                            </div>
                            <div class="col-lg-1">
                                <label>&nbsp;</label><br>
                                <button class="btn btn-secondary"  id="btn_checkdriver" onclick="select_checkdriversr('2')"  name="btn_checkdriver" data-toggle="modal"  data-target="#modal_checkdriver"><span class="fa fa-check"></span> พขร.(2)</button>
                            </div>
                            <?php
                            if ($_GET['companycode'] == 'RCC' || $_GET['companycode'] == 'RATC') {
                                ?>
                                <div class="col-lg-2">
                                    <label>พขร.(ควบคุม)(3) :</label>
                                    <input type="text"  class="form-control" name="txt_copydiagramemployeename3" id="txt_copydiagramemployeename3">
                                </div>
                                <div class="col-lg-2">
                                    <label>&nbsp;</label><br>
                                    <button class="btn btn-secondary"  id="btn_checkdriver" onclick="select_checkdriversr('3')"  name="btn_checkdriver" data-toggle="modal"  data-target="#modal_checkdriver"><span class="fa fa-check"></span> พขร.(ควบคุม)(3)</button>
                                </div>

                                <div class="col-lg-2">
                                    <label>จำนวนคัน(กรณีงานรับกลับ) :</label>
                                    <input  type="text" class="form-control"  id="txt_copydiagramunit"  name="txt_copydiagramunit"> 
                                </div>

                                <?php
                            }
                            ?>

                        </div>
                        <div class="row">

                            <div class="col-lg-3">
                                <font style="color: red">* </font><label>ชื่อรถ :</label>
                                <input type="text" class="form-control"  id="txt_copydiagramthainame" name="txt_copydiagramthainame">
                            </div>
                            <?php
                            if ($_GET['worktype'] == 'OTHER') {
                                ?>
                                <div class="col-lg-3">
                                    <label>ประเภทรถ :</label>
                                    <select id="cb_copydiagramcartype" name="cb_copydiagramcartype" class="form-control"  title="เลือกประเภทรถ..." >
                                        <option value="">เลือกประเภทรถ</option>
                                        <?php
                                        $condi = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "'";
                                        $sql_seCartype = "{call megVehicletransportpriceother_v2(?,?)}";
                                        $params_seCartype = array(
                                            array('select_vehicletype', SQLSRV_PARAM_IN),
                                            array($condi, SQLSRV_PARAM_IN)
                                        );
                                        $query_seCartype = sqlsrv_query($conn, $sql_seCartype, $params_seCartype);
                                        while ($result_seCartype = sqlsrv_fetch_array($query_seCartype, SQLSRV_FETCH_ASSOC)) {
                                            ?>
                                            <option value="<?= $result_seCartype['VEHICLETYPE'] ?>"><?= $result_seCartype['VEHICLETYPE'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label>ต้นทาง :</label>
                                    <select id="cb_copydiagramjobstart" name="cb_copydiagramjobstart" class="form-control">
                                        <option value="">เลือก ต้นทาง</option>
                                        <?php
                                        $condi = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "'";
                                        $sql_seFrom = "{call megVehicletransportpriceother_v2(?,?)}";
                                        $params_seFrom = array(
                                            array('select_from', SQLSRV_PARAM_IN),
                                            array($condi, SQLSRV_PARAM_IN)
                                        );
                                        $query_seFrom = sqlsrv_query($conn, $sql_seFrom, $params_seFrom);
                                        while ($result_seFrom = sqlsrv_fetch_array($query_seFrom, SQLSRV_FETCH_ASSOC)) {
                                            ?>
                                            <option value="<?= $result_seFrom['FROM'] ?>"><?= $result_seFrom['FROM'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label>ปลายทาง :</label>
                                    <select id="cb_copydiagramjobend" name="cb_copydiagramjobend" class="form-control" >
                                        <option value="">เลือก ปลายทาง</option>
                                        <?php
                                        $condi = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "'";
                                        $sql_seTo = "{call megVehicletransportpriceother_v2(?,?)}";
                                        $params_seTo = array(
                                            array('select_to', SQLSRV_PARAM_IN),
                                            array($condi, SQLSRV_PARAM_IN)
                                        );
                                        $query_seTo = sqlsrv_query($conn, $sql_seTo, $params_seTo);
                                        while ($result_seTo = sqlsrv_fetch_array($query_seTo, SQLSRV_FETCH_ASSOC)) {
                                            ?>
                                            <option value="<?= $result_seTo['TO'] ?>"><?= $result_seTo['TO'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <?php
                            } else {
                                if ($_GET['companycode'] == 'RRC') {
                                    if ($_GET['customercode'] == 'GMT') {
                                        ?>
                                        <div class="col-lg-2">
                                            <label>ประเภทรถ :</label>
                                            <select id="cb_copydiagramcartype" name="cb_copydiagramcartype" class="form-control"  title="เลือกประเภทรถ..." >
                                                <option value="">เลือกประเภทรถ</option>
                                                <?php
                                                $sql_seCartype = "{call megVehicletransportpricerrcgmt_v2(?,?)}";
                                                $params_seCartype = array(
                                                    array('select_cartype', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seCartype = sqlsrv_query($conn, $sql_seCartype, $params_seCartype);
                                                while ($result_seCartype = sqlsrv_fetch_array($query_seCartype, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seCartype['VEHICLETYPE'] ?>"><?= $result_seCartype['VEHICLETYPE'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-1">
                                            <label>ไป / กลับ :</label>
                                            <select id="cb_copydiagramgoreturn" name="cb_copydiagramgoreturn" class="form-control"  title="เลือกประเภทรถ..." >
                                                <option value="go">ไป</option>
                                                <option value="return">กลับ</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <label>ประเภทวัสดุ :</label>
                                            <select id="cb_materialtype" name="cb_materialtype" class="form-control"  title="เลือกประเภทวัสดุ..." >
                                                <option value="">เลือกประเภทวัสดุ</option>
                                                <?php
                                                $condStatus = " AND SUBDOMAIN = 'status'";
                                                $sql_seStatus = "{call megStatus_v2(?,?)}";
                                                $params_seStatus = array(
                                                    array('select_status', SQLSRV_PARAM_IN),
                                                    array($condStatus, SQLSRV_PARAM_IN)
                                                );
                                                $query_seStatus = sqlsrv_query($conn, $sql_seStatus, $params_seStatus);
                                                while ($result_seStatus = sqlsrv_fetch_array($query_seStatus, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seStatus['STATUSDETAILS'] ?>"><?= $result_seStatus['STATUSDETAILS'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <label>ต้นทาง :</label>
                                            <select id="cb_copydiagramjobstart" name="cb_copydiagramjobstart" class="form-control">
                                                <option value="">เลือก ต้นทาง</option>
                                                <?php
                                                $sql_seFrom = "{call megVehicletransportpricerrcgmt_v2(?,?)}";
                                                $params_seFrom = array(
                                                    array('select_startways', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seFrom = sqlsrv_query($conn, $sql_seFrom, $params_seFrom);
                                                while ($result_seFrom = sqlsrv_fetch_array($query_seFrom, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seFrom['STARTWAYS'] ?>"><?= $result_seFrom['STARTWAYS'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <label>ปลายทาง :</label>
                                            <select id="cb_copydiagramjobend" name="cb_copydiagramjobend" class="form-control" >
                                                <option value="">เลือก ปลายทาง</option>
                                                <?php
                                                $sql_seTo = "{call megVehicletransportpricerrcgmt_v2(?,?)}";
                                                $params_seTo = array(
                                                    array('select_endways', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seTo = sqlsrv_query($conn, $sql_seTo, $params_seTo);
                                                while ($result_seTo = sqlsrv_fetch_array($query_seTo, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seTo['ENDWAYS'] ?>"><?= $result_seTo['ENDWAYS'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <?php
                                    } else if ($_GET['customercode'] == 'BP') {
                                        ?>
                                        <div class="col-lg-2">
                                            <label>ประเภทรถ :</label>
                                            <select id="cb_copydiagramcartype" name="cb_copydiagramcartype" class="form-control"  title="เลือกประเภทรถ..." >
                                                <option value="">เลือกประเภทรถ</option>
                                                <?php
                                                $sql_seCartype = "{call megVehicletransportpricerrcbp_v2(?,?)}";
                                                $params_seCartype = array(
                                                    array('select_cartype', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seCartype = sqlsrv_query($conn, $sql_seCartype, $params_seCartype);
                                                while ($result_seCartype = sqlsrv_fetch_array($query_seCartype, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seCartype['VEHICLETYPE'] ?>"><?= $result_seCartype['VEHICLETYPE'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-1">
                                            <label>ไป / กลับ :</label>
                                            <select id="cb_copydiagramgoreturn" name="cb_copydiagramgoreturn" class="form-control"  title="เลือกประเภทรถ..." >
                                                <option value="go">ไป</option>
                                                <option value="return">กลับ</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <label>ประเภทวัสดุ :</label>
                                            <select id="cb_materialtype" name="cb_materialtype" class="form-control"  title="เลือกประเภทวัสดุ..." >
                                                <option value="">เลือกประเภทวัสดุ</option>
                                                <?php
                                                $condStatus = " AND SUBDOMAIN = 'status'";
                                                $sql_seStatus = "{call megStatus_v2(?,?)}";
                                                $params_seStatus = array(
                                                    array('select_status', SQLSRV_PARAM_IN),
                                                    array($condStatus, SQLSRV_PARAM_IN)
                                                );
                                                $query_seStatus = sqlsrv_query($conn, $sql_seStatus, $params_seStatus);
                                                while ($result_seStatus = sqlsrv_fetch_array($query_seStatus, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seStatus['STATUSDETAILS'] ?>"><?= $result_seStatus['STATUSDETAILS'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <label>ต้นทาง :</label>
                                            <select id="cb_copydiagramjobstart" name="cb_copydiagramjobstart" class="form-control">
                                                <option value="">เลือก ต้นทาง</option>
                                                <?php
                                                $sql_seFrom = "{call megVehicletransportpricerrcbp_v2(?,?)}";
                                                $params_seFrom = array(
                                                    array('select_startways', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seFrom = sqlsrv_query($conn, $sql_seFrom, $params_seFrom);
                                                while ($result_seFrom = sqlsrv_fetch_array($query_seFrom, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seFrom['STARTWAYS'] ?>"><?= $result_seFrom['STARTWAYS'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <label>ปลายทาง :</label>
                                            <select id="cb_copydiagramjobend" name="cb_copydiagramjobend" class="form-control" >
                                                <option value="">เลือก ปลายทาง</option>
                                                <?php
                                                $sql_seTo = "{call megVehicletransportpricerrcbp_v2(?,?)}";
                                                $params_seTo = array(
                                                    array('select_endways', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seTo = sqlsrv_query($conn, $sql_seTo, $params_seTo);
                                                while ($result_seTo = sqlsrv_fetch_array($query_seTo, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seTo['ENDWAYS'] ?>"><?= $result_seTo['ENDWAYS'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <?php
                                    } else if ($_GET['customercode'] == 'TTAST') {
                                        ?>
                                        <div class="col-lg-2">
                                            <label>ประเภทรถ :</label>
                                            <select id="cb_copydiagramcartype" name="cb_copydiagramcartype" class="form-control"  title="เลือกประเภทรถ..." >
                                                <option value="">เลือกประเภทรถ</option>
                                                <?php
                                                $sql_seCartype = "{call megVehicletransportpricerrcttast_v2(?,?)}";
                                                $params_seCartype = array(
                                                    array('select_cartype', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seCartype = sqlsrv_query($conn, $sql_seCartype, $params_seCartype);
                                                while ($result_seCartype = sqlsrv_fetch_array($query_seCartype, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seCartype['VEHICLETYPE'] ?>"><?= $result_seCartype['VEHICLETYPE'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-1">
                                            <label>ไป / กลับ :</label>
                                            <select id="cb_copydiagramgoreturn" name="cb_copydiagramgoreturn" class="form-control"  title="เลือกประเภทรถ..." >
                                                <option value="go">ไป</option>
                                                <option value="return">กลับ</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <label>ประเภทวัสดุ :</label>
                                            <select id="cb_materialtype" name="cb_materialtype" class="form-control"  title="เลือกประเภทวัสดุ..." >
                                                <option value="">เลือกประเภทวัสดุ</option>
                                                <?php
                                                $condStatus = " AND SUBDOMAIN = 'status'";
                                                $sql_seStatus = "{call megStatus_v2(?,?)}";
                                                $params_seStatus = array(
                                                    array('select_status', SQLSRV_PARAM_IN),
                                                    array($condStatus, SQLSRV_PARAM_IN)
                                                );
                                                $query_seStatus = sqlsrv_query($conn, $sql_seStatus, $params_seStatus);
                                                while ($result_seStatus = sqlsrv_fetch_array($query_seStatus, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seStatus['STATUSDETAILS'] ?>"><?= $result_seStatus['STATUSDETAILS'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <label>ต้นทาง :</label>
                                            <select id="cb_copydiagramjobstart" name="cb_copydiagramjobstart" class="form-control">
                                                <option value="">เลือก ต้นทาง</option>
                                                <?php
                                                $sql_seFrom = "{call megVehicletransportpricerrcttast_v2(?,?)}";
                                                $params_seFrom = array(
                                                    array('select_startways', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seFrom = sqlsrv_query($conn, $sql_seFrom, $params_seFrom);
                                                while ($result_seFrom = sqlsrv_fetch_array($query_seFrom, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seFrom['STARTWAYS'] ?>"><?= $result_seFrom['STARTWAYS'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <label>ปลายทาง :</label>
                                            <select id="cb_copydiagramjobend" name="cb_copydiagramjobend" class="form-control" >
                                                <option value="">เลือก ปลายทาง</option>
                                                <?php
                                                $sql_seTo = "{call megVehicletransportpricerrcttast_v2(?,?)}";
                                                $params_seTo = array(
                                                    array('select_endways', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seTo = sqlsrv_query($conn, $sql_seTo, $params_seTo);
                                                while ($result_seTo = sqlsrv_fetch_array($query_seTo, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seTo['ENDWAYS'] ?>"><?= $result_seTo['ENDWAYS'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <?php
                                    } else if ($_GET['customercode'] == 'TTTC') {
                                        ?>
                                        <div class="col-lg-2">
                                            <label>ประเภทรถ :</label>
                                            <select id="cb_copydiagramcartype" name="cb_copydiagramcartype" class="form-control"  title="เลือกประเภทรถ..." >
                                                <option value="">เลือกประเภทรถ</option>
                                                <?php
                                                $sql_seCartype = "{call megVehicletransportpricerrctttc_v2(?,?)}";
                                                $params_seCartype = array(
                                                    array('select_cartype', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seCartype = sqlsrv_query($conn, $sql_seCartype, $params_seCartype);
                                                while ($result_seCartype = sqlsrv_fetch_array($query_seCartype, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seCartype['VEHICLETYPE'] ?>"><?= $result_seCartype['VEHICLETYPE'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-1">
                                            <label>ไป / กลับ :</label>
                                            <select id="cb_copydiagramgoreturn" name="cb_copydiagramgoreturn" class="form-control"  title="เลือกประเภทรถ..." >
                                                <option value="go">ไป</option>
                                                <option value="return">กลับ</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <label>ประเภทวัสดุ :</label>
                                            <select id="cb_materialtype" name="cb_materialtype" class="form-control"  title="เลือกประเภทวัสดุ..." >
                                                <option value="">เลือกประเภทวัสดุ</option>
                                                <?php
                                                $condStatus = " AND SUBDOMAIN = 'status'";
                                                $sql_seStatus = "{call megStatus_v2(?,?)}";
                                                $params_seStatus = array(
                                                    array('select_status', SQLSRV_PARAM_IN),
                                                    array($condStatus, SQLSRV_PARAM_IN)
                                                );
                                                $query_seStatus = sqlsrv_query($conn, $sql_seStatus, $params_seStatus);
                                                while ($result_seStatus = sqlsrv_fetch_array($query_seStatus, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seStatus['STATUSDETAILS'] ?>"><?= $result_seStatus['STATUSDETAILS'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <label>ต้นทาง :</label>
                                            <select id="cb_copydiagramjobstart" name="cb_copydiagramjobstart" class="form-control">
                                                <option value="">เลือก ต้นทาง</option>
                                                <?php
                                                $sql_seFrom = "{call megVehicletransportpricerrctttc_v2(?,?)}";
                                                $params_seFrom = array(
                                                    array('select_startways', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seFrom = sqlsrv_query($conn, $sql_seFrom, $params_seFrom);
                                                while ($result_seFrom = sqlsrv_fetch_array($query_seFrom, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seFrom['STARTWAYS'] ?>"><?= $result_seFrom['STARTWAYS'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <label>ปลายทาง :</label>
                                            <select id="cb_copydiagramjobend" name="cb_copydiagramjobend" class="form-control" >
                                                <option value="">เลือก ปลายทาง</option>
                                                <?php
                                                $sql_seTo = "{call megVehicletransportpricerrctttc_v2(?,?)}";
                                                $params_seTo = array(
                                                    array('select_endways', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seTo = sqlsrv_query($conn, $sql_seTo, $params_seTo);
                                                while ($result_seTo = sqlsrv_fetch_array($query_seTo, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seTo['ENDWAYS'] ?>"><?= $result_seTo['ENDWAYS'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <?php
                                    }
                                } else if ($_GET['companycode'] == 'RKR') {
                                    if ($_GET['customercode'] == 'TGT') {
                                        ?>
                                        <div class="col-lg-3">
                                            <label>ประเภทรถ :</label>
                                            <select id="cb_copydiagramcartype" name="cb_copydiagramcartype" class="form-control"  title="เลือกประเภทรถ..." >
                                                <option value="">เลือกประเภทรถ</option>
                                                <?php
                                                $sql_seCartype = "{call megVehicletransportpricerkrtgt_v2(?,?)}";
                                                $params_seCartype = array(
                                                    array('select_vehicletype', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seCartype = sqlsrv_query($conn, $sql_seCartype, $params_seCartype);
                                                while ($result_seCartype = sqlsrv_fetch_array($query_seCartype, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seCartype['VEHICLETYPE'] ?>"><?= $result_seCartype['VEHICLETYPE'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>ต้นทาง :</label>
                                            <select id="cb_copydiagramjobstart" name="cb_copydiagramjobstart" class="form-control">
                                                <option value="">เลือก ต้นทาง</option>
                                                <?php
                                                $sql_seFrom = "{call megVehicletransportpricerkrtgt_v2(?,?)}";
                                                $params_seFrom = array(
                                                    array('select_from', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seFrom = sqlsrv_query($conn, $sql_seFrom, $params_seFrom);
                                                while ($result_seFrom = sqlsrv_fetch_array($query_seFrom, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seFrom['FROM'] ?>"><?= $result_seFrom['FROM'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>ปลายทาง :</label>
                                            <select id="cb_copydiagramjobend" name="cb_copydiagramjobend" class="form-control" >
                                                <option value="">เลือก ปลายทาง</option>
                                                <?php
                                                $sql_seTo = "{call megVehicletransportpricerkrtgt_v2(?,?)}";
                                                $params_seTo = array(
                                                    array('select_to', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seTo = sqlsrv_query($conn, $sql_seTo, $params_seTo);
                                                while ($result_seTo = sqlsrv_fetch_array($query_seTo, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seTo['TO'] ?>"><?= $result_seTo['TO'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <?php
                                    } else if ($_GET['customercode'] == 'DAIKI') {
                                        ?>
                                        <div class="col-lg-3">
                                            <label>ประเภทรถ :</label>
                                            <select id="cb_copydiagramcartype" name="cb_copydiagramcartype" class="form-control"  title="เลือกประเภทรถ..." >
                                                <option value="">เลือกประเภทรถ</option>
                                                <?php
                                                $sql_seCartype = "{call megVehicletransportpricerkrdaiki_v2(?,?)}";
                                                $params_seCartype = array(
                                                    array('select_vehicletype', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seCartype = sqlsrv_query($conn, $sql_seCartype, $params_seCartype);
                                                while ($result_seCartype = sqlsrv_fetch_array($query_seCartype, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seCartype['VEHICLETYPE'] ?>"><?= $result_seCartype['VEHICLETYPE'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>ต้นทาง :</label>
                                            <select id="cb_copydiagramjobstart" name="cb_copydiagramjobstart" class="form-control">
                                                <option value="">เลือก ต้นทาง</option>
                                                <?php
                                                $sql_seFrom = "{call megVehicletransportpricerkrdaiki_v2(?,?)}";
                                                $params_seFrom = array(
                                                    array('select_from', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seFrom = sqlsrv_query($conn, $sql_seFrom, $params_seFrom);
                                                while ($result_seFrom = sqlsrv_fetch_array($query_seFrom, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seFrom['FROM'] ?>"><?= $result_seFrom['FROM'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>ปลายทาง :</label>
                                            <select id="cb_copydiagramjobend" name="cb_copydiagramjobend" class="form-control" >
                                                <option value="">เลือก ปลายทาง</option>
                                                <?php
                                                $sql_seTo = "{call megVehicletransportpricerkrdaiki_v2(?,?)}";
                                                $params_seTo = array(
                                                    array('select_to', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seTo = sqlsrv_query($conn, $sql_seTo, $params_seTo);
                                                while ($result_seTo = sqlsrv_fetch_array($query_seTo, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seTo['TO'] ?>"><?= $result_seTo['TO'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <?php
                                    } else if ($_GET['customercode'] == 'TTPRO') {
                                        ?>
                                        <div class="col-lg-3">
                                            <label>ประเภทรถ :</label>
                                            <select id="cb_copydiagramcartype" name="cb_copydiagramcartype" class="form-control"  title="เลือกประเภทรถ..." >
                                                <option value="">เลือกประเภทรถ</option>
                                                <?php
                                                $sql_seCartype = "{call megVehicletransportpricerklttprostc_v2(?,?)}";
                                                $params_seCartype = array(
                                                    array('select_vehicletype', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seCartype = sqlsrv_query($conn, $sql_seCartype, $params_seCartype);
                                                while ($result_seCartype = sqlsrv_fetch_array($query_seCartype, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seCartype['VEHICLETYPE'] ?>"><?= $result_seCartype['VEHICLETYPE'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>ต้นทาง :</label>
                                            <select id="cb_copydiagramjobstart" name="cb_copydiagramjobstart" class="form-control">
                                                <option value="">เลือก ต้นทาง</option>
                                                <?php
                                                $sql_seFrom = "{call megVehicletransportpricerklttprostc_v2(?,?)}";
                                                $params_seFrom = array(
                                                    array('select_from', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seFrom = sqlsrv_query($conn, $sql_seFrom, $params_seFrom);
                                                while ($result_seFrom = sqlsrv_fetch_array($query_seFrom, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seFrom['FROM'] ?>"><?= $result_seFrom['FROM'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>ปลายทาง :</label>
                                            <select id="cb_copydiagramjobend" name="cb_copydiagramjobend" class="form-control" >
                                                <option value="">เลือก ปลายทาง</option>
                                                <?php
                                                $sql_seTo = "{call megVehicletransportpricerklttprostc_v2(?,?)}";
                                                $params_seTo = array(
                                                    array('select_to', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seTo = sqlsrv_query($conn, $sql_seTo, $params_seTo);
                                                while ($result_seTo = sqlsrv_fetch_array($query_seTo, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seTo['TO'] ?>"><?= $result_seTo['TO'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <?php
                                    } else if ($_GET['customercode'] == 'TTAST') {
                                        ?>
                                        <div class="col-lg-3">
                                            <label>ประเภทรถ :</label>
                                            <select id="cb_copydiagramcartype" name="cb_copydiagramcartype" class="form-control"  title="เลือกประเภทรถ..." >
                                                <option value="">เลือกประเภทรถ</option>
                                                <?php
                                                $sql_seCartype = "{call megVehicletransportpricerklttaststc_v2(?,?)}";
                                                $params_seCartype = array(
                                                    array('select_vehicletype', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seCartype = sqlsrv_query($conn, $sql_seCartype, $params_seCartype);
                                                while ($result_seCartype = sqlsrv_fetch_array($query_seCartype, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seCartype['VEHICLETYPE'] ?>"><?= $result_seCartype['VEHICLETYPE'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>ต้นทาง :</label>
                                            <select id="cb_copydiagramjobstart" name="cb_copydiagramjobstart" class="form-control">
                                                <option value="">เลือก ต้นทาง</option>
                                                <?php
                                                $sql_seFrom = "{call megVehicletransportpricerklttaststc_v2(?,?)}";
                                                $params_seFrom = array(
                                                    array('select_from', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seFrom = sqlsrv_query($conn, $sql_seFrom, $params_seFrom);
                                                while ($result_seFrom = sqlsrv_fetch_array($query_seFrom, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seFrom['FROM'] ?>"><?= $result_seFrom['FROM'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>ปลายทาง :</label>
                                            <select id="cb_copydiagramjobend" name="cb_copydiagramjobend" class="form-control" >
                                                <option value="">เลือก ปลายทาง</option>
                                                <?php
                                                $sql_seTo = "{call megVehicletransportpricerklttaststc_v2(?,?)}";
                                                $params_seTo = array(
                                                    array('select_to', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seTo = sqlsrv_query($conn, $sql_seTo, $params_seTo);
                                                while ($result_seTo = sqlsrv_fetch_array($query_seTo, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seTo['TO'] ?>"><?= $result_seTo['TO'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <?php
                                    } else if ($_GET['customercode'] == 'TTTC') {
                                        ?>
                                        <div class="col-lg-3">
                                            <label>ประเภทรถ :</label>
                                            <select id="cb_copydiagramcartype" name="cb_copydiagramcartype" class="form-control"  title="เลือกประเภทรถ..." >
                                                <option value="">เลือกประเภทรถ</option>
                                                <?php
                                                $sql_seCartype = "{call megVehicletransportpricerkltttcstc_v2(?,?)}";
                                                $params_seCartype = array(
                                                    array('select_vehicletype', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seCartype = sqlsrv_query($conn, $sql_seCartype, $params_seCartype);
                                                while ($result_seCartype = sqlsrv_fetch_array($query_seCartype, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seCartype['VEHICLETYPE'] ?>"><?= $result_seCartype['VEHICLETYPE'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>ต้นทาง :</label>
                                            <select id="cb_copydiagramjobstart" name="cb_copydiagramjobstart" class="form-control">
                                                <option value="">เลือก ต้นทาง</option>
                                                <?php
                                                $sql_seFrom = "{call megVehicletransportpricerkltttcstc_v2(?,?)}";
                                                $params_seFrom = array(
                                                    array('select_from', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seFrom = sqlsrv_query($conn, $sql_seFrom, $params_seFrom);
                                                while ($result_seFrom = sqlsrv_fetch_array($query_seFrom, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seFrom['FROM'] ?>"><?= $result_seFrom['FROM'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>ปลายทาง :</label>
                                            <select id="cb_copydiagramjobend" name="cb_copydiagramjobend" class="form-control" >
                                                <option value="">เลือก ปลายทาง</option>
                                                <?php
                                                $sql_seTo = "{call megVehicletransportpricerkltttcstc_v2(?,?)}";
                                                $params_seTo = array(
                                                    array('select_to', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seTo = sqlsrv_query($conn, $sql_seTo, $params_seTo);
                                                while ($result_seTo = sqlsrv_fetch_array($query_seTo, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seTo['TO'] ?>"><?= $result_seTo['TO'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <?php
                                    }

                                    if ($_GET['customercode'] == 'TTPRO') {
                                        ?>
                                        <div class="col-lg-3">
                                            <label>เลือกวางบิล :</label>
                                            <select id="cb_copydiagrambilling" name="cb_copydiagrambilling" class="form-control"  title="เลือกประเภทรถ..." >

                                                <?php
                                                $sql_seBilling = "{call megVehicletransportpricerkrttprostc_v2(?,?)}";
                                                $params_seBilling = array(
                                                    array('select_billing', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                                                while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seBilling['BILLING1'] ?>"><?= $result_seBilling['BILLING1'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>เลือก Zone :</label>
                                            <select id="cb_copydiagramzone" name="cb_copydiagramzone" class="form-control"  title="เลือกประเภทรถ..." >
                                                <option value="">เลือก Zone</option>
                                                <?php
                                                $sql_seZone = "{call megVehicletransportpricerkrttprostc_v2(?,?)}";
                                                $params_seZone = array(
                                                    array('select_zone', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seZone = sqlsrv_query($conn, $sql_seZone, $params_seZone);
                                                while ($result_seZone = sqlsrv_fetch_array($query_seZone, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seZone['ZONE'] ?>"><?= $result_seZone['ZONE'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>เลือก Location :</label>
                                            <select id="cb_copydiagramlocation" name="cb_copydiagramlocation" class="form-control"  title="เลือกประเภทรถ..." >
                                                <option value="">เลือก Location</option>
                                                <?php
                                                $sql_seLocation = "{call megVehicletransportpricerkrttprostc_v2(?,?)}";
                                                $params_seLocation = array(
                                                    array('select_location', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seLocation = sqlsrv_query($conn, $sql_seLocation, $params_seLocation);
                                                while ($result_seLocation = sqlsrv_fetch_array($query_seLocation, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seLocation['LOCATION'] ?>"><?= $result_seLocation['LOCATION'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <?php
                                    } else if ($_GET['customercode'] == 'TTAST') {
                                        ?>
                                        <div class="col-lg-3">
                                            <label>เลือกวางบิล :</label>
                                            <select id="cb_copydiagrambilling" name="cb_copydiagrambilling" class="form-control"  title="เลือกประเภทรถ..." >

                                                <?php
                                                $sql_seBilling = "{call megVehicletransportpricerkrttaststc_v2(?,?)}";
                                                $params_seBilling = array(
                                                    array('select_billing', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                                                while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seBilling['BILLING1'] ?>"><?= $result_seBilling['BILLING1'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>เลือก Zone :</label>
                                            <select id="cb_copydiagramzone" name="cb_copydiagramzone" class="form-control"  title="เลือกประเภทรถ..." >
                                                <option value="">เลือก Zone</option>
                                                <?php
                                                $sql_seZone = "{call megVehicletransportpricerkrttaststc_v2(?,?)}";
                                                $params_seZone = array(
                                                    array('select_zone', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seZone = sqlsrv_query($conn, $sql_seZone, $params_seZone);
                                                while ($result_seZone = sqlsrv_fetch_array($query_seZone, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seZone['ZONE'] ?>"><?= $result_seZone['ZONE'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>เลือก Location :</label>
                                            <select id="cb_copydiagramlocation" name="cb_copydiagramlocation" class="form-control"  title="เลือกประเภทรถ..." >
                                                <option value="">เลือก Location</option>
                                                <?php
                                                $sql_seLocation = "{call megVehicletransportpricerkrttaststc_v2(?,?)}";
                                                $params_seLocation = array(
                                                    array('select_location', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seLocation = sqlsrv_query($conn, $sql_seLocation, $params_seLocation);
                                                while ($result_seLocation = sqlsrv_fetch_array($query_seLocation, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seLocation['LOCATION'] ?>"><?= $result_seLocation['LOCATION'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <?php
                                    } else if ($_GET['customercode'] == 'TTTC') {
                                        ?>
                                        <div class="col-lg-3">
                                            <label>เลือกวางบิล :</label>
                                            <select id="cb_copydiagrambilling" name="cb_copydiagrambilling" class="form-control"  title="เลือกประเภทรถ..." >

                                                <?php
                                                $sql_seBilling = "{call megVehicletransportpricerkrtttcstc_v2(?,?)}";
                                                $params_seBilling = array(
                                                    array('select_billing', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                                                while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seBilling['BILLING1'] ?>"><?= $result_seBilling['BILLING1'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>เลือก Zone :</label>
                                            <select id="cb_copydiagramzone" name="cb_copydiagramzone" class="form-control"  title="เลือกประเภทรถ..." >
                                                <option value="">เลือก Zone</option>
                                                <?php
                                                $sql_seZone = "{call megVehicletransportpricerkrtttcstc_v2(?,?)}";
                                                $params_seZone = array(
                                                    array('select_zone', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seZone = sqlsrv_query($conn, $sql_seZone, $params_seZone);
                                                while ($result_seZone = sqlsrv_fetch_array($query_seZone, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seZone['ZONE'] ?>"><?= $result_seZone['ZONE'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>เลือก Location :</label>
                                            <select id="cb_copydiagramlocation" name="cb_copydiagramlocation" class="form-control"  title="เลือกประเภทรถ..." >
                                                <option value="">เลือก Location</option>
                                                <?php
                                                $sql_seLocation = "{call megVehicletransportpricerkrtttcstc_v2(?,?)}";
                                                $params_seLocation = array(
                                                    array('select_location', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seLocation = sqlsrv_query($conn, $sql_seLocation, $params_seLocation);
                                                while ($result_seLocation = sqlsrv_fetch_array($query_seLocation, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seLocation['LOCATION'] ?>"><?= $result_seLocation['LOCATION'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <?php
                                    }
                                } else if ($_GET['companycode'] == 'RKL') {
                                    if ($_GET['customercode'] == 'DAIKI') {
                                        ?>
                                        <div class="col-lg-3">
                                            <label>ประเภทรถ :</label>
                                            <select id="cb_copydiagramcartype" name="cb_copydiagramcartype" class="form-control"  title="เลือกประเภทรถ..." >
                                                <option value="">เลือกประเภทรถ</option>
                                                <?php
                                                $sql_seCartype = "{call megVehicletransportpricerkldaiki_v2(?,?)}";
                                                $params_seCartype = array(
                                                    array('select_vehicletype', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seCartype = sqlsrv_query($conn, $sql_seCartype, $params_seCartype);
                                                while ($result_seCartype = sqlsrv_fetch_array($query_seCartype, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seCartype['VEHICLETYPE'] ?>"><?= $result_seCartype['VEHICLETYPE'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>ต้นทาง :</label>
                                            <select id="cb_copydiagramjobstart" name="cb_copydiagramjobstart" class="form-control">
                                                <option value="">เลือก ต้นทาง</option>
                                                <?php
                                                $sql_seFrom = "{call megVehicletransportpricerkldaiki_v2(?,?)}";
                                                $params_seFrom = array(
                                                    array('select_from', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seFrom = sqlsrv_query($conn, $sql_seFrom, $params_seFrom);
                                                while ($result_seFrom = sqlsrv_fetch_array($query_seFrom, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seFrom['FROM'] ?>"><?= $result_seFrom['FROM'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>ปลายทาง :</label>
                                            <select id="cb_copydiagramjobend" name="cb_copydiagramjobend" class="form-control" >
                                                <option value="">เลือก ปลายทาง</option>
                                                <?php
                                                $sql_seTo = "{call megVehicletransportpricerkldaiki_v2(?,?)}";
                                                $params_seTo = array(
                                                    array('select_to', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seTo = sqlsrv_query($conn, $sql_seTo, $params_seTo);
                                                while ($result_seTo = sqlsrv_fetch_array($query_seTo, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seTo['TO'] ?>"><?= $result_seTo['TO'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <?php
                                    } else if ($_GET['customercode'] == 'TTPRO') {
                                        ?>
                                        <div class="col-lg-3">
                                            <label>ประเภทรถ :</label>
                                            <select id="cb_copydiagramcartype" name="cb_copydiagramcartype" class="form-control"  title="เลือกประเภทรถ..." >
                                                <option value="">เลือกประเภทรถ</option>
                                                <?php
                                                $sql_seCartype = "{call megVehicletransportpricerklttprostc_v2(?,?)}";
                                                $params_seCartype = array(
                                                    array('select_vehicletype', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seCartype = sqlsrv_query($conn, $sql_seCartype, $params_seCartype);
                                                while ($result_seCartype = sqlsrv_fetch_array($query_seCartype, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seCartype['VEHICLETYPE'] ?>"><?= $result_seCartype['VEHICLETYPE'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>ต้นทาง :</label>
                                            <select id="cb_copydiagramjobstart" name="cb_copydiagramjobstart" class="form-control">
                                                <option value="">เลือก ต้นทาง</option>
                                                <?php
                                                $sql_seFrom = "{call megVehicletransportpricerklttprostc_v2(?,?)}";
                                                $params_seFrom = array(
                                                    array('select_from', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seFrom = sqlsrv_query($conn, $sql_seFrom, $params_seFrom);
                                                while ($result_seFrom = sqlsrv_fetch_array($query_seFrom, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seFrom['FROM'] ?>"><?= $result_seFrom['FROM'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>ปลายทาง :</label>
                                            <select id="cb_copydiagramjobend" name="cb_copydiagramjobend" class="form-control" >
                                                <option value="">เลือก ปลายทาง</option>
                                                <?php
                                                $sql_seTo = "{call megVehicletransportpricerklttprostc_v2(?,?)}";
                                                $params_seTo = array(
                                                    array('select_to', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seTo = sqlsrv_query($conn, $sql_seTo, $params_seTo);
                                                while ($result_seTo = sqlsrv_fetch_array($query_seTo, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seTo['TO'] ?>"><?= $result_seTo['TO'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <?php
                                    } else if ($_GET['customercode'] == 'TTAST') {
                                        ?>
                                        <div class="col-lg-3">
                                            <label>ประเภทรถ :</label>
                                            <select id="cb_copydiagramcartype" name="cb_copydiagramcartype" class="form-control"  title="เลือกประเภทรถ..." >
                                                <option value="">เลือกประเภทรถ</option>
                                                <?php
                                                $sql_seCartype = "{call megVehicletransportpricerklttaststc_v2(?,?)}";
                                                $params_seCartype = array(
                                                    array('select_vehicletype', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seCartype = sqlsrv_query($conn, $sql_seCartype, $params_seCartype);
                                                while ($result_seCartype = sqlsrv_fetch_array($query_seCartype, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seCartype['VEHICLETYPE'] ?>"><?= $result_seCartype['VEHICLETYPE'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>ต้นทาง :</label>
                                            <select id="cb_copydiagramjobstart" name="cb_copydiagramjobstart" class="form-control">
                                                <option value="">เลือก ต้นทาง</option>
                                                <?php
                                                $sql_seFrom = "{call megVehicletransportpricerklttaststc_v2(?,?)}";
                                                $params_seFrom = array(
                                                    array('select_from', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seFrom = sqlsrv_query($conn, $sql_seFrom, $params_seFrom);
                                                while ($result_seFrom = sqlsrv_fetch_array($query_seFrom, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seFrom['FROM'] ?>"><?= $result_seFrom['FROM'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>ปลายทาง :</label>
                                            <select id="cb_copydiagramjobend" name="cb_copydiagramjobend" class="form-control" >
                                                <option value="">เลือก ปลายทาง</option>
                                                <?php
                                                $sql_seTo = "{call megVehicletransportpricerklttaststc_v2(?,?)}";
                                                $params_seTo = array(
                                                    array('select_to', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seTo = sqlsrv_query($conn, $sql_seTo, $params_seTo);
                                                while ($result_seTo = sqlsrv_fetch_array($query_seTo, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seTo['TO'] ?>"><?= $result_seTo['TO'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <?php
                                    } else if ($_GET['customercode'] == 'TTTC') {
                                        ?>
                                        <div class="col-lg-3">
                                            <label>ประเภทรถ :</label>
                                            <select id="cb_copydiagramcartype" name="cb_copydiagramcartype" class="form-control"  title="เลือกประเภทรถ..." >
                                                <option value="">เลือกประเภทรถ</option>
                                                <?php
                                                $sql_seCartype = "{call megVehicletransportpricerkltttcstc_v2(?,?)}";
                                                $params_seCartype = array(
                                                    array('select_vehicletype', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seCartype = sqlsrv_query($conn, $sql_seCartype, $params_seCartype);
                                                while ($result_seCartype = sqlsrv_fetch_array($query_seCartype, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seCartype['VEHICLETYPE'] ?>"><?= $result_seCartype['VEHICLETYPE'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>ต้นทาง :</label>
                                            <select id="cb_copydiagramjobstart" name="cb_copydiagramjobstart" class="form-control">
                                                <option value="">เลือก ต้นทาง</option>
                                                <?php
                                                $sql_seFrom = "{call megVehicletransportpricerkltttcstc_v2(?,?)}";
                                                $params_seFrom = array(
                                                    array('select_from', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seFrom = sqlsrv_query($conn, $sql_seFrom, $params_seFrom);
                                                while ($result_seFrom = sqlsrv_fetch_array($query_seFrom, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seFrom['FROM'] ?>"><?= $result_seFrom['FROM'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>ปลายทาง :</label>
                                            <select id="cb_copydiagramjobend" name="cb_copydiagramjobend" class="form-control" >
                                                <option value="">เลือก ปลายทาง</option>
                                                <?php
                                                $sql_seTo = "{call megVehicletransportpricerkltttcstc_v2(?,?)}";
                                                $params_seTo = array(
                                                    array('select_to', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seTo = sqlsrv_query($conn, $sql_seTo, $params_seTo);
                                                while ($result_seTo = sqlsrv_fetch_array($query_seTo, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seTo['TO'] ?>"><?= $result_seTo['TO'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <?php
                                    }

                                    if ($_GET['customercode'] == 'TTPRO') {
                                        ?>
                                        <div class="col-lg-3">
                                            <label>เลือกวางบิล :</label>
                                            <select id="cb_copydiagrambilling" name="cb_copydiagrambilling" class="form-control"  title="เลือกประเภทรถ..." >

                                                <?php
                                                $sql_seBilling = "{call megVehicletransportpricerklttprostc_v2(?,?)}";
                                                $params_seBilling = array(
                                                    array('select_billing', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                                                while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seBilling['BILLING1'] ?>"><?= $result_seBilling['BILLING1'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>เลือก Zone :</label>
                                            <select id="cb_copydiagramzone" name="cb_copydiagramzone" class="form-control"  title="เลือกประเภทรถ..." >
                                                <option value="">เลือก Zone</option>
                                                <?php
                                                $sql_seZone = "{call megVehicletransportpricerklttprostc_v2(?,?)}";
                                                $params_seZone = array(
                                                    array('select_zone', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seZone = sqlsrv_query($conn, $sql_seZone, $params_seZone);
                                                while ($result_seZone = sqlsrv_fetch_array($query_seZone, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seZone['ZONE'] ?>"><?= $result_seZone['ZONE'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>เลือก Location :</label>
                                            <select id="cb_copydiagramlocation" name="cb_copydiagramlocation" class="form-control"  title="เลือกประเภทรถ..." >
                                                <option value="">เลือก Location</option>
                                                <?php
                                                $sql_seLocation = "{call megVehicletransportpricerklttprostc_v2(?,?)}";
                                                $params_seLocation = array(
                                                    array('select_location', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seLocation = sqlsrv_query($conn, $sql_seLocation, $params_seLocation);
                                                while ($result_seLocation = sqlsrv_fetch_array($query_seLocation, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seLocation['LOCATION'] ?>"><?= $result_seLocation['LOCATION'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <?php
                                    } else if ($_GET['customercode'] == 'TTAST') {
                                        ?>
                                        <div class="col-lg-3">
                                            <label>เลือกวางบิล :</label>
                                            <select id="cb_copydiagrambilling" name="cb_copydiagrambilling" class="form-control"  title="เลือกประเภทรถ..." >

                                                <?php
                                                $sql_seBilling = "{call megVehicletransportpricerklttaststc_v2(?,?)}";
                                                $params_seBilling = array(
                                                    array('select_billing', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                                                while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seBilling['BILLING1'] ?>"><?= $result_seBilling['BILLING1'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>เลือก Zone :</label>
                                            <select id="cb_copydiagramzone" name="cb_copydiagramzone" class="form-control"  title="เลือกประเภทรถ..." >
                                                <option value="">เลือก Zone</option>
                                                <?php
                                                $sql_seZone = "{call megVehicletransportpricerklttaststc_v2(?,?)}";
                                                $params_seZone = array(
                                                    array('select_zone', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seZone = sqlsrv_query($conn, $sql_seZone, $params_seZone);
                                                while ($result_seZone = sqlsrv_fetch_array($query_seZone, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seZone['ZONE'] ?>"><?= $result_seZone['ZONE'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>เลือก Location :</label>
                                            <select id="cb_copydiagramlocation" name="cb_copydiagramlocation" class="form-control"  title="เลือกประเภทรถ..." >
                                                <option value="">เลือก Location</option>
                                                <?php
                                                $sql_seLocation = "{call megVehicletransportpricerklttaststc_v2(?,?)}";
                                                $params_seLocation = array(
                                                    array('select_location', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seLocation = sqlsrv_query($conn, $sql_seLocation, $params_seLocation);
                                                while ($result_seLocation = sqlsrv_fetch_array($query_seLocation, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seLocation['LOCATION'] ?>"><?= $result_seLocation['LOCATION'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <?php
                                    } else if ($_GET['customercode'] == 'TTTC') {
                                        ?>
                                        <div class="col-lg-3">
                                            <label>เลือกวางบิล :</label>
                                            <select id="cb_copydiagrambilling" name="cb_copydiagrambilling" class="form-control"  title="เลือกประเภทรถ..." >

                                                <?php
                                                $sql_seBilling = "{call megVehicletransportpricerkltttcstc_v2(?,?)}";
                                                $params_seBilling = array(
                                                    array('select_billing', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                                                while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seBilling['BILLING1'] ?>"><?= $result_seBilling['BILLING1'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>เลือก Zone :</label>
                                            <select id="cb_copydiagramzone" name="cb_copydiagramzone" class="form-control"  title="เลือกประเภทรถ..." >
                                                <option value="">เลือก Zone</option>
                                                <?php
                                                $sql_seZone = "{call megVehicletransportpricerkltttcstc_v2(?,?)}";
                                                $params_seZone = array(
                                                    array('select_zone', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seZone = sqlsrv_query($conn, $sql_seZone, $params_seZone);
                                                while ($result_seZone = sqlsrv_fetch_array($query_seZone, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seZone['ZONE'] ?>"><?= $result_seZone['ZONE'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>เลือก Location :</label>
                                            <select id="cb_copydiagramlocation" name="cb_copydiagramlocation" class="form-control"  title="เลือกประเภทรถ..." >
                                                <option value="">เลือก Location</option>
                                                <?php
                                                $sql_seLocation = "{call megVehicletransportpricerkltttcstc_v2(?,?)}";
                                                $params_seLocation = array(
                                                    array('select_location', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seLocation = sqlsrv_query($conn, $sql_seLocation, $params_seLocation);
                                                while ($result_seLocation = sqlsrv_fetch_array($query_seLocation, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seLocation['LOCATION'] ?>"><?= $result_seLocation['LOCATION'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <?php
                                    }
                                } else if ($_GET['companycode'] == 'RKS') {
                                    if ($_GET['customercode'] == 'DENSO-THAI' || $_GET['customercode'] == 'DENSO-WGR' || $_GET['customercode'] == 'DENSO-SALES' || $_GET['customercode'] == 'ANDEN' || $_GET['customercode'] == 'SDM' || $_GET['customercode'] == 'SKD' || $_GET['customercode'] == 'DENSO') {
                                        ?>

                                        <div class="col-lg-3">
                                            <label>Route No :</label>
                                            <select id="cb_copydiagramrouteno" name="cb_copydiagramrouteno" class="form-control">

                                                <option value="">เลือก Route No.</option>
                                                <?php
                                                $sql_seRouteno = "{call megVehicletransportpricerksdenso_v2(?,?)}";
                                                $params_seRouteno = array(
                                                    array('select_routeno', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seRouteno = sqlsrv_query($conn, $sql_seRouteno, $params_seRouteno);
                                                while ($result_seRouteno = sqlsrv_fetch_array($query_seRouteno, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seRouteno['ROUTENO'] ?>"><?= $result_seRouteno['ROUTENO'] ?></option>
                                                    <?php
                                                }
                                                ?>


                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>Route Type :</label>
                                            <select id="cb_copydiagramroutetype" name="cb_copydiagramroutetype" class="form-control">

                                                <option value="">เลือก Route Type</option>
                                                <?php
                                                $sql_seRoutetype = "{call megVehicletransportpricerksdenso_v2(?,?)}";
                                                $params_seRoutetype = array(
                                                    array('select_routetype', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seRoutetype = sqlsrv_query($conn, $sql_seRoutetype, $params_seRoutetype);
                                                while ($result_seRoutetype = sqlsrv_fetch_array($query_seRoutetype, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seRoutetype['ROUTETYPE'] ?>"><?= $result_seRoutetype['ROUTETYPE'] ?></option>
                                                    <?php
                                                }
                                                ?>

                                            </select>

                                        </div>
                                        <?php
                                    } else if ($_GET['customercode'] == 'TGT') {
                                        ?>

                                        <div class="col-lg-3">
                                            <label>ประเภทรถ :</label>
                                            <select id="cb_copydiagramcartype" name="cb_copydiagramcartype" class="form-control">
                                                <option value="">เลือก ประเภทรถ</option>
                                                <?php
                                                $sql_seVehicletype = "{call megVehicletransportpricerkstgt_v2(?,?)}";
                                                $params_seVehicletype = array(
                                                    array('select_vehicletype', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
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
                                        <div class="col-lg-3">
                                            <label>ต้นทาง :</label>
                                            <select id="cb_copydiagramjobstart" name="cb_copydiagramjobstart" class="form-control">
                                                <option value="">เลือก ต้นทาง</option>
                                                <?php
                                                $sql_seFrom = "{call megVehicletransportpricerkstgt_v2(?,?)}";
                                                $params_seFrom = array(
                                                    array('select_from', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seFrom = sqlsrv_query($conn, $sql_seFrom, $params_seFrom);
                                                while ($result_seFrom = sqlsrv_fetch_array($query_seFrom, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seFrom['FROM'] ?>"><?= $result_seFrom['FROM'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>ปลายทาง :</label>
                                            <select id="cb_copydiagramjobend" name="cb_copydiagramjobend" class="form-control" >
                                                <option value="">เลือก ปลายทาง</option>
                                                <?php
                                                $sql_seTo = "{call megVehicletransportpricerkstgt_v2(?,?)}";
                                                $params_seTo = array(
                                                    array('select_to', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seTo = sqlsrv_query($conn, $sql_seTo, $params_seTo);
                                                while ($result_seTo = sqlsrv_fetch_array($query_seTo, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seTo['TO'] ?>"><?= $result_seTo['TO'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <?php
                                    } else if ($_GET['customercode'] == 'STM') {
                                        ?>

                                        <div class="col-lg-3">
                                            <label>ประเภทรถ :</label>
                                            <select id="cb_copydiagramcartype" name="cb_copydiagramcartype" class="form-control">
                                                <option value="">เลือก ประเภทรถ</option>
                                                <?php
                                                $sql_seVehicletype = "{call megVehicletransportpricerksstm_v2(?,?)}";
                                                $params_seVehicletype = array(
                                                    array('select_vehicletype', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
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
                                        <div class="col-lg-3">
                                            <label>Transportation :</label>
                                            <select id="cb_copydiagramjobstart" name="cb_copydiagramjobstart" class="form-control">
                                                <option value="">เลือก Transportation</option>
                                                <?php
                                                $sql_seFrom = "{call megVehicletransportpricerksstm_v2(?,?)}";
                                                $params_seFrom = array(
                                                    array('select_from', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seFrom = sqlsrv_query($conn, $sql_seFrom, $params_seFrom);
                                                while ($result_seFrom = sqlsrv_fetch_array($query_seFrom, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seFrom['TRANSPORTATION'] ?>"><?= $result_seFrom['TRANSPORTATION'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <?php
                                    } else if ($_GET['customercode'] == 'TMT') {
                                        ?>

                                        <div class="col-lg-3">
                                            <label>ประเภทรถ :</label>
                                            <select id="cb_copydiagramcartype" name="cb_copydiagramcartype" class="form-control">
                                                <option value="">เลือก ประเภทรถ</option>
                                                <?php
                                                $sql_seVehicletype = "{call megVehicletransportpricerkstmt_v2(?,?)}";
                                                $params_seVehicletype = array(
                                                    array('select_vehicletype', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
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
                                        <div class="col-lg-3">
                                            <label>Transportation :</label>
                                            <select id="cb_copydiagramjobstart" name="cb_copydiagramjobstart" class="form-control">
                                                <option value="">เลือก Transportation</option>
                                                <?php
                                                $sql_seFrom = "{call megVehicletransportpricerkstmt_v2(?,?)}";
                                                $params_seFrom = array(
                                                    array('select_from', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seFrom = sqlsrv_query($conn, $sql_seFrom, $params_seFrom);
                                                while ($result_seFrom = sqlsrv_fetch_array($query_seFrom, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seFrom['TRANSPORTATION'] ?>"><?= $result_seFrom['TRANSPORTATION'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <?php
                                    } else if ($_GET['customercode'] == 'TAW') {
                                        ?>

                                        <div class="col-lg-3">
                                            <label>ประเภทรถ :</label>
                                            <select id="cb_copydiagramcartype" name="cb_copydiagramcartype" class="form-control">
                                                <option value="">เลือก ประเภทรถ</option>
                                                <?php
                                                $sql_seVehicletype = "{call megVehicletransportpricerkstaw_v2(?,?)}";
                                                $params_seVehicletype = array(
                                                    array('select_vehicletype', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
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
                                        <div class="col-lg-3">
                                            <label>Transportation :</label>
                                            <select id="cb_copydiagramjobstart" name="cb_copydiagramjobstart" class="form-control">
                                                <option value="">เลือก Transportation</option>
                                                <?php
                                                $sql_seFrom = "{call megVehicletransportpricerkstaw_v2(?,?)}";
                                                $params_seFrom = array(
                                                    array('select_from', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seFrom = sqlsrv_query($conn, $sql_seFrom, $params_seFrom);
                                                while ($result_seFrom = sqlsrv_fetch_array($query_seFrom, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?= $result_seFrom['TRANSPORTATION'] ?>"><?= $result_seFrom['TRANSPORTATION'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <?php
                                    }
                                } else if ($_GET['companycode'] == 'RCC' || $_GET['companycode'] == 'RATC') {
                                    if ($_GET['pricetype'] == '1') {
                                        ?>

                                        <div class="col-lg-3">
                                            <font style="color: red">* </font><label>ต้นทาง :</label>
                                            <input type="text" class="form-control"  id="txt_copydiagramjobstart" name="txt_copydiagramjobstart"> 
                                        </div>



                                        <div class="col-lg-2">
                                            <label>CLUSTER :</label>

                                            <div class="dropdown bootstrap-select show-tick form-control">

                                                <select multiple="" onchange="select_cluster()" id="cb_copydiagramcluster" name="cb_copydiagramcluster" class="selectpicker form-control" id="number-multiple" data-container="body" data-live-search="true" title="เลือก cluster..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98">
                                                    <?php
                                                    $sql_seCluster = "{call megVehicletransportpricerccttt1_v2(?,?)}";
                                                    $params_seCluster = array(
                                                        array('select_cluster', SQLSRV_PARAM_IN),
                                                        array('', SQLSRV_PARAM_IN)
                                                    );
                                                    $query_seCluster = sqlsrv_query($conn, $sql_seCluster, $params_seCluster);
                                                    while ($result_seCluster = sqlsrv_fetch_array($query_seCluster, SQLSRV_FETCH_ASSOC)) {
                                                        ?>
                                                        <option value="<?= $result_seCluster['CLUSTER'] ?>"><?= $result_seCluster['CLUSTER'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <input class="form-control" style="display: none"  id="txt_copydiagramcluster" name="txt_copydiagramcluster" maxlength="500" value="" >


                                                <div class="dropdown-menu open" role="combobox">
                                                    <div class="bs-searchbox">
                                                        <input type="text" class="form-control" autocomplete="off" role="textbox" aria-label="Search"></div>
                                                    <div class="bs-actionsbox">
                                                        <div class="btn-group btn-group-sm btn-block">
                                                            <button type="button" class="actions-btn bs-select-all btn btn-default">Select All</button>
                                                            <button type="button" class="actions-btn bs-deselect-all btn btn-default">Deselect All</button>
                                                        </div>
                                                    </div>
                                                    <div class="inner open" role="listbox" aria-expanded="false" tabindex="-1">
                                                        <ul class="dropdown-menu inner "></ul>
                                                    </div>
                                                </div>
                                            </div>          

                                        </div>





                                        <div class="col-lg-2">

                                            <label>ปลายทาง :</label>
                                            <div id="data_copydiagramjobenddef">
                                                <div class="dropdown bootstrap-select show-tick form-control">

                                                    <select multiple="" id="cb_copydiagramjobend" name="cb_copydiagramjobend" class="selectpicker form-control" id="number-multiple" data-container="body" data-live-search="true" title="เลือก ปลายทาง..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >

                                                    </select>
                                                    <input class="form-control" style="display: none"   id="txt_copydiagramjobend" name="txt_copydiagramjobend" maxlength="500" value="" >


                                                    <div class="dropdown-menu open" role="combobox">
                                                        <div class="bs-searchbox">
                                                            <input type="text" class="form-control" autocomplete="off" role="textbox" aria-label="Search"></div>
                                                        <div class="bs-actionsbox">
                                                            <div class="btn-group btn-group-sm btn-block">
                                                                <button type="button" class="actions-btn bs-select-all btn btn-default">Select All</button>
                                                                <button type="button" class="actions-btn bs-deselect-all btn btn-default">Deselect All</button>
                                                            </div>
                                                        </div>
                                                        <div class="inner open" role="listbox" aria-expanded="false" tabindex="-1">
                                                            <ul class="dropdown-menu inner "></ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="data_copydiagramjobendsr"></div>
                                        </div>
                                        <div class="col-lg-2">
                                            <label>ก่อนเวลารายงานตัว (OTH) :</label>
                                            <input type="text" class="form-control"  id="txt_beforpersentoth"  name="txt_beforpersentoth"> 
                                        </div>



                                        <?php
                                    } else if ($_GET['pricetype'] == '2') {
                                        ?>
                                        <div class="col-lg-3">
                                            <font style="color: red">* </font><label>ต้นทาง :</label>
                                            <input type="text" class="form-control"  id="txt_copydiagramjobstart" name="txt_copydiagramjobstart"> 
                                        </div>
                                        <div class="col-lg-2">
                                            <label>งาน :</label><br>
                                            <div id="copydiagramroutedef">
                                                <select  id="cb_copydiagramroute" name="cb_copydiagramroute" class="form-control" >
                                                    <option value="">เลือกงาน</option>
                                                </select>
                                            </div>
                                            <div id="copydiagramroutesr"></div>
                                        </div>


                                        <div class="col-lg-2">
                                            <label>งาน(ย่อย) :</label><br>
                                            <div id="copydiagramsubroutedef">
                                                <select  id="cb_copydiagramsubroute" name="cb_copydiagramsubroute" class="form-control" >
                                                    <option value="">เลือกงาน(ย่อย)</option>
                                                </select>
                                            </div>
                                            <div id="copydiagramsubroutesr"></div>

                                        </div>

                                        <div class="col-lg-2">
                                            <label>จำนวนโหลด :</label><br>
                                            <select  id="cb_copydiagramload" name="cb_copydiagramload" class="form-control">
                                                <option value="">เลือกจำนวนโหลด</option>
                                                <option value="4">4 Load</option>
                                                <option value="8">8 Load</option>

                                            </select>
                                        </div>


                                        <?php
                                    }
                                }
                            }
                            ?>

                        </div>

                        <div class="row">&nbsp;</div>
                        <div class="row">
                            <div class="col-lg-2">
                                <label>เวลาทำแผน :</label>
                                <input type="text" class="form-control" value="<?= $result_seSystime['SYSTIME'] ?>" style="background-color: #f080802e" disabled="" id="txt_copydiagramdateinput" name="txt_copydiagramdateinput">
                            </div>
                            <div class="col-lg-2">
                                <label>เวลารายงานตัว :</label>
                                <input type="text" class="form-control timeen" style="background-color: #f080802e" disabled="" id="txt_copydiagramdatepresent" name="txt_copydiagramdatepresent">

                            </div>
                            <div class="col-lg-2">
                                <label>เวลาเข้าวีแอล ( <input type="checkbox" id="chk_copydiagramdatevlin" name="chk_copydiagramdatevlin" onchange="change_textboxdate()"> : ข้ามวัน )</label>
                                <input type="text" class="form-control timeen" id="txt_copydiagramdatevlin" name="txt_copydiagramdatevlin" onchange="show_timepresent(this.value)">
                                <input type="text" class="form-control datetimeen" id="txt_copydiagramdatevlin2" name="txt_copydiagramdatevlin2" onchange="show_timepresent(this.value)" style="display: none">
                            </div>
                            <div class="col-lg-2">
                                <label>เวลาออกวีแอล ( <input type="checkbox" id="chk_copydiagramdatevlout" name="chk_copydiagramdatevlout" onchange="change_textboxdate()"> : ข้ามวัน )</label>
                                <input type="text" class="form-control timeen" id="txt_copydiagramdatevlout" name="txt_copydiagramdatevlout">
                                <input type="text" class="form-control datetimeen" id="txt_copydiagramdatevlout2" name="txt_copydiagramdatevlout2" style="display: none">
                            </div>
                            <div class="col-lg-2">
                                <label>เวลาเข้าดีลเลอร์ ( <input type="checkbox" id="chk_copydiagramdatedealerin" name="chk_copydiagramdatedealerin" onchange="change_textboxdate()"> : ข้ามวัน )</label>
                                <input type="text" class="form-control timeen" id="txt_copydiagramdatedealerin" name="txt_copydiagramdatedealerin">
                                <input type="text" class="form-control  datetimeen" id="txt_copydiagramdatedealerin2" name="txt_copydiagramdatedealerin2" style="display: none">
                            </div>
                            <div class="col-lg-2">
                                <label>เวลากลับบริษัท ( <input type="checkbox" id="chk_copydiagramdatereturn" name="chk_copydiagramdatereturn" onchange="change_textboxdate()"> : ข้ามวัน )</label>
                                <input type="text" class="form-control timeen" id="txt_copydiagramdatereturn" name="txt_copydiagramdatereturn">
                                <input type="text" class="form-control datetimeen" id="txt_copydiagramdatereturn2" name="txt_copydiagramdatereturn2" style="display: none">
                            </div>
                        </div>
                        <div class="row">&nbsp;</div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="well" va>
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <label class="checkbox-inline">
                                                <input type="checkbox" id="chk_copydiagrammonday" name="chk_copydiagrammonday" checked="" value="" style="transform: scale(2)">&nbsp;<label>จันทร์</label><label id="lab_monday"></label>
                                            </label>
                                        </div>

                                        <div class="col-lg-2">
                                            <label class="checkbox-inline">
                                                <input type="checkbox" id="chk_copydiagramtuesday" name="chk_copydiagramtuesday" checked="" value="" style="transform: scale(2)">&nbsp;<label>อังคาร</label><label id="lab_tuesday"></label>
                                            </label>
                                        </div>
                                        <div class="col-lg-2">
                                            <label class="checkbox-inline">
                                                <input type="checkbox" checked="" id="chk_copydiagramwednesday" name="chk_copydiagramwednesday" value="" style="transform: scale(2)">&nbsp;<label>พุธ</label><label id="lab_wednesday"></label>
                                            </label>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="checkbox-inline">
                                                <input type="checkbox" checked="" id="chk_copydiagramthursday" name="chk_copydiagramthursday" value="" style="transform: scale(2)">&nbsp;<label>พฤหัสบดี</label><label id="lab_thursday"></label>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <label class="checkbox-inline">
                                                <input type="checkbox" checked="" id="chk_copydiagramfriday" name="chk_copydiagramfriday" value="" style="transform: scale(2)">&nbsp;<label>ศุกร์</label><label id="lab_friday"></label>
                                            </label>
                                        </div>
                                        <div class="col-lg-2">
                                            <label class="checkbox-inline">
                                                <input type="checkbox" checked="" id="chk_copydiagramsaturday" name="chk_copydiagramsaturday" value="" style="transform: scale(2)">&nbsp;<label>เสาร์</label><label id="lab_saturday"></label>
                                            </label>
                                        </div>
                                        <div class="col-lg-2">
                                            <label class="checkbox-inline">
                                                <input type="checkbox" id="chk_copydiagramsunday" name="chk_copydiagramsunday" checked="" value="" style="transform: scale(2)">&nbsp;<label>อาทิตย์</label><label id="lab_sunday"></label>
                                            </label>
                                        </div>
                                    </div>

                                </div>
                            </div>





                        </div>

                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                        <!--<button type="button" class="btn btn-success" onclick="experience()">ตรวจสอบประสปการณ์ในการวิ่งงาน</button>-->
                        <button type="button" class="btn btn-primary" onclick="save_copydiagram()">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_checkdriver" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-modal-parent="#modal_copydiagram">
            <div class="modal-dialog" style="width: 60%">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">

                        <h5 class="modal-title">ประสปการณ์ในเส้นทางและสถานที่รับส่งสินค้า</h5>
                    </div>
                    <div class="modal-body">
                        <div id="modal_checkdriversr"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal fade" id="modal_adddn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 80%">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="title">เอกสารรายละเอียดสินค้า</h5>

                    </div>
                    <div class="modal-body">

                        <div class="row" >

                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        วันที่/เวลา ปฎิบัติงานจริง
                                    </div>
                                    <!-- /.panel-heading -->
                                    <div class="panel-body">
                                        <div class="table-responsive">


                                            <div id="datadef_actual">
                                                <table class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>

                                                            <th>เวลารายงานตัว</th>
                                                            <th>เวลาเปิดงาน</th>
                                                            <th>เวลาเข้า VL</th>
                                                            <th>เวลาออก VL</th>
                                                            <th>เวลาเข้าดีลเลอร์</th>
                                                            <th>เวลากลับบริษัท</th>
                                                            <th>เวลาปิดงาน</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        /* $sql_seVehicletransportplan = "{call megVehicletransportplan_v2(?,?)}";
                                                          $params_seVehicletransportplan = array(
                                                          array('select_vehicletransportplan', SQLSRV_PARAM_IN),
                                                          array('', SQLSRV_PARAM_IN)
                                                          );
                                                          $query_seVehicletransportplan = sqlsrv_query($conn, $sql_seVehicletransportplan, $params_seVehicletransportplan);
                                                          while ($result_seVehicletransportplan = sqlsrv_fetch_array($query_seVehicletransportplan, SQLSRV_FETCH_ASSOC)) {
                                                         */
                                                        ?>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td><input type="text" class="form-control datetimeen" onchange="edit_vehicletransportplanactual(this.value, 'DATEVLIN_ACTUAL')"</td>
                                                            <td><input type="text" class="form-control datetimeen" onchange="edit_vehicletransportplanactual(this.value, 'DATEVLOUT_ACTUAL')"></td>
                                                            <td><input type="text" class="form-control datetimeen" onchange="edit_vehicletransportplanactual(this.value, 'DATEDEALERIN_ACTUAL')"></td>
                                                            <td><input type="text" class="form-control datetimeen" onchange="edit_vehicletransportplanactual(this.value, 'DATERETURN_ACTUAL')"></td>
                                                            <td><input type="text" class="form-control datetimeen" onchange="edit_vehicletransportplanactual(this.value, 'DATECLOSE_ACTUAL')"></td>

                                                        </tr>
                                                        <?php
//}
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="datasr_actual"></div>
                                        </div>
                                        <!-- /.table-responsive -->
                                    </div>
                                    <!-- /.panel-body -->
                                </div>
                                <!-- /.panel -->
                            </div>
                        </div>
                        <div class="row" >

                            <input class="form-control" id="txt_route" name="txt_route" style="display: none" >
                            <input class="form-control" id="txt_vehicletransportplanid" name="txt_vehicletransportplanid" style="display: none" >
                            <input class="form-control" id="txt_jobno" name="txt_jobno" style="display: none" >


                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        เอกสารรายละเอียดสินค้า
                                    </div>
                                    <!-- /.panel-heading -->
                                    <div class="panel-body">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <font style="color: red">* </font><label>ประเภทเอกสาร :</label>
                                                <select  class="form-control" id="cb_documenttype" name="cb_documenttype">
                                                    <option value="DOC-0001">เอกสารรายละเอียดสินค้า</option>
                                                    <option value="DOC-0002">ใบวางบิลของลูกค้า</option>
                                                    <option value="DOC-0003">เอกสารอื่นๆ</option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-2">

                                            <div class="form-group">
                                                <font style="color: red">* </font><label>จำนวน :</label>
                                                <input class="form-control" id="txt_amount" name="txt_amount">
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <font style="color: red">* </font> <label>หน่วย :</label>
                                                <select  class="form-control" id="cb_unit" name="cb_unit">
                                                    <option   value ="UNIT-041425">คัน</option>
                                                    <?php
                                                    $sql_seUnit = "{call megUnit_v2(?,?)}";
                                                    $params_seUnit = array(
                                                        array('select_unit', SQLSRV_PARAM_IN),
                                                        array('', SQLSRV_PARAM_IN)
                                                    );
                                                    $query_seUnit = sqlsrv_query($conn, $sql_seUnit, $params_seUnit);
                                                    while ($result_seUnit = sqlsrv_fetch_array($query_seUnit, SQLSRV_FETCH_ASSOC)) {
                                                        ?>
                                                        <option   value ="<?= $result_seUnit['UNITCODE'] ?>"><?= $result_seUnit['UNITDESC'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">

                                            <div class="form-group">
                                                <label>หมายเหตุ :</label>
                                                <textarea class="form-control" id="txt_documentremark" name="txt_documentremark"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <font style="color: red">* </font><label>สถานะ :</label>

                                                <select class="form-control" id="cb_activestatus" name="cb_activestatus">

                                                    <?php
                                                    $selected = "SELECTED";

                                                    switch ($result_getCustomer['ACTIVESTATUS']) {
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
                                                                <option value = "1">ใช้งาน</option>
                                                                <option value="0" >ไม่ใช้งาน</option>
                                                                <?php
                                                            }
                                                            break;
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div id="datadef"></div>
                                            <div id="datasr"></div>
                                        </div>
                                        <!-- /.table-responsive -->
                                    </div>
                                    <!-- /.panel-body -->
                                </div>
                                <!-- /.panel -->
                            </div>


                        </div>



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                        <button type="button" class="btn btn-primary" onclick="save_vehicletransportdocument()">บันทึก</button>
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
        <div class="row">

            <div class="col-lg-12" style="text-align: right">


                <form method="post">
                    <input class="btn btn-default" type="button" style="background-color: red;border:solid 2px white" id="btn_srquotation" name="btn_srquotation" value=""> * แจ้งเตือนข้อมูล ไม่พบราคาขนส่ง &emsp;
                    <input type="text" id="txt_vehicletransportdocumentid" name="txt_vehicletransportdocumentid" class="form-control" style="display: none"  value="">
                    <input type="text" id="txt_companycode" name="txt_companycode" class="form-control" style="display: none"  value="<?= $_GET['companycode'] ?>">
                    <input type="text" id="txt_customercode" name="txt_customercode" class="form-control" style="display: none"  value="<?= $_GET['customercode'] ?>">
                    <input class="form-control" style="display: none"  id="txt_copydiagramsubroute" name="txt_copydiagramsubroute" maxlength="500" value="" >
                    <!--<button type="button" id="addrow" name="addrow" onclick="javascript:appendRow()" class="btn btn-outline btn-default"><li class="fa fa-plus-circle"></li> เพิ่มแถว</button>-->
                    <input  style="margin-right: 15px" type="button"  data-toggle="modal"  data-target="#modal_copydiagram"  class=" btn btn-default" value="NEW DIAGRAM">
                    <!--<input  style="margin-right: 15px"  type="button"  onclick="save_vehicletransportplan('<?php //echo $_GET['EMPLOYEENAME1']                                                                                                   ?>')"  class=" btn btn-default" value="NEW JOB">-->
                    <!--<button type="button" onclick="javascript:deleteRows()" class="btn btn-outline btn-default"><li class="fa fa-plus-circle"></li> ลบแถว</button>-->
                    <!--<button type="button" onclick="javascript:appendColumn()" class="btn btn-outline btn-default"><li class="fa fa-minus-circle"></li> เพิ่มคอลัมม์</button>-->
                    <!--<button type="button" onclick="javascript:deleteColumns()" class="btn btn-outline btn-default"><li class="fa fa-minus-circle"></li> ลบคอลัมม์</button>
                    <button type="button" onclick="javascript:deleteColumns();deleteRows()" class="btn btn-outline btn-default"><li class="fa fa-minus-circle"></li> ลบแถวและคอลัมม์</button>-->
                </form>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12">&nbsp;</div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color: #e7e7e7">
                        <div class="row">
                            <div class="col-lg-6">
                                <?php
                                $meg = 'แผนขนส่ง';
                                echo "<a href='report_company.php'>บริษัท</a> / <a href='report_customer.php?type=report&companycode=" . $_GET['companycode'] . "'>ลูกค้า</a>  / " . $meg;
                                $link = "<a href='report_company.php?type=report'>บริษัท</a> / <a href='report_customer.php?type=report&companycode=" . $_GET['companycode'] . "'>ลูกค้า</a> ";
                                $_SESSION["link"] = $link;
                                ?>
                            </div>
                            <div class="col-lg-6 text-right"><?= $result_seComp['Company_NameT'] ?>
                            </div>
                        </div>
                    </div>
                    <!-- /.panel-heading -->

                    <div class="panel-body">

                        <div class="row" >
                            <!--<div class="col-lg-4"><br>
                                <a href="#" onclick="pdf_transportplan();" class="btn btn-default">PDF <li class="fa fa-print"></li></a>
                            </div>-->

                            <div class="col-lg-6">&nbsp;</div>
                            <div class="col-lg-2" >วันที่เริ่มต้น
                                <input type="text" value="<?= $result_seSystime['STARTWEEK']; ?>" name="txt_datestartsr" readonly="" id="txt_datestartsr" onchange="add_dateweek1(this.value)" class="form-control dateen" >
                            </div>

                            <div class="col-lg-2" >วันที่สิ้นสุด
                                <input type="text" value="<?= $result_seSystime['ENDWEEK']; ?>" name="txt_dateendsr" style="background-color: #f080802e"  disabled=""  id="txt_dateendsr" class="form-control dateen" >    
                            </div>
                            <div class="col-lg-2 " >สถานะ
                                <select  class="form-control" id="cb_statussr" name="cb_statussr" onchange="dateendsr()">


                                    <option   value ="O">แผนงานยังไม่ถึงเวลารายงาน</option>
                                    <option   value ="P">แผนงานรายงานตัวเรียบร้อย</option>
                                    <option   value ="L">แผนงานเลยเวลารายงานตัว</option>
                                    <option   value ="1">แผนงานเปิดงาน</option>
                                    <option   value ="2">แผนงานปิดงาน</option>
                                    <option   value ="3">แผนงานเอกสารสมบูรณ์</option>
                                    <option   value ="0">แผนงานยกเลิก</option>
                                    <option   value ="X">แผนงานตัดงาน</option>


                                </select>
                            </div>

                        </div>
                        <div class="row" >&nbsp;</div>

                        <div id="showdatadef">
                            <div class="row">
                                <div class="col-lg-12">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#monday" data-toggle="tab" aria-expanded="true" onclick="show_monday()">จันทร์<label id="lbl_m"></label></a>
                                        </li>
                                        <li class=""><a href="#tuesday" data-toggle="tab" aria-expanded="true" onclick="show_tuesday()">อังคาร<label id="lbl_tu"></label></a>
                                        </li>
                                        <li class=""><a href="#wednesday" data-toggle="tab" aria-expanded="false" onclick="show_wednesday()">พุธ<label id="lbl_w"></label></a>
                                        </li>

                                        <li class=""><a href="#thursday" data-toggle="tab" aria-expanded="false" onclick="show_thursday()">พฤหัสบดี<label id="lbl_th"></label></a>

                                        <li class=""><a href="#friday" data-toggle="tab" aria-expanded="false" onclick="show_friday()">ศุกร์<label id="lbl_f"></label></a>
                                        </li>
                                        <li class=""><a href="#saturday" data-toggle="tab" aria-expanded="false" onclick="show_saturday()">เสาร์<label id="lbl_sat"></label></a>
                                        </li>
                                        <li class=""><a href="#sunday" data-toggle="tab" aria-expanded="false" onclick="show_sunday()">อาทิตย์<label id="lbl_sun"></label></a>
                                        </li>
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <p>&nbsp;</p>


                                        <div class="tab-pane fade active in" id="mondaydef">
                                            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                <div id="show_mondaydef">
                                                    <table  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example11" role="grid" aria-describedby="dataTables-example11" style="width: 100%;">
                                                        <thead >
                                                            <tr>

                                                                <th style="text-align: center;"><label style="width: 50px">DELETE JOB</label></th>
                                                                <th style="text-align: center;"><label style="width: 50px">EDIT JOB</label></th>
                                                                <!--<th style="text-align: center;"><label style="width: 50px">COPY ROOT</label></th>-->
                                                                <!--<th style="text-align: center;"><label style="width: 50px">ADD DN</label></th>-->
                                                                <th style="text-align: center;"><label style="width: 50px">COPY JOB</label></th>
                                                                <th style="text-align: center;"><label style="width: 200px">พนักงาน(1)</label></th> 
                                                                <th style="text-align: center;"><label style="width: 200px">พนักงาน(2)</label></th>
                                                                <th style="text-align: center;"><label style="width: 200px">ชื่อรถ</label></th> 
                                                                <th style="text-align: center;"><label style="width: 200px">ต้นทาง</label></th>
                                                                <th style="text-align: center;"><label style="width: 200px">CLUSTER</label></th>
                                                                <th style="text-align: center;"><label style="width: 200px">ปลายทาง</label></th> 
                                                                <th style="text-align: center;"><label style="width: 100px">JOB NO</label></th>
                                                                <th style="text-align: center;"><label style="width: 100px">TRIP </label></th>
                                                                <th style="text-align: center;"><label style="width: 100px">วันที่ทำแผน</label></th>
                                                                <th style="text-align: center;"><label style="width: 100px">วันที่ทำงาน</label></th>
                                                                <th style="text-align: center;"><label style="width: 100px">วันที่ทำงานเสร็จ</label></th>
                                                                <th style="text-align: center;"><label style="width: 100px">รายงานตัว</label></th>
                                                                <th style="text-align: center;"><label style="width: 100px">เข้าวีแอล</label></th> 
                                                                <th style="text-align: center;"><label style="width: 100px">ออกวีแอล</label></th>
                                                                <th style="text-align: center;"><label style="width: 100px">เข้าดีลเลอร์</label></th>
                                                                <th style="text-align: center;"><label style="width: 100px">กลับบริษัท</label></th>
                                                                <th style="text-align: center;"><label style="width: 100px">สถานะ</label></th> 

            <!--<th style="text-align: center;">สายงาน</th>-->


                                                            </tr>

                                                        </thead>
                                                        <tbody>

                                                            <?php
                                                            $i1 = 1;

                                                            if ($_GET['vehicletransportplanid'] != "") {
                                                                $conditionmonday = " AND DATENAME(DW,a.DATEPRESENT) = 'Monday' AND a.COMPANYCODE ='" . $_GET['companycode'] . "' AND a.CUSTOMERCODE ='" . $_GET['customercode'] . "' AND a.VEHICLETRANSPORTPLANID = '" . $_GET['vehicletransportplanid'] . "' AND a.STATUSNUMBER = 'O'";
                                                            } else {
                                                                $conditionmonday = " AND DATENAME(DW,a.DATEPRESENT) = 'Monday' AND (CONVERT(DATE,a.DATEPRESENT,103) BETWEEN CONVERT(DATE,'" . $result_seSystime['STARTWEEK'] . "',103) AND CONVERT(DATE,'" . $result_seSystime['ENDWEEK'] . "',103)) AND a.STATUSNUMBER = 'O' AND a.COMPANYCODE ='" . $_GET['companycode'] . "' AND a.CUSTOMERCODE ='" . $_GET['customercode'] . "'";
                                                            }


                                                            $sql_sePlanmonday = "{call megVehicletransportplan_v2(?,?,?,?)}";
                                                            $params_sePlanmonday = array(
                                                                array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
                                                                array($conditionmonday, SQLSRV_PARAM_IN),
                                                                array($condish, SQLSRV_PARAM_IN),
                                                                array('', SQLSRV_PARAM_IN)
                                                            );
                                                            $query_sePlanmonday = sqlsrv_query($conn, $sql_sePlanmonday, $params_sePlanmonday);
                                                            while ($result_sePlanmonday = sqlsrv_fetch_array($query_sePlanmonday, SQLSRV_FETCH_ASSOC)) {

                                                                if ($result_sePlanmonday['COMPANYCODE'] == 'RRC') {
                                                                    if ($result_sePlanmonday['CUSTOMERCODE'] == 'GMT') {
                                                                        $jobsm1 = select_jobautocomplatestartgetway('megVehicletransportpricerrcgmt_v2', 'select_startways', '');
                                                                    } else if ($result_sePlanmonday['CUSTOMERCODE'] == 'BP') {
                                                                        $jobsm1 = select_jobautocomplatestartgetway('megVehicletransportpricerrcbp_v2', 'select_startways', '');
                                                                    } else if ($result_sePlanmonday['CUSTOMERCODE'] == 'TTAST') {
                                                                        $jobsm1 = select_jobautocomplatestartgetway('megVehicletransportpricerrcttast_v2', 'select_startways', '');
                                                                    } else if ($result_sePlanmonday['CUSTOMERCODE'] == 'TTTC') {
                                                                        $jobsm1 = select_jobautocomplatestartgetway('megVehicletransportpricerrctttc_v2', 'select_startways', '');
                                                                    }
                                                                } else if ($result_sePlanmonday['COMPANYCODE'] == 'RCC' || $result_sePlanmonday['COMPANYCODE'] == 'RATC') {
                                                                    $jobsm2 = select_jobautocomplate('megVehicletransportprice_v2', 'select_vehicletransportprice', '');
                                                                } else if ($result_sePlanmonday['COMPANYCODE'] == 'RKS') {
                                                                    if ($result_sePlanmonday['CUSTOMERCODE'] == 'DENSO-THAI' || $result_sePlanmonday['CUSTOMERCODE'] == 'DENSO-WGR' || $result_sePlanmonday['CUSTOMERCODE'] == 'DENSO-SALES' || $result_sePlanmonday['CUSTOMERCODE'] == 'ANDEN' || $result_sePlanmonday['CUSTOMERCODE'] == 'SDM' || $result_sePlanmonday['CUSTOMERCODE'] == 'SKD' || $result_sePlanmonday['CUSTOMERCODE'] == 'DENSO') {
                                                                        $jobsm3 = select_jobautocomplatestartrks_denso('megVehicletransportpricerksdenso_v2', 'select_routeno', '');
                                                                    } else if ($result_sePlanmonday['CUSTOMERCODE'] == 'TGT') {
                                                                        $jobsm4 = select_jobautocomplatestartrks_tgt('megVehicletransportpricerkstgt_v2', 'select_supplier', '');
                                                                    }
                                                                }
                                                                ?>
                                                                <tr 
                                                                <?php
                                                                if ($result_sePlanmonday['ACTUALPRICE'] == '' || $result_sePlanmonday['ACTUALPRICE'] == '0.00') {
                                                                    ?>
                                                                        style="color: red"
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    >


                                                                    <td style="text-align: center;">
                                                                        <button onclick="delete_vehicletransportplan('<?= $result_sePlanmonday['VEHICLETRANSPORTPLANID'] ?>');" title="ลบแผนการขนส่ง" type="button" class="btn btn-default btn-circle"><span class="fa fa-times"></span></button> 
                                                                    </td>

                                                                    <?php
                                                                    if ($result_sePlanmonday['COMPANYCODE'] == 'RCC' || $result_sePlanmonday['COMPANYCODE'] == 'RATC') {
                                                                        ?>
                                                                        <td style="text-align: center;">
                                                                            <button onclick="update_modalrcc('<?= $result_sePlanmonday['VEHICLETRANSPORTPLANID'] ?>')"  data-toggle="modal"  data-target="#modal_copydiagramupd"  title="แก้ไขแผนการขนส่ง" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-wrench"></span></button> 
                                                                        </td>
                                                                        <?php
                                                                    } else if ($result_sePlanmonday['COMPANYCODE'] == 'RRC') {
                                                                        ?>
                                                                        <td style="text-align: center;">
                                                                            <button onclick="update_modalrrc('<?= $result_sePlanmonday['VEHICLETRANSPORTPLANID'] ?>')"  data-toggle="modal"  data-target="#modal_copydiagramupdrrc"  title="แก้ไขแผนการขนส่ง" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-wrench"></span></button> 
                                                                        </td>
                                                                        <?php
                                                                    } else if ($result_sePlanmonday['COMPANYCODE'] == 'RKS') {
                                                                        ?>
                                                                        <td style="text-align: center;">
                                                                            <button onclick="update_modalrks('<?= $result_sePlanmonday['VEHICLETRANSPORTPLANID'] ?>')"  data-toggle="modal"  data-target="#modal_copydiagramupdrks"  title="แก้ไขแผนการขนส่ง" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-wrench"></span></button> 
                                                                        </td>
                                                                        <?php
                                                                    }
                                                                    ?>




                                                                    <td style="text-align: center;">
                                                                        <button title="COPY JOB" type="button" onclick="select_copyjob('<?= $result_sePlanmonday['JOBNO'] ?>', '<?= $result_sePlanmonday['JOBSTART'] ?>', '<?= $result_sePlanmonday['JOBEND'] ?>', '<?= $result_sePlanmonday['DATEVLIN'] ?>');" class="btn btn-default btn-circle" data-toggle="modal"  data-target="#modal_copyjob"><span class="fa fa-copy"></span></button>
                                                                    </td>
                                                                    <td><?= $result_sePlanmonday['EMPLOYEENAME1'] ?></td>
                                                                    <td><?= $result_sePlanmonday['EMPLOYEENAME2'] ?></td>
                                                                    <td><?= $result_sePlanmonday['THAINAME'] ?></td>
                                                                    <td><?= $result_sePlanmonday['JOBSTART'] ?></td>
                                                                    <td><?= $result_sePlanmonday['CLUSTER'] ?></td>
                                                                    <td><?= $result_sePlanmonday['JOBEND'] ?></td>
                                                                    <td ><?= $result_sePlanmonday['JOBNO'] ?></td>
                                                                    <td ><?= $result_sePlanmonday['TRIPNO'] ?></td>
                                                                    <td><?= $result_sePlanmonday['DATEINPUT'] ?></td>
                                                                    <td><?= $result_sePlanmonday['DATEWORKING'] ?></td>
                                                                    <td><?= $result_sePlanmonday['DATEWORKSUS'] ?></td>
                                                                    <td><?= $result_sePlanmonday['DATEPRESENT'] ?></td>
                                                                    <td><?= $result_sePlanmonday['DATEVLIN'] ?></td>
                                                                    <td><?= $result_sePlanmonday['DATEVLOUT'] ?></td>
                                                                    <td><?= $result_sePlanmonday['DATEDEALERIN'] ?></td>
                                                                    <td><?= $result_sePlanmonday['DATERETURN'] ?></td>
                                                                    <td>
                                                                        <?php
                                                                        switch ($result_sePlanmonday['STATUSNUMBER']) {
                                                                            case '0': {
                                                                                    ?>
                                                                                    แผนงานยกเลิก

                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case 'O': {
                                                                                    ?>
                                                                                    แผนงานยังไม่ถึงเวลารายงาน
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case 'L': {
                                                                                    ?>
                                                                                    แผนงานเลยเวลารายงานตัว
                                                                                    <?php
                                                                                }
                                                                                break;

                                                                            case '1': {
                                                                                    ?>
                                                                                    แผนงานเปิดงาน
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '2': {
                                                                                    ?>
                                                                                    แผนงานปิดงาน
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '3': {
                                                                                    ?>
                                                                                    แผนงานเอกสารสมบูรณ์
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            default : {
                                                                                    
                                                                                }
                                                                                break;
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                $i1++;
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade " id="monday">
                                            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer"> 
                                                <div id="show_monday"></div>

                                            </div>
                                        </div>


                                        <div class="tab-pane fade " id="tuesday">

                                            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                <div id="show_tuesday"></div>

                                            </div>
                                        </div>


                                        <div class="tab-pane fade " id="wednesday">

                                            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                <div id="show_wednesday"></div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade " id="thursday">

                                            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                <div id="show_thursday"></div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade " id="friday">

                                            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                <div id="show_friday"></div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade " id="saturday">

                                            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                <div id="show_saturday"></div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade " id="sunday">

                                            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer"> 
                                                <div id="show_sunday"></div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="showdatasr">

                        </div>
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
        <script src="../js/jquery.datetimepicker.full.js"></script>
        <script src="../dist/js/jquery.autocomplete.js"></script>
        <script src="../dist/js/bootstrap-select.js"></script>

        <?php
        $job = '';
        if ($_GET['companycode'] == 'RRC' && $_GET['customercode'] == 'GMT') {
            $job = select_jobautocomplatestartgetway('megVehicletransportpricerrcgmt_v2', 'select_startways', '');
        }
        if ($_GET['companycode'] == 'RRC' && $_GET['customercode'] == 'BP') {
            $job = select_jobautocomplatestartgetway('megVehicletransportpricerrcbp_v2', 'select_startways', '');
        }
        if ($_GET['companycode'] == 'RRC' && $_GET['customercode'] == 'TTAST') {
            $job = select_jobautocomplatestartgetway('megVehicletransportpricerrcttast_v2', 'select_startways', '');
        }
        if ($_GET['companycode'] == 'RRC' && $_GET['customercode'] == 'TTTC') {
            $job = select_jobautocomplatestartgetway('megVehicletransportpricerrctttc_v2', 'select_startways', '');
        } else if ($_GET['companycode'] == 'RCC' && $_GET['customercode'] == 'TTT') {
            $job = select_jobautocomplate('megVehicletransportpricerccttt1_v2', 'select_vehicletransportprice', '');
        } else if ($_GET['companycode'] == 'RATC' && $_GET['customercode'] == 'TTT') {
            $job = select_jobautocomplate('megVehicletransportpricerccttt1_v2', 'select_vehicletransportprice', '');
        }
        if ($_GET['companycode'] == 'RRC' || $_GET['companycode'] == 'RCC' || $_GET['companycode'] == 'RATC') {
            $thainame = select_carautocomplate('megVehicleinfo_v2', 'selectcond_vehicleinfo', " AND a.THAINAME != '-' AND (a.ENGNAME  LIKE '%R-%' OR a.ENGNAME  LIKE '%RA-%'", " OR a.THAINAME LIKE '%ดินแดง%'  OR a.THAINAME  LIKE '%อุทัยธานี%'  OR a.THAINAME  LIKE '%คลองเขื่อน%'  ", " OR a.THAINAME LIKE '%RP-%' OR a.THAINAME  LIKE '%สวนผึ้ง%' OR a.THAINAME  LIKE '%ด่านช้าง%'", " OR a.ENGNAME LIKE '%Khao Chamao%' OR a.ENGNAME LIKE '%Kerry%' OR a.ENGNAME LIKE '%Chaloem Prakiat%')");
        } else {
            $thainame = select_vehiclenumberautocomplate('megVehicleinfo_v2', 'select_vehicleinfo', '');
        }
        $jobrccend = select_jobautocomplateendgetway('megVehicletransportpricerrcgmt_v2', 'select_endways', '');
        $jobendrks_denso = select_jobautocomplateendrks_denso('megVehicletransportpricerksdenso_v2', 'select_routetype', '');
        $emp = select_empautocomplate('megEmployeeEHR_v2', 'select_employee', " ");
        $cluster = select_clusterautocomplate('megVehicletransportprice_v2', 'select_cluster', '');
        ?>


        <script type="text/javascript">
                                                                            function show_monday()
                                                                            {
                                                                                $.ajax({
                                                                                    type: 'post',
                                                                                    url: 'meg_data.php',
                                                                                    data: {
                                                                                        txt_flg: "show_monday", companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', vehicletransportplanid: '<?= $_GET['vehicletransportplanid'] ?>', STARTWEEK: '<?= $result_seSystime['STARTWEEK'] ?>', ENDWEEK: '<?= $result_seSystime['ENDWEEK'] ?>', condish: "<?= $condish ?>"
                                                                                    },
                                                                                    success: function (rs) {

                                                                                        document.getElementById("show_monday").innerHTML = rs;
                                                                                        document.getElementById("show_mondaydef").innerHTML = "";
                                                                                        document.getElementById("show_tuesday").innerHTML = "";
                                                                                        document.getElementById("show_wednesday").innerHTML = "";
                                                                                        document.getElementById("show_thursday").innerHTML = "";
                                                                                        document.getElementById("show_friday").innerHTML = "";
                                                                                        document.getElementById("show_saturday").innerHTML = "";
                                                                                        document.getElementById("show_sunday").innerHTML = "";

                                                                                        $('#dataTables-example11').DataTable({

                                                                                            order: [[0, "desc"]],
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });


                                                                                    }
                                                                                });


                                                                            }
                                                                            function show_tuesday()
                                                                            {

                                                                                $.ajax({
                                                                                    type: 'post',
                                                                                    url: 'meg_data.php',
                                                                                    data: {
                                                                                        txt_flg: "show_tuesday", companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', vehicletransportplanid: '<?= $_GET['vehicletransportplanid'] ?>', STARTWEEK: '<?= $result_seSystime['STARTWEEK'] ?>', ENDWEEK: '<?= $result_seSystime['ENDWEEK'] ?>', condish: "<?= $condish ?>"
                                                                                    },
                                                                                    success: function (rs) {

                                                                                        document.getElementById("show_monday").innerHTML = "";
                                                                                        document.getElementById("show_mondaydef").innerHTML = "";
                                                                                        document.getElementById("show_tuesday").innerHTML = rs;
                                                                                        document.getElementById("show_wednesday").innerHTML = "";
                                                                                        document.getElementById("show_thursday").innerHTML = "";
                                                                                        document.getElementById("show_friday").innerHTML = "";
                                                                                        document.getElementById("show_saturday").innerHTML = "";
                                                                                        document.getElementById("show_sunday").innerHTML = "";
                                                                                        $('#dataTables-example22').DataTable({

                                                                                            order: [[0, "desc"]],
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });





                                                                                    }
                                                                                });
                                                                            }
                                                                            function show_wednesday()
                                                                            {
                                                                                $.ajax({
                                                                                    type: 'post',
                                                                                    url: 'meg_data.php',
                                                                                    data: {
                                                                                        txt_flg: "show_wednesday", companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', vehicletransportplanid: '<?= $_GET['vehicletransportplanid'] ?>', STARTWEEK: '<?= $result_seSystime['STARTWEEK'] ?>', ENDWEEK: '<?= $result_seSystime['ENDWEEK'] ?>', condish: "<?= $condish ?>"
                                                                                    },
                                                                                    success: function (rs) {

                                                                                        document.getElementById("show_monday").innerHTML = "";
                                                                                        document.getElementById("show_mondaydef").innerHTML = "";
                                                                                        document.getElementById("show_tuesday").innerHTML = "";
                                                                                        document.getElementById("show_wednesday").innerHTML = rs;
                                                                                        document.getElementById("show_thursday").innerHTML = "";
                                                                                        document.getElementById("show_friday").innerHTML = "";
                                                                                        document.getElementById("show_saturday").innerHTML = "";
                                                                                        document.getElementById("show_sunday").innerHTML = "";
                                                                                        $('#dataTables-example33').DataTable({

                                                                                            order: [[0, "desc"]],
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });




                                                                                    }
                                                                                });
                                                                            }
                                                                            function show_thursday()
                                                                            {
                                                                                $.ajax({
                                                                                    type: 'post',
                                                                                    url: 'meg_data.php',
                                                                                    data: {
                                                                                        txt_flg: "show_thursday", companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', vehicletransportplanid: '<?= $_GET['vehicletransportplanid'] ?>', STARTWEEK: '<?= $result_seSystime['STARTWEEK'] ?>', ENDWEEK: '<?= $result_seSystime['ENDWEEK'] ?>', condish: "<?= $condish ?>"
                                                                                    },
                                                                                    success: function (rs) {

                                                                                        document.getElementById("show_monday").innerHTML = "";
                                                                                        document.getElementById("show_mondaydef").innerHTML = "";
                                                                                        document.getElementById("show_tuesday").innerHTML = "";
                                                                                        document.getElementById("show_wednesday").innerHTML = "";
                                                                                        document.getElementById("show_thursday").innerHTML = rs;
                                                                                        document.getElementById("show_friday").innerHTML = "";
                                                                                        document.getElementById("show_saturday").innerHTML = "";
                                                                                        document.getElementById("show_sunday").innerHTML = "";
                                                                                        $('#dataTables-example44').DataTable({

                                                                                            order: [[0, "desc"]],
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });



                                                                                    }
                                                                                });
                                                                            }
                                                                            function show_friday()
                                                                            {
                                                                                $.ajax({
                                                                                    type: 'post',
                                                                                    url: 'meg_data.php',
                                                                                    data: {
                                                                                        txt_flg: "show_friday", companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', vehicletransportplanid: '<?= $_GET['vehicletransportplanid'] ?>', STARTWEEK: '<?= $result_seSystime['STARTWEEK'] ?>', ENDWEEK: '<?= $result_seSystime['ENDWEEK'] ?>', condish: "<?= $condish ?>"
                                                                                    },
                                                                                    success: function (rs) {

                                                                                        document.getElementById("show_monday").innerHTML = "";
                                                                                        document.getElementById("show_mondaydef").innerHTML = "";
                                                                                        document.getElementById("show_tuesday").innerHTML = "";
                                                                                        document.getElementById("show_wednesday").innerHTML = "";
                                                                                        document.getElementById("show_thursday").innerHTML = "";
                                                                                        document.getElementById("show_friday").innerHTML = rs;
                                                                                        document.getElementById("show_saturday").innerHTML = "";
                                                                                        document.getElementById("show_sunday").innerHTML = "";
                                                                                        $('#dataTables-example55').DataTable({

                                                                                            order: [[0, "desc"]],
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });



                                                                                    }
                                                                                });
                                                                            }
                                                                            function show_saturday()
                                                                            {
                                                                                $.ajax({
                                                                                    type: 'post',
                                                                                    url: 'meg_data.php',
                                                                                    data: {
                                                                                        txt_flg: "show_saturday", companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', vehicletransportplanid: '<?= $_GET['vehicletransportplanid'] ?>', STARTWEEK: '<?= $result_seSystime['STARTWEEK'] ?>', ENDWEEK: '<?= $result_seSystime['ENDWEEK'] ?>', condish: "<?= $condish ?>"
                                                                                    },
                                                                                    success: function (rs) {

                                                                                        document.getElementById("show_monday").innerHTML = "";
                                                                                        document.getElementById("show_mondaydef").innerHTML = "";
                                                                                        document.getElementById("show_tuesday").innerHTML = "";
                                                                                        document.getElementById("show_wednesday").innerHTML = "";
                                                                                        document.getElementById("show_thursday").innerHTML = "";
                                                                                        document.getElementById("show_friday").innerHTML = "";
                                                                                        document.getElementById("show_saturday").innerHTML = rs;
                                                                                        document.getElementById("show_sunday").innerHTML = "";
                                                                                        $('#dataTables-example66').DataTable({

                                                                                            order: [[0, "desc"]],
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });

                                                                                    }
                                                                                });
                                                                            }
                                                                            function show_sunday()
                                                                            {
                                                                                $.ajax({
                                                                                    type: 'post',
                                                                                    url: 'meg_data.php',
                                                                                    data: {
                                                                                        txt_flg: "show_sunday", companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', vehicletransportplanid: '<?= $_GET['vehicletransportplanid'] ?>', STARTWEEK: '<?= $result_seSystime['STARTWEEK'] ?>', ENDWEEK: '<?= $result_seSystime['ENDWEEK'] ?>', condish: "<?= $condish ?>"
                                                                                    },
                                                                                    success: function (rs) {

                                                                                        document.getElementById("show_monday").innerHTML = "";
                                                                                        document.getElementById("show_mondaydef").innerHTML = "";
                                                                                        document.getElementById("show_tuesday").innerHTML = "";
                                                                                        document.getElementById("show_wednesday").innerHTML = "";
                                                                                        document.getElementById("show_thursday").innerHTML = "";
                                                                                        document.getElementById("show_friday").innerHTML = "";
                                                                                        document.getElementById("show_saturday").innerHTML = "";
                                                                                        document.getElementById("show_sunday").innerHTML = rs;
                                                                                        $('#dataTables-example77').DataTable({

                                                                                            order: [[0, "desc"]],
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    }
                                                                                });
                                                                            }



                                                                            $('.modal-child').on('show.bs.modal', function () {
                                                                                var modalParent = $(this).attr('data-modal-parent');
                                                                                $(modalParent).css('opacity', 0);
                                                                            });

                                                                            $('.modal-child').on('hidden.bs.modal', function () {
                                                                                var modalParent = $(this).attr('data-modal-parent');
                                                                                $(modalParent).css('opacity', 1);
                                                                            });

                                                                            function select_employee(emp, data)
                                                                            {
                                                                                if (emp == '1')
                                                                                {
                                                                                    document.getElementById('txt_copydiagramemployeename1').value = data;
                                                                                } else if (emp == '2')
                                                                                {
                                                                                    document.getElementById('txt_copydiagramemployeename2').value = data;
                                                                                } else if (emp == '3')
                                                                                {
                                                                                    if ('<?= $_GET['companycode'] ?>' == 'RCC' || '<?= $_GET['companycode'] ?>' == 'RATC')
                                                                                    {
                                                                                        document.getElementById('txt_copydiagramemployeename3').value = data;
                                                                                    }
                                                                                }
                                                                            }

                                                                            function select_checkdriversr(emp)
                                                                            {
                                                                                var jobstart = "";
                                                                                var jobend = "";
                                                                                if ('<?= $_GET['companycode'] ?>' == 'RRC')
                                                                                {
                                                                                    jobstart = document.getElementById('cb_copydiagramjobstart').value;
                                                                                    jobend = document.getElementById('cb_copydiagramjobend').value;
                                                                                } else if ('<?= $_GET['companycode'] ?>' == 'RCC' || '<?= $_GET['companycode'] ?>' == 'RATC')
                                                                                {
                                                                                    if ('<?= $_GET['pricetype'] ?>' == '1')
                                                                                    {
                                                                                        jobstart = document.getElementById('txt_copydiagramjobstart').value;
                                                                                        jobend = document.getElementById('txt_copydiagramjobend').value;


                                                                                    } else if ('<?= $_GET['pricetype'] ?>' == '2')
                                                                                    {
                                                                                        jobstart = document.getElementById('cb_copydiagramjobstart').value;
                                                                                        jobend = document.getElementById('txt_copydiagramroute').value;
                                                                                    }
                                                                                }
                                                                                $.ajax({
                                                                                    type: 'post',
                                                                                    url: 'meg_data.php',
                                                                                    data: {
                                                                                        txt_flg: "select_checkdriversr", jobstart: jobstart, jobend: jobend, emp: emp
                                                                                    },
                                                                                    success: function (rs) {

                                                                                        document.getElementById("modal_checkdriversr").innerHTML = rs;
                                                                                        $('#dataTables-checkdriver').DataTable({
                                                                                            responsive: true,
                                                                                            order: [[0, "desc"]]
                                                                                        });
                                                                                    }
                                                                                });
                                                                            }


                                                                            function experience()
                                                                            {
                                                                                if ('<?= $_GET['companycode'] ?>' == 'RRC')
                                                                                {

                                                                                    var employeename1 = document.getElementById('txt_copydiagramemployeename1').value;
                                                                                    var employeename2 = document.getElementById('txt_copydiagramemployeename2').value;
                                                                                    var jobstart = document.getElementById('cb_copydiagramjobstart').value;
                                                                                    var jobend = document.getElementById('cb_copydiagramjobend').value;

                                                                                    $.ajax({
                                                                                        type: 'post',
                                                                                        url: 'meg_data.php',
                                                                                        data: {
                                                                                            txt_flg: "rs_experience", employeename: employeename1, jobstart: jobstart, jobend: jobend
                                                                                        },
                                                                                        success: function (rs) {

                                                                                            document.getElementById("div_jobendemp1").innerHTML = rs;

                                                                                        }
                                                                                    });
                                                                                    $.ajax({
                                                                                        type: 'post',
                                                                                        url: 'meg_data.php',
                                                                                        data: {
                                                                                            txt_flg: "rs_experience", employeename: employeename2, jobstart: jobstart, jobend: jobend
                                                                                        },
                                                                                        success: function (rs) {

                                                                                            document.getElementById("div_jobendemp2").innerHTML = rs;

                                                                                        }
                                                                                    });


                                                                                } else if ('<?= $_GET['companycode'] ?>' == 'RCC' || '<?= $_GET['companycode'] ?>' == 'RATC')
                                                                                {
                                                                                    if ('<?= $_GET['pricetype'] ?>' == '1') {

                                                                                        var employeename1 = document.getElementById('txt_copydiagramemployeename1').value;
                                                                                        var employeename2 = document.getElementById('txt_copydiagramemployeename2').value;
                                                                                        var jobstart = document.getElementById('txt_copydiagramjobstart').value;
                                                                                        var jobend = document.getElementById('txt_copydiagramjobend').value;


                                                                                        $.ajax({
                                                                                            type: 'post',
                                                                                            url: 'meg_data.php',
                                                                                            data: {
                                                                                                txt_flg: "rs_experience", employeename: employeename1, jobstart: jobstart, jobend: jobend
                                                                                            },
                                                                                            success: function (rs) {

                                                                                                document.getElementById("div_jobendemp1").innerHTML = rs;

                                                                                            }
                                                                                        });
                                                                                        $.ajax({
                                                                                            type: 'post',
                                                                                            url: 'meg_data.php',
                                                                                            data: {
                                                                                                txt_flg: "rs_experience", employeename: employeename2, jobstart: jobstart, jobend: jobend
                                                                                            },
                                                                                            success: function (rs) {

                                                                                                document.getElementById("div_jobendemp2").innerHTML = rs;

                                                                                            }
                                                                                        });
                                                                                    } else if ('<?= $_GET['pricetype'] ?>' == '2') {

                                                                                        var employeename1 = document.getElementById('txt_copydiagramemployeename1').value;
                                                                                        var employeename2 = document.getElementById('txt_copydiagramemployeename2').value;
                                                                                        var jobstart = document.getElementById('txt_copydiagramjobstart').value;
                                                                                        var jobend = document.getElementById('txt_copydiagramroute').value;


                                                                                        $.ajax({
                                                                                            type: 'post',
                                                                                            url: 'meg_data.php',
                                                                                            data: {
                                                                                                txt_flg: "rs_experience", employeename: employeename1, jobstart: jobstart, jobend: jobend
                                                                                            },
                                                                                            success: function (rs) {

                                                                                                document.getElementById("div_jobendemp1").innerHTML = rs;

                                                                                            }
                                                                                        });
                                                                                        $.ajax({
                                                                                            type: 'post',
                                                                                            url: 'meg_data.php',
                                                                                            data: {
                                                                                                txt_flg: "rs_experience", employeename: employeename2, jobstart: jobstart, jobend: jobend
                                                                                            },
                                                                                            success: function (rs) {

                                                                                                document.getElementById("div_jobendemp2").innerHTML = rs;

                                                                                            }
                                                                                        });
                                                                                    }

                                                                                }
                                                                            }
                                                                            function update_modalrks(vehicletransportplanid)
                                                                            {
                                                                                $.ajax({
                                                                                    type: 'post',
                                                                                    url: 'meg_data.php',
                                                                                    data: {
                                                                                        txt_flg: "modal_updatediagramrks", vehicletransportplanid: vehicletransportplanid, customercode: '<?= $_GET['customercode'] ?>'
                                                                                    },
                                                                                    success: function (rs) {

                                                                                        document.getElementById("modalbodyupdatediagramrkssr").innerHTML = rs;
                                                                                        $(function () {

                                                                                            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                                            // กรณีใช้แบบ input
                                                                                            $(".datedef").datetimepicker({
                                                                                                timepicker: false,
                                                                                                format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000			
                                                                                                lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.

                                                                                            });
                                                                                        });

                                                                                        $(function () {
                                                                                            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                                            // กรณีใช้แบบ input
                                                                                            $(".datetimeen").datetimepicker({
                                                                                                timepicker: true,
                                                                                                dateformat: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00 - 00 - 0000
                                                                                                lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                                                timeFormat: "HH:mm"

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

                                                                                        var txt_copydiagramthainameupdrks = [<?= $thainame ?>];
                                                                                        $("#txt_copydiagramthainameupdrks").autocomplete({
                                                                                            source: [txt_copydiagramthainameupdrks]
                                                                                        });
                                                                                        var txt_copydiagramemployeenameupdrks1 = [<?= $emp ?>];
                                                                                        $("#txt_copydiagramemployeenameupdrks1").autocomplete({
                                                                                            source: [txt_copydiagramemployeenameupdrks1]
                                                                                        });
                                                                                        var txt_copydiagramemployeenameupdrks2 = [<?= $emp ?>];
                                                                                        $("#txt_copydiagramemployeenameupdrks2").autocomplete({
                                                                                            source: [txt_copydiagramemployeenameupdrks2]
                                                                                        });
                                                                                    }



                                                                                });

                                                                            }
                                                                            function update_modalrcc(vehicletransportplanid)
                                                                            {
                                                                                $.ajax({
                                                                                    type: 'post',
                                                                                    url: 'meg_data.php',
                                                                                    data: {
                                                                                        txt_flg: "modal_updatediagramrcc", vehicletransportplanid: vehicletransportplanid
                                                                                    },
                                                                                    success: function (rs) {

                                                                                        document.getElementById("modalbodyupdatediagramrccsr").innerHTML = rs;

                                                                                        var txt_copydiagramemployeenameupdrcc1 = [<?= $emp ?>];
                                                                                        $("#txt_copydiagramemployeenameupdrcc1").autocomplete({
                                                                                            source: [txt_copydiagramemployeenameupdrcc1]
                                                                                        });

                                                                                        var txt_copydiagramemployeenameupdrcc2 = [<?= $emp ?>];
                                                                                        $("#txt_copydiagramemployeenameupdrcc2").autocomplete({
                                                                                            source: [txt_copydiagramemployeenameupdrcc2]
                                                                                        });

                                                                                        var txt_copydiagramthainameupdrcc = [<?= $thainame ?>];
                                                                                        $("#txt_copydiagramthainameupdrcc").autocomplete({
                                                                                            source: [txt_copydiagramthainameupdrcc]
                                                                                        });


                                                                                        $(function () {

                                                                                            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                                            // กรณีใช้แบบ input
                                                                                            $(".datedef").datetimepicker({
                                                                                                timepicker: false,
                                                                                                format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000			
                                                                                                lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.

                                                                                            });
                                                                                        });

                                                                                        $(function () {
                                                                                            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                                            // กรณีใช้แบบ input
                                                                                            $(".datetimeen").datetimepicker({
                                                                                                timepicker: true,
                                                                                                dateformat: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00 - 00 - 0000
                                                                                                lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                                                timeFormat: "HH:mm"

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








                                                                                    }
                                                                                });

                                                                            }
                                                                            function update_modalrrc(vehicletransportplanid)
                                                                            {
                                                                                $.ajax({
                                                                                    type: 'post',
                                                                                    url: 'meg_data.php',
                                                                                    data: {
                                                                                        txt_flg: "modal_updatediagramrrc", vehicletransportplanid: vehicletransportplanid
                                                                                    },
                                                                                    success: function (rs) {

                                                                                        document.getElementById("modalbodyupdatediagramrrcsr").innerHTML = rs;

                                                                                        var txt_copydiagramemployeenameupdrrc1 = [<?= $emp ?>];
                                                                                        $("#txt_copydiagramemployeenameupdrrc1").autocomplete({
                                                                                            source: [txt_copydiagramemployeenameupdrrc1]
                                                                                        });

                                                                                        var txt_copydiagramemployeenameupdrrc2 = [<?= $emp ?>];
                                                                                        $("#txt_copydiagramemployeenameupdrrc2").autocomplete({
                                                                                            source: [txt_copydiagramemployeenameupdrrc2]
                                                                                        });

                                                                                        var txt_copydiagramthainameupdrrc = [<?= $thainame ?>];
                                                                                        $("#txt_copydiagramthainameupdrrc").autocomplete({
                                                                                            source: [txt_copydiagramthainameupdrrc]
                                                                                        });


                                                                                        $(function () {

                                                                                            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                                            // กรณีใช้แบบ input
                                                                                            $(".datedef").datetimepicker({
                                                                                                timepicker: false,
                                                                                                format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000			
                                                                                                lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.

                                                                                            });
                                                                                        });

                                                                                        $(function () {
                                                                                            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                                            // กรณีใช้แบบ input
                                                                                            $(".datetimeen").datetimepicker({
                                                                                                timepicker: true,
                                                                                                dateformat: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00 - 00 - 0000
                                                                                                lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                                                timeFormat: "HH:mm"

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




                                                                                    }
                                                                                });

                                                                            }


                                                                            function se_copydiagramroute(copydiagramjobstart)
                                                                            {
                                                                                $.ajax({
                                                                                    type: 'post',
                                                                                    url: 'meg_data.php',
                                                                                    data: {
                                                                                        txt_flg: "show_copydiagramjobstart", copydiagramjobstart: copydiagramjobstart
                                                                                    },
                                                                                    success: function (rs) {

                                                                                        document.getElementById("copydiagramroutesr").innerHTML = rs;
                                                                                        document.getElementById("copydiagramroutedef").innerHTML = "";

                                                                                        $("#cb_copydiagramroute").html(rs).selectpicker('refresh');
                                                                                        $('.selectpicker').on('changed.bs.select', function () {
                                                                                            document.getElementById('txt_copydiagramroute').value = $(this).val();

                                                                                        });


                                                                                    }
                                                                                });
                                                                            }

                                                                            function se_copydiagramsubroute(copydiagramroute)
                                                                            {


                                                                                $.ajax({
                                                                                    type: 'post',
                                                                                    url: 'meg_data.php',
                                                                                    data: {
                                                                                        txt_flg: "show_copydiagramsubroute", copydiagramroute: copydiagramroute
                                                                                    },
                                                                                    success: function (rs) {

                                                                                        document.getElementById("copydiagramsubroutesr").innerHTML = rs;
                                                                                        document.getElementById("copydiagramsubroutedef").innerHTML = "";

                                                                                        $("#cb_copydiagramsubroute").html(rs).selectpicker('refresh');
                                                                                        $('.selectpicker').on('changed.bs.select', function () {
                                                                                            document.getElementById('txt_copydiagramsubroute').value = $(this).val();

                                                                                        });


                                                                                    }
                                                                                });
                                                                            }
                                                                            function save_mileage(editableObj, mileagetype, vehicleregisternumber1, jobno)
                                                                            {

                                                                                $.ajax({
                                                                                    url: 'meg_data.php',
                                                                                    type: 'POST',
                                                                                    data: {
                                                                                        txt_flg: "save_mileage", mileageid: '', vehicleregisternumber1: vehicleregisternumber1, jobno: jobno, editableObj: editableObj.innerHTML, mileagetype: mileagetype
                                                                                    },
                                                                                    success: function () {

                                                                                    }
                                                                                });
                                                                            }
        </script>
        <script type="text/javascript">



            $.ajax({
                type: 'post',
                url: 'meg_data.php',
                data: {
                    txt_flg: "select_adddateweek", datestart: document.getElementById("txt_datestartsr").value
                },
                success: function (rs) {

                    var res = rs.split("|");
                    document.getElementById("txt_dateendsr").value = res[0];



                    document.getElementById("lbl_m").innerHTML = '(' + res[1] + ')';
                    document.getElementById("lbl_tu").innerHTML = '(' + res[2] + ')';
                    document.getElementById("lbl_w").innerHTML = '(' + res[3] + ')';
                    document.getElementById("lbl_th").innerHTML = '(' + res[4] + ')';
                    document.getElementById("lbl_f").innerHTML = '(' + res[5] + ')';
                    document.getElementById("lbl_sat").innerHTML = '(' + res[6] + ')';
                    document.getElementById("lbl_sun").innerHTML = '(' + res[7] + ')';






                }
            });


            /*
             
             var txt_jobstartm1 = [<?//= $jobsm1 ?>];
             for (n = 1; n < <?//= $i1 ?>; n++) {
             $("#txt_jobstartm1" + n).autocomplete({
             source: [txt_jobstartm1]
             });
             }
             var txt_jobstartm2 = [<?//= $jobsm2 ?>];
             for (n = 1; n < <?//= $i1 ?>; n++) {
             $("#txt_jobstartm2" + n).autocomplete({
             source: [txt_jobstartm2]
             });
             }
             var txt_jobstartm3 = [<?//= $jobsm3 ?>];
             for (n = 1; n < <?//= $i1 ?>; n++) {
             $("#txt_jobstartm3" + n).autocomplete({
             source: [txt_jobstartm3]
             });
             }
             var txt_jobstartm4 = [<?//= $jobsm4 ?>];
             for (n = 1; n < <?//= $i1 ?>; n++) {
             $("#txt_jobstartm4" + n).autocomplete({
             source: [txt_jobstartm4]
             });
             }
             
             var txt_jobstarttu1 = [<?//= $jobstu1 ?>];
             for (n = 1; n < <?//= $i2 ?>; n++) {
             $("#txt_jobstarttu1" + n).autocomplete({
             source: [txt_jobstarttu1]
             });
             }
             var txt_jobstarttu2 = [<?//= $jobstu2 ?>];
             for (n = 1; n < <?//= $i2 ?>; n++) {
             $("#txt_jobstarttu2" + n).autocomplete({
             source: [txt_jobstarttu2]
             });
             }
             
             var txt_jobstartw1 = [<?//= $jobsw1 ?>];
             for (n = 1; n < <?//= $i3 ?>; n++) {
             $("#txt_jobstartw1" + n).autocomplete({
             source: [txt_jobstartw1]
             });
             }
             var txt_jobstartw2 = [<?//= $jobsw2 ?>];
             for (n = 1; n < <?//= $i3 ?>; n++) {
             $("#txt_jobstartw2" + n).autocomplete({
             source: [txt_jobstartw2]
             });
             }
             
             var txt_jobstartth1 = [<?//= $jobsth1 ?>];
             for (n = 1; n < <?//= $i4 ?>; n++) {
             $("#txt_jobstartth1" + n).autocomplete({
             source: [txt_jobstartth1]
             });
             }
             var txt_jobstartth2 = [<?//= $jobsth2 ?>];
             for (n = 1; n < <?//= $i4 ?>; n++) {
             $("#txt_jobstartth2" + n).autocomplete({
             source: [txt_jobstartth2]
             });
             }
             
             var txt_jobstartf1 = [<?//= $jobsf1 ?>];
             for (n = 1; n < <?//= $i5 ?>; n++) {
             $("#txt_jobstartf1" + n).autocomplete({
             source: [txt_jobstartf1]
             });
             }
             var txt_jobstartf2 = [<?//= $jobsf2 ?>];
             for (n = 1; n < <?//= $i5 ?>; n++) {
             $("#txt_jobstartf2" + n).autocomplete({
             source: [txt_jobstartf2]
             });
             }
             
             var txt_jobstartsat1 = [<?//= $jobssat1 ?>];
             for (n = 1; n < <?//= $i6 ?>; n++) {
             $("#txt_jobstartsat1" + n).autocomplete({
             source: [txt_jobstartsat1]
             });
             }
             var txt_jobstartsat2 = [<?//= $jobssat2 ?>];
             for (n = 1; n < <?//= $i6 ?>; n++) {
             $("#txt_jobstartsat2" + n).autocomplete({
             source: [txt_jobstartsat2]
             });
             }
             
             var txt_jobstartsun1 = [<?//= $jobssun1 ?>];
             for (n = 1; n < <?//= $i7 ?>; n++) {
             $("#txt_jobstartsun1" + n).autocomplete({
             source: [txt_jobstartsun1]
             });
             }
             var txt_jobstartsun2 = [<?//= $jobssun2 ?>];
             for (n = 1; n < <?//= $i7 ?>; n++) {
             $("#txt_jobstartsun2" + n).autocomplete({
             source: [txt_jobstartsun2]
             });
             }
             
             var txt_clusterm = [<?//= $cluster ?>];
             for (n = 1; n < <?//= $i1 ?>; n++) {
             $("#txt_clusterm" + n).autocomplete({
             source: [txt_clusterm]
             });
             }
             
             var txt_clustertu = [<?//= $cluster ?>];
             for (n = 1; n < <?//= $i2 ?>; n++) {
             $("#txt_clustertu" + n).autocomplete({
             source: [txt_clustertu]
             });
             }
             
             var txt_clusterw = [<?//= $cluster ?>];
             for (n = 1; n < <?//= $i3 ?>; n++) {
             $("#txt_clusterw" + n).autocomplete({
             source: [txt_clusterw]
             });
             }
             
             var txt_clusterth = [<?//= $cluster ?>];
             for (n = 1; n < <?//= $i4 ?>; n++) {
             $("#txt_clusterth" + n).autocomplete({
             source: [txt_clusterth]
             });
             }
             
             var txt_clusterf = [<?//= $cluster ?>];
             for (n = 1; n < <?//= $i5 ?>; n++) {
             $("#txt_clusterf" + n).autocomplete({
             source: [txt_clusterf]
             });
             }
             
             var txt_clustersat = [<?//= $cluster ?>];
             for (n = 1; n < <?//= $i6 ?>; n++) {
             $("#txt_clustersat" + n).autocomplete({
             source: [txt_clustersat]
             });
             }
             
             var txt_clustersun = [<?//= $cluster ?>];
             for (n = 1; n < <?//= $i7 ?>; n++) {
             $("#txt_clustersun" + n).autocomplete({
             source: [txt_clustersun]
             });
             }
             
             
             
             var txt_jobendm = [<?//= $jobrccend ?>];
             for (n = 1; n < <?//= $i1 ?>; n++) {
             $("#txt_jobendm" + n).autocomplete({
             source: [txt_jobendm]
             });
             }
             var txt_jobendm1 = [<?//= $jobendrks_denso ?>];
             for (n = 1; n < <?//= $i1 ?>; n++) {
             $("#txt_jobendm1" + n).autocomplete({
             source: [txt_jobendm1]
             });
             }
             var txt_jobendtu = [<?//= $jobrccend ?>];
             for (n = 1; n < <?//= $i2 ?>; n++) {
             $("#txt_jobendtu" + n).autocomplete({
             source: [txt_jobendtu]
             });
             }
             
             var txt_jobendw = [<?//= $jobrccend ?>];
             for (n = 1; n < <?//= $i3 ?>; n++) {
             $("#txt_jobendw" + n).autocomplete({
             source: [txt_jobendw]
             });
             }
             
             var txt_jobendth = [<?//= $jobrccend ?>];
             for (n = 1; n < <?//= $i4 ?>; n++) {
             $("#txt_jobendth" + n).autocomplete({
             source: [txt_jobendth]
             });
             }
             
             var txt_jobendf = [<?//= $jobrccend ?>];
             for (n = 1; n < <?//= $i5 ?>; n++) {
             
             $("#txt_jobendf" + n).autocomplete({
             source: [txt_jobendf]
             });
             }
             
             var txt_jobendsat = [<?//= $jobrccend ?>];
             for (n = 1; n < <?//= $i6 ?>; n++) {
             $("#txt_jobendsat" + n).autocomplete({
             source: [txt_jobendsat]
             });
             }
             
             var txt_jobendsun = [<?//= $jobrccend ?>];
             for (n = 1; n < <?//= $i7 ?>; n++) {
             $("#txt_jobendsun" + n).autocomplete({
             source: [txt_jobendsun]
             });
             }
             
             var txt_employeem1 = [<?//= $emp ?>];
             for (n = 1; n < <?//= $i1 ?>; n++) {
             $("#txt_employeem1" + n).autocomplete({
             source: [txt_employeem1]
             });
             }
             
             var txt_employeetu1 = [<?//= $emp ?>];
             for (n = 1; n < <?//= $i2 ?>; n++) {
             $("#txt_employeetu1" + n).autocomplete({
             source: [txt_employeetu1]
             });
             }
             
             var txt_employeew1 = [<?//= $emp ?>];
             for (n = 1; n < <?//= $i3 ?>; n++) {
             $("#txt_employeew1" + n).autocomplete({
             source: [txt_employeew1]
             });
             }
             
             var txt_employeeth1 = [<?//= $emp ?>];
             for (n = 1; n < <?//= $i4 ?>; n++) {
             $("#txt_employeeth1" + n).autocomplete({
             source: [txt_employeeth1]
             });
             }
             
             var txt_employeef1 = [<?//= $emp ?>];
             for (n = 1; n < <?//= $i5 ?>; n++) {
             $("#txt_employeef1" + n).autocomplete({
             source: [txt_employeef1]
             });
             }
             
             var txt_employeesat1 = [<?//= $emp ?>];
             for (n = 1; n < <?//= $i6 ?>; n++) {
             $("#txt_employeesat1" + n).autocomplete({
             source: [txt_employeesat1]
             });
             }
             
             var txt_employeesun1 = [<?//= $emp ?>];
             for (n = 1; n < <?//= $i7 ?>; n++) {
             $("#txt_employeesun1" + n).autocomplete({
             source: [txt_employeesun1]
             });
             }
             
             var txt_employeem2 = [<?//= $emp ?>];
             for (n = 1; n < <?//= $i1 ?>; n++) {
             $("#txt_employeem2" + n).autocomplete({
             source: [txt_employeem2]
             });
             }
             
             var txt_employeetu2 = [<?//= $emp ?>];
             for (n = 1; n < <?//= $i2 ?>; n++) {
             $("#txt_employeetu2" + n).autocomplete({
             source: [txt_employeetu2]
             });
             }
             
             var txt_employeew2 = [<?//= $emp ?>];
             for (n = 1; n < <?//= $i3 ?>; n++) {
             $("#txt_employeew2" + n).autocomplete({
             source: [txt_employeew2]
             });
             }
             
             var txt_employeeth2 = [<?//= $emp ?>];
             for (n = 1; n < <?//= $i4 ?>; n++) {
             $("#txt_employeeth2" + n).autocomplete({
             source: [txt_employeeth2]
             });
             }
             
             var txt_employeef2 = [<?//= $emp ?>];
             for (n = 1; n < <?//= $i5 ?>; n++) {
             $("#txt_employeef2" + n).autocomplete({
             source: [txt_employeef2]
             });
             }
             
             var txt_employeesat2 = [<?//= $emp ?>];
             for (n = 1; n < <?//= $i6 ?>; n++) {
             $("#txt_employeesat2" + n).autocomplete({
             source: [txt_employeesat2]
             });
             }
             
             var txt_employeesun2 = [<?//= $emp ?>];
             for (n = 1; n < <?//= $i7 ?>; n++) {
             $("#txt_employeesun2" + n).autocomplete({
             source: [txt_employeesun2]
             });
             }
             
             var txt_carm = [<?//= $thainame ?>];
             for (n = 1; n < <?//= $i1 ?>; n++) {
             $("#txt_carm" + n).autocomplete({
             source: [txt_carm]
             });
             }
             
             var txt_cartu = [<?//= $thainame ?>];
             for (n = 1; n < <?//= $i2 ?>; n++) {
             $("#txt_cartu" + n).autocomplete({
             source: [txt_cartu]
             });
             }
             
             var txt_carw = [<?//= $thainame ?>];
             for (n = 1; n < <?//= $i3 ?>; n++) {
             $("#txt_carw" + n).autocomplete({
             source: [txt_carw]
             });
             }
             
             var txt_carth = [<?//= $thainame ?>];
             for (n = 1; n < <?//= $i4 ?>; n++) {
             
             $("#txt_carth" + n).autocomplete({
             source: [txt_carth]
             });
             }
             
             var txt_carf = [<?//= $thainame ?>];
             for (n = 1; n < <?//= $i5 ?>; n++) {
             $("#txt_carf" + n).autocomplete({
             source: [txt_carf]
             });
             }
             
             var txt_carsat = [<?//= $thainame ?>];
             for (n = 1; n < <?//= $i6 ?>; n++) {
             $("#txt_carsat" + n).autocomplete({
             source: [txt_carsat]
             });
             }
             
             var txt_carsun = [<?//= $thainame ?>];
             for (n = 1; n < <?//= $i7 ?>; n++) {
             $("#txt_carsun" + n).autocomplete({
             source: [txt_carsun]
             });
             }
             */

            var txt_copydiagramemployeename1 = [<?= $emp ?>];
            $("#txt_copydiagramemployeename1").autocomplete({
                source: [txt_copydiagramemployeename1]
            });

            var txt_copydiagramemployeenameupd1 = [<?= $emp ?>];
            $("#txt_copydiagramemployeenameupd1").autocomplete({
                source: [txt_copydiagramemployeenameupd1]
            });


            var txt_copydiagramemployeename2 = [<?= $emp ?>];
            $("#txt_copydiagramemployeename2").autocomplete({
                source: [txt_copydiagramemployeename2]
            });
            if ('<?= $_GET['companycode'] ?>' == 'RCC' || '<?= $_GET['companycode'] ?>' == 'RATC')
            {
                var txt_copydiagramemployeename3 = [<?= $emp ?>];
                $("#txt_copydiagramemployeename3").autocomplete({
                    source: [txt_copydiagramemployeename3]
                });
            }

            var txt_copydiagramemployeenameupd2 = [<?= $emp ?>];
            $("#txt_copydiagramemployeenameupd2").autocomplete({
                source: [txt_copydiagramemployeenameupd2]
            });

            var txt_copydiagramthainame = [<?= $thainame ?>];
            $("#txt_copydiagramthainame").autocomplete({
                source: [txt_copydiagramthainame]
            });
            var txt_copydiagramthainameupd = [<?= $thainame ?>];
            $("#txt_copydiagramthainameupd").autocomplete({
                source: [txt_copydiagramthainameupd]
            });


            var txt_copydiagramjobstart = [<?= $job ?>];
            $("#txt_copydiagramjobstart").autocomplete({
                source: [txt_copydiagramjobstart]
            });

            var txt_copydiagramjobend = [<?= $jobrccend ?>];
            $("#txt_copydiagramjobend").autocomplete({
                source: [txt_copydiagramjobend]
            });





            /*var copydiagramcluster = [<?//= $cluster ?>];
             $("#txt_copydiagramcluster").autocomplete({
             source: [copydiagramcluster]
             });
             */
            /*var cb_copydiagramjobend = [<?//= $job ?>];
             $("#cb_copydiagramjobend").autocomplete({
             source: [cb_copydiagramjobend]
             });*/

        </script>

        <script>


            function select_cluster()
            {
                $('.selectpicker').on('changed.bs.select', function () {
                    document.getElementById('txt_copydiagramcluster').value = $(this).val();
                    select_jobend();
                });


            }
            function select_jobend()
            {

                var copydiagramthainame = document.getElementById("txt_copydiagramthainame").value;
                var copydiagramjobstart = document.getElementById("txt_copydiagramjobstart").value;

                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "show_copydiagramjobend", cluster: document.getElementById('txt_copydiagramcluster').value, copydiagramthainame: copydiagramthainame, copydiagramjobstart: copydiagramjobstart
                    },
                    success: function (rs) {

                        document.getElementById("data_copydiagramjobendsr").innerHTML = rs;
                        document.getElementById("data_copydiagramjobenddef").innerHTML = "";

                        $("#cb_copydiagramjobend").html(rs).selectpicker('refresh');
                        $('.selectpicker').on('changed.bs.select', function () {
                            document.getElementById('txt_copydiagramjobend').value = $(this).val();

                        });


                    }
                });
            }

            function pdf_transportplan()
            {
                var datestart = document.getElementById("txt_datestartsr").value;
                var dateend = document.getElementById("txt_dateendsr").value;
                window.open('pdf_transportplan.php?datestart=' + datestart + '&dateend=' + dateend, '_blank');


            }

        </script>
        <script>
            function noWeekends(date) {
                var day = date.getDay();
                // ถ้าวันเป็นวันอาทิตย์ (0) หรือวันเสาร์ (6)
                if (day === 2 || day === 3 || day === 4 || day === 5 || day === 6 || day === 0) {

                    // เลือกไม่ได้
                    return [false, "", "วันนี้เป็นวันหยุด"];
                }
                // เลือกได้ตามปกติ
                return [true, "", ""];
            }

        </script>
        <script>
            $(function () {
                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                // กรณีใช้แบบ input
                $(".dateen").datetimepicker({
                    timepicker: false,
                    format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000			
                    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                    beforeShowDay: noWeekends

                });
            });
        </script>
        <script>
            $(function () {

                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                // กรณีใช้แบบ input
                $(".datedef").datetimepicker({
                    timepicker: false,
                    format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000			
                    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.

                });
            });
        </script>

        <script>
            $(function () {
                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                // กรณีใช้แบบ input
                $(".datetimeen").datetimepicker({
                    timepicker: true,
                    dateformat: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00 - 00 - 0000
                    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                    timeFormat: "HH:mm"

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
        </script>
        <script>

            $(document).ready(function () {
                $('#dataTables-example11').DataTable({

                    order: [[0, "desc"]],
                    scrollX: true,
                    scrollY: '500px',
                });





                $('#dataTables-example2').DataTable({
                    responsive: true,
                    order: [[0, "desc"]]
                });

                $('#dataTables-checkdriver').DataTable({
                    responsive: true,
                    order: [[0, "desc"]]
                });



                $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                    $($.fn.dataTable.tables(true)).DataTable()
                            .columns.adjust()
                            .responsive.recalc();
                });

            });
        </script>
        <script>
            // append row to the HTML table
            function appendRow() {
                var tbl = document.getElementById('dataTables-example'), // table reference
                        row = tbl.insertRow(tbl.rows.length), // append table row
                        i;
                // insert table cells to the new row
                for (i = 0; i < tbl.rows[2].cells.length; i++) {
                    createCell(row.insertCell(i), '', 'row');
                }
            }

            // create DIV element and append to the table cell
            function createCell(cell, text, style) {
                var div = document.createElement('div'), // create DIV element
                        txt = document.createTextNode(text); // create text node
                div.appendChild(txt); // append text node to the DIV
                div.setAttribute('class', style); // set DIV class attribute
                div.setAttribute('className', style); // set DIV class attribute for IE (?!)
                cell.appendChild(div); // append DIV to the table cell
            }
            // append column to the HTML table
            function appendColumn() {
                var tbl = document.getElementById('dataTables-example'), // table reference
                        i;
                // open loop for each row and append cell
                for (i = 0; i < tbl.rows.length; i++) {
                    createCell(tbl.rows[i].insertCell(tbl.rows[i].cells.length), '', 'col');
                }
            }
            // delete table rows with index greater then 0
            function deleteRows() {
                var tbl = document.getElementById('dataTables-example'), // table reference
                        lastRow = tbl.rows.length - 1, // set the last row index
                        i;
                // delete rows with index greater then 0
                for (i = lastRow; i > 2; i--) {
                    tbl.deleteRow(i);
                }
            }

            // delete table columns with index greater then 0
            function deleteColumns() {
                var tbl = document.getElementById('dataTables-example'), // table reference
                        lastCol = tbl.rows[0].cells.length - 1, // set the last column index
                        i, j;
                // delete cells with index greater then 0 (for each row)
                for (i = 0; i < tbl.rows.length; i++) {
                    for (j = lastCol; j > 5; j--) {
                        tbl.rows[i].deleteCell(j);
                    }
                }
            }
        </script>
        <script>

            function chk_disible()
            {
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "select_vehicletransportdocument", vehicletransportplanid: vehicletransportplanid
                    },
                    success: function (response) {
                        if (response)
                        {

                            document.getElementById("datasr").innerHTML = response;
                            document.getElementById("datadef").innerHTML = "";
                        }
                        $(document).ready(function () {
                            $('#dataTables-example2').DataTable({
                                responsive: true,
                                order: [[0, "desc"]]
                            });
                        });
                    }
                });
            }

            function add_dateweek1(datestart)
            {


                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "select_adddateweek", datestart: datestart
                    },
                    success: function (rs) {

                        var res = rs.split("|");
                        document.getElementById("txt_dateendsr").value = res[0];

                        dateendsr();







                    }
                });


            }


            function dateendsr()
            {

                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "showupdate_vehicletransportplan", datestart: document.getElementById("txt_datestartsr").value, dateend: document.getElementById("txt_dateendsr").value, statusnumber: document.getElementById("cb_statussr").value, companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', pricetype: '<?= $_GET['pricetype'] ?>'
                    },
                    success: function (rs) {
                        document.getElementById("showdatasr").innerHTML = rs;
                        document.getElementById("showdatadef").innerHTML = "";



                        $(document).ready(function () {
                            $('#dataTables-example11').DataTable({

                                order: [[0, "desc"]],
                                scrollX: true,
                                scrollY: '500px',
                            });

                            $('#dataTables-example22').DataTable({

                                order: [[0, "desc"]],
                                scrollX: true,
                                scrollY: '500px',

                            });

                            $('#dataTables-example33').DataTable({

                                order: [[0, "desc"]],
                                scrollX: true,
                                scrollY: '500px',
                            });

                            $('#dataTables-example44').DataTable({

                                order: [[0, "desc"]],
                                scrollX: true,
                                scrollY: '500px',
                            });

                            $('#dataTables-example55').DataTable({

                                order: [[0, "desc"]],
                                scrollX: true,
                                scrollY: '500px',
                            });

                            $('#dataTables-example66').DataTable({

                                order: [[0, "desc"]],
                                scrollX: true,
                                scrollY: '500px',
                            });

                            $('#dataTables-example77').DataTable({

                                order: [[0, "desc"]],
                                scrollX: true,
                                scrollY: '500px',
                            });
                            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                                $($.fn.dataTable.tables(true)).DataTable()
                                        .columns.adjust()
                                        .responsive.recalc();
                            });
                        });


                        $("#cb_jobendm<?= $i1 ?>").html(rs).selectpicker('refresh');
                        $('.selectpicker').on('changed.bs.select', function () {

                            //edit_vehicletransportplan('' + $(this).val() + '', 'JOBEND', ID);

                        });

                        /*
                         
                         var txt_jobstartm1 = [<?//= $jobsm1 ?>];
                         for (n = 1; n < <?//= $i1 ?>; n++) {
                         $("#txt_jobstartm1" + n).autocomplete({
                         source: [txt_jobstartm1]
                         });
                         }
                         var txt_jobstartm2 = [<?//= $jobsm2 ?>];
                         for (n = 1; n < <?//= $i1 ?>; n++) {
                         $("#txt_jobstartm2" + n).autocomplete({
                         source: [txt_jobstartm2]
                         });
                         }
                         var txt_jobstartm3 = [<?//= $jobsm3 ?>];
                         for (n = 1; n < <?//= $i1 ?>; n++) {
                         $("#txt_jobstartm3" + n).autocomplete({
                         source: [txt_jobstartm3]
                         });
                         }
                         var txt_jobstartm4 = [<?//= $jobsm4 ?>];
                         for (n = 1; n < <?//= $i1 ?>; n++) {
                         $("#txt_jobstartm4" + n).autocomplete({
                         source: [txt_jobstartm4]
                         });
                         }
                         
                         var txt_jobstarttu1 = [<?//= $jobstu1 ?>];
                         for (n = 1; n < <?//= $i2 ?>; n++) {
                         $("#txt_jobstarttu1" + n).autocomplete({
                         source: [txt_jobstarttu1]
                         });
                         }
                         var txt_jobstarttu2 = [<?//= $jobstu2 ?>];
                         for (n = 1; n < <?//= $i2 ?>; n++) {
                         $("#txt_jobstarttu2" + n).autocomplete({
                         source: [txt_jobstarttu2]
                         });
                         }
                         
                         var txt_jobstartw1 = [<?//= $jobsw1 ?>];
                         for (n = 1; n < <?//= $i3 ?>; n++) {
                         $("#txt_jobstartw1" + n).autocomplete({
                         source: [txt_jobstartw1]
                         });
                         }
                         var txt_jobstartw2 = [<?//= $jobsw2 ?>];
                         for (n = 1; n < <?//= $i3 ?>; n++) {
                         $("#txt_jobstartw2" + n).autocomplete({
                         source: [txt_jobstartw2]
                         });
                         }
                         
                         var txt_jobstartth1 = [<?//= $jobsth1 ?>];
                         for (n = 1; n < <?//= $i4 ?>; n++) {
                         $("#txt_jobstartth1" + n).autocomplete({
                         source: [txt_jobstartth1]
                         });
                         }
                         var txt_jobstartth2 = [<?//= $jobsth2 ?>];
                         for (n = 1; n < <?//= $i4 ?>; n++) {
                         $("#txt_jobstartth2" + n).autocomplete({
                         source: [txt_jobstartth2]
                         });
                         }
                         
                         var txt_jobstartf1 = [<?//= $jobsf1 ?>];
                         for (n = 1; n < <?//= $i5 ?>; n++) {
                         $("#txt_jobstartf1" + n).autocomplete({
                         source: [txt_jobstartf1]
                         });
                         }
                         var txt_jobstartf2 = [<?//= $jobsf2 ?>];
                         for (n = 1; n < <?//= $i5 ?>; n++) {
                         $("#txt_jobstartf2" + n).autocomplete({
                         source: [txt_jobstartf2]
                         });
                         }
                         
                         var txt_jobstartsat1 = [<?//= $jobssat1 ?>];
                         for (n = 1; n < <?//= $i6 ?>; n++) {
                         $("#txt_jobstartsat1" + n).autocomplete({
                         source: [txt_jobstartsat1]
                         });
                         }
                         var txt_jobstartsat2 = [<?//= $jobssat2 ?>];
                         for (n = 1; n < <?//= $i6 ?>; n++) {
                         $("#txt_jobstartsat2" + n).autocomplete({
                         source: [txt_jobstartsat2]
                         });
                         }
                         
                         var txt_jobstartsun1 = [<?//= $jobssun1 ?>];
                         for (n = 1; n < <?//= $i7 ?>; n++) {
                         $("#txt_jobstartsun1" + n).autocomplete({
                         source: [txt_jobstartsun1]
                         });
                         }
                         var txt_jobstartsun2 = [<?//= $jobssun2 ?>];
                         for (n = 1; n < <?//= $i7 ?>; n++) {
                         $("#txt_jobstartsun2" + n).autocomplete({
                         source: [txt_jobstartsun2]
                         });
                         }
                         
                         var txt_clusterm = [<?//= $cluster ?>];
                         for (n = 1; n < <?//= $i1 ?>; n++) {
                         $("#txt_clusterm" + n).autocomplete({
                         source: [txt_clusterm]
                         });
                         }
                         
                         var txt_clustertu = [<?//= $cluster ?>];
                         for (n = 1; n < <?//= $i2 ?>; n++) {
                         $("#txt_clustertu" + n).autocomplete({
                         source: [txt_clustertu]
                         });
                         }
                         
                         var txt_clusterw = [<?//= $cluster ?>];
                         for (n = 1; n < <?//= $i3 ?>; n++) {
                         $("#txt_clusterw" + n).autocomplete({
                         source: [txt_clusterw]
                         });
                         }
                         
                         var txt_clusterth = [<?//= $cluster ?>];
                         for (n = 1; n < <?//= $i4 ?>; n++) {
                         $("#txt_clusterth" + n).autocomplete({
                         source: [txt_clusterth]
                         });
                         }
                         
                         var txt_clusterf = [<?//= $cluster ?>];
                         for (n = 1; n < <?//= $i5 ?>; n++) {
                         $("#txt_clusterf" + n).autocomplete({
                         source: [txt_clusterf]
                         });
                         }
                         
                         var txt_clustersat = [<?//= $cluster ?>];
                         for (n = 1; n < <?//= $i6 ?>; n++) {
                         $("#txt_clustersat" + n).autocomplete({
                         source: [txt_clustersat]
                         });
                         }
                         
                         var txt_clustersun = [<?//= $cluster ?>];
                         for (n = 1; n < <?//= $i7 ?>; n++) {
                         $("#txt_clustersun" + n).autocomplete({
                         source: [txt_clustersun]
                         });
                         }
                         
                         
                         
                         var txt_jobendm = [<?//= $jobrccend ?>];
                         for (n = 1; n < <?//= $i1 ?>; n++) {
                         $("#txt_jobendm" + n).autocomplete({
                         source: [txt_jobendm]
                         });
                         }
                         var txt_jobendm1 = [<?//= $jobendrks_denso ?>];
                         for (n = 1; n < <?//= $i1 ?>; n++) {
                         $("#txt_jobendm1" + n).autocomplete({
                         source: [txt_jobendm1]
                         });
                         }
                         var txt_jobendtu = [<?//= $jobrccend ?>];
                         for (n = 1; n < <?//= $i2 ?>; n++) {
                         $("#txt_jobendtu" + n).autocomplete({
                         source: [txt_jobendtu]
                         });
                         }
                         
                         var txt_jobendw = [<?//= $jobrccend ?>];
                         for (n = 1; n < <?//= $i3 ?>; n++) {
                         $("#txt_jobendw" + n).autocomplete({
                         source: [txt_jobendw]
                         });
                         }
                         
                         var txt_jobendth = [<?//= $jobrccend ?>];
                         for (n = 1; n < <?//= $i4 ?>; n++) {
                         $("#txt_jobendth" + n).autocomplete({
                         source: [txt_jobendth]
                         });
                         }
                         
                         var txt_jobendf = [<?//= $jobrccend ?>];
                         for (n = 1; n < <?//= $i5 ?>; n++) {
                         
                         $("#txt_jobendf" + n).autocomplete({
                         source: [txt_jobendf]
                         });
                         }
                         
                         var txt_jobendsat = [<?//= $jobrccend ?>];
                         for (n = 1; n < <?//= $i6 ?>; n++) {
                         $("#txt_jobendsat" + n).autocomplete({
                         source: [txt_jobendsat]
                         });
                         }
                         
                         var txt_jobendsun = [<?//= $jobrccend ?>];
                         for (n = 1; n < <?//= $i7 ?>; n++) {
                         $("#txt_jobendsun" + n).autocomplete({
                         source: [txt_jobendsun]
                         });
                         }
                         
                         var txt_employeem1 = [<?//= $emp ?>];
                         for (n = 1; n < <?//= $i1 ?>; n++) {
                         $("#txt_employeem1" + n).autocomplete({
                         source: [txt_employeem1]
                         });
                         }
                         
                         var txt_employeetu1 = [<?//= $emp ?>];
                         for (n = 1; n < <?//= $i2 ?>; n++) {
                         $("#txt_employeetu1" + n).autocomplete({
                         source: [txt_employeetu1]
                         });
                         }
                         
                         var txt_employeew1 = [<?//= $emp ?>];
                         for (n = 1; n < <?//= $i3 ?>; n++) {
                         $("#txt_employeew1" + n).autocomplete({
                         source: [txt_employeew1]
                         });
                         }
                         
                         var txt_employeeth1 = [<?//= $emp ?>];
                         for (n = 1; n < <?//= $i4 ?>; n++) {
                         $("#txt_employeeth1" + n).autocomplete({
                         source: [txt_employeeth1]
                         });
                         }
                         
                         var txt_employeef1 = [<?//= $emp ?>];
                         for (n = 1; n < <?//= $i5 ?>; n++) {
                         $("#txt_employeef1" + n).autocomplete({
                         source: [txt_employeef1]
                         });
                         }
                         
                         var txt_employeesat1 = [<?//= $emp ?>];
                         for (n = 1; n < <?//= $i6 ?>; n++) {
                         $("#txt_employeesat1" + n).autocomplete({
                         source: [txt_employeesat1]
                         });
                         }
                         
                         var txt_employeesun1 = [<?//= $emp ?>];
                         for (n = 1; n < <?//= $i7 ?>; n++) {
                         $("#txt_employeesun1" + n).autocomplete({
                         source: [txt_employeesun1]
                         });
                         }
                         
                         var txt_employeem2 = [<?//= $emp ?>];
                         for (n = 1; n < <?//= $i1 ?>; n++) {
                         $("#txt_employeem2" + n).autocomplete({
                         source: [txt_employeem2]
                         });
                         }
                         
                         var txt_employeetu2 = [<?//= $emp ?>];
                         for (n = 1; n < <?//= $i2 ?>; n++) {
                         $("#txt_employeetu2" + n).autocomplete({
                         source: [txt_employeetu2]
                         });
                         }
                         
                         var txt_employeew2 = [<?//= $emp ?>];
                         for (n = 1; n < <?//= $i3 ?>; n++) {
                         $("#txt_employeew2" + n).autocomplete({
                         source: [txt_employeew2]
                         });
                         }
                         
                         var txt_employeeth2 = [<?//= $emp ?>];
                         for (n = 1; n < <?//= $i4 ?>; n++) {
                         $("#txt_employeeth2" + n).autocomplete({
                         source: [txt_employeeth2]
                         });
                         }
                         
                         var txt_employeef2 = [<?//= $emp ?>];
                         for (n = 1; n < <?//= $i5 ?>; n++) {
                         $("#txt_employeef2" + n).autocomplete({
                         source: [txt_employeef2]
                         });
                         }
                         
                         var txt_employeesat2 = [<?//= $emp ?>];
                         for (n = 1; n < <?//= $i6 ?>; n++) {
                         $("#txt_employeesat2" + n).autocomplete({
                         source: [txt_employeesat2]
                         });
                         }
                         
                         var txt_employeesun2 = [<?//= $emp ?>];
                         for (n = 1; n < <?//= $i7 ?>; n++) {
                         $("#txt_employeesun2" + n).autocomplete({
                         source: [txt_employeesun2]
                         });
                         }
                         
                         var txt_carm = [<?//= $thainame ?>];
                         for (n = 1; n < <?//= $i1 ?>; n++) {
                         $("#txt_carm" + n).autocomplete({
                         source: [txt_carm]
                         });
                         }
                         
                         var txt_cartu = [<?//= $thainame ?>];
                         for (n = 1; n < <?//= $i2 ?>; n++) {
                         $("#txt_cartu" + n).autocomplete({
                         source: [txt_cartu]
                         });
                         }
                         
                         var txt_carw = [<?//= $thainame ?>];
                         for (n = 1; n < <?//= $i3 ?>; n++) {
                         $("#txt_carw" + n).autocomplete({
                         source: [txt_carw]
                         });
                         }
                         
                         var txt_carth = [<?//= $thainame ?>];
                         for (n = 1; n < <?//= $i4 ?>; n++) {
                         
                         $("#txt_carth" + n).autocomplete({
                         source: [txt_carth]
                         });
                         }
                         
                         var txt_carf = [<?//= $thainame ?>];
                         for (n = 1; n < <?//= $i5 ?>; n++) {
                         $("#txt_carf" + n).autocomplete({
                         source: [txt_carf]
                         });
                         }
                         
                         var txt_carsat = [<?//= $thainame ?>];
                         for (n = 1; n < <?//= $i6 ?>; n++) {
                         $("#txt_carsat" + n).autocomplete({
                         source: [txt_carsat]
                         });
                         }
                         
                         var txt_carsun = [<?//= $thainame ?>];
                         for (n = 1; n < <?//= $i7 ?>; n++) {
                         $("#txt_carsun" + n).autocomplete({
                         source: [txt_carsun]
                         });
                         }
                         */






                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "select_adddateweek", datestart: document.getElementById("txt_datestartsr").value
                            },
                            success: function (rs) {

                                var res = rs.split("|");
                                document.getElementById("txt_dateendsr").value = res[0];



                                document.getElementById("lbl_m").innerHTML = '(' + res[1] + ')';
                                document.getElementById("lbl_tu").innerHTML = '(' + res[2] + ')';
                                document.getElementById("lbl_w").innerHTML = '(' + res[3] + ')';
                                document.getElementById("lbl_th").innerHTML = '(' + res[4] + ')';
                                document.getElementById("lbl_f").innerHTML = '(' + res[5] + ')';
                                document.getElementById("lbl_sat").innerHTML = '(' + res[6] + ')';
                                document.getElementById("lbl_sun").innerHTML = '(' + res[7] + ')';






                            }
                        });




                    }
                });
            }
            function showupdate_vehicletransportdocument(vehicletransportplanid)
            {
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "select_vehicletransportdocument", vehicletransportplanid: vehicletransportplanid
                    },
                    success: function (response) {
                        if (response)
                        {

                            document.getElementById("datasr").innerHTML = response;
                            document.getElementById("datadef").innerHTML = "";
                        }
                        $(document).ready(function () {
                            $('#dataTables-example2').DataTable({
                                responsive: true,
                                order: [[0, "desc"]]
                            });
                        });
                    }
                });
            }
            function showupdate_vehicletransportactual(vehicletransportplanid)
            {

                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "select_vehicletransportactual", vehicletransportplanid: vehicletransportplanid
                    },
                    success: function (response) {
                        if (response)
                        {

                            document.getElementById("datasr_actual").innerHTML = response;
                            document.getElementById("datadef_actual").innerHTML = "";

                            $(function () {
                                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                // กรณีใช้แบบ input
                                $(".datetimeen").datetimepicker({
                                    timepicker: true,
                                    dateformat: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00 - 00 - 0000
                                    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                    timeFormat: "HH:mm"

                                }
                                );
                            });

                        }

                    }
                });
            }


            function add_dateweek(datestart)
            {


                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "select_adddateweek", datestart: datestart
                    },
                    success: function (rs) {

                        var res = rs.split("|");
                        document.getElementById("txt_copydiagramdateend").value = res[0];
                        document.getElementById("lab_monday").innerHTML = '(' + res[1] + ')';
                        document.getElementById("lab_tuesday").innerHTML = '(' + res[2] + ')';
                        document.getElementById("lab_wednesday").innerHTML = '(' + res[3] + ')';
                        document.getElementById("lab_thursday").innerHTML = '(' + res[4] + ')';
                        document.getElementById("lab_friday").innerHTML = '(' + res[5] + ')';
                        document.getElementById("lab_saturday").innerHTML = '(' + res[6] + ')';
                        document.getElementById("lab_sunday").innerHTML = '(' + res[7] + ')';


                        create_jobno('monday', '<?= $_GET['companycode'] ?>', res[1]);
                        create_jobno('tuesday', '<?= $_GET['companycode'] ?>', res[2]);
                        create_jobno('wednesday', '<?= $_GET['companycode'] ?>', res[3]);
                        create_jobno('thursday', '<?= $_GET['companycode'] ?>', res[4]);
                        create_jobno('friday', '<?= $_GET['companycode'] ?>', res[5]);
                        create_jobno('saturday', '<?= $_GET['companycode'] ?>', res[6]);
                        create_jobno('sunday', '<?= $_GET['companycode'] ?>', res[7]);
                    }
                });
            }
        </script>
        <script>
            function chknull_vehicletransportdocument()
            {
                if (document.getElementById("cb_documenttype").value == "")
                {
                    alert('ประเภทเอกสาร เป็นค่าว่าง !!!')
                    document.getElementById('cb_documenttype').focus();
                    return false;
                } else if (document.getElementById("txt_amount").value == "")
                {
                    alert('จำนวน เป็นค่าว่าง !!!')
                    document.getElementById('txt_amount').focus();
                    return false;
                } else if (document.getElementById("cb_unit").value == "")
                {
                    alert('หน่วย เป็นค่าว่าง !!!')
                    document.getElementById('cb_unit').focus();
                    return false;
                } else if (document.getElementById("cb_activestatus").value == "")
                {
                    alert('สถานะ เป็นค่าว่าง !!!')
                    document.getElementById('cb_activestatus').focus();
                    return false;
                } else
                {
                    return true;
                }
            }

            function add_vehicletransportplanroot(CUSTOMERCODE, COMPANYCODE, VEHICLEREGISNUMBER1, VEHICLEREGISNUMBER2, THAINAME, ENGNAME, VEHICLETRANSPORTPRICEID, CLUSTER, DEALERCODE, NAME, SRBASE4L, SRBASE8L, GWBASE4L, GWBASE8L, BPBASE4L, BPBASE8L, OTHBASE4L, OTHBASE8L, E1, E2, E3, E4, C1, C2, C3, C4, C5, C6, C7, C8, C9, O1, O2, O3, O4, JOBSTART, JOBEND, EMPLOYEECODE1, EMPLOYEENAME1, EMPLOYEECODE2, EMPLOYEENAME2, EMPLOYEECODE3, EMPLOYEENAME3, EMPLOYEECODE4, EMPLOYEENAME4, JOBNO, TRIPNO, DATEINPUT, DATESTART, DATEWORKING, DATEWORKSUS, DATEPRESENT, DATEVLIN, DATEVLOUT, DATEDEALERIN, DATERETURN, STATUS, ACTIVESTATUS, REMARK)
            {

                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "save_vehicletransportplan", VEHICLETRANSPORTPLANID: '', CUSTOMERCODE: CUSTOMERCODE, COMPANYCODE: COMPANYCODE, VEHICLEREGISNUMBER1: VEHICLEREGISNUMBER1, VEHICLEREGISNUMBER2: VEHICLEREGISNUMBER2, THAINAME: THAINAME, ENGNAME: ENGNAME, VEHICLETRANSPORTPRICEID: VEHICLETRANSPORTPRICEID, CLUSTER: CLUSTER, DEALERCODE: DEALERCODE, NAME: NAME, SRBASE4L: SRBASE4L, SRBASE8L: SRBASE8L, GWBASE4L: GWBASE4L, GWBASE8L: GWBASE8L, BPBASE4L: BPBASE4L, BPBASE8L: BPBASE8L, OTHBASE4L: OTHBASE4L, OTHBASE8L: OTHBASE8L, E1: E1, E2: E2, E3: E3, E4: E4, C1: C1, C2: C2, C3: C3, C4: C4, C5: C5, C6: C6, C7: C7, C8: C8, C9: C9, O1: O1, O2: O2, O3: O3, O4: O4, JOBSTART: JOBSTART, JOBEND: JOBEND, EMPLOYEECODE1: EMPLOYEECODE1, EMPLOYEENAME1: EMPLOYEENAME1, EMPLOYEECODE2: EMPLOYEECODE2, EMPLOYEENAME2: EMPLOYEENAME2, EMPLOYEECODE3: EMPLOYEECODE3, EMPLOYEENAME3: EMPLOYEENAME3, EMPLOYEECODE4: EMPLOYEECODE4, EMPLOYEENAME4: EMPLOYEENAME4, JOBNO: JOBNO, TRIPNO: TRIPNO, DATEINPUT: DATEINPUT, DATESTART: DATESTART, DATEWORKING: DATEWORKING, DATEWORKSUS: DATEWORKSUS, DATEPRESENT: DATEPRESENT, DATEVLIN: DATEVLIN, DATEVLOUT: DATEVLOUT, DATEDEALERIN: DATEDEALERIN, DATERETURN: DATERETURN, STATUS: STATUS, ACTIVESTATUS: ACTIVESTATUS, REMARK: REMARK
                    },
                    success: function (rs) {
                        alert(rs);
                        window.location.reload();
                    }
                });
            }
            function update_vehicletransportdocument(vehicletransportdocumentid, vehicletransportplanid, documenttype, documentnumber, amount, unit, activestatus, documentremark)
            {
                document.getElementById("txt_vehicletransportdocumentid").value = vehicletransportdocumentid;
                document.getElementById("txt_vehicletransportplanid").value = vehicletransportplanid;
                document.getElementById("cb_documenttype").value = documenttype;
                document.getElementById("txt_documentnumber").value = documentnumber;
                document.getElementById("txt_amount").value = amount;
                document.getElementById("cb_unit").value = unit;
                document.getElementById("cb_activestatus").value = activestatus;
                document.getElementById("txt_documentremark").value = documentremark;
            }
            function save_vehicletransportdocument()
            {
                var route = document.getElementById("txt_route").value;
                var vehicletransportdocumentid = document.getElementById("txt_vehicletransportdocumentid").value;
                var vehicletransportplanid = document.getElementById("txt_vehicletransportplanid").value;
                var documenttype = document.getElementById("cb_documenttype").value;
                var amount = document.getElementById("txt_amount").value;
                var unit = document.getElementById("cb_unit").value;
                var activestatus = document.getElementById("cb_activestatus").value;
                var documentremark = document.getElementById("txt_documentremark").value;

                if (route == "-")
                {
                    alert('กรุณาเลือกเส้นทางก่อน !!!');
                } else
                {


                    if (chknull_vehicletransportdocument())
                    {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_vehicletransportdocumentadmin", vehicletransportdocumentid: vehicletransportdocumentid, vehicletransportplanid: vehicletransportplanid, documenttype: documenttype, amount: amount, unit: unit, activestatus: activestatus, documentremark: documentremark

                            },
                            success: function (rs) {
                                alert(rs);
                                showupdate_vehicletransportdocument(vehicletransportplanid);
                            }
                        });
                    }
                }
            }


            function save_vehicletransportplan(employeename1)
            {

                var companycode = document.getElementById("txt_companycode").value;
                var customercode = document.getElementById("txt_customercode").value;
                if (companycode != '' && customercode != '')
                {

                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "save_vehicletransportplan", VEHICLETRANSPORTPLANID: '', CUSTOMERCODE: customercode, COMPANYCODE: companycode, VEHICLEREGISNUMBER1: '', VEHICLEREGISNUMBER2: '', THAINAME: '', ENGNAME: '', VEHICLETRANSPORTPRICEID: '', CLUSTER: '', DEALERCODE: '', NAME: '', SRBASE4L: '', SRBASE8L: '', GWBASE4L: '', GWBASE8L: '', BPBASE4L: '', BPBASE8L: '', OTHBASE4L: '', OTHBASE8L: '', E1: '', E2: '', E3: '', E4: '', C1: '', C2: '', C3: '', C4: '', C5: '', C6: '', C7: '', C8: '', C9: '', O1: '', O2: '', O3: '', O4: '', JOBSTART: '', JOBEND: '', EMPLOYEECODE1: '', EMPLOYEENAME1: employeename1, EMPLOYEECODE2: '', EMPLOYEENAME2: '', EMPLOYEECODE3: '', EMPLOYEENAME3: '', EMPLOYEECODE4: '', EMPLOYEENAME4: '', JOBNO: '<?= $run_jobno ?>', TRIPNO: '', DATEINPUT: '', DATEWORKING: '', DATEWORKSUS: '', DATEPRESENT: '', DATEVLIN: '', DATEVLOUT: '', DATEDEALERIN: '', DATERETURN: '', STATUS: '', ACTIVESTATUS: '', REMARK: ''
                        },
                        success: function (rs) {
                            alert(rs);
                            //alert('เพิ่มแผนการขนส่งเรียบร้อยแล้ว');

                            window.location.reload();
                        }
                    });
                } else
                {
                    alert('ไม่สามารถสร้างแผนการขนส่งได้ !!!');
                }
            }
            function delete_vehicletransportplan(vehicletransportplanid)
            {

                var confirmation = confirm("ต้องการลบข้อมูล ?");
                if (confirmation) {
                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "delete_vehicletransportplan", vehicletransportplanid: vehicletransportplanid
                        },
                        success: function () {

                            window.location.reload();
                        }
                    });
                }
            }
            function delete_vehicletransportdocument(vehicletransportdocumentid, vehicletransportplanid)
            {
                var confirmation = confirm("ต้องการลบข้อมูล ?");
                if (confirmation) {
                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "delete_vehicletransportdocument", vehicletransportdocumentid: vehicletransportdocumentid
                        },
                        success: function () {
                            alert('ลบข้อมูลเรียบร้อยแล้ว');
                            showupdate_vehicletransportdocument(vehicletransportplanid);
                        }
                    });
                }
            }


        </script>

        <script>

            function edit_vehicletransportplaninner(editableObj, fieldname, ID)
            {
                var dataedit = editableObj.innerHTML;
                $.ajax({
                    url: 'meg_data.php',
                    type: 'POST',
                    data: {
                        txt_flg: "edit_vehicletransportplan", editableObj: dataedit, ID: ID, fieldname: fieldname
                    },
                    success: function () {

                    }
                });
            }
            function update_vehicletransportplanjob(rootno, statusnumber)
            {

                $.ajax({
                    url: 'meg_data.php',
                    type: 'post',
                    data: {
                        txt_flg: "edit_vehicletransportplanjob", rootno: rootno, statusnumber: statusnumber
                    },
                    success: function () {

                        //window.location.reload();
                    }

                });
            }
            function edit_vehicletransportplanactual(editableObj, fieldname)
            {
                var vehicletransportplanid = document.getElementById("txt_vehicletransportplanid").value;

                $.ajax({
                    url: 'meg_data.php',
                    type: 'POST',
                    data: {
                        txt_flg: "edit_datevehicletransportplan", editableObj: editableObj, ID: vehicletransportplanid, fieldname: fieldname
                    },
                    success: function () {

                    }
                });
            }
            function edit_vehicletransportplanend(editableObj, fieldname, ID)
            {

                //for (var n = 1; n < <?//= $i ?>; n++) {

                //if (document.getElementById("txt_employee2" + n).value != "" || document.getElementById("txt_employee21" + n).value != "")
                //{

                /*if (document.getElementById("txt_employee2" + n).value == document.getElementById("txt_employee1" + n).value)
                 {
                 alert('เลือกพนักงาน(2)ให้ถูกต้อง !!!');
                 document.getElementById("txt_employee2" + n).value = '';
                 document.getElementById("txt_employee2" + n).focus();
                 } else
                 {*/

                $.ajax({
                    url: 'meg_data.php',
                    type: 'POST',
                    data: {
                        txt_flg: "edit_vehicletransportplan", editableObj: editableObj, ID: ID, fieldname: fieldname
                    },
                    success: function () {

                        window.location.reload();
                    }
                });
                //}
                //}
                //}

            }
            function reload()
            {
                window.location.reload();
            }
            function select_vehicletransportplanjobend(editableObj, fieldname, ID, cb_idname1)
            {
                if (fieldname == 'CLUSTER')
                {
                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "show_jobend", cluster: editableObj, cb_idname1: cb_idname1
                        },
                        success: function (rs) {


                            document.getElementById("data_clustersr" + cb_idname1).innerHTML = rs;
                            document.getElementById("data_clusterdef" + cb_idname1).innerHTML = "";


                            $("#" + cb_idname1).html(rs).selectpicker('refresh');
                            $('.selectpicker').on('changed.bs.select', function () {

                                edit_vehicletransportplan('' + $(this).val() + '', 'JOBEND', ID);

                            });
                            edit_vehicletransportplan(editableObj, fieldname, ID);
                        }
                    });
                }
            }

            function edit_vehicletransportplan(editableObj, fieldname, ID)
            {

                //for (var n = 1; n < <?//= $i ?>; n++) {

                //if (document.getElementById("txt_employee2" + n).value != "" || document.getElementById("txt_employee21" + n).value != "")
                //{

                /*if (document.getElementById("txt_employee2" + n).value == document.getElementById("txt_employee1" + n).value)
                 {
                 alert('เลือกพนักงาน(2)ให้ถูกต้อง !!!');
                 document.getElementById("txt_employee2" + n).value = '';
                 document.getElementById("txt_employee2" + n).focus();
                 } else
                 {*/

                $.ajax({
                    url: 'meg_data.php',
                    type: 'POST',
                    data: {
                        txt_flg: "edit_vehicletransportplan", editableObj: editableObj, ID: ID, fieldname: fieldname
                    },
                    success: function () {

                    }
                });
                //}
                //}
                //}

            }
        </script>
        <script>
            function edit_datevehicletransportplan(editableObj, fieldname, ID) {
                $.ajax({
                    url: 'meg_data.php',
                    type: 'POST',
                    data: {
                        txt_flg: "edit_datevehicletransportplan", editableObj: editableObj, ID: ID, fieldname: fieldname
                    },
                    success: function () {


                    }
                });
            }
        </script>

        <script>

            function create_jobno(typeday, companycode, jobdate)
            {

                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "create_jobno", companycode: companycode, jobdate: jobdate
                    },
                    success: function (rs) {
                        if (typeday == 'monday')
                        {
                            document.getElementById("txt_copydiagramjobnomonday").value = rs;
                        }
                        if (typeday == 'tuesday')
                        {
                            document.getElementById("txt_copydiagramjobnotuesday").value = rs;
                        }
                        if (typeday == 'wednesday')
                        {
                            document.getElementById("txt_copydiagramjobnowednesday").value = rs;
                        }
                        if (typeday == 'thursday')
                        {
                            document.getElementById("txt_copydiagramjobnothursday").value = rs;
                        }
                        if (typeday == 'friday')
                        {
                            document.getElementById("txt_copydiagramjobnofriday").value = rs;
                        }
                        if (typeday == 'saturday')
                        {
                            document.getElementById("txt_copydiagramjobnosaturday").value = rs;
                        }
                        if (typeday == 'sunday')
                        {
                            document.getElementById("txt_copydiagramjobnosunday").value = rs;
                        }
                    }
                });
            }
            function checknull_copydiagram(vehicletransportplanid)
            {
                if (vehicletransportplanid == '')
                {
                    if (document.getElementById("txt_copydiagramdatestart").value == "")
                    {
                        alert("วันที่เริ่มต้น เป็นค่าว่าง !!!");
                        return false;
                    } else if (document.getElementById("txt_copydiagramemployeename1").value == "")
                    {
                        alert("พนักงาน (1) เป็นค่าว่าง !!!");
                        return false;
                    } else if (document.getElementById("txt_copydiagramthainame").value == "")
                    {
                        alert("ชื่อรถ เป็นค่าว่าง !!!");
                        return false;
                    } else
                    {
                        return true;
                    }
                } else
                {
                    return true;
                }
            }

            function update_copydiagram(ID, fieldname, editableObj)
            {

                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "edit_vehicletransportplan",
                        ID: ID,
                        fieldname: fieldname,
                        editableObj: editableObj



                    },
                    success: function () {

                    }
                });
            }
            function save_copydiagram()
            {
                var datevlin = "";
                var datevlout = "";
                var dealerin = "";
                var datereturn = "";
                var vehicletype = "";
                var materialtype = "";
                var employeename1 = "";
                var employeename2 = "";
                var employeename3 = "";
                var thainame = "";
                var goreturn = "";
                var pricetype = "";
                var load = "";
                var route = "";
                var cluster = "";
                var jobstart = "";
                var jobend = "";
                var copydiagramunit = "";

                var vehicletransportplanid = '';
                if (document.getElementById("txt_copydiagramvehicletransportplanid").value == '')
                {
                    vehicletransportplanid = '';
                } else
                {
                    vehicletransportplanid = document.getElementById("txt_copydiagramvehicletransportplanid").value;
                }

                var copydiagramdatestart = document.getElementById("txt_copydiagramdatestart").value;
                var copydiagramdateend = document.getElementById("txt_copydiagramdateend").value;

                if ('<?= $_GET['worktype'] ?>' == 'OTHER')
                {
                    vehicletype = document.getElementById("cb_copydiagramcartype").value;
                    materialtype = '';
                    goreturn = '';
                } else
                {
                    if ('<?= $_GET['companycode'] ?>' == 'RRC')
                    {

                        vehicletype = document.getElementById("cb_copydiagramcartype").value;
                        materialtype = document.getElementById("cb_materialtype").value;
                        goreturn = document.getElementById("cb_copydiagramgoreturn").value;


                    } else if ('<?= $_GET['companycode'] ?>' == 'RKS')
                    {
                        if ('<?= $_GET['customercode'] ?>' == 'TGT')
                        {
                            vehicletype = document.getElementById("cb_copydiagramcartype").value;
                            materialtype = '';
                            goreturn = '';
                        } else if ('<?= $_GET['customercode'] ?>' == 'STM')
                        {
                            vehicletype = document.getElementById("cb_copydiagramcartype").value;
                            materialtype = '';
                            goreturn = '';
                        } else if ('<?= $_GET['customercode'] ?>' == 'TMT')
                        {
                            vehicletype = document.getElementById("cb_copydiagramcartype").value;
                            materialtype = '';
                            goreturn = '';
                        } else if ('<?= $_GET['customercode'] ?>' == 'TAW')
                        {
                            vehicletype = document.getElementById("cb_copydiagramcartype").value;
                            materialtype = '';
                            goreturn = '';
                        }
                    }
                }
                if ('<?= $_GET['companycode'] ?>' == 'RCC' || '<?= $_GET['companycode'] ?>' == 'RATC')
                {
                    copydiagramunit = document.getElementById("txt_copydiagramunit").value;
                } else
                {
                    copydiagramunit = '';
                }





                if (vehicletransportplanid == '')
                {
                    employeename1 = document.getElementById("txt_copydiagramemployeename1").value;
                    employeename2 = document.getElementById("txt_copydiagramemployeename2").value;
                    if ('<?= $_GET['companycode'] ?>' == 'RCC' || '<?= $_GET['companycode'] ?>' == 'RATC')
                    {
                        employeename3 = document.getElementById("txt_copydiagramemployeename3").value;
                    }

                    thainame = document.getElementById("txt_copydiagramthainame").value;
                    if (chk_copydiagramdatevlin.checked == true) {
                        datevlin = document.getElementById("txt_copydiagramdatevlin2").value;
                    } else
                    {
                        datevlin = document.getElementById("txt_copydiagramdatevlin").value;
                    }
                    if (chk_copydiagramdatevlout.checked == true) {
                        datevlout = document.getElementById("txt_copydiagramdatevlout2").value;
                    } else
                    {
                        datevlout = document.getElementById("txt_copydiagramdatevlout").value;
                    }
                    if (chk_copydiagramdatedealerin.checked == true) {
                        dealerin = document.getElementById("txt_copydiagramdatedealerin2").value;
                    } else
                    {
                        dealerin = document.getElementById("txt_copydiagramdatedealerin").value;
                    }
                    if (chk_copydiagramdatereturn.checked == true) {
                        datereturn = document.getElementById("txt_copydiagramdatereturn2").value;
                    } else
                    {
                        datereturn = document.getElementById("txt_copydiagramdatereturn").value;
                    }
                } else
                {
                    employeename1 = document.getElementById("txt_copydiagramemployeenameupd1").value;
                    employeename2 = document.getElementById("txt_copydiagramemployeenameupd2").value;
                    thainame = document.getElementById("txt_copydiagramthainameupd").value;
                    if (chk_copydiagramdatevlinupd.checked == true) {
                        datevlin = document.getElementById("txt_copydiagramdatevlinupd2").value;
                    } else
                    {
                        datevlin = document.getElementById("txt_copydiagramdatevlinupd").value;

                    }
                    if (chk_copydiagramdatevloutupd.checked == true) {
                        datevlout = document.getElementById("txt_copydiagramdatevloutupd2").value;
                    } else
                    {
                        datevlout = document.getElementById("txt_copydiagramdatevloutupd").value;
                    }
                    if (chk_copydiagramdatedealerinupd.checked == true) {
                        dealerin = document.getElementById("txt_copydiagramdatedealerinupd2").value;
                    } else
                    {
                        dealerin = document.getElementById("txt_copydiagramdatedealerinupd").value;
                    }
                    if (chk_copydiagramdatereturnupd.checked == true) {
                        datereturn = document.getElementById("txt_copydiagramdatereturnupd2").value;
                    } else
                    {
                        datereturn = document.getElementById("txt_copydiagramdatereturnupd").value;
                    }
                }


                if ('<?= $_GET['companycode'] ?>' == 'RCC' || '<?= $_GET['companycode'] ?>' == 'RATC')
                {
                    if ('<?= $_GET['pricetype'] == '1' ?>')
                    {
                        cluster = document.getElementById("txt_copydiagramcluster").value;
                        pricetype = '1';
                    } else if ('<?= $_GET['pricetype'] == '2' ?>')
                    {

                        pricetype = '2';
                        load = document.getElementById("cb_copydiagramload").value;
                        route = document.getElementById("cb_copydiagramroute").value;
                    }
                }

                if ('<?= $_GET['worktype'] ?>' == 'OTHER')
                {
                    jobstart = document.getElementById("cb_copydiagramjobstart").value;
                    jobend = document.getElementById("cb_copydiagramjobend").value;
                } else
                {
                    if ('<?= $_GET['companycode'] ?>' == 'RKS')
                    {
                        if ('<?= $_GET['customercode'] ?>' == 'DENSO-THAI' || '<?= $_GET['customercode'] ?>' == 'DENSO-WGR' || '<?= $_GET['customercode'] ?>' == 'DENSO-SALES' || '<?= $_GET['customercode'] ?>' == 'ANDEN' || '<?= $_GET['customercode'] ?>' == 'SDM' || '<?= $_GET['customercode'] ?>' == 'SKD' || '<?= $_GET['customercode'] ?>' == 'DENSO')
                        {
                            jobstart = document.getElementById("cb_copydiagramrouteno").value;
                            jobend = document.getElementById("cb_copydiagramroutetype").value;
                        } else if ('<?= $_GET['customercode'] ?>' == 'TGT')
                        {
                            jobstart = document.getElementById("cb_copydiagramjobstart").value;
                            jobend = document.getElementById("cb_copydiagramjobend").value;

                        } else if ('<?= $_GET['customercode'] ?>' == 'STM')
                        {
                            jobstart = document.getElementById("cb_copydiagramjobstart").value;
                            jobend = '';

                        } else if ('<?= $_GET['customercode'] ?>' == 'TMT')
                        {
                            jobstart = document.getElementById("cb_copydiagramjobstart").value;
                            jobend = '';

                        } else if ('<?= $_GET['customercode'] ?>' == 'TAW')
                        {
                            jobstart = document.getElementById("cb_copydiagramjobstart").value;
                            jobend = '';

                        }
                    } else if ('<?= $_GET['companycode'] ?>' == 'RRC')
                    {
                        jobstart = document.getElementById("cb_copydiagramjobstart").value;
                        jobend = document.getElementById("cb_copydiagramjobend").value;
                    } else if ('<?= $_GET['companycode'] ?>' == 'RKR')
                    {
                        jobstart = document.getElementById("cb_copydiagramjobstart").value;
                        jobend = document.getElementById("cb_copydiagramjobend").value;
                    } else if ('<?= $_GET['companycode'] ?>' == 'RKL')
                    {
                        jobstart = document.getElementById("cb_copydiagramjobstart").value;
                        jobend = document.getElementById("cb_copydiagramjobend").value;
                    } else if ('<?= $_GET['companycode'] ?>' == 'RCC' || '<?= $_GET['companycode'] ?>' == 'RATC')
                    {
                        if ('<?= $_GET['pricetype'] == '1' ?>')
                        {
                            jobstart = document.getElementById("txt_copydiagramjobstart").value;
                            jobend = document.getElementById("txt_copydiagramjobend").value;
                        } else if ('<?= $_GET['pricetype'] == '2' ?>')
                        {
                            jobstart = document.getElementById("txt_copydiagramjobstart").value;
                            jobend = document.getElementById("txt_copydiagramsubroute").value;
                        }
                    }
                }

                var dateinput = document.getElementById("txt_copydiagramdateinput").value;
                var datepresent = document.getElementById("txt_copydiagramdatepresent").value;




                if (checknull_copydiagram(vehicletransportplanid)) {


                    if (chk_copydiagrammonday.checked == true) {



                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid,
                                STARTDATE: copydiagramdatestart,
                                ENDDATE: copydiagramdateend,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame,
                                JOBSTART: jobstart,
                                CLUSTER: cluster,
                                JOBEND: jobend,
                                EMPLOYEENAME1: employeename1,
                                EMPLOYEENAME2: employeename2,
                                EMPLOYEENAME3: employeename3,
                                JOBNO: document.getElementById("txt_copydiagramjobnomonday").value,
                                DATEINPUT: dateinput,
                                DATEPRESENT: datepresent,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn,
                                VEHICLETYPE: vehicletype,
                                MATERIALTYPE: materialtype,
                                GORETURN: goreturn,
                                PRICETYPE: pricetype,
                                LOAD: load,
                                ROUTE: route,
                                UNIT: copydiagramunit

                            },
                            success: function () {


                            }
                        });
                    }
                    if (chk_copydiagramtuesday.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid,
                                STARTDATE: copydiagramdatestart,
                                ENDDATE: copydiagramdateend,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame,
                                JOBSTART: jobstart,
                                CLUSTER: cluster,
                                JOBEND: jobend,
                                EMPLOYEENAME1: employeename1,
                                EMPLOYEENAME2: employeename2,
                                EMPLOYEENAME3: employeename3,
                                JOBNO: document.getElementById("txt_copydiagramjobnotuesday").value,
                                DATEINPUT: dateinput,
                                DATEPRESENT: datepresent,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn,
                                VEHICLETYPE: vehicletype,
                                MATERIALTYPE: materialtype,
                                GORETURN: goreturn,
                                PRICETYPE: pricetype,
                                LOAD: load,
                                ROUTE: route,
                                UNIT: copydiagramunit

                            },
                            success: function () {


                            }
                        });
                    }
                    if (chk_copydiagramwednesday.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid,
                                STARTDATE: copydiagramdatestart,
                                ENDDATE: copydiagramdateend,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame,
                                JOBSTART: jobstart,
                                CLUSTER: cluster,
                                JOBEND: jobend,
                                EMPLOYEENAME1: employeename1,
                                EMPLOYEENAME2: employeename2,
                                EMPLOYEENAME3: employeename3,
                                JOBNO: document.getElementById("txt_copydiagramjobnowednesday").value,
                                DATEINPUT: dateinput,
                                DATEPRESENT: datepresent,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn,
                                VEHICLETYPE: vehicletype,
                                MATERIALTYPE: materialtype,
                                GORETURN: goreturn,
                                PRICETYPE: pricetype,
                                LOAD: load,
                                ROUTE: route,
                                UNIT: copydiagramunit

                            },
                            success: function () {


                            }
                        });
                    }
                    if (chk_copydiagramthursday.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid,
                                STARTDATE: copydiagramdatestart,
                                ENDDATE: copydiagramdateend,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame,
                                JOBSTART: jobstart,
                                CLUSTER: cluster,
                                JOBEND: jobend,
                                EMPLOYEENAME1: employeename1,
                                EMPLOYEENAME2: employeename2,
                                EMPLOYEENAME3: employeename3,
                                JOBNO: document.getElementById("txt_copydiagramjobnothursday").value,
                                DATEINPUT: dateinput,
                                DATEPRESENT: datepresent,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn,
                                VEHICLETYPE: vehicletype,
                                MATERIALTYPE: materialtype,
                                GORETURN: goreturn,
                                PRICETYPE: pricetype,
                                LOAD: load,
                                ROUTE: route,
                                UNIT: copydiagramunit

                            },
                            success: function () {


                            }
                        });
                    }
                    if (chk_copydiagramfriday.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid,
                                STARTDATE: copydiagramdatestart,
                                ENDDATE: copydiagramdateend,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame,
                                JOBSTART: jobstart,
                                CLUSTER: cluster,
                                JOBEND: jobend,
                                EMPLOYEENAME1: employeename1,
                                EMPLOYEENAME2: employeename2,
                                EMPLOYEENAME3: employeename3,
                                JOBNO: document.getElementById("txt_copydiagramjobnofriday").value,
                                DATEINPUT: dateinput,
                                DATEPRESENT: datepresent,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn,
                                VEHICLETYPE: vehicletype,
                                MATERIALTYPE: materialtype,
                                GORETURN: goreturn,
                                PRICETYPE: pricetype,
                                LOAD: load,
                                ROUTE: route,
                                UNIT: copydiagramunit

                            },
                            success: function () {


                            }
                        });
                    }
                    if (chk_copydiagramsaturday.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid,
                                STARTDATE: copydiagramdatestart,
                                ENDDATE: copydiagramdateend,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame,
                                JOBSTART: jobstart,
                                CLUSTER: cluster,
                                JOBEND: jobend,
                                EMPLOYEENAME1: employeename1,
                                EMPLOYEENAME2: employeename2,
                                EMPLOYEENAME3: employeename3,
                                JOBNO: document.getElementById("txt_copydiagramjobnosaturday").value,
                                DATEINPUT: dateinput,
                                DATEPRESENT: datepresent,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn,
                                VEHICLETYPE: vehicletype,
                                MATERIALTYPE: materialtype,
                                GORETURN: goreturn,
                                PRICETYPE: pricetype,
                                LOAD: load,
                                ROUTE: route,
                                UNIT: copydiagramunit

                            },
                            success: function () {


                            }
                        });
                    }
                    if (chk_copydiagramsunday.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid,
                                STARTDATE: copydiagramdatestart,
                                ENDDATE: copydiagramdateend,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame,
                                JOBSTART: jobstart,
                                CLUSTER: cluster,
                                JOBEND: jobend,
                                EMPLOYEENAME1: employeename1,
                                EMPLOYEENAME2: employeename2,
                                EMPLOYEENAME3: employeename3,
                                JOBNO: document.getElementById("txt_copydiagramjobnosunday").value,
                                DATEINPUT: dateinput,
                                DATEPRESENT: datepresent,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn,
                                VEHICLETYPE: vehicletype,
                                MATERIALTYPE: materialtype,
                                GORETURN: goreturn,
                                PRICETYPE: pricetype,
                                LOAD: load,
                                ROUTE: route,
                                UNIT: copydiagramunit

                            },
                            success: function () {


                            }
                        });
                    }
                    alert('บันทึกข้อมูลเรียบร้อย');




                    window.location.reload();
                }
            }
            function save_copyjob() {

                var JOBNO = document.getElementById("txt_jobno").value;
                //RKS-190701-000-091
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "save_copyjobvehicletransportplan", JOBNO: JOBNO, ROWSAMOUNT: document.getElementById("txt_rowsamount").value
                    },
                    success: function (rs) {
                        alert(rs);
                        window.location.reload();
                    }
                });



            }
            function select_copyjob(jobno, jobstrat, jobend, startdate) {
                document.getElementById("title_copyjob").innerHTML = '<b>Copy Job เส้นทาง : ' + jobstrat + '-' + jobend + '</b>';
                document.getElementById("txt_startdatejobcopy").value = startdate;
                document.getElementById("txt_jobno").value = jobno;
            }

            function select_vehicletransportplanid(vehicletransportplanid, jobstrat, jobend) {

                $(document).ready(function () {

                    document.getElementById("title").innerHTML = '<b>เส้นทาง : ' + jobstrat + '-' + jobend + '</b>';
                    document.getElementById("txt_vehicletransportplanid").value = vehicletransportplanid;
                    document.getElementById("txt_route").value = jobstrat + '-' + jobend;
                });
                showupdate_vehicletransportdocument(vehicletransportplanid);
                showupdate_vehicletransportactual(vehicletransportplanid);
            }

        </script>
        <script>
            $('#exampleModal').on('show', function () {
            })
        </script>
        <script language="JavaScript">
            document.onkeyup = function (e) {
                if (e.ctrlKey && e.which == 67) {

                }
            };
        </script>

        <script>

            function change_textboxdate()
            {

                if (chk_copydiagramdatevlin.checked == true) {
                    document.getElementById("txt_copydiagramdatevlin2").style.display = '';
                    document.getElementById("txt_copydiagramdatevlin").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdatevlin2").style.display = 'none';
                    document.getElementById("txt_copydiagramdatevlin").style.display = '';
                }
                if (chk_copydiagramdatevlout.checked == true) {
                    document.getElementById("txt_copydiagramdatevlout2").style.display = '';
                    document.getElementById("txt_copydiagramdatevlout").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdatevlout2").style.display = 'none';
                    document.getElementById("txt_copydiagramdatevlout").style.display = '';
                }
                if (chk_copydiagramdatedealerin.checked == true) {

                    document.getElementById("txt_copydiagramdatedealerin2").style.display = '';
                    document.getElementById("txt_copydiagramdatedealerin").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdatedealerin2").style.display = 'none';
                    document.getElementById("txt_copydiagramdatedealerin").style.display = '';
                }
                if (chk_copydiagramdatereturn.checked == true) {
                    document.getElementById("txt_copydiagramdatereturn2").style.display = '';
                    document.getElementById("txt_copydiagramdatereturn").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdatereturn2").style.display = 'none';
                    document.getElementById("txt_copydiagramdatereturn").style.display = '';
                }
            }
            function show_timepresentupd(data)
            {
                if (chk_copydiagramdatevlinupd.checked == true) {
                    var rs = (parseInt(data.substr(11, 2)) - 1) + data.substr(13, 5);
                    document.getElementById("txt_copydiagramdatepresentupd").value = rs;
                } else
                {
                    var rs = parseInt(data.substring(0, 2)) - 1;
                    rs = rs + data.substring(2, 5);
                    document.getElementById("txt_copydiagramdatepresentupd").value = rs;
                }
            }
            function show_timepresent(data)
            {
                if (chk_copydiagramdatevlin.checked == true) {

                    if (data.substr(11, 2) == '00')
                    {
                        var rs = '23' + data.substr(13, 5);
                        document.getElementById("txt_copydiagramdatepresent").value = rs;
                    } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                    {
                        var rs = parseInt(data.substr(11, 2)) - 1;
                        rs = rs + data.substr(13, 5);
                        document.getElementById("txt_copydiagramdatepresent").value = rs;
                    } else
                    {
                        var rs = parseInt(data.substr(11, 2)) - 1;
                        rs = rs + data.substr(13, 5);
                        document.getElementById("txt_copydiagramdatepresent").value = rs;
                    }

                } else
                {

                    if ('<?= $_GET['companycode'] ?>' == 'RKS' || '<?= $_GET['companycode'] ?>' == 'RRC' || '<?= $_GET['companycode'] ?>' == 'RKR' || '<?= $_GET['companycode'] ?>' == 'RKL')
                    {

                        if (data.substring(0, 2) == '00')
                        {
                            var rs = '23' + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresent").value = rs;
                        } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                        {
                            var rs = parseInt(data.substring(0, 2)) - 1;
                            rs = rs + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresent").value = rs;
                        } else
                        {
                            var rs = parseInt(data.substring(0, 2)) - 1;
                            rs = rs + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresent").value = rs;
                        }

                    } else if ('<?= $_GET['companycode'] ?>' == 'RCC' || '<?= $_GET['companycode'] ?>' == 'RATC')
                    {

                        if (<?= $_GET['pricetype'] ?> == '2')
                        {
                            if (data.substring(0, 2) == '00')
                            {
                                var rs = '23' + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent").value = rs;
                            } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                            {
                                var rs = parseInt(data.substring(0, 2)) - 1;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent").value = rs;
                            } else
                            {
                                var rs = parseInt(data.substring(0, 2)) - 1;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent").value = rs;
                            }
                        } else
                        {
                            if (document.getElementById("txt_copydiagramjobstart").value == "GW")
                            {
                                if (data.substring(0, 2) == '00')
                                {
                                    var rs = '23' + data.substring(2, 5);
                                    document.getElementById("txt_copydiagramdatepresent").value = rs;
                                } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                                {
                                    var rs = parseInt(data.substring(0, 2)) - 1;
                                    rs = rs + data.substring(2, 5);
                                    document.getElementById("txt_copydiagramdatepresent").value = rs;
                                } else
                                {
                                    var rs = parseInt(data.substring(0, 2)) - 1;
                                    rs = rs + data.substring(2, 5);
                                    document.getElementById("txt_copydiagramdatepresent").value = rs;
                                }
                            } else if (document.getElementById("txt_copydiagramjobstart").value == "BP")
                            {
                                if (data.substring(0, 2) == '00')
                                {
                                    var rs = '23' + data.substring(2, 5);
                                    document.getElementById("txt_copydiagramdatepresent").value = rs;
                                } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                                {
                                    var rs = parseInt(data.substring(0, 2)) - 1;
                                    rs = rs + data.substring(2, 5);
                                    document.getElementById("txt_copydiagramdatepresent").value = rs;
                                } else
                                {
                                    var rs = parseInt(data.substring(0, 2)) - 1;
                                    rs = rs + data.substring(2, 5);
                                    document.getElementById("txt_copydiagramdatepresent").value = rs;
                                }
                            } else if (document.getElementById("txt_copydiagramjobstart").value == "SR")
                            {

                                if (data.substring(0, 2) == '00')
                                {
                                    var rs = '23' + data.substring(2, 5);
                                    document.getElementById("txt_copydiagramdatepresent").value = rs;
                                } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                                {
                                    var rs = parseInt(data.substring(0, 2)) - 1;
                                    rs = rs + data.substring(2, 5);
                                    document.getElementById("txt_copydiagramdatepresent").value = rs;
                                } else
                                {
                                    var rs = parseInt(data.substring(0, 2)) - 1;
                                    rs = rs + data.substring(2, 5);
                                    document.getElementById("txt_copydiagramdatepresent").value = rs;
                                }
                            } else
                            {
                                if ('<?= $_GET['companycode'] ?>' != 'RRC')
                                {
                                    var rs = parseInt(data.substring(0, 2)) - document.getElementById("txt_beforpersentoth").value;
                                    rs = rs + data.substring(2, 5);
                                    document.getElementById("txt_copydiagramdatepresent").value = rs;
                                } else
                                {
                                    if (data.substring(0, 2) == '00')
                                    {
                                        var rs = '23' + data.substring(2, 5);
                                        document.getElementById("txt_copydiagramdatepresent").value = rs;
                                    } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                                    {
                                        var rs = parseInt(data.substring(0, 2)) - 1;
                                        rs = rs + data.substring(2, 5);
                                        document.getElementById("txt_copydiagramdatepresent").value = rs;
                                    } else
                                    {
                                        var rs = parseInt(data.substring(0, 2)) - 1;
                                        rs = rs + data.substring(2, 5);
                                        document.getElementById("txt_copydiagramdatepresent").value = rs;
                                    }
                                }

                            }
                        }
                    }
                }
            }
        </script>

    </body>


</html>
<?php
sqlsrv_close($conn);
?>
