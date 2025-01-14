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

$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

$billingcode = create_billing();
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



        <div id="wrapper">
            <?php
            if ($_GET['companycode'] == 'RKS' && $_GET['customercode'] == 'TMT') {
                ?>
                <div class="modal fade" id="modal_insbilling" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="row" >
                                    <div class="col-lg-12">
                                        <p id="pbillingcode"></p>
                                    </div>

                                </div>

                            </div>
                            <div class="modal-body">
                                <div class="row" >
                                    <div class="col-lg-4">
                                        <div class="form-group">

                                            <label>วันที่ : </label>
                                            <input class="form-control" readonly="" id="txt_billingid" name="txt_billingid" style="display: none" >
                                            <input class="form-control" readonly="" id="txt_billingcode" name="txt_billingcode" style="display: none" >
                                            <input class="form-control" readonly="" id="txt_invoicecode" name="txt_invoicecode" style="display: none" >

                                            <input class="form-control dateen" readonly="" onchange="datetodate();"  style="background-color: #f080802e" id="txt_billingdate" name="txt_billingdate" >

                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">

                                            <label>วันที่ครบกำหนด : </label>

                                            <input class="form-control dateen" readonly="" style="background-color: #f080802e" id="txt_paymentdate" name="txt_paymentdate" >

                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">

                                            <label>วันที่วางบิลTMT : </label>

                                            <input class="form-control dateen" readonly="" style="background-color: #f080802e" id="txt_datedue" name="txt_datedue" >

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">

                                            <label>เลข PR,PO ชุดที่1 : </label>

                                            <input type="text" class="form-control "  style="background-color: #f080802e" id="txt_prpo1" name="txt_prpo2" >

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">

                                            <label> จำนวนรอบ 6W,10W : </label>

                                            <input type="text" class="form-control "  style="background-color: #f080802e" id="txt_trip1" name="txt_trip1" >

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">

                                            <label>เลข PR,PO ชุดที่2 : </label>

                                            <input type="text" class="form-control "  style="background-color: #f080802e" id="txt_prpo2" name="txt_prpo2" >

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">

                                            <label>จำนวนรอบ 6W,10W : </label>

                                            <input type="text" class="form-control "  style="background-color: #f080802e" id="txt_trip2" name="txt_trip2" >

                                        </div>
                                    </div>
                                </div>
                                <div class="row">&nbsp;</div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                                <button type="button" class="btn btn-primary" onclick="save_billinginvoice()">บันทึก</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                ?>
                <div class="modal fade" id="modal_insbilling" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="row" >
                                    <div class="col-lg-12">
                                        <p id="pbillingcode"></p>
                                    </div>

                                </div>

                            </div>
                            <div class="modal-body">
                                <div class="row" >
                                    <div class="col-lg-4">
                                        <div class="form-group">

                                            <label>วันที่ : </label>
                                            <input class="form-control" readonly="" id="txt_billingid" name="txt_billingid" style="display: none" >
                                            <input class="form-control" readonly="" id="txt_billingcode" name="txt_billingcode" style="display: none" >
                                            <input class="form-control" readonly="" id="txt_invoicecode" name="txt_invoicecode" style="display: none" >

                                            <input class="form-control dateen" readonly="" onchange="datetodate();"  style="background-color: #f080802e" id="txt_billingdate" name="txt_billingdate" >

                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">

                                            <label>วันที่ครบกำหนด : </label>

                                            <input class="form-control dateen" readonly="" style="background-color: #f080802e" id="txt_paymentdate" name="txt_paymentdate" >

                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">

                                            <label>วันที่วางบิล : </label>

                                            <input class="form-control dateen" readonly="" style="background-color: #f080802e" id="txt_datedue" name="txt_datedue" >

                                        </div>
                                    </div>
                                </div>
                                <div class="row">&nbsp;</div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                                <button type="button" class="btn btn-primary" onclick="save_billinginvoice()">บันทึก</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
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
                            รายงานใบส่งสินค้า
                        </h2>
                    </div>
                    <!-- /.col-lg-12 -->
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
                                <?php
                                $meg = 'เอกสารวางบิล : ' . $_GET['billingcode'];
                                if ($_GET['companycode'] == 'RKL' || $_GET['companycode'] == 'RKS' || $_GET['companycode'] == 'RKR') {
                                    echo "<a href='report_companybillingamata.php'>บริษัท</a> / <a href='report_customerbillingamata.php?type=report&companycode=" . $_GET['companycode'] . "'>ลูกค้า</a> / <a href='report_billing.php?&companycode=" . $_GET['companycode'] . "&customercode=" . $_GET['customercode'] . "&carrytype=" . $_GET['carrytype'] . "'>รายงานเอกสารวางบิล</a> / " . $meg;
                                    $link = "<a href='report_companybillingamata.php?type=report'>บริษัท</a> / <a href='report_customerbillingamata.php?type=report&companycode=" . $_GET['companycode'] . "'>ลูกค้า</a> / <a href='report_billing.php'>รายงานเอกสารวางบิล</a> ";
                                } else {
                                    echo "<a href='report_companybillinggetway.php'>บริษัท</a> / <a href='report_customerbillinggetway.php?type=report&companycode=" . $_GET['companycode'] . "'>ลูกค้า</a> / <a href='report_billing.php?&companycode=" . $_GET['companycode'] . "&customercode=" . $_GET['customercode'] . "&carrytype=" . $_GET['carrytype'] . "'>รายงานเอกสารวางบิล</a> / " . $meg;
                                    $link = "<a href='report_companybillinggetway.php?type=report'>บริษัท</a> / <a href='report_customerbillinggetway.php?type=report&companycode=" . $_GET['companycode'] . "'>ลูกค้า</a> / <a href='report_billing.php'>รายงานเอกสารวางบิล</a> ";
                                }

                                $_SESSION["link"] = $link;
                                ?>

                            </div>
                            <!-- /.panel-heading -->

                            <div class="panel-body">


                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                    <div id="datadef">
                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                            <thead>
                                                <tr>

                                                    <th style="text-align: center;width: 10%">ลำดับ</th>
                                                    <th>เลขที่ใบกำกับ</th>
                                                    <th>วันที่</th>
                                                    <th>ครบกำหนด</th>

                                                    <th style="text-align: center;width: 10%"><a href="#" onclick="select_billinginvoince('<?= $_GET['billingcode'] ?>')">เพิ่มข้อมูล</a></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                if ($_GET['companycode'] == 'RKS') {
                                                    if ($_GET['customercode'] == 'DAIKI' || $_GET['customercode'] == 'NITTSUSHOJI' || $_GET['customercode'] == 'SWN' || $_GET['customercode'] == 'GMT' || $_GET['customercode'] == 'TAW' || $_GET['customercode'] == 'SWN'|| $_GET['customercode'] == 'TTTC'|| $_GET['customercode'] == 'THAITOHKEN') {
                                                        $condLogbilling1 = " AND a.BILLINGCODE = '" . $_GET['billingcode'] . "'";
                                                        $condLogbilling2 = "";
                                                        $sql_seLogbilling = "{call megLogbillinginvoice_v2(?,?,?)}";
                                                        $params_seLogbilling = array(
                                                            array('select_logbillinginvoice_all', SQLSRV_PARAM_IN),
                                                            array($condLogbilling1, SQLSRV_PARAM_IN),
                                                            array($condLogbilling2, SQLSRV_PARAM_IN)
                                                        );
                                                        $query_seLogbilling = sqlsrv_query($conn, $sql_seLogbilling, $params_seLogbilling);
                                                    } else {
                                                        $sql_seLogbilling = "SELECT DISTINCT a.DUEDATE,a.LOGBILLINGINVOICEID,a.COMPANYCODE,a.CUSTOMERCODE, a.BILLINGCODE, a.INVOICECODE, a.BILLINGDATE, a.PAYMENTDATE,a.PRPO1,a.TRIP1,a.PRPO2,a.TRIP2, a.SUMTOTAL, a.EXPRESSWAYAMT15, a.EXPRESSWAYAMT45, a.EXPRESSWAYAMT55, a.EXPRESSWAYAMT65, a.EXPRESSWAYAMT75, a.EXPRESSWAYAMT100, a.EXPRESSWAYAMT195, a.EXPRESSWAYAMT65RETURN, a.EXPRESSWAYAMT105RETURN, a.EXPRESSWAYPRICE15, a.EXPRESSWAYPRICE45, a.EXPRESSWAYPRICE55, a.EXPRESSWAYPRICE65, a.EXPRESSWAYPRICE75, a.EXPRESSWAYPRICE100, a.EXPRESSWAYPRICE195, a.EXPRESSWAYPRICE65RETURN, a.EXPRESSWAYPRICE105RETURN, a.ACTIVESTATUS, a.REMARK,b.EXPRESSWAYCODE FROM [dbo].[LOGBILLINGINVOICE] a
                                                            INNER JOIN [dbo].[LOGINVOICE] b ON a.INVOICECODE = b.INVOICECODE
                                                            WHERE a.ACTIVESTATUS = '1' AND a.BILLINGCODE = '" . $_GET['billingcode'] . "'";
                                                        $params_seLogbilling = array();
                                                        $query_seLogbilling = sqlsrv_query($conn, $sql_seLogbilling, $params_seLogbilling);
                                                    }
                                                } else if ($_GET['companycode'] == 'RKR') {
                                                    if ($_GET['customercode'] == 'TGT' || $_GET['customercode'] == 'TTAT' || $_GET['customercode'] == 'TTASTSTC' || $_GET['customercode'] == 'PARAGON' || $_GET['customercode'] == 'NITTSUSHOJI' || $_GET['customercode'] == 'DAIKI' || $_GET['customercode'] == 'TTAST' || $_GET['customercode'] == 'SUTT' || $_GET['customercode'] == 'CH-AUTO' || $_GET['customercode'] == 'TTTC' || $_GET['customercode'] == 'TTTCSTC' || $_GET['customercode'] == 'RNSTEEL' || $_GET['customercode'] == 'TSAT') {
                                                        $condLogbilling1 = " AND a.BILLINGCODE = '" . $_GET['billingcode'] . "'";
                                                        $condLogbilling2 = "";
                                                        $sql_seLogbilling = "{call megLogbillinginvoice_v2(?,?,?)}";
                                                        $params_seLogbilling = array(
                                                            array('select_logbillinginvoice_all', SQLSRV_PARAM_IN),
                                                            array($condLogbilling1, SQLSRV_PARAM_IN),
                                                            array($condLogbilling2, SQLSRV_PARAM_IN)
                                                        );
                                                        $query_seLogbilling = sqlsrv_query($conn, $sql_seLogbilling, $params_seLogbilling);
                                                    } else {
                                                        $condLogbilling1 = " AND a.BILLINGCODE = '" . $_GET['billingcode'] . "'";
                                                        $condLogbilling2 = "";
                                                        $sql_seLogbilling = "{call megLogbillinginvoice_v2(?,?,?)}";
                                                        $params_seLogbilling = array(
                                                            array('select_logbillinginvoice', SQLSRV_PARAM_IN),
                                                            array($condLogbilling1, SQLSRV_PARAM_IN),
                                                            array($condLogbilling2, SQLSRV_PARAM_IN)
                                                        );
                                                        $query_seLogbilling = sqlsrv_query($conn, $sql_seLogbilling, $params_seLogbilling);
                                                    }
                                                } else {

                                                    $sql_seLogbilling = "SELECT DISTINCT a.DUEDATE,a.LOGBILLINGINVOICEID,a.COMPANYCODE,a.CUSTOMERCODE, a.BILLINGCODE, a.INVOICECODE, a.BILLINGDATE, a.PAYMENTDATE,a.PRPO1,a.TRIP1,a.PRPO2,a.TRIP2, a.SUMTOTAL, a.EXPRESSWAYAMT15, a.EXPRESSWAYAMT45, a.EXPRESSWAYAMT55, a.EXPRESSWAYAMT65, a.EXPRESSWAYAMT75, a.EXPRESSWAYAMT100, a.EXPRESSWAYAMT195, a.EXPRESSWAYAMT65RETURN, a.EXPRESSWAYAMT105RETURN, a.EXPRESSWAYPRICE15, a.EXPRESSWAYPRICE45, a.EXPRESSWAYPRICE55, a.EXPRESSWAYPRICE65, a.EXPRESSWAYPRICE75, a.EXPRESSWAYPRICE100, a.EXPRESSWAYPRICE195, a.EXPRESSWAYPRICE65RETURN, a.EXPRESSWAYPRICE105RETURN, a.ACTIVESTATUS, a.REMARK,b.EXPRESSWAYCODE FROM [dbo].[LOGBILLINGINVOICE] a
                                                        INNER JOIN [dbo].[LOGINVOICE] b ON a.INVOICECODE = b.INVOICECODE
                                                        WHERE a.ACTIVESTATUS = '1' AND a.BILLINGCODE = '" . $_GET['billingcode'] . "'";
                                                    $params_seLogbilling = array();
                                                    $query_seLogbilling = sqlsrv_query($conn, $sql_seLogbilling, $params_seLogbilling);
                                                }


                                                while ($result_seLogbilling = sqlsrv_fetch_array($query_seLogbilling, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <tr class="odd gradeX">

                                                        <td style="text-align: center;width: 10%"><?= $i ?></td>
                                                        <td><?= $result_seLogbilling['INVOICECODE'] ?></td>
                                                        <td><?= $result_seLogbilling['BILLINGDATE'] ?></td>
                                                        <td><?= $result_seLogbilling['PAYMENTDATE'] ?></td>

                                                        <td style="text-align: center">


                                                            <button onclick="delete_invoice('<?= $result_seLogbilling['LOGBILLINGINVOICEID'] ?>');" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>



                                            </tbody>

                                        </table>

                                    </div>
                                    <div id="datasr"></div>
                                </div>

                                <!-- /.panel-body -->
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
                                                            $(function () {
                                                                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                // กรณีใช้แบบ input
                                                                $(".dateen").datetimepicker({
                                                                    timepicker: false,
                                                                    format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                                                    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


                                                                });
                                                            });
                                                            function select_billinginvoince(billingcode)
                                                            {


                                                                $.ajax({
                                                                    type: 'post',
                                                                    url: 'meg_data.php',
                                                                    data: {
                                                                        txt_flg: "select_billinginvoince", billingcode: billingcode, companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>'
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
                                                                    }
                                                                });
                                                            }
                                                            function delete_invoice(invoiceid)
                                                            {


                                                                $.ajax({
                                                                    type: 'post',
                                                                    url: 'meg_data.php',
                                                                    data: {
                                                                        txt_flg: "delete_logbillinginvoice", invoiceid: invoiceid
                                                                    },
                                                                    success: function () {
                                                                        alert('ลบข้อมูลเรียบร้อยแล้ว');
                                                                        window.location.reload();
                                                                    }
                                                                });
                                                                //}
                                                            }
                                                            function show_invoincecode(billingid, billingcode, invoicecode)
                                                            {
                                                                document.getElementById("pbillingcode").innerHTML = 'เอกสารวางบิลเลขที่ : ' + billingcode;
                                                                document.getElementById("txt_billingid").value = billingid;
                                                                document.getElementById("txt_billingcode").value = billingcode;
                                                                document.getElementById("txt_invoicecode").value = invoicecode;



                                                            }
                                                            function save_billinginvoice()
                                                            {
                                                                if ('<?= $_GET['companycode'] ?>' == 'RKS' && '<?= $_GET['customercode'] ?>' == 'TMT') {

                                                                    var prpo1 = document.getElementById("txt_prpo1").value;
                                                                    var trip1 = document.getElementById("txt_trip1").value;
                                                                    var prpo2 = document.getElementById("txt_prpo2").value;
                                                                    var trip2 = document.getElementById("txt_trip2").value;


                                                                } else {

                                                                    var prpo1 = '';
                                                                    var trip1 = '';
                                                                    var prpo2 = '';
                                                                    var trip2 = '';

                                                                }
                                                                $.ajax({
                                                                    type: 'post',
                                                                    url: 'meg_data.php',
                                                                    data: {
                                                                        txt_flg: "save_logbillinginvoice", condition1: document.getElementById("txt_billingid").value, condition2: '', companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', billingcode: document.getElementById("txt_billingcode").value, invoicecode: document.getElementById("txt_invoicecode").value, billingdate: document.getElementById('txt_billingdate').value, paymentdate: document.getElementById('txt_paymentdate').value, sumtotal: '', duedate: document.getElementById('txt_datedue').value, prpo1: prpo1, trip1: trip1, prpo2: prpo2, trip2: trip2
                                                                    },
                                                                    success: function () {

                                                                        save_logprocess('Billing', 'Save Billinginvoice', '<?= $result_seLogin['PersonCode'] ?>');
                                                                        window.location.reload();

                                                                    }
                                                                });

                                                            }

                                                            function gdatetodate()
                                                            {
                                                                document.getElementById('txt_gdateend').value = document.getElementById('txt_gdatestart').value;
                                                            }
                                                            function datetodate()
                                                            {
                                                                document.getElementById('txt_paymentdate').value = document.getElementById('txt_billingdate').value;

                                                            }

        </script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').DataTable({
                    responsive: true
                });
            });
        </script>

    </body>

</html>
<?php
sqlsrv_close($conn);
?>
