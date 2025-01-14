<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

// if ($_GET['id1'] != "") {
//     $condition1 = " AND a.MENUID = " . $_GET['id1'];
//     $sql_getMenu = "{call megMenu_v2(?,?)}";
//     $params_getMenu = array(
//         array('select_menu', SQLSRV_PARAM_IN),
//         array($condition1, SQLSRV_PARAM_IN)
//     );
//     $query_getMenu = sqlsrv_query($conn, $sql_getMenu, $params_getMenu);
//     $result_getMenu = sqlsrv_fetch_array($query_getMenu, SQLSRV_FETCH_ASSOC);
// }

$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

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
        <!-- <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet"> -->
        <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
        <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">

        <!-- <link href="../dist/css/buttons.dataTables.min.css" rel="stylesheet">
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet"> -->
        

        
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
            table.dataTable thead .sorting_desc {
                background: white; 
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
            
            #loading {
                display:none; 
                opacity: 0.5;
                /* border-radius: 50%; */
                /* border-top: 12px ; */
                width: 10px;
                left: 10px;
                right: 800px;
                top:10px;
                bottom: 450px;
                height: 10px;
                
                /* animation: spin 1s linear infinite; */
            }
            
            .center {
                position: absolute;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
                margin: auto;
            }
            /* #spinner:not([hidden]) {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            #spinner::after {
                content: "";
                width: 200px;
                height: 200px;
                border: 30px solid #f3f3f3;
                border-top: 30px solid #f25a41;
                border-radius: 100%;
                will-change: transform;
                animation: spin 1s infinite linear
            }

            @keyframes spin {
                from {
                    transform: rotate(0deg);
                }
                to {
                    transform: rotate(360deg);
                }
            } */
        </style>
    </head>

    <body>
        <div id="wrapper">

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

            <!-- <div id="page-wrapper" > -->
                <div class="row">
                    <div class="col-md-12">&nbsp;</div>
                </div>

                <!-- <ul class="nav nav-pills">
                    <li class="active"><a href="#tenko1" data-toggle="tab" aria-expanded="false">แผนงาน (1)</a>
                    </li>
                    <li ><a href="#tenko2" data-toggle="tab" aria-expanded="true">แผนงาน (2)</a>
                    </li>


                </ul> -->
                <div class="tab-content">
                    <div class="row">
                        <div class="col-md-12">&nbsp;</div>
                    </div>
                    <div class="tab-pane fade  active in" id="tenko1">

                        <div class="row">


                            <div class="col-md-2" >
                                <label>บริษัท</label>
                                <select class="form-control"  id="cb_company" name="cb_company">

                                    <option value = "RCC">ร่วมกิจรุ่งเรือง คาร์ แคริเออร์</option>
                                    <option value = "RATC">ร่วมกิจ ออโตโมทีฟ ทรานสปอร์ต</option>
                                    <option value = "RRC">ร่วมกิจ รีไซเคิล แคริเออร์</option>

                                </select>
                            </div>
                            <div class="col-lg-2">

                                <div class="form-group">
                                    <label>ค้นหาตามช่วงวันที่</label>
                                    <input class="form-control dateen" readonly="" onchange="datetodate();" style="background-color: #f080802e" id="txt_datestart" name="txt_datestart" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">

                                </div>

                            </div>
                            <div class="col-lg-2">
                                <label>&nbsp;</label>
                                <div class="form-group">
                                    <input type="text" class="form-control dateen" readonly="" style="background-color: #f080802e" id="txt_dateend" name="txt_dateend" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE']; ?>">

                                </div>
                            </div>


                            <div class="col-lg-2">
                                <label>&nbsp;</label>
                                <div class="form-group">
                                    <button class="btn btn-default" onclick="select_customertenkogateway();">ค้นหา <li class="fa fa-search"></li></button>
                                </div>

                            </div>

                        </div>
                        <!-- /.row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">

                                        <a href='index2.php'>หน้าแรก</a> / แผนงาน
                                    </div>
                                    <!-- /.panel-heading -->

                                    <div class="panel-body">
                                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                            <div id="datadef">
                                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>ชื่อลูกค้า</th>
                                                            <th>แผนงานทั้งหมด</th>
                                                            <th>แผนงานยังไม่ถึงเวลารายงานตัว</th>
                                                            <th>แผนงานตรวจร่างกายเรียบร้อย</th>
                                                            <th>แผนงานเลยเวลารายงานตัว</th>
                                                            <th>แผนงานเปิดงาน</th>
                                                            <th>แผนงานปิดงาน</th>
                                                            <th>แผนงานเอกสารสมบูรณ์</th>
                                                            <th>แผนงานตัดงาน</th>
                                                            <th>แผนงานยกเลิก</th>


                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $condCustomer = " AND COMPANYCODE IN ('RCC')";
                                                        $sql_seCustomer = "{call megCustomer_v2(?,?)}";
                                                        $params_seCustomer = array(
                                                            array('select_customer', SQLSRV_PARAM_IN),
                                                            array($condCustomer, SQLSRV_PARAM_IN)
                                                        );
                                                        $query_seCustomer = sqlsrv_query($conn, $sql_seCustomer, $params_seCustomer);
                                                        while ($result_seCustomer = sqlsrv_fetch_array($query_seCustomer, SQLSRV_FETCH_ASSOC)) {
                                                            if ($result_seCustomer['STATUSNUMBER'] != '' || $result_seCustomer['STATUSNUMBER'] != 'NULL') {
                                                                $condCntcusall = " AND a.COMPANYCODE = '" . $result_seCustomer['COMPANYCODE'] . "' AND a.CUSTOMERCODE = '" . $result_seCustomer['CUSTOMERCODE'] . "' ";
                                                                $sql_seCntcusall = "{call megCustomer_v2(?,?,?)}";
                                                                $params_seCntcusall = array(
                                                                    array('select_cntcustomer', SQLSRV_PARAM_IN),
                                                                    array($condCntcusall, SQLSRV_PARAM_IN),
                                                                    array(" AND CONVERT(DATE,a.DATEWORKING,103) BETWEEN CONVERT(DATE,GETDATE(),103) AND CONVERT(DATE,GETDATE(),103) ", SQLSRV_PARAM_IN)
                                                                );
                                                                $query_seCntcusall = sqlsrv_query($conn, $sql_seCntcusall, $params_seCntcusall);
                                                                $result_seCntcusall = sqlsrv_fetch_array($query_seCntcusall, SQLSRV_FETCH_ASSOC);
                                                            } else {
                                                                $condCntcusall = " AND a.COMPANYCODE = '" . $result_seCustomer['COMPANYCODE'] . "' AND a.CUSTOMERCODE = '" . $result_seCustomer['CUSTOMERCODE'] . "'  ";
                                                                $sql_seCntcusall = "{call megCustomer_v2(?,?,?)}";
                                                                $params_seCntcusall = array(
                                                                    array('select_cntcustomer', SQLSRV_PARAM_IN),
                                                                    array($condCntcusall, SQLSRV_PARAM_IN),
                                                                    array(" AND CONVERT(DATE,a.DATEWORKING,103) BETWEEN CONVERT(DATE,GETDATE(),103) AND CONVERT(DATE,GETDATE(),103) ", SQLSRV_PARAM_IN)
                                                                );
                                                                $query_seCntcusall = sqlsrv_query($conn, $sql_seCntcusall, $params_seCntcusall);
                                                                $result_seCntcusall = sqlsrv_fetch_array($query_seCntcusall, SQLSRV_FETCH_ASSOC);
                                                            }






                                                            $condCntcus0 = " AND a.COMPANYCODE = '" . $result_seCustomer['COMPANYCODE'] . "' AND a.CUSTOMERCODE = '" . $result_seCustomer['CUSTOMERCODE'] . "' AND a.STATUSNUMBER = 'O'  ";
                                                            $sql_seCntcus0 = "{call megCustomer_v2(?,?,?)}";
                                                            $params_seCntcus0 = array(
                                                                array('select_cntcustomer', SQLSRV_PARAM_IN),
                                                                array($condCntcus0, SQLSRV_PARAM_IN),
                                                                array(" AND CONVERT(DATE,a.DATEWORKING,103) BETWEEN CONVERT(DATE,GETDATE(),103) AND CONVERT(DATE,GETDATE(),103) ", SQLSRV_PARAM_IN)
                                                            );
                                                            $query_seCntcus0 = sqlsrv_query($conn, $sql_seCntcus0, $params_seCntcus0);
                                                            $result_seCntcus0 = sqlsrv_fetch_array($query_seCntcus0, SQLSRV_FETCH_ASSOC);


                                                            $condCntcuspresent1 = " AND a.COMPANYCODE = '" . $result_seCustomer['COMPANYCODE'] . "' AND a.CUSTOMERCODE = '" . $result_seCustomer['CUSTOMERCODE'] . "' ";
                                                            $condCntcuspresent2 = " AND a.STATUSNUMBER = 'P' AND a.STATUSNUMBER != '0' AND CONVERT(DATE,a.DATEWORKING,103) BETWEEN CONVERT(DATE,GETDATE(),103) AND CONVERT(DATE,GETDATE(),103) ";
                                                            $sql_seCntcuspresent = "{call megCustomer_v2(?,?,?)}";
                                                            $params_seCntcuspresent = array(
                                                                array('select_cntcustomerpresent', SQLSRV_PARAM_IN),
                                                                array($condCntcuspresent1, SQLSRV_PARAM_IN),
                                                                array($condCntcuspresent2, SQLSRV_PARAM_IN)
                                                            );
                                                            $query_seCntcuspresent = sqlsrv_query($conn, $sql_seCntcuspresent, $params_seCntcuspresent);
                                                            $result_seCntcuspresent = sqlsrv_fetch_array($query_seCntcuspresent, SQLSRV_FETCH_ASSOC);

                                                            $condCntcus1 = " AND a.COMPANYCODE = '" . $result_seCustomer['COMPANYCODE'] . "' AND a.CUSTOMERCODE = '" . $result_seCustomer['CUSTOMERCODE'] . "' AND a.STATUSNUMBER = 'L' ";
                                                            $sql_seCntcus1 = "{call megCustomer_v2(?,?,?)}";
                                                            $params_seCntcus1 = array(
                                                                array('select_cntcustomer', SQLSRV_PARAM_IN),
                                                                array($condCntcus1, SQLSRV_PARAM_IN),
                                                                array("  AND CONVERT(DATE,a.DATEWORKING,103) BETWEEN CONVERT(DATE,GETDATE(),103) AND CONVERT(DATE,GETDATE(),103)", SQLSRV_PARAM_IN)
                                                            );
                                                            $query_seCntcus1 = sqlsrv_query($conn, $sql_seCntcus1, $params_seCntcus1);
                                                            $result_seCntcus1 = sqlsrv_fetch_array($query_seCntcus1, SQLSRV_FETCH_ASSOC);


                                                            if ($result_seCustomer['STATUSNUMBER'] != '' || $result_seCustomer['STATUSNUMBER'] != 'NULL') {
                                                                $condCntcus2 = " AND a.COMPANYCODE = '" . $result_seCustomer['COMPANYCODE'] . "' AND a.CUSTOMERCODE = '" . $result_seCustomer['CUSTOMERCODE'] . "' AND (a.STATUSNUMBER = '1'  OR a.STATUSNUMBER = 'T')  ";
                                                                $sql_seCntcus2 = "{call megCustomer_v2(?,?,?)}";
                                                                $params_seCntcus2 = array(
                                                                    array('select_cntcustomer', SQLSRV_PARAM_IN),
                                                                    array($condCntcus2, SQLSRV_PARAM_IN),
                                                                    array("  AND CONVERT(DATE,a.DATEWORKING,103) BETWEEN CONVERT(DATE,GETDATE(),103) AND CONVERT(DATE,GETDATE(),103)", SQLSRV_PARAM_IN)
                                                                );
                                                                $query_seCntcus2 = sqlsrv_query($conn, $sql_seCntcus2, $params_seCntcus2);
                                                                $result_seCntcus2 = sqlsrv_fetch_array($query_seCntcus2, SQLSRV_FETCH_ASSOC);
                                                            } else {
                                                                $condCntcus2 = " AND a.COMPANYCODE = '" . $result_seCustomer['COMPANYCODE'] . "' AND a.CUSTOMERCODE = '" . $result_seCustomer['CUSTOMERCODE'] . "' AND (a.STATUSNUMBER = '1'  OR a.STATUSNUMBER = 'T') AND VEHICLETRANSPORTPLANID NOT IN (SELECT VEHICLETRANSPORTPLANID FROM TENKOMASTER) ";
                                                                $sql_seCntcus2 = "{call megCustomer_v2(?,?,?)}";
                                                                $params_seCntcus2 = array(
                                                                    array('select_cntcustomer', SQLSRV_PARAM_IN),
                                                                    array($condCntcus2, SQLSRV_PARAM_IN),
                                                                    array("  AND CONVERT(DATE,a.DATEWORKING,103) BETWEEN CONVERT(DATE,GETDATE(),103) AND CONVERT(DATE,GETDATE(),103)", SQLSRV_PARAM_IN)
                                                                );
                                                                $query_seCntcus2 = sqlsrv_query($conn, $sql_seCntcus2, $params_seCntcus2);
                                                                $result_seCntcus2 = sqlsrv_fetch_array($query_seCntcus2, SQLSRV_FETCH_ASSOC);
                                                            }




                                                            $condCntcus3 = " AND a.COMPANYCODE = '" . $result_seCustomer['COMPANYCODE'] . "' AND a.CUSTOMERCODE = '" . $result_seCustomer['CUSTOMERCODE'] . "' AND a.STATUSNUMBER = '2'  ";
                                                            $sql_seCntcus3 = "{call megCustomer_v2(?,?,?)}";
                                                            $params_seCntcus3 = array(
                                                                array('select_cntcustomer', SQLSRV_PARAM_IN),
                                                                array($condCntcus3, SQLSRV_PARAM_IN),
                                                                array("  AND CONVERT(DATE,a.DATEWORKING,103) BETWEEN CONVERT(DATE,GETDATE(),103) AND CONVERT(DATE,GETDATE(),103)", SQLSRV_PARAM_IN)
                                                            );
                                                            $query_seCntcus3 = sqlsrv_query($conn, $sql_seCntcus3, $params_seCntcus3);
                                                            $result_seCntcus3 = sqlsrv_fetch_array($query_seCntcus3, SQLSRV_FETCH_ASSOC);

                                                            $condCntcus4 = " AND a.COMPANYCODE = '" . $result_seCustomer['COMPANYCODE'] . "' AND a.CUSTOMERCODE = '" . $result_seCustomer['CUSTOMERCODE'] . "' AND a.STATUSNUMBER = '3' AND VEHICLETRANSPORTPLANID NOT IN (SELECT VEHICLETRANSPORTPLANID FROM TENKOMASTER) ";
                                                            $sql_seCntcus4 = "{call megCustomer_v2(?,?,?)}";
                                                            $params_seCntcus4 = array(
                                                                array('select_cntcustomer', SQLSRV_PARAM_IN),
                                                                array($condCntcus4, SQLSRV_PARAM_IN),
                                                                array("  AND CONVERT(DATE,a.DATEWORKING,103) BETWEEN CONVERT(DATE,GETDATE(),103) AND CONVERT(DATE,GETDATE(),103)", SQLSRV_PARAM_IN)
                                                            );
                                                            $query_seCntcus4 = sqlsrv_query($conn, $sql_seCntcus4, $params_seCntcus4);
                                                            $result_seCntcus4 = sqlsrv_fetch_array($query_seCntcus4, SQLSRV_FETCH_ASSOC);

                                                            $condCntcus5 = " AND a.COMPANYCODE = '" . $result_seCustomer['COMPANYCODE'] . "' AND a.CUSTOMERCODE = '" . $result_seCustomer['CUSTOMERCODE'] . "' AND a.STATUSNUMBER = 'X' ";
                                                            $sql_seCntcus5 = "{call megCustomer_v2(?,?,?)}";
                                                            $params_seCntcus5 = array(
                                                                array('select_cntcustomer', SQLSRV_PARAM_IN),
                                                                array($condCntcus5, SQLSRV_PARAM_IN),
                                                                array("  AND CONVERT(DATE,a.DATEWORKING,103) BETWEEN CONVERT(DATE,GETDATE(),103) AND CONVERT(DATE,GETDATE(),103)", SQLSRV_PARAM_IN)
                                                            );
                                                            $query_seCntcus5 = sqlsrv_query($conn, $sql_seCntcus5, $params_seCntcus5);
                                                            $result_seCntcus5 = sqlsrv_fetch_array($query_seCntcus5, SQLSRV_FETCH_ASSOC);

                                                            $condCntcus6 = " AND a.COMPANYCODE = '" . $result_seCustomer['COMPANYCODE'] . "' AND a.CUSTOMERCODE = '" . $result_seCustomer['CUSTOMERCODE'] . "' AND a.STATUSNUMBER = '0'AND VEHICLETRANSPORTPLANID NOT IN (SELECT VEHICLETRANSPORTPLANID FROM TENKOMASTER) ";
                                                            $sql_seCntcus6 = "{call megCustomer_v2(?,?,?)}";
                                                            $params_seCntcus6 = array(
                                                                array('select_cntcustomer', SQLSRV_PARAM_IN),
                                                                array($condCntcus6, SQLSRV_PARAM_IN),
                                                                array("  AND CONVERT(DATE,a.DATEWORKING,103) BETWEEN CONVERT(DATE,GETDATE(),103) AND CONVERT(DATE,GETDATE(),103)", SQLSRV_PARAM_IN)
                                                            );
                                                            $query_seCntcus6 = sqlsrv_query($conn, $sql_seCntcus6, $params_seCntcus6);
                                                            $result_seCntcus6 = sqlsrv_fetch_array($query_seCntcus6, SQLSRV_FETCH_ASSOC);
                                                            ?>
                                                            <tr>
                                                                <td>(<?= $result_seCustomer['COMPANYCODE'] ?>) <?= $result_seCustomer['NAMETH'] ?></td>
                                                                <td style="text-align: center"><b><?= $result_seCntcus0['cnt'] + $result_seCntcuspresent['cnt'] + $result_seCntcus1['cnt'] + $result_seCntcus2['cnt'] + $result_seCntcus3['cnt'] + $result_seCntcus4['cnt'] + $result_seCntcus5['cnt'] + $result_seCntcus6['cnt'] ?></b></td>
                                                                <td style="text-align: center"><?php if ($result_seCntcus0['cnt'] != '0') { ?><a href="#" onclick="select_customertenkoamatacnt('<?= $result_seCustomer['CUSTOMERCODE'] ?>', 'O')" ><?= $result_seCntcus0['cnt'] ?></a><?php } else { ?><?php } ?></td>
                                                                <td style="text-align: center"><?php if ($result_seCntcuspresent['cnt'] != '0') { ?><a href="#" onclick="select_customertenkoamatacnt('<?= $result_seCustomer['CUSTOMERCODE'] ?>', 'P')" ><?= $result_seCntcuspresent['cnt'] ?></a><?php } else { ?><?php } ?></td>
                                                                <td style="text-align: center"><?php if ($result_seCntcus1['cnt'] != '0') { ?><a href="#" onclick="select_customertenkoamatacnt('<?= $result_seCustomer['CUSTOMERCODE'] ?>', 'L')" ><?= $result_seCntcus1['cnt'] ?></a><?php } else { ?><?php } ?></td>
                                                                <td style="text-align: center"><?php if ($result_seCntcus2['cnt'] != '0') { ?><a href="#" onclick="select_customertenkoamatacnt('<?= $result_seCustomer['CUSTOMERCODE'] ?>', '1')" ><?= $result_seCntcus2['cnt'] ?></a><?php } else { ?><?php } ?></td>
                                                                <td style="text-align: center"><?php if ($result_seCntcus3['cnt'] != '0') { ?><a href="#" onclick="select_customertenkoamatacnt('<?= $result_seCustomer['CUSTOMERCODE'] ?>', '2')" ><?= $result_seCntcus3['cnt'] ?></a><?php } else { ?><?php } ?></td>
                                                                <td style="text-align: center"><?php if ($result_seCntcus4['cnt'] != '0') { ?><a href="#" onclick="select_customertenkoamatacnt('<?= $result_seCustomer['CUSTOMERCODE'] ?>', '3')" ><?= $result_seCntcus4['cnt'] ?></a><?php } else { ?><?php } ?></td>
                                                                <td style="text-align: center"><?php if ($result_seCntcus5['cnt'] != '0') { ?><a href="#" onclick="select_customertenkoamatacnt('<?= $result_seCustomer['CUSTOMERCODE'] ?>', 'X')" ><?= $result_seCntcus5['cnt'] ?></a><?php } else { ?><?php } ?></td>
                                                                <td style="text-align: center"><?php if ($result_seCntcus6['cnt'] != '0') { ?><a href="#" onclick="select_customertenkoamatacnt('<?= $result_seCustomer['CUSTOMERCODE'] ?>', '0')" ><?= $result_seCntcus6['cnt'] ?></a><?php } else { ?><?php } ?></td>

                                                            </tr>
                                                            <?php
                                                            $sumemployee += ($result_seCntcus0['cnt'] + $result_seCntcuspresent['cnt'] + $result_seCntcus1['cnt'] + $result_seCntcus2['cnt'] + $result_seCntcus3['cnt'] + $result_seCntcus4['cnt'] + $result_seCntcus5['cnt'] + $result_seCntcus6['cnt']);
                                                            $sumcusO += $result_seCntcus0['cnt'];
                                                            $sumcusP += $result_seCntcuspresent['cnt'];
                                                            $sumcusL += $result_seCntcus1['cnt'];
                                                            $sumcus1 += $result_seCntcus2['cnt'];
                                                            $sumcus2 += $result_seCntcus3['cnt'];
                                                            $sumcus3 += $result_seCntcus4['cnt'];
                                                            $sumcusX += $result_seCntcus5['cnt'];
                                                            $sumcus0 += $result_seCntcus6['cnt'];
                                                        }
                                                        ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td style="text-align: center"><b>รวม</b></td>
                                                            <td style="text-align: center"><b><?= $sumemployee ?></b></td>
                                                            <td style="text-align: center"><?php if ($sumcusO != '0') { ?><a href="#"><?= $sumcusO ?></a><?php } else { ?><b><?= $sumcusO ?><?php } ?></b></td>
                                                            <td style="text-align: center"><?php if ($sumcusP != '0') { ?><a href="#"><?= $sumcusP ?></a><?php } else { ?><b><?= $sumcusP ?><?php } ?></b></td>
                                                            <td style="text-align: center"><?php if ($sumcusL != '0') { ?><a href="#"><?= $sumcusL ?></a><?php } else { ?><b><?= $sumcusL ?><?php } ?></b></td>
                                                            <td style="text-align: center"><?php if ($sumcus1 != '0') { ?><a href="#"><?= $sumcus1 ?></a><?php } else { ?><b><?= $sumcus1 ?><?php } ?></b></td>
                                                            <td style="text-align: center"><?php if ($sumcus2 != '0') { ?><a href="#"><?= $sumcus2 ?></a><?php } else { ?><b><?= $sumcus2 ?><?php } ?></b></td>
                                                            <td style="text-align: center"><?php if ($sumcus3 != '0') { ?><a href="#"><?= $sumcus3 ?></a><?php } else { ?><b><?= $sumcus3 ?><?php } ?></b></td>
                                                            <td style="text-align: center"><?php if ($sumcusX != '0') { ?><a href="#"><?= $sumcusX ?></a><?php } else { ?><b><?= $sumcusX ?><?php } ?></b></td>
                                                            <td style="text-align: center"><?php if ($sumcus0 != '0') { ?><a href="#"><?= $sumcus0 ?></a><?php } else { ?><b><?= $sumcus0 ?><?php } ?></b></td>

                                                        </tr>
                                                    </tfoot>
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


             <!-- this will show our spinner -->
            <!-- <div hidden id="spinner" class ="spinner"></div>-->

            <div  id="loading" class="center" >
                <p><img style="" src="../images/truckload5.gif" /></p>
            </div>

            <!-- </div> -->
          <!--<script src="../vendor/jquery/jquery.min.js"></script>-->
            <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
            <!-- <script src="../vendor/metisMenu/metisMenu.min.js"></script> -->
            <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
            <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
            <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
            <!-- <script src="../dist/js/sb-admin-2.js"></script> -->
            <script src="../js/jquery.datetimepicker.full.js"></script>

            <!-- <script src="../dist/js/jszip.min.js"></script> -->
            <!-- <script src="../dist/js/dataTables.buttons.min.js"></script> -->
            <!-- <script src="../dist/js/buttons.html5.min.js"></script> -->
            <!-- <script src="../dist/js/buttons.print.min.js"></script> -->
            <script src="../dist/js/bootstrap-select.js"></script>
            <script src="../dist/js/jquery.autocomplete.js"></script>
			<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>

            <script>

                function showLoading() {
                    $("#loading").show();
                    
                }

                function hideLoading() {
                    $("#loading").hide();
                }
                function update_vehicletransportplanjob(rootno, statusnumber)
                {

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

                            window.location.reload();
                        }
                    });
                }
                function update_vehicletransportplanjobhome(rootno, statusnumber)
                {

                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "edit_vehicletransportplanjobhome", rootno: rootno, statusnumber: statusnumber
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

                            window.location.reload();
                        }
                    });
                }
                    function getPlanid(planid) {
                        // alert(planid);
                        select_customerdetail(planid);
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
                    $(document).ready(function () {
                        $('#dataTables-example').DataTable({
                            responsive: true,
                            order: [[0, "desc"]]
                        });
                    });

                    $(document).ready(function () {
                        $('#dataTables-example2').DataTable({
                            order: [[0, "desc"]],
                            scrollX: true,
                            scrollY: '500px',
                        });
                    });
            </script>


    </body>
    <script>
        $(function () {
            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
            // กรณีใช้แบบ input
            $(".dateen").datetimepicker({
                timepicker: false,
                format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


            });
        });

        function gdatetodate()
        {
            document.getElementById('txt_gdateend').value = document.getElementById('txt_gdatestart').value;
        }
        function datetodate()
        {
            document.getElementById('txt_dateend').value = document.getElementById('txt_datestart').value;

        }
        function datetodate2()
        {
            document.getElementById('txt_dateend2').value = document.getElementById('txt_datestart2').value;

        }
        function select_customertenkoamatacnt(customercode, statusnumber)
        {
            var companycode = document.getElementById('cb_company').value;
            var datestart = document.getElementById('txt_datestart').value;
            var dateend = document.getElementById('txt_dateend').value;

            window.open('report_operation.php?companycode=' + companycode + '&customercode=' + customercode + '&datestart=' + datestart + '&dateend=' + dateend + '&statusnumber=' + statusnumber, '_blank');
        }
        function select_customertenkogateway()
        {
            //loadData();
            showLoading();

            var companycode = document.getElementById('cb_company').value;
            var datestart = document.getElementById('txt_datestart').value;
            var dateend = document.getElementById('txt_dateend').value;
            $.ajax({
                url: 'meg_data.php',
                type: 'POST',
                data: {
                    txt_flg: "select_customertenkogateway", companycode: companycode, datestart: datestart, dateend: dateend
                },
                success: function (rs) {
                    //alert('โหลดข้อมูลเรียบร้อย');
                    hideLoading();
					swal.fire({
                        title: "Good Job!",
                        text: "โหลดข้อมูลเรียบร้อย",
                        icon: "success",
                    });
                    document.getElementById("datadef").innerHTML = "";
                    document.getElementById("datasr").innerHTML = rs;

                    save_logprocess('Driver Management', 'Select Driver Management', '<?= $result_seLogin['PersonCode'] ?>');


                    $(document).ready(function () {
                        $('#dataTables-example').DataTable({
                            responsive: true,
                            order: [[0, "desc"]]
                        });
                    });
                }
            });
        }
        
        function delete_menu(val)
        {
            var confirmation = confirm("ต้องการลบข้อมูล ?");

            if (confirmation) {
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "delete_menu", menuid: val
                    },
                    success: function () {
                        alert('ลบข้อมูลเรียบร้อยแล้ว');
                        window.location.reload();
                    }
                });
            }
        }
        
        // const spinner = document.getElementById("spinner");
                
        // function loadData() {
        // spinner.removeAttribute('hidden');
        // fetch('https://www.mocky.io/v2/5185415ba171ea3a00704eed?mocky-delay=1200ms')
        //     .then(response => response.json())
        //     .then(data => {
        //     spinner.setAttribute('hidden', '');
        //     console.log(data)
        //     });
        // }
    </script>
    <script>
        function delete_submenu(val)
        {
            var confirmation = confirm("ต้องการลบข้อมูล ?");

            if (confirmation) {
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "delete_submenu", submenuid: val
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
