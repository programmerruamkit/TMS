<!DOCTYPE html>
<?php
session_start();
ini_set('max_execution_time', 300);
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

// $sql_seSystime = "{call megGetdate_v2(?)}";
// $params_seSystime = array(
//   array('select_getdate', SQLSRV_PARAM_IN)
// );
// $query_seSystime = sqlsrv_query($conn, $sql_seSystime, $params_seSystime);
// $result_seSystime = sqlsrv_fetch_array($query_seSystime, SQLSRV_FETCH_ASSOC);

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

// echo $result_sePlan1['VEHICLETRANSPORTPLANID'];
// $sql_seConfrimskbs = "SELECT CONFRIMSKBID FROM CONFRIMSKB WHERE VEHICLETRANSPORTPLANID = '" . $_GET['vehicletransportplanid'] . "'";
// $params_seConfrimskbs = array();
// $query_seConfrimskbs = sqlsrv_query($conn, $sql_seConfrimskbs, $params_seConfrimskbs);
// $result_seConfrimskbs = sqlsrv_fetch_array($query_seConfrimskbs, SQLSRV_FETCH_ASSOC);

$condition1 = " AND (a.USERNAME ='" . $_SESSION["USERNAME"] . "' AND a.PASSWORD = '" . $_SESSION["PASSWORD"] . "') AND a.ACTIVESTATUS = 1";
$sql_seLogin = "{call megRoleaccount_v2(?,?)}";
$params_seLogin = array(
  array('select_roleaccount', SQLSRV_PARAM_IN),
  array($condition1, SQLSRV_PARAM_IN)
);
$query_seLogin = sqlsrv_query($conn, $sql_seLogin, $params_seLogin);
$result_seLogin = sqlsrv_fetch_array($query_seLogin, SQLSRV_FETCH_ASSOC);
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
  <!-- <link href="../dist/css/select2.min.css" rel="stylesheet"> -->
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
  .swal2-popup {
      font-size: 16px !important;
      padding: 17px;
      border: 1px solid #F0E1A1;
      display: block;
      margin: 22px;
      text-align: center;
      color: #61534e;
  }



  </style>
</head>
<body >

  <div id="wrapper">
    <input class="form-control" style="display: none"  id="txt_updatezoneskb" name="txt_updatezoneskb" maxlength="300" value="" >
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
  
    <!-- Modal เลือกประเภทงานที่จะแก้ไข -->
    <div class="modal fade" id="modal_copydiagramupdrccjobtype" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
      <div class="modal-dialog" role="document" style="width: 30%">
        <div class="modal-content">
          <div class="modal-header">
            <div class="row">
              <div class="col-lg-5">
                <h5 class="modal-title" id="title_copydiagram"><b>Select Jobtype</b></h5>
              </div>

            </div>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-12">
                <label>เลือกประเภทงาน :</label>
                <select class="form-control"  id="cb_copydiagramjobtype" name="cb_copydiagramjobtype" style="">
                  <option value="SH">SH</option>
                  <option value="NM">Nomal</option>
                  <!-- <option value="SHN">SH(N)</option> -->
                </select>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
            <button type="button" class="btn btn-primary" onclick="select_copydiagramjobend()">ตกลง</button>
          </div>
        </div>
      </div>
    </div>
  <!-- ///////////////////////////////////////////////////////////////////////////////////////////////// -->
  <!-- Modal  แก้ไขประเภทงาน NM -->
    <div class="modal fade" id="modal_copydiagramupdrccnm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-modal-parent="#modal_copydiagramupdrccjobtype">
      <div class="modal-dialog" role="document" style="width: 80%">
        <div class="modal-content">
          <div class="modal-header">
            <div class="row">
              <div class="col-lg-5">
                <h5 class="modal-title" id="title_copydiagram"><b>Update Diagram(RCC,RATC)</b></h5>
              </div>

            </div>
          </div>
          <div class="modal-body">
            <div class="well">
              <div class="modal-header">
                <label>แก้ไขการวิ่งงาน ประเภทงาน (Nomal)</label>
              </div>
              <div class="modal-body" >
                    <div class="row">
                      <div class="col-lg-3">
                        <label>พนักงาน (1) :</label>
                        <input type="text" onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'EMPLOYEENAME1', this.value)" class="form-control" name="txt_copydiagramemployeenameupdnm1" id="txt_copydiagramemployeenameupdnm1"  value="<?= $result_sePlan1['EMPLOYEENAME1'] ?>">
                      </div>
                      <div class="col-lg-3">
                        <label>พนักงาน (2) :</label>
                        <input type="text" onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'EMPLOYEENAME2', this.value)"  class="form-control" name="txt_copydiagramemployeenameupdnm2" id="txt_copydiagramemployeenameupdnm2" value="<?= $result_sePlan1['EMPLOYEENAME2'] ?>">
                      </div>
                      <div class="col-lg-3">
                        <label>ผู้ควบคุม :</label>
                        <input type="text" onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'EMPLOYEENAMECONTROL', this.value)"  class="form-control" name="txt_copydiagramemployeenameupdnm_controller" id="txt_copydiagramemployeenameupdnm_controller" value="<?= $result_sePlan1['EMPLOYEENAMECONTROL'] ?>">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-3">
                        <label>ชื่อรถ :</label>
                        <input type="text"  class="form-control"  id="txt_copydiagramthainameupdnm" name="txt_copydiagramthainameupdnm" value="<?= $result_sePlan1['THAINAME'] ?>">
                      </div>
                      <div class="col-lg-3">
                          <label style="font-size: 16px;">ต้นทาง:</label>&nbsp;&nbsp;<font style="color: red;font-size: 16px;"><b>*</b></font>
                          <div class="dropdown bootstrap-select show-tick form-control" onchange="select_clusternm('nm')">
                              <select   multiple="" id="txt_jobstart_rccratcnm" name="txt_jobstart_rccratcnm" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก ต้นทาง..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                  <?php
                                  // $condiLocation1 = " AND COMPANYCODE = 'RKR' AND CUSTOMERCODE = 'TTASTSTC'";
                                  $sql_seJobstartRound4 = "{call megJobstartrccratc_v2(?,?)}";
                                  $params_seJobstartRound4 = array(
                                      array('select_jobstart', SQLSRV_PARAM_IN),
                                      array('', SQLSRV_PARAM_IN)
                                  );
                                  $query_seJobstartRound4 = sqlsrv_query($conn, $sql_seJobstartRound4, $params_seJobstartRound4);
                                  while ($result_seJobstartRound4 = sqlsrv_fetch_array($query_seJobstartRound4, SQLSRV_FETCH_ASSOC)) {
                                      ?>
                                      <option value="<?= $result_seJobstartRound4['JOBSTART'] ?>"><?= $result_seJobstartRound4['JOBSTART'] ?></option>
                                      <?php
                                  }
                                  ?>
                              </select>
                              <input class="form-control" style="display:none"   id="txt_jobstart_nm_check" name="txt_jobstart_nm_check" maxlength="500" value="" >
                          </div>
                      </div>
                      <div class="col-lg-3">
                          <label style="font-size: 16px;">คลัสเตอร์ :</label>
                          <div id="data_copydiagramclusterdefnm">
                              <div class="dropdown bootstrap-select show-tick form-control">
                                  <select  data-size="5" multiple="" id="cb_copydiagramcluster_rccratcnm" name="cb_copydiagramcluster_rccratcnm" class="selectpicker_rccratcnm form-control"  data-container="body" data-live-search="true" title="เลือก คลัสเตอร์..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                  </select>
                                  <input class="form-control" style=""   id="txt_cluster_rccratcnm" name="txt_cluster_rccratcnm" maxlength="200" value="" >
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
                          <div id="data_copydiagramclustersrnm"></div>
                      </div>
                    </div>
                    <div class="row">&nbsp;</div>
                    <div class="row">
                      <div class="col-lg-2">
                        <label>เวลาเริ่มงาน  </label>
                        <input type="text" value="<?= $result_sePlan1['TIMERK'] ?>" readonly="" class="form-control datetimeen" id="txt_copydiagramdaterkupdnm" name="txt_copydiagramdaterkupdnm"  >

                      </div>
                      <div class="col-lg-2">
                        <label>เวลาเข้าวีแอล</label>
                        <input type="text" value="<?= $result_sePlan1['TIMEVLIN'] ?>" readonly="" class="form-control datetimeen" id="txt_copydiagramdatevlinupdnm" name="txt_copydiagramdatevlinupdnm"  >

                      </div>
                      <div class="col-lg-2">
                        <label>เวลาออกวีแอล </label>
                        <input type="text" value="<?= $result_sePlan1['TIMEVLOUT'] ?>" readonly="" class="form-control datetimeen" id="txt_copydiagramdatevloutupdnm" name="txt_copydiagramdatevloutupdnm" >

                      </div>
                      <div class="col-lg-2">
                        <label>เวลาเข้าดีลเลอร์ </label>
                        <input type="text" value="<?= $result_sePlan1['TIMEDEALERIN'] ?>" readonly="" class="form-control datetimeen" id="txt_copydiagramdatedealerinupdnm" name="txt_copydiagramdatedealerinupdnm" >

                      </div>
                      <div class="col-lg-2">
                        <label>เวลากลับบริษัท </label>
                        <input type="text" value="<?= $result_sePlan1['TIMERETURN'] ?>" readonly="" class="form-control datetimeen" id="txt_copydiagramdatereturnupdnm" name="txt_copydiagramdatereturnupdnm" >

                      </div>
                    </div>
                  </div>
                </div>


              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" onclick="save_copydiagram()">บันทึก</button>
              </div>
          </div>
      </div>
    </div>
    <!-- //////////////////////////////////////////////////////////////////////////////////////// -->
    <!-- Modal  แก้ไขประเภทงาน SH -->
    <div class="modal fade" id="modal_copydiagramupdrccsh" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-modal-parent="#modal_copydiagramupdrccjobtype">
      <div class="modal-dialog" role="document" style="width: 80%">
        <div class="modal-content">
          <div class="modal-header">
            <div class="row">
              <div class="col-lg-5">
                <h5 class="modal-title" id="title_copydiagram"><b>Update Diagram(RCC,RATC)</b></h5>
              </div>

            </div>
          </div>
          <div class="modal-body">
            <div class="well">
              <div class="modal-header">
                <label>แก้ไขการวิ่งงาน ประเภทงาน (SH)</label>
              </div>
              <div class="modal-body" >
                    <div class="row">
                      <div class="col-lg-3">
                        <label>พนักงาน (1) :</label>
                        <input type="text" onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'EMPLOYEENAME1', this.value)" class="form-control" name="txt_copydiagramemployeenameupdsh1" id="txt_copydiagramemployeenameupdsh1"  value="<?= $result_sePlan1['EMPLOYEENAME1'] ?>">
                      </div>
                      <div class="col-lg-3">
                        <label>พนักงาน (2) :</label>
                        <input type="text" onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'EMPLOYEENAME2', this.value)"  class="form-control" name="txt_copydiagramemployeenameupdsh2" id="txt_copydiagramemployeenameupdsh2" value="<?= $result_sePlan1['EMPLOYEENAME2'] ?>">
                      </div>
                      <div class="col-lg-3">
                        <label>ผู้ควบคุม :</label>
                        <input type="text" onchange="update_copydiagram('<?= $result_sePlan1['VEHICLETRANSPORTPLANID'] ?>', 'EMPLOYEENAMECONTROL', this.value)"  class="form-control" name="txt_copydiagramemployeenameupdsh_controller" id="txt_copydiagramemployeenameupdsh_controller" value="<?= $result_sePlan1['EMPLOYEENAMECONTROL'] ?>">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-3">
                        <label>ชื่อรถ :</label>
                        <input type="text"  class="form-control"  id="txt_copydiagramthainameupdsh" name="txt_copydiagramthainameupdsh" value="<?= $result_sePlan1['THAINAME'] ?>">
                      </div>
                      <div class="col-lg-3">
                          <label style="font-size: 16px;">ต้นทาง (SH):</label>&nbsp;&nbsp;<font style="color: red;font-size: 16px;"><b>*</b></font>
                          <div class="dropdown bootstrap-select show-tick form-control" onchange="select_clustersh('sh')" >
                              <select   multiple="" id="txt_jobstart_rccratcsh" name="txt_jobstart_rccratcsh" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก ต้นทาง..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                  <?php
                                  // $condiLocation1 = " AND COMPANYCODE = 'RKR' AND CUSTOMERCODE = 'TTASTSTC'";
                                  $sql_seJobstartRound4 = "{call megJobstartrccratc_v2(?,?)}";
                                  $params_seJobstartRound4 = array(
                                      array('select_jobstart', SQLSRV_PARAM_IN),
                                      array('', SQLSRV_PARAM_IN)
                                  );
                                  $query_seJobstartRound4 = sqlsrv_query($conn, $sql_seJobstartRound4, $params_seJobstartRound4);
                                  while ($result_seJobstartRound4 = sqlsrv_fetch_array($query_seJobstartRound4, SQLSRV_FETCH_ASSOC)) {
                                      ?>
                                      <option value="<?= $result_seJobstartRound4['JOBSTART'] ?>"><?= $result_seJobstartRound4['JOBSTART'] ?></option>
                                      <?php
                                  }
                                  ?>
                              </select>
                              <input class="form-control" style="display:none"   id="txt_jobstart_sh_check" name="txt_jobstart_sh_check" maxlength="500" value="" >
                          </div>
                      </div>
                      <div class="col-lg-3">
                          <label style="font-size: 16px;">คลัสเตอร์ (SH):</label>
                          <div id="data_copydiagramclusterdefsh">
                              <div class="dropdown bootstrap-select show-tick form-control">
                                  <select  data-size="5" multiple="" id="cb_copydiagramcluster_rccratcsh" name="cb_copydiagramcluster_rccratcsh" class="selectpicker_rccratcsh form-control"  data-container="body" data-live-search="true" title="เลือก คลัสเตอร์..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                  </select>
                                  <input class="form-control" style=""   id="txt_cluster_rccratcsh" name="txt_cluster_rccratcsh" maxlength="200" value="" >
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
                          <div id="data_copydiagramclustersrsh"></div>
                      </div>
                    </div>
                    <div class="row">&nbsp;</div>
                    <div class="row">
                      <div class="col-lg-2">
                        <label>เวลาเริ่มงาน  </label>
                        <input type="text" value="<?= $result_sePlan1['TIMERK'] ?>" readonly="" class="form-control datetimeen" id="txt_copydiagramdaterkupdsh" name="txt_copydiagramdaterkupdsh"  >

                      </div>
                      <div class="col-lg-2">
                        <label>เวลาเข้าวีแอล  </label>
                        <input type="text" value="<?= $result_sePlan1['TIMEVLIN'] ?>" readonly="" class="form-control datetimeen" id="txt_copydiagramdatevlinupdsh" name="txt_copydiagramdatevlinupdsh"  >

                      </div>
                      <div class="col-lg-2">
                        <label>เวลาออกวีแอล </label>
                        <input type="text" value="<?= $result_sePlan1['TIMEVLOUT'] ?>" readonly="" class="form-control datetimeen" id="txt_copydiagramdatevloutupdsh" name="txt_copydiagramdatevloutupdsh" >

                      </div>
                      <div class="col-lg-2">
                        <label>เวลาเข้าดีลเลอร์ </label>
                        <input type="text" value="<?= $result_sePlan1['TIMEDEALERIN'] ?>" readonly="" class="form-control datetimeen" id="txt_copydiagramdatedealerinupdsh" name="txt_copydiagramdatedealerinupdsh" >

                      </div>
                      <div class="col-lg-2">
                        <label>เวลากลับบริษัท </label>
                        <input type="text" value="<?= $result_sePlan1['TIMERETURN'] ?>" readonly="" class="form-control datetimeen" id="txt_copydiagramdatereturnupdsh" name="txt_copydiagramdatereturnupdsh" >

                      </div>
                    </div>
                  </div>
                </div>


              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" onclick="save_copydiagram()">บันทึก</button>
              </div>
          </div>
      </div>
    </div>
    <!-- //////////////////////////////////////////////////////////////////////////////////////// -->

        
              <div class="row" >
                <div class="col-lg-12" style="text-align: right">
                        <input class="btn btn-default" type="button" style="background-color: red;border:solid 2px white" id="btn_srquotation" name="btn_srquotation" value=""> * แจ้งเตือนข้อมูล ไม่พบไอดีราคาขนส่ง (PriceId)
                        <input class="btn btn-default" type="button" style="background-color: orange;border:solid 2px white" id="btn_srquotation" name="btn_srquotation" value=""> * แจ้งเตือนข้อมูล ไม่พบราคาขนส่ง (Price)
                </div>
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
                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                  <table  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example1" style="width: 100%;">
                                    <thead>
                                      <tr>
                                        <th style="text-align: left;width:5%">แก้ไขงาน 1</th>
                                        <th style="text-align: left;width:10%">พนักงาน(1)</th>
                                        <th style="text-align: left;width:10%">พนักงาน(2)</th>
                                        <th style="text-align: left;width:10%">รอบวิ่ง</th>
                                        <th style="text-align: left;width:10%">ชื่อรถ</th>
                                        <th style="text-align: left;width:10%">ต้นทาง</th>
                                        <th style="text-align: left;width:10%">CLUSTER</th>
                                        <th style="text-align: left;width:10%">ปลายทาง</th>
                                        <th style="text-align: left;width:22%">JOB NO</th>
                                        <th style="text-align: left;width:15%">วันที่ทำแผน</th>
                                        <th style="text-align: left;width:15%">วันที่ทำงาน</th>
                                        <th style="text-align: left;width:10%">รายงานตัว</th>
                                        <th style="text-align: left;width:10%">เข้าวีแอล</th>
                                        <th style="text-align: left;width:10%">ออกวีแอล</th>
                                        <th style="text-align: left;width:10%">เข้าดีลเลอร์</th>
                                        <th style="text-align: left;width:10%">กลับบริษัท</th>
                                        <th style="text-align: left;width:10%">สถานะ</th>
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

                                            ?>
                                            <tr
                                            <?php
                                            // VEHICLETRANSPORTPRICEID ไม่เจอ 
                                            if ($result_sePlanmonday['VEHICLETRANSPORTPRICEID'] == NULL || $result_sePlanmonday['VEHICLETRANSPORTPRICEID'] == '') {
                                                ?>
                                                    style="color: red" 
                                                    
                                                <?php
                                                // ACTUALPRICE ไม่เจอ
                                              } else if ($result_sePlanmonday['ACTUALPRICE'] == NULL || $result_sePlanmonday['ACTUALPRICE'] == '' || $result_sePlanmonday['ACTUALPRICE'] == '0.00') {
                                                ?>
                                                style="color: orange"
                                                <?php
                                              } else {
                                                ?>

                                                <?php
                                              }
                                            ?>
                                            >
                                            
                                            <!-- จัดการ -->
                                            <?php
                                            if ($result_sePlanmonday['VEHICLETRANSPORTPRICEID'] == '' && ($result_sePlanmonday['COMPANYCODE'] == 'RCC' || $result_sePlanmonday['COMPANYCODE'] == 'RATC')) {
                                              ?>
                                              <td style="text-align: center;">
                                                <button  data-toggle="modal"  data-target="#modal_copydiagramupdrccjobtype"  title="แก้ไขแผนการขนส่ง RCC&RATC" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-wrench"></span></button>
                                              </td>
                                              <?php
                                            } else {
                                              if ($result_sePlanmonday['COMPANYCODE'] == 'RCC' || $result_sePlanmonday['COMPANYCODE'] == 'RATC') {
                                                ?>
                                                <td style="text-align: center;">
                                                  <button onclick="update_copydiagramrcc('<?= $result_sePlanmonday['EMPLOYEENAME1'] ?>', '<?= $result_sePlanmonday['EMPLOYEENAME2'] ?>', '<?= $result_sePlanmonday['THAINAME'] ?>', '<?= $result_sePlanmonday['JOBSTART'] ?>', '<?= $result_sePlanmonday['TIMEINPUT'] ?>', '<?= $result_sePlanmonday['TIMEPRESENT'] ?>', '<?= $result_sePlanmonday['TIMEVLIN'] ?>', '<?= $result_sePlanmonday['TIMEVLOUT'] ?>', '<?= $result_sePlanmonday['TIMEDEALERIN'] ?>', '<?= $result_sePlanmonday['TIMERETURN'] ?>')"  data-toggle="modal"  data-target="#modal_copydiagramupdrccjobtype"  title="แก้ไขแผนการขนส่ง RCC&RATC" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-wrench"></span></button>
                                                </td>
                                                <?php
                                              } 
                                            }

                                            // $result_sePlanmonday['DATEWORKSUS'] วันที่ทำงานเสร็จ
                                            ?>
                                            
                                             


                                            <td><?= $result_sePlanmonday['EMPLOYEENAME1'] ?></td>
                                            <td><?= $result_sePlanmonday['EMPLOYEENAME2'] ?></td>
                                            <td><?= $result_sePlan1['ROUNDAMOUNT'] ?></td>
                                            <td><?= $result_sePlanmonday['THAINAME'] ?></td>
                                            <td><?= $result_sePlanmonday['JOBSTART'] ?></td>
                                            <td><?= $result_sePlanmonday['CLUSTER'] ?></td>
                                            <td><?= $result_sePlanmonday['JOBEND  '] ?></td>
                                            <td><?= $result_sePlanmonday['JOBNO'] ?></td>
                                            <td><?= $result_sePlanmonday['DATEINPUT'] ?></td>
                                            <td><?= $result_sePlanmonday['DATERK'] ?></td>
                                            <td><?= $result_sePlanmonday['DATEPRESENT'] ?></td>
                                            <td><?= $result_sePlanmonday['DATEVLIN'] ?></td>
                                            <td><?= $result_sePlanmonday['DATEVLOUT'] ?></td>
                                            <td><?= $result_sePlanmonday['DATEDEALERIN'] ?></td>
                                            <td><?= $result_sePlanmonday['DATERETURN'] ?></td>
                                            <!-- <td>1</td> -->
                                            <td> <?php
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
              <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
              <!-- <script src="../dist/js/select2.js"></script> -->


              <?php
              if ($_GET['companycode'] == 'RCC' || $_GET['companycode'] == 'RATC') {
                $thainame = select_carautocomplate('megVehicleinfo_v2', 'selectcond_vehicleinfo', " AND a.THAINAME != '-' AND (a.ENGNAME  LIKE 'R-%' OR a.ENGNAME  LIKE 'RA-%') ORDER BY a.ENGNAME ASC","", "", "");
              } else {
                $thainame = select_vehiclenumberautocomplate('megVehicleinfo_v2', 'select_vehicleinfo', '');
              }
              $emp = select_empautocomplate('megEmployeeEHR_v2', 'select_employeeehr2', "");
              ?>


              <script>

              

              function save_logprocess(category, process, employeecode)
              {
                $.ajax({
                  url: 'meg_data.php',
                  type: 'POST',
                  data: {
                    txt_flg: "save_logprocess", category: category, process: process, employeecode: employeecode
                  },
                  success: function () {


                  }
                });
              }

              

              

              function select_copydiagramjobend() {

                jobtype = document.getElementById('cb_copydiagramjobtype').value;

                if (jobtype == 'SH'){
                  $("#modal_copydiagramupdrccsh").modal();
                } else if (jobtype == 'NM'){
                  $("#modal_copydiagramupdrccnm").modal();
                } else{
                  
                }

              }

              

              // autocomplete สำหรับเลือกชื่อพนักงาน แผนงาน SH
              var txt_copydiagramemployeenameupdsh1 = [<?= $emp ?>];
              $("#txt_copydiagramemployeenameupdsh1").autocomplete({
                source: [txt_copydiagramemployeenameupdsh1]
              });

              var txt_copydiagramemployeenameupdsh2 = [<?= $emp ?>];
              $("#txt_copydiagramemployeenameupdsh2").autocomplete({
                source: [txt_copydiagramemployeenameupdsh2]
              });

              var txt_copydiagramemployeenameupdsh_controller = [<?= $emp ?>];
              $("#txt_copydiagramemployeenameupdsh_controller").autocomplete({
                source: [txt_copydiagramemployeenameupdsh_controller]
              });
              /////////////////////////////////////////////////////////////

              // autocomplete สำหรับเลือกชื่อพนักงาน แผนงาน NM
              var txt_copydiagramemployeenameupdnm1 = [<?= $emp ?>];
              $("#txt_copydiagramemployeenameupdnm1").autocomplete({
                source: [txt_copydiagramemployeenameupdnm1]
              });

              var txt_copydiagramemployeenameupdnm2 = [<?= $emp ?>];
              $("#txt_copydiagramemployeenameupdnm2").autocomplete({
                source: [txt_copydiagramemployeenameupdnm2]
              });
              
              var txt_copydiagramemployeenameupdnm_controller = [<?= $emp ?>];
              $("#txt_copydiagramemployeenameupdnm_controller").autocomplete({
                source: [txt_copydiagramemployeenameupdnm_controller]
              });
              ////////////////////////////////////////////////////////////

              // autocomplete สำหรับเลือกชื่อรถ 
              var txt_copydiagramthainameupdsh = [<?= $thainame ?>];
              $("#txt_copydiagramthainameupdsh").autocomplete({
                source: [txt_copydiagramthainameupdsh]
              });

              var txt_copydiagramthainameupdnm = [<?= $thainame ?>];
              $("#txt_copydiagramthainameupdnm").autocomplete({
                source: [txt_copydiagramthainameupdnm]
              });
              /////////////////////////////////////////////////////

             

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
                scrollY: '300px',
              });
            });


            
            function save_copydiagram()
            {

              // alert(document.getElementById('txt_jobstart_rccratcnm').value);

              if (document.getElementById('cb_copydiagramjobtype').value == "SH") {

                $.ajax({
                  type: 'post',
                  url: 'meg_data_transportplan_newrccratc.php',
                  data: {
                    txt_flg: "edit_vehicletransportplanmix_update",
                    VEHICLETRANSPORTPLANID: '<?= $_GET['vehicletransportplanid'] ?>',
                    EMPLOYEENAME1: document.getElementById('txt_copydiagramemployeenameupdsh1').value,
                    EMPLOYEENAME2: document.getElementById('txt_copydiagramemployeenameupdsh2').value,
                    VEHICLEINFO: document.getElementById('txt_copydiagramthainameupdsh').value,
                    CLUSTER: document.getElementById('txt_cluster_rccratcsh').value, //@FIELDNAME
                    JOBEND: document.getElementById('txt_cluster_rccratcsh').value,
                    LOAD: '',
                    copydiagramdaterkupd: document.getElementById('txt_copydiagramdaterkupdsh').value,
                    copydiagramdatevlinupd: document.getElementById('txt_copydiagramdatevlinupdsh').value,
                    copydiagramdatevloutupd: document.getElementById('txt_copydiagramdatevloutupdsh').value,
                    copydiagramdatedealerinupd: document.getElementById('txt_copydiagramdatedealerinupdsh').value,
                    copydiagramdatereturnupd: document.getElementById('txt_copydiagramdatereturnupdsh').value,
                    JOBSTART: document.getElementById('txt_jobstart_sh_check').value,
                    WORKTYPE: 'sh'
                    // JOBSTART: document.getElementById('txt_copydiagramjobstartupd').value

                  },
                  success: function (rs) {
                    // alert(rs);
                    // alert('บันทึกข้อมูลเรียบร้อย...');
                    // window.location.reload();
                    swal.fire({
                        title: "Good Job!",
                        text: "ยืนยันและบันทึกข้อมูลทั้งหมดเรียบร้อย",
                        showConfirmButton: false,
                        icon: "success"
                    });
                    // delay reload current page   
                    setTimeout(() => {
                        document.location.reload();
                    }, 1200);
                  }
                });
              } else if (document.getElementById('cb_copydiagramjobtype').value == "NM") {

                // alert('eeee');
                // alert(document.getElementById('txt_copydiagramdaterkupdnm').value);

                $.ajax({
                  type: 'post',
                  url: 'meg_data_transportplan_newrccratc.php',
                  data: {
                    txt_flg: "edit_vehicletransportplanmix_update",
                    VEHICLETRANSPORTPLANID: '<?= $_GET['vehicletransportplanid'] ?>',
                    EMPLOYEENAME1: document.getElementById('txt_copydiagramemployeenameupdnm1').value,
                    EMPLOYEENAME2: document.getElementById('txt_copydiagramemployeenameupdnm2').value,
                    VEHICLEINFO: document.getElementById('txt_copydiagramthainameupdnm').value,
                    CLUSTER: document.getElementById('txt_cluster_rccratcnm').value,
                    JOBEND: document.getElementById('txt_cluster_rccratcnm').value,
                    LOAD: '',
                    copydiagramdaterkupd: document.getElementById('txt_copydiagramdaterkupdnm').value,
                    copydiagramdatevlinupd: document.getElementById('txt_copydiagramdatevlinupdnm').value,
                    copydiagramdatevloutupd: document.getElementById('txt_copydiagramdatevloutupdnm').value,
                    copydiagramdatedealerinupd: document.getElementById('txt_copydiagramdatedealerinupdnm').value,
                    copydiagramdatereturnupd: document.getElementById('txt_copydiagramdatereturnupdnm').value,
                    JOBSTART: document.getElementById('txt_jobstart_nm_check').value,
                    WORKTYPE: 'nm'


                  },
                  success: function (rs) {
                    // alert(rs);
                    // alert('บันทึกข้อมูลเรียบร้อย...');
                    // window.location.reload();
                    swal.fire({
                        title: "Good Job!",
                        text: "ยืนยันและบันทึกข้อมูลทั้งหมดเรียบร้อย",
                        showConfirmButton: false,
                        icon: "success"
                    });
                    // delay reload current page   
                    setTimeout(() => {
                        document.location.reload();
                    }, 1200);
                  }
                });


              } else {
                

              }


              save_logprocess('Driver Management', 'Update Job', '<?= $result_seLogin['PersonCode'] ?>');

            }

            // function reload()
            // {
            //   alert('แก้ไขข้อมูลเรียบร้อย...');
            //   window.location.reload();
            // }

            // function แสดง cluster ประเภทงาน nm
            function select_clusternm(checkround)
            {
              
                // alert(checkround);
                // var copydiagramthainame = document.getElementById("txt_copydiagramthainame").value;
                //var copydiagramjobstart = document.getElementById("txt_copydiagramjobstart").value;
                // var companycode = document.getElementById("txt_copydiagramcompany").value;
                // var customercode = document.getElementById("txt_copydiagramcustomer").value;
                check_jobstart(checkround);
                var worktype      = checkround;
                var companycode   = 'RCC_RATC';
                var customercode  = 'TTT';
                // alert(worktype);
                // alert(companycode);
                // alert(customercode);

                $.ajax({
                    type: 'post',
                    url: 'meg_data_transportplan_newrccratc.php',
                    data: {
                        txt_flg: "show_copydiagramcluster_compennm", worktype: worktype, companycode: companycode, customercode: customercode
                                // txt_flg: "show_copydiagramjobend", cluster: document.getElementById('txt_copydiagramcluster').value, copydiagramthainame: copydiagramthainame
                    },
                    success: function (rs) {

                        document.getElementById("data_copydiagramclustersrnm").innerHTML = rs;
                        document.getElementById("data_copydiagramclusterdefnm").innerHTML = "";

                        $("#cb_copydiagramcluster_rccratcnm").html(rs).selectpicker('refresh');
                        $('.selectpicker_rccratcnm').on('changed.bs.select', function () {
                            document.getElementById('txt_cluster_rccratcnm').value = $(this).val();

                        });


                    }
                });
                
            }
            // function แสดง cluster ประเภทงาน sh
            function select_clustersh(checkround)
            {
                // alert(checkround);
                // var copydiagramthainame = document.getElementById("txt_copydiagramthainame").value;
                //var copydiagramjobstart = document.getElementById("txt_copydiagramjobstart").value;
                // var companycode = document.getElementById("txt_copydiagramcompany").value;
                // var customercode = document.getElementById("txt_copydiagramcustomer").value;
                check_jobstart(checkround);
                var worktype      = checkround;
                var companycode   = 'RCC_RATC';
                var customercode  = 'TTT';
                // alert(worktype);
                // alert(companycode);
                // alert(customercode);

                $.ajax({
                    type: 'post',
                    url: 'meg_data_transportplan_newrccratc.php',
                    data: {
                        txt_flg: "show_copydiagramcluster_compensh", worktype: worktype, companycode: companycode, customercode: customercode
                                // txt_flg: "show_copydiagramjobend", cluster: document.getElementById('txt_copydiagramcluster').value, copydiagramthainame: copydiagramthainame
                    },
                    success: function (rs) {

                        document.getElementById("data_copydiagramclustersrsh").innerHTML = rs;
                        document.getElementById("data_copydiagramclusterdefsh").innerHTML = "";

                        $("#cb_copydiagramcluster_rccratcsh").html(rs).selectpicker('refresh');
                        $('.selectpicker_rccratcsh').on('changed.bs.select', function () {
                            document.getElementById('txt_cluster_rccratcsh').value = $(this).val();

                        });


                    }
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

                  // document.getElementById("data_copydiagramjobendsr").innerHTML = rs;
                  // document.getElementById("data_copydiagramjobenddef").innerHTML = "";
                  // $("#cb_copydiagramjobend").html(rs).selectpicker('refresh');
                  // $('.selectpicker').on('changed.bs.select', function () {
                  //   document.getElementById('txt_copydiagramjobend').value = $(this).val();
                  // });
                }
              });
            }
            function check_jobstart(checkround) {
                
                // alert(checkround);
                if (checkround == 'nm') {
                  var options = document.getElementById('txt_jobstart_rccratcnm').selectedOptions;
                  var values = Array.from(options).map(({ value }) => value);
                  
                  document.getElementById('txt_jobstart_nm_check').value = values;
                }else{
                  var options = document.getElementById('txt_jobstart_rccratcsh').selectedOptions;
                  var values = Array.from(options).map(({ value }) => value);
                  
                  document.getElementById('txt_jobstart_sh_check').value = values;
                }
                
                // alert(values);
            }
            function update_copydiagram(ID, fieldname, editableObj)
            {
              // alert(fieldname);
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
              save_logprocess('Driver Management', 'Update Job', '<?= $result_seLogin['PersonCode'] ?>');
            }
         
      


function update_copydiagramrcc(txtcopydiagramemployeenameupd1, txtcopydiagramemployeenameupd2, txtcopydiagramthainameupd, txtcopydiagramjobstartupd,
  txtcopydiagramdateinputupd, txtcopydiagramdatepresentupd, txtcopydiagramdatevlinupd, txtcopydiagramdatevloutupd, txtcopydiagramdatedealerinupd,
  txtcopydiagramdatereturnupd)
  {
    if (txtcopydiagramemployeenameupd1 != '')
    {

      document.getElementById("txt_copydiagramemployeenameupdsh1").value = txtcopydiagramemployeenameupd1;
      document.getElementById("txt_copydiagramemployeenameupdnm1").value = txtcopydiagramemployeenameupd1;
    }
    if (txtcopydiagramemployeenameupd2 != '')
    {

      document.getElementById("txt_copydiagramemployeenameupdsh2").value = txtcopydiagramemployeenameupd2;
      document.getElementById("txt_copydiagramemployeenameupdnm2").value = txtcopydiagramemployeenameupd2;
    }
    if (txtcopydiagramthainameupd != '')
    {

      document.getElementById("txt_copydiagramthainameupdsh").value = txtcopydiagramthainameupd;
      document.getElementById("txt_copydiagramthainameupdnm").value = txtcopydiagramthainameupd;
    }
    if (txtcopydiagramdatevlinupd != '')
    {

      document.getElementById("txt_copydiagramdatevlinupdsh").value = txtcopydiagramdatevlinupd;
      document.getElementById("txt_copydiagramdatevlinupdnm").value = txtcopydiagramdatevlinupd;
    }
    if (txtcopydiagramdatevloutupd != '')
    {

      document.getElementById("txt_copydiagramdatevloutupdsh").value = txtcopydiagramdatevloutupd;
      document.getElementById("txt_copydiagramdatevloutupdnm").value = txtcopydiagramdatevloutupd;
    }
    if (txtcopydiagramdatedealerinupd != '')
    {

      document.getElementById("txt_copydiagramdatedealerinupdsh").value = txtcopydiagramdatedealerinupd;
      document.getElementById("txt_copydiagramdatedealerinupdnm").value = txtcopydiagramdatedealerinupd;
    }
    if (txtcopydiagramdatereturnupd != '')
    {

      document.getElementById("txt_copydiagramdatereturnupdsh").value = txtcopydiagramdatereturnupd;
      document.getElementById("txt_copydiagramdatereturnupdnm").value = txtcopydiagramdatereturnupd;
    }



    //

  }

  
  </script>
  <script>
        $(document).ready(function () {
            $('#dataTables-example1').DataTable({
                responsive: true
            });
        });
  </script>



</body>


</html>
<?php
sqlsrv_close($conn);
?>
