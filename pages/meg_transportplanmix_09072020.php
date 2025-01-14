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

$condiPlan1 = " AND a.VEHICLETRANSPORTPLANID ='" . $_GET['vehicletransportplanid'] . "'";
$sql_sePlan1 = "{call megVehicletransportplan_v2(?,?,?,?)}";
$params_sePlan1 = array(
    array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
    array($condiPlan1, SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_sePlan1 = sqlsrv_query($conn, $sql_sePlan1, $params_sePlan1);
$result_sePlan1 = sqlsrv_fetch_array($query_sePlan1, SQLSRV_FETCH_ASSOC);


$sql_seConfrimskbs = "SELECT CONFRIMSKBID FROM CONFRIMSKB WHERE VEHICLETRANSPORTPLANID = '" . $_GET['vehicletransportplanid'] . "'";
$params_seConfrimskbs = array();
$query_seConfrimskbs = sqlsrv_query($conn, $sql_seConfrimskbs, $params_seConfrimskbs);
$result_seConfrimskbs = sqlsrv_fetch_array($query_seConfrimskbs, SQLSRV_FETCH_ASSOC);
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
        <link href="../dist/css/select2.min.css" rel="stylesheet">
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

        <div id="wrapper">

            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <?php
                include '../pages/meg_header.php';
                //include '../pages/meg_leftmenu.php';
                ?>
            </nav>



            <div class="modal fade" id="modal_copydiagramupdrcc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="width: 80%">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="row">
                                <div class="col-lg-5">
                                    <h5 class="modal-title" id="title_copydiagram"><b>Update Diagram(RCC)</b></h5>
                                </div>

                            </div>
                        </div>
                        <div class="modal-body">

                            <?php
                            $sql_seWorktype = "SELECT b.VEHICLETRANSPORTPRICEID,a.JOBSTART,a.JOBEND,a.WORKTYPE,b.CARRYTYPE
                      FROM dbo.VEHICLETRANSPORTPLAN a
                      INNER JOIN [dbo].[VEHICLETRANSPORTPRICE] b ON a.[VEHICLETRANSPORTPRICEID] = b.[VEHICLETRANSPORTPRICEID]
                      WHERE a.VEHICLETRANSPORTPLANID ='" . $_GET['vehicletransportplanid'] . "'";
                            $params_seWorktype = array();
                            $query_seWorktype = sqlsrv_query($conn, $sql_seWorktype, $params_seWorktype);
                            $result_seWorktype = sqlsrv_fetch_array($query_seWorktype, SQLSRV_FETCH_ASSOC);
                            ?>
                            <input class="form-control" style="display:none"     id="txt_copydiagramroutesh" name="txt_copydiagramroutesh" maxlength="500" value="" >
                            <input class="form-control" style="display:none"     id="txt_copydiagramsubroutesh" name="txt_copydiagramsubroutesh" maxlength="500" value="" >
                            <input class="form-control" style="display:none"     id="txt_copydiagramrouteshn" name="txt_copydiagramrouteshn" maxlength="500" value="" >
                            <input class="form-control" style="display:none"     id="txt_copydiagramsubrouteshn" name="txt_copydiagramsubrouteshn" maxlength="500" value="" >
                            <div class="well">
                                <div class="modal-header">
                                    <label>แก้ไขการวิ่งงาน ประเภทงาน (<?= $result_seWorktype['WORKTYPE'] ?>)</label>
                                </div>
                                <div class="modal-body" >
                                    <div class="row">

                                        <div class="col-lg-3">
                                            <label>พนักงาน (1) :</label>
                                            <input class="form-control" style="display: none"   id="txt_copydiagramroute" name="txt_copydiagramroute" maxlength="500" value="" >
                                            <input class="form-control" style="display: none"  id="txt_copydiagramsubroute" name="txt_copydiagramsubroute" maxlength="500" value="" >
                                            <input type="text"   name="txt_copydiagramemployeenameupd1" id="txt_copydiagramemployeenameupd1" class="form-control">

                                        </div>

                                        <div class="col-lg-3">
                                            <label>พนักงาน (2) :</label>
                                            <input type="text"   class="form-control" name="txt_copydiagramemployeenameupd2" id="txt_copydiagramemployeenameupd2">
                                        </div>
                                    </div>
                                    <div class="row">




                                        <div class="col-lg-3">
                                            <label>ชื่อรถ :</label>
                                            <input type="text"  class="form-control"  id="txt_copydiagramthainameupd" name="txt_copydiagramthainameupd">
                                        </div>
<?php
if ($result_sePlan1['WORKTYPE'] == "nm") {
    ?>
                                            <div class="col-lg-3">
                                                <label>ต้นทาง(Normal) :</label>
                                                <select multiple="multiple"  id="txt_copydiagramjobstartupd" name="txt_copydiagramjobstartupd" style="width: 100%">
                                                    <option value="">เลือกต้นทาง55</option>
                                                    <option value="GW">GW</option>
                                                    <option value="BP">BP</option>
                                                    <option value="BP25">BP-25</option>
                                                    <option value="SR">SR</option>
                                                    <option value="TAC">TAC</option>
                                                    <option value="OTH">OTH</option>
                                                    <option value="SW">SW</option>
                                                    <option value="SP">SP</option>
                                                    <option value="BP25RAI">BP25RAI</option>
                                                </select>


                                            </div>
                                            <div class="col-lg-3">
                                                <label>CLUSTER(Normal) :</label>

                                                <div class="dropdown bootstrap-select show-tick form-control">

                                                    <select multiple="" onchange="select_cluster()" id="cb_copydiagramcluster" name="cb_copydiagramcluster" class="selectpicker form-control" id="number-multiple" data-container="body" data-live-search="true" title="เลือก cluster..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98">
    <?php
    $conselect_cluster1 = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "'";
    $sql_seCluster = "{call megVehicletransportprice_v2(?,?,?,?)}";
    $params_seCluster = array(
        array('select_cluster', SQLSRV_PARAM_IN),
        array($conselect_cluster1, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query_seCluster = sqlsrv_query($conn, $sql_seCluster, $params_seCluster);
    while ($result_seCluster = sqlsrv_fetch_array($query_seCluster, SQLSRV_FETCH_ASSOC)) {
        ?>
                                                            <option  value="<?= $result_seCluster['CLUSTER'] ?>" ><?= $result_seCluster['CLUSTER'] ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <input class="form-control" style="display:none"  id="txt_copydiagramcluster" name="txt_copydiagramcluster" maxlength="500" value="" >
                                                    <input class="form-control" style="display:none"  id="txt_companycodenm" name="txt_companycodenm" maxlength="500" value="<?= $_GET['companycode'] ?>" >
                                                    <input class="form-control" style="display:none"  id="txt_customercodenm" name="txt_customercodenm" maxlength="500" value="<?= $_GET['customercode'] ?>" >

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
                                            <div class="col-lg-3">

                                                <label>ปลายทาง(Normal) :</label>
                                                <div id="data_copydiagramjobenddef">

                                                    <div class="dropdown bootstrap-select show-tick form-control">

                                                        <select multiple="" id="cb_copydiagramjobend" name="cb_copydiagramjobend" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก ปลายทาง..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98">
    <?php
    $conTo1 = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "'";
    $sql_seTo = "{call megVehicletransportprice_v2(?,?,?,?)}";
    $params_seTo = array(
        array('select_names', SQLSRV_PARAM_IN),
        array($condiJobend, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query_seTo = sqlsrv_query($conn, $sql_seTo, $params_seTo);
    while ($result_seTo = sqlsrv_fetch_array($query_seTo, SQLSRV_FETCH_ASSOC)) {
        $selected = "";
        if ($result_sePlan1['JOBEND'] == $result_seTo['FROM']) {
            $selected = "selected";
        }
        ?>
                                                                <option value="<?= $result_seTo['FROM'] ?>" <?= $selected ?>><?= $result_seTo['FROM'] ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <input class="form-control" style="display:none"  id="txt_copydiagramjobend" name="txt_copydiagramjobend" maxlength="500" value="" >


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

    <?php
} else if ($result_sePlan1['WORKTYPE'] == "sh") {
    ?>
                                            <div class="col-lg-3">
                                                <label>ต้นทางSH :</label><br>
                                                <select  id="cb_copydiagramjobstartsh" name="cb_copydiagramjobstartsh" class="form-control" onchange="se_copydiagramroutesh(this.value)">
                                                    <option value="">เลือกต้นทาง</option>
                                                    <option value="GW">GW</option>
                                                    <option value="BP">BP</option>
                                                    <option value="BP25RAI">BP-25RAI</option>
                                                    <option value="SR">SR</option>
                                                    <option value="TAC">TAC</option>
                                                    <option value="OTH">OTH</option>
                                                    <option value="SW">SW</option>
                                                    <option value="SP">SP</option>
                                                </select>
                                                <input class="form-control" style="display:none"  id="txt_worktypesh" name="txt_worktypesh" maxlength="500" value="<?= $result_sePlan1['WORKTYPE'] ?>">
                                                <input class="form-control" style="display:none"  id="txt_companycodesh" name="txt_companycodesh" maxlength="500" value="<?= $_GET['companycode'] ?>">
                                                <input class="form-control" style="display:none"  id="txt_customercodesh" name="txt_customercodesh" maxlength="500" value="<?= $_GET['customercode'] ?>">
                                            </div>

                                            <div class="col-lg-2">
                                                <label>งานSH :</label><br>
                                                <div id="copydiagramroutedefsh">
                                                    <select  id="cb_copydiagramroutesh" name="cb_copydiagramroutesh" class="form-control" >
                                                        <option value="">เลือกงาน</option>
                                                    </select>
                                                    <input class="form-control" style="display:none"  id="txt_copydiagramcluster" name="txt_copydiagramcluster" maxlength="500" value="" >
                                                </div>
                                                <div id="copydiagramroutesrsh"></div>
                                            </div>


                                            <div class="col-lg-2">
                                                <label>งาน(ย่อย)SH :</label><br>
                                                <div id="copydiagramsubroutedefsh">
                                                    <select  id="cb_copydiagramsubroutesh" name="cb_copydiagramsubroutesh" class="form-control" onchange="se_copydiagramsubroutesh(this.value)" >
                                                        <option value="">เลือกงาน(ย่อย)</option>
                                                    </select>
                                                </div>
                                                <div id="copydiagramsubroutesrsh"></div>

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
} else if ($result_seWorktype['WORKTYPE'] == "sh(n)") {
    ?>
                                            <div class="col-lg-3">
                                                <label>ต้นทาง(SH(N)) :</label><br>
                                                <select  id="cb_copydiagramjobstartshn" name="cb_copydiagramjobstartshn" class="form-control" onchange="se_copydiagramrouteshn(this.value)">
                                                    <option value="">เลือกต้นทาง</option>
                                                    <option value="GW">GW</option>
                                                    <option value="BP">BP</option>
                                                    <option value="SR">SR</option>
                                                </select>
                                                <input class="form-control" style="display:none"  id="txt_worktypeshn" name="txt_worktypeshn" maxlength="500" value="<?= $result_seWorktype['WORKTYPE'] ?>">
                                                <input class="form-control" style="display:none"  id="txt_companycodeshn" name="txt_companycodeshn" maxlength="500" value="<?= $_GET['companycode'] ?>">
                                                <input class="form-control" style="display:none"  id="txt_customercodeshn" name="txt_customercodeshn" maxlength="500" value="<?= $_GET['customercode'] ?>">
                                            </div>

                                            <div class="col-lg-2">
                                                <label>งาน(SH(N)) :</label><br>
                                                <div id="copydiagramroutedefshn">
                                                    <select  id="cb_copydiagramrouteshn" name="cb_copydiagramrouteshn" class="form-control" >
                                                        <option value="">เลือกงาน</option>
                                                    </select>

                                                </div>
                                                <div id="copydiagramroutesrshn"></div>
                                            </div>


                                            <div class="col-lg-2">
                                                <label>งานย่อย(SH(N)) :</label><br>
                                                <div id="copydiagramsubroutedefshn">
                                                    <select  id="cb_copydiagramsubrouteshn" name="cb_copydiagramsubrouteshn" class="form-control" onchange="se_copydiagramsubroutesh(this.value)" >
                                                        <option value="">เลือกงาน(ย่อย)</option>
                                                    </select>
                                                </div>
                                                <div id="copydiagramsubroutesrshn"></div>

                                            </div>

                                            <div class="col-lg-2">
                                                <label>จำนวนโหลด(SH(N)) :</label><br>
                                                <select  id="cb_copydiagramloadshn" name="cb_copydiagramloadshn" class="form-control">
                                                    <option value="">เลือกจำนวนโหลด</option>
                                                    <option value="4">4 Load</option>
                                                    <option value="8">8 Load</option>

                                                </select>
                                            </div>

    <?php
} else {
    ?>


    <?php
}
?>



                                    </div>
                                    <div class="row">&nbsp;</div>
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <label>เวลาเริ่มงาน  </label>
                                            <input type="text" value="<?= $result_sePlan1['TIMERK'] ?>" readonly="" class="form-control datetimeen" id="txt_copydiagramdaterkupd" name="txt_copydiagramdaterkupd" onchange="show_timepresentupd(this.value)" >

                                        </div>
                                        <div class="col-lg-2">
                                            <label>เวลาเข้าวีแอล  </label>
                                            <input type="text" value="<?= $result_sePlan1['TIMEVLIN'] ?>" readonly="" class="form-control datetimeen" id="txt_copydiagramdatevlinupd" name="txt_copydiagramdatevlinupd"  >

                                        </div>
                                        <div class="col-lg-2">
                                            <label>เวลาออกวีแอล </label>
                                            <input type="text" value="<?= $result_sePlan1['TIMEVLOUT'] ?>" readonly="" class="form-control datetimeen" id="txt_copydiagramdatevloutupd" name="txt_copydiagramdatevloutupd" >

                                        </div>
                                        <div class="col-lg-2">
                                            <label>เวลาเข้าดีลเลอร์ </label>
                                            <input type="text" value="<?= $result_sePlan1['TIMEDEALERIN'] ?>" readonly="" class="form-control datetimeen" id="txt_copydiagramdatedealerinupd" name="txt_copydiagramdatedealerinupd" >

                                        </div>
                                        <div class="col-lg-2">
                                            <label>เวลากลับบริษัท </label>
                                            <input type="text" value="<?= $result_sePlan1['TIMERETURN'] ?>" readonly="" class="form-control datetimeen" id="txt_copydiagramdatereturnupd" name="txt_copydiagramdatereturnupd" >

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--<?php
                                        //if ($result_sePlan1['WORKTYPE'] != "sh") {
?>
                            <div class="well">
                            <div class="modal-header">
                            <label>งาน SH</label>
                          </div>
                          <div class="modal-body" >

                          <div class="row">
                          <div class="col-lg-3">
                          <label>ต้นทาง :</label><br>
                          <select  id="cb_copydiagramjobstartsh" name="cb_copydiagramjobstartsh" class="form-control" onchange="se_copydiagramroutesh(this.value)">
                          <option value="">เลือกต้นทาง</option>

                          <option value="GW">GW</option>
                          <option value="BP">BP</option>
                          <option value="SR">SR</option>
                          <option value="TAC">TAC</option>
                          <option value="OTH">OTH</option>



                        </select>
                      </div>

                      <div class="col-lg-3">
                      <label>งาน :</label><br>
                      <div id="copydiagramroutedefsh">
                      <select  id="cb_copydiagramroutesh" name="cb_copydiagramroutesh" class="form-control" >

                      <option value="">เลือกงาน</option>
                    </select>


                  </div>
                  <div id="copydiagramroutesrsh"></div>

                </div>


                <div class="col-lg-3">
                <label>งาน(ย่อย) :</label><br>
                <div id="copydiagramsubroutedefsh">
                <select  id="cb_copydiagramsubroutesh" name="cb_copydiagramsubroutesh" class="form-control" >
                <option value="">เลือกงาน(ย่อย)</option>
              </select>
            </div>
            <div id="copydiagramsubroutesrsh"></div>

            </div>

            <div class="col-lg-3">
            <label>จำนวนโหลด :</label><br>
            <select  id="cb_copydiagramloadsh" name="cb_copydiagramloadsh" class="form-control">
            <option value="">เลือกจำนวนโหลด</option>
            <option value="4">4 Load</option>
            <option value="8">8 Load</option>

            </select>
            </div>
            </div>
            </div>
            </div>
<?php
//}
?>-->

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                            <button type="button" class="btn btn-primary" onclick="save_copydiagram()">บันทึก</button>
                        </div>
                    </div>
                </div>
            </div>


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



                        <div id="modalcopydiagramupdrrc"></div>




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



                        <div id="modalcopydiagramupdrks"></div>




                    </div>
                </div>
            </div>
            <div class="modal fade" id="modal_copydiagramupdrkr" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="width: 80%">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="row">
                                <div class="col-lg-5">
                                    <h5 class="modal-title" id="title_copydiagram"><b>Update Diagram</b></h5>
                                </div>

                            </div>
                        </div>



                        <div id="modalcopydiagramupdrkr"></div>




                    </div>
                </div>
            </div>
            <div class="modal fade" id="modal_copydiagramupdrkrw" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="width: 80%">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="row">
                                <div class="col-lg-5">
                                    <h5 class="modal-title" id="title_copydiagram"><b>Update Diagram</b></h5>
                                </div>

                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">

                                <div class="col-lg-3">
                                    <label>พนักงาน (1) :</label>
                                    <input onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'EMPLOYEENAME1', this.value)" type="text"   name="txt_copydiagramemployeenameupdrkrton1" id="txt_copydiagramemployeenameupdrkrton1" class="form-control" value="<?= $result_sePlan1['EMPLOYEENAME1'] ?>">

                                </div>

                                <div class="col-lg-3">
                                    <label>พนักงาน (2) :</label>
                                    <input onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'EMPLOYEENAME2', this.value)" type="text"   class="form-control" name="txt_copydiagramemployeenameupdrkrton2" id="txt_copydiagramemployeenameupdrkrton2" value="<?= $result_sePlan1['EMPLOYEENAME2'] ?>">
                                </div>
                                <div class="col-lg-3">
                                    <label>ชื่อรถ :</label>
                                    <input onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'THAINAME', this.value)" type="text"  class="form-control"  id="txt_copydiagramthainameupdrkrton" name="txt_copydiagramthainameupdrkrton" value="<?= $result_sePlan1['THAINAME'] ?>">
                                </div>




                            </div>
                            <div class="row">
<?php
if ($_GET['customercode'] == 'TTASTSTC' || $_GET['customercode'] == 'TTASTCS' || $_GET['customercode'] == 'TTPROSTC' || $_GET['customercode'] == 'TTPROCS' || $_GET['customercode'] == 'DAIKI') {
    ?>
                                    <div class="col-lg-3">
                                        <label>ประเภทรถ :</label>
                                        <select id="cb_copydiagramcartyperkrton" name="cb_copydiagramcartyperkrton" class="form-control" onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'VEHICLETYPE', this.value)">
                                            <option value="">เลือก ประเภทรถ</option>
    <?php
    $conVehicletype1 = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "'";
    $sql_seVehicletype = "{call megVehicletransportprice_v2(?,?,?,?)}";
    $params_seVehicletype = array(
        array('select_vehicletype', SQLSRV_PARAM_IN),
        array($conVehicletype1, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query_seVehicletype = sqlsrv_query($conn, $sql_seVehicletype, $params_seVehicletype);
    while ($result_seVehicletype = sqlsrv_fetch_array($query_seVehicletype, SQLSRV_FETCH_ASSOC)) {
        $selected = "";
        if ($result_sePlan1['VEHICLETYPE'] == $result_seVehicletype['VEHICLETYPE']) {
            $selected = "selected";
        }
        ?>
                                                <option value="<?= $result_seVehicletype['VEHICLETYPE'] ?>" <?= $selected ?>><?= $result_seVehicletype['VEHICLETYPE'] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label>ต้นทาง :</label>
                                        <select id="cb_copydiagramjobstartrkrton" name="cb_copydiagramjobstartrkrton" class="form-control" onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'JOBSTART', this.value)">
                                            <option value="">เลือก ต้นทาง</option>
    <?php
    $conFrom1 = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "'";
    $sql_seFrom = "{call megVehicletransportprice_v2(?,?,?,?)}";
    $params_seFrom = array(
        array('select_from', SQLSRV_PARAM_IN),
        array($conFrom1, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query_seFrom = sqlsrv_query($conn, $sql_seFrom, $params_seFrom);
    while ($result_seFrom = sqlsrv_fetch_array($query_seFrom, SQLSRV_FETCH_ASSOC)) {
        $selected = "";
        if ($result_sePlan1['JOBSTART'] == $result_seFrom['FROM']) {
            $selected = "selected";
        }
        ?>
                                                <option value="<?= $result_seFrom['FROM'] ?>" <?= $selected ?>><?= $result_seFrom['FROM'] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">

                                        <label>โซน :</label>
                                        <select multiple="multiple" onchange="select_zone('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'CLUSTER', this.value)" id="cb_copydiagramzonerkrton" name="cb_copydiagramzonerkrton" style="width: 100%">
    <?php
    $condiLocation1 = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "'";
    $sql_seLocation = "{call megVehicletransportprice_v2(?,?,?,?)}";
    $params_seLocation = array(
        array('select_location', SQLSRV_PARAM_IN),
        array($condiLocation1, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query_seLocation = sqlsrv_query($conn, $sql_seLocation, $params_seLocation);
    while ($result_seLocation = sqlsrv_fetch_array($query_seLocation, SQLSRV_FETCH_ASSOC)) {
        ?>
                                                <option value="<?= $result_seLocation['LOCATION'] ?>" ><?= $result_seLocation['LOCATION'] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>

                                    </div>
                                    <div class="col-lg-3">

                                        <label>ปลายทาง :</label>
                                        <div id="data_copydiagramjobendtondef">
                                            <div class="dropdown bootstrap-select show-tick form-control">

                                                <select multiple="" id="cb_copydiagramjobendrkrton" name="cb_copydiagramjobendrkrton" class="selectpicker form-control" onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'LOCATION', this.value)" id="number-multiple" data-container="body" data-live-search="true" title="เลือก ปลายทาง..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >

                                                </select>
                                                <input class="form-control" style="display: none"   id="txt_copydiagramjobendton" name="txt_copydiagramjobendton" maxlength="500" value="" >


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
                                        <div id="data_copydiagramjobendtonsr"></div>
                                    </div>

    <?php
}
?>
                            </div>

                            <div class="row">&nbsp;</div>
                            <div class="row">
                                <div class="col-lg-2">
                                    <label>เวลารายงานตัว  </label>
                                    <input type="text"  readonly="" disabled="" class="form-control " id="txt_copydiagramdateinputupdrkr" name="txt_copydiagramdateinputupdrkr" value="<?= $result_sePlan1['DATEINPUT111'] ?>">

                                </div>
                                <div class="col-lg-2">
                                    <label>เวลาเริ่มงาน  </label>
                                    <input type="text" onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'DATERK', this.value)" value="<?= $result_sePlan1['DATERK111'] ?>" readonly="" class="form-control datetimeen" id="txt_copydiagramdatevlinupdrkr" name="txt_copydiagramdaterkupdrkr"  >

                                </div>
                                <div class="col-lg-2">
                                    <label>เวลาเข้า(ลูกค้า)  </label>
                                    <input type="text" onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'DATEVLIN', this.value)" value="<?= $result_sePlan1['DATEVLIN111'] ?>" readonly="" class="form-control datetimeen" id="txt_copydiagramdatevlinupdrkr" name="txt_copydiagramdatevlinupdrkr"  >

                                </div>
                                <div class="col-lg-2">
                                    <label>เวลาออก(ลูกค้า) </label>
                                    <input type="text" onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'DATEVLOUT', this.value)" value="<?= $result_sePlan1['DATEVLOUT111'] ?>" readonly="" class="form-control datetimeen" id="txt_copydiagramdatevloutupdrkr" name="txt_copydiagramdatevloutupdrkr" >

                                </div>
                                <div class="col-lg-2">
                                    <label>เวลาเข้า(ลูกค้า2) </label>
                                    <input type="text" onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'DATEDEALERIN', this.value)" value="<?= $result_sePlan1['DATEDEALERIN111'] ?>" readonly="" class="form-control datetimeen" id="txt_copydiagramdatedealerinupdrkr" name="txt_copydiagramdatedealerinupdrkr" >

                                </div>
                                <div class="col-lg-2">
                                    <label>เวลากลับบริษัท </label>
                                    <input type="text" onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'DATERETURN', this.value)" value="<?= $result_sePlan1['DATERETURN111'] ?>" readonly="" class="form-control datetimeen" id="txt_copydiagramdatereturnupdrkr" name="txt_copydiagramdatereturnupdrkr" >

                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                            <button type="button" class="btn btn-primary" onclick="reload()">บันทึก</button>
                        </div>





                    </div>
                </div>
            </div>
            <div class="modal fade" id="modal_copydiagramupdrklskb" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="width: 80%">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="row">
                                <div class="col-lg-5">
                                    <h5 class="modal-title" id="title_copydiagram"><b>Update Diagram</b></h5>
                                </div>

                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">

                                <div class="col-lg-3">
                                    <label>พนักงาน (1) :</label>
                                    <input onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'EMPLOYEENAME1', this.value)" type="text"   name="txt_copydiagramemployeenameupdrkl1" id="txt_copydiagramemployeenameupdrkl1" class="form-control" value="<?= $result_sePlan1['EMPLOYEENAME1'] ?>">

                                </div>

                                <div class="col-lg-3">
                                    <label>พนักงาน (2) :</label>
                                    <input onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'EMPLOYEENAME2', this.value)" type="text"   class="form-control" name="txt_copydiagramemployeenameupdrkl2" id="txt_copydiagramemployeenameupdrkl2" value="<?= $result_sePlan1['EMPLOYEENAME2'] ?>">
                                </div>
                                <div class="col-lg-3">
                                    <label>ชื่อรถ :</label>
                                    <input onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'THAINAME', this.value)" type="text"  class="form-control"  id="txt_copydiagramthainameupdrkl" name="txt_copydiagramthainameupdrkl" value="<?= $result_sePlan1['THAINAME'] ?>">
                                </div>




                            </div>
                            <div class="row">
<?php
$condiConfrimskb = " AND VEHICLETRANSPORTPLANID ='" . $_GET['vehicletransportplanid'] . "'";
$sql_seConfrimskb = "{call megConfrimskb_v2(?,?)}";
$params_seConfrimskb = array(
    array('select_vehicletransportplanconfrimskb', SQLSRV_PARAM_IN),
    array($condiConfrimskb, SQLSRV_PARAM_IN)
);
$query_seConfrimskb = sqlsrv_query($conn, $sql_seConfrimskb, $params_seConfrimskb);
$result_seConfrimskb = sqlsrv_fetch_array($query_seConfrimskb, SQLSRV_FETCH_ASSOC);
?>
                                <div class="col-lg-3">
                                    <label>ประเภทรถ :</label>
                                    <select id="cb_copydiagramcartyperkrton" name="cb_copydiagramcartyperkrton" class="form-control" onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'VEHICLETYPE', this.value)">
                                        <option value="">เลือก ประเภทรถ</option>
<?php
$conVehicletype1 = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "'";
$sql_seVehicletype = "{call megVehicletransportprice_v2(?,?,?,?)}";
$params_seVehicletype = array(
    array('select_vehicletype', SQLSRV_PARAM_IN),
    array($conVehicletype1, SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seVehicletype = sqlsrv_query($conn, $sql_seVehicletype, $params_seVehicletype);
while ($result_seVehicletype = sqlsrv_fetch_array($query_seVehicletype, SQLSRV_FETCH_ASSOC)) {
    $selected = "";
    if ($result_sePlan1['VEHICLETYPE'] == $result_seVehicletype['VEHICLETYPE']) {
        $selected = "selected";
    }
    ?>
                                            <option value="<?= $result_seVehicletype['VEHICLETYPE'] ?>" <?= $selected ?>><?= $result_seVehicletype['VEHICLETYPE'] ?></option>
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
$condiFrom1 = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "'";
$sql_seFrom = "{call megVehicletransportprice_v2(?,?,?,?)}";
$params_seFrom = array(
    array('select_from', SQLSRV_PARAM_IN),
    array($condiFrom1, SQLSRV_PARAM_IN),
    array("", SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seFrom = sqlsrv_query($conn, $sql_seFrom, $params_seFrom);
while ($result_seFrom = sqlsrv_fetch_array($query_seFrom, SQLSRV_FETCH_ASSOC)) {
    $selected = "";
    if ($result_sePlan1['JOBSTART'] == $result_seFrom['FROM']) {
        $selected = "selected";
    }
    ?>
                                            <option value="<?= $result_seFrom['FROM'] ?>" <?= $selected ?>><?= $result_seFrom['FROM'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-3">

                                    <label>โซน :</label>

                                    <select multiple="" onchange="select_zoneskb('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'CLUSTER', this.value)" id="cb_copydiagramzoneskb" name="cb_copydiagramzoneskb" class=" form-control" style="width: 100%">
<?php
$condiZone1 = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "'";
$sql_seZone = "{call megVehicletransportprice_v2(?,?,?,?)}";
$params_seZone = array(
    array('select_zone', SQLSRV_PARAM_IN),
    array($condiZone1, SQLSRV_PARAM_IN),
    array("", SQLSRV_PARAM_IN),
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
                                    <input class="form-control" style="display: none"   id="txt_copydiagramzoneskb" name="txt_copydiagramzoneskb" maxlength="500" value="" >


                                </div>
                                <div class="col-lg-3">

                                    <label>ปลายทาง :</label>
                                    <div id="data_copydiagramlocationdef">
                                        <div class="dropdown bootstrap-select show-tick form-control">

                                            <select multiple="" id="cb_copydiagramlocationskb" name="cb_copydiagramlocationskb" class="selectpicker form-control" id="number-multiple" data-container="body" data-live-search="true" title="เลือก ปลายทาง..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >

                                            </select>
                                            <input class="form-control" style="display: none"   id="txt_copydiagramjobendskb" name="txt_copydiagramjobendskb" maxlength="500" value="" >


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
                                    <div id="data_copydiagramlocationsr"></div>
                                </div>


                            </div>

                            <div class="row">&nbsp;</div>
                            <div class="row">
                                <div class="col-lg-2">
                                    <label>เวลารายงานตัว  </label>
                                    <input type="text"  readonly="" disabled="" class="form-control " id="txt_copydiagramdateinputupdrkr" name="txt_copydiagramdateinputupdrkr" value="<?= $result_sePlan1['DATEINPUT111'] ?>">

                                </div>
                                <div class="col-lg-2">
                                    <label>เวลาเริ่มงาน  </label>
                                    <input type="text" onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'DATERK', this.value)" value="<?= $result_sePlan1['DATERK111'] ?>" readonly="" class="form-control datetimeen" id="txt_copydiagramdatevlinupdrkr" name="txt_copydiagramdaterkupdrkr"  >

                                </div>
                                <div class="col-lg-2">
                                    <label>เวลาเข้า(ลูกค้า)  </label>
                                    <input type="text" onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'DATEVLIN', this.value)" value="<?= $result_sePlan1['DATEVLIN111'] ?>" readonly="" class="form-control datetimeen" id="txt_copydiagramdatevlinupdrkr" name="txt_copydiagramdatevlinupdrkr"  >

                                </div>
                                <div class="col-lg-2">
                                    <label>เวลาออก(ลูกค้า) </label>
                                    <input type="text" onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'DATEVLOUT', this.value)" value="<?= $result_sePlan1['DATEVLOUT111'] ?>" readonly="" class="form-control datetimeen" id="txt_copydiagramdatevloutupdrkr" name="txt_copydiagramdatevloutupdrkr" >

                                </div>
                                <div class="col-lg-2">
                                    <label>เวลาเข้า(ลูกค้า2) </label>
                                    <input type="text" onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'DATEDEALERIN', this.value)" value="<?= $result_sePlan1['DATEDEALERIN111'] ?>" readonly="" class="form-control datetimeen" id="txt_copydiagramdatedealerinupdrkr" name="txt_copydiagramdatedealerinupdrkr" >

                                </div>
                                <div class="col-lg-2">
                                    <label>เวลากลับบริษัท </label>
                                    <input type="text" onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'DATERETURN', this.value)" value="<?= $result_sePlan1['DATERETURN111'] ?>" readonly="" class="form-control datetimeen" id="txt_copydiagramdatereturnupdrkr" name="txt_copydiagramdatereturnupdrkr" >

                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                            <button type="button" class="btn btn-primary" onclick="update_planskb()">บันทึก</button>
                        </div>





                    </div>
                </div>
            </div>
            <div class="modal fade" id="modal_copydiagramupdrklw" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="width: 80%">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="row">
                                <div class="col-lg-5">
                                    <h5 class="modal-title" id="title_copydiagram"><b>Update Diagram</b></h5>
                                </div>

                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">

                                <div class="col-lg-3">
                                    <label>พนักงาน (1) :</label>
                                    <input onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'EMPLOYEENAME1', this.value)" type="text"   name="txt_copydiagramemployeenameupdrklton1" id="txt_copydiagramemployeenameupdrklton1" class="form-control" value="<?= $result_sePlan1['EMPLOYEENAME1'] ?>">

                                </div>

                                <div class="col-lg-3">
                                    <label>พนักงาน (2) :</label>
                                    <input onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'EMPLOYEENAME2', this.value)" type="text"   class="form-control" name="txt_copydiagramemployeenameupdrklton2" id="txt_copydiagramemployeenameupdrklton2" value="<?= $result_sePlan1['EMPLOYEENAME2'] ?>">
                                </div>
                                <div class="col-lg-3">
                                    <label>ชื่อรถ :</label>
                                    <input onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'THAINAME', this.value)" type="text"  class="form-control"  id="txt_copydiagramthainameupdrklton" name="txt_copydiagramthainameupdrklton" value="<?= $result_sePlan1['THAINAME'] ?>">
                                </div>




                            </div>
                            <div class="row">
<?php
if ($_GET['customercode'] == 'TTASTSTC' || $_GET['customercode'] == 'TTASTCS' || $_GET['customercode'] == 'TTPROSTC' || $_GET['customercode'] == 'TTPROCS' || $_GET['customercode'] == 'DAIKI' || $_GET['customercode'] == 'TTTCSTC' || $_GET['customercode'] == 'TTTCSTC') {
    ?>
                                    <div class="col-lg-3">
                                        <label>ประเภทรถ :</label>
                                        <select id="cb_copydiagramcartyperklton" name="cb_copydiagramcartyperklton" class="form-control" onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'VEHICLETYPE', this.value)">
                                            <option value="">เลือก ประเภทรถ</option>
    <?php
    $conVehicletype1 = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "'";
    $sql_seVehicletype = "{call megVehicletransportprice_v2(?,?,?,?)}";
    $params_seVehicletype = array(
        array('select_vehicletype', SQLSRV_PARAM_IN),
        array($conVehicletype1, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query_seVehicletype = sqlsrv_query($conn, $sql_seVehicletype, $params_seVehicletype);
    while ($result_seVehicletype = sqlsrv_fetch_array($query_seVehicletype, SQLSRV_FETCH_ASSOC)) {
        $selected = "";
        if ($result_sePlan1['VEHICLETYPE'] == $result_seVehicletype['VEHICLETYPE']) {
            $selected = "selected";
        }
        ?>
                                                <option value="<?= $result_seVehicletype['VEHICLETYPE'] ?>" <?= $selected ?>><?= $result_seVehicletype['VEHICLETYPE'] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label>ต้นทาง :</label>
                                        <select id="cb_copydiagramjobstartrklton" name="cb_copydiagramjobstartrklton" class="form-control" onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'JOBSTART', this.value)">
                                            <option value="">เลือก ต้นทาง</option>
    <?php
    $conFrom1 = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "'";
    $sql_seFrom = "{call megVehicletransportprice_v2(?,?,?,?)}";
    $params_seFrom = array(
        array('select_from', SQLSRV_PARAM_IN),
        array($conFrom1, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query_seFrom = sqlsrv_query($conn, $sql_seFrom, $params_seFrom);
    while ($result_seFrom = sqlsrv_fetch_array($query_seFrom, SQLSRV_FETCH_ASSOC)) {
        $selected = "";
        if ($result_sePlan1['JOBSTART'] == $result_seFrom['FROM']) {
            $selected = "selected";
        }
        ?>
                                                <option value="<?= $result_seFrom['FROM'] ?>" <?= $selected ?>><?= $result_seFrom['FROM'] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">

                                        <label>โซน :</label>

                                        <select multiple="" onchange="select_zonerklton('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'CLUSTER', this.value)"  id="cb_copydiagramzonerklton" name="cb_copydiagramzonerklton" class=" form-control" style="width: 100%">
    <?php
    $condiLocation1 = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "'";
    $sql_seLocation = "{call megVehicletransportprice_v2(?,?,?,?)}";
    $params_seLocation = array(
        array('select_location', SQLSRV_PARAM_IN),
        array($condiLocation1, SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN),
        array('', SQLSRV_PARAM_IN)
    );
    $query_seLocation = sqlsrv_query($conn, $sql_seLocation, $params_seLocation);
    while ($result_seLocation = sqlsrv_fetch_array($query_seLocation, SQLSRV_FETCH_ASSOC)) {
        ?>
                                                <option value="<?= $result_seLocation['LOCATION'] ?>" ><?= $result_seLocation['LOCATION'] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>


                                    </div>
                                    <div class="col-lg-3">

                                        <label>ปลายทาง :</label>

                                        <div id="data_copydiagramjobendrkltondef">
                                            <div class="dropdown bootstrap-select show-tick form-control">

                                                <select multiple="" id="cb_copydiagramjobendrklton" name="cb_copydiagramjobendrklton" class="selectpicker form-control" onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'LOCATION', this.value)" id="number-multiple" data-container="body" data-live-search="true" title="เลือก ปลายทาง..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >

                                                </select>
                                                <input class="form-control" style="display: none"   id="txt_copydiagramjobendrklton" name="txt_copydiagramjobendrklton" maxlength="500" value="" >


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

                                        <div id="data_copydiagramjobendrkltonsr"></div>
                                    </div>

    <?php
}
?>
                            </div>

                            <div class="row">&nbsp;</div>
                            <div class="row">
                                <div class="col-lg-2">
                                    <label>เวลารายงานตัว  </label>
                                    <input type="text"  readonly="" disabled="" class="form-control " id="txt_copydiagramdateinputupdrkr" name="txt_copydiagramdateinputupdrkr" value="<?= $result_sePlan1['DATEINPUT111'] ?>">

                                </div>
                                <div class="col-lg-2">
                                    <label>เวลาเริ่มงาน  </label>
                                    <input type="text" onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'DATERK', this.value)" value="<?= $result_sePlan1['DATERK111'] ?>" readonly="" class="form-control datetimeen" id="txt_copydiagramdatevlinupdrkr" name="txt_copydiagramdaterkupdrkr"  >

                                </div>
                                <div class="col-lg-2">
                                    <label>เวลาเข้า(ลูกค้า)  </label>
                                    <input type="text" onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'DATEVLIN', this.value)" value="<?= $result_sePlan1['DATEVLIN111'] ?>" readonly="" class="form-control datetimeen" id="txt_copydiagramdatevlinupdrkr" name="txt_copydiagramdatevlinupdrkr"  >

                                </div>
                                <div class="col-lg-2">
                                    <label>เวลาออก(ลูกค้า) </label>
                                    <input type="text" onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'DATEVLOUT', this.value)" value="<?= $result_sePlan1['DATEVLOUT111'] ?>" readonly="" class="form-control datetimeen" id="txt_copydiagramdatevloutupdrkr" name="txt_copydiagramdatevloutupdrkr" >

                                </div>
                                <div class="col-lg-2">
                                    <label>เวลาเข้า(ลูกค้า2) </label>
                                    <input type="text" onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'DATEDEALERIN', this.value)" value="<?= $result_sePlan1['DATEDEALERIN111'] ?>" readonly="" class="form-control datetimeen" id="txt_copydiagramdatedealerinupdrkr" name="txt_copydiagramdatedealerinupdrkr" >

                                </div>
                                <div class="col-lg-2">
                                    <label>เวลากลับบริษัท </label>
                                    <input type="text" onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'DATERETURN', this.value)" value="<?= $result_sePlan1['DATERETURN111'] ?>" readonly="" class="form-control datetimeen" id="txt_copydiagramdatereturnupdrkr" name="txt_copydiagramdatereturnupdrkr" >

                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                            <button type="button" class="btn btn-primary" onclick="reload()">บันทึก</button>
                        </div>





                    </div>
                </div>
            </div>
            <div class="modal fade" id="modal_copydiagramupdrkl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="width: 80%">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="row">
                                <div class="col-lg-5">
                                    <h5 class="modal-title" id="title_copydiagram"><b>Update Diagram</b></h5>
                                </div>

                            </div>
                        </div>



                        <div id="modalcopydiagramupdrkl"></div>




                    </div>
                </div>
            </div>
            <div class="modal fade" id="modal_confrimpriceskb" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-modal-parent="#modal_copydiagram">
                <div class="modal-dialog" role="document" style="width: 60%">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="row">
                                <div class="col-lg-5">
                                    <h5 class="modal-title" id="title_copydiagram"><b>ยืนยันราคาขนส่ง</b></h5>
                                </div>

                            </div>
                        </div>



                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>ต้นทาง :</label>
                                        <input type="text" class="form-control" id="txt_confrimjobid" name="txt_confrimjobid" style="display: none">
                                        <input type="text" class="form-control" id="txt_confrimjobstart" name="txt_confrimjobstart" disabled="" style="background-color: #f080802e">
                                    </div>

                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label>Cluster :</label>
                                        <input type="text" class="form-control" id="txt_confrimcluster" name="txt_confrimcluster" disabled="" style="background-color: #f080802e">
                                    </div>

                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>ปลายทาง :</label>
                                        <input type="text" class="form-control" id="txt_confrimjobend" name="txt_confrimjobend" disabled="" style="background-color: #f080802e">
                                    </div>

                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label>ระยะทาง(กม.) :</label>
                                        <input type="text" class="form-control" id="txt_confrimkm" name="txt_confrimkm"  onchange="edit_pricekm(this.value)" onkeypress="edit_pricekm(this.value)">
                                        <input type="text" class="form-control" id="txt_pricekm" name="txt_pricekm" style="display: none">
                                    </div>

                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label>ค่าเที่ยวพนักงาน :</label>
                                        <input type="text" class="form-control" id="txt_confrimcomp" name="txt_confrimcomp">
                                    </div>

                                </div>
                            </div>
                            <div id="show_confrimskb"></div>

                        </div>
                        <div class="modal-footer">

                            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                            <button type="button" class="btn btn-primary"  onclick="save_confrimpriceskb()">บันทึก</button>

                        </div>




                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-12">&nbsp;</div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="background-color: #e7e7e7">

<?php
$meg = 'แก้ไขงาน';
echo "<a href='report_operation.php?companycode=" . $_GET['companycode'] . "&customercode=" . $_GET['customercode'] . "&statusnumber=" . $_GET['statusnumber'] . "&datestart=" . $_GET['datestart'] . "&dateend=" . $_GET['dateend'] . "'> แผนการปฏิบัติงาน</a> / " . $meg;
$link = "<a href='report_operation.php?companycode=" . $_GET['companycode'] . "&customercode=" . $_GET['customercode'] . "&statusnumber=" . $_GET['statusnumber'] . "&datestart=" . $_GET['datestart'] . "&dateend=" . $_GET['dateend'] . "'> แผนการปฏิบัติงาน</a> ";
$_SESSION["link"] = $link;
?>
                        </div>
                        <!-- /.panel-heading -->

                        <div class="panel-body">


                            <div class="row" >&nbsp;</div>

                            <div id="showdatadef">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <!-- Nav tabs -->


                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <p>&nbsp;</p>


                                            <div class="tab-pane fade active in" id="monday">
                                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                                    <table  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example11" style="width: 100%;">
                                                        <thead >
                                                            <tr>
                                                                <th style="display: none">&nbsp;</th>

                                                                <th style="text-align: center;"><label style="width: 50px">EDIT JOB</label></th>
                                                                <th style="text-align: center;"><label style="width: 200px">พนักงาน(1)</label></th>
                                                                <th style="text-align: center;"><label style="width: 200px">พนักงาน(2)</label></th>
                                                                <th style="text-align: center;"><label style="width: 200px">รอบวิ่ง</label></th>
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


$conditionmonday = " AND a.COMPANYCODE ='" . $_GET['companycode'] . "' AND a.CUSTOMERCODE ='" . $_GET['customercode'] . "' AND a.VEHICLETRANSPORTPLANID = '" . $_GET['vehicletransportplanid'] . "' ";



$sql_sePlanmonday = "{call megVehicletransportplan_v2(?,?,?,?)}";
$params_sePlanmonday = array(
    array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
    array($conditionmonday, SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_sePlanmonday = sqlsrv_query($conn, $sql_sePlanmonday, $params_sePlanmonday);
while ($result_sePlanmonday = sqlsrv_fetch_array($query_sePlanmonday, SQLSRV_FETCH_ASSOC)) {

    if ($result_sePlanmonday['COMPANYCODE'] == 'RRC') {
        if ($result_sePlanmonday['CUSTOMERCODE'] == 'GMT') {
            $jobsm1 = select_jobautocomplatestartgetway('megVehicletransportprice_v2', 'select_startways', '');
        } else if ($result_sePlanmonday['CUSTOMERCODE'] == 'BP') {
            $jobsm1 = select_jobautocomplatestartgetway('megVehicletransportprice_v2', 'select_startways', '');
        } else if ($result_sePlanmonday['CUSTOMERCODE'] == 'TTAST') {
            $jobsm1 = select_jobautocomplatestartgetway('megVehicletransportprice_v2', 'select_startways', '');
        } else if ($result_sePlanmonday['CUSTOMERCODE'] == 'TTTC') {
            $jobsm1 = select_jobautocomplatestartgetway('megVehicletransportprice_v2', 'select_startways', '');
        }
    } else if ($result_sePlanmonday['COMPANYCODE'] == 'RCC' || $result_sePlanmonday['COMPANYCODE'] == 'RATC') {
        $jobsm2 = select_jobautocomplate('megVehicletransportprice_v2', 'select_vehicletransportprice', '');
    } else if ($result_sePlanmonday['COMPANYCODE'] == 'RKS') {
        if ($result_sePlanmonday['CUSTOMERCODE'] == 'DENSO-THAI' || $result_sePlanmonday['CUSTOMERCODE'] == 'DENSO-WGR' || $result_sePlanmonday['CUSTOMERCODE'] == 'DENSO-SALES' || $result_sePlanmonday['CUSTOMERCODE'] == 'ANDEN' || $result_sePlanmonday['CUSTOMERCODE'] == 'SDM' || $result_sePlanmonday['CUSTOMERCODE'] == 'SKD' || $result_sePlanmonday['CUSTOMERCODE'] == 'DENSO') {
            $jobsm3 = select_jobautocomplatestartrks_denso('megVehicletransportprice_v2', 'select_routeno', '');
        } else if ($result_sePlanmonday['CUSTOMERCODE'] == 'TGT') {
            $jobsm4 = select_jobautocomplatestartrks_tgt('megVehicletransportprice_v2', 'select_supplier', '');
        }
    }
    ?>
                                                                <tr
                                                                <?php
                                                                if ($result_sePlanmonday['ACTUALPRICE'] == '' || $result_sePlanmonday['VEHICLETRANSPORTPRICEID'] == '') {
                                                                    ?>
                                                                        style="color: red"
                                                                    <?php
                                                                }
                                                                ?>
                                                                    >
                                                                    <td style="display: none">&nbsp;</td>

    <?php
    if ($result_sePlanmonday['VEHICLETRANSPORTPRICEID'] == '') {
        ?>
                                                                        <td style="text-align: center;">
                                                                            <button  data-toggle="modal"  data-target="#modal_copydiagramupdrcc" disabled=""  title="แก้ไขแผนการขนส่ง" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-wrench"></span></button>
                                                                        </td>
        <?php
    } else {
        if ($result_sePlanmonday['COMPANYCODE'] == 'RCC' || $result_sePlanmonday['COMPANYCODE'] == 'RATC') {
            ?>
                                                                            <td style="text-align: center;">
                                                                                <button onclick="update_copydiagramrcc('<?= $result_sePlanmonday['EMPLOYEENAME1'] ?>', '<?= $result_sePlanmonday['EMPLOYEENAME2'] ?>', '<?= $result_sePlanmonday['THAINAME'] ?>', '<?= $result_sePlanmonday['JOBSTART'] ?>', '<?= $result_sePlanmonday['TIMEINPUT'] ?>', '<?= $result_sePlanmonday['TIMEPRESENT'] ?>', '<?= $result_sePlanmonday['TIMEVLIN'] ?>', '<?= $result_sePlanmonday['TIMEVLOUT'] ?>', '<?= $result_sePlanmonday['TIMEDEALERIN'] ?>', '<?= $result_sePlanmonday['TIMERETURN'] ?>')"  data-toggle="modal"  data-target="#modal_copydiagramupdrcc"  title="แก้ไขแผนการขนส่ง" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-wrench"></span></button>
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
                                                                                <button onclick="update_modalrks('<?= $result_sePlanmonday['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_sePlanmonday['CARRYTYPE'] ?>')"  data-toggle="modal"  data-target="#modal_copydiagramupdrks"  title="แก้ไขแผนการขนส่ง" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-wrench"></span></button>
                                                                            </td>
            <?php
        } else if ($result_sePlanmonday['COMPANYCODE'] == 'RKR') {
            if ($result_sePlanmonday['CARRYTYPE'] == 'trip') {
                ?>
                                                                                <td style="text-align: center;">
                                                                                    <button onclick="update_modalrkr('<?= $result_sePlanmonday['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_sePlanmonday['CARRYTYPE'] ?>')"  data-toggle="modal"  data-target="#modal_copydiagramupdrkr"  title="แก้ไขแผนการขนส่ง" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-wrench"></span></button>
                                                                                </td>

                <?php
            } else {
                ?>
                                                                                <td style="text-align: center;">
                                                                                    <button  data-toggle="modal"  data-target="#modal_copydiagramupdrkrw"  title="แก้ไขแผนการขนส่ง" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-wrench"></span></button>
                                                                                </td>
                <?php
            }
        } else if ($result_sePlanmonday['COMPANYCODE'] == 'RKL') {
            if ($result_sePlanmonday['CARRYTYPE'] == 'trip') {
                if ($result_sePlanmonday['CUSTOMERCODE'] == 'SKB') {
                    ?>
                                                                                    <td style="text-align: center;">
                                                                                        <button onclick="update_modalrkl('<?= $result_sePlanmonday['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_sePlanmonday['CARRYTYPE'] ?>')" data-toggle="modal"  data-target="#modal_copydiagramupdrklskb"  title="แก้ไขแผนการขนส่ง" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-wrench"></span></button>
                                                                                        <!--<button  disabled=""  title="แก้ไขแผนการขนส่ง" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-wrench"></span></button>-->
                                                                                    </td>
                    <?php
                } else {
                    ?>
                                                                                    <td style="text-align: center;">
                                                                                        <button onclick="update_modalrkl('<?= $result_sePlanmonday['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_sePlanmonday['CARRYTYPE'] ?>')"  data-toggle="modal"  data-target="#modal_copydiagramupdrkl"  title="แก้ไขแผนการขนส่ง" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-wrench"></span></button>
                                                                                    </td>
                    <?php
                }
                ?>


                <?php
            } else {
                ?>
                                                                                <td style="text-align: center;">
                                                                                    <button data-toggle="modal"  data-target="#modal_copydiagramupdrklw"  title="แก้ไขแผนการขนส่ง" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-wrench"></span></button>
                                                                                </td>
                <?php
            }
        }
    }
    ?>



                                                                    <td><?= $result_sePlanmonday['EMPLOYEENAME1'] ?></td>
                                                                    <td><?= $result_sePlanmonday['EMPLOYEENAME2'] ?></td>
                                                                    <td><?= $result_sePlan1['ROUNDAMOUNT'] ?></td>
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
                                    </div>
                                </div>
                            </div>
                            <div id="showdatasr">

                            </div>
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
        <script src="../dist/js/select2.js"></script>


<?php
$job = '';
if ($_GET['companycode'] == 'RRC' && $_GET['customercode'] == 'GMT') {
    $job = select_jobautocomplatestartgetway('megVehicletransportprice_v2', 'select_from', '');
}
if ($_GET['companycode'] == 'RRC' && $_GET['customercode'] == 'BP') {
    $job = select_jobautocomplatestartgetway('megVehicletransportprice_v2', 'select_from', '');
}
if ($_GET['companycode'] == 'RRC' && $_GET['customercode'] == 'TTAST') {
    $job = select_jobautocomplatestartgetway('megVehicletransportprice_v2', 'select_from', '');
}
if ($_GET['companycode'] == 'RRC' && $_GET['customercode'] == 'TTTC') {
    $job = select_jobautocomplatestartgetway('megVehicletransportprice_v2', 'select_from', '');
} else if ($_GET['companycode'] == 'RCC' && $_GET['customercode'] == 'TTT') {
    $job = select_jobautocomplate('megVehicletransportprice_v2', 'select_beginjob', '');
} else if ($_GET['companycode'] == 'RATC' && $_GET['customercode'] == 'TTT') {
    $job = select_jobautocomplate('megVehicletransportprice_v2', 'select_beginjob', '');
}
if ($_GET['companycode'] == 'RRC' || $_GET['companycode'] == 'RCC' || $_GET['companycode'] == 'RATC') {
    $thainame = select_carautocomplate('megVehicleinfo_v2', 'selectcond_vehicleinfo', " AND a.THAINAME != '-' AND (a.ENGNAME  LIKE '%R-%' OR a.ENGNAME  LIKE '%RA-%'", " OR a.THAINAME LIKE '%ดินแดง%'  OR a.THAINAME  LIKE '%อุทัยธานี%'  OR a.THAINAME  LIKE '%คลองเขื่อน%'  ", " OR a.THAINAME LIKE '%RP-%' OR a.THAINAME  LIKE '%สวนผึ้ง%' OR a.THAINAME  LIKE '%ด่านช้าง%'", " OR a.ENGNAME LIKE '%Khao Chamao%' OR a.ENGNAME LIKE '%Kerry%' OR a.ENGNAME LIKE '%Chaloem Prakiat%')");
} else {
    $thainame = select_vehiclenumberautocomplate('megVehicleinfo_v2', 'select_vehicleinfo', '');
}
$jobrccend = select_jobautocomplateendgetway('megVehicletransportprice_v2', 'select_to', '');


$emp = select_empautocomplate('megEmployeeEHR_v2', 'select_employee', "");
$cluster = select_clusterautocomplate('megVehicletransportprice_v2', 'select_cluster', '');
?>


        <script>
                                                    $('#cb_copydiagramzonerkrton').select2({
                                                        placeholder: 'เลือกโซน'
                                                    });
                                                    $('#cb_copydiagramzonerklton').select2({
                                                        placeholder: 'เลือกโซน'
                                                    });
                                                    $('#cb_copydiagramzoneskb').select2({
                                                        placeholder: 'เลือกโซน'
                                                    });

                                                    $(document).ready(function () {
                                                        $('#txt_copydiagramjobstartupd').select2({
                                                            placeholder: 'เลือกต้นทาง'
                                                        });
                                                    });



                                                    function se_copydiagramroutesh(copydiagramjobstartsh)
                                                    {
                                                        //T1111

                                                        var worktype = document.getElementById('txt_worktypesh').value;
                                                        var companycode = document.getElementById('txt_companycodesh').value;
                                                        var customercode = document.getElementById('txt_customercodesh').value;


                                                        // alert(worktype);
                                                        // alert(companycode);
                                                        // alert(customercode);
                                                        // alert(copydiagramjobstartsh);

                                                        $.ajax({
                                                            type: 'post',
                                                            url: 'meg_data.php',
                                                            data: {
                                                                txt_flg: "show_copydiagramjobstartsh", copydiagramjobstartsh: copydiagramjobstartsh, companycode: companycode, customercode: customercode, worktype: worktype
                                                            },
                                                            success: function (rs) {

                                                                document.getElementById("copydiagramroutesrsh").innerHTML = rs;
                                                                document.getElementById("copydiagramroutedefsh").innerHTML = "";

                                                                $("#cb_copydiagramroutesh").html(rs).selectpicker('refresh');
                                                                $('.selectpicker').on('changed.bs.select', function () {
                                                                    document.getElementById('txt_copydiagramroutesh').value = $(this).val();
                                                                    se_copydiagramsubroutesh(document.getElementById('txt_copydiagramroutesh').value);
                                                                });



                                                            }
                                                        });

                                                    }
                                                    function se_copydiagramrouteshn(copydiagramjobstartshn)
                                                    {
                                                        //T1111

                                                        var worktype = document.getElementById('txt_worktypeshn').value;
                                                        var companycode = document.getElementById('txt_companycodeshn').value;
                                                        var customercode = document.getElementById('txt_customercodeshn').value;


                                                        // alert(worktype);
                                                        // alert(companycode);
                                                        // alert(customercode);
                                                        // alert(copydiagramjobstartshn);

                                                        $.ajax({
                                                            type: 'post',
                                                            url: 'meg_data.php',
                                                            data: {
                                                                txt_flg: "show_copydiagramjobstartshn", copydiagramjobstartshn: copydiagramjobstartshn, companycode: companycode, customercode: customercode, worktype: worktype
                                                            },
                                                            success: function (rs) {

                                                                document.getElementById("copydiagramroutesrshn").innerHTML = rs;
                                                                document.getElementById("copydiagramroutedefshn").innerHTML = "";

                                                                $("#cb_copydiagramrouteshn").html(rs).selectpicker('refresh');
                                                                $('.selectpicker').on('changed.bs.select', function () {
                                                                    document.getElementById('txt_copydiagramrouteshn').value = $(this).val();
                                                                    se_copydiagramsubrouteshn(document.getElementById('txt_copydiagramrouteshn').value);
                                                                });



                                                            }
                                                        });

                                                    }

                                                    function se_copydiagramsubrouteshn(data)
                                                    {

                                                        var worktype = document.getElementById('txt_worktypeshn').value;
                                                        var companycode = document.getElementById('txt_companycodeshn').value;
                                                        var customercode = document.getElementById('txt_customercodeshn').value;



                                                        $.ajax({
                                                            type: 'post',
                                                            url: 'meg_data.php',
                                                            data: {
                                                                txt_flg: "show_copydiagramsubrouteshn", copydiagramroute: data, companycode: companycode, customercode: customercode, worktype: worktype
                                                            },
                                                            success: function (rs) {

                                                                document.getElementById("copydiagramsubroutesrshn").innerHTML = rs;
                                                                document.getElementById("copydiagramsubroutedefshn").innerHTML = "";

                                                                $("#cb_copydiagramsubrouteshn").html(rs).selectpicker('refresh');
                                                                $('.selectpicker').on('changed.bs.select', function () {
                                                                    document.getElementById('txt_copydiagramsubrouteshn').value = $(this).val();

                                                                });


                                                            }
                                                        });
                                                    }


                                                    function se_copydiagramsubroutesh(data)
                                                    {

                                                        $.ajax({
                                                            type: 'post',
                                                            url: 'meg_data.php',
                                                            data: {
                                                                txt_flg: "show_copydiagramsubroutesh", copydiagramroutesh: data
                                                            },
                                                            success: function (rs) {

                                                                document.getElementById("copydiagramsubroutesrsh").innerHTML = rs;
                                                                document.getElementById("copydiagramsubroutedefsh").innerHTML = "";

                                                                $("#cb_copydiagramsubroutesh").html(rs).selectpicker('refresh');
                                                                $('.selectpicker').on('changed.bs.select', function () {
                                                                    document.getElementById('txt_copydiagramsubroutesh').value = $(this).val();

                                                                });


                                                            }
                                                        });
                                                    }




                                                    function select_zone(VEHICLETRANSPORTPLANID, COL, DATA)
                                                    {


                                                        select_jobendton(VEHICLETRANSPORTPLANID);
                                                        update_copydiagram(VEHICLETRANSPORTPLANID, COL, $('#cb_copydiagramzonerkrton').val().toString());

                                                    }

                                                    function select_jobendton(VEHICLETRANSPORTPLANID)
                                                    {
                                                        var txtcopydiagramzone = $('#cb_copydiagramzonerkrton').val().toString();
                                                        $.ajax({
                                                            type: 'post',
                                                            url: 'meg_data.php',
                                                            data: {
                                                                txt_flg: "show_copydiagramjobendton", companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', zone: txtcopydiagramzone, VEHICLETRANSPORTPLANID: VEHICLETRANSPORTPLANID
                                                            },
                                                            success: function (rs) {

                                                                document.getElementById("data_copydiagramjobendtonsr").innerHTML = rs;
                                                                document.getElementById("data_copydiagramjobendtondef").innerHTML = "";

                                                                $("#cb_copydiagramjobendton").html(rs).selectpicker('refresh');
                                                                $('.selectpicker').on('changed.bs.select', function () {
                                                                    document.getElementById('txt_copydiagramjobendton').value = $(this).val();
                                                                    update_copydiagram(VEHICLETRANSPORTPLANID, 'JOBEND', document.getElementById('txt_copydiagramjobendton').value);
                                                                });


                                                            }
                                                        });
                                                    }


                                                    function select_zonerklton(VEHICLETRANSPORTPLANID, COL, DATA)
                                                    {

                                                        select_jobendrklton(VEHICLETRANSPORTPLANID);


                                                        update_copydiagram(VEHICLETRANSPORTPLANID, COL, $('#cb_copydiagramzonerklton').val().toString());

                                                    }

                                                    function select_jobendrklton(VEHICLETRANSPORTPLANID)
                                                    {
                                                        var txtcopydiagramzone = $('#cb_copydiagramzonerklton').val().toString();
                                                        $.ajax({
                                                            type: 'post',
                                                            url: 'meg_data.php',
                                                            data: {
                                                                txt_flg: "show_copydiagramjobendrklton", companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', zone: txtcopydiagramzone, VEHICLETRANSPORTPLANID: VEHICLETRANSPORTPLANID
                                                            },
                                                            success: function (rs) {


                                                                document.getElementById("data_copydiagramjobendrkltonsr").innerHTML = rs;
                                                                document.getElementById("data_copydiagramjobendrkltondef").innerHTML = "";




                                                                $("#cb_copydiagramjobendrklton").html(rs).selectpicker('refresh');
                                                                $('.selectpicker').on('changed.bs.select', function () {
                                                                    document.getElementById('txt_copydiagramjobendrklton').value = $(this).val();
                                                                    update_copydiagram(VEHICLETRANSPORTPLANID, 'JOBEND', document.getElementById('txt_copydiagramjobendrklton').value);
                                                                });


                                                            }
                                                        });
                                                    }




                                                    var txt_copydiagramemployeenameupdrkrton1 = [<?= $emp ?>];
                                                    $("#txt_copydiagramemployeenameupdrkrton1").autocomplete({
                                                        source: [txt_copydiagramemployeenameupdrkrton1]
                                                    });

                                                    var txt_copydiagramemployeenameupdrkrton2 = [<?= $emp ?>];
                                                    $("#txt_copydiagramemployeenameupdrkrton2").autocomplete({
                                                        source: [txt_copydiagramemployeenameupdrkrton2]
                                                    });


                                                    var txt_copydiagramemployeenameupdrklton1 = [<?= $emp ?>];
                                                    $("#txt_copydiagramemployeenameupdrklton1").autocomplete({
                                                        source: [txt_copydiagramemployeenameupdrklton1]
                                                    });

                                                    var txt_copydiagramemployeenameupdrklton2 = [<?= $emp ?>];
                                                    $("#txt_copydiagramemployeenameupdrklton2").autocomplete({
                                                        source: [txt_copydiagramemployeenameupdrklton2]
                                                    });


                                                    var txt_copydiagramemployeenameupdrkl1 = [<?= $emp ?>];
                                                    $("#txt_copydiagramemployeenameupdrkl1").autocomplete({
                                                        source: [txt_copydiagramemployeenameupdrkl1]
                                                    });

                                                    var txt_copydiagramemployeenameupdrkl2 = [<?= $emp ?>];
                                                    $("#txt_copydiagramemployeenameupdrkl2").autocomplete({
                                                        source: [txt_copydiagramemployeenameupdrkl2]
                                                    });



                                                    var txt_copydiagramemployeenameupd1 = [<?= $emp ?>];
                                                    $("#txt_copydiagramemployeenameupd1").autocomplete({
                                                        source: [txt_copydiagramemployeenameupd1]
                                                    });

                                                    var txt_copydiagramemployeenameupd2 = [<?= $emp ?>];
                                                    $("#txt_copydiagramemployeenameupd2").autocomplete({
                                                        source: [txt_copydiagramemployeenameupd2]
                                                    });


                                                    var txt_copydiagramthainameupd = [<?= $thainame ?>];
                                                    $("#txt_copydiagramthainameupd").autocomplete({
                                                        source: [txt_copydiagramthainameupd]
                                                    });


                                                    var txt_copydiagramthainameupdrkrton = [<?= $thainame ?>];
                                                    $("#txt_copydiagramthainameupdrkrton").autocomplete({
                                                        source: [txt_copydiagramthainameupdrkrton]
                                                    });

                                                    var txt_copydiagramthainameupdrklton = [<?= $thainame ?>];
                                                    $("#txt_copydiagramthainameupdrklton").autocomplete({
                                                        source: [txt_copydiagramthainameupdrklton]
                                                    });

                                                    var txt_copydiagramthainameupdrkl = [<?= $thainame ?>];
                                                    $("#txt_copydiagramthainameupdrkl").autocomplete({
                                                        source: [txt_copydiagramthainameupdrkl]
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
                                                    $(document).ready(function () {
                                                        $('#dataTables-example').DataTable({

                                                            order: [[0, "desc"]],
                                                            scrollX: true,
                                                            scrollY: '500px',
                                                        });
                                                    });


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
                                                        select_subroute(copydiagramroute)
                                                    }
                                                    function save_copydiagramrrc()
                                                    {
                                                        var CARTYPE = '';
                                                        var JOBSTART = '';
                                                        var JOBEND = '';
                                                        if ('<?= $_GET['customercode'] ?>' == 'GMT')
                                                        {
                                                            CARTYPE = document.getElementById('cb_copydiagramcartypeupdrrcgmt').value;
                                                            JOBSTART = document.getElementById('cb_copydiagramjobstartupdrrcgmt').value;
                                                            JOBEND = document.getElementById('cb_copydiagramjobendupdrrcgmt').value;

                                                        } else if ('<?= $_GET['customercode'] ?>' == 'TTAST')
                                                        {
                                                            CARTYPE = document.getElementById('cb_copydiagramcartypeupdrrcttast').value;
                                                            JOBSTART = document.getElementById('cb_copydiagramjobstartupdrrcttast').value;
                                                            JOBEND = document.getElementById('cb_copydiagramjobendupdrrcttast').value;
                                                        } else if ('<?= $_GET['customercode'] ?>' == 'BP')
                                                        {
                                                            CARTYPE = document.getElementById('cb_copydiagramcartypeupdrrcbp').value;
                                                            JOBSTART = document.getElementById('cb_copydiagramjobstartupdrrcbp').value;
                                                            JOBEND = document.getElementById('cb_copydiagramjobendupdrrcbp').value;
                                                        } else if ('<?= $_GET['customercode'] ?>' == 'TTTC')
                                                        {
                                                            CARTYPE = document.getElementById('cb_copydiagramcartypeupdrrctttc').value;
                                                            JOBSTART = document.getElementById('cb_copydiagramjobstartupdrrctttc').value;
                                                            JOBEND = document.getElementById('cb_copydiagramjobendupdrrctttc').value;
                                                        }



                                                        $.ajax({
                                                            type: 'post',
                                                            url: 'meg_data.php',
                                                            data: {
                                                                txt_flg: "edit_vehicletransportplanrrc",
                                                                VEHICLETRANSPORTPLANID: '<?= $_GET['vehicletransportplanid'] ?>',
                                                                EMPLOYEENAME1: document.getElementById('txt_copydiagramemployeenameupdrrc1').value,
                                                                EMPLOYEENAME2: document.getElementById('txt_copydiagramemployeenameupdrrc2').value,
                                                                VEHICLEINFO: document.getElementById('txt_copydiagramthainameupdrrc').value,
                                                                VEHICLETYPE: CARTYPE,
                                                                C8: document.getElementById('cb_copydiagramgoreturnupdrrc').value,
                                                                MATERIALTYPE: document.getElementById('cb_materialtypeupdrrc').value,
                                                                JOBSTART: JOBSTART,
                                                                JOBEND: JOBEND,
                                                                COPYDIAGRAMDATEVLINUPD: document.getElementById('txt_copydiagramdatevlinupdrrc').value,
                                                                COPYDIAGRAMDATEVLOUTUPD: document.getElementById('txt_copydiagramdatevloutupdrrc').value,
                                                                COPYDIAGRAMDATEDEALERINUPD: document.getElementById('txt_copydiagramdatedealerinupdrrc').value,
                                                                COPYDIAGRAMDATERETURNUPD: document.getElementById('txt_copydiagramdatereturnupdrrc').value


                                                            },
                                                            success: function (rs) {
                                                                alert(rs);
                                                                window.location.reload();
                                                            }
                                                        });
                                                    }
                                                    function save_copydiagram()
                                                    {
<?php
if ($result_sePlan1['WORKTYPE'] == "sh") {
    ?>

                                                            alert('ยืนยันแก้ไขงาน(SH)...');

                                                            var cluster = document.getElementById('txt_copydiagramroutesh').value;
                                                            var jobend = document.getElementById('txt_copydiagramsubroutesh').value;
                                                            // alert(cluster);
                                                            // alert(jobend);
                                                            $.ajax({
                                                                type: 'post',
                                                                url: 'meg_data.php',
                                                                data: {
                                                                    txt_flg: "edit_vehicletransportplanmixsh",
                                                                    VEHICLETRANSPORTPLANID: '<?= $_GET['vehicletransportplanid'] ?>',
                                                                    EMPLOYEENAME1: document.getElementById('txt_copydiagramemployeenameupd1').value,
                                                                    EMPLOYEENAME2: document.getElementById('txt_copydiagramemployeenameupd2').value,
                                                                    VEHICLEINFO: document.getElementById('txt_copydiagramthainameupd').value,
                                                                    CLUSTER: document.getElementById('txt_copydiagramroutesh').value, //@FIELDNAME
                                                                    JOBEND: document.getElementById('txt_copydiagramsubroutesh').value,
                                                                    LOAD: document.getElementById('cb_copydiagramload').value,
                                                                    copydiagramdaterkupd: document.getElementById('txt_copydiagramdaterkupd').value,
                                                                    copydiagramdatevlinupd: document.getElementById('txt_copydiagramdatevlinupd').value,
                                                                    copydiagramdatevloutupd: document.getElementById('txt_copydiagramdatevloutupd').value,
                                                                    copydiagramdatedealerinupd: document.getElementById('txt_copydiagramdatedealerinupd').value,
                                                                    copydiagramdatereturnupd: document.getElementById('txt_copydiagramdatereturnupd').value,
                                                                    JOBSTART: document.getElementById('cb_copydiagramjobstartsh').value
                                                                            // JOBSTART: document.getElementById('txt_copydiagramjobstartupd').value

                                                                },
                                                                success: function (rs) {
                                                                    alert('บันทึกข้อมูลเรียบร้อย...');
                                                                    window.location.reload();
                                                                }
                                                            });
    <?php
} else if ($result_sePlan1['WORKTYPE'] == "nm") {
    ?>

                                                            alert('ยืนยันแก้ไขงาน(Normal)...');

                                                            $.ajax({
                                                                type: 'post',
                                                                url: 'meg_data.php',
                                                                data: {
                                                                    txt_flg: "edit_vehicletransportplanmix",
                                                                    VEHICLETRANSPORTPLANID: '<?= $_GET['vehicletransportplanid'] ?>',
                                                                    EMPLOYEENAME1: document.getElementById('txt_copydiagramemployeenameupd1').value,
                                                                    EMPLOYEENAME2: document.getElementById('txt_copydiagramemployeenameupd2').value,
                                                                    VEHICLEINFO: document.getElementById('txt_copydiagramthainameupd').value,
                                                                    CLUSTER: document.getElementById('txt_copydiagramcluster').value,
                                                                    JOBEND: document.getElementById('txt_copydiagramjobend').value,
                                                                    LOAD: '',
                                                                    copydiagramdaterkupd: document.getElementById('txt_copydiagramdaterkupd').value,
                                                                    copydiagramdatevlinupd: document.getElementById('txt_copydiagramdatevlinupd').value,
                                                                    copydiagramdatevloutupd: document.getElementById('txt_copydiagramdatevloutupd').value,
                                                                    copydiagramdatedealerinupd: document.getElementById('txt_copydiagramdatedealerinupd').value,
                                                                    copydiagramdatereturnupd: document.getElementById('txt_copydiagramdatereturnupd').value,
                                                                    JOBSTART: document.getElementById('txt_copydiagramjobstartupd').value


                                                                },
                                                                success: function () {
                                                                    alert('บันทึกข้อมูลเรียบร้อย...');
                                                                    window.location.reload();
                                                                }
                                                            });

                                                            /*$.ajax({
                                                             type: 'post',
                                                             url: 'meg_data.php',
                                                             data: {
                                                             txt_flg: "edit_vehicletransportplanmixnsh",
                                                             VEHICLETRANSPORTPLANID: '<?//= $_GET['vehicletransportplanid'] ?>',
                                                             JOBSTARTSH: document.getElementById('cb_copydiagramjobstartsh').value,
                                                             JOBENDMAINSH: document.getElementById('txt_copydiagramroutesh').value,
                                                             JOBENDSH: document.getElementById('txt_copydiagramsubroutesh').value,
                                                             LOADSH: document.getElementById('cb_copydiagramloadsh').value,

                                                             },
                                                             success: function () {
                                                             alert('บันทึกข้อมูลเรียบร้อย...');
                                                             window.location.reload();
                                                             }
                                                             });*/
    <?php
} else {
    ?>
                                                            //บันทึกแผนงานshn
                                                            alert('ยืนยันแก้ไขงาน(SH(N))...');

                                                            $.ajax({
                                                                type: 'post',
                                                                url: 'meg_data.php',
                                                                data: {
                                                                    txt_flg: "edit_vehicletransportplanmix",
                                                                    VEHICLETRANSPORTPLANID: '<?= $_GET['vehicletransportplanid'] ?>',
                                                                    EMPLOYEENAME1: document.getElementById('txt_copydiagramemployeenameupd1').value,
                                                                    EMPLOYEENAME2: document.getElementById('txt_copydiagramemployeenameupd2').value,
                                                                    VEHICLEINFO: document.getElementById('txt_copydiagramthainameupd').value,
                                                                    CLUSTER: document.getElementById('txt_copydiagramrouteshn').value, //@FIELDNAME
                                                                    JOBEND: document.getElementById('txt_copydiagramsubrouteshn').value,
                                                                    LOAD: document.getElementById('cb_copydiagramloadshn').value,
                                                                    copydiagramdaterkupd: document.getElementById('txt_copydiagramdaterkupd').value,
                                                                    copydiagramdatevlinupd: document.getElementById('txt_copydiagramdatevlinupd').value,
                                                                    copydiagramdatevloutupd: document.getElementById('txt_copydiagramdatevloutupd').value,
                                                                    copydiagramdatedealerinupd: document.getElementById('txt_copydiagramdatedealerinupd').value,
                                                                    copydiagramdatereturnupd: document.getElementById('txt_copydiagramdatereturnupd').value,
                                                                    JOBSTART: document.getElementById('cb_copydiagramjobstartshn').value


                                                                },
                                                                success: function () {
                                                                    alert('บันทึกข้อมูลเรียบร้อย...');
                                                                    window.location.reload();
                                                                }
                                                            });




    <?php
}
?>



                                                    }
                                                    function reload()
                                                    {
                                                        window.location.reload();
                                                    }
                                                    function select_subroute(copydiagramroute)
                                                    {

                                                        $('.selectpicker').on('changed.bs.select', function () {
                                                            document.getElementById('txt_copydiagramsubroute').value = $(this).val();
                                                            select_jobend(copydiagramroute);
                                                        });
                                                    }
                                                    function select_cluster(copydiagramjobstart)
                                                    {
                                                        $('.selectpicker').on('changed.bs.select', function () {
                                                            document.getElementById('txt_copydiagramcluster').value = $(this).val();
                                                            select_jobend(copydiagramjobstart);
                                                        });
                                                    }
                                                    function select_jobend(copydiagramjobstart)
                                                    {

                                                        var companycode = document.getElementById('txt_companycodenm').value;
                                                        var customercode = document.getElementById('txt_customercodenm').value;

                                                        $.ajax({
                                                            type: 'post',
                                                            url: 'meg_data.php',
                                                            data: {
                                                                txt_flg: "show_copydiagramjobend", cluster: document.getElementById('txt_copydiagramcluster').value, copydiagramjobstart: copydiagramjobstart, companycode: companycode, customercode: customercode
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
                                                    function update_planskb()
                                                    {

                                                        $.ajax({
                                                            type: 'post',
                                                            url: 'meg_data.php',
                                                            data: {
                                                                txt_flg: "update_planskb",
                                                                vehicletransportplanid:'<?=$_GET['vehicletransportplanid']?>'

                                                            },
                                                            success: function (rs) {
                                                                alert(rs);
                                                               window.location.reload();
                                                            }
                                                        });
                                                    }
                                                     function update_copydiagram2(ID, fieldname, editableObj)
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

                                                                    select_confrimpriceskb(editableObj);

                                                            }
                                                        });
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

                                                    function update_modalrks(vehicletransportplanid, carrytype)
                                                    {

                                                        $.ajax({
                                                            type: 'post',
                                                            url: 'meg_data.php',
                                                            data: {
                                                                txt_flg: "modal_updatediagramrks", vehicletransportplanid: vehicletransportplanid, companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', carrytype: carrytype
                                                            },
                                                            success: function (rs) {

                                                                document.getElementById("modalcopydiagramupdrks").innerHTML = rs;
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
                                                    function update_modalrkr(vehicletransportplanid, carrytype)
                                                    {
                                                        $.ajax({
                                                            type: 'post',
                                                            url: 'meg_data.php',
                                                            data: {
                                                                txt_flg: "modal_updatediagramrkr", vehicletransportplanid: vehicletransportplanid, companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', carrytype: carrytype
                                                            },
                                                            success: function (rs) {

                                                                document.getElementById("modalcopydiagramupdrkr").innerHTML = rs;
                                                                $("#cb_copydiagramzonerkr").html(rs).selectpicker('refresh');
                                                                $('.selectpicker').on('changed.bs.select', function () {
                                                                    document.getElementById('txt_copydiagramzonerkr').value = $(this).val();
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

                                                                var txt_copydiagramthainameupdrkr = [<?= $thainame ?>];
                                                                $("#txt_copydiagramthainameupdrkr").autocomplete({
                                                                    source: [txt_copydiagramthainameupdrkr]
                                                                });
                                                                var txt_copydiagramemployeenameupdrkr1 = [<?= $emp ?>];
                                                                $("#txt_copydiagramemployeenameupdrkr1").autocomplete({
                                                                    source: [txt_copydiagramemployeenameupdrkr1]
                                                                });
                                                                var txt_copydiagramemployeenameupdrkr2 = [<?= $emp ?>];
                                                                $("#txt_copydiagramemployeenameupdrkr2").autocomplete({
                                                                    source: [txt_copydiagramemployeenameupdrkr2]
                                                                });
                                                            }



                                                        });

                                                    }
                                                    function update_modalrkl(vehicletransportplanid, carrytype)
                                                    {
                                                        $.ajax({
                                                            type: 'post',
                                                            url: 'meg_data.php',
                                                            data: {
                                                                txt_flg: "modal_updatediagramrkl", vehicletransportplanid: vehicletransportplanid, companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', carrytype: carrytype
                                                            },
                                                            success: function (rs) {

                                                                document.getElementById("modalcopydiagramupdrkl").innerHTML = rs;
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

                                                                var txt_copydiagramthainameupdrkr = [<?= $thainame ?>];
                                                                $("#txt_copydiagramthainameupdrkr").autocomplete({
                                                                    source: [txt_copydiagramthainameupdrkr]
                                                                });
                                                                var txt_copydiagramemployeenameupdrkr1 = [<?= $emp ?>];
                                                                $("#txt_copydiagramemployeenameupdrkr1").autocomplete({
                                                                    source: [txt_copydiagramemployeenameupdrkr1]
                                                                });
                                                                var txt_copydiagramemployeenameupdrkr2 = [<?= $emp ?>];
                                                                $("#txt_copydiagramemployeenameupdrkr2").autocomplete({
                                                                    source: [txt_copydiagramemployeenameupdrkr2]
                                                                });


                                                                $("#cb_updatezoneskb").html(rs).selectpicker('refresh');
                                                                $('.selectpicker').on('changed.bs.select', function () {
                                                                    document.getElementById('txt_updatezoneskb').value = $(this).val();
                                                                });


                                                            }



                                                        });

                                                    }
                                                    /*
                                                     function update_copydiagramrrc(copydiagramemployeenameupdrrc1, copydiagramemployeenameupdrrc2, copydiagramthainameupdrrc, copydiagramcartypeupdrrc, copydiagramgoreturnupdrrc,
                                                     materialtypeupdrrc, copydiagramjobstartupdrrc, copydiagramjobendupdrrc)
                                                     {

                                                     if (copydiagramemployeenameupdrrc1 != '')
                                                     {
                                                     document.getElementById('txt_copydiagramemployeenameupdrrc1').value = copydiagramemployeenameupdrrc1;
                                                     }
                                                     if (copydiagramemployeenameupdrrc2 != '')
                                                     {
                                                     document.getElementById('txt_copydiagramemployeenameupdrrc2').value = copydiagramemployeenameupdrrc2;
                                                     }
                                                     if (copydiagramthainameupdrrc != '')
                                                     {

                                                     document.getElementById('txt_copydiagramthainameupdrrc').value = copydiagramthainameupdrrc;
                                                     }
                                                     if (copydiagramcartypeupdrrc != '')
                                                     {
                                                     if ('<?//= $_GET['customercode'] ?>' == 'GMT')
                                                     {
                                                     document.getElementById('cb_copydiagramcartypeupdrrcgmt').value = copydiagramcartypeupdrrc;
                                                     } else if ('<?//= $_GET['customercode'] ?>' == 'TTAST')
                                                     {
                                                     document.getElementById('cb_copydiagramcartypeupdrrcttast').value = copydiagramcartypeupdrrc;
                                                     } else if ('<?//= $_GET['customercode'] ?>' == 'BP')
                                                     {
                                                     document.getElementById('cb_copydiagramcartypeupdrrcbp').value = copydiagramcartypeupdrrc;
                                                     } else if ('<?//= $_GET['customercode'] ?>' == 'TTTC')
                                                     {
                                                     document.getElementById('cb_copydiagramcartypeupdrrctttc').value = copydiagramcartypeupdrrc;
                                                     }

                                                     }
                                                     if (copydiagramgoreturnupdrrc != '')
                                                     {

                                                     document.getElementById('cb_copydiagramgoreturnupdrrc').value = copydiagramgoreturnupdrrc;
                                                     }
                                                     if (materialtypeupdrrc != '')
                                                     {

                                                     document.getElementById('cb_materialtypeupdrrc').value = materialtypeupdrrc;
                                                     }
                                                     if (copydiagramjobstartupdrrc != '')
                                                     {

                                                     if ('<?//= $_GET['customercode'] ?>' == 'GMT')
                                                     {
                                                     document.getElementById('cb_copydiagramjobstartupdrrcgmt').value = copydiagramjobstartupdrrc;
                                                     } else if ('<?//= $_GET['customercode'] ?>' == 'TTAST')
                                                     {
                                                     document.getElementById('cb_copydiagramjobstartupdrrcttast').value = copydiagramjobstartupdrrc;
                                                     } else if ('<?//= $_GET['customercode'] ?>' == 'BP')
                                                     {
                                                     document.getElementById('cb_copydiagramjobstartupdrrcbp').value = copydiagramjobstartupdrrc;
                                                     } else if ('<?//= $_GET['customercode'] ?>' == 'TTTC')
                                                     {
                                                     document.getElementById('cb_copydiagramjobstartupdrrctttc').value = copydiagramjobstartupdrrc;
                                                     }




                                                     }
                                                     if (copydiagramjobendupdrrc != '')
                                                     {

                                                     if ('<?//= $_GET['customercode'] ?>' == 'GMT')
                                                     {
                                                     document.getElementById('cb_copydiagramjobendupdrrcgmt').value = copydiagramjobendupdrrc;
                                                     } else if ('<?//= $_GET['customercode'] ?>' == 'TTAST')
                                                     {
                                                     document.getElementById('cb_copydiagramjobendupdrrcttast').value = copydiagramjobendupdrrc;
                                                     } else if ('<?//= $_GET['customercode'] ?>' == 'BP')
                                                     {
                                                     document.getElementById('cb_copydiagramjobendupdrrcbp').value = copydiagramjobendupdrrc;
                                                     } else if ('<?//= $_GET['customercode'] ?>' == 'TTTC')
                                                     {
                                                     document.getElementById('cb_copydiagramjobendupdrrctttc').value = copydiagramjobendupdrrc;
                                                     }



                                                     }


                                                     */
                                                    function update_modalrrc(vehicletransportplanid)
                                                    {
                                                        $.ajax({
                                                            type: 'post',
                                                            url: 'meg_data.php',
                                                            data: {
                                                                txt_flg: "modal_updatediagramrrc", vehicletransportplanid: vehicletransportplanid, companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>'
                                                            },
                                                            success: function (rs) {

                                                                document.getElementById("modalcopydiagramupdrrc").innerHTML = rs;

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

                                                    function update_copydiagramrcc(txtcopydiagramemployeenameupd1, txtcopydiagramemployeenameupd2, txtcopydiagramthainameupd, txtcopydiagramjobstartupd,
                                                            txtcopydiagramdateinputupd, txtcopydiagramdatepresentupd, txtcopydiagramdatevlinupd, txtcopydiagramdatevloutupd, txtcopydiagramdatedealerinupd,
                                                            txtcopydiagramdatereturnupd)
                                                    {



                                                        if (txtcopydiagramemployeenameupd1 != '')
                                                        {
                                                            document.getElementById("txt_copydiagramemployeenameupd1").value = txtcopydiagramemployeenameupd1;
                                                        }
                                                        if (txtcopydiagramemployeenameupd2 != '')
                                                        {
                                                            document.getElementById("txt_copydiagramemployeenameupd2").value = txtcopydiagramemployeenameupd2;
                                                        }
                                                        if (txtcopydiagramthainameupd != '')
                                                        {
                                                            document.getElementById("txt_copydiagramthainameupd").value = txtcopydiagramthainameupd;
                                                        }






                                                        if (txtcopydiagramdatevlinupd != '')
                                                        {
                                                            document.getElementById("txt_copydiagramdatevlinupd").value = txtcopydiagramdatevlinupd;
                                                        }
                                                        if (txtcopydiagramdatevloutupd != '')
                                                        {
                                                            document.getElementById("txt_copydiagramdatevloutupd").value = txtcopydiagramdatevloutupd;
                                                        }
                                                        if (txtcopydiagramdatedealerinupd != '')
                                                        {
                                                            document.getElementById("txt_copydiagramdatedealerinupd").value = txtcopydiagramdatedealerinupd;
                                                        }
                                                        if (txtcopydiagramdatereturnupd != '')
                                                        {
                                                            document.getElementById("txt_copydiagramdatereturnupd").value = txtcopydiagramdatereturnupd;
                                                        }



                                                        //

                                                    }

                                                    function select_confrimpriceskb(locationskb)
                                                    {

                                                        document.getElementById('txt_confrimjobstart').value = document.getElementById('cb_copydiagramjobstart').value;
                                                        document.getElementById('txt_confrimcluster').value = document.getElementById('cb_copydiagramzoneskb').value;
                                                        document.getElementById('txt_confrimjobend').value = locationskb;


                                                        $("#modal_confrimpriceskb").modal();
                                                        $.ajax({
                                                            type: 'post',
                                                            url: 'meg_data.php',
                                                            data: {
                                                                txt_flg: "show_updconfrimskb", vehicletransportplanid: '<?= $_GET['vehicletransportplanid'] ?>'
                                                            },
                                                            success: function (rs) {

                                                                document.getElementById("show_confrimskb").innerHTML = rs;

                                                            }
                                                        });

                                                    }
                                                    function select_zoneskb(VEHICLETRANSPORTPLANID, COL, DATA)
                                                    {


                                                        select_locationskb(VEHICLETRANSPORTPLANID);
                                                        document.getElementById('txt_copydiagramzoneskb').value = $('#cb_copydiagramzoneskb').val().toString();
                                                        update_copydiagram(VEHICLETRANSPORTPLANID, COL, $('#cb_copydiagramzoneskb').val().toString());


                                                    }

                                                    function select_locationskb(VEHICLETRANSPORTPLANID)
                                                    {

                                                        var txtcopydiagramzoneskb = $('#cb_copydiagramzoneskb').val().toString();

                                                        $.ajax({
                                                            type: 'post',
                                                            url: 'meg_data.php',
                                                            data: {
                                                                txt_flg: "show_copydiagramlocationskb", companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', zone: txtcopydiagramzoneskb, VEHICLETRANSPORTPLANID: VEHICLETRANSPORTPLANID
                                                            },
                                                            success: function (rs) {

                                                                document.getElementById("data_copydiagramlocationsr").innerHTML = rs;
                                                                document.getElementById("data_copydiagramlocationdef").innerHTML = "";

                                                                $("#cb_copydiagramlocationskb").html(rs).selectpicker('refresh');
                                                                $('.selectpicker').on('changed.bs.select', function () {
                                                                    document.getElementById('txt_copydiagramjobendskb').value = $(this).val();




                                                                });
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
                                                    function delete_confrimtempskb(confrimskbid)
                                                    {
                                                        var confirmation = confirm("ต้องการลบข้อมูล ?");
                                                        if (confirmation) {
                                                            $.ajax({
                                                                type: 'post',
                                                                url: 'meg_data.php',
                                                                data: {
                                                                    txt_flg: "delete_confrimtempskb", confrimskbid: confrimskbid
                                                                },
                                                                success: function () {

                                                                    //window.location.reload();
                                                                    select_confrimpriceskb('');
                                                                }
                                                            });
                                                        }
                                                    }
                                                    function edit_pricekm(condition)
                                                    {

                                                        $.ajax({
                                                            url: 'meg_data.php',
                                                            type: 'POST',
                                                            data: {
                                                                txt_flg: "select_pricekm", condition: condition
                                                            },
                                                            success: function (rs) {

                                                                document.getElementById("txt_pricekm").value = rs;

                                                            }
                                                        });
                                                    }

                                                    function save_confrimpriceskb()
                                                    {
                                                        var condition = '';
                                                        var jobstart = document.getElementById("txt_confrimjobstart").value;
                                                        var cluster = document.getElementById("txt_copydiagramzoneskb").value;
                                                        var jobend = document.getElementById("txt_confrimjobend").value;
                                                        var km = document.getElementById("txt_confrimkm").value;
                                                        var compensation = document.getElementById("txt_confrimcomp").value;
                                                        var pricekm = document.getElementById("txt_pricekm").value;

                                                        $.ajax({
                                                            url: 'meg_data.php',
                                                            type: 'POST',
                                                            data: {
                                                                txt_flg: "save_confrimtempskb", condition: condition, jobstart: jobstart, cluster: cluster, jobend: jobend, km: km, compensation: compensation, pricekm: pricekm
                                                            },
                                                            success: function () {

                                                                select_confrimpriceskb('');
                                                                document.getElementById("txt_confrimjobstart").value = "";
                                                                document.getElementById("txt_confrimcluster").value = "";
                                                                document.getElementById("txt_confrimjobend").value = "";
                                                                document.getElementById("txt_confrimkm").value = "";
                                                                document.getElementById("txt_confrimcomp").value = "";
                                                                document.getElementById("txt_pricekm").value = "";
                                                            }
                                                        });
                                                    }


        </script>




    </body>


</html>
<?php
sqlsrv_close($conn);
?>
