
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

$sql_sePlanData = "SELECT JOBNO,EMPLOYEENAME1,EMPLOYEENAME2 FROM VEHICLETRANSPORTPLAN
 WHERE VEHICLETRANSPORTPLANID ='".$_GET['vehicletransportplanid']."'";
$query_sePlanData   = sqlsrv_query($conn, $sql_sePlanData, $params_sePlanData);
$result_sePlanData  = sqlsrv_fetch_array($query_sePlanData, SQLSRV_FETCH_ASSOC);

// echo $_SESSION['ROLENAME'];
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

        /* Caption text */
        /* .text {
        color: #f2f2f2;
        font-size: 15px;
        padding: 8px 12px;
        position: absolute;
        bottom: 8px;
        width: 100%;
        text-align: center;
        } */

        /* Number text (1/3 etc) */
        .numbertext {
        color: #f2f2f2;
        font-size: 12px;
        padding: 8px 12px;
        position: absolute;
        top: 0;
        }

        /* The dots/bullets/indicators */
        .dot {
        height: 15px;
        width: 15px;
        margin: 0 2px;
        background-color: #bbb;
        border-radius: 50%;
        display: inline-block;
        transition: background-color 0.6s ease;
        }

        .active {
        background-color: #717171;
        }

        /* Fading animation */
        .slide {
        animation-name: slide;
        animation-duration: 1.5s;
        }

        @keyframes slide {
        from {opacity: .4} 
        to {opacity: 1}
        }

        /* On smaller screens, decrease text size */
        @media only screen and (max-width: 300px) {
        .text {font-size: 11px}
        }

        
        div[data-balloon] {
            float:left;
        }

        div[data-balloon]:hover::after {
            content: attr(data-balloon);
            border: 1px solid black;
            border-radius: 8px;
            background: #eee;
            padding: 4px; 
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
                        <p><font color="red">ข้อมูลที่แสดงคือข้อมูลวันที่ปัจจุบันเท่านั้น</font></p>
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
                                        <input disabled="" style="display: none" type="text" id="txt_planid"   name="txt_planid"   value="<?=$_GET['vehicletransportplanid']?>">
                                        <div class="col-lg-3" style="text-align: center">
                                            <div class="form-group">
                                                <label>Trailer Number</label>
                                                <input disabled="" class="form-control"  id="txt_trailernamber_show" name="txt_trailernamber_show" value="<?= str_replace("(4L)","",$result_seVehicleinfo['THAINAME']) ?>">
                                                <input disabled="" style="display:none" class="form-control"  id="txt_trailernamber" name="txt_trailernamber" value="<?= $result_seVehicleinfo['THAINAME'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-3" style="text-align: center">
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
                                        <div class="col-lg-3">
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
                                        <div class="col-lg-3" style="text-align: center">
                                            <div class="form-group" >
                                                <label>Time</label>
                                                <input disabled=""  class="form-control"  id="txt_datetime" name="txt_datetime" value="<?= date("Y/m/d H:i") ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>Location</label>
                                                <input class="form-control"  id="txt_location" name="txt_location" value="<?= $result_info['AFFCUSTOMER'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>Root Cause</label>
                                                <input class="form-control"  id="txt_rootcause" name="txt_rootcause"  value="<?= $result_info['VEHICLEREGISTERFIRSTDATE'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>Result</label>
                                                <input class="form-control"  id="txt_result" name="txt_result" value="">
                                            </div>
                                        </div>
                                        <div class="col-lg-3" >
                                            <div class="form-group">
                                                <label>GPS Check</label>
                                                <select  style="width:200px;height:40px;" id="cb_gpscheck" name="cb_gpscheck" class="selectpicker form-control" data-container="body" data-live-search="true" title="-GPS Check-" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                                    <option value="">-Don't Check-</option>
                                                    <option value="Start">Start</option>
                                                    <option value="Middle">Middle</option>
                                                    <option value="Finish">Finish</option> 
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>Job No</label>
                                                <input disabled="" class="form-control"  id="txt_jobno" name="txt_jobno" value="<?=$result_sePlanData['JOBNO']?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>Driver 1</label>
                                                <input disabled="" class="form-control"  id="txt_driver1" name="txt_driver1" value="<?=$result_sePlanData['EMPLOYEENAME1']?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>Driver 2</label>
                                                <input disabled="" class="form-control"  id="txt_driver2" name="txt_driver1" value="<?=$result_sePlanData['EMPLOYEENAME2']?>">
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
                                        <div class="col-sm-6">รายละเอียดข้อมูล GPS Auditing</div>
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
                                                                    <th style="width: 40px;">GPS check</th>
                                                                    <th style="width: 70px;">PlanID</th>
                                                                    <th style="width: 60px;">Driver 1</th>
                                                                    <th style="width: 50px;">Driver 2</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php

                                                            // $condiReporttransport1 = " AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'" . $_POST['datestart'] . "',103) AND CONVERT(DATE,'" . $_POST['dateend'] . "',103)";
                                                            // $condiReporttransport2 = "";
                                                            // $condiReporttransport3 = "";
                                                            // เงื่อนไขเดิม AND SUBSTRING(b.PersonCode, 1, 2) IN ('01','02','07','08','06','10')

                                                            $i = 1;
                                                            $sql_seData = "SELECT TRAILERNUMBER,PROBLEM,DRIVERNAME,DATETIMEAUDIT,LOCATIONAUDIT,ROOTCAUSE,RESULT,GPSCHECK,PLANID,DRIVERNAME1,DRIVERNAME2
                                                                        FROM [dbo].[GPSAUDITING]
                                                                        WHERE CONVERT(DATE,CREATEDATE) BETWEEN CONVERT(DATE,GETDATE()) AND CONVERT(DATE,GETDATE())
                                                                        AND TRAILERNUMBER ='".$result_seVehicleinfo['THAINAME']."'
                                                                        ORDER BY REMARK ASC";
                                                            $params_seData = array();
                                                            $query_seData = sqlsrv_query($conn, $sql_seData, $params_seData);
                                                            while ($result_seData = sqlsrv_fetch_array($query_seData, SQLSRV_FETCH_ASSOC)) {

                                                             
                                                                $DATETIMEAUDITING_CHK = str_replace("T"," ",$result_seData['DATETIMEAUDIT']);
                                                                $DATETIMEAUDITING     = str_replace("-","/",$DATETIMEAUDITING_CHK);

                                                                // echo $result_seData['DRIVER_BMI'];
                                                                // echo '<br>';
                                                                ?>

                                                                <tr>
                                                                    <td style="text-align: center"><?= $i ?></td>
                                                                    <td style="text-align: center"><?=str_replace("(4L)","",$result_seData['TRAILERNUMBER'])?></td>
                                                                    <td style="text-align: center"><?=$result_seData['PROBLEM']?></td>
                                                                    <td style="text-align: center"><?=$result_seData['DRIVERNAME']?></td>
                                                                    <td style="text-align: center"><?=$DATETIMEAUDITING ?></td>
                                                                    <td style="text-align: center"><?=$result_seData['LOCATIONAUDIT']?></td>
                                                                    <td style="text-align: center"><?=$result_seData['ROOTCAUSE']?></td>
                                                                    <td style="text-align: center"><?=$result_seData['RESULT']?></td>
                                                                    <td style="text-align: center"><?=$result_seData['GPSCHECK']?></td>
                                                                    <td style="text-align: center"><?=$result_seData['PLANID']?></td>
                                                                    <td style="text-align: center"><?=$result_seData['DRIVERNAME1']?></td>
                                                                    <td style="text-align: center"><?=$result_seData['DRIVERNAME2']?></td>
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

                                        // function datetodate()
                                        // {
                                        //     document.getElementById('txt_dateend_dashboard').value = document.getElementById('txt_datestart_dashboard').value;

                                        // }
                                    

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
                                            var gpscheck            = $("#cb_gpscheck").val();
                                            var jobno               = $("#txt_jobno").val();
                                            var planid              = $("#txt_planid").val();
                                            var drivername1         = $("#txt_driver1").val();
                                            var drivername2         = $("#txt_driver2").val();
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
                                                    gpscheck:gpscheck,
                                                    jobno:jobno,
                                                    planid:planid,
                                                    drivername1:drivername1,
                                                    drivername2:drivername2,
                                                    createby:createby
                                                },
                                                success: function (rs) {
                                                    // alert(rs);

                                                    swal.fire({
                                                        title: "Good Job !!!",
                                                        text: "เพิ่มข้อมูล GPS Audit เรียบร้อย !!!",
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

                                        
                                        function delete_labotrondata(labotrondataid)
                                        {
                                            // alert('delete');
                                            // alert(labotrondataid);

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
                                                    
                                                    if ('<?=$_SESSION['ROLENAME']?>' !='ADMIN') {
                                                        // alert('NOT ADMIN');
                                                        swal.fire({
                                                            title: "Warning!",
                                                            text: "SYSTEM ADMIN เท่านั้นที่สามารถลบข้อมูลได้!!!",
                                                            icon: "warning",
                                                            showConfirmButton: true,
                                                            allowOutsideClick: false,
                                                        });
                                                    }else{
                                                        // alert('ADMIN');
                                                         
                                                        $.ajax({
                                                            type: 'post',
                                                            url: 'meg_data2.php',
                                                            data: {
                                                                txt_flg: "delete_labotrondata", labotrondataid: labotrondataid
                                                            },
                                                            success: function (rs) {
                                                                // alert(rs);
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

                                                    }
                                                    



                                                }else{
                                                    //else check การลบข้อมูล
                                                    // window.location.reload();
                                                }
                                            })
                                            
                                        }
                                        
                                        
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
                                                timepicker: true,
                                                dateformat: 'Y-m-d' , // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00 - 00 - 0000
                                                lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                timeFormat: "HH:mm"

                                            }
                                            );
                                        });
                                        

                                  
                        
    </script>
</html>
<?php
sqlsrv_close($conn);
?>
