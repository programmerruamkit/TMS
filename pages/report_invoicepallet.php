<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$condition1 = " AND (a.USERNAME ='" . $_SESSION["USERNAME"] . "' AND a.PASSWORD = '" . $_SESSION["PASSWORD"] . "') AND a.ACTIVESTATUS = 1";
$sql_seLogin = "{call megRoleaccount_v2(?,?)}";
$params_seLogin = array(
  array('select_roleaccount', SQLSRV_PARAM_IN),
  array($condition1, SQLSRV_PARAM_IN)
);
$query_seLogin = sqlsrv_query($conn, $sql_seLogin, $params_seLogin);
$result_seLogin = sqlsrv_fetch_array($query_seLogin, SQLSRV_FETCH_ASSOC);

$conditionEHR = " AND a.PersonID ='" . $_SESSION["EMPLOYEEID"] . "'";
$sql_seEHR = "{call megEmployeeEHR_v2(?,?)}";
$params_seEHR = array(
  array('select_employeeehr2', SQLSRV_PARAM_IN),
  array($conditionEHR, SQLSRV_PARAM_IN)
);
$query_seEHR = sqlsrv_query($conn, $sql_seEHR, $params_seEHR);
$result_seEHR = sqlsrv_fetch_array($query_seEHR, SQLSRV_FETCH_ASSOC);

$sumgmtweight = "";
$sumcusweight = "";
$sumamounttrip = "";
$sumtotal = "";
delLogselect('delete_logselect', '', $result_seEHR['PersonCode']);
$condCompany = " AND Company_Code ='" . $_GET['companycode'] . "'";
$sql_seCompany = "{call megCompanyEHR_v2(?,?)}";
$params_seCompany = array(
  array('select_company', SQLSRV_PARAM_IN),
  array($condCompany, SQLSRV_PARAM_IN)
);
$query_seCompany = sqlsrv_query($conn, $sql_seCompany, $params_seCompany);
$result_seCompany = sqlsrv_fetch_array($query_seCompany, SQLSRV_FETCH_ASSOC);

$condCustomer = " AND a.CUSTOMERCODE ='" . $_GET['customercode'] . "'";
$sql_seCustomer = "{call megCustomer_v2(?,?)}";
$params_seCustomer = array(
  array('select_customer', SQLSRV_PARAM_IN),
  array($condCustomer, SQLSRV_PARAM_IN)
);
$query_seCustomer = sqlsrv_query($conn, $sql_seCustomer, $params_seCustomer);
$result_seCustomer = sqlsrv_fetch_array($query_seCustomer, SQLSRV_FETCH_ASSOC);

$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
  array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

/*
$condCnt11 = " AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'30/3/2019',103) AND CONVERT(DATE,'30/3/2019',103)";
$condCnt12 = " AND b.COMPANYCODE = 'RRC' AND b.CUSTOMERCODE = 'GMT'";

$sql_seCnt1 = "{call megVehicletransportdocumentdrivergetway_v2(?,?,?)}";
$params_seCnt1 = array(
array('select_countloginvoice', SQLSRV_PARAM_IN),
array($condCnt11, SQLSRV_PARAM_IN),
array($condCnt12, SQLSRV_PARAM_IN)
);
$query_seCnt1 = sqlsrv_query($conn, $sql_seCnt1, $params_seCnt1);
$result_seCnt1 = sqlsrv_fetch_array($query_seCnt1, SQLSRV_FETCH_ASSOC);

$condCnt21 = " AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'30/3/2019',103) AND CONVERT(DATE,'30/3/2019',103)";
$condCnt22 = " AND b.COMPANYCODE = 'RRC' AND b.CUSTOMERCODE = 'GMT' AND a.INVOICECODE =''";

$sql_seCnt2 = "{call megVehicletransportdocumentdrivergetway_v2(?,?,?)}";
$params_seCnt2 = array(
array('select_countloginvoice', SQLSRV_PARAM_IN),
array($condCnt21, SQLSRV_PARAM_IN),
array($condCnt22, SQLSRV_PARAM_IN)
);
$query_seCnt2 = sqlsrv_query($conn, $sql_seCnt2, $params_seCnt2);
$result_seCnt2 = sqlsrv_fetch_array($query_seCnt2, SQLSRV_FETCH_ASSOC);

echo $result_seCnt1['COUNTLOGINVOICE'];echo "<br>";
echo $result_seCnt2['COUNTLOGINVOICE'];echo "<br>";
* */
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
  <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
  <link href="../js/jquery.datetimepicker.css" rel="stylesheet">


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

  <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
  <script type="text/javascript" src="js/jquery.form.min.js"></script>


  <link href="style/style.css" rel="stylesheet" type="text/css">

</head>

<body >
  <div class="modal fade" id="modal_updatebilling" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="row" >
            <div class="col-lg-12">
              <label>แก้ไขแผนกวางบิล</label>
            </div>

          </div>

        </div>
        <div class="modal-body">
          <div id="updatebilling"></div>

        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modal_insinvoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="row" >
            <div class="col-lg-12">
              <label>เพิ่มเลขใบส่งสินค้า</label>
            </div>

          </div>

        </div>
        <div class="modal-body">
          <div class="row" >

            <div class="col-lg-4">
              <div class="form-group">

                <label>เลขที่ใบส่งสินค้า : </label>

                <input class="form-control" id="txt_invoicecode" name="txt_invoicecode" >

              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-group">

                <label>เลขที่ใบค่าทางด่วน : </label>

                <input class="form-control" id="txt_expresswaycode" name="txt_expresswaycode" >

              </div>
            </div>
            <div class="col-lg-4">
              <label>วันที่ครบกำหนด</label>
              <div class="form-group">
                <input type="text" class="form-control dateen"  readonly=""  style="background-color: #f080802e" id="txt_dulydate" name="txt_dulydate" placeholder="วันที่ครบกำหนด" value="<?= $result_getDate['SYSDATE']; ?>">
              </div>
            </div>

          </div>

          <div class="row">&nbsp;</div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
          <button type="button"  class="btn btn-primary" onclick="add_invoice()">บันทึก</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modal_image" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div id="modalimage"></div>
    </div>
  </div>
  <div class="modal fade" id="modal_repair" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 100%">
      <div id="datamodal_sr"></div>
    </div>
  </div>

  <div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
      <?php
      include '../pages/meg_header.php';
      include '../pages/meg_leftmenu.php';
      ?>
    </nav>

    <div id="page-wrapper">
      <div class="row">
        <div class="col-lg-12">
          <h2 class="page-header"><i class="fa fa-file-text-o"></i>
            รายงานวางบิล(พาเลท)
          </h2>
        </div>
        <!-- /.col-lg-12 -->
      </div>



      <div class="row">

        <div class="col-lg-6" >
          <label>&nbsp;</label><br>
          <label>บริษัท : <?= $result_seCompany['Company_NameT'] ?> / ลูกค้า : <?= $result_seCustomer['NAMETH'] ?></label><br>
          <!--<a href="#" onclick="pdf_chartstopwork();" class="btn btn-default">สถิติการขอหยุดรถ <li class="fa fa-print"></li></a>-->
        </div>

      </div>
      <div class="row" >
        <div class="col-lg-12">
          &nbsp;

        </div>
      </div>

      <div class="row">

        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <div class="row">

                <div class="col-lg-6">
                  <?php
                  $meg = 'รายงานวางบิล(พาเลท)';
                  if ($_GET['companycode'] == 'RKL' || $_GET['companycode'] == 'RKS' || $_GET['companycode'] == 'RKR') {
                    echo "<a href='report_companybillingamata.php?type=report'>บริษัท</a> / <a href='report_customerbillingamata.php?type=report&companycode=" . $_GET['companycode'] . "'>ลูกค้า</a>  / " . $meg;
                    $link = "<a href='report_companybillingamata.php?type=report'>บริษัท</a> / <a href='report_customerbillingamata.php?type=report&companycode=" . $_GET['companycode'] . "'>ลูกค้า</a> ";
                  } else {
                    echo "<a href='report_companybillinggetway.php?type=report'>บริษัท</a> / <a href='report_customerbillinggetway.php?type=report&companycode=" . $_GET['companycode'] . "'>ลูกค้า</a>  / " . $meg;
                    $link = "<a href='report_companybillinggetway.php?type=report'>บริษัท</a> / <a href='report_customerbillinggetway.php?type=report&companycode=" . $_GET['companycode'] . "'>ลูกค้า</a> ";
                  }
                  $_SESSION["link"] = $link;
                  ?>
                </div>


                <div class="col-lg-6 text-right">
                  <?= $result_seCompany['Company_NameT'] ?> / <?= $result_seCustomer['NAMETH'] ?>
                </div>
              </div>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">

              <ul class="nav nav-tabs">
                <li class="active"><a href="#invoice_add" data-toggle="tab">เพิ่มใบสั่งสินค้า</a>
                </li>
                <li class=""><a href="#invoice_detail" data-toggle="tab">รายการใบสั่งสินค้า</a>
                </li>
                <li class=""><a href="#invoice_unlock" data-toggle="tab">ปลดล็อคใบสั่งสินค้า</a>
                </li>


              </ul>

              <div class="tab-content">
                <div class="tab-pane fade active in" id="invoice_add">
                  <div class="panel-body">
                    <div class="modal fade" id="modal_dirverdoc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document" style="width: 80%">
                        <div class="modal-content">
                          <div class="modal-header">
                            <div class="row">
                              <div class="col-lg-5">
                                <h5 class="modal-title" id="title_copydiagram"><b>แก้ไขค่าเที่ยวพนักงาน</b></h5>
                              </div>

                            </div>
                          </div>
                          <div class="modal-body">

                            <div id="dirverdocsr"></div>


                          </div>
                          <div class="modal-footer">
                            <button type="button" onclick="reload()" class="btn btn-secondary" data-dismiss="modal">ปิด</button>

                          </div>
                        </div>
                      </div>
                    </div>






                    <div class="row">
                      <div class="col-lg-2">

                        <div class="form-group">
                          <label>ค้นหาตามช่วงวันที่</label>
                          <input class="form-control dateen" readonly="" onchange="datetodate();" style="background-color: #f080802e"  id="txt_datestart" name="txt_datestart" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">

                        </div>

                      </div>
                      <div class="col-lg-2">
                        <label>&nbsp;</label>
                        <div class="form-group">
                          <input type="text" class="form-control dateen"  readonly=""  style="background-color: #f080802e" id="txt_dateend" name="txt_dateend" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE']; ?>">

                        </div>
                      </div>
                      <?php
                      if ($_GET['companycode'] == 'RRC') {
                        if ($_GET['customercode'] == 'GMT') {
                          ?>
                          <div class="col-lg-2">
                            <label>&nbsp;</label>
                            <div class="form-group">
                              <select id="cb_materialtype" name="cb_materialtype" class="form-control"  title="เลือกประเภทวัสดุ..." >

                                <option value="">ไม่ระบุแผนก</option>
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
                          </div>
                          <?php
                        } else {
                          ?>

                          <input type="text" class="form-control" id="cb_materialtype" style="display: none">

                          <?php
                        }
                        if ($_GET['customercode'] == 'GMT') {
                          ?>
                          <div class="col-lg-2">
                            <label>ต้นทาง :</label>
                            <select id="cb_copydiagramjobstart" name="cb_copydiagramjobstart" class="form-control" >
                              <option value="">เลือก ต้นทาง</option>
                              <?php
                              $condTo1 = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "'";
                              $sql_seTo = "{call megVehicletransportprice_v2(?,?,?,?)}";
                              $params_seTo = array(
                                array('select_from', SQLSRV_PARAM_IN),
                                array($condTo1, SQLSRV_PARAM_IN),
                                array('', SQLSRV_PARAM_IN),
                                array('', SQLSRV_PARAM_IN)
                              );
                              $query_seTo = sqlsrv_query($conn, $sql_seTo, $params_seTo);
                              while ($result_seTo = sqlsrv_fetch_array($query_seTo, SQLSRV_FETCH_ASSOC)) {
                                ?>
                                <option value="<?= $result_seTo['FROM'] ?>"><?= $result_seTo['FROM'] ?></option>
                                <?php
                              }
                              ?>
                            </select>
                          </div>
                          <?php
                        }

                        if ($_GET['customercode'] == 'GMT') {
                          ?>
                          <div class="col-lg-2">
                            <label>ปลายทาง :</label>
                            <select id="cb_copydiagramjobend" name="cb_copydiagramjobend" class="form-control" >
                              <option value="">เลือก ปลายทาง</option>
                              <?php
                              $condTo1 = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "'";
                              $sql_seTo = "{call megVehicletransportprice_v2(?,?,?,?)}";
                              $params_seTo = array(
                                array('select_to', SQLSRV_PARAM_IN),
                                array($condTo1, SQLSRV_PARAM_IN),
                                array('', SQLSRV_PARAM_IN),
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
                        } else if ($_GET['customercode'] == 'BP') {
                          ?>
                          <div class="col-lg-2">
                            <label>ปลายทาง :</label>
                            <select id="cb_copydiagramjobend" name="cb_copydiagramjobend" class="form-control" >
                              <option value="">เลือก ปลายทาง</option>
                              <?php
                              $condTo1 = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "'";
                              $sql_seTo = "{call megVehicletransportprice_v2(?,?,?,?)}";
                              $params_seTo = array(
                                array('select_to', SQLSRV_PARAM_IN),
                                array($condTo1, SQLSRV_PARAM_IN),
                                array('', SQLSRV_PARAM_IN),
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
                          <div class="col-lg-2">
                            <label>ปลายทาง :</label>
                            <select id="cb_copydiagramjobend" name="cb_copydiagramjobend" class="form-control" >
                              <option value="">เลือก ปลายทาง</option>
                              <?php
                              $condTo1 = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "'";
                              $sql_seTo = "{call megVehicletransportprice_v2(?,?,?,?)}";
                              $params_seTo = array(
                                array('select_to', SQLSRV_PARAM_IN),
                                array($condTo1, SQLSRV_PARAM_IN),
                                array('', SQLSRV_PARAM_IN),
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
                          <div class="col-lg-2">
                            <label>ปลายทาง :</label>
                            <select id="cb_copydiagramjobend" name="cb_copydiagramjobend" class="form-control" >
                              <option value="">เลือก ปลายทาง</option>
                              <?php
                              $condTo1 = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "'";
                              $sql_seTo = "{call megVehicletransportprice_v2(?,?,?,?)}";
                              $params_seTo = array(
                                array('select_to', SQLSRV_PARAM_IN),
                                array($condTo1, SQLSRV_PARAM_IN),
                                array('', SQLSRV_PARAM_IN),
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
                      }
                      ?>
                      <?php
                      if ($_GET['companycode'] == 'RKS') {
                        if ($_GET['customercode'] == 'TMT') {
                          ?>
                          <div class="col-lg-2">
                            <label>route :</label>
                            <select id="cb_route" name="cb_route" class="form-control" >
                              <option value="">เลือก Route</option>
                              <?php
                              $condFrom1 = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "'";
                              $sql_seFrom = "{call megVehicletransportprice_v2(?,?,?,?)}";
                              $params_seFrom = array(
                                array('select_from', SQLSRV_PARAM_IN),
                                array($condFrom1, SQLSRV_PARAM_IN),
                                array('', SQLSRV_PARAM_IN),
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
                          <?php
                        } else if ($_GET['customercode'] == 'STM') {
                          ?>
                          <div class="col-lg-2">
                            <label>route :</label>
                            <select id="cb_route" name="cb_route" class="form-control" disabled>
                              <option value="">เลือก Route</option>
                              <?php
                              $condFrom1 = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "'";
                              $sql_seFrom = "{call megVehicletransportprice_v2(?,?,?,?)}";
                              $params_seFrom = array(
                                array('select_from', SQLSRV_PARAM_IN),
                                array($condFrom1, SQLSRV_PARAM_IN),
                                array('', SQLSRV_PARAM_IN),
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
                          <?php
                        } else if ($_GET['customercode'] == 'DENSO-THAI') {
                          ?>
                          <div class="col-lg-2">
                            <label>ต้นทาง</label>
                            <select id="cb_route" name="cb_route" class="form-control" >
                              <option value="">เลือก ต้นทาง</option>
                              <?php
                              $condRoute1 = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "'";
                              $sql_seRoute = "{call megVehicletransportprice_v2(?,?,?,?)}";
                              $params_seRoute = array(
                                array('select_routeno', SQLSRV_PARAM_IN),
                                array($condRoute1, SQLSRV_PARAM_IN),
                                array('', SQLSRV_PARAM_IN),
                                array('', SQLSRV_PARAM_IN)
                              );
                              $query_seRoute = sqlsrv_query($conn, $sql_seRoute, $params_seRoute);
                              while ($result_seRoute = sqlsrv_fetch_array($query_seRoute, SQLSRV_FETCH_ASSOC)) {
                                ?>
                                <option value="<?= $result_seRoute['ROUTENO'] ?>"><?= $result_seRoute['ROUTENO'] ?></option>
                                <?php
                              }
                              ?>
                            </select>
                          </div>
                          <?php
                        } else if ($_GET['customercode'] == 'TGT') {
                          ?>
                          <div class="col-lg-2">
                            <label>ต้นทาง :</label>
                            <select id="cb_route" name="cb_route" class="form-control" >
                              <option value="">เลือก ต้นทาง</option>
                              <?php
                              $condfrom1 = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "'";
                              $sql_sefrom = "{call megVehicletransportprice_v2(?,?,?,?)}";
                              $params_sefrom = array(
                                array('select_from', SQLSRV_PARAM_IN),
                                array($condfrom1, SQLSRV_PARAM_IN),
                                array('', SQLSRV_PARAM_IN),
                                array('', SQLSRV_PARAM_IN)
                              );
                              $query_sefrom = sqlsrv_query($conn, $sql_sefrom, $params_sefrom);
                              while ($result_sefrom = sqlsrv_fetch_array($query_sefrom, SQLSRV_FETCH_ASSOC)) {
                                ?>
                                <option value="<?= $result_sefrom['FROM'] ?>"><?= $result_sefrom['FROM'] ?></option>
                                <?php
                              }
                              ?>
                            </select>
                          </div>
                          <?php
                        } else {
                          ?>
                          <select id="cb_route" name="cb_route" class="form-control" style="display: none">
                            <option value=""></option>

                          </select>
                          <?php
                        }
                      } else {
                        ?>
                        <select id="cb_route" name="cb_route" class="form-control" style="display: none">
                          <option value=""></option>

                        </select>
                        <?php
                      }

                      if ($_GET['companycode'] == 'RKS') {
                        ?>

                        <input type="text" class="form-control" id="cb_materialtype" style="display: none">
                        <select id="cb_copydiagramjobend" name="cb_copydiagramjobend" class="form-control" style="display: none">
                          <option value=""></option>

                        </select>

                        <?php
                      }

                      if ($_GET['companycode'] == 'RKR') {
                        if ($_GET['customercode'] == 'TTASTSTC' || $_GET['customercode'] == 'TTPROSTC' || $_GET['customercode'] == 'DAIKI' || $_GET['customercode'] == 'TTASTCS') {
                          ?>

                          <?php
                        }
                      }

                      if ($_GET['companycode'] == 'RKL') {

                        if ($_GET['customercode'] == 'TTASTSTC' || $_GET['customercode'] == 'TTPROSTC' || $_GET['customercode'] == 'TTTCSTC' || $_GET['customercode'] == 'TTASTCS' || $_GET['customercode'] == 'DAIKI') {
                          ?>
                          <div class="col-lg-2">
                            <label>วางบิล :</label>
                            <select id="cb_billing" name="cb_billing" class="form-control" >
                              <option value="">เลือก วางบิล</option>
                              <?php
                              $condBilling1 = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "'";
                              $sql_seBilling = "{call megVehicletransportprice_v2(?,?,?,?)}";
                              $params_seBilling = array(
                                array('select_billing', SQLSRV_PARAM_IN),
                                array($condBilling1, SQLSRV_PARAM_IN),
                                array('', SQLSRV_PARAM_IN),
                                array('', SQLSRV_PARAM_IN)
                              );
                              $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                              while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                                ?>
                                <option value="<?= $result_seBilling['BILLING'] ?>"><?= $result_seBilling['BILLING'] ?></option>
                                <?php
                              }
                              ?>
                            </select>
                          </div>
                          <?php
                        }
                        ?>
                        <input type="text" class="form-control" id="cb_materialtype" style="display: none">
                        <select id="cb_copydiagramjobend" name="cb_copydiagramjobend" class="form-control" style="display: none">
                          <option value=""></option>

                        </select>

                        <?php
                      }
                      ?>
                      <div class="col-lg-2">
                        <label>&nbsp;</label>
                        <div class="form-group">
                          <button type="button" class="btn btn-default" onclick="select_invoice();">ค้นหา <li class="fa fa-search"></li></button>
                        </div>

                      </div>



                    </div>
                    <?php
                    if ($_GET['companycode'] == 'RKS') {
                      if ($_GET['customercode'] == 'TAW') {
                        ?>



                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                          <div id="datadef">

                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                              <thead>
                                <tr>
                                  <th style="text-align: center">ลำดับที่</th>
                                  <th style="text-align: center">วันที่</th>
                                  <th style="text-align: center">หมายเลข DO</th>
                                  <th style="text-align: center">ทะเบียนรถ</th>
                                  <th style="text-align: center">พนักงาน</th>
                                  <th style="text-align: center">เส้นทาง</th>
                                  <th style="text-align: center">QT</th>
                                  <th style="text-align: center">ราคา</th>
                                  <th style="text-align: center">จำนวนเงิน(บาท)</th>
                                  <th style="text-align: center;width: 100px">

                                    <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                  </th>

                                </tr>

                              </thead>


                            </table>



                          </div>
                          <div id="datasr"></div>
                        </div>

                        <?php
                      } else if ($_GET['customercode'] == 'TGT') {
                        ?>



                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                          <div id="datadef">

                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                              <thead>
                                <tr>
                                  <th style="text-align: center">ลำดับที่</th>
                                  <th style="text-align: center">วันที่</th>
                                  <th style="text-align: center">หมายเลข DO</th>
                                  <th style="text-align: center">ทะเบียนรถ</th>
                                  <th style="text-align: center">พนักงาน</th>
                                  <th style="text-align: center">เส้นทาง</th>
                                  <th style="text-align: center">QT</th>
                                  <th style="text-align: center">ราคา</th>
                                  <th style="text-align: center">จำนวนเงิน(บาท)</th>
                                  <th style="text-align: center;width: 100px">

                                    <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                  </th>

                                </tr>

                              </thead>


                            </table>



                          </div>
                          <div id="datasr"></div>
                        </div>

                        <?php
                      } else if ($_GET['customercode'] == 'DENSO-THAI') {
                        ?>



                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                          <div id="datadef">

                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                              <thead>
                                <tr>
                                  <th style="text-align: center">ลำดับที่</th>
                                  <th style="text-align: center">วันที่</th>
                                  <th style="text-align: center">ทะเบียนรถ</th>
                                  <th style="text-align: center">พนักงานขับรถ</th>
                                  <th style="text-align: center">หมายเลขเส้นทาง</th>
                                  <th style="text-align: center">ประเภทรถ</th>
                                  <th style="text-align: center">จำนวนเงิน(บาท)</th>
                                  <th style="text-align: center">หมายเหตุ</th>
                                  <th style="text-align: center;width: 100px">

                                    <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                  </th>

                                </tr>

                              </thead>


                            </table>



                          </div>
                          <div id="datasr"></div>
                        </div>

                        <?php
                      } else if ($_GET['customercode'] == 'TMT') {
                        ?>



                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                          <div id="datadef">

                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                              <thead>
                                <tr>
                                  <th style="text-align: center">DATE</th>
                                  <th style="text-align: center">ROUTE</th>
                                  <th style="text-align: center">6 Wheels</th>
                                  <th style="text-align: center">10 Wheels</th>
                                  <th style="text-align: center">Extra Truck</th>
                                  <th style="text-align: center">TOTAL</th>
                                  <th style="text-align: center;width: 100px">

                                    <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                  </th>

                                </tr>

                              </thead>
                              <tbody>

                              </tbody>

                            </table>



                          </div>
                          <div id="datasr"></div>
                        </div>

                        <?php
                      } else if ($_GET['customercode'] == 'STM') {
                        ?>



                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                          <div id="datadef">
                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                              <thead>
                                <tr>
                                  <th style="text-align: center">DATE</th>
                                  <th style="text-align: center">ROUTE</th>
                                  <th style="text-align: center">QTY TRIP</th>
                                  <th style="text-align: center">Extra Truck</th>
                                  <th style="text-align: center">TOTAL</th>
                                  <th style="text-align: center;width: 100px">

                                    <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                  </th>

                                </tr>

                              </thead>
                              <tbody></tbody>
                            </table>




                          </div>
                          <div id="datasr"></div>
                        </div>

                        <?php
                      } else if ($_GET['customercode'] == 'DAIKI') {
                        ?>



                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                          <div id="datadef">
                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                              <thead>
                                <tr>
                                  <th style="text-align: center">ลำดับ</th>
                                  <th style="text-align: center">วันที่</th>
                                  <th style="text-align: center">หมายเลข DO</th>
                                  <th style="text-align: center">ทะเบียนรถ</th>
                                  <th style="text-align: center">พนักงาน</th>
                                  <th style="text-align: center">จาก</th>
                                  <th style="text-align: center">ถึง</th>
                                  <th style="text-align: center">QT.</th>
                                  <th style="text-align: center">หน่วยละ</th>
                                  <th style="text-align: center">จำนวนเงิน</th>
                                  <th style="text-align: center;width: 100px">

                                    <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                  </th>

                                </tr>

                              </thead>
                              <tbody>

                              </tbody>
                            </table>




                          </div>
                          <div id="datasr"></div>
                        </div>

                        <?php
                      } else if ($_GET['customercode'] == 'GMT') {
                        ?>



                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                          <div id="datadef">
                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                              <thead>
                                <tr>
                                  <th style="text-align: center">ลำดับ</th>
                                  <th style="text-align: center">วันที่</th>
                                  <th style="text-align: center">หมายเลข DO</th>
                                  <th style="text-align: center">ทะเบียนรถ</th>
                                  <th style="text-align: center">พนักงาน</th>
                                  <th style="text-align: center">จาก</th>
                                  <th style="text-align: center">ถึง</th>
                                  <th style="text-align: center">QT.</th>
                                  <th style="text-align: center">หน่วยละ</th>
                                  <th style="text-align: center">จำนวนเงิน</th>
                                  <th style="text-align: center;width: 100px">

                                    <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                  </th>

                                </tr>

                              </thead>
                              <tbody>

                              </tbody>
                            </table>




                          </div>
                          <div id="datasr"></div>
                        </div>

                        <?php
                      } else if ($_GET['customercode'] == 'TKT') {
                        ?>



                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                          <div id="datadef">
                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                              <thead>
                                <tr>
                                  <th style="text-align: center">ลำดับ</th>
                                  <th style="text-align: center">วันที่</th>
                                  <th style="text-align: center">หมายเลข DO</th>
                                  <th style="text-align: center">ทะเบียนรถ</th>
                                  <th style="text-align: center">พนักงาน</th>
                                  <th style="text-align: center">จาก</th>
                                  <th style="text-align: center">ถึง</th>
                                  <th style="text-align: center">QT.</th>
                                  <th style="text-align: center">หน่วยละ</th>
                                  <th style="text-align: center">จำนวนเงิน</th>
                                  <th style="text-align: center;width: 100px">

                                    <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                  </th>

                                </tr>

                              </thead>
                              <tbody>

                              </tbody>
                            </table>




                          </div>
                          <div id="datasr"></div>
                        </div>

                        <?php
                      }
                    } else if ($_GET['companycode'] == 'RRC') {
                      if ($_GET['customercode'] == 'GMT') {
                        ?>



                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                          <div id="datadef">

                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                              <thead>
                                <tr>
                                  <th style="text-align: center" rowspan="2">No.</th>
                                  <th style="text-align: center" rowspan="2">Document</th>
                                  <th style="text-align: center" rowspan="2">D/M/Y</th>
                                  <th style="text-align: center" rowspan="2">Driver</th>
                                  <th style="text-align: center" rowspan="2">Truck No.</th>
                                  <th style="text-align: center" colspan="2">Delivery</th>
                                  <th style="text-align: center" colspan="2">Weight (Tons)</th>
                                  <th style="text-align: center">Price</th>
                                  <th style="text-align: center" rowspan="2">Total</th>
                                  <!--<th style="text-align: center" rowspan="2">Status</th>-->
                                  <th style="text-align: center;width: 100px" rowspan="2">

                                    <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                  </th>

                                </tr>
                                <tr>
                                  <th style="text-align: center">From</th>
                                  <th style="text-align: center">To</th>
                                  <th style="text-align: center">GMT weight</th>
                                  <th style="text-align: center">CUS weight</th>
                                  <th style="text-align: center">Baht/Trips</th>
                                </tr>
                              </thead>


                            </table>



                          </div>
                          <div id="datasr"></div>
                        </div>
                        <?php
                      }

                      if ($_GET['customercode'] == 'TTAST') {
                        ?>
                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                          <div id="datadef">

                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                              <thead>
                                <tr>
                                  <th style="text-align: center;width: 5%">ลำดับ</th>
                                  <th style="text-align: center;width: 5%">วันที่</th>
                                  <th style="text-align: center;width: 10%">หมายเลข DO</th>
                                  <th style="text-align: center;width: 5%">ทะเบียนรถ</th>
                                  <th style="text-align: center;width: 10%">พนักงาน</th>
                                  <th style="text-align: center;width: 5%">จาก</th>
                                  <th style="text-align: center;width: 5%">ถึง</th>
                                  <th style="text-align: center;width: 10%">จำนวนแพ็ค/เที่ยว</th>
                                  <th style="text-align: center;width: 10%">น้ำหนักรวม/เที่ยว</th>
                                  <th style="text-align: center;width: 5%">QT.</th>
                                  <th style="text-align: center;width: 10%">หน่วยละ</th>
                                  <th style="text-align: center;width: 10%">จำนวนเงิน(บาท)</th>
                                  <th style="text-align: center;width: 10%">

                                    <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                  </th>


                                </tr>
                              </thead>


                            </table>



                          </div>
                          <div id="datasr"></div>
                        </div>
                        <?php
                      }

                      if ($_GET['customercode'] == 'BP') {
                        ?>
                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                          <div id="datadef">
                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                              <thead>
                                <tr>
                                  <th style="text-align: center" rowspan="2">No.</th>
                                  <th style="text-align: center" rowspan="2">D/M/Y</th>
                                  <th style="text-align: center" rowspan="2">Driver</th>
                                  <th style="text-align: center" rowspan="2">Truck No.</th>
                                  <th style="text-align: center" colspan="2">Delivery</th>
                                  <th style="text-align: center" colspan="2">Weight (Tons)</th>
                                  <th style="text-align: center">Price</th>
                                  <th style="text-align: center" rowspan="2">Total</th>
                                  <!--<th style="text-align: center" rowspan="2">Status</th>-->
                                  <th style="text-align: center;width: 10px" rowspan="2">

                                    <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                  </th>

                                </tr>
                                <tr>
                                  <th style="text-align: center">From</th>
                                  <th style="text-align: center">To</th>
                                  <th style="text-align: center">GMT weight</th>
                                  <th style="text-align: center">CUS weight</th>
                                  <th style="text-align: center">Baht/Trips</th>
                                </tr>
                              </thead>


                            </table>



                          </div>
                          <div id="datasr"></div>
                        </div>
                        <?php
                      }
                    } else if ($_GET['companycode'] == 'RKR') {
                      if ($_GET['carrytype'] == 'trip') {
                        if ($_GET['customercode'] == 'DAIKI') {
                          ?>



                          <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div id="datadef">
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">ลำดับ</th>
                                    <th style="text-align: center">วันที่</th>
                                    <th style="text-align: center">หมายเลข DO</th>
                                    <th style="text-align: center">ทะเบียนรถ</th>
                                    <th style="text-align: center">พนักงาน</th>
                                    <th style="text-align: center">จาก</th>
                                    <th style="text-align: center">ถึง</th>
                                    <th style="text-align: center">QT.</th>
                                    <th style="text-align: center">หน่วยละ</th>
                                    <th style="text-align: center">จำนวนเงิน</th>
                                    <th style="text-align: center;width: 100px">

                                      <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                    </th>

                                  </tr>

                                </thead>
                                <tbody>

                                </tbody>
                              </table>




                            </div>
                            <div id="datasr"></div>
                          </div>

                          <?php
                        } else if ($_GET['customercode'] == 'TTPRO') {
                          ?>



                          <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div id="datadef">
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">ลำดับ</th>
                                    <th style="text-align: center">วันที่</th>
                                    <th style="text-align: center">หมายเลข DO</th>
                                    <th style="text-align: center">ทะเบียนรถ</th>
                                    <th style="text-align: center">พนักงาน</th>
                                    <th style="text-align: center">จาก</th>
                                    <th style="text-align: center">ถึง</th>
                                    <th style="text-align: center">QT.</th>
                                    <th style="text-align: center">หน่วยละ</th>
                                    <th style="text-align: center">จำนวนเงิน</th>
                                    <th style="text-align: center;width: 100px">

                                      <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                    </th>

                                  </tr>

                                </thead>
                                <tbody>

                                </tbody>
                              </table>




                            </div>
                            <div id="datasr"></div>
                          </div>

                          <?php
                        } else if ($_GET['customercode'] == 'TTAST') {
                          ?>



                          <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div id="datadef">
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">ลำดับ</th>
                                    <th style="text-align: center">วันที่</th>
                                    <th style="text-align: center">หมายเลข DO</th>
                                    <th style="text-align: center">ทะเบียนรถ</th>
                                    <th style="text-align: center">พนักงาน</th>
                                    <th style="text-align: center">จาก</th>
                                    <th style="text-align: center">ถึง</th>
                                    <th style="text-align: center">QT.</th>
                                    <th style="text-align: center">หน่วยละ</th>
                                    <th style="text-align: center">จำนวนเงิน</th>
                                    <th style="text-align: center;width: 100px">

                                      <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                    </th>

                                  </tr>

                                </thead>
                                <tbody>

                                </tbody>
                              </table>




                            </div>
                            <div id="datasr"></div>
                          </div>

                          <?php
                        } else if ($_GET['customercode'] == 'TTAT') {
                          ?>



                          <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div id="datadef">
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">ลำดับ</th>
                                    <th style="text-align: center">วันที่</th>
                                    <th style="text-align: center">หมายเลข DO</th>
                                    <th style="text-align: center">ทะเบียนรถ</th>
                                    <th style="text-align: center">พนักงาน</th>
                                    <th style="text-align: center">จาก</th>
                                    <th style="text-align: center">ถึง</th>
                                    <th style="text-align: center">QT.</th>
                                    <th style="text-align: center">หน่วยละ</th>
                                    <th style="text-align: center">จำนวนเงิน</th>
                                    <th style="text-align: center;width: 100px">

                                      <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                    </th>

                                  </tr>

                                </thead>
                                <tbody>

                                </tbody>
                              </table>




                            </div>
                            <div id="datasr"></div>
                          </div>

                          <?php
                        } else if ($_GET['customercode'] == 'TMT') {
                          ?>



                          <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div id="datadef">
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">ลำดับ</th>
                                    <th style="text-align: center">วันที่</th>
                                    <th style="text-align: center">หมายเลข DO</th>
                                    <th style="text-align: center">ทะเบียนรถ</th>
                                    <th style="text-align: center">พนักงาน</th>
                                    <th style="text-align: center">จาก</th>
                                    <th style="text-align: center">ถึง</th>
                                    <th style="text-align: center">QT.</th>
                                    <th style="text-align: center">หน่วยละ</th>
                                    <th style="text-align: center">จำนวนเงิน</th>
                                    <th style="text-align: center;width: 100px">

                                      <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                    </th>

                                  </tr>

                                </thead>
                                <tbody>

                                </tbody>
                              </table>




                            </div>
                            <div id="datasr"></div>
                          </div>

                          <?php
                        } else if ($_GET['customercode'] == 'TGT') {
                          ?>



                          <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div id="datadef">
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">ลำดับ</th>
                                    <th style="text-align: center">วันที่</th>
                                    <th style="text-align: center">หมายเลข DO</th>
                                    <th style="text-align: center">ทะเบียนรถ</th>
                                    <th style="text-align: center">พนักงาน</th>
                                    <th style="text-align: center">จาก</th>
                                    <th style="text-align: center">ถึง</th>
                                    <th style="text-align: center">QT.</th>
                                    <th style="text-align: center">หน่วยละ</th>
                                    <th style="text-align: center">จำนวนเงิน</th>
                                    <th style="text-align: center;width: 100px">

                                      <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                    </th>

                                  </tr>

                                </thead>
                                <tbody>

                                </tbody>
                              </table>




                            </div>
                            <div id="datasr"></div>
                          </div>

                          <?php
                        } else if ($_GET['customercode'] == 'YNP') {
                          ?>



                          <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div id="datadef">
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">ลำดับ</th>
                                    <th style="text-align: center">วันที่</th>
                                    <th style="text-align: center">หมายเลข DO</th>
                                    <th style="text-align: center">ทะเบียนรถ</th>
                                    <th style="text-align: center">พนักงาน</th>
                                    <th style="text-align: center">จาก</th>
                                    <th style="text-align: center">ถึง</th>
                                    <th style="text-align: center">QT.</th>
                                    <th style="text-align: center">หน่วยละ</th>
                                    <th style="text-align: center">จำนวนเงิน</th>
                                    <th style="text-align: center;width: 100px">

                                      <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                    </th>

                                  </tr>

                                </thead>
                                <tbody>

                                </tbody>
                              </table>




                            </div>
                            <div id="datasr"></div>
                          </div>

                          <?php
                        } else if ($_GET['customercode'] == 'GMT') {
                          ?>



                          <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div id="datadef">
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">ลำดับ</th>
                                    <th style="text-align: center">วันที่</th>
                                    <th style="text-align: center">หมายเลข DO</th>
                                    <th style="text-align: center">ทะเบียนรถ</th>
                                    <th style="text-align: center">พนักงาน</th>
                                    <th style="text-align: center">จาก</th>
                                    <th style="text-align: center">ถึง</th>
                                    <th style="text-align: center">QT.</th>
                                    <th style="text-align: center">หน่วยละ</th>
                                    <th style="text-align: center">จำนวนเงิน</th>
                                    <th style="text-align: center;width: 100px">

                                      <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                    </th>

                                  </tr>

                                </thead>
                                <tbody>

                                </tbody>
                              </table>




                            </div>
                            <div id="datasr"></div>
                          </div>

                          <?php
                        }
                      } else if ($_GET['carrytype'] == 'weight') {
                        if ($_GET['customercode'] == 'TTPROSTC') {
                          ?>



                          <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div id="datadef">
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">ลำดับ</th>
                                    <th style="text-align: center">วันที่</th>
                                    <th style="text-align: center">หมายเลข DO</th>
                                    <th style="text-align: center">ทะเบียนรถ</th>
                                    <th style="text-align: center">พนักงาน</th>
                                    <th style="text-align: center">จาก</th>
                                    <th style="text-align: center">ถึง</th>
                                    <th style="text-align: center">QT.</th>
                                    <th style="text-align: center">หน่วยละ</th>
                                    <th style="text-align: center">จำนวนเงิน</th>
                                    <th style="text-align: center;width: 100px">

                                      <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                    </th>

                                  </tr>

                                </thead>
                                <tbody>

                                </tbody>
                              </table>




                            </div>
                            <div id="datasr"></div>
                          </div>

                          <?php
                        } else if ($_GET['customercode'] == 'TTASTSTC') {
                          ?>



                          <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div id="datadef">
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">ลำดับ</th>
                                    <th style="text-align: center">วันที่</th>
                                    <th style="text-align: center">หมายเลข DO</th>
                                    <th style="text-align: center">ทะเบียนรถ</th>
                                    <th style="text-align: center">พนักงาน</th>
                                    <th style="text-align: center">จาก</th>
                                    <th style="text-align: center">ถึง</th>
                                    <th style="text-align: center">QT.</th>
                                    <th style="text-align: center">หน่วยละ</th>
                                    <th style="text-align: center">จำนวนเงิน</th>
                                    <th style="text-align: center;width: 200px">

                                      <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a></a>

                                    </th>

                                  </tr>

                                </thead>
                                <tbody>

                                </tbody>
                              </table>




                            </div>
                            <div id="datasr"></div>
                          </div>

                          <?php
                        } else if ($_GET['customercode'] == 'TTASTCS') {
                          ?>



                          <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div id="datadef">
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">ลำดับ</th>
                                    <th style="text-align: center">วันที่</th>
                                    <th style="text-align: center">หมายเลข DO</th>
                                    <th style="text-align: center">ทะเบียนรถ</th>
                                    <th style="text-align: center">พนักงาน</th>
                                    <th style="text-align: center">จาก</th>
                                    <th style="text-align: center">ถึง</th>
                                    <th style="text-align: center">QT.</th>
                                    <th style="text-align: center">หน่วยละ</th>
                                    <th style="text-align: center">จำนวนเงิน</th>
                                    <th style="text-align: center;width: 100px">

                                      <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                    </th>

                                  </tr>

                                </thead>
                                <tbody>

                                </tbody>
                              </table>




                            </div>
                            <div id="datasr"></div>
                          </div>

                          <?php
                        } else if ($_GET['customercode'] == 'DAIKI') {
                          ?>



                          <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div id="datadef">
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">ลำดับ</th>
                                    <th style="text-align: center">วันที่</th>
                                    <th style="text-align: center">หมายเลข DO</th>
                                    <th style="text-align: center">ทะเบียนรถ</th>
                                    <th style="text-align: center">พนักงาน</th>
                                    <th style="text-align: center">จาก</th>
                                    <th style="text-align: center">ถึง</th>
                                    <th style="text-align: center">QT.</th>
                                    <th style="text-align: center">หน่วยละ</th>
                                    <th style="text-align: center">จำนวนเงิน</th>
                                    <th style="text-align: center;width: 100px">

                                      <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                    </th>

                                  </tr>

                                </thead>
                                <tbody>

                                </tbody>
                              </table>




                            </div>
                            <div id="datasr"></div>
                          </div>

                          <?php
                        }
                      }
                    } else if ($_GET['companycode'] == 'RKL') {
                      if ($_GET['carrytype'] == 'trip') {
                        if ($_GET['customercode'] == 'SKB') {
                          ?>
                          <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div id="datadef">
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">ลำดับ</th>
                                    <th style="text-align: center">วันที่</th>
                                    <th style="text-align: center">หมายเลข DO</th>
                                    <th style="text-align: center">ทะเบียนรถ</th>
                                    <th style="text-align: center">พนักงาน</th>
                                    <th style="text-align: center">จาก</th>
                                    <th style="text-align: center">ถึง</th>
                                    <th style="text-align: center">QT.</th>
                                    <th style="text-align: center">หน่วยละ</th>
                                    <th style="text-align: center">จำนวนเงิน</th>
                                    <th style="text-align: center;width: 100px">

                                      <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                    </th>

                                  </tr>

                                </thead>
                                <tbody>

                                </tbody>
                              </table>




                            </div>
                            <div id="datasr"></div>
                          </div>
                          <?php
                        } else if ($_GET['customercode'] == 'TTTC') {
                          ?>
                          <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div id="datadef">
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">ลำดับ</th>
                                    <th style="text-align: center">วันที่</th>
                                    <th style="text-align: center">หมายเลข DO</th>
                                    <th style="text-align: center">ทะเบียนรถ</th>
                                    <th style="text-align: center">พนักงาน</th>
                                    <th style="text-align: center">จาก</th>
                                    <th style="text-align: center">ถึง</th>
                                    <th style="text-align: center">QT.</th>
                                    <th style="text-align: center">หน่วยละ</th>
                                    <th style="text-align: center">จำนวนเงิน</th>
                                    <th style="text-align: center;width: 100px">

                                      <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                    </th>

                                  </tr>

                                </thead>
                                <tbody>

                                </tbody>
                              </table>




                            </div>
                            <div id="datasr"></div>
                          </div>
                          <?php
                        } else if ($_GET['customercode'] == 'CH-AUTO') {
                          ?>
                          <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div id="datadef">
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">ลำดับ</th>
                                    <th style="text-align: center">วันที่</th>
                                    <th style="text-align: center">หมายเลข DO</th>
                                    <th style="text-align: center">ทะเบียนรถ</th>
                                    <th style="text-align: center">พนักงาน</th>
                                    <th style="text-align: center">จาก</th>
                                    <th style="text-align: center">ถึง</th>
                                    <th style="text-align: center">QT.</th>
                                    <th style="text-align: center">หน่วยละ</th>
                                    <th style="text-align: center">จำนวนเงิน</th>
                                    <th style="text-align: center;width: 100px">

                                      <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                    </th>

                                  </tr>

                                </thead>
                                <tbody>

                                </tbody>
                              </table>




                            </div>
                            <div id="datasr"></div>
                          </div>
                          <?php
                        } else if ($_GET['customercode'] == 'TTAT') {
                          ?>
                          <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div id="datadef">
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">ลำดับ</th>
                                    <th style="text-align: center">วันที่</th>
                                    <th style="text-align: center">หมายเลข DO</th>
                                    <th style="text-align: center">ทะเบียนรถ</th>
                                    <th style="text-align: center">พนักงาน</th>
                                    <th style="text-align: center">จาก</th>
                                    <th style="text-align: center">ถึง</th>
                                    <th style="text-align: center">QT.</th>
                                    <th style="text-align: center">หน่วยละ</th>
                                    <th style="text-align: center">จำนวนเงิน</th>
                                    <th style="text-align: center;width: 100px">

                                      <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                    </th>

                                  </tr>

                                </thead>
                                <tbody>

                                </tbody>
                              </table>




                            </div>
                            <div id="datasr"></div>
                          </div>
                          <?php
                        } else if ($_GET['customercode'] == 'TKT') {
                          ?>
                          <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div id="datadef">
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">ลำดับ</th>
                                    <th style="text-align: center">วันที่</th>
                                    <th style="text-align: center">หมายเลข DO</th>
                                    <th style="text-align: center">ทะเบียนรถ</th>
                                    <th style="text-align: center">พนักงาน</th>
                                    <th style="text-align: center">จาก</th>
                                    <th style="text-align: center">ถึง</th>
                                    <th style="text-align: center">QT.</th>
                                    <th style="text-align: center">หน่วยละ</th>
                                    <th style="text-align: center">จำนวนเงิน</th>
                                    <th style="text-align: center;width: 100px">

                                      <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                    </th>

                                  </tr>

                                </thead>
                                <tbody>

                                </tbody>
                              </table>




                            </div>
                            <div id="datasr"></div>
                          </div>
                          <?php
                        } else if ($_GET['customercode'] == 'TSAT') {
                          ?>
                          <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div id="datadef">
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">ลำดับ</th>
                                    <th style="text-align: center">วันที่</th>
                                    <th style="text-align: center">หมายเลข DO</th>
                                    <th style="text-align: center">ทะเบียนรถ</th>
                                    <th style="text-align: center">พนักงาน</th>
                                    <th style="text-align: center">จาก</th>
                                    <th style="text-align: center">ถึง</th>
                                    <th style="text-align: center">QT.</th>
                                    <th style="text-align: center">หน่วยละ</th>
                                    <th style="text-align: center">จำนวนเงิน</th>
                                    <th style="text-align: center;width: 100px">

                                      <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                    </th>

                                  </tr>

                                </thead>
                                <tbody>

                                </tbody>
                              </table>




                            </div>
                            <div id="datasr"></div>
                          </div>
                          <?php
                        } else if ($_GET['customercode'] == 'YNP') {
                          ?>
                          <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div id="datadef">
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">ลำดับ</th>
                                    <th style="text-align: center">วันที่</th>
                                    <th style="text-align: center">หมายเลข DO</th>
                                    <th style="text-align: center">ทะเบียนรถ</th>
                                    <th style="text-align: center">พนักงาน</th>
                                    <th style="text-align: center">จาก</th>
                                    <th style="text-align: center">ถึง</th>
                                    <th style="text-align: center">QT.</th>
                                    <th style="text-align: center">หน่วยละ</th>
                                    <th style="text-align: center">จำนวนเงิน</th>
                                    <th style="text-align: center;width: 100px">

                                      <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                    </th>

                                  </tr>

                                </thead>
                                <tbody>

                                </tbody>
                              </table>




                            </div>
                            <div id="datasr"></div>
                          </div>
                          <?php
                        } else if ($_GET['customercode'] == 'WSBT') {
                          ?>
                          <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div id="datadef">
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">ลำดับ</th>
                                    <th style="text-align: center">วันที่</th>
                                    <th style="text-align: center">หมายเลข DO</th>
                                    <th style="text-align: center">ทะเบียนรถ</th>
                                    <th style="text-align: center">พนักงาน</th>
                                    <th style="text-align: center">จาก</th>
                                    <th style="text-align: center">ถึง</th>
                                    <th style="text-align: center">QT.</th>
                                    <th style="text-align: center">หน่วยละ</th>
                                    <th style="text-align: center">จำนวนเงิน</th>
                                    <th style="text-align: center;width: 100px">

                                      <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                    </th>

                                  </tr>

                                </thead>
                                <tbody>

                                </tbody>
                              </table>




                            </div>
                            <div id="datasr"></div>
                          </div>
                          <?php
                        } else if ($_GET['customercode'] == 'TMT') {
                          ?>
                          <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div id="datadef">
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">ลำดับ</th>
                                    <th style="text-align: center">วันที่</th>
                                    <th style="text-align: center">หมายเลข DO</th>
                                    <th style="text-align: center">ทะเบียนรถ</th>
                                    <th style="text-align: center">พนักงาน</th>
                                    <th style="text-align: center">จาก</th>
                                    <th style="text-align: center">ถึง</th>
                                    <th style="text-align: center">QT.</th>
                                    <th style="text-align: center">หน่วยละ</th>
                                    <th style="text-align: center">จำนวนเงิน</th>
                                    <th style="text-align: center;width: 100px">

                                      <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                    </th>

                                  </tr>

                                </thead>
                                <tbody>

                                </tbody>
                              </table>




                            </div>
                            <div id="datasr"></div>
                          </div>
                          <?php
                        } else if ($_GET['customercode'] == 'NITTSUSHOJI') {
                          ?>
                          <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div id="datadef">
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">ลำดับ</th>
                                    <th style="text-align: center">วันที่</th>
                                    <th style="text-align: center">หมายเลข DO</th>
                                    <th style="text-align: center">ทะเบียนรถ</th>
                                    <th style="text-align: center">พนักงาน</th>
                                    <th style="text-align: center">จาก</th>
                                    <th style="text-align: center">ถึง</th>
                                    <th style="text-align: center">QT.</th>
                                    <th style="text-align: center">หน่วยละ</th>
                                    <th style="text-align: center">จำนวนเงิน</th>
                                    <th style="text-align: center;width: 100px">

                                      <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                    </th>

                                  </tr>

                                </thead>
                                <tbody>

                                </tbody>
                              </table>




                            </div>
                            <div id="datasr"></div>
                          </div>
                          <?php
                        }
                      } else if ($_GET['carrytype'] == 'weight') {
                        if ($_GET['customercode'] == 'DAIKI') {
                          ?>



                          <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div id="datadef">
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">ลำดับ</th>
                                    <th style="text-align: center">วันที่</th>
                                    <th style="text-align: center">หมายเลข DO</th>
                                    <th style="text-align: center">ทะเบียนรถ</th>
                                    <th style="text-align: center">พนักงาน</th>
                                    <th style="text-align: center">จาก</th>
                                    <th style="text-align: center">ถึง</th>
                                    <th style="text-align: center">QT.</th>
                                    <th style="text-align: center">หน่วยละ</th>
                                    <th style="text-align: center">จำนวนเงิน</th>
                                    <th style="text-align: center;width: 100px">

                                      <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                    </th>

                                  </tr>

                                </thead>
                                <tbody>

                                </tbody>
                              </table>




                            </div>
                            <div id="datasr"></div>
                          </div>

                          <?php
                        } else if ($_GET['customercode'] == 'TTPROSTC') {
                          ?>



                          <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div id="datadef">
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">ลำดับ</th>
                                    <th style="text-align: center">วันที่</th>
                                    <th style="text-align: center">หมายเลข DO</th>
                                    <th style="text-align: center">ทะเบียนรถ</th>
                                    <th style="text-align: center">พนักงาน</th>
                                    <th style="text-align: center">จาก</th>
                                    <th style="text-align: center">ถึง</th>
                                    <th style="text-align: center">QT.</th>
                                    <th style="text-align: center">หน่วยละ</th>
                                    <th style="text-align: center">จำนวนเงิน</th>
                                    <th style="text-align: center;width: 100px">

                                      <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                    </th>

                                  </tr>

                                </thead>
                                <tbody>

                                </tbody>
                              </table>




                            </div>
                            <div id="datasr"></div>
                          </div>

                          <?php
                        } else if ($_GET['customercode'] == 'TTASTSTC') {
                          ?>



                          <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div id="datadef">
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">ลำดับ</th>
                                    <th style="text-align: center">วันที่</th>
                                    <th style="text-align: center">หมายเลข DO</th>
                                    <th style="text-align: center">ทะเบียนรถ</th>
                                    <th style="text-align: center">พนักงาน</th>
                                    <th style="text-align: center">จาก</th>
                                    <th style="text-align: center">ถึง</th>
                                    <th style="text-align: center">QT.</th>
                                    <th style="text-align: center">หน่วยละ</th>
                                    <th style="text-align: center">จำนวนเงิน</th>
                                    <th style="text-align: center;width: 100px">

                                      <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                    </th>

                                  </tr>

                                </thead>
                                <tbody>

                                </tbody>
                              </table>




                            </div>
                            <div id="datasr"></div>
                          </div>

                          <?php
                        } else if ($_GET['customercode'] == 'TTASTCS') {
                          ?>



                          <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div id="datadef">
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">ลำดับ</th>
                                    <th style="text-align: center">วันที่</th>
                                    <th style="text-align: center">หมายเลข DO</th>
                                    <th style="text-align: center">ทะเบียนรถ</th>
                                    <th style="text-align: center">พนักงาน</th>
                                    <th style="text-align: center">จาก</th>
                                    <th style="text-align: center">ถึง</th>
                                    <th style="text-align: center">QT.</th>
                                    <th style="text-align: center">หน่วยละ</th>
                                    <th style="text-align: center">จำนวนเงิน</th>
                                    <th style="text-align: center;width: 100px">

                                      <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                    </th>

                                  </tr>

                                </thead>
                                <tbody>

                                </tbody>
                              </table>




                            </div>
                            <div id="datasr"></div>
                          </div>

                          <?php
                        } else if ($_GET['customercode'] == 'TTTCSTC') {
                          ?>



                          <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div id="datadef">
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">ลำดับ</th>
                                    <th style="text-align: center">วันที่</th>
                                    <th style="text-align: center">หมายเลข DO</th>
                                    <th style="text-align: center">ทะเบียนรถ</th>
                                    <th style="text-align: center">พนักงาน</th>
                                    <th style="text-align: center">จาก</th>
                                    <th style="text-align: center">ถึง</th>
                                    <th style="text-align: center">QT.</th>
                                    <th style="text-align: center">หน่วยละ</th>
                                    <th style="text-align: center">จำนวนเงิน</th>
                                    <th style="text-align: center;width: 100px">

                                      <a href="#" data-toggle="modal" data-target="#modal_insinvoice">เพิ่มใบส่งสินค้า </a>

                                    </th>

                                  </tr>

                                </thead>
                                <tbody>

                                </tbody>
                              </table>




                            </div>
                            <div id="datasr"></div>
                          </div>

                          <?php
                        }
                      }
                    }
                    ?>
                    <!-- /.panel-body -->
                  </div>
                </div>
                <div class="tab-pane fade" id="invoice_detail">
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-lg-2">
                        <div class="form-group">
                          <label>ค้นหาตามช่วงวันที่</label>
                          <input class="form-control dateen" readonly="" onchange="datetodate();" style="background-color: #f080802e"  id="txt_datestartdetail" name="txt_datestartdetail" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">
                        </div>
                      </div>
                      <div class="col-lg-2">
                        <label>&nbsp;</label>
                        <div class="form-group">
                          <input type="text" class="form-control dateen"  readonly=""  style="background-color: #f080802e" id="txt_dateenddetail" name="txt_dateenddetail" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE']; ?>">
                        </div>
                      </div>

                      <div class="col-lg-2">
                        <label>&nbsp;</label>
                        <div class="form-group">
                          <button type="button" class="btn btn-default" onclick="select_invoicedetail();">ค้นหา <li class="fa fa-search"></li></button>
                        </div>
                      </div>




                    </div>
                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                      <div id="datadetaildef">
                        <?php
                        if ($_GET['companycode'] == 'RKS') {
                          if ($_GET['customercode'] == 'TAW') {
                            ?>
                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                              <thead>
                                <tr>
                                  <th style="text-align: center">No</th>
                                  <th style="text-align: center">D/M/Y</th>
                                  <th style="text-align: center">Invoicecode</th>
                                  <th style="text-align: center">จัดการ</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $i = 1;
                                $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RKS' AND a.CUSTOMERCODE = 'TAW'";
                                $condInvoice2 = "";

                                $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                $params_seInvoice = array(
                                  array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                  array($condInvoice1, SQLSRV_PARAM_IN),
                                  array($condInvoice2, SQLSRV_PARAM_IN)
                                );
                                $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                  ?>
                                  <tr>
                                    <td style="text-align: center"><?= $i ?></td>
                                    <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                    <td><?= $result_seInvoice['INVOICECODE'] ?></td>

                                    <td style="text-align: center">

                                      <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                      <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                    </td>
                                  </tr>
                                  <?php
                                  $i++;
                                }
                                ?>
                              </tbody>
                            </table>
                            <?php
                          } else if ($_GET['customercode'] == 'TGT') {
                            ?>
                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                              <thead>
                                <tr>
                                  <th style="text-align: center">No</th>
                                  <th style="text-align: center">D/M/Y</th>
                                  <th style="text-align: center">Invoicecode</th>
                                  <th style="text-align: center">จัดการ</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $i = 1;
                                $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RKS' AND a.CUSTOMERCODE = 'TGT'";
                                $condInvoice2 = "";

                                $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                $params_seInvoice = array(
                                  array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                  array($condInvoice1, SQLSRV_PARAM_IN),
                                  array($condInvoice2, SQLSRV_PARAM_IN)
                                );
                                $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                  ?>
                                  <tr>
                                    <td style="text-align: center"><?= $i ?></td>
                                    <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                    <td><?= $result_seInvoice['INVOICECODE'] ?></td>

                                    <td style="text-align: center">

                                      <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                      <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                    </td>
                                  </tr>
                                  <?php
                                  $i++;
                                }
                                ?>
                              </tbody>
                            </table>
                            <?php
                          } else if ($_GET['customercode'] == 'DENSO-THAI') {
                            ?>
                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                              <thead>
                                <tr>
                                  <th style="text-align: center">No</th>
                                  <th style="text-align: center">D/M/Y</th>
                                  <th style="text-align: center">Invoicecode</th>
                                  <th style="text-align: center">จัดการ</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $i = 1;
                                $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RKS' AND a.CUSTOMERCODE = 'DENSO-THAI'";
                                $condInvoice2 = "";

                                $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                $params_seInvoice = array(
                                  array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                  array($condInvoice1, SQLSRV_PARAM_IN),
                                  array($condInvoice2, SQLSRV_PARAM_IN)
                                );
                                $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                  ?>
                                  <tr>
                                    <td style="text-align: center"><?= $i ?></td>
                                    <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                    <td><?= $result_seInvoice['INVOICECODE'] ?></td>
                                    <td style="text-align: center">

                                      <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                      <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                    </td>
                                  </tr>
                                  <?php
                                  $i++;
                                }
                                ?>
                              </tbody>
                            </table>
                            <?php
                          } else if ($_GET['customercode'] == 'TMT') {
                            ?>
                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                              <thead>
                                <tr>
                                  <th style="text-align: center">No</th>
                                  <th style="text-align: center">D/M/Y</th>
                                  <th style="text-align: center">Invoicecode</th>
                                  <th style="text-align: center">จัดการ</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $i = 1;
                                $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RKS' AND a.CUSTOMERCODE = 'TMT'";
                                $condInvoice2 = "";

                                $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                $params_seInvoice = array(
                                  array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                  array($condInvoice1, SQLSRV_PARAM_IN),
                                  array($condInvoice2, SQLSRV_PARAM_IN)
                                );
                                $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                  ?>
                                  <tr>
                                    <td style="text-align: center"><?= $i ?></td>
                                    <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                    <td><?= $result_seInvoice['INVOICECODE'] ?></td>
                                    <td style="text-align: center">

                                      <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                      <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                    </td>
                                  </tr>
                                  <?php
                                  $i++;
                                }
                                ?>
                              </tbody>
                            </table>
                            <?php
                          } else if ($_GET['customercode'] == 'STM') {
                            ?>
                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                              <thead>
                                <tr>
                                  <th style="text-align: center">No</th>
                                  <th style="text-align: center">D/M/Y</th>
                                  <th style="text-align: center">Invoicecode</th>
                                  <th style="text-align: center">จัดการ</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $i = 1;

                                $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RKS' AND a.CUSTOMERCODE = 'STM'";
                                $condInvoice2 = "";

                                $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                $params_seInvoice = array(
                                  array('select_loginvoicestm', SQLSRV_PARAM_IN),
                                  array($condInvoice1, SQLSRV_PARAM_IN),
                                  array($condInvoice2, SQLSRV_PARAM_IN)
                                );
                                $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                  ?>
                                  <tr>
                                    <td style="text-align: center"><?= $i ?></td>
                                    <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                    <td><?= $result_seInvoice['INVOICECODE'] ?></td>
                                    <td style="text-align: center">

                                      <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                      <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                    </td>
                                  </tr>
                                  <?php
                                  $i++;
                                }
                                ?>
                              </tbody>
                            </table>
                            <?php
                          } else if ($_GET['customercode'] == 'DAIKI') {
                            ?>
                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                              <thead>
                                <tr>
                                  <th style="text-align: center">No</th>
                                  <th style="text-align: center">D/M/Y</th>
                                  <th style="text-align: center">Invoicecode</th>
                                  <th style="text-align: center">จัดการ</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $i = 1;
                                $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RKS' AND a.CUSTOMERCODE = 'DAIKI'";
                                $condInvoice2 = "";

                                $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                $params_seInvoice = array(
                                  array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                  array($condInvoice1, SQLSRV_PARAM_IN),
                                  array($condInvoice2, SQLSRV_PARAM_IN)
                                );
                                $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                  ?>
                                  <tr>
                                    <td style="text-align: center"><?= $i ?></td>
                                    <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                    <td><?= $result_seInvoice['INVOICECODE'] ?></td>
                                    <td style="text-align: center">

                                      <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                      <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                    </td>
                                  </tr>
                                  <?php
                                  $i++;
                                }
                                ?>
                              </tbody>
                            </table>
                            <?php
                          } else if ($_GET['customercode'] == 'GMT') {
                            ?>
                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                              <thead>
                                <tr>
                                  <th style="text-align: center">No</th>
                                  <th style="text-align: center">D/M/Y</th>
                                  <th style="text-align: center">Invoicecode</th>
                                  <th style="text-align: center">จัดการ</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $i = 1;
                                $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RKS' AND a.CUSTOMERCODE = 'GMT'";
                                $condInvoice2 = "";

                                $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                $params_seInvoice = array(
                                  array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                  array($condInvoice1, SQLSRV_PARAM_IN),
                                  array($condInvoice2, SQLSRV_PARAM_IN)
                                );
                                $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                  ?>
                                  <tr>
                                    <td style="text-align: center"><?= $i ?></td>
                                    <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                    <td><?= $result_seInvoice['INVOICECODE'] ?></td>
                                    <td style="text-align: center">

                                      <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                      <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                    </td>
                                  </tr>
                                  <?php
                                  $i++;
                                }
                                ?>
                              </tbody>
                            </table>
                            <?php
                          } else if ($_GET['customercode'] == 'TKT') {
                            ?>
                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                              <thead>
                                <tr>
                                  <th style="text-align: center">No</th>
                                  <th style="text-align: center">D/M/Y</th>
                                  <th style="text-align: center">Invoicecode</th>
                                  <th style="text-align: center">จัดการ</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $i = 1;
                                $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RKS' AND a.CUSTOMERCODE = 'TKT'";
                                $condInvoice2 = "";

                                $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                $params_seInvoice = array(
                                  array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                  array($condInvoice1, SQLSRV_PARAM_IN),
                                  array($condInvoice2, SQLSRV_PARAM_IN)
                                );
                                $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                  ?>
                                  <tr>
                                    <td style="text-align: center"><?= $i ?></td>
                                    <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                    <td><?= $result_seInvoice['INVOICECODE'] ?></td>
                                    <td style="text-align: center">

                                      <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                      <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                    </td>
                                  </tr>
                                  <?php
                                  $i++;
                                }
                                ?>
                              </tbody>
                            </table>
                            <?php
                          }
                        }
                        if ($_GET['companycode'] == 'RRC') {
                          if ($_GET['customercode'] == 'GMT') {
                            ?>
                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                              <thead>
                                <tr>
                                  <th style="text-align: center">No</th>
                                  <th style="text-align: center">D/M/Y</th>
                                  <th style="text-align: center">Invoicecode</th>
                                  <th style="text-align: center">จัดการ</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $i = 1;
                                $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RRC' AND a.CUSTOMERCODE = 'GMT'";
                                $condInvoice2 = "";

                                $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                $params_seInvoice = array(
                                  array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                  array($condInvoice1, SQLSRV_PARAM_IN),
                                  array($condInvoice2, SQLSRV_PARAM_IN)
                                );
                                $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                  ?>
                                  <tr>
                                    <td style="text-align: center"><?= $i ?></td>
                                    <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                    <td><?= $result_seInvoice['INVOICECODE'] ?></td>
                                    <td style="text-align: center">

                                      <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                      <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                    </td>
                                  </tr>
                                  <?php
                                  $i++;
                                }
                                ?>
                              </tbody>
                            </table>
                            <?php
                          } else if ($_GET['customercode'] == 'BP') {
                            ?>
                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                              <thead>
                                <tr>
                                  <th style="text-align: center">No</th>
                                  <th style="text-align: center">D/M/Y</th>
                                  <th style="text-align: center">Invoicecode</th>
                                  <th style="text-align: center">จัดการ</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $i = 1;
                                $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RRC' AND a.CUSTOMERCODE = 'BP'";
                                $condInvoice2 = "";

                                $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                $params_seInvoice = array(
                                  array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                  array($condInvoice1, SQLSRV_PARAM_IN),
                                  array($condInvoice2, SQLSRV_PARAM_IN)
                                );
                                $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                  ?>
                                  <tr>
                                    <td style="text-align: center"><?= $i ?></td>
                                    <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                    <td><?= $result_seInvoice['INVOICECODE'] ?></td>
                                    <td style="text-align: center">

                                      <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                      <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                    </td>
                                  </tr>
                                  <?php
                                  $i++;
                                }
                                ?>
                              </tbody>
                            </table>
                            <?php
                          } else if ($_GET['customercode'] == 'TTAST') {
                            ?>
                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                              <thead>
                                <tr>
                                  <th style="text-align: center">No</th>
                                  <th style="text-align: center">D/M/Y</th>
                                  <th style="text-align: center">Invoicecode</th>
                                  <th style="text-align: center">จัดการ</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $i = 1;
                                $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RRC' AND a.CUSTOMERCODE = 'TTAST'";
                                $condInvoice2 = "";

                                $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                $params_seInvoice = array(
                                  array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                  array($condInvoice1, SQLSRV_PARAM_IN),
                                  array($condInvoice2, SQLSRV_PARAM_IN)
                                );
                                $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                  ?>
                                  <tr>
                                    <td style="text-align: center"><?= $i ?></td>
                                    <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                    <td><?= $result_seInvoice['INVOICECODE'] ?></td>
                                    <td style="text-align: center">

                                      <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                      <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                    </td>
                                  </tr>
                                  <?php
                                  $i++;
                                }
                                ?>
                              </tbody>
                            </table>
                            <?php
                          }
                        } else if ($_GET['companycode'] == 'RKR') {
                          if ($_GET['carrytype'] == 'trip') {
                            if ($_GET['customercode'] == 'DAIKI') {
                              ?>
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">No</th>
                                    <th style="text-align: center">D/M/Y</th>
                                    <th style="text-align: center">Invoicecode</th>
                                    <th style="text-align: center">จัดการ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $i = 1;
                                  $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RKR' AND a.CUSTOMERCODE = 'DAIKI'";
                                  $condInvoice2 = "";

                                  $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                  $params_seInvoice = array(
                                    array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                    array($condInvoice1, SQLSRV_PARAM_IN),
                                    array($condInvoice2, SQLSRV_PARAM_IN)
                                  );
                                  $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                  while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                      <td style="text-align: center"><?= $i ?></td>
                                      <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                      <td><?= $result_seInvoice['INVOICECODE'] ?></td>
                                      <td style="text-align: center">

                                        <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                        <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                      </td>
                                    </tr>
                                    <?php
                                    $i++;
                                  }
                                  ?>
                                </tbody>
                              </table>
                              <?php
                            } else if ($_GET['customercode'] == 'TTPRO') {
                              ?>
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">No</th>
                                    <th style="text-align: center">D/M/Y</th>
                                    <th style="text-align: center">Invoicecode</th>
                                    <th style="text-align: center">จัดการ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $i = 1;
                                  $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RKR' AND a.CUSTOMERCODE = 'TTPRO'";
                                  $condInvoice2 = "";

                                  $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                  $params_seInvoice = array(
                                    array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                    array($condInvoice1, SQLSRV_PARAM_IN),
                                    array($condInvoice2, SQLSRV_PARAM_IN)
                                  );
                                  $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                  while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                      <td style="text-align: center"><?= $i ?></td>
                                      <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                      <td><?= $result_seInvoice['INVOICECODE'] ?></td>
                                      <td style="text-align: center">

                                        <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                        <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                      </td>
                                    </tr>
                                    <?php
                                    $i++;
                                  }
                                  ?>
                                </tbody>
                              </table>
                              <?php
                            } else if ($_GET['customercode'] == 'TTAST') {
                              ?>
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">No</th>
                                    <th style="text-align: center">D/M/Y</th>
                                    <th style="text-align: center">Invoicecode</th>
                                    <th style="text-align: center">จัดการ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $i = 1;
                                  $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RKR' AND a.CUSTOMERCODE = 'TTAST'";
                                  $condInvoice2 = "";

                                  $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                  $params_seInvoice = array(
                                    array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                    array($condInvoice1, SQLSRV_PARAM_IN),
                                    array($condInvoice2, SQLSRV_PARAM_IN)
                                  );
                                  $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                  while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                      <td style="text-align: center"><?= $i ?></td>
                                      <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                      <td><?= $result_seInvoice['INVOICECODE'] ?></td>
                                      <td style="text-align: center">

                                        <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                        <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                      </td>
                                    </tr>
                                    <?php
                                    $i++;
                                  }
                                  ?>
                                </tbody>
                              </table>
                              <?php
                            } else if ($_GET['customercode'] == 'TTAT') {
                              ?>
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">No</th>
                                    <th style="text-align: center">D/M/Y</th>
                                    <th style="text-align: center">Invoicecode</th>
                                    <th style="text-align: center">จัดการ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $i = 1;
                                  $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RKR' AND a.CUSTOMERCODE = 'TTAT'";
                                  $condInvoice2 = "";

                                  $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                  $params_seInvoice = array(
                                    array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                    array($condInvoice1, SQLSRV_PARAM_IN),
                                    array($condInvoice2, SQLSRV_PARAM_IN)
                                  );
                                  $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                  while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                      <td style="text-align: center"><?= $i ?></td>
                                      <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                      <td><?= $result_seInvoice['INVOICECODE'] ?></td>
                                      <td style="text-align: center">

                                        <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                        <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                      </td>
                                    </tr>
                                    <?php
                                    $i++;
                                  }
                                  ?>
                                </tbody>
                              </table>
                              <?php
                            } else if ($_GET['customercode'] == 'TMT') {
                              ?>
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">No</th>
                                    <th style="text-align: center">D/M/Y</th>
                                    <th style="text-align: center">Invoicecode</th>
                                    <th style="text-align: center">จัดการ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $i = 1;
                                  $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RKR' AND a.CUSTOMERCODE = 'TMT'";
                                  $condInvoice2 = "";

                                  $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                  $params_seInvoice = array(
                                    array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                    array($condInvoice1, SQLSRV_PARAM_IN),
                                    array($condInvoice2, SQLSRV_PARAM_IN)
                                  );
                                  $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                  while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                      <td style="text-align: center"><?= $i ?></td>
                                      <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                      <td><?= $result_seInvoice['INVOICECODE'] ?></td>
                                      <td style="text-align: center">

                                        <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                        <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                      </td>
                                    </tr>
                                    <?php
                                    $i++;
                                  }
                                  ?>
                                </tbody>
                              </table>
                              <?php
                            } else if ($_GET['customercode'] == 'TGT') {
                              ?>
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">No</th>
                                    <th style="text-align: center">D/M/Y</th>
                                    <th style="text-align: center">Invoicecode</th>
                                    <th style="text-align: center">จัดการ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $i = 1;
                                  $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RKR' AND a.CUSTOMERCODE = 'TGT'";
                                  $condInvoice2 = "";

                                  $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                  $params_seInvoice = array(
                                    array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                    array($condInvoice1, SQLSRV_PARAM_IN),
                                    array($condInvoice2, SQLSRV_PARAM_IN)
                                  );
                                  $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                  while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                      <td style="text-align: center"><?= $i ?></td>
                                      <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                      <td><?= $result_seInvoice['INVOICECODE'] ?></td>
                                      <td style="text-align: center">

                                        <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                        <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                      </td>
                                    </tr>
                                    <?php
                                    $i++;
                                  }
                                  ?>
                                </tbody>
                              </table>
                              <?php
                            } else if ($_GET['customercode'] == 'YNP') {
                              ?>
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">No</th>
                                    <th style="text-align: center">D/M/Y</th>
                                    <th style="text-align: center">Invoicecode</th>
                                    <th style="text-align: center">จัดการ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $i = 1;
                                  $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RKR' AND a.CUSTOMERCODE = 'YNP'";
                                  $condInvoice2 = "";

                                  $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                  $params_seInvoice = array(
                                    array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                    array($condInvoice1, SQLSRV_PARAM_IN),
                                    array($condInvoice2, SQLSRV_PARAM_IN)
                                  );
                                  $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                  while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                      <td style="text-align: center"><?= $i ?></td>
                                      <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                      <td><?= $result_seInvoice['INVOICECODE'] ?></td>
                                      <td style="text-align: center">

                                        <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                        <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                      </td>
                                    </tr>
                                    <?php
                                    $i++;
                                  }
                                  ?>
                                </tbody>
                              </table>
                              <?php
                            } else if ($_GET['customercode'] == 'GMT') {
                              ?>
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">No</th>
                                    <th style="text-align: center">D/M/Y</th>
                                    <th style="text-align: center">Invoicecode</th>
                                    <th style="text-align: center">จัดการ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $i = 1;
                                  $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RKR' AND a.CUSTOMERCODE = 'GMT'";
                                  $condInvoice2 = "";

                                  $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                  $params_seInvoice = array(
                                    array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                    array($condInvoice1, SQLSRV_PARAM_IN),
                                    array($condInvoice2, SQLSRV_PARAM_IN)
                                  );
                                  $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                  while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                      <td style="text-align: center"><?= $i ?></td>
                                      <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                      <td><?= $result_seInvoice['INVOICECODE'] ?></td>
                                      <td style="text-align: center">

                                        <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                        <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                      </td>
                                    </tr>
                                    <?php
                                    $i++;
                                  }
                                  ?>
                                </tbody>
                              </table>
                              <?php
                            }
                          } else if ($_GET['carrytype'] == 'weight') {
                            if ($_GET['customercode'] == 'TTPROSTC') {
                              ?>
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">No</th>
                                    <th style="text-align: center">D/M/Y</th>
                                    <th style="text-align: center">Invoicecode</th>
                                    <th style="text-align: center">จัดการ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $i = 1;
                                  $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RKR' AND a.CUSTOMERCODE = 'TTPROSTC'";
                                  $condInvoice2 = "";

                                  $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                  $params_seInvoice = array(
                                    array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                    array($condInvoice1, SQLSRV_PARAM_IN),
                                    array($condInvoice2, SQLSRV_PARAM_IN)
                                  );
                                  $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                  while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                      <td style="text-align: center"><?= $i ?></td>
                                      <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                      <td><?= $result_seInvoice['INVOICECODE'] ?></td>
                                      <td style="text-align: center">

                                        <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                        <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                      </td>
                                    </tr>
                                    <?php
                                    $i++;
                                  }
                                  ?>
                                </tbody>
                              </table>
                              <?php
                            } else if ($_GET['customercode'] == 'TTASTSTC') {
                              ?>
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">No</th>
                                    <th style="text-align: center">D/M/Y</th>
                                    <th style="text-align: center">Invoicecode</th>
                                    <th style="text-align: center">จัดการ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $i = 1;
                                  $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RKR' AND a.CUSTOMERCODE = 'TTASTSTC'";
                                  $condInvoice2 = "";

                                  $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                  $params_seInvoice = array(
                                    array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                    array($condInvoice1, SQLSRV_PARAM_IN),
                                    array($condInvoice2, SQLSRV_PARAM_IN)
                                  );
                                  $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                  while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                      <td style="text-align: center"><?= $i ?></td>
                                      <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                      <td><?= $result_seInvoice['INVOICECODE'] ?></td>
                                      <td style="text-align: center">
                                        <button onclick="excel_billingrkrttaststcpallet('<?= $result_seInvoice['INVOICECODE'] ?>');" title="Excel" type="button" class="btn btn-default btn-circle"><span class="fa fa-file-excel-o"></span></button>
                                        <button onclick="pdf_billingrkrttaststcpallet('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                        <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                      </td>
                                    </tr>
                                    <?php
                                    $i++;
                                  }
                                  ?>
                                </tbody>
                              </table>
                              <?php
                            } else if ($_GET['customercode'] == 'TTASTCS') {
                              ?>
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">No</th>
                                    <th style="text-align: center">D/M/Y</th>
                                    <th style="text-align: center">Invoicecode</th>
                                    <th style="text-align: center">จัดการ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $i = 1;
                                  $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RKR' AND a.CUSTOMERCODE = 'TTASTCS'";
                                  $condInvoice2 = "";

                                  $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                  $params_seInvoice = array(
                                    array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                    array($condInvoice1, SQLSRV_PARAM_IN),
                                    array($condInvoice2, SQLSRV_PARAM_IN)
                                  );
                                  $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                  while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                      <td style="text-align: center"><?= $i ?></td>
                                      <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                      <td><?= $result_seInvoice['INVOICECODE'] ?></td>
                                      <td style="text-align: center">

                                        <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                        <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                      </td>
                                    </tr>
                                    <?php
                                    $i++;
                                  }
                                  ?>
                                </tbody>
                              </table>
                              <?php
                            } else if ($_GET['customercode'] == 'DAIKI') {
                              ?>
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">No</th>
                                    <th style="text-align: center">D/M/Y</th>
                                    <th style="text-align: center">Invoicecode</th>
                                    <th style="text-align: center">จัดการ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $i = 1;
                                  $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RKR' AND a.CUSTOMERCODE = 'DAIKI' AND '" . $_GET['carrytype'] . "' = 'weight'";
                                  $condInvoice2 = "";

                                  $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                  $params_seInvoice = array(
                                    array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                    array($condInvoice1, SQLSRV_PARAM_IN),
                                    array($condInvoice2, SQLSRV_PARAM_IN)
                                  );
                                  $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                  while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                      <td style="text-align: center"><?= $i ?></td>
                                      <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                      <td><?= $result_seInvoice['INVOICECODE'] ?></td>
                                      <td style="text-align: center">

                                        <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                        <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                      </td>
                                    </tr>
                                    <?php
                                    $i++;
                                  }
                                  ?>
                                </tbody>
                              </table>
                              <?php
                            }
                          }
                        } else if ($_GET['companycode'] == 'RKL') {
                          if ($_GET['carrytype'] == 'trip') {
                            if ($_GET['customercode'] == 'SKB') {
                              ?>
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">No</th>
                                    <th style="text-align: center">D/M/Y</th>
                                    <th style="text-align: center">Invoicecode</th>
                                    <th style="text-align: center">จัดการ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $i = 1;
                                  $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RKL' AND a.CUSTOMERCODE = 'SKB'";
                                  $condInvoice2 = "";

                                  $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                  $params_seInvoice = array(
                                    array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                    array($condInvoice1, SQLSRV_PARAM_IN),
                                    array($condInvoice2, SQLSRV_PARAM_IN)
                                  );
                                  $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                  while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                      <td style="text-align: center"><?= $i ?></td>
                                      <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                      <td><?= $result_seInvoice['INVOICECODE'] ?></td>
                                      <td style="text-align: center">

                                        <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                        <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                      </td>
                                    </tr>
                                    <?php
                                    $i++;
                                  }
                                  ?>
                                </tbody>
                              </table>
                              <?php
                            } else if ($_GET['customercode'] == 'TTTC') {
                              ?>
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">No</th>
                                    <th style="text-align: center">D/M/Y</th>
                                    <th style="text-align: center">Invoicecode</th>
                                    <th style="text-align: center">จัดการ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $i = 1;
                                  $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RKL' AND a.CUSTOMERCODE = 'TTTC'";
                                  $condInvoice2 = "";

                                  $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                  $params_seInvoice = array(
                                    array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                    array($condInvoice1, SQLSRV_PARAM_IN),
                                    array($condInvoice2, SQLSRV_PARAM_IN)
                                  );
                                  $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                  while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                      <td style="text-align: center"><?= $i ?></td>
                                      <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                      <td><?= $result_seInvoice['INVOICECODE'] ?></td>
                                      <td style="text-align: center">

                                        <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                        <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                      </td>
                                    </tr>
                                    <?php
                                    $i++;
                                  }
                                  ?>
                                </tbody>
                              </table>
                              <?php
                            } else if ($_GET['customercode'] == 'CH-AUTO') {
                              ?>
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">No</th>
                                    <th style="text-align: center">D/M/Y</th>
                                    <th style="text-align: center">Invoicecode</th>
                                    <th style="text-align: center">จัดการ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $i = 1;
                                  $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RKL' AND a.CUSTOMERCODE = 'CH-AUTO'";
                                  $condInvoice2 = "";

                                  $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                  $params_seInvoice = array(
                                    array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                    array($condInvoice1, SQLSRV_PARAM_IN),
                                    array($condInvoice2, SQLSRV_PARAM_IN)
                                  );
                                  $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                  while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                      <td style="text-align: center"><?= $i ?></td>
                                      <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                      <td><?= $result_seInvoice['INVOICECODE'] ?></td>
                                      <td style="text-align: center">

                                        <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                        <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                      </td>
                                    </tr>
                                    <?php
                                    $i++;
                                  }
                                  ?>
                                </tbody>
                              </table>
                              <?php
                            } else if ($_GET['customercode'] == 'TTAT') {
                              ?>
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">No</th>
                                    <th style="text-align: center">D/M/Y</th>
                                    <th style="text-align: center">Invoicecode</th>
                                    <th style="text-align: center">จัดการ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $i = 1;
                                  $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RKL' AND a.CUSTOMERCODE = 'TTAT'";
                                  $condInvoice2 = "";

                                  $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                  $params_seInvoice = array(
                                    array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                    array($condInvoice1, SQLSRV_PARAM_IN),
                                    array($condInvoice2, SQLSRV_PARAM_IN)
                                  );
                                  $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                  while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                      <td style="text-align: center"><?= $i ?></td>
                                      <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                      <td><?= $result_seInvoice['INVOICECODE'] ?></td>
                                      <td style="text-align: center">

                                        <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                        <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                      </td>
                                    </tr>
                                    <?php
                                    $i++;
                                  }
                                  ?>
                                </tbody>
                              </table>
                              <?php
                            } else if ($_GET['customercode'] == 'TKT') {
                              ?>
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">No</th>
                                    <th style="text-align: center">D/M/Y</th>
                                    <th style="text-align: center">Invoicecode</th>
                                    <th style="text-align: center">จัดการ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $i = 1;
                                  $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RKL' AND a.CUSTOMERCODE = 'TKT'";
                                  $condInvoice2 = "";

                                  $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                  $params_seInvoice = array(
                                    array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                    array($condInvoice1, SQLSRV_PARAM_IN),
                                    array($condInvoice2, SQLSRV_PARAM_IN)
                                  );
                                  $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                  while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                      <td style="text-align: center"><?= $i ?></td>
                                      <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                      <td><?= $result_seInvoice['INVOICECODE'] ?></td>
                                      <td style="text-align: center">

                                        <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                        <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                      </td>
                                    </tr>
                                    <?php
                                    $i++;
                                  }
                                  ?>
                                </tbody>
                              </table>
                              <?php
                            } else if ($_GET['customercode'] == 'TSAT') {
                              ?>
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">No</th>
                                    <th style="text-align: center">D/M/Y</th>
                                    <th style="text-align: center">Invoicecode</th>
                                    <th style="text-align: center">จัดการ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $i = 1;
                                  $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RKL' AND a.CUSTOMERCODE = 'TSAT'";
                                  $condInvoice2 = "";

                                  $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                  $params_seInvoice = array(
                                    array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                    array($condInvoice1, SQLSRV_PARAM_IN),
                                    array($condInvoice2, SQLSRV_PARAM_IN)
                                  );
                                  $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                  while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                      <td style="text-align: center"><?= $i ?></td>
                                      <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                      <td><?= $result_seInvoice['INVOICECODE'] ?></td>
                                      <td style="text-align: center">

                                        <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                        <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                      </td>
                                    </tr>
                                    <?php
                                    $i++;
                                  }
                                  ?>
                                </tbody>
                              </table>
                              <?php
                            } else if ($_GET['customercode'] == 'YNP') {
                              ?>
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">No</th>
                                    <th style="text-align: center">D/M/Y</th>
                                    <th style="text-align: center">Invoicecode</th>
                                    <th style="text-align: center">จัดการ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $i = 1;
                                  $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RKL' AND a.CUSTOMERCODE = 'YNP'";
                                  $condInvoice2 = "";

                                  $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                  $params_seInvoice = array(
                                    array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                    array($condInvoice1, SQLSRV_PARAM_IN),
                                    array($condInvoice2, SQLSRV_PARAM_IN)
                                  );
                                  $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                  while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                      <td style="text-align: center"><?= $i ?></td>
                                      <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                      <td><?= $result_seInvoice['INVOICECODE'] ?></td>
                                      <td style="text-align: center">

                                        <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                        <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                      </td>
                                    </tr>
                                    <?php
                                    $i++;
                                  }
                                  ?>
                                </tbody>
                              </table>
                              <?php
                            } else if ($_GET['customercode'] == 'WSBT') {
                              ?>
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">No</th>
                                    <th style="text-align: center">D/M/Y</th>
                                    <th style="text-align: center">Invoicecode</th>
                                    <th style="text-align: center">จัดการ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $i = 1;
                                  $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RKL' AND a.CUSTOMERCODE = 'WSBT'";
                                  $condInvoice2 = "";

                                  $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                  $params_seInvoice = array(
                                    array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                    array($condInvoice1, SQLSRV_PARAM_IN),
                                    array($condInvoice2, SQLSRV_PARAM_IN)
                                  );
                                  $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                  while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                      <td style="text-align: center"><?= $i ?></td>
                                      <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                      <td><?= $result_seInvoice['INVOICECODE'] ?></td>
                                      <td style="text-align: center">

                                        <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                        <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                      </td>
                                    </tr>
                                    <?php
                                    $i++;
                                  }
                                  ?>
                                </tbody>
                              </table>
                              <?php
                            } else if ($_GET['customercode'] == 'TMT') {
                              ?>
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">No</th>
                                    <th style="text-align: center">D/M/Y</th>
                                    <th style="text-align: center">Invoicecode</th>
                                    <th style="text-align: center">จัดการ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $i = 1;
                                  $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RKL' AND a.CUSTOMERCODE = 'TMT'";
                                  $condInvoice2 = "";

                                  $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                  $params_seInvoice = array(
                                    array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                    array($condInvoice1, SQLSRV_PARAM_IN),
                                    array($condInvoice2, SQLSRV_PARAM_IN)
                                  );
                                  $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                  while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                      <td style="text-align: center"><?= $i ?></td>
                                      <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                      <td><?= $result_seInvoice['INVOICECODE'] ?></td>
                                      <td style="text-align: center">

                                        <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                        <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                      </td>
                                    </tr>
                                    <?php
                                    $i++;
                                  }
                                  ?>
                                </tbody>
                              </table>
                              <?php
                            } else if ($_GET['customercode'] == 'NITTSUSHOJI') {
                              ?>
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">No</th>
                                    <th style="text-align: center">D/M/Y</th>
                                    <th style="text-align: center">Invoicecode</th>
                                    <th style="text-align: center">จัดการ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $i = 1;
                                  $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RKL' AND a.CUSTOMERCODE = 'NITTSUSHOJI'";
                                  $condInvoice2 = "";

                                  $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                  $params_seInvoice = array(
                                    array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                    array($condInvoice1, SQLSRV_PARAM_IN),
                                    array($condInvoice2, SQLSRV_PARAM_IN)
                                  );
                                  $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                  while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                      <td style="text-align: center"><?= $i ?></td>
                                      <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                      <td><?= $result_seInvoice['INVOICECODE'] ?></td>
                                      <td style="text-align: center">

                                        <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                        <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                      </td>
                                    </tr>
                                    <?php
                                    $i++;
                                  }
                                  ?>
                                </tbody>
                              </table>
                              <?php
                            }
                          } else if ($_GET['carrytype'] == 'weight') {
                            if ($_GET['customercode'] == 'DAIKI') {
                              ?>
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">No</th>
                                    <th style="text-align: center">D/M/Y</th>
                                    <th style="text-align: center">Invoicecode</th>
                                    <th style="text-align: center">จัดการ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $i = 1;
                                  $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RKL' AND a.CUSTOMERCODE = 'DAIKI'";
                                  $condInvoice2 = "";

                                  $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                  $params_seInvoice = array(
                                    array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                    array($condInvoice1, SQLSRV_PARAM_IN),
                                    array($condInvoice2, SQLSRV_PARAM_IN)
                                  );
                                  $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                  while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                      <td style="text-align: center"><?= $i ?></td>
                                      <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                      <td><?= $result_seInvoice['INVOICECODE'] ?></td>
                                      <td style="text-align: center">

                                        <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                        <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                      </td>
                                    </tr>
                                    <?php
                                    $i++;
                                  }
                                  ?>
                                </tbody>
                              </table>
                              <?php
                            } else if ($_GET['customercode'] == 'TTPROSTC') {
                              ?>
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">No</th>
                                    <th style="text-align: center">D/M/Y</th>
                                    <th style="text-align: center">Invoicecode</th>
                                    <th style="text-align: center">จัดการ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $i = 1;
                                  $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RKL' AND a.CUSTOMERCODE = 'TTPROSTC'";
                                  $condInvoice2 = "";

                                  $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                  $params_seInvoice = array(
                                    array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                    array($condInvoice1, SQLSRV_PARAM_IN),
                                    array($condInvoice2, SQLSRV_PARAM_IN)
                                  );
                                  $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                  while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                      <td style="text-align: center"><?= $i ?></td>
                                      <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                      <td><?= $result_seInvoice['INVOICECODE'] ?></td>
                                      <td style="text-align: center">

                                        <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                        <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                      </td>
                                    </tr>
                                    <?php
                                    $i++;
                                  }
                                  ?>
                                </tbody>
                              </table>
                              <?php
                            } else if ($_GET['customercode'] == 'TTASTSTC') {
                              ?>
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">No</th>
                                    <th style="text-align: center">D/M/Y</th>
                                    <th style="text-align: center">Invoicecode</th>
                                    <th style="text-align: center">จัดการ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $i = 1;
                                  $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RKL' AND a.CUSTOMERCODE = 'TTASTSTC'";
                                  $condInvoice2 = "";

                                  $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                  $params_seInvoice = array(
                                    array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                    array($condInvoice1, SQLSRV_PARAM_IN),
                                    array($condInvoice2, SQLSRV_PARAM_IN)
                                  );
                                  $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                  while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                      <td style="text-align: center"><?= $i ?></td>
                                      <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                      <td><?= $result_seInvoice['INVOICECODE'] ?></td>
                                      <td style="text-align: center">

                                        <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                        <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                      </td>
                                    </tr>
                                    <?php
                                    $i++;
                                  }
                                  ?>
                                </tbody>
                              </table>
                              <?php
                            } else if ($_GET['customercode'] == 'TTASTCS') {
                              ?>
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">No</th>
                                    <th style="text-align: center">D/M/Y</th>
                                    <th style="text-align: center">Invoicecode</th>
                                    <th style="text-align: center">จัดการ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $i = 1;
                                  $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RKL' AND a.CUSTOMERCODE = 'TTASTCS'";
                                  $condInvoice2 = "";

                                  $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                  $params_seInvoice = array(
                                    array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                    array($condInvoice1, SQLSRV_PARAM_IN),
                                    array($condInvoice2, SQLSRV_PARAM_IN)
                                  );
                                  $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                  while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                      <td style="text-align: center"><?= $i ?></td>
                                      <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                      <td><?= $result_seInvoice['INVOICECODE'] ?></td>
                                      <td style="text-align: center">

                                        <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                        <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                      </td>
                                    </tr>
                                    <?php
                                    $i++;
                                  }
                                  ?>
                                </tbody>
                              </table>
                              <?php
                            } else if ($_GET['customercode'] == 'TTTCSTC') {
                              ?>
                              <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="text-align: center">No</th>
                                    <th style="text-align: center">D/M/Y</th>
                                    <th style="text-align: center">Invoicecode</th>
                                    <th style="text-align: center">จัดการ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $i = 1;
                                  $condInvoice1 = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE()) AND a.COMPANYCODE = 'RKL' AND a.CUSTOMERCODE = 'TTTCSTC'";
                                  $condInvoice2 = "";

                                  $sql_seInvoice = "{call megLoginvoice_v2(?,?,?)}";
                                  $params_seInvoice = array(
                                    array('select_loginvoicedist', SQLSRV_PARAM_IN),
                                    array($condInvoice1, SQLSRV_PARAM_IN),
                                    array($condInvoice2, SQLSRV_PARAM_IN)
                                  );
                                  $query_seInvoice = sqlsrv_query($conn, $sql_seInvoice, $params_seInvoice);
                                  while ($result_seInvoice = sqlsrv_fetch_array($query_seInvoice, SQLSRV_FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                      <td style="text-align: center"><?= $i ?></td>
                                      <td><?= $result_seInvoice['CREATEDATE'] ?></td>
                                      <td><?= $result_seInvoice['INVOICECODE'] ?></td>
                                      <td style="text-align: center">

                                        <button onclick="pdf_invoicerkstgt2('<?= $result_seInvoice['INVOICECODE'] ?>', '<?= $result_seInvoice['TRANSPORTATION'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span></button>
                                        <button onclick="delete_invoice('<?= $result_seInvoice['INVOICECODE'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                      </td>
                                    </tr>
                                    <?php
                                    $i++;
                                  }
                                  ?>
                                </tbody>
                              </table>
                              <?php
                            }
                          }
                        }
                        ?>

                      </div>
                      <div id="datadetailsr"></div>
                    </div>
                    <!-- /.panel-body -->
                  </div>
                </div>
                <div class="tab-pane fade" id="invoice_unlock">
                  <div class="panel-body">


                    <div class="row">
                      <div class="col-lg-2">

                        <div class="form-group">
                          <label>ค้นหาตามช่วงวันที่</label>
                          <input class="form-control dateen" readonly="" onchange="datetodate();" style="background-color: #f080802e"  id="txt_datestartunlock" name="txt_datestartunlock" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">

                        </div>

                      </div>
                      <div class="col-lg-2">
                        <label>&nbsp;</label>
                        <div class="form-group">
                          <input type="text" class="form-control dateen"  readonly=""  style="background-color: #f080802e" id="txt_dateendunlock" name="txt_dateendunlock" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE']; ?>">

                        </div>
                      </div>
                      <?php
                      if ($_GET['companycode'] == 'RRC') {
                        if ($_GET['customercode'] == 'GMT' || $_GET['customercode'] == 'BP') {
                          ?>
                          <div class="col-lg-2">
                            <label>&nbsp;</label>
                            <div class="form-group">
                              <select id="cb_materialtypeunlock" name="cb_materialtypeunlock" class="form-control"  title="เลือกประเภทวัสดุ..." >

                                <option value="">ไม่ระบุแผนก</option>
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
                          </div>
                          <?php
                        }
                      }
                      ?>
                      <div class="col-lg-2">
                        <label>&nbsp;</label>
                        <div class="form-group">
                          <button type="button" class="btn btn-default" onclick="select_invoiceunlock();">ค้นหา <li class="fa fa-search"></li></button>
                        </div>

                      </div>



                    </div>
                    <?php
                    if ($_GET['companycode'] == 'RKS') {
                      if ($_GET['customercode'] == 'TAW') {
                        ?>
                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                          <div id="datadefunlock">

                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                              <thead>
                                <tr>
                                  <th style="text-align: center">No.</th>
                                  <th style="text-align: center">Document</th>
                                  <th style="text-align: center">D/M/Y</th>
                                  <th style="text-align: center">Driver</th>

                                  <th style="text-align: center;">

                                    ปลดล็อค

                                  </th>

                                </tr>

                              </thead>
                              <tbody>
                                <?php
                                $i = 1;
                                $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                                $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

                                $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                                $params_seBilling = array(
                                  array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                                  array($condBilling1, SQLSRV_PARAM_IN),
                                  array($condBilling2, SQLSRV_PARAM_IN)
                                );


                                $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                                while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                                  $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                                  $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                                  $params_seEmployeeehr = array(
                                    array('select_employeeehr2', SQLSRV_PARAM_IN),
                                    array($condEmployeeehr1, SQLSRV_PARAM_IN)
                                  );
                                  $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                                  $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                                  ?>
                                  <tr>
                                    <td style="text-align: center"><?= $i ?></td>
                                    <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                                    <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                                    <td><?= $result_seEmployeeehr['nameT'] ?></td>
                                    <td style="text-align: center">
                                      <?php
                                      if ($result_seBilling['BILLINGSTATUS'] == '1') {
                                        ?>
                                        <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                                        <?php
                                      }
                                      ?>

                                    </td>


                                  </tr>
                                  <?php
                                  $i++;
                                }
                                ?>
                              </tbody>


                            </table>



                          </div>
                          <div id="datasrunlock"></div>
                        </div>
                        <?php
                      } else if ($_GET['customercode'] == 'TGT') {
                        ?>
                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                          <div id="datadefunlock">

                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                              <thead>
                                <tr>
                                  <th style="text-align: center">No.</th>
                                  <th style="text-align: center">Document</th>
                                  <th style="text-align: center">D/M/Y</th>
                                  <th style="text-align: center">Driver</th>

                                  <th style="text-align: center;">

                                    ปลดล็อค

                                  </th>

                                </tr>

                              </thead>
                              <tbody>
                                <?php
                                $i = 1;
                                $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                                $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

                                $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                                $params_seBilling = array(
                                  array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                                  array($condBilling1, SQLSRV_PARAM_IN),
                                  array($condBilling2, SQLSRV_PARAM_IN)
                                );


                                $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                                while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                                  $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                                  $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                                  $params_seEmployeeehr = array(
                                    array('select_employeeehr2', SQLSRV_PARAM_IN),
                                    array($condEmployeeehr1, SQLSRV_PARAM_IN)
                                  );
                                  $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                                  $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                                  ?>
                                  <tr>
                                    <td style="text-align: center"><?= $i ?></td>
                                    <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                                    <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                                    <td><?= $result_seEmployeeehr['nameT'] ?></td>
                                    <td style="text-align: center">
                                      <?php
                                      if ($result_seBilling['BILLINGSTATUS'] == '1') {
                                        ?>
                                        <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                                        <?php
                                      }
                                      ?>

                                    </td>


                                  </tr>
                                  <?php
                                  $i++;
                                }
                                ?>
                              </tbody>


                            </table>



                          </div>
                          <div id="datasrunlock"></div>
                        </div>
                        <?php
                      } else if ($_GET['customercode'] == 'DENSO-THAI') {
                        ?>
                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                          <div id="datadefunlock">

                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                              <thead>
                                <tr>
                                  <th style="text-align: center">No.</th>
                                  <th style="text-align: center">Document</th>
                                  <th style="text-align: center">D/M/Y</th>
                                  <th style="text-align: center">Driver</th>

                                  <th style="text-align: center;">

                                    ปลดล็อค

                                  </th>

                                </tr>

                              </thead>
                              <tbody>
                                <?php
                                $i = 1;
                                $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                                $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

                                $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                                $params_seBilling = array(
                                  array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                                  array($condBilling1, SQLSRV_PARAM_IN),
                                  array($condBilling2, SQLSRV_PARAM_IN)
                                );


                                $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                                while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                                  $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                                  $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                                  $params_seEmployeeehr = array(
                                    array('select_employeeehr2', SQLSRV_PARAM_IN),
                                    array($condEmployeeehr1, SQLSRV_PARAM_IN)
                                  );
                                  $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                                  $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                                  ?>
                                  <tr>
                                    <td style="text-align: center"><?= $i ?></td>
                                    <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                                    <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                                    <td><?= $result_seEmployeeehr['nameT'] ?></td>
                                    <td style="text-align: center">
                                      <?php
                                      if ($result_seBilling['BILLINGSTATUS'] == '1') {
                                        ?>
                                        <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                                        <?php
                                      }
                                      ?>

                                    </td>


                                  </tr>
                                  <?php
                                  $i++;
                                }
                                ?>
                              </tbody>


                            </table>



                          </div>
                          <div id="datasrunlock"></div>
                        </div>
                        <?php
                      } else if ($_GET['customercode'] == 'TMT') {
                        ?>
                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                          <div id="datadefunlock">

                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                              <thead>
                                <tr>
                                  <th style="text-align: center">No.</th>
                                  <th style="text-align: center">Document</th>
                                  <th style="text-align: center">D/M/Y</th>
                                  <th style="text-align: center">Driver</th>

                                  <th style="text-align: center;">

                                    ปลดล็อค

                                  </th>

                                </tr>

                              </thead>
                              <tbody>
                                <?php
                                $i = 1;
                                $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                                $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

                                $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                                $params_seBilling = array(
                                  array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                                  array($condBilling1, SQLSRV_PARAM_IN),
                                  array($condBilling2, SQLSRV_PARAM_IN)
                                );


                                $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                                while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                                  $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                                  $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                                  $params_seEmployeeehr = array(
                                    array('select_employeeehr2', SQLSRV_PARAM_IN),
                                    array($condEmployeeehr1, SQLSRV_PARAM_IN)
                                  );
                                  $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                                  $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                                  ?>
                                  <tr>
                                    <td style="text-align: center"><?= $i ?></td>
                                    <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                                    <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                                    <td><?= $result_seEmployeeehr['nameT'] ?></td>
                                    <td style="text-align: center">
                                      <?php
                                      if ($result_seBilling['BILLINGSTATUS'] == '1') {
                                        ?>
                                        <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                                        <?php
                                      }
                                      ?>

                                    </td>


                                  </tr>
                                  <?php
                                  $i++;
                                }
                                ?>
                              </tbody>


                            </table>



                          </div>
                          <div id="datasrunlock"></div>
                        </div>
                        <?php
                      } else if ($_GET['customercode'] == 'STM') {
                        ?>
                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                          <div id="datadefunlock">

                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                              <thead>
                                <tr>
                                  <th style="text-align: center">No.</th>
                                  <th style="text-align: center">Document</th>
                                  <th style="text-align: center">D/M/Y</th>
                                  <th style="text-align: center">Driver</th>

                                  <th style="text-align: center;">

                                    ปลดล็อค

                                  </th>

                                </tr>

                              </thead>
                              <tbody>
                                <?php
                                $i = 1;
                                $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                                $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

                                $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                                $params_seBilling = array(
                                  array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                                  array($condBilling1, SQLSRV_PARAM_IN),
                                  array($condBilling2, SQLSRV_PARAM_IN)
                                );


                                $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                                while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                                  $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                                  $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                                  $params_seEmployeeehr = array(
                                    array('select_employeeehr2', SQLSRV_PARAM_IN),
                                    array($condEmployeeehr1, SQLSRV_PARAM_IN)
                                  );
                                  $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                                  $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                                  ?>
                                  <tr>
                                    <td style="text-align: center"><?= $i ?></td>
                                    <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                                    <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                                    <td><?= $result_seEmployeeehr['nameT'] ?></td>
                                    <td style="text-align: center">
                                      <?php
                                      if ($result_seBilling['BILLINGSTATUS'] == '1') {
                                        ?>
                                        <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                                        <?php
                                      }
                                      ?>

                                    </td>


                                  </tr>
                                  <?php
                                  $i++;
                                }
                                ?>
                              </tbody>


                            </table>



                          </div>
                          <div id="datasrunlock"></div>
                        </div>
                        <?php
                      } else if ($_GET['customercode'] == 'DAIKI') {
                        ?>
                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                          <div id="datadefunlock">

                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                              <thead>
                                <tr>
                                  <th style="text-align: center">No.</th>
                                  <th style="text-align: center">Document</th>
                                  <th style="text-align: center">D/M/Y</th>
                                  <th style="text-align: center">Driver</th>

                                  <th style="text-align: center;">

                                    ปลดล็อค

                                  </th>

                                </tr>

                              </thead>
                              <tbody>
                                <?php
                                $i = 1;
                                $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                                $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

                                $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                                $params_seBilling = array(
                                  array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                                  array($condBilling1, SQLSRV_PARAM_IN),
                                  array($condBilling2, SQLSRV_PARAM_IN)
                                );


                                $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                                while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                                  $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                                  $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                                  $params_seEmployeeehr = array(
                                    array('select_employeeehr2', SQLSRV_PARAM_IN),
                                    array($condEmployeeehr1, SQLSRV_PARAM_IN)
                                  );
                                  $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                                  $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                                  ?>
                                  <tr>
                                    <td style="text-align: center"><?= $i ?></td>
                                    <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                                    <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                                    <td><?= $result_seEmployeeehr['nameT'] ?></td>
                                    <td style="text-align: center">
                                      <?php
                                      if ($result_seBilling['BILLINGSTATUS'] == '1') {
                                        ?>
                                        <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                                        <?php
                                      }
                                      ?>

                                    </td>


                                  </tr>
                                  <?php
                                  $i++;
                                }
                                ?>
                              </tbody>


                            </table>



                          </div>
                          <div id="datasrunlock"></div>
                        </div>
                        <?php
                      } else if ($_GET['customercode'] == 'GMT') {
                        ?>
                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                          <div id="datadefunlock">

                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                              <thead>
                                <tr>
                                  <th style="text-align: center">No.</th>
                                  <th style="text-align: center">Document</th>
                                  <th style="text-align: center">D/M/Y</th>
                                  <th style="text-align: center">Driver</th>

                                  <th style="text-align: center;">

                                    ปลดล็อค

                                  </th>

                                </tr>

                              </thead>
                              <tbody>
                                <?php
                                $i = 1;
                                $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                                $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

                                $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                                $params_seBilling = array(
                                  array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                                  array($condBilling1, SQLSRV_PARAM_IN),
                                  array($condBilling2, SQLSRV_PARAM_IN)
                                );


                                $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                                while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                                  $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                                  $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                                  $params_seEmployeeehr = array(
                                    array('select_employeeehr2', SQLSRV_PARAM_IN),
                                    array($condEmployeeehr1, SQLSRV_PARAM_IN)
                                  );
                                  $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                                  $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                                  ?>
                                  <tr>
                                    <td style="text-align: center"><?= $i ?></td>
                                    <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                                    <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                                    <td><?= $result_seEmployeeehr['nameT'] ?></td>
                                    <td style="text-align: center">
                                      <?php
                                      if ($result_seBilling['BILLINGSTATUS'] == '1') {
                                        ?>
                                        <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                                        <?php
                                      }
                                      ?>

                                    </td>


                                  </tr>
                                  <?php
                                  $i++;
                                }
                                ?>
                              </tbody>


                            </table>



                          </div>
                          <div id="datasrunlock"></div>
                        </div>
                        <?php
                      } else if ($_GET['customercode'] == 'TKT') {
                        ?>
                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                          <div id="datadefunlock">

                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                              <thead>
                                <tr>
                                  <th style="text-align: center">No.</th>
                                  <th style="text-align: center">Document</th>
                                  <th style="text-align: center">D/M/Y</th>
                                  <th style="text-align: center">Driver</th>

                                  <th style="text-align: center;">

                                    ปลดล็อค

                                  </th>

                                </tr>

                              </thead>
                              <tbody>
                                <?php
                                $i = 1;
                                $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                                $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

                                $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                                $params_seBilling = array(
                                  array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                                  array($condBilling1, SQLSRV_PARAM_IN),
                                  array($condBilling2, SQLSRV_PARAM_IN)
                                );


                                $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                                while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                                  $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                                  $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                                  $params_seEmployeeehr = array(
                                    array('select_employeeehr2', SQLSRV_PARAM_IN),
                                    array($condEmployeeehr1, SQLSRV_PARAM_IN)
                                  );
                                  $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                                  $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                                  ?>
                                  <tr>
                                    <td style="text-align: center"><?= $i ?></td>
                                    <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                                    <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                                    <td><?= $result_seEmployeeehr['nameT'] ?></td>
                                    <td style="text-align: center">
                                      <?php
                                      if ($result_seBilling['BILLINGSTATUS'] == '1') {
                                        ?>
                                        <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                                        <?php
                                      }
                                      ?>

                                    </td>


                                  </tr>
                                  <?php
                                  $i++;
                                }
                                ?>
                              </tbody>


                            </table>



                          </div>
                          <div id="datasrunlock"></div>
                        </div>
                        <?php
                      }
                    } else if ($_GET['companycode'] == 'RRC') {
                      if ($_GET['customercode'] == 'GMT') {
                        ?>



                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                          <div id="datadefunlock">

                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                              <thead>
                                <tr>
                                  <th style="text-align: center" rowspan="2">No.</th>
                                  <th style="text-align: center" rowspan="2">Document</th>
                                  <th style="text-align: center" rowspan="2">D/M/Y</th>
                                  <th style="text-align: center" rowspan="2">Driver</th>
                                  <th style="text-align: center" rowspan="2">Truck No.</th>
                                  <th style="text-align: center" colspan="2">Delivery</th>
                                  <th style="text-align: center" colspan="2">Weight (Tons)</th>
                                  <th style="text-align: center">Price</th>
                                  <th style="text-align: center" rowspan="2">Total</th>
                                  <!--<th style="text-align: center" rowspan="2">Status</th>-->
                                  <th style="text-align: center;width: 100px" >

                                    ปลดล็อค

                                  </th>

                                </tr>
                                <tr>
                                  <th style="text-align: center">From</th>
                                  <th style="text-align: center">To</th>
                                  <th style="text-align: center">GMT weight</th>
                                  <th style="text-align: center">CUS weight</th>
                                  <th style="text-align: center">Baht/Trips</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $i = 1;
                                $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                                $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = 'ไม่ระบุแผนก' AND a.DOCUMENTCODE != '' ";

                                $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                                $params_seBilling = array(
                                  array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                                  array($condBilling1, SQLSRV_PARAM_IN),
                                  array($condBilling2, SQLSRV_PARAM_IN)
                                );

                                $sql_seBillings = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                                $params_seBillings = array(
                                  array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                                  array($condBilling1, SQLSRV_PARAM_IN),
                                  array($condBilling2, SQLSRV_PARAM_IN)
                                );
                                $query_seBillings = sqlsrv_query($conn, $sql_seBillings, $params_seBillings);
                                $result_seBillings = sqlsrv_fetch_array($query_seBillings, SQLSRV_FETCH_ASSOC);

                                $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                                while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                                  $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                                  $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                                  $params_seEmployeeehr = array(
                                    array('select_employeeehr2', SQLSRV_PARAM_IN),
                                    array($condEmployeeehr1, SQLSRV_PARAM_IN)
                                  );
                                  $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                                  $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                                  ?>
                                  <tr>
                                    <td style="text-align: center"><?= $i ?></td>
                                    <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                                    <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                                    <td><?= $result_seEmployeeehr['nameT'] ?></td>
                                    <td><?= $result_seBilling['VEHICLEREGISNUMBER'] ?></td>
                                    <td><?= $result_seBilling['JOBSTART'] ?></td>
                                    <td><?= $result_seBilling['JOBEND'] ?></td>
                                    <td contenteditable="true" style="width: 100px" onkeyup="editinner_vehicletransportdocumentdrivergetway1(this, 'WEIGHTIN', '<?= $result_seBilling['VEHICLETRANSPORTDOCUMENTDRIVERGETWAYID'] ?>')"><?= $result_seBilling['WEIGHTIN'] ?></td>
                                    <td contenteditable="true" style="width: 100px" onkeyup="editinner_vehicletransportdocumentdrivergetway1(this, 'WEIGHTOUT', '<?= $result_seBilling['VEHICLETRANSPORTDOCUMENTDRIVERGETWAYID'] ?>')"><?= $result_seBilling['WEIGHTOUT'] ?></td>
                                    <td><?= number_format($result_seBilling['ACTUALPRICE'], 2) ?></td>
                                    <td><?= number_format($result_seBilling['ACTUALPRICE'], 2) ?></td>
                                    <!--<td style="text-align: center">
                                    <?php
                                    //if ($result_seBilling['BILLINGSTATUS'] == '1') {
                                    ?>
                                    <font style="color: green"> success</font>
                                    <?php
                                    // } else {
                                    ?>
                                    <font style="color: red"> unsuccess</font>
                                    <?php
                                    // }
                                    ?>

                                  </td>
                                -->
                                <td style="text-align: center">
                                  <?php
                                  if ($result_seBilling['BILLINGSTATUS'] == '1') {
                                    ?>
                                    <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                                    <?php
                                  }
                                  ?>

                                </td>


                              </tr>
                              <?php
                              $i++;
                            }
                            ?>
                          </tbody>


                        </table>



                      </div>
                      <div id="datasrunlock"></div>
                    </div>
                    <?php
                  }

                  if ($_GET['customercode'] == 'TTAST') {
                    ?>
                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                      <div id="datadefunlock">

                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                          <thead>
                            <tr>
                              <th style="text-align: center;width: 5%">ลำดับ</th>
                              <th style="text-align: center;width: 5%">วันที่</th>
                              <th style="text-align: center;width: 10%">หมายเลข DO</th>
                              <th style="text-align: center;width: 5%">ทะเบียนรถ</th>
                              <th style="text-align: center;width: 10%">พนักงาน</th>
                              <th style="text-align: center;width: 5%">จาก</th>
                              <th style="text-align: center;width: 5%">ถึง</th>
                              <th style="text-align: center;width: 10%">จำนวนแพ็ค/เที่ยว</th>
                              <th style="text-align: center;width: 10%">น้ำหนักรวม/เที่ยว</th>
                              <th style="text-align: center;width: 5%">QT.</th>
                              <th style="text-align: center;width: 10%">หน่วยละ</th>
                              <th style="text-align: center;width: 10%">จำนวนเงิน(บาท)</th>
                              <!--<th style="text-align: center" rowspan="2">Status</th>-->
                              <th style="text-align: center;width: 10%">

                                ปลดล็อค

                              </th>


                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $i = 1;
                            $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE())  AND BILLINGSTATUS ='1'";
                            $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND a.DOCUMENTCODE != ''";
                            $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                            $params_seBilling = array(
                              array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                              array($condBilling1, SQLSRV_PARAM_IN),
                              array($condBilling2, SQLSRV_PARAM_IN)
                            );

                            $sql_seBillings = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                            $params_seBillings = array(
                              array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                              array($condBilling1, SQLSRV_PARAM_IN),
                              array($condBilling2, SQLSRV_PARAM_IN)
                            );
                            $query_seBillings = sqlsrv_query($conn, $sql_seBillings, $params_seBillings);
                            $result_seBillings = sqlsrv_fetch_array($query_seBillings, SQLSRV_FETCH_ASSOC);

                            $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                            while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                              $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                              $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                              $params_seEmployeeehr = array(
                                array('select_employeeehr2', SQLSRV_PARAM_IN),
                                array($condEmployeeehr1, SQLSRV_PARAM_IN)
                              );
                              $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                              $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                              ?>
                              <tr>
                                <td style="text-align: center"><?= $i ?></td>
                                <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                                <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                                <td><?= $result_seBilling['VEHICLEREGISNUMBER'] ?></td>
                                <td><?= $result_seEmployeeehr['nameT'] ?></td>
                                <td><?= $result_seBilling['JOBSTART'] ?></td>
                                <td><?= $result_seBilling['JOBEND'] ?></td>
                                <td contenteditable="true" style="width: 100px" onkeyup="editinner_vehicletransportdocumentdrivergetway1(this, 'TRIPAMOUNT', '<?= $result_seBilling['VEHICLETRANSPORTDOCUMENTDRIVERGETWAYID'] ?>')"><?= $result_seBilling['TRIPAMOUNT'] ?></td>
                                <td contenteditable="true" style="width: 100px" onkeyup="editinner_vehicletransportdocumentdrivergetway1(this, 'WEIGHTOUT', '<?= $result_seBilling['VEHICLETRANSPORTDOCUMENTDRIVERGETWAYID'] ?>')"><?= $result_seBilling['WEIGHTOUT'] ?></td>
                                <td>1</td>
                                <td><?= number_format($result_seBilling['ACTUALPRICE'], 2) ?></td>
                                <td><?= number_format($result_seBilling['ACTUALPRICE'], 2) ?></td>
                                <!--<td style="text-align: center">
                                <?php
                                //if ($result_seBilling['BILLINGSTATUS'] == '1') {
                                ?>
                                <font style="color: green"> success</font>
                                <?php
                                //} else {
                                ?>
                                <font style="color: red"> unsuccess</font>
                                <?php
                                //}
                                ?>

                              </td>
                            -->
                            <td style="text-align: center">
                              <?php
                              if ($result_seBilling['BILLINGSTATUS'] == '1') {
                                ?>
                                <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                                <?php
                              }
                              ?>

                            </td>



                          </tr>
                          <?php
                          $i++;
                        }
                        ?>
                      </tbody>


                    </table>



                  </div>
                  <div id="datasrunlock"></div>
                </div>
                <?php
              }

              if ($_GET['customercode'] == 'BP') {
                ?>
                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                  <div id="datadefunlock">
                    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                      <thead>
                        <tr>
                          <th style="text-align: center" rowspan="2">No.</th>
                          <th style="text-align: center" rowspan="2">D/M/Y</th>
                          <th style="text-align: center" rowspan="2">Driver</th>
                          <th style="text-align: center" rowspan="2">Truck No.</th>
                          <th style="text-align: center" colspan="2">Delivery</th>
                          <th style="text-align: center" colspan="2">Weight (Tons)</th>
                          <th style="text-align: center">Price</th>
                          <th style="text-align: center" rowspan="2">Total</th>
                          <!--<th style="text-align: center" rowspan="2">Status</th>-->
                          <th style="text-align: center;width: 10px">

                            ปลดล็อค

                          </th>

                        </tr>
                        <tr>
                          <th style="text-align: center">From</th>
                          <th style="text-align: center">To</th>
                          <th style="text-align: center">GMT weight</th>
                          <th style="text-align: center">CUS weight</th>
                          <th style="text-align: center">Baht/Trips</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $i = 1;
                        $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                        $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = 'ไม่ระบุแผนก' AND a.DOCUMENTCODE != '' ";
                        $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                        $params_seBilling = array(
                          array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                          array($condBilling1, SQLSRV_PARAM_IN),
                          array($condBilling2, SQLSRV_PARAM_IN)
                        );

                        $sql_seBillings = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                        $params_seBillings = array(
                          array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                          array($condBilling1, SQLSRV_PARAM_IN),
                          array($condBilling2, SQLSRV_PARAM_IN)
                        );
                        $query_seBillings = sqlsrv_query($conn, $sql_seBillings, $params_seBillings);
                        $result_seBillings = sqlsrv_fetch_array($query_seBillings, SQLSRV_FETCH_ASSOC);



                        $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                        while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                          $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['DRIVERNAME'] . "'";
                          $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                          $params_seEmployeeehr = array(
                            array('select_employeeehr2', SQLSRV_PARAM_IN),
                            array($condEmployeeehr1, SQLSRV_PARAM_IN)
                          );
                          $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                          $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                          ?>
                          <tr>
                            <td style="text-align: center"><?= $i ?></td>
                            <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                            <td><?= $result_seEmployeeehr['nameT'] ?></td>
                            <td><?= $result_seBilling['VEHICLEREGISNUMBER1'] ?></td>
                            <td><?= $result_seBilling['JOBSTART'] ?></td>
                            <td><?= $result_seBilling['JOBEND'] ?></td>
                            <td contenteditable="true" style="width: 100px" onkeyup="editinner_vehicletransportdocumentdrivergetway1(this, 'WEIGHTIN', '<?= $result_seBilling['VEHICLETRANSPORTDOCUMENTDRIVERGETWAYID'] ?>')"><?= $result_seBilling['WEIGHTIN'] ?></td>
                            <td contenteditable="true" style="width: 100px" onkeyup="editinner_vehicletransportdocumentdrivergetway1(this, 'WEIGHTOUT', '<?= $result_seBilling['VEHICLETRANSPORTDOCUMENTDRIVERGETWAYID'] ?>')"><?= $result_seBilling['WEIGHTOUT'] ?></td>
                            <td><?= number_format($result_seBilling['ACTUALPRICE'], 2) ?></td>
                            <td><?= number_format($result_seBilling['ACTUALPRICE'], 2) ?></td>
                            <!--<td style="text-align: center">
                            <?php
                            //if ($result_seBilling['BILLINGSTATUS'] == '1') {
                            ?>
                            <font style="color: green"> success</font>
                            <?php
                            //} else {
                            ?>
                            <font style="color: red"> unsuccess</font>
                            <?php
                            //}
                            ?>

                          </td>
                        -->
                        <td style="text-align: center">
                          <?php
                          if ($result_seBilling['BILLINGSTATUS'] == '1') {
                            ?>
                            <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                            <?php
                          }
                          ?>

                        </td>


                      </tr>
                      <?php
                      $i++;
                    }
                    ?>
                  </tbody>


                </table>



              </div>
              <div id="datasrunlock"></div>
            </div>
            <?php
          }
        } else if ($_GET['companycode'] == 'RKR') {
          if ($_GET['carrytype'] == 'trip') {
            if ($_GET['customercode'] == 'DAIKI') {
              ?>
              <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div id="datadefunlock">

                  <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                    <thead>
                      <tr>
                        <th style="text-align: center">No.</th>
                        <th style="text-align: center">Document</th>
                        <th style="text-align: center">D/M/Y</th>
                        <th style="text-align: center">Driver</th>

                        <th style="text-align: center;">

                          ปลดล็อค

                        </th>

                      </tr>

                    </thead>
                    <tbody>
                      <?php
                      $i = 1;
                      $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                      $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

                      $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                      $params_seBilling = array(
                        array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                        array($condBilling1, SQLSRV_PARAM_IN),
                        array($condBilling2, SQLSRV_PARAM_IN)
                      );


                      $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                      while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                        $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                        $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                        $params_seEmployeeehr = array(
                          array('select_employeeehr2', SQLSRV_PARAM_IN),
                          array($condEmployeeehr1, SQLSRV_PARAM_IN)
                        );
                        $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                        $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                        ?>
                        <tr>
                          <td style="text-align: center"><?= $i ?></td>
                          <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                          <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                          <td><?= $result_seEmployeeehr['nameT'] ?></td>
                          <td style="text-align: center">
                            <?php
                            if ($result_seBilling['BILLINGSTATUS'] == '1') {
                              ?>
                              <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                              <?php
                            }
                            ?>

                          </td>


                        </tr>
                        <?php
                        $i++;
                      }
                      ?>
                    </tbody>


                  </table>



                </div>
                <div id="datasrunlock"></div>
              </div>
              <?php
            } else if ($_GET['customercode'] == 'TTPRO') {
              ?>
              <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div id="datadefunlock">

                  <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                    <thead>
                      <tr>
                        <th style="text-align: center">No.</th>
                        <th style="text-align: center">Document</th>
                        <th style="text-align: center">D/M/Y</th>
                        <th style="text-align: center">Driver</th>

                        <th style="text-align: center;">

                          ปลดล็อค

                        </th>

                      </tr>

                    </thead>
                    <tbody>
                      <?php
                      $i = 1;
                      $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                      $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

                      $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                      $params_seBilling = array(
                        array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                        array($condBilling1, SQLSRV_PARAM_IN),
                        array($condBilling2, SQLSRV_PARAM_IN)
                      );


                      $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                      while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                        $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                        $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                        $params_seEmployeeehr = array(
                          array('select_employeeehr2', SQLSRV_PARAM_IN),
                          array($condEmployeeehr1, SQLSRV_PARAM_IN)
                        );
                        $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                        $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                        ?>
                        <tr>
                          <td style="text-align: center"><?= $i ?></td>
                          <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                          <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                          <td><?= $result_seEmployeeehr['nameT'] ?></td>
                          <td style="text-align: center">
                            <?php
                            if ($result_seBilling['BILLINGSTATUS'] == '1') {
                              ?>
                              <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                              <?php
                            }
                            ?>

                          </td>


                        </tr>
                        <?php
                        $i++;
                      }
                      ?>
                    </tbody>


                  </table>



                </div>
                <div id="datasrunlock"></div>
              </div>
              <?php
            } else if ($_GET['customercode'] == 'TTAST') {
              ?>
              <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div id="datadefunlock">

                  <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                    <thead>
                      <tr>
                        <th style="text-align: center">No.</th>
                        <th style="text-align: center">Document</th>
                        <th style="text-align: center">D/M/Y</th>
                        <th style="text-align: center">Driver</th>

                        <th style="text-align: center;">

                          ปลดล็อค

                        </th>

                      </tr>

                    </thead>
                    <tbody>
                      <?php
                      $i = 1;
                      $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                      $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

                      $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                      $params_seBilling = array(
                        array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                        array($condBilling1, SQLSRV_PARAM_IN),
                        array($condBilling2, SQLSRV_PARAM_IN)
                      );


                      $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                      while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                        $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                        $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                        $params_seEmployeeehr = array(
                          array('select_employeeehr2', SQLSRV_PARAM_IN),
                          array($condEmployeeehr1, SQLSRV_PARAM_IN)
                        );
                        $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                        $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                        ?>
                        <tr>
                          <td style="text-align: center"><?= $i ?></td>
                          <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                          <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                          <td><?= $result_seEmployeeehr['nameT'] ?></td>
                          <td style="text-align: center">
                            <?php
                            if ($result_seBilling['BILLINGSTATUS'] == '1') {
                              ?>
                              <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                              <?php
                            }
                            ?>

                          </td>


                        </tr>
                        <?php
                        $i++;
                      }
                      ?>
                    </tbody>


                  </table>



                </div>
                <div id="datasrunlock"></div>
              </div>
              <?php
            } else if ($_GET['customercode'] == 'TTAT') {
              ?>
              <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div id="datadefunlock">

                  <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                    <thead>
                      <tr>
                        <th style="text-align: center">No.</th>
                        <th style="text-align: center">Document</th>
                        <th style="text-align: center">D/M/Y</th>
                        <th style="text-align: center">Driver</th>

                        <th style="text-align: center;">

                          ปลดล็อค

                        </th>

                      </tr>

                    </thead>
                    <tbody>
                      <?php
                      $i = 1;
                      $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                      $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

                      $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                      $params_seBilling = array(
                        array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                        array($condBilling1, SQLSRV_PARAM_IN),
                        array($condBilling2, SQLSRV_PARAM_IN)
                      );


                      $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                      while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                        $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                        $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                        $params_seEmployeeehr = array(
                          array('select_employeeehr2', SQLSRV_PARAM_IN),
                          array($condEmployeeehr1, SQLSRV_PARAM_IN)
                        );
                        $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                        $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                        ?>
                        <tr>
                          <td style="text-align: center"><?= $i ?></td>
                          <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                          <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                          <td><?= $result_seEmployeeehr['nameT'] ?></td>
                          <td style="text-align: center">
                            <?php
                            if ($result_seBilling['BILLINGSTATUS'] == '1') {
                              ?>
                              <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                              <?php
                            }
                            ?>

                          </td>


                        </tr>
                        <?php
                        $i++;
                      }
                      ?>
                    </tbody>


                  </table>



                </div>
                <div id="datasrunlock"></div>
              </div>
              <?php
            } else if ($_GET['customercode'] == 'TMT') {
              ?>
              <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div id="datadefunlock">

                  <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                    <thead>
                      <tr>
                        <th style="text-align: center">No.</th>
                        <th style="text-align: center">Document</th>
                        <th style="text-align: center">D/M/Y</th>
                        <th style="text-align: center">Driver</th>

                        <th style="text-align: center;">

                          ปลดล็อค

                        </th>

                      </tr>

                    </thead>
                    <tbody>
                      <?php
                      $i = 1;
                      $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                      $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

                      $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                      $params_seBilling = array(
                        array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                        array($condBilling1, SQLSRV_PARAM_IN),
                        array($condBilling2, SQLSRV_PARAM_IN)
                      );


                      $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                      while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                        $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                        $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                        $params_seEmployeeehr = array(
                          array('select_employeeehr2', SQLSRV_PARAM_IN),
                          array($condEmployeeehr1, SQLSRV_PARAM_IN)
                        );
                        $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                        $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                        ?>
                        <tr>
                          <td style="text-align: center"><?= $i ?></td>
                          <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                          <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                          <td><?= $result_seEmployeeehr['nameT'] ?></td>
                          <td style="text-align: center">
                            <?php
                            if ($result_seBilling['BILLINGSTATUS'] == '1') {
                              ?>
                              <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                              <?php
                            }
                            ?>

                          </td>


                        </tr>
                        <?php
                        $i++;
                      }
                      ?>
                    </tbody>


                  </table>



                </div>
                <div id="datasrunlock"></div>
              </div>
              <?php
            } else if ($_GET['customercode'] == 'TGT') {
              ?>
              <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div id="datadefunlock">

                  <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                    <thead>
                      <tr>
                        <th style="text-align: center">No.</th>
                        <th style="text-align: center">Document</th>
                        <th style="text-align: center">D/M/Y</th>
                        <th style="text-align: center">Driver</th>

                        <th style="text-align: center;">

                          ปลดล็อค

                        </th>

                      </tr>

                    </thead>
                    <tbody>
                      <?php
                      $i = 1;
                      $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                      $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

                      $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                      $params_seBilling = array(
                        array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                        array($condBilling1, SQLSRV_PARAM_IN),
                        array($condBilling2, SQLSRV_PARAM_IN)
                      );


                      $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                      while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                        $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                        $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                        $params_seEmployeeehr = array(
                          array('select_employeeehr2', SQLSRV_PARAM_IN),
                          array($condEmployeeehr1, SQLSRV_PARAM_IN)
                        );
                        $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                        $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                        ?>
                        <tr>
                          <td style="text-align: center"><?= $i ?></td>
                          <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                          <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                          <td><?= $result_seEmployeeehr['nameT'] ?></td>
                          <td style="text-align: center">
                            <?php
                            if ($result_seBilling['BILLINGSTATUS'] == '1') {
                              ?>
                              <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                              <?php
                            }
                            ?>

                          </td>


                        </tr>
                        <?php
                        $i++;
                      }
                      ?>
                    </tbody>


                  </table>



                </div>
                <div id="datasrunlock"></div>
              </div>
              <?php
            } else if ($_GET['customercode'] == 'YNP') {
              ?>
              <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div id="datadefunlock">

                  <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                    <thead>
                      <tr>
                        <th style="text-align: center">No.</th>
                        <th style="text-align: center">Document</th>
                        <th style="text-align: center">D/M/Y</th>
                        <th style="text-align: center">Driver</th>

                        <th style="text-align: center;">

                          ปลดล็อค

                        </th>

                      </tr>

                    </thead>
                    <tbody>
                      <?php
                      $i = 1;
                      $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                      $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

                      $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                      $params_seBilling = array(
                        array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                        array($condBilling1, SQLSRV_PARAM_IN),
                        array($condBilling2, SQLSRV_PARAM_IN)
                      );


                      $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                      while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                        $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                        $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                        $params_seEmployeeehr = array(
                          array('select_employeeehr2', SQLSRV_PARAM_IN),
                          array($condEmployeeehr1, SQLSRV_PARAM_IN)
                        );
                        $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                        $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                        ?>
                        <tr>
                          <td style="text-align: center"><?= $i ?></td>
                          <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                          <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                          <td><?= $result_seEmployeeehr['nameT'] ?></td>
                          <td style="text-align: center">
                            <?php
                            if ($result_seBilling['BILLINGSTATUS'] == '1') {
                              ?>
                              <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                              <?php
                            }
                            ?>

                          </td>


                        </tr>
                        <?php
                        $i++;
                      }
                      ?>
                    </tbody>


                  </table>



                </div>
                <div id="datasrunlock"></div>
              </div>
              <?php
            } else if ($_GET['customercode'] == 'GMT') {
              ?>
              <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div id="datadefunlock">

                  <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                    <thead>
                      <tr>
                        <th style="text-align: center">No.</th>
                        <th style="text-align: center">Document</th>
                        <th style="text-align: center">D/M/Y</th>
                        <th style="text-align: center">Driver</th>

                        <th style="text-align: center;">

                          ปลดล็อค

                        </th>

                      </tr>

                    </thead>
                    <tbody>
                      <?php
                      $i = 1;
                      $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                      $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

                      $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                      $params_seBilling = array(
                        array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                        array($condBilling1, SQLSRV_PARAM_IN),
                        array($condBilling2, SQLSRV_PARAM_IN)
                      );


                      $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                      while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                        $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                        $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                        $params_seEmployeeehr = array(
                          array('select_employeeehr2', SQLSRV_PARAM_IN),
                          array($condEmployeeehr1, SQLSRV_PARAM_IN)
                        );
                        $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                        $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                        ?>
                        <tr>
                          <td style="text-align: center"><?= $i ?></td>
                          <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                          <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                          <td><?= $result_seEmployeeehr['nameT'] ?></td>
                          <td style="text-align: center">
                            <?php
                            if ($result_seBilling['BILLINGSTATUS'] == '1') {
                              ?>
                              <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                              <?php
                            }
                            ?>

                          </td>


                        </tr>
                        <?php
                        $i++;
                      }
                      ?>
                    </tbody>


                  </table>



                </div>
                <div id="datasrunlock"></div>
              </div>
              <?php
            }
          } else if ($_GET['carrytype'] == 'weight') {
            if ($_GET['customercode'] == 'TTPROSTC') {
              ?>

              <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div id="datadefunlock">

                  <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                    <thead>
                      <tr>
                        <th style="text-align: center">No.</th>
                        <th style="text-align: center">Document</th>
                        <th style="text-align: center">D/M/Y</th>
                        <th style="text-align: center">Driver</th>

                        <th style="text-align: center;">

                          ปลดล็อค

                        </th>

                      </tr>

                    </thead>
                    <tbody>
                      <?php
                      $i = 1;
                      $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                      $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

                      $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                      $params_seBilling = array(
                        array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                        array($condBilling1, SQLSRV_PARAM_IN),
                        array($condBilling2, SQLSRV_PARAM_IN)
                      );


                      $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                      while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                        $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                        $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                        $params_seEmployeeehr = array(
                          array('select_employeeehr2', SQLSRV_PARAM_IN),
                          array($condEmployeeehr1, SQLSRV_PARAM_IN)
                        );
                        $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                        $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                        ?>
                        <tr>
                          <td style="text-align: center"><?= $i ?></td>
                          <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                          <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                          <td><?= $result_seEmployeeehr['nameT'] ?></td>
                          <td style="text-align: center">
                            <?php
                            if ($result_seBilling['BILLINGSTATUS'] == '1') {
                              ?>
                              <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                              <?php
                            }
                            ?>

                          </td>


                        </tr>
                        <?php
                        $i++;
                      }
                      ?>
                    </tbody>


                  </table>



                </div>
                <div id="datasrunlock"></div>
              </div>
              <?php
            } else if ($_GET['customercode'] == 'TTASTSTC') {
              ?>

              <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div id="datadefunlock">

                  <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                    <thead>
                      <tr>
                        <th style="text-align: center">No.</th>
                        <th style="text-align: center">Document</th>
                        <th style="text-align: center">D/M/Y</th>
                        <th style="text-align: center">Driver</th>

                        <th style="text-align: center;">

                          ปลดล็อค

                        </th>

                      </tr>

                    </thead>
                    <tbody>
                      <?php
                      $i = 1;
                      $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                      $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

                      $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                      $params_seBilling = array(
                        array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                        array($condBilling1, SQLSRV_PARAM_IN),
                        array($condBilling2, SQLSRV_PARAM_IN)
                      );


                      $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                      while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                        $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                        $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                        $params_seEmployeeehr = array(
                          array('select_employeeehr2', SQLSRV_PARAM_IN),
                          array($condEmployeeehr1, SQLSRV_PARAM_IN)
                        );
                        $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                        $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                        ?>
                        <tr>
                          <td style="text-align: center"><?= $i ?></td>
                          <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                          <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                          <td><?= $result_seEmployeeehr['nameT'] ?></td>
                          <td style="text-align: center">
                            <?php
                            if ($result_seBilling['BILLINGSTATUS'] == '1') {
                              ?>
                              <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                              <?php
                            }
                            ?>

                          </td>


                        </tr>
                        <?php
                        $i++;
                      }
                      ?>
                    </tbody>


                  </table>



                </div>
                <div id="datasrunlock"></div>
              </div>
              <?php
            } else if ($_GET['customercode'] == 'TTASTCS') {
              ?>

              <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div id="datadefunlock">

                  <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                    <thead>
                      <tr>
                        <th style="text-align: center">No.</th>
                        <th style="text-align: center">Document</th>
                        <th style="text-align: center">D/M/Y</th>
                        <th style="text-align: center">Driver</th>

                        <th style="text-align: center;">

                          ปลดล็อค

                        </th>

                      </tr>

                    </thead>
                    <tbody>
                      <?php
                      $i = 1;
                      $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                      $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

                      $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                      $params_seBilling = array(
                        array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                        array($condBilling1, SQLSRV_PARAM_IN),
                        array($condBilling2, SQLSRV_PARAM_IN)
                      );


                      $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                      while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                        $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                        $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                        $params_seEmployeeehr = array(
                          array('select_employeeehr2', SQLSRV_PARAM_IN),
                          array($condEmployeeehr1, SQLSRV_PARAM_IN)
                        );
                        $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                        $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                        ?>
                        <tr>
                          <td style="text-align: center"><?= $i ?></td>
                          <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                          <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                          <td><?= $result_seEmployeeehr['nameT'] ?></td>
                          <td style="text-align: center">
                            <?php
                            if ($result_seBilling['BILLINGSTATUS'] == '1') {
                              ?>
                              <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                              <?php
                            }
                            ?>

                          </td>


                        </tr>
                        <?php
                        $i++;
                      }
                      ?>
                    </tbody>


                  </table>



                </div>
                <div id="datasrunlock"></div>
              </div>
              <?php
            } else if ($_GET['customercode'] == 'DAIKI') {
              ?>

              <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div id="datadefunlock">

                  <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                    <thead>
                      <tr>
                        <th style="text-align: center">No.</th>
                        <th style="text-align: center">Document</th>
                        <th style="text-align: center">D/M/Y</th>
                        <th style="text-align: center">Driver</th>

                        <th style="text-align: center;">

                          ปลดล็อค

                        </th>

                      </tr>

                    </thead>
                    <tbody>
                      <?php
                      $i = 1;
                      $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                      $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

                      $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                      $params_seBilling = array(
                        array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                        array($condBilling1, SQLSRV_PARAM_IN),
                        array($condBilling2, SQLSRV_PARAM_IN)
                      );


                      $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                      while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                        $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                        $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                        $params_seEmployeeehr = array(
                          array('select_employeeehr2', SQLSRV_PARAM_IN),
                          array($condEmployeeehr1, SQLSRV_PARAM_IN)
                        );
                        $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                        $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                        ?>
                        <tr>
                          <td style="text-align: center"><?= $i ?></td>
                          <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                          <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                          <td><?= $result_seEmployeeehr['nameT'] ?></td>
                          <td style="text-align: center">
                            <?php
                            if ($result_seBilling['BILLINGSTATUS'] == '1') {
                              ?>
                              <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                              <?php
                            }
                            ?>

                          </td>


                        </tr>
                        <?php
                        $i++;
                      }
                      ?>
                    </tbody>


                  </table>



                </div>
                <div id="datasrunlock"></div>
              </div>
              <?php
            }
          }
        } else if ($_GET['companycode'] == 'RKL') {
          if ($_GET['carrytype'] == 'trip') {
            if ($_GET['customercode'] == 'SKB') {
              ?>

              <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div id="datadefunlock">

                  <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                    <thead>
                      <tr>
                        <th style="text-align: center">No.</th>
                        <th style="text-align: center">Document</th>
                        <th style="text-align: center">D/M/Y</th>
                        <th style="text-align: center">Driver</th>

                        <th style="text-align: center;">

                          ปลดล็อค

                        </th>

                      </tr>

                    </thead>
                    <tbody>
                      <?php
                      $i = 1;
                      $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                      $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

                      $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                      $params_seBilling = array(
                        array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                        array($condBilling1, SQLSRV_PARAM_IN),
                        array($condBilling2, SQLSRV_PARAM_IN)
                      );


                      $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                      while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                        $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                        $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                        $params_seEmployeeehr = array(
                          array('select_employeeehr2', SQLSRV_PARAM_IN),
                          array($condEmployeeehr1, SQLSRV_PARAM_IN)
                        );
                        $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                        $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                        ?>
                        <tr>
                          <td style="text-align: center"><?= $i ?></td>
                          <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                          <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                          <td><?= $result_seEmployeeehr['nameT'] ?></td>
                          <td style="text-align: center">
                            <?php
                            if ($result_seBilling['BILLINGSTATUS'] == '1') {
                              ?>
                              <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                              <?php
                            }
                            ?>

                          </td>


                        </tr>
                        <?php
                        $i++;
                      }
                      ?>
                    </tbody>


                  </table>



                </div>
                <div id="datasrunlock"></div>
              </div>
              <?php
            } else if ($_GET['customercode'] == 'TTTC') {
              ?>

              <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div id="datadefunlock">

                  <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                    <thead>
                      <tr>
                        <th style="text-align: center">No.</th>
                        <th style="text-align: center">Document</th>
                        <th style="text-align: center">D/M/Y</th>
                        <th style="text-align: center">Driver</th>

                        <th style="text-align: center;">

                          ปลดล็อค

                        </th>

                      </tr>

                    </thead>
                    <tbody>
                      <?php
                      $i = 1;
                      $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                      $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

                      $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                      $params_seBilling = array(
                        array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                        array($condBilling1, SQLSRV_PARAM_IN),
                        array($condBilling2, SQLSRV_PARAM_IN)
                      );


                      $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                      while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                        $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                        $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                        $params_seEmployeeehr = array(
                          array('select_employeeehr2', SQLSRV_PARAM_IN),
                          array($condEmployeeehr1, SQLSRV_PARAM_IN)
                        );
                        $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                        $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                        ?>
                        <tr>
                          <td style="text-align: center"><?= $i ?></td>
                          <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                          <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                          <td><?= $result_seEmployeeehr['nameT'] ?></td>
                          <td style="text-align: center">
                            <?php
                            if ($result_seBilling['BILLINGSTATUS'] == '1') {
                              ?>
                              <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                              <?php
                            }
                            ?>

                          </td>


                        </tr>
                        <?php
                        $i++;
                      }
                      ?>
                    </tbody>


                  </table>



                </div>
                <div id="datasrunlock"></div>
              </div>
              <?php
            } else if ($_GET['customercode'] == 'CH-AUTO') {
              ?>

              <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div id="datadefunlock">

                  <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                    <thead>
                      <tr>
                        <th style="text-align: center">No.</th>
                        <th style="text-align: center">Document</th>
                        <th style="text-align: center">D/M/Y</th>
                        <th style="text-align: center">Driver</th>

                        <th style="text-align: center;">

                          ปลดล็อค

                        </th>

                      </tr>

                    </thead>
                    <tbody>
                      <?php
                      $i = 1;
                      $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                      $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

                      $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                      $params_seBilling = array(
                        array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                        array($condBilling1, SQLSRV_PARAM_IN),
                        array($condBilling2, SQLSRV_PARAM_IN)
                      );


                      $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                      while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                        $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                        $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                        $params_seEmployeeehr = array(
                          array('select_employeeehr2', SQLSRV_PARAM_IN),
                          array($condEmployeeehr1, SQLSRV_PARAM_IN)
                        );
                        $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                        $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                        ?>
                        <tr>
                          <td style="text-align: center"><?= $i ?></td>
                          <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                          <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                          <td><?= $result_seEmployeeehr['nameT'] ?></td>
                          <td style="text-align: center">
                            <?php
                            if ($result_seBilling['BILLINGSTATUS'] == '1') {
                              ?>
                              <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                              <?php
                            }
                            ?>

                          </td>


                        </tr>
                        <?php
                        $i++;
                      }
                      ?>
                    </tbody>


                  </table>



                </div>
                <div id="datasrunlock"></div>
              </div>
              <?php
            } else if ($_GET['customercode'] == 'TTAT') {
              ?>

              <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div id="datadefunlock">

                  <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                    <thead>
                      <tr>
                        <th style="text-align: center">No.</th>
                        <th style="text-align: center">Document</th>
                        <th style="text-align: center">D/M/Y</th>
                        <th style="text-align: center">Driver</th>

                        <th style="text-align: center;">

                          ปลดล็อค

                        </th>

                      </tr>

                    </thead>
                    <tbody>
                      <?php
                      $i = 1;
                      $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                      $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

                      $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                      $params_seBilling = array(
                        array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                        array($condBilling1, SQLSRV_PARAM_IN),
                        array($condBilling2, SQLSRV_PARAM_IN)
                      );


                      $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                      while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                        $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                        $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                        $params_seEmployeeehr = array(
                          array('select_employeeehr2', SQLSRV_PARAM_IN),
                          array($condEmployeeehr1, SQLSRV_PARAM_IN)
                        );
                        $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                        $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                        ?>
                        <tr>
                          <td style="text-align: center"><?= $i ?></td>
                          <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                          <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                          <td><?= $result_seEmployeeehr['nameT'] ?></td>
                          <td style="text-align: center">
                            <?php
                            if ($result_seBilling['BILLINGSTATUS'] == '1') {
                              ?>
                              <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                              <?php
                            }
                            ?>

                          </td>


                        </tr>
                        <?php
                        $i++;
                      }
                      ?>
                    </tbody>


                  </table>



                </div>
                <div id="datasrunlock"></div>
              </div>
              <?php
            } else if ($_GET['customercode'] == 'TKT') {
              ?>

              <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div id="datadefunlock">

                  <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                    <thead>
                      <tr>
                        <th style="text-align: center">No.</th>
                        <th style="text-align: center">Document</th>
                        <th style="text-align: center">D/M/Y</th>
                        <th style="text-align: center">Driver</th>

                        <th style="text-align: center;">

                          ปลดล็อค

                        </th>

                      </tr>

                    </thead>
                    <tbody>
                      <?php
                      $i = 1;
                      $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                      $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

                      $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                      $params_seBilling = array(
                        array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                        array($condBilling1, SQLSRV_PARAM_IN),
                        array($condBilling2, SQLSRV_PARAM_IN)
                      );


                      $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                      while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                        $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                        $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                        $params_seEmployeeehr = array(
                          array('select_employeeehr2', SQLSRV_PARAM_IN),
                          array($condEmployeeehr1, SQLSRV_PARAM_IN)
                        );
                        $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                        $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                        ?>
                        <tr>
                          <td style="text-align: center"><?= $i ?></td>
                          <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                          <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                          <td><?= $result_seEmployeeehr['nameT'] ?></td>
                          <td style="text-align: center">
                            <?php
                            if ($result_seBilling['BILLINGSTATUS'] == '1') {
                              ?>
                              <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                              <?php
                            }
                            ?>

                          </td>


                        </tr>
                        <?php
                        $i++;
                      }
                      ?>
                    </tbody>


                  </table>



                </div>
                <div id="datasrunlock"></div>
              </div>
              <?php
            } else if ($_GET['customercode'] == 'TSAT') {
              ?>

              <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div id="datadefunlock">

                  <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                    <thead>
                      <tr>
                        <th style="text-align: center">No.</th>
                        <th style="text-align: center">Document</th>
                        <th style="text-align: center">D/M/Y</th>
                        <th style="text-align: center">Driver</th>

                        <th style="text-align: center;">

                          ปลดล็อค

                        </th>

                      </tr>

                    </thead>
                    <tbody>
                      <?php
                      $i = 1;
                      $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                      $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

                      $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                      $params_seBilling = array(
                        array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                        array($condBilling1, SQLSRV_PARAM_IN),
                        array($condBilling2, SQLSRV_PARAM_IN)
                      );


                      $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                      while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                        $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                        $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                        $params_seEmployeeehr = array(
                          array('select_employeeehr2', SQLSRV_PARAM_IN),
                          array($condEmployeeehr1, SQLSRV_PARAM_IN)
                        );
                        $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                        $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                        ?>
                        <tr>
                          <td style="text-align: center"><?= $i ?></td>
                          <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                          <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                          <td><?= $result_seEmployeeehr['nameT'] ?></td>
                          <td style="text-align: center">
                            <?php
                            if ($result_seBilling['BILLINGSTATUS'] == '1') {
                              ?>
                              <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                              <?php
                            }
                            ?>

                          </td>


                        </tr>
                        <?php
                        $i++;
                      }
                      ?>
                    </tbody>


                  </table>



                </div>
                <div id="datasrunlock"></div>
              </div>
              <?php
            } else if ($_GET['customercode'] == 'YNP') {
              ?>

              <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div id="datadefunlock">

                  <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                    <thead>
                      <tr>
                        <th style="text-align: center">No.</th>
                        <th style="text-align: center">Document</th>
                        <th style="text-align: center">D/M/Y</th>
                        <th style="text-align: center">Driver</th>

                        <th style="text-align: center;">

                          ปลดล็อค

                        </th>

                      </tr>

                    </thead>
                    <tbody>
                      <?php
                      $i = 1;
                      $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                      $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

                      $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                      $params_seBilling = array(
                        array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                        array($condBilling1, SQLSRV_PARAM_IN),
                        array($condBilling2, SQLSRV_PARAM_IN)
                      );


                      $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                      while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                        $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                        $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                        $params_seEmployeeehr = array(
                          array('select_employeeehr2', SQLSRV_PARAM_IN),
                          array($condEmployeeehr1, SQLSRV_PARAM_IN)
                        );
                        $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                        $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                        ?>
                        <tr>
                          <td style="text-align: center"><?= $i ?></td>
                          <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                          <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                          <td><?= $result_seEmployeeehr['nameT'] ?></td>
                          <td style="text-align: center">
                            <?php
                            if ($result_seBilling['BILLINGSTATUS'] == '1') {
                              ?>
                              <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                              <?php
                            }
                            ?>

                          </td>


                        </tr>
                        <?php
                        $i++;
                      }
                      ?>
                    </tbody>


                  </table>



                </div>
                <div id="datasrunlock"></div>
              </div>
              <?php
            } else if ($_GET['customercode'] == 'WSBT') {
              ?>

              <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div id="datadefunlock">

                  <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                    <thead>
                      <tr>
                        <th style="text-align: center">No.</th>
                        <th style="text-align: center">Document</th>
                        <th style="text-align: center">D/M/Y</th>
                        <th style="text-align: center">Driver</th>

                        <th style="text-align: center;">

                          ปลดล็อค

                        </th>

                      </tr>

                    </thead>
                    <tbody>
                      <?php
                      $i = 1;
                      $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                      $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

                      $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                      $params_seBilling = array(
                        array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                        array($condBilling1, SQLSRV_PARAM_IN),
                        array($condBilling2, SQLSRV_PARAM_IN)
                      );


                      $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                      while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                        $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                        $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                        $params_seEmployeeehr = array(
                          array('select_employeeehr2', SQLSRV_PARAM_IN),
                          array($condEmployeeehr1, SQLSRV_PARAM_IN)
                        );
                        $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                        $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                        ?>
                        <tr>
                          <td style="text-align: center"><?= $i ?></td>
                          <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                          <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                          <td><?= $result_seEmployeeehr['nameT'] ?></td>
                          <td style="text-align: center">
                            <?php
                            if ($result_seBilling['BILLINGSTATUS'] == '1') {
                              ?>
                              <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                              <?php
                            }
                            ?>

                          </td>


                        </tr>
                        <?php
                        $i++;
                      }
                      ?>
                    </tbody>


                  </table>



                </div>
                <div id="datasrunlock"></div>
              </div>
              <?php
            } else if ($_GET['customercode'] == 'TMT') {
              ?>

              <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div id="datadefunlock">

                  <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                    <thead>
                      <tr>
                        <th style="text-align: center">No.</th>
                        <th style="text-align: center">Document</th>
                        <th style="text-align: center">D/M/Y</th>
                        <th style="text-align: center">Driver</th>

                        <th style="text-align: center;">

                          ปลดล็อค

                        </th>

                      </tr>

                    </thead>
                    <tbody>
                      <?php
                      $i = 1;
                      $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                      $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

                      $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                      $params_seBilling = array(
                        array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                        array($condBilling1, SQLSRV_PARAM_IN),
                        array($condBilling2, SQLSRV_PARAM_IN)
                      );


                      $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                      while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                        $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                        $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                        $params_seEmployeeehr = array(
                          array('select_employeeehr2', SQLSRV_PARAM_IN),
                          array($condEmployeeehr1, SQLSRV_PARAM_IN)
                        );
                        $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                        $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                        ?>
                        <tr>
                          <td style="text-align: center"><?= $i ?></td>
                          <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                          <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                          <td><?= $result_seEmployeeehr['nameT'] ?></td>
                          <td style="text-align: center">
                            <?php
                            if ($result_seBilling['BILLINGSTATUS'] == '1') {
                              ?>
                              <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                              <?php
                            }
                            ?>

                          </td>


                        </tr>
                        <?php
                        $i++;
                      }
                      ?>
                    </tbody>


                  </table>



                </div>
                <div id="datasrunlock"></div>
              </div>
              <?php
            } else if ($_GET['customercode'] == 'NITTSUSHOJI') {
              ?>

              <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div id="datadefunlock">

                  <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                    <thead>
                      <tr>
                        <th style="text-align: center">No.</th>
                        <th style="text-align: center">Document</th>
                        <th style="text-align: center">D/M/Y</th>
                        <th style="text-align: center">Driver</th>

                        <th style="text-align: center;">

                          ปลดล็อค

                        </th>

                      </tr>

                    </thead>
                    <tbody>
                      <?php
                      $i = 1;
                      $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                      $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

                      $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                      $params_seBilling = array(
                        array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                        array($condBilling1, SQLSRV_PARAM_IN),
                        array($condBilling2, SQLSRV_PARAM_IN)
                      );


                      $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                      while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                        $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                        $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                        $params_seEmployeeehr = array(
                          array('select_employeeehr2', SQLSRV_PARAM_IN),
                          array($condEmployeeehr1, SQLSRV_PARAM_IN)
                        );
                        $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                        $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                        ?>
                        <tr>
                          <td style="text-align: center"><?= $i ?></td>
                          <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                          <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                          <td><?= $result_seEmployeeehr['nameT'] ?></td>
                          <td style="text-align: center">
                            <?php
                            if ($result_seBilling['BILLINGSTATUS'] == '1') {
                              ?>
                              <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                              <?php
                            }
                            ?>

                          </td>


                        </tr>
                        <?php
                        $i++;
                      }
                      ?>
                    </tbody>


                  </table>



                </div>
                <div id="datasrunlock"></div>
              </div>
              <?php
            }
          } else if ($_GET['carrytype'] == 'weight') {
            if ($_GET['customercode'] == 'DAIKI') {
              ?>

              <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div id="datadefunlock">

                  <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                    <thead>
                      <tr>
                        <th style="text-align: center">No.</th>
                        <th style="text-align: center">Document</th>
                        <th style="text-align: center">D/M/Y</th>
                        <th style="text-align: center">Driver</th>

                        <th style="text-align: center;">

                          ปลดล็อค

                        </th>

                      </tr>

                    </thead>
                    <tbody>
                      <?php
                      $i = 1;
                      $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                      $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

                      $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                      $params_seBilling = array(
                        array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                        array($condBilling1, SQLSRV_PARAM_IN),
                        array($condBilling2, SQLSRV_PARAM_IN)
                      );


                      $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                      while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                        $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                        $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                        $params_seEmployeeehr = array(
                          array('select_employeeehr2', SQLSRV_PARAM_IN),
                          array($condEmployeeehr1, SQLSRV_PARAM_IN)
                        );
                        $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                        $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                        ?>
                        <tr>
                          <td style="text-align: center"><?= $i ?></td>
                          <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                          <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                          <td><?= $result_seEmployeeehr['nameT'] ?></td>
                          <td style="text-align: center">
                            <?php
                            if ($result_seBilling['BILLINGSTATUS'] == '1') {
                              ?>
                              <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                              <?php
                            }
                            ?>

                          </td>


                        </tr>
                        <?php
                        $i++;
                      }
                      ?>
                    </tbody>


                  </table>



                </div>
                <div id="datasrunlock"></div>
              </div>
              <?php
            } else if ($_GET['customercode'] == 'TTPROSTC') {
              ?>

              <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div id="datadefunlock">

                  <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                    <thead>
                      <tr>
                        <th style="text-align: center">No.</th>
                        <th style="text-align: center">Document</th>
                        <th style="text-align: center">D/M/Y</th>
                        <th style="text-align: center">Driver</th>

                        <th style="text-align: center;">

                          ปลดล็อค

                        </th>

                      </tr>

                    </thead>
                    <tbody>
                      <?php
                      $i = 1;
                      $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                      $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

                      $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                      $params_seBilling = array(
                        array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                        array($condBilling1, SQLSRV_PARAM_IN),
                        array($condBilling2, SQLSRV_PARAM_IN)
                      );


                      $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                      while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                        $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                        $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                        $params_seEmployeeehr = array(
                          array('select_employeeehr2', SQLSRV_PARAM_IN),
                          array($condEmployeeehr1, SQLSRV_PARAM_IN)
                        );
                        $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                        $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                        ?>
                        <tr>
                          <td style="text-align: center"><?= $i ?></td>
                          <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                          <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                          <td><?= $result_seEmployeeehr['nameT'] ?></td>
                          <td style="text-align: center">
                            <?php
                            if ($result_seBilling['BILLINGSTATUS'] == '1') {
                              ?>
                              <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                              <?php
                            }
                            ?>

                          </td>


                        </tr>
                        <?php
                        $i++;
                      }
                      ?>
                    </tbody>


                  </table>



                </div>
                <div id="datasrunlock"></div>
              </div>
              <?php
            } else if ($_GET['customercode'] == 'TTASTSTC') {
              ?>

              <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div id="datadefunlock">

                  <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                    <thead>
                      <tr>
                        <th style="text-align: center">No.</th>
                        <th style="text-align: center">Document</th>
                        <th style="text-align: center">D/M/Y</th>
                        <th style="text-align: center">Driver</th>

                        <th style="text-align: center;">

                          ปลดล็อค

                        </th>

                      </tr>

                    </thead>
                    <tbody>
                      <?php
                      $i = 1;
                      $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                      $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

                      $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                      $params_seBilling = array(
                        array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                        array($condBilling1, SQLSRV_PARAM_IN),
                        array($condBilling2, SQLSRV_PARAM_IN)
                      );


                      $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                      while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                        $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                        $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                        $params_seEmployeeehr = array(
                          array('select_employeeehr2', SQLSRV_PARAM_IN),
                          array($condEmployeeehr1, SQLSRV_PARAM_IN)
                        );
                        $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                        $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                        ?>
                        <tr>
                          <td style="text-align: center"><?= $i ?></td>
                          <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                          <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                          <td><?= $result_seEmployeeehr['nameT'] ?></td>
                          <td style="text-align: center">
                            <?php
                            if ($result_seBilling['BILLINGSTATUS'] == '1') {
                              ?>
                              <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                              <?php
                            }
                            ?>

                          </td>


                        </tr>
                        <?php
                        $i++;
                      }
                      ?>
                    </tbody>


                  </table>



                </div>
                <div id="datasrunlock"></div>
              </div>
              <?php
            } else if ($_GET['customercode'] == 'TTASTCS') {
              ?>

              <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div id="datadefunlock">

                  <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                    <thead>
                      <tr>
                        <th style="text-align: center">No.</th>
                        <th style="text-align: center">Document</th>
                        <th style="text-align: center">D/M/Y</th>
                        <th style="text-align: center">Driver</th>

                        <th style="text-align: center;">

                          ปลดล็อค

                        </th>

                      </tr>

                    </thead>
                    <tbody>
                      <?php
                      $i = 1;
                      $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                      $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

                      $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                      $params_seBilling = array(
                        array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                        array($condBilling1, SQLSRV_PARAM_IN),
                        array($condBilling2, SQLSRV_PARAM_IN)
                      );


                      $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                      while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                        $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                        $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                        $params_seEmployeeehr = array(
                          array('select_employeeehr2', SQLSRV_PARAM_IN),
                          array($condEmployeeehr1, SQLSRV_PARAM_IN)
                        );
                        $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                        $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                        ?>
                        <tr>
                          <td style="text-align: center"><?= $i ?></td>
                          <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                          <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                          <td><?= $result_seEmployeeehr['nameT'] ?></td>
                          <td style="text-align: center">
                            <?php
                            if ($result_seBilling['BILLINGSTATUS'] == '1') {
                              ?>
                              <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                              <?php
                            }
                            ?>

                          </td>


                        </tr>
                        <?php
                        $i++;
                      }
                      ?>
                    </tbody>


                  </table>



                </div>
                <div id="datasrunlock"></div>
              </div>
              <?php
            } else if ($_GET['customercode'] == 'TTTCSTC') {
              ?>

              <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div id="datadefunlock">

                  <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-exampleunlock" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                    <thead>
                      <tr>
                        <th style="text-align: center">No.</th>
                        <th style="text-align: center">Document</th>
                        <th style="text-align: center">D/M/Y</th>
                        <th style="text-align: center">Driver</th>

                        <th style="text-align: center;">

                          ปลดล็อค

                        </th>

                      </tr>

                    </thead>
                    <tbody>
                      <?php
                      $i = 1;
                      $condBilling1 = " AND CONVERT(DATE,b.DATEVLIN) = CONVERT(DATE,GETDATE()) AND BILLINGSTATUS ='1'";
                      $condBilling2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' AND b.MATERIALTYPE = '' AND a.DOCUMENTCODE != '' ";

                      $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?)}";
                      $params_seBilling = array(
                        array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                        array($condBilling1, SQLSRV_PARAM_IN),
                        array($condBilling2, SQLSRV_PARAM_IN)
                      );


                      $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                      while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                        $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "'";
                        $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                        $params_seEmployeeehr = array(
                          array('select_employeeehr2', SQLSRV_PARAM_IN),
                          array($condEmployeeehr1, SQLSRV_PARAM_IN)
                        );
                        $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                        $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                        ?>
                        <tr>
                          <td style="text-align: center"><?= $i ?></td>
                          <td><?= $result_seBilling['DOCUMENTCODE'] ?></td>
                          <td><?= $result_seBilling['DATE_VLIN'] ?></td>
                          <td><?= $result_seEmployeeehr['nameT'] ?></td>
                          <td style="text-align: center">
                            <?php
                            if ($result_seBilling['BILLINGSTATUS'] == '1') {
                              ?>
                              <input type="checkbox" checked="" style="transform: scale(2)" id="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>" name="chk_invoice<?= $result_seBilling['DOCUMENTCODE'] ?>"  class="form-control"  onchange="save_unlogselect('<?= $result_seBilling['DOCUMENTCODE'] ?>')">
                              <?php
                            }
                            ?>

                          </td>


                        </tr>
                        <?php
                        $i++;
                      }
                      ?>

                    </tbody>


                  </table>



                </div>
                <div id="datasrunlock"></div>
              </div>
              <?php
            }
          }
        }
        ?>
        <!-- /.panel-body -->
      </div>
    </div>
  </div>
</div>

<!-- /.panel -->
</div>
</div>
</div>
</div>

</div>

<!--<script src="../vendor/jquery/jquery.min.js"></script>-->
<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="../vendor/metisMenu/metisMenu.min.js"></script>
<script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
<script src="../dist/js/sb-admin-2.js"></script>
<script src="../js/jquery.datetimepicker.full.js"></script>

<script src="../dist/js/jszip.min.js"></script>
<script src="../dist/js/dataTables.buttons.min.js"></script>
<script src="../dist/js/buttons.html5.min.js"></script>
<script src="../dist/js/buttons.print.min.js"></script>
<script src="../dist/js/bootstrap-select.js"></script>
<script src="../dist/js/jquery.autocomplete.js"></script>


<script type="text/javascript">
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
function show_billing(companycode, customercode, billing, vehicletransportplanid) {


  $.ajax({
    url: 'meg_data.php',
    type: 'POST',
    data: {
      txt_flg: "show_updatebilling", companycode: companycode, customercode: customercode, billing: billing, vehicletransportplanid: vehicletransportplanid
    },
    success: function (rs) {
      document.getElementById("updatebilling").innerHTML = rs;
    }
  });


}
function save_billing(vehicletransportplanid) {


  $.ajax({
    url: 'meg_data.php',
    type: 'POST',
    data: {
      txt_flg: "save_updatebilling", companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', customercodeupd: document.getElementById('cb_updatebillingcus').value, billingupd: document.getElementById('cb_updatebilling').value, vehicletransportplanid: vehicletransportplanid, datestart: document.getElementById('txt_datestart').value, dateend: document.getElementById('txt_dateend').value, billing: document.getElementById('cb_billing').value
    },
    success: function () {

      window.location.reload();
    }
  });


}
function editvar_vehicletransportpricepp(editableObj, fieldname, IDPRICE, IDPLAN) {

  var dataedit = editableObj.innerHTML;
  $.ajax({
    url: 'meg_data.php',
    type: 'POST',
    data: {
      txt_flg: "edit_vehicletransportprice", editableObj: dataedit, ID: IDPRICE, fieldname: fieldname
    },
    success: function () {

    }
  });

  $.ajax({
    url: 'meg_data.php',
    type: 'POST',
    data: {
      txt_flg: "edit_vehicletransportdocumentdriver", editableObj: dataedit, ID: IDPLAN, fieldname: 'ACTUALPRICE'
    },
    success: function () {

    }
  });
}
function save_unlogselect(logselect)
{
  $.ajax({
    type: 'post',
    url: 'meg_data.php',
    data: {
      txt_flg: "edit_vehicletransportdocumentdriverdoc", editableObj: '', ID: logselect, fieldname: 'BILLINGSTATUS'
    },
    success: function () {


    }
  });
  /*$.ajax({
  type: 'post',
  url: 'meg_data.php',
  data: {
  txt_flg: "edit_vehicletransportdocumentdriverdoc", editableObj: '', ID: logselect, fieldname: 'DOCUMENTCODE'
},
success: function () {


}
});
*/

select_invoiceunlock();

}
/*function save_logselect(logselect, employeecode, employeecodechk)
{



$.ajax({
type: 'post',
url: 'meg_data.php',
data: {
txt_flg: "save_logselect", logselect: logselect, employeecode: employeecode, employeecodechk: employeecodechk
},
success: function () {


}
});

}*/
function delete_invoice(invoicecode)
{


  $.ajax({
    type: 'post',
    url: 'meg_data.php',
    data: {
      txt_flg: "delete_invoicepallet", invoicecode: invoicecode
    },
    success: function (rs) {

      alert('ลบข้อมูลเรียบร้อยแล้ว');
      window.location.reload();
    }
  });
  //}
}


function edit_invoince(editableObj, fieldname, ID)
{
  var dataedit = editableObj.innerHTML;
  $.ajax({
    url: 'meg_data.php',
    type: 'POST',
    data: {
      txt_flg: "edit_invoince", editableObj: dataedit, ID: ID, fieldname: fieldname
    },
    success: function () {

    }
  });
}

$(function () {
  $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
  // กรณีใช้แบบ input
  $(".dateen").datetimepicker({
    timepicker: false,
    format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


  });
});
function select_invoice()
{
  var jobstart = "";

  var billing = '';
  var datestart = document.getElementById('txt_datestart').value;
  var dateend = document.getElementById('txt_dateend').value;
  var materialtype = '';
  var jobend = '';
  var route = '';
  var billing = '';



  $.ajax({
    type: 'post',
    url: 'meg_data.php',
    data: {
      txt_flg: "select_invoicepallet", companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', datestart: datestart, dateend: dateend, materialtype: materialtype, jobstart: jobstart, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing
    },
    success: function (response) {
      if (response)
      {



        document.getElementById("datasr").innerHTML = response;
        document.getElementById("datadef").innerHTML = "";

      }

      $(document).ready(function () {
        $('#dataTables-example').DataTable({
          responsive: true
        });


      });

      save_logprocess('Invoice', 'Select Invoicepallet', '<?= $result_seLogin['PersonCode'] ?>');
    }
  });
  //}
}
function select_invoiceunlock()
{

  var datestart = document.getElementById('txt_datestartunlock').value;
  var dateend = document.getElementById('txt_dateendunlock').value;
  var materialtype = "";
  if ('<?= $_GET['companycode'] ?>' == 'RRC') {
    if ('<?= $_GET['customercode'] ?>' == 'GMT' || '<?= $_GET['customercode'] ?>' == 'BP') {
      var materialtype = document.getElementById('cb_materialtypeunlock').value;
    }
  }

  $.ajax({
    type: 'post',
    url: 'meg_data.php',
    data: {
      txt_flg: "select_invoiceunlock", companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', datestart: datestart, dateend: dateend, materialtype: materialtype, carrytype: '<?= $_GET['carrytype'] ?>'
    },
    success: function (response) {
      if (response)
      {

        document.getElementById("datasrunlock").innerHTML = response;
        document.getElementById("datadefunlock").innerHTML = "";

      }

      $(document).ready(function () {
        $('#dataTables-exampleunlock').DataTable({
          responsive: true
        });


      });

      save_logprocess('Invoice', 'Select Invoiceunlockpallet', '<?= $result_seLogin['PersonCode'] ?>');
    }
  });
  //}
}
function select_invoicedetail()
{
  var datestartdetail = document.getElementById('txt_datestartdetail').value;
  var dateenddetail = document.getElementById('txt_dateenddetail').value;


  $.ajax({
    type: 'post',
    url: 'meg_data.php',
    data: {
      txt_flg: "select_invoicedetailpallet", datestartdetail: datestartdetail, dateenddetail: dateenddetail, companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', carrytype: '<?= $_GET['carrytype'] ?>'
    },
    success: function (response) {
      if (response)
      {

        document.getElementById("datadetailsr").innerHTML = response;
        document.getElementById("datadetaildef").innerHTML = "";
      }

      $(document).ready(function () {

        $('#dataTables-example1').DataTable({
          responsive: true
        });
      });

      save_logprocess('Invoice', 'Select Invoicedetailpallet', '<?= $result_seLogin['PersonCode'] ?>');
    }
  });
  //}
}

</script>
<script type="text/javascript">

function add_invoice()
{

  var invoicecode = document.getElementById('txt_invoicecode').value;
  var expresswaycode = document.getElementById('txt_expresswaycode').value;
  var datestart = document.getElementById('txt_datestart').value;
  var dateend = document.getElementById('txt_dateend').value;
  var jobend = '';

  var route = '';
  var dulydate = document.getElementById('txt_dulydate').value;

  var billing = 'pallet';
  if ('<?= $_GET['companycode'] ?>' == 'RRC')
  {
    if ('<?= $_GET['customercode'] ?>' == 'GMT') {
      var jobstart = document.getElementById('cb_copydiagramjobstart').value;
      var materialtype = document.getElementById('cb_materialtype').value;
      $.ajax({
        url: 'meg_data.php',
        type: 'POST',
        data: {
          txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: materialtype, companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: jobend, jobstart: jobstart, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: materialtype,dulydate:dulydate
        },
        success: function () {

          reload();
        }
      });
    } else if ('<?= $_GET['customercode'] ?>' == 'BP') {
      var materialtype = document.getElementById('cb_materialtype').value;
      $.ajax({
        url: 'meg_data.php',
        type: 'POST',
        data: {
          txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
        },
        success: function () {

          reload();
        }
      });
    } else if ('<?= $_GET['customercode'] ?>' == 'TTAST') {

      $.ajax({
        url: 'meg_data.php',
        type: 'POST',
        data: {
          txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
        },
        success: function () {
          reload();
        }
      });
    }
  } else if ('<?= $_GET['companycode'] ?>' == 'RKS')
  {
    if ('<?= $_GET['customercode'] ?>' == 'TAW') {

      $.ajax({
        url: 'meg_data.php',
        type: 'POST',
        data: {
          txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
        },
        success: function () {

          reload();
        }
      });
    } else if ('<?= $_GET['customercode'] ?>' == 'TGT') {



      $.ajax({
        url: 'meg_data.php',
        type: 'POST',
        data: {
          txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
        },
        success: function () {
          reload();

        }
      });
    } else if ('<?= $_GET['customercode'] ?>' == 'DENSO-THAI') {



      $.ajax({
        url: 'meg_data.php',
        type: 'POST',
        data: {
          txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
        },
        success: function () {


          reload();
        }
      });
    } else if ('<?= $_GET['customercode'] ?>' == 'TMT') {



      $.ajax({
        url: 'meg_data.php',
        type: 'POST',
        data: {
          txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
        },
        success: function () {


          reload();
        }
      });
    } else if ('<?= $_GET['customercode'] ?>' == 'STM') {



      $.ajax({
        url: 'meg_data.php',
        type: 'POST',
        data: {
          txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
        },
        success: function () {


          reload();
        }
      });
    } else if ('<?= $_GET['customercode'] ?>' == 'DAIKI') {



      $.ajax({
        url: 'meg_data.php',
        type: 'POST',
        data: {
          txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
        },
        success: function () {


          reload();
        }
      });
    } else if ('<?= $_GET['customercode'] ?>' == 'GMT') {



      $.ajax({
        url: 'meg_data.php',
        type: 'POST',
        data: {
          txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
        },
        success: function () {


          reload();
        }
      });
    } else if ('<?= $_GET['customercode'] ?>' == 'TKT') {



      $.ajax({
        url: 'meg_data.php',
        type: 'POST',
        data: {
          txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
        },
        success: function () {


          reload();
        }
      });
    }

  } else if ('<?= $_GET['companycode'] ?>' == 'RKR')
  {
    if ('<?= $_GET['carrytype'] ?>' == 'trip')
    {
      if ('<?= $_GET['customercode'] ?>' == 'DAIKI') {
        $.ajax({
          url: 'meg_data.php',
          type: 'POST',
          data: {
            txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
          },
          success: function () {


            reload();
          }
        });
      } else if ('<?= $_GET['customercode'] ?>' == 'TTPRO') {



        $.ajax({
          url: 'meg_data.php',
          type: 'POST',
          data: {
            txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
          },
          success: function () {


            reload();
          }
        });
      } else if ('<?= $_GET['customercode'] ?>' == 'TTAST') {



        $.ajax({
          url: 'meg_data.php',
          type: 'POST',
          data: {
            txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
          },
          success: function () {


            reload();
          }
        });
      } else if ('<?= $_GET['customercode'] ?>' == 'TTAT') {



        $.ajax({
          url: 'meg_data.php',
          type: 'POST',
          data: {
            txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
          },
          success: function () {


            reload();
          }
        });
      } else if ('<?= $_GET['customercode'] ?>' == 'TMT') {



        $.ajax({
          url: 'meg_data.php',
          type: 'POST',
          data: {
            txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
          },
          success: function () {


            reload();
          }
        });
      } else if ('<?= $_GET['customercode'] ?>' == 'TGT') {



        $.ajax({
          url: 'meg_data.php',
          type: 'POST',
          data: {
            txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
          },
          success: function () {


            reload();
          }
        });
      } else if ('<?= $_GET['customercode'] ?>' == 'YNP') {



        $.ajax({
          url: 'meg_data.php',
          type: 'POST',
          data: {
            txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
          },
          success: function () {


            reload();
          }
        });
      } else if ('<?= $_GET['customercode'] ?>' == 'GMT') {



        $.ajax({
          url: 'meg_data.php',
          type: 'POST',
          data: {
            txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
          },
          success: function () {


            reload();
          }
        });
      }
    } else if ('<?= $_GET['carrytype'] ?>' == 'weight')
    {
      if ('<?= $_GET['customercode'] ?>' == 'TTPROSTC') {



        $.ajax({
          url: 'meg_data.php',
          type: 'POST',
          data: {
            txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
          },
          success: function () {


            reload();
          }
        });
      } else if ('<?= $_GET['customercode'] ?>' == 'TTASTSTC') {



        $.ajax({
          url: 'meg_data.php',
          type: 'POST',
          data: {
            txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
          },
          success: function () {


            reload();
          }
        });
      } else if ('<?= $_GET['customercode'] ?>' == 'TTASTCS') {



        $.ajax({
          url: 'meg_data.php',
          type: 'POST',
          data: {
            txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
          },
          success: function () {


            reload();
          }
        });
      } else if ('<?= $_GET['customercode'] ?>' == 'DAIKI') {



        $.ajax({
          url: 'meg_data.php',
          type: 'POST',
          data: {
            txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
          },
          success: function () {


            reload();
          }
        });
      }
    }
  } else if ('<?= $_GET['companycode'] ?>' == 'RKL')
  {
    if ('<?= $_GET['carrytype'] ?>' == 'trip')
    {
      if ('<?= $_GET['customercode'] ?>' == 'SKB') {
        $.ajax({
          url: 'meg_data.php',
          type: 'POST',
          data: {
            txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
          },
          success: function () {


            reload();
          }
        });
      } else if ('<?= $_GET['customercode'] ?>' == 'TTTC') {
        $.ajax({
          url: 'meg_data.php',
          type: 'POST',
          data: {
            txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
          },
          success: function () {


            reload();
          }
        });
      } else if ('<?= $_GET['customercode'] ?>' == 'CH-AUTO') {
        $.ajax({
          url: 'meg_data.php',
          type: 'POST',
          data: {
            txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
          },
          success: function () {


            reload();
          }
        });
      } else if ('<?= $_GET['customercode'] ?>' == 'TTAT') {
        $.ajax({
          url: 'meg_data.php',
          type: 'POST',
          data: {
            txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
          },
          success: function () {


            reload();
          }
        });
      } else if ('<?= $_GET['customercode'] ?>' == 'TKT') {
        $.ajax({
          url: 'meg_data.php',
          type: 'POST',
          data: {
            txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
          },
          success: function () {


            reload();
          }
        });
      } else if ('<?= $_GET['customercode'] ?>' == 'TSAT') {
        $.ajax({
          url: 'meg_data.php',
          type: 'POST',
          data: {
            txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
          },
          success: function () {


            reload();
          }
        });
      } else if ('<?= $_GET['customercode'] ?>' == 'YNP') {
        $.ajax({
          url: 'meg_data.php',
          type: 'POST',
          data: {
            txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
          },
          success: function () {


            reload();
          }
        });
      } else if ('<?= $_GET['customercode'] ?>' == 'WSBT') {
        $.ajax({
          url: 'meg_data.php',
          type: 'POST',
          data: {
            txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
          },
          success: function () {


            reload();
          }
        });
      } else if ('<?= $_GET['customercode'] ?>' == 'TMT') {
        $.ajax({
          url: 'meg_data.php',
          type: 'POST',
          data: {
            txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
          },
          success: function () {


            reload();
          }
        });
      } else if ('<?= $_GET['customercode'] ?>' == 'NITTSUSHOJI') {
        $.ajax({
          url: 'meg_data.php',
          type: 'POST',
          data: {
            txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
          },
          success: function () {


            reload();
          }
        });
      }
    } else if ('<?= $_GET['carrytype'] ?>' == 'weight')
    {
      if ('<?= $_GET['customercode'] ?>' == 'DAIKI') {
        $.ajax({
          url: 'meg_data.php',
          type: 'POST',
          data: {
            txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
          },
          success: function () {


            reload();
          }
        });
      } else if ('<?= $_GET['customercode'] ?>' == 'TTPROSTC') {



        $.ajax({
          url: 'meg_data.php',
          type: 'POST',
          data: {
            txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
          },
          success: function () {


            reload();
          }
        });
      } else if ('<?= $_GET['customercode'] ?>' == 'TTASTSTC') {



        $.ajax({
          url: 'meg_data.php',
          type: 'POST',
          data: {
            txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
          },
          success: function () {


            reload();
          }
        });
      } else if ('<?= $_GET['customercode'] ?>' == 'TTASTCS') {



        $.ajax({
          url: 'meg_data.php',
          type: 'POST',
          data: {
            txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
          },
          success: function () {


            reload();
          }
        });
      } else if ('<?= $_GET['customercode'] ?>' == 'TTTCSTC') {



        $.ajax({
          url: 'meg_data.php',
          type: 'POST',
          data: {
            txt_flg: "add_loginvoicepallet", datestart: datestart, dateend: dateend, materialtype: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', invoicecode: invoicecode, expresswaycode: expresswaycode, jobend: jobend, route: route, carrytype: '<?= $_GET['carrytype'] ?>', billing: billing,dulydate:dulydate
          },
          success: function () {


            reload();
          }
        });
      }
    }
  }
  save_logprocess('Invoice', 'Save Invoicepallet', '<?= $result_seLogin['PersonCode'] ?>');
}




function excel_rrcgmt(invoicecode)
{
  save_logprocess('Invoice', 'Excel Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_invoicegmt1.php?invoicecode=' + invoicecode, '_blank');

}
function pdf_invoicegmt(invoicecode)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_invoicegmt1.php?invoicecode=' + invoicecode, '_blank');

}
function excel_rkstaw(invoicecode)
{
  save_logprocess('Invoice', 'Excel Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('excel_billingrkstaw.php?invoicecode=' + invoicecode, '_blank');

}
function pdf_invoicerkstaw(invoicecode)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_invoicerkstaw1.php?invoicecode=' + invoicecode, '_blank');
}
function excel_rkstgt(invoicecode, transportation)
{
  save_logprocess('Invoice', 'Excel Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  var tran = transportation.split("+");
  if (typeof tran[1] == 'undefined')
  {
    window.open('excel_billingrkstgtpallet.php?invoicecode=' + invoicecode + '&transportation=' + transportation + '&companycode=<?= $_GET['companycode'] ?>&customercode=<?= $_GET['customercode'] ?>', '_blank');


  } else {
    window.open('excel_billingrkstgtpallet.php?invoicecode=' + invoicecode + '&transportation1=' + tran[0] + '&transportation2=' + tran[1] + '&companycode=<?= $_GET['companycode'] ?>&customercode=<?= $_GET['customercode'] ?>', '_blank');

  }

}
function pdf_invoicerkstgt(invoicecode, transportation)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  var tran = transportation.split("+");
  if (typeof tran[1] == 'undefined')
  {
    window.open('pdf_invoicerkstgtpallet1.php?invoicecode=' + invoicecode + '&transportation=' + transportation + '&companycode=<?= $_GET['companycode'] ?>&customercode=<?= $_GET['customercode'] ?>', '_blank');


  } else {
    window.open('pdf_invoicerkstgtpallet1.php?invoicecode=' + invoicecode + '&transportation1=' + tran[0] + '&transportation2=' + tran[1] + '&companycode=<?= $_GET['companycode'] ?>&customercode=<?= $_GET['customercode'] ?>', '_blank');

  }


}
function pdf_invoicerkstgt2(invoicecode, transportation)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  var tran = transportation.split("+");
  if (typeof tran[1] == 'undefined')
  {
    window.open('pdf_invoicerkstgtpallet2.php?invoicecode=' + invoicecode + '&transportation=' + transportation + '&companycode=<?= $_GET['companycode'] ?>&customercode=<?= $_GET['customercode'] ?>', '_blank');


  } else {
    window.open('pdf_invoicerkstgtpallet2.php?invoicecode=' + invoicecode + '&transportation1=' + tran[0] + '&transportation2=' + tran[1] + '&companycode=<?= $_GET['companycode'] ?>&customercode=<?= $_GET['customercode'] ?>', '_blank');

  }

}
function excel_rksdensothai(invoicecode)
{
  save_logprocess('Invoice', 'Excel Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('excel_billingrksdensothai.php?invoicecode=' + invoicecode, '_blank');

}
function pdf_invoicerksdensothai(invoicecode)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_invoicerksdensothai1.php?invoicecode=' + invoicecode + '&startdate=' + document.getElementById('txt_datestart').value + '&enddate=' + document.getElementById('txt_dateend').value, '_blank');
}
function excel_rkstmt(invoicecode)
{
  save_logprocess('Invoice', 'Excel Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('excel_billingrkstmt.php?invoicecode=' + invoicecode, '_blank');


}
function pdf_invoicerkstmt(invoicecode)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_invoicerkstmt1.php?invoicecode=' + invoicecode + '&startdate=' + document.getElementById('txt_datestart').value + '&enddate=' + document.getElementById('txt_dateend').value, '_blank');
}
function excel_rksstm(invoicecode)
{
  save_logprocess('Invoice', 'Excel Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('excel_billingrksstm.php?invoicecode=' + invoicecode, '_blank');

}
function pdf_invoicerksstm(invoicecode)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_invoicerksstm1.php?invoicecode=' + invoicecode + '&startdate=' + document.getElementById('txt_datestart').value + '&enddate=' + document.getElementById('txt_dateend').value, '_blank');
}
function excel_rksdaiki(invoicecode)
{
  save_logprocess('Invoice', 'Excel Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('excel_billingrksdaiki.php?invoicecode=' + invoicecode + '&startdate=' + document.getElementById('txt_datestart').value + '&enddate=' + document.getElementById('txt_dateend').value, '_blank');

}
function pdf_invoicerksdaiki(invoicecode)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_invoicerksdaiki1.php?invoicecode=' + invoicecode + '&startdate=' + document.getElementById('txt_datestart').value + '&enddate=' + document.getElementById('txt_dateend').value, '_blank');
}
function excel_rksgmt(invoicecode)
{
  save_logprocess('Invoice', 'Excel Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('excel_billingrksgmt.php?invoicecode=' + invoicecode, '_blank');

}
function pdf_invoicerksgmt(invoicecode)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_invoicerksgmt1.php?invoicecode=' + invoicecode + '&startdate=' + document.getElementById('txt_datestart').value + '&enddate=' + document.getElementById('txt_dateend').value, '_blank');
}
function excel_rkstkt(invoicecode)
{
  save_logprocess('Invoice', 'Excel Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('excel_billingrkstkt.php?invoicecode=' + invoicecode, '_blank');

}
function pdf_invoicerkstkt(invoicecode)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_invoicerkstkt1.php?invoicecode=' + invoicecode + '&startdate=' + document.getElementById('txt_datestart').value + '&enddate=' + document.getElementById('txt_dateend').value, '_blank');
}
function reload()
{
  location.reload();
}
function excel_rrcbp(invoicecode)
{
  save_logprocess('Invoice', 'Excel Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('excel_billingrrcbp.php?invoicecode=' + invoicecode, '_blank');

}
function pdf_invoicebp(invoicecode)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_invoicebp1.php?invoicecode=' + invoicecode, '_blank');
}
function excel_rrcttast(invoicecode)
{
  save_logprocess('Invoice', 'Excel Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('excel_billingrrcttast.php?invoicecode=' + invoicecode, '_blank');

}
function pdf_invoicettast(invoicecode)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_invoicettast1.php?invoicecode=' + invoicecode, '_blank');
}
function excel_rkrdaiki(invoicecode)
{
  save_logprocess('Invoice', 'Excel Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('excel_billingrkrdaiki.php?invoicecode=' + invoicecode, '_blank');

}
function pdf_invoicerkrdaiki(invoicecode)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_invoicerkrdaiki1.php?invoicecode=' + invoicecode, '_blank');
}
function excel_rkrttpro(invoicecode)
{
  save_logprocess('Invoice', 'Excel Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('excel_billingrkrttpro.php?invoicecode=' + invoicecode, '_blank');

}
function pdf_invoicerkrttpro(invoicecode)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_invoicerkrttpro1.php?invoicecode=' + invoicecode, '_blank');
}
function excel_rkrttast(invoicecode)
{
  save_logprocess('Invoice', 'Excel Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('excel_billingrkrttast.php?invoicecode=' + invoicecode, '_blank');

}
function pdf_invoicerkrttast(invoicecode)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_invoicerkrttast1.php?invoicecode=' + invoicecode, '_blank');
}
function excel_rkrttat(invoicecode)
{
  save_logprocess('Invoice', 'Excel Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('excel_billingrkrttat.php?invoicecode=' + invoicecode, '_blank');

}
function pdf_invoicerkrtmt(invoicecode)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_invoicerkrtmt1.php?invoicecode=' + invoicecode, '_blank');
}
function pdf_invoicerkrtgt(invoicecode)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_invoicerkrtgt1.php?invoicecode=' + invoicecode, '_blank');
}
function pdf_invoicerkrynp(invoicecode)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_invoicerkrynp1.php?invoicecode=' + invoicecode, '_blank');
}
function pdf_invoicerkrgmt(invoicecode)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_invoicerkrgmt1.php?invoicecode=' + invoicecode, '_blank');
}


function pdf_invoicerkrttat(invoicecode)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_invoicerkrttat1.php?invoicecode=' + invoicecode, '_blank');
}

function excel_rkrttprostc(invoicecode)
{
  save_logprocess('Invoice', 'Excel Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('excel_billingrkrttprostc.php?invoicecode=' + invoicecode, '_blank');

}
function pdf_invoicerkrttprostc(invoicecode)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_invoicerkrttprostc1.php?invoicecode=' + invoicecode + '&companycode=<?= $_GET['companycode'] ?>&customercode=<?= $_GET['customercode'] ?>', '_blank');

}
function excel_rkrttaststc(invoicecode)
{
  save_logprocess('Invoice', 'Excel Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('excel_billingrkrttaststc.php?invoicecode=' + invoicecode + '&companycode=<?= $_GET['companycode'] ?>&customercode=<?= $_GET['customercode'] ?>', '_blank');
}

// Function Print ใบวางบิล Pallet
function excel_billingrkrttaststcpallet(invoicecode)
{
  save_logprocess('Invoice', 'Excel Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('excel_billingrkrttaststcpallet.php?invoicecode=' + invoicecode + '&companycode=<?= $_GET['companycode'] ?>&customercode=<?= $_GET['customercode'] ?>', '_blank');
}
function pdf_billingrkrttaststcpallet(invoicecode)
{
  save_logprocess('Invoice', 'PDF Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_billingrkrttaststcpallet.php?invoicecode=' + invoicecode + '&companycode=<?= $_GET['companycode'] ?>&customercode=<?= $_GET['customercode'] ?>', '_blank');
}
function excel_billingrklttaststcpallet(invoicecode)
{
  save_logprocess('Invoice', 'Excel Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('excel_billingrklttaststcpallet.php?invoicecode=' + invoicecode + '&companycode=<?= $_GET['companycode'] ?>&customercode=<?= $_GET['customercode'] ?>', '_blank');
}
function pdf_billingrklttaststcpallet(invoicecode)
{
  save_logprocess('Invoice', 'PDF Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_billingrklttaststcpallet.php?invoicecode=' + invoicecode + '&companycode=<?= $_GET['companycode'] ?>&customercode=<?= $_GET['customercode'] ?>', '_blank');
}
///////////////////////////////////////////////////
function pdf_invoicerkrttaststc(invoicecode)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_invoicerkrttaststc1.php?invoicecode=' + invoicecode + '&companycode=<?= $_GET['companycode'] ?>&customercode=<?= $_GET['customercode'] ?>', '_blank');
}
function excel_rkrttastcs(invoicecode)
{
  save_logprocess('Invoice', 'Excel Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('excel_billingrkrttastcs.php?invoicecode=' + invoicecode, '_blank');
}
function excel_rkrdaikiton(invoicecode)
{
  save_logprocess('Invoice', 'Excel Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('excel_rkrdaikiton.php?invoicecode=' + invoicecode, '_blank');
}

function pdf_invoicerkrttastcs(invoicecode)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_invoicerkrttastcs1.php?invoicecode=' + invoicecode + '&companycode=<?= $_GET['companycode'] ?>&customercode=<?= $_GET['customercode'] ?>', '_blank');
}
function pdf_invoicerkrdaikiton(invoicecode)
{
  window.open('pdf_invoicerkrdaikiton1.php?invoicecode=' + invoicecode + '&companycode=<?= $_GET['companycode'] ?>&customercode=<?= $_GET['customercode'] ?>', '_blank');
}

function excel_rkldaikiton(invoicecode)
{
  save_logprocess('Invoice', 'Excel Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('excel_billingrkldaikiton.php?invoicecode=' + invoicecode, '_blank');
}
function pdf_invoicerkldaikiton(invoicecode)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_invoicerkldaikiton1.php?invoicecode=' + invoicecode, '_blank');
}
function excel_rklttprostc(invoicecode)
{
  save_logprocess('Invoice', 'Excel Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('excel_billingrklttprostc.php?invoicecode=' + invoicecode, '_blank');
}
function pdf_invoicerklttprostc(invoicecode)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_invoicerklttprostc1.php?invoicecode=' + invoicecode, '_blank');
}
function excel_rklttaststc(invoicecode)
{
  save_logprocess('Invoice', 'Excel Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('excel_billingrklttaststc.php?invoicecode=' + invoicecode, '_blank');
}
function pdf_invoicerklttaststc(invoicecode)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_invoicerklttaststc1.php?invoicecode=' + invoicecode, '_blank');
}
function excel_rklttastcs(invoicecode)
{
  save_logprocess('Invoice', 'Excel Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('excel_billingrklttastcs.php?invoicecode=' + invoicecode, '_blank');
}
function pdf_invoicerklttastcs(invoicecode)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_invoicerklttastcs1.php?invoicecode=' + invoicecode, '_blank');
}
function excel_rkltttcstc(invoicecode)
{
  save_logprocess('Invoice', 'Excel Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('excel_billingrkltttcstc.php?invoicecode=' + invoicecode, '_blank');
}
function pdf_invoicerkltttcstc(invoicecode)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_invoicerkltttcstc1.php?invoicecode=' + invoicecode, '_blank');
}
function pdf_invoicerklskb(invoicecode)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_invoicerklskb1.php?invoicecode=' + invoicecode + '&companycode=<?= $_GET['companycode'] ?>&customercode=<?= $_GET['customercode'] ?>', '_blank');
}
function pdf_invoicerkltttc(invoicecode)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_invoicerkltttc1.php?invoicecode=' + invoicecode, '_blank');
}
function pdf_invoicerklchauto(invoicecode)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_invoicerklchauto1.php?invoicecode=' + invoicecode, '_blank');
}
function pdf_invoicerklttat(invoicecode)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_invoicerklttat1.php?invoicecode=' + invoicecode, '_blank');
}
function pdf_invoicerkltkt(invoicecode)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_invoicerkltkt1.php?invoicecode=' + invoicecode, '_blank');
}
function pdf_invoicerkltsat(invoicecode)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_invoicerkltsat1.php?invoicecode=' + invoicecode, '_blank');
}
function pdf_invoicerklynp(invoicecode)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_invoicerklynp1.php?invoicecode=' + invoicecode, '_blank');
}
function pdf_invoicerklwsbt(invoicecode)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_invoicerklwsbt1.php?invoicecode=' + invoicecode, '_blank');
}
function pdf_invoicerkltmt(invoicecode)
{
  window.open('pdf_invoicerkltmt1.php?invoicecode=' + invoicecode, '_blank');
}
function pdf_invoicerklnittsushoji(invoicecode)
{
  save_logprocess('Invoice', 'Print Logbilling', '<?= $result_seLogin['PersonCode'] ?>');
  window.open('pdf_invoicerklnittsushoji1.php?invoicecode=' + invoicecode, '_blank');
}





function gdatetodate()
{
  document.getElementById('txt_gdateend').value = document.getElementById('txt_gdatestart').value;
}
function datetodate()
{
  document.getElementById('txt_dateend').value = document.getElementById('txt_datestart').value;
  document.getElementById('txt_dateendunlock').value = document.getElementById('txt_datestartunlock').value;
  document.getElementById('txt_dateenddetail').value = document.getElementById('txt_datestartdetail').value;
}


</script>
<script>
$(document).ready(function () {
  $('#dataTables-example').DataTable({
    responsive: true
  });
  $('#dataTables-example1').DataTable({
    responsive: true
  });
  $(document).ready(function () {
    $('#dataTables-exampleunlock').DataTable({
      responsive: true
    });
  });
});
</script>

</body>

</html>
<?php
sqlsrv_close($conn);
?>
