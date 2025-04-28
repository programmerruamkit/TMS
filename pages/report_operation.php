<!DOCTYPE html>
<?php
session_start();
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");


// $sql_getDate = "{call megStopwork_v2(?)}";
// $params_getDate = array(
//     array('select_getdate', SQLSRV_PARAM_IN)
// );
// $query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
// $result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

$condiCompany = " AND Company_Code = '" . $_GET['companycode'] . "'";
$sql_seCompany = "{call megCompany_v2(?,?)}";
$params_seCompany = array(
    array('select_company', SQLSRV_PARAM_IN),
    array($condiCompany, SQLSRV_PARAM_IN)
);
$query_seCompany = sqlsrv_query($conn, $sql_seCompany, $params_seCompany);
$result_seCompany = sqlsrv_fetch_array($query_seCompany, SQLSRV_FETCH_ASSOC);

// $condition1 = " AND (a.USERNAME ='" . $_SESSION["USERNAME"] . "' AND a.PASSWORD = '" . $_SESSION["PASSWORD"] . "') AND a.ACTIVESTATUS = 1";
// $sql_seLogin = "{call megRoleaccount_v2(?,?)}";
// $params_seLogin = array(
//     array('select_roleaccount', SQLSRV_PARAM_IN),
//     array($condition1, SQLSRV_PARAM_IN)
// );
// $query_seLogin = sqlsrv_query($conn, $sql_seLogin, $params_seLogin);
// $result_seLogin = sqlsrv_fetch_array($query_seLogin, SQLSRV_FETCH_ASSOC);

// echo $_SESSION["USERNAME"];
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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">

        <style>

            .navbar-default {

                border-color: #ffcb0b;
            }
            #page-wrapper {

                border-left: 1px solid #ffcb0b;
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
                                                <th style="text-align: center;width:30%">จัดการแผน</th>
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
                                                <th style="text-align: center;width:30%">จัดการแผน</th>
                                                <th style="text-align: center;width:25%">เลขที่งาน</th>
                                                <th style="text-align: center;width:10%">ทะเบียน/ชื่อรถ</th>

                                                <th style="text-align: center;width:15%">พนักงาน(1)</th>
                                                <th style="text-align: center;width:15%">พนักงาน(2)</th>
                                                <?php
                                                if ($_GET['companycode'] == 'RKL' && $_GET['customercode'] == 'SKB') {
                                                ?>
                                                <th style="text-align: center;width:15%">พนักงาน(3)</th>
                                                <?php
                                                }else {
                                                ?>

                                                <?php
                                                }
                                                ?>
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


                                            // $maxday1 = "";
                                            // $maxday2 = "";
                                            $cntamt1 = "";
                                            $cntamt2 = "";

                                            // $condMaxday1 = "";
                                            // $sql_seMaxday1 = "{call megOperation_v2(?,?,?,?,?)}";
                                            // $params_seMaxday1 = array(
                                            //     array('select_maxday60', SQLSRV_PARAM_IN),
                                            //     array($condMaxday1, SQLSRV_PARAM_IN),
                                            //     array($result_seOps['EMPLOYEENAME1'], SQLSRV_PARAM_IN),
                                            //     array($result_seOps['JOBSTART'], SQLSRV_PARAM_IN),
                                            //     array($result_seOps['JOBEND'], SQLSRV_PARAM_IN)
                                            // );
                                            // $query_seMaxday1 = sqlsrv_query($conn, $sql_seMaxday1, $params_seMaxday1);
                                            // $result_seMaxday1 = sqlsrv_fetch_array($query_seMaxday1, SQLSRV_FETCH_ASSOC);

                                            // $condMaxday2 = "";
                                            // $sql_seMaxday2 = "{call megOperation_v2(?,?,?,?,?)}";
                                            // $params_seMaxday2 = array(
                                            //     array('select_maxday60', SQLSRV_PARAM_IN),
                                            //     array($condMaxday2, SQLSRV_PARAM_IN),
                                            //     array($result_seOps['EMPLOYEENAME2'], SQLSRV_PARAM_IN),
                                            //     array($result_seOps['JOBSTART'], SQLSRV_PARAM_IN),
                                            //     array($result_seOps['JOBEND'], SQLSRV_PARAM_IN)
                                            // );
                                            // $query_seMaxday2 = sqlsrv_query($conn, $sql_seMaxday2, $params_seMaxday2);
                                            // $result_seMaxday2 = sqlsrv_fetch_array($query_seMaxday2, SQLSRV_FETCH_ASSOC);

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
                                            
                                            // if ($result_seOps['EMPLOYEENAME1'] != '') {
                                            //     if ($result_seMaxday1['MAXDAY'] < 60) {
                                            //         $maxday1 = " / <font style='color:#00CC00'>วิ่งงานล่าสุด ";
                                            //     } else {
                                            //         $maxday1 = " / <font style='color:red'>วิ่งงานล่าสุด ";
                                            //     }
                                            // }
                                            // if ($result_seOps['EMPLOYEENAME2'] != '') {
                                            //     if ($result_seMaxday2['MAXDAY'] < 60) {
                                            //         $maxday2 = " / <font style='color:#00CC00'>วิ่งงานล่าสุด ";
                                            //     } else {
                                            //         $maxday2 = " / <font style='color:red'>วิ่งงานล่าสุด ";
                                            //     }
                                            // }

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
                                                            if ($_GET['companycode'] == "RRC" || $_GET['companycode'] == "RKS" || $_GET['companycode'] == "RKR" || $_GET['companycode'] == "RKL" || $_GET['companycode'] == "all") {
                                                                ?>
                                                                <li>
                                                                    <a target="_blank" href='meg_transportplanmix.php?type=transportplan&meg=add&companycode=<?= $result_seOps['COMPANYCODE'] ?>&customercode=<?= $result_seOps['CUSTOMERCODE'] ?>&vehicletransportplanid=<?= $result_seOps['VEHICLETRANSPORTPLANID'] ?>&statusnumber=<?= $_GET['statusnumber'] ?>&datestart=<?= $_GET['datestart'] ?>&dateend=<?= $_GET['dateend'] ?>' >แก้ไขงาน</a>
                                                                </li>
                                                                <?php
                                                            }else if ($_GET['companycode'] == "RCC" || $_GET['companycode'] == "RATC"){
                                                            ?>
                                                                <li>
                                                                    <a target="_blank" href='meg_transportplanmix_newrccratc.php?type=transportplan&meg=add&companycode=<?= $result_seOps['COMPANYCODE'] ?>&customercode=<?= $result_seOps['CUSTOMERCODE'] ?>&vehicletransportplanid=<?= $result_seOps['VEHICLETRANSPORTPLANID'] ?>&statusnumber=<?= $_GET['statusnumber'] ?>&datestart=<?= $_GET['datestart'] ?>&dateend=<?= $_GET['dateend'] ?>' >แก้ไขงาน RCC</a>
                                                                </li>
                                                            <?php
                                                            }else{
                                                            ?>

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

                                                <!-- EDIT PLAN -->
                                                <td style="text-align: center;" >
                                                    <button class="danger" onclick="delete_vehicletransportplan('<?= $result_seOps['VEHICLETRANSPORTPLANID'] ?>');" title="ลบแผนการขนส่ง" type="button" class="btn btn-default btn-circle"><span class="fa fa-times"></span></button>
                                                </td>
                                                
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
                                                

                                                <!-- THAINAME -->
                                                <?php
                                                if ($_GET['companycode'] == 'RCC'  || $_GET['companycode'] == 'RATC' || $_GET['companycode'] == 'RRC') {
                                                 ?>
                                                
                                                    <td ><input  type="button"     id="btn_thainame" name="btn_thainame" class="btn btn-default" onclick ="open_modalthainame('<?= $result_seOps['VEHICLETRANSPORTPLANID'] ?>');" value="<?= str_replace("(4L)","",$result_seOps['THAINAME']); ?>"></td>
                                                
                                                 <?php
                                                }else {
                                                  ?>
                                                
                                                    <td ><?= $result_seOps['THAINAME'] ?></td>
                                                  
                                                  <?php
                                                }
                                                ?>

                                                <td ><?= $result_seOps['EMPLOYEENAME1'] ?>  <?= $cntamt1 ?></td>
                                                <td ><?= $result_seOps['EMPLOYEENAME2'] ?>  <?= $cntamt2 ?></td>
                                                <?php
                                                if ($_GET['companycode'] == 'RKL'  && $_GET['customercode'] == 'SKB') {
                                                ?>
                                                <td ><?= $result_seOps['EMPLOYEENAME3'] ?></td>
                                                <?php
                                                }else {
                                                ?>

                                                <?php
                                                }
                                                ?>
                                                <!-- <td ><?= $result_seOps['EMPLOYEENAME1'] ?> <?= $maxday1 . ($result_seMaxday1['DATEVLIN'] != "") ? $result_seMaxday1['DATEVLIN'] : "" . "</font>"; ?> <?= $cntamt1 ?></td>
                                                <td ><?= $result_seOps['EMPLOYEENAME2'] ?> <?= $maxday2 . ($result_seMaxday2['DATEVLIN'] != "") ? $result_seMaxday2['DATEVLIN'] : "" . "</font>"; ?> <?= $cntamt2 ?></td> -->
                                                <td>                                              
                                                    <?php if($_GET['companycode'] == 'RCC'  || $_GET['companycode'] == 'RATC') { ?>                                                                      
                                                        <select id="txt_roundamountgw" name="txt_roundamountgw" class="form-control" onchange="update_copydiagram('<?= $result_seOps['VEHICLETRANSPORTPLANID'] ?>', 'ROUNDAMOUNT', this.value)">
                                                            <option value disabled selected>-เลือกรอบที่วิ่งงาน-</option>              
                                                            <?php
                                                                $sql_slram = "SELECT * FROM [dbo].[ROUNDAMOUNT] WHERE ID IN(1,2,5,6)";
                                                                $query_slram = sqlsrv_query($conn, $sql_slram);
                                                                while($result_slram = sqlsrv_fetch_array($query_slram, SQLSRV_FETCH_ASSOC)) {
                                                                $selected = "";
                                                                $SePY_CCID = $result_seOps['ROUNDAMOUNT'];
                                                                    $SeCC_ID = $result_slram['NAME'];
                                                                if ($SePY_CCID == $SeCC_ID) { $selected = "selected"; }
                                                            ?>
                                                            <option value="<?=$result_slram['NAME']?>" <?= $selected ?>>รอบที่ <?php echo $result_slram["NAME"];?></option>
                                                            <?php } ?>
                                                        </select>
                                                    <?php }else if($_GET['companycode'] == 'RRC') { ?>                       
                                                        <select id="txt_roundamountgw" name="txt_roundamountgw" class="form-control" onchange="update_copydiagram('<?= $result_seOps['VEHICLETRANSPORTPLANID'] ?>', 'ROUNDAMOUNT', this.value)">
                                                            <option value disabled selected>-เลือกรอบที่วิ่งงาน-</option>              
                                                            <?php
                                                                $sql_slram = "SELECT * FROM [dbo].[ROUNDAMOUNT] WHERE ID IN(3,4)";
                                                                $query_slram = sqlsrv_query($conn, $sql_slram);
                                                                while($result_slram = sqlsrv_fetch_array($query_slram, SQLSRV_FETCH_ASSOC)) {
                                                                $selected = "";
                                                                $SePY_CCID = $result_seOps['ROUNDAMOUNT'];
                                                                    $SeCC_ID = $result_slram['NAME'];
                                                                if ($SePY_CCID == $SeCC_ID) { $selected = "selected"; }
                                                            ?>
                                                            <option value="<?=$result_slram['NAME']?>" <?= $selected ?>>รอบที่ <?php echo $result_slram["NAME"];?></option>
                                                            <?php } ?>
                                                        </select> 
                                                    <?php }else if($_GET['companycode'] == 'RKS'  && $_GET['customercode'] == 'STM') { ?>                       
                                                        
                                                        <input  style="width:80px;height:35px;font-size:12pt;text-align:center" type="button"  width="480" height="480"   id="btn_roundamount" name="btn_roundamount" class="btn btn-default" onclick ="open_modalstmeditround('<?= $result_seOps['VEHICLETRANSPORTPLANID'] ?>');" value="<?= $result_seOps['ROUNDAMOUNT'] ?>">
                                                    
                                                    <?php }  ?>
                                                </td>
                                                <td><?= $result_seOps['JOBSTART'] ?></td>
                                                
                                                <td><?= $result_seOps['CLUSTER'] ?></td>
                                                <td><?= $result_seOps['JOBEND'] ?></td>
                                                <!-- เวลารายงานตัว -->
                                                <?php
                                                if ($_GET['companycode'] == 'RCC' || $_GET['companycode'] == 'RATC' || $_GET['companycode'] == 'RRC') {
                                                ?>
                                                    <?php
                                                    if($result_seCheckpresente['CHECKPRESENT'] =='1'){
                                                    ?>
                                                        <td ><input  style="color: red" type="button"     id="btn_remark14" name="btn_remark14" class="btn btn-default" onclick ="open_modal('<?= $result_seOps['VEHICLETRANSPORTPLANID'] ?>');" value="<?= $result_seOps['DATEPRESENT'] ?>"></td>
                                                    <?php
                                                    }else{
                                                    ?>
                                                        <td><input  type="button"     id="btn_remark14" name="btn_remark14" class="btn btn-default" onclick ="open_modal('<?= $result_seOps['VEHICLETRANSPORTPLANID'] ?>');" value="<?= $result_seOps['DATEPRESENT'] ?>"></td>
                                                    <?php
                                                    }
                                                    ?>
                                                
                                                
                                                <?php
                                                // RKR,RKS,RKL
                                                }else {
                                                 ?>
                                                  <?php
                                                    if($result_seCheckpresente['CHECKPRESENT'] =='1'){
                                                    ?>
                                                        <td  style="color: red"><?= $result_seOps['DATEPRESENT'] ?></td>
                                                    <?php
                                                    }else{
                                                    ?>
                                                        <td <?= ($result_seCheckpresente['CHECKPRESENT']) ? "style='color: red'" : "" ?>><?= $result_seOps['DATEPRESENT'] ?></td>
                                                    <?php
                                                    }
                                                    ?>
                                                
                                                 <?php
                                                }
                                                ?>

                                                <!-- วันที่และเวลาทำงาน -->
                                                <?php
                                                if ($_GET['companycode'] == 'RCC' ||  $_GET['companycode'] == 'RATC') {
                                                ?>
                                                    <td><input  type="button"     id="btn_remark15" name="btn_remark15" class="btn btn-default" onclick ="open_modaldaterk('<?= $result_seOps['VEHICLETRANSPORTPLANID'] ?>','<?= $result_seOps['JOBSTART'] ?>','<?= $result_seOps['WORKTYPE'] ?>');" value="<?= $result_seOps['DATERK'] ?>"></td>
                                                  
                                                <?php
                                                // RKR,RKS,RKL
                                                }else {
                                                 ?>
                                                    <td><?= $result_seOps['DATERK'] ?></td>
                                                
                                                 <?php
                                                }
                                                ?>
                                                
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

        <input type="" disabled ="" id="txt_companycode"  name="txt_companycode"     style="display:none" value = "<?=$_GET['companycode']?>">
        <input type="" disabled ="" id="txt_customercode" name="txt_customercode"    style="display:none" value = "<?=$_GET['customercode']?>">
        <input type="" disabled ="" id="txt_datestart"    name="txt_datestart"       style="display:none" value = "<?=$_GET['datestart']?>">
        <input type="" disabled ="" id="txt_dateend"      name="txt_dateend"         style="display:none" value = "<?=$_GET['dateend']?>">
        <input type="" disabled ="" id="txt_statusnumber" name="txt_statusnumber"    style="display:none" value = "<?=$_GET['statusnumber']?>">                                

        <!-- Modal แสดงการแก้ไขวันที่ เวลา รายงานตัว-->
        <div class="modal fade" id="modal_tenkorestremark" name="modal_tenkorestremark" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document"  >
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="row">
                            <div class="col-lg-6">
                                <h5 class="modal-title" ><b>เลือกเวลารายงานตัว</b></h5>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <label>เวลารายงานตัว  </label>
                                <input type="text"  class="form-control datetimeen" id="txt_startrest" name="txt_startrest">
                            </div>
                        </div>
                        <div id="datacompdetaildatepresentsr"></div> 
                        <!-- txt_planid อยู่ตรงนี้ -->
                        <input type="hidden"  autocomplete="off" disabled ="" id="txt_planid" name="txt_planid" value="">
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-lg-12">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                            <button type="button" class="btn btn-primary"  onclick="save_presentdate()">บันทึก</button>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal ทะเบียนรถ-->
        <div class="modal fade" id="modal_modalthainame" name="modal_modalthainame" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document"  >
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="row">
                            <div class="col-lg-6">
                                <h5 class="modal-title" ><b>แก้ไขทะเบียนรถ</b></h5>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <label>ทะเบียนรถ</label>
                                <!-- <input type="text"  class="form-control" id="txt_copydiagramthainame11" name="txt_copydiagramthainame11"> -->
                                <select  onchange="select_sethainame()" id="cb_sethainame" name="cb_sethainame" class="selectpicker form-control"  data-container="body" data-live-search="true" title="เลือก ทะเบียนรถ..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98">
                                <?php
                                    $sql_seThainame = "SELECT a.VEHICLEINFOID, a.VEHICLEREGISNUMBER, a.THAINAME,a.REGISTYPE
                                        FROM VEHICLEINFO a
                                        WHERE a.ACTIVESTATUS = 1
                                        AND a.THAINAME != '-' 
                                        AND a.THAINAME != '--'
                                        AND a.REGISTYPE = 'ทะเบียนหัว'
                                        AND (a.ENGNAME  LIKE '%R-%' OR a.ENGNAME  LIKE '%RA-%')
                                        ORDER BY THAINAME,VEHICLEINFOID ASC";
                                    $params_seThainame = array();
                                    $query_seThainame = sqlsrv_query($conn, $sql_seThainame, $params_seThainame);
                                    while ($result_seThainame = sqlsrv_fetch_array($query_seThainame, SQLSRV_FETCH_ASSOC)) {
                                        ?>
                                        <option value="<?= $result_seThainame['THAINAME'] ?>"><?= str_replace("(4L)","",$result_seThainame['THAINAME']);  ?></option>
                                        
                                        <?php
                                    }
                                    ?>
                                    
                                </select>   
                                <input class="form-control" type="hidden"  id="txt_thainame" name="txt_thainame" maxlength="500" value="" >  
                            </div>
                        </div>
                        <div id="datacompdetaildatepresentsr"></div> 
                        <!-- txt_planid อยู่ตรงนี้ -->
                        <input type="hidden"  autocomplete="off" disabled ="" id="txt_planid" name="txt_planid" value="">
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-lg-12">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                            <button type="button" class="btn btn-primary"  onclick="save_thainame()">บันทึก</button>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal แก้ไขรอบวิ่งงาน STM-->
        <div  class="modal fade" id="modal_modalstmeditround" name="modal_modalstmeditround" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div style="width: 400px;" class="modal-dialog modal-sm" role="document"  >
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="row">
                            <div class="col-lg-12">
                                <h5 class="modal-title" ><b>แก้ไขรอบวิ่งงาน สายงาน STM</b></h5>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12" style="text-align:left">
                                <label>เลือกรอบวิ่งงาน STM</label>
                                <input type="text" class="form-control"  id="txt_editstmround" name="txt_editstmround">
                                
                                <!-- <select   id="cb_seround" name="cb_seround" class="selectpicker form-control"  data-container="body" data-live-search="true" title="เลือก รอบที่วิ่งงาน..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98">
                                     <?php
                                    $sql_seStmround = "SELECT STM_ROUND AS 'ROUND' FROM STM_ROUNDAMOUNT
                                    ORDER BY STM_ROUND ASC";
                                    $params_seStmround = array();
                                    $query_seStmround = sqlsrv_query($conn, $sql_seStmround, $params_seStmround);
                                    while ($result_seStmround = sqlsrv_fetch_array($query_seStmround, SQLSRV_FETCH_ASSOC)) {
                                        ?>
                                        <option value="<?= $result_seStmround['ROUND'] ?>"><?= $result_seStmround['ROUND'] ?></option>
                                        
                                        <?php
                                    }
                                    ?> 
                                    
                                    
                                    
                                </select>    -->
                                 
                            </div>
                        </div>
                        <div id="datacompdetaildatepresentsr"></div> 
                        <!-- txt_planid อยู่ตรงนี้ -->
                        <input type="hidden"  autocomplete="off" disabled ="" id="txt_planid_stmround" name="txt_planid_stmround" value="">
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-lg-12">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                            <button type="button" class="btn btn-primary"  onclick="save_stmround()">บันทึก</button>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- modal  แสดงการแก้ไขวันที่ เวลา ทำงาน-->
        <div class="modal fade" id="modal_editdaterk" name="modal_editdaterk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div style="width: 750px;" class="modal-dialog modal-md" role="document"  >
                <div class="modal-content">
                    
                    <input type="hidden"  autocomplete="off" disabled ="" id="txt_planid_editdaterk"  name="txt_planid_editdaterk"    value="">
                    <!-- ใช้ตัวนี้ -->
                    <input type="hidden"  autocomplete="off"  id="txt_jobstart_editdaterk" name="txt_jobstart_editdaterk" value="">
                    <input type="hidden"  autocomplete="off" disabled ="" id="txt_worktype_editdaterk" name="txt_worktype_editdaterk" value="">
                    
                    <div class="modal-header">
                        <div class="row">
                            <div class="col-lg-6">
                                <h5 class="modal-title" ><b>เลือกวันที่ และเวลาในการทำงาน</b></h5>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-10">
                                <b>เงื่อนไขการคำนวณเวลา</b><br>
                                <b>ต้นทาง:</b>&nbsp; GW,OTH เวลา -1 ชั่วโมง<br>
                                <b>ต้นทาง:</b>&nbsp; BP,BP(STOCK48RAI),BP25RAI,SW,SP เวลา -2 ชั่วโมง<br>
                                <b>ต้นทาง:</b>&nbsp; SR,TAC,Lenso,LCB เวลา -3 ชั่วโมง<br>
                                <b>ต้นทาง:</b>&nbsp; อื่นๆ เวลา ไม่ลบชั่วโมง<br>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-10">
                                <!-- ตัวนี้ใช้ทดสอบ -->
                                <!-- <b><font color="red">เปิดให้แก้ไขสำหรับทดสอบเท่านั้น</font></b><br> -->
                                <b>ต้นทางของแผนงานนี้: <input  disabled="" type="text"  autocomplete="off"  id="txt_jobstartshow_editdaterk" name="txt_jobstartshow_editdaterk" value=""></b><br>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <label>วันที่และเวลารายงานตัว  </label>
                                <input disabled="" type="text"  class="form-control datetimeen" id="txt_editdatepresent" name="txt_editdatepresent">
                            </div>
                            <div class="col-lg-6">
                                <label>วันที่และเวลาเริ่มงาน  </label>
                                <input type="text"  class="form-control datetimeen" id="txt_editdaterk" name="txt_editdaterk"  onchange="show_editdaterk(this.value)" autocomplete="off">
                            </div>
                        </div>
                        <div id="datacompdetaildatepresentsr"></div> 
                        <!-- txt_planid อยู่ตรงนี้ -->
                       
                    </div>
                    <br>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-lg-12">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                            <button type="button" class="btn btn-primary"  onclick="save_daterk()">บันทึก</button>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal แสดงข้อมูลการคีย์ค่าตอบแทน -->
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
        <!-- <script src="../dist/js/buttons.html5.min.js"></script>
        <script src="../dist/js/buttons.print.min.js"></script>  -->
        <script src="../dist/js/bootstrap-select.js"></script>
        <script src="../dist/js/jquery.autocomplete.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
        
        <script type="text/javascript"> 
                                                
                                                <?php
                                                $stmround = select_vehiclenumberautocomplate('megVehicleinfo_v2', 'select_roundstm', '');
                                                    
                                                ?>
                                                function delete_vehicletransportplan(vehicletransportplanid)
                                                {
                                                    // alert('delete');
                                                    // alert(vehicletransportplanid);

                                                    Swal.fire({
                                                        title: 'ต้องการลบข้อมูล?',
                                                        text: "กรุณากด 'ตกลง' เพื่อยืนยันการลบข้อมูล!!!",
                                                        icon: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonColor: '#3085d6',
                                                        cancelButtonColor: '#d33',
                                                        confirmButtonText: 'ตกลง',
                                                        cancelButtonText: 'ยกเลิก'
                                                    }).then((result) => {
                                                        
                                                        if (result.isConfirmed) {
                                                            
                                                            $.ajax({
                                                                type: 'post',
                                                                url: 'meg_data.php',
                                                                data: {
                                                                    txt_flg: "delete_vehicletransportplan", vehicletransportplanid: vehicletransportplanid
                                                                },
                                                                success: function (rs) {
                                                                    // alert('ลบข้อมูลเรียบร้อย');
                                                                    // location.reload();

                                                                    swal.fire({
                                                                        title: "Good Job!",
                                                                        text: "ลบข้อมูลเรียบร้อย",
                                                                        showConfirmButton: false,
                                                                        icon: "success"
                                                                    });
                                                                    // alert(rs); 
																	
																	 setTimeout(() => {
                                                                        document.location.reload();
																	 }, 1500);

                                                                }
                                                            });



                                                        }else{
                                                            //else check การลบข้อมูล
                                                            // window.location.reload();
                                                        }
                                                    })
                                                    
                                                    // var confirmation = confirm("ต้องการลบข้อมูล ?");
                                                    // if (confirmation) {
                                                    //     $.ajax({
                                                    //         type: 'post',
                                                    //         url: 'meg_data.php',
                                                    //         data: {
                                                    //             txt_flg: "delete_vehicletransportplan", vehicletransportplanid: vehicletransportplanid
                                                    //         },
                                                    //         success: function () {

                                                    //             window.location.reload();
                                                    //         }
                                                    //     });
                                                    // }
                                                }

                                                var txt_editstmround = [<?= $stmround ?>];
                                                $("#txt_editstmround").autocomplete({
                                                    source: [txt_editstmround]
                                                });

                                                function update_copydiagram(ID, fieldname, editableObj)
                                                    {

                                                        // alert(ID);
                                                        // alert(fieldname);
                                                        // alert(editableObj);

                                                        $.ajax({
                                                            type: 'post',
                                                            url: 'meg_data.php',
                                                            data: {
                                                                txt_flg: "edit_vehicletransportplan",
                                                                ID: ID,
                                                                fieldname: fieldname,
                                                                editableObj: editableObj
                                                            },
                                                            success: function (rs) {
                                                                // alert(rs);
                                                                //update_modalrks(ID);
                                                            }
                                                        });
                                                    }
                                                    function select_sethainame()
                                                    {
                                                        $('.selectpicker').on('changed.bs.select', function () {
                                                            document.getElementById('txt_thainame').value = $(this).val();
                                                            
                                                        });


                                                    }

                                                    $(function () {
                                                        $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                        // กรณีใช้แบบ input
                                                        $(".datetimeen").datetimepicker({
                                                            timepicker: true,
                                                            format: 'Y-m-d H:i' , // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00 - 00 - 0000
                                                            lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                            // timeFormat: "HH:mm"

                                                        }
                                                        );
                                                    });  
                                                    function open_modal(x){
                                                        $('#modal_tenkorestremark').modal('show');
                                                        document.getElementById("txt_planid").value = x;
                                                    } 
                                                    function open_modalthainame(x){
                                                        $('#modal_modalthainame').modal('show');
                                                        document.getElementById("txt_planid").value = x;
                                                    } 
                                                    function open_modalstmeditround(x){
                                                        $('#modal_modalstmeditround').modal('show');
                                                        document.getElementById("txt_planid_stmround").value = x;
                                                    } 
                                                    function open_modaldaterk(planid,jobstart,worktype){
                                                        $('#modal_editdaterk').modal('show');
                                                        document.getElementById("txt_planid_editdaterk").value = planid;
                                                        document.getElementById("txt_jobstart_editdaterk").value = jobstart;
                                                        document.getElementById("txt_jobstartshow_editdaterk").value = jobstart;
                                                        document.getElementById("txt_worktype_editdaterk").value = worktype;
                                                    } 
                                                    function save_presentdate()
                                                    {
                                                        var vehicleplanid = document.getElementById("txt_planid").value;
                                                        var value  = document.getElementById("txt_startrest").value;

                                                        // alert(vehicleplanid);
                                                        // alert(value);

                                                        
                                                        $.ajax({
                                                                url: 'meg_data2.php',
                                                                type: 'POST',
                                                                data: {
                                                                    txt_flg: "edit_vehicletransportdocumentplanclosejob", ID: vehicleplanid, fieldname: 'DATEPRESENT', editableObj: value
                                                                },
                                                                success: function () {
                                                                alert('แก้ไขเวลารายงานตัวเรียบร้อย');
                                                                window.location.reload();      
                                                                }
                                                            });
                                                    }
                                                    function save_thainame()
                                                    {
                                                        var vehicleplanid = document.getElementById("txt_planid").value;
                                                        var value  = document.getElementById("cb_sethainame").value;

                                                        // alert(vehicleplanid);
                                                        // alert(value);
                                                        $.ajax({
                                                                url: 'meg_data2.php',
                                                                type: 'POST',
                                                                data: {
                                                                    txt_flg: "edit_vehicletransportdocumentsavethainame", ID: vehicleplanid, fieldname: 'THAINAME', editableObj: value
                                                                },
                                                                success: function () {
                                                                alert('แก้ไขทะเบียนรถเรียบร้อย');
                                                                window.location.reload();     
                                                                }
                                                            });
                                                    }
                                                    //function แก้ไขรอบวิ่งงานสายงาย STM
                                                    function save_stmround(){
                                                        var vehicleplanid = document.getElementById("txt_planid_stmround").value;
                                                        var value  = document.getElementById("txt_editstmround").value;

                                                        // alert(vehicleplanid);
                                                        // alert(value);
                                                        
                                                        if (value == '') {
                                                            // alert('กรุณาเลือกรอบวิ่งงานให้ถูกต้อง หรือ กดปิดถ้าไม่ต้องการแก้ไข');
                                                            swal.fire({
                                                                title: "warning",
                                                                text: "กรุณาเลือกรอบวิ่งงานให้ถูกต้อง กดปิดถ้าไม่ต้องการแก้ไข",
                                                                icon: "warning",

                                                                // text: "กรุณาเลือกรอบวิ่งงานให้ถูกต้อง หรือ\n <br>กดปิดถ้าไม่ต้องการแก้ไข",
                                                            });
                                                        }else{
                                                            $.ajax({
                                                                url: 'meg_data2.php',
                                                                type: 'POST',
                                                                data: {
                                                                    txt_flg: "edit_vehicletransportdocumentsavestmround", ID: vehicleplanid, fieldname: 'ROUNDAMOUNT', editableObj: value
                                                                },
                                                                success: function () {
                                                                    // alert('แก้ไขรอบวิ่งงานเรียบร้อย');
                                                                    swal.fire({
                                                                        title: "Good Job!",
                                                                        text: "แก้ไขรอบวิ่งงานเรียบร้อย",
                                                                        icon: "success",
                                                                    });
                                                                    $('#modal_modalstmeditround').modal('hide');
                                                                    window.location.reload();     
                                                                }
                                                            });
                                                        }

                                                    }
                                                    
                                                    function show_editdaterk(data){
                                                        // อันนี้ใช้ในระบบจริง
                                                        var jobstart  = document.getElementById("txt_jobstart_editdaterk").value;

                                                        // อันนี้ใช้ในระบบทดสอบ
                                                        // var jobstart  = document.getElementById("txt_jobstartshow_editdaterk").value;
                                                        var worktype  = document.getElementById("txt_worktype_editdaterk").value;
                                                        // alert(data);
                                                        // alert(jobstart);
                                                        // alert(worktype);


                                                        // คำนวณวันที่รายงานตัวแยกตามต้นทาง และส่งค่าไป modal 
                                                        if (worktype == 'sh')
                                                        {   
                                                                // alert("งานSH กดข้ามวัน");
                                                            if (jobstart == "GW" || jobstart == "OTH" ){
                                                                //GW -1 ชั่วโมง 
                                                                // alert("งานSH กดข้ามวันต้นทาง GW");   
                                                                var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                                                                var startDateTime = datechk;
                                                                var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(1, 'hours').format('YYYY/MM/DD HH:mm');
                                                                
                                                                document.getElementById("txt_editdatepresent").value = newDateTime;

                                                        
                                                                
                                                            }else if (jobstart == "BP" || jobstart == "BP(STOCK48RAI)" || jobstart == "BP25RAI"  || jobstart == "SW" || jobstart == "SP"){
                                                                // BP,BP(STOCK48RAI),BP25RAI,SW,SP -2  ชั่วโมง  
                                                                // alert("งานSH กดข้ามวันต้นทาง BP,BP(STOCK48RAI),BP25RAI,SW,SP");   
                                                                var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                                                                var startDateTime = datechk;
                                                                var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(2, 'hours').format('YYYY/MM/DD HH:mm');
                                                        
                                                            document.getElementById("txt_editdatepresent").value = newDateTime;
                                                                
                                                            
                                                            }else if (jobstart == "SR" || jobstart == "TAC" || jobstart == "Lenso" || jobstart == "LCB"){
                                                                // SR,TAC,Lenso,LCB -3   ชั่วโมง
                                                                // alert("งานSH กดข้ามวันต้นทาง BP,BP(STOCK48RAI),BP25RAI,SW,SP");   
                                                                var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                                                                var startDateTime = datechk;
                                                                var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(3, 'hours').format('YYYY/MM/DD HH:mm');
                                                        
                                                            document.getElementById("txt_editdatepresent").value = newDateTime;  
                                                                
                                                            }else{
                                                                // อื่นๆไม่ลบชั่วโมง  
                                                                var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                                                                var startDateTime = datechk;
                                                                var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(0, 'hours').format('YYYY/MM/DD HH:mm');
                                                            
                                                                document.getElementById("txt_editdatepresent").value = newDateTime;

                                                            }
                                                            
                                                        } else
                                                        {

                                                            //วางแผนงาน NM OR SH(N) กดข้ามวัน
                                                            if (jobstart == "GW" || jobstart == "OTH")
                                                            {
                                                                // alert("งานSH กดข้ามวันต้นทาง GW");   
                                                                var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                                                                var startDateTime = datechk;
                                                                var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(1, 'hours').format('YYYY/MM/DD HH:mm');
                                                            
                                                                document.getElementById("txt_editdatepresent").value = newDateTime;

                                                            } else if (jobstart == "BP" || jobstart == "BP25" || jobstart == "BP(STOCK48RAI)" || jobstart == "BP25RAI" || jobstart == "SW" || jobstart == "SP")
                                                            {
                                                                // BP,BP(STOCK48RAI),BP25RAI,SW,SP -2    
                                                                // alert("งานSH กดข้ามวันต้นทาง BP,BP(STOCK48RAI),BP25RAI,SW,SP");   
                                                                var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                                                                var startDateTime = datechk;
                                                                var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(2, 'hours').format('YYYY/MM/DD HH:mm');
                                                            
                                                                document.getElementById("txt_editdatepresent").value = newDateTime;

                                                            } else if (jobstart == "SR" || jobstart == "TAC" || jobstart == "LCB" )
                                                            {
                                                                // SR,TAC,Lenso,LCB -3   
                                                                // alert("งานSH กดข้ามวันต้นทาง BP,BP(STOCK48RAI),BP25RAI,SW,SP");   
                                                                var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                                                                var startDateTime = datechk;
                                                                var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(3, 'hours').format('YYYY/MM/DD HH:mm');
                                                            
                                                                document.getElementById("txt_editdatepresent").value = newDateTime;

                                                            } else
                                                            {
                                                                // อื่นๆไม่ลบชั่วโมง  
                                                                var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                                                                var startDateTime = datechk;
                                                                var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(0, 'hours').format('YYYY/MM/DD HH:mm');
                                                            
                                                                document.getElementById("txt_editdatepresent").value = newDateTime;
                                                                


                                                            }
                                                        }

                                                    }
                                                    function save_daterk()
                                                    {
                                                        var vehicleplanid   = document.getElementById("txt_planid_editdaterk").value;
                                                        var datepresent     = document.getElementById("txt_editdatepresent").value;
                                                        var daterk          = document.getElementById("txt_editdaterk").value;

                                                         // alert(vehicleplanid);
                                                         // alert(datepresent);
                                                         // alert(daterk);

                                                        if (daterk == '') {
                                                            alert("ไม่สามารถบันทึกได้ กรุณาเลือกวันที่เริ่มงาน!!!");
                                                        }else{
                                                            // save daterk บันทึกเวลาเริ่มงาน
                                                            $.ajax({
                                                                url: 'meg_data2.php',
                                                                type: 'POST',
                                                                data: {
                                                                    txt_flg: "edit_vehicletransportdocumentplanclosejob", ID: vehicleplanid, fieldname: 'DATEPRESENT', editableObj: datepresent
                                                                },
                                                                success: function () {
                                                                // alert('แก้ไขเวลาเริ่มงานเรียบร้อย');
                                                                // window.location.reload();      
                                                                }
                                                            });

                                                            // save datepresent บันทึกเวลารายงานตัว
                                                            $.ajax({
                                                                url: 'meg_data2.php',
                                                                type: 'POST',
                                                                data: {
                                                                    txt_flg: "edit_vehicletransportdocumentplanclosejob", ID: vehicleplanid, fieldname: 'DATERK', editableObj: daterk
                                                                },
                                                                success: function () {
                                                                alert('แก้ไขเวลาเริ่มงานและเวลารายงานตัวเรียบร้อย');
                                                                // window.location.reload();      
                                                                }
                                                            });
                                                        }
                                                     
                                                    }
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

                                                    function getPlanid2(planid) {
                                                        // alert(planid);
                                                        select_editjobdatepresent(planid);
                                                    }
                                                    
                                                    function editjob(com,cus,planid,statusnumber,datestart,dateend) {
                                                        // alert(planid);
                                                        var companycode  = com;
                                                        var customercode = cus;
                                                        var vehicletransportplanid = planid;
                                                        var statusnumber = statusnumber;
                                                        var datestart = datestart;
                                                        var dateend = dateend;

                                                        // alert(companycode);
                                                        // alert(customercode);
                                                        // alert(vehicletransportplanid);
                                                        // alert(statusnumber);
                                                        // alert(datestart);
                                                        // alert(dateend);

                                                        // window.open('meg_tenkodocument.php?vehicletransportplanid=' + vehicletransportplanid, '_blank');
                                                        window.open('meg_transportplanmix.php?type=transportplan&meg=add&companycode=' + companycode+'&customercode=' + customercode+'&vehicletransportplanid=' + vehicletransportplanid+'&statusnumber=' + statusnumber+'&datestart=' + datestart+'&dateend=' + dateend, '_blank');
                                                        // window.open('meg_transportplanmix.php?type=transportplan&meg=add&companycode=<?= $companycode ?>&customercode=<?= $customercode ?>&vehicletransportplanid=<?= $vehicletransportplanid ?>&statusnumber=<?= $statusnumber ?>&datestart=<?= $datestart ?>&dateend=<?= $dateend ?>', '_blank');
                                                        
                                                        
                                                       
                                                    } 
                                                    function closejob(planid) {
                                                        // alert(planid);
                                                        var vehicleplanid = planid;
                                                        // alert(vehicleplanid);
                                                        
                                                        $.ajax({
                                                            url: 'meg_data2.php',
                                                            type: 'POST',
                                                            data: {
                                                                txt_flg: "edit_vehicletransportdocumentplanclosejob", ID: vehicleplanid, fieldname: 'STATUS', editableObj: 'แผนงานปิดงาน'
                                                            },
                                                            success: function () {
                                                               

                                                            }
                                                        });

                                                        $.ajax({
                                                            url: 'meg_data2.php',
                                                            type: 'POST',
                                                            data: {
                                                                txt_flg: "edit_vehicletransportdocumentplanclosejob", ID: vehicleplanid, fieldname: 'STATUSNUMBER', editableObj: '2'
                                                            },
                                                            success: function ($rs) {
																
																//swal.fire({
                                                                //    title: "Good Job!",
                                                                //    text: "ปิดงานเรียบร้อย !!!",
                                                                //    icon: "success",
                                                                //    showConfirmButton: false,
                                                                //    allowOutsideClick: false,
                                                                //});
																
                                                                //setTimeout(() => {
                                                                //    document.location.reload();
                                                                //}, 1800);
																
                                                                //if ($rs = ' ') {
                                                                //    alert('ปิดงานเรียบร้อย..........');    
                                                                //}else{
                                                                //    alert($rs);
                                                                //}
                                                                
                                                                
                                                            }
                                                        });
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
                                                        var  companycode  = document.getElementById("txt_companycode").value;
                                                        var  customercode = document.getElementById("txt_customercode").value;
                                                        var  datestart = document.getElementById("txt_datestart").value;
                                                        var  dateend = document.getElementById("txt_dateend").value;
                                                        var  statusnumber = document.getElementById("txt_statusnumber").value;

                                                        // alert(companycode);
                                                        // alert(customercode);
                                                        // alert(datestart);
                                                        // alert(dateend);
                                                        // alert(statusnumber);

                                                        // alert(planid);
                                                        $.ajax({
                                                            type: 'post',
                                                            url: 'meg_data2.php',
                                                            data: {
                                                                txt_flg: "select_customercompensationdetail", planid: planid,companycode:companycode,customercode:customercode,datestart:datestart,dateend:dateend,statusnumber:statusnumber
                                                            },
                                                            success: function (response) {
                                                                if (response) {

                                                                    document.getElementById("datacompdetailsr").innerHTML = response;
                                                                    // document.getElementById("datacompdetaildef").innerHTML = "";

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
                                                           // alert('ไม่มีเลขที่เท็งโกะ กรุณาตรวจสอบข้อมูล หรือ แจ้งเจ้าหน้าที่')
														   swal.fire({
                                                                title: "Warning!",
                                                                text: "ไม่มีเลขที่เท็งโกะ กรุณาตรวจสอบข้อมูล หรือ แจ้งเจ้าหน้าที่",
                                                                icon: "warning",
                                                                showConfirmButton: true,
                                                                allowOutsideClick: false,
                                                            });
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
                                                                        save_logprocess('Driver Management', 'Save Open Job', '<?= $_SESSION["USERNAME"] ?>');
                                                                    } else if (statusnumber == '2')
                                                                    {
                                                                        save_logprocess('Driver Management', 'Save Close Job', '<?= $_SESSION["USERNAME"] ?>');
                                                                    } else if (statusnumber == 'X')
                                                                    {
                                                                        save_logprocess('Driver Management', 'Save Cut Job', '<?= $_SESSION["USERNAME"] ?>');
                                                                    }
																
																	//swal.fire({
                                                                    //    title: "Good Job!",
                                                                    //    text: "ดำเนินการเรียบร้อย",
                                                                    //    icon: "success",
                                                                    //    showConfirmButton: false,
                                                                    //    allowOutsideClick: false,
                                                                    //});
                                                                    // alert(rs);   
																	
                                                                    //setTimeout(() => {
                                                                    //    document.location.reload();
                                                                    //}, 1800);

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
