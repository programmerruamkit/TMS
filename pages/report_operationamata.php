<!DOCTYPE html>
<?php
session_start();
ini_set('max_execution_time', 300);
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

$condition1 = "  AND a.PersonID = '" . $_SESSION["EMPLOYEEID"] . "'";
$sql_seEmployee = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmployee = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
$result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC);

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

$condition1 = ($_SESSION["EMPLOYEEID"] != "") ? " AND a.EMPLOYEEID = '" . $_SESSION["EMPLOYEEID"] . "'" : "";
//$condition1 = ($_SESSION["EMPLOYEEID"] != "") ? " AND a.EMPLOYEEID = 238" : "";
$sql_sePremissions = "{call megRoleaccount_v2(?,?)}";
$params_sePremissions = array(
    array('select_permissions', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_sePremissions = sqlsrv_query($conn, $sql_sePremissions, $params_sePremissions);
$result_sePremissions = sqlsrv_fetch_array($query_sePremissions, SQLSRV_FETCH_ASSOC);
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
        <!-- <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet"> -->
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="style/style.css" rel="stylesheet" type="text/css">



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
        <div class="modal fade" id="modal_selecttenko" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-modal-parent="#modal_copydiagram">
            <div class="modal-dialog" style="width: 80%">
                <!-- Modal content-->
                <div class="modal-content">

                    <div id="select_selecttenko"></div>
                </div>
            </div>
        </div>



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
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;">

            <div class="navbar-header" >
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../pages/index.php"><font style="color: #000;font-size: 14px"><img src="../images/logo.ico" height="30"> <strong>Transport Management System</strong></font></a>
            </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <font style="color:#337ab7 "><?= $result_seEmployee['nameT'] ?></font>
                </li>
                <li class="dropdown">
                    <?php
                    if ($_SESSION["ROLENAME"] != "") {
                        ?>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <?= $_SESSION["ROLENAME"] ?>
                        </a>
                        <?php
                    } else {
                        ?>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            เลือกสิทธิ์เข้าใช้งาน <i class="fa fa-caret-down"></i>
                        </a>
                        <?php
                    }
                    ?>
                    <ul class="dropdown-menu dropdown-user">
                        <?php
                        $query_sePremissions3 = sqlsrv_query($conn, $sql_sePremissions, $params_sePremissions);
                        while ($result_sePremissions3 = sqlsrv_fetch_array($query_sePremissions3, SQLSRV_FETCH_ASSOC)) {
                            ?>
                            <li><a href="" onclick="create_premissions('<?= $result_sePremissions3['ROLEID'] ?>');"><i class="fa fa-user fa-fw"></i> <?= $result_sePremissions3['ROLENAME'] ?></a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </li>
                <!-- <li>
                        <font style="color:#337ab7 "><?= $result_sePremissions["NAME"] ?></font>
                    </li> -->
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
                                <select class="form-control"  id="cb_company" name="cb_company" >
                                    <option value = "">บริษัททั้งหมด</option>
                                    <option value = "RKR">ร่วมกิจรุ่งเรือง (1993)</option>
                                    <option value = "RKL">ร่วมกิจรุ่งเรือง โลจิสติคส์</option>
                                    <option value = "RKS">ร่วมกิจรุ่งเรือง เซอร์วิส</option>
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
                                    <button class="btn btn-default"  onclick="select_operationamata();">ค้นหา <li class="fa fa-search"></li></button>
                                </div>

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
                                                <li><a href="#tenko2" onclick="select_tenkotransport()" data-toggle="tab">เท็งโกะระหว่างทาง</a>
                                                </li>
                                                <li><a href="#tenko3" onclick="select_tenkoafter()" data-toggle="tab">เท็งโกะเลิกงาน</a>
                                                </li>
                                                <li><a href="#tenko4" onclick="select_tenkoclosejob()" data-toggle="tab">ปิดงาน</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="row">
                                                    <div class="col-md-12" >&nbsp;</div>
                                                </div>
                                                <div class="tab-pane fade active in" id="tenko1">
                                                    <div class="row">

                                                        
                                                        <div class="col-lg-2">&nbsp;</div>
                                                        <div class="col-lg-2" style="text-align: right">
                                                            <input class="btn btn-default" type="button" style="background-color: red;border:solid 2px white" id="btn_srquotation" name="btn_srquotation" value=""><font style="color:red"> * ไม่พบไอดีราคาขนส่ง(ไอดีราคา) </font> 
                                                        </div>
                                                        <div class="col-lg-2" style="text-align: right">
                                                            <input class="btn btn-default" type="button" style="background-color: #FFAF03;border:solid 2px white" id="btn_srquotation" name="btn_srquotation" value=""><font style="color:#FFAF03"> * ไม่พบราคาขนส่ง(จำนวนราคา) </font> 
                                                        </div>
                                                        <div class="col-lg-2" style="text-align: right">
                                                            <input class="btn btn-default" type="button" style="background-color: black;border:solid 2px white" id="btn_srquotation" name="btn_srquotation" value=""><font style="color:black"> * ยังไม่ได้ตรวจ </font>
                                                        </div>
                                                        <div class="col-lg-2" style="text-align: right">
                                                            <input class="btn btn-default" type="button" style="background-color: green;border:solid 2px white" id="btn_srquotation" name="btn_srquotation" value=""><font style="color:green"> * ตรวจเรียบร้อย </font> 
                                                        </div>


                                                    </div>
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
                                                                            <th style="text-align: center;width:5%">ทำงาน</th>

                                                                            
                                                                            <th style="text-align: center;width:5%">เข้าวีแอล</th>
                                                                            <th style="text-align: center;width:5%">ออกวีแอล</th>

                                                                            <th style="text-align: center;width:5%">เข้าดีลเลอร์</th>
                                                                            <th style="text-align: center;width:5%">กลับบริษัท</th>





                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                        <?php
                                                                        $sql_seOps = "{call megVehicletransportplan_v2(?,?,?,?)}";

                                                                        $condOps1 = " AND a.COMPANYCODE IN ('RKR','RKL','RKS')";
                                                                        $condOps2 = " AND (a.STATUSNUMBER = 'O' OR a.STATUSNUMBER = 'L' OR a.STATUSNUMBER = 'P')";
                                                                        $condOps3 = " AND((CONVERT(DATE,a.DATEVLIN) = CONVERT(DATE,GETDATE(),103)) OR (CONVERT(DATE,a.DATEPRESENT) = CONVERT(DATE,GETDATE(),103)))";
                                                                        $params_seOps = array(
                                                                            array('select_tenkodatafortenkodocumentamata', SQLSRV_PARAM_IN),
                                                                            array($condOps1, SQLSRV_PARAM_IN),
                                                                            array($condOps2, SQLSRV_PARAM_IN),
                                                                            array($condOps3, SQLSRV_PARAM_IN)
                                                                        );



                                                                        $i = 1;
                                                                        $query_seOps = sqlsrv_query($conn, $sql_seOps, $params_seOps);
                                                                        while ($result_seOps = sqlsrv_fetch_array($query_seOps, SQLSRV_FETCH_ASSOC)) {

                                                                            // $employeecode = ($result_seOps['EMPLOYEECODE1'] != "") ? " AND a.TENKOMASTERDIRVERCODE1 = '" . $result_seOps['EMPLOYEECODE1'] . "'" : "";
                                                                            // $condiTenkomaster = " AND a.VEHICLETRANSPORTPLANID != '' AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE())" . $employeecode;
                                                                            // $sql_seTenkomaster = "{call megEdittenkomaster_v2(?,?)}";
                                                                            // $params_seTenkomaster = array(
                                                                            //     array('select_tenkomaster', SQLSRV_PARAM_IN),
                                                                            //     array($condiTenkomaster, SQLSRV_PARAM_IN)
                                                                            // );
                                                                            // $query_seTenkmaster = sqlsrv_query($conn, $sql_seTenkomaster, $params_seTenkomaster);
                                                                            // $result_seTenkmaster = sqlsrv_fetch_array($query_seTenkmaster, SQLSRV_FETCH_ASSOC);

                                                                            // $sql_seCheckplan = "SELECT TOP 1 c.TENKOBEFOREGREETCHECK FROM VEHICLETRANSPORTPLAN a 
                                                                            // INNER JOIN [dbo].[TENKOBEFORE] c ON a.TENKOMASTERID = c.TENKOMASTERID
                                                                            // WHERE a.VEHICLETRANSPORTPLANID = '" . $result_seOps['VEHICLETRANSPORTPLANID'] . "'";
                                                                            // $params_seCheckplan = array();
                                                                            // $query_seCheckplan = sqlsrv_query($conn, $sql_seCheckplan, $params_seCheckplan);
                                                                            // $result_seCheckplan = sqlsrv_fetch_array($query_seCheckplan, SQLSRV_FETCH_ASSOC);
                                                                            ?>


                                                                            <tr 
                                                                                <?php
                                                                                if ($result_seOps['VEHICLETRANSPORTPRICEID'] == '' || $result_seOps['VEHICLETRANSPORTPRICEID'] == 'NULL') {
                                                                                ?>
                                                                                    style="color: red"
                                                                                    <?php
                                                                                } else if ($result_seOps['ACTUALPRICE'] == '' || $result_seOps['ACTUALPRICE'] == '0.00') {
                                                                                    ?>
                                                                                    style="color: #FFAF03"
                                                                                    <?php
                                                                                } else if ($result_seOps['STATUSNUMBER'] != 'P') {
                                                                                    ?>
                                                                                    style="color: black"
                                                                                    <?php
                                                                                } else {
                                                                                    ?>
                                                                                    style="color: green"
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                                >

                                                                                <td style="text-align: center">
                                                                                    <div class="btn-group">
                                                                                        <button type="button"  class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                                                                            <i class="fa fa-chevron-down"></i>
                                                                                        </button>
                                                                                        <ul class="dropdown-menu slidedown" style="width: 300px">
                                                                                            <?php
                                                                                            if ($result_seOps['ACTUALPRICE'] != "") {
                                                                                                //if (($result_seOps['COMPANYCODE'] == 'RKR' && $result_seOps['CUSTOMERCODE'] == 'TTASTSTC' && $result_seTenkmaster['TENKOMASTERID'] != '') ||
                                                                                                //        ($result_seOps['COMPANYCODE'] == 'RKR' && $result_seOps['CUSTOMERCODE'] == 'TTASTCS' && $result_seTenkmaster['TENKOMASTERID'] != '') ||
                                                                                                //        ($result_seOps['COMPANYCODE'] == 'RKL' && $result_seOps['CUSTOMERCODE'] == 'TTASTSTC' && $result_seTenkmaster['TENKOMASTERID'] != '') ||
                                                                                                //        ($result_seOps['COMPANYCODE'] == 'RKL' && $result_seOps['CUSTOMERCODE'] == 'TTASTCS' && $result_seTenkmaster['TENKOMASTERID'] != '') ||
                                                                                                //       ($result_seOps['COMPANYCODE'] == 'RKS' && $result_seOps['CUSTOMERCODE'] == 'TMT' && $result_seTenkmaster['TENKOMASTERID'] != '')
                                                                                                //) {
                                                                                                ?>
                                                                                                <!--   <li>
                                                                                                        <a tabindex="-1" href='#' onclick="modal_selecttenko('<?//= $result_seOps['EMPLOYEECODE1'] ?>', '<?//= $result_seOps['VEHICLETRANSPORTPLANID'] ?>', '1')"  data-toggle="modal"  data-target="#modal_selecttenko"><?//= $result_seOps['EMPLOYEENAME1'] ?></a>
                                                                                                   </li>
                                                                                                   <li class="divider"></li>
                                                                                                   <li>
                                                                                                       <a tabindex="-1" href='#' onclick="modal_selecttenko('<?//= $result_seOps['EMPLOYEECODE2'] ?>', '<?//= $result_seOps['VEHICLETRANSPORTPLANID'] ?>', '2')"  data-toggle="modal"  data-target="#modal_selecttenko"><?//= $result_seOps['EMPLOYEENAME2'] ?></a>
                                                                                                   </li>

                                                                                                -->
                                                                                                <?php
                                                                                                //} else {
                                                                                                ?>
                                                                                                
                                                                                                <!-- CHK TENKODRIVER1 -->
                                                                                                <?php
                                                                                                if ($result_seOps['EMPLOYEENAME1'] != '') {
                                                                                                ?>   
                                                                                                <li>
                                                                                                    <a tabindex="-1" href='#' onclick="save_tenkomaster('<?= $result_seOps['VEHICLETRANSPORTPLANID'] ?>', '', '<?= $result_seOps['EMPLOYEECODE1'] ?>', '1')" ><?= $result_seOps['EMPLOYEENAME1'] ?></a>
                                                                                                </li>
                                                                                                <li class="divider"></li>
                                                                                                <?php
                                                                                                  if ($result_seOps['TENKOMASTERID'] != '') {
                                                                                                ?>
                                                                                                 <!-- <li>
                                                                                                    <a tabindex="-1" href='#' data-confirm ="กรุณากด 'ตกลง' เพื่อยืนยันการบันทึกข้อมูล?" onclick="save_tenkomasterhome('<?= $result_seOps['VEHICLETRANSPORTPLANID'] ?>', '', '<?= $result_seOps['EMPLOYEECODE1'] ?>', '1')" ><?= $result_seOps['EMPLOYEENAME1'] ?>(ตรวจร่างกายใหม่)</a>
                                                                                                </li>    -->
                                                                                                <?php
                                                                                                  }  else {
                                                                                                 ?>
                                                                                                   <!-- ELSE CHK TENKOMASTERID FOR EMPLOYEE1 -->                  
                                                                                                 <?php
                                                                                                  }
                                                                                                ?>
                                                                                                
                                                                                                <?php
                                                                                                }else {
                                                                                                ?>
                                                                                                    <!-- ELSE CHK EMPLOYEENAME2 -->                                    
                                                                                                <?php
                                                                                                }
                                                                                                ?>

                                                                                                
                                                                                                <li class="divider"></li>
                                                                                                <?php 
                                                                                                if ($result_seOps['EMPLOYEENAME2'] != '') {
                                                                                                ?>
                                                                                                <li>
                                                                                                    <a tabindex="-1" href='#' onclick="save_tenkomaster('<?= $result_seOps['VEHICLETRANSPORTPLANID'] ?>', '', '<?= $result_seOps['EMPLOYEECODE2'] ?>', '2')" ><?= $result_seOps['EMPLOYEENAME2'] ?></a>
                                                                                                </li>

                                                                                                <li class="divider"></li>
                                                                                                <?php
                                                                                                if ($result_seOps['TENKOMASTERID'] != '') {
                                                                                                  ?>
                                                                                                <!-- <li>
                                                                                                    <a tabindex="-1" href='#' data-confirm ="กรุณากด 'ตกลง' เพื่อยืนยันการบันทึกข้อมูล?" onclick="save_tenkomasterhome('<?= $result_seOps['VEHICLETRANSPORTPLANID'] ?>', '', '<?= $result_seOps['EMPLOYEECODE2'] ?>', '2')" ><?= $result_seOps['EMPLOYEENAME2'] ?>(ตรวจร่างกายใหม่)</a>
                                                                                                </li>  -->
                                                                                                  <?php
                                                                                                }else {
                                                                                                   ?>
                                                                                                    <!-- ELSE CHK TENKOMASTERID FOR EMPLOYEE2 -->
                                                                                                   <?php     
                                                                                                }
                                                                                                ?>
                                                                                                            
                                                                                                <?php                                           
                                                                                                }else {
                                                                                                 ?>
                                                                                                    <!-- ELSE CHK EMPLOYEENAME2 -->
                                                                                                 <?php
                                                                                                }
                                                                                                ?>
                                                                                                
                                                                                                <?php
                                                                                                //}
                                                                                            } else {
                                                                                                ?>
                                                                                                <!-- ELSE FOR MAIN IF ACTUALPRICE-->
                                                                                                <li>-</li>
                                                                                                <?php
                                                                                            }
                                                                                            ?>







                                                                                        </ul>
                                                                                    </div>

                                                                                </td>




                                                                                <td ><?= $result_seOps['JOBNO'] ?></td>
                                                                                <td ><?= $result_seOps['THAINAME'] ?></td>
                                                                                <td ><?= ($result_seOps['EMPLOYEENAME1']) ? $result_seOps['EMPLOYEENAME1'] . '(' . $result_seOps['EMPLOYEECODE1'] . ')' : '' ?> </td>
                                                                                <td ><?= ($result_seOps['EMPLOYEENAME2']) ? $result_seOps['EMPLOYEENAME2'] . '(' . $result_seOps['EMPLOYEECODE2'] . ')' : '' ?></td>
                                                                                <td><?= $result_seOps['JOBSTART'] ?></td>
                                                                                <td><?= $result_seOps['JOBEND'] ?></td>
                                                                                <td><?= $result_seOps['DATEPRESENT'] ?></td>
                                                                                <td><?= $result_seOps['DATERK'] ?></td>
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
                                                <div class="tab-pane fade" id="tenko2">
                                                    <div id="data_tenkotransport"></div>
                                                </div>
                                                <div class="tab-pane fade" id="tenko3">
                                                    <div id="data_tenkoafter"></div>
                                                </div>
                                                <div class="tab-pane fade" id="tenko4">
                                                    <div id="data_tenkoclosejob"></div>
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





            <script src="../vendor/jquery/jquery.min.js"></script>
            <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
            <script src="../vendor/metisMenu/metisMenu.min.js"></script>
            <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
            <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
            <!-- <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script> -->
            <script src="../dist/js/sb-admin-2.js"></script>
            <script src="../js/jquery.datetimepicker.full.js"></script>

            <!-- <script src="../dist/js/jszip.min.js"></script> -->
            <!-- <script src="../dist/js/dataTables.buttons.min.js"></script> -->
            <!-- <script src="../dist/js/buttons.html5.min.js"></script> -->
            <!-- <script src="../dist/js/buttons.print.min.js"></script> -->
            <!-- <script src="../dist/js/bootstrap-select.js"></script> -->
            <!-- <script src="../dist/js/jquery.autocomplete.js"></script>    -->

            <script type="text/javascript"> 
                                                                                                function select_tenkotransport()
                                                                                                {
                                                                                                        // alert("Tenko2");
                                                                                                        $.ajax({
                                                                                                            url: 'meg_data_reportoperationamata.php',
                                                                                                            type: 'POST',
                                                                                                            data: {
                                                                                                                txt_flg: "select_tenkotransport", '': ''
                                                                                                            },
                                                                                                            success: function (rs) {
                                                                                                                document.getElementById("data_tenkotransport").innerHTML = rs;

                                                                                                              

                                                                                                                $('#dataTables-example_tenkotransport').DataTable({
                                                                                                                    responsive: true,
                                                                                                                    order: [[8, "asc"]],
                                                                                                                });
                                                                                                            }
                                                                                                        });
                                                                       
                                                                                                }
                                                                                                function select_tenkoafter()
                                                                                                {
                                                                                                        // alert("Tenko2");
                                                                                                        $.ajax({
                                                                                                            url: 'meg_data_reportoperationamata.php',
                                                                                                            type: 'POST',
                                                                                                            data: {
                                                                                                                txt_flg: "select_tenkoafter", '': ''
                                                                                                            },
                                                                                                            success: function (rs) {
                                                                                                                document.getElementById("data_tenkoafter").innerHTML = rs;

                                                                                                            

                                                                                                                $('#dataTables-example_tenkoafter').DataTable({
                                                                                                                    responsive: true,
                                                                                                                    order: [[1, "desc"]]
                                                                                                                });
                                                                                                            }
                                                                                                        });
                                                                       
                                                                                                }
                                                                                                function select_tenkoclosejob()
                                                                                                {
                                                                                                        // alert("Tenko2");
                                                                                                        $.ajax({
                                                                                                            url: 'meg_data_reportoperationamata.php',
                                                                                                            type: 'POST',
                                                                                                            data: {
                                                                                                                txt_flg: "select_tenkoclosejob", '': ''
                                                                                                            },
                                                                                                            success: function (rs) {
                                                                                                                document.getElementById("data_tenkoclosejob").innerHTML = rs;

                                                                                                               

                                                                                                                $('#dataTables-example_tenkoclosejob').DataTable({
                                                                                                                    responsive: true
                                                                                                                });
                                                                                                            }
                                                                                                        });
                                                                       
                                                                                                }     
                                                                                                function update_tenkomaster(tenkomasterid, vehicletransportplanid, employeecode, statusemp)
                                                                                                {


                                                                                                    save_tenkomaster(vehicletransportplanid, '', employeecode, statusemp);

                                                                                                    $.ajax({
                                                                                                        url: 'meg_data.php',
                                                                                                        type: 'POST',
                                                                                                        data: {
                                                                                                            txt_flg: "update_tenkomaster", tenkomasterid: tenkomasterid, vehicletransportplanid: vehicletransportplanid
                                                                                                        },
                                                                                                        success: function () {



                                                                                                        }

                                                                                                    });



                                                                                                }
                                                                                                function datetodate()
                                                                                                {
                                                                                                    document.getElementById('txt_dateend').value = document.getElementById('txt_datestart').value;

                                                                                                }
                                                                                                // function modal_selecttenko(employeecode, vehicletransportplanid, statusemp)
                                                                                                // {


                                                                                                //     $.ajax({
                                                                                                //         url: 'meg_data.php',
                                                                                                //         type: 'POST',
                                                                                                //         data: {
                                                                                                //             txt_flg: "select_selecttenko", employeecode: employeecode, vehicletransportplanid: vehicletransportplanid, statusemp: statusemp
                                                                                                //         },
                                                                                                //         success: function (rs) {


                                                                                                //             document.getElementById("select_selecttenko").innerHTML = rs;
                                                                                                //             $('#dataTables-example').DataTable({
                                                                                                //                 responsive: true
                                                                                                //             });


                                                                                                //         }

                                                                                                //     });


                                                                                                // }
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
                                                                                                function select_operationamata()
                                                                                                {

                                                                                                    $.ajax({
                                                                                                        url: 'meg_data.php',
                                                                                                        type: 'POST',
                                                                                                        data: {
                                                                                                            txt_flg: "select_operationtenkoamata", companycode: document.getElementById("cb_company").value, datestart: document.getElementById('txt_datestart').value, dateend: document.getElementById('txt_dateend').value
                                                                                                        },
                                                                                                        success: function (rs) {

                                                                                                            document.getElementById("datadef").innerHTML = "";
                                                                                                            document.getElementById("datasr").innerHTML = rs;

                                                                                                            save_logprocess('Tenko', 'Select Company', '<?= $result_seLogin['PersonCode'] ?>');


                                                                                                            $('#dataTables-example1').DataTable({
                                                                                                                responsive: true
                                                                                                            });
                                                                                                            $('#dataTables-example2').DataTable({
                                                                                                                responsive: true
                                                                                                            });
                                                                                                            $('#dataTables-example3').DataTable({
                                                                                                                responsive: true
                                                                                                            });
                                                                                                            $('#dataTables-example4').DataTable({
                                                                                                                responsive: true
                                                                                                            });

                                                                                                            $(function () {
                                                                                                                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                                                                // กรณีใช้แบบ input
                                                                                                                $(".dateen").datetimepicker({
                                                                                                                    timepicker: false,
                                                                                                                    format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                                                                                                    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                                                                    minDate: 0,

                                                                                                                });
                                                                                                            });
                                                                                                        }

                                                                                                    });




                                                                                                }


                                                                                                // function edit_chkvehicletransportjobendtemp(editableObj, fieldname, ID1, vehicletransportplanid)
                                                                                                // {

                                                                                                //     if (document.getElementById(ID1).checked == true) {


                                                                                                //         $.ajax({
                                                                                                //             url: 'meg_data.php',
                                                                                                //             type: 'POST',
                                                                                                //             data: {
                                                                                                //                 txt_flg: "edit_vehicletransportjobendtemp", editableObj: '1', ID1: ID1, fieldname: fieldname
                                                                                                //             },
                                                                                                //             success: function (rs) {

                                                                                                //                 //window.location.reload();
                                                                                                //             }
                                                                                                //         });

                                                                                                //     } else
                                                                                                //     {
                                                                                                //         $.ajax({
                                                                                                //             url: 'meg_data.php',
                                                                                                //             type: 'POST',
                                                                                                //             data: {
                                                                                                //                 txt_flg: "edit_vehicletransportjobendtemp", editableObj: '0', ID1: ID1, fieldname: fieldname
                                                                                                //             },
                                                                                                //             success: function () {

                                                                                                //                 //window.location.reload();
                                                                                                //             }
                                                                                                //         });
                                                                                                //     }

                                                                                                //     alert(vehicletransportplanid);
                                                                                                //     $.ajax({
                                                                                                //         url: 'meg_data.php',
                                                                                                //         type: 'POST',
                                                                                                //         data: {
                                                                                                //             txt_flg: "edit_vehicletransportplantemp", vehicletransportplanid: vehicletransportplanid
                                                                                                //         },
                                                                                                //         success: function () {



                                                                                                //         }
                                                                                                //     });



                                                                                                // }
                                                                                                // function edit_vehicletransportjobendtempinner(editableObj, fieldname, ID1)
                                                                                                // {


                                                                                                //     $.ajax({
                                                                                                //         url: 'meg_data.php',
                                                                                                //         type: 'POST',
                                                                                                //         data: {
                                                                                                //             txt_flg: "edit_vehicletransportjobendtemp", editableObj: editableObj.innerHTML, ID1: ID1, fieldname: fieldname
                                                                                                //         },
                                                                                                //         success: function () {

                                                                                                //             //window.location.reload();
                                                                                                //         }
                                                                                                //     });



                                                                                                // }
                                                                                                // function select_compensationcluster(cluster, num, tempjobendid)
                                                                                                // {

                                                                                                //     $.ajax({
                                                                                                //         url: 'meg_data.php',
                                                                                                //         type: 'POST',
                                                                                                //         data: {
                                                                                                //             txt_flg: "select_compensationcluster", cluster: cluster, tempjobendid: tempjobendid
                                                                                                //         },
                                                                                                //         success: function (rs) {

                                                                                                //             document.getElementById("def_jobend" + num).innerHTML = "";
                                                                                                //             document.getElementById("sr_jobend" + num).innerHTML = rs;
                                                                                                //             update_compensationcluster(cluster);
                                                                                                //         }
                                                                                                //     });

                                                                                                // }
                                                                                                // function update_compensationcluster(editableObj)
                                                                                                // {


                                                                                                //     update_vehicletransportplan(editableObj, 'CLUSTER', '<?= $_GET['vehicletransportplanid'] ?>');


                                                                                                // }
                                                                                                // function update_compensationjobend(jobend)
                                                                                                // {


                                                                                                //     edit_vehicletransportjobendtemp(jobend, 'JOBEND', document.getElementById("tempjobendid").value);



                                                                                                // }
                                                                                                // function edit_vehicletransportjobendtemp(editableObj, fieldname, ID1)
                                                                                                // {


                                                                                                //     $.ajax({
                                                                                                //         url: 'meg_data.php',
                                                                                                //         type: 'POST',
                                                                                                //         data: {
                                                                                                //             txt_flg: "edit_vehicletransportjobendtemp", editableObj: editableObj, ID1: ID1, fieldname: fieldname
                                                                                                //         },
                                                                                                //         success: function () {
                                                                                                //             // alert(rs);
                                                                                                //             //window.location.reload();
                                                                                                //         }
                                                                                                //     });



                                                                                                // }
                                                                                                // function show_confrimdriving(vehicletransportplanid)
                                                                                                // {

                                                                                                //     $.ajax({
                                                                                                //         type: 'post',
                                                                                                //         url: 'meg_data.php',
                                                                                                //         data: {
                                                                                                //             txt_flg: "show_confrimdriving", vehicletransportplanid: vehicletransportplanid

                                                                                                //         },
                                                                                                //         success: function (rs) {

                                                                                                //             document.getElementById("data_confrimdriving").innerHTML = rs;
                                                                                                //         }
                                                                                                //     });

                                                                                                // }
                                                                                                function save_tenkomaster2(vehicletransportplanid, tenkostatus, employeecode, statusemp)
                                                                                                {

                                                                                                    if (statusemp == '1')
                                                                                                    {
                                                                                                        window.open('meg_tenkodocument1.php?vehicletransportplanid=' + vehicletransportplanid + '&employeecode1=' + employeecode, '_blank');
                                                                                                    } else
                                                                                                    {
                                                                                                        window.open('meg_tenkodocument1.php?vehicletransportplanid=' + vehicletransportplanid + '&employeecode2=' + employeecode, '_blank');
                                                                                                    }

                                                                                                    window.location.reload();
                                                                                                }
                                                                                                function save_tenkomaster(vehicletransportplanid, tenkostatus, employeecode, statusemp)
                                                                                                {
                                                                                                    // alert(tenkostatus);

                                                                                                    if (tenkostatus == 'T')
                                                                                                    {

                                                                                                        $.ajax({
                                                                                                            type: 'post',
                                                                                                            url: 'meg_data.php',
                                                                                                            data: {
                                                                                                                txt_flg: "save_tenkomaster", tenkomasterid: '', vehicletransportplanid: vehicletransportplanid, changeka: '',
                                                                                                                remark1: '', remark2: '', status: tenkostatus, officer: '<?= $result_seEmployee["nameT"] ?>', statusemp: statusemp

                                                                                                            },
                                                                                                            success: function () {
                                                                                                                if (statusemp == '1')
                                                                                                                {
                                                                                                                    window.open('meg_tenkodocument1.php?vehicletransportplanid=' + vehicletransportplanid + '&employeecode1=' + employeecode, '_blank');
                                                                                                                } else
                                                                                                                {
                                                                                                                    window.open('meg_tenkodocument1.php?vehicletransportplanid=' + vehicletransportplanid + '&employeecode2=' + employeecode, '_blank');
                                                                                                                }

                                                                                                                window.location.reload();
                                                                                                            }
                                                                                                        });
                                                                                                    } else
                                                                                                    {
                                                                                                        // alert('else');
                                                                                                        // alert(statusemp);
                                                                                                        $.ajax({
                                                                                                            type: 'post',
                                                                                                            url: 'meg_data.php',
                                                                                                            data: {
                                                                                                                txt_flg: "save_tenkomaster", tenkomasterid: '', vehicletransportplanid: vehicletransportplanid, changeka: '',
                                                                                                                remark1: '', remark2: '', status: tenkostatus, officer: '<?= $result_seEmployee["nameT"] ?>', statusemp: statusemp

                                                                                                            },
                                                                                                            success: function () {

                                                                                                                if (statusemp == '1')
                                                                                                                {

                                                                                                                    window.open('meg_tenkodocument1.php?vehicletransportplanid=' + vehicletransportplanid + '&employeecode1=' + employeecode, '_blank');
                                                                                                                } else
                                                                                                                {

                                                                                                                    window.open('meg_tenkodocument1.php?vehicletransportplanid=' + vehicletransportplanid + '&employeecode2=' + employeecode, '_blank');
                                                                                                                }

                                                                                                                window.location.reload();
                                                                                                            }
                                                                                                        });
                                                                                                    }


                                                                                                }
                                                                                                // ตรวจร่างกายใหม่
                                                                                                // function save_tenkomasterhome(vehicletransportplanid, tenkostatus, employeecode, statusemp)
                                                                                                // {
                                                                                                //     $(document).on('click', ':not(form)[data-confirm]', function(e){
                                                                                                //     if(confirm($(this).data('confirm'))){
                                                                                                //     e.stopImmediatePropagation();
                                                                                                //     e.preventDefault();
                                                                                                    
                                                                                                //     // alert('ต้องการจะตรวจร่างกายใหม่');
                                                                                                //     $.ajax({
                                                                                                //             type: 'post',
                                                                                                //             url: 'meg_data.php',
                                                                                                //             data: {
                                                                                                //                 txt_flg: "save_tenkomasterhome", tenkomasterid: '', vehicletransportplanid: vehicletransportplanid, changeka: '',
                                                                                                //                 remark1: '', remark2: '', status: tenkostatus, officer: '<?= $result_seEmployee["nameT"] ?>', statusemp: statusemp

                                                                                                //             },
                                                                                                //             success: function () {

                                                                                                //                 if (statusemp == '1')
                                                                                                //                 {

                                                                                                //                     window.open('meg_tenkodocument1.php?vehicletransportplanid=' + vehicletransportplanid + '&employeecode1=' + employeecode, '_blank');
                                                                                                //                 } else
                                                                                                //                 {

                                                                                                //                     window.open('meg_tenkodocument1.php?vehicletransportplanid=' + vehicletransportplanid + '&employeecode2=' + employeecode, '_blank');
                                                                                                //                 }

                                                                                                //                 window.location.reload();
                                                                                                //             }
                                                                                                //         });
                                                                                                //     }else{
                                                                                                //     alert('ยกเลิก');
                                                                                                //         // window.location.reload();
                                                                                                //     }

                                                                                                    
                                                                                                // });
                                                                                                    
                                                                                                //     // $.ajax({
                                                                                                //     //         type: 'post',
                                                                                                //     //         url: 'meg_data.php',
                                                                                                //     //         data: {
                                                                                                //     //             txt_flg: "save_tenkomasterhome", tenkomasterid: '', vehicletransportplanid: vehicletransportplanid, changeka: '',
                                                                                                //     //             remark1: '', remark2: '', status: tenkostatus, officer: '<?= $result_seEmployee["nameT"] ?>', statusemp: statusemp

                                                                                                //     //         },
                                                                                                //     //         success: function () {

                                                                                                //     //             if (statusemp == '1')
                                                                                                //     //             {

                                                                                                //     //                 window.open('meg_tenkodocument1.php?vehicletransportplanid=' + vehicletransportplanid + '&employeecode1=' + employeecode, '_blank');
                                                                                                //     //             } else
                                                                                                //     //             {

                                                                                                //     //                 window.open('meg_tenkodocument1.php?vehicletransportplanid=' + vehicletransportplanid + '&employeecode2=' + employeecode, '_blank');
                                                                                                //     //             }

                                                                                                //     //             window.location.reload();
                                                                                                //     //         }
                                                                                                //     //     });
                                                                                                // }
                                                                                                // function update_vehicletransportplanjob(rootno, statusnumber)
                                                                                                // {

                                                                                                //     $.ajax({
                                                                                                //         type: 'post',
                                                                                                //         url: 'meg_data.php',
                                                                                                //         data: {
                                                                                                //             txt_flg: "edit_vehicletransportplanjob", rootno: rootno, statusnumber: statusnumber
                                                                                                //         },
                                                                                                //         success: function () {

                                                                                                //             window.location.reload();
                                                                                                //         }
                                                                                                //     });
                                                                                                // }

                                                                                                $(function () {
                                                                                                    $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                                                    // กรณีใช้แบบ input
                                                                                                    $(".dateen").datetimepicker({
                                                                                                        timepicker: false,
                                                                                                        format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                                                                                        lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                                                        minDate: 0,

                                                                                                    });
                                                                                                });



                                                                                        </script>
                                                                                        <script>
                                                                                            $(document).ready(function () {
                                                                                                $('#dataTables-example1').DataTable({
                                                                                                    responsive: true,
                                                                                                    order: [[8, "asc"]],
                                                                                                });
                                                                                                $('#dataTables-example2').DataTable({
                                                                                                    responsive: true
                                                                                                });
                                                                                                $('#dataTables-example3').DataTable({
                                                                                                    responsive: true
                                                                                                });
                                                                                                $('#dataTables-example4').DataTable({
                                                                                                    responsive: true
                                                                                                });
                                                                                            });
                                                                                        </script>

    </body>

</html>
<?php
sqlsrv_close($conn);
?>
