
<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$employee1 = " AND a.PersonCode = '" .$_SESSION["USERNAME"] . "'";
$sql_seEmp1 = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmp1 = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($employee1, SQLSRV_PARAM_IN)
);
$query_seEmp1 = sqlsrv_query($conn, $sql_seEmp1, $params_seEmp1);
$result_seEmp1 = sqlsrv_fetch_array($query_seEmp1, SQLSRV_FETCH_ASSOC);


$sql_seVehicleinfo = "SELECT VEHICLEINFOID,THAINAME
FROM VEHICLEINFO WHERE VEHICLEINFOID ='".$_GET['vehicleinfoid']."'";
$query_seVehicleinfo    = sqlsrv_query($conn, $sql_seVehicleinfo, $params_seVehicleinfo);
$result_seVehicleinfo   = sqlsrv_fetch_array($query_seVehicleinfo, SQLSRV_FETCH_ASSOC);

$sql_sePlanData = "SELECT JOBNO,VEHICLETRANSPORTPLANID,EMPLOYEENAME1,EMPLOYEENAME2,THAINAME,
ROW_NUMBER() OVER (PARTITION BY THAINAME ORDER BY VEHICLETRANSPORTPLANID ASC) AS 'ROWNUM'
FROM VEHICLETRANSPORTPLAN
WHERE THAINAME ='".$result_seVehicleinfo['THAINAME']."'
AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,GETDATE(),103) AND CONVERT(DATE,GETDATE(),103)
ORDER BY VEHICLETRANSPORTPLANID ASC";
$query_sePlanData   = sqlsrv_query($conn, $sql_sePlanData, $params_sePlanData);
while($result_sePlanData  = sqlsrv_fetch_array($query_sePlanData, SQLSRV_FETCH_ASSOC)){

// echo $_SESSION['ROLENAME'];

if ($result_sePlanData['ROWNUM'] == '1') {
    $JOBNO1  = $result_sePlanData['JOBNO'];
    $PLANID1 = $result_sePlanData['VEHICLETRANSPORTPLANID'];
    $EMPLOYEENAME11 = $result_sePlanData['EMPLOYEENAME1'];
    $EMPLOYEENAME21 = $result_sePlanData['EMPLOYEENAME2'];
}else {
    $JOBNO2 = $result_sePlanData['JOBNO'];
    $PLANID2 = $result_sePlanData['VEHICLETRANSPORTPLANID'];
    $EMPLOYEENAME12 = $result_sePlanData['EMPLOYEENAME1'];
    $EMPLOYEENAME22 = $result_sePlanData['EMPLOYEENAME2'];
}

}


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
        <!-- Zoom CSS -->
        <!-- <link rel="stylesheet" type="text/css" href="css/zoom.css"> -->

        <!-- data table css -->
        <!-- <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet"> -->
        <link href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/buttons/3.0.0/css/buttons.dataTables.css" rel="stylesheet">

    </head>
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
    h1 {
        text-align: center;
        text-transform: uppercase;
        /* color: #F94F05; */
        text-decoration: overline;
        text-decoration: underline;
        /* text-shadow: 2px 2px #F9DA05; */
        font-size:40px;
        }
       
        * {box-sizing: border-box;}
        body {font-family: Verdana, sans-serif;}
        .mySlides {display: none;}
        img {vertical-align: middle;}

        /* Slideshow container */
        .slideshow-container {
        max-width: 1000px;
        position: relative;
        margin: auto;
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
            position:fixed;
            /* border-radius: 50%; */
            /* border-top: 12px ; */
            width: 10px;
            left: 500px;
            right: 50px;
            top: 160px;
            bottom: 800px;
            height: 10px;
            
            /* animation: spin 1s linear infinite; */
        }
    </style>
    <body>
        <div id="wrapper">
            <!-- <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

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
            </nav> -->

            <div id="page-wrapper" >
            
                <div class="row">
                    <div class="col-md-12" style="background-color: #e7e7e7">
                        <h1>GPS AUDITING &nbsp; Day : <?=date("d/m/Y")?></h1>
                    </div>
                    <div class="col-md-12" style="background-color: #e7e7e7;text-align: center">
                        <h2>ทะเบียนรถ : <?= str_replace("(4L)","",$result_seVehicleinfo['THAINAME']) ?></h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="background-color: #e7e7e7;font-size:20px;text-align: center">
                        <br>
                        <!-- <p><font color="red">ข้อมูลที่แสดงคือข้อมูลวันที่ปัจจุบันเท่านั้น</font></p> -->
                    </div>
                </div>
                <div class="row" style="background-color: #e7e7e7">
                    <!-- ตารางค่าความดัน -->
                    <div class="col-lg-12" style="background-color: #e7e7e7"></div>
                    <!-- คำแนะนำ -->
                    <div class="col-md-3" style="background-color: #e7e7e7">
                        <div class="slideshow-container" style="">
                            
                            </div>
                            
                        </div>
                    </div>

                <div class="row" >
                    <div class="col-lg-12">
                        <div class="well">
                            <div class="row">
                                <div class="panel-heading" style="background-color: #e7e7e7">
                                    ข้อมูลรถ / <?= str_replace("(4L)","",$result_seVehicleinfo['THAINAME']) ?>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">&nbsp;</div>
                                </div>
                                    <div class="row" >
                                        <input disabled="" style="display: none" type="text" id="txt_username" name="txt_username" value="<?=$result_seEmp1['nameT']?>">
                                       
                                        <div class="col-lg-4" style="text-align: center">
                                            <div class="form-group">
                                                <label>Trailer Number</label>
                                                <input disabled="" class="form-control"  id="txt_trailernamber_show" name="txt_trailernamber_show" value="<?= str_replace("(4L)","",$result_seVehicleinfo['THAINAME']) ?>">
                                                <input disabled="" style="display:none" class="form-control"  id="txt_trailernamber" name="txt_trailernamber" value="<?= $result_seVehicleinfo['THAINAME'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-4" style="text-align: center">
                                            <div class="form-group">
                                                <label>Problem</label>
                                                <!-- <input  class="form-control"  id="txt_Problem" name="txt_Problem" value="<?= $result_info['REGISTYPE'] ?>"> -->
                                                <div class="dropdown bootstrap-select show-tick form-control">
                                                <!-- $emp = select_empautocomplate('megEmployeeEHR_v2', 'select_employeehealth', ""); -->
                                                <select   id="txt_problem" name="txt_problem" class="selectpicker form-control" data-container="body" data-live-search="true" title="-Don't Select-" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                    <option value="">-Don't Select-</option>
                                                    <?php
                                                    // $condiLocation1 = " AND COMPANYCODE = 'RKR' AND CUSTOMERCODE = 'TTASTSTC'";
                                                    $sql_seProblem = "SELECT ITEMS FROM [dbo].[GPSAUDITINGMASTER] ORDER BY REMARK ASC";
                                                    $params_seProblem = array();
                                                    $query_seProblem = sqlsrv_query($conn, $sql_seProblem, $params_seProblem);
                                                    while ($result_seProblem = sqlsrv_fetch_array($query_seProblem, SQLSRV_FETCH_ASSOC)) {
                                                        ?>
                                                        <option value="<?= $result_seProblem['ITEMS'] ?>"><?= $result_seProblem['ITEMS'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <input class="form-control" style="display: none"   id="txt_copydiagramzone" name="txt_copydiagramzone" maxlength="500" value="" >
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Driver name:</label>
                                            <div class="dropdown bootstrap-select show-tick form-control">
                                                <!-- $emp = select_empautocomplate('megEmployeeEHR_v2', 'select_employeehealth', ""); -->
                                                <select   id="txt_drivername" name="txt_drivername" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก พนักงาน..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                    <option value="">-ไม่เลือกพนักงาน-</option>
                                                    <?php
                                                    // $condiLocation1 = " AND COMPANYCODE = 'RKR' AND CUSTOMERCODE = 'TTASTSTC'";
                                                    $sql_seName = "{call megEmployeeEHR_v2(?,?)}";
                                                    $params_seName = array(
                                                        array('select_employeeehr2', SQLSRV_PARAM_IN),
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
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Location</label>
                                                <input class="form-control"  id="txt_location" name="txt_location" value="<?= $result_info['AFFCUSTOMER'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Root Cause</label>
                                                <input class="form-control"  id="txt_rootcause" name="txt_rootcause"  value="<?= $result_info['VEHICLEREGISTERFIRSTDATE'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Result</label>
                                                <select  style="width:200px;height:40px;" id="txt_result" name="txt_result" class="selectpicker form-control" data-container="body" data-live-search="false" title="-Result Check-" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                    <option value="">-Result Check-</option>
                                                    <option value="OK">OK</option>
                                                    <option value="NG">NG</option>
                                                </select>
                                                <!-- <input class="form-control"  id="txt_result" name="txt_result" value=""> -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class = "row" style="height:40px;"></div>  -->
                                    <div class="row">
                                        <div class="col-lg-4" >
                                            <div class="form-group">
                                                <label>GPS Check (Start)</label>
                                                <select  style="width:200px;height:40px;" id="cb_gpscheck_start" name="cb_gpscheck_start" class="selectpicker form-control" data-container="body" data-live-search="false" title="-GPS Check Start-" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                    <option value="">-Don't Check Start-</option>
                                                    <option value="OK">OK</option>
                                                    <option value="NG">NG</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4" >
                                            <div class="form-group">
                                                <label>GPS Check (Middle)</label>
                                                <select  style="width:200px;height:40px;" id="cb_gpscheck_middle" name="cb_gpscheck_middle" class="selectpicker form-control" data-container="body" data-live-search="false" title="-GPS Check Middle-" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                    <option value="">-Don't Check Middle-</option>
                                                    <option value="OK">OK</option>
                                                    <option value="NG">NG</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4" >
                                            <div class="form-group">
                                                <label>GPS Check (Finish)</label>
                                                <select  style="width:200px;height:40px;" id="cb_gpscheck_finish" name="cb_gpscheck_finish" class="selectpicker form-control" data-container="body" data-live-search="false" title="-GPS Check Finish-" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                    <option value="">-Don't Check Finish-</option>
                                                    <option value="OK">OK</option>
                                                    <option value="NG">NG</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Job No.1</label>
                                                <input disabled="" class="form-control"  id="txt_jobno1" name="txt_jobno1" value="<?=$JOBNO1?>">
                                                <input disabled="" style="display:none" type="text" id="txt_planid1"   name="txt_planid1"   value="<?=$PLANID1?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Driver 1</label>
                                                <input disabled="" class="form-control"  id="txt_driver11" name="txt_driver11" value="<?=$EMPLOYEENAME11?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Driver 2</label>
                                                <input disabled="" class="form-control"  id="txt_driver21" name="txt_driver21" value="<?=$EMPLOYEENAME21?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Job No.2</label>
                                                <input disabled="" class="form-control"  id="txt_jobno2"  name="txt_jobno2"   value="<?=$JOBNO2?>">
                                                <input disabled="" style="display:none" type="text"  id="txt_planid2" name="txt_planid2"  value="<?=$PLANID2?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Driver 1</label>
                                                <input disabled="" class="form-control"  id="txt_driver12" name="txt_driver12" value="<?=$EMPLOYEENAME12?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Driver 2</label>
                                                <input disabled="" class="form-control"  id="txt_driver22" name="txt_driver22" value="<?=$EMPLOYEENAME22?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4" style="text-align: center">
                                            <div class="form-group" >
                                                <label>Time</label>
                                                <input disabled=""  class="form-control"  id="txt_datetime" name="txt_datetime" value="<?= date("Y/m/d H:i") ?>">
                                            </div>
                                        </div>
                                    </div>
                                     <!-- END ROW9 -->  
                                    <!-- <br>-->
                                    <div class="col-lg-12" style="text-align: center;">
                                        <br><br>
                                        <input style="width:200px;height:60px;color:#ffffff;font-size: 20px;" type="button" onclick="save_gpsauditing();" name="btnSend" id="btnSend" value="บันทึกข้อมูล" class="btn btn-success">
                                        <!-- <input style="background-color: #3CBC8D;width:200px;height:40px;color:#ffffff;font-size: 20px;" type="button" onclick="print_data('<?= $_GET['vehicleinfoid'] ?>');" name="btnSend" id="btnSend" value="พิมพ์ข้อมูลรถ" class="btn btn-success"> -->
                                        <!-- <button style="background-color: #1372d1;width:200px;height:40px;color:#ffffff;font-size: 20px;" onclick="pdf_printvehicleinfo('<?= $_GET['vehicleinfoid'] ?>')" title="พิมพ์" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-print"></span>พิมพ์ข้อมูล</button> -->
                                    </div>                
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="tab-content">
                    <div class="row">
                        <div class="col-md-12">&nbsp;</div>
                    </div>
                               
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-md-12">&nbsp;</div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #e7e7e7">

                                    <div class="row">
                                        <div class="col-sm-6">รายละเอียดข้อมูล GPS Auditing <font color="red">(ข้อมูลที่แสดงบนตารางคือข้อมูลวันที่ปัจจุบันเท่านั้น)</font></div>
                                        <!-- <div class="col-sm-6 text-right"><a target="_bank" href='meg_vehiclrinfoamata.php?vehicleinfoid=&meg=add'>เพิ่มข้อมูลรถ</a></div> --> 
                                    </div>
                                
                                </div><br>
                                <!-- /.panel-heading -->
                                <!-- <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>พิมพ์ข้อมูลประวัติอุบัติเหตุ </label><br>   
                                            <input type="button"  name="" id=""onclick="print_accidentpdf()" value="พิมพ์ข้อมูลประวัติอุบัติเหตุ (PDF)" class="btn btn-primary">
                                            <input type="button"  name="" id=""onclick="print_accidentexcel()" value="พิมพ์ข้อมูลประวัติอุบัติเหตุ (EXCEL)" class="btn btn-primary">
                                        </div>
                                </div> -->
                                    <div class="row">
                                        <div class="col-lg-12" >
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <label>ค้นหาตามช่วงวันที่</label>
                                                    <input class="form-control dateen" readonly="" onchange="datetodate();" style="background-color: #f080802e"  id="txt_datestart_auditing" name="txt_datestart_auditing" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">
                                                </div>

                                            </div>
                                            <div class="col-lg-2">
                                                <label>&nbsp;</label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control dateen"  readonly=""  style="background-color: #f080802e" id="txt_dateend_auditing" name="txt_dateend_auditing" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-1">
                                                <label>&nbsp;</label>
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-default" onclick="select_gpsauditingskp();">ค้นหา <li class="fa fa-search"></li></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="panel panel-default">
                                                
                                                <!-- /.panel-heading -->

                                                <div class="panel-body">

                                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                        <div id="datadef">
                                                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
                                                                <thead >
                                                                    <tr>
                                                                        <th style="width: 5px;">No</th>
                                                                        <th style="width: 40px;">Trailer Number</th>
                                                                        <th style="width: 70px;">Problem</th>
                                                                        <th style="width: 70px;">Driver Name</th>
                                                                        <th style="width: 50px;">Time</th>
                                                                        <th style="width: 50px;">Location</th>
                                                                        <th style="width: 50px;">Root cause</th>
                                                                        <th style="width: 50px;">Result</th>
                                                                        <th style="width: 40px;">GPS CHECK<br>(START)</th>
                                                                        <th style="width: 40px;">GPS CHECK<br>(MIDDLE)</th>
                                                                        <th style="width: 40px;">GPS CHECK<br>(FINISH)</th>
                                                                        <th style="width: 70px;">PlanID_1</th>
                                                                        <th style="width: 70px;">PlanID_2</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php

                                                                // $condiReporttransport1 = " AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)";
                                                                // $condiReporttransport2 = "";
                                                                // $condiReporttransport3 = "";
                                                                // เงื่อนไขเดิม AND SUBSTRING(b.PersonCode, 1, 2) IN ('01','02','07','08','06','10')

                                                                $i = 1;
                                                                $sql_seData = "SELECT TRAILERNUMBER,PROBLEM,DRIVERNAME,DATETIMEAUDIT,LOCATIONAUDIT,ROOTCAUSE,RESULT,
                                                                            GPSCHECK_START,GPSCHECK_MIDDLE,GPSCHECK_FINISH,PLANID1,DRIVERNAME11,DRIVERNAME12,PLANID2,DRIVERNAME21,DRIVERNAME22
                                                                            FROM [dbo].[GPSAUDITING]
                                                                            WHERE CONVERT(DATE,CREATEDATE) BETWEEN CONVERT(DATE,GETDATE()) AND CONVERT(DATE,GETDATE())
                                                                            AND TRAILERNUMBER ='".$result_seVehicleinfo['THAINAME']."'
                                                                            ORDER BY REMARK ASC";
                                                                $params_seData = array();
                                                                $query_seData = sqlsrv_query($conn, $sql_seData, $params_seData);
                                                                while ($result_seData = sqlsrv_fetch_array($query_seData, SQLSRV_FETCH_ASSOC)) {

                                                                
                                                                    $DATETIMEAUDIT_CHK = str_replace("T"," ",$result_seData['DATETIMEAUDIT']);
                                                                    $DATETIMEAUDIT     = str_replace("-","/",$DATETIMEAUDIT_CHK);

                                                                    // echo $result_seData['DRIVER_BMI'];
                                                                    // echo '<br>';
                                                                    ?>

                                                                    <tr>
                                                                        <td style="text-align: center"><?= $i ?></td>
                                                                        <td style="text-align: center"><?=str_replace("(4L)","",$result_seData['TRAILERNUMBER'])?></td>
                                                                        <td style="text-align: center"><?=$result_seData['PROBLEM']?></td>
                                                                        <td style="text-align: center"><?=$result_seData['DRIVERNAME']?></td>
                                                                        <td style="text-align: center"><?=$DATETIMEAUDIT ?></td>
                                                                        <td style="text-align: center"><?=$result_seData['LOCATIONAUDIT']?></td>
                                                                        <td style="text-align: center"><?=$result_seData['ROOTCAUSE']?></td>
                                                                        <td style="text-align: center"><?=$result_seData['RESULT']?></td>
                                                                        <td style="text-align: center"><?=$result_seData['GPSCHECK_START']?></td>
                                                                        <td style="text-align: center"><?=$result_seData['GPSCHECK_MIDDLE']?></td>
                                                                        <td style="text-align: center"><?=$result_seData['GPSCHECK_FINISH']?></td>
                                                                        <td style="text-align: center"><?=$result_seData['PLANID1']?></td>
                                                                        <td style="text-align: center"><?=$result_seData['PLANID2']?></td>
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

                                
                                <!-- /.panel -->
                            </div>
                        </div>
                    </div>



                </div>
            </div>

            <!-- this will show our spinner -->
            <div  id="loading" class="center" >
                <p><img style="" src="../images/truckload5.gif" /></p>
            </div>



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
                                                                
            <!-- Zoom Js -->
            <!-- <script src="js/zoom.js"></script> -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
            
            <!-- Data Table Export File -->
            <!-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script> -->
            <script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
            <script src="https://cdn.datatables.net/buttons/3.0.0/js/dataTables.buttons.js"></script>
            <script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.dataTables.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
            <!-- <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script> -->
            <script src="//cdn.datatables.net/plug-ins/1.13.6/i18n/th.json"></script>
            <script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.html5.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.colVis.min.js"></script>


    </body>
    <script>

                                        function datetodate()
                                        {
                                            document.getElementById('txt_dateend_auditing').value = document.getElementById('txt_datestart_auditing').value;

                                        }
                                        
                                        function showLoading() {
                                            $("#loading").show();
                                            
                                        }

                                        function hideLoading() {
                                            $("#loading").hide();
                                        }


                                        // let slideIndex = 0;
                                        // showSlides();

                                        // function showSlides() {
                                        // let i;
                                        // let slides = document.getElementsByClassName("mySlides");
                                        // let dots = document.getElementsByClassName("dot");
                                        // for (i = 0; i < slides.length; i++) {
                                        //     slides[i].style.display = "none";  
                                        // }
                                        // slideIndex++;
                                        // if (slideIndex > slides.length) {slideIndex = 1}    
                                        // for (i = 0; i < dots.length; i++) {
                                        //     dots[i].className = dots[i].className.replace(" active", "");
                                        // }
                                        // slides[slideIndex-1].style.display = "block";  
                                        // dots[slideIndex-1].className += " active";
                                        // setTimeout(showSlides, 4000); // Change image every 2 seconds
                                        // }

                                        function save_gpsauditing(){
           
                                            // alert(employeecode1);
                                            // alert(tenkomasterid);
                                            // alert(companycode);
                                            var trailernumber   = $("#txt_trailernamber").val(); 
                                            var problem         = $("#txt_problem").val(); 
                                            var drivername      = $("#txt_drivername").val();   
                                            
                                            // DATETIME MONITORING
                                            var datetimedatachk     = $("#txt_datetime").val();
                                            var datetimedata1       = datetimedatachk.replace(" ","T"); // replace " " เป็น "T"
                                            var datetimedata2       = datetimedata1.replaceAll("/","-");
                                            var datetimedata        = datetimedata2;

                                            // alert(datetimedata);

                                            var location            = $("#txt_location").val();
                                            var rootcause           = $("#txt_rootcause").val();
                                            var result              = $("#txt_result").val();

                                            var gpscheckstart       = $("#cb_gpscheck_start").val();
                                            var gpscheckmiddle      = $("#cb_gpscheck_middle").val();
                                            var gpscheckfinish      = $("#cb_gpscheck_finish").val();


                                            var jobno1               = $("#txt_jobno1").val();
                                            var planid1              = $("#txt_planid1").val();
                                            var drivername11         = $("#txt_driver11").val();
                                            var drivername21         = $("#txt_driver21").val();

                                            var jobno2               = $("#txt_jobno2").val();
                                            var planid2              = $("#txt_planid2").val();
                                            var drivername12         = $("#txt_driver12").val();
                                            var drivername22         = $("#txt_driver22").val();

                                            var createby            = $("#txt_username").val();


                                            $.ajax({
                                                type: 'post',
                                                url: 'meg_data_gpsaudit.php',
                                                data: {
                                                    txt_flg: "save_gpsauditing",
                                                    trailernumber:trailernumber,
                                                    problem:problem,
                                                    drivername:drivername,
                                                    datetimedata:datetimedata,
                                                    location:location,
                                                    rootcause:rootcause,
                                                    result:result,
                                                    gpscheckstart:gpscheckstart,
                                                    gpscheckmiddle:gpscheckmiddle,
                                                    gpscheckfinish:gpscheckfinish,
                                                    jobno1:jobno1,
                                                    planid1:planid1,
                                                    drivername11:drivername11,
                                                    drivername21:drivername21,
                                                    jobno2:jobno2,
                                                    planid2:planid2,
                                                    drivername12:drivername12,
                                                    drivername22:drivername22,
                                                    createby:createby
                                                },
                                                success: function (rs) {
                                                    // alert(rs);

                                                    swal.fire({
                                                        title: "Good Job !!!",
                                                        text: "เพิ่มข้อมูล GPS Auditing เรียบร้อย !!!",
                                                        icon: "success",
                                                        showConfirmButton: true,
                                                        allowOutsideClick: false,
                                                        timer: 1500,
                                                    });
                                                    window.location.reload();
                                                    
                                                }
                                            }); 

                                             
                                            
                                            

                                            // save_logprocess('Report', 'Excel รายงานค่าเที่ยว (เบี้ยเลี้ยง/อาหาร)(RCC,RATC)', '<?= $result_seLogin['PersonCode'] ?>');

                                        }
                                        function select_gpsauditingskp() {

                                        var datestart   = document.getElementById('txt_datestart_auditing').value;
                                        var dateend     = document.getElementById('txt_dateend_auditing').value;
                                        var thainame    = '<?=$result_seVehicleinfo['THAINAME']?>';

                                        // alert(datestart);
                                        // alert(dateend);
                                        // alert(companycode);
                                        // alert(customercode);
                                        // alert(status);
                                        // รูปแบบ เดือน/วัน/ปี

                                        
                                        if (datestart == '') {
                                            
                                            swal.fire({
                                                title: "Warning !",
                                                text: "กรุณาเลือกวันที่เริ่มต้น",
                                                icon: "warning",
                                            });
                                                    
                                        }else if(dateend == ''){

                                            swal.fire({
                                                title: "Warning !",
                                                text: "กรุณาเลือกวันที่สิ้นสุด",
                                                icon: "warning",
                                            });

                                        }else{

                                            showLoading();
                                            $.ajax({
                                                type: 'post',
                                                url: 'meg_data_gpsaudit.php',
                                                data: {
                                                    txt_flg: "select_gpsauditingskp", datestart: datestart, dateend: dateend,thainame: thainame
                                                },
                                                success: function (response) {
                                                    
                                                    hideLoading();
                                                    // alert('โหลดข้อมูลเรียบร้อย');
                                                    swal.fire({
                                                        title: "Good Job!",
                                                        text: "โหลดข้อมูลเรียบร้อย",
                                                        icon: "success",
                                                        showConfirmButton: true,
                                                        allowOutsideClick: false
                                                    });
                                                    
                                                    if (response)
                                                    {
                                                        document.getElementById("datasr").innerHTML = response;
                                                        document.getElementById("datadef").innerHTML = "";
                                                    }
                                                    $(document).ready(function () {
                                                        
                                                        $('#dataTables-example').DataTable({

                                                            order: [[10, 'desc']],
                                                            scrollX: true,
                                                            scrollY: '500px',
                                                            charset: 'UTF-8',
                                                            fieldSeparator: ';',
                                                            bom: true,
                                                            // dom: 'Bfrtip',
                                                            lengthMenu: [
                                                                        [ 10, 15, 20, -1 ],
                                                                        [ '10 rows', '15 rows', '20 rows', 'Show all' ]
                                                                    ],
                                                            layout: {
                                                                topStart: {
                                                                        
                                                                    buttons: [
                                                                        {
                                                                            
                                                                            extend: 'pageLength'
                                                                        },
                                                                        'colvis'
                                                                        ,
                                                                        {
                                                                            exportOptions: {
                                                                                columns: ':visible'
                                                                            },
                                                                            extend: 'excelHtml5'
                                                                            
                                                                        }
                                                                    ]
                                                                }
                                                            }


                                                        });
                                                    });

                                                    
                                                }
                                            });
                                        }

                                        }
                                        
                                        // function delete_labotrondata(labotrondataid)
                                        // {
                                        //     // alert('delete');
                                        //     // alert(labotrondataid);

                                        //     Swal.fire({
                                        //         title: 'ต้องการลบข้อมูล?',
                                        //         text: "กรุณากด 'ตกลง' เพื่อยืนยันการลบข้อมูล!!!",
                                        //         icon: 'warning',
                                        //         showCancelButton: true,
                                        //         confirmButtonColor: '#3085d6',
                                        //         cancelButtonColor: '#d33',
                                        //         confirmButtonText: 'ตกลง',
                                        //         cancelButtonText: 'ยกเลิก'
                                        //     }).then((result) => {
                                                
                                        //         if (result.isConfirmed) {
                                                    
                                        //             if ('<?=$_SESSION['ROLENAME']?>' !='ADMIN') {
                                        //                 // alert('NOT ADMIN');
                                        //                 swal.fire({
                                        //                     title: "Warning!",
                                        //                     text: "SYSTEM ADMIN เท่านั้นที่สามารถลบข้อมูลได้!!!",
                                        //                     icon: "warning",
                                        //                     showConfirmButton: true,
                                        //                     allowOutsideClick: false,
                                        //                 });
                                        //             }else{
                                        //                 // alert('ADMIN');
                                                         
                                        //                 $.ajax({
                                        //                     type: 'post',
                                        //                     url: 'meg_data2.php',
                                        //                     data: {
                                        //                         txt_flg: "delete_labotrondata", labotrondataid: labotrondataid
                                        //                     },
                                        //                     success: function (rs) {
                                        //                         // alert(rs);
                                        //                         // alert('ลบข้อมูลเรียบร้อย');
                                        //                         // location.reload();

                                        //                         swal.fire({
                                        //                             title: "Good Job!",
                                        //                             text: "ลบข้อมูลเรียบร้อย",
                                        //                             showConfirmButton: false,
                                        //                             icon: "success"
                                        //                         });
                                        //                         // alert(rs);   
                                        //                         setTimeout(() => {
                                        //                             document.location.reload();
                                        //                         }, 1500);

                                        //                     }
                                        //                 });

                                        //             }
                                                    



                                        //         }else{
                                        //             //else check การลบข้อมูล
                                        //             // window.location.reload();
                                        //         }
                                        //     })
                                            
                                        // }
                                        
                                        
                                        $(document).ready(function () {
                                            $('#dataTables-example').DataTable({
                                                // order: [[0, "asc"]],
                                                // scrollX: true,
                                                // scrollY: '520px',

                                                order: [[10, 'desc']],
                                                scrollX: true,
                                                scrollY: '500px',
                                                charset: 'UTF-8',
                                                fieldSeparator: ';',
                                                bom: true,
                                                // dom: 'Bfrtip',
                                                lengthMenu: [
                                                            [ 10, 15, 20, -1 ],
                                                            [ '10 rows', '15 rows', '20 rows', 'Show all' ]
                                                        ],
                                                layout: {
                                                    topStart: {
                                                            
                                                        buttons: [
                                                            {
                                                                
                                                                extend: 'pageLength'
                                                            },
                                                            'colvis'
                                                            ,
                                                            {
                                                                exportOptions: {
                                                                    columns: ':visible'
                                                                },
                                                                extend: 'excelHtml5'
                                                                
                                                            }
                                                        ]
                                                    }
                                                }
                                            });
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
                                        

                                  
                        
    </script>
</html>
<?php
sqlsrv_close($conn);
?>
