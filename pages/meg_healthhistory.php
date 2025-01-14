<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");



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
        <link href="../js/bootstrap-datepicker.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
        <style>
            .navbar-default {

                border-color: #ffcb0b;
            }
            #page-wrapper {
                border-left: 1px solid #ffcb0b;
            }
            .container {
            display: block;
            position: relative;
            padding-left: 35px;
            margin-bottom: 12px;
            cursor: pointer;
            font-size: 22px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            }

            /* Hide the browser's default checkbox */
            .container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
            }

            /* Create a custom checkbox */
            .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 25px;
            width: 25px;
            background-color: #8e8e8e;
            }

            /* On mouse-over, add a grey background color */
            .container:hover input ~ .checkmark {
            background-color: #ccc;
            }

            /* When the checkbox is checked, add a blue background */
            .container input:checked ~ .checkmark {
            background-color: #05ad16;
            }

            /* Create the checkmark/indicator (hidden when not checked) */
            .checkmark:after {
            content: "";
            position: absolute;
            display: none;
            }

            /* Show the checkmark when checked */
            .container input:checked ~ .checkmark:after {
            display: block;
            }

            /* Style the checkmark/indicator */
            .container .checkmark:after {
            left: 9px;
            top: 5px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 3px 3px 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
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
    <body>

        <div id="wrapper">
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
        <!-- <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">

                    <li><a href="meg_logout.php"><i class="fa fa-sign-out fa-fw"></i> ออกจากระบบ</a>
                    </li>
                </ul>
            </li>
        </ul> -->
        </nav>


            <!-- <div id="page-wrapper"> -->
                <!-- <p>&nbsp;</p> -->

                <div id="datade_edit">
              
                            
                   
                    <div class="row">
                        
                        <div class="col-lg-12">&nbsp;</div>
                        <div class="col-lg-12">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>เลือกปี (รายงาน)</label><br>   
                                    <select id="select_yearreport" name="select_yearreport" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก ปีรายงาน" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                        <!-- <option value="">เลือกปี</option>
                                        <?php
                                        $sql_seMonthst = "SELECT DISTINCT CREATEYEAR+543 AS 'YEAR'  
                                        FROM [dbo].[HEALTHHISTORY]";
                                        $params_seMonthst = array();
                                        $query_seMonthst = sqlsrv_query($conn, $sql_seMonthst, $params_seMonthst);
                                        while ($result_seMonthst = sqlsrv_fetch_array($query_seMonthst, SQLSRV_FETCH_ASSOC)) {
                                            ?>
                                            <option value="<?= $result_seMonthst['YEAR']-543 ?>"><?= $result_seMonthst['YEAR'] ?></option>

                                            <?php
                                        }
                                        ?> -->
                                        <?php
                                        for ($y = 1993; $y <= 2100; $y++) { ?>
                                        <option value ="<?=$y?>" <?=($_GET['YearsSelect']==$y? 'selected' : '')?> > <?=$y+543?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>เลือกบริษัท (รายงาน)</label><br>   
                                    <select id="select_com" name="select_com" class="form-control" onchange="select_customer(this.value)">
                                        <option value="00">เลือกบริษัท</option>
                                        <option value="01">บริษัท ร่วมกิจรุ่งเรือง (1993)</option>
                                        <option value="02">บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส</option>
                                        <option value="04">บริษัท ร่วมกิจรุ่งเรือง คาร์ แคริเออร์</option>
                                        <option value="05">บริษัท ร่วมกิจ รีไซเคิล แคริเออร์</option>
                                        <option value="06">บริษัท ร่วมกิจรุ่งเรือง ทรัค ดีเทลส์</option>
                                        <option value="07">บริษัท ร่วมกิจรุ่งเรือง โลจิสติคส์</option>
                                        <option value="08">บริษัท ร่วมกิจรุ่งเรือง เทรนนิ่ง เซ็นเตอร์</option>
                                        <option value="09">บริษัท ร่วมกิจ ออโตโมทีฟ ทรานสปอร์ต</option>
                                        <option value="10">บริษัท ร่วมกิจ ไอที</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <label>เลือกตำแหน่ง (รายงาน)</label>
                                <div class="dropdown bootstrap-select show-tick form-control">
                                    <!-- $emp = select_empautocomplate('megEmployeeEHR_v2', 'select_employeehealth', ""); -->
                                    <select   id="txt_positionname" name="txt_positionname" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก ตำแหน่ง" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                    
                                    <?php
                                        $sql_sePosition = "SELECT DISTINCT PositionnameT FROM EMPLOYEEEHR2 
                                        WHERE PositionNameT != '-'";
                                        $params_sePosition = array();
                                        $query_sePosition = sqlsrv_query($conn, $sql_sePosition, $params_sePosition);
                                        while ($result_sePosition = sqlsrv_fetch_array($query_sePosition, SQLSRV_FETCH_ASSOC)) {
                                            ?>
                                            <option value="<?= $result_sePosition['PositionnameT'] ?>"><?= $result_sePosition['PositionnameT'] ?></option>

                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <input class="form-control" style="display: none"   id="txt_copydiagramzone" name="txt_copydiagramzone" maxlength="500" value="" >
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>พิมพ์ข้อมูลประวัติสุขภาพ &nbsp;<i class="fa fa-file-excel-o" aria-hidden="true"></i></label><br>   
                                    <input type="button" onclick="print_health()" name="" id="" value="พิมพ์ข้อมูลประวัติสุขภาพ" class="btn btn-primary">
                                </div>
                            </div>
                        </div>   

                        <div class="col-lg-12">&nbsp;</div>
                        <div class="col-lg-12">
                            <div class="col-lg-2">
                                <label>เลือกพนักงาน (ค้นหา)</label>
                                <div class="dropdown bootstrap-select show-tick form-control">
                                    <!-- $emp = select_empautocomplate('megEmployeeEHR_v2', 'select_employeehealth', ""); -->
                                    <select   id="txt_drivername" name="txt_drivername" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก พนักงาน..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                        <?php
                                        // $condiLocation1 = " AND COMPANYCODE = 'RKR' AND CUSTOMERCODE = 'TTASTSTC'";
                                        $sql_seName = "{call megEmployeeEHR_v2(?,?)}";
                                        $params_seName = array(
                                            array('select_employeehealth', SQLSRV_PARAM_IN),
                                            array('', SQLSRV_PARAM_IN)
                                        );
                                        $query_seName = sqlsrv_query($conn, $sql_seName, $params_seName);
                                        while ($result_seName = sqlsrv_fetch_array($query_seName, SQLSRV_FETCH_ASSOC)) {
                                            ?>
                                            <option value="<?= $result_seName['nameT'] ?>"><?= $result_seName['nameT'] ?> (<?= $result_seName['PersonCode'] ?>)</option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <input class="form-control" style="display: none"   id="txt_copydiagramzone" name="txt_copydiagramzone" maxlength="500" value="" >
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>เลือกปี (ค้นหา)</label><br>   
                                    <select id="select_year" name="select_year" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก ปีค้นหา" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                        <!-- <option value="">เลือกปี</option> -->
                                        <!-- <?php
                                        $sql_seMonthst = "SELECT DISTINCT CREATEYEAR+543 AS 'YEAR'  FROM [dbo].[HEALTHHISTORY]";
                                        $params_seMonthst = array();
                                        $query_seMonthst = sqlsrv_query($conn, $sql_seMonthst, $params_seMonthst);
                                        while ($result_seMonthst = sqlsrv_fetch_array($query_seMonthst, SQLSRV_FETCH_ASSOC)) {
                                            ?>
                                            <option value="<?= $result_seMonthst['YEAR']-543 ?>"><?= $result_seMonthst['YEAR'] ?></option>
    
                                            <?php
                                        }
                                        ?> -->
                                        <?php
                                        for ($y = 1993; $y <= 2100; $y++) { ?>
                                        <option value ="<?=$y?>" <?=($_GET['YearsSelect']==$y? 'selected' : '')?> > <?=$y+543?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>ค้นหาข้อมูลประวัติสุขภาพ&nbsp;<i class="fa fa-search" aria-hidden="true"></i> </label><br>   
                                    <input type="button" onclick="search_health()" name="" id="" value="ค้นหาข้อมูลประวัติสุขภาพ" class="btn btn-primary">
                                </div>
                            </div>
                        </div> 
                        
                        <?php
                        //เข้าดูข้อมูลยกเว้น สิทธิ์ TENKO(AMT)
                        if ($_SESSION["ROLENAME"] != "TENKO(AMT)") {
                        ?>
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                    <a href='index2.php'>หน้าแรก</a> / บันทึกข้อมูลประวัติสุขภาพ
                                    </div>
                                    <input  class="form-control" type="hidden" id="txt_username" name="txt_username" value="<?=$_SESSION["USERNAME"]?>">
                                    <div id="datadef_edit">
                                        <div class="panel-body">
                                            <div class="row" >
                                                <!-- <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label>พนักงาน : <font style="color: red">*</font></label>
                                                        <input   class="form-control" type="text" id="txt_employee1" name="txt_employee1" value="">
                                                    </div>
                                                </div> -->
                                                <div class="col-lg-2">
                                                    <label>เลือกพนักงาน (บันทึก)</label>
                                                    <div class="dropdown bootstrap-select show-tick form-control">
                                                        <!-- $emp = select_empautocomplate('megEmployeeEHR_v2', 'select_employeehealth', ""); -->
                                                        <select   id="txt_drivername_save" name="txt_drivername_save" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก พนักงาน..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                            <?php
                                                            // $condiLocation1 = " AND COMPANYCODE = 'RKR' AND CUSTOMERCODE = 'TTASTSTC'";
                                                            $sql_seName = "{call megEmployeeEHR_v2(?,?)}";
                                                            $params_seName = array(
                                                                array('select_employeehealth', SQLSRV_PARAM_IN),
                                                                array('', SQLSRV_PARAM_IN)
                                                            );
                                                            $query_seName = sqlsrv_query($conn, $sql_seName, $params_seName);
                                                            while ($result_seName = sqlsrv_fetch_array($query_seName, SQLSRV_FETCH_ASSOC)) {
                                                                ?>
                                                                <option value="<?= $result_seName['nameT'] ?>"><?= $result_seName['nameT'] ?> (<?= $result_seName['PersonCode'] ?>)</option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <input class="form-control" style="display: none"   id="txt_copydiagramzone" name="txt_copydiagramzone" maxlength="500" value="" >
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                       <br><br><br>
                                                    </div>
                                                </div>

                                            </div>
                                            
                                            
                                            <!-- START ROW1 -->
                                            <div class="row" >
                                                <div class="col-lg-4" >
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" style="background-color: #f8f8f8;">
                                                            <label><font style="font-size: 16px">5 โรคเสี่ยง</font></label>
                                                        </div>
                                                        <!-- /.panel-heading -->
                                                        <div class="panel-body">
                                                            <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                                <div class = "row">
                                                                    <div class="col-lg-12">
                                                                        <label class="container">เบาหวาน
                                                                            <input type="checkbox" id="diabetes" name ="diabetes" value ="">
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                    </div>  
                                                                </div>
                                                                <div class = "row">
                                                                    <div class="col-lg-12">
                                                                        <label class="container">ความดันโลหิตสูง
                                                                            <input type="checkbox" id="hbp" name="hbp" value ="">
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                    </div>  
                                                                </div>
                                                                <div class = "row">
                                                                    <div class="col-lg-12">
                                                                        <label class="container">ความดันโลหิตต่ำ
                                                                            <input type="checkbox" id="lbp" name="lbp" value ="">
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                    </div>  
                                                                </div>
                                                                <div class = "row">
                                                                    <div class="col-lg-12">
                                                                        <label class="container">โรคหัวใจ
                                                                            <input type="checkbox" id="heartdisease" name="heartdisease" value ="">
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                    </div>  
                                                                </div>
                                                                <div class = "row">
                                                                    <div class="col-lg-12">
                                                                        <label class="container">ลมชัก/ลมบ้าหมู
                                                                            <input type="checkbox" id="epilepsy" name="epilepsy" value ="">
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                    </div>  
                                                                </div>
                                                                <div class = "row">
                                                                    <div class="col-lg-12">
                                                                        <label class="container">ผ่าตัดสมอง
                                                                            <input type="checkbox" id="brainsurgery" name="brainsurgery" value ="">
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                    </div>  
                                                                </div>
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- .panel-body -->
                                                    </div>
                                                    <!-- /.panel -->
                                                </div>
                                                <!-- END COLUNM1 -->
                                        
                                                <!-- START COLUNM2 -->
                                                <div class="col-lg-4" >
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" style="background-color: #f8f8f8;">
                                                            <label><font style="font-size: 16px">สายตา</font></label>
                                                        </div>
                                                        <!-- /.panel-heading -->
                                                        <div class="panel-body">
                                                            <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                                <div class = "row">
                                                                    <div class="col-lg-5">
                                                                        <label class="container">สายตาสั้น 
                                                                            <input type="checkbox" id="short_sight" name="short_sight" value= "" >
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                    </div>  
                                                                </div>
                                                                <div class = "row">
                                                                    <div class="scol-lg-4">
                                                                        <form class="form-inline">
                                                                            <div class="form-group">
                                                                                <label >(R)</label>
                                                                                <input type="text" class="form-control" id="short_sightr" name="short_sightr" value= "" autocomplete="off">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label >(L)</label>
                                                                                <input type="text" class="form-control" id="short_sightl" name="short_sightl" value= "" autocomplete="off">
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                                <div class = "row">
                                                                    <div class="col-lg-5">
                                                                        <label class="container">สายตายาว
                                                                            <input type="checkbox" id="long_sight" name="long_sight" value= "">
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                    </div>  
                                                                </div>
                                                                <div class = "row">
                                                                    <div class="scol-lg-4">
                                                                        <form class="form-inline">
                                                                            <div class="form-group">
                                                                                <label >(R)</label>
                                                                                <input type="text" class="form-control" id="long_sightr" name="long_sightr" value= "" autocomplete="off">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label >(L)</label>
                                                                                <input type="text" class="form-control" id="long_sightl" name="long_sightl" value= "" autocomplete="off">
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                                <div class = "row">
                                                                    <div class="col-lg-6">
                                                                        <label class="container">สายตาเอียง
                                                                            <input type="checkbox" id="oblique_sight" name="oblique_sight" value= "">
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                    </div>  
                                                                </div>
                                                                <div class = "row">
                                                                    <div class="scol-lg-6">
                                                                        <form class="form-inline">
                                                                            <div class="form-group">
                                                                                <label >(R)</label>
                                                                                <input type="text" class="form-control" id="oblique_sightr" name="oblique_sightr" value= "" autocomplete="off">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label >(L)</label>
                                                                                <input type="text" class="form-control" id="oblique_sightl" name="oblique_sightl" value= "" autocomplete="off">
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                                <div class = "row">
                                                                    <label ></label>
                                                                </div>
                                                                <div class = "row">
                                                                    <div class="col-lg-6">
                                                                        <label class="form-group" style="text-align: left"><font style="font-size: 22px">ตาบอดสี</font>
                                                                            <!-- <input type="checkbox" disabled id="color_blind" name="color_blind" value= ""> -->
                                                                            <!-- <span class="checkmark"></span> -->
                                                                        </label>
                                                                    </div>  
                                                                </div>
                                                                <div class = "row">
                                                                    <div class="col-lg-5">
                                                                        <label class="container">ปกติ
                                                                                <input type="checkbox" id="color_blindok" name="color_blindok" value= "">
                                                                                <span class="checkmark"></span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-lg-5">
                                                                        <label class="container">ผิดปกติ
                                                                                <input type="checkbox" id="color_blindng" name="color_blindng" value= "">
                                                                                <span class="checkmark"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                        <!-- .panel-body -->
                                                    </div>
                                                    <!-- /.panel -->
                                                
                                                </div>
                                            <!-- END COLUNM3 -->   

                                                <!-- START COLUNM3 -->
                                                    <div class="col-lg-4" >
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading" style="background-color: #f8f8f8;">
                                                                <label><font style="font-size: 16px">โรคอื่นๆ</font></label>
                                                            </div>
                                                        <!-- /.panel-heading -->
                                                            <div class="panel-body">
                                                                <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                                    <div class = "row">
                                                                        <div class="scol-lg-4">
                                                                            <form class="form-inline">
                                                                                <div class="form-group">
                                                                                    <label >(1)</label>
                                                                                    <input type="text" class="form-control" id="other_disease1" name = "other_disease1" value="" size="55" autocomplete="off">
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                    <div class = "row">
                                                                        <label ></label>
                                                                    </div>
                                                                    <div class = "row">
                                                                        <div class="scol-lg-4">
                                                                            <form class="form-inline">
                                                                                <div class="form-group">
                                                                                    <label >(2)</label>
                                                                                    <input type="text" class="form-control" id="other_disease2" name = "other_disease2" value="" size="55" autocomplete="off">
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                    <div class = "row">
                                                                        <label ></label>
                                                                    </div>
                                                                    <div class = "row">
                                                                        <div class="scol-lg-4">
                                                                            <form class="form-inline">
                                                                                <div class="form-group">
                                                                                    <label >(3)</label>
                                                                                    <input type="text" class="form-control" id="other_disease3" name = "other_disease3" value="" size="55" autocomplete="off">
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                    <div class = "row">
                                                                        <label ></label>
                                                                    </div>
                                                                    <div class = "row">
                                                                        <div class="scol-lg-4">
                                                                            <form class="form-inline">
                                                                                <div class="form-group">
                                                                                    <label >(4)</label>
                                                                                    <input type="text" class="form-control" id="other_disease4" name = "other_disease4" value="" size="55" autocomplete="off">
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                    <div class = "row">
                                                                        <label ></label>
                                                                    </div>
                                                                    <div class = "row">
                                                                        <div class="scol-lg-4">
                                                                            <form class="form-inline">
                                                                                <div class="form-group">
                                                                                    <label >(5)</label>
                                                                                    <input type="text" class="form-control" id="other_disease5" name = "other_disease5" value="" size="55" autocomplete="off">
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                    <div class = "row">
                                                                        <label ></label>
                                                                    </div>
                                                                    <div class = "row">
                                                                        <div class="scol-lg-4">
                                                                            <form class="form-inline">
                                                                                <div class="form-group">
                                                                                    <label >(6)</label>
                                                                                    <input type="text" class="form-control" id="other_disease6" name = "other_disease6" value="" size="55" autocomplete="off">
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                    <div class = "row">
                                                                        <label ></label>
                                                                    </div>
                                                                    <div class = "row">
                                                                        <label ></label>
                                                                    </div>
                                                                    <div class = "row">
                                                                        <label ></label>
                                                                    </div>
                                                                    <div class = "row">
                                                                        <label ></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <!-- .panel-body -->
                                                    </div>
                                                    <!-- /.panel -->
                                                </div> 
                                                <!-- /.panel default-->
                                            </div>
                                            <!-- END COLUNM3 -->
                                            

                                            

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <input type="button" onclick="save_health();" name="btnSend" id="btnSend" value="บันทึกข้อมูล" class="btn btn-primary">
                                                    <!-- <input type="button"  data-confirm ="กรุณากด 'ตกลง' เพื่อยืนยันการบันทึกข้อมูล?" name="btnSend" id="btnSend" value="บันทึกข้อมูล" class="btn btn-primary"> -->
                                                    
                                                </div>
                                            </div>

                                            <!-- /.row (nested) -->
                                        </div>

                                    </div>
                                    <div id="datasr_edit"></div>
                                    <!-- /.panel-body -->
                                </div>
                                <!-- /.panel -->
                            </div>
                        <?php
                        }else {
                        ?>

                        <?php
                        }
                        ?>
                        
                        <!-- /.col-lg-12 -->
                    </div>




                <!-- </div> -->
                <div id="datasr_edit">

                </div>
                <div class="row" >
                    <div class="col-lg-12">
                        &nbsp;

                    </div>
                </div>
                  
                



            <!-- </div> -->

        </div>

        

        <?php
        $emp = select_empautocomplate('megEmployeeEHR_v2', 'select_employeehealth', "");

        ?>
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
    <script src="../dist/js/sb-admin-2.js"></script>
    <script src="../js/jquery.datetimepicker.full.js"></script>
    <script src="../dist/js/jquery.autocomplete.js"></script>
    <script src="../dist/js/bootstrap-select.js"></script>
    <script src="../js/bootstrap-datepicker.min.js"></script>
    <script src="../js/bootstrap-datepicker.th.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>

        <script type="text/javascript">

            var txt_employee1 = [<?= $emp ?>];
            $(function () {
                $("#txt_employee1").autocomplete({
                    source: [txt_employee1]
                });


            });
            
            //ปุ่ม Confirm แบบเก่า
            // $(document).on('click', ':not(form)[data-confirm]', function(e){
            //     if(!confirm($(this).data('confirm'))){
            //     e.stopImmediatePropagation();
            //     e.preventDefault();
                

            //     }else{

            //         save_health(); 
            //     }

                   
            // });    


            function print_health(){

                var year = document.getElementById('select_yearreport').value;
                var companycode = document.getElementById('select_com').value;
                var positionchk = document.getElementById('txt_positionname').value;


                if (positionchk == '') {
                    position = 'not select';
                }else{
                    position = positionchk;
                }

                if (year == '') {
                    swal.fire({
                        title: "Warning!",
                        text: "ยังไม่ได้เลือกปี ในการพิมพ์ข้อมูล",
                        icon: "warning",
                        showConfirmButton: true,
                        allowOutsideClick: false,
                    });
                }else if(companycode == '00'){
                    swal.fire({
                        title: "Warning!",
                        text: "ยังไม่ได้เลือกบริษัท ในการพิมพ์ข้อมูล",
                        icon: "warning",
                        showConfirmButton: true,
                        allowOutsideClick: false,
                    });
                }else{
                    // alert(position);
                    window.open('excel_healthhistory.php?createyear='+year+'&companycode='+companycode+'&position='+position, '_blank');
                }
                
            }



            function search_health(){
                var employeename = document.getElementById('txt_drivername').value;
                var year = document.getElementById('select_year').value;
                
                if (employeename == '') {
                    swal.fire({
                        title: "Warning!",
                        text: "ยังไม่ได้เลือกพนักงาน ในการค้นหาข้อมูล",
                        icon: "warning",
                        showConfirmButton: true,
                        allowOutsideClick: false,
                    });
                }else if(year == ''){
                    swal.fire({
                        title: "Warning!",
                        text: "ยังไม่ได้เลือกบริษัท ในการค้นหาข้อมูล",
                        icon: "warning",
                        showConfirmButton: true,
                        allowOutsideClick: false,
                    });
                }else{
                    window.open('report_healthhistory.php?employeename=' + employeename+'&createyear='+year, '_blank');
                }
                
                
            }
           
            
            
            
            
            
            function save_health()
            {
                 if (document.getElementById('txt_drivername_save').value == "")
                {
                    // alert("พนักงานเป็นค่าว่าง !");
                    swal.fire({
                        title: "Warning!",
                        text: "พนักงานเป็นค่าว่าง",
                        icon: "warning",
                        showConfirmButton: true,
                        allowOutsideClick: false,
                    });
                    document.getElementById('txt_drivername_save').focus();
                } else {
                  
                    var employeename = document.getElementById('txt_drivername_save').value;
                    var username = document.getElementById('txt_username').value;
                    var diabeteschk = "";
                    var hbpchk = "";
                    var lbpchk = "";
                    var heartdiseasechk = "";
                    var epilepsychk = "";
                    var brainsurgerychk = "";
                    var short_sightchk = "";
                    var long_sightchk = "";
                    var oblique_sightchk = "";
                    // var color_blindchk = "";
                    var color_blindokchk = "";
                    var color_blindngchk = "";
                    
                   
                    //เบาหวาน
                    if($("#diabetes").is(':checked')){

                        diabeteschk = '1';
                        //alert('1');
                    } else {
                        diabeteschk = '0';
                        //alert('0');
                    }

                    //ความดันโลหิตสูง
                    if($("#hbp").is(':checked')){

                        hbpchk = '1';
                        //alert('1');
                    } else {
                        hbpchk = '0';
                        //alert('0');
                    }
                    
                    //ความดันโลหิตต่ำ
                    if($("#lbp").is(':checked')){

                        lbpchk = '1';
                        //alert('1');
                    } else {
                        lbpchk = '0';
                        //alert('0');
                    }

                    //โรคหัวใจ
                    if($("#heartdisease").is(':checked')){

                        heartdiseasechk = '1';
                        //alert('1');
                    } else {
                        heartdiseasechk = '0';
                        //alert('0');
                    }

                    //ลมชัก/ลมบ้าหมู
                    if($("#epilepsy").is(':checked')){

                        epilepsychk = '1';
                        //alert('1');
                    } else {
                        epilepsychk = '0';
                        // alert('0');
                    }

                    //ผ่าตัดสมอง
                    if($("#brainsurgery").is(':checked')){

                        brainsurgerychk = '1';
                        // alert('1');
                    } else {
                        brainsurgerychk = '0';
                        // alert('0');
                    }

                    //สายตาสั้น
                    if($("#short_sight").is(':checked')){

                        short_sightchk = '1';
                        var short_sightr = document.getElementById('short_sightr').value;
                        var short_sightl = document.getElementById('short_sightl').value;
                        //alert(short_sightr);
                        //alert(short_sightl);
                        //alert('1');
                    } else {
                        short_sightchk = '0';
                        //alert('0');
                    }

                    //สายตายาว
                    if($("#long_sight").is(':checked')){

                        long_sightchk = '1';
                        var long_sightr = document.getElementById('long_sightr').value;
                        var long_sightl = document.getElementById('long_sightl').value;
                       // alert(long_sightr);
                        //alert(long_sightl);
                        //alert('1');
                    } else {
                        long_sightchk = '0';
                        //alert('0');
                    }

                    //สายตาเอียง
                    if($("#oblique_sight").is(':checked')){

                        oblique_sightchk = '1';
                        var oblique_sightr = document.getElementById('oblique_sightr').value;
                        var oblique_sightl = document.getElementById('oblique_sightl').value;
                       // alert(oblique_sightr);
                       // alert(oblique_sightl);
                       // alert('1');
                    } else {
                        oblique_sightchk = '0';
                        //alert('0');
                    }

                    // //ตาบอดสี
                    // if($("#color_blind").is(':checked')){

                    //     color_blindchk = '1';
                    //     //alert('1');
                    // } else {
                    //     color_blindchk = '0';
                    //     //alert('0');
                    // }

                    //ตาบอดสีปกติ
                    if($("#color_blindok").is(':checked')){

                        color_blindokchk = '1';
                        //alert('1');
                    } else {
                        color_blindokchk = '0';
                        //alert('0');
                    }

                    //ตาบอดสีไม่ปกติ
                    if($("#color_blindng").is(':checked')){

                        color_blindngchk = '1';
                        //alert('1');
                    } else {
                        color_blindngchk = '0';
                        //alert('0');
                    }
                    
                    //โรคอื่นๆ
                    var other_disease1 = document.getElementById('other_disease1').value;
                    var other_disease2 = document.getElementById('other_disease2').value;
                    var other_disease3 = document.getElementById('other_disease3').value;
                    var other_disease4 = document.getElementById('other_disease4').value;
                    var other_disease5 = document.getElementById('other_disease5').value;
                    var other_disease6 = document.getElementById('other_disease6').value;

                    // alert(other_disease1);
                    // alert(other_disease2);
                    // alert(other_disease3);
                    // alert(other_disease4);
                    // alert(other_disease5);
                    // alert(other_disease6);



                    
                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            
                            txt_flg: "save_healthhistory",
                            id:'', 
                            employeename:employeename,
                            diabetes: diabeteschk, 
                            hightbloodpressure:hbpchk,
                            lowbloodpressure: lbpchk, 
                            heartdisease:heartdiseasechk , 
                            epilepsy: epilepsychk,
                            brainsurgery: brainsurgerychk,
                            shortsight: short_sightchk,
                            short_sightr: short_sightr,
                            short_sightl: short_sightl,
                            longsight: long_sightchk,
                            long_sightr: long_sightr,
                            long_sightl: long_sightl,
                            obliquesight: oblique_sightchk,
                            oblique_sightr: oblique_sightr, 
                            oblique_sightl: oblique_sightl, 
                            color_blindok: color_blindokchk,
                            color_blindng: color_blindngchk,
                            other_disease1: other_disease1,
                            other_disease2: other_disease2,
                            other_disease3: other_disease3,
                            other_disease4: other_disease4,
                            other_disease5: other_disease5,
                            other_disease6: other_disease6,
                            createby:username
                        },
                        success: function (rs) {
                            
                            // alert("บันทึกข้อมูลเรียบร้อย");
                            Swal.fire({
                                title: 'บันทึกข้อมูลเรียบร้อย',
                                text: "กรุณากด 'ตกลง' เพื่อยืนยันการบันทึกข้อมูล!!!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'ตกลง',
                                cancelButtonText: 'ยกเลิก'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    Swal.fire(
                                    'Success!',
                                    'Your data has been saved.',
                                    'success'
                                    )
                                    window.location.reload();
                                }else{
                                    window.location.reload();
                                }
                            })

                            // swal.fire({
                            //     title: "Good Job!",
                            //     text: "บันทึกข้อมูลเรียบร้อย",
                            //     showConfirmButton: true,
                            //     allowOutsideClick: false,
                            //     icon: "success",
                            //     timer: 4500,  
                            // });

                           
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