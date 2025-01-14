<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");


$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

$condiCompany = " AND Company_Code = '" . $_GET['companycode'] . "'";
$sql_seCompany = "{call megCompany_v2(?,?)}";
$params_seCompany = array(
    array('select_company', SQLSRV_PARAM_IN),
    array($condiCompany, SQLSRV_PARAM_IN)
);
$query_seCompany = sqlsrv_query($conn, $sql_seCompany, $params_seCompany);
$result_seCompany = sqlsrv_fetch_array($query_seCompany, SQLSRV_FETCH_ASSOC);
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




        <div class="modal fade" id="modal_confrimvehicletransportplan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 80%">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="title"><b>ยืนยันรายการวิ่ง</b></h5>
                    </div>
                    <div class="modal-body">


                        <div id="data_confrimdriving"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                    </div>
                </div>

            </div>
        </div>
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

            <div class="navbar-header" >
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../pages/index.html"><font style="color: #000;font-size: 14px"><img src="../images/logo.ico" height="30"> <strong>Transport Management System</strong></font></a> 
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




        <div class="row" >
            <div class="col-lg-12" style="text-align: right">



                <input class="btn btn-default" type="button" style="background-color: red;border:solid 2px white" id="btn_srquotation" name="btn_srquotation" value=""> * แจ้งเตือนข้อมูล ไม่พบราคาขนส่ง  

            </div>
        </div>
        <div class="row">

            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color: #e7e7e7">
                        <div class="row">

                            <div class="col-lg-6">

                                <?php
                                $meg = 'รายงานตัวตรวจร่างกาย';




                                echo "<a href='index.php?type=report'>หน้าหลัก</a>  / " . $meg;
                                $link = "<a href='index.php?type=report'>หน้าหลัก</a> ";
                                $_SESSION["link"] = $link;
                                ?>
                            </div>
                            <!-- /.panel-heading -->

                            <div class="col-lg-6 text-right">
                                <?= $result_seCompany['Company_NameT'] ?>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">

                        <div class="row">

                            <div class="col-md-2" >
                                <label>บริษัท</label>
                                <select class="form-control"  id="cb_company" name="cb_company" onchange="select_operationgetway()">
                                   <option value = "">บริษัททั้งหมด</option> 
                                    <option value = "RCC">ร่วมกิจรุ่งเรือง คาร์ แคริเออร์</option> 
                                    <option value = "RATC">ร่วมกิจ ออโตโมทีฟ ทรานสปอร์ต</option> 
                                    <option value = "RRC">ร่วมกิจ รีไซเคิล แคริเออร์</option> 
                                </select>
                            </div>



                        </div>
                        <div class="row">

                            <div class="col-md-2" >&nbsp;</div>
                        </div>
                        <div id="datadef">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    ตารางตรวจเท็งโกะ
                                                </div>



                                            </div>
                                        </div>
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-pills">
                                                <li class="active"><a href="#tenko1" data-toggle="tab" aria-expanded="true">เท็งโกะก่อนเริ่มงาน</a>
                                                </li>
                                                <li><a href="#tenko2" data-toggle="tab">เท็งโกะระหว่างทาง</a>
                                                </li>
                                                <li><a href="#tenko3" data-toggle="tab">เท็งโกะเลิกงาน</a>
                                                </li>

                                            </ul>
                                            <div class="tab-content">
                                                <div class="row">
                                                    <div class="col-md-12" >&nbsp;</div>
                                                </div>
                                                <div class="tab-pane fade active in" id="tenko1">
                                                    <div class="row">

                                                        <div class="col-md-12" >
                                                            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">


                                                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                    <thead>
                                                                        <tr>

                                                                            <th style="text-align: center;width:5%" >จัดการ</th>



                                                                            <th style="text-align: center;width:15%">เลขที่งาน</th>
                                                                            <th style="text-align: center;width:10%">ทะเบียน/ชื่อรถ</th>

                                                                            <th style="text-align: center;width:15%">พนักงาน(1)</th>
                                                                            <th style="text-align: center;width:15%">พนักงาน(2)</th>

                                                                            <th style="text-align: center;width:10%">ต้นทาง</th>
                                                                            <th style="text-align: center;width:10%">ปลายทาง</th>

                                                                            <th style="text-align: center;width:5%">รายงานตัว</th>

                                                                            <th style="text-align: center;width:5%">เข้าวีแอล</th>
                                                                            <th style="text-align: center;width:5%">ออกวีแอล</th>

                                                                            <th style="text-align: center;width:5%">เข้าดีลเลอร์</th>
                                                                            <th style="text-align: center;width:5%">กลับบริษัท</th>





                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                        <?php
                                                                        $sql_seOps = "{call megVehicletransportplan_v2(?,?,?,?)}";

                                                                        $condOps1 = " AND a.COMPANYCODE IN ('RCC','RATC','RRC')";
                                                                        $condOps2 = " AND (a.STATUSNUMBER = 'O' OR a.STATUSNUMBER = 'L')";
                                                                        $condOps3 = " AND CONVERT(DATE,a.DATEVLIN) = CONVERT(DATE,GETDATE()) ";
                                                                        $params_seOps = array(
                                                                            array('select_datevehicletransportplanorderbydate', SQLSRV_PARAM_IN),
                                                                            array($condOps1, SQLSRV_PARAM_IN),
                                                                            array($condOps2, SQLSRV_PARAM_IN),
                                                                            array($condOps3, SQLSRV_PARAM_IN)
                                                                        );



                                                                        $i = 1;
                                                                        $query_seOps = sqlsrv_query($conn, $sql_seOps, $params_seOps);
                                                                        while ($result_seOps = sqlsrv_fetch_array($query_seOps, SQLSRV_FETCH_ASSOC)) {

                                                                            $maxday1 = "";
                                                                            $maxday2 = "";
                                                                            $cntamt1 = "";
                                                                            $cntamt2 = "";

                                                                            $condMaxday1 = "";
                                                                            $sql_seMaxday1 = "{call megOperation_v2(?,?,?,?,?)}";
                                                                            $params_seMaxday1 = array(
                                                                                array('select_maxday60', SQLSRV_PARAM_IN),
                                                                                array($condMaxday1, SQLSRV_PARAM_IN),
                                                                                array($result_seOps['EMPLOYEENAME1'], SQLSRV_PARAM_IN),
                                                                                array($result_seOps['JOBSTART'], SQLSRV_PARAM_IN),
                                                                                array($result_seOps['JOBEND'], SQLSRV_PARAM_IN)
                                                                            );
                                                                            $query_seMaxday1 = sqlsrv_query($conn, $sql_seMaxday1, $params_seMaxday1);
                                                                            $result_seMaxday1 = sqlsrv_fetch_array($query_seMaxday1, SQLSRV_FETCH_ASSOC);

                                                                            $condMaxday2 = "";
                                                                            $sql_seMaxday2 = "{call megOperation_v2(?,?,?,?,?)}";
                                                                            $params_seMaxday2 = array(
                                                                                array('select_maxday60', SQLSRV_PARAM_IN),
                                                                                array($condMaxday2, SQLSRV_PARAM_IN),
                                                                                array($result_seOps['EMPLOYEENAME2'], SQLSRV_PARAM_IN),
                                                                                array($result_seOps['JOBSTART'], SQLSRV_PARAM_IN),
                                                                                array($result_seOps['JOBEND'], SQLSRV_PARAM_IN)
                                                                            );
                                                                            $query_seMaxday2 = sqlsrv_query($conn, $sql_seMaxday2, $params_seMaxday2);
                                                                            $result_seMaxday2 = sqlsrv_fetch_array($query_seMaxday2, SQLSRV_FETCH_ASSOC);

                                                                            $condCountamt1 = "";
                                                                            $sql_seCountamt1 = "{call megOperation_v2(?,?,?,?,?)}";
                                                                            $params_seCountamt1 = array(
                                                                                array('select_countamount', SQLSRV_PARAM_IN),
                                                                                array($condCountamt1, SQLSRV_PARAM_IN),
                                                                                array($result_seOps['EMPLOYEENAME1'], SQLSRV_PARAM_IN),
                                                                                array($result_seOps['JOBSTART'], SQLSRV_PARAM_IN),
                                                                                array($result_seOps['JOBEND'], SQLSRV_PARAM_IN)
                                                                            );
                                                                            $query_seCountamt1 = sqlsrv_query($conn, $sql_seCountamt1, $params_seCountamt1);
                                                                            $result_seCountamt1 = sqlsrv_fetch_array($query_seCountamt1, SQLSRV_FETCH_ASSOC);

                                                                            $condCountamt2 = "";
                                                                            $sql_seCountamt2 = "{call megOperation_v2(?,?,?,?,?)}";
                                                                            $params_seCountamt2 = array(
                                                                                array('select_countamount', SQLSRV_PARAM_IN),
                                                                                array($condCountamt2, SQLSRV_PARAM_IN),
                                                                                array($result_seOps['EMPLOYEENAME2'], SQLSRV_PARAM_IN),
                                                                                array($result_seOps['JOBSTART'], SQLSRV_PARAM_IN),
                                                                                array($result_seOps['JOBEND'], SQLSRV_PARAM_IN)
                                                                            );
                                                                            $query_seCountamt2 = sqlsrv_query($conn, $sql_seCountamt2, $params_seCountamt2);
                                                                            $result_seCountamt2 = sqlsrv_fetch_array($query_seCountamt2, SQLSRV_FETCH_ASSOC);
                                                                            if ($result_seOps['EMPLOYEENAME1'] != '') {
                                                                                if ($result_seMaxday1['MAXDAY'] < 60) {
                                                                                    $maxday1 = " / <font style='color:#00CC00'>วิ่งงานล่าสุด ";
                                                                                } else {
                                                                                    $maxday1 = " / <font style='color:red'>วิ่งงานล่าสุด ";
                                                                                }
                                                                            }
                                                                            if ($result_seOps['EMPLOYEENAME2'] != '') {
                                                                                if ($result_seMaxday2['MAXDAY'] < 60) {
                                                                                    $maxday2 = " / <font style='color:#00CC00'>วิ่งงานล่าสุด ";
                                                                                } else {
                                                                                    $maxday2 = " / <font style='color:red'>วิ่งงานล่าสุด ";
                                                                                }
                                                                            }
                                                                            if ($result_seOps['EMPLOYEENAME1'] != '') {
                                                                                if ($result_seCountamt1['CNTAMT'] > 3) {
                                                                                    $cntamt1 = " / <font style='color:#00CC00'>เคยวิ่ง " . $result_seCountamt1['CNTAMT'] . " ครั้ง</font>";
                                                                                } else if ($result_seCountamt1['CNTAMT'] > 1 && $result_seCountamt1['CNTAMT'] < 4) {
                                                                                    $cntamt1 = " / <font style='color:#ffcb0b'>เคยวิ่ง " . $result_seCountamt1['CNTAMT'] . " ครั้ง</font>";
                                                                                } else {
                                                                                    $cntamt1 = " / <font style='color:red'>ไม่เคยวิ่ง</font>";
                                                                                }
                                                                            }
                                                                            if ($result_seOps['EMPLOYEENAME2'] != '') {
                                                                                if ($result_seCountamt2['CNTAMT'] > 3) {
                                                                                    $cntamt2 = " / <font style='color:#00CC00'>เคยวิ่ง " . $result_seCountamt2['CNTAMT'] . " ครั้ง</font>";
                                                                                } else if ($result_seCountamt2['CNTAMT'] > 1 && $result_seCountamt2['CNTAMT'] < 4) {
                                                                                    $cntamt2 = " / <font style='color:#ffcb0b'>เคยวิ่ง " . $result_seCountamt2['CNTAMT'] . " ครั้ง</font>";
                                                                                } else {
                                                                                    $cntamt2 = " / <font style='color:red'>ไม่เคยวิ่ง</font>";
                                                                                }
                                                                            }
                                                                            ?>


                                                                            <tr <?php
                                                                            if ($result_seOps['ACTUALPRICE'] == '' || $result_seOps['ACTUALPRICE'] == '0.00') {
                                                                                ?>
                                                                                    style="color: red"
                                                                                    <?php
                                                                                }
                                                                                ?>>


                                                                                <td style="text-align: center">
                                                                                    <div class="btn-group">
                                                                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                                                                            <i class="fa fa-chevron-down"></i>
                                                                                        </button>
                                                                                        <ul class="dropdown-menu slidedown">
                                                                                            <?php
                                                                                            if ($result_seOps['ACTUALPRICE'] != "") {
                                                                                                ?>
                                                                                                <li>
                                                                                                    <a tabindex="-1" href='#' onclick='save_tenkomaster(<?= $result_seOps['VEHICLETRANSPORTPLANID'] ?>)' >รายงานตัวตรวจร่างกาย</a>
                                                                                                </li>


                                                                                                <?php
                                                                                            } else {
                                                                                                ?>
                                                                                                <li>-</li>
                                                                                                <?php
                                                                                            }
                                                                                            ?>







                                                                                        </ul>
                                                                                    </div>

                                                                                </td>




                                                                                <td ><?= $result_seOps['JOBNO'] ?></td>

                                                                                <td ><?= $result_seOps['THAINAME'] ?></td>
                                                                                <td ><?= $result_seOps['EMPLOYEENAME1'] ?> <?= $maxday1 . ($result_seMaxday1['DATEVLIN'] != "") ? $result_seMaxday1['DATEVLIN'] : "" . "</font>"; ?> <?= $cntamt1 ?></td>
                                                                                <td ><?= $result_seOps['EMPLOYEENAME2'] ?> <?= $maxday2 . ($result_seMaxday2['DATEVLIN'] != "") ? $result_seMaxday2['DATEVLIN'] : "" . "</font>"; ?> <?= $cntamt2 ?></td>
                                                                                <td><?= $result_seOps['JOBSTART'] ?></td>
                                                                                <td><?= $result_seOps['JOBEND'] ?></td>
                                                                                <td><?= $result_seOps['DATEPRESENT'] ?></td>
                                                                                <td><?= $result_seOps['DATEVLIN'] ?></td>
                                                                                <td><?= $result_seOps['DATEVLOUT'] ?></td>
                                                                                <td><?= $result_seOps['DATEDEALERIN'] ?></td>
                                                                                <td><?= $result_seOps['DATERETURN'] ?></td>




                                                                            </tr>
                                                                            <?php
                                                                            $i++;
                                                                        }
                                                                        ?>

                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>

                                                        <!-- /.panel-body -->
                                                    </div>
                                                </div>
                                                <div class="tab-pane fad" id="tenko2">
                                                    <div class="row">

                                                        <div class="col-md-12" >
                                                            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example2" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                    <thead>
                                                                        <tr>

                                                                            <th style="text-align: center;width:5%" >จัดการ</th>



                                                                            <th style="text-align: center;width:15%">เลขที่งาน</th>
                                                                            <th style="text-align: center;width:10%">ทะเบียน/ชื่อรถ</th>

                                                                            <th style="text-align: center;width:15%">พนักงาน(1)</th>
                                                                            <th style="text-align: center;width:15%">พนักงาน(2)</th>

                                                                            <th style="text-align: center;width:10%">ต้นทาง</th>
                                                                            <th style="text-align: center;width:10%">ปลายทาง</th>

                                                                            <th style="text-align: center;width:5%">รายงานตัว</th>

                                                                            <th style="text-align: center;width:5%">เข้าวีแอล</th>
                                                                            <th style="text-align: center;width:5%">ออกวีแอล</th>

                                                                            <th style="text-align: center;width:5%">เข้าดีลเลอร์</th>
                                                                            <th style="text-align: center;width:5%">กลับบริษัท</th>





                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                        <?php
                                                                        $sql_seOps2 = "{call megVehicletransportplan_v2(?,?,?,?)}";

                                                                        $condOps21 = " AND a.COMPANYCODE IN ('RCC','RATC','RRC')";
                                                                        $condOps22 = " AND a.STATUSNUMBER = '1'";
                                                                        $condOps23 = "";
                                                                        $params_seOps2 = array(
                                                                            array('select_datevehicletransportplanorderbydate', SQLSRV_PARAM_IN),
                                                                            array($condOps21, SQLSRV_PARAM_IN),
                                                                            array($condOps22, SQLSRV_PARAM_IN),
                                                                            array($condOps23, SQLSRV_PARAM_IN)
                                                                        );



                                                                        $i = 1;
                                                                        $query_seOps2 = sqlsrv_query($conn, $sql_seOps2, $params_seOps2);
                                                                        while ($result_seOps2 = sqlsrv_fetch_array($query_seOps2, SQLSRV_FETCH_ASSOC)) {

                                                                            $maxday1 = "";
                                                                            $maxday2 = "";
                                                                            $cntamt1 = "";
                                                                            $cntamt2 = "";

                                                                            $condMaxday1 = "";
                                                                            $sql_seMaxday1 = "{call megOperation_v2(?,?,?,?,?)}";
                                                                            $params_seMaxday1 = array(
                                                                                array('select_maxday60', SQLSRV_PARAM_IN),
                                                                                array($condMaxday1, SQLSRV_PARAM_IN),
                                                                                array($result_seOps2['EMPLOYEENAME1'], SQLSRV_PARAM_IN),
                                                                                array($result_seOps2['JOBSTART'], SQLSRV_PARAM_IN),
                                                                                array($result_seOps2['JOBEND'], SQLSRV_PARAM_IN)
                                                                            );
                                                                            $query_seMaxday1 = sqlsrv_query($conn, $sql_seMaxday1, $params_seMaxday1);
                                                                            $result_seMaxday1 = sqlsrv_fetch_array($query_seMaxday1, SQLSRV_FETCH_ASSOC);

                                                                            $condMaxday2 = "";
                                                                            $sql_seMaxday2 = "{call megOperation_v2(?,?,?,?,?)}";
                                                                            $params_seMaxday2 = array(
                                                                                array('select_maxday60', SQLSRV_PARAM_IN),
                                                                                array($condMaxday2, SQLSRV_PARAM_IN),
                                                                                array($result_seOps2['EMPLOYEENAME2'], SQLSRV_PARAM_IN),
                                                                                array($result_seOps2['JOBSTART'], SQLSRV_PARAM_IN),
                                                                                array($result_seOps2['JOBEND'], SQLSRV_PARAM_IN)
                                                                            );
                                                                            $query_seMaxday2 = sqlsrv_query($conn, $sql_seMaxday2, $params_seMaxday2);
                                                                            $result_seMaxday2 = sqlsrv_fetch_array($query_seMaxday2, SQLSRV_FETCH_ASSOC);

                                                                            $condCountamt1 = "";
                                                                            $sql_seCountamt1 = "{call megOperation_v2(?,?,?,?,?)}";
                                                                            $params_seCountamt1 = array(
                                                                                array('select_countamount', SQLSRV_PARAM_IN),
                                                                                array($condCountamt1, SQLSRV_PARAM_IN),
                                                                                array($result_seOps2['EMPLOYEENAME1'], SQLSRV_PARAM_IN),
                                                                                array($result_seOps2['JOBSTART'], SQLSRV_PARAM_IN),
                                                                                array($result_seOps2['JOBEND'], SQLSRV_PARAM_IN)
                                                                            );
                                                                            $query_seCountamt1 = sqlsrv_query($conn, $sql_seCountamt1, $params_seCountamt1);
                                                                            $result_seCountamt1 = sqlsrv_fetch_array($query_seCountamt1, SQLSRV_FETCH_ASSOC);

                                                                            $condCountamt2 = "";
                                                                            $sql_seCountamt2 = "{call megOperation_v2(?,?,?,?,?)}";
                                                                            $params_seCountamt2 = array(
                                                                                array('select_countamount', SQLSRV_PARAM_IN),
                                                                                array($condCountamt2, SQLSRV_PARAM_IN),
                                                                                array($result_seOps2['EMPLOYEENAME2'], SQLSRV_PARAM_IN),
                                                                                array($result_seOps2['JOBSTART'], SQLSRV_PARAM_IN),
                                                                                array($result_seOps2['JOBEND'], SQLSRV_PARAM_IN)
                                                                            );
                                                                            $query_seCountamt2 = sqlsrv_query($conn, $sql_seCountamt2, $params_seCountamt2);
                                                                            $result_seCountamt2 = sqlsrv_fetch_array($query_seCountamt2, SQLSRV_FETCH_ASSOC);
                                                                            if ($result_seOps2['EMPLOYEENAME1'] != '') {
                                                                                if ($result_seMaxday1['MAXDAY'] < 60) {
                                                                                    $maxday1 = " / <font style='color:#00CC00'>วิ่งงานล่าสุด ";
                                                                                } else {
                                                                                    $maxday1 = " / <font style='color:red'>วิ่งงานล่าสุด ";
                                                                                }
                                                                            }
                                                                            if ($result_seOps2['EMPLOYEENAME2'] != '') {
                                                                                if ($result_seMaxday2['MAXDAY'] < 60) {
                                                                                    $maxday2 = " / <font style='color:#00CC00'>วิ่งงานล่าสุด ";
                                                                                } else {
                                                                                    $maxday2 = " / <font style='color:red'>วิ่งงานล่าสุด ";
                                                                                }
                                                                            }
                                                                            if ($result_seOps2['EMPLOYEENAME1'] != '') {
                                                                                if ($result_seCountamt1['CNTAMT'] > 3) {
                                                                                    $cntamt1 = " / <font style='color:#00CC00'>เคยวิ่ง " . $result_seCountamt1['CNTAMT'] . " ครั้ง</font>";
                                                                                } else if ($result_seCountamt1['CNTAMT'] > 1 && $result_seCountamt1['CNTAMT'] < 4) {
                                                                                    $cntamt1 = " / <font style='color:#ffcb0b'>เคยวิ่ง " . $result_seCountamt1['CNTAMT'] . " ครั้ง</font>";
                                                                                } else {
                                                                                    $cntamt1 = " / <font style='color:red'>ไม่เคยวิ่ง</font>";
                                                                                }
                                                                            }
                                                                            if ($result_seOps2['EMPLOYEENAME2'] != '') {
                                                                                if ($result_seCountamt2['CNTAMT'] > 3) {
                                                                                    $cntamt2 = " / <font style='color:#00CC00'>เคยวิ่ง " . $result_seCountamt2['CNTAMT'] . " ครั้ง</font>";
                                                                                } else if ($result_seCountamt2['CNTAMT'] > 1 && $result_seCountamt2['CNTAMT'] < 4) {
                                                                                    $cntamt2 = " / <font style='color:#ffcb0b'>เคยวิ่ง " . $result_seCountamt2['CNTAMT'] . " ครั้ง</font>";
                                                                                } else {
                                                                                    $cntamt2 = " / <font style='color:red'>ไม่เคยวิ่ง</font>";
                                                                                }
                                                                            }
                                                                            ?>


                                                                            <tr <?php
                                                                            if ($result_seOps2['ACTUALPRICE'] == '' || $result_seOps2['ACTUALPRICE'] == '0.00') {
                                                                                ?>
                                                                                    style="color: red"
                                                                                    <?php
                                                                                }
                                                                                ?>>


                                                                                <td style="text-align: center">
                                                                                    <div class="btn-group">
                                                                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                                                                            <i class="fa fa-chevron-down"></i>
                                                                                        </button>
                                                                                        <ul class="dropdown-menu slidedown">
                                                                                            <?php
                                                                                            if ($result_seOps2['ACTUALPRICE'] != "") {
                                                                                                ?>
                                                                                                <li>
                                                                                                    <a tabindex="-1" href='#' onclick='save_tenkomaster(<?= $result_seOps2['VEHICLETRANSPORTPLANID'] ?>)' >รายงานตัวตรวจร่างกาย</a>
                                                                                                </li>


                                                                                                <?php
                                                                                            } else {
                                                                                                ?>
                                                                                                <li>-</li>
                                                                                                <?php
                                                                                            }
                                                                                            ?>







                                                                                        </ul>
                                                                                    </div>

                                                                                </td>




                                                                                <td ><?= $result_seOps2['JOBNO'] ?></td>

                                                                                <td ><?= $result_seOps2['THAINAME'] ?></td>
                                                                                <td ><?= $result_seOps2['EMPLOYEENAME1'] ?> <?= $maxday1 . ($result_seMaxday1['DATEVLIN'] != "") ? $result_seMaxday1['DATEVLIN'] : "" . "</font>"; ?> <?= $cntamt1 ?></td>
                                                                                <td ><?= $result_seOps2['EMPLOYEENAME2'] ?> <?= $maxday2 . ($result_seMaxday2['DATEVLIN'] != "") ? $result_seMaxday2['DATEVLIN'] : "" . "</font>"; ?> <?= $cntamt2 ?></td>
                                                                                <td><?= $result_seOps2['JOBSTART'] ?></td>
                                                                                <td><?= $result_seOps2['JOBEND'] ?></td>
                                                                                <td><?= $result_seOps2['DATEPRESENT'] ?></td>
                                                                                <td><?= $result_seOps2['DATEVLIN'] ?></td>
                                                                                <td><?= $result_seOps2['DATEVLOUT'] ?></td>
                                                                                <td><?= $result_seOps2['DATEDEALERIN'] ?></td>
                                                                                <td><?= $result_seOps2['DATERETURN'] ?></td>




                                                                            </tr>
                                                                            <?php
                                                                            $i++;
                                                                        }
                                                                        ?>

                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>

                                                        <!-- /.panel-body -->
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="tenko3">
                                                    <div class="row">

                                                        <div class="col-md-12" >
                                                            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example3" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                    <thead>
                                                                        <tr>

                                                                            <th style="text-align: center;width:5%" >จัดการ</th>



                                                                            <th style="text-align: center;width:15%">เลขที่งาน</th>
                                                                            <th style="text-align: center;width:10%">ทะเบียน/ชื่อรถ</th>

                                                                            <th style="text-align: center;width:15%">พนักงาน(1)</th>
                                                                            <th style="text-align: center;width:15%">พนักงาน(2)</th>

                                                                            <th style="text-align: center;width:10%">ต้นทาง</th>
                                                                            <th style="text-align: center;width:10%">ปลายทาง</th>

                                                                            <th style="text-align: center;width:5%">รายงานตัว</th>

                                                                            <th style="text-align: center;width:5%">เข้าวีแอล</th>
                                                                            <th style="text-align: center;width:5%">ออกวีแอล</th>

                                                                            <th style="text-align: center;width:5%">เข้าดีลเลอร์</th>
                                                                            <th style="text-align: center;width:5%">กลับบริษัท</th>





                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                        <?php
                                                                        $sql_seOps3 = "{call megVehicletransportplan_v2(?,?,?,?)}";

                                                                        $condOps31 = " AND a.COMPANYCODE IN ('RCC','RATC','RRC')";
                                                                        $condOps32 = " AND a.STATUSNUMBER = '1'";
                                                                        $condOps33 = "";
                                                                        $params_seOps3 = array(
                                                                            array('select_datevehicletransportplanorderbydate', SQLSRV_PARAM_IN),
                                                                            array($condOps31, SQLSRV_PARAM_IN),
                                                                            array($condOps32, SQLSRV_PARAM_IN),
                                                                            array($condOps33, SQLSRV_PARAM_IN)
                                                                        );



                                                                        $i = 1;
                                                                        $query_seOps3 = sqlsrv_query($conn, $sql_seOps3, $params_seOps3);
                                                                        while ($result_seOps3 = sqlsrv_fetch_array($query_seOps3, SQLSRV_FETCH_ASSOC)) {

                                                                            $maxday1 = "";
                                                                            $maxday2 = "";
                                                                            $cntamt1 = "";
                                                                            $cntamt2 = "";

                                                                            $condMaxday1 = "";
                                                                            $sql_seMaxday1 = "{call megOperation_v2(?,?,?,?,?)}";
                                                                            $params_seMaxday1 = array(
                                                                                array('select_maxday60', SQLSRV_PARAM_IN),
                                                                                array($condMaxday1, SQLSRV_PARAM_IN),
                                                                                array($result_seOps3['EMPLOYEENAME1'], SQLSRV_PARAM_IN),
                                                                                array($result_seOps3['JOBSTART'], SQLSRV_PARAM_IN),
                                                                                array($result_seOps3['JOBEND'], SQLSRV_PARAM_IN)
                                                                            );
                                                                            $query_seMaxday1 = sqlsrv_query($conn, $sql_seMaxday1, $params_seMaxday1);
                                                                            $result_seMaxday1 = sqlsrv_fetch_array($query_seMaxday1, SQLSRV_FETCH_ASSOC);

                                                                            $condMaxday2 = "";
                                                                            $sql_seMaxday2 = "{call megOperation_v2(?,?,?,?,?)}";
                                                                            $params_seMaxday2 = array(
                                                                                array('select_maxday60', SQLSRV_PARAM_IN),
                                                                                array($condMaxday2, SQLSRV_PARAM_IN),
                                                                                array($result_seOps3['EMPLOYEENAME2'], SQLSRV_PARAM_IN),
                                                                                array($result_seOps3['JOBSTART'], SQLSRV_PARAM_IN),
                                                                                array($result_seOps3['JOBEND'], SQLSRV_PARAM_IN)
                                                                            );
                                                                            $query_seMaxday2 = sqlsrv_query($conn, $sql_seMaxday2, $params_seMaxday2);
                                                                            $result_seMaxday2 = sqlsrv_fetch_array($query_seMaxday2, SQLSRV_FETCH_ASSOC);

                                                                            $condCountamt1 = "";
                                                                            $sql_seCountamt1 = "{call megOperation_v2(?,?,?,?,?)}";
                                                                            $params_seCountamt1 = array(
                                                                                array('select_countamount', SQLSRV_PARAM_IN),
                                                                                array($condCountamt1, SQLSRV_PARAM_IN),
                                                                                array($result_seOps3['EMPLOYEENAME1'], SQLSRV_PARAM_IN),
                                                                                array($result_seOps3['JOBSTART'], SQLSRV_PARAM_IN),
                                                                                array($result_seOps3['JOBEND'], SQLSRV_PARAM_IN)
                                                                            );
                                                                            $query_seCountamt1 = sqlsrv_query($conn, $sql_seCountamt1, $params_seCountamt1);
                                                                            $result_seCountamt1 = sqlsrv_fetch_array($query_seCountamt1, SQLSRV_FETCH_ASSOC);

                                                                            $condCountamt2 = "";
                                                                            $sql_seCountamt2 = "{call megOperation_v2(?,?,?,?,?)}";
                                                                            $params_seCountamt2 = array(
                                                                                array('select_countamount', SQLSRV_PARAM_IN),
                                                                                array($condCountamt2, SQLSRV_PARAM_IN),
                                                                                array($result_seOps3['EMPLOYEENAME2'], SQLSRV_PARAM_IN),
                                                                                array($result_seOps3['JOBSTART'], SQLSRV_PARAM_IN),
                                                                                array($result_seOps3['JOBEND'], SQLSRV_PARAM_IN)
                                                                            );
                                                                            $query_seCountamt2 = sqlsrv_query($conn, $sql_seCountamt2, $params_seCountamt2);
                                                                            $result_seCountamt2 = sqlsrv_fetch_array($query_seCountamt2, SQLSRV_FETCH_ASSOC);
                                                                            if ($result_seOps3['EMPLOYEENAME1'] != '') {
                                                                                if ($result_seMaxday1['MAXDAY'] < 60) {
                                                                                    $maxday1 = " / <font style='color:#00CC00'>วิ่งงานล่าสุด ";
                                                                                } else {
                                                                                    $maxday1 = " / <font style='color:red'>วิ่งงานล่าสุด ";
                                                                                }
                                                                            }
                                                                            if ($result_seOps3['EMPLOYEENAME2'] != '') {
                                                                                if ($result_seMaxday2['MAXDAY'] < 60) {
                                                                                    $maxday2 = " / <font style='color:#00CC00'>วิ่งงานล่าสุด ";
                                                                                } else {
                                                                                    $maxday2 = " / <font style='color:red'>วิ่งงานล่าสุด ";
                                                                                }
                                                                            }
                                                                            if ($result_seOps3['EMPLOYEENAME1'] != '') {
                                                                                if ($result_seCountamt1['CNTAMT'] > 3) {
                                                                                    $cntamt1 = " / <font style='color:#00CC00'>เคยวิ่ง " . $result_seCountamt1['CNTAMT'] . " ครั้ง</font>";
                                                                                } else if ($result_seCountamt1['CNTAMT'] > 1 && $result_seCountamt1['CNTAMT'] < 4) {
                                                                                    $cntamt1 = " / <font style='color:#ffcb0b'>เคยวิ่ง " . $result_seCountamt1['CNTAMT'] . " ครั้ง</font>";
                                                                                } else {
                                                                                    $cntamt1 = " / <font style='color:red'>ไม่เคยวิ่ง</font>";
                                                                                }
                                                                            }
                                                                            if ($result_seOps3['EMPLOYEENAME2'] != '') {
                                                                                if ($result_seCountamt2['CNTAMT'] > 3) {
                                                                                    $cntamt2 = " / <font style='color:#00CC00'>เคยวิ่ง " . $result_seCountamt2['CNTAMT'] . " ครั้ง</font>";
                                                                                } else if ($result_seCountamt2['CNTAMT'] > 1 && $result_seCountamt2['CNTAMT'] < 4) {
                                                                                    $cntamt2 = " / <font style='color:#ffcb0b'>เคยวิ่ง " . $result_seCountamt2['CNTAMT'] . " ครั้ง</font>";
                                                                                } else {
                                                                                    $cntamt2 = " / <font style='color:red'>ไม่เคยวิ่ง</font>";
                                                                                }
                                                                            }
                                                                            ?>


                                                                            <tr <?php
                                                                            if ($result_seOps3['ACTUALPRICE'] == '' || $result_seOps3['ACTUALPRICE'] == '0.00') {
                                                                                ?>
                                                                                    style="color: red"
                                                                                    <?php
                                                                                }
                                                                                ?>>


                                                                                <td style="text-align: center">
                                                                                    <div class="btn-group">
                                                                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                                                                            <i class="fa fa-chevron-down"></i>
                                                                                        </button>
                                                                                        <ul class="dropdown-menu slidedown">
                                                                                            <?php
                                                                                            if ($result_seOps3['ACTUALPRICE'] != "") {
                                                                                                ?>
                                                                                                <li>
                                                                                                    <a tabindex="-1" href='#' onclick='save_tenkomaster(<?= $result_seOps3['VEHICLETRANSPORTPLANID'] ?>)' >รายงานตัวตรวจร่างกาย</a>
                                                                                                </li>


                                                                                                <?php
                                                                                            } else {
                                                                                                ?>
                                                                                                <li>-</li>
                                                                                                <?php
                                                                                            }
                                                                                            ?>







                                                                                        </ul>
                                                                                    </div>

                                                                                </td>




                                                                                <td ><?= $result_seOps3['JOBNO'] ?></td>

                                                                                <td ><?= $result_seOps3['THAINAME'] ?></td>
                                                                                <td ><?= $result_seOps3['EMPLOYEENAME1'] ?> <?= $maxday1 . ($result_seMaxday1['DATEVLIN'] != "") ? $result_seMaxday1['DATEVLIN'] : "" . "</font>"; ?> <?= $cntamt1 ?></td>
                                                                                <td ><?= $result_seOps3['EMPLOYEENAME2'] ?> <?= $maxday2 . ($result_seMaxday2['DATEVLIN'] != "") ? $result_seMaxday2['DATEVLIN'] : "" . "</font>"; ?> <?= $cntamt2 ?></td>
                                                                                <td><?= $result_seOps3['JOBSTART'] ?></td>
                                                                                <td><?= $result_seOps3['JOBEND'] ?></td>
                                                                                <td><?= $result_seOps3['DATEPRESENT'] ?></td>
                                                                                <td><?= $result_seOps3['DATEVLIN'] ?></td>
                                                                                <td><?= $result_seOps3['DATEVLOUT'] ?></td>
                                                                                <td><?= $result_seOps3['DATEDEALERIN'] ?></td>
                                                                                <td><?= $result_seOps3['DATERETURN'] ?></td>




                                                                            </tr>
                                                                            <?php
                                                                            $i++;
                                                                        }
                                                                        ?>

                                                                    </tbody>
                                                                </table>

                                                            </div>
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
                        <div id="datasr"></div>
                        <!-- /.panel -->
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
                                                                                                        function select_operationgetway()
                                                                                                        {

                                                                                                            $.ajax({
                                                                                                                url: 'meg_data.php',
                                                                                                                type: 'POST',
                                                                                                                data: {
                                                                                                                    txt_flg: "select_operationgetway", company: document.getElementById("cb_company").value
                                                                                                                },
                                                                                                                success: function (rs) {

                                                                                                                    document.getElementById("datadef").innerHTML = "";
                                                                                                                    document.getElementById("datasr").innerHTML = rs;
                                                                                                                    $('#dataTables-example1').DataTable({
                                                                                                                        responsive: true
                                                                                                                    });
                                                                                                                    $('#dataTables-example2').DataTable({
                                                                                                                        responsive: true
                                                                                                                    });
                                                                                                                    $('#dataTables-example3').DataTable({
                                                                                                                        responsive: true
                                                                                                                    });
                                                                                                                }

                                                                                                            });




                                                                                                        }


                                                                                                        function edit_chkvehicletransportjobendtemp(editableObj, fieldname, ID1, vehicletransportplanid)
                                                                                                        {

                                                                                                            if (document.getElementById(ID1).checked == true) {


                                                                                                                $.ajax({
                                                                                                                    url: 'meg_data.php',
                                                                                                                    type: 'POST',
                                                                                                                    data: {
                                                                                                                        txt_flg: "edit_vehicletransportjobendtemp", editableObj: '1', ID1: ID1, fieldname: fieldname
                                                                                                                    },
                                                                                                                    success: function (rs) {

                                                                                                                        //window.location.reload();
                                                                                                                    }
                                                                                                                });

                                                                                                            } else
                                                                                                            {
                                                                                                                $.ajax({
                                                                                                                    url: 'meg_data.php',
                                                                                                                    type: 'POST',
                                                                                                                    data: {
                                                                                                                        txt_flg: "edit_vehicletransportjobendtemp", editableObj: '0', ID1: ID1, fieldname: fieldname
                                                                                                                    },
                                                                                                                    success: function () {

                                                                                                                        //window.location.reload();
                                                                                                                    }
                                                                                                                });
                                                                                                            }

                                                                                                            alert(vehicletransportplanid);
                                                                                                            $.ajax({
                                                                                                                url: 'meg_data.php',
                                                                                                                type: 'POST',
                                                                                                                data: {
                                                                                                                    txt_flg: "edit_vehicletransportplantemp", vehicletransportplanid: vehicletransportplanid
                                                                                                                },
                                                                                                                success: function () {



                                                                                                                }
                                                                                                            });



                                                                                                        }
                                                                                                        function edit_vehicletransportjobendtempinner(editableObj, fieldname, ID1)
                                                                                                        {


                                                                                                            $.ajax({
                                                                                                                url: 'meg_data.php',
                                                                                                                type: 'POST',
                                                                                                                data: {
                                                                                                                    txt_flg: "edit_vehicletransportjobendtemp", editableObj: editableObj.innerHTML, ID1: ID1, fieldname: fieldname
                                                                                                                },
                                                                                                                success: function () {

                                                                                                                    //window.location.reload();
                                                                                                                }
                                                                                                            });



                                                                                                        }
                                                                                                        function select_compensationcluster(cluster, num, tempjobendid)
                                                                                                        {

                                                                                                            $.ajax({
                                                                                                                url: 'meg_data.php',
                                                                                                                type: 'POST',
                                                                                                                data: {
                                                                                                                    txt_flg: "select_compensationcluster", cluster: cluster, tempjobendid: tempjobendid
                                                                                                                },
                                                                                                                success: function (rs) {

                                                                                                                    document.getElementById("def_jobend" + num).innerHTML = "";
                                                                                                                    document.getElementById("sr_jobend" + num).innerHTML = rs;
                                                                                                                    update_compensationcluster(cluster);
                                                                                                                }
                                                                                                            });

                                                                                                        }
                                                                                                        function update_compensationcluster(editableObj)
                                                                                                        {


                                                                                                            update_vehicletransportplan(editableObj, 'CLUSTER', '<?= $_GET['vehicletransportplanid'] ?>');


                                                                                                        }
                                                                                                        function update_compensationjobend(jobend)
                                                                                                        {


                                                                                                            edit_vehicletransportjobendtemp(jobend, 'JOBEND', document.getElementById("tempjobendid").value);



                                                                                                        }
                                                                                                        function edit_vehicletransportjobendtemp(editableObj, fieldname, ID1)
                                                                                                        {


                                                                                                            $.ajax({
                                                                                                                url: 'meg_data.php',
                                                                                                                type: 'POST',
                                                                                                                data: {
                                                                                                                    txt_flg: "edit_vehicletransportjobendtemp", editableObj: editableObj, ID1: ID1, fieldname: fieldname
                                                                                                                },
                                                                                                                success: function () {
                                                                                                                    // alert(rs);
                                                                                                                    //window.location.reload();
                                                                                                                }
                                                                                                            });



                                                                                                        }
                                                                                                        function show_confrimdriving(vehicletransportplanid)
                                                                                                        {

                                                                                                            $.ajax({
                                                                                                                type: 'post',
                                                                                                                url: 'meg_data.php',
                                                                                                                data: {
                                                                                                                    txt_flg: "show_confrimdriving", vehicletransportplanid: vehicletransportplanid

                                                                                                                },
                                                                                                                success: function (rs) {

                                                                                                                    document.getElementById("data_confrimdriving").innerHTML = rs;
                                                                                                                }
                                                                                                            });

                                                                                                        }
                                                                                                        function save_tenkomaster(vehicletransportplanid)
                                                                                                        {

                                                                                                            $.ajax({
                                                                                                                type: 'post',
                                                                                                                url: 'meg_data.php',
                                                                                                                data: {
                                                                                                                    txt_flg: "save_tenkomaster", tenkomasterid: '', vehicletransportplanid: vehicletransportplanid, changeka: '',
                                                                                                                    remark1: '', remark2: '', status: '1', officer: '<?= $result_seEmployee["nameT"] ?>'

                                                                                                                },
                                                                                                                success: function () {

                                                                                                                    window.open('meg_tenkodocument.php?vehicletransportplanid=' + vehicletransportplanid, '_blank');
                                                                                                                }
                                                                                                            });

                                                                                                        }
                                                                                                        function update_vehicletransportplanjob(rootno, statusnumber)
                                                                                                        {

                                                                                                            $.ajax({
                                                                                                                type: 'post',
                                                                                                                url: 'meg_data.php',
                                                                                                                data: {
                                                                                                                    txt_flg: "edit_vehicletransportplanjob", rootno: rootno, statusnumber: statusnumber
                                                                                                                },
                                                                                                                success: function () {

                                                                                                                    window.location.reload();
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



            </script>
            <script>
                $(document).ready(function () {
                    $('#dataTables-example1').DataTable({
                        responsive: true
                    });
                    $('#dataTables-example2').DataTable({
                        responsive: true
                    });
                    $('#dataTables-example3').DataTable({
                        responsive: true
                    });
                });
            </script>

    </body>

</html>
<?php
sqlsrv_close($conn);
?>