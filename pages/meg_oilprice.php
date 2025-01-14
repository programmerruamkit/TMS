<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");


$condiCompanyrkrs = " AND OILPEICEID = '" . $_GET['oilpriceid'] . "'";
$sql_seCompanyrkrs = "{call megOilprice_v2(?,?,?,?)}";
$params_seCompanyrkrs = array(
    array('select_oilprice', SQLSRV_PARAM_IN),
    array($condiCompanyrkrs, SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seCompanyrkrs = sqlsrv_query($conn, $sql_seCompanyrkrs, $params_seCompanyrkrs);
$result_seCompanyrkrs = sqlsrv_fetch_array($query_seCompanyrkrs, SQLSRV_FETCH_ASSOC);

if ($_GET['meg'] == "add") {
    $condComp = " AND Company_Code = '" . $_GET['companycode'] . "'";
    $company = $_GET['companycode'];
} else {
    $condComp = " AND Company_Code = '" . $result_seCompanyrkrs['COMPANYCODE'] . "'";
    $company = $result_seCompanyrkrs['COMPANYCODE'];
}
$sql_seComp = "{call megCompanyEHR_v2(?,?)}";
$params_seComp = array(
    array('select_company', SQLSRV_PARAM_IN),
    array($condComp, SQLSRV_PARAM_IN)
);
$query_seComp = sqlsrv_query($conn, $sql_seComp, $params_seComp);
$result_seComp = sqlsrv_fetch_array($query_seComp, SQLSRV_FETCH_ASSOC);


$buttonname = ($_GET['meg'] == 'edit') ? "แก้ไขข้อมูล" : "บันทึกข้อมูล";
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
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
        <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
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
    </head>
    <body>
        <div id="wrapper">
            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <?php
                include '../pages/meg_header.php';
                include '../pages/meg_leftmenu.php';
                ?>
            </nav>

            <div id="page-wrapper">
                <div class="row" >
                    <div class="col-lg-12">

                        <h2 class="page-header">
                            <i class="glyphicon glyphicon-oil"></i>  
                            ราคาน้ำมัน


                        </h2>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color: #e7e7e7">
                                <div class="row" >

                                    <div class="col-lg-6">
                                        <?php
                                        $meg = ($_GET['meg'] == 'add') ? 'เพิ่มข้อมูล' : 'แก้ไขข้อมูล';

                                        echo $_SESSION["link"] . " / " . $meg;
                                        ?>
                                    </div>
                                    <div class="col-lg-6 text-right">
                                        <?= $result_seComp['Company_NameT'] ?>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">

                                <div class="row" >

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <font style="color: red">* </font><label>ปี</label>
                                            <select class="form-control" id="cb_year" name="cb_year">
                                                <?php
                                                switch ($result_seCompanyrkrs['YEAR']) {
                                                    case '2019': {
                                                            ?>
                                                            <option value ="">เลือกปี</option>
                                                            <option value ="2019" selected="">2019</option>
                                                            <option value ="2020">2020</option>
                                                            <option value ="2021">2021</option>
                                                            <option value ="2022">2022</option>
                                                            <option value ="2023">2023</option>
                                                            <option value ="2024">2024</option>
                                                            <option value ="2025">2025</option>
                                                            <option value ="2026">2026</option>
                                                            <option value ="2027">2027</option>
                                                            <option value ="2028">2028</option>

                                                            <?php
                                                        }
                                                        break;
                                                    case '2020': {
                                                            ?>
                                                            <option value ="">เลือกปี</option>
                                                            <option value ="2019">2019</option>
                                                            <option value ="2020" selected="">2020</option>
                                                            <option value ="2021">2021</option>
                                                            <option value ="2022">2022</option>
                                                            <option value ="2023">2023</option>
                                                            <option value ="2024">2024</option>
                                                            <option value ="2025">2025</option>
                                                            <option value ="2026">2026</option>
                                                            <option value ="2027">2027</option>
                                                            <option value ="2028">2028</option>
                                                            <?php
                                                        }
                                                        break;
                                                    case '2021': {
                                                            ?>
                                                            <option value ="">เลือกปี</option>
                                                            <option value ="2019">2019</option>
                                                            <option value ="2020">2020</option>
                                                            <option value ="2021" selected="">2021</option>
                                                            <option value ="2022">2022</option>
                                                            <option value ="2023">2023</option>
                                                            <option value ="2024">2024</option>
                                                            <option value ="2025">2025</option>
                                                            <option value ="2026">2026</option>
                                                            <option value ="2027">2027</option>
                                                            <option value ="2028">2028</option>
                                                            <?php
                                                        }
                                                        break;
                                                    case '2022': {
                                                            ?>
                                                            <option value ="">เลือกปี</option>
                                                            <option value ="2019">2019</option>
                                                            <option value ="2020">2020</option>
                                                            <option value ="2021">2021</option>
                                                            <option value ="2022" selected="">2022</option>
                                                            <option value ="2023">2023</option>
                                                            <option value ="2024">2024</option>
                                                            <option value ="2025">2025</option>
                                                            <option value ="2026">2026</option>
                                                            <option value ="2027">2027</option>
                                                            <option value ="2028">2028</option>
                                                            <?php
                                                        }
                                                        break;
                                                    case '2023': {
                                                            ?>
                                                            <option value ="">เลือกปี</option>
                                                            <option value ="2019">2019</option>
                                                            <option value ="2020">2020</option>
                                                            <option value ="2021">2021</option>
                                                            <option value ="2022">2022</option>
                                                            <option value ="2023" selected="">2023</option>
                                                            <option value ="2024">2024</option>
                                                            <option value ="2025">2025</option>
                                                            <option value ="2026">2026</option>
                                                            <option value ="2027">2027</option>
                                                            <option value ="2028">2028</option>
                                                            <?php
                                                        }
                                                        break;
                                                    case '2024': {
                                                            ?>
                                                            <option value ="">เลือกปี</option>
                                                            <option value ="2019">2019</option>
                                                            <option value ="2020">2020</option>
                                                            <option value ="2021">2021</option>
                                                            <option value ="2022">2022</option>
                                                            <option value ="2023">2023</option>
                                                            <option value ="2024" selected="">2024</option>
                                                            <option value ="2025">2025</option>
                                                            <option value ="2026">2026</option>
                                                            <option value ="2027">2027</option>
                                                            <option value ="2028">2028</option>
                                                            <?php
                                                        }
                                                        break;
                                                    case '2025': {
                                                            ?>
                                                            <option value ="">เลือกปี</option>
                                                            <option value ="2019">2019</option>
                                                            <option value ="2020">2020</option>
                                                            <option value ="2021">2021</option>
                                                            <option value ="2022">2022</option>
                                                            <option value ="2023">2023</option>
                                                            <option value ="2024">2024</option>
                                                            <option value ="2025" selected="">2025</option>
                                                            <option value ="2026">2026</option>
                                                            <option value ="2027">2027</option>
                                                            <option value ="2028">2028</option>
                                                            <?php
                                                        }
                                                        break;
                                                    case '2026': {
                                                            ?>
                                                            <option value ="">เลือกปี</option>
                                                            <option value ="2019">2019</option>
                                                            <option value ="2020">2020</option>
                                                            <option value ="2021">2021</option>
                                                            <option value ="2022">2022</option>
                                                            <option value ="2023">2023</option>
                                                            <option value ="2024">2024</option>
                                                            <option value ="2025">2025</option>
                                                            <option value ="2026" selected="">2026</option>
                                                            <option value ="2027">2027</option>
                                                            <option value ="2028">2028</option>
                                                            <?php
                                                        }
                                                        break;
                                                    case '2027': {
                                                            ?>
                                                            <option value ="">เลือกปี</option>
                                                            <option value ="2019">2019</option>
                                                            <option value ="2020">2020</option>
                                                            <option value ="2021">2021</option>
                                                            <option value ="2022">2022</option>
                                                            <option value ="2023">2023</option>
                                                            <option value ="2024">2024</option>
                                                            <option value ="2025">2025</option>
                                                            <option value ="2026">2026</option>
                                                            <option value ="2027" selected="">2027</option>
                                                            <option value ="2028">2028</option>
                                                            <?php
                                                        }
                                                        break;
                                                    case '2028': {
                                                            ?>
                                                            <option value ="">เลือกปี</option>
                                                            <option value ="2019">2019</option>
                                                            <option value ="2020">2020</option>
                                                            <option value ="2021">2021</option>
                                                            <option value ="2022">2022</option>
                                                            <option value ="2023">2023</option>
                                                            <option value ="2024">2024</option>
                                                            <option value ="2025">2025</option>
                                                            <option value ="2026">2026</option>
                                                            <option value ="2027">2027</option>
                                                            <option value ="2028" selected="">2028</option>
                                                            <?php
                                                        }
                                                        break;
                                                    default : {
                                                            ?>
                                                            <option value ="">เลือกปี</option>
                                                            <option value ="2019">2019</option>
                                                            <option value ="2020">2020</option>
                                                            <option value ="2021">2021</option>
                                                            <option value ="2022">2022</option>
                                                            <option value ="2023">2023</option>
                                                            <option value ="2024">2024</option>
                                                            <option value ="2025">2025</option>
                                                            <option value ="2026">2026</option>
                                                            <option value ="2027">2027</option>
                                                            <option value ="2028">2028</option>

                                                            <?php
                                                        }
                                                        break;
                                                }
                                                ?>

                                            </select>

                                        </div>
                                    </div>

                                    <div class = "col-lg-3">
                                        <div class = "form-group">
                                            <font style="color: red">* </font><label>เดือน</label>
                                            <select class="form-control" id="cb_month" name="cb_month">
                                                <?php
                                                switch ($result_seCompanyrkrs['MONTH']) {
                                                    case 'มกราคม': {
                                                            ?>
                                                            <option value ="">เลือกเดือน</option>
                                                            <option value ="มกราคม" selected="">มกราคม</option>
                                                            <option value ="กุมภาพันธ์">กุมภาพันธ์ </option>
                                                            <option value ="มีนาคม">มีนาคม </option>
                                                            <option value ="เมษายน">เมษายน</option>
                                                            <option value ="พฤษภาคม">พฤษภาคม </option>
                                                            <option value ="มิถุนายน">มิถุนายน </option>
                                                            <option value ="กรกฎาคม">กรกฎาคม </option>
                                                            <option value ="สิงหาคม">สิงหาคม </option>
                                                            <option value ="กันยายน">กันยายน </option>
                                                            <option value ="ตุลาคม">ตุลาคม </option>
                                                            <option value ="พฤศจิกายน">พฤศจิกายน </option>
                                                            <option value ="ธันวาคม">ธันวาคม </option>

                                                            <?php
                                                        }
                                                        break;
                                                    case 'กุมภาพันธ์': {
                                                            ?>
                                                            <option value ="">เลือกเดือน</option>
                                                            <option value ="มกราคม">มกราคม</option>
                                                            <option value ="กุมภาพันธ์" selected="">กุมภาพันธ์ </option>
                                                            <option value ="มีนาคม">มีนาคม </option>
                                                            <option value ="เมษายน">เมษายน</option>
                                                            <option value ="พฤษภาคม">พฤษภาคม </option>
                                                            <option value ="มิถุนายน">มิถุนายน </option>
                                                            <option value ="กรกฎาคม">กรกฎาคม </option>
                                                            <option value ="สิงหาคม">สิงหาคม </option>
                                                            <option value ="กันยายน">กันยายน </option>
                                                            <option value ="ตุลาคม">ตุลาคม </option>
                                                            <option value ="พฤศจิกายน">พฤศจิกายน </option>
                                                            <option value ="ธันวาคม">ธันวาคม </option>
                                                            <?php
                                                        }
                                                        break;
                                                    case 'มีนาคม': {
                                                            ?>
                                                            <option value ="">เลือกเดือน</option>
                                                            <option value ="มกราคม">มกราคม</option>
                                                            <option value ="กุมภาพันธ์">กุมภาพันธ์ </option>
                                                            <option value ="มีนาคม" selected="">มีนาคม </option>
                                                            <option value ="เมษายน">เมษายน</option>
                                                            <option value ="พฤษภาคม">พฤษภาคม </option>
                                                            <option value ="มิถุนายน">มิถุนายน </option>
                                                            <option value ="กรกฎาคม">กรกฎาคม </option>
                                                            <option value ="สิงหาคม">สิงหาคม </option>
                                                            <option value ="กันยายน">กันยายน </option>
                                                            <option value ="ตุลาคม">ตุลาคม </option>
                                                            <option value ="พฤศจิกายน">พฤศจิกายน </option>
                                                            <option value ="ธันวาคม">ธันวาคม </option>
                                                            <?php
                                                        }
                                                        break;
                                                    case 'เมษายน': {
                                                            ?>
                                                            <option value ="">เลือกเดือน</option>
                                                            <option value ="มกราคม">มกราคม</option>
                                                            <option value ="กุมภาพันธ์">กุมภาพันธ์ </option>
                                                            <option value ="มีนาคม">มีนาคม </option>
                                                            <option value ="เมษายน" selected="">เมษายน</option>
                                                            <option value ="พฤษภาคม">พฤษภาคม </option>
                                                            <option value ="มิถุนายน">มิถุนายน </option>
                                                            <option value ="กรกฎาคม">กรกฎาคม </option>
                                                            <option value ="สิงหาคม">สิงหาคม </option>
                                                            <option value ="กันยายน">กันยายน </option>
                                                            <option value ="ตุลาคม">ตุลาคม </option>
                                                            <option value ="พฤศจิกายน">พฤศจิกายน </option>
                                                            <option value ="ธันวาคม">ธันวาคม </option>
                                                            <?php
                                                        }
                                                        break;
                                                    case 'พฤษภาคม': {
                                                            ?>
                                                            <option value ="">เลือกเดือน</option>
                                                            <option value ="มกราคม">มกราคม</option>
                                                            <option value ="กุมภาพันธ์">กุมภาพันธ์ </option>
                                                            <option value ="มีนาคม">มีนาคม </option>
                                                            <option value ="เมษายน">เมษายน</option>
                                                            <option value ="พฤษภาคม" selected="">พฤษภาคม </option>
                                                            <option value ="มิถุนายน">มิถุนายน </option>
                                                            <option value ="กรกฎาคม">กรกฎาคม </option>
                                                            <option value ="สิงหาคม">สิงหาคม </option>
                                                            <option value ="กันยายน">กันยายน </option>
                                                            <option value ="ตุลาคม">ตุลาคม </option>
                                                            <option value ="พฤศจิกายน">พฤศจิกายน </option>
                                                            <option value ="ธันวาคม">ธันวาคม </option>
                                                            <?php
                                                        }
                                                        break;
                                                    case 'มิถุนายน': {
                                                            ?>
                                                            <option value ="">เลือกเดือน</option>
                                                            <option value ="มกราคม">มกราคม</option>
                                                            <option value ="กุมภาพันธ์">กุมภาพันธ์ </option>
                                                            <option value ="มีนาคม">มีนาคม </option>
                                                            <option value ="เมษายน">เมษายน</option>
                                                            <option value ="พฤษภาคม">พฤษภาคม </option>
                                                            <option value ="มิถุนายน" selected="">มิถุนายน </option>
                                                            <option value ="กรกฎาคม">กรกฎาคม </option>
                                                            <option value ="สิงหาคม">สิงหาคม </option>
                                                            <option value ="กันยายน">กันยายน </option>
                                                            <option value ="ตุลาคม">ตุลาคม </option>
                                                            <option value ="พฤศจิกายน">พฤศจิกายน </option>
                                                            <option value ="ธันวาคม">ธันวาคม </option>
                                                            <?php
                                                        }
                                                        break;
                                                    case 'กรกฎาคม': {
                                                            ?>
                                                            <option value ="">เลือกเดือน</option>
                                                            <option value ="มกราคม">มกราคม</option>
                                                            <option value ="กุมภาพันธ์">กุมภาพันธ์ </option>
                                                            <option value ="มีนาคม">มีนาคม </option>
                                                            <option value ="เมษายน">เมษายน</option>
                                                            <option value ="พฤษภาคม">พฤษภาคม </option>
                                                            <option value ="มิถุนายน">มิถุนายน </option>
                                                            <option value ="กรกฎาคม" selected="">กรกฎาคม </option>
                                                            <option value ="สิงหาคม">สิงหาคม </option>
                                                            <option value ="กันยายน">กันยายน </option>
                                                            <option value ="ตุลาคม">ตุลาคม </option>
                                                            <option value ="พฤศจิกายน">พฤศจิกายน </option>
                                                            <option value ="ธันวาคม">ธันวาคม </option>
                                                            <?php
                                                        }
                                                        break;
                                                    case 'สิงหาคม': {
                                                            ?>
                                                            <option value ="">เลือกเดือน</option>
                                                            <option value ="มกราคม">มกราคม</option>
                                                            <option value ="กุมภาพันธ์">กุมภาพันธ์ </option>
                                                            <option value ="มีนาคม">มีนาคม </option>
                                                            <option value ="เมษายน">เมษายน</option>
                                                            <option value ="พฤษภาคม">พฤษภาคม </option>
                                                            <option value ="มิถุนายน">มิถุนายน </option>
                                                            <option value ="กรกฎาคม">กรกฎาคม </option>
                                                            <option value ="สิงหาคม" selected="">สิงหาคม </option>
                                                            <option value ="กันยายน">กันยายน </option>
                                                            <option value ="ตุลาคม">ตุลาคม </option>
                                                            <option value ="พฤศจิกายน">พฤศจิกายน </option>
                                                            <option value ="ธันวาคม">ธันวาคม </option>
                                                            <?php
                                                        }
                                                        break;
                                                    case 'กันยายน': {
                                                            ?>
                                                            <option value ="">เลือกเดือน</option>
                                                            <option value ="มกราคม">มกราคม</option>
                                                            <option value ="กุมภาพันธ์">กุมภาพันธ์ </option>
                                                            <option value ="มีนาคม">มีนาคม </option>
                                                            <option value ="เมษายน">เมษายน</option>
                                                            <option value ="พฤษภาคม">พฤษภาคม </option>
                                                            <option value ="มิถุนายน">มิถุนายน </option>
                                                            <option value ="กรกฎาคม">กรกฎาคม </option>
                                                            <option value ="สิงหาคม">สิงหาคม </option>
                                                            <option value ="กันยายน" selected="">กันยายน </option>
                                                            <option value ="ตุลาคม">ตุลาคม </option>
                                                            <option value ="พฤศจิกายน">พฤศจิกายน </option>
                                                            <option value ="ธันวาคม">ธันวาคม </option>
                                                            <?php
                                                        }
                                                        break;
                                                    case 'ตุลาคม': {
                                                            ?>
                                                            <option value ="">เลือกเดือน</option>
                                                            <option value ="มกราคม">มกราคม</option>
                                                            <option value ="กุมภาพันธ์">กุมภาพันธ์ </option>
                                                            <option value ="มีนาคม">มีนาคม </option>
                                                            <option value ="เมษายน">เมษายน</option>
                                                            <option value ="พฤษภาคม">พฤษภาคม </option>
                                                            <option value ="มิถุนายน">มิถุนายน </option>
                                                            <option value ="กรกฎาคม">กรกฎาคม </option>
                                                            <option value ="สิงหาคม">สิงหาคม </option>
                                                            <option value ="กันยายน">กันยายน </option>
                                                            <option value ="ตุลาคม" selected="">ตุลาคม </option>
                                                            <option value ="พฤศจิกายน">พฤศจิกายน </option>
                                                            <option value ="ธันวาคม">ธันวาคม </option>
                                                            <?php
                                                        }
                                                        break;
                                                    case 'พฤศจิกายน': {
                                                            ?>
                                                            <option value ="">เลือกเดือน</option>
                                                            <option value ="มกราคม">มกราคม</option>
                                                            <option value ="กุมภาพันธ์">กุมภาพันธ์ </option>
                                                            <option value ="มีนาคม">มีนาคม </option>
                                                            <option value ="เมษายน">เมษายน</option>
                                                            <option value ="พฤษภาคม">พฤษภาคม </option>
                                                            <option value ="มิถุนายน">มิถุนายน </option>
                                                            <option value ="กรกฎาคม">กรกฎาคม </option>
                                                            <option value ="สิงหาคม">สิงหาคม </option>
                                                            <option value ="กันยายน">กันยายน </option>
                                                            <option value ="ตุลาคม">ตุลาคม </option>
                                                            <option value ="พฤศจิกายน" selected="">พฤศจิกายน </option>
                                                            <option value ="ธันวาคม">ธันวาคม </option>
                                                            <?php
                                                        }
                                                        break;
                                                    case 'ธันวาคม': {
                                                            ?>
                                                            <option value ="">เลือกเดือน</option>
                                                            <option value ="มกราคม">มกราคม</option>
                                                            <option value ="กุมภาพันธ์">กุมภาพันธ์ </option>
                                                            <option value ="มีนาคม">มีนาคม </option>
                                                            <option value ="เมษายน">เมษายน</option>
                                                            <option value ="พฤษภาคม">พฤษภาคม </option>
                                                            <option value ="มิถุนายน">มิถุนายน </option>
                                                            <option value ="กรกฎาคม">กรกฎาคม </option>
                                                            <option value ="สิงหาคม">สิงหาคม </option>
                                                            <option value ="กันยายน">กันยายน </option>
                                                            <option value ="ตุลาคม">ตุลาคม </option>
                                                            <option value ="พฤศจิกายน">พฤศจิกายน </option>
                                                            <option value ="ธันวาคม" selected="">ธันวาคม </option>
                                                            <?php
                                                        }
                                                        break;
                                                    default : {
                                                            ?>
                                                            <option value ="">เลือกเดือน</option>
                                                            <option value ="มกราคม">มกราคม</option>
                                                            <option value ="กุมภาพันธ์">กุมภาพันธ์ </option>
                                                            <option value ="มีนาคม">มีนาคม </option>
                                                            <option value ="เมษายน">เมษายน</option>
                                                            <option value ="พฤษภาคม">พฤษภาคม </option>
                                                            <option value ="มิถุนายน">มิถุนายน </option>
                                                            <option value ="กรกฎาคม">กรกฎาคม </option>
                                                            <option value ="สิงหาคม">สิงหาคม </option>
                                                            <option value ="กันยายน">กันยายน </option>
                                                            <option value ="ตุลาคม">ตุลาคม </option>
                                                            <option value ="พฤศจิกายน">พฤศจิกายน </option>
                                                            <option value ="ธันวาคม">ธันวาคม </option>

                                                            <?php
                                                        }
                                                        break;
                                                }
                                                ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <font style="color: red">* </font><label>ราคา/ลิตร (บาท)</label>
                                            <input class="form-control" type="text"   id="txt_price" name="txt_price" value="<?= $result_seCompanyrkrs['PRICE'] ?>">

                                        </div>
                                    </div>

                                </div>
                                <div class="row" >
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>หมายเหตุ</label>
                                            <textarea class="form-control" autocomplete="off" rows="3" id="txt_remark" name="txt_remark" ><?= $result_seCompanyrkrs['REMARK'] ?></textarea>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">

                                        <input type="button"  name="btnSend" id="btnSend" onclick="save_oilprice('<?= $result_seCompanyrkrs['OILPEICEID'] ?>')" value="<?= $buttonname ?>" class="btn btn-primary">




                                    </div>
                                    <div class="col-lg-12">&nbsp;</div>
                                </div>



                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">

                                <div class="row">
                                    <div class="col-lg-12">
                                        รายการข้อมูลราคาน้ำมัน
                                    </div>



                                </div>
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">



                                <div class="row">

                                    <div class="col-md-12">
                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>บริษัท</th>
                                                    <th>ปี</th>
                                                    <th>เดือน</th>
                                                    <th>ราคา/ลิตร(บาท)</th>
                                                    <th>หมายเหตุ</th>
                                                    <th style="text-align: center">สถานะ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                echo $_SESSION['USERNAME'];
                                                if ($_GET['meg'] == 'add') {
                                                    $condiCompanyrkr = " AND COMPANYCODE = '" . $_GET['companycode'] . "'";
                                                } else {
                                                    $condiCompanyrkr = " AND OILPEICEID = '" . $_GET['oilpriceid'] . "'";
                                                }
                                                $sql_seCompanyrkr = "{call megOilprice_v2(?,?,?,?)}";
                                                $params_seCompanyrkr = array(
                                                    array('select_oilprice', SQLSRV_PARAM_IN),
                                                    array($condiCompanyrkr, SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seCompanyrkr = sqlsrv_query($conn, $sql_seCompanyrkr, $params_seCompanyrkr);
                                                while ($result_seCompanyrkr = sqlsrv_fetch_array($query_seCompanyrkr, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <tr class="odd gradeX">
                                                        <td><?= $result_seCompanyrkr['COMPANYCODE'] ?></td>
                                                        <td><?= $result_seCompanyrkr['YEAR'] ?></td>
                                                        <td><?= $result_seCompanyrkr['MONTH'] ?></td>
                                                        <td><?= $result_seCompanyrkr['PRICE'] ?></td>
                                                        <td><?= $result_seCompanyrkr['REMARK'] ?></td>
                                                        <td style="text-align: center"><?php echo ($result_seCompanyrkr['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>

                                                    </tr>
                                                    <?php
                                                }
                                                ?>



                                            </tbody>


                                        </table>
                                    </div>

                                    <!-- /.panel-body -->
                                </div>


                                                
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>

            </div>
        </div>

        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="../vendor/metisMenu/metisMenu.min.js"></script>
        <script src="../vendor/raphael/raphael.min.js"></script>
        <script src="../dist/js/sb-admin-2.js"></script>
        <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
        <script src="../js/jquery.datetimepicker.full.js"></script>
        <script src="../dist/js/jszip.min.js"></script>
        <script src="../dist/js/dataTables.buttons.min.js"></script>
        <script src="../dist/js/buttons.html5.min.js"></script>
        <script src="../dist/js/buttons.print.min.js"></script>
        <script src="../dist/js/jquery.autocomplete.js"></script>


        <script src="../dist/js/bootstrap-select.js"></script>
        <script type="text/javascript">
                                            $('.selectpicker').on('changed.bs.select', function () {
                                                document.getElementById('txt_comp').value = $(this).val();

                                            });

                                            $(function () {
                                                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                // กรณีใช้แบบ input
                                                $(".dateen").datetimepicker({
                                                    timepicker: false,
                                                    format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000			
                                                    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


                                                });
                                            });

                                            $(document).ready(function () {
                                                $('#dataTables-example1').DataTable({
                                                    responsive: true
                                                });
                                            });
                                            function chknull_oilprice()
                                            {
                                                if (document.getElementById('cb_year').value == '')
                                                {
                                                    alert('ปี เป็นค่าว่าง !!!')
                                                    document.getElementById('cb_year').focus();
                                                    return false;
                                                } else if (document.getElementById('cb_month').value == '')
                                                {
                                                    alert('เดือน เป็นค่าว่าง !!!')
                                                    document.getElementById('cb_month').focus();
                                                    return false;
                                                } else if (document.getElementById('txt_price').value == '')
                                                {
                                                    alert('ราคา เป็นค่าว่าง !!!')
                                                    document.getElementById('txt_price').focus();
                                                    return false;
                                                } else
                                                {
                                                    return true;
                                                }
                                            }
                                            function save_oilprice(oilpriceid)
                                            {


                                                var year = document.getElementById('cb_year').value;
                                                var month = document.getElementById('cb_month').value;
                                                var price = document.getElementById('txt_price').value;
                                                var remark = document.getElementById('txt_remark').value;
                                                var createby = '<?=$_SESSION['USERNAME']?>';

                                                if (chknull_oilprice())
                                                {
                                                    $.ajax({
                                                        type: 'post',
                                                        url: 'meg_data.php',
                                                        data: {
                                                            txt_flg: "save_oilprice", 
                                                            oilpriceid: oilpriceid,
                                                            condition2:'',
                                                            condition3:'', 
                                                            company: '<?= $company ?>', 
                                                            year: year,
                                                            month: month, 
                                                            price: price, 
                                                            remark: remark,
                                                            createby: createby

                                                        },
                                                        success: function (response) {
                                                            alert(response);
                                                            window.location.reload();
                                                        }
                                                    });
                                                }
                                            }
        </script>


    </body>


</html>


<?php
sqlsrv_close($conn);
?>