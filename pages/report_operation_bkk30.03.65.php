<!DOCTYPE html>
<?php
session_start();
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
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
        <?php
        if ($_GET['statusnumber'] == 'O') {
            ?>
            <title>แผนงานยังไม่ถึงเวลารายงานตัว</title>
            <?php
        } else if ($_GET['statusnumber'] == 'P') {
            ?>
            <title>แผนงานตรวจร่างกายเรียบร้อย</title>
            <?php
        } else if ($_GET['statusnumber'] == 'L') {
            ?>
            <title>แผนงานเลยเวลารายงานตัว</title>
            <?php
        } else if ($_GET['statusnumber'] == '1' || $_GET['statusnumber'] == 'T') {
            ?>
            <title>แผนงานเปิดงาน</title>
            <?php
        } else if ($_GET['statusnumber'] == '2') {
            ?>
            <title>แผนงานปิดงาน</title>
            <?php
        } else if ($_GET['statusnumber'] == '3') {
            ?>
            <title>แผนงานเอกสารสมบูรณ์</title>
            <?php
        } else if ($_GET['statusnumber'] == 'X') {
            ?>
            <title>แผนงานตัดงาน</title>
            <?php
        } else if ($_GET['statusnumber'] == '0') {
            ?>
            <title>แผนงานยกเลิก</title>
            <?php
        }
        ?>
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
                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
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




        <div class="row" >
            <div class="col-lg-12" style="text-align: right">
                <?php
                if ($_GET['companycode'] == 'RCC' || $_GET['companycode'] == 'RRC' || $_GET['companycode'] == 'RATC') {
                ?>  
                    <input class="btn btn-default" type="button" style="background-color: red;border:solid 2px white" id="btn_srquotation" name="btn_srquotation" value=""> * แจ้งเตือนข้อมูล ไม่พบไอดีราคาขนส่ง (PriceId)
                    <input class="btn btn-default" type="button" style="background-color: orange;border:solid 2px white" id="btn_srquotation" name="btn_srquotation" value=""> * แจ้งเตือนข้อมูล ไม่พบราคาขนส่ง (Price)
                    || (nm) หมายถึง แผนงาน Normal,(sh) หมายถึงแผนงาน Shuttle,sh(n) หมายถึงแผนงาน Shuttle(Normal)  
                <?php
                }else {
                 ?>
                   <input class="btn btn-default" type="button" style="background-color: red;border:solid 2px white" id="btn_srquotation" name="btn_srquotation" value=""> * แจ้งเตือนข้อมูล ไม่พบราคาขนส่ง   
                 <?php
                }
                ?>
                

            </div>
        </div>
        <div class="row">

            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color: #e7e7e7">
                        <div class="row">

                            <div class="col-lg-6">

                                <?php
                                $meg = '';
                                if ($_GET['statusnumber'] == 'O') {
                                    $meg = 'แผนงานยังไม่ถึงเวลารายงานตัว';
                                } else if ($_GET['statusnumber'] == 'P') {
                                    $meg = 'แผนงานตรวจร่างกายเรียบร้อย';
                                } else if ($_GET['statusnumber'] == 'L') {
                                    $meg = 'แผนงานเลยเวลารายงานตัว';
                                } else if ($_GET['statusnumber'] == '1' || $_GET['statusnumber'] == 'T') {
                                    $meg = 'แผนงานเปิดงาน';
                                } else if ($_GET['statusnumber'] == '2') {
                                    $meg = 'แผนงานปิดงาน';
                                } else if ($_GET['statusnumber'] == '3') {
                                    $meg = 'แผนงานเอกสารสมบูรณ์';
                                } else if ($_GET['statusnumber'] == 'X') {
                                    $meg = 'แผนงานตัดงาน';
                                } else if ($_GET['statusnumber'] == '0') {
                                    $meg = 'แผนงานยกเลิก';
                                } else if ($_GET['statusnumber'] == 'E') {
                                    $meg = 'แผนงานทั้งหมด';
                                }


                                if ($_GET['companycode'] == 'RRC' || $_GET['companycode'] == 'RCC' || $_GET['companycode'] == 'RATC') {
                                    echo "<a href='report_customertenkogetway.php?type=report'>ลูกค้า</a>  / " . $meg;
                                    $link = "<a href='report_customertenkogetway.php?type=report'>ลูกค้า</a> ";
                                } else {
                                    echo "<a href='report_customertenkoamata.php?type=report'>ลูกค้า</a>  / " . $meg;
                                    $link = "<a href='report_customertenkoamata.php?type=report'>ลูกค้า</a> ";
                                }

                                $_SESSION["link"] = $link;

                                if ($_GET['statusnumber'] == 'E') {

                                    if ($_GET['datestart'] == "") {
                                        $condOps11 = " AND a.COMPANYCODE = '" . $_GET['companycode'] . "' AND a.CUSTOMERCODE = '" . $_GET['customercode'] . "'";
                                        $condOps12 = "";
                                        $condOps13 = "";
                                    } else {
                                        $condOps11 = " AND a.COMPANYCODE = '" . $_GET['companycode'] . "' AND a.CUSTOMERCODE = '" . $_GET['customercode'] . "'";
                                        $condOps12 = " AND CONVERT(DATE,a.DATEVLIN,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)  ";
                                        $condOps13 = "";
                                    }
                                } else {

                                    if ($_GET['datestart'] == "") {
                                        $condOps11 = " AND a.STATUSNUMBER = '" . $_GET['statusnumber'] . "' AND a.COMPANYCODE = '" . $_GET['companycode'] . "' AND a.CUSTOMERCODE = '" . $_GET['customercode'] . "'";
                                        $condOps12 = "";
                                        $condOps13 = "";
                                    } else {
                                        $condOps11 = " AND a.STATUSNUMBER = '" . $_GET['statusnumber'] . "' AND a.COMPANYCODE = '" . $_GET['companycode'] . "' AND a.CUSTOMERCODE = '" . $_GET['customercode'] . "'";
                                        $condOps12 = " AND CONVERT(DATE,a.DATEVLIN,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)  ";
                                        $condOps13 = "";
                                    }
                                }


                                $sql_seOps1 = "{call megVehicletransportplan_v2(?,?,?,?)}";
                                if ($_GET['statusnumber'] == '0') {
                                    $params_seOps1 = array(
                                        array('select_datevehicletransportplancancel', SQLSRV_PARAM_IN),
                                        array($condOps11, SQLSRV_PARAM_IN),
                                        array($condOps12, SQLSRV_PARAM_IN),
                                        array($condOps13, SQLSRV_PARAM_IN)
                                    );
                                } else {
                                    $params_seOps1 = array(
                                        array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
                                        array($condOps11, SQLSRV_PARAM_IN),
                                        array($condOps12, SQLSRV_PARAM_IN),
                                        array($condOps13, SQLSRV_PARAM_IN)
                                    );
                                }



                                $query_seOps1 = sqlsrv_query($conn, $sql_seOps1, $params_seOps1);
                                $result_seOps1 = sqlsrv_fetch_array($query_seOps1, SQLSRV_FETCH_ASSOC);
                                ?>
                            </div>
                            <!-- /.panel-heading -->

                            <div class="col-lg-6 text-right">
                                <?= $result_seCompany['Company_NameT'] ?>
                            </div>
                        </div>
                    </div>

                                
                    
                    <div class="panel-body">
                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div id="datadef">

                                <table  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            
                                            <th style="text-align: center;width:5%" >จัดการ</th>
                                            <?php
                                            if ($_GET['statusnumber'] == 'P' && ($_GET['companycode'] == 'RCC' || $_GET['companycode'] == 'RRC' || $_GET['companycode'] == 'RATC' )) {
                                              ?>
                                                
                                                <th style="text-align: center;width:7%" >เปิดงาน<input type="button"   data-confirm ="กรุณากด 'ตกลง' เพื่อยืนยันการเปิดงานทั้งหมด!!!" onclick ="confirm_openjob('<?= $_GET['companycode'] ?>','<?= $_GET['customercode'] ?>','<?= $_GET['datestart'] ?>','<?= $_GET['statusnumber'] ?>');" name="btnSend" id="btnSend" value="เปิดงานทั้งหมด" class="btn btn-primary"></button></th>
                                                <!-- <th style="text-align: center;width:7%" >เปิดงาน<button type="button" class="btn btn-default btn-md" name="open_btn" id ="open_btn"  onclick="Open_alljob('<?= $_GET['companycode'] ?>','<?= $_GET['customercode'] ?>','<?= $_GET['datestart'] ?>','<?= $_GET['dateend'] ?>','<?= $_GET['statusnumber'] ?>');" >เปิดงานทั้งหมด</button></th> -->
                                              <?php
                                            }else{
                                               ?>
                                                
                                            <?php
                                            }
                                            ?>
                                            
                                            <?php
                                            if ($_GET['companycode'] == 'RCC' || $_GET['companycode'] == 'RRC' || $_GET['companycode'] == 'RATC') {
                                             ?>
                                                <th style="text-align: center;width:30%">เลขที่งาน</th>
                                                <th style="text-align: center;width:10%">ทะเบียน/ชื่อรถ</th>

                                                <th style="text-align: center;width:15%">พนักงาน(1)</th>
                                                <th style="text-align: center;width:15%">พนักงาน(2)</th>

                                                <th style="text-align: center;width:15%">รอบวิ่ง</th>
                                                <th style="text-align: center;width:5%">ต้นทาง</th>
                                                <th style="text-align: center;width:5%">คลัสเตอร์</th>
                                                <th style="text-align: center;width:20%">ปลายทาง</th>

                                                <th style="text-align: center;width:5%">รายงานตัว</th>
                                                <th style="text-align: center;width:5%">เวลาเริ่มงาน</th>
                                                <th style="text-align: center;width:5%">เข้า (VL)</th>
                                                <th style="text-align: center;width:5%">ออก (VL)</th>

                                                <th style="text-align: center;width:5%">เข้า (DEALER)</th>
                                                <th style="text-align: center;width:5%">กลับบริษัท</th>

                                                <th style="text-align: center;width:5%">ตรวจสอบ</th>
                                             <?php
                                            }else {
                                             ?>
                                                <th style="text-align: center;width:25%">เลขที่งาน</th>
                                                <th style="text-align: center;width:10%">ทะเบียน/ชื่อรถ</th>

                                                <th style="text-align: center;width:15%">พนักงาน(1)</th>
                                                <th style="text-align: center;width:15%">พนักงาน(2)</th>

                                                <th style="text-align: center;width:15%">รอบวิ่ง</th>
                                                <th style="text-align: center;width:10%">ต้นทาง</th>
                                                <th style="text-align: center;width:10%">โซน</th>
                                                <th style="text-align: center;width:10%">ปลายทาง</th>

                                                <th style="text-align: center;width:5%">รายงานตัว</th>
                                                <th style="text-align: center;width:5%">เวลาเริ่มงาน</th>
                                                <th style="text-align: center;width:5%">เข้า (VL)</th>
                                                <th style="text-align: center;width:5%">ออก (VL)</th>

                                                <th style="text-align: center;width:5%">เข้า (DEALER)</th>
                                                <th style="text-align: center;width:5%">กลับบริษัท</th>

                                                <th style="text-align: center;width:5%">ตรวจสอบ</th>
                                             <?php
                                            }
                                            ?>

                                            

                                            <!--<th style="text-align: center;width:5%">ยืยยันรายการวิ่ง</th>-->



                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $sql_seOps = "{call megVehicletransportplan_v2(?,?,?,?)}";

                                        $statusnumber = ($_GET['statusnumber'] == '1') ? " AND (a.STATUSNUMBER = '" . $_GET['statusnumber'] . "' OR a.STATUSNUMBER = 'T')" : " AND a.STATUSNUMBER = '" . $_GET['statusnumber'] . "'";
                                        $condOps1 = " AND a.COMPANYCODE = '" . $_GET['companycode'] . "' AND a.CUSTOMERCODE = '" . $_GET['customercode'] . "'";
                                        $condOps2 = " AND CONVERT(DATE,a.DATEWORKING,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)";
                                        $condOps3 = $statusnumber;

                                        $params_seOps = array(
                                            array('select_datevehicletransportplanorderbydate', SQLSRV_PARAM_IN),
                                            array($condOps1, SQLSRV_PARAM_IN),
                                            array($condOps2, SQLSRV_PARAM_IN),
                                            array($condOps3, SQLSRV_PARAM_IN)
                                        );






                                        $i = 1;
                                        $query_seOps = sqlsrv_query($conn, $sql_seOps, $params_seOps);
                                        while ($result_seOps = sqlsrv_fetch_array($query_seOps, SQLSRV_FETCH_ASSOC)) {
                                            $sql_seCheckpresent = "SELECT CASE WHEN GETDATE() > DATEPRESENT THEN 1 ELSE 0 END AS CHECKPRESENT FROM [dbo].[VEHICLETRANSPORTPLAN]
                                            WHERE [VEHICLETRANSPORTPLANID] = '" . $result_seOps['VEHICLETRANSPORTPLANID'] . "' ";
                                            $query_seCheckpresent = sqlsrv_query($conn, $sql_seCheckpresent, $params_seCheckpresent);
                                            $result_seCheckpresente = sqlsrv_fetch_array($query_seCheckpresent, SQLSRV_FETCH_ASSOC);


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


                                            <!-- <tr 
                                            <?php
                                            if ($result_seOps['VEHICLETRANSPORTPRICEID'] == NULL || $result_seOps['VEHICLETRANSPORTPRICEID'] == '') {
                                            ?>
                                                    style="color: red"
                                                    <?php
                                            }
                                            ?>
                                            > -->
                                            <tr
                                            <?php 
                                            if ($result_seOps['VEHICLETRANSPORTPRICEID'] == NULL || $result_seOps['VEHICLETRANSPORTPRICEID'] == '') {
                                                    ?>
                                                        style="color: red"
                                                    <?php
                                                    // ACTUALPRICE = NULL
                                                } else if ($result_seOps['ACTUALPRICE'] == NULL || $result_seOps['ACTUALPRICE'] == '' || $result_sePlanmonday['ACTUALPRICE'] == '0.00') {
                                                    ?>
                                                    style="color: orange"
                                                    <?php
                                                } else {
                                                    ?>

                                                    <?php
                                                }
                                            ?>
                                            >

                                                <td style="text-align: center">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                                            <i class="fa fa-chevron-down"></i>
                                                        </button>
                                                        <ul class="dropdown-menu slidedown">



                                                            <?php
                                                            if ($_GET['companycode'] == "RRC" || $_GET['companycode'] == "RCC" || $_GET['companycode'] == "RATC" || $_GET['companycode'] == "RKS" || $_GET['companycode'] == "RKR" || $_GET['companycode'] == "RKL" || $_GET['companycode'] == "all") {
                                                                ?>
                                                                <li>
                                                                    <a target="_blank" href='meg_transportplanmix.php?type=transportplan&meg=add&companycode=<?= $result_seOps['COMPANYCODE'] ?>&customercode=<?= $result_seOps['CUSTOMERCODE'] ?>&vehicletransportplanid=<?= $result_seOps['VEHICLETRANSPORTPLANID'] ?>&statusnumber=<?= $_GET['statusnumber'] ?>&datestart=<?= $_GET['datestart'] ?>&dateend=<?= $_GET['dateend'] ?>' >แก้ไขงาน</a>
                                                                </li>
                                                                <?php
                                                            }
                                                            ?>

                                                            <?php
                                                            if ($result_seOps['ACTUALPRICE'] != "") {

                                                                // if ($_GET['statusnumber'] == 'L' || $_GET['statusnumber'] == 'P' ) {
                                                                    if ( $_GET['statusnumber'] == 'P' ) {
                                                                        ?>
                                                                        <?php
                                                                            $sql_chktenkomaster = "SELECT VEHICLETRANSPORTPLANID,JOBNO,TENKOMASTERID
                                                                                FROM VEHICLETRANSPORTPLAN WHERE VEHICLETRANSPORTPLANID ='".$result_seOps['VEHICLETRANSPORTPLANID']."'";
                                                                            $params_chktenkomaster = array();
                                                                            $query_chktenkomaster = sqlsrv_query($conn, $sql_chktenkomaster, $params_chktenkomaster);
                                                                            $result_chktenkomaster = sqlsrv_fetch_array($query_chktenkomaster, SQLSRV_FETCH_ASSOC);
                                                                        ?>
                                                                        <li class="divider"></li>
                                                                        <li>
                                                                        <?php
                                                                        if($result_chktenkomaster['TENKOMASTERID'] == '' || $result_chktenkomaster['TENKOMASTERID'] == NULL ){
                                                                        ?>
                                                                            <a  href='#' onclick='update_vehicletransportplanjob(0,<?= $result_seOps['VEHICLETRANSPORTPLANID'] ?>, 1)'>เปิดงาน</a>
                                                                        <?php
                                                                        }else{
                                                                         ?>
                                                                            <a  href='#' onclick='update_vehicletransportplanjob(<?= $result_chktenkomaster['TENKOMASTERID'] ?>,<?= $result_seOps['VEHICLETRANSPORTPLANID'] ?>, 1)'>เปิดงาน</a>    
                                                                         <?php   
                                                                        }
                                                                        ?>
                                                                            
                                                                        </li>
                                                                        <?php
                                                                }
                                                                ?>


                                                                <?php
                                                                // if ($_GET['statusnumber'] == 'L' || $_GET['statusnumber'] == '1'  || $_GET['statusnumber'] == 'T') {
                                                                    if ( $_GET['statusnumber'] == '1'  || $_GET['statusnumber'] == 'T') {
                                                                        ?>
                                                                         
                                                                        <li class="divider"></li>
                                                                        <li>
                                                                            <a  href='#' onclick='update_vehicletransportplanjob(1,<?= $result_seOps['VEHICLETRANSPORTPLANID'] ?>, 2)'>ปิดงาน</a>
                                                                        </li>
                                                                        
                                                                        <?php
                                                                    }
                                                                ?>

                                                                <li class="divider"></li>
                                                                <li>
                                                                    <a  href='#' onclick="update_vehicletransportplanjob(1,<?= $result_seOps['VEHICLETRANSPORTPLANID'] ?>, 'X')">ยกเลิก(ตัดงาน)</a>
                                                                </li>
                                                                <?php
                                                            }
                                                            ?>





                                                        </ul>
                                                    </div>

                                                </td>

                                                <?php
                                                if ($_GET['statusnumber'] == 'P' && ($_GET['companycode'] == 'RCC' || $_GET['companycode'] == 'RRC' || $_GET['companycode'] == 'RATC' )) {
                                                  ?>
                                                    <td style="text-align: center;"><button type="button" class="btn btn-default btn-md" name="open_btn" id ="open_btn"  onclick="update_vehicletransportplanjob(1,'<?= $result_seOps['VEHICLETRANSPORTPLANID'] ?>','1');" >เปิดงาน</button></td> 
                                                  <?php
                                                }else{
                                                    ?>
                                                        
                                                    <?php
                                                }
                                                ?>

                                                <!-- JOBNO -->
                                                <?php
                                                if ($_GET['companycode'] == 'RCC' || $_GET['companycode'] == 'RRC' || $_GET['companycode'] == 'RATC') {
                                                 ?>
                                                    <td ><?= $result_seOps['JOBNO'] ?> (<?=$result_seOps['WORKTYPE']?>)</td>
                                                 <?php
                                                }else {
                                                  ?>
                                                    <td ><?= $result_seOps['JOBNO'] ?></td>
                                                  <?php
                                                }
                                                ?>
                                                

                                                <td ><?= $result_seOps['THAINAME'] ?></td>
                                                <td ><?= $result_seOps['EMPLOYEENAME1'] ?> <?= $maxday1 . ($result_seMaxday1['DATEVLIN'] != "") ? $result_seMaxday1['DATEVLIN'] : "" . "</font>"; ?> <?= $cntamt1 ?></td>
                                                <td ><?= $result_seOps['EMPLOYEENAME2'] ?> <?= $maxday2 . ($result_seMaxday2['DATEVLIN'] != "") ? $result_seMaxday2['DATEVLIN'] : "" . "</font>"; ?> <?= $cntamt2 ?></td>
                                                <td><?= $result_seOps['ROUNDAMOUNT'] ?></td>
                                                <td><?= $result_seOps['JOBSTART'] ?></td>
                                                
                                                <td><?= $result_seOps['CLUSTER'] ?></td>
                                                <td><?= $result_seOps['JOBEND'] ?></td>
                                                <td <?= ($result_seCheckpresente['CHECKPRESENT']) ? "style='color: red'" : "" ?>><?= $result_seOps['DATEPRESENT'] ?></td>
                                                <td><?= $result_seOps['DATEWORKING'] ?></td>
                                                <td><?= $result_seOps['DATEVLIN'] ?></td>
                                                <td><?= $result_seOps['DATEVLOUT'] ?></td>
                                                <td><?= $result_seOps['DATEDEALERIN'] ?></td>
                                                <td><?= $result_seOps['DATERETURN'] ?></td>

                                                <td style="text-align: center;"><button type="button" class="btn btn-default btn-md" name="myBtn" id ="myBtn" data-toggle="modal" data-target="#myModal" onclick="getPlanid('<?= $result_seOps['VEHICLETRANSPORTPLANID'] ?>');" >ตรวจสอบ</button></td>
                                                
                                                            
                                                </td>
                                                <!--
                                                <td>
                                                    <?//php
                                                    if ($result_seOps['COMPANYCODE'] == 'RCC' || $result_seOps['COMPANYCODE'] == 'RATC') {
                                                        ?>
                                                        <a data-toggle="modal" data-target="#modal_confrimvehicletransportplan" onclick="show_confrimdriving('<?//= $result_seOps['VEHICLETRANSPORTPLANID'] ?>')" class="btn btn-default">ยืนยันรายการวิ่ง <li class="fa fa-truck"></li></a>
                                                        <?//php
                                                    } else {
                                                        echo "-";
                                                    }
                                                    ?>
                                                </td>

                                                -->

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

        <div class="container">


            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><b>ข้อมูลการคีย์ค่าตอบแทนของพนักงาน </b></h4>
                        </div>
                        <div class="modal-body">
                            <div id="datacompdetailsr"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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

                                                    function confirm_openjob(companycode,customercode,datestart,statusnumber){
                                                        $(document).on('click', ':not(form)[data-confirm]', function(e){
                                                        if(confirm($(this).data('confirm'))){
                                                        e.stopImmediatePropagation();
                                                        e.preventDefault();
                                                        
                                                        Open_alljob(companycode,customercode,datestart,statusnumber);   
                                                        }else{

                                                            window.location.reload();      
                                                        }

                                                        
                                                    }); 

                                                    }

                                                    function getPlanid(planid) {
                                                        // alert(planid);
                                                        select_customerdetail(planid);
                                                    }
                                                    
                                                     

                                                    function Open_alljob(companycode,customercode,datestart,statusnumber){

                                                        // alert(companycode);
                                                        // alert(customercode);
                                                        // alert(datestart);   
                                                        // alert(statusnumber);   

                                                        $.ajax({
                                                            type: 'post',
                                                            url: 'meg_data.php',
                                                            data: {
                                                                txt_flg: "open_alljob",companycode: companycode,customercode: customercode,datestart: datestart
                                                            },
                                                            success: function (rs) {
                                                            //    alert(rs);
                                                            window.location.reload(); 
                                                            }
                                                        });
                                                    } 

                                                    function select_customerdetail(planid)
                                                    {

                                                        // alert(planid);
                                                        $.ajax({
                                                            type: 'post',
                                                            url: 'meg_data.php',
                                                            data: {
                                                                txt_flg: "select_customercompensationdetail", planid: planid
                                                            },
                                                            success: function (response) {
                                                                if (response) {

                                                                    document.getElementById("datacompdetailsr").innerHTML = response;
                                                                    document.getElementById("datacompdetaildef").innerHTML = "";

                                                                }




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

                                                    function update_vehicletransportplanjob(tenkomasterid,rootno, statusnumber)
                                                    {
                                                        // alert(tenkomasterid);
                                                        // alert(rootno);
                                                        // alert(statusnumber);
                                                        if(tenkomasterid == '0'){
                                                            alert('ไม่มีเลขที่เท็งโกะ กรุณาตรวจสอบข้อมูล หรือ แจ้งเจ้าหน้าที่')
                                                        }else{
                                                            $.ajax({
                                                                type: 'post',
                                                                url: 'meg_data.php',
                                                                data: {
                                                                    txt_flg: "edit_vehicletransportplanjobstm", rootno: rootno, statusnumber: statusnumber
                                                                },
                                                                success: function () {
                                                                    if (statusnumber == '1')
                                                                    {
                                                                        save_logprocess('Driver Management', 'Save Open Job', '<?= $result_seLogin['PersonCode'] ?>');
                                                                    } else if (statusnumber == '2')
                                                                    {
                                                                        save_logprocess('Driver Management', 'Save Close Job', '<?= $result_seLogin['PersonCode'] ?>');
                                                                    } else if (statusnumber == 'x')
                                                                    {
                                                                        save_logprocess('Driver Management', 'Save Cut Job', '<?= $result_seLogin['PersonCode'] ?>');
                                                                    }

                                                                    // window.location.reload();
                                                                }
                                                            });     
                                                        }
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
