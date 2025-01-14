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


$run_jobno = create_jobno(substr($_GET['companycode'],0,3), 'GETDATE()');
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
        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <?php
                include '../pages/meg_header.php';
//include '../pages/meg_leftmenu.php';
                ?>
            </nav>

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
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                            <button type="button" class="btn btn-primary" onclick="save_copyjob()">บันทึก</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modal_copydiagram" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="width: 80%">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="row">
                                <div class="col-lg-5">
                                    <h5 class="modal-title" id="title_copydiagram"><b>New Diagram</b></h5>
                                </div>
                                <div class="col-lg-1" style="text-align: right">
                                    <label>ช่วงวันที่</label> 
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
                                <div class="col-lg-3">
                                    <font style="color: red">* </font><label>พนักงาน (1) :</label>
                                    <input type="text"  name="txt_copydiagramemployeename1" id="txt_copydiagramemployeename1" class="form-control">
                                </div>
                                <!--
                                <div class="col-lg-3">
                                    <label>พนักงาน (2) :</label>
                                    <input type="text"  class="form-control" name="txt_copydiagramemployeename2" id="txt_copydiagramemployeename2">
                                </div>
                                -->
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <font style="color: red">* </font><label>เลือกประเภทรถ :</label>
                                    <select  class="form-control" id="cb_vehicletype" name="cb_vehicletype" onchange="editvar_vehicletransportpricevaluerrc(this.value, 'VEHICLETYPE', '<?= $result_sePrice['VEHICLETRANSPORTPRICEID'] ?>')">
                                        <option   value ="">เลือกประเภทรถ</option>
                                        <?php
                                        $sql_seVehicletype = "{call megVehicletype_v2(?)}";
                                        $params_seVehicletype = array(
                                            array('select_vehicletypegetway', SQLSRV_PARAM_IN)
                                        );
                                        $query_seVehicletype = sqlsrv_query($conn, $sql_seVehicletype, $params_seVehicletype);
                                        while ($result_seVehicletype = sqlsrv_fetch_array($query_seVehicletype, SQLSRV_FETCH_ASSOC)) {
                                            $selected = "";
                                            if ($result_sePrice["VEHICLETYPE"] == $result_seVehicletype['VEHICLETYPECODE']) {
                                                $selected = "SELECTED";
                                            }
                                            ?>
                                            <option   value ="<?= $result_seVehicletype['VEHICLETYPECODE'] ?>"<?= $selected ?>><?= $result_seVehicletype['VEHICLETYPEDESC'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>

                                </div>


                                <div class="col-lg-3">
                                    <font style="color: red">* </font><label>ต้นทาง :</label>
                                    <input type="text" class="form-control"  id="txt_copydiagramjobstart" name="txt_copydiagramjobstart"> 
                                </div>
                                <!--<div class="col-lg-2">
                                    <label>ก่อนเวลารายงานตัว (OTH) :</label>
                                    <input type="text" class="form-control"  id="txt_beforpersentoth"  name="txt_beforpersentoth"> 
                                </div>
                                -->
                                <!--
                                <div class="col-lg-2">
                                    <font style="color: red">* </font><label>CLUSTER :</label>

                                    <div class="dropdown bootstrap-select show-tick form-control">

                                        <select multiple="" onchange="select_cluster()" id="cb_copydiagramcluster" name="cb_copydiagramcluster" class="selectpicker form-control" id="number-multiple" data-container="body" data-live-search="true" title="เลือก cluster..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98">
                                <?php
                                /* $sql_seCluster = "{call megVehicletransportprice_v2(?,?)}";
                                  $params_seCluster = array(
                                  array('select_cluster', SQLSRV_PARAM_IN),
                                  array('', SQLSRV_PARAM_IN)
                                  );
                                  $query_seCluster = sqlsrv_query($conn, $sql_seCluster, $params_seCluster);
                                  while ($result_seCluster = sqlsrv_fetch_array($query_seCluster, SQLSRV_FETCH_ASSOC)) {
                                  ?>
                                  <option value="<?= $result_seCluster['CLUSTER'] ?>"><?= $result_seCluster['CLUSTER'] ?></option>
                                  <?php
                                  } */
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
                                -->
                                <div class="col-lg-3">
                                    <font style="color: red">* </font><label>ปลายทาง :</label>
                                    <input type="text" class="form-control"  id="txt_copydiagramjobend" name="txt_copydiagramjobend"> 
                                </div>
                                <!--
                                <div class="col-lg-2">
                                    <font style="color: red">* </font><label>ปลายทาง :</label>
                                    <div id="data_copydiagramjobenddef">
                                        <div class="dropdown bootstrap-select show-tick form-control">

                                            <select multiple="" id="cb_copydiagramjobend" name="cb_copydiagramjobend" class="selectpicker form-control" id="number-multiple" data-container="body" data-live-search="true" title="เลือก ปลายทาง..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98">

                                            </select>
                                            <input class="form-control" style="display: none"  id="txt_copydiagramjobend" name="txt_copydiagramjobend" maxlength="500" value="" >


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
                                -->

                            </div>

                            <div class="row">&nbsp;</div>
                            <div class="row">
                                <div class="col-lg-2">
                                    <font style="color: red">* </font><label>เวลาทำแผน :</label>
                                    <input type="text" class="form-control" value="<?= $result_seSystime['SYSTIME'] ?>" style="background-color: #f080802e" disabled="" id="txt_copydiagramdateinput" name="txt_copydiagramdateinput">
                                </div>
                                <div class="col-lg-2">
                                    <font style="color: red">* </font><label>เวลารายงานตัว :</label>
                                    <input type="text" class="form-control timeen" style="background-color: #f080802e" disabled="" id="txt_copydiagramdatepresent" name="txt_copydiagramdatepresent">

                                </div>
                                <div class="col-lg-2">
                                    <font style="color: red">* </font><label>เวลาเข้าวีแอล ( <input type="checkbox" id="chk_copydiagramdatevlin" name="chk_copydiagramdatevlin" onchange="change_textboxdate()"> : ข้ามวัน )</label>
                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatevlin" name="txt_copydiagramdatevlin" onchange="show_timepresent(this.value)">
                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdatevlin2" name="txt_copydiagramdatevlin2" onchange="show_timepresent(this.value)" style="display: none">
                                </div>
                                <div class="col-lg-2">
                                    <font style="color: red">* </font><label>เวลาออกวีแอล ( <input type="checkbox" id="chk_copydiagramdatevlout" name="chk_copydiagramdatevlout" onchange="change_textboxdate()"> : ข้ามวัน )</label>
                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatevlout" name="txt_copydiagramdatevlout">
                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdatevlout2" name="txt_copydiagramdatevlout2" style="display: none">
                                </div>
                                <div class="col-lg-2">
                                    <font style="color: red">* </font><label>เวลาเข้าดีลเลอร์ ( <input type="checkbox" id="chk_copydiagramdatedealerin" name="chk_copydiagramdatedealerin" onchange="change_textboxdate()"> : ข้ามวัน )</label>
                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatedealerin" name="txt_copydiagramdatedealerin">
                                    <input type="text" class="form-control  datetimeen" id="txt_copydiagramdatedealerin2" name="txt_copydiagramdatedealerin2" style="display: none">
                                </div>
                                <div class="col-lg-2">
                                    <font style="color: red">* </font><label>เวลากลับบริษัท ( <input type="checkbox" id="chk_copydiagramdatereturn" name="chk_copydiagramdatereturn" onchange="change_textboxdate()"> : ข้ามวัน )</label>
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
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                            <button type="button" class="btn btn-primary" onclick="save_copydiagram()">บันทึก</button>
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
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
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
                        <input class="btn btn-default" type="button" style="background-color: red;border:solid 2px #666" id="btn_srquotation" name="btn_srquotation" value=""> * แจ้งเตือนข้อมูล ไม่พบราคาขนส่ง &emsp;
                        <input type="text" id="txt_vehicletransportdocumentid" name="txt_vehicletransportdocumentid" class="form-control" style="display: none"  value="">
                        <input type="text" id="txt_companycode" name="txt_companycode" class="form-control" style="display: none"  value="<?= $_GET['companycode'] ?>">
                        <input type="text" id="txt_customercode" name="txt_customercode" class="form-control" style="display: none"  value="<?= $_GET['customercode'] ?>">

                        <!--<button type="button" id="addrow" name="addrow" onclick="javascript:appendRow()" class="btn btn-outline btn-default"><li class="fa fa-plus-circle"></li> เพิ่มแถว</button>-->
                        <input  style="margin-right: 15px" type="button"  data-toggle="modal"  data-target="#modal_copydiagram"  class=" btn btn-default" value="NEW DIAGRAM">
                        <input  style="margin-right: 15px"  type="button"  onclick="save_vehicletransportplan('<?php echo $_GET['EMPLOYEENAME1'] ?>')"  class=" btn btn-default" value="NEW JOB">
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

                            <?php
                            $meg = 'แผนขนส่ง';
                            echo "<a href='report_company.php'>บริษัท</a> / <a href='report_customer.php?type=report&companycode=" . $_GET['companycode'] . "'>ลูกค้า</a>  / " . $meg;
                            $link = "<a href='report_company.php?type=report'>บริษัท</a> / <a href='report_customer.php?type=report&companycode=" . $_GET['companycode'] . "'>ลูกค้า</a> ";
                            $_SESSION["link"] = $link;
                            ?>
                        </div>
                        <!-- /.panel-heading -->

                        <div class="panel-body">

                            <div class="row" >
                                <div class="col-lg-4"><br>
                                    <a href="#" onclick="pdf_transportplan();" class="btn btn-default">PDF <li class="fa fa-print"></li></a>
                                </div>

                                <div class="col-lg-2">&nbsp;</div>
                                <div class="col-lg-2" >วันที่เริ่มต้น
                                    <input type="text" value="<?= $result_seSystime['STARTWEEK']; ?>" name="txt_datestartsr" readonly="" id="txt_datestartsr" onchange="add_dateweek1(this.value)" class="form-control dateen" >
                                </div>

                                <div class="col-lg-2" >วันที่สิ้นสุด
                                    <input type="text" value="<?= $result_seSystime['ENDWEEK']; ?>" name="txt_dateendsr" style="background-color: #f080802e"  disabled=""  id="txt_dateendsr" class="form-control dateen" >    
                                </div>
                                <div class="col-lg-2 " >สถานะ
                                    <select  class="form-control" id="cb_statussr" name="cb_statussr" onchange="dateendsr()">
                                        <option   value ="">เลือกสถานะ</option>
                                        <option   value ="0">แผนงานยกเลิก</option>
                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                        <option   value ="5">ปิดงาน</option>

                                    </select>
                                </div>

                            </div>
                            <div class="row" >&nbsp;</div>

                            <div id="showdatadef">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a href="#monday" data-toggle="tab" aria-expanded="true">จันทร์<label id="lbl_m"></label></a>
                                            </li>
                                            <li class=""><a href="#tuesday" data-toggle="tab" aria-expanded="true">อังคาร<label id="lbl_tu"></label></a>
                                            </li>
                                            <li class=""><a href="#wednesday" data-toggle="tab" aria-expanded="false">พุธ<label id="lbl_w"></label></a>
                                            </li>

                                            <li class=""><a href="#thursday" data-toggle="tab" aria-expanded="false">พฤหัสบดี<label id="lbl_th"></label></a>

                                            <li class=""><a href="#friday" data-toggle="tab" aria-expanded="false">ศุกร์<label id="lbl_f"></label></a>
                                            </li>
                                            <li class=""><a href="#saturday" data-toggle="tab" aria-expanded="false">เสาร์<label id="lbl_sat"></label></a>
                                            </li>
                                            <li class=""><a href="#sunday" data-toggle="tab" aria-expanded="false">อาทิตย์<label id="lbl_sun"></label></a>
                                            </li>
                                        </ul>

                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <p>&nbsp;</p>


                                            <div class="tab-pane fade active in" id="monday">

                                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                                    <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example11" role="grid" aria-describedby="dataTables-example11" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th style="display: none">&nbsp;</th>
                                                                <th style="text-align: center;"><label style="width: 50px">DELETE JOB</label></th>
                                                                <th style="text-align: center;"><label style="width: 50px">COPY ROOT</label></th>
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
                                                                $conditionmonday = ($_GET['vehicletransportplanid'] != "") ? "  AND DATENAME(DW,a.DATEPRESENT) = 'Monday' AND a.COMPANYCODE ='" . $_GET['companycode'] . "' AND a.CUSTOMERCODE ='" . $_GET['customercode'] . "' AND a.VEHICLETRANSPORTPLANID = '" . $_GET['vehicletransportplanid'] . "'" : " AND DATENAME(DW,a.DATEPRESENT) = 'Monday' AND a.CUSTOMERCODE ='" . $_GET['customercode'] . "'";
                                                            } else {
                                                                $conditionmonday = "  AND DATENAME(DW,a.DATEPRESENT) = 'Monday'";
                                                            }


                                                            $sql_sePlanmonday = "{call megVehicletransportplan_v2(?,?)}";
                                                            $params_sePlanmonday = array(
                                                                array('select_vehicletransportplan', SQLSRV_PARAM_IN),
                                                                array($conditionmonday, SQLSRV_PARAM_IN)
                                                            );
                                                            $query_sePlanmonday = sqlsrv_query($conn, $sql_sePlanmonday, $params_sePlanmonday);
                                                            while ($result_sePlanmonday = sqlsrv_fetch_array($query_sePlanmonday, SQLSRV_FETCH_ASSOC)) {
                                                                ?>
                                                                <tr 
                                                                <?php
                                                                if (($result_sePlanmonday['SRBASE4L'] == '' || $result_sePlanmonday['SRBASE4L'] == '0.00') &&
                                                                        ($result_sePlanmonday['SRBASE8L'] == '' || $result_sePlanmonday['SRBASE8L'] == '0.00') &&
                                                                        ($result_sePlanmonday['GWBASE4L'] == '' || $result_sePlanmonday['GWBASE4L'] == '0.00') &&
                                                                        ($result_sePlanmonday['GWBASE8L'] == '' || $result_sePlanmonday['GWBASE8L'] == '0.00') &&
                                                                        ($result_sePlanmonday['BPBASE4L'] == '' || $result_sePlanmonday['BPBASE4L'] == '0.00') &&
                                                                        ($result_sePlanmonday['BPBASE8L'] == '' || $result_sePlanmonday['BPBASE8L'] == '0.00') &&
                                                                        ($result_sePlanmonday['OTHBASE4L'] == '' || $result_sePlanmonday['OTHBASE4L'] == '0.00') &&
                                                                        ($result_sePlanmonday['OTHBASE8L'] == '' || $result_sePlanmonday['OTHBASE8L'] == '0.00')) {
                                                                    ?>
                                                                        style="color: red"
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    >
                                                                    <td style="display: none">&nbsp;</td>

                                                                    <td style="text-align: center;">
                                                                        <button onclick="delete_vehicletransportplan('<?= $result_sePlanmonday['VEHICLETRANSPORTPLANID'] ?>');" title="ลบแผนการขนส่ง" type="button" class="btn btn-default btn-circle"><span class="fa fa-times"></span></button> 
                                                                    </td>
                                                                    <td style="text-align: center;">
                                                                        <button onclick="add_vehicletransportplanroot('<?= $result_sePlanmonday['CUSTOMERCODE'] ?>', '<?= $result_sePlanmonday['COMPANYCODE'] ?>', '<?= $result_sePlanmonday['VEHICLEREGISNUMBER1'] ?>', '<?= $result_sePlanmonday['VEHICLEREGISNUMBER2'] ?>', '<?= $result_sePlanmonday['THAINAME'] ?>', '<?= $result_sePlanmonday['ENGNAME'] ?>', '<?= $result_sePlanmonday['VEHICLETRANSPORTPRICEID'] ?>', '<?= $result_sePlanmonday['CLUSTER'] ?>', '<?= $result_sePlanmonday['DEALERCODE'] ?>', '<?= $result_sePlanmonday['NAME'] ?>', '<?= $result_sePlanmonday['SRBASE4L'] ?>', '<?= $result_sePlanmonday['SRBASE8L'] ?>', '<?= $result_sePlanmonday['GWBASE4L'] ?>', '<?= $result_sePlanmonday['GWBASE8L'] ?>', '<?= $result_sePlanmonday['BPBASE4L'] ?>', '<?= $result_sePlanmonday['BPBASE8L'] ?>', '<?= $result_sePlanmonday['OTHBASE4L'] ?>', '<?= $result_sePlanmonday['OTHBASE8L'] ?>', '<?= $result_sePlanmonday['E1'] ?>', '<?= $result_sePlanmonday['E2'] ?>', '<?= $result_sePlanmonday['E3'] ?>', '<?= $result_sePlanmonday['E4'] ?>', '<?= $result_sePlanmonday['C1'] ?>', '<?= $result_sePlanmonday['C2'] ?>', '<?= $result_sePlanmonday['C3'] ?>', '<?= $result_sePlanmonday['C4'] ?>', '<?= $result_sePlanmonday['C5'] ?>', '<?= $result_sePlanmonday['C6'] ?>', '<?= $result_sePlanmonday['C7'] ?>', '<?= $result_sePlanmonday['C8'] ?>', '<?= $result_sePlanmonday['C9'] ?>', '<?= $result_sePlanmonday['O1'] ?>', '<?= $result_sePlanmonday['O2'] ?>', '<?= $result_sePlanmonday['O3'] ?>', '<?= $result_sePlanmonday['O4'] ?>', '<?= $result_sePlanmonday['JOBSTART'] ?>', '<?= $result_sePlanmonday['JOBEND'] ?>', '<?= $result_sePlanmonday['EMPLOYEECODE1'] ?>', '<?= $result_sePlanmonday['EMPLOYEENAME1'] ?>', '<?= $result_sePlanmonday['EMPLOYEECODE2'] ?>', '<?= $result_sePlanmonday['EMPLOYEENAME2'] ?>', '<?= $result_sePlanmonday['EMPLOYEECODE3'] ?>', '<?= $result_sePlanmonday['EMPLOYEENAME3'] ?>', '<?= $result_sePlanmonday['EMPLOYEECODE4'] ?>', '<?= $result_sePlanmonday['EMPLOYEENAME4'] ?>', '<?= $result_sePlanmonday['JOBNO'] ?>', '<?= $result_sePlanmonday['TRIPNO'] ?>', '<?= $result_sePlanmonday['DATEINPUT'] ?>', '<?= $result_sePlanmonday['DATESTART'] ?>', '<?= $result_sePlanmonday['DATEWORKING'] ?>', '<?= $result_sePlanmonday['DATEWORKSUS'] ?>', '<?= $result_sePlanmonday['DATEPRESENT'] ?>', '<?= $result_sePlanmonday['DATEVLIN'] ?>', '<?= $result_sePlanmonday['DATEVLOUT'] ?>', '<?= $result_sePlanmonday['DATEDEALERIN'] ?>', '<?= $result_sePlanmonday['DATERETURN'] ?>', '<?= $result_sePlanmonday['STATUS'] ?>', '<?= $result_sePlanmonday['ACTIVESTATUS'] ?>', '<?= $result_sePlanmonday['REMARK'] ?>')" title="คัดลอกรูทการขนส่ง" type="button" class="btn btn-default btn-circle"><span class="fa fa-copy"></span></button> 
                                                                    </td>
                                                                    <!--<td style="text-align: center;">
                                                                        <button title="เพิ่มเอกสารรายละเอียดสินค้า" type="button" onclick="select_vehicletransportplanid('<?= $result_sePlanmonday['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_sePlanmonday['JOBSTART'] ?>', '<?= $result_sePlanmonday['JOBEND'] ?>');" class="btn btn-default btn-circle" data-toggle="modal" data-target="#modal_adddn"><span class="fa fa-plus"></span></button>
                                                                    </td>-->
                                                                    <td style="text-align: center;">
                                                                        <button title="COPY JOB" type="button" onclick="select_copyjob('<?= $result_sePlanmonday['JOBSTART'] ?>', '<?= $result_sePlanmonday['JOBEND'] ?>', '<?= $result_sePlanmonday['DATEVLIN'] ?>');" class="btn btn-default btn-circle" data-toggle="modal"  data-target="#modal_copyjob"><span class="fa fa-copy"></span></button>
                                                                    </td>



                                                                    <td>
                                                                        <input type="text" size="20"   name="txt_employeem1<?= $i1 ?>" id="txt_employeem1<?= $i1 ?>"  onchange="edit_vehicletransportplan(this.value, 'EMPLOYEENAME1', '<?= $result_sePlanmonday['VEHICLETRANSPORTPLANID'] ?>')"   class="form-control" value="<?= $result_sePlanmonday['EMPLOYEENAME1'] ?>">
                                                                        <label style="display: none"><?= $result_sePlanmonday['EMPLOYEENAME1'] ?></label>

                                                                    </td>



                                                                    <td>
                                                                        <input type="text" size="20"   name="txt_employeem2<?= $i1 ?>"  id="txt_employeem2<?= $i1 ?>"  onchange="edit_vehicletransportplan(this.value, 'EMPLOYEENAME2', '<?= $result_sePlanmonday['VEHICLETRANSPORTPLANID'] ?>')"   class="form-control" value="<?= $result_sePlanmonday['EMPLOYEENAME2'] ?>">
                                                                        <label style="display: none"><?= $result_sePlanmonday['EMPLOYEENAME2'] ?></label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" size="20"  name="txt_carm<?= $i1 ?>"  id="txt_carm<?= $i1 ?>"   onchange="edit_vehicletransportplan(this.value, 'THAINAME', '<?= $result_sePlanmonday['VEHICLETRANSPORTPLANID'] ?>')"   class="form-control" value="<?= $result_sePlanmonday['THAINAME'] ?>">
                                                                        <label style="display: none"><?= $result_sePlanmonday['THAINAME'] ?></label>
                                                                    </td>



                                                                    <td>
                                                                        <input type="text" size="20"  name="txt_jobstartm<?= $i1 ?>" id="txt_jobstartm<?= $i1 ?>"  onchange="edit_vehicletransportplan(this.value, 'JOBSTART', '<?= $result_sePlanmonday['VEHICLETRANSPORTPLANID'] ?>')"   class="form-control" value="<?= $result_sePlanmonday['JOBSTART'] ?>">
                                                                        <label style="display: none"><?= $result_sePlanmonday['JOBSTART'] ?></label>
                                                                    </td>


                                                                    <td>
                                                                        <input type="text"  size="20" name="txt_clusterm<?= $i1 ?>" id="txt_clusterm<?= $i1 ?>"  onchange="select_vehicletransportplanjobend(this.value, 'CLUSTER', '<?= $result_sePlanmonday['VEHICLETRANSPORTPLANID'] ?>', 'cb_jobendm<?= $i1 ?>')"   class="form-control" value="<?= $result_sePlanmonday['CLUSTER'] ?>">
                                                                        <label style="display: none"><?= $result_sePlanmonday['CLUSTER'] ?></label>
                                                                    </td>

                                                                    <td>
                                                                        <div id="data_clusterdefcb_jobendm<?= $i1 ?>">
                                                                            <select title="ปลายทาง" class="selectpicker" multiple="" data-actions-box="true"  id="cb_jobendm<?= $i1 ?>" name="cb_jobendm<?= $i1 ?>" >

                                                                                <?php
                                                                                $conditionJobend = " AND a.VEHICLETRANSPORTPLANID='" . $result_sePlanmonday['VEHICLETRANSPORTPLANID'] . "' AND a.CLUSTER='" . $result_sePlanmonday['CLUSTER'] . "'";
                                                                                $sql_seJobend = "{call megVehicletransportplan_v2(?,?)}";
                                                                                $params_seJobend = array(
                                                                                    array('select_jobend', SQLSRV_PARAM_IN),
                                                                                    array($conditionJobend, SQLSRV_PARAM_IN)
                                                                                );
                                                                                $query_seJobend = sqlsrv_query($conn, $sql_seJobend, $params_seJobend);
                                                                                while ($result_seJobend = sqlsrv_fetch_array($query_seJobend, SQLSRV_FETCH_ASSOC)) {

                                                                                    $arr_ph = explode(",", $result_seJobend['JOBEND']);
                                                                                    foreach ($arr_ph as $i) {
                                                                                        ?>
                                                                                        <option value = "<?= $i ?>"><?= $i ?></option>
                                                                                        <?php
                                                                                    }
                                                                                }
                                                                                ?>



                                                                            </select>
                                                                        </div>
                                                                        <div id="data_clustersrcb_jobendm<?= $i1 ?>"></div>

                                                                    </td>
                                                                    <td ><p style="width: 150px"><?= $result_sePlanmonday['JOBNO'] ?></p></td>
                                                                    <td contenteditable="true"  onkeyup="edit_vehicletransportplaninner(this, 'TRIPNO', '<?= $result_sePlanmonday['VEHICLETRANSPORTPLANID'] ?>')"><?= $result_sePlanmonday['TRIPNO'] ?></td>

                                                                    <td><input type="text" size="20" id="txt_dateinput" name="txt_dateinput" disabled=""   onchange="edit_datevehicletransportplan(this.value, 'DATEINPUT', '<?= $result_sePlanmonday['VEHICLETRANSPORTPLANID'] ?>')"  class="form-control datetimeen"  value="<?= $result_sePlanmonday['DATEINPUT'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_dateworking" name="txt_dateworking"  onchange="edit_datevehicletransportplan(this.value, 'DATEWORKING', '<?= $result_sePlanmonday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlanmonday['DATEWORKING'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_dateworksus" name="txt_dateworksus"  onchange="edit_datevehicletransportplan(this.value, 'DATEWORKSUS', '<?= $result_sePlanmonday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlanmonday['DATEWORKSUS'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_datepresent" name="txt_datepresent"  onchange="edit_datevehicletransportplan(this.value, 'DATEPRESENT', '<?= $result_sePlanmonday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlanmonday['DATEPRESENT'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_datevlin" name="txt_datevlin"  onchange="edit_datevehicletransportplan(this.value, 'DATEVLIN', '<?= $result_sePlanmonday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlanmonday['DATEVLIN'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_datevlout" name="txt_datevlout"  onchange="edit_datevehicletransportplan(this.value, 'DATEVLOUT', '<?= $result_sePlanmonday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlanmonday['DATEVLOUT'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_datedealerin" name="txt_datedealerin"  onchange="edit_datevehicletransportplan(this.value, 'DATEDEALERIN', '<?= $result_sePlanmonday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlanmonday['DATEDEALERIN'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_datereturn" name="txt_datereturn"  onchange="edit_datevehicletransportplan(this.value, 'DATERETURN', '<?= $result_sePlanmonday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlanmonday['DATERETURN'] ?>"></td>




                                                                    <td >
                                                                        <select  style="width: 150px" class="form-control" id="cb_status" name="cb_status" onchange = "update_vehicletransportplanjob('<?= $result_sePlanmonday['VEHICLETRANSPORTPLANID'] ?>', this.value, )">
                                                                            <option   value ="">เลือกสถานะ</option>
                                                                            <?php
                                                                            switch ($result_sePlanmonday['STATUSNUMBER']) {
                                                                                case '0': {
                                                                                        ?>
                                                                                        <option  selected=""  value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                case '1': {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   selected="" value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                case '2': {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option  selected="" value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;

                                                                                case '3': {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option selected=""  value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                case '4': {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option selected=""  value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                case '5': {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option  selected="" value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                default : {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                            }
                                                                            ?>


                                                                        </select>
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
                                            <div class="tab-pane fade " id="tuesday">
                                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                                    <table  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example22" role="grid" aria-describedby="dataTables-example22" style="width: 100%;">
                                                        <thead >
                                                            <tr>
                                                                <th style="display: none">&nbsp;</th>
                                                                <th style="text-align: center;"><label style="width: 50px">DELETE JOB</label></th>
                                                                <th style="text-align: center;"><label style="width: 50px">COPY ROOT</label></th>
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

                                                            </tr>

                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i2 = 1;
                                                            if ($_GET['vehicletransportplanid'] != "") {
                                                                $conditiontuesday = ($_GET['vehicletransportplanid'] != "") ? "  AND DATENAME(DW,a.DATEPRESENT) = 'Tuesday' AND a.COMPANYCODE ='" . $_GET['companycode'] . "' AND a.CUSTOMERCODE ='" . $_GET['customercode'] . "' AND a.VEHICLETRANSPORTPLANID = '" . $_GET['vehicletransportplanid'] . "' " : "  AND DATENAME(DW,a.DATEPRESENT) = 'Tuesday' AND a.CUSTOMERCODE ='" . $_GET['customercode'] . "'";
                                                            } else {
                                                                $conditiontuesday = "  AND DATENAME(DW,a.DATEPRESENT) = 'Tuesday'";
                                                            }

                                                            $sql_sePlantuesday = "{call megVehicletransportplan_v2(?,?)}";
                                                            $params_sePlantuesday = array(
                                                                array('select_vehicletransportplan', SQLSRV_PARAM_IN),
                                                                array($conditiontuesday, SQLSRV_PARAM_IN)
                                                            );
                                                            $query_sePlantuesday = sqlsrv_query($conn, $sql_sePlantuesday, $params_sePlantuesday);
                                                            while ($result_sePlantuesday = sqlsrv_fetch_array($query_sePlantuesday, SQLSRV_FETCH_ASSOC)) {
                                                                ?>
                                                                <tr 
                                                                <?php
                                                                if (($result_sePlantuesday['SRBASE4L'] == '' || $result_sePlantuesday['SRBASE4L'] == '0.00') &&
                                                                        ($result_sePlantuesday['SRBASE8L'] == '' || $result_sePlantuesday['SRBASE8L'] == '0.00') &&
                                                                        ($result_sePlantuesday['GWBASE4L'] == '' || $result_sePlantuesday['GWBASE4L'] == '0.00') &&
                                                                        ($result_sePlantuesday['GWBASE8L'] == '' || $result_sePlantuesday['GWBASE8L'] == '0.00') &&
                                                                        ($result_sePlantuesday['BPBASE4L'] == '' || $result_sePlantuesday['BPBASE4L'] == '0.00') &&
                                                                        ($result_sePlantuesday['BPBASE8L'] == '' || $result_sePlantuesday['BPBASE8L'] == '0.00') &&
                                                                        ($result_sePlantuesday['OTHBASE4L'] == '' || $result_sePlantuesday['OTHBASE4L'] == '0.00') &&
                                                                        ($result_sePlantuesday['OTHBASE8L'] == '' || $result_sePlantuesday['OTHBASE8L'] == '0.00')) {
                                                                    ?>
                                                                        style="color: red"
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    >
                                                                    <td style="display: none">&nbsp;</td>

                                                                    <td style="text-align: center;">
                                                                        <button onclick="delete_vehicletransportplan('<?= $result_sePlantuesday['VEHICLETRANSPORTPLANID'] ?>');" title="ลบแผนการขนส่ง" type="button" class="btn btn-default btn-circle"><span class="fa fa-times"></span></button> 
                                                                    </td>
                                                                    <td style="text-align: center;">
                                                                        <button onclick="add_vehicletransportplanroot('<?= $result_sePlantuesday['CUSTOMERCODE'] ?>', '<?= $result_sePlantuesday['COMPANYCODE'] ?>', '<?= $result_sePlantuesday['VEHICLEREGISNUMBER1'] ?>', '<?= $result_sePlantuesday['VEHICLEREGISNUMBER2'] ?>', '<?= $result_sePlantuesday['THAINAME'] ?>', '<?= $result_sePlantuesday['ENGNAME'] ?>', '<?= $result_sePlantuesday['VEHICLETRANSPORTPRICEID'] ?>', '<?= $result_sePlantuesday['CLUSTER'] ?>', '<?= $result_sePlantuesday['DEALERCODE'] ?>', '<?= $result_sePlantuesday['NAME'] ?>', '<?= $result_sePlantuesday['SRBASE4L'] ?>', '<?= $result_sePlantuesday['SRBASE8L'] ?>', '<?= $result_sePlantuesday['GWBASE4L'] ?>', '<?= $result_sePlantuesday['GWBASE8L'] ?>', '<?= $result_sePlantuesday['BPBASE4L'] ?>', '<?= $result_sePlantuesday['BPBASE8L'] ?>', '<?= $result_sePlantuesday['OTHBASE4L'] ?>', '<?= $result_sePlantuesday['OTHBASE8L'] ?>', '<?= $result_sePlantuesday['E1'] ?>', '<?= $result_sePlantuesday['E2'] ?>', '<?= $result_sePlantuesday['E3'] ?>', '<?= $result_sePlantuesday['E4'] ?>', '<?= $result_sePlantuesday['C1'] ?>', '<?= $result_sePlantuesday['C2'] ?>', '<?= $result_sePlantuesday['C3'] ?>', '<?= $result_sePlantuesday['C4'] ?>', '<?= $result_sePlantuesday['C5'] ?>', '<?= $result_sePlantuesday['C6'] ?>', '<?= $result_sePlantuesday['C7'] ?>', '<?= $result_sePlantuesday['C8'] ?>', '<?= $result_sePlantuesday['C9'] ?>', '<?= $result_sePlantuesday['O1'] ?>', '<?= $result_sePlantuesday['O2'] ?>', '<?= $result_sePlantuesday['O3'] ?>', '<?= $result_sePlantuesday['O4'] ?>', '<?= $result_sePlantuesday['JOBSTART'] ?>', '<?= $result_sePlantuesday['JOBEND'] ?>', '<?= $result_sePlantuesday['EMPLOYEECODE1'] ?>', '<?= $result_sePlantuesday['EMPLOYEENAME1'] ?>', '<?= $result_sePlantuesday['EMPLOYEECODE2'] ?>', '<?= $result_sePlantuesday['EMPLOYEENAME2'] ?>', '<?= $result_sePlantuesday['EMPLOYEECODE3'] ?>', '<?= $result_sePlantuesday['EMPLOYEENAME3'] ?>', '<?= $result_sePlantuesday['EMPLOYEECODE4'] ?>', '<?= $result_sePlantuesday['EMPLOYEENAME4'] ?>', '<?= $result_sePlantuesday['JOBNO'] ?>', '<?= $result_sePlantuesday['TRIPNO'] ?>', '<?= $result_sePlantuesday['DATEINPUT'] ?>', '<?= $result_sePlantuesday['DATESTART'] ?>', '<?= $result_sePlantuesday['DATEWORKING'] ?>', '<?= $result_sePlantuesday['DATEWORKSUS'] ?>', '<?= $result_sePlantuesday['DATEPRESENT'] ?>', '<?= $result_sePlantuesday['DATEVLIN'] ?>', '<?= $result_sePlantuesday['DATEVLOUT'] ?>', '<?= $result_sePlanmonday['DATEDEALERIN'] ?>', '<?= $result_sePlantuesday['DATERETURN'] ?>', '<?= $result_sePlantuesday['STATUS'] ?>', '<?= $result_sePlantuesday['ACTIVESTATUS'] ?>', '<?= $result_sePlantuesday['REMARK'] ?>')" title="คัดลอกรูทการขนส่ง" type="button" class="btn btn-default btn-circle"><span class="fa fa-copy"></span></button> 
                                                                    </td>
                                                                    <!--<td style="text-align: center;">
                                                                        <button title="เพิ่มเอกสารรายละเอียดสินค้า" type="button" onclick="select_vehicletransportplanid('<?= $result_sePlantuesday['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_sePlantuesday['JOBSTART'] ?>', '<?= $result_sePlantuesday['JOBEND'] ?>');" class="btn btn-default btn-circle" data-toggle="modal" data-target="#modal_adddn"><span class="fa fa-plus"></span></button>
                                                                    </td>-->
                                                                    <td style="text-align: center;">
                                                                        <button title="COPY JOB" type="button" onclick="select_copyjob('<?= $result_sePlantuesday['JOBSTART'] ?>', '<?= $result_sePlantuesday['JOBEND'] ?>', '<?= $result_sePlantuesday['DATEVLIN'] ?>');" class="btn btn-default btn-circle" data-toggle="modal"  data-target="#modal_copyjob"><span class="fa fa-copy"></span></button>
                                                                    </td>

                                                                    <td>
                                                                        <input type="text" size="20"   name="txt_employeetu1<?= $i2 ?>" id="txt_employeetu1<?= $i2 ?>"  onchange="edit_vehicletransportplan(this.value, 'EMPLOYEENAME1', '<?= $result_sePlantuesday['VEHICLETRANSPORTPLANID'] ?>')"   class="form-control" value="<?= $result_sePlantuesday['EMPLOYEENAME1'] ?>">
                                                                        <label style="display: none"><?= $result_sePlantuesday['EMPLOYEENAME1'] ?></label>
                                                                    </td>



                                                                    <td>
                                                                        <input type="text" size="20"  name="txt_employeetu2<?= $i2 ?>"  id="txt_employeetu2<?= $i2 ?>"  onchange="edit_vehicletransportplan(this.value, 'EMPLOYEENAME2', '<?= $result_sePlantuesday['VEHICLETRANSPORTPLANID'] ?>')"   class="form-control" value="<?= $result_sePlantuesday['EMPLOYEENAME2'] ?>">
                                                                        <label style="display: none"><?= $result_sePlantuesday['EMPLOYEENAME2'] ?></label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" size="20"  name="txt_cartu<?= $i2 ?>"  id="txt_cartu<?= $i2 ?>"   onchange="edit_vehicletransportplan(this.value, 'THAINAME', '<?= $result_sePlantuesday['VEHICLETRANSPORTPLANID'] ?>')"   class="form-control" value="<?= $result_sePlantuesday['THAINAME'] ?>">
                                                                        <label style="display: none"><?= $result_sePlantuesday['THAINAME'] ?></label>
                                                                    </td>


                                                                    <td>
                                                                        <input type="text" size="20"   name="txt_jobstarttu<?= $i2 ?>" id="txt_jobstarttu<?= $i2 ?>"  onchange="edit_vehicletransportplan(this.value, 'JOBSTART', '<?= $result_sePlantuesday['VEHICLETRANSPORTPLANID'] ?>')"   class="form-control" value="<?= $result_sePlantuesday['JOBSTART'] ?>">
                                                                        <label style="display: none"><?= $result_sePlantuesday['JOBSTART'] ?></label>
                                                                    </td>

                                                                    <td>
                                                                        <input type="text" size="20"  name="txt_clustertu<?= $i2 ?>" id="txt_clustertu<?= $i2 ?>"  onchange="select_vehicletransportplanjobend(this.value, 'CLUSTER', '<?= $result_sePlantuesday['VEHICLETRANSPORTPLANID'] ?>', 'cb_jobendtu<?= $i2 ?>')"   class="form-control" value="<?= $result_sePlantuesday['CLUSTER'] ?>">
                                                                        <label style="display: none"><?= $result_sePlantuesday['CLUSTER'] ?></label>
                                                                    </td>

                                                                    <td>
                                                                        <div id="data_clusterdefcb_jobendtu<?= $i2 ?>">
                                                                            <select title="ปลายทาง" class="selectpicker" multiple="" data-actions-box="true"  id="cb_jobendtu<?= $i2 ?>" name="cb_jobendtu<?= $i2 ?>" >

                                                                                <?php
                                                                                $conditionJobend = " AND a.VEHICLETRANSPORTPLANID='" . $result_sePlantuesday['VEHICLETRANSPORTPLANID'] . "' AND a.CLUSTER='" . $result_sePlantuesday['CLUSTER'] . "'";
                                                                                $sql_seJobend = "{call megVehicletransportplan_v2(?,?)}";
                                                                                $params_seJobend = array(
                                                                                    array('select_jobend', SQLSRV_PARAM_IN),
                                                                                    array($conditionJobend, SQLSRV_PARAM_IN)
                                                                                );
                                                                                $query_seJobend = sqlsrv_query($conn, $sql_seJobend, $params_seJobend);
                                                                                while ($result_seJobend = sqlsrv_fetch_array($query_seJobend, SQLSRV_FETCH_ASSOC)) {

                                                                                    $arr_ph = explode(",", $result_seJobend['JOBEND']);
                                                                                    foreach ($arr_ph as $i) {
                                                                                        ?>
                                                                                        <option value = "<?= $i ?>"><?= $i ?></option>
                                                                                        <?php
                                                                                    }
                                                                                }
                                                                                ?>



                                                                            </select>
                                                                        </div>
                                                                        <div id="data_clustersrcb_jobendtu<?= $i2 ?>"></div>

                                                                    </td>

                                                                    <td ><p style="width: 150px"><?= $result_sePlantuesday['JOBNO'] ?></p></td>
                                                                    <td contenteditable="true"  onkeyup="edit_vehicletransportplaninner(this, 'TRIPNO', '<?= $result_sePlantuesday['VEHICLETRANSPORTPLANID'] ?>')"><?= $result_sePlantuesday['TRIPNO'] ?></td>

                                                                    <td><input type="text" size="20" id="txt_dateinput" name="txt_dateinput"  onchange="edit_datevehicletransportplan(this.value, 'DATEINPUT', '<?= $result_sePlantuesday['VEHICLETRANSPORTPLANID'] ?>')"  class="form-control datetimeen"  value="<?= $result_sePlantuesday['DATEINPUT'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_dateworking" name="txt_dateworking"  onchange="edit_datevehicletransportplan(this.value, 'DATEWORKING', '<?= $result_sePlantuesday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlantuesday['DATEWORKING'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_dateworksus" name="txt_dateworksus"  onchange="edit_datevehicletransportplan(this.value, 'DATEWORKSUS', '<?= $result_sePlantuesday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlantuesday['DATEWORKSUS'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_datepresent" name="txt_datepresent"  onchange="edit_datevehicletransportplan(this.value, 'DATEPRESENT', '<?= $result_sePlantuesday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlantuesday['DATEPRESENT'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_datevlin" name="txt_datevlin"  onchange="edit_datevehicletransportplan(this.value, 'DATEVLIN', '<?= $result_sePlantuesday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlantuesday['DATEVLIN'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_datevlout" name="txt_datevlout"  onchange="edit_datevehicletransportplan(this.value, 'DATEVLOUT', '<?= $result_sePlantuesday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlantuesday['DATEVLOUT'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_datedealerin" name="txt_datedealerin"  onchange="edit_datevehicletransportplan(this.value, 'DATEDEALERIN', '<?= $result_sePlantuesday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlantuesday['DATEDEALERIN'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_datereturn" name="txt_datereturn"  onchange="edit_datevehicletransportplan(this.value, 'DATERETURN', '<?= $result_sePlantuesday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlantuesday['DATERETURN'] ?>"></td>




                                                                    <td >
                                                                        <select  style="width: 150px" class="form-control" id="cb_status" name="cb_status" onchange = "update_vehicletransportplanjob('<?= $result_sePlantuesday['VEHICLETRANSPORTPLANID'] ?>', this.value, )">
                                                                            <option   value ="">เลือกสถานะ</option>
                                                                            <?php
                                                                            switch ($result_sePlantuesday['STATUSNUMBER']) {
                                                                                case '0': {
                                                                                        ?>
                                                                                        <option  selected=""  value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                case '1': {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   selected="" value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                case '2': {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option  selected="" value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;

                                                                                case '3': {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option selected=""  value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                case '4': {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option selected=""  value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                case '5': {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option  selected="" value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                default : {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                            }
                                                                            ?>


                                                                        </select>
                                                                    </td> 
                                                                </tr>
                                                                <?php
                                                                $i2++;
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade " id="wednesday">
                                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                                    <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example33" role="grid" aria-describedby="dataTables-example33" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th style="display: none">&nbsp;</th>
                                                                <th style="text-align: center;"><label style="width: 50px">DELETE JOB</label></th>
                                                                <th style="text-align: center;"><label style="width: 50px">COPY ROOT</label></th>
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

                                                            </tr>

                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i3 = 1;
                                                            if ($_GET['vehicletransportplanid'] != "") {
                                                                $conditionwednesday = ($_GET['vehicletransportplanid'] != "") ? "  AND DATENAME(DW,a.DATEPRESENT) = 'Wednesday' AND a.COMPANYCODE ='" . $_GET['companycode'] . "' AND a.CUSTOMERCODE ='" . $_GET['customercode'] . "' AND a.VEHICLETRANSPORTPLANID = '" . $_GET['vehicletransportplanid'] . "' " : "  AND DATENAME(DW,a.DATEPRESENT) = 'Wednesday' AND a.CUSTOMERCODE ='" . $_GET['customercode'] . "'";
                                                            } else {
                                                                $conditionwednesday = "  AND DATENAME(DW,a.DATEPRESENT) = 'Wednesday'";
                                                            }
//echo $condition1;
                                                            $sql_sePlanwednesday = "{call megVehicletransportplan_v2(?,?)}";
                                                            $params_sePlanwednesday = array(
                                                                array('select_vehicletransportplan', SQLSRV_PARAM_IN),
                                                                array($conditionwednesday, SQLSRV_PARAM_IN)
                                                            );
                                                            $query_sePlanwednesday = sqlsrv_query($conn, $sql_sePlanwednesday, $params_sePlanwednesday);
                                                            while ($result_sePlanwednesday = sqlsrv_fetch_array($query_sePlanwednesday, SQLSRV_FETCH_ASSOC)) {
                                                                ?>
                                                                <tr 
                                                                <?php
                                                                if (($result_sePlanwednesday['SRBASE4L'] == '' || $result_sePlanwednesday['SRBASE4L'] == '0.00') &&
                                                                        ($result_sePlanwednesday['SRBASE8L'] == '' || $result_sePlanwednesday['SRBASE8L'] == '0.00') &&
                                                                        ($result_sePlanwednesday['GWBASE4L'] == '' || $result_sePlanwednesday['GWBASE4L'] == '0.00') &&
                                                                        ($result_sePlanwednesday['GWBASE8L'] == '' || $result_sePlanwednesday['GWBASE8L'] == '0.00') &&
                                                                        ($result_sePlanwednesday['BPBASE4L'] == '' || $result_sePlanwednesday['BPBASE4L'] == '0.00') &&
                                                                        ($result_sePlanwednesday['BPBASE8L'] == '' || $result_sePlanwednesday['BPBASE8L'] == '0.00') &&
                                                                        ($result_sePlanwednesday['OTHBASE4L'] == '' || $result_sePlanwednesday['OTHBASE4L'] == '0.00') &&
                                                                        ($result_sePlanwednesday['OTHBASE8L'] == '' || $result_sePlanwednesday['OTHBASE8L'] == '0.00')) {
                                                                    ?>
                                                                        style="color: red"
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    >
                                                                    <td style="display: none">&nbsp;</td>

                                                                    <td style="text-align: center;">
                                                                        <button onclick="delete_vehicletransportplan('<?= $result_sePlanwednesday['VEHICLETRANSPORTPLANID'] ?>');" title="ลบแผนการขนส่ง" type="button" class="btn btn-default btn-circle"><span class="fa fa-times"></span></button> 
                                                                    </td>
                                                                    <td style="text-align: center;">
                                                                        <button onclick="add_vehicletransportplanroot('<?= $result_sePlanwednesday['CUSTOMERCODE'] ?>', '<?= $result_sePlanwednesday['COMPANYCODE'] ?>', '<?= $result_sePlanwednesday['VEHICLEREGISNUMBER1'] ?>', '<?= $result_sePlanwednesday['VEHICLEREGISNUMBER2'] ?>', '<?= $result_sePlanwednesday['THAINAME'] ?>', '<?= $result_sePlanwednesday['ENGNAME'] ?>', '<?= $result_sePlanwednesday['VEHICLETRANSPORTPRICEID'] ?>', '<?= $result_sePlanwednesday['CLUSTER'] ?>', '<?= $result_sePlanwednesday['DEALERCODE'] ?>', '<?= $result_sePlanwednesday['NAME'] ?>', '<?= $result_sePlanwednesday['SRBASE4L'] ?>', '<?= $result_sePlanwednesday['SRBASE8L'] ?>', '<?= $result_sePlanwednesday['GWBASE4L'] ?>', '<?= $result_sePlanwednesday['GWBASE8L'] ?>', '<?= $result_sePlanwednesday['BPBASE4L'] ?>', '<?= $result_sePlanwednesday['BPBASE8L'] ?>', '<?= $result_sePlanwednesday['OTHBASE4L'] ?>', '<?= $result_sePlanwednesday['OTHBASE8L'] ?>', '<?= $result_sePlanwednesday['E1'] ?>', '<?= $result_sePlanwednesday['E2'] ?>', '<?= $result_sePlanwednesday['E3'] ?>', '<?= $result_sePlanwednesday['E4'] ?>', '<?= $result_sePlanwednesday['C1'] ?>', '<?= $result_sePlanwednesday['C2'] ?>', '<?= $result_sePlanwednesday['C3'] ?>', '<?= $result_sePlanwednesday['C4'] ?>', '<?= $result_sePlanwednesday['C5'] ?>', '<?= $result_sePlanwednesday['C6'] ?>', '<?= $result_sePlanwednesday['C7'] ?>', '<?= $result_sePlanwednesday['C8'] ?>', '<?= $result_sePlanwednesday['C9'] ?>', '<?= $result_sePlanwednesday['O1'] ?>', '<?= $result_sePlanwednesday['O2'] ?>', '<?= $result_sePlanwednesday['O3'] ?>', '<?= $result_sePlanwednesday['O4'] ?>', '<?= $result_sePlanwednesday['JOBSTART'] ?>', '<?= $result_sePlanwednesday['JOBEND'] ?>', '<?= $result_sePlanwednesday['EMPLOYEECODE1'] ?>', '<?= $result_sePlanwednesday['EMPLOYEENAME1'] ?>', '<?= $result_sePlanwednesday['EMPLOYEECODE2'] ?>', '<?= $result_sePlanwednesday['EMPLOYEENAME2'] ?>', '<?= $result_sePlanwednesday['EMPLOYEECODE3'] ?>', '<?= $result_sePlanwednesday['EMPLOYEENAME3'] ?>', '<?= $result_sePlanwednesday['EMPLOYEECODE4'] ?>', '<?= $result_sePlanwednesday['EMPLOYEENAME4'] ?>', '<?= $result_sePlanwednesday['JOBNO'] ?>', '<?= $result_sePlanwednesday['TRIPNO'] ?>', '<?= $result_sePlanwednesday['DATEINPUT'] ?>', '<?= $result_sePlanwednesday['DATESTART'] ?>', '<?= $result_sePlanwednesday['DATEWORKING'] ?>', '<?= $result_sePlanwednesday['DATEWORKSUS'] ?>', '<?= $result_sePlanwednesday['DATEPRESENT'] ?>', '<?= $result_sePlanwednesday['DATEVLIN'] ?>', '<?= $result_sePlantuesday['DATEVLOUT'] ?>', '<?= $result_sePlanwednesday['DATEDEALERIN'] ?>', '<?= $result_sePlanwednesday['DATERETURN'] ?>', '<?= $result_sePlanwednesday['STATUS'] ?>', '<?= $result_sePlanwednesday['ACTIVESTATUS'] ?>', '<?= $result_sePlanwednesday['REMARK'] ?>')" title="คัดลอกรูทการขนส่ง" type="button" class="btn btn-default btn-circle"><span class="fa fa-copy"></span></button> 
                                                                    </td>
                                                                    <!--<td style="text-align: center;">
                                                                        <button title="เพิ่มเอกสารรายละเอียดสินค้า" type="button" onclick="select_vehicletransportplanid('<?= $result_sePlanwednesday['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_sePlanwednesday['JOBSTART'] ?>', '<?= $result_sePlanwednesday['JOBEND'] ?>');" class="btn btn-default btn-circle" data-toggle="modal" data-target="#modal_adddn"><span class="fa fa-plus"></span></button>
                                                                    </td>-->
                                                                    <td style="text-align: center;">
                                                                        <button title="COPY JOB" type="button" onclick="select_copyjob('<?= $result_sePlanwednesday['JOBSTART'] ?>', '<?= $result_sePlanwednesday['JOBEND'] ?>', '<?= $result_sePlanwednesday['DATEVLIN'] ?>');" class="btn btn-default btn-circle" data-toggle="modal"  data-target="#modal_copyjob"><span class="fa fa-copy"></span></button>
                                                                    </td>

                                                                    <td>
                                                                        <input type="text" size="20"   name="txt_employeew1<?= $i3 ?>" id="txt_employeew1<?= $i3 ?>"  onchange="edit_vehicletransportplan(this.value, 'EMPLOYEENAME1', '<?= $result_sePlanwednesday['VEHICLETRANSPORTPLANID'] ?>')"   class="form-control" value="<?= $result_sePlanwednesday['EMPLOYEENAME1'] ?>">
                                                                        <label style="display: none"><?= $result_sePlanwednesday['EMPLOYEENAME1'] ?></label>
                                                                    </td>



                                                                    <td>
                                                                        <input type="text" size="20" name="txt_employeew2<?= $i3 ?>"  id="txt_employeew2<?= $i3 ?>"  onchange="edit_vehicletransportplan(this.value, 'EMPLOYEENAME2', '<?= $result_sePlanwednesday['VEHICLETRANSPORTPLANID'] ?>')"   class="form-control" value="<?= $result_sePlanwednesday['EMPLOYEENAME2'] ?>">
                                                                        <label style="display: none"><?= $result_sePlanwednesday['EMPLOYEENAME2'] ?></label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" size="20"  name="txt_carw<?= $i3 ?>"  id="txt_carw<?= $i3 ?>"   onchange="edit_vehicletransportplan(this.value, 'THAINAME', '<?= $result_sePlanwednesday['VEHICLETRANSPORTPLANID'] ?>')"   class="form-control" value="<?= $result_sePlanwednesday['THAINAME'] ?>">
                                                                        <label style="display: none"><?= $result_sePlanwednesday['THAINAME'] ?></label>
                                                                    </td>


                                                                    <td>
                                                                        <input type="text" size="20"  name="txt_jobstartw<?= $i3 ?>" id="txt_jobstartw<?= $i3 ?>"  onchange="edit_vehicletransportplan(this.value, 'JOBSTART', '<?= $result_sePlanwednesday['VEHICLETRANSPORTPLANID'] ?>')"   class="form-control" value="<?= $result_sePlanwednesday['JOBSTART'] ?>">
                                                                        <label style="display: none"><?= $result_sePlanwednesday['JOBSTART'] ?></label>
                                                                    </td>

                                                                    <td>
                                                                        <input type="text" size="20"  name="txt_clusterw<?= $i3 ?>" id="txt_clusterw<?= $i3 ?>"  onchange="select_vehicletransportplanjobend(this.value, 'CLUSTER', '<?= $result_sePlanwednesday['VEHICLETRANSPORTPLANID'] ?>', 'cb_jobendw<?= $i3 ?>')"   class="form-control" value="<?= $result_sePlanwednesday['CLUSTER'] ?>">
                                                                        <label style="display: none"><?= $result_sePlanwednesday['CLUSTER'] ?></label>
                                                                    </td>


                                                                    <td>
                                                                        <div id="data_clusterdefcb_jobendw<?= $i3 ?>">
                                                                            <select title="ปลายทาง" class="selectpicker" multiple="" data-actions-box="true"  id="cb_jobendw<?= $i3 ?>" name="cb_jobendw<?= $i3 ?>" >

                                                                                <?php
                                                                                $conditionJobend = " AND a.VEHICLETRANSPORTPLANID='" . $result_sePlanwednesday['VEHICLETRANSPORTPLANID'] . "' AND a.CLUSTER='" . $result_sePlanwednesday['CLUSTER'] . "'";
                                                                                $sql_seJobend = "{call megVehicletransportplan_v2(?,?)}";
                                                                                $params_seJobend = array(
                                                                                    array('select_jobend', SQLSRV_PARAM_IN),
                                                                                    array($conditionJobend, SQLSRV_PARAM_IN)
                                                                                );
                                                                                $query_seJobend = sqlsrv_query($conn, $sql_seJobend, $params_seJobend);
                                                                                while ($result_seJobend = sqlsrv_fetch_array($query_seJobend, SQLSRV_FETCH_ASSOC)) {

                                                                                    $arr_ph = explode(",", $result_seJobend['JOBEND']);
                                                                                    foreach ($arr_ph as $i) {
                                                                                        ?>
                                                                                        <option value = "<?= $i ?>"><?= $i ?></option>
                                                                                        <?php
                                                                                    }
                                                                                }
                                                                                ?>



                                                                            </select>
                                                                        </div>
                                                                        <div id="data_clustersrcb_jobendw<?= $i3 ?>"></div>

                                                                    </td>


                                                                    <td ><p style="width: 150px"><?= $result_sePlanwednesday['JOBNO'] ?></p></td>
                                                                    <td contenteditable="true"  onkeyup="edit_vehicletransportplaninner(this, 'TRIPNO', '<?= $result_sePlanwednesday['VEHICLETRANSPORTPLANID'] ?>')"><?= $result_sePlanwednesday['TRIPNO'] ?></td>

                                                                    <td><input type="text" size="20" id="txt_dateinput" name="txt_dateinput"  onchange="edit_datevehicletransportplan(this.value, 'DATEINPUT', '<?= $result_sePlanwednesday['VEHICLETRANSPORTPLANID'] ?>')"  class="form-control datetimeen"  value="<?= $result_sePlanwednesday['DATEINPUT'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_dateworking" name="txt_dateworking"  onchange="edit_datevehicletransportplan(this.value, 'DATEWORKING', '<?= $result_sePlanwednesday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlanwednesday['DATEWORKING'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_dateworksus" name="txt_dateworksus"  onchange="edit_datevehicletransportplan(this.value, 'DATEWORKSUS', '<?= $result_sePlanwednesday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlanwednesday['DATEWORKSUS'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_datepresent" name="txt_datepresent"  onchange="edit_datevehicletransportplan(this.value, 'DATEPRESENT', '<?= $result_sePlanwednesday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlanwednesday['DATEPRESENT'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_datevlin" name="txt_datevlin"  onchange="edit_datevehicletransportplan(this.value, 'DATEVLIN', '<?= $result_sePlanwednesday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlanwednesday['DATEVLIN'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_datevlout" name="txt_datevlout"  onchange="edit_datevehicletransportplan(this.value, 'DATEVLOUT', '<?= $result_sePlanwednesday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlanwednesday['DATEVLOUT'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_datedealerin" name="txt_datedealerin"  onchange="edit_datevehicletransportplan(this.value, 'DATEDEALERIN', '<?= $result_sePlanwednesday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlanwednesday['DATEDEALERIN'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_datereturn" name="txt_datereturn"  onchange="edit_datevehicletransportplan(this.value, 'DATERETURN', '<?= $result_sePlanwednesday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlanwednesday['DATERETURN'] ?>"></td>




                                                                    <td >
                                                                        <select  style="width: 150px" class="form-control" id="cb_status" name="cb_status" onchange = "update_vehicletransportplanjob('<?= $result_sePlanwednesday['VEHICLETRANSPORTPLANID'] ?>', this.value, )">
                                                                            <option   value ="">เลือกสถานะ</option>
                                                                            <?php
                                                                            switch ($result_sePlanwednesday['STATUSNUMBER']) {
                                                                                case '0': {
                                                                                        ?>
                                                                                        <option  selected=""  value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                case '1': {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   selected="" value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                case '2': {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option  selected="" value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;

                                                                                case '3': {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option selected=""  value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                case '4': {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option selected=""  value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                case '5': {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option  selected="" value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                default : {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                            }
                                                                            ?>


                                                                        </select>
                                                                    </td>    
                                                                </tr>
                                                                <?php
                                                                $i3++;
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="thursday">
                                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                                    <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example44" role="grid" aria-describedby="dataTables-example44" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th style="display: none">&nbsp;</th>
                                                                <th style="text-align: center;"><label style="width: 50px">DELETE JOB</label></th>
                                                                <th style="text-align: center;"><label style="width: 50px">COPY ROOT</label></th>
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



                                                            </tr>

                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i4 = 1;
                                                            if ($_GET['vehicletransportplanid'] != "") {
                                                                $conditionthursday = ($_GET['vehicletransportplanid'] != "") ? "  AND DATENAME(DW,a.DATEPRESENT) = 'Thursday' AND a.COMPANYCODE ='" . $_GET['companycode'] . "' AND a.CUSTOMERCODE ='" . $_GET['customercode'] . "' AND a.VEHICLETRANSPORTPLANID = '" . $_GET['vehicletransportplanid'] . "' " : "  AND DATENAME(DW,a.DATEPRESENT) = 'Thursday' AND a.CUSTOMERCODE ='" . $_GET['customercode'] . "'";
                                                            } else {
                                                                $conditionthursday = "  AND DATENAME(DW,a.DATEPRESENT) = 'Thursday'";
                                                            }
                                                            $sql_sePlanthursday = "{call megVehicletransportplan_v2(?,?)}";
                                                            $params_sePlanthursday = array(
                                                                array('select_vehicletransportplan', SQLSRV_PARAM_IN),
                                                                array($conditionthursday, SQLSRV_PARAM_IN)
                                                            );

                                                            $query_sePlanthursday = sqlsrv_query($conn, $sql_sePlanthursday, $params_sePlanthursday);
                                                            while ($result_sePlanthursday = sqlsrv_fetch_array($query_sePlanthursday, SQLSRV_FETCH_ASSOC)) {
                                                                ?>
                                                                <tr 
                                                                <?php
                                                                if (($result_sePlanthursday['SRBASE4L'] == '' || $result_sePlanthursday['SRBASE4L'] == '0.00') &&
                                                                        ($result_sePlanthursday['SRBASE8L'] == '' || $result_sePlanthursday['SRBASE8L'] == '0.00') &&
                                                                        ($result_sePlanthursday['GWBASE4L'] == '' || $result_sePlanthursday['GWBASE4L'] == '0.00') &&
                                                                        ($result_sePlanthursday['GWBASE8L'] == '' || $result_sePlanthursday['GWBASE8L'] == '0.00') &&
                                                                        ($result_sePlanthursday['BPBASE4L'] == '' || $result_sePlanthursday['BPBASE4L'] == '0.00') &&
                                                                        ($result_sePlanthursday['BPBASE8L'] == '' || $result_sePlanthursday['BPBASE8L'] == '0.00') &&
                                                                        ($result_sePlanthursday['OTHBASE4L'] == '' || $result_sePlanthursday['OTHBASE4L'] == '0.00') &&
                                                                        ($result_sePlanthursday['OTHBASE8L'] == '' || $result_sePlanthursday['OTHBASE8L'] == '0.00')) {
                                                                    ?>
                                                                        style="color: red"
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    >
                                                                    <td style="display: none">&nbsp;</td>

                                                                    <td style="text-align: center;">
                                                                        <button onclick="delete_vehicletransportplan('<?= $result_sePlanthursday['VEHICLETRANSPORTPLANID'] ?>');" title="ลบแผนการขนส่ง" type="button" class="btn btn-default btn-circle"><span class="fa fa-times"></span></button> 
                                                                    </td>
                                                                    <td style="text-align: center;">
                                                                        <button onclick="add_vehicletransportplanroot('<?= $result_sePlanthursday['CUSTOMERCODE'] ?>', '<?= $result_sePlanthursday['COMPANYCODE'] ?>', '<?= $result_sePlanthursday['VEHICLEREGISNUMBER1'] ?>', '<?= $result_sePlanthursday['VEHICLEREGISNUMBER2'] ?>', '<?= $result_sePlanthursday['THAINAME'] ?>', '<?= $result_sePlanthursday['ENGNAME'] ?>', '<?= $result_sePlanthursday['VEHICLETRANSPORTPRICEID'] ?>', '<?= $result_sePlanthursday['CLUSTER'] ?>', '<?= $result_sePlanthursday['DEALERCODE'] ?>', '<?= $result_sePlanthursday['NAME'] ?>', '<?= $result_sePlanthursday['SRBASE4L'] ?>', '<?= $result_sePlanthursday['SRBASE8L'] ?>', '<?= $result_sePlanthursday['GWBASE4L'] ?>', '<?= $result_sePlanthursday['GWBASE8L'] ?>', '<?= $result_sePlanthursday['BPBASE4L'] ?>', '<?= $result_sePlanthursday['BPBASE8L'] ?>', '<?= $result_sePlanthursday['OTHBASE4L'] ?>', '<?= $result_sePlanthursday['OTHBASE8L'] ?>', '<?= $result_sePlanthursday['E1'] ?>', '<?= $result_sePlanthursday['E2'] ?>', '<?= $result_sePlanthursday['E3'] ?>', '<?= $result_sePlanthursday['E4'] ?>', '<?= $result_sePlanthursday['C1'] ?>', '<?= $result_sePlanthursday['C2'] ?>', '<?= $result_sePlanthursday['C3'] ?>', '<?= $result_sePlanthursday['C4'] ?>', '<?= $result_sePlanthursday['C5'] ?>', '<?= $result_sePlanthursday['C6'] ?>', '<?= $result_sePlanthursday['C7'] ?>', '<?= $result_sePlanthursday['C8'] ?>', '<?= $result_sePlanthursday['C9'] ?>', '<?= $result_sePlanthursday['O1'] ?>', '<?= $result_sePlanthursday['O2'] ?>', '<?= $result_sePlanthursday['O3'] ?>', '<?= $result_sePlanthursday['O4'] ?>', '<?= $result_sePlanthursday['JOBSTART'] ?>', '<?= $result_sePlanthursday['JOBEND'] ?>', '<?= $result_sePlanthursday['EMPLOYEECODE1'] ?>', '<?= $result_sePlanthursday['EMPLOYEENAME1'] ?>', '<?= $result_sePlanthursday['EMPLOYEECODE2'] ?>', '<?= $result_sePlanthursday['EMPLOYEENAME2'] ?>', '<?= $result_sePlanthursday['EMPLOYEECODE3'] ?>', '<?= $result_sePlanthursday['EMPLOYEENAME3'] ?>', '<?= $result_sePlanthursday['EMPLOYEECODE4'] ?>', '<?= $result_sePlanthursday['EMPLOYEENAME4'] ?>', '<?= $result_sePlanthursday['JOBNO'] ?>', '<?= $result_sePlanthursday['TRIPNO'] ?>', '<?= $result_sePlanthursday['DATEINPUT'] ?>', '<?= $result_sePlanthursday['DATESTART'] ?>', '<?= $result_sePlanthursday['DATEWORKING'] ?>', '<?= $result_sePlanthursday['DATEWORKSUS'] ?>', '<?= $result_sePlanthursday['DATEPRESENT'] ?>', '<?= $result_sePlanthursday['DATEVLIN'] ?>', '<?= $result_sePlanthursday['DATEVLOUT'] ?>', '<?= $result_sePlanthursday['DATEDEALERIN'] ?>', '<?= $result_sePlanthursday['DATERETURN'] ?>', '<?= $result_sePlanthursday['STATUS'] ?>', '<?= $result_sePlanthursday['ACTIVESTATUS'] ?>', '<?= $result_sePlanthursday['REMARK'] ?>')" title="คัดลอกรูทการขนส่ง" type="button" class="btn btn-default btn-circle"><span class="fa fa-copy"></span></button> 
                                                                    </td>
                                                                   <!-- <td style="text-align: center;">
                                                                        <button title="เพิ่มเอกสารรายละเอียดสินค้า" type="button" onclick="select_vehicletransportplanid('<?= $result_sePlanthursday['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_sePlanthursday['JOBSTART'] ?>', '<?= $result_sePlanthursday['JOBEND'] ?>');" class="btn btn-default btn-circle" data-toggle="modal" data-target="#modal_adddn"><span class="fa fa-plus"></span></button>
                                                                    </td>-->
                                                                    <td style="text-align: center;">
                                                                        <button title="COPY JOB" type="button" onclick="select_copyjob('<?= $result_sePlanthursday['JOBSTART'] ?>', '<?= $result_sePlanthursday['JOBEND'] ?>', '<?= $result_sePlanthursday['DATEVLIN'] ?>');" class="btn btn-default btn-circle" data-toggle="modal"  data-target="#modal_copyjob"><span class="fa fa-copy"></span></button>
                                                                    </td>

                                                                    <td>
                                                                        <input type="text" size="20"   name="txt_employeeth1<?= $i4 ?>" id="txt_employeeth1<?= $i4 ?>"  onchange="edit_vehicletransportplan(this.value, 'EMPLOYEENAME1', '<?= $result_sePlanthursday['VEHICLETRANSPORTPLANID'] ?>')"   class="form-control" value="<?= $result_sePlanthursday['EMPLOYEENAME1'] ?>">
                                                                        <label style="display: none"><?= $result_sePlanthursday['EMPLOYEENAME1'] ?></label>
                                                                    </td>



                                                                    <td>
                                                                        <input type="text" size="20"  name="txt_employeeth2<?= $i4 ?>"  id="txt_employeeth2<?= $i4 ?>"  onchange="edit_vehicletransportplan(this.value, 'EMPLOYEENAME2', '<?= $result_sePlanthursday['VEHICLETRANSPORTPLANID'] ?>')"   class="form-control" value="<?= $result_sePlanthursday['EMPLOYEENAME2'] ?>">
                                                                        <label style="display: none"><?= $result_sePlanthursday['EMPLOYEENAME2'] ?></label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" size="20"  name="txt_carth<?= $i4 ?>"  id="txt_carth<?= $i4 ?>"   onchange="edit_vehicletransportplan(this.value, 'THAINAME', '<?= $result_sePlanthursday['VEHICLETRANSPORTPLANID'] ?>')"   class="form-control" value="<?= $result_sePlanthursday['THAINAME'] ?>">
                                                                        <label style="display: none"><?= $result_sePlanthursday['THAINAME'] ?></label>
                                                                    </td>


                                                                    <td>
                                                                        <input type="text" size="20"   name="txt_jobstartth<?= $i4 ?>" id="txt_jobstartth<?= $i4 ?>"  onchange="edit_vehicletransportplan(this.value, 'JOBSTART', '<?= $result_sePlanthursday['VEHICLETRANSPORTPLANID'] ?>')"   class="form-control" value="<?= $result_sePlanthursday['JOBSTART'] ?>">
                                                                        <label style="display: none"><?= $result_sePlanthursday['JOBSTART'] ?></label>
                                                                    </td>

                                                                    <td>
                                                                        <input type="text" size="20"  name="txt_clusterth<?= $i4 ?>" id="txt_clusterth<?= $i4 ?>"  onchange="select_vehicletransportplanjobend(this.value, 'CLUSTER', '<?= $result_sePlanthursday['VEHICLETRANSPORTPLANID'] ?>', 'cb_jobendth<?= $i4 ?>')"   class="form-control" value="<?= $result_sePlanthursday['CLUSTER'] ?>">
                                                                        <label style="display: none"><?= $result_sePlanthursday['CLUSTER'] ?></label>
                                                                    </td>

                                                                    <td>
                                                                        <div id="data_clusterdefcb_jobendth<?= $i4 ?>">
                                                                            <select title="ปลายทาง" class="selectpicker" multiple="" data-actions-box="true"  id="cb_jobendth<?= $i4 ?>" name="cb_jobendth<?= $i4 ?>" >

                                                                                <?php
                                                                                $conditionJobend = " AND a.VEHICLETRANSPORTPLANID='" . $result_sePlanthursday['VEHICLETRANSPORTPLANID'] . "' AND a.CLUSTER='" . $result_sePlanthursday['CLUSTER'] . "'";
                                                                                $sql_seJobend = "{call megVehicletransportplan_v2(?,?)}";
                                                                                $params_seJobend = array(
                                                                                    array('select_jobend', SQLSRV_PARAM_IN),
                                                                                    array($conditionJobend, SQLSRV_PARAM_IN)
                                                                                );
                                                                                $query_seJobend = sqlsrv_query($conn, $sql_seJobend, $params_seJobend);
                                                                                while ($result_seJobend = sqlsrv_fetch_array($query_seJobend, SQLSRV_FETCH_ASSOC)) {

                                                                                    $arr_ph = explode(",", $result_seJobend['JOBEND']);
                                                                                    foreach ($arr_ph as $i) {
                                                                                        ?>
                                                                                        <option value = "<?= $i ?>"><?= $i ?></option>
                                                                                        <?php
                                                                                    }
                                                                                }
                                                                                ?>



                                                                            </select>
                                                                        </div>
                                                                        <div id="data_clustersrcb_jobendth<?= $i4 ?>"></div>

                                                                    </td>


                                                                    <td ><p style="width: 150px"><?= $result_sePlanthursday['JOBNO'] ?></p></td>
                                                                    <td contenteditable="true"  onkeyup="edit_vehicletransportplaninner(this, 'TRIPNO', '<?= $result_sePlanthursday['VEHICLETRANSPORTPLANID'] ?>')"><?= $result_sePlanthursday['TRIPNO'] ?></td>

                                                                    <td><input type="text" size="20" id="txt_dateinput" name="txt_dateinput"  onchange="edit_datevehicletransportplan(this.value, 'DATEINPUT', '<?= $result_sePlanthursday['VEHICLETRANSPORTPLANID'] ?>')"  class="form-control datetimeen"  value="<?= $result_sePlanthursday['DATEINPUT'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_dateworking" name="txt_dateworking"  onchange="edit_datevehicletransportplan(this.value, 'DATEWORKING', '<?= $result_sePlanthursday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlanthursday['DATEWORKING'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_dateworksus" name="txt_dateworksus"  onchange="edit_datevehicletransportplan(this.value, 'DATEWORKSUS', '<?= $result_sePlanthursday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlanthursday['DATEWORKSUS'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_datepresent" name="txt_datepresent"  onchange="edit_datevehicletransportplan(this.value, 'DATEPRESENT', '<?= $result_sePlanthursday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlanthursday['DATEPRESENT'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_datevlin" name="txt_datevlin"  onchange="edit_datevehicletransportplan(this.value, 'DATEVLIN', '<?= $result_sePlanthursday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlanthursday['DATEVLIN'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_datevlout" name="txt_datevlout"  onchange="edit_datevehicletransportplan(this.value, 'DATEVLOUT', '<?= $result_sePlanthursday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlanthursday['DATEVLOUT'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_datedealerin" name="txt_datedealerin"  onchange="edit_datevehicletransportplan(this.value, 'DATEDEALERIN', '<?= $result_sePlanthursday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlanthursday['DATEDEALERIN'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_datereturn" name="txt_datereturn"  onchange="edit_datevehicletransportplan(this.value, 'DATERETURN', '<?= $result_sePlanthursday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlanthursday['DATERETURN'] ?>"></td>




                                                                    <td >
                                                                        <select  style="width: 150px" class="form-control" id="cb_status" name="cb_status" onchange = "update_vehicletransportplanjob('<?= $result_sePlanthursday['VEHICLETRANSPORTPLANID'] ?>', this.value, )">
                                                                            <option   value ="">เลือกสถานะ</option>
                                                                            <?php
                                                                            switch ($result_sePlanthursday['STATUSNUMBER']) {
                                                                                case '0': {
                                                                                        ?>
                                                                                        <option  selected=""  value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                case '1': {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   selected="" value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                case '2': {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option  selected="" value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;

                                                                                case '3': {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option selected=""  value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                case '4': {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option selected=""  value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                case '5': {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option  selected="" value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                default : {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                            }
                                                                            ?>


                                                                        </select>
                                                                    </td>  
                                                                </tr>
                                                                <?php
                                                                $i4++;
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div> 
                                            </div>
                                            <div class="tab-pane fade" id="friday">
                                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                                    <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example55" role="grid" aria-describedby="dataTables-example55" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th style="display: none">&nbsp;</th>
                                                                <th style="text-align: center;"><label style="width: 50px">DELETE JOB</label></th>
                                                                <th style="text-align: center;"><label style="width: 50px">COPY ROOT</label></th>
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



                                                            </tr>

                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i5 = 1;
                                                            if ($_GET['vehicletransportplanid'] != "") {
                                                                $conditionfriday = ($_GET['vehicletransportplanid'] != "") ? "  AND DATENAME(DW,a.DATEPRESENT) = 'Friday' AND a.COMPANYCODE ='" . $_GET['companycode'] . "' AND a.CUSTOMERCODE ='" . $_GET['customercode'] . "' AND a.VEHICLETRANSPORTPLANID = '" . $_GET['vehicletransportplanid'] . "' " : "  AND DATENAME(DW,a.DATEPRESENT) = 'Friday' AND a.CUSTOMERCODE ='" . $_GET['customercode'] . "'";
                                                            } else {
                                                                $conditionfriday = "  AND DATENAME(DW,a.DATEPRESENT) = 'Friday'";
                                                            }
                                                            $sql_sePlanfriday = "{call megVehicletransportplan_v2(?,?)}";
                                                            $params_sePlanfriday = array(
                                                                array('select_vehicletransportplan', SQLSRV_PARAM_IN),
                                                                array($conditionfriday, SQLSRV_PARAM_IN)
                                                            );
                                                            $query_sePlanfriday = sqlsrv_query($conn, $sql_sePlanfriday, $params_sePlanfriday);
                                                            while ($result_sePlanfriday = sqlsrv_fetch_array($query_sePlanfriday, SQLSRV_FETCH_ASSOC)) {
                                                                ?>
                                                                <tr 
                                                                <?php
                                                                if (($result_sePlanfriday['SRBASE4L'] == '' || $result_sePlanfriday['SRBASE4L'] == '0.00') &&
                                                                        ($result_sePlanfriday['SRBASE8L'] == '' || $result_sePlanfriday['SRBASE8L'] == '0.00') &&
                                                                        ($result_sePlanfriday['GWBASE4L'] == '' || $result_sePlanfriday['GWBASE4L'] == '0.00') &&
                                                                        ($result_sePlanfriday['GWBASE8L'] == '' || $result_sePlanfriday['GWBASE8L'] == '0.00') &&
                                                                        ($result_sePlanfriday['BPBASE4L'] == '' || $result_sePlanfriday['BPBASE4L'] == '0.00') &&
                                                                        ($result_sePlanfriday['BPBASE8L'] == '' || $result_sePlanfriday['BPBASE8L'] == '0.00') &&
                                                                        ($result_sePlanfriday['OTHBASE4L'] == '' || $result_sePlanfriday['OTHBASE4L'] == '0.00') &&
                                                                        ($result_sePlanfriday['OTHBASE8L'] == '' || $result_sePlanfriday['OTHBASE8L'] == '0.00')) {
                                                                    ?>
                                                                        style="color: red"
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    >
                                                                    <td style="display: none">&nbsp;</td>

                                                                    <td style="text-align: center;">
                                                                        <button onclick="delete_vehicletransportplan('<?= $result_sePlanfriday['VEHICLETRANSPORTPLANID'] ?>');" title="ลบแผนการขนส่ง" type="button" class="btn btn-default btn-circle"><span class="fa fa-times"></span></button> 
                                                                    </td>
                                                                    <td style="text-align: center;">
                                                                        <button onclick="add_vehicletransportplanroot('<?= $result_sePlanfriday['CUSTOMERCODE'] ?>', '<?= $result_sePlanfriday['COMPANYCODE'] ?>', '<?= $result_sePlanfriday['VEHICLEREGISNUMBER1'] ?>', '<?= $result_sePlanfriday['VEHICLEREGISNUMBER2'] ?>', '<?= $result_sePlanfriday['THAINAME'] ?>', '<?= $result_sePlanfriday['ENGNAME'] ?>', '<?= $result_sePlanfriday['VEHICLETRANSPORTPRICEID'] ?>', '<?= $result_sePlanfriday['CLUSTER'] ?>', '<?= $result_sePlanfriday['DEALERCODE'] ?>', '<?= $result_sePlanfriday['NAME'] ?>', '<?= $result_sePlanfriday['SRBASE4L'] ?>', '<?= $result_sePlanfriday['SRBASE8L'] ?>', '<?= $result_sePlanfriday['GWBASE4L'] ?>', '<?= $result_sePlanfriday['GWBASE8L'] ?>', '<?= $result_sePlanfriday['BPBASE4L'] ?>', '<?= $result_sePlanfriday['BPBASE8L'] ?>', '<?= $result_sePlanfriday['OTHBASE4L'] ?>', '<?= $result_sePlanfriday['OTHBASE8L'] ?>', '<?= $result_sePlanfriday['E1'] ?>', '<?= $result_sePlanfriday['E2'] ?>', '<?= $result_sePlanfriday['E3'] ?>', '<?= $result_sePlanfriday['E4'] ?>', '<?= $result_sePlanfriday['C1'] ?>', '<?= $result_sePlanfriday['C2'] ?>', '<?= $result_sePlanfriday['C3'] ?>', '<?= $result_sePlanfriday['C4'] ?>', '<?= $result_sePlanfriday['C5'] ?>', '<?= $result_sePlanfriday['C6'] ?>', '<?= $result_sePlanfriday['C7'] ?>', '<?= $result_sePlanfriday['C8'] ?>', '<?= $result_sePlanfriday['C9'] ?>', '<?= $result_sePlanfriday['O1'] ?>', '<?= $result_sePlanfriday['O2'] ?>', '<?= $result_sePlanfriday['O3'] ?>', '<?= $result_sePlanfriday['O4'] ?>', '<?= $result_sePlanfriday['JOBSTART'] ?>', '<?= $result_sePlanfriday['JOBEND'] ?>', '<?= $result_sePlanfriday['EMPLOYEECODE1'] ?>', '<?= $result_sePlanfriday['EMPLOYEENAME1'] ?>', '<?= $result_sePlanfriday['EMPLOYEECODE2'] ?>', '<?= $result_sePlanfriday['EMPLOYEENAME2'] ?>', '<?= $result_sePlanfriday['EMPLOYEECODE3'] ?>', '<?= $result_sePlanfriday['EMPLOYEENAME3'] ?>', '<?= $result_sePlanfriday['EMPLOYEECODE4'] ?>', '<?= $result_sePlanfriday['EMPLOYEENAME4'] ?>', '<?= $result_sePlanfriday['JOBNO'] ?>', '<?= $result_sePlanfriday['TRIPNO'] ?>', '<?= $result_sePlanfriday['DATEINPUT'] ?>', '<?= $result_sePlanfriday['DATESTART'] ?>', '<?= $result_sePlanfriday['DATEWORKING'] ?>', '<?= $result_sePlanfriday['DATEWORKSUS'] ?>', '<?= $result_sePlanfriday['DATEPRESENT'] ?>', '<?= $result_sePlanfriday['DATEVLIN'] ?>', '<?= $result_sePlanfriday['DATEVLOUT'] ?>', '<?= $result_sePlanfriday['DATEDEALERIN'] ?>', '<?= $result_sePlanfriday['DATERETURN'] ?>', '<?= $result_sePlanfriday['STATUS'] ?>', '<?= $result_sePlanfriday['ACTIVESTATUS'] ?>', '<?= $result_sePlanfriday['REMARK'] ?>')" title="คัดลอกรูทการขนส่ง" type="button" class="btn btn-default btn-circle"><span class="fa fa-copy"></span></button> 
                                                                    </td>
                                                                    <!--<td style="text-align: center;">
                                                                        <button title="เพิ่มเอกสารรายละเอียดสินค้า" type="button" onclick="select_vehicletransportplanid('<?= $result_sePlanfriday['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_sePlanfriday['JOBSTART'] ?>', '<?= $result_sePlanfriday['JOBEND'] ?>');" class="btn btn-default btn-circle" data-toggle="modal" data-target="#modal_adddn"><span class="fa fa-plus"></span></button>
                                                                    </td>-->
                                                                    <td style="text-align: center;">
                                                                        <button title="COPY JOB" type="button" onclick="select_copyjob('<?= $result_sePlanfriday['JOBSTART'] ?>', '<?= $result_sePlanfriday['JOBEND'] ?>', '<?= $result_sePlanfriday['DATEVLIN'] ?>');" class="btn btn-default btn-circle" data-toggle="modal"  data-target="#modal_copyjob"><span class="fa fa-copy"></span></button>
                                                                    </td>

                                                                    <td>
                                                                        <input type="text" size="20"   name="txt_employeef1<?= $i5 ?>" id="txt_employeef1<?= $i5 ?>"  onchange="edit_vehicletransportplan(this.value, 'EMPLOYEENAME1', '<?= $result_sePlanfriday['VEHICLETRANSPORTPLANID'] ?>')"   class="form-control" value="<?= $result_sePlanfriday['EMPLOYEENAME1'] ?>">
                                                                        <label style="display: none"><?= $result_sePlanfriday['EMPLOYEENAME1'] ?></label>
                                                                    </td>



                                                                    <td>
                                                                        <input type="text" size="20"  name="txt_employeef2<?= $i5 ?>"  id="txt_employeef2<?= $i5 ?>"  onchange="edit_vehicletransportplan(this.value, 'EMPLOYEENAME2', '<?= $result_sePlanfriday['VEHICLETRANSPORTPLANID'] ?>')"   class="form-control" value="<?= $result_sePlanfriday['EMPLOYEENAME2'] ?>">
                                                                        <label style="display: none"><?= $result_sePlanfriday['EMPLOYEENAME2'] ?></label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" size="20"  name="txt_carf<?= $i5 ?>"  id="txt_carf<?= $i5 ?>"   onchange="edit_vehicletransportplan(this.value, 'THAINAME', '<?= $result_sePlanfriday['VEHICLETRANSPORTPLANID'] ?>')"   class="form-control" value="<?= $result_sePlanfriday['THAINAME'] ?>">
                                                                        <label style="display: none"><?= $result_sePlanfriday['THAINAME'] ?></label>
                                                                    </td>



                                                                    <td>
                                                                        <input type="text" size="20"  name="txt_jobstartf<?= $i5 ?>" id="txt_jobstartf<?= $i5 ?>"  onchange="edit_vehicletransportplan(this.value, 'JOBSTART', '<?= $result_sePlanfriday['VEHICLETRANSPORTPLANID'] ?>')"   class="form-control" value="<?= $result_sePlanfriday['JOBSTART'] ?>">
                                                                        <label style="display: none"><?= $result_sePlanfriday['JOBSTART'] ?></label>
                                                                    </td>

                                                                    <td>
                                                                        <input type="text" size="20"  name="txt_clusterf<?= $i5 ?>" id="txt_clusterf<?= $i5 ?>"  onchange="select_vehicletransportplanjobend(this.value, 'CLUSTER', '<?= $result_sePlanfriday['VEHICLETRANSPORTPLANID'] ?>', 'cb_jobendf<?= $i5 ?>')"   class="form-control" value="<?= $result_sePlanfriday['CLUSTER'] ?>">
                                                                        <label style="display: none"><?= $result_sePlanfriday['CLUSTER'] ?></label>
                                                                    </td>

                                                                    <td>
                                                                        <div id="data_clusterdefcb_jobendf<?= $i5 ?>">
                                                                            <select title="ปลายทาง" class="selectpicker" multiple="" data-actions-box="true"  id="cb_jobendf<?= $i5 ?>" name="cb_jobendf<?= $i5 ?>" >

                                                                                <?php
                                                                                $conditionJobend = " AND a.VEHICLETRANSPORTPLANID='" . $result_sePlanfriday['VEHICLETRANSPORTPLANID'] . "' AND a.CLUSTER='" . $result_sePlanfriday['CLUSTER'] . "'";
                                                                                $sql_seJobend = "{call megVehicletransportplan_v2(?,?)}";
                                                                                $params_seJobend = array(
                                                                                    array('select_jobend', SQLSRV_PARAM_IN),
                                                                                    array($conditionJobend, SQLSRV_PARAM_IN)
                                                                                );
                                                                                $query_seJobend = sqlsrv_query($conn, $sql_seJobend, $params_seJobend);
                                                                                while ($result_seJobend = sqlsrv_fetch_array($query_seJobend, SQLSRV_FETCH_ASSOC)) {

                                                                                    $arr_ph = explode(",", $result_seJobend['JOBEND']);
                                                                                    foreach ($arr_ph as $i) {
                                                                                        ?>
                                                                                        <option value = "<?= $i ?>"><?= $i ?></option>
                                                                                        <?php
                                                                                    }
                                                                                }
                                                                                ?>



                                                                            </select>
                                                                        </div>
                                                                        <div id="data_clustersrcb_jobendf<?= $i5 ?>"></div>

                                                                    </td>


                                                                    <td ><p style="width: 150px"><?= $result_sePlanfriday['JOBNO'] ?></p></td>
                                                                    <td contenteditable="true"  onkeyup="edit_vehicletransportplaninner(this, 'TRIPNO', '<?= $result_sePlanfriday['VEHICLETRANSPORTPLANID'] ?>')"><?= $result_sePlanfriday['TRIPNO'] ?></td>

                                                                    <td><input type="text" size="20" id="txt_dateinput" name="txt_dateinput"  onchange="edit_datevehicletransportplan(this.value, 'DATEINPUT', '<?= $result_sePlanfriday['VEHICLETRANSPORTPLANID'] ?>')"  class="form-control datetimeen"  value="<?= $result_sePlanfriday['DATEINPUT'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_dateworking" name="txt_dateworking"  onchange="edit_datevehicletransportplan(this.value, 'DATEWORKING', '<?= $result_sePlanfriday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlanfriday['DATEWORKING'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_dateworksus" name="txt_dateworksus"  onchange="edit_datevehicletransportplan(this.value, 'DATEWORKSUS', '<?= $result_sePlanfriday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlanfriday['DATEWORKSUS'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_datepresent" name="txt_datepresent"  onchange="edit_datevehicletransportplan(this.value, 'DATEPRESENT', '<?= $result_sePlanfriday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlanfriday['DATEPRESENT'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_datevlin" name="txt_datevlin"  onchange="edit_datevehicletransportplan(this.value, 'DATEVLIN', '<?= $result_sePlanfriday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlanfriday['DATEVLIN'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_datevlout" name="txt_datevlout"  onchange="edit_datevehicletransportplan(this.value, 'DATEVLOUT', '<?= $result_sePlanfriday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlanfriday['DATEVLOUT'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_datedealerin" name="txt_datedealerin"  onchange="edit_datevehicletransportplan(this.value, 'DATEDEALERIN', '<?= $result_sePlanfriday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlanfriday['DATEDEALERIN'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_datereturn" name="txt_datereturn"  onchange="edit_datevehicletransportplan(this.value, 'DATERETURN', '<?= $result_sePlanfriday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlanfriday['DATERETURN'] ?>"></td>




                                                                    <td >
                                                                        <select  style="width: 150px" class="form-control" id="cb_status" name="cb_status" onchange = "update_vehicletransportplanjob('<?= $result_sePlanfriday['VEHICLETRANSPORTPLANID'] ?>', this.value, )">
                                                                            <option   value ="">เลือกสถานะ</option>
                                                                            <?php
                                                                            switch ($result_sePlanfriday['STATUSNUMBER']) {
                                                                                case '0': {
                                                                                        ?>
                                                                                        <option  selected=""  value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                case '1': {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   selected="" value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                case '2': {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option  selected="" value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;

                                                                                case '3': {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option selected=""  value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                case '4': {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option selected=""  value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                case '5': {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option  selected="" value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                default : {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                            }
                                                                            ?>


                                                                        </select>
                                                                    </td>                                                                                                                                                                                                                                                              



                                                                </tr>
                                                                <?php
                                                                $i5++;
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="saturday">
                                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                                    <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example66" role="grid" aria-describedby="dataTables-example66" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th style="display: none">&nbsp;</th>
                                                                <th style="text-align: center;"><label style="width: 50px">DELETE JOB</label></th>
                                                                <th style="text-align: center;"><label style="width: 50px">COPY ROOT</label></th>
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




                                                            </tr>

                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i6 = 1;
                                                            if ($_GET['vehicletransportplanid'] != "") {
                                                                $conditionsaturday = ($_GET['vehicletransportplanid'] != "") ? "  AND DATENAME(DW,a.DATEPRESENT) = 'Saturday' AND a.COMPANYCODE ='" . $_GET['companycode'] . "' AND a.CUSTOMERCODE ='" . $_GET['customercode'] . "' AND a.VEHICLETRANSPORTPLANID = '" . $_GET['vehicletransportplanid'] . "' " : "  AND DATENAME(DW,a.DATEPRESENT) = 'Saturday' AND a.CUSTOMERCODE ='" . $_GET['customercode'] . "'";
                                                            } else {
                                                                $conditionsaturday = "  AND DATENAME(DW,a.DATEPRESENT) = 'Saturday'";
                                                            }
//echo $conditionsaturday;
                                                            $sql_sePlansaturday = "{call megVehicletransportplan_v2(?,?)}";
                                                            $params_sePlansaturday = array(
                                                                array('select_vehicletransportplan', SQLSRV_PARAM_IN),
                                                                array($conditionsaturday, SQLSRV_PARAM_IN)
                                                            );

                                                            $query_sePlansaturday = sqlsrv_query($conn, $sql_sePlansaturday, $params_sePlansaturday);
                                                            while ($result_sePlansaturday = sqlsrv_fetch_array($query_sePlansaturday, SQLSRV_FETCH_ASSOC)) {
                                                                ?>
                                                                <tr 
                                                                <?php
                                                                if (($result_sePlansaturday['SRBASE4L'] == '' || $result_sePlansaturday['SRBASE4L'] == '0.00') &&
                                                                        ($result_sePlansaturday['SRBASE8L'] == '' || $result_sePlansaturday['SRBASE8L'] == '0.00') &&
                                                                        ($result_sePlansaturday['GWBASE4L'] == '' || $result_sePlansaturday['GWBASE4L'] == '0.00') &&
                                                                        ($result_sePlansaturday['GWBASE8L'] == '' || $result_sePlansaturday['GWBASE8L'] == '0.00') &&
                                                                        ($result_sePlansaturday['BPBASE4L'] == '' || $result_sePlansaturday['BPBASE4L'] == '0.00') &&
                                                                        ($result_sePlansaturday['BPBASE8L'] == '' || $result_sePlansaturday['BPBASE8L'] == '0.00') &&
                                                                        ($result_sePlansaturday['OTHBASE4L'] == '' || $result_sePlansaturday['OTHBASE4L'] == '0.00') &&
                                                                        ($result_sePlansaturday['OTHBASE8L'] == '' || $result_sePlansaturday['OTHBASE8L'] == '0.00')) {
                                                                    ?>
                                                                        style="color: red"
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    >
                                                                    <td style="display: none">&nbsp;</td>

                                                                    <td style="text-align: center;">
                                                                        <button onclick="delete_vehicletransportplan('<?= $result_sePlansaturday['VEHICLETRANSPORTPLANID'] ?>');" title="ลบแผนการขนส่ง" type="button" class="btn btn-default btn-circle"><span class="fa fa-times"></span></button> 
                                                                    </td>
                                                                    <td style="text-align: center;">
                                                                        <button onclick="add_vehicletransportplanroot('<?= $result_sePlansaturday['CUSTOMERCODE'] ?>', '<?= $result_sePlansaturday['COMPANYCODE'] ?>', '<?= $result_sePlansaturday['VEHICLEREGISNUMBER1'] ?>', '<?= $result_sePlansaturday['VEHICLEREGISNUMBER2'] ?>', '<?= $result_sePlansaturday['THAINAME'] ?>', '<?= $result_sePlansaturday['ENGNAME'] ?>', '<?= $result_sePlansaturday['VEHICLETRANSPORTPRICEID'] ?>', '<?= $result_sePlansaturday['CLUSTER'] ?>', '<?= $result_sePlansaturday['DEALERCODE'] ?>', '<?= $result_sePlansaturday['NAME'] ?>', '<?= $result_sePlansaturday['SRBASE4L'] ?>', '<?= $result_sePlansaturday['SRBASE8L'] ?>', '<?= $result_sePlansaturday['GWBASE4L'] ?>', '<?= $result_sePlansaturday['GWBASE8L'] ?>', '<?= $result_sePlansaturday['BPBASE4L'] ?>', '<?= $result_sePlansaturday['BPBASE8L'] ?>', '<?= $result_sePlansaturday['OTHBASE4L'] ?>', '<?= $result_sePlansaturday['OTHBASE8L'] ?>', '<?= $result_sePlansaturday['E1'] ?>', '<?= $result_sePlansaturday['E2'] ?>', '<?= $result_sePlansaturday['E3'] ?>', '<?= $result_sePlansaturday['E4'] ?>', '<?= $result_sePlansaturday['C1'] ?>', '<?= $result_sePlansaturday['C2'] ?>', '<?= $result_sePlansaturday['C3'] ?>', '<?= $result_sePlansaturday['C4'] ?>', '<?= $result_sePlansaturday['C5'] ?>', '<?= $result_sePlansaturday['C6'] ?>', '<?= $result_sePlansaturday['C7'] ?>', '<?= $result_sePlansaturday['C8'] ?>', '<?= $result_sePlansaturday['C9'] ?>', '<?= $result_sePlansaturday['O1'] ?>', '<?= $result_sePlansaturday['O2'] ?>', '<?= $result_sePlansaturday['O3'] ?>', '<?= $result_sePlansaturday['O4'] ?>', '<?= $result_sePlansaturday['JOBSTART'] ?>', '<?= $result_sePlansaturday['JOBEND'] ?>', '<?= $result_sePlansaturday['EMPLOYEECODE1'] ?>', '<?= $result_sePlansaturday['EMPLOYEENAME1'] ?>', '<?= $result_sePlansaturday['EMPLOYEECODE2'] ?>', '<?= $result_sePlansaturday['EMPLOYEENAME2'] ?>', '<?= $result_sePlansaturday['EMPLOYEECODE3'] ?>', '<?= $result_sePlansaturday['EMPLOYEENAME3'] ?>', '<?= $result_sePlansaturday['EMPLOYEECODE4'] ?>', '<?= $result_sePlansaturday['EMPLOYEENAME4'] ?>', '<?= $result_sePlansaturday['JOBNO'] ?>', '<?= $result_sePlansaturday['TRIPNO'] ?>', '<?= $result_sePlansaturday['DATEINPUT'] ?>', '<?= $result_sePlansaturday['DATESTART'] ?>', '<?= $result_sePlansaturday['DATEWORKING'] ?>', '<?= $result_sePlansaturday['DATEWORKSUS'] ?>', '<?= $result_sePlansaturday['DATEPRESENT'] ?>', '<?= $result_sePlansaturday['DATEVLIN'] ?>', '<?= $result_sePlansaturday['DATEVLOUT'] ?>', '<?= $result_sePlansaturday['DATEDEALERIN'] ?>', '<?= $result_sePlansaturday['DATERETURN'] ?>', '<?= $result_sePlansaturday['STATUS'] ?>', '<?= $result_sePlansaturday['ACTIVESTATUS'] ?>', '<?= $result_sePlansaturday['REMARK'] ?>')" title="คัดลอกรูทการขนส่ง" type="button" class="btn btn-default btn-circle"><span class="fa fa-copy"></span></button> 
                                                                    </td>
                                                                    <!--<td style="text-align: center;">
                                                                        <button title="เพิ่มเอกสารรายละเอียดสินค้า" type="button" onclick="select_vehicletransportplanid('<?= $result_sePlansaturday['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_sePlansaturday['JOBSTART'] ?>', '<?= $result_sePlansaturday['JOBEND'] ?>');" class="btn btn-default btn-circle" data-toggle="modal" data-target="#modal_adddn"><span class="fa fa-plus"></span></button>
                                                                    </td>-->
                                                                    <td style="text-align: center;">
                                                                        <button title="COPY JOB" type="button" onclick="select_copyjob('<?= $result_sePlansaturday['JOBSTART'] ?>', '<?= $result_sePlansaturday['JOBEND'] ?>', '<?= $result_sePlansaturday['DATEVLIN'] ?>');" class="btn btn-default btn-circle" data-toggle="modal"  data-target="#modal_copyjob"><span class="fa fa-copy"></span></button>
                                                                    </td>

                                                                    <td>
                                                                        <input type="text" size="20"    name="txt_employeesat1<?= $i6 ?>" id="txt_employeesat1<?= $i6 ?>"  onchange="edit_vehicletransportplan(this.value, 'EMPLOYEENAME1', '<?= $result_sePlansaturday['VEHICLETRANSPORTPLANID'] ?>')"   class="form-control" value="<?= $result_sePlansaturday['EMPLOYEENAME1'] ?>">
                                                                        <label style="display: none"><?= $result_sePlansaturday['EMPLOYEENAME1'] ?></label>
                                                                    </td>



                                                                    <td>
                                                                        <input type="text" size="20"  name="txt_employeesat2<?= $i6 ?>"  id="txt_employeesat2<?= $i6 ?>"  onchange="edit_vehicletransportplan(this.value, 'EMPLOYEENAME2', '<?= $result_sePlansaturday['VEHICLETRANSPORTPLANID'] ?>')"   class="form-control" value="<?= $result_sePlansaturday['EMPLOYEENAME2'] ?>">
                                                                        <label style="display: none"><?= $result_sePlansaturday['EMPLOYEENAME2'] ?></label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" size="20"  name="txt_carsat<?= $i6 ?>"  id="txt_carsat<?= $i6 ?>"   onchange="edit_vehicletransportplan(this.value, 'THAINAME', '<?= $result_sePlansaturday['VEHICLETRANSPORTPLANID'] ?>')"   class="form-control" value="<?= $result_sePlansaturday['THAINAME'] ?>">
                                                                        <label style="display: none"><?= $result_sePlansaturday['THAINAME'] ?></label>
                                                                    </td>



                                                                    <td>
                                                                        <input type="text" size="20"   name="txt_jobstartsat<?= $i6 ?>" id="txt_jobstartsat<?= $i6 ?>"  onchange="edit_vehicletransportplan(this.value, 'JOBSTART', '<?= $result_sePlansaturday['VEHICLETRANSPORTPLANID'] ?>')"   class="form-control" value="<?= $result_sePlansaturday['JOBSTART'] ?>">
                                                                        <label style="display: none"><?= $result_sePlansaturday['JOBSTART'] ?></label>
                                                                    </td>

                                                                    <td>
                                                                        <input type="text" size="20"  name="txt_clustersat<?= $i6 ?>" id="txt_clustersat<?= $i6 ?>"  onchange="select_vehicletransportplanjobend(this.value, 'CLUSTER', '<?= $result_sePlansaturday['VEHICLETRANSPORTPLANID'] ?>', 'cb_jobendsat<?= $i6 ?>')"   class="form-control" value="<?= $result_sePlansaturday['CLUSTER'] ?>">
                                                                        <label style="display: none"><?= $result_sePlansaturday['CLUSTER'] ?></label>
                                                                    </td>


                                                                    <td>
                                                                        <div id="data_clusterdefcb_jobendsat<?= $i6 ?>">
                                                                            <select title="ปลายทาง" class="selectpicker" multiple="" data-actions-box="true"  id="cb_jobendsat<?= $i6 ?>" name="cb_jobendsat<?= $i6 ?>" >

                                                                                <?php
                                                                                $conditionJobend = " AND a.VEHICLETRANSPORTPLANID='" . $result_sePlansaturday['VEHICLETRANSPORTPLANID'] . "' AND a.CLUSTER='" . $result_sePlansaturday['CLUSTER'] . "'";
                                                                                $sql_seJobend = "{call megVehicletransportplan_v2(?,?)}";
                                                                                $params_seJobend = array(
                                                                                    array('select_jobend', SQLSRV_PARAM_IN),
                                                                                    array($conditionJobend, SQLSRV_PARAM_IN)
                                                                                );
                                                                                $query_seJobend = sqlsrv_query($conn, $sql_seJobend, $params_seJobend);
                                                                                while ($result_seJobend = sqlsrv_fetch_array($query_seJobend, SQLSRV_FETCH_ASSOC)) {

                                                                                    $arr_ph = explode(",", $result_seJobend['JOBEND']);
                                                                                    foreach ($arr_ph as $i) {
                                                                                        ?>
                                                                                        <option value = "<?= $i ?>"><?= $i ?></option>
                                                                                        <?php
                                                                                    }
                                                                                }
                                                                                ?>



                                                                            </select>
                                                                        </div>
                                                                        <div id="data_clustersrcb_jobendsat<?= $i6 ?>"></div>

                                                                    </td>


                                                                    <td ><p style="width: 150px"><?= $result_sePlansaturday['JOBNO'] ?></p></td>
                                                                    <td contenteditable="true"  onkeyup="edit_vehicletransportplaninner(this, 'TRIPNO', '<?= $result_sePlansaturday['VEHICLETRANSPORTPLANID'] ?>')"><?= $result_sePlansaturday['TRIPNO'] ?></td>

                                                                    <td><input type="text" size="20" id="txt_dateinput" name="txt_dateinput"  onchange="edit_datevehicletransportplan(this.value, 'DATEINPUT', '<?= $result_sePlansaturday['VEHICLETRANSPORTPLANID'] ?>')"  class="form-control datetimeen"  value="<?= $result_sePlansaturday['DATEINPUT'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_dateworking" name="txt_dateworking"  onchange="edit_datevehicletransportplan(this.value, 'DATEWORKING', '<?= $result_sePlansaturday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlansaturday['DATEWORKING'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_dateworksus" name="txt_dateworksus"  onchange="edit_datevehicletransportplan(this.value, 'DATEWORKSUS', '<?= $result_sePlansaturday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlansaturday['DATEWORKSUS'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_datepresent" name="txt_datepresent"  onchange="edit_datevehicletransportplan(this.value, 'DATEPRESENT', '<?= $result_sePlansaturday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlansaturday['DATEPRESENT'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_datevlin" name="txt_datevlin"  onchange="edit_datevehicletransportplan(this.value, 'DATEVLIN', '<?= $result_sePlansaturday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlansaturday['DATEVLIN'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_datevlout" name="txt_datevlout"  onchange="edit_datevehicletransportplan(this.value, 'DATEVLOUT', '<?= $result_sePlansaturday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlansaturday['DATEVLOUT'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_datedealerin" name="txt_datedealerin"  onchange="edit_datevehicletransportplan(this.value, 'DATEDEALERIN', '<?= $result_sePlansaturday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlansaturday['DATEDEALERIN'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_datereturn" name="txt_datereturn"  onchange="edit_datevehicletransportplan(this.value, 'DATERETURN', '<?= $result_sePlansaturday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlansaturday['DATERETURN'] ?>"></td>




                                                                    <td >
                                                                        <select  style="width: 150px" class="form-control" id="cb_status" name="cb_status" onchange = "update_vehicletransportplanjob('<?= $result_sePlansaturday['VEHICLETRANSPORTPLANID'] ?>', this.value, )">
                                                                            <option   value ="">เลือกสถานะ</option>
                                                                            <?php
                                                                            switch ($result_sePlansaturday['STATUSNUMBER']) {
                                                                                case '0': {
                                                                                        ?>
                                                                                        <option  selected=""  value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                case '1': {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   selected="" value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                case '2': {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option  selected="" value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;

                                                                                case '3': {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option selected=""  value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                case '4': {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option selected=""  value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                case '5': {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option  selected="" value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                default : {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                            }
                                                                            ?>


                                                                        </select>
                                                                    </td>                                                                                                                                                                                                                                                              




                                                                </tr>
                                                                <?php
                                                                $i6++;
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div></div>
                                            <div class="tab-pane fade" id="sunday">
                                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                                    <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example77" role="grid" aria-describedby="dataTables-example77" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th style="display: none">&nbsp;</th>
                                                                <th style="text-align: center;"><label style="width: 50px">DELETE JOB</label></th>
                                                                <th style="text-align: center;"><label style="width: 50px">COPY ROOT</label></th>
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




                                                            </tr>

                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i7 = 1;
                                                            if ($_GET['vehicletransportplanid'] != "") {
                                                                $conditionsunday = ($_GET['vehicletransportplanid'] != "") ? "  AND DATENAME(DW,a.DATEPRESENT) = 'Sunday' AND a.COMPANYCODE ='" . $_GET['companycode'] . "' AND a.CUSTOMERCODE ='" . $_GET['customercode'] . "' AND a.VEHICLETRANSPORTPLANID = '" . $_GET['vehicletransportplanid'] . "' " : "  AND DATENAME(DW,a.DATEPRESENT) AND a.CUSTOMERCODE ='" . $_GET['customercode'] . "'";
                                                            } else {
                                                                $conditionsunday = "  AND DATENAME(DW,a.DATEPRESENT) = 'Sunday'";
                                                            }

                                                            $sql_sePlansunday = "{call megVehicletransportplan_v2(?,?)}";
                                                            $params_sePlansunday = array(
                                                                array('select_vehicletransportplan', SQLSRV_PARAM_IN),
                                                                array($conditionsunday, SQLSRV_PARAM_IN)
                                                            );

                                                            $query_sePlansunday = sqlsrv_query($conn, $sql_sePlansunday, $params_sePlansunday);
                                                            while ($result_sePlansunday = sqlsrv_fetch_array($query_sePlansunday, SQLSRV_FETCH_ASSOC)) {
                                                                ?>
                                                                <tr 
                                                                <?php
                                                                if (($result_sePlansunday['SRBASE4L'] == '' || $result_sePlansunday['SRBASE4L'] == '0.00') &&
                                                                        ($result_sePlansunday['SRBASE8L'] == '' || $result_sePlansunday['SRBASE8L'] == '0.00') &&
                                                                        ($result_sePlansunday['GWBASE4L'] == '' || $result_sePlansunday['GWBASE4L'] == '0.00') &&
                                                                        ($result_sePlansunday['GWBASE8L'] == '' || $result_sePlansunday['GWBASE8L'] == '0.00') &&
                                                                        ($result_sePlansunday['BPBASE4L'] == '' || $result_sePlansunday['BPBASE4L'] == '0.00') &&
                                                                        ($result_sePlansunday['BPBASE8L'] == '' || $result_sePlansunday['BPBASE8L'] == '0.00') &&
                                                                        ($result_sePlansunday['OTHBASE4L'] == '' || $result_sePlansunday['OTHBASE4L'] == '0.00') &&
                                                                        ($result_sePlansunday['OTHBASE8L'] == '' || $result_sePlansunday['OTHBASE8L'] == '0.00')) {
                                                                    ?>
                                                                        style="color: red"
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    >
                                                                    <td style="display: none">&nbsp;</td>

                                                                    <td style="text-align: center;">
                                                                        <button onclick="delete_vehicletransportplan('<?= $result_sePlansunday['VEHICLETRANSPORTPLANID'] ?>');" title="ลบแผนการขนส่ง" type="button" class="btn btn-default btn-circle"><span class="fa fa-times"></span></button> 
                                                                    </td>
                                                                    <td style="text-align: center;">
                                                                        <button onclick="add_vehicletransportplanroot('<?= $result_sePlansunday['CUSTOMERCODE'] ?>', '<?= $result_sePlansunday['COMPANYCODE'] ?>', '<?= $result_sePlansunday['VEHICLEREGISNUMBER1'] ?>', '<?= $result_sePlansunday['VEHICLEREGISNUMBER2'] ?>', '<?= $result_sePlansunday['THAINAME'] ?>', '<?= $result_sePlansunday['ENGNAME'] ?>', '<?= $result_sePlansunday['VEHICLETRANSPORTPRICEID'] ?>', '<?= $result_sePlansunday['CLUSTER'] ?>', '<?= $result_sePlansunday['DEALERCODE'] ?>', '<?= $result_sePlansunday['NAME'] ?>', '<?= $result_sePlansunday['SRBASE4L'] ?>', '<?= $result_sePlansunday['SRBASE8L'] ?>', '<?= $result_sePlansunday['GWBASE4L'] ?>', '<?= $result_sePlansunday['GWBASE8L'] ?>', '<?= $result_sePlansunday['BPBASE4L'] ?>', '<?= $result_sePlansunday['BPBASE8L'] ?>', '<?= $result_sePlansunday['OTHBASE4L'] ?>', '<?= $result_sePlansunday['OTHBASE8L'] ?>', '<?= $result_sePlansunday['E1'] ?>', '<?= $result_sePlansunday['E2'] ?>', '<?= $result_sePlansunday['E3'] ?>', '<?= $result_sePlansunday['E4'] ?>', '<?= $result_sePlansunday['C1'] ?>', '<?= $result_sePlansunday['C2'] ?>', '<?= $result_sePlansunday['C3'] ?>', '<?= $result_sePlansunday['C4'] ?>', '<?= $result_sePlansunday['C5'] ?>', '<?= $result_sePlansunday['C6'] ?>', '<?= $result_sePlansunday['C7'] ?>', '<?= $result_sePlansunday['C8'] ?>', '<?= $result_sePlansunday['C9'] ?>', '<?= $result_sePlansunday['O1'] ?>', '<?= $result_sePlansunday['O2'] ?>', '<?= $result_sePlansunday['O3'] ?>', '<?= $result_sePlansunday['O4'] ?>', '<?= $result_sePlansunday['JOBSTART'] ?>', '<?= $result_sePlansunday['JOBEND'] ?>', '<?= $result_sePlansunday['EMPLOYEECODE1'] ?>', '<?= $result_sePlansunday['EMPLOYEENAME1'] ?>', '<?= $result_sePlansunday['EMPLOYEECODE2'] ?>', '<?= $result_sePlansunday['EMPLOYEENAME2'] ?>', '<?= $result_sePlansunday['EMPLOYEECODE3'] ?>', '<?= $result_sePlansunday['EMPLOYEENAME3'] ?>', '<?= $result_sePlansunday['EMPLOYEECODE4'] ?>', '<?= $result_sePlansunday['EMPLOYEENAME4'] ?>', '<?= $result_sePlansunday['JOBNO'] ?>', '<?= $result_sePlansunday['TRIPNO'] ?>', '<?= $result_sePlansunday['DATEINPUT'] ?>', '<?= $result_sePlansunday['DATESTART'] ?>', '<?= $result_sePlansunday['DATEWORKING'] ?>', '<?= $result_sePlansunday['DATEPRESENT'] ?>', '<?= $result_sePlansunday['DATEVLIN'] ?>', '<?= $result_sePlansunday['DATEVLOUT'] ?>', '<?= $result_sePlansunday['DATEDEALERIN'] ?>', '<?= $result_sePlansunday['DATERETURN'] ?>', '<?= $result_sePlansunday['DATEWORKSUS'] ?>', '<?= $result_sePlansunday['STATUS'] ?>', '<?= $result_sePlansunday['ACTIVESTATUS'] ?>', '<?= $result_sePlansunday['REMARK'] ?>')" title="คัดลอกรูทการขนส่ง" type="button" class="btn btn-default btn-circle"><span class="fa fa-copy"></span></button> 
                                                                    </td>
                                                                    <!--<td style="text-align: center;">
                                                                        <button title="เพิ่มเอกสารรายละเอียดสินค้า" type="button" onclick="select_vehicletransportplanid('<?= $result_sePlansunday['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_sePlansunday['JOBSTART'] ?>', '<?= $result_sePlansunday['JOBEND'] ?>');" class="btn btn-default btn-circle" data-toggle="modal" data-target="#modal_adddn"><span class="fa fa-plus"></span></button>
                                                                    </td>-->
                                                                    <td style="text-align: center;">
                                                                        <button title="COPY JOB" type="button" onclick="select_copyjob('<?= $result_sePlansunday['JOBSTART'] ?>', '<?= $result_sePlansunday['JOBEND'] ?>', '<?= $result_sePlansunday['DATEVLIN'] ?>');" class="btn btn-default btn-circle" data-toggle="modal"  data-target="#modal_copyjob"><span class="fa fa-copy"></span></button>
                                                                    </td>

                                                                    <td>
                                                                        <input type="text" size="20"   name="txt_employeesun1<?= $i7 ?>" id="txt_employeesun1<?= $i7 ?>"  onchange="edit_vehicletransportplan(this.value, 'EMPLOYEENAME1', '<?= $result_sePlansunday['VEHICLETRANSPORTPLANID'] ?>')"   class="form-control" value="<?= $result_sePlansunday['EMPLOYEENAME1'] ?>">
                                                                        <label style="display: none"><?= $result_sePlansunday['EMPLOYEENAME1'] ?></label>
                                                                    </td>



                                                                    <td>
                                                                        <input type="text" size="20"  name="txt_employeesun2<?= $i7 ?>"  id="txt_employeesun2<?= $i7 ?>"  onchange="edit_vehicletransportplan(this.value, 'EMPLOYEENAME2', '<?= $result_sePlansunday['VEHICLETRANSPORTPLANID'] ?>')"   class="form-control" value="<?= $result_sePlansunday['EMPLOYEENAME2'] ?>">
                                                                        <label style="display: none"><?= $result_sePlansunday['EMPLOYEENAME2'] ?></label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" size="20"  name="txt_carsun<?= $i7 ?>"  id="txt_carsun<?= $i7 ?>"   onchange="edit_vehicletransportplan(this.value, 'THAINAME', '<?= $result_sePlansunday['VEHICLETRANSPORTPLANID'] ?>')"   class="form-control" value="<?= $result_sePlansunday['THAINAME'] ?>">
                                                                        <label style="display: none"><?= $result_sePlansunday['THAINAME'] ?></label>
                                                                    </td>



                                                                    <td>
                                                                        <input type="text" size="20"   name="txt_jobstartsun<?= $i7 ?>" id="txt_jobstartsun<?= $i7 ?>"  onchange="edit_vehicletransportplan(this.value, 'JOBSTART', '<?= $result_sePlansunday['VEHICLETRANSPORTPLANID'] ?>')"   class="form-control" value="<?= $result_sePlansunday['JOBSTART'] ?>">
                                                                        <label style="display: none"><?= $result_sePlansunday['JOBSTART'] ?></label>
                                                                    </td>

                                                                    <td>
                                                                        <input type="text" size="20"  name="txt_clustersun<?= $i7 ?>" id="txt_clustersun<?= $i7 ?>"  onchange="select_vehicletransportplanjobend(this.value, 'CLUSTER', '<?= $result_sePlansunday['VEHICLETRANSPORTPLANID'] ?>', 'cb_jobendsun<?= $i7 ?>')"   class="form-control" value="<?= $result_sePlansunday['CLUSTER'] ?>">
                                                                        <label style="display: none"><?= $result_sePlansunday['CLUSTER'] ?></label>
                                                                    </td>


                                                                    <td>
                                                                        <div id="data_clusterdefcb_jobendsun<?= $i7 ?>">
                                                                            <select title="ปลายทาง" class="selectpicker" multiple="" data-actions-box="true"  id="cb_jobendsun<?= $i7 ?>" name="cb_jobendsun<?= $i7 ?>" >

                                                                                <?php
                                                                                $conditionJobend = " AND a.VEHICLETRANSPORTPLANID='" . $result_sePlansunday['VEHICLETRANSPORTPLANID'] . "' AND a.CLUSTER='" . $result_sePlansunday['CLUSTER'] . "'";
                                                                                $sql_seJobend = "{call megVehicletransportplan_v2(?,?)}";
                                                                                $params_seJobend = array(
                                                                                    array('select_jobend', SQLSRV_PARAM_IN),
                                                                                    array($conditionJobend, SQLSRV_PARAM_IN)
                                                                                );
                                                                                $query_seJobend = sqlsrv_query($conn, $sql_seJobend, $params_seJobend);
                                                                                while ($result_seJobend = sqlsrv_fetch_array($query_seJobend, SQLSRV_FETCH_ASSOC)) {

                                                                                    $arr_ph = explode(",", $result_seJobend['JOBEND']);
                                                                                    foreach ($arr_ph as $i) {
                                                                                        ?>
                                                                                        <option value = "<?= $i ?>"><?= $i ?></option>
                                                                                        <?php
                                                                                    }
                                                                                }
                                                                                ?>



                                                                            </select>
                                                                        </div>
                                                                        <div id="data_clustersrcb_jobendsun<?= $i7 ?>"></div>

                                                                    </td>

                                                                    <td ><p style="width: 150px"><?= $result_sePlansunday['JOBNO'] ?></p></td>
                                                                    <td contenteditable="true"  onkeyup="edit_vehicletransportplaninner(this, 'TRIPNO', '<?= $result_sePlansunday['VEHICLETRANSPORTPLANID'] ?>')"><?= $result_sePlansunday['TRIPNO'] ?></td>

                                                                    <td><input type="text" size="20" id="txt_dateinput" name="txt_dateinput"  onchange="edit_datevehicletransportplan(this.value, 'DATEINPUT', '<?= $result_sePlansunday['VEHICLETRANSPORTPLANID'] ?>')"  class="form-control datetimeen"  value="<?= $result_sePlansunday['DATEINPUT'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_dateworking" name="txt_dateworking"  onchange="edit_datevehicletransportplan(this.value, 'DATEWORKING', '<?= $result_sePlansunday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlansunday['DATEWORKING'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_dateworksus" name="txt_dateworksus"  onchange="edit_datevehicletransportplan(this.value, 'DATEWORKSUS', '<?= $result_sePlansunday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlansunday['DATEWORKSUS'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_datepresent" name="txt_datepresent"  onchange="edit_datevehicletransportplan(this.value, 'DATEPRESENT', '<?= $result_sePlansunday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlansunday['DATEPRESENT'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_datevlin" name="txt_datevlin"  onchange="edit_datevehicletransportplan(this.value, 'DATEVLIN', '<?= $result_sePlansunday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlansunday['DATEVLIN'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_datevlout" name="txt_datevlout"  onchange="edit_datevehicletransportplan(this.value, 'DATEVLOUT', '<?= $result_sePlansunday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlansunday['DATEVLOUT'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_datedealerin" name="txt_datedealerin"  onchange="edit_datevehicletransportplan(this.value, 'DATEDEALERIN', '<?= $result_sePlansunday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlansunday['DATEDEALERIN'] ?>"></td>
                                                                    <td><input type="text" size="20" id="txt_datereturn" name="txt_datereturn"  onchange="edit_datevehicletransportplan(this.value, 'DATERETURN', '<?= $result_sePlansunday['VEHICLETRANSPORTPLANID'] ?>')" class="form-control datetimeen"  value="<?= $result_sePlansunday['DATERETURN'] ?>"></td>




                                                                    <td >
                                                                        <select  style="width: 150px" class="form-control" id="cb_status" name="cb_status" onchange = "update_vehicletransportplanjob('<?= $result_sePlansunday['VEHICLETRANSPORTPLANID'] ?>', this.value, )">
                                                                            <option   value ="">เลือกสถานะ</option>
                                                                            <?php
                                                                            switch ($result_sePlansunday['STATUSNUMBER']) {
                                                                                case '0': {
                                                                                        ?>
                                                                                        <option  selected=""  value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                case '1': {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   selected="" value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                case '2': {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option  selected="" value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;

                                                                                case '3': {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option selected=""  value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                case '4': {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option selected=""  value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                case '5': {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option  selected="" value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                default : {
                                                                                        ?>
                                                                                        <option    value ="0">แผนงานยกเลิก</option>
                                                                                        <option   value ="1">แผนงานยังไม่ถึงเวลารายงาน</option>
                                                                                        <option   value ="2">แผนงานเลยเวลารายงานตัว</option>
                                                                                        <option   value ="3">รายงานตัวเปิด Job เริ่มงาน</option>
                                                                                        <option   value ="4">รายงานตัวกลับปิด Job งาน</option>
                                                                                        <option   value ="5">ปิดงาน</option>
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                            }
                                                                            ?>


                                                                        </select>
                                                                    </td>                                                                                                                                                                                                                                                              



                                                                </tr>
                                                                <?php
                                                                $i7++;
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



        <script type="text/javascript">
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
<?php
$jobrccstart = select_jobautocomplatestartrrc('megVehicletransportpricerrc_v2', 'select_startways', '');
$jobrccend = select_jobautocomplateendrrc('megVehicletransportpricerrc_v2', 'select_endways', '');
$job = select_jobautocomplate('megVehicletransportprice_v2', 'select_vehicletransportprice', '');
$emp = select_empautocomplate('megEmployeeEHR_v2', 'select_employeeehr2', " AND d.Company_Code IN ('RCC','RATC','RRC')");
$thainame = select_carautocomplate('megVehicleinfo_v2', 'select_vehicleinfo', " AND a.THAINAME != '-' AND ((a.THAINAME  LIKE '%R-%' OR a.THAINAME  LIKE '%RA-%' OR a.THAINAME  LIKE '%RP-%' OR a.THAINAME  LIKE '%ดินแดง%'  OR a.THAINAME  LIKE '%อุทัยธานี%'  OR a.THAINAME  LIKE '%คลองเขื่อน%'  OR a.THAINAME  LIKE '%ด่านช้าง%'  OR a.THAINAME  LIKE '%สวนผึ้ง%') OR (a.ENGNAME  LIKE '%R-%' OR a.ENGNAME  LIKE '%RA-%' OR a.ENGNAME  LIKE '%RP-%' OR a.ENGNAME LIKE '%ดินแดง%'  OR a.ENGNAME LIKE '%อุทัยธานี%'  OR a.ENGNAME LIKE '%คลองเขื่อน%'  OR a.ENGNAME LIKE '%ด่านช้าง%'  OR a.ENGNAME LIKE '%สวนผึ้ง%'))");
$vehiclenumber = select_vehiclenumberautocomplate('megVehicleinfo_v2', 'select_vehicleinfo', " AND a.THAINAME != '-' AND ((a.THAINAME  LIKE '%R-%' OR a.THAINAME  LIKE '%RA-%' OR a.THAINAME  LIKE '%RP-%' OR a.THAINAME  LIKE '%ดินแดง%'  OR a.THAINAME  LIKE '%อุทัยธานี%'  OR a.THAINAME  LIKE '%คลองเขื่อน%'  OR a.THAINAME  LIKE '%ด่านช้าง%'  OR a.THAINAME  LIKE '%สวนผึ้ง%') OR (a.ENGNAME  LIKE '%R-%' OR a.ENGNAME  LIKE '%RA-%' OR a.ENGNAME  LIKE '%RP-%' OR a.ENGNAME LIKE '%ดินแดง%'  OR a.ENGNAME LIKE '%อุทัยธานี%'  OR a.ENGNAME LIKE '%คลองเขื่อน%'  OR a.ENGNAME LIKE '%ด่านช้าง%'  OR a.ENGNAME LIKE '%สวนผึ้ง%'))");
$cluster = select_clusterautocomplate('megVehicletransportprice_v2', 'select_cluster', '');
?>


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



            var txt_jobstartm = [<?= $job ?>];
            for (n = 1; n < <?= $i1 ?>; n++) {
                $("#txt_jobstartm" + n).autocomplete({
                    source: [txt_jobstartm]
                });
            }

            var txt_jobstarttu = [<?= $job ?>];
            for (n = 1; n < <?= $i2 ?>; n++) {
                $("#txt_jobstarttu" + n).autocomplete({
                    source: [txt_jobstarttu]
                });
            }

            var txt_jobstartw = [<?= $job ?>];
            for (n = 1; n < <?= $i3 ?>; n++) {
                $("#txt_jobstartw" + n).autocomplete({
                    source: [txt_jobstartw]
                });
            }

            var txt_jobstartth = [<?= $job ?>];
            for (n = 1; n < <?= $i4 ?>; n++) {
                $("#txt_jobstartth" + n).autocomplete({
                    source: [txt_jobstartth]
                });
            }

            var txt_jobstartf = [<?= $job ?>];
            for (n = 1; n < <?= $i5 ?>; n++) {
                $("#txt_jobstartf" + n).autocomplete({
                    source: [txt_jobstartf]
                });
            }

            var txt_jobstartsat = [<?= $job ?>];
            for (n = 1; n < <?= $i6 ?>; n++) {
                $("#txt_jobstartsat" + n).autocomplete({
                    source: [txt_jobstartsat]
                });
            }

            var txt_jobstartsun = [<?= $job ?>];
            for (n = 1; n < <?= $i7 ?>; n++) {
                $("#txt_jobstartsun" + n).autocomplete({
                    source: [txt_jobstartsun]
                });
            }

            var txt_clusterm = [<?= $cluster ?>];
            for (n = 1; n < <?= $i1 ?>; n++) {
                $("#txt_clusterm" + n).autocomplete({
                    source: [txt_clusterm]
                });
            }

            var txt_clustertu = [<?= $cluster ?>];
            for (n = 1; n < <?= $i2 ?>; n++) {
                $("#txt_clustertu" + n).autocomplete({
                    source: [txt_clustertu]
                });
            }

            var txt_clusterw = [<?= $cluster ?>];
            for (n = 1; n < <?= $i3 ?>; n++) {
                $("#txt_clusterw" + n).autocomplete({
                    source: [txt_clusterw]
                });
            }

            var txt_clusterth = [<?= $cluster ?>];
            for (n = 1; n < <?= $i4 ?>; n++) {
                $("#txt_clusterth" + n).autocomplete({
                    source: [txt_clusterth]
                });
            }

            var txt_clusterf = [<?= $cluster ?>];
            for (n = 1; n < <?= $i5 ?>; n++) {
                $("#txt_clusterf" + n).autocomplete({
                    source: [txt_clusterf]
                });
            }

            var txt_clustersat = [<?= $cluster ?>];
            for (n = 1; n < <?= $i6 ?>; n++) {
                $("#txt_clustersat" + n).autocomplete({
                    source: [txt_clustersat]
                });
            }

            var txt_clustersun = [<?= $cluster ?>];
            for (n = 1; n < <?= $i7 ?>; n++) {
                $("#txt_clustersun" + n).autocomplete({
                    source: [txt_clustersun]
                });
            }



            var txt_jobendm = [<?= $job ?>];
            for (n = 1; n < <?= $i1 ?>; n++) {
                $("#txt_jobendm" + n).autocomplete({
                    source: [txt_jobendm]
                });
            }

            var txt_jobendtu = [<?= $job ?>];
            for (n = 1; n < <?= $i2 ?>; n++) {
                $("#txt_jobendtu" + n).autocomplete({
                    source: [txt_jobendtu]
                });
            }

            var txt_jobendw = [<?= $job ?>];
            for (n = 1; n < <?= $i3 ?>; n++) {
                $("#txt_jobendw" + n).autocomplete({
                    source: [txt_jobendw]
                });
            }

            var txt_jobendth = [<?= $job ?>];
            for (n = 1; n < <?= $i4 ?>; n++) {
                $("#txt_jobendth" + n).autocomplete({
                    source: [txt_jobendth]
                });
            }

            var txt_jobendf = [<?= $job ?>];
            for (n = 1; n < <?= $i5 ?>; n++) {

                $("#txt_jobendf" + n).autocomplete({
                    source: [txt_jobendf]
                });
            }

            var txt_jobendsat = [<?= $job ?>];
            for (n = 1; n < <?= $i6 ?>; n++) {
                $("#txt_jobendsat" + n).autocomplete({
                    source: [txt_jobendsat]
                });
            }

            var txt_jobendsun = [<?= $job ?>];
            for (n = 1; n < <?= $i7 ?>; n++) {
                $("#txt_jobendsun" + n).autocomplete({
                    source: [txt_jobendsun]
                });
            }

            var txt_employeem1 = [<?= $emp ?>];
            for (n = 1; n < <?= $i1 ?>; n++) {
                $("#txt_employeem1" + n).autocomplete({
                    source: [txt_employeem1]
                });
            }

            var txt_employeetu1 = [<?= $emp ?>];
            for (n = 1; n < <?= $i2 ?>; n++) {
                $("#txt_employeetu1" + n).autocomplete({
                    source: [txt_employeetu1]
                });
            }

            var txt_employeew1 = [<?= $emp ?>];
            for (n = 1; n < <?= $i3 ?>; n++) {
                $("#txt_employeew1" + n).autocomplete({
                    source: [txt_employeew1]
                });
            }

            var txt_employeeth1 = [<?= $emp ?>];
            for (n = 1; n < <?= $i4 ?>; n++) {
                $("#txt_employeeth1" + n).autocomplete({
                    source: [txt_employeeth1]
                });
            }

            var txt_employeef1 = [<?= $emp ?>];
            for (n = 1; n < <?= $i5 ?>; n++) {
                $("#txt_employeef1" + n).autocomplete({
                    source: [txt_employeef1]
                });
            }

            var txt_employeesat1 = [<?= $emp ?>];
            for (n = 1; n < <?= $i6 ?>; n++) {
                $("#txt_employeesat1" + n).autocomplete({
                    source: [txt_employeesat1]
                });
            }

            var txt_employeesun1 = [<?= $emp ?>];
            for (n = 1; n < <?= $i7 ?>; n++) {
                $("#txt_employeesun1" + n).autocomplete({
                    source: [txt_employeesun1]
                });
            }

            var txt_employeem2 = [<?= $emp ?>];
            for (n = 1; n < <?= $i1 ?>; n++) {
                $("#txt_employeem2" + n).autocomplete({
                    source: [txt_employeem2]
                });
            }

            var txt_employeetu2 = [<?= $emp ?>];
            for (n = 1; n < <?= $i2 ?>; n++) {
                $("#txt_employeetu2" + n).autocomplete({
                    source: [txt_employeetu2]
                });
            }

            var txt_employeew2 = [<?= $emp ?>];
            for (n = 1; n < <?= $i3 ?>; n++) {
                $("#txt_employeew2" + n).autocomplete({
                    source: [txt_employeew2]
                });
            }

            var txt_employeeth2 = [<?= $emp ?>];
            for (n = 1; n < <?= $i4 ?>; n++) {
                $("#txt_employeeth2" + n).autocomplete({
                    source: [txt_employeeth2]
                });
            }

            var txt_employeef2 = [<?= $emp ?>];
            for (n = 1; n < <?= $i5 ?>; n++) {
                $("#txt_employeef2" + n).autocomplete({
                    source: [txt_employeef2]
                });
            }

            var txt_employeesat2 = [<?= $emp ?>];
            for (n = 1; n < <?= $i6 ?>; n++) {
                $("#txt_employeesat2" + n).autocomplete({
                    source: [txt_employeesat2]
                });
            }

            var txt_employeesun2 = [<?= $emp ?>];
            for (n = 1; n < <?= $i7 ?>; n++) {
                $("#txt_employeesun2" + n).autocomplete({
                    source: [txt_employeesun2]
                });
            }

            var txt_carm = [<?= $thainame ?>];
            for (n = 1; n < <?= $i1 ?>; n++) {
                $("#txt_carm" + n).autocomplete({
                    source: [txt_carm]
                });
            }

            var txt_cartu = [<?= $vehiclenumber ?>];
            for (n = 1; n < <?= $i2 ?>; n++) {
                $("#txt_cartu" + n).autocomplete({
                    source: [txt_cartu]
                });
            }

            var txt_carw = [<?= $vehiclenumber ?>];
            for (n = 1; n < <?= $i3 ?>; n++) {
                $("#txt_carw" + n).autocomplete({
                    source: [txt_carw]
                });
            }

            var txt_carth = [<?= $vehiclenumber ?>];
            for (n = 1; n < <?= $i4 ?>; n++) {

                $("#txt_carth" + n).autocomplete({
                    source: [txt_carth]
                });
            }

            var txt_carf = [<?= $vehiclenumber ?>];
            for (n = 1; n < <?= $i5 ?>; n++) {
                $("#txt_carf" + n).autocomplete({
                    source: [txt_carf]
                });
            }

            var txt_carsat = [<?= $vehiclenumber ?>];
            for (n = 1; n < <?= $i6 ?>; n++) {
                $("#txt_carsat" + n).autocomplete({
                    source: [txt_carsat]
                });
            }

            var txt_carsun = [<?= $vehiclenumber ?>];
            for (n = 1; n < <?= $i7 ?>; n++) {
                $("#txt_carsun" + n).autocomplete({
                    source: [txt_carsun]
                });
            }


            var txt_copydiagramemployeename1 = [<?= $emp ?>];
            $("#txt_copydiagramemployeename1").autocomplete({
                source: [txt_copydiagramemployeename1]
            });

            var txt_copydiagramemployeename2 = [<?= $emp ?>];
            $("#txt_copydiagramemployeename2").autocomplete({
                source: [txt_copydiagramemployeename2]
            });

            var txt_copydiagramthainame = [<?= $thainame ?>];
            $("#txt_copydiagramthainame").autocomplete({
                source: [txt_copydiagramthainame]
            });



            var txt_copydiagramjobstart = [<?= $jobrccstart ?>];
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

                $('#dataTables-example2').DataTable({
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
                        txt_flg: "showupdate_vehicletransportplan", datestart: document.getElementById("txt_datestartsr").value, dateend: document.getElementById("txt_dateendsr").value, statusnumber: document.getElementById("cb_statussr").value
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



                        var txt_jobstartm = [<?= $job ?>];
                        for (n = 1; n < <?= $i1 ?>; n++) {
                            $("#txt_jobstartm" + n).autocomplete({
                                source: [txt_jobstartm]
                            });
                        }

                        var txt_jobstarttu = [<?= $job ?>];
                        for (n = 1; n < <?= $i2 ?>; n++) {
                            $("#txt_jobstarttu" + n).autocomplete({
                                source: [txt_jobstarttu]
                            });
                        }

                        var txt_jobstartw = [<?= $job ?>];
                        for (n = 1; n < <?= $i3 ?>; n++) {
                            $("#txt_jobstartw" + n).autocomplete({
                                source: [txt_jobstartw]
                            });
                        }

                        var txt_jobstartth = [<?= $job ?>];
                        for (n = 1; n < <?= $i4 ?>; n++) {
                            $("#txt_jobstartth" + n).autocomplete({
                                source: [txt_jobstartth]
                            });
                        }

                        var txt_jobstartf = [<?= $job ?>];
                        for (n = 1; n < <?= $i5 ?>; n++) {
                            $("#txt_jobstartf" + n).autocomplete({
                                source: [txt_jobstartf]
                            });
                        }

                        var txt_jobstartsat = [<?= $job ?>];
                        for (n = 1; n < <?= $i6 ?>; n++) {
                            $("#txt_jobstartsat" + n).autocomplete({
                                source: [txt_jobstartsat]
                            });
                        }

                        var txt_jobstartsun = [<?= $job ?>];
                        for (n = 1; n < <?= $i7 ?>; n++) {
                            $("#txt_jobstartsun" + n).autocomplete({
                                source: [txt_jobstartsun]
                            });
                        }

                        var txt_jobendm = [<?= $job ?>];
                        for (n = 1; n < <?= $i1 ?>; n++) {
                            $("#txt_jobendm" + n).autocomplete({
                                source: [txt_jobendm]
                            });
                        }

                        var txt_jobendtu = [<?= $job ?>];
                        for (n = 1; n < <?= $i2 ?>; n++) {
                            $("#txt_jobendtu" + n).autocomplete({
                                source: [txt_jobendtu]
                            });
                        }

                        var txt_jobendw = [<?= $job ?>];
                        for (n = 1; n < <?= $i3 ?>; n++) {
                            $("#txt_jobendw" + n).autocomplete({
                                source: [txt_jobendw]
                            });
                        }

                        var txt_jobendth = [<?= $job ?>];
                        for (n = 1; n < <?= $i4 ?>; n++) {
                            $("#txt_jobendth" + n).autocomplete({
                                source: [txt_jobendth]
                            });
                        }

                        var txt_jobendf = [<?= $job ?>];
                        for (n = 1; n < <?= $i5 ?>; n++) {

                            $("#txt_jobendf" + n).autocomplete({
                                source: [txt_jobendf]
                            });
                        }

                        var txt_jobendsat = [<?= $job ?>];
                        for (n = 1; n < <?= $i6 ?>; n++) {
                            $("#txt_jobendsat" + n).autocomplete({
                                source: [txt_jobendsat]
                            });
                        }

                        var txt_jobendsun = [<?= $job ?>];
                        for (n = 1; n < <?= $i7 ?>; n++) {
                            $("#txt_jobendsun" + n).autocomplete({
                                source: [txt_jobendsun]
                            });
                        }

                        var txt_employeem1 = [<?= $emp ?>];
                        for (n = 1; n < <?= $i1 ?>; n++) {
                            $("#txt_employeem1" + n).autocomplete({
                                source: [txt_employeem1]
                            });
                        }

                        var txt_employeetu1 = [<?= $emp ?>];
                        for (n = 1; n < <?= $i2 ?>; n++) {
                            $("#txt_employeetu1" + n).autocomplete({
                                source: [txt_employeetu1]
                            });
                        }

                        var txt_employeew1 = [<?= $emp ?>];
                        for (n = 1; n < <?= $i3 ?>; n++) {
                            $("#txt_employeew1" + n).autocomplete({
                                source: [txt_employeew1]
                            });
                        }

                        var txt_employeeth1 = [<?= $emp ?>];
                        for (n = 1; n < <?= $i4 ?>; n++) {
                            $("#txt_employeeth1" + n).autocomplete({
                                source: [txt_employeeth1]
                            });
                        }

                        var txt_employeef1 = [<?= $emp ?>];
                        for (n = 1; n < <?= $i5 ?>; n++) {
                            $("#txt_employeef1" + n).autocomplete({
                                source: [txt_employeef1]
                            });
                        }

                        var txt_employeesat1 = [<?= $emp ?>];
                        for (n = 1; n < <?= $i6 ?>; n++) {
                            $("#txt_employeesat1" + n).autocomplete({
                                source: [txt_employeesat1]
                            });
                        }

                        var txt_employeesun1 = [<?= $emp ?>];
                        for (n = 1; n < <?= $i7 ?>; n++) {
                            $("#txt_employeesun1" + n).autocomplete({
                                source: [txt_employeesun1]
                            });
                        }

                        var txt_employeem2 = [<?= $emp ?>];
                        for (n = 1; n < <?= $i1 ?>; n++) {
                            $("#txt_employeem2" + n).autocomplete({
                                source: [txt_employeem2]
                            });
                        }

                        var txt_employeetu2 = [<?= $emp ?>];
                        for (n = 1; n < <?= $i2 ?>; n++) {
                            $("#txt_employeetu2" + n).autocomplete({
                                source: [txt_employeetu2]
                            });
                        }

                        var txt_employeew2 = [<?= $emp ?>];
                        for (n = 1; n < <?= $i3 ?>; n++) {
                            $("#txt_employeew2" + n).autocomplete({
                                source: [txt_employeew2]
                            });
                        }

                        var txt_employeeth2 = [<?= $emp ?>];
                        for (n = 1; n < <?= $i4 ?>; n++) {
                            $("#txt_employeeth2" + n).autocomplete({
                                source: [txt_employeeth2]
                            });
                        }

                        var txt_employeef2 = [<?= $emp ?>];
                        for (n = 1; n < <?= $i5 ?>; n++) {
                            $("#txt_employeef2" + n).autocomplete({
                                source: [txt_employeef2]
                            });
                        }

                        var txt_employeesat2 = [<?= $emp ?>];
                        for (n = 1; n < <?= $i6 ?>; n++) {
                            $("#txt_employeesat2" + n).autocomplete({
                                source: [txt_employeesat2]
                            });
                        }

                        var txt_employeesun2 = [<?= $emp ?>];
                        for (n = 1; n < <?= $i7 ?>; n++) {
                            $("#txt_employeesun2" + n).autocomplete({
                                source: [txt_employeesun2]
                            });
                        }

                        var txt_carm = [<?= $thainame ?>];
                        for (n = 1; n < <?= $i1 ?>; n++) {
                            $("#txt_carm" + n).autocomplete({
                                source: [txt_carm]
                            });
                        }

                        var txt_cartu = [<?= $thainame ?>];
                        for (n = 1; n < <?= $i2 ?>; n++) {
                            $("#txt_cartu" + n).autocomplete({
                                source: [txt_cartu]
                            });
                        }

                        var txt_carw = [<?= $thainame ?>];
                        for (n = 1; n < <?= $i3 ?>; n++) {
                            $("#txt_carw" + n).autocomplete({
                                source: [txt_carw]
                            });
                        }

                        var txt_carth = [<?= $thainame ?>];
                        for (n = 1; n < <?= $i4 ?>; n++) {

                            $("#txt_carth" + n).autocomplete({
                                source: [txt_carth]
                            });
                        }

                        var txt_carf = [<?= $thainame ?>];
                        for (n = 1; n < <?= $i5 ?>; n++) {
                            $("#txt_carf" + n).autocomplete({
                                source: [txt_carf]
                            });
                        }

                        var txt_carsat = [<?= $thainame ?>];
                        for (n = 1; n < <?= $i6 ?>; n++) {
                            $("#txt_carsat" + n).autocomplete({
                                source: [txt_carsat]
                            });
                        }

                        var txt_carsun = [<?= $thainame ?>];
                        for (n = 1; n < <?= $i7 ?>; n++) {
                            $("#txt_carsun" + n).autocomplete({
                                source: [txt_carsun]
                            });
                        }




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
            function checknull_copydiagram()
            {

                if (document.getElementById("txt_copydiagramemployeename1").value == "")
                {
                    alert("พนักงาน (1) เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("txt_copydiagramthainame").value == "")
                {
                    alert("ชื่อรถ เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("txt_copydiagramjobstart").value == "")
                {
                    alert("ต้นทาง เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("cb_copydiagramcluster").value == "")
                {
                    alert("CLUSTER เป็นค่าว่าง !!!");
                    return false;
                }
                /*else if (document.getElementById("txt_copydiagramdatepresent").value == "")
                 {
                 alert("เวลารายงานตัว  เป็นค่าว่าง !!!");
                 return false;
                 } else if (document.getElementById("txt_copydiagramdatevlin").value == "")
                 {
                 alert("เวลาเข้าวีแอล เป็นค่าว่าง !!!");
                 return false;
                 } else if (document.getElementById("txt_copydiagramdatevlout").value == "")
                 {
                 alert("เวลาออกวีแอล เป็นค่าว่าง !!!");
                 return false;
                 } else if (document.getElementById("txt_copydiagramdatedealerin").value == "")
                 {
                 alert("เวลาเข้าดีลเลอร์ เป็นค่าว่าง !!!");
                 return false;
                 } else if (document.getElementById("txt_copydiagramdatereturn").value == "")
                 {
                 alert("เวลากลับบริษัท เป็นค่าว่าง !!!");
                 return false;
                 } */
                else
                {
                    return true;
                }
            }

            function save_copydiagram()
            {

                var copydiagramdatestart = document.getElementById("txt_copydiagramdatestart").value;
                var copydiagramdateend = document.getElementById("txt_copydiagramdateend").value;
                var employeename1 = document.getElementById("txt_copydiagramemployeename1").value;
                var employeename2 = document.getElementById("txt_copydiagramemployeename2").value;
                var thainame = document.getElementById("txt_copydiagramthainame").value;
                var jobstart = document.getElementById("txt_copydiagramjobstart").value;
                var cluster = document.getElementById("txt_copydiagramcluster").value;
                var jobend = document.getElementById("txt_copydiagramjobend").value;
                var dateinput = document.getElementById("txt_copydiagramdateinput").value;
                var datepresent = document.getElementById("txt_copydiagramdatepresent").value;
                
              
                 
                
                var datevlin = "";
                var datevlout = "";
                var dealerin = "";
                var datereturn = "";
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
                
                
               
                if (checknull_copydiagram()) {
                    if (chk_copydiagrammonday.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
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
                                JOBNO: document.getElementById("txt_copydiagramjobnomonday").value,
                                DATEINPUT: dateinput,
                                DATEPRESENT: datepresent,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn

                            },
                            success: function (rs) {
                                alert(rs);
                                window.location.reload();
                            }
                        });
                    }
                    if (chk_copydiagramtuesday.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
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
                                JOBNO: document.getElementById("txt_copydiagramjobnotuesday").value,
                                DATEINPUT: dateinput,
                                DATEPRESENT: datepresent,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn

                            },
                            success: function () {

                                window.location.reload();
                            }
                        });
                    }
                    if (chk_copydiagramwednesday.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
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
                                JOBNO: document.getElementById("txt_copydiagramjobnowednesday").value,
                                DATEINPUT: dateinput,
                                DATEPRESENT: datepresent,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn

                            },
                            success: function () {

                                window.location.reload();
                            }
                        });
                    }
                    if (chk_copydiagramthursday.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
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
                                JOBNO: document.getElementById("txt_copydiagramjobnothursday").value,
                                DATEINPUT: dateinput,
                                DATEPRESENT: datepresent,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn

                            },
                            success: function () {

                                window.location.reload();
                            }
                        });
                    }
                    if (chk_copydiagramfriday.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
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
                                JOBNO: document.getElementById("txt_copydiagramjobnofriday").value,
                                DATEINPUT: dateinput,
                                DATEPRESENT: datepresent,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn

                            },
                            success: function () {

                                window.location.reload();
                            }
                        });
                    }
                    if (chk_copydiagramsaturday.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
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
                                JOBNO: document.getElementById("txt_copydiagramjobnosaturday").value,
                                DATEINPUT: dateinput,
                                DATEPRESENT: datepresent,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn

                            },
                            success: function () {

                                window.location.reload();
                            }
                        });
                    }
                    if (chk_copydiagramsunday.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
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
                                JOBNO: document.getElementById("txt_copydiagramjobnosunday").value,
                                DATEINPUT: dateinput,
                                DATEPRESENT: datepresent,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn

                            },
                            success: function () {

                                window.location.reload();
                            }
                        });
                    }
                }
            }
            function save_copyjob() {
                var startdatejobcopy = document.getElementById("txt_startdatejobcopy").value;

                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "create_jobno", companycode: '<?= $_GET['companycode'] ?>', jobdate: startdatejobcopy
                    },
                    success: function (rs) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copyjobvehicletransportplan", JOBNO: rs.replace(/^\s*|\s*$/g, ''), ROWSAMOUNT: document.getElementById("txt_rowsamount").value
                            },
                            success: function () {

                                window.location.reload();
                            }
                        });
                    }

                });
            }
            function select_copyjob(jobstrat, jobend, startdate) {
                document.getElementById("title_copyjob").innerHTML = '<b>Copy Job เส้นทาง : ' + jobstrat + '-' + jobend + '</b>';
                document.getElementById("txt_startdatejobcopy").value = startdate;
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

            function show_timepresent(data)
            {
                if (chk_copydiagramdatevlin.checked == true) {
                    var rs = (parseInt(data.substr(11, 2)) - 1) + data.substr(13, 5);
                    document.getElementById("txt_copydiagramdatepresent").value = rs;
                } else
                {
                    if (document.getElementById("txt_copydiagramjobstart").value == "GW")
                    {
                        var rs = parseInt(data.substring(0, 2)) - 1;
                        rs = rs + data.substring(2, 5);
                        document.getElementById("txt_copydiagramdatepresent").value = rs;
                    } else if (document.getElementById("txt_copydiagramjobstart").value == "BP")
                    {
                        var rs = parseInt(data.substring(0, 2)) - 1;
                        rs = rs + data.substring(2, 5);
                        document.getElementById("txt_copydiagramdatepresent").value = rs;
                    } else if (document.getElementById("txt_copydiagramjobstart").value == "SR")
                    {

                        var rs = parseInt(data.substring(0, 2)) - 1;
                        rs = rs + data.substring(2, 5);
                        document.getElementById("txt_copydiagramdatepresent").value = rs;
                    } else
                    {
                        var rs = parseInt(data.substring(0, 2)) - document.getElementById("txt_beforpersentoth").value;
                        rs = rs + data.substring(2, 5);
                        document.getElementById("txt_copydiagramdatepresent").value = rs;
                    }
                }
            }
        </script>

    </body>


</html>
<?php
sqlsrv_close($conn);
?>
