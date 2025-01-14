<!DOCTYPE html>
<?php
session_start();
ini_set('max_execution_time', 300);
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$condition1 = "  AND a.PersonID = '" . $_SESSION["EMPLOYEEID"] . "'";
$sql_seEmployee = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmployee = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
$result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC);

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
        <!-- <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet"> -->
        <!-- <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet"> -->
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">


        <!-- <link href="../dist/css/buttons.dataTables.min.css" rel="stylesheet"> -->
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">
        
        <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="js/jquery.form.min.js"></script>
        <!-- <link href="style/style.css" rel="stylesheet" type="text/css"> -->
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

            .button {
            display: inline-block;
            padding: 15px 25px;
            font-size: 24px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            outline: none;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 15px;
            box-shadow: 0 9px #999;
            }

            .button:hover {background-color: #3e8e41}

            .button:active {
            background-color: #3e8e41;
            box-shadow: 0 5px #666;
            transform: translateY(10px);
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
                        $sql_sePremissions = "{call megRoleaccount_v2(?,?)}";
                        $params_sePremissions = array(
                            array('select_permissions', SQLSRV_PARAM_IN),
                            array($condition1, SQLSRV_PARAM_IN)
                        );
                        $query_sePremissions = sqlsrv_query($conn, $sql_sePremissions, $params_sePremissions);
                        while ($result_sePremissions = sqlsrv_fetch_array($query_sePremissions, SQLSRV_FETCH_ASSOC)) {
                            ?>
                            <li><a href="" onclick="create_premissions('<?= $result_sePremissions['ROLEID'] ?>');"><i class="fa fa-user fa-fw"></i> <?= $result_sePremissions['ROLENAME'] ?></a></li>
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
                                $meg = 'Insert Accident Data,Simulator Data,Driver feedback Data';




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

                            <div class="col-md-2" >&nbsp;</div>
                        </div>
                        <div id="datadef">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    Insert Accident Data,Simulator Data,Driver feedback Data
                                                </div>



                                            </div>
                                        </div>
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-pills">
                                                <li class="active"><a href="#accident" data-toggle="tab" aria-expanded="true">ลงข้อมูลอุบัติเหตุ</a>
                                                </li>
                                                <li><a href="#simulator" data-toggle="tab">ลงข้อมูล SIMULATOR</a>
                                                </li>
                                                <li><a href="#feedbackdriver" data-toggle="tab">ลงข้อมูล Feedback Driver</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="row">
                                                    <div class="col-md-12" >&nbsp;</div>
                                                </div>
                                                <div class="tab-pane fade active in" id="accident">
                                                    <div class="row">

                                                        <input  class="form-control" type="hidden" id="txt_username" name="txt_username" value="<?=$_SESSION["USERNAME"]?>">
                                                        <div class="col-lg-2">
                                                            <label>เลือกพนักงาน:</label>
                                                            <div class="dropdown bootstrap-select show-tick form-control">
                                                                <!-- $emp = select_empautocomplate('megEmployeeEHR_v2', 'select_employeehealth', ""); -->
                                                                <select   id="txt_drivernamesearch" name="txt_drivernamesearch" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก พนักงาน..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
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
                                                                        <option value="<?= $result_seName['PersonCode'] ?>"><?= $result_seName['nameT'] ?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label>เลือกปีเริ่มต้น (ค้นหา)</label><br>   
                                                                <select   id="txt_yearsearchstart" name="txt_yearsearchstart" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก ปีเริ่มต้น..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                    <option value ="" disabled selected >- เลือกปี -</option>
                                                                    <?php
                                                                    for ($y = 1993; $y <= 2100; $y++) { ?>
                                                                    <option value ="<?=$y?>" <?=($_GET['YearsSelect']==$y? 'selected' : '')?> > <?=$y?> </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label>เลือกปีสิ้นสุด (ค้นหา)</label><br>   
                                                                <select   id="txt_yearsearchend" name="txt_yearsearchend" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก ปีสิ้นสุด..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                    <option value ="" disabled selected >- เลือกปี -</option>
                                                                    <?php
                                                                    for ($y = 1993; $y <= 2100; $y++) { ?>
                                                                    <option value ="<?=$y?>" <?=($_GET['YearsSelect']==$y? 'selected' : '')?> > <?=$y?> </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label>ค้นหาข้อมูลประวัติอุบัติเหตุ </label><br>   
                                                                <input type="button"  name="" id=""onclick="search_accident()" value="ค้นหาข้อมูลประวัติอุบัติเหตุ" class="btn btn-primary">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label>Upload Data</label><br>   
                                                                <input type="button"  name="" id="" onclick="upload_excelaccident()" value="Upload Accident Data" class="btn btn-primary">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <!-- START ROW1 -->
                                                    <div class="col-lg-4" >
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading" style="background-color: #f0c402;">
                                                                <label><font style="font-size: 16px">บันทึกข้อมูลอุบัติเหตุ</font></label>
                                                            </div>
                                                            
                                                            <div class="panel-body">
                                                                <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                                    <div class = "row">
                                                                        <div class="">
                                                                                <div class="form-group">
                                                                                    <label >รายละเอียดข้อมูลการเกิดอุบัติเหตุ</label><br><br>
                                                                                    <div class="col-lg-12">
                                                                                            <label ><u>พนักงานขับรถ (บันทึกข้อมูล)</u></label><br>
                                                                                            <div class="dropdown bootstrap-select show-tick form-control">
                                                                                                <select   id="txt_drivernameinsert" name="txt_drivernameinsert" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก พนักงาน..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                                    <?php
                                                                                                    $sql_seName = "{call megEmployeeEHR_v2(?,?)}";
                                                                                                    $params_seName = array(
                                                                                                        array('select_employeehealth', SQLSRV_PARAM_IN),
                                                                                                        array('', SQLSRV_PARAM_IN)
                                                                                                    );
                                                                                                    $query_seName = sqlsrv_query($conn, $sql_seName, $params_seName);
                                                                                                    while ($result_seName = sqlsrv_fetch_array($query_seName, SQLSRV_FETCH_ASSOC)) {
                                                                                                        ?>
                                                                                                        <option value="<?= $result_seName['nameT'] ?>"><?= $result_seName['nameT'] ?></option>
                                                                                                        <?php
                                                                                                    }
                                                                                                    ?>
                                                                                                </select>
                                                                                            </div>
                                                                                    </div>
                                                                                    <br><br><br><br>
                                                                                    <div class="col-lg-12">
                                                                                        <div class="form-group">
                                                                                            <label>เลือกปี (บันทึกข้อมูล)</label><br>   
                                                                                            <select   id="txt_selectyearsinsert" name="txt_selectyearsinsert" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก ปี..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                                <option value ="" disabled selected >- เลือกปี -</option>
                                                                                                <?php
                                                                                                for ($y = 1993; $y <= 2100; $y++) { ?>
                                                                                                <option value ="<?=$y?>" <?=($_GET['YearsSelect']==$y? 'selected' : '')?> > <?=$y?> </option>
                                                                                                <?php } ?>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <br><br><br><br>
                                                                                    <div class="col-lg-12">
                                                                                            <label ><u>วันที่และเวลาที่เกิดอุบัติเหตุ</u></label><br>
                                                                                            <input class="form-control dateen" placeholder="ลงข้อมูลเลือกวันที่และเวลา..."  title="วันที่และเวลาที่เกิดอุบัติเหตุ" style="height:40px; width:460px" id="txt_dayaccident" name="txt_dayaccident" value=""  min="" max=""  autocomplete="off">
                                                                                    </div>
                                                                                    <br><br><br><br>
                                                                                    <div class="col-lg-12">
                                                                                            <label ><u>สถานที่เกิดอุบัติเหตุ</u></label><br>
                                                                                            <input class="form-control" placeholder="ลงข้อมูลสถานที่เกิดอุบัติเหตุ..."  title="สถานที่เกิดอุบัติเหตุ" style="height:40px; width:460px" id="txt_locationaccident" name="txt_locationaccident" value=""  min="" max=""  autocomplete="off">
                                                                                    </div>
                                                                                    <br><br><br><br>
                                                                                    <div class="col-lg-12">
                                                                                            <label ><u>ปัญหาของอุบัติเหตุ</u></label><br>
                                                                                            <input class="form-control" placeholder="ลงข้อมูลปัญหาของอุบัติเหตุ..." title="ปัญหาของอุบัติเหตุ" style="height:40px; width:460px" id="txt_problemaccident" name="txt_problemaccident" value=""  min="" max=""  autocomplete="off">
                                                                                    </div>                                                                           
                                                                                    

                                                                                </div>

                                                                                <br><br>
                                                                                
                                                                        </div>
                                                                    </div>
                                                                    <br><br>  
                                                                    <div class = "row">
                                                                        <label ></label>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    
                                                    </div>
                                                <!-- END COLUNM1    -->
                                                <!-- START COLUNM2 -->
                                                <div class="col-lg-4" >
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" style="background-color: #f0c402;">
                                                            <label><font style="font-size: 16px">บันทึกสาเหตุของอุบัติเหตุ</font></label>
                                                        </div>
                                                        
                                                        <div class="panel-body">
                                                            <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                                <div class = "row">
                                                                    <div class="">
                                                                            <div class="form-group">
                                                                                <label >รายละเอียดสาเหตุของการเกิดอุบัติเหตุ</label><br><br>
                                                                                <div class="col-lg-12">
                                                                                        <label ><u>MAN (คน)</u></label><br>
                                                                                        <input class="form-control " placeholder="MAN (คน)..." style="height:40px; width:460px" id="txt_detailman" name="txt_detailman" value=""  min="" max=""  autocomplete="off">
                                                                                </div>
                                                                                <br><br><br><br>
                                                                                <div class="col-lg-12">
                                                                                        <label ><u>METHOD (อุปกรณ์/วิธีการทำงาน)</u></label><br>
                                                                                        <input class="form-control" placeholder="METHOD (อุปกรณ์/วิธีการทำงาน)..." style="height:40px; width:460px" id="txt_detailmethod" name="txt_detailmethod" value=""  min="" max=""  autocomplete="off">
                                                                                </div>
                                                                                <br><br><br><br>
                                                                                <div class="col-lg-12">
                                                                                        <label ><u>MECHINE (รถบรรทุก/เครื่องจักร)</u></label><br>
                                                                                        <input class="form-control" placeholder="MECHINE (รถบรรทุก/เครื่องจักร)..." style="height:40px; width:460px" id="txt_detailmechine" name="txt_detailmechine" value=""  min="" max=""  autocomplete="off">
                                                                                </div>                                                                           
                                                                                <br><br><br><br>
                                                                                <div class="col-lg-12">
                                                                                        <label ><u>ENVIRONMENT (สภาพแวดล้อม)</u></label><br>
                                                                                        <input class="form-control" placeholder="ENVIRONMENT (สภาพแวดล้อม)..." style="height:40px; width:460px" id="txt_detailenviroment" name="txt_detailenviroment" value=""  min="" max=""  autocomplete="off">
                                                                                </div>    

                                                                            </div>

                                                                            <br><br>
                                                                            
                                                                    </div>
                                                                </div>
                                                                <br><br>  
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
                                                        
                                                    </div>
                                                
                                                </div>
                                            <!-- END COLUNM2 -->  
                                            <!-- START COLUNM3 -->
                                                <div class="col-lg-4" >
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" style="background-color: #f0c402;">
                                                            <label><font style="font-size: 16px">หมายเหตุและประเภทของอุบัติเหตุ</font></label>
                                                        </div>
                                                        
                                                        <div class="panel-body">
                                                            <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                                <div class = "row">
                                                                    <div class="">
                                                                            <div class="form-group">
                                                                                <label >หมายเหตุ</label><br><br>
                                                                                <div class="col-lg-12">
                                                                                        <label ><u>หมายเหตุและประเภทของอุบัติเหตุ</u></label><br>
                                                                                        <input class="form-control " placeholder="ลงข้อมูลหมายเหตุ..." style="height:40px; width:460px" id="txt_remark" name="txt_remark" value=""  min="" max=""  autocomplete="off">
                                                                                </div>
                                                                                <br><br><br><br>
                                                                                <div class="col-lg-12">
                                                                                        <label ><u>ประเภทของอุบัติเหตุ <font style="color:red">*เช่น Accident,Incident,Part Damage,Drowzy,Driver,ThirdParty,MisOperation,Surrounding,MisRoute</font></u></label><br>
                                                                                        <select   id="txt_type" name="txt_type" class="selectpicker form-control" data-container="body" data-live-search="false" title="ประเภทของอุบัติเหตุ..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                            <option value =""  selected >- ประเภทของอุบัติเหตุ -</option>
                                                                                            <option value ="Accident">Accident Record</option>
                                                                                            <option value ="Incident">Incident Record</option>
                                                                                            <option value ="Drowzy">Drowzy</option>
                                                                                            <option value ="Driver">Driver</option>
                                                                                            <option value ="ThirdParty">ThirdParty</option>
                                                                                            <option value ="MisOperation">MisOperation</option>
                                                                                            <option value ="Surrounding">Surrounding</option>
                                                                                            <option value ="MisRoute">Mis-Route</option>
                                                                                        </select>
                                                                                </div>
                                                                                <br><br><br><br> 

                                                                            </div>

                                                                            <br><br>
                                                                            
                                                                    </div>
                                                                </div>
                                                                <br><br>  
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
                                                        
                                                    </div>
                                                
                                                </div>
                                            <!-- END COLUNM3 -->  
                                                <div  class="col-lg-12" style="text-align: center;">
                                                    <button type="button" class="button" name="myBtn" id ="myBtn"   onclick="save_accident();">บันทึกข้อมูลอุบัติเหตุ</button>
                                                </div>                                                  
                                                        <!-- /.panel-body -->
                                                    </div>
                                                </div>

                                                <!-- Simulator tap -->
                                                <div class="tab-pane fade" id="simulator">
                                                    <div class="row">

                                                        <input  class="form-control" type="hidden" id="txt_usernamesimu" name="txt_usernamesimu" value="<?=$_SESSION["USERNAME"]?>">
                                                        <div class="col-lg-2">
                                                            <label>เลือกพนักงาน:</label>
                                                            <div class="dropdown bootstrap-select show-tick form-control">
                                                                <!-- $emp = select_empautocomplate('megEmployeeEHR_v2', 'select_employeehealth', ""); -->
                                                                <select   id="txt_drivercodesearchsimu" name="txt_drivercodesearchsimu" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก พนักงาน..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
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
                                                                        <option value="<?= $result_seName['PersonCode'] ?>"><?= $result_seName['nameT'] ?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label>เลือกปีเริ่มต้น (ค้นหา)</label><br>   
                                                                <select   id="txt_yearsearchstartsimu" name="txt_yearsearchstartsimu" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก ปีเริ่มต้น..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                    <option value ="" disabled selected >- เลือกปี -</option>
                                                                    <?php
                                                                    for ($y = 1993; $y <= 2100; $y++) { ?>
                                                                    <option value ="<?=$y?>" <?=($_GET['YearsSelect']==$y? 'selected' : '')?> > <?=$y?> </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label>เลือกปีสิ้นสุด (ค้นหา)</label><br>   
                                                                <select   id="txt_yearsearchendsimu" name="txt_yearsearchendsimu" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก ปีสิ้นสุด..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                    <option value ="" disabled selected >- เลือกปี -</option>
                                                                    <?php
                                                                    for ($y = 1993; $y <= 2100; $y++) { ?>
                                                                    <option value ="<?=$y?>" <?=($_GET['YearsSelect']==$y? 'selected' : '')?> > <?=$y?> </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label>ค้นหาข้อมูล simulator</label><br>   
                                                                <input type="button"  name="" id=""onclick="search_simulator()" value="ค้นหาข้อมูล simulator" class="btn btn-primary">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label>Upload Simulator Data</label><br>   
                                                                <input type="button"  name="" id="" onclick="upload_excelsimulator()" data-toggle="modal" data-target="#myModal" value="Upload Simulator Data" class="btn btn-primary">
                                                            </div>
                                                        </div>               

                                                    </div>
                                                    <br>
                                                    <div class="col-lg-4" >
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading" style="background-color: #f0c402;">
                                                                <label><font style="font-size: 16px">DRIVING SIMULATOR</font></label>
                                                            </div>
                                                            
                                                            <div class="panel-body">
                                                                <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                                    <div class = "row">
                                                                        <div class="">
                                                                                <div class="form-group">
                                                                                    <!-- <label ><b><u><font style="color:red">เกณฑ์การประเมิน : มากกว่า 3 หรือ เท่ากับ 3 คือ ผ่านการประเมิน</font></u></b></label><br><br> -->
                                                                                    <div class="col-lg-12">
                                                                                            <label ><u>พนักงานขับรถ (บันทึกข้อมูล)</u></label><br>
                                                                                            <div class="dropdown bootstrap-select show-tick form-control">
                                                                                                <select   id="txt_drivercodeinsertsimu" name="txt_drivercodeinsertsimu" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก พนักงาน..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                                    <?php
                                                                                                    $sql_seName = "{call megEmployeeEHR_v2(?,?)}";
                                                                                                    $params_seName = array(
                                                                                                        array('select_employeehealth', SQLSRV_PARAM_IN),
                                                                                                        array('', SQLSRV_PARAM_IN)
                                                                                                    );
                                                                                                    $query_seName = sqlsrv_query($conn, $sql_seName, $params_seName);
                                                                                                    while ($result_seName = sqlsrv_fetch_array($query_seName, SQLSRV_FETCH_ASSOC)) {
                                                                                                        ?>
                                                                                                        <option value="<?= $result_seName['PersonCode'] ?>"><?= $result_seName['nameT'] ?></option>
                                                                                                        <?php
                                                                                                    }
                                                                                                    ?>
                                                                                                </select>
                                                                                            </div>
                                                                                    </div>
                                                                                    <br><br><br><br>
                                                                                    <div class="col-lg-12">
                                                                                        <div class="form-group">
                                                                                            <label>เลือกปี (บันทึกข้อมูล)</label><br>   
                                                                                            <select   id="txt_selectyearsinsertsimu" name="txt_selectyearsinsertsimu" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก ปี..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                                <option value ="" disabled selected >- เลือกปี -</option>
                                                                                                <?php
                                                                                                for ($y = 1993; $y <= 2100; $y++) { ?>
                                                                                                <option value ="<?=$y?>" <?=($_GET['YearsSelect']==$y? 'selected' : '')?> > <?=$y?> </option>
                                                                                                <?php } ?>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <br><br><br><br>
                                                                                    <div class="col-lg-12">
                                                                                            <label ><u>ผ่าน TLEP ครั้งแรก</u></label><br>
                                                                                            <input class="form-control dateensimu" placeholder="ลงข้อมูลวันที่ TLEP ครั้งแรก..." style="height:40px; width:460px" id="txt_tlepfirstpass" name="txt_tlepfirstpass" value=""  min="" max=""  autocomplete="off">
                                                                                    </div>
                                                                                    <br><br><br><br>
                                                                                    <div class="col-lg-12">
                                                                                            <label ><u>ผ่าน TLEP ล่าสุด</u></label><br>
                                                                                            <input class="form-control dateensimu" placeholder="ลงข้อมูลวันที่ TLEP ล่าสุด..." style="height:40px; width:460px" id="txt_tleppass" name="txt_tleppass" value=""  min="" max=""  autocomplete="off">
                                                                                    </div>
                                                                                    <br><br><br><br>
                                                                                    <br><br><br>

                                                                                </div>

                                                                                <!-- <br><br> -->
                                                                                
                                                                        </div>
                                                                    </div>
                                                                    <!-- <br><br>   -->
                                                                    <div class = "row">
                                                                        <label ></label>
                                                                    </div>
                                                                    <div class = "row">
                                                                        <label ></label>
                                                                    </div>
                                                                    <!-- <div class = "row">
                                                                        <label ></label>
                                                                    </div> -->
                                                                    
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    
                                                    </div>     
                                                    <div class="col-lg-4" >
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading" style="background-color: #f0c402;">
                                                                <label><font style="font-size: 16px">SIMULATOR DATA</font></label>
                                                            </div>
                                                            
                                                            <div class="panel-body">
                                                                <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                                    <div class = "row">
                                                                        <div class="">
                                                                                <div class="form-group">
                                                                                    <!-- <label ><b><u><font style="color:red">เกณฑ์การประเมิน : มากกว่า 3 หรือ เท่ากับ 3 คือ ผ่านการประเมิน</font></u></b></label><br><br> -->
                                                                                
                                                                                    <div class="col-lg-12">
                                                                                            <label ><u>ลงข้อมูลจุดอ่อนข้อที่ 1</u></label><br>
                                                                                            <input class="form-control "  placeholder="ลงข้อมูลจุดอ่อนข้อที่ 1..." style="height:40px; width:460px" id="txt_simudata1" name="txt_simudata1" value=""  min="" max=""  autocomplete="off">
                                                                                    </div>
                                                                                    <br><br><br><br><br>
                                                                                    <div class="col-lg-12">
                                                                                            <label ><u>ลงข้อมูลจุดอ่อนข้อที่ 2</u></label><br>
                                                                                            <input class="form-control "  placeholder="ลงข้อมูลจุดอ่อนข้อที่ 2..." style="height:40px; width:460px" id="txt_simudata2" name="txt_simudata2" value=""  min="" max=""  autocomplete="off">
                                                                                    </div>
                                                                                    <br><br><br><br><br>
                                                                                    <div class="col-lg-12">
                                                                                            <label ><u>ลงข้อมูลจุดอ่อนข้อที่ 3</u></label><br>
                                                                                            <input class="form-control "  placeholder="ลงข้อมูลจุดอ่อนข้อที่ 3..." style="height:40px; width:460px" id="txt_simudata3" name="txt_simudata3" value=""  min="" max=""  autocomplete="off">
                                                                                    </div>
                                                                                    <br><br><br><br><br>
                                                                                    <div class="col-lg-12">
                                                                                            <label ><u>ลงข้อมูลสวมแว่นสายตา</u></label><br>
                                                                                            <select   id="txt_tlepwearglasses" name="txt_tlepwearglasses" class="selectpicker form-control" data-container="body" data-live-search="false" title="เลือกข้อมูล..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                                <option value ="" disabled selected >- เลือกข้อมูล -</option>
                                                                                                <option value ="1"  >สวมแว่น</option>
                                                                                                <option value ="0"  >ไม่สวมแว่น</option>
                                                                                            </select>
                                                                                    </div>
                                                                                    <br><br><br><br>
                                                                                </div>

                                                                                <!-- <br><br> -->
                                                                                
                                                                        </div>
                                                                    </div>
                                                                    <!-- <br><br>   -->
                                                                    <div class = "row">
                                                                        <label ></label>
                                                                    </div>
                                                                    <div class = "row">
                                                                        <label ></label>
                                                                    </div>
                                                                    <!-- <div class = "row">
                                                                        <label ></label>
                                                                    </div> -->
                                                                    
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    
                                                    </div>                                         
                                                    <div  class="col-lg-12" style="text-align: center;">
                                                        <button type="button" class="button" name="myBtn" id ="myBtn"   onclick="save_simulator();">บันทึกข้อมูล SIMULATOR</button>
                                                    </div> 
                                                    
                                                </div>
                                                <!-- END TAP SIMULATOR-->
                                                
                                                <!-- Feedback Driver Tap -->
                                                <div class="tab-pane fade" id="feedbackdriver">
                                                    <div class="row">

                                                        <input  class="form-control" type="hidden" id="txt_usernamefeedback" name="txt_usernamefeedback" value="<?=$_SESSION["USERNAME"]?>">
                                                        <div class="col-lg-2">
                                                            <label>เลือกพนักงาน:</label>
                                                            <div class="dropdown bootstrap-select show-tick form-control">
                                                                <!-- $emp = select_empautocomplate('megEmployeeEHR_v2', 'select_employeehealth', ""); -->
                                                                <select   id="txt_drivercodesearchfeedback" name="txt_drivercodesearchfeedback" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก พนักงาน..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
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
                                                                        <option value="<?= $result_seName['PersonCode'] ?>"><?= $result_seName['nameT'] ?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label>เลือกปีเริ่มต้น (ค้นหา)</label><br>   
                                                                <select   id="txt_yearsearchstartfeedback" name="txt_yearsearchstartfeedback" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก ปีเริ่มต้น..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                    <option value ="" disabled selected >- เลือกปี -</option>
                                                                    <?php
                                                                    for ($y = 1993; $y <= 2100; $y++) { ?>
                                                                    <option value ="<?=$y?>" <?=($_GET['YearsSelect']==$y? 'selected' : '')?> > <?=$y?> </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label>เลือกปีสิ้นสุด (ค้นหา)</label><br>   
                                                                <select   id="txt_yearsearchendfeedback" name="txt_yearsearchendfeedback" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก ปีสิ้นสุด..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                    <option value ="" disabled selected >- เลือกปี -</option>
                                                                    <?php
                                                                    for ($y = 1993; $y <= 2100; $y++) { ?>
                                                                    <option value ="<?=$y?>" <?=($_GET['YearsSelect']==$y? 'selected' : '')?> > <?=$y?> </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label>เลือกพื้นที่(ค้นหา)</label><br>   
                                                                <select   id="txt_areasearchfeedback" name="txt_areasearchfeedback" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก พื้นที่..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                    <option value =""     selected >- เลือกพื้นที่ -</option>
                                                                    <option value ="amt"   >AMT</option>
                                                                    <option value ="gw"    >GW</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label>ค้นหาข้อมูล TruckCameraCheck</label><br>   
                                                                <input type="button"  name="" id=""onclick="search_truckcameracheck()" value="ค้นหาข้อมูล TruckCameraCheck" class="btn btn-primary">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label>ค้นหาข้อมูล WorkingIssue</label><br>   
                                                                <input type="button"  name="" id=""onclick="search_workingissue()" value="ค้นหาข้อมูล WorkingIssue" class="btn btn-primary">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label>ค้นหาข้อมูล SafetyFocusTheme</label><br>   
                                                                <input type="button"  name="" id=""onclick="search_safetyfocustheme()" value="ค้นหาข้อมูล SafetyFocusTheme" class="btn btn-primary">
                                                            </div>
                                                        </div> -->
                                                        <!-- <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label>Upload Simulator Data</label><br>   
                                                                <input type="button"  name="" id="" onclick="upload_excelsimulator()" data-toggle="modal" data-target="#myModal" value="Upload Simulator Data" class="btn btn-primary">
                                                            </div>
                                                        </div>                -->

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label>ค้นหาข้อมูล TruckCameraCheck</label><br>   
                                                                <input type="button"  name="" id=""onclick="search_truckcameracheck()" value="ค้นหาข้อมูล TruckCameraCheck" class="btn btn-primary">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label>ค้นหาข้อมูล WorkingIssue</label><br>   
                                                                <input type="button"  name="" id=""onclick="search_workingissue()" value="ค้นหาข้อมูล WorkingIssue" class="btn btn-primary">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label>ค้นหาข้อมูล SafetyFocusTheme</label><br>   
                                                                <input type="button"  name="" id=""onclick="search_safetyfocustheme()" value="ค้นหาข้อมูล SafetyFocusTheme" class="btn btn-primary">
                                                            </div>
                                                        </div>
                                                        <!-- <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label>Upload Simulator Data</label><br>   
                                                                <input type="button"  name="" id="" onclick="upload_excelsimulator()" data-toggle="modal" data-target="#myModal" value="Upload Simulator Data" class="btn btn-primary">
                                                            </div>
                                                        </div>                -->

                                                    </div>
                                                    <br>

                                                    <!-- เพิ่มข้อมูล Truck Camera Check -->
                                                    <div class="col-lg-4" >
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading" style="background-color: #f0c402;">
                                                                <label><font style="font-size: 16px">Truck Camera Check</font></label>
                                                            </div>
                                                            
                                                            <div class="panel-body">
                                                                <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                                    <div class = "row">
                                                                        <div class="">
                                                                                <div class="form-group">
                                                                                    <!-- <label ><b><u><font style="color:red">เกณฑ์การประเมิน : มากกว่า 3 หรือ เท่ากับ 3 คือ ผ่านการประเมิน</font></u></b></label><br><br> -->
                                                                                    <div class="col-lg-12">
                                                                                            <label ><u>พนักงานขับรถ (บันทึกข้อมูล)</u></label><br>
                                                                                            <div class="dropdown bootstrap-select show-tick form-control">
                                                                                                <select   id="txt_drivertruckcamera" name="txt_drivertruckcamera" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก พนักงาน..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                                    <?php
                                                                                                    $sql_seName = "{call megEmployeeEHR_v2(?,?)}";
                                                                                                    $params_seName = array(
                                                                                                        array('select_employeehealth', SQLSRV_PARAM_IN),
                                                                                                        array('', SQLSRV_PARAM_IN)
                                                                                                    );
                                                                                                    $query_seName = sqlsrv_query($conn, $sql_seName, $params_seName);
                                                                                                    while ($result_seName = sqlsrv_fetch_array($query_seName, SQLSRV_FETCH_ASSOC)) {
                                                                                                        ?>
                                                                                                        <option value="<?= $result_seName['PersonCode'] ?>"><?= $result_seName['nameT'] ?></option>
                                                                                                        <?php
                                                                                                    }
                                                                                                    ?>
                                                                                                </select>
                                                                                            </div>
                                                                                    </div>
                                                                                    <br><br><br><br>
                                                                                    <div class="col-lg-12">
                                                                                        <div class="form-group">
                                                                                            <label>เลือกปี (บันทึกข้อมูล)</label><br>   
                                                                                            <select   id="txt_selectyearstruckcamera" name="txt_selectyearstruckcamera" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก ปี..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                                <option value ="" disabled selected >- เลือกปี -</option>
                                                                                                <?php
                                                                                                for ($y = 1993; $y <= 2100; $y++) { ?>
                                                                                                <option value ="<?=$y?>" <?=($_GET['YearsSelect']==$y? 'selected' : '')?> > <?=$y?> </option>
                                                                                                <?php } ?>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <br><br><br><br>
                                                                                    <div class="col-lg-12">
                                                                                            <label ><u>วันที่ที่ทำการตรวจสอบ</u></label><br>
                                                                                            <input class="form-control dateensimu" placeholder="ลงข้อมูลวันที่ที่ทำการตรวจสอบ" style="height:40px; width:460px" id="txt_datetruckcamera" name="txt_datetruckcamera" value=""  min="" max=""  autocomplete="off">
                                                                                    </div>
                                                                                    <br><br><br><br>
                                                                                    <div class="col-lg-12">
                                                                                            <label ><u>Truck Camera Check</u></label><br>
                                                                                            <input class="form-control "  placeholder="ลงข้อมูล Truck Camera Check..." style="height:40px; width:460px" id="txt_datatruckcamera" name="txt_datatruckcamera" value=""  min="" max=""  autocomplete="off">
                                                                                    </div>
                                                                                    <br><br><br><br><br>
                                                                                    <br><br>

                                                                                </div>

                                                                                <!-- <br><br> -->
                                                                                
                                                                        </div>
                                                                    </div>
                                                                    <!-- <br><br>   -->
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
                                                                    <!-- <div class = "row">
                                                                        <label ></label>
                                                                    </div> -->
                                                                    
                                                                </div>
                                                            </div>
                                                            
                                                        </div>

                                                        <div  class="col-lg-12" style="text-align: left;">
                                                            <button type="button" class="button" name="myBtn" id ="myBtn"   onclick="save_truckcameracheck();">บันทึกข้อมูล TRUCK CAMERA</button>
                                                        </div>                                           
                                                    </div>
                                                    <!-- เพิ่มข้อมูลการทำงาน -->
                                                    <div class="col-lg-4" >
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading" style="background-color: #f0c402;">
                                                                <label><font style="font-size: 16px">Working Issue</font></label>
                                                            </div>
                                                            
                                                            <div class="panel-body">
                                                                <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                                    <div class = "row">
                                                                        <div class="">
                                                                                <div class="form-group">
                                                                                    <!-- <label ><b><u><font style="color:red">เกณฑ์การประเมิน : มากกว่า 3 หรือ เท่ากับ 3 คือ ผ่านการประเมิน</font></u></b></label><br><br> -->
                                                                                    <div class="col-lg-12">
                                                                                            <label ><u>พนักงานขับรถ (บันทึกข้อมูล)</u></label><br>
                                                                                            <div class="dropdown bootstrap-select show-tick form-control">
                                                                                                <select   id="txt_driverworkingissue" name="txt_driverworkingissue" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก พนักงาน..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                                    <?php
                                                                                                    $sql_seName = "{call megEmployeeEHR_v2(?,?)}";
                                                                                                    $params_seName = array(
                                                                                                        array('select_employeehealth', SQLSRV_PARAM_IN),
                                                                                                        array('', SQLSRV_PARAM_IN)
                                                                                                    );
                                                                                                    $query_seName = sqlsrv_query($conn, $sql_seName, $params_seName);
                                                                                                    while ($result_seName = sqlsrv_fetch_array($query_seName, SQLSRV_FETCH_ASSOC)) {
                                                                                                        ?>
                                                                                                        <option value="<?= $result_seName['PersonCode'] ?>"><?= $result_seName['nameT'] ?></option>
                                                                                                        <?php
                                                                                                    }
                                                                                                    ?>
                                                                                                </select>
                                                                                            </div>
                                                                                    </div>
                                                                                    <br><br><br><br>
                                                                                    <div class="col-lg-12">
                                                                                        <div class="form-group">
                                                                                            <label>เลือกปี (บันทึกข้อมูล)</label><br>   
                                                                                            <select   id="txt_selectyearsworkingissue" name="txt_selectyearsworkingissue" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก ปี..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                                <option value ="" disabled selected >- เลือกปี -</option>
                                                                                                <?php
                                                                                                for ($y = 1993; $y <= 2100; $y++) { ?>
                                                                                                <option value ="<?=$y?>" <?=($_GET['YearsSelect']==$y? 'selected' : '')?> > <?=$y?> </option>
                                                                                                <?php } ?>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <br><br><br><br>
                                                                                    <div class="col-lg-12">
                                                                                            <label ><u>วันที่ที่ทำการตรวจสอบ</u></label><br>
                                                                                            <input class="form-control dateensimu" placeholder="ลงข้อมูลวันที่ที่ทำการตรวจสอบ" style="height:40px; width:460px" id="txt_dateworkingissue" name="txt_dateworkingissue" value=""  min="" max=""  autocomplete="off">
                                                                                    </div>
                                                                                    <br><br><br><br>
                                                                                    <div class="col-lg-12">
                                                                                            <label ><u>Working Issue</u></label><br>
                                                                                            <input class="form-control"  placeholder="ลงข้อมูล Working Issue..." style="height:40px; width:460px" id="txt_dataworkingissue" name="txt_dataworkingissue" value=""  min="" max=""  autocomplete="off">
                                                                                    </div>
                                                                                    <br><br><br><br><br>
                                                                                    <br><br>

                                                                                </div>

                                                                                <!-- <br><br> -->
                                                                                
                                                                        </div>
                                                                    </div>
                                                                    <!-- <br><br>   -->
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
                                                                    <!-- <div class = "row">
                                                                        <label ></label>
                                                                    </div> -->
                                                                    
                                                                </div>
                                                            </div>
                                                            
                                                        </div>

                                                        <div  class="col-lg-12" style="text-align: left;">
                                                            <button type="button" class="button" name="myBtn" id ="myBtn"   onclick="save_workingissue();">บันทึกข้อมูล WORKING ISSUE</button>
                                                        </div>                                           
                                                    </div>
                                                    <!-- เพิ่มข้อมูล Safety Focus Theme -->
                                                    <div class="col-lg-4" >
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading" style="background-color: #f0c402;">
                                                                <label><font style="font-size: 16px">Safety Focus Theme(Insert Data)</font></label>
                                                            </div>
                                                            
                                                            <div class="panel-body">
                                                                <div class="alert alert-info"  style="background-color: #ffffff;border-color:#ddd;color: #333;border: 0px solid transparent;">
                                                                    <div class = "row">
                                                                        <div class="">
                                                                                <div class="form-group">
                                                                                    <!-- <label ><b><u><font style="color:red">เกณฑ์การประเมิน : มากกว่า 3 หรือ เท่ากับ 3 คือ ผ่านการประเมิน</font></u></b></label><br><br> -->
                                                                                    <div class="col-lg-12">
                                                                                            <label ><u>เลือกเดือน</u></label><br>
                                                                                            <div class="dropdown bootstrap-select show-tick form-control">
                                                                                                <select   id="txt_monthth" name="txt_monthth" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก เดือน..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                                    <!-- <option value="">เลือกเดือน</option> -->
                                                                                                    <option value="มกราคม">มกราคม</option>
                                                                                                    <option value="กุมภาพันธ์">กุมภาพันธ์</option>
                                                                                                    <option value="มีนาคม">มีนาคม</option>
                                                                                                    <option value="เมษายน">เมษายน</option>
                                                                                                    <option value="พฤษภาคม">พฤษภาคม</option>
                                                                                                    <option value="มิถุนายน">มิถุนายน</option>
                                                                                                    <option value="กรกฎาคม">กรกฎาคม</option>
                                                                                                    <option value="สิงหาคม">สิงหาคม</option>
                                                                                                    <option value="กันยายน">กันยายน</option>
                                                                                                    <option value="ตุลาคม">ตุลาคม</option>
                                                                                                    <option value="พฤศจิกายน">พฤศจิกายน</option>
                                                                                                    <option value="ธันวาคม">ธันวาคม</option>
                                                                                                </select>
                                                                                            </div>
                                                                                    </div>
                                                                                    <br><br><br><br>
                                                                                    <div class="col-lg-12">
                                                                                        <div class="form-group">
                                                                                            <label>เลือกปี (บันทึกข้อมูล)</label><br>   
                                                                                            <select   id="txt_selectyearsfocustheme" name="txt_selectyearsfocustheme" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก ปี..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                                <option value ="" disabled selected >- เลือกปี -</option>
                                                                                                <?php
                                                                                                for ($y = 1993; $y <= 2100; $y++) { ?>
                                                                                                <option value ="<?=$y?>" <?=($_GET['YearsSelect']==$y? 'selected' : '')?> > <?=$y?> </option>
                                                                                                <?php } ?>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <br><br><br><br>
                                                                                    <div class="col-lg-12">
                                                                                        <div class="form-group">
                                                                                            <label>เลือกพื้นที่</label><br>   
                                                                                            <select   id="txt_selectareafocustheme" name="txt_selectareafocustheme" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก ปี..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                                                                <option value =""  selected >- เลือกพื้นที่ -</option>
                                                                                                <option value ="gw"   >GW</option>
                                                                                                <option value ="amt"  >AMT</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <br><br><br><br>
                                                                                    <div class="col-lg-12">
                                                                                            <label ><u>Safety Focus Theme</u></label><br>
                                                                                            <input class="form-control "  placeholder="ลงข้อมูล Safety Focus Theme..." style="height:40px; width:450px" id="txt_safetyfocustheme" name="txt_safetyfocustheme" value=""  min="" max=""  autocomplete="off">
                                                                                    </div>
                                                                                    <br><br>

                                                                                </div>
                                                                                <br><br><br><br><br><br><br><br>
                                                                                <!-- <br><br> -->
                                                                                
                                                                        </div>
                                                                    </div>
                                                                    <!-- <br><br>   -->
                                                                    <div class = "row">
                                                                        <label ></label>
                                                                    </div>
                                                                    <!-- <div class = "row">
                                                                        <label ></label>
                                                                    </div> -->
                                                                    <!-- <div class = "row">
                                                                        <label ></label>
                                                                    </div> -->
                                                                    <!-- <div class = "row">
                                                                        <label ></label>
                                                                    </div> -->
                                                                    <!-- <div class = "row">
                                                                        <label ></label>
                                                                    </div> -->
                                                                    
                                                                </div>
                                                            </div>
                                                            
                                                        </div>

                                                        <div  class="col-lg-12" style="text-align: left;">
                                                            <button type="button" class="button" name="myBtn" id ="myBtn"   onclick="save_safetyfocustheme();">บันทึกข้อมูล SAFETY FOCUS THEME</button>
                                                        </div>                                           
                                                    </div>
                                                    <!-- ตารางแสดงข้อมูล -->
                                                    <!-- <div class="col-lg-4" >
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading" style="background-color: #f0c402;">
                                                                <label><font style="font-size: 16px">Safety Focus Theme(Show Data & Update Data)</font></label>
                                                            </div>
                                                            
                                                            <div class="panel-body">
                                                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                                    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>MONTH</th>
                                                                                <th>YEAR</th>
                                                                                <th>SAFETYDATA</th>
                                                                                
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <?php

                                                                        $sql_seData = "SELECT SAFETYID,MONTHTH,MONTHENG,YEARTHEME,SAFETYDATA FROM SAFETYFOCUSTHEME";
                                                                        $params_seData  = array(
                                                                            array('select_employeeehr2', SQLSRV_PARAM_IN),
                                                                            array('', SQLSRV_PARAM_IN)
                                                                        );
                                                                        $query_seData = sqlsrv_query($conn, $sql_seData, $params_seData);
                                                                        while ($result_seData = sqlsrv_fetch_array($query_seData, SQLSRV_FETCH_ASSOC)) {
                                                                            ?>
                                                                                <tr class="odd gradeX">
                                                                                    <td><input class="form-control" placeholder="แก้ไขเดือนภาษาไทย"  style="height:40px; width:100px" title="แก้ไขเดือนภาษาไทย" onchange="edit_safetytheme(this.value, 'MONTHTHAI', '<?=$result_seData['SAFETYID']?>')"   id="txt_dayaccident" name="txt_dayaccident" value="<?= $result_seData['MONTHTH'] ?>"  min="" max=""  autocomplete="off"></td>
                                                                                    <td><input class="form-control" placeholder="แก้ไขปี ค.ศ."       style="height:40px; width:100px" title="แก้ไขปี ค.ศ." onchange="edit_safetytheme(this.value, 'YEARTHEME', '<?=$result_seData['SAFETYID']?>')"   id="txt_dayaccident" name="txt_dayaccident" value="<?= $result_seData['YEARTHEME'] ?>"  min="" max=""  autocomplete="off"></td>
                                                                                    <td><input class="form-control" placeholder="แก้ไขเดือนภาษาไทย"  style="height:40px; width:200px" title="แก้ไขเดือนภาษาไทย" onchange="edit_safetytheme(this.value, 'SAFETYDATA', '<?=$result_seData['SAFETYID']?>')"   id="txt_dayaccident" name="txt_dayaccident" value="<?= $result_seData['SAFETYDATA'] ?>"  min="" max=""  autocomplete="off"></td> 
                                                                                    
                                                                                    
                                                                                    
                                                                                </tr>

                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                
                                                            </div>
                                                            
                                                        </div>
                                                    
                                                    </div>                                                 -->
                                                    
                                                    
                                                </div>
                                                <!-- END TAP FEEDBACK DRIVER-->

                                                

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
            <!-- <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script> -->
            <!-- <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script> -->
            <!-- <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script> -->
            <script src="../dist/js/sb-admin-2.js"></script>
            <script src="../js/jquery.datetimepicker.full.js"></script>

            <!-- <script src="../dist/js/jszip.min.js"></script> -->
            <!-- <script src="../dist/js/dataTables.buttons.min.js"></script> -->
            <!-- <script src="../dist/js/buttons.html5.min.js"></script> -->
            <!-- <script src="../dist/js/buttons.print.min.js"></script> -->
            <script src="../dist/js/bootstrap-select.js"></script>
            <script src="../dist/js/jquery.autocomplete.js"></script>  
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>

    </body>
    
                                                                                                    


            <script type="text/javascript"> 
                                                                                                 
            function search_accident(){

            var drivername = document.getElementById('txt_drivernamesearch').value;
            var yearstart = document.getElementById('txt_yearsearchstart').value;
            var yearend = document.getElementById('txt_yearsearchend').value;
            
            if (drivername == ''){
                // alert('กรุณาเลือกชื่อพนักงาน!!!');
                swal.fire({
                    title: "warning",
                    text: "กรุณาเลือกชื่อพนักงาน !!!",
                    icon: "warning",
                });
            }else if (yearstart == ''){
                // alert('กรุณาเลือกปีเริ่มต้น !!!');
                swal.fire({
                    title: "warning",
                    text: "กรุณาเลือกปีเริ่มต้น !!!",
                    icon: "warning",
                });
            }else if (yearend == ''){
                // alert('กรุณาเลือกปีสิ้นสุด !!!');
                swal.fire({
                    title: "warning",
                    text: "กรุณาเลือกปีสิ้นสุด !!!",
                    icon: "warning",
                });
            }else{
                window.open('report_accidenthhistory.php?employeecode=' + drivername+'&yearstart='+yearstart+'&yearend='+yearend, '_blank');
            }

            // window.open('report_accidenthhistory.php?employeecode=' + drivername+'&yearstart='+yearstart+'&yearend='+yearend, '_blank');

            }
            function search_simulator(){

            var drivername = document.getElementById('txt_drivercodesearchsimu').value;
            var yearstart = document.getElementById('txt_yearsearchstartsimu').value;
            var yearend = document.getElementById('txt_yearsearchendsimu').value;
            
            if (drivername == ''){
                // alert('กรุณาเลือกชื่อพนักงาน!!!');
                swal.fire({
                    title: "warning",
                    text: "กรุณาเลือกชื่อพนักงาน !!!",
                    icon: "warning",
                });
            }else if (yearstart == ''){
                // alert('กรุณาเลือกปีเริ่มต้น !!!');
                swal.fire({
                    title: "warning",
                    text: "กรุณาเลือกปีเริ่มต้น !!!",
                    icon: "warning",
                });
            }else if (yearend == ''){
                // alert('กรุณาเลือกปีสิ้นสุด !!!');
                swal.fire({
                    title: "warning",
                    text: "กรุณาเลือกปีสิ้นสุด !!!",
                    icon: "warning",
                });
            }else{
                window.open('report_simulatorhistory.php?employeecode=' + drivername+'&yearstart='+yearstart+'&yearend='+yearend, '_blank');
            }
            // window.open('report_simulatorhistory.php?employeecode=' + drivername+'&yearstart='+yearstart+'&yearend='+yearend, '_blank');

            }
            function upload_excelaccident(){

            var type = 'Upload';
            var file = 'Excel';

            window.open('meg_insertaccidentdata.php?type='+type+ '&file='+file, '_blank');

            }
            function upload_excelsimulator(){

            var type = 'Upload Simulator ';
            var file = 'Excel';

            window.open('meg_insertsimulatordata.php?type='+type+ '&file='+file, '_blank');

            }
            function save_accident() //save สำหรับ change สีการนอน
            {

                // alert(chkstatus);
                // alert(checkClient);

                var drivername = document.getElementById('txt_drivernameinsert').value;
                var years  = document.getElementById('txt_selectyearsinsert').value;
                var datetimeacci = document.getElementById('txt_dayaccident').value;
                var locationacci = document.getElementById('txt_locationaccident').value;
                var problemacci  = document.getElementById('txt_problemaccident').value;
                var detailman    = document.getElementById('txt_detailman').value;
                var detailmethod = document.getElementById('txt_detailmethod').value;
                var detailmechine    = document.getElementById('txt_detailmechine').value;
                var detailenvironment = document.getElementById('txt_detailenviroment').value;
                var remark = document.getElementById('txt_remark').value;
                var type = document.getElementById('txt_type').value;
                var createby = document.getElementById('txt_username').value;
                // alert(datejobstart);
                // alert(timejobstart);
                // alert(sessionid);
                // เช็คการลงข้อมูลคอลัมย์ที่1

                if(drivername == '' || years == '' || datetimeacci == '' || locationacci == '' || problemacci == '' 
                || detailman == '' || detailmethod == '' || detailmechine == '' || detailenvironment == ''
                || remark == '' || type == ''){
                
                    swal.fire({
                        title: "warning",
                        text: "กรุณาลงข้อมูลให้ครบถ้วนก่อนบันทึก !!!",
                        icon: "warning",
                    });

                  

                }else{

                    $.ajax({
                        type: 'post',
                        url: 'meg_data2.php',
                        data: {

                        txt_flg: "save_accident",
                        id:'', 
                        drivername: drivername,
                        years: years, 
                        datetimeacci: datetimeacci,
                        locationacci: locationacci,
                        problemacci: problemacci,
                        detailman: detailman,
                        detailmethod: detailmethod,
                        detailmechine: detailmechine,
                        detailenvironment: detailenvironment,
                        remark: remark,
                        type: type,
                        createby: createby


                        },
                            success: function (rs) {

                            alert("บันทึกข้อมูลเรียบร้อย");
                            // // alert(rs);    
                            window.location.reload();
                        }
                    });
                }


                

            }         

            function search_truckcameracheck(){

                var drivercode = document.getElementById('txt_drivercodesearchfeedback').value;
                var yearstart = document.getElementById('txt_yearsearchstartfeedback').value;
                var yearend = document.getElementById('txt_yearsearchendfeedback').value;

                if (drivercode == '') {
                    // alert('กรุณาเลือกพนักงาน !!!');
                    swal.fire({
                        title: "warning",
                        text: "กรุณาเลือกพนักงาน !!!",
                        icon: "warning",
                    });
                }else if (yearstart == ''){
                    // alert('กรุณาเลือกปีเริ่มต้น!!!');
                    swal.fire({
                        title: "warning",
                        text: "กรุณาเลือกปีเริ่มต้น !!!",
                        icon: "warning",
                    });
                }else if (yearend == ''){
                    // alert('กรุณาเลือกปีสิ้นสุด !!!');
                    swal.fire({
                        title: "warning",
                        text: "กรุณาเลือกปีสิ้นสุด !!!",
                        icon: "warning",
                    });
                }else{
                    window.open('report_truckcameracheck.php?employeecode=' + drivercode+'&yearstart='+yearstart+'&yearend='+yearend, '_blank');
                }
                

            }
            function search_workingissue(){

                var drivercode = document.getElementById('txt_drivercodesearchfeedback').value;
                var yearstart = document.getElementById('txt_yearsearchstartfeedback').value;
                var yearend = document.getElementById('txt_yearsearchendfeedback').value;

                if (drivercode == '') {
                    // alert('กรุณาเลือกพนักงาน !!!');
                    swal.fire({
                        title: "warning",
                        text: "กรุณาเลือกพนักงาน !!!",
                        icon: "warning",
                    });
                }else if (yearstart == ''){
                    // alert('กรุณาเลือกปีเริ่มต้น!!!');
                    swal.fire({
                        title: "warning",
                        text: "กรุณาเลือกปีเริ่มต้น !!!",
                        icon: "warning",
                    });
                }else if (yearend == ''){
                    // alert('กรุณาเลือกปีสิ้นสุด !!!');
                    swal.fire({
                        title: "warning",
                        text: "กรุณาเลือกปีสิ้นสุด !!!",
                        icon: "warning",
                    });
                }else{
                    window.open('report_workingissue.php?employeecode=' + drivercode+'&yearstart='+yearstart+'&yearend='+yearend, '_blank');
                }

                

            }
            function search_safetyfocustheme(){

                // var drivercode = document.getElementById('txt_drivercodesearchsimu').value;
                var yearstart = document.getElementById('txt_yearsearchstartfeedback').value;
                var yearend = document.getElementById('txt_yearsearchendfeedback').value;
                var area = document.getElementById('txt_areasearchfeedback').value;

                if (yearstart == ''){
                    // alert('กรุณาเลือกปีเริ่มต้น!!!');
                    swal.fire({
                        title: "warning",
                        text: "กรุณาเลือกปีเริ่มต้น !!!",
                        icon: "warning",
                    });
                }else if (yearend == ''){
                    // alert('กรุณาเลือกปีสิ้นสุด !!!');
                    swal.fire({
                        title: "warning",
                        text: "กรุณาเลือกปีสิ้นสุด !!!",
                        icon: "warning",
                    });
                }else if (area == ''){
                    // alert('กรุณาเลือกพื้นที่ !!!');
                    swal.fire({
                        title: "warning",
                        text: "กรุณาเลือกพื้นที่ !!!",
                        icon: "warning",
                    });
                }else{
                    window.open('report_safetyfocustheme.php?yearstart='+yearstart+'&yearend='+yearend+'&area='+area, '_blank');
                }

                

            }

            function save_simulator() //save สำหรับ change สีการนอน
            {

                // alert(chkstatus);
                // alert(checkClient);

                var drivercode = document.getElementById('txt_drivercodeinsertsimu').value;
                var yearssimu  = document.getElementById('txt_selectyearsinsertsimu').value;
                var tlepfirstpass = document.getElementById('txt_tlepfirstpass').value;
                var tleppass = document.getElementById('txt_tleppass').value;
                var simudata1 = document.getElementById('txt_simudata1').value;
                var simudata2 = document.getElementById('txt_simudata2').value;
                var simudata3 = document.getElementById('txt_simudata3').value;
                var tlepwearglasses = document.getElementById('txt_tlepwearglasses').value;
                var createby = document.getElementById('txt_usernamesimu').value;
                
                // alert(createby);
                // alert(timejobstart);
                // alert(sessionid);
                // เช็คการลงข้อมูลคอลัมย์ที่1

                if(drivercode == '' || yearssimu == '' || tlepfirstpass == '' || tleppass == '' 
                || simudata1  == '' || simudata2 == '' || simudata3 == '' || tlepwearglasses == ''){
                
                    swal.fire({
                        title: "warning",
                        text: "กรุณาลงข้อมูลให้ครบถ้วนก่อนบันทึก !!!",
                        icon: "warning",
                    });

                }else{
                    $.ajax({
                        type: 'post',
                        url: 'meg_data2.php',
                        data: {

                        txt_flg: "save_simulator",
                        id:'', 
                        drivercode: drivercode,
                        yearssimu: yearssimu, 
                        tlepfirstpass:tlepfirstpass,
                        tleppass: tleppass,
                        simudata1: simudata1,
                        simudata2: simudata2,
                        simudata3: simudata3,
                        tlepwearglasses: tlepwearglasses,
                        createby: createby


                        },
                        success: function (response) {
                            if (response) {

                                // alert("บันทึกข้อมูลเรียบร้อย");
                                swal.fire({
                                    title: "Good Job!",
                                    text: "บันทึกข้อมูลเรียบร้อย",
                                    icon: "success",
                                });
                                setTimeout(() => {
                                    document.location.reload();
                                }, 1500);
                                
                            }
                            
                            // // alert(rs);    
                            // window.location.reload();
                        

                        }
                    });
                
                }


                

            }   
            function save_truckcameracheck() 
            {

                // alert(chkstatus);
                // alert(checkClient);

                var drivercodetruckcamcheck = document.getElementById('txt_drivertruckcamera').value;
                var yearstruckcamcheck = document.getElementById('txt_selectyearstruckcamera').value;
                var datetruckcamcheck = document.getElementById('txt_datetruckcamera').value;
                var datatruckcamcheck = document.getElementById('txt_datatruckcamera').value;
                var createby = document.getElementById('txt_usernamefeedback').value;
                
                // alert(createby);
                // alert(timejobstart);
                // alert(sessionid);
                // เช็คการลงข้อมูลคอลัมย์ที่1

                if(drivercodetruckcamcheck == '' || yearstruckcamcheck == '' || datetruckcamcheck  == '' || datatruckcamcheck == '' ){
                
                    swal.fire({
                        title: "warning",
                        text: "กรุณาลงข้อมูลให้ครบถ้วนก่อนบันทึก !!!",
                        icon: "warning",
                    });

                }else{
                    $.ajax({
                        type: 'post',
                        url: 'meg_data2.php',
                        data: {

                        txt_flg: "save_truckcameracheck",
                        id:'', 
                        drivercode: drivercodetruckcamcheck,
                        yearstruckcamcheck: yearstruckcamcheck, 
                        datetruckcamcheck:datetruckcamcheck,
                        datatruckcamcheck: datatruckcamcheck,
                        createby: createby


                        },
                        success: function (response) {
                            if (response) {
                                // alert(response);
                                // alert("บันทึกข้อมูลเรียบร้อย");
                                swal.fire({
                                    title: "Good Job!",
                                    text: "บันทึกข้อมูลเรียบร้อย",
                                    icon: "success",
                                });
                                
                            }
                            // // alert(rs);    
                            // window.location.reload();
                        }
                    });
                }
            }
            function save_workingissue() //save สำหรับ change สีการนอน
            {

                // alert(chkstatus);
                // alert(checkClient);

                var drivercodeworkingissue = document.getElementById('txt_driverworkingissue').value;
                var yearsworkingissue = document.getElementById('txt_selectyearsworkingissue').value;
                var dateworkingissue = document.getElementById('txt_dateworkingissue').value;
                var dataworkingissue = document.getElementById('txt_dataworkingissue').value;
                var createby = document.getElementById('txt_usernamefeedback').value;
                
                // alert(createby);
                // alert(timejobstart);
                // alert(sessionid);
                // เช็คการลงข้อมูลคอลัมย์ที่1

                if(drivercodeworkingissue == '' || yearsworkingissue == '' || dateworkingissue  == '' || dataworkingissue == '' ){
                
                    swal.fire({
                        title: "warning",
                        text: "กรุณาลงข้อมูลให้ครบถ้วนก่อนบันทึก !!!",
                        icon: "warning",
                    });

                }else{
                    $.ajax({
                        type: 'post',
                        url: 'meg_data2.php',
                        data: {

                        txt_flg: "save_workingissue",
                        id:'', 
                        drivercode: drivercodeworkingissue,
                        yearsworkingissue: yearsworkingissue, 
                        dateworkingissue:dateworkingissue,
                        dataworkingissue: dataworkingissue,
                        createby: createby


                        },
                        success: function (response) {
                            if (response) {
                                // alert(response);
                                // alert("บันทึกข้อมูลเรียบร้อย");
                                swal.fire({
                                    title: "Good Job!",
                                    text: "บันทึกข้อมูลเรียบร้อย",
                                    icon: "success",
                                });
                                
                            }
                            
                            // // alert(rs);    
                            // window.location.reload();
                        

                        }
                    });
                
                }


                

            }
            function save_safetyfocustheme() //save สำหรับ change สีการนอน
            {

                // alert(chkstatus);
                // alert(checkClient);

                var monthth = document.getElementById('txt_monthth').value;
                var yearssafety  = document.getElementById('txt_selectyearsfocustheme').value;
                var safetydata = document.getElementById('txt_safetyfocustheme').value;
                var area = document.getElementById('txt_selectareafocustheme').value;
                var createby = document.getElementById('txt_usernamefeedback').value;
                
                // alert(monthth);
                // alert(yearssafety);
                // alert(safetydata);
                // alert(area);
                // alert(createby);
                // เช็คการลงข้อมูลคอลัมย์ที่1  
                if (monthth == 'มกราคม') {

                    var monththai = 'มกราคม';
                    var montheng  = 'January';
                    var yearscheck  = '01-'+yearssafety;
                    
                    // alert(yearscheck);

                }else if (monthth == 'กุมภาพันธ์'){

                    var monththai = 'กุมภาพันธ์';
                    var montheng  = 'February';
                    var yearscheck  = '02-'+yearssafety;

                }else if (monthth == 'มีนาคม'){

                    var monththai = 'มีนาคม';
                    var montheng  = 'March';
                    var yearscheck  = '03-'+yearssafety;

                }else if (monthth == 'เมษายน'){

                    var monththai = 'เมษายน';
                    var montheng  = 'April';
                    var yearscheck  = '04-'+yearssafety;

                }else if (monthth == 'พฤษภาคม'){

                    var monththai = 'พฤษภาคม';
                    var montheng  = 'May';
                    var yearscheck  = '05-'+yearssafety;

                }else if (monthth == 'มิถุนายน'){

                    var monththai = 'มิถุนายน';
                    var montheng  = 'June';
                    var yearscheck  = '06-'+yearssafety;

                }else if (monthth == 'กรกฎาคม'){

                    var monththai = 'กรกฎาคม';
                    var montheng  = 'July';
                    var yearscheck  = '07-'+yearssafety;

                }else if (monthth == 'สิงหาคม'){

                    var monththai = 'สิงหาคม';
                    var montheng  = 'August';
                    var yearscheck  = '08-'+yearssafety;

                }else if (monthth == 'กันยายน'){

                    var monththai = 'กันยายน';
                    var montheng  = 'September';
                    var yearscheck  = '09-'+yearssafety;

                }else if (monthth == 'ตุลาคม'){

                    var monththai = 'ตุลาคม';
                    var montheng  = 'October';
                    var yearscheck  = '10-'+yearssafety;

                }else if (monthth == 'พฤศจิกายน'){

                    var monththai = 'พฤศจิกายน';
                    var montheng  = 'November';
                    var yearscheck  = '11-'+yearssafety;

                }else{  
                    var monththai = 'ธันวาคม';
                    var montheng  = 'December';
                    var yearscheck  = '12-'+yearssafety;
                }

                if(monthth == '' || yearssafety == '' || safetydata == '' || area == ''){
                
                    swal.fire({
                        title: "warning",
                        text: "กรุณาลงข้อมูลให้ครบถ้วนก่อนบันทึก !!!",
                        icon: "warning",
                    });

                }else{
                    $.ajax({
                        type: 'post',
                        url: 'meg_data2.php',
                        data: {

                        txt_flg: "save_safetyfocustheme",
                        id:'', 
                        monththai: monththai,
                        montheng: montheng,
                        yearssafety: yearssafety,
                        yearscheck: yearscheck,
                        safetydata:safetydata,
                        area:area,
                        createby:createby

                        },
                        success: function (response) {
                            if (response) {

                                // alert("บันทึกข้อมูลเรียบร้อย");
                                swal.fire({
                                    title: "Good Job!",
                                    text: "บันทึกข้อมูลเรียบร้อย",
                                    icon: "success",
                                });
                                
                            }
                            
                            // // alert(rs);    
                            // window.location.reload();
                        

                        }
                    });
                }
                

            }    
            // function edit_safetytheme(value, fieldname, safetyid) {

                // alert(value);
                // alert(fieldname);
                // alert(safetyid);
                // alert(IDPLAN);
                // alert(IDDRIVER);

                // var modifyby = document.getElementById('txt_user').value;
                // //  alert(modifyby);

                // $.ajax({
                //     url: 'meg_data2.php',
                //     type: 'POST',
                //     data: {
                //         txt_flg: "update_safetyfocustheme", value: value, fieldname: fieldname, safetyid: safetyid,modifyby: modifyby
                //     },
                //     success: function (rs) {

                //         // window.location.reload();
                //     }
                // });


            // }

            $(function () {
                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                // กรณีใช้แบบ input
                $(".dateen").datetimepicker({
                    timepicker: true,
                    dateformat: 'Y-m-d' , // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00 - 00 - 0000
                    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                    timeFormat: "HH:mm"

                }
                );
            });

            $(function () {
                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                // กรณีใช้แบบ input
                $(".dateensimu").datetimepicker({
                    timepicker: false,
                    format: 'Y-m-d', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


                });
            });


            </script>
            <script>
                // $(document).ready(function () {
                //     $('#dataTables-example1').DataTable({
                //         responsive: true
                //     });
                //     $('#dataTables-example2').DataTable({
                //         responsive: true
                //     });
                //     $('#dataTables-example').DataTable({
                //         responsive: true
                //     });
                // });
            </script>

    

</html>
<?php
sqlsrv_close($conn);
?>
