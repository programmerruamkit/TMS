<!DOCTYPE html>
<?php
session_start();
ini_set('max_execution_time', 300);
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if (!isset($_SESSION["USERNAME"]) || !isset($_SESSION["PASSWORD"])) {
    header("location:../pages/meg_login.php?data=3");
}
$sql_seSystime = "{call megGetdate_v2(?)}";
$params_seSystime = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_seSystime = sqlsrv_query($conn, $sql_seSystime, $params_seSystime);
$result_seSystime = sqlsrv_fetch_array($query_seSystime, SQLSRV_FETCH_ASSOC);


$condition1 = " AND (a.USERNAME ='" . $_SESSION["USERNAME"] . "' AND a.PASSWORD = '" . $_SESSION["PASSWORD"] . "') AND a.ACTIVESTATUS = 1";
$sql_seLogin = "{call megRoleaccount_v2(?,?)}";
$params_seLogin = array(
    array('select_roleaccount', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_seLogin = sqlsrv_query($conn, $sql_seLogin, $params_seLogin);
$result_seLogin = sqlsrv_fetch_array($query_seLogin, SQLSRV_FETCH_ASSOC);



$run_jobno = create_jobno(substr($_GET['companycode'], 0, 3), 'GETDATE()');
$jobsm1 = '';
$jobsm2 = '';
$jobsm3 = '';
$jobsm4 = '';
$jobstu1 = '';
$jobstu2 = '';
$jobsw1 = '';
$jobsw2 = '';
$jobsth1 = '';
$jobsth2 = '';
$jobsf1 = '';
$jobsf2 = '';
$jobssat1 = '';
$jobssat2 = '';
$jobssun1 = '';
$jobssun2 = '';

$condComp = " AND Company_Code = '" . $_GET['companycode'] . "'";
$sql_seComp = "{call megCompanyEHR_v2(?,?)}";
$params_seComp = array(
    array('select_company', SQLSRV_PARAM_IN),
    array($condComp, SQLSRV_PARAM_IN)
);
$query_seComp = sqlsrv_query($conn, $sql_seComp, $params_seComp);
$result_seComp = sqlsrv_fetch_array($query_seComp, SQLSRV_FETCH_ASSOC);

$condiCustomer = " AND a.CUSTOMERCODE = '" . $_GET['customercode'] . "'";
$sql_seCustomer = "{call megCustomer_v2(?,?)}";
$params_seCustomer = array(
    array('select_customer', SQLSRV_PARAM_IN),
    array($condiCustomer, SQLSRV_PARAM_IN)
);
$query_seCustomer = sqlsrv_query($conn, $sql_seCustomer, $params_seCustomer);
$result_seCustomer = sqlsrv_fetch_array($query_seCustomer, SQLSRV_FETCH_ASSOC);

$condition1 = "  AND a.PersonID = '" . $_SESSION["EMPLOYEEID"] . "'";
$sql_seEmployee = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmployee = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
$result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC);
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
        <link href="../dist/css/select2.min.css" rel="stylesheet">



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

            .fileUpload {
                position: relative;
                overflow: hidden;
                margin: 10px;
            }
            .fileUpload input.upload {
                position: absolute;
                top: 0;
                right: 0;
                margin: 0;
                padding: 0;
                font-size: 20px;
                cursor: pointer;
                opacity: 0;
                filter: alpha(opacity=0);
            }




        </style>
    </head>
    <body >


        <input class="form-control" style="display: none"  id="txt_copydiagramroute" name="txt_copydiagramroute" maxlength="500" value="" >

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

        <input type="text" name="txt_copydiagramvehicletransportplanid" id="txt_copydiagramvehicletransportplanid" class="form-control" style="display: none">

        <div class="modal fade" id="modal_copydiagramupd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 80%">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="row">
                            <div class="col-lg-5">
                                <h5 class="modal-title" id="title_copydiagram"><b>Update Diagram</b></h5>
                            </div>

                        </div>
                    </div>

                    <div id="modalbodyupdatediagramrccsr"></div>

                </div>
            </div>
        </div>

        <!-- Model Update -->
        <div class="modal fade" id="modal_copyjob" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="title_copyjob">COPY JOB</h5>

                    </div>
                    <div class="modal-body">
                        <div class="row" >
                            <div class="col-lg-6">
                                <div class="form-group">

                                    <label>จำนวน (JOB) : </label>

                                    <input class="form-control" id="txt_startdatejobcopy" name="txt_startdatejobcopy" style="display: none">
                                    <input class="form-control" id="txt_rowsamount" name="txt_rowsamount" >

                                </div>
                            </div>
                        </div>
                        <div class="row">&nbsp;</div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                        <button type="button" class="btn btn-primary" onclick="save_copyjob()">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>    


        <div class="modal fade" id="modal_copydiagram" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 80%">
                <div class="modal-content">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <?php
                                if ($_GET['worktype'] == 'nm') {
                                    ?>

                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#normal" data-toggle="tab" aria-expanded="true" >Normal</a>
                                        </li>
                                        <li class=""><a href="#normalnormal" data-toggle="tab" aria-expanded="true" >Normal,Normal</a>
                                        </li>

                                    </ul>
                                    <?php
                                } else if ($_GET['worktype'] == 'sh') {
                                    ?>
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#shplan" data-toggle="tab" aria-expanded="true" >SH</a>
                                        </li>
                                        <li class=""><a href="#shsh" data-toggle="tab" aria-expanded="true" >SH,SH</a>
                                        </li>
                                        <li class=""><a href="#normalsh" data-toggle="tab" aria-expanded="false">Normal,SH</a>   </li>

                                    </ul>
                                    <?php
                                } else if ($_GET['worktype'] == 'sh(n)') {
                                    ?>
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#shnormal" data-toggle="tab" aria-expanded="true" >SH(N)</a>
                                        </li>
                                    </ul>
                                    <?php
                                }
                                ?>




                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <p>&nbsp;</p>

                                    <?php
                                    if ($_GET['worktype'] == 'nm') { ///งานnm
                                        ?>
                                        <div class="tab-pane fade active in" id="normal">
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    &nbsp;
                                                </div>
                                                <div class="col-lg-1" style="text-align: right">
                                                    <font style="color: red">* </font><label>ช่วงวันที่</label>
                                                </div>
                                                <div class="col-lg-3">

                                                    <input type="text" name="txt_copydiagramjobnomonday" id="txt_copydiagramjobnomonday" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnotuesday" id="txt_copydiagramjobnotuesday" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnowednesday" id="txt_copydiagramjobnowednesday" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnothursday" id="txt_copydiagramjobnothursday" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnofriday" id="txt_copydiagramjobnofriday" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnosaturday" id="txt_copydiagramjobnosaturday" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnosunday" id="txt_copydiagramjobnosunday" class="form-control" style="display: none">

                                                    <input type="text" name="txt_copydiagramdatestart"  readonly="" id="txt_copydiagramdatestart" onchange="add_dateweek(this.value)" class="form-control dateen" placeholder="วันที่เริ่มต้น...">

                                                </div>
                                                <div class="col-lg-3">
                                                    <input type="text" name="txt_copydiagramdateend" style="background-color: #f080802e"  disabled="" id="txt_copydiagramdateend" class="form-control dateen" placeholder="วันที่สิ้นสิ้นสุด...">
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12"><hr></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-2"><b><u>Normal1</u></b></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>พขร.(1) :</label>
                                                    <input type="text"  name="txt_copydiagramemployeename1" id="txt_copydiagramemployeename1" class="form-control">
                                                </div>
                                                <div class="col-lg-1">
                                                    <label>&nbsp;</label><br>

                                                    <button class="btn btn-secondary"  id="btn_checkdriver" onclick="select_checkdriversr('1')"  name="btn_checkdriver" data-toggle="modal"  data-target="#modal_checkdriver"><span class="fa fa-check"></span> พขร.(1)</button>
                                                </div>

                                                <div class="col-lg-2">
                                                    <label>พขร.(2) :</label> <!--<div id="div_jobendemp2">-</div >-->
                                                    <input type="text"  class="form-control" name="txt_copydiagramemployeename2" id="txt_copydiagramemployeename2">
                                                </div>
                                                <div class="col-lg-1">
                                                    <label>&nbsp;</label><br>
                                                    <button class="btn btn-secondary"  id="btn_checkdriver" onclick="select_checkdriversr('2')"  name="btn_checkdriver" data-toggle="modal"  data-target="#modal_checkdriver"><span class="fa fa-check"></span> พขร.(2)</button>
                                                </div>

                                                <div class="col-lg-2">
                                                    <label>พขร.(ควบคุม)(3) :</label>
                                                    <input type="text"  class="form-control" name="txt_copydiagramemployeename3" id="txt_copydiagramemployeename3">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>&nbsp;</label><br>
                                                    <button class="btn btn-secondary"  id="btn_checkdriver" onclick="select_checkdriversr('3')"  name="btn_checkdriver" data-toggle="modal"  data-target="#modal_checkdriver"><span class="fa fa-check"></span> พขร.(ควบคุม)(3)</button>
                                                </div>

                                                <div class="col-lg-2">
                                                    <label>จำนวนคัน(กรณีงานรับกลับ) :</label>
                                                    <input  type="text" class="form-control"  id="txt_copydiagramunit"  name="txt_copydiagramunit">
                                                </div>




                                            </div>
                                            <div class="row">

                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>ชื่อรถ :</label>
                                                    <input type="text" class="form-control"  id="txt_copydiagramthainame" name="txt_copydiagramthainame">

                                                </div>
                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>ชื่อรถ(หาง) :</label>
                                                    <input type="text" class="form-control"  id="txt_copydiagramthainame2" name="txt_copydiagramthainame2">
                                                </div>


                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>ต้นทาง(Normal1) :</label>
                                                    <select multiple="multiple"  id="txt_copydiagramjobstart11" name="txt_copydiagramjobstart11" style="width: 100%">
                                                        <option value="">เลือกต้นทาง</option>
                                                        <option value="GW">GW</option>
                                                        <option value="BP">BP</option>
                                                        <option value="SR">SR</option>
                                                        <option value="TAC">TAC</option>
                                                        <option value="OTH">OTH</option>
                                                        <option value="SW">SW</option>
                                                        <option value="SP">SP</option>
                                                        <option value="BP25RAI">BP25RAI</option>
                                                    </select>
                                                </div>



                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>CLUSTER(Normal1) :</label>

                                                    <div class="dropdown bootstrap-select show-tick form-control">

                                                        <select multiple="" onchange="select_cluster()" id="cb_copydiagramcluster" name="cb_copydiagramcluster" class="selectpicker form-control"  data-container="body" data-live-search="true" title="เลือก cluster..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98">
                                                            <?php
                                                            $condiCluster1 = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "'";
                                                            $sql_seCluster = "{call megVehicletransportprice_v2(?,?,?,?)}";
                                                            $params_seCluster = array(
                                                                array('select_cluster', SQLSRV_PARAM_IN),
                                                                array($condiCluster1, SQLSRV_PARAM_IN),
                                                                array('', SQLSRV_PARAM_IN),
                                                                array('', SQLSRV_PARAM_IN)
                                                            );
                                                            $query_seCluster = sqlsrv_query($conn, $sql_seCluster, $params_seCluster);
                                                            while ($result_seCluster = sqlsrv_fetch_array($query_seCluster, SQLSRV_FETCH_ASSOC)) {
                                                                ?>
                                                                <option value="<?= $result_seCluster['CLUSTER'] ?>"><?= $result_seCluster['CLUSTER'] ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <input class="form-control" style="display: none"  id="txt_copydiagramcluster" name="txt_copydiagramcluster" maxlength="500" value="" >
                                                        <input class="form-control" style="display: none"  id="txt_copydiagramcompany" name="txt_copydiagramcompany" maxlength="500" value="<?= $_GET['companycode'] ?>" >
                                                        <input class="form-control" style="display: none"  id="txt_copydiagramcustomer" name="txt_copydiagramcustomer" maxlength="500" value="<?= $_GET['customercode'] ?>" >

                                                        <div class="dropdown-menu open" role="combobox">
                                                            <div class="bs-searchbox">
                                                                <input type="text" class="form-control" autocomplete="off" role="textbox" aria-label="Search"></div>
                                                            <div class="bs-actionsbox">
                                                                <div class="btn-group btn-group-sm btn-block">
                                                                    <button type="button" class="actions-btn bs-select-all btn btn-default">Select All</button>
                                                                    <button type="button" class="actions-btn bs-deselect-all btn btn-default">Deselect All</button>
                                                                </div>
                                                            </div>
                                                            <div class="inner open" role="listbox" aria-expanded="false" tabindex="-1">
                                                                <ul class="dropdown-menu inner "></ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-lg-2">

                                                    <font style="color: red">* </font><label>ปลายทาง(Normal1) :</label>
                                                    <div id="data_copydiagramjobenddef">
                                                        <div class="dropdown bootstrap-select show-tick form-control">

                                                            <select multiple="" id="cb_copydiagramjobend" name="cb_copydiagramjobend" class="selectpicker form-control"  data-container="body" data-live-search="true" title="เลือก ปลายทาง..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >

                                                            </select>
                                                            <input class="form-control" style="display: none"   id="txt_copydiagramjobend" name="txt_copydiagramjobend" maxlength="500" value="" >


                                                            <div class="dropdown-menu open" role="combobox">
                                                                <div class="bs-searchbox">
                                                                    <input type="text" class="form-control" autocomplete="off" role="textbox" aria-label="Search"></div>
                                                                <div class="bs-actionsbox">
                                                                    <div class="btn-group btn-group-sm btn-block">
                                                                        <button type="button" class="actions-btn bs-select-all btn btn-default">Select All</button>
                                                                        <button type="button" class="actions-btn bs-deselect-all btn btn-default">Deselect All</button>
                                                                    </div>
                                                                </div>
                                                                <div class="inner open" role="listbox" aria-expanded="false" tabindex="-1">
                                                                    <ul class="dropdown-menu inner "></ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="data_copydiagramjobendsr"></div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>ก่อนเวลารายงานตัว (OTH)1 :</label>
                                                    <input type="text" class="form-control"  id="txt_beforpersentoth"  name="txt_beforpersentoth">
                                                </div>






                                            </div>

                                            <div class="row">&nbsp;</div>
											<div class="row">                            
                                                <div class="col-lg-2">
                                                    <label>รอบที่วิ่งงาน :</label>
                                                    <select id="txt_roundamount" name="txt_roundamount" class="form-control">
                                                        <option value disabled selected>-เลือกรอบที่วิ่งงาน-</option>
                                                        <option value="1">รอบที่ 1</option>
                                                        <option value="2">รอบที่ 2</option>
                                                        <option value="3">รอบที่ 3</option>
                                                        <option value="4">รอบที่ 4</option>
                                                    </select>                                
                                                </div>
                                            </div>
                                            <div class="row">&nbsp;</div>
                                            <div class="row">


                                                <input  type="text" class="form-control" value="<?= $result_seSystime['SYSTIME'] ?>" style="background-color: #f080802e;display: none" disabled="" id="txt_copydiagramdateinput" name="txt_copydiagramdateinput">

                                                <div class="col-lg-2">
                                                    <label>เวลารายงานตัว :</label>
                                                    <input type="text" class="form-control timeen" style="background-color: #f080802e" disabled="" id="txt_copydiagramdatepresent" name="txt_copydiagramdatepresent">

                                                </div>

                                                <div class="col-lg-2">
                                                    <label>เวลาเริ่มงาน ( <input type="checkbox" id="chk_copydiagramdaterk" name="chk_copydiagramdaterk" onchange="change_textboxdate()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdaterk" name="txt_copydiagramdaterk" onchange="show_timepresent(this.value)" autocomplete="off">
                                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdaterk2" name="txt_copydiagramdaterk2" onchange="show_timepresent(this.value)" style="display: none" autocomplete="off">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>เวลาเข้า(ลูกค้า) ( <input type="checkbox" id="chk_copydiagramdatevlin" name="chk_copydiagramdatevlin" onchange="change_textboxdate()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatevlin" name="txt_copydiagramdatevlin" autocomplete="off" autocomplete="off">
                                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdatevlin2" name="txt_copydiagramdatevlin2"  style="display: none" autocomplete="off">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>เวลาออก(ลูกค้า) ( <input type="checkbox" id="chk_copydiagramdatevlout" name="chk_copydiagramdatevlout" onchange="change_textboxdate()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatevlout" name="txt_copydiagramdatevlout" autocomplete="off">
                                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdatevlout2" name="txt_copydiagramdatevlout2" style="display: none" autocomplete="off">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>เวลาเข้า(ลูกค้า2) ( <input type="checkbox" id="chk_copydiagramdatedealerin" name="chk_copydiagramdatedealerin" onchange="change_textboxdate()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatedealerin" name="txt_copydiagramdatedealerin" autocomplete="off">
                                                    <input type="text" class="form-control  datetimeen" id="txt_copydiagramdatedealerin2" name="txt_copydiagramdatedealerin2" style="display: none" autocomplete="off">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>เวลากลับบริษัท ( <input type="checkbox" id="chk_copydiagramdatereturn" name="chk_copydiagramdatereturn" onchange="change_textboxdate()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatereturn" name="txt_copydiagramdatereturn" autocomplete="off">
                                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdatereturn2" name="txt_copydiagramdatereturn2" style="display: none" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="row">&nbsp;</div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="well" va>
                                                        <div class="row">
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" id="chk_copydiagrammonday" name="chk_copydiagrammonday" checked="" value="" style="transform: scale(2)">&nbsp;<label>จันทร์</label><label id="lab_monday"></label>
                                                                </label>
                                                            </div>

                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" id="chk_copydiagramtuesday" name="chk_copydiagramtuesday" checked="" value="" style="transform: scale(2)">&nbsp;<label>อังคาร</label><label id="lab_tuesday"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" checked="" id="chk_copydiagramwednesday" name="chk_copydiagramwednesday" value="" style="transform: scale(2)">&nbsp;<label>พุธ</label><label id="lab_wednesday"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" checked="" id="chk_copydiagramthursday" name="chk_copydiagramthursday" value="" style="transform: scale(2)">&nbsp;<label>พฤหัสบดี</label><label id="lab_thursday"></label>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" checked="" id="chk_copydiagramfriday" name="chk_copydiagramfriday" value="" style="transform: scale(2)">&nbsp;<label>ศุกร์</label><label id="lab_friday"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" checked="" id="chk_copydiagramsaturday" name="chk_copydiagramsaturday" value="" style="transform: scale(2)">&nbsp;<label>เสาร์</label><label id="lab_saturday"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" id="chk_copydiagramsunday" name="chk_copydiagramsunday" checked="" value="" style="transform: scale(2)">&nbsp;<label>อาทิตย์</label><label id="lab_sunday"></label>
                                                                </label>
                                                            </div>
                                                        </div>


                                                    </div>
                                                    <div class="row" >
                                                        <div class="col-lg-12 text-right">

                                                            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                                                            <button type="button" class="btn btn-primary" onclick="save_copydiagram()">บันทึก</button>
                                                        </div>
                                                    </div>
                                                </div>





                                            </div>
                                        </div>

                                        <div class="tab-pane fade " id="normalnormal">
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    &nbsp;
                                                </div>
                                                <div class="col-lg-1" style="text-align: right">
                                                    <font style="color: red">* </font><label>ช่วงวันที่</label>
                                                </div>
                                                <div class="col-lg-3">

                                                    <input type="text" name="txt_copydiagramjobnomonday21" id="txt_copydiagramjobnomonday21" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnotuesday21" id="txt_copydiagramjobnotuesday21" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnowednesday21" id="txt_copydiagramjobnowednesday21" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnothursday21" id="txt_copydiagramjobnothursday21" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnofriday21" id="txt_copydiagramjobnofriday21" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnosaturday21" id="txt_copydiagramjobnosaturday21" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnosunday21" id="txt_copydiagramjobnosunday21" class="form-control" style="display: none">

                                                    <input type="text" name="txt_copydiagramjobnomonday22" id="txt_copydiagramjobnomonday22" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnotuesday22" id="txt_copydiagramjobnotuesday22" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnowednesday22" id="txt_copydiagramjobnowednesday22" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnothursday22" id="txt_copydiagramjobnothursday22" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnofriday22" id="txt_copydiagramjobnofriday22" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnosaturday22" id="txt_copydiagramjobnosaturday22" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnosunday22" id="txt_copydiagramjobnosunday22" class="form-control" style="display: none">

                                                    <input type="text" name="txt_copydiagramdatestartnn"  readonly="" id="txt_copydiagramdatestartnn" onchange="add_dateweeknn(this.value)" class="form-control dateen" placeholder="วันที่เริ่มต้น...">

                                                </div>
                                                <div class="col-lg-3">
                                                    <input type="text" name="txt_copydiagramdateendnn" style="background-color: #f080802e"  disabled="" id="txt_copydiagramdateendnn" class="form-control dateen" placeholder="วันที่สิ้นสิ้นสุด...">
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12"><hr></div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-2"><b><u>Normal11</u></b></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>พขร.(1) :</label>
                                                    <input type="text"  name="txt_copydiagramemployeename21_1" id="txt_copydiagramemployeename21_1" class="form-control">
                                                </div>
                                                <div class="col-lg-1">
                                                    <label>&nbsp;</label><br>

                                                    <button class="btn btn-secondary"  id="btn_checkdriver" onclick="select_checkdriversr('1')"  name="btn_checkdriver" data-toggle="modal"  data-target="#modal_checkdriver"><span class="fa fa-check"></span> พขร.(1)</button>
                                                </div>

                                                <div class="col-lg-2">
                                                    <label>พขร.(2) :</label>
                                                    <input type="text"  class="form-control" name="txt_copydiagramemployeename21_2" id="txt_copydiagramemployeename21_2">
                                                </div>
                                                <div class="col-lg-1">
                                                    <label>&nbsp;</label><br>
                                                    <button class="btn btn-secondary"  id="btn_checkdriver" onclick="select_checkdriversr('2')"  name="btn_checkdriver" data-toggle="modal"  data-target="#modal_checkdriver"><span class="fa fa-check"></span> พขร.(2)</button>
                                                </div>

                                                <div class="col-lg-2">
                                                    <label>พขร.(ควบคุม)(3) :</label>
                                                    <input type="text"  class="form-control" name="txt_copydiagramemployeename21_3" id="txt_copydiagramemployeename21_3">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>&nbsp;</label><br>
                                                    <button class="btn btn-secondary"  id="btn_checkdriver" onclick="select_checkdriversr('3')"  name="btn_checkdriver" data-toggle="modal"  data-target="#modal_checkdriver"><span class="fa fa-check"></span> พขร.(ควบคุม)(3)</button>
                                                </div>

                                                <div class="col-lg-2">
                                                    <label>จำนวนคัน(กรณีงานรับกลับ) :</label>
                                                    <input  type="text" class="form-control"  id="txt_copydiagramunit21"  name="txt_copydiagramunit21">
                                                </div>




                                            </div>
                                            <div class="row">
                                                <?php
                                                ?>
                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>ชื่อรถ :</label>
                                                    <input type="text" class="form-control"  id="txt_copydiagramthainame21_1" name="txt_copydiagramthainame21_1">

                                                </div>
                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>ชื่อรถ(หาง) :</label>
                                                    <input type="text" class="form-control"  id="txt_copydiagramthainame21_2" name="txt_copydiagramthainame21_2">
                                                </div>


                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>ต้นทาง(Normal11) :</label>
                                                    <select multiple="multiple" id="txt_copydiagramjobstart21" name="txt_copydiagramjobstart21" class="form-control" style="width: 100%">
                                                        <option value="">เลือกต้นทาง</option>
                                                        <option value="GW">GW</option>
                                                        <option value="BP">BP</option>
                                                        <option value="SR">SR</option>
                                                        <option value="TAC">TAC</option>
                                                        <option value="OTH">OTH</option>
                                                        <option value="SW">SW</option>
                                                        <option value="SP">SP</option>
                                                        <option value="BP25RAI">BP25RAI</option>
                                                    </select>
                                                </div>



                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>CLUSTER(Normal11) :</label>




                                                    <select multiple="multiple"  onchange="select_cluster21(this.value)" id="cb_copydiagramcluster21" name="cb_copydiagramcluster21" class="form-control"  style="width: 100%">
                                                        <?php
                                                        $condiCluster21 = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "' ";
                                                        $sql_seCluster21 = "{call megVehicletransportprice_v2(?,?,?,?)}";
                                                        $params_seCluster21 = array(
                                                            array('select_cluster', SQLSRV_PARAM_IN),
                                                            array($condiCluster21, SQLSRV_PARAM_IN),
                                                            array('', SQLSRV_PARAM_IN),
                                                            array('', SQLSRV_PARAM_IN)
                                                        );
                                                        $query_seCluster21 = sqlsrv_query($conn, $sql_seCluster21, $params_seCluster21);
                                                        while ($result_seCluster21 = sqlsrv_fetch_array($query_seCluster21, SQLSRV_FETCH_ASSOC)) {
                                                            ?>
                                                            <option value="<?= $result_seCluster21['CLUSTER'] ?>"><?= $result_seCluster21['CLUSTER'] ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <input class="form-control" style="display:none"  id="txt_copydiagramcluster21" name="txt_copydiagramcluster21" maxlength="500" value="" >
                                                    <input class="form-control" style="display:none"  id="txt_copydiagramcompany21" name="txt_copydiagramcompany21" maxlength="500" value="<?= $_GET['companycode'] ?>" >
                                                    <input class="form-control" style="display:none"  id="txt_copydiagramcustomer21" name="txt_copydiagramcustomer21" maxlength="500" value="<?= $_GET['customercode'] ?>" >




                                                </div>





                                                <div class="col-lg-2">

                                                    <font style="color: red">* </font><label>ปลายทาง(Normal11) :</label>
                                                    <div id="data_copydiagramjobenddef21">
                                                        <div class="dropdown bootstrap-select show-tick form-control">

                                                            <select multiple="" id="cb_copydiagramjobend21" name="cb_copydiagramjobend21" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก ปลายทาง..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >

                                                            </select>
                                                            <input class="form-control" style="display:none"   id="txt_copydiagramjobend21" name="txt_copydiagramjobend21" maxlength="500" value="" >


                                                            <div class="dropdown-menu open" role="combobox">
                                                                <div class="bs-searchbox">
                                                                    <input type="text" class="form-control" autocomplete="off" role="textbox" aria-label="Search"></div>
                                                                <div class="bs-actionsbox">
                                                                    <div class="btn-group btn-group-sm btn-block">
                                                                        <button type="button" class="actions-btn bs-select-all btn btn-default">Select All</button>
                                                                        <button type="button" class="actions-btn bs-deselect-all btn btn-default">Deselect All</button>
                                                                    </div>
                                                                </div>
                                                                <div class="inner open" role="listbox" aria-expanded="false" tabindex="-1">
                                                                    <ul class="dropdown-menu inner "></ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="data_copydiagramjobendsr21"></div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>ก่อนเวลารายงานตัว (OTH) :</label>
                                                    <input type="text" class="form-control"  id="txt_beforpersentoth21"  name="txt_beforpersentoth21">
                                                </div>






                                            </div>

                                            <div class="row">&nbsp;</div>
											<div class="row">                            
                                                <div class="col-lg-2">
                                                    <label>รอบที่วิ่งงาน :</label>
                                                    <select id="txt_roundamount21" name="txt_roundamount21" class="form-control">
                                                        <option value disabled selected>-เลือกรอบที่วิ่งงาน-</option>
                                                        <option value="1">รอบที่ 1</option>
                                                        <option value="2">รอบที่ 2</option>
                                                        <option value="3">รอบที่ 3</option>
                                                        <option value="4">รอบที่ 4</option>
                                                    </select>                                
                                                </div>
                                            </div>
                                            <div class="row">&nbsp;</div>
                                            <div class="row">


                                                <input  type="text" class="form-control" value="<?= $result_seSystime['SYSTIME'] ?>" style="background-color: #f080802e;display: none" disabled="" id="txt_copydiagramdateinput21" name="txt_copydiagramdateinput21">

                                                <div class="col-lg-2">
                                                    <label>เวลารายงานตัว :</label>
                                                    <input type="text" class="form-control timeen" style="background-color: #f080802e" disabled="" id="txt_copydiagramdatepresent21" name="txt_copydiagramdatepresent21">

                                                </div>

                                                <div class="col-lg-2">
                                                    <label>เวลาเริ่มงาน ( <input type="checkbox" id="chk_copydiagramdaterk21" name="chk_copydiagramdaterk21" onchange="change_textboxdate21()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdaterk21" name="txt_copydiagramdaterk21" onchange="show_timepresent21(this.value)" autocomplete="off">
                                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdaterk221" name="txt_copydiagramdaterk221" onchange="show_timepresent21(this.value)" style="display: none" autocomplete="off">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>เวลาเข้า(ลูกค้า) ( <input type="checkbox" id="chk_copydiagramdatevlin21" name="chk_copydiagramdatevlin21" onchange="change_textboxdate21()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatevlin21" name="txt_copydiagramdatevlin21" autocomplete="off" autocomplete="off">
                                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdatevlin221" name="txt_copydiagramdatevlin221"  style="display: none" autocomplete="off">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>เวลาออก(ลูกค้า) ( <input type="checkbox" id="chk_copydiagramdatevlout21" name="chk_copydiagramdatevlout21" onchange="change_textboxdate21()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatevlout21" name="txt_copydiagramdatevlout21" autocomplete="off">
                                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdatevlout221" name="txt_copydiagramdatevlout221" style="display: none" autocomplete="off">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>เวลาเข้า(ลูกค้า2) ( <input type="checkbox" id="chk_copydiagramdatedealerin21" name="chk_copydiagramdatedealerin21" onchange="change_textboxdate21()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatedealerin21" name="txt_copydiagramdatedealerin21" autocomplete="off">
                                                    <input type="text" class="form-control  datetimeen" id="txt_copydiagramdatedealerin221" name="txt_copydiagramdatedealerin221" style="display: none" autocomplete="off">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>เวลากลับบริษัท ( <input type="checkbox" id="chk_copydiagramdatereturn21" name="chk_copydiagramdatereturn21" onchange="change_textboxdate21()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatereturn21" name="txt_copydiagramdatereturn21" autocomplete="off">
                                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdatereturn221" name="txt_copydiagramdatereturn221" style="display: none" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="row">&nbsp;</div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="well" va>
                                                        <div class="row">
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" id="chk_copydiagrammonday21" name="chk_copydiagrammonday21" checked="" value="" style="transform: scale(2)">&nbsp;<label>จันทร์</label><label id="lab_monday21"></label>
                                                                </label>
                                                            </div>

                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" id="chk_copydiagramtuesday21" name="chk_copydiagramtuesday21" checked="" value="" style="transform: scale(2)">&nbsp;<label>อังคาร</label><label id="lab_tuesday21"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" checked="" id="chk_copydiagramwednesday21" name="chk_copydiagramwednesday21" value="" style="transform: scale(2)">&nbsp;<label>พุธ</label><label id="lab_wednesday21"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" checked="" id="chk_copydiagramthursday21" name="chk_copydiagramthursday21" value="" style="transform: scale(2)">&nbsp;<label>พฤหัสบดี</label><label id="lab_thursday21"></label>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" checked="" id="chk_copydiagramfriday21" name="chk_copydiagramfriday21" value="" style="transform: scale(2)">&nbsp;<label>ศุกร์</label><label id="lab_friday21"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" checked="" id="chk_copydiagramsaturday21" name="chk_copydiagramsaturday21" value="" style="transform: scale(2)">&nbsp;<label>เสาร์</label><label id="lab_saturday21"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" id="chk_copydiagramsunday21" name="chk_copydiagramsunday21" checked="" value="" style="transform: scale(2)">&nbsp;<label>อาทิตย์</label><label id="lab_sunday21"></label>
                                                                </label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>





                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12"><hr></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-2"><b><u>Normal12</u></b></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>พขร.(1) :</label>
                                                    <input type="text"  name="txt_copydiagramemployeename22_1" id="txt_copydiagramemployeename22_1" class="form-control">
                                                </div>
                                                <div class="col-lg-1">
                                                    <label>&nbsp;</label><br>

                                                    <button class="btn btn-secondary"  id="btn_checkdriver" onclick="select_checkdriversr('1')"  name="btn_checkdriver" data-toggle="modal"  data-target="#modal_checkdriver"><span class="fa fa-check"></span> พขร.(1)</button>
                                                </div>

                                                <div class="col-lg-2">
                                                    <label>พขร.(2) :</label> <!--<div id="div_jobendemp2">-</div >-->
                                                    <input type="text"  class="form-control" name="txt_copydiagramemployeename22_2" id="txt_copydiagramemployeename22_2">
                                                </div>
                                                <div class="col-lg-1">
                                                    <label>&nbsp;</label><br>
                                                    <button class="btn btn-secondary"  id="btn_checkdriver" onclick="select_checkdriversr('2')"  name="btn_checkdriver" data-toggle="modal"  data-target="#modal_checkdriver"><span class="fa fa-check"></span> พขร.(2)</button>
                                                </div>

                                                <div class="col-lg-2">
                                                    <label>พขร.(ควบคุม)(3) :</label>
                                                    <input type="text"  class="form-control" name="txt_copydiagramemployeename22_3" id="txt_copydiagramemployeename22_3">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>&nbsp;</label><br>
                                                    <button class="btn btn-secondary"  id="btn_checkdriver" onclick="select_checkdriversr('3')"  name="btn_checkdriver" data-toggle="modal"  data-target="#modal_checkdriver"><span class="fa fa-check"></span> พขร.(ควบคุม)(3)</button>
                                                </div>

                                                <div class="col-lg-2">
                                                    <label>จำนวนคัน(กรณีงานรับกลับ) :</label>
                                                    <input  type="text" class="form-control"  id="txt_copydiagramunit22"  name="txt_copydiagramunit22">
                                                </div>




                                            </div>
                                            <div class="row">

                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>ชื่อรถ :</label>
                                                    <input type="text" class="form-control"  id="txt_copydiagramthainame22_1" name="txt_copydiagramthainame22_1">

                                                </div>
                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>ชื่อรถ(หาง) :</label>
                                                    <input type="text" class="form-control"  id="txt_copydiagramthainame22_2" name="txt_copydiagramthainame22_2">
                                                </div>


                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>ต้นทาง(Normal12) :</label>
                                                    <select multiple="multiple" id="txt_copydiagramjobstart22" name="txt_copydiagramjobstart22" class="form-control" style="width: 100%">
                                                        <option value="">เลือกต้นทาง</option>
                                                        <option value="GW">GW</option>
                                                        <option value="BP">BP</option>
                                                        <option value="SR">SR</option>
                                                        <option value="TAC">TAC</option>
                                                        <option value="OTH">OTH</option>
                                                        <option value="SW">SW</option>
                                                        <option value="SP">SP</option>
                                                        <option value="BP25RAI">BP25RAI</option>
                                                    </select>
                                                </div>



                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>CLUSTER(Normal12) :</label>


                                                    <select multiple="multiple"  onchange="select_cluster22(this.value)" id="cb_copydiagramcluster22" name="cb_copydiagramcluster22" class="form-control"  style="width: 100%">

                                                        <?php
                                                        $condiCluster22 = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "'";
                                                        $sql_seCluster22 = "{call megVehicletransportprice_v2(?,?,?,?)}";
                                                        $params_seCluster22 = array(
                                                            array('select_cluster', SQLSRV_PARAM_IN),
                                                            array($condiCluster22, SQLSRV_PARAM_IN),
                                                            array('', SQLSRV_PARAM_IN),
                                                            array('', SQLSRV_PARAM_IN)
                                                        );
                                                        $query_seCluster22 = sqlsrv_query($conn, $sql_seCluster22, $params_seCluster22);
                                                        while ($result_seCluster22 = sqlsrv_fetch_array($query_seCluster22, SQLSRV_FETCH_ASSOC)) {
                                                            ?>
                                                            <option value="<?= $result_seCluster22['CLUSTER'] ?>"><?= $result_seCluster22['CLUSTER'] ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <input class="form-control" style="display:none"  id="txt_copydiagramcluster22" name="txt_copydiagramcluster22" maxlength="500" value="" >
                                                    <input class="form-control" style="display:none"  id="txt_copydiagramcompany22" name="txt_copydiagramcompany22" maxlength="500" value="<?= $_GET['companycode'] ?>" >
                                                    <input class="form-control" style="display:none"  id="txt_copydiagramcustomer22" name="txt_copydiagramcustomer22" maxlength="500" value="<?= $_GET['customercode'] ?>" >



                                                </div>





                                                <div class="col-lg-2">

                                                    <font style="color: red">* </font><label>ปลายทาง(Normal12) :</label>
                                                    <div id="data_copydiagramjobenddef22">
                                                        <div class="dropdown bootstrap-select show-tick form-control">

                                                            <select multiple="" id="cb_copydiagramjobend22" name="cb_copydiagramjobend22" class="selectpicker form-control"  data-container="body" data-live-search="true" title="เลือก ปลายทาง..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >

                                                            </select>
                                                            <input class="form-control" style="display:none"   id="txt_copydiagramjobend22" name="txt_copydiagramjobend22" maxlength="500" value="" >


                                                            <div class="dropdown-menu open" role="combobox">
                                                                <div class="bs-searchbox">
                                                                    <input type="text" class="form-control" autocomplete="off" role="textbox" aria-label="Search"></div>
                                                                <div class="bs-actionsbox">
                                                                    <div class="btn-group btn-group-sm btn-block">
                                                                        <button type="button" class="actions-btn bs-select-all btn btn-default">Select All</button>
                                                                        <button type="button" class="actions-btn bs-deselect-all btn btn-default">Deselect All</button>
                                                                    </div>
                                                                </div>
                                                                <div class="inner open" role="listbox" aria-expanded="false" tabindex="-1">
                                                                    <ul class="dropdown-menu inner "></ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="data_copydiagramjobendsr22"></div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>ก่อนเวลารายงานตัว (OTH) :</label>
                                                    <input type="text" class="form-control"  id="txt_beforpersentoth22"  name="txt_beforpersentoth22">
                                                </div>





                                            </div>

                                            <div class="row">&nbsp;</div>
											<div class="row">                            
                                                <div class="col-lg-2">
                                                    <label>รอบที่วิ่งงาน :</label>
                                                    <select id="txt_roundamount22" name="txt_roundamount22" class="form-control">
                                                        <option value disabled selected>-เลือกรอบที่วิ่งงาน-</option>
                                                        <option value="1">รอบที่ 1</option>
                                                        <option value="2">รอบที่ 2</option>
                                                        <option value="3">รอบที่ 3</option>
                                                        <option value="4">รอบที่ 4</option>
                                                    </select>                                
                                                </div>
                                            </div>
                                            <div class="row">&nbsp;</div>
                                            <div class="row">


                                                <input  type="text" class="form-control" value="<?= $result_seSystime['SYSTIME'] ?>" style="background-color: #f080802e;display: none" disabled="" id="txt_copydiagramdateinput22" name="txt_copydiagramdateinput22">

                                                <div class="col-lg-2">
                                                    <label>เวลารายงานตัว :</label>
                                                    <input type="text" class="form-control timeen" style="background-color: #f080802e" disabled="" id="txt_copydiagramdatepresent22" name="txt_copydiagramdatepresent22">

                                                </div>

                                                <div class="col-lg-2">
                                                    <label>เวลาเริ่มงาน ( <input type="checkbox" id="chk_copydiagramdaterk22" name="chk_copydiagramdaterk22" onchange="change_textboxdate22()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdaterk22" name="txt_copydiagramdaterk22" onchange="show_timepresent22(this.value)" autocomplete="off">
                                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdaterk222" name="txt_copydiagramdaterk222" onchange="show_timepresent22(this.value)" style="display: none" autocomplete="off">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>เวลาเข้า(ลูกค้า) ( <input type="checkbox" id="chk_copydiagramdatevlin22" name="chk_copydiagramdatevlin22" onchange="change_textboxdate22()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatevlin22" name="txt_copydiagramdatevlin22" autocomplete="off" autocomplete="off">
                                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdatevlin222" name="txt_copydiagramdatevlin222"  style="display: none" autocomplete="off">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>เวลาออก(ลูกค้า) ( <input type="checkbox" id="chk_copydiagramdatevlout22" name="chk_copydiagramdatevlout22" onchange="change_textboxdate22()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatevlout22" name="txt_copydiagramdatevlout22" autocomplete="off">
                                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdatevlout222" name="txt_copydiagramdatevlout222" style="display: none" autocomplete="off">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>เวลาเข้า(ลูกค้า2) ( <input type="checkbox" id="chk_copydiagramdatedealerin22" name="chk_copydiagramdatedealerin22" onchange="change_textboxdate22()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatedealerin22" name="txt_copydiagramdatedealerin22" autocomplete="off">
                                                    <input type="text" class="form-control  datetimeen" id="txt_copydiagramdatedealerin222" name="txt_copydiagramdatedealerin222" style="display: none" autocomplete="off">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>เวลากลับบริษัท ( <input type="checkbox" id="chk_copydiagramdatereturn22" name="chk_copydiagramdatereturn22" onchange="change_textboxdate22()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatereturn22" name="txt_copydiagramdatereturn22" autocomplete="off">
                                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdatereturn222" name="txt_copydiagramdatereturn222" style="display: none" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="row">&nbsp;</div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="well" va>
                                                        <div class="row">
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" id="chk_copydiagrammonday22" name="chk_copydiagrammonday22" checked="" value="" style="transform: scale(2)">&nbsp;<label>จันทร์</label><label id="lab_monday22"></label>
                                                                </label>
                                                            </div>

                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" id="chk_copydiagramtuesday22" name="chk_copydiagramtuesday22" checked="" value="" style="transform: scale(2)">&nbsp;<label>อังคาร</label><label id="lab_tuesday22"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" checked="" id="chk_copydiagramwednesday22" name="chk_copydiagramwednesday22" value="" style="transform: scale(2)">&nbsp;<label>พุธ</label><label id="lab_wednesday22"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" checked="" id="chk_copydiagramthursday22" name="chk_copydiagramthursday22" value="" style="transform: scale(2)">&nbsp;<label>พฤหัสบดี</label><label id="lab_thursday22"></label>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" checked="" id="chk_copydiagramfriday22" name="chk_copydiagramfriday22" value="" style="transform: scale(2)">&nbsp;<label>ศุกร์</label><label id="lab_friday22"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" checked="" id="chk_copydiagramsaturday22" name="chk_copydiagramsaturday22" value="" style="transform: scale(2)">&nbsp;<label>เสาร์</label><label id="lab_saturday22"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" id="chk_copydiagramsunday22" name="chk_copydiagramsunday22" checked="" value="" style="transform: scale(2)">&nbsp;<label>อาทิตย์</label><label id="lab_sunday22"></label>
                                                                </label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row" >
                                                        <div class="col-lg-12 text-right">

                                                            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                                                            <button type="button" class="btn btn-primary" onclick="save_copydiagramnn()">บันทึก</button>
                                                        </div>
                                                    </div>
                                                </div>





                                            </div>
                                        </div>





                                        <?php
                                    } else if ($_GET['worktype'] == 'sh') {
                                        ?>
                                        <div class="tab-pane fade active in" id="shplan">
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    &nbsp;
                                                </div>
                                                <div class="col-lg-1" style="text-align: right">
                                                    <font style="color: red">* </font><label>ช่วงวันที่</label>
                                                </div>
                                                <div class="col-lg-3">

                                                    <input type="text" name="txt_copydiagramjobnomonday" id="txt_copydiagramjobnomonday" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnotuesday" id="txt_copydiagramjobnotuesday" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnowednesday" id="txt_copydiagramjobnowednesday" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnothursday" id="txt_copydiagramjobnothursday" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnofriday" id="txt_copydiagramjobnofriday" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnosaturday" id="txt_copydiagramjobnosaturday" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnosunday" id="txt_copydiagramjobnosunday" class="form-control" style="display: none">



                                                    <input type="text" name="txt_copydiagramdatestart"  readonly="" id="txt_copydiagramdatestart" onchange="add_dateweeksh(this.value)" class="form-control dateen" placeholder="วันที่เริ่มต้น...">

                                                </div>
                                                <div class="col-lg-3">
                                                    <input type="text" name="txt_copydiagramdateend" style="background-color: #f080802e"  disabled="" id="txt_copydiagramdateend" class="form-control dateen" placeholder="วันที่สิ้นสิ้นสุด...">
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12"><hr></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-2"><b><u>SH1</u></b></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>พขร.(1) :</label>
                                                    <input type="text"  name="txt_copydiagramemployeename1" id="txt_copydiagramemployeename1" class="form-control">
                                                </div>
                                                <div class="col-lg-1">
                                                    <label>&nbsp;</label><br>

                                                    <button class="btn btn-secondary"  id="btn_checkdriver" onclick="select_checkdriversr('1')"  name="btn_checkdriver" data-toggle="modal"  data-target="#modal_checkdriver"><span class="fa fa-check"></span> พขร.(1)</button>
                                                </div>

                                                <div class="col-lg-2">
                                                    <label>พขร.(2) :</label> <!--<div id="div_jobendemp2">-</div >-->
                                                    <input type="text"  class="form-control" name="txt_copydiagramemployeename2" id="txt_copydiagramemployeename2">
                                                </div>
                                                <div class="col-lg-1">
                                                    <label>&nbsp;</label><br>
                                                    <button class="btn btn-secondary"  id="btn_checkdriver" onclick="select_checkdriversr('2')"  name="btn_checkdriver" data-toggle="modal"  data-target="#modal_checkdriver"><span class="fa fa-check"></span> พขร.(2)</button>
                                                </div>

                                                <div class="col-lg-2">
                                                    <label>พขร.(ควบคุม)(3) :</label>
                                                    <input type="text"  class="form-control" name="txt_copydiagramemployeename3" id="txt_copydiagramemployeename3">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>&nbsp;</label><br>
                                                    <button class="btn btn-secondary"  id="btn_checkdriver" onclick="select_checkdriversr('3')"  name="btn_checkdriver" data-toggle="modal"  data-target="#modal_checkdriver"><span class="fa fa-check"></span> พขร.(ควบคุม)(3)</button>
                                                </div>

                                                <div class="col-lg-2">
                                                    <label>จำนวนคัน(กรณีงานรับกลับ) :</label>
                                                    <input  type="text" class="form-control"  id="txt_copydiagramunit"  name="txt_copydiagramunit">
                                                </div>




                                            </div>
                                            <div class="row">

                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>ชื่อรถ :</label>
                                                    <input type="text" class="form-control"  id="txt_copydiagramthainame" name="txt_copydiagramthainame">

                                                </div>
                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>ชื่อรถ(หาง) :</label>
                                                    <input type="text" class="form-control"  id="txt_copydiagramthainame2" name="txt_copydiagramthainame2">
                                                </div>

                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>ต้นทาง(SH1) :</label>
                                                    <select  id="txt_copydiagramjobstart" name="txt_copydiagramjobstart" class="form-control" onchange="se_copydiagramroute(this.value)">
                                                        <option value="">เลือกต้นทาง</option>
                                                        <option value="GW">GW</option>
                                                        <option value="BP">BP</option>
                                                        <option value="SR">SR</option>
                                                        <option value="TAC">TAC</option>
                                                        <option value="OTH">OTH</option>
                                                        <option value="SW">SW</option>
                                                        <option value="SP">SP</option>
                                                        <option value="Lenso">Lenso</option>
                                                        <option value="BP25RAI">BP25RAI</option>
                                                        <option value="BP(STOCK48RAI)">BP(STOCK48RAI)</option>
                                                    </select>

                                                </div>
                                                <div class="col-lg-2">
                                                    <label>งาน(SH1) :</label><br>
                                                    <div id="copydiagramroutedef">
                                                        <select  id="cb_copydiagramroute" name="cb_copydiagramroute" class="form-control" >
                                                            <option value="">เลือกงาน</option>
                                                        </select>
                                                        <input class="form-control" style="display:none"  id="txt_companycode_sh" name="txt_companycodesh" maxlength="500" value="<?= $_GET['companycode'] ?>" >
                                                        <input class="form-control" style="display:none"  id="txt_customercode_sh" name="txt_customercode_sh" maxlength="500" value="<?= $_GET['customercode'] ?>" >
                                                        <input class="form-control" style="display:none"  id="txt_worktype_sh" name="txt_worktype_sh" maxlength="500" value="<?= $_GET['worktype'] ?>" >
                                                    </div>
                                                    <div id="copydiagramroutesr"></div>
                                                </div>


                                                <div class="col-lg-2">
                                                    <label>งานย่อย(SH1) :</label><br>
                                                    <div id="copydiagramsubroutedef">
                                                        <select  id="cb_copydiagramsubroute" name="cb_copydiagramsubroute" class="form-control" >
                                                            <option value="">เลือกงาน(ย่อย)</option>
                                                        </select>
                                                        <input class="form-control" style="display:none"  id="txt_companycode_sh" name="txt_companycodesh" maxlength="500" value="<?= $_GET['companycode'] ?>" >
                                                        <input class="form-control" style="display:none"  id="txt_customercode_sh" name="txt_customercode_sh" maxlength="500" value="<?= $_GET['customercode'] ?>" >
                                                        <input class="form-control" style="display:none"  id="txt_worktype_sh" name="txt_worktype_sh" maxlength="500" value="<?= $_GET['worktype'] ?>" >
                                                    </div>
                                                    <div id="copydiagramsubroutesr"></div>

                                                </div>

                                                <div class="col-lg-2">
                                                    <label>จำนวนโหลด :</label><br>
                                                    <select  id="cb_copydiagramload" name="cb_copydiagramload" class="form-control">
                                                        <option value="">เลือกจำนวนโหลด</option>
                                                        <option value="4">4 Load</option>
                                                        <option value="8">8 Load</option>

                                                    </select>
                                                </div>




                                            </div>

                                            <div class="row">&nbsp;</div>
											<div class="row">                            
                                                <div class="col-lg-2">
                                                    <label>รอบที่วิ่งงาน :</label>
                                                    <select id="txt_roundamount" name="txt_roundamount" class="form-control">
                                                        <option value disabled selected>-เลือกรอบที่วิ่งงาน-</option>
                                                        <option value="1">รอบที่ 1</option>
                                                        <option value="2">รอบที่ 2</option>
                                                        <option value="3">รอบที่ 3</option>
                                                        <option value="4">รอบที่ 4</option>
                                                    </select>                                
                                                </div>
                                            </div>
                                            <div class="row">&nbsp;</div>
                                            <div class="row">


                                                <input  type="text" class="form-control" value="<?= $result_seSystime['SYSTIME'] ?>" style="background-color: #f080802e;display: none" disabled="" id="txt_copydiagramdateinput" name="txt_copydiagramdateinput">

                                                <div class="col-lg-2">
                                                    <label>เวลารายงานตัว :</label>
                                                    <input type="text" class="form-control timeen" style="background-color: #f080802e" disabled="" id="txt_copydiagramdatepresent" name="txt_copydiagramdatepresent">

                                                </div>

                                                <div class="col-lg-2">
                                                    <label>เวลาเริ่มงาน1 ( <input type="checkbox" id="chk_copydiagramdaterk" name="chk_copydiagramdaterk" onchange="change_textboxdate()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdaterk" name="txt_copydiagramdaterk" onchange="show_timepresent(this.value)" autocomplete="off">
                                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdaterk2" name="txt_copydiagramdaterk2" onchange="show_timepresent(this.value)" style="display: none" autocomplete="off">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>เวลาเข้า(ลูกค้า) ( <input type="checkbox" id="chk_copydiagramdatevlin" name="chk_copydiagramdatevlin" onchange="change_textboxdate()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatevlin" name="txt_copydiagramdatevlin" autocomplete="off" autocomplete="off">
                                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdatevlin2" name="txt_copydiagramdatevlin2"  style="display: none" autocomplete="off">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>เวลาออก(ลูกค้า) ( <input type="checkbox" id="chk_copydiagramdatevlout" name="chk_copydiagramdatevlout" onchange="change_textboxdate()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatevlout" name="txt_copydiagramdatevlout" autocomplete="off">
                                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdatevlout2" name="txt_copydiagramdatevlout2" style="display: none" autocomplete="off">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>เวลาเข้า(ลูกค้า2) ( <input type="checkbox" id="chk_copydiagramdatedealerin" name="chk_copydiagramdatedealerin" onchange="change_textboxdate()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatedealerin" name="txt_copydiagramdatedealerin" autocomplete="off">
                                                    <input type="text" class="form-control  datetimeen" id="txt_copydiagramdatedealerin2" name="txt_copydiagramdatedealerin2" style="display: none" autocomplete="off">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>เวลากลับบริษัท ( <input type="checkbox" id="chk_copydiagramdatereturn" name="chk_copydiagramdatereturn" onchange="change_textboxdate()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatereturn" name="txt_copydiagramdatereturn" autocomplete="off">
                                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdatereturn2" name="txt_copydiagramdatereturn2" style="display: none" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="row">&nbsp;</div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="well" va>
                                                        <div class="row">
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" id="chk_copydiagrammonday" name="chk_copydiagrammonday" checked="" value="" style="transform: scale(2)">&nbsp;<label>จันทร์</label><label id="lab_monday"></label>
                                                                </label>
                                                            </div>

                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" id="chk_copydiagramtuesday" name="chk_copydiagramtuesday" checked="" value="" style="transform: scale(2)">&nbsp;<label>อังคาร</label><label id="lab_tuesday"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" checked="" id="chk_copydiagramwednesday" name="chk_copydiagramwednesday" value="" style="transform: scale(2)">&nbsp;<label>พุธ</label><label id="lab_wednesday"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" checked="" id="chk_copydiagramthursday" name="chk_copydiagramthursday" value="" style="transform: scale(2)">&nbsp;<label>พฤหัสบดี</label><label id="lab_thursday"></label>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" checked="" id="chk_copydiagramfriday" name="chk_copydiagramfriday" value="" style="transform: scale(2)">&nbsp;<label>ศุกร์</label><label id="lab_friday"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" checked="" id="chk_copydiagramsaturday" name="chk_copydiagramsaturday" value="" style="transform: scale(2)">&nbsp;<label>เสาร์</label><label id="lab_saturday"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" id="chk_copydiagramsunday" name="chk_copydiagramsunday" checked="" value="" style="transform: scale(2)">&nbsp;<label>อาทิตย์</label><label id="lab_sunday"></label>
                                                                </label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row" >
                                                        <div class="col-lg-12 text-right">

                                                            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                                                            <button type="button" class="btn btn-primary" onclick="save_copydiagramsh()">บันทึก</button>
                                                        </div>
                                                    </div>
                                                </div>





                                            </div>
                                        </div>

                                        <div class="tab-pane fade " id="shsh">
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    &nbsp;
                                                </div>
                                                <div class="col-lg-1" style="text-align: right">
                                                    <font style="color: red">* </font><label>ช่วงวันที่</label>
                                                </div>
                                                <div class="col-lg-3">

                                                    <input type="text" name="txt_copydiagramjobnomonday21_sh" id="txt_copydiagramjobnomonday21_sh" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnotuesday21_sh" id="txt_copydiagramjobnotuesday21_sh" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnowednesday21_sh" id="txt_copydiagramjobnowednesday21_sh" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnothursday21_sh" id="txt_copydiagramjobnothursday21_sh" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnofriday21_sh" id="txt_copydiagramjobnofriday21_sh" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnosaturday21_sh" id="txt_copydiagramjobnosaturday21_sh" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnosunday21_sh" id="txt_copydiagramjobnosunday21_sh" class="form-control" style="display: none">

                                                    <input type="text" name="txt_copydiagramjobnomonday22_sh" id="txt_copydiagramjobnomonday22_sh" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnotuesday22_sh" id="txt_copydiagramjobnotuesday22_sh" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnowednesday22_sh" id="txt_copydiagramjobnowednesday22_sh" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnothursday22_sh" id="txt_copydiagramjobnothursday22_sh" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnofriday22_sh" id="txt_copydiagramjobnofriday22_sh" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnosaturday22_sh" id="txt_copydiagramjobnosaturday22_sh" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnosunday22_sh" id="txt_copydiagramjobnosunday22_sh" class="form-control" style="display: none">

                                                    <input type="text" name="txt_copydiagramdatestartshsh"  readonly="" id="txt_copydiagramdatestartshsh" onchange="add_dateweeksh2(this.value)" class="form-control dateen" placeholder="วันที่เริ่มต้น...">

                                                </div>
                                                <div class="col-lg-3">
                                                    <input type="text" name="txt_copydiagramdateendshsh" style="background-color: #f080802e"  disabled="" id="txt_copydiagramdateendshsh" class="form-control dateen" placeholder="วันที่สิ้นสิ้นสุด...">
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12"><hr></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-2"><b><u>SH/SH(1)</u></b></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>พขร.(1) :</label>
                                                    <input type="text"  name="txt_copydiagramemployeename21_1sh" id="txt_copydiagramemployeename21_1sh" class="form-control">
                                                </div>
                                                <div class="col-lg-1">
                                                    <label>&nbsp;</label><br>

                                                    <button class="btn btn-secondary"  id="btn_checkdriver" onclick="select_checkdriversr('1')"  name="btn_checkdriver" data-toggle="modal"  data-target="#modal_checkdriver"><span class="fa fa-check"></span> พขร.(1)</button>
                                                </div>

                                                <div class="col-lg-2">
                                                    <label>พขร.(2) :</label> <!--<div id="div_jobendemp2">-</div >-->
                                                    <input type="text"  class="form-control" name="txt_copydiagramemployeename21_2sh" id="txt_copydiagramemployeename21_2sh">
                                                </div>
                                                <div class="col-lg-1">
                                                    <label>&nbsp;</label><br>
                                                    <button class="btn btn-secondary"  id="btn_checkdriver" onclick="select_checkdriversr('2')"  name="btn_checkdriver" data-toggle="modal"  data-target="#modal_checkdriver"><span class="fa fa-check"></span> พขร.(2)</button>
                                                </div>

                                                <div class="col-lg-2">
                                                    <label>พขร.(ควบคุม)(3) :</label>
                                                    <input type="text"  class="form-control" name="txt_copydiagramemployeename21_3sh" id="txt_copydiagramemployeename21_3sh">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>&nbsp;</label><br>
                                                    <button class="btn btn-secondary"  id="btn_checkdriver" onclick="select_checkdriversr('3')"  name="btn_checkdriver" data-toggle="modal"  data-target="#modal_checkdriver"><span class="fa fa-check"></span> พขร.(ควบคุม)(3)</button>
                                                </div>

                                                <div class="col-lg-2">
                                                    <label>จำนวนคัน(กรณีงานรับกลับ) :</label>
                                                    <input  type="text" class="form-control"  id="txt_copydiagramunit21_sh"  name="txt_copydiagramunit21_sh">
                                                </div>




                                            </div>
                                            <div class="row">

                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>ชื่อรถ :</label>
                                                    <input type="text" class="form-control"  id="txt_copydiagramthainame21_1sh" name="txt_copydiagramthainame21_1sh">

                                                </div>
                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>ชื่อรถ(หาง) :</label>
                                                    <input type="text" class="form-control"  id="txt_copydiagramthainame21_2sh" name="txt_copydiagramthainame21_2sh">
                                                </div>

                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>ต้นทาง(SH/SH(1)) :</label>
                                                    <select  id="txt_copydiagramjobstart21_sh" name="txt_copydiagramjobstart21_sh" class="form-control" onchange="se_copydiagramroute21_sh(this.value)">
                                                        <option value="">เลือกต้นทาง</option>
                                                        <option value="GW">GW</option>
                                                        <option value="BP">BP</option>
                                                        <option value="SR">SR</option>
                                                        <option value="TAC">TAC</option>
                                                        <option value="OTH">OTH</option>
                                                        <option value="SW">SW</option>
                                                        <option value="SP">SP</option>
                                                        <option value="Lenso">Lenso</option>
                                                        <option value="BP25RAI">BP25RAI</option>
                                                        <option value="BP(STOCK48RAI)">BP(STOCK48RAI)</option>
                                                    </select>

                                                </div>
                                                <div class="col-lg-2">
                                                    <label>งาน(SH/SH(1)) :</label><br>
                                                    <div id="copydiagramroutedef21_sh">
                                                        <select  id="cb_copydiagramroute21_sh" name="cb_copydiagramroute21_sh" class="form-control" >
                                                            <option value="">เลือกงาน</option>
                                                        </select>
                                                        <input class="form-control" style="display:none"  id="txt_companycode21_sh" name="txt_companycode21_sh" maxlength="500" value="<?= $_GET['companycode'] ?>" >
                                                        <input class="form-control" style="display:none"  id="txt_customercode21_sh" name="txt_customercode21_sh" maxlength="500" value="<?= $_GET['customercode'] ?>" >
                                                        <input class="form-control" style="display:none"  id="txt_worktype21_sh" name="txt_worktype21_sh" maxlength="500" value="<?= $_GET['worktype'] ?>" >

                                                    </div>
                                                    <div id="copydiagramroutesr21_sh"></div>
                                                </div>


                                                <div class="col-lg-2">
                                                    <label>งานย่อย(SH/SH(1)) :</label><br>
                                                    <div id="copydiagramsubroutedef21_sh">
                                                        <select  id="cb_copydiagramsubroute21_sh" name="cb_copydiagramsubroute21_sh" class="form-control" >
                                                            <option value="">เลือกงาน(ย่อย)</option>
                                                        </select>
                                                        <input class="form-control" style="display:none"  id="txt_companycode21_sh" name="txt_companycode21_sh" maxlength="500" value="<?= $_GET['companycode'] ?>" >
                                                        <input class="form-control" style="display:none"  id="txt_customercode21_sh" name="txt_customercode21_sh" maxlength="500" value="<?= $_GET['customercode'] ?>" >
                                                        <input class="form-control" style="display:none"  id="txt_worktype21_sh" name="txt_worktype21_sh" maxlength="500" value="<?= $_GET['worktype'] ?>" >

                                                    </div>
                                                    <div id="copydiagramsubroutesr21_sh"></div>

                                                </div>

                                                <div class="col-lg-2">
                                                    <label>จำนวนโหลด(SH/SH(1)) :</label><br>
                                                    <select  id="cb_copydiagramload21_sh" name="cb_copydiagramload21_sh" class="form-control">
                                                        <option value="">เลือกจำนวนโหลด</option>
                                                        <option value="4">4 Load</option>
                                                        <option value="8">8 Load</option>

                                                    </select>
                                                </div>



                                            </div>

                                            <div class="row">&nbsp;</div>
											<div class="row">                            
                                                <div class="col-lg-2">
                                                    <label>รอบที่วิ่งงาน :</label>
                                                    <select id="txt_roundamount21_sh" name="txt_roundamount21_sh" class="form-control">
                                                        <option value disabled selected>-เลือกรอบที่วิ่งงาน-</option>
                                                        <option value="1">รอบที่ 1</option>
                                                        <option value="2">รอบที่ 2</option>
                                                        <option value="3">รอบที่ 3</option>
                                                        <option value="4">รอบที่ 4</option>
                                                    </select>                                
                                                </div>
                                            </div>
                                            <div class="row">&nbsp;</div>
                                            <div class="row">


                                                <input  type="text" class="form-control" value="<?= $result_seSystime['SYSTIME'] ?>" style="background-color: #f080802e;display: none" disabled="" id="txt_copydiagramdateinput21_sh" name="txt_copydiagramdateinput21_sh">

                                                <div class="col-lg-2">
                                                    <label>เวลารายงานตัว :</label>
                                                    <input type="text" class="form-control timeen" style="background-color: #f080802e" disabled="" id="txt_copydiagramdatepresent21_sh" name="txt_copydiagramdatepresent21_sh">

                                                </div>

                                                <div class="col-lg-2">
                                                    <label>เวลาเริ่มงาน ( <input type="checkbox" id="chk_copydiagramdaterk21_sh" name="chk_copydiagramdaterk21_sh" onchange="change_textboxdate21_sh()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdaterk21_sh" name="txt_copydiagramdaterk21_sh" onchange="show_timepresent21_sh(this.value)" autocomplete="off">
                                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdaterk221_sh" name="txt_copydiagramdaterk221_sh" onchange="show_timepresent21_sh(this.value)" style="display: none" autocomplete="off">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>เวลาเข้า(ลูกค้า) ( <input type="checkbox" id="chk_copydiagramdatevlin21_sh" name="chk_copydiagramdatevlin21_sh" onchange="change_textboxdate21_sh()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatevlin21_sh" name="txt_copydiagramdatevlin21_sh" autocomplete="off" autocomplete="off">
                                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdatevlin221_sh" name="txt_copydiagramdatevlin221_sh"  style="display: none" autocomplete="off">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>เวลาออก(ลูกค้า) ( <input type="checkbox" id="chk_copydiagramdatevlout21_sh" name="chk_copydiagramdatevlout21_sh" onchange="change_textboxdate21_sh()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatevlout21_sh" name="txt_copydiagramdatevlout21_sh" autocomplete="off">
                                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdatevlout221_sh" name="txt_copydiagramdatevlout221_sh" style="display: none" autocomplete="off">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>เวลาเข้า(ลูกค้า2) ( <input type="checkbox" id="chk_copydiagramdatedealerin21_sh" name="chk_copydiagramdatedealerin21_sh" onchange="change_textboxdate21_sh()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatedealerin21_sh" name="txt_copydiagramdatedealerin21_sh" autocomplete="off">
                                                    <input type="text" class="form-control  datetimeen" id="txt_copydiagramdatedealerin221_sh" name="txt_copydiagramdatedealerin221_sh" style="display: none" autocomplete="off">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>เวลากลับบริษัท ( <input type="checkbox" id="chk_copydiagramdatereturn21_sh" name="chk_copydiagramdatereturn21_sh" onchange="change_textboxdate21_sh()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatereturn21_sh" name="txt_copydiagramdatereturn21_sh" autocomplete="off">
                                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdatereturn221_sh" name="txt_copydiagramdatereturn221_sh" style="display: none" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="row">&nbsp;</div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="well" va>
                                                        <div class="row">
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" id="chk_copydiagrammonday21_sh" name="chk_copydiagrammonday21_sh" checked="" value="" style="transform: scale(2)">&nbsp;<label>จันทร์</label><label id="lab_monday21_sh"></label>
                                                                </label>
                                                            </div>

                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" id="chk_copydiagramtuesday21_sh" name="chk_copydiagramtuesday21_sh" checked="" value="" style="transform: scale(2)">&nbsp;<label>อังคาร</label><label id="lab_tuesday21_sh"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" checked="" id="chk_copydiagramwednesday21_sh" name="chk_copydiagramwednesday21_sh" value="" style="transform: scale(2)">&nbsp;<label>พุธ</label><label id="lab_wednesday21_sh"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" checked="" id="chk_copydiagramthursday21_sh" name="chk_copydiagramthursday21_sh" value="" style="transform: scale(2)">&nbsp;<label>พฤหัสบดี</label><label id="lab_thursday21_sh"></label>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" checked="" id="chk_copydiagramfriday21_sh" name="chk_copydiagramfriday21_sh" value="" style="transform: scale(2)">&nbsp;<label>ศุกร์</label><label id="lab_friday21_sh"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" checked="" id="chk_copydiagramsaturday21_sh" name="chk_copydiagramsaturday21_sh2" value="" style="transform: scale(2)">&nbsp;<label>เสาร์</label><label id="lab_saturday21_sh"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" id="chk_copydiagramsunday21_sh" name="chk_copydiagramsunday21_sh" checked="" value="" style="transform: scale(2)">&nbsp;<label>อาทิตย์</label><label id="lab_sunday21_sh"></label>
                                                                </label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>





                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12"><hr></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-2"><b><u>SH/SH(2)</u></b></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>พขร.(1) :</label>
                                                    <input type="text"  name="txt_copydiagramemployeename22_1sh" id="txt_copydiagramemployeename22_1sh" class="form-control">
                                                </div>
                                                <div class="col-lg-1">
                                                    <label>&nbsp;</label><br>

                                                    <button class="btn btn-secondary"  id="btn_checkdriver" onclick="select_checkdriversr('1')"  name="btn_checkdriver" data-toggle="modal"  data-target="#modal_checkdriver"><span class="fa fa-check"></span> พขร.(1)</button>
                                                </div>

                                                <div class="col-lg-2">
                                                    <label>พขร.(2) :</label> <!--<div id="div_jobendemp2">-</div >-->
                                                    <input type="text"  class="form-control" name="txt_copydiagramemployeename22_2sh" id="txt_copydiagramemployeename22_2sh">
                                                </div>
                                                <div class="col-lg-1">
                                                    <label>&nbsp;</label><br>
                                                    <button class="btn btn-secondary"  id="btn_checkdriver" onclick="select_checkdriversr('2')"  name="btn_checkdriver" data-toggle="modal"  data-target="#modal_checkdriver"><span class="fa fa-check"></span> พขร.(2)</button>
                                                </div>

                                                <div class="col-lg-2">
                                                    <label>พขร.(ควบคุม)(3) :</label>
                                                    <input type="text"  class="form-control" name="txt_copydiagramemployeename22_3sh" id="txt_copydiagramemployeename22_3sh">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>&nbsp;</label><br>
                                                    <button class="btn btn-secondary"  id="btn_checkdriver" onclick="select_checkdriversr('3')"  name="btn_checkdriver" data-toggle="modal"  data-target="#modal_checkdriver"><span class="fa fa-check"></span> พขร.(ควบคุม)(3)</button>
                                                </div>

                                                <div class="col-lg-2">
                                                    <label>จำนวนคัน(กรณีงานรับกลับ) :</label>
                                                    <input  type="text" class="form-control"  id="txt_copydiagramunit22_sh"  name="txt_copydiagramunit22_sh">
                                                </div>




                                            </div>
                                            <div class="row">

                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>ชื่อรถ :</label>
                                                    <input type="text" class="form-control"  id="txt_copydiagramthainame22_1sh" name="txt_copydiagramthainame22_1sh">

                                                </div>
                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>ชื่อรถ(หาง) :</label>
                                                    <input type="text" class="form-control"  id="txt_copydiagramthainame22_2sh" name="txt_copydiagramthainame22_2sh">
                                                </div>

                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>ต้นทาง(SH/SH(2)) :</label>
                                                    <select  id="txt_copydiagramjobstart22_sh" name="txt_copydiagramjobstart22_sh" class="form-control" onchange="se_copydiagramroute22_sh(this.value)">
                                                        <option value="">เลือกต้นทาง</option>
                                                        <option value="GW">GW</option>
                                                        <option value="BP">BP</option>
                                                        <option value="SR">SR</option>
                                                        <option value="TAC">TAC</option>
                                                        <option value="OTH">OTH</option>
                                                        <option value="SW">SW</option>
                                                        <option value="SP">SP</option>
                                                        <option value="Lenso">Lenso</option>
                                                        <option value="BP25RAI">BP25RAI</option>
                                                        <option value="BP(STOCK48RAI)">BP(STOCK48RAI)</option>
                                                    </select>

                                                </div>
                                                <div class="col-lg-2">
                                                    <label>งาน(SH/SH(2)) :</label><br>
                                                    <div id="copydiagramroutedef22_sh">
                                                        <select  id="cb_copydiagramroute22_sh" name="cb_copydiagramroute22_sh" class="form-control" >
                                                            <option value="">เลือกงาน</option>
                                                        </select>
                                                        <input class="form-control" style="display:none"  id="txt_companycode22_sh" name="txt_companycode22_sh" maxlength="500" value="<?= $_GET['companycode'] ?>" >
                                                        <input class="form-control" style="display:none"  id="txt_customercode22_sh" name="txt_customercode22_sh" maxlength="500" value="<?= $_GET['customercode'] ?>" >
                                                        <input class="form-control" style="display:none"  id="txt_worktype22_sh" name="txt_worktype22_sh" maxlength="500" value="<?= $_GET['worktype'] ?>" >
                                                    </div>
                                                    <div id="copydiagramroutesr22_sh"></div>
                                                </div>


                                                <div class="col-lg-2">
                                                    <label>งานย่อย(SH/SH(2)) :</label><br>
                                                    <div id="copydiagramsubroutedef22_sh">
                                                        <select  id="cb_copydiagramsubroute22_sh" name="cb_copydiagramsubroute22_sh" class="form-control" >
                                                            <option value="">เลือกงาน(ย่อย)</option>
                                                        </select>
                                                        <input class="form-control" style="display:none"  id="txt_companycode22_sh" name="txt_companycode22_sh" maxlength="500" value="<?= $_GET['companycode'] ?>" >
                                                        <input class="form-control" style="display:none"  id="txt_customercode22_sh" name="txt_customercode22_sh" maxlength="500" value="<?= $_GET['customercode'] ?>" >
                                                        <input class="form-control" style="display:none"  id="txt_worktype22_sh" name="txt_worktype22_sh" maxlength="500" value="<?= $_GET['worktype'] ?>" >
                                                    </div>
                                                    <div id="copydiagramsubroutesr22_sh"></div>

                                                </div>

                                                <div class="col-lg-2">
                                                    <label>จำนวนโหลด(SH/SH(2)) :</label><br>
                                                    <select  id="cb_copydiagramload22_sh" name="cb_copydiagramload22_sh" class="form-control">
                                                        <option value="">เลือกจำนวนโหลด</option>
                                                        <option value="4">4 Load</option>
                                                        <option value="8">8 Load</option>

                                                    </select>
                                                </div>




                                            </div>

                                            <div class="row">&nbsp;</div>
											<div class="row">                            
                                                <div class="col-lg-2">
                                                    <label>รอบที่วิ่งงาน :</label>
                                                    <select id="txt_roundamount22_sh" name="txt_roundamount22_sh" class="form-control">
                                                        <option value disabled selected>-เลือกรอบที่วิ่งงาน-</option>
                                                        <option value="1">รอบที่ 1</option>
                                                        <option value="2">รอบที่ 2</option>
                                                        <option value="3">รอบที่ 3</option>
                                                        <option value="4">รอบที่ 4</option>
                                                    </select>                                
                                                </div>
                                            </div>
                                            <div class="row">&nbsp;</div>
                                            <div class="row">


                                                <input  type="text" class="form-control" value="<?= $result_seSystime['SYSTIME'] ?>" style="background-color: #f080802e;display: none" disabled="" id="txt_copydiagramdateinput22_sh" name="txt_copydiagramdateinput22_sh">

                                                <div class="col-lg-2">
                                                    <label>เวลารายงานตัว :</label>
                                                    <input type="text" class="form-control timeen" style="background-color: #f080802e" disabled="" id="txt_copydiagramdatepresent22_sh" name="txt_copydiagramdatepresent22_sh">

                                                </div>

                                                <div class="col-lg-2">
                                                    <label>เวลาเริ่มงาน ( <input type="checkbox" id="chk_copydiagramdaterk22_sh" name="chk_copydiagramdaterk22_sh" onchange="change_textboxdate22_sh()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdaterk22_sh" name="txt_copydiagramdaterk22_sh" onchange="show_timepresent22_sh(this.value)" autocomplete="off">
                                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdaterk222_sh" name="txt_copydiagramdaterk222_sh" onchange="show_timepresent22_sh(this.value)" style="display: none" autocomplete="off">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>เวลาเข้า(ลูกค้า) ( <input type="checkbox" id="chk_copydiagramdatevlin22_sh" name="chk_copydiagramdatevlin22_sh" onchange="change_textboxdate22_sh()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatevlin22_sh" name="txt_copydiagramdatevlin22_sh" autocomplete="off" autocomplete="off">
                                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdatevlin222_sh" name="txt_copydiagramdatevlin222_sh"  style="display: none" autocomplete="off">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>เวลาออก(ลูกค้า) ( <input type="checkbox" id="chk_copydiagramdatevlout22_sh" name="chk_copydiagramdatevlout22_sh" onchange="change_textboxdate22_sh()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatevlout22_sh" name="txt_copydiagramdatevlout22_sh" autocomplete="off">
                                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdatevlout222_sh" name="txt_copydiagramdatevlout222_sh" style="display: none" autocomplete="off">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>เวลาเข้า(ลูกค้า2) ( <input type="checkbox" id="chk_copydiagramdatedealerin22_sh" name="chk_copydiagramdatedealerin22_sh" onchange="change_textboxdate22_sh()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatedealerin22_sh" name="txt_copydiagramdatedealerin22_sh" autocomplete="off">
                                                    <input type="text" class="form-control  datetimeen" id="txt_copydiagramdatedealerin222_sh" name="txt_copydiagramdatedealerin222_sh" style="display: none" autocomplete="off">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>เวลากลับบริษัท ( <input type="checkbox" id="chk_copydiagramdatereturn22_sh" name="chk_copydiagramdatereturn22_sh" onchange="change_textboxdate22_sh()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatereturn22_sh" name="txt_copydiagramdatereturn22_sh" autocomplete="off">
                                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdatereturn222_sh" name="txt_copydiagramdatereturn222_sh" style="display: none" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="row">&nbsp;</div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="well" va>
                                                        <div class="row">
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" id="chk_copydiagrammonday22_sh" name="chk_copydiagrammonday22_sh" checked="" value="" style="transform: scale(2)">&nbsp;<label>จันทร์</label><label id="lab_monday22_sh"></label>
                                                                </label>
                                                            </div>

                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" id="chk_copydiagramtuesday22_sh" name="chk_copydiagramtuesday22_sh" checked="" value="" style="transform: scale(2)">&nbsp;<label>อังคาร</label><label id="lab_tuesday22_sh"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" checked="" id="chk_copydiagramwednesday22_sh" name="chk_copydiagramwednesday22_sh" value="" style="transform: scale(2)">&nbsp;<label>พุธ</label><label id="lab_wednesday22_sh"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" checked="" id="chk_copydiagramthursday22_sh" name="chk_copydiagramthursday22_sh" value="" style="transform: scale(2)">&nbsp;<label>พฤหัสบดี</label><label id="lab_thursday22_sh"></label>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" checked="" id="chk_copydiagramfriday22_sh" name="chk_copydiagramfriday22_sh" value="" style="transform: scale(2)">&nbsp;<label>ศุกร์</label><label id="lab_friday22_sh"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" checked="" id="chk_copydiagramsaturday22_sh" name="chk_copydiagramsaturday22_sh" value="" style="transform: scale(2)">&nbsp;<label>เสาร์</label><label id="lab_saturday22_sh"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" id="chk_copydiagramsunday22_sh" name="chk_copydiagramsunday22_sh" checked="" value="" style="transform: scale(2)">&nbsp;<label>อาทิตย์</label><label id="lab_sunday22_sh"></label>
                                                                </label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row" >
                                                        <div class="col-lg-12 text-right">

                                                            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                                                            <button type="button" class="btn btn-primary" onclick="save_copydiagramshsh()">บันทึก</button>
                                                        </div>
                                                    </div>
                                                </div>





                                            </div>
                                        </div>
                                        <div class="tab-pane fade " id="normalsh">

                                            <div class="row">
                                                <div class="col-lg-5">
                                                    &nbsp;
                                                </div>
                                                <div class="col-lg-1" style="text-align: right">
                                                    <font style="color: red">* </font><label>ช่วงวันที่</label>
                                                </div>
                                                <div class="col-lg-3">

                                                    <input type="text" name="txt_copydiagramjobnomonday31" id="txt_copydiagramjobnomonday31" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnotuesday31" id="txt_copydiagramjobnotuesday31" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnowednesday31" id="txt_copydiagramjobnowednesday31" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnothursday31" id="txt_copydiagramjobnothursday31" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnofriday31" id="txt_copydiagramjobnofriday31" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnosaturday31" id="txt_copydiagramjobnosaturday31" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnosunday31" id="txt_copydiagramjobnosunday31" class="form-control" style="display: none">

                                                    <input type="text" name="txt_copydiagramjobnomonday32" id="txt_copydiagramjobnomonday32" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnotuesday32" id="txt_copydiagramjobnotuesday32" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnowednesday32" id="txt_copydiagramjobnowednesday32" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnothursday32" id="txt_copydiagramjobnothursday32" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnofriday32" id="txt_copydiagramjobnofriday32" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnosaturday32" id="txt_copydiagramjobnosaturday32" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnosunday32" id="txt_copydiagramjobnosunday32" class="form-control" style="display: none">

                                                    <input type="text" name="txt_copydiagramdatestartns"  readonly="" id="txt_copydiagramdatestartns" onchange="add_dateweekns(this.value)" class="form-control dateen" placeholder="วันที่เริ่มต้น...">

                                                </div>
                                                <div class="col-lg-3">
                                                    <input type="text" name="txt_copydiagramdateendns" style="background-color: #f080802e"  disabled="" id="txt_copydiagramdateendns" class="form-control dateen" placeholder="วันที่สิ้นสิ้นสุด...">
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12"><hr></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-2"><b><u>NM/SH1</u></b></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>พขร.(1) :</label>
                                                    <input type="text"  name="txt_copydiagramemployeename31_1" id="txt_copydiagramemployeename31_1" class="form-control">
                                                </div>
                                                <div class="col-lg-1">
                                                    <label>&nbsp;</label><br>

                                                    <button class="btn btn-secondary"  id="btn_checkdriver" onclick="select_checkdriversr('1')"  name="btn_checkdriver" data-toggle="modal"  data-target="#modal_checkdriver"><span class="fa fa-check"></span> พขร.(1)</button>
                                                </div>

                                                <div class="col-lg-2">
                                                    <label>พขร.(2) :</label> <!--<div id="div_jobendemp2">-</div >-->
                                                    <input type="text"  class="form-control" name="txt_copydiagramemployeename31_2" id="txt_copydiagramemployeename31_2">
                                                </div>
                                                <div class="col-lg-1">
                                                    <label>&nbsp;</label><br>
                                                    <button class="btn btn-secondary"  id="btn_checkdriver" onclick="select_checkdriversr('2')"  name="btn_checkdriver" data-toggle="modal"  data-target="#modal_checkdriver"><span class="fa fa-check"></span> พขร.(2)</button>
                                                </div>

                                                <div class="col-lg-2">
                                                    <label>พขร.(ควบคุม)(3) :</label>
                                                    <input type="text"  class="form-control" name="txt_copydiagramemployeename31_3" id="txt_copydiagramemployeename31_3">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>&nbsp;</label><br>
                                                    <button class="btn btn-secondary"  id="btn_checkdriver" onclick="select_checkdriversr('3')"  name="btn_checkdriver" data-toggle="modal"  data-target="#modal_checkdriver"><span class="fa fa-check"></span> พขร.(ควบคุม)(3)</button>
                                                </div>

                                                <div class="col-lg-2">
                                                    <label>จำนวนคัน(กรณีงานรับกลับ) :</label>
                                                    <input  type="text" class="form-control"  id="txt_copydiagramunit31"  name="txt_copydiagramunit31">
                                                </div>




                                            </div>
                                            <div class="row">

                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>ชื่อรถ :</label>
                                                    <input type="text" class="form-control"  id="txt_copydiagramthainame31_1" name="txt_copydiagramthainame31_1">

                                                </div>
                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>ชื่อรถ(หาง) :</label>
                                                    <input type="text" class="form-control"  id="txt_copydiagramthainame31_2" name="txt_copydiagramthainame31_2">
                                                </div>


                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>ต้นทาง(NM/SH(1)) :</label>
                                                    <select multiple="multiple" id="txt_copydiagramjobstart31" name="txt_copydiagramjobstart31" class="form-control" style="width: 100%">
                                                        <option value="">เลือกต้นทาง</option>
                                                        <option value="GW">GW</option>
                                                        <option value="BP">BP</option>
                                                        <option value="SR">SR</option>
                                                        <option value="TAC">TAC</option>
                                                        <option value="OTH">OTH</option>
                                                        <option value="SW">SW</option>
                                                        <option value="SP">SP</option>
                                                        <option value="BP25RAI">BP25RAI</option>
                                                    </select>
                                                </div>



                                                <div class="col-lg-2">
                                                    <label>CLUSTER(NM/SH(1)) :</label>

                                                    <div class="dropdown bootstrap-select show-tick form-control">

                                                        <select multiple="" onchange="select_cluster31()" id="cb_copydiagramcluster31" name="cb_copydiagramcluster31" class="selectpicker form-control"  data-container="body" data-live-search="true" title="เลือก cluster..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98">
                                                            <?php
                                                            $condiCluster31 = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "'";
                                                            $sql_seCluster31 = "{call megVehicletransportprice_v2(?,?,?,?)}";
                                                            $params_seCluster31 = array(
                                                                array('select_cluster', SQLSRV_PARAM_IN),
                                                                array($condiCluster31, SQLSRV_PARAM_IN),
                                                                array('', SQLSRV_PARAM_IN),
                                                                array('', SQLSRV_PARAM_IN)
                                                            );
                                                            $query_seCluster31 = sqlsrv_query($conn, $sql_seCluster31, $params_seCluster31);
                                                            while ($result_seCluster31 = sqlsrv_fetch_array($query_seCluster31, SQLSRV_FETCH_ASSOC)) {
                                                                ?>
                                                                <option value="<?= $result_seCluster31['CLUSTER'] ?>"><?= $result_seCluster31['CLUSTER'] ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <input class="form-control" style="display: none"  id="txt_copydiagramcluster31" name="txt_copydiagramcluster31" maxlength="500" value="" >


                                                        <div class="dropdown-menu open" role="combobox">
                                                            <div class="bs-searchbox">
                                                                <input type="text" class="form-control" autocomplete="off" role="textbox" aria-label="Search"></div>
                                                            <div class="bs-actionsbox">
                                                                <div class="btn-group btn-group-sm btn-block">
                                                                    <button type="button" class="actions-btn bs-select-all btn btn-default">Select All</button>
                                                                    <button type="button" class="actions-btn bs-deselect-all btn btn-default">Deselect All</button>
                                                                </div>
                                                            </div>
                                                            <div class="inner open" role="listbox" aria-expanded="false" tabindex="-1">
                                                                <ul class="dropdown-menu inner "></ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>





                                                <div class="col-lg-2">

                                                    <label>ปลายทาง(NM/SH(1)) :</label>
                                                    <div id="data_copydiagramjobenddef31">
                                                        <div class="dropdown bootstrap-select show-tick form-control">

                                                            <select multiple="" id="cb_copydiagramjobend31" name="cb_copydiagramjobend31" class="selectpicker form-control"  data-container="body" data-live-search="true" title="เลือก ปลายทาง..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >

                                                            </select>
                                                            <input class="form-control" style="display: none"   id="txt_copydiagramjobend31" name="txt_copydiagramjobend31" maxlength="500" value="" >


                                                            <div class="dropdown-menu open" role="combobox">
                                                                <div class="bs-searchbox">
                                                                    <input type="text" class="form-control" autocomplete="off" role="textbox" aria-label="Search"></div>
                                                                <div class="bs-actionsbox">
                                                                    <div class="btn-group btn-group-sm btn-block">
                                                                        <button type="button" class="actions-btn bs-select-all btn btn-default">Select All</button>
                                                                        <button type="button" class="actions-btn bs-deselect-all btn btn-default">Deselect All</button>
                                                                    </div>
                                                                </div>
                                                                <div class="inner open" role="listbox" aria-expanded="false" tabindex="-1">
                                                                    <ul class="dropdown-menu inner "></ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="data_copydiagramjobendsr31"></div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>ก่อนเวลารายงานตัว (OTH) :</label>
                                                    <input type="text" class="form-control"  id="txt_beforpersentoth31"  name="txt_beforpersentoth31">
                                                </div>






                                            </div>

                                            <div class="row">&nbsp;</div>
											<div class="row">                            
                                                <div class="col-lg-2">
                                                    <label>รอบที่วิ่งงาน :</label>
                                                    <select id="txt_roundamount31" name="txt_roundamount31" class="form-control">
                                                        <option value disabled selected>-เลือกรอบที่วิ่งงาน-</option>
                                                        <option value="1">รอบที่ 1</option>
                                                        <option value="2">รอบที่ 2</option>
                                                        <option value="3">รอบที่ 3</option>
                                                        <option value="4">รอบที่ 4</option>
                                                    </select>                                
                                                </div>
                                            </div>
                                            <div class="row">&nbsp;</div>
                                            <div class="row">


                                                <input  type="text" class="form-control" value="<?= $result_seSystime['SYSTIME'] ?>" style="background-color: #f080802e;display: none" disabled="" id="txt_copydiagramdateinput31" name="txt_copydiagramdateinput31">

                                                <div class="col-lg-2">
                                                    <label>เวลารายงานตัว :</label>
                                                    <input type="text" class="form-control timeen" style="background-color: #f080802e" disabled="" id="txt_copydiagramdatepresent31" name="txt_copydiagramdatepresent31">

                                                </div>

                                                <div class="col-lg-2">
                                                    <label>เวลาเริ่มงาน ( <input type="checkbox" id="chk_copydiagramdaterk31" name="chk_copydiagramdaterk31" onchange="change_textboxdate31()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdaterk31" name="txt_copydiagramdaterk31" onchange="show_timepresent31(this.value)" autocomplete="off">
                                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdaterk231" name="txt_copydiagramdaterk231" onchange="show_timepresent31(this.value)" style="display: none" autocomplete="off">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>เวลาเข้า(ลูกค้า) ( <input type="checkbox" id="chk_copydiagramdatevlin31" name="chk_copydiagramdatevlin31" onchange="change_textboxdate31()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatevlin31" name="txt_copydiagramdatevlin31" autocomplete="off" autocomplete="off">
                                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdatevlin231" name="txt_copydiagramdatevlin231"  style="display: none" autocomplete="off">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>เวลาออก(ลูกค้า) ( <input type="checkbox" id="chk_copydiagramdatevlout31" name="chk_copydiagramdatevlout31" onchange="change_textboxdate31()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatevlout31" name="txt_copydiagramdatevlout31" autocomplete="off">
                                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdatevlout231" name="txt_copydiagramdatevlout231" style="display: none" autocomplete="off">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>เวลาเข้า(ลูกค้า2) ( <input type="checkbox" id="chk_copydiagramdatedealerin31" name="chk_copydiagramdatedealerin31" onchange="change_textboxdate31()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatedealerin31" name="txt_copydiagramdatedealerin31" autocomplete="off">
                                                    <input type="text" class="form-control  datetimeen" id="txt_copydiagramdatedealerin231" name="txt_copydiagramdatedealerin231" style="display: none" autocomplete="off">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>เวลากลับบริษัท ( <input type="checkbox" id="chk_copydiagramdatereturn31" name="chk_copydiagramdatereturn31" onchange="change_textboxdate31()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatereturn31" name="txt_copydiagramdatereturn31" autocomplete="off">
                                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdatereturn231" name="txt_copydiagramdatereturn231" style="display: none" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="row">&nbsp;</div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="well" va>
                                                        <div class="row">
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" id="chk_copydiagrammonday31" name="chk_copydiagrammonday31" checked="" value="" style="transform: scale(2)">&nbsp;<label>จันทร์</label><label id="lab_monday31"></label>
                                                                </label>
                                                            </div>

                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" id="chk_copydiagramtuesday31" name="chk_copydiagramtuesday31" checked="" value="" style="transform: scale(2)">&nbsp;<label>อังคาร</label><label id="lab_tuesday31"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" checked="" id="chk_copydiagramwednesday31" name="chk_copydiagramwednesday31" value="" style="transform: scale(2)">&nbsp;<label>พุธ</label><label id="lab_wednesday31"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" checked="" id="chk_copydiagramthursday31" name="chk_copydiagramthursday31" value="" style="transform: scale(2)">&nbsp;<label>พฤหัสบดี</label><label id="lab_thursday31"></label>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" checked="" id="chk_copydiagramfriday31" name="chk_copydiagramfriday31" value="" style="transform: scale(2)">&nbsp;<label>ศุกร์</label><label id="lab_friday31"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" checked="" id="chk_copydiagramsaturday31" name="chk_copydiagramsaturday31" value="" style="transform: scale(2)">&nbsp;<label>เสาร์</label><label id="lab_saturday31"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" id="chk_copydiagramsunday31" name="chk_copydiagramsunday31" checked="" value="" style="transform: scale(2)">&nbsp;<label>อาทิตย์</label><label id="lab_sunday31"></label>
                                                                </label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>




                                            </div>
                                            <div class ="row">
                                                <div class="col-lg-12"><hr></div>
                                            </div>


                                            <div class="row">
                                                <div class="col-lg-2"><b><u>NM/SH(2)</u></b></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>พขร.(1) :</label>
                                                    <input type="text"  name="txt_copydiagramemployeename32_1" id="txt_copydiagramemployeename32_1" class="form-control">
                                                </div>
                                                <div class="col-lg-1">
                                                    <label>&nbsp;</label><br>

                                                    <button class="btn btn-secondary"  id="btn_checkdriver" onclick="select_checkdriversr('1')"  name="btn_checkdriver" data-toggle="modal"  data-target="#modal_checkdriver"><span class="fa fa-check"></span> พขร.(1)</button>
                                                </div>

                                                <div class="col-lg-2">
                                                    <label>พขร.(2) :</label> <!--<div id="div_jobendemp2">-</div >-->
                                                    <input type="text"  class="form-control" name="txt_copydiagramemployeename32_2" id="txt_copydiagramemployeename32_2">
                                                </div>
                                                <div class="col-lg-1">
                                                    <label>&nbsp;</label><br>
                                                    <button class="btn btn-secondary"  id="btn_checkdriver" onclick="select_checkdriversr('2')"  name="btn_checkdriver" data-toggle="modal"  data-target="#modal_checkdriver"><span class="fa fa-check"></span> พขร.(2)</button>
                                                </div>

                                                <div class="col-lg-2">
                                                    <label>พขร.(ควบคุม)(3) :</label>
                                                    <input type="text"  class="form-control" name="txt_copydiagramemployeename32_3" id="txt_copydiagramemployeename32_3">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>&nbsp;</label><br>
                                                    <button class="btn btn-secondary"  id="btn_checkdriver" onclick="select_checkdriversr('3')"  name="btn_checkdriver" data-toggle="modal"  data-target="#modal_checkdriver"><span class="fa fa-check"></span> พขร.(ควบคุม)(3)</button>
                                                </div>

                                                <div class="col-lg-2">
                                                    <label>จำนวนคัน(กรณีงานรับกลับ) :</label>
                                                    <input  type="text" class="form-control"  id="txt_copydiagramunit32"  name="txt_copydiagramunit32">
                                                </div>




                                            </div>
                                            <div class="row">

                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>ชื่อรถ :</label>
                                                    <input type="text" class="form-control"  id="txt_copydiagramthainame32_1" name="txt_copydiagramthainame32_1">

                                                </div>
                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>ชื่อรถ(หาง) :</label>
                                                    <input type="text" class="form-control"  id="txt_copydiagramthainame32_2" name="txt_copydiagramthainame32_2">
                                                </div>

                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>ต้นทาง(NM/SH(2)) :</label>
                                                    <select  id="txt_copydiagramjobstart32" name="txt_copydiagramjobstart32" class="form-control" onchange="se_copydiagramroute32(this.value)">
                                                        <option value="">เลือกต้นทาง</option>
                                                        <option value="GW">GW</option>
                                                        <option value="BP">BP</option>
                                                        <option value="SR">SR</option>
                                                        <option value="TAC">TAC</option>
                                                        <option value="OTH">OTH</option>
                                                        <option value="SW">SW</option>
                                                        <option value="SP">SP</option>
                                                        <option value="Lenso">Lenso</option>
                                                        <option value="BP25RAI">BP25RAI</option>
                                                        <option value="BP(STOCK48RAI)">BP(STOCK48RAI)</option>
                                                    </select>

                                                </div>
                                                <div class="col-lg-2">
                                                    <label>งาน(NM/SH(2)) :</label><br>
                                                    <div id="copydiagramroutedef32">
                                                        <select  id="cb_copydiagramroute32" name="cb_copydiagramroute32" class="form-control" >
                                                            <option value="">เลือกงาน</option>
                                                        </select>
                                                        <input class="form-control" style="display:none"  id="txt_companycode32_sh" name="txt_companycode32_sh" maxlength="500" value="<?= $_GET['companycode'] ?>" >
                                                        <input class="form-control" style="display:none"  id="txt_customercode32_sh" name="txt_customercode32_sh" maxlength="500" value="<?= $_GET['customercode'] ?>" >
                                                        <input class="form-control" style="display:none"  id="txt_worktype32_sh" name="txt_worktype32_sh" maxlength="500" value="<?= $_GET['worktype'] ?>" >

                                                    </div>
                                                    <div id="copydiagramroutesr32"></div>
                                                </div>


                                                <div class="col-lg-2">
                                                    <label>งานย่อย(NM/SH(2)) :</label><br>
                                                    <div id="copydiagramsubroutedef32">
                                                        <select  id="cb_copydiagramsubroute32" name="cb_copydiagramsubroute32" class="form-control" >
                                                            <option value="">เลือกงาน(ย่อย)</option>
                                                        </select>
                                                        <input class="form-control" style="display:none"  id="txt_companycode32_sh" name="txt_companycode32_sh" maxlength="500" value="<?= $_GET['companycode'] ?>" >
                                                        <input class="form-control" style="display:none"  id="txt_customercode32_sh" name="txt_customercode32_sh" maxlength="500" value="<?= $_GET['customercode'] ?>" >
                                                        <input class="form-control" style="display:none"  id="txt_worktype32_sh" name="txt_worktype32_sh" maxlength="500" value="<?= $_GET['worktype'] ?>" >

                                                    </div>
                                                    <div id="copydiagramsubroutesr32"></div>

                                                </div>

                                                <div class="col-lg-2">
                                                    <label>จำนวนโหลด(NM/SH(2)) :</label><br>
                                                    <select  id="cb_copydiagramload32" name="cb_copydiagramload32" class="form-control">
                                                        <option value="">เลือกจำนวนโหลด</option>
                                                        <option value="4">4 Load</option>
                                                        <option value="8">8 Load</option>

                                                    </select>
                                                </div>




                                            </div>

                                            <div class="row">&nbsp;</div>
											<div class="row">                            
                                                <div class="col-lg-2">
                                                    <label>รอบที่วิ่งงาน :</label>
                                                    <select id="txt_roundamount32" name="txt_roundamount32" class="form-control">
                                                        <option value disabled selected>-เลือกรอบที่วิ่งงาน-</option>
                                                        <option value="1">รอบที่ 1</option>
                                                        <option value="2">รอบที่ 2</option>
                                                        <option value="3">รอบที่ 3</option>
                                                        <option value="4">รอบที่ 4</option>
                                                    </select>                                
                                                </div>
                                            </div>
                                            <div class="row">&nbsp;</div>
                                            <div class="row">


                                                <input  type="text" class="form-control" value="<?= $result_seSystime['SYSTIME'] ?>" style="background-color: #f080802e;display: none" disabled="" id="txt_copydiagramdateinput32" name="txt_copydiagramdateinput32">

                                                <div class="col-lg-2">
                                                    <label>เวลารายงานตัว :</label>
                                                    <input type="text" class="form-control timeen" style="background-color: #f080802e" disabled="" id="txt_copydiagramdatepresent32" name="txt_copydiagramdatepresent32">

                                                </div>

                                                <div class="col-lg-2">
                                                    <label>เวลาเริ่มงาน ( <input type="checkbox" id="chk_copydiagramdaterk32" name="chk_copydiagramdaterk32" onchange="change_textboxdate32()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdaterk32" name="txt_copydiagramdaterk32" onchange="show_timepresent32(this.value)" autocomplete="off">
                                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdaterk232" name="txt_copydiagramdaterk232" onchange="show_timepresent32(this.value)" style="display: none" autocomplete="off">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>เวลาเข้า(ลูกค้า) ( <input type="checkbox" id="chk_copydiagramdatevlin32" name="chk_copydiagramdatevlin32" onchange="change_textboxdate32()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatevlin32" name="txt_copydiagramdatevlin32" autocomplete="off" autocomplete="off">
                                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdatevlin232" name="txt_copydiagramdatevlin232"  style="display: none" autocomplete="off">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>เวลาออก(ลูกค้า) ( <input type="checkbox" id="chk_copydiagramdatevlout32" name="chk_copydiagramdatevlout32" onchange="change_textboxdate32()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatevlout32" name="txt_copydiagramdatevlout32" autocomplete="off">
                                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdatevlout232" name="txt_copydiagramdatevlout232" style="display: none" autocomplete="off">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>เวลาเข้า(ลูกค้า2) ( <input type="checkbox" id="chk_copydiagramdatedealerin32" name="chk_copydiagramdatedealerin32" onchange="change_textboxdate32()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatedealerin32" name="txt_copydiagramdatedealerin32" autocomplete="off">
                                                    <input type="text" class="form-control  datetimeen" id="txt_copydiagramdatedealerin232" name="txt_copydiagramdatedealerin232" style="display: none" autocomplete="off">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>เวลากลับบริษัท ( <input type="checkbox" id="chk_copydiagramdatereturn32" name="chk_copydiagramdatereturn32" onchange="change_textboxdate32()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatereturn32" name="txt_copydiagramdatereturn32" autocomplete="off">
                                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdatereturn232" name="txt_copydiagramdatereturn232" style="display: none" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="row">&nbsp;</div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="well" va>
                                                        <div class="row">
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" id="chk_copydiagrammonday32" name="chk_copydiagrammonday32" checked="" value="" style="transform: scale(2)">&nbsp;<label>จันทร์</label><label id="lab_monday32"></label>
                                                                </label>
                                                            </div>

                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" id="chk_copydiagramtuesday32" name="chk_copydiagramtuesday32" checked="" value="" style="transform: scale(2)">&nbsp;<label>อังคาร</label><label id="lab_tuesday32"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" checked="" id="chk_copydiagramwednesday32" name="chk_copydiagramwednesday32" value="" style="transform: scale(2)">&nbsp;<label>พุธ</label><label id="lab_wednesday32"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" checked="" id="chk_copydiagramthursday32" name="chk_copydiagramthursday32" value="" style="transform: scale(2)">&nbsp;<label>พฤหัสบดี</label><label id="lab_thursday32"></label>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" checked="" id="chk_copydiagramfriday32" name="chk_copydiagramfriday32" value="" style="transform: scale(2)">&nbsp;<label>ศุกร์</label><label id="lab_friday32"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" checked="" id="chk_copydiagramsaturday32" name="chk_copydiagramsaturday32" value="" style="transform: scale(2)">&nbsp;<label>เสาร์</label><label id="lab_saturday32"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" id="chk_copydiagramsunday32" name="chk_copydiagramsunday32" checked="" value="" style="transform: scale(2)">&nbsp;<label>อาทิตย์</label><label id="lab_sunday32"></label>
                                                                </label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>





                                            </div>
                                            <div class="row" >
                                                <div class="col-lg-12 text-right">

                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                                                    <button type="button" class="btn btn-primary" onclick="save_copydiagramns()">บันทึก</button>
                                                </div>
                                            </div>

                                        </div>


                                        <?php
                                    } else if ($_GET['worktype'] == 'sh(n)') {  ///งานsh(n)
                                        ?>
                                        <div class="tab-pane fade active in" id="shnormal">
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    &nbsp;
                                                </div>
                                                <div class="col-lg-1" style="text-align: right">
                                                    <font style="color: red">* </font><label>ช่วงวันที่</label>
                                                </div>
                                                <div class="col-lg-3">

                                                    <input type="text" name="txt_copydiagramjobnomondayshn" id="txt_copydiagramjobnomondayshn" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnotuesdayshn" id="txt_copydiagramjobnotuesdayshn" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnowednesdayshn" id="txt_copydiagramjobnowednesdayshn" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnothursdayshn" id="txt_copydiagramjobnothursdayshn" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnofridayshn" id="txt_copydiagramjobnofridayshn" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnosaturdayshn" id="txt_copydiagramjobnosaturdayshn" class="form-control" style="display: none">
                                                    <input type="text" name="txt_copydiagramjobnosundayshn" id="txt_copydiagramjobnosundayshn" class="form-control" style="display: none">



                                                    <input type="text" name="txt_copydiagramdatestartshn"  readonly="" id="txt_copydiagramdatestartshn" onchange="add_dateweekshn(this.value)" class="form-control dateen" placeholder="วันที่เริ่มต้น...">

                                                </div>
                                                <div class="col-lg-3">
                                                    <input type="text" name="txt_copydiagramdateendshn" style="background-color: #f080802e"  disabled="" id="txt_copydiagramdateendshn" class="form-control dateen" placeholder="วันที่สิ้นสิ้นสุด...">
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12"><hr></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-2"><b><u>SH(N)1</u></b></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>พขร.(1)SHN :</label>
                                                    <input type="text"  name="txt_copydiagramemployeename1shn" id="txt_copydiagramemployeename1shn" class="form-control">
                                                </div>
                                                <div class="col-lg-1">
                                                    <label>&nbsp;</label><br>

                                                    <button class="btn btn-secondary"  id="btn_checkdriver" onclick="select_checkdriversr('1')"  name="btn_checkdriver" data-toggle="modal"  data-target="#modal_checkdriver"><span class="fa fa-check"></span> พขร.(1)</button>
                                                </div>

                                                <div class="col-lg-2">
                                                    <label>พขร.(2) :</label> <!--<div id="div_jobendemp2">-</div >-->
                                                    <input type="text"  class="form-control" name="txt_copydiagramemployeename2shn" id="txt_copydiagramemployeename2shn">
                                                </div>
                                                <div class="col-lg-1">
                                                    <label>&nbsp;</label><br>
                                                    <button class="btn btn-secondary"  id="btn_checkdriver" onclick="select_checkdriversr('2')"  name="btn_checkdriver" data-toggle="modal"  data-target="#modal_checkdriver"><span class="fa fa-check"></span> พขร.(2)</button>
                                                </div>

                                                <div class="col-lg-2">
                                                    <label>พขร.(ควบคุม)(3) :</label>
                                                    <input type="text"  class="form-control" name="txt_copydiagramemployeename3shn" id="txt_copydiagramemployeename3shn">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>&nbsp;</label><br>
                                                    <button class="btn btn-secondary"  id="btn_checkdriver" onclick="select_checkdriversr('3')"  name="btn_checkdriver" data-toggle="modal"  data-target="#modal_checkdriver"><span class="fa fa-check"></span> พขร.(ควบคุม)(3)</button>
                                                </div>

                                                <div class="col-lg-2">
                                                    <label>จำนวนคัน(กรณีงานรับกลับ) :</label>
                                                    <input  type="text" class="form-control"  id="txt_copydiagramunitshn"  name="txt_copydiagramunitshn">
                                                </div>




                                            </div>
                                            <div class="row">

                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>ชื่อรถ :</label>
                                                    <input type="text" class="form-control"  id="txt_copydiagramthainame1shn" name="txt_copydiagramthainame1shn">

                                                </div>
                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>ชื่อรถ(หาง) :</label>
                                                    <input type="text" class="form-control"  id="txt_copydiagramthainame2shn" name="txt_copydiagramthainame2shn">
                                                </div>

                                                <div class="col-lg-2">
                                                    <font style="color: red">* </font><label>ต้นทางSH(N) :</label>
                                                    <select  id="txt_copydiagramjobstartshn" name="txt_copydiagramjobstartshn" class="form-control" onchange="se_copydiagramrouteshnormal(this.value)">
                                                        <option value="">เลือกต้นทาง</option>
                                                        <option value="GW">GW</option>
                                                        <option value="BP">BP</option>
                                                        <option value="SR">SR</option>
                                                    </select>

                                                </div>
                                                <div class="col-lg-2">
                                                    <label>งานSH(N) :</label><br>
                                                    <div id="copydiagramroutedefshn">
                                                        <select  id="cb_copydiagramrouteshn" name="cb_copydiagramrouteshn" class="form-control" >
                                                            <option value="">เลือกงาน</option>
                                                        </select>
                                                        <input class="form-control" style="display:none"  id="txt_companycode_shn" name="txt_companycodeshn" maxlength="500" value="<?= $_GET['companycode'] ?>" >
                                                        <input class="form-control" style="display:none"  id="txt_customercode_shn" name="txt_customercode_shn" maxlength="500" value="<?= $_GET['customercode'] ?>" >
                                                        <input class="form-control" style="display:none"  id="txt_worktype_shn" name="txt_worktype_shn" maxlength="500" value="<?= $_GET['worktype'] ?>" >
                                                    </div>
                                                    <div id="copydiagramroutesrshn"></div>
                                                </div>


                                                <div class="col-lg-2">
                                                    <label>งาน(ย่อย)SH(N) :</label><br>
                                                    <div id="copydiagramsubroutedefshn">
                                                        <select  id="cb_copydiagramsubrouteshn" name="cb_copydiagramsubrouteshn" class="form-control" >
                                                            <option value="">เลือกงาน(ย่อย)</option>
                                                        </select>
                                                        <input class="form-control" style="display:none"  id="txt_companycode_shn" name="txt_companycodeshn" maxlength="500" value="<?= $_GET['companycode'] ?>" >
                                                        <input class="form-control" style="display:none"  id="txt_customercode_shn" name="txt_customercode_shn" maxlength="500" value="<?= $_GET['customercode'] ?>" >
                                                        <input class="form-control" style="display:none"  id="txt_worktype_shn" name="txt_worktype_shn" maxlength="500" value="<?= $_GET['worktype'] ?>" >
                                                    </div>
                                                    <div id="copydiagramsubroutesrshn"></div>

                                                </div>

                                                <div class="col-lg-2">
                                                    <label>จำนวนโหลด :</label><br>
                                                    <select  id="cb_copydiagramloadshn" name="cb_copydiagramloadshn" class="form-control">
                                                        <option value="">เลือกจำนวนโหลด</option>
                                                        <option value="4">4 Load</option>
                                                        <option value="8">8 Load</option>

                                                    </select>
                                                </div>




                                            </div>

                                            <div class="row">&nbsp;</div>
											<div class="row">                            
                                                <div class="col-lg-2">
                                                    <label>รอบที่วิ่งงาน :</label>
                                                    <select id="txt_roundamountshn" name="txt_roundamountshn" class="form-control">
                                                        <option value disabled selected>-เลือกรอบที่วิ่งงาน-</option>
                                                        <option value="1">รอบที่ 1</option>
                                                        <option value="2">รอบที่ 2</option>
                                                        <option value="3">รอบที่ 3</option>
                                                        <option value="4">รอบที่ 4</option>
                                                    </select>                                
                                                </div>
                                            </div>
                                            <div class="row">&nbsp;</div>
                                            <div class="row">


                                                <input  type="text" class="form-control" value="<?= $result_seSystime['SYSTIME'] ?>" style="background-color: #f080802e;display: none" disabled="" id="txt_copydiagramdateinputshn" name="txt_copydiagramdateinputshn">

                                                <div class="col-lg-2">
                                                    <label>เวลารายงานตัว :</label>
                                                    <input type="text" class="form-control timeen" style="background-color: #f080802e" disabled="" id="txt_copydiagramdatepresentshn" name="txt_copydiagramdatepresentshn">

                                                </div>

                                                <div class="col-lg-2">
                                                    <label>เวลาเริ่มงาน ( <input type="checkbox" id="chk_copydiagramdaterkshn" name="chk_copydiagramdaterkshn" onchange="change_textboxdateshn()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdaterkshn" name="txt_copydiagramdaterkshn" onchange="show_timepresentshn(this.value)" autocomplete="off">
                                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdaterk2shn" name="txt_copydiagramdaterk2shn" onchange="show_timepresentshn(this.value)" style="display: none" autocomplete="off">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>เวลาเข้า(ลูกค้า) ( <input type="checkbox" id="chk_copydiagramdatevlinshn" name="chk_copydiagramdatevlinshn" onchange="change_textboxdateshn()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatevlinshn" name="txt_copydiagramdatevlinshn" autocomplete="off" autocomplete="off">
                                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdatevlin2shn" name="txt_copydiagramdatevlin2shn"  style="display: none" autocomplete="off">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>เวลาออก(ลูกค้า) ( <input type="checkbox" id="chk_copydiagramdatevloutshn" name="chk_copydiagramdatevloutshn" onchange="change_textboxdateshn()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatevloutshn" name="txt_copydiagramdatevloutshn" autocomplete="off">
                                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdatevlout2shn" name="txt_copydiagramdatevlout2shn" style="display: none" autocomplete="off">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>เวลาเข้า(ลูกค้า2) ( <input type="checkbox" id="chk_copydiagramdatedealerinshn" name="chk_copydiagramdatedealerinshn" onchange="change_textboxdateshn()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatedealerinshn" name="txt_copydiagramdatedealerinshn" autocomplete="off">
                                                    <input type="text" class="form-control  datetimeen" id="txt_copydiagramdatedealerin2shn" name="txt_copydiagramdatedealerin2shn" style="display: none" autocomplete="off">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>เวลากลับบริษัท ( <input type="checkbox" id="chk_copydiagramdatereturnshn" name="chk_copydiagramdatereturnshn" onchange="change_textboxdateshn()"> : ข้ามวัน )</label>
                                                    <input type="text" class="form-control timeen" id="txt_copydiagramdatereturnshn" name="txt_copydiagramdatereturnshn" autocomplete="off">
                                                    <input type="text" class="form-control datetimeen" id="txt_copydiagramdatereturn2shn" name="txt_copydiagramdatereturn2shn" style="display: none" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="row">&nbsp;</div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="well" va>
                                                        <div class="row">
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" id="chk_copydiagrammondayshn" name="chk_copydiagrammondayshn" checked="" value="" style="transform: scale(2)">&nbsp;<label>จันทร์</label><label id="lab_mondayshn"></label>
                                                                </label>
                                                            </div>

                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" id="chk_copydiagramtuesdayshn" name="chk_copydiagramtuesdayshn" checked="" value="" style="transform: scale(2)">&nbsp;<label>อังคาร</label><label id="lab_tuesdayshn"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" checked="" id="chk_copydiagramwednesdayshn" name="chk_copydiagramwednesdayshn" value="" style="transform: scale(2)">&nbsp;<label>พุธ</label><label id="lab_wednesdayshn"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" checked="" id="chk_copydiagramthursdayshn" name="chk_copydiagramthursdayshn" value="" style="transform: scale(2)">&nbsp;<label>พฤหัสบดี</label><label id="lab_thursdayshn"></label>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" checked="" id="chk_copydiagramfridayshn" name="chk_copydiagramfridayshn" value="" style="transform: scale(2)">&nbsp;<label>ศุกร์</label><label id="lab_fridayshn"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" checked="" id="chk_copydiagramsaturdayshn" name="chk_copydiagramsaturdayshn" value="" style="transform: scale(2)">&nbsp;<label>เสาร์</label><label id="lab_saturdayshn"></label>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" id="chk_copydiagramsundayshn" name="chk_copydiagramsundayshn" checked="" value="" style="transform: scale(2)">&nbsp;<label>อาทิตย์</label><label id="lab_sundayshn"></label>
                                                                </label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row" >
                                                        <div class="col-lg-12 text-right">

                                                            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                                                            <button type="button" class="btn btn-primary" onclick="save_copydiagramshn()">บันทึก</button>
                                                        </div>
                                                    </div>
                                                </div>





                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>


                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_checkdriver" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-modal-parent="#modal_copydiagram">
            <div class="modal-dialog" style="width: 60%">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">

                        <h5 class="modal-title">ประสปการณ์ในเส้นทางและสถานที่รับส่งสินค้า</h5>
                    </div>
                    <div class="modal-body">
                        <div id="modal_checkdriversr"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal fade" id="modal_adddn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="width: 80%">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="title">เอกสารรายละเอียดสินค้า</h5>

                    </div>
                    <div class="modal-body">

                        <div class="row" >

                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        วันที่/เวลา ปฎิบัติงานจริง
                                    </div>
                                    <!-- /.panel-heading -->
                                    <div class="panel-body">
                                        <div class="table-responsive">


                                            <div id="datadef_actual">
                                                <table class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>

                                                            <th>เวลารายงานตัว</th>
                                                            <th>เวลาเปิดงาน</th>
                                                            <th>เวลาเข้า VL</th>
                                                            <th>เวลาออก VL</th>
                                                            <th>เวลาเข้า(ลูกค้า2)</th>
                                                            <th>เวลากลับบริษัท</th>
                                                            <th>เวลาปิดงาน</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        /* $sql_seVehicletransportplan = "{call megVehicletransportplan_v2(?,?)}";
                                                          $params_seVehicletransportplan = array(
                                                          array('select_vehicletransportplan', SQLSRV_PARAM_IN),
                                                          array('', SQLSRV_PARAM_IN)
                                                          );
                                                          $query_seVehicletransportplan = sqlsrv_query($conn, $sql_seVehicletransportplan, $params_seVehicletransportplan);
                                                          while ($result_seVehicletransportplan = sqlsrv_fetch_array($query_seVehicletransportplan, SQLSRV_FETCH_ASSOC)) {
                                                         */
                                                        ?>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td><input type="text" class="form-control datetimeen" onchange="edit_vehicletransportplanactual(this.value, 'DATEVLIN_ACTUAL')"</td>
                                                            <td><input type="text" class="form-control datetimeen" onchange="edit_vehicletransportplanactual(this.value, 'DATEVLOUT_ACTUAL')"></td>
                                                            <td><input type="text" class="form-control datetimeen" onchange="edit_vehicletransportplanactual(this.value, 'DATEDEALERIN_ACTUAL')"></td>
                                                            <td><input type="text" class="form-control datetimeen" onchange="edit_vehicletransportplanactual(this.value, 'DATERETURN_ACTUAL')"></td>
                                                            <td><input type="text" class="form-control datetimeen" onchange="edit_vehicletransportplanactual(this.value, 'DATECLOSE_ACTUAL')"></td>

                                                        </tr>
                                                        <?php
//}
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="datasr_actual"></div>
                                        </div>
                                        <!-- /.table-responsive -->
                                    </div>
                                    <!-- /.panel-body -->
                                </div>
                                <!-- /.panel -->
                            </div>
                        </div>
                        <div class="row" >

                            <input class="form-control" id="txt_route" name="txt_route" style="display: none" >
                            <input class="form-control" id="txt_vehicletransportplanid" name="txt_vehicletransportplanid" style="display: none" >
                            <input class="form-control" id="txt_jobno" name="txt_jobno" style="display: none" >


                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        เอกสารรายละเอียดสินค้า
                                    </div>
                                    <!-- /.panel-heading -->
                                    <div class="panel-body">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <font style="color: red">* </font><label>ประเภทเอกสาร :</label>
                                                <select  class="form-control" id="cb_documenttype" name="cb_documenttype">
                                                    <option value="DOC-0001">เอกสารรายละเอียดสินค้า</option>
                                                    <option value="DOC-0002">ใบวางบิลของลูกค้า</option>
                                                    <option value="DOC-0003">เอกสารอื่นๆ</option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-2">

                                            <div class="form-group">
                                                <font style="color: red">* </font><label>จำนวน :</label>
                                                <input class="form-control" id="txt_amount" name="txt_amount">
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <font style="color: red">* </font> <label>หน่วย :</label>
                                                <select  class="form-control" id="cb_unit" name="cb_unit">
                                                    <option   value ="UNIT-041425">คัน</option>
                                                    <?php
                                                    $sql_seUnit = "{call megUnit_v2(?,?)}";
                                                    $params_seUnit = array(
                                                        array('select_unit', SQLSRV_PARAM_IN),
                                                        array('', SQLSRV_PARAM_IN)
                                                    );
                                                    $query_seUnit = sqlsrv_query($conn, $sql_seUnit, $params_seUnit);
                                                    while ($result_seUnit = sqlsrv_fetch_array($query_seUnit, SQLSRV_FETCH_ASSOC)) {
                                                        ?>
                                                        <option   value ="<?= $result_seUnit['UNITCODE'] ?>"><?= $result_seUnit['UNITDESC'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">

                                            <div class="form-group">
                                                <label>หมายเหตุ :</label>
                                                <textarea class="form-control" id="txt_documentremark" name="txt_documentremark"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <font style="color: red">* </font><label>สถานะ :</label>

                                                <select class="form-control" id="cb_activestatus" name="cb_activestatus">

                                                    <?php
                                                    $selected = "SELECTED";

                                                    switch ($result_getCustomer['ACTIVESTATUS']) {
                                                        case '1': {
                                                                ?>
                                                                <option value = "0" >ไม่ใช้งาน</option>
                                                                <option value = "1" <?= $selected ?>>ใช้งาน</option>
                                                                <?php
                                                            }
                                                            break;
                                                        case '0': {
                                                                ?>
                                                                <option value = "0" <?= $selected ?>>ไม่ใช้งาน</option>
                                                                <option value="1" >ใช้งาน</option>
                                                                <?php
                                                            }
                                                            break;

                                                        default : {
                                                                ?>
                                                                <option value = "1">ใช้งาน</option>
                                                                <option value="0" >ไม่ใช้งาน</option>
                                                                <?php
                                                            }
                                                            break;
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div id="datadef"></div>
                                            <div id="datasr"></div>
                                        </div>
                                        <!-- /.table-responsive -->
                                    </div>
                                    <!-- /.panel-body -->
                                </div>
                                <!-- /.panel -->
                            </div>


                        </div>



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                        <button type="button" class="btn btn-primary" onclick="save_vehicletransportdocument()">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>



        <div class="row" >
            <div class="col-lg-12">
                &nbsp;
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">

            <div class="col-lg-12" style="text-align: right">


                <form method="post">
                    <input class="btn btn-default" type="button" style="background-color: red;border:solid 2px white" id="btn_srquotation" name="btn_srquotation" value=""> * แจ้งเตือนข้อมูล ไม่พบราคาขนส่ง &emsp;
                    <input type="text" id="txt_vehicletransportdocumentid" name="txt_vehicletransportdocumentid" class="form-control" style="display: none"  value="">
                    <input type="text" id="txt_companycode" name="txt_companycode" class="form-control" style="display: none"  value="<?= $_GET['companycode'] ?>">
                    <input type="text" id="txt_customercode" name="txt_customercode" class="form-control" style="display: none"  value="<?= $_GET['customercode'] ?>">
                    <input class="form-control" style="display: none"  id="txt_copydiagramsubroute" name="txt_copydiagramsubroute" maxlength="500" value="" >
                    <!--<button type="button" id="addrow" name="addrow" onclick="javascript:appendRow()" class="btn btn-outline btn-default"><li class="fa fa-plus-circle"></li> เพิ่มแถว</button>-->
                    <input  style="margin-right: 15px" type="button"  data-toggle="modal"  data-target="#modal_copydiagram"  class=" btn btn-default" value="NEW DIAGRAM">
                    <!--<input  style="margin-right: 15px"  type="button"  onclick="save_vehicletransportplan('<?php //echo $_GET['EMPLOYEENAME1']                                                                                                                                                                                                ?>')"  class=" btn btn-default" value="NEW JOB">-->
                    <!--<button type="button" onclick="javascript:deleteRows()" class="btn btn-outline btn-default"><li class="fa fa-plus-circle"></li> ลบแถว</button>-->
                    <!--<button type="button" onclick="javascript:appendColumn()" class="btn btn-outline btn-default"><li class="fa fa-minus-circle"></li> เพิ่มคอลัมม์</button>-->
                    <!--<button type="button" onclick="javascript:deleteColumns()" class="btn btn-outline btn-default"><li class="fa fa-minus-circle"></li> ลบคอลัมม์</button>
                    <button type="button" onclick="javascript:deleteColumns();deleteRows()" class="btn btn-outline btn-default"><li class="fa fa-minus-circle"></li> ลบแถวและคอลัมม์</button>-->
                </form>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12">&nbsp;</div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color: #e7e7e7">
                        <div class="row">
                            <div class="col-lg-6">
                                <?php
                                $meg = 'แผนขนส่ง';

                                echo "<a href='report_companygetway.php'>บริษัท</a> / <a href='report_customergetway.php?type=report&companycode=" . $_GET['companycode'] . "'>ลูกค้า</a>  / " . $meg;
                                $link = "<a href='report_companygetway.php?type=report'>บริษัท</a> / <a href='report_customergetway.php?type=report&companycode=" . $_GET['companycode'] . "'>ลูกค้า</a> ";


                                $_SESSION["link"] = $link;
                                ?>
                            </div>
                            <div class="col-lg-6 text-right"><?= $result_seComp['Company_NameT'] ?> / <?= $result_seCustomer['NAMETH'] ?></div>
                        </div>
                    </div>
                    <!-- /.panel-heading -->

                    <div class="panel-body">

                        <div class="row" >
                            <!--<div class="col-lg-4"><br>
                                <a href="#" onclick="pdf_transportplan();" class="btn btn-default">PDF <li class="fa fa-print"></li></a>
                            </div>-->

                            <div class="col-lg-6">&nbsp;</div>
                            <div class="col-lg-2" >วันที่เริ่มต้น
                                <input type="text" value="<?= $result_seSystime['STARTWEEK']; ?>" name="txt_datestartsr" readonly="" id="txt_datestartsr" onchange="add_dateweek1(this.value)" class="form-control dateen" >
                            </div>

                            <div class="col-lg-2" >วันที่สิ้นสุด
                                <input type="text" value="<?= $result_seSystime['ENDWEEK']; ?>" name="txt_dateendsr" style="background-color: #f080802e"  disabled=""  id="txt_dateendsr" class="form-control dateen" >
                            </div>
                            <div class="col-lg-2 " >สถานะ
                                <select  class="form-control" id="cb_statussr" name="cb_statussr" onchange="dateendsr()">
                                    <option   value ="">แผนงานทั้งหมด (<?= $_GET['worktype']?>)</option>               
                                    <option   value ="O">แผนงานยังไม่ถึงเวลารายงาน</option>
                                    <option   value ="P">แผนงานรายงานตัวเรียบร้อย</option>
                                    <option   value ="L">แผนงานเลยเวลารายงานตัว</option>
                                    <option   value ="1">แผนงานเปิดงาน</option>
                                    <option   value ="2">แผนงานปิดงาน</option>
                                    <option   value ="3">แผนงานเอกสารสมบูรณ์</option>
                                    <option   value ="0">แผนงานยกเลิก</option>
                                    <option   value ="X">แผนงานตัดงาน</option>
                                </select>
                            </div>


                        </div>
                        <div class="row" >&nbsp;</div>

                        <div id="showdatadef">
                            <div class="row">
                                <div class="col-lg-12">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#monday" data-toggle="tab" aria-expanded="true" onclick="show_monday()">จันทร์<label id="lbl_m"></label></a>
                                        </li>
                                        <li class=""><a href="#tuesday" data-toggle="tab" aria-expanded="true" onclick="show_tuesday()">อังคาร<label id="lbl_tu"></label></a>
                                        </li>
                                        <li class=""><a href="#wednesday" data-toggle="tab" aria-expanded="false" onclick="show_wednesday()">พุธ<label id="lbl_w"></label></a>
                                        </li>

                                        <li class=""><a href="#thursday" data-toggle="tab" aria-expanded="false" onclick="show_thursday()">พฤหัสบดี<label id="lbl_th"></label></a>

                                        <li class=""><a href="#friday" data-toggle="tab" aria-expanded="false" onclick="show_friday()">ศุกร์<label id="lbl_f"></label></a>
                                        </li>
                                        <li class=""><a href="#saturday" data-toggle="tab" aria-expanded="false" onclick="show_saturday()">เสาร์<label id="lbl_sat"></label></a>
                                        </li>
                                        <li class=""><a href="#sunday" data-toggle="tab" aria-expanded="false" onclick="show_sunday()">อาทิตย์<label id="lbl_sun"></label></a>
                                        </li>
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <p>&nbsp;</p>


                                        <div class="tab-pane fade active in" id="mondaydef">
                                            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                <div id="show_mondaydef">
                                                    <form name="frmMain" action="meg_deletetransportplan.php" method="post" OnSubmit="return onDelete();">
                                                        
                                                        <input type="text" id="url" name="url" value="<?= $_SERVER['REQUEST_URI'] ?>" style="display: none">
                                                        <table  class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example11" role="grid" aria-describedby="dataTables-example11" style="width: 100%;">
                                                            <thead >
                                                                <tr>

                                                                    <th style="text-align: center;"><label style="width: 50px"><input type="submit" name="btnDelete" class="btn btn-default btn-circle" value="ลบ"></label></th>
                                                                    <th style="text-align: center;"><label style="width: 50px">DELETE JOBGW</label></th>
                                                                    <th style="text-align: center;"><label style="width: 50px">EDIT JOB</label></th>
                                                                    <th style="text-align: center;"><label style="width: 50px">COPY JOB</label></th>
                                                                    <!--<th style="text-align: center;"><label style="width: 50px">COPY ROOT</label></th>-->
                                                                    <!--<th style="text-align: center;"><label style="width: 50px">ADD DN</label></th>-->
                                                                    <?php
                                                                    if ($_GET['companycode'] == 'RCC' || $_GET['companycode'] == 'RATC') {
                                                                        ?>
                                                                        <th style="text-align: center;"><label style="width: 100px">ขาไป / กลับ</label></th>
                                                                        <th style="text-align: center;"><label style="width: 50px">รอบที่วิ่งงาน</label></th>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <th style="text-align: center;"><label style="width: 100px">รอบวิ่ง</label></th>
                                                                        <?php
                                                                    }
                                                                    ?>

                                                                    <th style="text-align: center;"><label style="width: 200px">พนักงาน(1)</label></th>
                                                                    <th style="text-align: center;"><label style="width: 200px">พนักงาน(2)</label></th>
                                                                    <th style="text-align: center;"><label style="width: 200px">ชื่อรถ</label></th>
                                                                    <th style="text-align: center;"><label style="width: 200px">ต้นทาง</label></th>
                                                                    <th style="text-align: center;"><label style="width: 200px">CLUSTER</label></th>
                                                                    <th style="text-align: center;"><label style="width: 200px">ปลายทาง</label></th>
                                                                    <th style="text-align: center;"><label style="width: 100px">JOB NO</label></th>
                                                                    <th style="text-align: center;"><label style="width: 100px">TRIP </label></th>
                                                                    <th style="text-align: center;"><label style="width: 100px">ทำแผน</label></th>

                                                                    <th style="text-align: center;"><label style="width: 100px">รายงานตัว</label></th>
                                                                    <th style="text-align: center;"><label style="width: 100px">ทำงาน</label></th>
                                                                    <th style="text-align: center;"><label style="width: 100px">เข้า(ลูกค้า)</label></th>
                                                                    <th style="text-align: center;"><label style="width: 100px">ออก(ลูกค้า)</label></th>
                                                                    <th style="text-align: center;"><label style="width: 100px">เข้า(ลูกค้า2)</label></th>
                                                                    <th style="text-align: center;"><label style="width: 100px">กลับบริษัท</label></th>
                                                                    <th style="text-align: center;"><label style="width: 100px">สถานะ</label></th>

                                                                <!--<th style="text-align: center;">สายงาน</th>-->


                                                                </tr>

                                                            </thead>
                                                            <tbody>
                                                                    
                                                                <?php
                                                                // echo "แผนงานเริ่มวัน";
                                                                $i1 = 1;

                                                                
                                                                $sql_seGetdate = "SELECT CASE WHEN DATEPART(dw,GETDATE()) = '1' THEN CONVERT(NVARCHAR(30),DATEADD(DAY,1,GETDATE()),103)
                                                                WHEN DATEPART(dw,GETDATE()) = '3' THEN CONVERT(NVARCHAR(30),DATEADD(DAY,-1,GETDATE()),103)
                                                                WHEN DATEPART(dw,GETDATE()) = '4' THEN CONVERT(NVARCHAR(30),DATEADD(DAY,-2,GETDATE()),103)
                                                                WHEN DATEPART(dw,GETDATE()) = '5' THEN CONVERT(NVARCHAR(30),DATEADD(DAY,-3,GETDATE()),103)
                                                                WHEN DATEPART(dw,GETDATE()) = '6' THEN CONVERT(NVARCHAR(30),DATEADD(DAY,-4,GETDATE()),103)
                                                                WHEN DATEPART(dw,GETDATE()) = '7' THEN CONVERT(NVARCHAR(30),DATEADD(DAY,-5,GETDATE()),103)
                                                                ELSE CONVERT(NVARCHAR(30),GETDATE(),103) END AS 'FWEEKDAY'";
                                                                $params_seGetdate = array();
                                                                $query_seGetdate = sqlsrv_query($conn, $sql_seGetdate, $params_seGetdate);
                                                                $result_seGetdate = sqlsrv_fetch_array($query_seGetdate, SQLSRV_FETCH_ASSOC);

                                                                if ($_GET['vehicletransportplanid'] != "") {
                                                                    $conditionmonday1 = "  AND a.VEHICLETRANSPORTPLANID = '" . $_GET['vehicletransportplanid'] . "' ";
                                                                } else {
                                                                    $conditionmonday1 = " AND (CONVERT(DATE,a.DATEWORKING,103) BETWEEN CONVERT(DATE,'".$result_seGetdate['FWEEKDAY']."',103) AND CONVERT(DATE,GETDATE(),103))";
                                                                }
                                                                // $conditionmonday2 = " AND a.STATUSNUMBER = 'O' AND DATENAME(DW,a.DATEWORKING) = 'Monday' AND a.COMPANYCODE ='" . $_GET['companycode'] . "' AND a.CUSTOMERCODE ='" . $_GET['customercode'] . "'";
                                                                // $sql_sePlanmonday = "{call megVehicletransportplan_v2(?,?,?,?)}";
                                                                // $params_sePlanmonday = array(
                                                                //     array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
                                                                //     array($conditionmonday1, SQLSRV_PARAM_IN),
                                                                //     array(" AND (a.WORKTYPE = '" . $_GET['worktype'] . "' OR a.WORKTYPE IS NULL) AND b.CARRYTYPE = '" . $_GET['carrytype'] . "'", SQLSRV_PARAM_IN),
                                                                //     array($conditionmonday2, SQLSRV_PARAM_IN)
                                                                // );

                                                                $conditionmonday2 = "  AND DATENAME(DW,a.DATEWORKING) = 'Monday' AND a.COMPANYCODE ='" . $_GET['companycode'] . "' AND a.CUSTOMERCODE ='" . $_GET['customercode'] . "'";
                                                                $sql_sePlanmonday = "{call megVehicletransportplan_v2(?,?,?,?)}";
                                                                $params_sePlanmonday = array(
                                                                    array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
                                                                    array($conditionmonday1, SQLSRV_PARAM_IN),
                                                                    array(" AND (a.WORKTYPE = '" . $_GET['worktype'] . "' OR a.WORKTYPE IS NULL) AND  (b.CARRYTYPE = '" . $_GET['carrytype'] . "' OR b.CARRYTYPE IS NULL)", SQLSRV_PARAM_IN),
                                                                    array($conditionmonday2, SQLSRV_PARAM_IN)
                                                                );

                                                                $query_sePlanmonday = sqlsrv_query($conn, $sql_sePlanmonday, $params_sePlanmonday);
                                                                while ($result_sePlanmonday = sqlsrv_fetch_array($query_sePlanmonday, SQLSRV_FETCH_ASSOC)) {
                                                                    ?>
                                                                    <tr
                                                                    <?php
                                                                    // PRICEID = NULL
                                                                    if ($result_sePlanmonday['VEHICLETRANSPORTPRICEID'] == NULL || $result_sePlanmonday['VEHICLETRANSPORTPRICEID'] == '') {
                                                                        // if ($result_sePlanmonday['C2'] == '' || $result_sePlanmonday['C2'] == NULL) { // C2 คือจำนวนงานรับกลับ
                                                                            ?>
                                                                                style="color: red"
                                                                                <?php
                                                                            // }
                                                                            // ACTUALPRICE = NULL
                                                                        } else if ($result_sePlanmonday['ACTUALPRICE'] == NULL || $result_sePlanmonday['ACTUALPRICE'] == '' || $result_sePlanmonday['ACTUALPRICE'] == '0.00') {
                                                                            ?>
                                                                            style="color: orange"
                                                                            <?php
                                                                        } else {
                                                                            ?>

                                                                            <?php
                                                                        }
                                                                        ?>
                                                                        >

                                                                        <td align="center"><input class="form-control" type="checkbox" name="chkDel[]" value="<?php echo $result_sePlanmonday["VEHICLETRANSPORTPLANID"]; ?>"></td>

                                                                        <td style="text-align: center;">
                                                                            <button onclick="delete_vehicletransportplan('<?= $result_sePlanmonday['VEHICLETRANSPORTPLANID'] ?>');" title="ลบแผนการขนส่ง" type="button" class="btn btn-default btn-circle"><span class="fa fa-times"></span></button>
                                                                        </td>


                                                                        <td style="text-align: center;">
                                                                            <button onclick="update_modalrcc('<?= $result_sePlanmonday['VEHICLETRANSPORTPLANID'] ?>')"  data-toggle="modal"  data-target="#modal_copydiagramupd"  title="แก้ไขแผนการขนส่ง" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-wrench"></span></button>
                                                                        </td>
                                                                        <td style="text-align: center;">
                                                                            <button title="COPY JOB" type="button" onclick="select_copyjob('<?= $result_sePlanmonday['JOBNO'] ?>', '<?= $result_sePlanmonday['JOBSTART'] ?>', '<?= $result_sePlanmonday['JOBEND'] ?>', '<?= $result_sePlanmonday['DATEVLIN'] ?>');" class="btn btn-default btn-circle" data-toggle="modal"  data-target="#modal_copyjob"><span class="fa fa-copy"></span></button>
                                                                        </td>
                                                                        <?php
                                                                        if ($_GET['companycode'] == 'RCC' || $_GET['companycode'] == 'RATC') {
                                                                            if ($result_sePlanmonday['C2'] != '' || $result_sePlanmonday['C2'] != NULL) { // C2 คือจำนวนงานรับกลับ ?>
                                                                                <td style="text-align: center">งานรับกลับ</td>
                                                                            <?php } else { ?>
                                                                                <td style="text-align: center">&nbsp;</td>
                                                                            <?php } ?>                                                                            
                                                                            <!-- <td style="text-align: center"><?= $result_sePlanmonday['ROUNDAMOUNT'] ?></td>       -->      
                                                                            <td>
                                                                                <?php if($result_sePlanmonday['ROUNDAMOUNT'] != '') { ?>
                                                                                    <select id="txt_roundamountgw" name="txt_roundamountgw" class="form-control" onchange="update_copydiagram('<?= $result_sePlanmonday['VEHICLETRANSPORTPLANID'] ?>', 'ROUNDAMOUNT', this.value)">
                                                                                        <option value disabled selected>--</option>                                                                                        
                                                                                        <?php
                                                                                            $sql_slram = "SELECT * FROM [dbo].[ROUNDAMOUNT] WHERE ID IN(1,2,5,6)";
                                                                                            $query_slram = sqlsrv_query($conn, $sql_slram);
                                                                                            while($result_slram = sqlsrv_fetch_array($query_slram, SQLSRV_FETCH_ASSOC)) {
                                                                                            $selected = "";
                                                                                            $SePY_CCID = $result_sePlanmonday['ROUNDAMOUNT'];
                                                                                                $SeCC_ID = $result_slram['NAME'];
                                                                                            if ($SePY_CCID == $SeCC_ID) { $selected = "selected"; }
                                                                                        ?>
                                                                                        <option value="<?=$result_slram['NAME']?>" <?= $selected ?>>รอบที่ <?php echo $result_slram["NAME"];?></option>
                                                                                        <?php } ?>
                                                                                    </select>  
                                                                                <?php } ?>
                                                                            </td>
                                                                            <?php
                                                                        } else { ?>
                                                                            <td style="text-align: center"><?= $result_sePlanmonday['ROUNDAMOUNT'] ?></td>
                                                                            <?php
                                                                        }
                                                                        ?>

                                                                        <td><?= $result_sePlanmonday['EMPLOYEENAME1'] ?></td>
                                                                        <td><?= $result_sePlanmonday['EMPLOYEENAME2'] ?></td>
                                                                        <td><?= $result_sePlanmonday['THAINAME'] ?></td>
                                                                        <td><?= $result_sePlanmonday['JOBSTART'] ?></td>
                                                                        <td><?= $result_sePlanmonday['CLUSTER'] ?></td>
                                                                        <td><?= $result_sePlanmonday['JOBEND'] ?></td>
                                                                        <td ><?= $result_sePlanmonday['JOBNO'] ?></td>
                                                                        <td ><?= $result_sePlanmonday['TRIPNO'] ?></td>
                                                                        <td><?= $result_sePlanmonday['DATEINPUT'] ?></td>
                                                                        <td><?= $result_sePlanmonday['DATEPRESENT'] ?></td>
                                                                        <!-- แก้ไขเวลาทำงาน เฉพาะสายงาน RCC และ RATC -->
                                                                        <?php
                                                                        if ($_GET['companycode'] == 'RCC' || $_GET['companycode'] == 'RATC') {
                                                                        ?>
                                                                            <td><input  type="button"     id="btn_remark15" name="btn_remark15" class="btn btn-default" onclick ="open_modaldaterk('<?= $result_sePlanmonday['VEHICLETRANSPORTPLANID'] ?>','<?= $result_sePlanmonday['JOBSTART'] ?>','<?= $result_sePlanmonday['WORKTYPE'] ?>');" value="<?= $result_sePlanmonday['DATERK'] ?>"></td>                                   
                                                                        <?php
                                                                        }else{
                                                                        ?>
                                                                            <td><?= $result_sePlanmonday['DATERK'] ?></td>
                                                                        <?php
                                                                        }
                                                                        ?>

                                                                        <td><?= $result_sePlanmonday['DATEVLIN'] ?></td>
                                                                        <td><?= $result_sePlanmonday['DATEVLOUT'] ?></td>
                                                                        <td><?= $result_sePlanmonday['DATEDEALERIN'] ?></td>
                                                                        <td><?= $result_sePlanmonday['DATERETURN'] ?></td>
                                                                        <td>
                                                                            <?php
                                                                            switch ($result_sePlanmonday['STATUSNUMBER']) {
                                                                                case '0': {
                                                                                        ?>
                                                                                        แผนงานยกเลิก

                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                case 'O': {
                                                                                        ?>
                                                                                        แผนงานยังไม่ถึงเวลารายงาน
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                case 'L': {
                                                                                        ?>
                                                                                        แผนงานเลยเวลารายงานตัว
                                                                                        <?php
                                                                                    }
                                                                                    break;

                                                                                case '1': {
                                                                                        ?>
                                                                                        แผนงานเปิดงาน
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                case '2': {
                                                                                        ?>
                                                                                        แผนงานปิดงาน
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                case '3': {
                                                                                        ?>
                                                                                        แผนงานเอกสารสมบูรณ์
                                                                                        <?php
                                                                                    }
                                                                                    break;
                                                                                default : {
                                                                                        
                                                                                    }
                                                                                    break;
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                    $i1++;
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </form>  
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade " id="monday">
                                            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                <div id="show_monday"></div>

                                            </div>
                                        </div>


                                        <div class="tab-pane fade " id="tuesday">

                                            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                <div id="show_tuesday"></div>

                                            </div>
                                        </div>


                                        <div class="tab-pane fade " id="wednesday">

                                            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                <div id="show_wednesday"></div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade " id="thursday">

                                            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                <div id="show_thursday"></div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade " id="friday">

                                            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                <div id="show_friday"></div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade " id="saturday">

                                            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                <div id="show_saturday"></div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade " id="sunday">

                                            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                <div id="show_sunday"></div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="showdatasr">

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
                                <b>ต้นทางของแผนงานนี้: <input disabled=""  type="text"  autocomplete="off"  id="txt_jobstartshow_editdaterk" name="txt_jobstartshow_editdaterk" value=""></b><br>
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

        
        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="../vendor/metisMenu/metisMenu.min.js"></script>
        <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
        <script src="../dist/js/sb-admin-2.js"></script>
        <script src="../js/jquery.datetimepicker.full.js"></script>
        <script src="../dist/js/jquery.autocomplete.js"></script>
        <script src="../dist/js/bootstrap-select.js"></script>
        <script src="../dist/js/select2.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" crossorigin="anonymous"></script>    
        
        

        <?php
        $job = '';


        $job = select_jobautocomplatestarttttsh('megVehicletransportprice_v2', 'select_fromtttsh', '');


        $thainame = select_carautocomplate('megVehicleinfo_v2', 'selectcond_vehicleinfo', " AND a.THAINAME != '-' AND (a.ENGNAME  LIKE '%R-%' OR a.ENGNAME  LIKE '%RA-%' OR a.ENGNAME  LIKE '%G-%'", " OR a.THAINAME LIKE '%ดินแดง%'  OR a.THAINAME  LIKE '%อุทัยธานี%'  OR a.THAINAME  LIKE '%คลองเขื่อน%'  ", " OR a.THAINAME LIKE '%RP-%' OR a.THAINAME  LIKE '%สวนผึ้ง%' OR a.THAINAME  LIKE '%ด่านช้าง%'", " OR a.ENGNAME LIKE '%Khao Chamao%' OR a.ENGNAME LIKE '%Kerry%' OR a.ENGNAME LIKE '%Chaloem Prakiat%' OR a.THAINAME LIKE '%แปลงยาว%' OR a.THAINAME LIKE '%สนามชัยเขต%')");

        $jobrccend = select_jobautocomplateendgetway('megVehicletransportprice_v2', 'select_to', '');


        $emp = select_empautocomplate('megEmployeeEHR_v2', 'select_employeeehr2', " ");
        //$cluster = select_clusterautocomplate('megVehicletransportprice_v2', 'select_cluster', '');
        ?>


        <script type="text/javascript">


                                                                        // function การแก้ไขเวลาในหน้าแผนงาน

                                                                        function open_modaldaterk(planid,jobstart,worktype){
                                                                            $('#modal_editdaterk').modal('show');
                                                                            document.getElementById("txt_planid_editdaterk").value = planid;
                                                                            document.getElementById("txt_jobstart_editdaterk").value = jobstart;
                                                                            document.getElementById("txt_jobstartshow_editdaterk").value = jobstart;
                                                                            document.getElementById("txt_worktype_editdaterk").value = worktype;
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
                                                                        function save_daterk(){

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
                                                                        ///////////////////////////////////////////////////////
                                                                        
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

                                                                        $('#txt_copydiagramjobstart11').select2({
                                                                            placeholder: 'เลือกต้นทาง'
                                                                        });
                                                                        $('#txt_copydiagramjobstart21').select2({
                                                                            placeholder: 'เลือกต้นทาง'
                                                                        });
                                                                        $('#txt_copydiagramjobstart22').select2({
                                                                            placeholder: 'เลือกต้นทาง'
                                                                        });
                                                                        $('#txt_copydiagramjobstart31').select2({
                                                                            placeholder: 'เลือกต้นทาง'
                                                                        });
                                                                        $('#txt_copydiagramjobstarshn').select2({
                                                                            placeholder: 'เลือกต้นทาง'
                                                                        });
                                                                        $('#cb_copydiagramcluster21').select2({
                                                                            placeholder: 'เลือก Cluster'
                                                                        });
                                                                        $('#cb_copydiagramcluster22').select2({
                                                                            placeholder: 'เลือก Cluster'
                                                                        });



                                                                        function show_monday()
                                                                        {
                                                                            $.ajax({
                                                                                type: 'post',
                                                                                url: 'meg_data.php',
                                                                                data: {
                                                                                    txt_flg: "show_monday", companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', vehicletransportplanid: '<?= $_GET['vehicletransportplanid'] ?>', STARTWEEK: document.getElementById("txt_datestartsr").value, ENDWEEK: document.getElementById("txt_dateendsr").value, condish: "<?= $condish ?>", statusnumber: document.getElementById("cb_statussr").value, worktype: '<?= $_GET['worktype'] ?>', carrytype: '<?= $_GET['carrytype'] ?>'
                                                                                    , url: '<?= $_SERVER['REQUEST_URI'] ?>'
                                                                                },
                                                                                success: function (rs) {

                                                                                    document.getElementById("show_monday").innerHTML = rs;
                                                                                    document.getElementById("show_mondaydef").innerHTML = "";
                                                                                    document.getElementById("show_tuesday").innerHTML = "";
                                                                                    document.getElementById("show_wednesday").innerHTML = "";
                                                                                    document.getElementById("show_thursday").innerHTML = "";
                                                                                    document.getElementById("show_friday").innerHTML = "";
                                                                                    document.getElementById("show_saturday").innerHTML = "";
                                                                                    document.getElementById("show_sunday").innerHTML = "";

                                                                                    $('#dataTables-example11').DataTable({

                                                                                        order: [[0, "desc"]],
                                                                                        scrollX: true,
                                                                                        scrollY: '500px',
                                                                                    });


                                                                                }
                                                                            });


                                                                        }
                                                                        function show_tuesday()
                                                                        {

                                                                            $.ajax({
                                                                                type: 'post',
                                                                                url: 'meg_data.php',
                                                                                data: {
                                                                                    txt_flg: "show_tuesday", companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', vehicletransportplanid: '<?= $_GET['vehicletransportplanid'] ?>', STARTWEEK: document.getElementById("txt_datestartsr").value, ENDWEEK: document.getElementById("txt_dateendsr").value, condish: "<?= $condish ?>", statusnumber: document.getElementById("cb_statussr").value, worktype: '<?= $_GET['worktype'] ?>', carrytype: '<?= $_GET['carrytype'] ?>'
                                                                                    , url: '<?= $_SERVER['REQUEST_URI'] ?>'
                                                                                },
                                                                                success: function (rs) {

                                                                                    document.getElementById("show_monday").innerHTML = "";
                                                                                    document.getElementById("show_mondaydef").innerHTML = "";
                                                                                    document.getElementById("show_tuesday").innerHTML = rs;
                                                                                    document.getElementById("show_wednesday").innerHTML = "";
                                                                                    document.getElementById("show_thursday").innerHTML = "";
                                                                                    document.getElementById("show_friday").innerHTML = "";
                                                                                    document.getElementById("show_saturday").innerHTML = "";
                                                                                    document.getElementById("show_sunday").innerHTML = "";
                                                                                    $('#dataTables-example22').DataTable({

                                                                                        order: [[0, "desc"]],
                                                                                        scrollX: true,
                                                                                        scrollY: '500px',
                                                                                    });





                                                                                }
                                                                            });
                                                                        }
                                                                        function show_wednesday()
                                                                        {
                                                                            $.ajax({
                                                                                type: 'post',
                                                                                url: 'meg_data.php',
                                                                                data: {
                                                                                    txt_flg: "show_wednesday", companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', vehicletransportplanid: '<?= $_GET['vehicletransportplanid'] ?>', STARTWEEK: document.getElementById("txt_datestartsr").value, ENDWEEK: document.getElementById("txt_dateendsr").value, condish: "<?= $condish ?>", statusnumber: document.getElementById("cb_statussr").value, worktype: '<?= $_GET['worktype'] ?>', carrytype: '<?= $_GET['carrytype'] ?>'
                                                                                    , url: '<?= $_SERVER['REQUEST_URI'] ?>'
                                                                                },
                                                                                success: function (rs) {

                                                                                    document.getElementById("show_monday").innerHTML = "";
                                                                                    document.getElementById("show_mondaydef").innerHTML = "";
                                                                                    document.getElementById("show_tuesday").innerHTML = "";
                                                                                    document.getElementById("show_wednesday").innerHTML = rs;
                                                                                    document.getElementById("show_thursday").innerHTML = "";
                                                                                    document.getElementById("show_friday").innerHTML = "";
                                                                                    document.getElementById("show_saturday").innerHTML = "";
                                                                                    document.getElementById("show_sunday").innerHTML = "";
                                                                                    $('#dataTables-example33').DataTable({

                                                                                        order: [[0, "desc"]],
                                                                                        scrollX: true,
                                                                                        scrollY: '500px',
                                                                                    });




                                                                                }
                                                                            });
                                                                        }
                                                                        function show_thursday()
                                                                        {
                                                                            $.ajax({
                                                                                type: 'post',
                                                                                url: 'meg_data.php',
                                                                                data: {
                                                                                    txt_flg: "show_thursday", companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', vehicletransportplanid: '<?= $_GET['vehicletransportplanid'] ?>', STARTWEEK: document.getElementById("txt_datestartsr").value, ENDWEEK: document.getElementById("txt_dateendsr").value, condish: "<?= $condish ?>", statusnumber: document.getElementById("cb_statussr").value, worktype: '<?= $_GET['worktype'] ?>', carrytype: '<?= $_GET['carrytype'] ?>'
                                                                                    , url: '<?= $_SERVER['REQUEST_URI'] ?>'
                                                                                },
                                                                                success: function (rs) {

                                                                                    document.getElementById("show_monday").innerHTML = "";
                                                                                    document.getElementById("show_mondaydef").innerHTML = "";
                                                                                    document.getElementById("show_tuesday").innerHTML = "";
                                                                                    document.getElementById("show_wednesday").innerHTML = "";
                                                                                    document.getElementById("show_thursday").innerHTML = rs;
                                                                                    document.getElementById("show_friday").innerHTML = "";
                                                                                    document.getElementById("show_saturday").innerHTML = "";
                                                                                    document.getElementById("show_sunday").innerHTML = "";
                                                                                    $('#dataTables-example44').DataTable({

                                                                                        order: [[0, "desc"]],
                                                                                        scrollX: true,
                                                                                        scrollY: '500px',
                                                                                    });



                                                                                }
                                                                            });
                                                                        }
                                                                        function show_friday()
                                                                        {
                                                                            $.ajax({
                                                                                type: 'post',
                                                                                url: 'meg_data.php',
                                                                                data: {
                                                                                    txt_flg: "show_friday", companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', vehicletransportplanid: '<?= $_GET['vehicletransportplanid'] ?>', STARTWEEK: document.getElementById("txt_datestartsr").value, ENDWEEK: document.getElementById("txt_dateendsr").value, condish: "<?= $condish ?>", statusnumber: document.getElementById("cb_statussr").value, worktype: '<?= $_GET['worktype'] ?>', carrytype: '<?= $_GET['carrytype'] ?>'
                                                                                    , url: '<?= $_SERVER['REQUEST_URI'] ?>'
                                                                                },
                                                                                success: function (rs) {

                                                                                    document.getElementById("show_monday").innerHTML = "";
                                                                                    document.getElementById("show_mondaydef").innerHTML = "";
                                                                                    document.getElementById("show_tuesday").innerHTML = "";
                                                                                    document.getElementById("show_wednesday").innerHTML = "";
                                                                                    document.getElementById("show_thursday").innerHTML = "";
                                                                                    document.getElementById("show_friday").innerHTML = rs;
                                                                                    document.getElementById("show_saturday").innerHTML = "";
                                                                                    document.getElementById("show_sunday").innerHTML = "";
                                                                                    $('#dataTables-example55').DataTable({

                                                                                        order: [[0, "desc"]],
                                                                                        scrollX: true,
                                                                                        scrollY: '500px',
                                                                                    });



                                                                                }
                                                                            });
                                                                        }
                                                                        function show_saturday()
                                                                        {
                                                                            $.ajax({
                                                                                type: 'post',
                                                                                url: 'meg_data.php',
                                                                                data: {
                                                                                    txt_flg: "show_saturday", companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', vehicletransportplanid: '<?= $_GET['vehicletransportplanid'] ?>', STARTWEEK: document.getElementById("txt_datestartsr").value, ENDWEEK: document.getElementById("txt_dateendsr").value, condish: "<?= $condish ?>", statusnumber: document.getElementById("cb_statussr").value, worktype: '<?= $_GET['worktype'] ?>', carrytype: '<?= $_GET['carrytype'] ?>'
                                                                                    , url: '<?= $_SERVER['REQUEST_URI'] ?>'
                                                                                },
                                                                                success: function (rs) {

                                                                                    document.getElementById("show_monday").innerHTML = "";
                                                                                    document.getElementById("show_mondaydef").innerHTML = "";
                                                                                    document.getElementById("show_tuesday").innerHTML = "";
                                                                                    document.getElementById("show_wednesday").innerHTML = "";
                                                                                    document.getElementById("show_thursday").innerHTML = "";
                                                                                    document.getElementById("show_friday").innerHTML = "";
                                                                                    document.getElementById("show_saturday").innerHTML = rs;
                                                                                    document.getElementById("show_sunday").innerHTML = "";
                                                                                    $('#dataTables-example66').DataTable({

                                                                                        order: [[0, "desc"]],
                                                                                        scrollX: true,
                                                                                        scrollY: '500px',
                                                                                    });

                                                                                }
                                                                            });
                                                                        }
                                                                        function show_sunday()
                                                                        {
                                                                            $.ajax({
                                                                                type: 'post',
                                                                                url: 'meg_data.php',
                                                                                data: {
                                                                                    txt_flg: "show_sunday", companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', vehicletransportplanid: '<?= $_GET['vehicletransportplanid'] ?>', STARTWEEK: document.getElementById("txt_datestartsr").value, ENDWEEK: document.getElementById("txt_dateendsr").value, condish: "<?= $condish ?>", statusnumber: document.getElementById("cb_statussr").value, worktype: '<?= $_GET['worktype'] ?>', carrytype: '<?= $_GET['carrytype'] ?>'
                                                                                    , url: '<?= $_SERVER['REQUEST_URI'] ?>'
                                                                                },
                                                                                success: function (rs) {

                                                                                    document.getElementById("show_monday").innerHTML = "";
                                                                                    document.getElementById("show_mondaydef").innerHTML = "";
                                                                                    document.getElementById("show_tuesday").innerHTML = "";
                                                                                    document.getElementById("show_wednesday").innerHTML = "";
                                                                                    document.getElementById("show_thursday").innerHTML = "";
                                                                                    document.getElementById("show_friday").innerHTML = "";
                                                                                    document.getElementById("show_saturday").innerHTML = "";
                                                                                    document.getElementById("show_sunday").innerHTML = rs;
                                                                                    $('#dataTables-example77').DataTable({

                                                                                        order: [[0, "desc"]],
                                                                                        scrollX: true,
                                                                                        scrollY: '500px',
                                                                                    });
                                                                                }
                                                                            });
                                                                        }



                                                                        $('.modal-child').on('show.bs.modal', function () {
                                                                            var modalParent = $(this).attr('data-modal-parent');
                                                                            $(modalParent).css('opacity', 0);
                                                                        });

                                                                        $('.modal-child').on('hidden.bs.modal', function () {
                                                                            var modalParent = $(this).attr('data-modal-parent');
                                                                            $(modalParent).css('opacity', 1);
                                                                        });

                                                                        function select_employee(emp, data)
                                                                        {
                                                                            if (emp == '1')
                                                                            {
                                                                                document.getElementById('txt_copydiagramemployeename1').value = data;
                                                                            } else if (emp == '2')
                                                                            {
                                                                                document.getElementById('txt_copydiagramemployeename2').value = data;
                                                                            } else if (emp == '3')
                                                                            {

                                                                                document.getElementById('txt_copydiagramemployeename3').value = data;

                                                                            }
                                                                        }

                                                                        function select_checkdriversr(emp)
                                                                        {
                                                                            var jobstart = "";
                                                                            var jobend = "";

                                                                            if ('<?= $_GET['worktype'] ?>' != 'sh')
                                                                            {
                                                                                jobstart = document.getElementById('txt_copydiagramjobstart').value;
                                                                                jobend = document.getElementById('txt_copydiagramjobend').value;


                                                                            } else if ('<?= $_GET['worktype'] ?>' == 'sh')
                                                                            {
                                                                                jobstart = document.getElementById('cb_copydiagramjobstart').value;
                                                                                jobend = document.getElementById('txt_copydiagramroute').value;
                                                                            }

                                                                            $.ajax({
                                                                                type: 'post',
                                                                                url: 'meg_data.php',
                                                                                data: {
                                                                                    txt_flg: "select_checkdriversr", jobstart: jobstart, jobend: jobend, emp: emp
                                                                                },
                                                                                success: function (rs) {

                                                                                    document.getElementById("modal_checkdriversr").innerHTML = rs;
                                                                                    $('#dataTables-checkdriver').DataTable({
                                                                                        responsive: true,
                                                                                        order: [[0, "desc"]]
                                                                                    });
                                                                                }
                                                                            });
                                                                        }


                                                                        function experience()
                                                                        {

                                                                            if ('<?= $_GET['worktype'] ?>' == 'sh') {

                                                                                var employeename1 = document.getElementById('txt_copydiagramemployeename1').value;
                                                                                var employeename2 = document.getElementById('txt_copydiagramemployeename2').value;
                                                                                var jobstart = document.getElementById('txt_copydiagramjobstart').value;
                                                                                var jobend = document.getElementById('txt_copydiagramjobend').value;


                                                                                $.ajax({
                                                                                    type: 'post',
                                                                                    url: 'meg_data.php',
                                                                                    data: {
                                                                                        txt_flg: "rs_experience", employeename: employeename1, jobstart: jobstart, jobend: jobend
                                                                                    },
                                                                                    success: function (rs) {

                                                                                        document.getElementById("div_jobendemp1").innerHTML = rs;

                                                                                    }
                                                                                });
                                                                                $.ajax({
                                                                                    type: 'post',
                                                                                    url: 'meg_data.php',
                                                                                    data: {
                                                                                        txt_flg: "rs_experience", employeename: employeename2, jobstart: jobstart, jobend: jobend
                                                                                    },
                                                                                    success: function (rs) {

                                                                                        document.getElementById("div_jobendemp2").innerHTML = rs;

                                                                                    }
                                                                                });
                                                                            } else if ('<?= $_GET['worktype'] ?>' == 'sh') {

                                                                                var employeename1 = document.getElementById('txt_copydiagramemployeename1').value;
                                                                                var employeename2 = document.getElementById('txt_copydiagramemployeename2').value;
                                                                                var jobstart = document.getElementById('txt_copydiagramjobstart').value;
                                                                                var jobend = document.getElementById('txt_copydiagramroute').value;


                                                                                $.ajax({
                                                                                    type: 'post',
                                                                                    url: 'meg_data.php',
                                                                                    data: {
                                                                                        txt_flg: "rs_experience", employeename: employeename1, jobstart: jobstart, jobend: jobend
                                                                                    },
                                                                                    success: function (rs) {

                                                                                        document.getElementById("div_jobendemp1").innerHTML = rs;

                                                                                    }
                                                                                });
                                                                                $.ajax({
                                                                                    type: 'post',
                                                                                    url: 'meg_data.php',
                                                                                    data: {
                                                                                        txt_flg: "rs_experience", employeename: employeename2, jobstart: jobstart, jobend: jobend
                                                                                    },
                                                                                    success: function (rs) {

                                                                                        document.getElementById("div_jobendemp2").innerHTML = rs;

                                                                                    }
                                                                                });
                                                                            }


                                                                        }


                                                                        function update_modalrcc(vehicletransportplanid)
                                                                        {
                                                                            $.ajax({
                                                                                type: 'post',
                                                                                url: 'meg_data.php',
                                                                                data: {
                                                                                    txt_flg: "modal_updatediagramrcc", vehicletransportplanid: vehicletransportplanid, companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>'
                                                                                },
                                                                                success: function (rs) {

                                                                                    document.getElementById("modalbodyupdatediagramrccsr").innerHTML = rs;

                                                                                    var txt_copydiagramemployeenameupdrcc1 = [<?= $emp ?>];
                                                                                    $("#txt_copydiagramemployeenameupdrcc1").autocomplete({
                                                                                        source: [txt_copydiagramemployeenameupdrcc1]
                                                                                    });

                                                                                    var txt_copydiagramemployeenameupdrcc2 = [<?= $emp ?>];
                                                                                    $("#txt_copydiagramemployeenameupdrcc2").autocomplete({
                                                                                        source: [txt_copydiagramemployeenameupdrcc2]
                                                                                    });

                                                                                    var txt_copydiagramthainameupdrcc = [<?= $thainame ?>];
                                                                                    $("#txt_copydiagramthainameupdrcc").autocomplete({
                                                                                        source: [txt_copydiagramthainameupdrcc]
                                                                                    });
                                                                                    var txt_copydiagramthainameupdrcc2 = [<?= $thainame ?>];
                                                                                    $("#txt_copydiagramthainameupdrcc2").autocomplete({
                                                                                        source: [txt_copydiagramthainameupdrcc2]
                                                                                    });


                                                                                    $(function () {

                                                                                        $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                                        // กรณีใช้แบบ input
                                                                                        $(".datedef").datetimepicker({
                                                                                            timepicker: false,
                                                                                            format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                                                                            lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.

                                                                                        });
                                                                                    });

                                                                                    $(function () {
                                                                                        $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                                        // กรณีใช้แบบ input
                                                                                        $(".datetimeen").datetimepicker({
                                                                                            timepicker: true,
                                                                                            dateformat: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00 - 00 - 0000
                                                                                            lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                                            timeFormat: "HH:mm"

                                                                                        }
                                                                                        );
                                                                                    });
                                                                                    $(function () {
                                                                                        $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ. // กรณีใช้แบบ input
                                                                                        $(".timeen").datetimepicker({
                                                                                            datepicker: false,
                                                                                            format: 'H:i',
                                                                                            //mask: '29:59',
                                                                                            lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                                        });
                                                                                    });








                                                                                }
                                                                            });

                                                                        }


                                                                        function se_copydiagramroute(copydiagramjobstart)
                                                                        {

                                                                            var companycodesh = document.getElementById('txt_companycode_sh').value;
                                                                            var customercodesh = document.getElementById('txt_customercode_sh').value;
                                                                            var worktypesh = document.getElementById('txt_worktype_sh').value;



                                                                            $.ajax({
                                                                                type: 'post',
                                                                                url: 'meg_data.php',
                                                                                data: {
                                                                                    txt_flg: "show_copydiagramjobstart", copydiagramjobstart: copydiagramjobstart, companycode: companycodesh, customercode: customercodesh, worktype: worktypesh
                                                                                },
                                                                                success: function (rs) {

                                                                                    document.getElementById("copydiagramroutesr").innerHTML = rs;
                                                                                    document.getElementById("copydiagramroutedef").innerHTML = "";

                                                                                    $("#cb_copydiagramroute").html(rs).selectpicker('refresh');
                                                                                    $('.selectpicker').on('changed.bs.select', function () {
                                                                                        document.getElementById('txt_copydiagramroute').value = $(this).val();
                                                                                        se_copydiagramsubroute(document.getElementById('txt_copydiagramroute').value, document.getElementById('txt_companycode_sh').value, document.getElementById('txt_customercode_sh').value, document.getElementById('txt_worktype_sh').value);
                                                                                    });



                                                                                }
                                                                            });

                                                                        }
                                                                        function se_copydiagramrouteshnormal(copydiagramjobstartshn)
                                                                        {

                                                                            var companycodesh = document.getElementById('txt_companycode_shn').value;
                                                                            var customercodesh = document.getElementById('txt_customercode_shn').value;
                                                                            var worktypesh = document.getElementById('txt_worktype_shn').value;

                                                                            // alert(copydiagramjobstartshn);
                                                                            // alert(companycodesh);
                                                                            // alert(customercodesh);
                                                                            // alert(worktypesh);

                                                                            $.ajax({
                                                                                type: 'post',
                                                                                url: 'meg_data.php',
                                                                                data: {
                                                                                    txt_flg: "show_copydiagramjobstartshn", copydiagramjobstartshn: copydiagramjobstartshn, companycode: companycodesh, customercode: customercodesh, worktype: worktypesh
                                                                                },
                                                                                success: function (rs) {

                                                                                    document.getElementById("copydiagramroutesrshn").innerHTML = rs;
                                                                                    document.getElementById("copydiagramroutedefshn").innerHTML = "";

                                                                                    $("#cb_copydiagramrouteshn").html(rs).selectpicker('refresh');
                                                                                    $('.selectpicker').on('changed.bs.select', function () {
                                                                                        document.getElementById('txt_copydiagramrouteshn').value = $(this).val();
                                                                                        se_copydiagramsubrouteshnormal(document.getElementById('txt_copydiagramrouteshn').value, document.getElementById('txt_companycode_shn').value, document.getElementById('txt_customercode_shn').value, document.getElementById('txt_worktype_shn').value);
                                                                                    });



                                                                                }
                                                                            });

                                                                        }
                                                                        function se_copydiagramroute32(copydiagramjobstart32)
                                                                        {

                                                                            var companycodesh = document.getElementById('txt_companycode32_sh').value;
                                                                            var customercodesh = document.getElementById('txt_customercode32_sh').value;
                                                                            var worktypesh = document.getElementById('txt_worktype32_sh').value;


                                                                            $.ajax({
                                                                                type: 'post',
                                                                                url: 'meg_data.php',
                                                                                data: {
                                                                                    txt_flg: "show_copydiagramjobstart32", copydiagramjobstart32: copydiagramjobstart32, companycode: companycodesh, customercode: customercodesh, worktype: worktypesh
                                                                                },
                                                                                success: function (rs) {

                                                                                    document.getElementById("copydiagramroutesr32").innerHTML = rs;
                                                                                    document.getElementById("copydiagramroutedef32").innerHTML = "";

                                                                                    $("#cb_copydiagramroute32").html(rs).selectpicker('refresh');
                                                                                    $('.selectpicker').on('changed.bs.select', function () {
                                                                                        document.getElementById('txt_copydiagramroute32').value = $(this).val();
                                                                                        se_copydiagramsubroute32(document.getElementById('txt_copydiagramroute32').value, document.getElementById('txt_companycode32_sh').value, document.getElementById('txt_customercode32_sh').value, document.getElementById('txt_worktype32_sh').value);
                                                                                    });



                                                                                }
                                                                            });

                                                                        }
                                                                        function se_copydiagramroute22_sh(copydiagramjobstart22_sh)
                                                                        {

                                                                            var companycodeshsh = document.getElementById('txt_companycode22_sh').value;
                                                                            var customercodeshsh = document.getElementById('txt_customercode22_sh').value;
                                                                            var worktypeshsh = document.getElementById('txt_worktype22_sh').value;

                                                                            // alert(copydiagramjobstart22_sh);
                                                                            // alert(companycodeshsh);
                                                                            // alert(customercodeshsh);
                                                                            // alert(worktypeshsh);

                                                                            $.ajax({
                                                                                type: 'post',
                                                                                url: 'meg_data.php',
                                                                                data: {
                                                                                    txt_flg: "show_copydiagramjobstart22_sh", copydiagramjobstart22_sh: copydiagramjobstart22_sh, companycode: companycodeshsh, customercode: customercodeshsh, worktype: worktypeshsh
                                                                                },
                                                                                success: function (rs) {

                                                                                    document.getElementById("copydiagramroutesr22_sh").innerHTML = rs;
                                                                                    document.getElementById("copydiagramroutedef22_sh").innerHTML = "";

                                                                                    //$("#cb_copydiagramroute22_sh").html(rs).selectpicker('refresh');
                                                                                    //$('.selectpicker').on('changed.bs.select', function () {
                                                                                    //    document.getElementById('txt_copydiagramroute22_sh').value = $(this).val();
                                                                                    //    se_copydiagramsubroute22_sh(document.getElementById('txt_copydiagramroute22_sh').value, document.getElementById('txt_companycode22_sh').value, document.getElementById('txt_customercode22_sh').value, document.getElementById('txt_worktype22_sh').value);
                                                                                    //});
                                                                                    $('#cb_copydiagramroute22_sh').select2({
                                                                                        placeholder: 'เลือก Route'
                                                                                    });

                                                                                    



                                                                                }
                                                                            });

                                                                        }
                                                                        function se_copydiagramroute21_sh(copydiagramjobstart21_sh)
                                                                        {

                                                                            var companycodeshsh = document.getElementById('txt_companycode21_sh').value;
                                                                            var customercodeshsh = document.getElementById('txt_customercode21_sh').value;
                                                                            var worktypeshsh = document.getElementById('txt_worktype21_sh').value;


                                                                            $.ajax({
                                                                                type: 'post',
                                                                                url: 'meg_data.php',
                                                                                data: {
                                                                                    txt_flg: "show_copydiagramjobstart21_sh", copydiagramjobstart21_sh: copydiagramjobstart21_sh, companycode: companycodeshsh, customercode: customercodeshsh, worktype: worktypeshsh
                                                                                },
                                                                                success: function (rs) {

                                                                                    document.getElementById("copydiagramroutesr21_sh").innerHTML = rs;
                                                                                    document.getElementById("copydiagramroutedef21_sh").innerHTML = "";


                                                                                    $('#cb_copydiagramroute21_sh').select2({
                                                                                        placeholder: 'เลือก Route'
                                                                                        
                                                                                    });
                                                                                    

                                                                                    



                                                                                }
                                                                            });

                                                                        }
                                                                        function se_copydiagramsubroute22_sh(data, companycode, customercode, worktype)
                                                                        {

                                                                            $.ajax({
                                                                                type: 'post',
                                                                                url: 'meg_data.php',
                                                                                data: {
                                                                                    txt_flg: "show_copydiagramsubroute22_sh", copydiagramroute22_sh: data, companycode: companycode, customercode: customercode, worktype: worktype
                                                                                },
                                                                                success: function (rs) {

                                                                                    document.getElementById("copydiagramsubroutesr22_sh").innerHTML = rs;
                                                                                    document.getElementById("copydiagramsubroutedef22_sh").innerHTML = "";

                                                                                    $("#cb_copydiagramsubroute22_sh").html(rs).selectpicker('refresh');
                                                                                    $('.selectpicker').on('changed.bs.select', function () {
                                                                                        document.getElementById('txt_copydiagramsubroute22_sh').value = $(this).val();

                                                                                    });


                                                                                }
                                                                            });
                                                                        }
                                                                        function se_copydiagramsubroute22before_sh()
                                                                        {
                                                                            se_copydiagramsubroute22_sh(document.getElementById('cb_copydiagramroute22_sh').value, document.getElementById('txt_companycode22_sh').value, document.getElementById('txt_customercode22_sh').value, document.getElementById('txt_worktype22_sh').value);
                                                                        }
                                                                        function se_copydiagramsubroute21before_sh()
                                                                        {
                                                                            se_copydiagramsubroute21_sh(document.getElementById('cb_copydiagramroute21_sh').value, document.getElementById('txt_companycode21_sh').value, document.getElementById('txt_customercode21_sh').value, document.getElementById('txt_worktype21_sh').value);
                                                                        }
                                                                        function se_copydiagramsubroute21_sh(data, companycode, customercode, worktype)
                                                                        {

                                                                            $.ajax({
                                                                                type: 'post',
                                                                                url: 'meg_data.php',
                                                                                data: {
                                                                                    txt_flg: "show_copydiagramsubroute21_sh", copydiagramroute21_sh: data, companycode: companycode, customercode: customercode, worktype: worktype
                                                                                },
                                                                                success: function (rs) {

                                                                                    document.getElementById("copydiagramsubroutesr21_sh").innerHTML = rs;
                                                                                    document.getElementById("copydiagramsubroutedef21_sh").innerHTML = "";

                                                                                    $("#cb_copydiagramsubroute21_sh").html(rs).selectpicker('refresh');
                                                                                    $('.selectpicker').on('changed.bs.select', function () {
                                                                                        document.getElementById('txt_copydiagramsubroute21_sh').value = $(this).val();

                                                                                    });


                                                                                }
                                                                            });
                                                                        }
                                                                        function se_copydiagramsubroute32(data, companycode, customercode, worktype)
                                                                        {

                                                                            $.ajax({
                                                                                type: 'post',
                                                                                url: 'meg_data.php',
                                                                                data: {
                                                                                    txt_flg: "show_copydiagramsubroute32", copydiagramroute32: data, companycode: companycode, customercode: customercode, worktype: worktype
                                                                                },
                                                                                success: function (rs) {

                                                                                    document.getElementById("copydiagramsubroutesr32").innerHTML = rs;
                                                                                    document.getElementById("copydiagramsubroutedef32").innerHTML = "";

                                                                                    $("#cb_copydiagramsubroute32").html(rs).selectpicker('refresh');
                                                                                    $('.selectpicker').on('changed.bs.select', function () {
                                                                                        document.getElementById('txt_copydiagramsubroute32').value = $(this).val();

                                                                                    });


                                                                                }
                                                                            });
                                                                        }
                                                                        function se_copydiagramsubroute(data, companycode, customercode, worktype)
                                                                        {
                                                                            // alert(data);
                                                                            // alert(companycode);
                                                                            // alert(customercode);
                                                                            // alert(worktype);

                                                                            $.ajax({
                                                                                type: 'post',
                                                                                url: 'meg_data.php',
                                                                                data: {
                                                                                    txt_flg: "show_copydiagramsubroute", copydiagramroute: data, companycode: companycode, customercode: customercode, worktype: worktype
                                                                                },
                                                                                success: function (rs) {

                                                                                    document.getElementById("copydiagramsubroutesr").innerHTML = rs;
                                                                                    document.getElementById("copydiagramsubroutedef").innerHTML = "";

                                                                                    $("#cb_copydiagramsubroute").html(rs).selectpicker('refresh');
                                                                                    $('.selectpicker').on('changed.bs.select', function () {
                                                                                        document.getElementById('txt_copydiagramsubroute').value = $(this).val();

                                                                                    });


                                                                                }
                                                                            });
                                                                        }
                                                                        function se_copydiagramsubrouteshnormal(data, companycode, customercode, worktype)
                                                                        {
                                                                            // alert(data);
                                                                            // alert(companycode);
                                                                            // alert(customercode);
                                                                            // alert(worktype);

                                                                            $.ajax({
                                                                                type: 'post',
                                                                                url: 'meg_data.php',
                                                                                data: {//////// งานsh(n) ที่เลือกลูกค้าในงาน Normal
                                                                                    txt_flg: "show_copydiagramsubrouteshn", copydiagramroute: data, companycode: companycode, customercode: customercode, worktype: worktype
                                                                                },
                                                                                success: function (rs) {

                                                                                    document.getElementById("copydiagramsubroutesrshn").innerHTML = rs;
                                                                                    document.getElementById("copydiagramsubroutedefshn").innerHTML = "";

                                                                                    $("#cb_copydiagramsubrouteshn").html(rs).selectpicker('refresh');
                                                                                    $('.selectpicker').on('changed.bs.select', function () {
                                                                                        document.getElementById('txt_copydiagramsubrouteshn').value = $(this).val();

                                                                                    });


                                                                                }
                                                                            });
                                                                        }
                                                                        function save_mileage(editableObj, mileagetype, vehicleregisternumber1, jobno)
                                                                        {

                                                                            $.ajax({
                                                                                url: 'meg_data.php',
                                                                                type: 'POST',
                                                                                data: {
                                                                                    txt_flg: "save_mileage", mileageid: '', vehicleregisternumber1: vehicleregisternumber1, jobno: jobno, editableObj: editableObj.innerHTML, mileagetype: mileagetype
                                                                                },
                                                                                success: function () {

                                                                                }
                                                                            });
                                                                        }
                                                                        function edit_pricekm(condition)
                                                                        {

                                                                            $.ajax({
                                                                                url: 'meg_data.php',
                                                                                type: 'POST',
                                                                                data: {
                                                                                    txt_flg: "select_pricekm", condition: condition
                                                                                },
                                                                                success: function (rs) {

                                                                                    document.getElementById("txt_pricekm").value = rs;

                                                                                }
                                                                            });
                                                                        }
                                                                        function save_confrimpriceskb()
                                                                        {
                                                                            var condition = '';
                                                                            var jobstart = document.getElementById("txt_confrimjobstart").value;
                                                                            var cluster = document.getElementById("txt_confrimcluster").value;
                                                                            var jobend = document.getElementById("txt_confrimjobend").value;
                                                                            var km = document.getElementById("txt_confrimkm").value;
                                                                            var compensation = document.getElementById("txt_confrimcomp").value;
                                                                            var pricekm = document.getElementById("txt_pricekm").value;

                                                                            $.ajax({
                                                                                url: 'meg_data.php',
                                                                                type: 'POST',
                                                                                data: {
                                                                                    txt_flg: "save_confrimtempskb", condition: condition, jobstart: jobstart, cluster: cluster, jobend: jobend, km: km, compensation: compensation, pricekm: pricekm
                                                                                },
                                                                                success: function () {
                                                                                    select_confrimpriceskb('');
                                                                                    document.getElementById("txt_confrimjobstart").value = "";
                                                                                    document.getElementById("txt_confrimcluster").value = "";
                                                                                    document.getElementById("txt_confrimjobend").value = "";
                                                                                    document.getElementById("txt_confrimkm").value = "";
                                                                                    document.getElementById("txt_confrimcomp").value = "";
                                                                                    document.getElementById("txt_pricekm").value = "";
                                                                                }
                                                                            });
                                                                        }

        </script>
        <script type="text/javascript">



            $.ajax({
                type: 'post',
                url: 'meg_data.php',
                data: {
                    txt_flg: "select_adddateweek", datestart: document.getElementById("txt_datestartsr").value
                },
                success: function (rs) {

                    var res = rs.split("|");
                    document.getElementById("txt_dateendsr").value = res[0];



                    document.getElementById("lbl_m").innerHTML = '(' + res[1] + ')';
                    document.getElementById("lbl_tu").innerHTML = '(' + res[2] + ')';
                    document.getElementById("lbl_w").innerHTML = '(' + res[3] + ')';
                    document.getElementById("lbl_th").innerHTML = '(' + res[4] + ')';
                    document.getElementById("lbl_f").innerHTML = '(' + res[5] + ')';
                    document.getElementById("lbl_sat").innerHTML = '(' + res[6] + ')';
                    document.getElementById("lbl_sun").innerHTML = '(' + res[7] + ')';






                }
            });


            /*
             
             var txt_jobstartm1 = [<?//= $jobsm1 ?>];
             for (n = 1; n < <?//= $i1 ?>; n++) {
             $("#txt_jobstartm1" + n).autocomplete({
             source: [txt_jobstartm1]
             });
             }
             var txt_jobstartm2 = [<?//= $jobsm2 ?>];
             for (n = 1; n < <?//= $i1 ?>; n++) {
             $("#txt_jobstartm2" + n).autocomplete({
             source: [txt_jobstartm2]
             });
             }
             var txt_jobstartm3 = [<?//= $jobsm3 ?>];
             for (n = 1; n < <?//= $i1 ?>; n++) {
             $("#txt_jobstartm3" + n).autocomplete({
             source: [txt_jobstartm3]
             });
             }
             var txt_jobstartm4 = [<?//= $jobsm4 ?>];
             for (n = 1; n < <?//= $i1 ?>; n++) {
             $("#txt_jobstartm4" + n).autocomplete({
             source: [txt_jobstartm4]
             });
             }
             
             var txt_jobstarttu1 = [<?//= $jobstu1 ?>];
             for (n = 1; n < <?//= $i2 ?>; n++) {
             $("#txt_jobstarttu1" + n).autocomplete({
             source: [txt_jobstarttu1]
             });
             }
             var txt_jobstarttu2 = [<?//= $jobstu2 ?>];
             for (n = 1; n < <?//= $i2 ?>; n++) {
             $("#txt_jobstarttu2" + n).autocomplete({
             source: [txt_jobstarttu2]
             });
             }
             
             var txt_jobstartw1 = [<?//= $jobsw1 ?>];
             for (n = 1; n < <?//= $i3 ?>; n++) {
             $("#txt_jobstartw1" + n).autocomplete({
             source: [txt_jobstartw1]
             });
             }
             var txt_jobstartw2 = [<?//= $jobsw2 ?>];
             for (n = 1; n < <?//= $i3 ?>; n++) {
             $("#txt_jobstartw2" + n).autocomplete({
             source: [txt_jobstartw2]
             });
             }
             
             var txt_jobstartth1 = [<?//= $jobsth1 ?>];
             for (n = 1; n < <?//= $i4 ?>; n++) {
             $("#txt_jobstartth1" + n).autocomplete({
             source: [txt_jobstartth1]
             });
             }
             var txt_jobstartth2 = [<?//= $jobsth2 ?>];
             for (n = 1; n < <?//= $i4 ?>; n++) {
             $("#txt_jobstartth2" + n).autocomplete({
             source: [txt_jobstartth2]
             });
             }
             
             var txt_jobstartf1 = [<?//= $jobsf1 ?>];
             for (n = 1; n < <?//= $i5 ?>; n++) {
             $("#txt_jobstartf1" + n).autocomplete({
             source: [txt_jobstartf1]
             });
             }
             var txt_jobstartf2 = [<?//= $jobsf2 ?>];
             for (n = 1; n < <?//= $i5 ?>; n++) {
             $("#txt_jobstartf2" + n).autocomplete({
             source: [txt_jobstartf2]
             });
             }
             
             var txt_jobstartsat1 = [<?//= $jobssat1 ?>];
             for (n = 1; n < <?//= $i6 ?>; n++) {
             $("#txt_jobstartsat1" + n).autocomplete({
             source: [txt_jobstartsat1]
             });
             }
             var txt_jobstartsat2 = [<?//= $jobssat2 ?>];
             for (n = 1; n < <?//= $i6 ?>; n++) {
             $("#txt_jobstartsat2" + n).autocomplete({
             source: [txt_jobstartsat2]
             });
             }
             
             var txt_jobstartsun1 = [<?//= $jobssun1 ?>];
             for (n = 1; n < <?//= $i7 ?>; n++) {
             $("#txt_jobstartsun1" + n).autocomplete({
             source: [txt_jobstartsun1]
             });
             }
             var txt_jobstartsun2 = [<?//= $jobssun2 ?>];
             for (n = 1; n < <?//= $i7 ?>; n++) {
             $("#txt_jobstartsun2" + n).autocomplete({
             source: [txt_jobstartsun2]
             });
             }
             
             var txt_clusterm = [<?//= $cluster ?>];
             for (n = 1; n < <?//= $i1 ?>; n++) {
             $("#txt_clusterm" + n).autocomplete({
             source: [txt_clusterm]
             });
             }
             
             var txt_clustertu = [<?//= $cluster ?>];
             for (n = 1; n < <?//= $i2 ?>; n++) {
             $("#txt_clustertu" + n).autocomplete({
             source: [txt_clustertu]
             });
             }
             
             var txt_clusterw = [<?//= $cluster ?>];
             for (n = 1; n < <?//= $i3 ?>; n++) {
             $("#txt_clusterw" + n).autocomplete({
             source: [txt_clusterw]
             });
             }
             
             var txt_clusterth = [<?//= $cluster ?>];
             for (n = 1; n < <?//= $i4 ?>; n++) {
             $("#txt_clusterth" + n).autocomplete({
             source: [txt_clusterth]
             });
             }
             
             var txt_clusterf = [<?//= $cluster ?>];
             for (n = 1; n < <?//= $i5 ?>; n++) {
             $("#txt_clusterf" + n).autocomplete({
             source: [txt_clusterf]
             });
             }
             
             var txt_clustersat = [<?//= $cluster ?>];
             for (n = 1; n < <?//= $i6 ?>; n++) {
             $("#txt_clustersat" + n).autocomplete({
             source: [txt_clustersat]
             });
             }
             
             var txt_clustersun = [<?//= $cluster ?>];
             for (n = 1; n < <?//= $i7 ?>; n++) {
             $("#txt_clustersun" + n).autocomplete({
             source: [txt_clustersun]
             });
             }
             
             
             
             var txt_jobendm = [<?//= $jobrccend ?>];
             for (n = 1; n < <?//= $i1 ?>; n++) {
             $("#txt_jobendm" + n).autocomplete({
             source: [txt_jobendm]
             });
             }
             var txt_jobendm1 = [<?//= $jobendrks_denso ?>];
             for (n = 1; n < <?//= $i1 ?>; n++) {
             $("#txt_jobendm1" + n).autocomplete({
             source: [txt_jobendm1]
             });
             }
             var txt_jobendtu = [<?//= $jobrccend ?>];
             for (n = 1; n < <?//= $i2 ?>; n++) {
             $("#txt_jobendtu" + n).autocomplete({
             source: [txt_jobendtu]
             });
             }
             
             var txt_jobendw = [<?//= $jobrccend ?>];
             for (n = 1; n < <?//= $i3 ?>; n++) {
             $("#txt_jobendw" + n).autocomplete({
             source: [txt_jobendw]
             });
             }
             
             var txt_jobendth = [<?//= $jobrccend ?>];
             for (n = 1; n < <?//= $i4 ?>; n++) {
             $("#txt_jobendth" + n).autocomplete({
             source: [txt_jobendth]
             });
             }
             
             var txt_jobendf = [<?//= $jobrccend ?>];
             for (n = 1; n < <?//= $i5 ?>; n++) {
             
             $("#txt_jobendf" + n).autocomplete({
             source: [txt_jobendf]
             });
             }
             
             var txt_jobendsat = [<?//= $jobrccend ?>];
             for (n = 1; n < <?//= $i6 ?>; n++) {
             $("#txt_jobendsat" + n).autocomplete({
             source: [txt_jobendsat]
             });
             }
             
             var txt_jobendsun = [<?//= $jobrccend ?>];
             for (n = 1; n < <?//= $i7 ?>; n++) {
             $("#txt_jobendsun" + n).autocomplete({
             source: [txt_jobendsun]
             });
             }
             
             var txt_employeem1 = [<?//= $emp ?>];
             for (n = 1; n < <?//= $i1 ?>; n++) {
             $("#txt_employeem1" + n).autocomplete({
             source: [txt_employeem1]
             });
             }
             
             var txt_employeetu1 = [<?//= $emp ?>];
             for (n = 1; n < <?//= $i2 ?>; n++) {
             $("#txt_employeetu1" + n).autocomplete({
             source: [txt_employeetu1]
             });
             }
             
             var txt_employeew1 = [<?//= $emp ?>];
             for (n = 1; n < <?//= $i3 ?>; n++) {
             $("#txt_employeew1" + n).autocomplete({
             source: [txt_employeew1]
             });
             }
             
             var txt_employeeth1 = [<?//= $emp ?>];
             for (n = 1; n < <?//= $i4 ?>; n++) {
             $("#txt_employeeth1" + n).autocomplete({
             source: [txt_employeeth1]
             });
             }
             
             var txt_employeef1 = [<?//= $emp ?>];
             for (n = 1; n < <?//= $i5 ?>; n++) {
             $("#txt_employeef1" + n).autocomplete({
             source: [txt_employeef1]
             });
             }
             
             var txt_employeesat1 = [<?//= $emp ?>];
             for (n = 1; n < <?//= $i6 ?>; n++) {
             $("#txt_employeesat1" + n).autocomplete({
             source: [txt_employeesat1]
             });
             }
             
             var txt_employeesun1 = [<?//= $emp ?>];
             for (n = 1; n < <?//= $i7 ?>; n++) {
             $("#txt_employeesun1" + n).autocomplete({
             source: [txt_employeesun1]
             });
             }
             
             var txt_employeem2 = [<?//= $emp ?>];
             for (n = 1; n < <?//= $i1 ?>; n++) {
             $("#txt_employeem2" + n).autocomplete({
             source: [txt_employeem2]
             });
             }
             
             var txt_employeetu2 = [<?//= $emp ?>];
             for (n = 1; n < <?//= $i2 ?>; n++) {
             $("#txt_employeetu2" + n).autocomplete({
             source: [txt_employeetu2]
             });
             }
             
             var txt_employeew2 = [<?//= $emp ?>];
             for (n = 1; n < <?//= $i3 ?>; n++) {
             $("#txt_employeew2" + n).autocomplete({
             source: [txt_employeew2]
             });
             }
             
             var txt_employeeth2 = [<?//= $emp ?>];
             for (n = 1; n < <?//= $i4 ?>; n++) {
             $("#txt_employeeth2" + n).autocomplete({
             source: [txt_employeeth2]
             });
             }
             
             var txt_employeef2 = [<?//= $emp ?>];
             for (n = 1; n < <?//= $i5 ?>; n++) {
             $("#txt_employeef2" + n).autocomplete({
             source: [txt_employeef2]
             });
             }
             
             var txt_employeesat2 = [<?//= $emp ?>];
             for (n = 1; n < <?//= $i6 ?>; n++) {
             $("#txt_employeesat2" + n).autocomplete({
             source: [txt_employeesat2]
             });
             }
             
             var txt_employeesun2 = [<?//= $emp ?>];
             for (n = 1; n < <?//= $i7 ?>; n++) {
             $("#txt_employeesun2" + n).autocomplete({
             source: [txt_employeesun2]
             });
             }
             
             var txt_carm = [<?//= $thainame ?>];
             for (n = 1; n < <?//= $i1 ?>; n++) {
             $("#txt_carm" + n).autocomplete({
             source: [txt_carm]
             });
             }
             
             var txt_cartu = [<?//= $thainame ?>];
             for (n = 1; n < <?//= $i2 ?>; n++) {
             $("#txt_cartu" + n).autocomplete({
             source: [txt_cartu]
             });
             }
             
             var txt_carw = [<?//= $thainame ?>];
             for (n = 1; n < <?//= $i3 ?>; n++) {
             $("#txt_carw" + n).autocomplete({
             source: [txt_carw]
             });
             }
             
             var txt_carth = [<?//= $thainame ?>];
             for (n = 1; n < <?//= $i4 ?>; n++) {
             
             $("#txt_carth" + n).autocomplete({
             source: [txt_carth]
             });
             }
             
             var txt_carf = [<?//= $thainame ?>];
             for (n = 1; n < <?//= $i5 ?>; n++) {
             $("#txt_carf" + n).autocomplete({
             source: [txt_carf]
             });
             }
             
             var txt_carsat = [<?//= $thainame ?>];
             for (n = 1; n < <?//= $i6 ?>; n++) {
             $("#txt_carsat" + n).autocomplete({
             source: [txt_carsat]
             });
             }
             
             var txt_carsun = [<?//= $thainame ?>];
             for (n = 1; n < <?//= $i7 ?>; n++) {
             $("#txt_carsun" + n).autocomplete({
             source: [txt_carsun]
             });
             }
             */

            var txt_copydiagramemployeename1 = [<?= $emp ?>];
            $("#txt_copydiagramemployeename1").autocomplete({
                source: [txt_copydiagramemployeename1]
            });





            var txt_copydiagramemployeenameupd1 = [<?= $emp ?>];
            $("#txt_copydiagramemployeenameupd1").autocomplete({
                source: [txt_copydiagramemployeenameupd1]
            });


            var txt_copydiagramemployeename2 = [<?= $emp ?>];
            $("#txt_copydiagramemployeename2").autocomplete({
                source: [txt_copydiagramemployeename2]
            });

            var txt_copydiagramemployeename3 = [<?= $emp ?>];
            $("#txt_copydiagramemployeename3").autocomplete({
                source: [txt_copydiagramemployeename3]
            });


            var txt_copydiagramemployeenameupd2 = [<?= $emp ?>];
            $("#txt_copydiagramemployeenameupd2").autocomplete({
                source: [txt_copydiagramemployeenameupd2]
            });

            var txt_copydiagramthainame = [<?= $thainame ?>];
            $("#txt_copydiagramthainame").autocomplete({
                source: [txt_copydiagramthainame]
            });

            var txt_copydiagramthainame2 = [<?= $thainame ?>];
            $("#txt_copydiagramthainame2").autocomplete({
                source: [txt_copydiagramthainame2]
            });

            var txt_copydiagramthainameupd = [<?= $thainame ?>];
            $("#txt_copydiagramthainameupd").autocomplete({
                source: [txt_copydiagramthainameupd]
            });


            var txt_copydiagramjobstart = [<?= $job ?>];
            $("#txt_copydiagramjobstart").autocomplete({
                source: [txt_copydiagramjobstart]
            });

            var txt_copydiagramjobend = [<?= $jobrccend ?>];
            $("#txt_copydiagramjobend").autocomplete({
                source: [txt_copydiagramjobend]
            });

            /////////////////////////////////////////////////
            var txt_copydiagramemployeename21_1 = [<?= $emp ?>];
            $("#txt_copydiagramemployeename21_1").autocomplete({
                source: [txt_copydiagramemployeename21_1]
            });

            var txt_copydiagramemployeename21_2 = [<?= $emp ?>];
            $("#txt_copydiagramemployeename21_2").autocomplete({
                source: [txt_copydiagramemployeename21_2]
            });

            var txt_copydiagramemployeename21_3 = [<?= $emp ?>];
            $("#txt_copydiagramemployeename21_3").autocomplete({
                source: [txt_copydiagramemployeename21_3]
            });

            var txt_copydiagramemployeename22_1 = [<?= $emp ?>];
            $("#txt_copydiagramemployeename22_1").autocomplete({
                source: [txt_copydiagramemployeename22_1]
            });

            var txt_copydiagramemployeename22_2 = [<?= $emp ?>];
            $("#txt_copydiagramemployeename22_2").autocomplete({
                source: [txt_copydiagramemployeename22_2]
            });

            var txt_copydiagramemployeename22_3 = [<?= $emp ?>];
            $("#txt_copydiagramemployeename22_3").autocomplete({
                source: [txt_copydiagramemployeename22_3]
            });

            var txt_copydiagramemployeename31_1 = [<?= $emp ?>];
            $("#txt_copydiagramemployeename31_1").autocomplete({
                source: [txt_copydiagramemployeename31_1]
            });

            var txt_copydiagramemployeename31_2 = [<?= $emp ?>];
            $("#txt_copydiagramemployeename31_2").autocomplete({
                source: [txt_copydiagramemployeename31_2]
            });
            var txt_copydiagramemployeename31_3 = [<?= $emp ?>];
            $("#txt_copydiagramemployeename31_3").autocomplete({
                source: [txt_copydiagramemployeename31_3]
            });

            var txt_copydiagramemployeename32_1 = [<?= $emp ?>];
            $("#txt_copydiagramemployeename32_1").autocomplete({
                source: [txt_copydiagramemployeename32_1]
            });

            var txt_copydiagramemployeename32_2 = [<?= $emp ?>];
            $("#txt_copydiagramemployeename32_2").autocomplete({
                source: [txt_copydiagramemployeename32_2]
            });
            var txt_copydiagramemployeename32_3 = [<?= $emp ?>];
            $("#txt_copydiagramemployeename32_3").autocomplete({
                source: [txt_copydiagramemployeename32_3]
            });

            //////////////////////////////////////////////
            var txt_copydiagramthainame21_1 = [<?= $thainame ?>];
            $("#txt_copydiagramthainame21_1").autocomplete({
                source: [txt_copydiagramthainame21_1]
            });

            var txt_copydiagramthainame21_2 = [<?= $thainame ?>];
            $("#txt_copydiagramthainame21_2").autocomplete({
                source: [txt_copydiagramthainame21_2]
            });

            var txt_copydiagramthainame22_1 = [<?= $thainame ?>];
            $("#txt_copydiagramthainame22_1").autocomplete({
                source: [txt_copydiagramthainame22_1]
            });

            var txt_copydiagramthainame22_2 = [<?= $thainame ?>];
            $("#txt_copydiagramthainame22_2").autocomplete({
                source: [txt_copydiagramthainame22_2]
            });

            var txt_copydiagramthainame31_1 = [<?= $thainame ?>];
            $("#txt_copydiagramthainame31_1").autocomplete({
                source: [txt_copydiagramthainame31_1]
            });

            var txt_copydiagramthainame31_2 = [<?= $thainame ?>];
            $("#txt_copydiagramthainame31_2").autocomplete({
                source: [txt_copydiagramthainame31_2]
            });

            var txt_copydiagramthainame32_1 = [<?= $thainame ?>];
            $("#txt_copydiagramthainame32_1").autocomplete({
                source: [txt_copydiagramthainame32_1]
            });

            var txt_copydiagramthainame32_2 = [<?= $thainame ?>];
            $("#txt_copydiagramthainame32_2").autocomplete({
                source: [txt_copydiagramthainame32_2]
            });
            //////////////////////////////////////////
            var txt_copydiagramemployeename21_1sh = [<?= $emp ?>];
            $("#txt_copydiagramemployeename21_1sh").autocomplete({
                source: [txt_copydiagramemployeename21_1sh]
            });

            var txt_copydiagramemployeename21_2sh = [<?= $emp ?>];
            $("#txt_copydiagramemployeename21_2sh").autocomplete({
                source: [txt_copydiagramemployeename21_2sh]
            });
            var txt_copydiagramemployeename21_3sh = [<?= $emp ?>];
            $("#txt_copydiagramemployeename21_3sh").autocomplete({
                source: [txt_copydiagramemployeename21_3sh]
            });
            var txt_copydiagramthainame21_1sh = [<?= $thainame ?>];
            $("#txt_copydiagramthainame21_1sh").autocomplete({
                source: [txt_copydiagramthainame21_1sh]
            });

            var txt_copydiagramthainame21_2sh = [<?= $thainame ?>];
            $("#txt_copydiagramthainame21_2sh").autocomplete({
                source: [txt_copydiagramthainame21_2sh]
            });

            //
            var txt_copydiagramemployeename22_1sh = [<?= $emp ?>];
            $("#txt_copydiagramemployeename22_1sh").autocomplete({
                source: [txt_copydiagramemployeename22_1sh]
            });

            var txt_copydiagramemployeename22_2sh = [<?= $emp ?>];
            $("#txt_copydiagramemployeename22_2sh").autocomplete({
                source: [txt_copydiagramemployeename22_2sh]
            });

            var txt_copydiagramemployeename22_3sh = [<?= $emp ?>];
            $("#txt_copydiagramemployeename22_3sh").autocomplete({
                source: [txt_copydiagramemployeename22_3sh]
            });

            var txt_copydiagramemployeename1shn = [<?= $emp ?>];
            $("#txt_copydiagramemployeename1shn").autocomplete({
                source: [txt_copydiagramemployeename1shn]
            });

            var txt_copydiagramemployeename2shn = [<?= $emp ?>];
            $("#txt_copydiagramemployeename2shn").autocomplete({
                source: [txt_copydiagramemployeename2shn]
            });

            var txt_copydiagramemployeename3shn = [<?= $emp ?>];
            $("#txt_copydiagramemployeename3shn").autocomplete({
                source: [txt_copydiagramemployeename3shn]
            });

            ////////////////////////////////////////////////////////
            var txt_copydiagramthainame22_1sh = [<?= $thainame ?>];
            $("#txt_copydiagramthainame22_1sh").autocomplete({
                source: [txt_copydiagramthainame22_1sh]
            });

            var txt_copydiagramthainame22_2sh = [<?= $thainame ?>];
            $("#txt_copydiagramthainame22_2sh").autocomplete({
                source: [txt_copydiagramthainame22_2sh]
            });

            var txt_copydiagramthainame1shn = [<?= $thainame ?>];
            $("#txt_copydiagramthainame1shn").autocomplete({
                source: [txt_copydiagramthainame1shn]
            });

            var txt_copydiagramthainame2shn = [<?= $thainame ?>];
            $("#txt_copydiagramthainame2shn").autocomplete({
                source: [txt_copydiagramthainame2shn]
            });
        </script>

        <script>


            function select_cluster()
            {
                $('.selectpicker').on('changed.bs.select', function () {
                    document.getElementById('txt_copydiagramcluster').value = $(this).val();
                    select_jobend();
                });


            }
            function select_cluster21(data)
            {
                // $('.selectpicker').on('changed.bs.select', function () {
                document.getElementById('txt_copydiagramcluster21').value = data;
                select_jobend21();
                // });


            }
            // function select_cluster21(data)
            // {
            //     $('.selectpicker').on('changed.bs.select', function () {
            //     document.getElementById('txt_copydiagramcluster21').value = data;
            //     select_jobend21();
            //     });
            //
            //
            // }
            function select_cluster22(data)
            {
                // $('.selectpicker').on('changed.bs.select', function () {
                document.getElementById('txt_copydiagramcluster22').value = data;
                select_jobend22();
                // });


            }
            function select_cluster31()
            {
                $('.selectpicker').on('changed.bs.select', function () {
                    document.getElementById('txt_copydiagramcluster31').value = $(this).val();
                    select_jobend31();
                });


            }
            function select_zone()
            {
                $('.selectpicker').on('changed.bs.select', function () {
                    document.getElementById('txt_copydiagramzone').value = $(this).val();
                    select_jobendton();
                });



            }

            function delete_confrimtempskb(confrimskbid)
            {
                var confirmation = confirm("ต้องการลบข้อมูล ?");
                if (confirmation) {
                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "delete_confrimtempskb", confrimskbid: confrimskbid
                        },
                        success: function () {

                            //window.location.reload();
                            select_confrimpriceskb();
                        }
                    });
                }
            }
            function select_confrimpriceskb(jobend)
            {
                document.getElementById('txt_confrimjobstart').value = document.getElementById('cb_copydiagramjobstart').value;
                document.getElementById('txt_confrimcluster').value = document.getElementById('txt_copydiagramzoneskb').value;
                document.getElementById('txt_confrimjobend').value = jobend;

                $("#modal_confrimpriceskb").modal();
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "show_confrimtempskb"
                    },
                    success: function (rs) {

                        document.getElementById("show_confrimtempskb").innerHTML = rs;

                    }
                });

            }
            function select_zoneskb()
            {
                $('.selectpicker').on('changed.bs.select', function () {
                    document.getElementById('txt_copydiagramzoneskb').value = $(this).val();
                    select_locationskb();
                });



            }

            function select_locationskb()
            {

                var txtcopydiagramzoneskb = document.getElementById("txt_copydiagramzoneskb").value;

                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "show_copydiagramlocationskb", companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', zone: txtcopydiagramzoneskb
                    },
                    success: function (rs) {

                        document.getElementById("data_copydiagramlocationsr").innerHTML = rs;
                        document.getElementById("data_copydiagramlocationdef").innerHTML = "";

                        $("#cb_copydiagramlocationskb").html(rs).selectpicker('refresh');
                        $('.selectpicker').on('changed.bs.select', function () {
                            document.getElementById('txt_copydiagramjobendskb').value = $(this).val();




                        });
                        $(function () {
                            $('[data-toggle="popover"]').popover({
                                html: true,
                                content: function () {
                                    return $('#popover-content').html();
                                }
                            });
                        })


                    }
                });
            }

            function select_jobendton()
            {
                var txtcopydiagramzone = document.getElementById("txt_copydiagramzone").value;
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "show_copydiagramjobendton", companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', zone: txtcopydiagramzone
                    },
                    success: function (rs) {

                        document.getElementById("data_copydiagramjobendtonsr").innerHTML = rs;
                        document.getElementById("data_copydiagramjobendtondef").innerHTML = "";

                        $("#cb_copydiagramjobendton").html(rs).selectpicker('refresh');
                        $('.selectpicker').on('changed.bs.select', function () {
                            document.getElementById('txt_copydiagramjobendton').value = $(this).val();

                        });


                    }
                });
            }
            function select_jobend()
            {

                var copydiagramthainame = document.getElementById("txt_copydiagramthainame").value;
                //var copydiagramjobstart = document.getElementById("txt_copydiagramjobstart").value;
                var companycode = document.getElementById("txt_copydiagramcompany").value;
                var customercode = document.getElementById("txt_copydiagramcustomer").value;

                // alert(companycode);
                // alert(customercode);

                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "show_copydiagramjobend", cluster: document.getElementById('txt_copydiagramcluster').value, copydiagramthainame: copydiagramthainame, companycode: companycode, customercode: customercode
                                // txt_flg: "show_copydiagramjobend", cluster: document.getElementById('txt_copydiagramcluster').value, copydiagramthainame: copydiagramthainame
                    },
                    success: function (rs) {

                        document.getElementById("data_copydiagramjobendsr").innerHTML = rs;
                        document.getElementById("data_copydiagramjobenddef").innerHTML = "";

                        $("#cb_copydiagramjobend").html(rs).selectpicker('refresh');
                        $('.selectpicker').on('changed.bs.select', function () {
                            document.getElementById('txt_copydiagramjobend').value = $(this).val();

                        });


                    }
                });
            }
            function select_jobend21()
            {

                var copydiagramthainame21 = document.getElementById("txt_copydiagramthainame21_1").value;
                var copydiagramjobstart21 = document.getElementById("txt_copydiagramjobstart21").value;
                var companycode = document.getElementById("txt_copydiagramcompany21").value;
                var customercode = document.getElementById("txt_copydiagramcustomer21").value;


                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "show_copydiagramjobend21", cluster21: document.getElementById('txt_copydiagramcluster21').value, copydiagramthainame21: copydiagramthainame21, copydiagramjobstart21: copydiagramjobstart21, companycode: companycode, customercode: customercode
                    },
                    success: function (rs) {

                        document.getElementById("data_copydiagramjobendsr21").innerHTML = rs;
                        document.getElementById("data_copydiagramjobenddef21").innerHTML = "";

                        $("#cb_copydiagramjobend21").html(rs).selectpicker('refresh');
                        $('.selectpicker').on('changed.bs.select', function () {
                            document.getElementById('txt_copydiagramjobend21').value = $(this).val();

                        });


                    }
                });
            }
            function select_jobend22()
            {

                var copydiagramthainame22 = document.getElementById("txt_copydiagramthainame22_1").value;
                var copydiagramjobstart22 = document.getElementById("txt_copydiagramjobstart22").value;
                var companycode = document.getElementById("txt_copydiagramcompany22").value;
                var customercode = document.getElementById("txt_copydiagramcustomer22").value;

                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "show_copydiagramjobend22", cluster22: document.getElementById('txt_copydiagramcluster22').value, copydiagramthainame22: copydiagramthainame22, copydiagramjobstart22: copydiagramjobstart22, companycode: companycode, customercode: customercode
                    },
                    success: function (rs) {

                        document.getElementById("data_copydiagramjobendsr22").innerHTML = rs;
                        document.getElementById("data_copydiagramjobenddef22").innerHTML = "";

                        $("#cb_copydiagramjobend22").html(rs).selectpicker('refresh');
                        $('.selectpicker').on('changed.bs.select', function () {
                            document.getElementById('txt_copydiagramjobend22').value = $(this).val();

                        });


                    }
                });
            }
            function select_jobend31()
            {

                var copydiagramthainame31 = document.getElementById("txt_copydiagramthainame31_1").value;
                var copydiagramjobstart31 = document.getElementById("txt_copydiagramjobstart31").value;

                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "show_copydiagramjobend31", cluster31: document.getElementById('txt_copydiagramcluster31').value, copydiagramthainame31: copydiagramthainame31, copydiagramjobstart31: copydiagramjobstart31
                    },
                    success: function (rs) {

                        document.getElementById("data_copydiagramjobendsr31").innerHTML = rs;
                        document.getElementById("data_copydiagramjobenddef31").innerHTML = "";

                        $("#cb_copydiagramjobend31").html(rs).selectpicker('refresh');
                        $('.selectpicker').on('changed.bs.select', function () {
                            document.getElementById('txt_copydiagramjobend31').value = $(this).val();

                        });


                    }
                });
            }
            function pdf_transportplan()
            {
                var datestart = document.getElementById("txt_datestartsr").value;
                var dateend = document.getElementById("txt_dateendsr").value;
                window.open('pdf_transportplan.php?datestart=' + datestart + '&dateend=' + dateend, '_blank');


            }

        </script>
        <script>
            function noWeekends(date) {
                var day = date.getDay();
                // ถ้าวันเป็นวันอาทิตย์ (0) หรือวันเสาร์ (6)
                if (day === 2 || day === 3 || day === 4 || day === 5 || day === 6 || day === 0) {

                    // เลือกไม่ได้
                    return [false, "", "วันนี้เป็นวันหยุด"];
                }
                // เลือกได้ตามปกติ
                return [true, "", ""];
            }

        </script>
        <script>
            $(function () {
                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                // กรณีใช้แบบ input
                $(".dateen").datetimepicker({
                    timepicker: false,
                    format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                    beforeShowDay: noWeekends

                });
            });
        </script>
        <script>
            $(function () {

                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                // กรณีใช้แบบ input
                $(".datedef").datetimepicker({
                    timepicker: false,
                    format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.

                });
            });
        </script>

        <script>
            $(function () {
                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                // กรณีใช้แบบ input
                $(".datetimeen").datetimepicker({
                    timepicker: true,
                    dateformat: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00 - 00 - 0000
                    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                    timeFormat: "HH:mm"

                }
                );
            });
            $(function () {
                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ. // กรณีใช้แบบ input
                $(".timeen").datetimepicker({
                    datepicker: false,
                    format: 'H:i',
                    //mask: '29:59',
                    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                });
            });
        </script>
        <script>

            $(document).ready(function () {
                $('#dataTables-example11').DataTable({

                    order: [[0, "desc"]],
                    scrollX: true,
                    scrollY: '500px',
                });




                $('#dataTables-example2').DataTable({
                    responsive: true,
                    order: [[0, "desc"]]
                });

                $('#dataTables-checkdriver').DataTable({
                    responsive: true,
                    order: [[0, "desc"]]
                });



                $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                    $($.fn.dataTable.tables(true)).DataTable()
                            .columns.adjust()
                            .responsive.recalc();
                });

            });
        </script>
        <script>
            // append row to the HTML table
            function appendRow() {
                var tbl = document.getElementById('dataTables-example'), // table reference
                        row = tbl.insertRow(tbl.rows.length), // append table row
                        i;
                // insert table cells to the new row
                for (i = 0; i < tbl.rows[2].cells.length; i++) {
                    createCell(row.insertCell(i), '', 'row');
                }
            }

            // create DIV element and append to the table cell
            function createCell(cell, text, style) {
                var div = document.createElement('div'), // create DIV element
                        txt = document.createTextNode(text); // create text node
                div.appendChild(txt); // append text node to the DIV
                div.setAttribute('class', style); // set DIV class attribute
                div.setAttribute('className', style); // set DIV class attribute for IE (?!)
                cell.appendChild(div); // append DIV to the table cell
            }
            // append column to the HTML table
            function appendColumn() {
                var tbl = document.getElementById('dataTables-example'), // table reference
                        i;
                // open loop for each row and append cell
                for (i = 0; i < tbl.rows.length; i++) {
                    createCell(tbl.rows[i].insertCell(tbl.rows[i].cells.length), '', 'col');
                }
            }
            // delete table rows with index greater then 0
            function deleteRows() {
                var tbl = document.getElementById('dataTables-example'), // table reference
                        lastRow = tbl.rows.length - 1, // set the last row index
                        i;
                // delete rows with index greater then 0
                for (i = lastRow; i > 2; i--) {
                    tbl.deleteRow(i);
                }
            }

            // delete table columns with index greater then 0
            function deleteColumns() {
                var tbl = document.getElementById('dataTables-example'), // table reference
                        lastCol = tbl.rows[0].cells.length - 1, // set the last column index
                        i, j;
                // delete cells with index greater then 0 (for each row)
                for (i = 0; i < tbl.rows.length; i++) {
                    for (j = lastCol; j > 5; j--) {
                        tbl.rows[i].deleteCell(j);
                    }
                }
            }
        </script>
        <script>

            function chk_disible()
            {
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "select_vehicletransportdocument", vehicletransportplanid: vehicletransportplanid
                    },
                    success: function (response) {
                        if (response)
                        {

                            document.getElementById("datasr").innerHTML = response;
                            document.getElementById("datadef").innerHTML = "";
                        }
                        $(document).ready(function () {
                            $('#dataTables-example2').DataTable({
                                responsive: true,
                                order: [[0, "desc"]]
                            });
                        });
                    }
                });
            }

            function add_dateweek1(datestart)
            {


                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "select_adddateweek", datestart: datestart
                    },
                    success: function (rs) {

                        var res = rs.split("|");
                        document.getElementById("txt_dateendsr").value = res[0];

                        dateendsr();







                    }
                });


            }


            function dateendsr()
            {

                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "showupdate_vehicletransportplan", datestart: document.getElementById("txt_datestartsr").value, dateend: document.getElementById("txt_dateendsr").value, statusnumber: document.getElementById("cb_statussr").value, companycode: '<?= $_GET['companycode'] ?>', customercode: '<?= $_GET['customercode'] ?>', worktype: '<?= $_GET['worktype'] ?>', carrytype: '<?= $_GET['carrytype'] ?>'
                    },
                    success: function (rs) {
                        document.getElementById("showdatasr").innerHTML = rs;
                        document.getElementById("showdatadef").innerHTML = "";



                        $(document).ready(function () {
                            $('#dataTables-example11').DataTable({

                                order: [[0, "desc"]],
                                scrollX: true,
                                scrollY: '500px',
                            });

                            $('#dataTables-example22').DataTable({

                                order: [[0, "desc"]],
                                scrollX: true,
                                scrollY: '500px',

                            });

                            $('#dataTables-example33').DataTable({

                                order: [[0, "desc"]],
                                scrollX: true,
                                scrollY: '500px',
                            });

                            $('#dataTables-example44').DataTable({

                                order: [[0, "desc"]],
                                scrollX: true,
                                scrollY: '500px',
                            });

                            $('#dataTables-example55').DataTable({

                                order: [[0, "desc"]],
                                scrollX: true,
                                scrollY: '500px',
                            });

                            $('#dataTables-example66').DataTable({

                                order: [[0, "desc"]],
                                scrollX: true,
                                scrollY: '500px',
                            });

                            $('#dataTables-example77').DataTable({

                                order: [[0, "desc"]],
                                scrollX: true,
                                scrollY: '500px',
                            });
                            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                                $($.fn.dataTable.tables(true)).DataTable()
                                        .columns.adjust()
                                        .responsive.recalc();
                            });
                        });


                        $("#cb_jobendm<?= $i1 ?>").html(rs).selectpicker('refresh');
                        $('.selectpicker').on('changed.bs.select', function () {

                            //edit_vehicletransportplan('' + $(this).val() + '', 'JOBEND', ID);

                        });






                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "select_adddateweek", datestart: document.getElementById("txt_datestartsr").value
                            },
                            success: function (rs) {

                                var res = rs.split("|");
                                document.getElementById("txt_dateendsr").value = res[0];



                                document.getElementById("lbl_m").innerHTML = '(' + res[1] + ')';
                                document.getElementById("lbl_tu").innerHTML = '(' + res[2] + ')';
                                document.getElementById("lbl_w").innerHTML = '(' + res[3] + ')';
                                document.getElementById("lbl_th").innerHTML = '(' + res[4] + ')';
                                document.getElementById("lbl_f").innerHTML = '(' + res[5] + ')';
                                document.getElementById("lbl_sat").innerHTML = '(' + res[6] + ')';
                                document.getElementById("lbl_sun").innerHTML = '(' + res[7] + ')';

                                save_logprocess('Planing', 'Select Status Planing', '<?= $result_seLogin['PersonCode'] ?>');

                            }
                        });

                    }
                });
            }
            function showupdate_vehicletransportdocument(vehicletransportplanid)
            {
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "select_vehicletransportdocument", vehicletransportplanid: vehicletransportplanid
                    },
                    success: function (response) {
                        if (response)
                        {

                            document.getElementById("datasr").innerHTML = response;
                            document.getElementById("datadef").innerHTML = "";
                        }
                        $(document).ready(function () {
                            $('#dataTables-example2').DataTable({
                                responsive: true,
                                order: [[0, "desc"]]
                            });
                        });
                    }
                });
            }
            function showupdate_vehicletransportactual(vehicletransportplanid)
            {

                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "select_vehicletransportactual", vehicletransportplanid: vehicletransportplanid
                    },
                    success: function (response) {
                        if (response)
                        {

                            document.getElementById("datasr_actual").innerHTML = response;
                            document.getElementById("datadef_actual").innerHTML = "";

                            $(function () {
                                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                // กรณีใช้แบบ input
                                $(".datetimeen").datetimepicker({
                                    timepicker: true,
                                    dateformat: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00 - 00 - 0000
                                    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                    timeFormat: "HH:mm"

                                }
                                );
                            });

                        }

                    }
                });
            }



            function add_dateweeksh(datestart)
            {


                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "select_adddateweek", datestart: datestart
                    },
                    success: function (rs) {

                        var res = rs.split("|");
                        document.getElementById("txt_copydiagramdateend").value = res[0];


                        document.getElementById("lab_monday").innerHTML = '(' + res[1] + ')';
                        document.getElementById("lab_tuesday").innerHTML = '(' + res[2] + ')';
                        document.getElementById("lab_wednesday").innerHTML = '(' + res[3] + ')';
                        document.getElementById("lab_thursday").innerHTML = '(' + res[4] + ')';
                        document.getElementById("lab_friday").innerHTML = '(' + res[5] + ')';
                        document.getElementById("lab_saturday").innerHTML = '(' + res[6] + ')';
                        document.getElementById("lab_sunday").innerHTML = '(' + res[7] + ')';

                        create_jobno11_sh('monday', '<?= $_GET['companycode'] ?>', res[1]);
                        create_jobno11_sh('tuesday', '<?= $_GET['companycode'] ?>', res[2]);
                        create_jobno11_sh('wednesday', '<?= $_GET['companycode'] ?>', res[3]);
                        create_jobno11_sh('thursday', '<?= $_GET['companycode'] ?>', res[4]);
                        create_jobno11_sh('friday', '<?= $_GET['companycode'] ?>', res[5]);
                        create_jobno11_sh('saturday', '<?= $_GET['companycode'] ?>', res[6]);
                        create_jobno11_sh('sunday', '<?= $_GET['companycode'] ?>', res[7]);


                    }
                });
            }

            function add_dateweekshn(datestart)
            {
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "select_adddateweek", datestart: datestart
                    },
                    success: function (rs) {

                        var res = rs.split("|");
                        document.getElementById("txt_copydiagramdateendshn").value = res[0];


                        document.getElementById("lab_mondayshn").innerHTML = '(' + res[1] + ')';
                        document.getElementById("lab_tuesdayshn").innerHTML = '(' + res[2] + ')';
                        document.getElementById("lab_wednesdayshn").innerHTML = '(' + res[3] + ')';
                        document.getElementById("lab_thursdayshn").innerHTML = '(' + res[4] + ')';
                        document.getElementById("lab_fridayshn").innerHTML = '(' + res[5] + ')';
                        document.getElementById("lab_saturdayshn").innerHTML = '(' + res[6] + ')';
                        document.getElementById("lab_sundayshn").innerHTML = '(' + res[7] + ')';

                        create_jobnoshn('monday', '<?= $_GET['companycode'] ?>', res[1]);
                        create_jobnoshn('tuesday', '<?= $_GET['companycode'] ?>', res[2]);
                        create_jobnoshn('wednesday', '<?= $_GET['companycode'] ?>', res[3]);
                        create_jobnoshn('thursday', '<?= $_GET['companycode'] ?>', res[4]);
                        create_jobnoshn('friday', '<?= $_GET['companycode'] ?>', res[5]);
                        create_jobnoshn('saturday', '<?= $_GET['companycode'] ?>', res[6]);
                        create_jobnoshn('sunday', '<?= $_GET['companycode'] ?>', res[7]);


                    }
                });
            }

            function add_dateweeksh2(datestart)
            {


                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "select_adddateweek", datestart: datestart
                    },
                    success: function (rs) {

                        var res = rs.split("|");
                        document.getElementById("txt_copydiagramdateendshsh").value = res[0];

                        document.getElementById("lab_monday21_sh").innerHTML = '(' + res[1] + ')';
                        document.getElementById("lab_tuesday21_sh").innerHTML = '(' + res[2] + ')';
                        document.getElementById("lab_wednesday21_sh").innerHTML = '(' + res[3] + ')';
                        document.getElementById("lab_thursday21_sh").innerHTML = '(' + res[4] + ')';
                        document.getElementById("lab_friday21_sh").innerHTML = '(' + res[5] + ')';
                        document.getElementById("lab_saturday21_sh").innerHTML = '(' + res[6] + ')';
                        document.getElementById("lab_sunday21_sh").innerHTML = '(' + res[7] + ')';

                        document.getElementById("lab_monday22_sh").innerHTML = '(' + res[1] + ')';
                        document.getElementById("lab_tuesday22_sh").innerHTML = '(' + res[2] + ')';
                        document.getElementById("lab_wednesday22_sh").innerHTML = '(' + res[3] + ')';
                        document.getElementById("lab_thursday22_sh").innerHTML = '(' + res[4] + ')';
                        document.getElementById("lab_friday22_sh").innerHTML = '(' + res[5] + ')';
                        document.getElementById("lab_saturday22_sh").innerHTML = '(' + res[6] + ')';
                        document.getElementById("lab_sunday22_sh").innerHTML = '(' + res[7] + ')';



                        create_jobno21_sh('monday', '<?= $_GET['companycode'] ?>', res[1]);
                        create_jobno21_sh('tuesday', '<?= $_GET['companycode'] ?>', res[2]);
                        create_jobno21_sh('wednesday', '<?= $_GET['companycode'] ?>', res[3]);
                        create_jobno21_sh('thursday', '<?= $_GET['companycode'] ?>', res[4]);
                        create_jobno21_sh('friday', '<?= $_GET['companycode'] ?>', res[5]);
                        create_jobno21_sh('saturday', '<?= $_GET['companycode'] ?>', res[6]);
                        create_jobno21_sh('sunday', '<?= $_GET['companycode'] ?>', res[7]);

                        create_jobno22_sh('monday', '<?= $_GET['companycode'] ?>', res[1]);
                        create_jobno22_sh('tuesday', '<?= $_GET['companycode'] ?>', res[2]);
                        create_jobno22_sh('wednesday', '<?= $_GET['companycode'] ?>', res[3]);
                        create_jobno22_sh('thursday', '<?= $_GET['companycode'] ?>', res[4]);
                        create_jobno22_sh('friday', '<?= $_GET['companycode'] ?>', res[5]);
                        create_jobno22_sh('saturday', '<?= $_GET['companycode'] ?>', res[6]);
                        create_jobno22_sh('sunday', '<?= $_GET['companycode'] ?>', res[7]);


                    }
                });
            }
            function create_jobno11_sh(typeday, companycode, jobdate)
            {

                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "create_jobno", companycode: companycode, jobdate: jobdate
                    },
                    success: function (rs) {
                        if (typeday == 'monday')
                        {
                            document.getElementById("txt_copydiagramjobnomonday").value = rs;

                        }
                        if (typeday == 'tuesday')
                        {
                            document.getElementById("txt_copydiagramjobnotuesday").value = rs;

                        }
                        if (typeday == 'wednesday')
                        {
                            document.getElementById("txt_copydiagramjobnowednesday").value = rs;

                        }
                        if (typeday == 'thursday')
                        {
                            document.getElementById("txt_copydiagramjobnothursday").value = rs;

                        }
                        if (typeday == 'friday')
                        {
                            document.getElementById("txt_copydiagramjobnofriday").value = rs;

                        }
                        if (typeday == 'saturday')
                        {
                            document.getElementById("txt_copydiagramjobnosaturday").value = rs;

                        }
                        if (typeday == 'sunday')
                        {
                            document.getElementById("txt_copydiagramjobnosunday").value = rs;

                        }
                    }
                });
            }
            function create_jobno21_sh(typeday, companycode, jobdate)
            {

                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "create_jobno", companycode: companycode, jobdate: jobdate
                    },
                    success: function (rs) {
                        if (typeday == 'monday')
                        {
                            document.getElementById("txt_copydiagramjobnomonday21_sh").value = rs;

                        }
                        if (typeday == 'tuesday')
                        {
                            document.getElementById("txt_copydiagramjobnotuesday21_sh").value = rs;

                        }
                        if (typeday == 'wednesday')
                        {
                            document.getElementById("txt_copydiagramjobnowednesday21_sh").value = rs;

                        }
                        if (typeday == 'thursday')
                        {
                            document.getElementById("txt_copydiagramjobnothursday21_sh").value = rs;

                        }
                        if (typeday == 'friday')
                        {
                            document.getElementById("txt_copydiagramjobnofriday21_sh").value = rs;

                        }
                        if (typeday == 'saturday')
                        {
                            document.getElementById("txt_copydiagramjobnosaturday21_sh").value = rs;

                        }
                        if (typeday == 'sunday')
                        {
                            document.getElementById("txt_copydiagramjobnosunday21_sh").value = rs;

                        }
                    }
                });
            }
            function create_jobno22_sh(typeday, companycode, jobdate)
            {

                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "create_jobno", companycode: companycode, jobdate: jobdate
                    },
                    success: function (rs) {
                        if (typeday == 'monday')
                        {
                            document.getElementById("txt_copydiagramjobnomonday22_sh").value = rs;

                        }
                        if (typeday == 'tuesday')
                        {
                            document.getElementById("txt_copydiagramjobnotuesday22_sh").value = rs;

                        }
                        if (typeday == 'wednesday')
                        {
                            document.getElementById("txt_copydiagramjobnowednesday22_sh").value = rs;

                        }
                        if (typeday == 'thursday')
                        {
                            document.getElementById("txt_copydiagramjobnothursday22_sh").value = rs;

                        }
                        if (typeday == 'friday')
                        {
                            document.getElementById("txt_copydiagramjobnofriday22_sh").value = rs;

                        }
                        if (typeday == 'saturday')
                        {
                            document.getElementById("txt_copydiagramjobnosaturday22_sh").value = rs;

                        }
                        if (typeday == 'sunday')
                        {
                            document.getElementById("txt_copydiagramjobnosunday22_sh").value = rs;

                        }
                    }
                });
            }
            function create_jobnoshn(typeday, companycode, jobdate)
            {

                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "create_jobno", companycode: companycode, jobdate: jobdate
                    },
                    success: function (rs) {
                        if (typeday == 'monday')
                        {
                            document.getElementById("txt_copydiagramjobnomondayshn").value = rs;

                        }
                        if (typeday == 'tuesday')
                        {
                            document.getElementById("txt_copydiagramjobnotuesdayshn").value = rs;

                        }
                        if (typeday == 'wednesday')
                        {
                            document.getElementById("txt_copydiagramjobnowednesdayshn").value = rs;

                        }
                        if (typeday == 'thursday')
                        {
                            document.getElementById("txt_copydiagramjobnothursdayshn").value = rs;

                        }
                        if (typeday == 'friday')
                        {
                            document.getElementById("txt_copydiagramjobnofridayshn").value = rs;

                        }
                        if (typeday == 'saturday')
                        {
                            document.getElementById("txt_copydiagramjobnosaturdayshn").value = rs;

                        }
                        if (typeday == 'sunday')
                        {
                            document.getElementById("txt_copydiagramjobnosundayshn").value = rs;

                        }
                    }
                });
            }
        </script>
        <script>
            function chknull_vehicletransportdocument()
            {
                if (document.getElementById("cb_documenttype").value == "")
                {
                    alert('ประเภทเอกสาร เป็นค่าว่าง !!!')
                    document.getElementById('cb_documenttype').focus();
                    return false;
                } else if (document.getElementById("txt_amount").value == "")
                {
                    alert('จำนวน เป็นค่าว่าง !!!')
                    document.getElementById('txt_amount').focus();
                    return false;
                } else if (document.getElementById("cb_unit").value == "")
                {
                    alert('หน่วย เป็นค่าว่าง !!!')
                    document.getElementById('cb_unit').focus();
                    return false;
                } else if (document.getElementById("cb_activestatus").value == "")
                {
                    alert('สถานะ เป็นค่าว่าง !!!')
                    document.getElementById('cb_activestatus').focus();
                    return false;
                } else
                {
                    return true;
                }
            }

            function add_vehicletransportplanroot(CUSTOMERCODE, COMPANYCODE, VEHICLEREGISNUMBER1, VEHICLEREGISNUMBER2, THAINAME, ENGNAME, VEHICLETRANSPORTPRICEID, CLUSTER, DEALERCODE, NAME, SRBASE4L, SRBASE8L, GWBASE4L, GWBASE8L, BPBASE4L, BPBASE8L, OTHBASE4L, OTHBASE8L, E1, E2, E3, E4, C1, C2, C3, C4, C5, C6, C7, C8, C9, O1, O2, O3, O4, JOBSTART, JOBEND, EMPLOYEECODE1, EMPLOYEENAME1, EMPLOYEECODE2, EMPLOYEENAME2, EMPLOYEECODE3, EMPLOYEENAME3, EMPLOYEECODE4, EMPLOYEENAME4, JOBNO, TRIPNO, DATEINPUT, DATESTART, DATEWORKING, DATEWORKSUS, DATEPRESENT, DATEVLIN, DATEVLOUT, DATEDEALERIN, DATERETURN, STATUS, ACTIVESTATUS, REMARK)
            {

                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "save_vehicletransportplan", VEHICLETRANSPORTPLANID: '', CUSTOMERCODE: CUSTOMERCODE, COMPANYCODE: COMPANYCODE, VEHICLEREGISNUMBER1: VEHICLEREGISNUMBER1, VEHICLEREGISNUMBER2: VEHICLEREGISNUMBER2, THAINAME: THAINAME, ENGNAME: ENGNAME, VEHICLETRANSPORTPRICEID: VEHICLETRANSPORTPRICEID, CLUSTER: CLUSTER, DEALERCODE: DEALERCODE, NAME: NAME, SRBASE4L: SRBASE4L, SRBASE8L: SRBASE8L, GWBASE4L: GWBASE4L, GWBASE8L: GWBASE8L, BPBASE4L: BPBASE4L, BPBASE8L: BPBASE8L, OTHBASE4L: OTHBASE4L, OTHBASE8L: OTHBASE8L, E1: E1, E2: E2, E3: E3, E4: E4, C1: C1, C2: C2, C3: C3, C4: C4, C5: C5, C6: C6, C7: C7, C8: C8, C9: C9, O1: O1, O2: O2, O3: O3, O4: O4, JOBSTART: JOBSTART, JOBEND: JOBEND, EMPLOYEECODE1: EMPLOYEECODE1, EMPLOYEENAME1: EMPLOYEENAME1, EMPLOYEECODE2: EMPLOYEECODE2, EMPLOYEENAME2: EMPLOYEENAME2, EMPLOYEECODE3: EMPLOYEECODE3, EMPLOYEENAME3: EMPLOYEENAME3, EMPLOYEECODE4: EMPLOYEECODE4, EMPLOYEENAME4: EMPLOYEENAME4, JOBNO: JOBNO, TRIPNO: TRIPNO, DATEINPUT: DATEINPUT, DATESTART: DATESTART, DATEWORKING: DATEWORKING, DATEWORKSUS: DATEWORKSUS, DATEPRESENT: DATEPRESENT, DATEVLIN: DATEVLIN, DATEVLOUT: DATEVLOUT, DATEDEALERIN: DATEDEALERIN, DATERETURN: DATERETURN, STATUS: STATUS, ACTIVESTATUS: ACTIVESTATUS, REMARK: REMARK
                    },
                    success: function (rs) {
                        alert(rs);
                        window.location.reload();
                    }
                });
            }
            function update_vehicletransportdocument(vehicletransportdocumentid, vehicletransportplanid, documenttype, documentnumber, amount, unit, activestatus, documentremark)
            {
                document.getElementById("txt_vehicletransportdocumentid").value = vehicletransportdocumentid;
                document.getElementById("txt_vehicletransportplanid").value = vehicletransportplanid;
                document.getElementById("cb_documenttype").value = documenttype;
                document.getElementById("txt_documentnumber").value = documentnumber;
                document.getElementById("txt_amount").value = amount;
                document.getElementById("cb_unit").value = unit;
                document.getElementById("cb_activestatus").value = activestatus;
                document.getElementById("txt_documentremark").value = documentremark;
            }
            function save_vehicletransportdocument()
            {
                var route = document.getElementById("txt_route").value;
                var vehicletransportdocumentid = document.getElementById("txt_vehicletransportdocumentid").value;
                var vehicletransportplanid = document.getElementById("txt_vehicletransportplanid").value;
                var documenttype = document.getElementById("cb_documenttype").value;
                var amount = document.getElementById("txt_amount").value;
                var unit = document.getElementById("cb_unit").value;
                var activestatus = document.getElementById("cb_activestatus").value;
                var documentremark = document.getElementById("txt_documentremark").value;

                if (route == "-")
                {
                    alert('กรุณาเลือกเส้นทางก่อน !!!');
                } else
                {


                    if (chknull_vehicletransportdocument())
                    {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_vehicletransportdocumentadmin", vehicletransportdocumentid: vehicletransportdocumentid, vehicletransportplanid: vehicletransportplanid, documenttype: documenttype, amount: amount, unit: unit, activestatus: activestatus, documentremark: documentremark

                            },
                            success: function (rs) {
                                alert(rs);
                                showupdate_vehicletransportdocument(vehicletransportplanid);
                            }
                        });
                    }
                }
            }


            function save_vehicletransportplan(employeename1)
            {

                var companycode = document.getElementById("txt_companycode").value;
                var customercode = document.getElementById("txt_customercode").value;
                if (companycode != '' && customercode != '')
                {

                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "save_vehicletransportplan", VEHICLETRANSPORTPLANID: '', CUSTOMERCODE: customercode, COMPANYCODE: companycode, VEHICLEREGISNUMBER1: '', VEHICLEREGISNUMBER2: '', THAINAME: '', ENGNAME: '', VEHICLETRANSPORTPRICEID: '', CLUSTER: '', DEALERCODE: '', NAME: '', SRBASE4L: '', SRBASE8L: '', GWBASE4L: '', GWBASE8L: '', BPBASE4L: '', BPBASE8L: '', OTHBASE4L: '', OTHBASE8L: '', E1: '', E2: '', E3: '', E4: '', C1: '', C2: '', C3: '', C4: '', C5: '', C6: '', C7: '', C8: '', C9: '', O1: '', O2: '', O3: '', O4: '', JOBSTART: '', JOBEND: '', EMPLOYEECODE1: '', EMPLOYEENAME1: employeename1, EMPLOYEECODE2: '', EMPLOYEENAME2: '', EMPLOYEECODE3: '', EMPLOYEENAME3: '', EMPLOYEECODE4: '', EMPLOYEENAME4: '', JOBNO: '<?= $run_jobno ?>', TRIPNO: '', DATEINPUT: '', DATEWORKING: '', DATEWORKSUS: '', DATEPRESENT: '', DATEVLIN: '', DATEVLOUT: '', DATEDEALERIN: '', DATERETURN: '', STATUS: '', ACTIVESTATUS: '', REMARK: ''
                        },
                        success: function (rs) {
                            alert(rs);
                            //alert('เพิ่มแผนการขนส่งเรียบร้อยแล้ว');

                            window.location.reload();
                        }
                    });
                } else
                {
                    alert('ไม่สามารถสร้างแผนการขนส่งได้ !!!');
                }
            }

            function delete_vehicletransportplan(vehicletransportplanid)
            {

                var confirmation = confirm("ต้องการลบข้อมูล ?");
                if (confirmation) {
                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "delete_vehicletransportplan", vehicletransportplanid: vehicletransportplanid
                        },
                        success: function () {

                            window.location.reload();
                        }
                    });
                }
            }
            function delete_vehicletransportdocument(vehicletransportdocumentid, vehicletransportplanid)
            {
                var confirmation = confirm("ต้องการลบข้อมูล ?");
                if (confirmation) {
                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "delete_vehicletransportdocument", vehicletransportdocumentid: vehicletransportdocumentid
                        },
                        success: function () {
                            alert('ลบข้อมูลเรียบร้อยแล้ว');
                            showupdate_vehicletransportdocument(vehicletransportplanid);
                        }
                    });
                }
            }


        </script>

        <script>

            function edit_vehicletransportplaninner(editableObj, fieldname, ID)
            {
                var dataedit = editableObj.innerHTML;
                $.ajax({
                    url: 'meg_data.php',
                    type: 'POST',
                    data: {
                        txt_flg: "edit_vehicletransportplan", editableObj: dataedit, ID: ID, fieldname: fieldname
                    },
                    success: function () {

                    }
                });
            }
            function update_vehicletransportplanjob(rootno, statusnumber)
            {

                $.ajax({
                    url: 'meg_data.php',
                    type: 'post',
                    data: {
                        txt_flg: "edit_vehicletransportplanjob", rootno: rootno, statusnumber: statusnumber
                    },
                    success: function () {

                        //window.location.reload();
                    }

                });
            }
            function edit_vehicletransportplanactual(editableObj, fieldname)
            {
                var vehicletransportplanid = document.getElementById("txt_vehicletransportplanid").value;

                $.ajax({
                    url: 'meg_data.php',
                    type: 'POST',
                    data: {
                        txt_flg: "edit_datevehicletransportplan", editableObj: editableObj, ID: vehicletransportplanid, fieldname: fieldname
                    },
                    success: function () {

                    }
                });
            }
            function edit_vehicletransportplanend(editableObj, fieldname, ID)
            {

                //for (var n = 1; n < <?//= $i ?>; n++) {

                //if (document.getElementById("txt_employee2" + n).value != "" || document.getElementById("txt_employee21" + n).value != "")
                //{

                /*if (document.getElementById("txt_employee2" + n).value == document.getElementById("txt_employee1" + n).value)
                 {
                 alert('เลือกพนักงาน(2)ให้ถูกต้อง !!!');
                 document.getElementById("txt_employee2" + n).value = '';
                 document.getElementById("txt_employee2" + n).focus();
                 } else
                 {*/

                $.ajax({
                    url: 'meg_data.php',
                    type: 'POST',
                    data: {
                        txt_flg: "edit_vehicletransportplan", editableObj: editableObj, ID: ID, fieldname: fieldname
                    },
                    success: function () {

                        window.location.reload();
                    }
                });
                //}
                //}
                //}

            }
            function reload()
            {
                window.location.reload();
            }
            function select_vehicletransportplanjobend(editableObj, fieldname, ID, cb_idname1)
            {
                if (fieldname == 'CLUSTER')
                {
                    $.ajax({
                        type: 'post',
                        url: 'meg_data.php',
                        data: {
                            txt_flg: "show_jobend", cluster: editableObj, cb_idname1: cb_idname1
                        },
                        success: function (rs) {


                            document.getElementById("data_clustersr" + cb_idname1).innerHTML = rs;
                            document.getElementById("data_clusterdef" + cb_idname1).innerHTML = "";


                            $("#" + cb_idname1).html(rs).selectpicker('refresh');
                            $('.selectpicker').on('changed.bs.select', function () {

                                edit_vehicletransportplan('' + $(this).val() + '', 'JOBEND', ID);

                            });
                            edit_vehicletransportplan(editableObj, fieldname, ID);
                        }
                    });
                }
            }

            function edit_vehicletransportplan(editableObj, fieldname, ID)
            {

                //for (var n = 1; n < <?//= $i ?>; n++) {

                //if (document.getElementById("txt_employee2" + n).value != "" || document.getElementById("txt_employee21" + n).value != "")
                //{

                /*if (document.getElementById("txt_employee2" + n).value == document.getElementById("txt_employee1" + n).value)
                 {
                 alert('เลือกพนักงาน(2)ให้ถูกต้อง !!!');
                 document.getElementById("txt_employee2" + n).value = '';
                 document.getElementById("txt_employee2" + n).focus();
                 } else
                 {*/

                $.ajax({
                    url: 'meg_data.php',
                    type: 'POST',
                    data: {
                        txt_flg: "edit_vehicletransportplan", editableObj: editableObj, ID: ID, fieldname: fieldname
                    },
                    success: function () {

                    }
                });
                //}
                //}
                //}

            }
        </script>
        <script>
            function edit_datevehicletransportplan(editableObj, fieldname, ID) {
                $.ajax({
                    url: 'meg_data.php',
                    type: 'POST',
                    data: {
                        txt_flg: "edit_datevehicletransportplan", editableObj: editableObj, ID: ID, fieldname: fieldname
                    },
                    success: function () {


                    }
                });
            }
        </script>

        <script>
            function add_dateweek(datestart)
            {


                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "select_adddateweek", datestart: datestart
                    },
                    success: function (rs) {

                        var res = rs.split("|");
                        document.getElementById("txt_copydiagramdateend").value = res[0];

                        document.getElementById("lab_monday").innerHTML = '(' + res[1] + ')';
                        document.getElementById("lab_tuesday").innerHTML = '(' + res[2] + ')';
                        document.getElementById("lab_wednesday").innerHTML = '(' + res[3] + ')';
                        document.getElementById("lab_thursday").innerHTML = '(' + res[4] + ')';
                        document.getElementById("lab_friday").innerHTML = '(' + res[5] + ')';
                        document.getElementById("lab_saturday").innerHTML = '(' + res[6] + ')';
                        document.getElementById("lab_sunday").innerHTML = '(' + res[7] + ')';






                        create_jobno('monday', '<?= $_GET['companycode'] ?>', res[1]);
                        create_jobno('tuesday', '<?= $_GET['companycode'] ?>', res[2]);
                        create_jobno('wednesday', '<?= $_GET['companycode'] ?>', res[3]);
                        create_jobno('thursday', '<?= $_GET['companycode'] ?>', res[4]);
                        create_jobno('friday', '<?= $_GET['companycode'] ?>', res[5]);
                        create_jobno('saturday', '<?= $_GET['companycode'] ?>', res[6]);
                        create_jobno('sunday', '<?= $_GET['companycode'] ?>', res[7]);
                    }
                });
            }
            function add_dateweeknn(datestart)
            {


                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "select_adddateweek", datestart: datestart
                    },
                    success: function (rs) {

                        var res = rs.split("|");
                        document.getElementById("txt_copydiagramdateendnn").value = res[0];

                        document.getElementById("lab_monday21").innerHTML = '(' + res[1] + ')';
                        document.getElementById("lab_tuesday21").innerHTML = '(' + res[2] + ')';
                        document.getElementById("lab_wednesday21").innerHTML = '(' + res[3] + ')';
                        document.getElementById("lab_thursday21").innerHTML = '(' + res[4] + ')';
                        document.getElementById("lab_friday21").innerHTML = '(' + res[5] + ')';
                        document.getElementById("lab_saturday21").innerHTML = '(' + res[6] + ')';
                        document.getElementById("lab_sunday21").innerHTML = '(' + res[7] + ')';

                        document.getElementById("lab_monday22").innerHTML = '(' + res[1] + ')';
                        document.getElementById("lab_tuesday22").innerHTML = '(' + res[2] + ')';
                        document.getElementById("lab_wednesday22").innerHTML = '(' + res[3] + ')';
                        document.getElementById("lab_thursday22").innerHTML = '(' + res[4] + ')';
                        document.getElementById("lab_friday22").innerHTML = '(' + res[5] + ')';
                        document.getElementById("lab_saturday22").innerHTML = '(' + res[6] + ')';
                        document.getElementById("lab_sunday22").innerHTML = '(' + res[7] + ')';






                        create_jobno21('monday', '<?= $_GET['companycode'] ?>', res[1]);
                        create_jobno21('tuesday', '<?= $_GET['companycode'] ?>', res[2]);
                        create_jobno21('wednesday', '<?= $_GET['companycode'] ?>', res[3]);
                        create_jobno21('thursday', '<?= $_GET['companycode'] ?>', res[4]);
                        create_jobno21('friday', '<?= $_GET['companycode'] ?>', res[5]);
                        create_jobno21('saturday', '<?= $_GET['companycode'] ?>', res[6]);
                        create_jobno21('sunday', '<?= $_GET['companycode'] ?>', res[7]);

                        create_jobno22('monday', '<?= $_GET['companycode'] ?>', res[1]);
                        create_jobno22('tuesday', '<?= $_GET['companycode'] ?>', res[2]);
                        create_jobno22('wednesday', '<?= $_GET['companycode'] ?>', res[3]);
                        create_jobno22('thursday', '<?= $_GET['companycode'] ?>', res[4]);
                        create_jobno22('friday', '<?= $_GET['companycode'] ?>', res[5]);
                        create_jobno22('saturday', '<?= $_GET['companycode'] ?>', res[6]);
                        create_jobno22('sunday', '<?= $_GET['companycode'] ?>', res[7]);
                    }
                });
            }
            function add_dateweekns(datestart)
            {


                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "select_adddateweek", datestart: datestart
                    },
                    success: function (rs) {

                        var res = rs.split("|");
                        document.getElementById("txt_copydiagramdateendns").value = res[0];

                        document.getElementById("lab_monday31").innerHTML = '(' + res[1] + ')';
                        document.getElementById("lab_tuesday31").innerHTML = '(' + res[2] + ')';
                        document.getElementById("lab_wednesday31").innerHTML = '(' + res[3] + ')';
                        document.getElementById("lab_thursday31").innerHTML = '(' + res[4] + ')';
                        document.getElementById("lab_friday31").innerHTML = '(' + res[5] + ')';
                        document.getElementById("lab_saturday31").innerHTML = '(' + res[6] + ')';
                        document.getElementById("lab_sunday31").innerHTML = '(' + res[7] + ')';

                        document.getElementById("lab_monday32").innerHTML = '(' + res[1] + ')';
                        document.getElementById("lab_tuesday32").innerHTML = '(' + res[2] + ')';
                        document.getElementById("lab_wednesday32").innerHTML = '(' + res[3] + ')';
                        document.getElementById("lab_thursday32").innerHTML = '(' + res[4] + ')';
                        document.getElementById("lab_friday32").innerHTML = '(' + res[5] + ')';
                        document.getElementById("lab_saturday32").innerHTML = '(' + res[6] + ')';
                        document.getElementById("lab_sunday32").innerHTML = '(' + res[7] + ')';






                        create_jobno31('monday', '<?= $_GET['companycode'] ?>', res[1]);
                        create_jobno31('tuesday', '<?= $_GET['companycode'] ?>', res[2]);
                        create_jobno31('wednesday', '<?= $_GET['companycode'] ?>', res[3]);
                        create_jobno31('thursday', '<?= $_GET['companycode'] ?>', res[4]);
                        create_jobno31('friday', '<?= $_GET['companycode'] ?>', res[5]);
                        create_jobno31('saturday', '<?= $_GET['companycode'] ?>', res[6]);
                        create_jobno31('sunday', '<?= $_GET['companycode'] ?>', res[7]);

                        create_jobno32('monday', '<?= $_GET['companycode'] ?>', res[1]);
                        create_jobno32('tuesday', '<?= $_GET['companycode'] ?>', res[2]);
                        create_jobno32('wednesday', '<?= $_GET['companycode'] ?>', res[3]);
                        create_jobno32('thursday', '<?= $_GET['companycode'] ?>', res[4]);
                        create_jobno32('friday', '<?= $_GET['companycode'] ?>', res[5]);
                        create_jobno32('saturday', '<?= $_GET['companycode'] ?>', res[6]);
                        create_jobno32('sunday', '<?= $_GET['companycode'] ?>', res[7]);
                    }
                });
            }
            function create_jobno21(typeday, companycode, jobdate)
            {

                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "create_jobno", companycode: companycode, jobdate: jobdate
                    },
                    success: function (rs) {
                        if (typeday == 'monday')
                        {
                            document.getElementById("txt_copydiagramjobnomonday21").value = rs;

                        }
                        if (typeday == 'tuesday')
                        {
                            document.getElementById("txt_copydiagramjobnotuesday21").value = rs;

                        }
                        if (typeday == 'wednesday')
                        {
                            document.getElementById("txt_copydiagramjobnowednesday21").value = rs;

                        }
                        if (typeday == 'thursday')
                        {
                            document.getElementById("txt_copydiagramjobnothursday21").value = rs;

                        }
                        if (typeday == 'friday')
                        {
                            document.getElementById("txt_copydiagramjobnofriday21").value = rs;

                        }
                        if (typeday == 'saturday')
                        {
                            document.getElementById("txt_copydiagramjobnosaturday21").value = rs;

                        }
                        if (typeday == 'sunday')
                        {
                            document.getElementById("txt_copydiagramjobnosunday21").value = rs;

                        }
                    }
                });
            }
            function create_jobno22(typeday, companycode, jobdate)
            {

                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "create_jobno", companycode: companycode, jobdate: jobdate
                    },
                    success: function (rs) {
                        if (typeday == 'monday')
                        {
                            document.getElementById("txt_copydiagramjobnomonday22").value = rs;

                        }
                        if (typeday == 'tuesday')
                        {
                            document.getElementById("txt_copydiagramjobnotuesday22").value = rs;

                        }
                        if (typeday == 'wednesday')
                        {
                            document.getElementById("txt_copydiagramjobnowednesday22").value = rs;

                        }
                        if (typeday == 'thursday')
                        {
                            document.getElementById("txt_copydiagramjobnothursday22").value = rs;

                        }
                        if (typeday == 'friday')
                        {
                            document.getElementById("txt_copydiagramjobnofriday22").value = rs;

                        }
                        if (typeday == 'saturday')
                        {
                            document.getElementById("txt_copydiagramjobnosaturday22").value = rs;

                        }
                        if (typeday == 'sunday')
                        {
                            document.getElementById("txt_copydiagramjobnosunday22").value = rs;

                        }
                    }
                });
            }
            function create_jobno31(typeday, companycode, jobdate)
            {

                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "create_jobno", companycode: companycode, jobdate: jobdate
                    },
                    success: function (rs) {
                        if (typeday == 'monday')
                        {
                            document.getElementById("txt_copydiagramjobnomonday31").value = rs;

                        }
                        if (typeday == 'tuesday')
                        {
                            document.getElementById("txt_copydiagramjobnotuesday31").value = rs;

                        }
                        if (typeday == 'wednesday')
                        {
                            document.getElementById("txt_copydiagramjobnowednesday31").value = rs;

                        }
                        if (typeday == 'thursday')
                        {
                            document.getElementById("txt_copydiagramjobnothursday31").value = rs;

                        }
                        if (typeday == 'friday')
                        {
                            document.getElementById("txt_copydiagramjobnofriday31").value = rs;

                        }
                        if (typeday == 'saturday')
                        {
                            document.getElementById("txt_copydiagramjobnosaturday31").value = rs;

                        }
                        if (typeday == 'sunday')
                        {
                            document.getElementById("txt_copydiagramjobnosunday31").value = rs;

                        }
                    }
                });
            }
            function create_jobno32(typeday, companycode, jobdate)
            {

                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "create_jobno", companycode: companycode, jobdate: jobdate
                    },
                    success: function (rs) {
                        if (typeday == 'monday')
                        {
                            document.getElementById("txt_copydiagramjobnomonday32").value = rs;

                        }
                        if (typeday == 'tuesday')
                        {
                            document.getElementById("txt_copydiagramjobnotuesday32").value = rs;

                        }
                        if (typeday == 'wednesday')
                        {
                            document.getElementById("txt_copydiagramjobnowednesday32").value = rs;

                        }
                        if (typeday == 'thursday')
                        {
                            document.getElementById("txt_copydiagramjobnothursday32").value = rs;

                        }
                        if (typeday == 'friday')
                        {
                            document.getElementById("txt_copydiagramjobnofriday32").value = rs;

                        }
                        if (typeday == 'saturday')
                        {
                            document.getElementById("txt_copydiagramjobnosaturday32").value = rs;

                        }
                        if (typeday == 'sunday')
                        {
                            document.getElementById("txt_copydiagramjobnosunday32").value = rs;

                        }
                    }
                });
            }
            function create_jobno(typeday, companycode, jobdate)
            {

                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "create_jobno", companycode: companycode, jobdate: jobdate
                    },
                    success: function (rs) {
                        if (typeday == 'monday')
                        {
                            document.getElementById("txt_copydiagramjobnomonday").value = rs;

                        }
                        if (typeday == 'tuesday')
                        {
                            document.getElementById("txt_copydiagramjobnotuesday").value = rs;

                        }
                        if (typeday == 'wednesday')
                        {
                            document.getElementById("txt_copydiagramjobnowednesday").value = rs;

                        }
                        if (typeday == 'thursday')
                        {
                            document.getElementById("txt_copydiagramjobnothursday").value = rs;

                        }
                        if (typeday == 'friday')
                        {
                            document.getElementById("txt_copydiagramjobnofriday").value = rs;

                        }
                        if (typeday == 'saturday')
                        {
                            document.getElementById("txt_copydiagramjobnosaturday").value = rs;

                        }
                        if (typeday == 'sunday')
                        {
                            document.getElementById("txt_copydiagramjobnosunday").value = rs;

                        }
                    }
                });
            }


            function checknull_copydiagram(vehicletransportplanid)
            {
                if (vehicletransportplanid == '')
                {


                    if ('<?= $_GET['worktype'] ?>' == 'sh')
                    {
                        if (document.getElementById("txt_copydiagramdatestart").value == "")
                        {
                            alert("วันที่เริ่มต้น เป็นค่าว่าง !!!");
                            return false;
                        } else if (document.getElementById("txt_copydiagramemployeename1").value == "")
                        {
                            alert("พนักงาน (1) เป็นค่าว่าง !!!");
                            return false;
                        } else if (document.getElementById("txt_copydiagramthainame").value == "")
                        {
                            alert("ชื่อรถ เป็นค่าว่าง !!!");
                            return false;
                        } else if (document.getElementById("txt_copydiagramjobstart").value == "")
                        {
                            alert("ต้นทาง(SH1) เป็นค่าว่าง !!!");
                            return false;
                        } else if (document.getElementById("txt_copydiagramroute").value == "")
                        {
                            alert("งาน(SH1) เป็นค่าว่าง !!!");
                            return false;
                        } else if (document.getElementById("txt_copydiagramsubroute").value == "")
                        {
                            alert("งานย่อย(SH1) เป็นค่าว่าง !!!");
                            return false;
                        } else if (document.getElementById("cb_copydiagramload").value == "")
                        {
                            alert("จำนวนโหลด เป็นค่าว่าง !!!");
                            return false;
                        // } else if (document.getElementById("txt_roundamount").value == "")
                        // {
                        //     alert("รอบที่วิ่งงาน เป็นค่าว่าง !!!");
                        //     return false;
                        } else
                        {
                            return true;
                        }
                    } else if ('<?= $_GET['worktype'] ?>' == 'nm')
                    {
                        if (document.getElementById("txt_copydiagramdatestart").value == "")
                        {
                            alert("วันที่เริ่มต้น เป็นค่าว่าง !!!");
                            return false;
                        } else if (document.getElementById("txt_copydiagramemployeename1").value == "")
                        {
                            alert("พนักงาน (1) เป็นค่าว่าง !!!");
                            return false;
                        } else if (document.getElementById("txt_copydiagramthainame").value == "")
                        {
                            alert("ชื่อรถ เป็นค่าว่าง !!!");
                            return false;
                        } else if (document.getElementById("txt_copydiagramjobstart11").value == "")
                        {
                            alert("ต้นทาง(Normal1) เป็นค่าว่าง !!!");
                            return false;
                        } else if (document.getElementById("txt_copydiagramcluster").value == "")
                        {
                            alert("CLUSTER(Normal1) เป็นค่าว่าง !!!");
                            return false;
                        } else if (document.getElementById("txt_copydiagramjobend").value == "")
                        {
                            alert("ปลายทาง(Normal1) เป็นค่าว่าง !!!");
                            return false;
                        // } else if (document.getElementById("txt_roundamount").value == "")
                        // {
                        //     alert("รอบที่วิ่งงาน เป็นค่าว่าง !!!");
                        //     return false;
                        } else
                        {
                            return true;
                        }
                    }



                } else
                {
                    return true;
                }
            }
            function checknull_copydiagramnn()
            {

                if (document.getElementById("txt_copydiagramdatestartnn").value == "")
                {
                    alert("วันที่เริ่มต้น เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("txt_copydiagramemployeename21_1").value == "")
                {
                    alert("พนักงาน (1) เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("txt_copydiagramthainame21_1").value == "")
                {
                    alert("ชื่อรถ เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("txt_copydiagramemployeename22_1").value == "")
                {
                    alert("พนักงาน (1) เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("txt_copydiagramthainame22_1").value == "")
                {
                    alert("ชื่อรถ เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("txt_copydiagramjobstart21").value == "")
                {
                    alert("ต้นทาง(Normal11) เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("txt_copydiagramjobstart22").value == "")
                {
                    alert("ต้นทาง(Normal12) เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("cb_copydiagramcluster21").value == "")
                {
                    alert("CLUSTER(Normal11) เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("cb_copydiagramcluster22").value == "")
                {
                    alert("CLUSTER(Normal12) เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("txt_copydiagramjobend21").value == "")
                {
                    alert("ปลายทาง(Normal11) เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("txt_copydiagramjobend22").value == "")
                {
                    alert("ปลายทาง(Normal12) เป็นค่าว่าง !!!");
                    return false;
                // } else if (document.getElementById("txt_roundamount21").value == "")
                // {
                //     alert("รอบที่วิ่งงาน เป็นค่าว่าง !!!");
                //     return false;
                } else
                {
                    return true;
                }

            }
            function checknull_copydiagramsh()
            {

                if (document.getElementById("txt_copydiagramdatestartshsh").value == "")
                {
                    alert("วันที่เริ่มต้น เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("txt_copydiagramemployeename21_1sh").value == "")
                {
                    alert("พนักงาน (1) เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("txt_copydiagramemployeename22_1sh").value == "")
                {
                    alert("พนักงาน (1) เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("txt_copydiagramthainame21_1sh").value == "")
                {
                    alert("ชื่อรถ เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("txt_copydiagramthainame22_1sh").value == "")
                {
                    alert("ชื่อรถ เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("txt_copydiagramjobstart21_sh").value == "")
                {
                    alert("ต้นทาง(SH1) เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("txt_copydiagramjobstart21_sh").value == "")
                {
                    alert("ต้นทาง(SH1) เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("cb_copydiagramroute21_sh").value == "")
                {
                    alert("งาน(SH1) เป็นค่าว่าง !!!");
                    return false;

                } else if (document.getElementById("cb_copydiagramroute22_sh").value == "")
                {
                    alert("งาน(SH1) เป็นค่าว่าง !!!");
                    return false;



                } else if (document.getElementById("txt_copydiagramsubroute21_sh").value == "")
                {
                    alert("งานย่อย(SH1) เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("txt_copydiagramsubroute22_sh").value == "")
                {
                    alert("งานย่อย(SH1) เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("cb_copydiagramload21_sh").value == "")
                {
                    alert("จำนวนโหลด เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("cb_copydiagramload22_sh").value == "")
                {
                    alert("จำนวนโหลด เป็นค่าว่าง !!!");
                    return false;
                // } else if (document.getElementById("txt_roundamount21_sh").value == "")
                // {
                //     alert("รอบที่วิ่งงาน เป็นค่าว่าง !!!");
                //     return false;
                } else
                {
                    return true;
                }







            }
            function checknull_copydiagramshn()
            {

                if (document.getElementById("txt_copydiagramdatestartshn").value == "")
                {
                    alert("วันที่เริ่มต้น เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("txt_copydiagramemployeename1shn").value == "")
                {
                    alert("พนักงาน (1) เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("txt_copydiagramemployeename1shn").value == "")
                {
                    alert("พนักงาน (2) เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("txt_copydiagramjobstartshn").value == "")
                {
                    alert("ต้นทาง  เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("txt_copydiagramrouteshn").value == "")
                {
                    alert("งานSH(N) เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("txt_copydiagramsubrouteshn").value == "")
                {
                    alert("งาน(ย่อย)SH(N) เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("cb_copydiagramloadshn").value == "")
                {
                    alert("จำนวนโหลด เป็นค่าว่าง !!!");
                    return false;
                // } else if (document.getElementById("txt_roundamountshn").value == "")
                // {
                //     alert("รอบที่วิ่งงาน เป็นค่าว่าง !!!");
                //     return false;
                } else
                {
                    return true;
                }

            }
            function checknull_copydiagramns()
            {

                if (document.getElementById("txt_copydiagramdatestartns").value == "")
                {
                    alert("วันที่เริ่มต้น เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("txt_copydiagramemployeename31_1").value == "")
                {
                    alert("พนักงาน (1) เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("txt_copydiagramthainame31_1").value == "")
                {
                    alert("ชื่อรถ เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("txt_copydiagramemployeename32_1").value == "")
                {
                    alert("พนักงาน (1) เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("txt_copydiagramthainame32_1").value == "")
                {
                    alert("ชื่อรถ เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("txt_copydiagramjobstart31").value == "")
                {
                    alert("ต้นทาง(NM/SH(1))  เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("txt_copydiagramjobstart32").value == "")
                {
                    alert("ต้นทาง(NM/SH(2))  เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("txt_copydiagramcluster31").value == "")
                {
                    alert("CLUSTER(NM/SH(1)) เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("txt_copydiagramroute32").value == "")
                {
                    alert("งาน(NM/SH(2)) เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("txt_copydiagramjobend31").value == "")
                {
                    alert("ปลายทาง(NM/SH(1)) เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("txt_copydiagramsubroute32").value == "")
                {
                    alert("งานย่อย(NM/SH(2)) เป็นค่าว่าง !!!");
                    return false;
                } else if (document.getElementById("cb_copydiagramload32").value == "")
                {
                    alert("จำนวนโหลด(NM/SH(2)) เป็นค่าว่าง !!!");
                    return false;
                // } else if (document.getElementById("txt_roundamount31").value == "")
                // {
                //     alert("รอบที่วิ่งงาน เป็นค่าว่าง !!!");
                //     return false;
                } else
                {
                    return true;
                }

            }

            function update_copydiagram(ID, fieldname, editableObj)
            {


                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "edit_vehicletransportplan",
                        ID: ID,
                        fieldname: fieldname,
                        editableObj: editableObj
                    },
                    success: function () {


                    }
                });
            }
            function save_copydiagramns()
            {


                /////start n1/////
                var dateworking_31 = "";
                var daterk_31 = "";
                var datevlin_31 = "";
                var datevlout_31 = "";
                var dealerin_31 = "";
                var datereturn_31 = "";
                var vehicletype_31 = "";
                var materialtype_31 = "";
                var employeename1_31 = "";
                var employeename2_31 = "";
                var employeename3_31 = "";
                var thainame_31 = "";
                var goreturn_31 = "";
                var load_31 = "";
                var route_31 = "";
                var cluster_31 = "";
                var jobstart_31 = "";
                var jobend_31 = "";
                var copydiagramunit_31 = "";
                var roundamount_31 = document.getElementById("txt_roundamount31").value;
                var dn_31 = "";
                var billing_31 = "";
                var vehicletransportplanid_31 = "";

                var copydiagramdatestart_31 = document.getElementById("txt_copydiagramdatestartns").value;
                var copydiagramdateend_31 = document.getElementById("txt_copydiagramdateendns").value;
                copydiagramunit_31 = document.getElementById("txt_copydiagramunit31").value;

                employeename1_31 = document.getElementById("txt_copydiagramemployeename31_1").value;
                employeename2_31 = document.getElementById("txt_copydiagramemployeename31_2").value;
                employeename3_31 = document.getElementById("txt_copydiagramemployeename31_3").value;


                thainame_31 = document.getElementById("txt_copydiagramthainame31_1").value;
                if (chk_copydiagramdaterk31.checked == true) {
                    daterk_31 = document.getElementById("txt_copydiagramdaterk231").value;

                } else
                {
                    daterk_31 = document.getElementById("txt_copydiagramdaterk31").value;

                }
                if (chk_copydiagramdatevlin31.checked == true) {
                    datevlin_31 = document.getElementById("txt_copydiagramdatevlin231").value;

                } else
                {
                    datevlin_31 = document.getElementById("txt_copydiagramdatevlin31").value;

                }
                if (chk_copydiagramdatevlout31.checked == true) {
                    datevlout_31 = document.getElementById("txt_copydiagramdatevlout231").value;

                } else
                {
                    datevlout_31 = document.getElementById("txt_copydiagramdatevlout31").value;

                }
                if (chk_copydiagramdatedealerin31.checked == true) {
                    dealerin_31 = document.getElementById("txt_copydiagramdatedealerin231").value;

                } else
                {
                    dealerin_31 = document.getElementById("txt_copydiagramdatedealerin31").value;

                }
                if (chk_copydiagramdatereturn31.checked == true) {
                    datereturn_31 = document.getElementById("txt_copydiagramdatereturn231").value;

                } else
                {
                    datereturn_31 = document.getElementById("txt_copydiagramdatereturn31").value;

                }


                cluster_31 = document.getElementById("txt_copydiagramcluster31").value;
                //jobstart_31 = document.getElementById("txt_copydiagramjobstart31").value;
                jobstart_31 = $('#txt_copydiagramjobstart31').val().toString();
                jobend_31 = document.getElementById("txt_copydiagramjobend31").value;




                var dateinput_31 = document.getElementById("txt_copydiagramdateinput31").value;
                var datepresent_31 = document.getElementById("txt_copydiagramdatepresent31").value;




                if (checknull_copydiagramns()) {

                    dateworking_31 = document.getElementById("txt_copydiagramdaterk31").value;

                    if (chk_copydiagrammonday31.checked == true) {




                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid_31,
                                STARTDATE: copydiagramdatestart_31,
                                ENDDATE: copydiagramdateend_31,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame_31,
                                JOBSTART: jobstart_31,
                                CLUSTER: cluster_31,
                                JOBEND: jobend_31,
                                EMPLOYEENAME1: employeename1_31,
                                EMPLOYEENAME2: employeename2_31,
                                EMPLOYEENAME3: employeename3_31,
                                JOBNO: document.getElementById("txt_copydiagramjobnomonday31").value,
                                DATEINPUT: dateinput_31,
                                DATERK: daterk_31,
                                DATEPRESENT: datepresent_31,
                                DATEWORKING: daterk_31,
                                DATEVLIN: datevlin_31,
                                DATEVLOUT: datevlout_31,
                                DATEDEALERIN: dealerin_31,
                                DATERETURN: datereturn_31,
                                VEHICLETYPE: vehicletype_31,
                                MATERIALTYPE: materialtype_31,
                                GORETURN: goreturn_31,
                                WORKTYPE: 'nm',
                                LOAD: load_31,
                                ROUTE: route_31,
                                UNIT: copydiagramunit_31,
                                ROUNDAMOUNT: roundamount_31,
                                DN: dn_31,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame31_2").value,
                                BILLING: billing_31,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'
                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Monday Planing', '<?= $result_seLogin['PersonCode'] ?>');
                            }
                        });
                    }

                    if (chk_copydiagramtuesday31.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid_31,
                                STARTDATE: copydiagramdatestart_31,
                                ENDDATE: copydiagramdateend_31,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame_31,
                                JOBSTART: jobstart_31,
                                CLUSTER: cluster_31,
                                JOBEND: jobend_31,
                                EMPLOYEENAME1: employeename1_31,
                                EMPLOYEENAME2: employeename2_31,
                                EMPLOYEENAME3: employeename3_31,
                                JOBNO: document.getElementById("txt_copydiagramjobnotuesday31").value,
                                DATEINPUT: dateinput_31,
                                DATERK: daterk_31,
                                DATEPRESENT: datepresent_31,
                                DATEWORKING: daterk_31,
                                DATEVLIN: datevlin_31,
                                DATEVLOUT: datevlout_31,
                                DATEDEALERIN: dealerin_31,
                                DATERETURN: datereturn_31,
                                VEHICLETYPE: vehicletype_31,
                                MATERIALTYPE: materialtype_31,
                                GORETURN: goreturn_31,
                                WORKTYPE: 'nm',
                                LOAD: load_31,
                                ROUTE: route_31,
                                UNIT: copydiagramunit_31,
                                ROUNDAMOUNT: roundamount_31,
                                DN: dn_31,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame31_2").value,
                                BILLING: billing_31,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {

                                save_logprocess('Planing', 'Save Tuesday Planing', '<?= $result_seLogin['PersonCode'] ?>');
                            }
                        });
                    }
                    if (chk_copydiagramwednesday31.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid_31,
                                STARTDATE: copydiagramdatestart_31,
                                ENDDATE: copydiagramdateend_31,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame_31,
                                JOBSTART: jobstart_31,
                                CLUSTER: cluster_31,
                                JOBEND: jobend_31,
                                EMPLOYEENAME1: employeename1_31,
                                EMPLOYEENAME2: employeename2_31,
                                EMPLOYEENAME3: employeename3_31,
                                JOBNO: document.getElementById("txt_copydiagramjobnowednesday31").value,
                                DATEINPUT: dateinput_31,
                                DATERK: daterk_31,
                                DATEPRESENT: datepresent_31,
                                DATEWORKING: daterk_31,
                                DATEVLIN: datevlin_31,
                                DATEVLOUT: datevlout_31,
                                DATEDEALERIN: dealerin_31,
                                DATERETURN: datereturn_31,
                                VEHICLETYPE: vehicletype_31,
                                MATERIALTYPE: materialtype_31,
                                GORETURN: goreturn_31,
                                WORKTYPE: 'nm',
                                LOAD: load_31,
                                ROUTE: route_31,
                                UNIT: copydiagramunit_31,
                                ROUNDAMOUNT: roundamount_31,
                                DN: dn_31,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame31_2").value,
                                BILLING: billing_31,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {

                                save_logprocess('Planing', 'Save Wednesday Planing', '<?= $result_seLogin['PersonCode'] ?>');
                            }
                        });
                    }
                    if (chk_copydiagramthursday31.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid_31,
                                STARTDATE: copydiagramdatestart_31,
                                ENDDATE: copydiagramdateend_31,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame_31,
                                JOBSTART: jobstart_31,
                                CLUSTER: cluster_31,
                                JOBEND: jobend_31,
                                EMPLOYEENAME1: employeename1_31,
                                EMPLOYEENAME2: employeename2_31,
                                EMPLOYEENAME3: employeename3_31,
                                JOBNO: document.getElementById("txt_copydiagramjobnothursday31").value,
                                DATEINPUT: dateinput_31,
                                DATERK: daterk_31,
                                DATEPRESENT: datepresent_31,
                                DATEWORKING: daterk_31,
                                DATEVLIN: datevlin_31,
                                DATEVLOUT: datevlout_31,
                                DATEDEALERIN: dealerin_31,
                                DATERETURN: datereturn_31,
                                VEHICLETYPE: vehicletype_31,
                                MATERIALTYPE: materialtype_31,
                                GORETURN: goreturn_31,
                                WORKTYPE: 'nm',
                                LOAD: load_31,
                                ROUTE: route_31,
                                UNIT: copydiagramunit_31,
                                ROUNDAMOUNT: roundamount_31,
                                DN: dn_31,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame31_2").value,
                                BILLING: billing_31,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Thursday Planing', '<?= $result_seLogin['PersonCode'] ?>');

                            }
                        });
                    }
                    if (chk_copydiagramfriday31.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid_31,
                                STARTDATE: copydiagramdatestart_31,
                                ENDDATE: copydiagramdateend_31,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame_31,
                                JOBSTART: jobstart_31,
                                CLUSTER: cluster_31,
                                JOBEND: jobend_31,
                                EMPLOYEENAME1: employeename1_31,
                                EMPLOYEENAME2: employeename2_31,
                                EMPLOYEENAME3: employeename3_31,
                                JOBNO: document.getElementById("txt_copydiagramjobnofriday31").value,
                                DATEINPUT: dateinput_31,
                                DATERK: daterk_31,
                                DATEPRESENT: datepresent_31,
                                DATEWORKING: daterk_31,
                                DATEVLIN: datevlin_31,
                                DATEVLOUT: datevlout_31,
                                DATEDEALERIN: dealerin_31,
                                DATERETURN: datereturn_31,
                                VEHICLETYPE: vehicletype_31,
                                MATERIALTYPE: materialtype_31,
                                GORETURN: goreturn_31,
                                WORKTYPE: 'nm',
                                LOAD: load_31,
                                ROUTE: route_31,
                                UNIT: copydiagramunit_31,
                                ROUNDAMOUNT: roundamount_31,
                                DN: dn_31,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame31_2").value,
                                BILLING: billing_31,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {

                                save_logprocess('Planing', 'Save Friday Planing', '<?= $result_seLogin['PersonCode'] ?>');

                            }
                        });
                    }
                    if (chk_copydiagramsaturday31.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid_31,
                                STARTDATE: copydiagramdatestart_31,
                                ENDDATE: copydiagramdateend_31,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame_31,
                                JOBSTART: jobstart_31,
                                CLUSTER: cluster_31,
                                JOBEND: jobend_31,
                                EMPLOYEENAME1: employeename1_31,
                                EMPLOYEENAME2: employeename2_31,
                                EMPLOYEENAME3: employeename3_31,
                                JOBNO: document.getElementById("txt_copydiagramjobnosaturday31").value,
                                DATEINPUT: dateinput_31,
                                DATERK: daterk_31,
                                DATEPRESENT: datepresent_31,
                                DATEWORKING: daterk_31,
                                DATEVLIN: datevlin_31,
                                DATEVLOUT: datevlout_31,
                                DATEDEALERIN: dealerin_31,
                                DATERETURN: datereturn_31,
                                VEHICLETYPE: vehicletype_31,
                                MATERIALTYPE: materialtype_31,
                                GORETURN: goreturn_31,
                                WORKTYPE: 'nm',
                                LOAD: load_31,
                                ROUTE: route_31,
                                UNIT: copydiagramunit_31,
                                ROUNDAMOUNT: roundamount_31,
                                DN: dn_31,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame31_2").value,
                                BILLING: billing_31,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Saturday Planing', '<?= $result_seLogin['PersonCode'] ?>');

                            }
                        });
                    }
                    if (chk_copydiagramsunday31.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid_31,
                                STARTDATE: copydiagramdatestart_31,
                                ENDDATE: copydiagramdateend_31,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame_31,
                                JOBSTART: jobstart_31,
                                CLUSTER: cluster_31,
                                JOBEND: jobend_31,
                                EMPLOYEENAME1: employeename1_31,
                                EMPLOYEENAME2: employeename2_31,
                                EMPLOYEENAME3: employeename3_31,
                                JOBNO: document.getElementById("txt_copydiagramjobnosunday31").value,
                                DATEINPUT: dateinput_31,
                                DATERK: daterk_31,
                                DATEPRESENT: datepresent_31,
                                DATEWORKING: daterk_31,
                                DATEVLIN: datevlin_31,
                                DATEVLOUT: datevlout_31,
                                DATEDEALERIN: dealerin_31,
                                DATERETURN: datereturn_31,
                                VEHICLETYPE: vehicletype_31,
                                MATERIALTYPE: materialtype_31,
                                GORETURN: goreturn_31,
                                WORKTYPE: 'nm',
                                LOAD: load_31,
                                ROUTE: route_31,
                                UNIT: copydiagramunit_31,
                                ROUNDAMOUNT: roundamount_31,
                                DN: dn_31,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame31_2").value,
                                BILLING: billing_31,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Sunday Planing', '<?= $result_seLogin['PersonCode'] ?>');

                            }
                        });
                    }

                    alert('บันทึกข้อมูล JOB1 เรียบร้อย');


                    /////end n1/////
                    /////start n2/////
                    var dateworking_32 = "";
                    var daterk_32 = "";
                    var datevlin_32 = "";
                    var datevlout_32 = "";
                    var dealerin_32 = "";
                    var datereturn_32 = "";
                    var vehicletype_32 = "";
                    var materialtype_32 = "";
                    var employeename1_32 = "";
                    var employeename2_32 = "";
                    var employeename3_32 = "";
                    var thainame_32 = "";
                    var goreturn_32 = "";
                    var load_32 = "";
                    var route_32 = "";
                    var cluster_32 = "";
                    var jobstart_32 = "";
                    var jobend_32 = "";
                    var copydiagramunit_32 = "";
                    var roundamount_32 = document.getElementById("txt_roundamount32").value;
                    var dn_32 = "";
                    var billing_32 = "";
                    var vehicletransportplanid_32 = "";

                    var copydiagramdatestart_32 = document.getElementById("txt_copydiagramdatestartns").value;
                    var copydiagramdateend_32 = document.getElementById("txt_copydiagramdateendns").value;
                    copydiagramunit_32 = document.getElementById("txt_copydiagramunit32").value;

                    employeename1_32 = document.getElementById("txt_copydiagramemployeename32_1").value;
                    employeename2_32 = document.getElementById("txt_copydiagramemployeename32_2").value;
                    employeename3_32 = document.getElementById("txt_copydiagramemployeename32_3").value;


                    thainame_32 = document.getElementById("txt_copydiagramthainame32_1").value;
                    if (chk_copydiagramdaterk32.checked == true) {
                        daterk_32 = document.getElementById("txt_copydiagramdaterk232").value;

                    } else
                    {
                        daterk_32 = document.getElementById("txt_copydiagramdaterk32").value;

                    }
                    if (chk_copydiagramdatevlin32.checked == true) {
                        datevlin_32 = document.getElementById("txt_copydiagramdatevlin232").value;

                    } else
                    {
                        datevlin_32 = document.getElementById("txt_copydiagramdatevlin32").value;

                    }
                    if (chk_copydiagramdatevlout32.checked == true) {
                        datevlout_32 = document.getElementById("txt_copydiagramdatevlout232").value;

                    } else
                    {
                        datevlout_32 = document.getElementById("txt_copydiagramdatevlout32").value;

                    }
                    if (chk_copydiagramdatedealerin32.checked == true) {
                        dealerin_32 = document.getElementById("txt_copydiagramdatedealerin232").value;

                    } else
                    {
                        dealerin_32 = document.getElementById("txt_copydiagramdatedealerin32").value;

                    }
                    if (chk_copydiagramdatereturn32.checked == true) {
                        datereturn_32 = document.getElementById("txt_copydiagramdatereturn232").value;

                    } else
                    {
                        datereturn_32 = document.getElementById("txt_copydiagramdatereturn32").value;

                    }


                    load_32 = document.getElementById("cb_copydiagramload32").value;
                    route_32 = document.getElementById("cb_copydiagramroute32").value;

                    jobstart_32 = document.getElementById("txt_copydiagramjobstart32").value;
                    //jobend = document.getElementById("txt_copydiagramroute").value;
                    jobend_32 = document.getElementById("txt_copydiagramsubroute32").value;

                    var dateinput_32 = document.getElementById("txt_copydiagramdateinput32").value;
                    var datepresent_32 = document.getElementById("txt_copydiagramdatepresent32").value;

                    if (chk_copydiagrammonday32.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid_32,
                                STARTDATE: copydiagramdatestart_32,
                                ENDDATE: copydiagramdateend_32,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame_32,
                                JOBSTART: jobstart_32,
                                CLUSTER: cluster_32,
                                JOBEND: jobend_32,
                                EMPLOYEENAME1: employeename1_32,
                                EMPLOYEENAME2: employeename2_32,
                                EMPLOYEENAME3: employeename3_32,
                                JOBNO: document.getElementById("txt_copydiagramjobnomonday32").value,
                                DATEINPUT: dateinput_32,
                                DATERK: daterk_32,
                                DATEPRESENT: datepresent_32,
                                DATEWORKING: daterk_32,
                                DATEVLIN: datevlin_32,
                                DATEVLOUT: datevlout_32,
                                DATEDEALERIN: dealerin_32,
                                DATERETURN: datereturn_32,
                                VEHICLETYPE: vehicletype_32,
                                MATERIALTYPE: materialtype_32,
                                GORETURN: goreturn_32,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load_32,
                                ROUTE: route_32,
                                UNIT: copydiagramunit_32,
                                ROUNDAMOUNT: roundamount_32,
                                DN: dn_32,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame32_2").value,
                                BILLING: billing_32,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'
                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Monday Planing', '<?= $result_seLogin['PersonCode'] ?>');
                            }
                        });
                    }
                    if (chk_copydiagramtuesday32.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid_32,
                                STARTDATE: copydiagramdatestart_32,
                                ENDDATE: copydiagramdateend_32,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame_32,
                                JOBSTART: jobstart_32,
                                CLUSTER: cluster_32,
                                JOBEND: jobend_32,
                                EMPLOYEENAME1: employeename1_32,
                                EMPLOYEENAME2: employeename2_32,
                                EMPLOYEENAME3: employeename3_32,
                                JOBNO: document.getElementById("txt_copydiagramjobnotuesday32").value,
                                DATEINPUT: dateinput_32,
                                DATERK: daterk_32,
                                DATEPRESENT: datepresent_32,
                                DATEWORKING: daterk_32,
                                DATEVLIN: datevlin_32,
                                DATEVLOUT: datevlout_32,
                                DATEDEALERIN: dealerin_32,
                                DATERETURN: datereturn_32,
                                VEHICLETYPE: vehicletype_32,
                                MATERIALTYPE: materialtype_32,
                                GORETURN: goreturn_32,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load_32,
                                ROUTE: route_32,
                                UNIT: copydiagramunit_32,
                                ROUNDAMOUNT: roundamount_32,
                                DN: dn_32,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame32_2").value,
                                BILLING: billing_32,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Tuesday Planing', '<?= $result_seLogin['PersonCode'] ?>');

                            }
                        });
                    }
                    if (chk_copydiagramwednesday32.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid_32,
                                STARTDATE: copydiagramdatestart_32,
                                ENDDATE: copydiagramdateend_32,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame_32,
                                JOBSTART: jobstart_32,
                                CLUSTER: cluster_32,
                                JOBEND: jobend_32,
                                EMPLOYEENAME1: employeename1_32,
                                EMPLOYEENAME2: employeename2_32,
                                EMPLOYEENAME3: employeename3_32,
                                JOBNO: document.getElementById("txt_copydiagramjobnowednesday32").value,
                                DATEINPUT: dateinput_32,
                                DATERK: daterk_32,
                                DATEPRESENT: datepresent_32,
                                DATEWORKING: daterk_32,
                                DATEVLIN: datevlin_32,
                                DATEVLOUT: datevlout_32,
                                DATEDEALERIN: dealerin_32,
                                DATERETURN: datereturn_32,
                                VEHICLETYPE: vehicletype_32,
                                MATERIALTYPE: materialtype_32,
                                GORETURN: goreturn_32,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load_32,
                                ROUTE: route_32,
                                UNIT: copydiagramunit_32,
                                ROUNDAMOUNT: roundamount_32,
                                DN: dn_32,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame32_2").value,
                                BILLING: billing_32,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Wednesday Planing', '<?= $result_seLogin['PersonCode'] ?>');

                            }
                        });
                    }
                    if (chk_copydiagramthursday32.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid_32,
                                STARTDATE: copydiagramdatestart_32,
                                ENDDATE: copydiagramdateend_32,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame_32,
                                JOBSTART: jobstart_32,
                                CLUSTER: cluster_32,
                                JOBEND: jobend_32,
                                EMPLOYEENAME1: employeename1_32,
                                EMPLOYEENAME2: employeename2_32,
                                EMPLOYEENAME3: employeename3_32,
                                JOBNO: document.getElementById("txt_copydiagramjobnothursday32").value,
                                DATEINPUT: dateinput_32,
                                DATERK: daterk_32,
                                DATEPRESENT: datepresent_32,
                                DATEWORKING: daterk_32,
                                DATEVLIN: datevlin_32,
                                DATEVLOUT: datevlout_32,
                                DATEDEALERIN: dealerin_32,
                                DATERETURN: datereturn_32,
                                VEHICLETYPE: vehicletype_32,
                                MATERIALTYPE: materialtype_32,
                                GORETURN: goreturn_32,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load_32,
                                ROUTE: route_32,
                                UNIT: copydiagramunit_32,
                                ROUNDAMOUNT: roundamount_32,
                                DN: dn_32,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame32_2").value,
                                BILLING: billing_32,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Thursday Planing', '<?= $result_seLogin['PersonCode'] ?>');

                            }
                        });
                    }
                    if (chk_copydiagramfriday32.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid_32,
                                STARTDATE: copydiagramdatestart_32,
                                ENDDATE: copydiagramdateend_32,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame_32,
                                JOBSTART: jobstart_32,
                                CLUSTER: cluster_32,
                                JOBEND: jobend_32,
                                EMPLOYEENAME1: employeename1_32,
                                EMPLOYEENAME2: employeename2_32,
                                EMPLOYEENAME3: employeename3_32,
                                JOBNO: document.getElementById("txt_copydiagramjobnofriday32").value,
                                DATEINPUT: dateinput_32,
                                DATERK: daterk_32,
                                DATEPRESENT: datepresent_32,
                                DATEWORKING: daterk_32,
                                DATEVLIN: datevlin_32,
                                DATEVLOUT: datevlout_32,
                                DATEDEALERIN: dealerin_32,
                                DATERETURN: datereturn_32,
                                VEHICLETYPE: vehicletype_32,
                                MATERIALTYPE: materialtype_32,
                                GORETURN: goreturn_32,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load_32,
                                ROUTE: route_32,
                                UNIT: copydiagramunit_32,
                                ROUNDAMOUNT: roundamount_32,
                                DN: dn_32,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame32_2").value,
                                BILLING: billing_32,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {

                                save_logprocess('Planing', 'Save Friday Planing', '<?= $result_seLogin['PersonCode'] ?>');

                            }
                        });
                    }
                    if (chk_copydiagramsaturday32.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid_32,
                                STARTDATE: copydiagramdatestart_32,
                                ENDDATE: copydiagramdateend_32,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame_32,
                                JOBSTART: jobstart_32,
                                CLUSTER: cluster_32,
                                JOBEND: jobend_32,
                                EMPLOYEENAME1: employeename1_32,
                                EMPLOYEENAME2: employeename2_32,
                                EMPLOYEENAME3: employeename3_32,
                                JOBNO: document.getElementById("txt_copydiagramjobnosaturday32").value,
                                DATEINPUT: dateinput_32,
                                DATERK: daterk_32,
                                DATEPRESENT: datepresent_32,
                                DATEWORKING: daterk_32,
                                DATEVLIN: datevlin_32,
                                DATEVLOUT: datevlout_32,
                                DATEDEALERIN: dealerin_32,
                                DATERETURN: datereturn_32,
                                VEHICLETYPE: vehicletype_32,
                                MATERIALTYPE: materialtype_32,
                                GORETURN: goreturn_32,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load_32,
                                ROUTE: route_32,
                                UNIT: copydiagramunit_32,
                                ROUNDAMOUNT: roundamount_32,
                                DN: dn_32,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame32_2").value,
                                BILLING: billing_32,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Saturday Planing', '<?= $result_seLogin['PersonCode'] ?>');

                            }
                        });
                    }
                    if (chk_copydiagramsunday32.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid_32,
                                STARTDATE: copydiagramdatestart_32,
                                ENDDATE: copydiagramdateend_32,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame_32,
                                JOBSTART: jobstart_32,
                                CLUSTER: cluster_32,
                                JOBEND: jobend_32,
                                EMPLOYEENAME1: employeename1_32,
                                EMPLOYEENAME2: employeename2_32,
                                EMPLOYEENAME3: employeename3_32,
                                JOBNO: document.getElementById("txt_copydiagramjobnosunday32").value,
                                DATEINPUT: dateinput_32,
                                DATERK: daterk_32,
                                DATEPRESENT: datepresent_32,
                                DATEWORKING: daterk_32,
                                DATEVLIN: datevlin_32,
                                DATEVLOUT: datevlout_32,
                                DATEDEALERIN: dealerin_32,
                                DATERETURN: datereturn_32,
                                VEHICLETYPE: vehicletype_32,
                                MATERIALTYPE: materialtype_32,
                                GORETURN: goreturn_32,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load_32,
                                ROUTE: route_32,
                                UNIT: copydiagramunit_32,
                                ROUNDAMOUNT: roundamount_32,
                                DN: dn_32,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame32_2").value,
                                BILLING: billing_32,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {

                                save_logprocess('Planing', 'Save Sunday Planing', '<?= $result_seLogin['PersonCode'] ?>');
                            }
                        });
                    }
                    alert('บันทึกข้อมูล JOB2 เรียบร้อย');
                    window.location.reload();
                }
                /////end e2 /////
            }
            function save_copydiagramnn()
            {
                /////start n1/////
                var dateworking_21 = "";
                var daterk_21 = "";
                var datevlin_21 = "";
                var datevlout_21 = "";
                var dealerin_21 = "";
                var datereturn_21 = "";
                var vehicletype_21 = "";
                var materialtype_21 = "";
                var employeename1_21 = "";
                var employeename2_21 = "";
                var employeename3_21 = "";
                var thainame_21 = "";
                var goreturn_21 = "";
                var load_21 = "";
                var route_21 = "";
                var cluster_21 = "";
                var jobstart_21 = "";
                var jobend_21 = "";
                var copydiagramunit_21 = "";
                var roundamount_21 = document.getElementById("txt_roundamount21").value;
                var dn_21 = "";
                var billing_21 = "";
                var vehicletransportplanid_21 = "";

                var copydiagramdatestart_21 = document.getElementById("txt_copydiagramdatestartnn").value;
                var copydiagramdateend_21 = document.getElementById("txt_copydiagramdateendnn").value;
                copydiagramunit_21 = document.getElementById("txt_copydiagramunit21").value;

                employeename1_21 = document.getElementById("txt_copydiagramemployeename21_1").value;
                employeename2_21 = document.getElementById("txt_copydiagramemployeename21_2").value;
                employeename3_21 = document.getElementById("txt_copydiagramemployeename21_3").value;


                thainame_21 = document.getElementById("txt_copydiagramthainame21_1").value;
                if (chk_copydiagramdaterk.checked == true) {
                    daterk_21 = document.getElementById("txt_copydiagramdaterk221").value;

                } else
                {

                    daterk_21 = document.getElementById("txt_copydiagramdaterk21").value;


                }
                if (chk_copydiagramdatevlin21.checked == true) {
                    datevlin_21 = document.getElementById("txt_copydiagramdatevlin221").value;

                } else
                {
                    datevlin_21 = document.getElementById("txt_copydiagramdatevlin21").value;

                }
                if (chk_copydiagramdatevlout21.checked == true) {
                    datevlout_21 = document.getElementById("txt_copydiagramdatevlout221").value;

                } else
                {
                    datevlout_21 = document.getElementById("txt_copydiagramdatevlout21").value;

                }
                if (chk_copydiagramdatedealerin21.checked == true) {
                    dealerin_21 = document.getElementById("txt_copydiagramdatedealerin221").value;

                } else
                {
                    dealerin_21 = document.getElementById("txt_copydiagramdatedealerin21").value;

                }
                if (chk_copydiagramdatereturn21.checked == true) {
                    datereturn_21 = document.getElementById("txt_copydiagramdatereturn221").value;

                } else
                {
                    datereturn_21 = document.getElementById("txt_copydiagramdatereturn21").value;

                }



                cluster_21 = document.getElementById("txt_copydiagramcluster21").value;
                //cluster_21 = document.getElementById("cb_copydiagramcluster21").value;
                //jobstart_21 = document.getElementById("txt_copydiagramjobstart21").value;
                jobstart_21 = $('#txt_copydiagramjobstart21').val().toString();

                jobend_21 = document.getElementById("txt_copydiagramjobend21").value;




                var dateinput_21 = document.getElementById("txt_copydiagramdateinput21").value;
                var datepresent_21 = document.getElementById("txt_copydiagramdatepresent21").value;




                if (checknull_copydiagramnn()) {

                    dateworking_21 = document.getElementById("txt_copydiagramdaterk21").value;

                    if (chk_copydiagrammonday21.checked == true) {
                        //T111
                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid_21,
                                STARTDATE: copydiagramdatestart_21,
                                ENDDATE: copydiagramdateend_21,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame_21,
                                JOBSTART: jobstart_21,
                                CLUSTER: cluster_21,
                                JOBEND: jobend_21,
                                EMPLOYEENAME1: employeename1_21,
                                EMPLOYEENAME2: employeename2_21,
                                EMPLOYEENAME3: employeename3_21,
                                JOBNO: document.getElementById("txt_copydiagramjobnomonday21").value,
                                DATEINPUT: dateinput_21,
                                DATERK: daterk_21,
                                DATEPRESENT: datepresent_21,
                                DATEWORKING: daterk_21,
                                DATEVLIN: datevlin_21,
                                DATEVLOUT: datevlout_21,
                                DATEDEALERIN: dealerin_21,
                                DATERETURN: datereturn_21,
                                VEHICLETYPE: vehicletype_21,
                                MATERIALTYPE: materialtype_21,
                                GORETURN: goreturn_21,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load_21,
                                ROUTE: route_21,
                                UNIT: copydiagramunit_21,
                                ROUNDAMOUNT: roundamount_21,
                                DN: dn_21,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame21_2").value,
                                BILLING: billing_21,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'
                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Monday Planing', '<?= $result_seLogin['PersonCode'] ?>');
                            }
                        });
                    }

                    if (chk_copydiagramtuesday21.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid_21,
                                STARTDATE: copydiagramdatestart_21,
                                ENDDATE: copydiagramdateend_21,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame_21,
                                JOBSTART: jobstart_21,
                                CLUSTER: cluster_21,
                                JOBEND: jobend_21,
                                EMPLOYEENAME1: employeename1_21,
                                EMPLOYEENAME2: employeename2_21,
                                EMPLOYEENAME3: employeename3_21,
                                JOBNO: document.getElementById("txt_copydiagramjobnotuesday21").value,
                                DATEINPUT: dateinput_21,
                                DATERK: daterk_21,
                                DATEPRESENT: datepresent_21,
                                DATEWORKING: daterk_21,
                                DATEVLIN: datevlin_21,
                                DATEVLOUT: datevlout_21,
                                DATEDEALERIN: dealerin_21,
                                DATERETURN: datereturn_21,
                                VEHICLETYPE: vehicletype_21,
                                MATERIALTYPE: materialtype_21,
                                GORETURN: goreturn_21,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load_21,
                                ROUTE: route_21,
                                UNIT: copydiagramunit_21,
                                ROUNDAMOUNT: roundamount_21,
                                DN: dn_21,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame21_2").value,
                                BILLING: billing_21,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Tuesday Planing', '<?= $result_seLogin['PersonCode'] ?>');

                            }
                        });
                    }
                    if (chk_copydiagramwednesday21.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid_21,
                                STARTDATE: copydiagramdatestart_21,
                                ENDDATE: copydiagramdateend_21,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame_21,
                                JOBSTART: jobstart_21,
                                CLUSTER: cluster_21,
                                JOBEND: jobend_21,
                                EMPLOYEENAME1: employeename1_21,
                                EMPLOYEENAME2: employeename2_21,
                                EMPLOYEENAME3: employeename3_21,
                                JOBNO: document.getElementById("txt_copydiagramjobnowednesday21").value,
                                DATEINPUT: dateinput_21,
                                DATERK: daterk_21,
                                DATEPRESENT: datepresent_21,
                                DATEWORKING: daterk_21,
                                DATEVLIN: datevlin_21,
                                DATEVLOUT: datevlout_21,
                                DATEDEALERIN: dealerin_21,
                                DATERETURN: datereturn_21,
                                VEHICLETYPE: vehicletype_21,
                                MATERIALTYPE: materialtype_21,
                                GORETURN: goreturn_21,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load_21,
                                ROUTE: route_21,
                                UNIT: copydiagramunit_21,
                                ROUNDAMOUNT: roundamount_21,
                                DN: dn_21,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame21_2").value,
                                BILLING: billing_21,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Wednesday Planing', '<?= $result_seLogin['PersonCode'] ?>');

                            }
                        });
                    }
                    if (chk_copydiagramthursday21.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid_21,
                                STARTDATE: copydiagramdatestart_21,
                                ENDDATE: copydiagramdateend_21,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame_21,
                                JOBSTART: jobstart_21,
                                CLUSTER: cluster_21,
                                JOBEND: jobend_21,
                                EMPLOYEENAME1: employeename1_21,
                                EMPLOYEENAME2: employeename2_21,
                                EMPLOYEENAME3: employeename3_21,
                                JOBNO: document.getElementById("txt_copydiagramjobnothursday21").value,
                                DATEINPUT: dateinput_21,
                                DATERK: daterk_21,
                                DATEPRESENT: datepresent_21,
                                DATEWORKING: daterk_21,
                                DATEVLIN: datevlin_21,
                                DATEVLOUT: datevlout_21,
                                DATEDEALERIN: dealerin_21,
                                DATERETURN: datereturn_21,
                                VEHICLETYPE: vehicletype_21,
                                MATERIALTYPE: materialtype_21,
                                GORETURN: goreturn_21,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load_21,
                                ROUTE: route_21,
                                UNIT: copydiagramunit_21,
                                ROUNDAMOUNT: roundamount_21,
                                DN: dn_21,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame21_2").value,
                                BILLING: billing_21,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Thursday Planing', '<?= $result_seLogin['PersonCode'] ?>');

                            }
                        });
                    }
                    if (chk_copydiagramfriday21.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid_21,
                                STARTDATE: copydiagramdatestart_21,
                                ENDDATE: copydiagramdateend_21,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame_21,
                                JOBSTART: jobstart_21,
                                CLUSTER: cluster_21,
                                JOBEND: jobend_21,
                                EMPLOYEENAME1: employeename1_21,
                                EMPLOYEENAME2: employeename2_21,
                                EMPLOYEENAME3: employeename3_21,
                                JOBNO: document.getElementById("txt_copydiagramjobnofriday21").value,
                                DATEINPUT: dateinput_21,
                                DATERK: daterk_21,
                                DATEPRESENT: datepresent_21,
                                DATEWORKING: daterk_21,
                                DATEVLIN: datevlin_21,
                                DATEVLOUT: datevlout_21,
                                DATEDEALERIN: dealerin_21,
                                DATERETURN: datereturn_21,
                                VEHICLETYPE: vehicletype_21,
                                MATERIALTYPE: materialtype_21,
                                GORETURN: goreturn_21,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load_21,
                                ROUTE: route_21,
                                UNIT: copydiagramunit_21,
                                ROUNDAMOUNT: roundamount_21,
                                DN: dn_21,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame21_2").value,
                                BILLING: billing_21,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {

                                save_logprocess('Planing', 'Save Friday Planing', '<?= $result_seLogin['PersonCode'] ?>');

                            }
                        });
                    }
                    if (chk_copydiagramsaturday21.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid_21,
                                STARTDATE: copydiagramdatestart_21,
                                ENDDATE: copydiagramdateend_21,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame_21,
                                JOBSTART: jobstart_21,
                                CLUSTER: cluster_21,
                                JOBEND: jobend_21,
                                EMPLOYEENAME1: employeename1_21,
                                EMPLOYEENAME2: employeename2_21,
                                EMPLOYEENAME3: employeename3_21,
                                JOBNO: document.getElementById("txt_copydiagramjobnosaturday21").value,
                                DATEINPUT: dateinput_21,
                                DATERK: daterk_21,
                                DATEPRESENT: datepresent_21,
                                DATEWORKING: daterk_21,
                                DATEVLIN: datevlin_21,
                                DATEVLOUT: datevlout_21,
                                DATEDEALERIN: dealerin_21,
                                DATERETURN: datereturn_21,
                                VEHICLETYPE: vehicletype_21,
                                MATERIALTYPE: materialtype_21,
                                GORETURN: goreturn_21,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load_21,
                                ROUTE: route_21,
                                UNIT: copydiagramunit_21,
                                ROUNDAMOUNT: roundamount_21,
                                DN: dn_21,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame21_2").value,
                                BILLING: billing_21,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {

                                save_logprocess('Planing', 'Save Saturday Planing', '<?= $result_seLogin['PersonCode'] ?>');
                            }
                        });
                    }
                    if (chk_copydiagramsunday21.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid_21,
                                STARTDATE: copydiagramdatestart_21,
                                ENDDATE: copydiagramdateend_21,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame_21,
                                JOBSTART: jobstart_21,
                                CLUSTER: cluster_21,
                                JOBEND: jobend_21,
                                EMPLOYEENAME1: employeename1_21,
                                EMPLOYEENAME2: employeename2_21,
                                EMPLOYEENAME3: employeename3_21,
                                JOBNO: document.getElementById("txt_copydiagramjobnosunday21").value,
                                DATEINPUT: dateinput_21,
                                DATERK: daterk_21,
                                DATEPRESENT: datepresent_21,
                                DATEWORKING: daterk_21,
                                DATEVLIN: datevlin_21,
                                DATEVLOUT: datevlout_21,
                                DATEDEALERIN: dealerin_21,
                                DATERETURN: datereturn_21,
                                VEHICLETYPE: vehicletype_21,
                                MATERIALTYPE: materialtype_21,
                                GORETURN: goreturn_21,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load_21,
                                ROUTE: route_21,
                                UNIT: copydiagramunit_21,
                                ROUNDAMOUNT: roundamount_21,
                                DN: dn_21,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame21_2").value,
                                BILLING: billing_21,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Sunday Planing', '<?= $result_seLogin['PersonCode'] ?>');

                            }
                        });
                    }
                    alert('บันทึกข้อมูล JOB1 เรียบร้อย');


                    /////end n1/////
                    /////start n2/////
                    var dateworking_22 = "";
                    var daterk_22 = "";
                    var datevlin_22 = "";
                    var datevlout_22 = "";
                    var dealerin_22 = "";
                    var datereturn_22 = "";
                    var vehicletype_22 = "";
                    var materialtype_22 = "";
                    var employeename1_22 = "";
                    var employeename2_22 = "";
                    var employeename3_22 = "";
                    var thainame_22 = "";
                    var goreturn_22 = "";
                    var load_22 = "";
                    var route_22 = "";
                    var cluster_22 = "";
                    var jobstart_22 = "";
                    var jobend_22 = "";
                    var copydiagramunit_22 = "";
                    var roundamount_22 = document.getElementById("txt_roundamount22").value;
                    var dn_22 = "";
                    var billing_22 = "";
                    var vehicletransportplanid_22 = "";

                    var copydiagramdatestart_22 = document.getElementById("txt_copydiagramdatestartnn").value;
                    var copydiagramdateend_22 = document.getElementById("txt_copydiagramdateendnn").value;
                    copydiagramunit_22 = document.getElementById("txt_copydiagramunit22").value;

                    employeename1_22 = document.getElementById("txt_copydiagramemployeename22_1").value;
                    employeename2_22 = document.getElementById("txt_copydiagramemployeename22_2").value;
                    employeename3_22 = document.getElementById("txt_copydiagramemployeename22_3").value;


                    thainame_22 = document.getElementById("txt_copydiagramthainame22_1").value;
                    if (chk_copydiagramdaterk22.checked == true) {
                        daterk_22 = document.getElementById("txt_copydiagramdaterk222").value;

                    } else
                    {
                        daterk_22 = document.getElementById("txt_copydiagramdaterk22").value;

                    }
                    if (chk_copydiagramdatevlin22.checked == true) {
                        datevlin_22 = document.getElementById("txt_copydiagramdatevlin222").value;

                    } else
                    {
                        datevlin_22 = document.getElementById("txt_copydiagramdatevlin22").value;

                    }
                    if (chk_copydiagramdatevlout22.checked == true) {
                        datevlout_22 = document.getElementById("txt_copydiagramdatevlout222").value;

                    } else
                    {
                        datevlout_22 = document.getElementById("txt_copydiagramdatevlout22").value;

                    }
                    if (chk_copydiagramdatedealerin22.checked == true) {
                        dealerin_22 = document.getElementById("txt_copydiagramdatedealerin222").value;

                    } else
                    {
                        dealerin_22 = document.getElementById("txt_copydiagramdatedealerin22").value;

                    }
                    if (chk_copydiagramdatereturn22.checked == true) {
                        datereturn_22 = document.getElementById("txt_copydiagramdatereturn222").value;

                    } else
                    {
                        datereturn_22 = document.getElementById("txt_copydiagramdatereturn22").value;

                    }
                    cluster_22 = document.getElementById("txt_copydiagramcluster22").value;
                    //cluster_22 = document.getElementById.value;

                    //jobstart_22 = document.getElementById("txt_copydiagramjobstart22").value;
                    jobstart_22 = $('#txt_copydiagramjobstart22').val().toString();
                    jobend_22 = document.getElementById("txt_copydiagramjobend22").value;

                    var dateinput_22 = document.getElementById("txt_copydiagramdateinput22").value;
                    var datepresent_22 = document.getElementById("txt_copydiagramdatepresent22").value;


                    if (chk_copydiagrammonday22.checked == true) {
                        //T2222
                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid_22,
                                STARTDATE: copydiagramdatestart_22,
                                ENDDATE: copydiagramdateend_22,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame_22,
                                JOBSTART: jobstart_22,
                                CLUSTER: cluster_22,
                                JOBEND: jobend_22,
                                EMPLOYEENAME1: employeename1_22,
                                EMPLOYEENAME2: employeename2_22,
                                EMPLOYEENAME3: employeename3_22,
                                JOBNO: document.getElementById("txt_copydiagramjobnomonday22").value,
                                DATEINPUT: dateinput_22,
                                DATERK: daterk_22,
                                DATEPRESENT: datepresent_22,
                                DATEWORKING: daterk_22,
                                DATEVLIN: datevlin_22,
                                DATEVLOUT: datevlout_22,
                                DATEDEALERIN: dealerin_22,
                                DATERETURN: datereturn_22,
                                VEHICLETYPE: vehicletype_22,
                                MATERIALTYPE: materialtype_22,
                                GORETURN: goreturn_22,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load_22,
                                ROUTE: route_22,
                                UNIT: copydiagramunit_22,
                                ROUNDAMOUNT: roundamount_22,
                                DN: dn_22,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame22_2").value,
                                BILLING: billing_22,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'
                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Monday Planing', '<?= $result_seLogin['PersonCode'] ?>');

                            }
                        });
                    }
                    if (chk_copydiagramtuesday22.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid_22,
                                STARTDATE: copydiagramdatestart_22,
                                ENDDATE: copydiagramdateend_22,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame_22,
                                JOBSTART: jobstart_22,
                                CLUSTER: cluster_22,
                                JOBEND: jobend_22,
                                EMPLOYEENAME1: employeename1_22,
                                EMPLOYEENAME2: employeename2_22,
                                EMPLOYEENAME3: employeename3_22,
                                JOBNO: document.getElementById("txt_copydiagramjobnotuesday22").value,
                                DATEINPUT: dateinput_22,
                                DATERK: daterk_22,
                                DATEPRESENT: datepresent_22,
                                DATEWORKING: daterk_22,
                                DATEVLIN: datevlin_22,
                                DATEVLOUT: datevlout_22,
                                DATEDEALERIN: dealerin_22,
                                DATERETURN: datereturn_22,
                                VEHICLETYPE: vehicletype_22,
                                MATERIALTYPE: materialtype_22,
                                GORETURN: goreturn_22,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load_22,
                                ROUTE: route_22,
                                UNIT: copydiagramunit_22,
                                ROUNDAMOUNT: roundamount_22,
                                DN: dn_22,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame22_2").value,
                                BILLING: billing_22,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {

                                save_logprocess('Planing', 'Save Tuesday Planing', '<?= $result_seLogin['PersonCode'] ?>');
                            }
                        });
                    }
                    if (chk_copydiagramwednesday22.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid_22,
                                STARTDATE: copydiagramdatestart_22,
                                ENDDATE: copydiagramdateend_22,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame_22,
                                JOBSTART: jobstart_22,
                                CLUSTER: cluster_22,
                                JOBEND: jobend_22,
                                EMPLOYEENAME1: employeename1_22,
                                EMPLOYEENAME2: employeename2_22,
                                EMPLOYEENAME3: employeename3_22,
                                JOBNO: document.getElementById("txt_copydiagramjobnowednesday22").value,
                                DATEINPUT: dateinput_22,
                                DATERK: daterk_22,
                                DATEPRESENT: datepresent_22,
                                DATEWORKING: daterk_22,
                                DATEVLIN: datevlin_22,
                                DATEVLOUT: datevlout_22,
                                DATEDEALERIN: dealerin_22,
                                DATERETURN: datereturn_22,
                                VEHICLETYPE: vehicletype_22,
                                MATERIALTYPE: materialtype_22,
                                GORETURN: goreturn_22,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load_22,
                                ROUTE: route_22,
                                UNIT: copydiagramunit_22,
                                ROUNDAMOUNT: roundamount_22,
                                DN: dn_22,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame22_2").value,
                                BILLING: billing_22,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Wednesday Planing', '<?= $result_seLogin['PersonCode'] ?>');

                            }
                        });
                    }
                    if (chk_copydiagramthursday22.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid_22,
                                STARTDATE: copydiagramdatestart_22,
                                ENDDATE: copydiagramdateend_22,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame_22,
                                JOBSTART: jobstart_22,
                                CLUSTER: cluster_22,
                                JOBEND: jobend_22,
                                EMPLOYEENAME1: employeename1_22,
                                EMPLOYEENAME2: employeename2_22,
                                EMPLOYEENAME3: employeename3_22,
                                JOBNO: document.getElementById("txt_copydiagramjobnothursday22").value,
                                DATEINPUT: dateinput_22,
                                DATERK: daterk_22,
                                DATEPRESENT: datepresent_22,
                                DATEWORKING: daterk_22,
                                DATEVLIN: datevlin_22,
                                DATEVLOUT: datevlout_22,
                                DATEDEALERIN: dealerin_22,
                                DATERETURN: datereturn_22,
                                VEHICLETYPE: vehicletype_22,
                                MATERIALTYPE: materialtype_22,
                                GORETURN: goreturn_22,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load_22,
                                ROUTE: route_22,
                                UNIT: copydiagramunit_22,
                                ROUNDAMOUNT: roundamount_22,
                                DN: dn_22,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame22_2").value,
                                BILLING: billing_22,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Thursday Planing', '<?= $result_seLogin['PersonCode'] ?>');

                            }
                        });
                    }
                    if (chk_copydiagramfriday22.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid_22,
                                STARTDATE: copydiagramdatestart_22,
                                ENDDATE: copydiagramdateend_22,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame_22,
                                JOBSTART: jobstart_22,
                                CLUSTER: cluster_22,
                                JOBEND: jobend_22,
                                EMPLOYEENAME1: employeename1_22,
                                EMPLOYEENAME2: employeename2_22,
                                EMPLOYEENAME3: employeename3_22,
                                JOBNO: document.getElementById("txt_copydiagramjobnofriday22").value,
                                DATEINPUT: dateinput_22,
                                DATERK: daterk_22,
                                DATEPRESENT: datepresent_22,
                                DATEWORKING: daterk_22,
                                DATEVLIN: datevlin_22,
                                DATEVLOUT: datevlout_22,
                                DATEDEALERIN: dealerin_22,
                                DATERETURN: datereturn_22,
                                VEHICLETYPE: vehicletype_22,
                                MATERIALTYPE: materialtype_22,
                                GORETURN: goreturn_22,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load_22,
                                ROUTE: route_22,
                                UNIT: copydiagramunit_22,
                                ROUNDAMOUNT: roundamount_22,
                                DN: dn_22,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame22_2").value,
                                BILLING: billing_22,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {

                                save_logprocess('Planing', 'Save Friday Planing', '<?= $result_seLogin['PersonCode'] ?>');

                            }
                        });
                    }
                    if (chk_copydiagramsaturday22.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid_22,
                                STARTDATE: copydiagramdatestart_22,
                                ENDDATE: copydiagramdateend_22,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame_22,
                                JOBSTART: jobstart_22,
                                CLUSTER: cluster_22,
                                JOBEND: jobend_22,
                                EMPLOYEENAME1: employeename1_22,
                                EMPLOYEENAME2: employeename2_22,
                                EMPLOYEENAME3: employeename3_22,
                                JOBNO: document.getElementById("txt_copydiagramjobnosaturday22").value,
                                DATEINPUT: dateinput_22,
                                DATERK: daterk_22,
                                DATEPRESENT: datepresent_22,
                                DATEWORKING: daterk_22,
                                DATEVLIN: datevlin_22,
                                DATEVLOUT: datevlout_22,
                                DATEDEALERIN: dealerin_22,
                                DATERETURN: datereturn_22,
                                VEHICLETYPE: vehicletype_22,
                                MATERIALTYPE: materialtype_22,
                                GORETURN: goreturn_22,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load_22,
                                ROUTE: route_22,
                                UNIT: copydiagramunit_22,
                                ROUNDAMOUNT: roundamount_22,
                                DN: dn_22,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame22_2").value,
                                BILLING: billing_22,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {

                                save_logprocess('Planing', 'Save Saturday Planing', '<?= $result_seLogin['PersonCode'] ?>');
                            }
                        });
                    }
                    if (chk_copydiagramsunday22.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid_22,
                                STARTDATE: copydiagramdatestart_22,
                                ENDDATE: copydiagramdateend_22,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame_22,
                                JOBSTART: jobstart_22,
                                CLUSTER: cluster_22,
                                JOBEND: jobend_22,
                                EMPLOYEENAME1: employeename1_22,
                                EMPLOYEENAME2: employeename2_22,
                                EMPLOYEENAME3: employeename3_22,
                                JOBNO: document.getElementById("txt_copydiagramjobnosunday22").value,
                                DATEINPUT: dateinput_22,
                                DATERK: daterk_22,
                                DATEPRESENT: datepresent_22,
                                DATEWORKING: daterk_22,
                                DATEVLIN: datevlin_22,
                                DATEVLOUT: datevlout_22,
                                DATEDEALERIN: dealerin_22,
                                DATERETURN: datereturn_22,
                                VEHICLETYPE: vehicletype_22,
                                MATERIALTYPE: materialtype_22,
                                GORETURN: goreturn_22,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load_22,
                                ROUTE: route_22,
                                UNIT: copydiagramunit_22,
                                ROUNDAMOUNT: roundamount_22,
                                DN: dn_22,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame22_2").value,
                                BILLING: billing_22,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Sunday Planing', '<?= $result_seLogin['PersonCode'] ?>');

                            }
                        });
                    }
                    alert('บันทึกข้อมูล JOB2 เรียบร้อย');
                    window.location.reload();
                }
                /////end e2 /////
            }
            function save_copydiagramshsh()
            {
                var dateworking = "";
                var daterk = "";
                var datevlin = "";
                var datevlout = "";
                var dealerin = "";
                var datereturn = "";
                var vehicletype = "";
                var materialtype = "";
                var employeename1 = "";
                var employeename2 = "";
                var employeename3 = "";
                var thainame = "";
                var goreturn = "";
                var load = "";
                var route = "";
                var cluster = "";
                var jobstart = "";
                var jobend = "";
                var copydiagramunit = document.getElementById("txt_copydiagramunit21_sh").value;
                var roundamount = document.getElementById("txt_roundamount21_sh").value;
                var dn = "";
                var billing = "";
                var vehicletransportplanid = '';


                var copydiagramdatestart = document.getElementById("txt_copydiagramdatestartshsh").value;
                var copydiagramdateend = document.getElementById("txt_copydiagramdateendshsh").value;
                employeename1 = document.getElementById("txt_copydiagramemployeename21_1sh").value;
                employeename2 = document.getElementById("txt_copydiagramemployeename21_2sh").value;
                employeename3 = document.getElementById("txt_copydiagramemployeename21_3sh").value;


                thainame = document.getElementById("txt_copydiagramthainame21_1sh").value;

                if (chk_copydiagramdaterk.checked == true) {
                    daterk = document.getElementById("txt_copydiagramdaterk221_sh").value;

                } else
                {
                    daterk = document.getElementById("txt_copydiagramdaterk21_sh").value;

                }
                if (chk_copydiagramdatevlin.checked == true) {
                    datevlin = document.getElementById("txt_copydiagramdatevlin221_sh").value;

                } else
                {
                    datevlin = document.getElementById("txt_copydiagramdatevlin21_sh").value;

                }
                if (chk_copydiagramdatevlout.checked == true) {
                    datevlout = document.getElementById("txt_copydiagramdatevlout221_sh").value;

                } else
                {
                    datevlout = document.getElementById("txt_copydiagramdatevlout21_sh").value;

                }
                if (chk_copydiagramdatedealerin.checked == true) {
                    dealerin = document.getElementById("txt_copydiagramdatedealerin221_sh").value;

                } else
                {
                    dealerin = document.getElementById("txt_copydiagramdatedealerin21_sh").value;

                }
                if (chk_copydiagramdatereturn.checked == true) {
                    datereturn = document.getElementById("txt_copydiagramdatereturn221_sh").value;

                } else
                {
                    datereturn = document.getElementById("txt_copydiagramdatereturn21_sh").value;

                }

                load = document.getElementById("cb_copydiagramload21_sh").value;
                route = document.getElementById("cb_copydiagramroute21_sh").value;

                jobstart = document.getElementById("txt_copydiagramjobstart21_sh").value;
                //jobend = document.getElementById("txt_copydiagramroute").value;
                jobend = document.getElementById("txt_copydiagramsubroute21_sh").value;

                var dateinput = document.getElementById("txt_copydiagramdateinput21_sh").value;
                var datepresent = document.getElementById("txt_copydiagramdatepresent21_sh").value;




                if (checknull_copydiagramsh(vehicletransportplanid)) {

                    dateworking = document.getElementById("txt_copydiagramdaterk21_sh").value;

                    if (chk_copydiagrammonday21_sh.checked == true) {
                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid,
                                STARTDATE: copydiagramdatestart,
                                ENDDATE: copydiagramdateend,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame,
                                JOBSTART: jobstart,
                                CLUSTER: cluster,
                                JOBEND: jobend,
                                EMPLOYEENAME1: employeename1,
                                EMPLOYEENAME2: employeename2,
                                EMPLOYEENAME3: employeename3,
                                JOBNO: document.getElementById("txt_copydiagramjobnomonday21_sh").value,
                                DATEINPUT: dateinput,
                                DATERK: daterk,
                                DATEPRESENT: datepresent,
                                DATEWORKING: dateworking,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn,
                                VEHICLETYPE: vehicletype,
                                MATERIALTYPE: materialtype,
                                GORETURN: goreturn,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load,
                                ROUTE: route,
                                UNIT: copydiagramunit,
                                ROUNDAMOUNT: roundamount,
                                DN: dn,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame21_2sh").value,
                                BILLING: billing,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'


                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Monday Planing', '<?= $result_seLogin['PersonCode'] ?>');
                            }
                        });
                    }
                    if (chk_copydiagramtuesday21_sh.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid,
                                STARTDATE: copydiagramdatestart,
                                ENDDATE: copydiagramdateend,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame,
                                JOBSTART: jobstart,
                                CLUSTER: cluster,
                                JOBEND: jobend,
                                EMPLOYEENAME1: employeename1,
                                EMPLOYEENAME2: employeename2,
                                EMPLOYEENAME3: employeename3,
                                JOBNO: document.getElementById("txt_copydiagramjobnotuesday21_sh").value,
                                DATEINPUT: dateinput,
                                DATERK: daterk,
                                DATEPRESENT: datepresent,
                                DATEWORKING: dateworking,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn,
                                VEHICLETYPE: vehicletype,
                                MATERIALTYPE: materialtype,
                                GORETURN: goreturn,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load,
                                ROUTE: route,
                                UNIT: copydiagramunit,
                                ROUNDAMOUNT: roundamount,
                                DN: dn,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame21_2sh").value,
                                BILLING: billing,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {

                                save_logprocess('Planing', 'Save Tuesday Planing', '<?= $result_seLogin['PersonCode'] ?>');
                            }
                        });
                    }
                    if (chk_copydiagramwednesday21_sh.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid,
                                STARTDATE: copydiagramdatestart,
                                ENDDATE: copydiagramdateend,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame,
                                JOBSTART: jobstart,
                                CLUSTER: cluster,
                                JOBEND: jobend,
                                EMPLOYEENAME1: employeename1,
                                EMPLOYEENAME2: employeename2,
                                EMPLOYEENAME3: employeename3,
                                JOBNO: document.getElementById("txt_copydiagramjobnowednesday21_sh").value,
                                DATEINPUT: dateinput,
                                DATERK: daterk,
                                DATEPRESENT: datepresent,
                                DATEWORKING: dateworking,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn,
                                VEHICLETYPE: vehicletype,
                                MATERIALTYPE: materialtype,
                                GORETURN: goreturn,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load,
                                ROUTE: route,
                                UNIT: copydiagramunit,
                                ROUNDAMOUNT: roundamount,
                                DN: dn,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame21_2sh").value,
                                BILLING: billing,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Wednesday Planing', '<?= $result_seLogin['PersonCode'] ?>');

                            }
                        });
                    }
                    if (chk_copydiagramthursday21_sh.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid,
                                STARTDATE: copydiagramdatestart,
                                ENDDATE: copydiagramdateend,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame,
                                JOBSTART: jobstart,
                                CLUSTER: cluster,
                                JOBEND: jobend,
                                EMPLOYEENAME1: employeename1,
                                EMPLOYEENAME2: employeename2,
                                EMPLOYEENAME3: employeename3,
                                JOBNO: document.getElementById("txt_copydiagramjobnothursday21_sh").value,
                                DATEINPUT: dateinput,
                                DATERK: daterk,
                                DATEPRESENT: datepresent,
                                DATEWORKING: dateworking,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn,
                                VEHICLETYPE: vehicletype,
                                MATERIALTYPE: materialtype,
                                GORETURN: goreturn,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load,
                                ROUTE: route,
                                UNIT: copydiagramunit,
                                ROUNDAMOUNT: roundamount,
                                DN: dn,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame21_2sh").value,
                                BILLING: billing,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Thursday Planing', '<?= $result_seLogin['PersonCode'] ?>');

                            }
                        });
                    }
                    if (chk_copydiagramfriday21_sh.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid,
                                STARTDATE: copydiagramdatestart,
                                ENDDATE: copydiagramdateend,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame,
                                JOBSTART: jobstart,
                                CLUSTER: cluster,
                                JOBEND: jobend,
                                EMPLOYEENAME1: employeename1,
                                EMPLOYEENAME2: employeename2,
                                EMPLOYEENAME3: employeename3,
                                JOBNO: document.getElementById("txt_copydiagramjobnofriday21_sh").value,
                                DATEINPUT: dateinput,
                                DATERK: daterk,
                                DATEPRESENT: datepresent,
                                DATEWORKING: dateworking,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn,
                                VEHICLETYPE: vehicletype,
                                MATERIALTYPE: materialtype,
                                GORETURN: goreturn,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load,
                                ROUTE: route,
                                UNIT: copydiagramunit,
                                ROUNDAMOUNT: roundamount,
                                DN: dn,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame21_2sh").value,
                                BILLING: billing,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Friday Planing', '<?= $result_seLogin['PersonCode'] ?>');


                            }
                        });
                    }
                    if (chk_copydiagramsaturday21_sh.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid,
                                STARTDATE: copydiagramdatestart,
                                ENDDATE: copydiagramdateend,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame,
                                JOBSTART: jobstart,
                                CLUSTER: cluster,
                                JOBEND: jobend,
                                EMPLOYEENAME1: employeename1,
                                EMPLOYEENAME2: employeename2,
                                EMPLOYEENAME3: employeename3,
                                JOBNO: document.getElementById("txt_copydiagramjobnosaturday21_sh").value,
                                DATEINPUT: dateinput,
                                DATERK: daterk,
                                DATEPRESENT: datepresent,
                                DATEWORKING: dateworking,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn,
                                VEHICLETYPE: vehicletype,
                                MATERIALTYPE: materialtype,
                                GORETURN: goreturn,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load,
                                ROUTE: route,
                                UNIT: copydiagramunit,
                                ROUNDAMOUNT: roundamount,
                                DN: dn,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame21_2sh").value,
                                BILLING: billing,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {

                                save_logprocess('Planing', 'Save Saturday Planing', '<?= $result_seLogin['PersonCode'] ?>');
                            }
                        });
                    }
                    if (chk_copydiagramsunday21_sh.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid,
                                STARTDATE: copydiagramdatestart,
                                ENDDATE: copydiagramdateend,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame,
                                JOBSTART: jobstart,
                                CLUSTER: cluster,
                                JOBEND: jobend,
                                EMPLOYEENAME1: employeename1,
                                EMPLOYEENAME2: employeename2,
                                EMPLOYEENAME3: employeename3,
                                JOBNO: document.getElementById("txt_copydiagramjobnosunday21_sh").value,
                                DATEINPUT: dateinput,
                                DATERK: daterk,
                                DATEPRESENT: datepresent,
                                DATEWORKING: dateworking,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn,
                                VEHICLETYPE: vehicletype,
                                MATERIALTYPE: materialtype,
                                GORETURN: goreturn,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load,
                                ROUTE: route,
                                UNIT: copydiagramunit,
                                ROUNDAMOUNT: roundamount,
                                DN: dn,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame21_2sh").value,
                                BILLING: billing,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {

                                save_logprocess('Planing', 'Save Sunday Planing', '<?= $result_seLogin['PersonCode'] ?>');
                            }
                        });
                    }

                    alert('บันทึกข้อมูล JOB1 เรียบร้อย');




                    var dateworking_sh2 = "";
                    var daterk_sh2 = "";
                    var datevlin_sh2 = "";
                    var datevlout_sh2 = "";
                    var dealerin_sh2 = "";
                    var datereturn_sh2 = "";
                    var vehicletype_sh2 = "";
                    var materialtype_sh2 = "";
                    var employeename1_sh2 = "";
                    var employeename2_sh2 = "";
                    var employeename3_sh2 = "";
                    var thainame_sh2 = document.getElementById("txt_copydiagramthainame22_1sh").value;
                    var goreturn_sh2 = "";
                    var load_sh2 = "";
                    var route_sh2 = "";
                    var cluster_sh2 = "";
                    var jobstart_sh2 = "";
                    var jobend_sh2 = "";
                    var copydiagramunit_sh2 = document.getElementById("txt_copydiagramunit22_sh").value;
                    var roundamount_sh2 = document.getElementById("txt_roundamount22_sh").value;
                    var dn_sh2 = "";
                    var billing_sh2 = "";
                    var vehicletransportplanid_sh2 = '';


                    var copydiagramdatestart_sh2 = document.getElementById("txt_copydiagramdatestartshsh").value;
                    var copydiagramdateend_sh2 = document.getElementById("txt_copydiagramdateendshsh").value;
                    employeename1_sh2 = document.getElementById("txt_copydiagramemployeename22_1sh").value;
                    employeename2_sh2 = document.getElementById("txt_copydiagramemployeename22_2sh").value;
                    employeename3_sh2 = document.getElementById("txt_copydiagramemployeename22_3sh").value;



                    if (chk_copydiagramdaterk.checked == true) {
                        daterk_sh2 = document.getElementById("txt_copydiagramdaterk222_sh").value;

                    } else
                    {
                        daterk_sh2 = document.getElementById("txt_copydiagramdaterk22_sh").value;

                    }
                    if (chk_copydiagramdatevlin.checked == true) {
                        datevlin_sh2 = document.getElementById("txt_copydiagramdatevlin222_sh").value;

                    } else
                    {
                        datevlin_sh2 = document.getElementById("txt_copydiagramdatevlin22_sh").value;

                    }
                    if (chk_copydiagramdatevlout.checked == true) {
                        datevlout_sh2 = document.getElementById("txt_copydiagramdatevlout222_sh").value;

                    } else
                    {
                        datevlout_sh2 = document.getElementById("txt_copydiagramdatevlout22_sh").value;

                    }
                    if (chk_copydiagramdatedealerin.checked == true) {
                        dealerin_sh2 = document.getElementById("txt_copydiagramdatedealerin222_sh").value;

                    } else
                    {
                        dealerin_sh2 = document.getElementById("txt_copydiagramdatedealerin22_sh").value;

                    }
                    if (chk_copydiagramdatereturn.checked == true) {
                        datereturn_sh2 = document.getElementById("txt_copydiagramdatereturn222_sh").value;

                    } else
                    {
                        datereturn_sh2 = document.getElementById("txt_copydiagramdatereturn22_sh").value;

                    }

                    load_sh2 = document.getElementById("cb_copydiagramload22_sh").value;
                    route_sh2 = document.getElementById("cb_copydiagramroute22_sh").value;

                    jobstart_sh2 = document.getElementById("txt_copydiagramjobstart22_sh").value;
                    //jobend = document.getElementById("txt_copydiagramroute").value;
                    jobend_sh2 = document.getElementById("txt_copydiagramsubroute22_sh").value;

                    var dateinput_sh2 = document.getElementById("txt_copydiagramdateinput22_sh").value;
                    var datepresent_sh2 = document.getElementById("txt_copydiagramdatepresent22_sh").value;

                    if (chk_copydiagrammonday22_sh.checked == true) {
                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid_sh2,
                                STARTDATE: copydiagramdatestart_sh2,
                                ENDDATE: copydiagramdateend_sh2,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame_sh2,
                                JOBSTART: jobstart_sh2,
                                CLUSTER: cluster_sh2,
                                JOBEND: jobend_sh2,
                                EMPLOYEENAME1: employeename1_sh2,
                                EMPLOYEENAME2: employeename2_sh2,
                                EMPLOYEENAME3: employeename3_sh2,
                                JOBNO: document.getElementById("txt_copydiagramjobnomonday22_sh").value,
                                DATEINPUT: dateinput_sh2,
                                DATERK: daterk_sh2,
                                DATEPRESENT: datepresent_sh2,
                                DATEWORKING: dateworking_sh2,
                                DATEVLIN: datevlin_sh2,
                                DATEVLOUT: datevlout_sh2,
                                DATEDEALERIN: dealerin_sh2,
                                DATERETURN: datereturn_sh2,
                                VEHICLETYPE: vehicletype_sh2,
                                MATERIALTYPE: materialtype_sh2,
                                GORETURN: goreturn_sh2,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load_sh2,
                                ROUTE: route_sh2,
                                UNIT: copydiagramunit_sh2,
                                ROUNDAMOUNT: roundamount_sh2,
                                DN: dn_sh2,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame22_2sh").value,
                                BILLING: billing_sh2,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'


                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Monday Planing', '<?= $result_seLogin['PersonCode'] ?>');
                            }
                        });
                    }
                    if (chk_copydiagramtuesday22_sh.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid_sh2,
                                STARTDATE: copydiagramdatestart_sh2,
                                ENDDATE: copydiagramdateend_sh2,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame_sh2,
                                JOBSTART: jobstart_sh2,
                                CLUSTER: cluster_sh2,
                                JOBEND: jobend_sh2,
                                EMPLOYEENAME1: employeename1_sh2,
                                EMPLOYEENAME2: employeename2_sh2,
                                EMPLOYEENAME3: employeename3_sh2,
                                JOBNO: document.getElementById("txt_copydiagramjobnotuesday22_sh").value,
                                DATEINPUT: dateinput_sh2,
                                DATERK: daterk_sh2,
                                DATEPRESENT: datepresent_sh2,
                                DATEWORKING: dateworking_sh2,
                                DATEVLIN: datevlin_sh2,
                                DATEVLOUT: datevlout_sh2,
                                DATEDEALERIN: dealerin_sh2,
                                DATERETURN: datereturn_sh2,
                                VEHICLETYPE: vehicletype_sh2,
                                MATERIALTYPE: materialtype_sh2,
                                GORETURN: goreturn_sh2,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load_sh2,
                                ROUTE: route_sh2,
                                UNIT: copydiagramunit_sh2,
                                ROUNDAMOUNT: roundamount_sh2,
                                DN: dn_sh2,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame22_2sh").value,
                                BILLING: billing_sh2,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {

                                save_logprocess('Planing', 'Save Tuesday Planing', '<?= $result_seLogin['PersonCode'] ?>');
                            }
                        });
                    }
                    if (chk_copydiagramwednesday22_sh.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid_sh2,
                                STARTDATE: copydiagramdatestart_sh2,
                                ENDDATE: copydiagramdateend_sh2,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame_sh2,
                                JOBSTART: jobstart_sh2,
                                CLUSTER: cluster_sh2,
                                JOBEND: jobend_sh2,
                                EMPLOYEENAME1: employeename1_sh2,
                                EMPLOYEENAME2: employeename2_sh2,
                                EMPLOYEENAME3: employeename3_sh2,
                                JOBNO: document.getElementById("txt_copydiagramjobnowednesday22_sh").value,
                                DATEINPUT: dateinput_sh2,
                                DATERK: daterk_sh2,
                                DATEPRESENT: datepresent_sh2,
                                DATEWORKING: dateworking_sh2,
                                DATEVLIN: datevlin_sh2,
                                DATEVLOUT: datevlout_sh2,
                                DATEDEALERIN: dealerin_sh2,
                                DATERETURN: datereturn_sh2,
                                VEHICLETYPE: vehicletype_sh2,
                                MATERIALTYPE: materialtype_sh2,
                                GORETURN: goreturn_sh2,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load_sh2,
                                ROUTE: route_sh2,
                                UNIT: copydiagramunit_sh2,
                                ROUNDAMOUNT: roundamount_sh2,
                                DN: dn_sh2,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame22_2sh").value,
                                BILLING: billing_sh2,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Wednesday Planing', '<?= $result_seLogin['PersonCode'] ?>');

                            }
                        });
                    }
                    if (chk_copydiagramthursday22_sh.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid_sh2,
                                STARTDATE: copydiagramdatestart_sh2,
                                ENDDATE: copydiagramdateend_sh2,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame_sh2,
                                JOBSTART: jobstart_sh2,
                                CLUSTER: cluster_sh2,
                                JOBEND: jobend_sh2,
                                EMPLOYEENAME1: employeename1_sh2,
                                EMPLOYEENAME2: employeename2_sh2,
                                EMPLOYEENAME3: employeename3_sh2,
                                JOBNO: document.getElementById("txt_copydiagramjobnothursday22_sh").value,
                                DATEINPUT: dateinput_sh2,
                                DATERK: daterk_sh2,
                                DATEPRESENT: datepresent_sh2,
                                DATEWORKING: dateworking_sh2,
                                DATEVLIN: datevlin_sh2,
                                DATEVLOUT: datevlout_sh2,
                                DATEDEALERIN: dealerin_sh2,
                                DATERETURN: datereturn_sh2,
                                VEHICLETYPE: vehicletype_sh2,
                                MATERIALTYPE: materialtype_sh2,
                                GORETURN: goreturn_sh2,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load_sh2,
                                ROUTE: route_sh2,
                                UNIT: copydiagramunit_sh2,
                                ROUNDAMOUNT: roundamount_sh2,
                                DN: dn_sh2,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame22_2sh").value,
                                BILLING: billing_sh2,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {

                                save_logprocess('Planing', 'Save Thursday Planing', '<?= $result_seLogin['PersonCode'] ?>');
                            }
                        });
                    }
                    if (chk_copydiagramfriday22_sh.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid_sh2,
                                STARTDATE: copydiagramdatestart_sh2,
                                ENDDATE: copydiagramdateend_sh2,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame_sh2,
                                JOBSTART: jobstart_sh2,
                                CLUSTER: cluster_sh2,
                                JOBEND: jobend_sh2,
                                EMPLOYEENAME1: employeename1_sh2,
                                EMPLOYEENAME2: employeename2_sh2,
                                EMPLOYEENAME3: employeename3_sh2,
                                JOBNO: document.getElementById("txt_copydiagramjobnofriday22_sh").value,
                                DATEINPUT: dateinput_sh2,
                                DATERK: daterk_sh2,
                                DATEPRESENT: datepresent_sh2,
                                DATEWORKING: dateworking_sh2,
                                DATEVLIN: datevlin_sh2,
                                DATEVLOUT: datevlout_sh2,
                                DATEDEALERIN: dealerin_sh2,
                                DATERETURN: datereturn_sh2,
                                VEHICLETYPE: vehicletype_sh2,
                                MATERIALTYPE: materialtype_sh2,
                                GORETURN: goreturn_sh2,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load_sh2,
                                ROUTE: route_sh2,
                                UNIT: copydiagramunit_sh2,
                                ROUNDAMOUNT: roundamount_sh2,
                                DN: dn_sh2,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame22_2sh").value,
                                BILLING: billing_sh2,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {

                                save_logprocess('Planing', 'Save Friday Planing', '<?= $result_seLogin['PersonCode'] ?>');

                            }
                        });
                    }
                    if (chk_copydiagramsaturday22_sh.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid_sh2,
                                STARTDATE: copydiagramdatestart_sh2,
                                ENDDATE: copydiagramdateend_sh2,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame_sh2,
                                JOBSTART: jobstart_sh2,
                                CLUSTER: cluster_sh2,
                                JOBEND: jobend_sh2,
                                EMPLOYEENAME1: employeename1_sh2,
                                EMPLOYEENAME2: employeename2_sh2,
                                EMPLOYEENAME3: employeename3_sh2,
                                JOBNO: document.getElementById("txt_copydiagramjobnosaturday22_sh").value,
                                DATEINPUT: dateinput_sh2,
                                DATERK: daterk_sh2,
                                DATEPRESENT: datepresent_sh2,
                                DATEWORKING: dateworking_sh2,
                                DATEVLIN: datevlin_sh2,
                                DATEVLOUT: datevlout_sh2,
                                DATEDEALERIN: dealerin_sh2,
                                DATERETURN: datereturn_sh2,
                                VEHICLETYPE: vehicletype_sh2,
                                MATERIALTYPE: materialtype_sh2,
                                GORETURN: goreturn_sh2,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load_sh2,
                                ROUTE: route_sh2,
                                UNIT: copydiagramunit_sh2,
                                ROUNDAMOUNT: roundamount_sh2,
                                DN: dn_sh2,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame22_2sh").value,
                                BILLING: billing_sh2,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {

                                save_logprocess('Planing', 'Save Saturday Planing', '<?= $result_seLogin['PersonCode'] ?>');
                            }
                        });
                    }
                    if (chk_copydiagramsunday22_sh.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid_sh2,
                                STARTDATE: copydiagramdatestart_sh2,
                                ENDDATE: copydiagramdateend_sh2,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame_sh2,
                                JOBSTART: jobstart_sh2,
                                CLUSTER: cluster_sh2,
                                JOBEND: jobend_sh2,
                                EMPLOYEENAME1: employeename1_sh2,
                                EMPLOYEENAME2: employeename2_sh2,
                                EMPLOYEENAME3: employeename3_sh2,
                                JOBNO: document.getElementById("txt_copydiagramjobnosunday22_sh").value,
                                DATEINPUT: dateinput_sh2,
                                DATERK: daterk_sh2,
                                DATEPRESENT: datepresent_sh2,
                                DATEWORKING: dateworking_sh2,
                                DATEVLIN: datevlin_sh2,
                                DATEVLOUT: datevlout_sh2,
                                DATEDEALERIN: dealerin_sh2,
                                DATERETURN: datereturn_sh2,
                                VEHICLETYPE: vehicletype_sh2,
                                MATERIALTYPE: materialtype_sh2,
                                GORETURN: goreturn_sh2,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load_sh2,
                                ROUTE: route_sh2,
                                UNIT: copydiagramunit_sh2,
                                ROUNDAMOUNT: roundamount_sh2,
                                DN: dn_sh2,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame22_2sh").value,
                                BILLING: billing_sh2,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Sunday Planing', '<?= $result_seLogin['PersonCode'] ?>');

                            }
                        });
                    }

                    alert('บันทึกข้อมูล JOB2 เรียบร้อย');
                    window.location.reload();



                }
            }
            function save_copydiagramshn() {

                var dateworking = "";
                var daterk = "";
                var datevlin = "";
                var datevlout = "";
                var dealerin = "";
                var datereturn = "";
                var vehicletype = "";
                var materialtype = "";
                var employeename1 = "";
                var employeename2 = "";
                var employeename3 = "";
                var thainame = "";
                var goreturn = "";
                var load = "";
                var route = "";
                var cluster = "";
                var jobstart = "";
                var jobend = "";
                var copydiagramunit = document.getElementById("txt_copydiagramunitshn").value;
                var roundamount = document.getElementById("txt_roundamountshn").value;
                var dn = "";
                var billing = "";
                var vehicletransportplanid = '';


                var copydiagramdatestart = document.getElementById("txt_copydiagramdatestartshn").value;
                var copydiagramdateend = document.getElementById("txt_copydiagramdateendshn").value;
                copydiagramunit = document.getElementById("txt_copydiagramunitshn").value;
                employeename1 = document.getElementById("txt_copydiagramemployeename1shn").value;
                employeename2 = document.getElementById("txt_copydiagramemployeename2shn").value;
                employeename3 = document.getElementById("txt_copydiagramemployeename3shn").value;


                thainame = document.getElementById("txt_copydiagramthainame1shn").value;
                if (chk_copydiagramdaterkshn.checked == true) {
                    daterk = document.getElementById("txt_copydiagramdaterk2shn").value;

                } else
                {
                    daterk = document.getElementById("txt_copydiagramdaterkshn").value;

                }
                if (chk_copydiagramdatevlinshn.checked == true) {
                    datevlin = document.getElementById("txt_copydiagramdatevlin2shn").value;

                } else
                {
                    datevlin = document.getElementById("txt_copydiagramdatevlinshn").value;

                }
                if (chk_copydiagramdatevloutshn.checked == true) {
                    datevlout = document.getElementById("txt_copydiagramdatevlout2shn").value;

                } else
                {
                    datevlout = document.getElementById("txt_copydiagramdatevloutshn").value;

                }
                if (chk_copydiagramdatedealerinshn.checked == true) {
                    dealerin = document.getElementById("txt_copydiagramdatedealerin2shn").value;

                } else
                {
                    dealerin = document.getElementById("txt_copydiagramdatedealerinshn").value;

                }
                if (chk_copydiagramdatereturnshn.checked == true) {
                    datereturn = document.getElementById("txt_copydiagramdatereturn2shn").value;

                } else
                {
                    datereturn = document.getElementById("txt_copydiagramdatereturnshn").value;

                }

                load = document.getElementById("cb_copydiagramloadshn").value;
                route = document.getElementById("cb_copydiagramrouteshn").value;

                jobstart = document.getElementById("txt_copydiagramjobstartshn").value;
                //jobend = document.getElementById("txt_copydiagramroute").value;
                jobend = document.getElementById("txt_copydiagramsubrouteshn").value;





                var dateinput = document.getElementById("txt_copydiagramdateinputshn").value;
                var datepresent = document.getElementById("txt_copydiagramdatepresentshn").value;



                if (checknull_copydiagramshn(vehicletransportplanid)) {

                    dateworking = document.getElementById("txt_copydiagramdaterkshn").value;

                    if (chk_copydiagrammondayshn.checked == true) {
                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid,
                                STARTDATE: copydiagramdatestart,
                                ENDDATE: copydiagramdateend,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame,
                                JOBSTART: jobstart,
                                CLUSTER: cluster,
                                JOBEND: jobend,
                                EMPLOYEENAME1: employeename1,
                                EMPLOYEENAME2: employeename2,
                                EMPLOYEENAME3: employeename3,
                                JOBNO: document.getElementById("txt_copydiagramjobnomondayshn").value,
                                DATEINPUT: dateinput,
                                DATERK: daterk,
                                DATEPRESENT: datepresent,
                                DATEWORKING: dateworking,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn,
                                VEHICLETYPE: vehicletype,
                                MATERIALTYPE: materialtype,
                                GORETURN: goreturn,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load,
                                ROUTE: route,
                                UNIT: copydiagramunit,
                                ROUNDAMOUNT: roundamount,
                                DN: dn,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame2shn").value,
                                BILLING: billing,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'


                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Monday Planing', '<?= $result_seLogin['PersonCode'] ?>');
                            }
                        });
                    }
                    if (chk_copydiagramtuesdayshn.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid,
                                STARTDATE: copydiagramdatestart,
                                ENDDATE: copydiagramdateend,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame,
                                JOBSTART: jobstart,
                                CLUSTER: cluster,
                                JOBEND: jobend,
                                EMPLOYEENAME1: employeename1,
                                EMPLOYEENAME2: employeename2,
                                EMPLOYEENAME3: employeename3,
                                JOBNO: document.getElementById("txt_copydiagramjobnotuesdayshn").value,
                                DATEINPUT: dateinput,
                                DATERK: daterk,
                                DATEPRESENT: datepresent,
                                DATEWORKING: dateworking,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn,
                                VEHICLETYPE: vehicletype,
                                MATERIALTYPE: materialtype,
                                GORETURN: goreturn,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load,
                                ROUTE: route,
                                UNIT: copydiagramunit,
                                ROUNDAMOUNT: roundamount,
                                DN: dn,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame2shn").value,
                                BILLING: billing,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Tuesday Planing', '<?= $result_seLogin['PersonCode'] ?>');

                            }
                        });
                    }
                    if (chk_copydiagramwednesdayshn.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid,
                                STARTDATE: copydiagramdatestart,
                                ENDDATE: copydiagramdateend,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame,
                                JOBSTART: jobstart,
                                CLUSTER: cluster,
                                JOBEND: jobend,
                                EMPLOYEENAME1: employeename1,
                                EMPLOYEENAME2: employeename2,
                                EMPLOYEENAME3: employeename3,
                                JOBNO: document.getElementById("txt_copydiagramjobnowednesdayshn").value,
                                DATEINPUT: dateinput,
                                DATERK: daterk,
                                DATEPRESENT: datepresent,
                                DATEWORKING: dateworking,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn,
                                VEHICLETYPE: vehicletype,
                                MATERIALTYPE: materialtype,
                                GORETURN: goreturn,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load,
                                ROUTE: route,
                                UNIT: copydiagramunit,
                                ROUNDAMOUNT: roundamount,
                                DN: dn,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame2shn").value,
                                BILLING: billing,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {

                                save_logprocess('Planing', 'Save Wednesday Planing', '<?= $result_seLogin['PersonCode'] ?>');
                            }
                        });
                    }
                    if (chk_copydiagramthursdayshn.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid,
                                STARTDATE: copydiagramdatestart,
                                ENDDATE: copydiagramdateend,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame,
                                JOBSTART: jobstart,
                                CLUSTER: cluster,
                                JOBEND: jobend,
                                EMPLOYEENAME1: employeename1,
                                EMPLOYEENAME2: employeename2,
                                EMPLOYEENAME3: employeename3,
                                JOBNO: document.getElementById("txt_copydiagramjobnothursdayshn").value,
                                DATEINPUT: dateinput,
                                DATERK: daterk,
                                DATEPRESENT: datepresent,
                                DATEWORKING: dateworking,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn,
                                VEHICLETYPE: vehicletype,
                                MATERIALTYPE: materialtype,
                                GORETURN: goreturn,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load,
                                ROUTE: route,
                                UNIT: copydiagramunit,
                                ROUNDAMOUNT: roundamount,
                                DN: dn,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame2shn").value,
                                BILLING: billing,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {

                                save_logprocess('Planing', 'Save Thursday Planing', '<?= $result_seLogin['PersonCode'] ?>');
                            }
                        });
                    }
                    if (chk_copydiagramfridayshn.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid,
                                STARTDATE: copydiagramdatestart,
                                ENDDATE: copydiagramdateend,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame,
                                JOBSTART: jobstart,
                                CLUSTER: cluster,
                                JOBEND: jobend,
                                EMPLOYEENAME1: employeename1,
                                EMPLOYEENAME2: employeename2,
                                EMPLOYEENAME3: employeename3,
                                JOBNO: document.getElementById("txt_copydiagramjobnofridayshn").value,
                                DATEINPUT: dateinput,
                                DATERK: daterk,
                                DATEPRESENT: datepresent,
                                DATEWORKING: dateworking,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn,
                                VEHICLETYPE: vehicletype,
                                MATERIALTYPE: materialtype,
                                GORETURN: goreturn,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load,
                                ROUTE: route,
                                UNIT: copydiagramunit,
                                ROUNDAMOUNT: roundamount,
                                DN: dn,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame2shn").value,
                                BILLING: billing,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Friday Planing', '<?= $result_seLogin['PersonCode'] ?>');


                            }
                        });
                    }
                    if (chk_copydiagramsaturdayshn.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid,
                                STARTDATE: copydiagramdatestart,
                                ENDDATE: copydiagramdateend,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame,
                                JOBSTART: jobstart,
                                CLUSTER: cluster,
                                JOBEND: jobend,
                                EMPLOYEENAME1: employeename1,
                                EMPLOYEENAME2: employeename2,
                                EMPLOYEENAME3: employeename3,
                                JOBNO: document.getElementById("txt_copydiagramjobnosaturdayshn").value,
                                DATEINPUT: dateinput,
                                DATERK: daterk,
                                DATEPRESENT: datepresent,
                                DATEWORKING: dateworking,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn,
                                VEHICLETYPE: vehicletype,
                                MATERIALTYPE: materialtype,
                                GORETURN: goreturn,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load,
                                ROUTE: route,
                                UNIT: copydiagramunit,
                                ROUNDAMOUNT: roundamount,
                                DN: dn,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame2shn").value,
                                BILLING: billing,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Saturday Planing', '<?= $result_seLogin['PersonCode'] ?>');

                            }
                        });
                    }
                    if (chk_copydiagramsundayshn.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid,
                                STARTDATE: copydiagramdatestart,
                                ENDDATE: copydiagramdateend,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame,
                                JOBSTART: jobstart,
                                CLUSTER: cluster,
                                JOBEND: jobend,
                                EMPLOYEENAME1: employeename1,
                                EMPLOYEENAME2: employeename2,
                                EMPLOYEENAME3: employeename3,
                                JOBNO: document.getElementById("txt_copydiagramjobnosundayshn").value,
                                DATEINPUT: dateinput,
                                DATERK: daterk,
                                DATEPRESENT: datepresent,
                                DATEWORKING: dateworking,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn,
                                VEHICLETYPE: vehicletype,
                                MATERIALTYPE: materialtype,
                                GORETURN: goreturn,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load,
                                ROUTE: route,
                                UNIT: copydiagramunit,
                                ROUNDAMOUNT: roundamount,
                                DN: dn,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame2shn").value,
                                BILLING: billing,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Sunday Planing', '<?= $result_seLogin['PersonCode'] ?>');

                            }
                        });
                    }
                    alert('บันทึกข้อมูลเรียบร้อย');
                    window.location.reload();
                }
            }
            function save_copydiagramsh()
            {
                var dateworking = "";
                var daterk = "";
                var datevlin = "";
                var datevlout = "";
                var dealerin = "";
                var datereturn = "";
                var vehicletype = "";
                var materialtype = "";
                var employeename1 = "";
                var employeename2 = "";
                var employeename3 = "";
                var thainame = "";
                var goreturn = "";
                var load = "";
                var route = "";
                var cluster = "";
                var jobstart = "";
                var jobend = "";
                var copydiagramunit = "";
                var roundamount = document.getElementById("txt_roundamount").value;
                var dn = "";
                var billing = "";
                var vehicletransportplanid = '';


                var copydiagramdatestart = document.getElementById("txt_copydiagramdatestart").value;
                var copydiagramdateend = document.getElementById("txt_copydiagramdateend").value;
                copydiagramunit = document.getElementById("txt_copydiagramunit").value;
                employeename1 = document.getElementById("txt_copydiagramemployeename1").value;
                employeename2 = document.getElementById("txt_copydiagramemployeename2").value;
                employeename3 = document.getElementById("txt_copydiagramemployeename3").value;


                thainame = document.getElementById("txt_copydiagramthainame").value;
                if (chk_copydiagramdaterk.checked == true) {
                    daterk = document.getElementById("txt_copydiagramdaterk2").value;

                } else
                {
                    daterk = document.getElementById("txt_copydiagramdaterk").value;

                }
                if (chk_copydiagramdatevlin.checked == true) {
                    datevlin = document.getElementById("txt_copydiagramdatevlin2").value;

                } else
                {
                    datevlin = document.getElementById("txt_copydiagramdatevlin").value;

                }
                if (chk_copydiagramdatevlout.checked == true) {
                    datevlout = document.getElementById("txt_copydiagramdatevlout2").value;

                } else
                {
                    datevlout = document.getElementById("txt_copydiagramdatevlout").value;

                }
                if (chk_copydiagramdatedealerin.checked == true) {
                    dealerin = document.getElementById("txt_copydiagramdatedealerin2").value;

                } else
                {
                    dealerin = document.getElementById("txt_copydiagramdatedealerin").value;

                }
                if (chk_copydiagramdatereturn.checked == true) {
                    datereturn = document.getElementById("txt_copydiagramdatereturn2").value;

                } else
                {
                    datereturn = document.getElementById("txt_copydiagramdatereturn").value;

                }

                load = document.getElementById("cb_copydiagramload").value;
                route = document.getElementById("cb_copydiagramroute").value;

                jobstart = document.getElementById("txt_copydiagramjobstart").value;
                //jobend = document.getElementById("txt_copydiagramroute").value;
                jobend = document.getElementById("txt_copydiagramsubroute").value;





                var dateinput = document.getElementById("txt_copydiagramdateinput").value;
                var datepresent = document.getElementById("txt_copydiagramdatepresent").value;



                if (checknull_copydiagram(vehicletransportplanid)) {

                    dateworking = document.getElementById("txt_copydiagramdaterk").value;

                    if (chk_copydiagrammonday.checked == true) {
                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid,
                                STARTDATE: copydiagramdatestart,
                                ENDDATE: copydiagramdateend,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame,
                                JOBSTART: jobstart,
                                CLUSTER: cluster,
                                JOBEND: jobend,
                                EMPLOYEENAME1: employeename1,
                                EMPLOYEENAME2: employeename2,
                                EMPLOYEENAME3: employeename3,
                                JOBNO: document.getElementById("txt_copydiagramjobnomonday").value,
                                DATEINPUT: dateinput,
                                DATERK: daterk,
                                DATEPRESENT: datepresent,
                                DATEWORKING: dateworking,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn,
                                VEHICLETYPE: vehicletype,
                                MATERIALTYPE: materialtype,
                                GORETURN: goreturn,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load,
                                ROUTE: route,
                                UNIT: copydiagramunit,
                                ROUNDAMOUNT: roundamount,
                                DN: dn,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame2").value,
                                BILLING: billing,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'


                            },
                            success: function (rs) {
                                save_logprocess('Planing', 'Save Monday Planing', '<?= $result_seLogin['PersonCode'] ?>');
                            }
                        });
                    }
                    if (chk_copydiagramtuesday.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid,
                                STARTDATE: copydiagramdatestart,
                                ENDDATE: copydiagramdateend,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame,
                                JOBSTART: jobstart,
                                CLUSTER: cluster,
                                JOBEND: jobend,
                                EMPLOYEENAME1: employeename1,
                                EMPLOYEENAME2: employeename2,
                                EMPLOYEENAME3: employeename3,
                                JOBNO: document.getElementById("txt_copydiagramjobnotuesday").value,
                                DATEINPUT: dateinput,
                                DATERK: daterk,
                                DATEPRESENT: datepresent,
                                DATEWORKING: dateworking,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn,
                                VEHICLETYPE: vehicletype,
                                MATERIALTYPE: materialtype,
                                GORETURN: goreturn,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load,
                                ROUTE: route,
                                UNIT: copydiagramunit,
                                ROUNDAMOUNT: roundamount,
                                DN: dn,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame2").value,
                                BILLING: billing,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {

                                save_logprocess('Planing', 'Save Tuesday Planing', '<?= $result_seLogin['PersonCode'] ?>');
                            }
                        });
                    }
                    if (chk_copydiagramwednesday.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid,
                                STARTDATE: copydiagramdatestart,
                                ENDDATE: copydiagramdateend,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame,
                                JOBSTART: jobstart,
                                CLUSTER: cluster,
                                JOBEND: jobend,
                                EMPLOYEENAME1: employeename1,
                                EMPLOYEENAME2: employeename2,
                                EMPLOYEENAME3: employeename3,
                                JOBNO: document.getElementById("txt_copydiagramjobnowednesday").value,
                                DATEINPUT: dateinput,
                                DATERK: daterk,
                                DATEPRESENT: datepresent,
                                DATEWORKING: dateworking,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn,
                                VEHICLETYPE: vehicletype,
                                MATERIALTYPE: materialtype,
                                GORETURN: goreturn,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load,
                                ROUTE: route,
                                UNIT: copydiagramunit,
                                ROUNDAMOUNT: roundamount,
                                DN: dn,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame2").value,
                                BILLING: billing,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Wednesday Planing', '<?= $result_seLogin['PersonCode'] ?>');

                            }
                        });
                    }
                    if (chk_copydiagramthursday.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid,
                                STARTDATE: copydiagramdatestart,
                                ENDDATE: copydiagramdateend,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame,
                                JOBSTART: jobstart,
                                CLUSTER: cluster,
                                JOBEND: jobend,
                                EMPLOYEENAME1: employeename1,
                                EMPLOYEENAME2: employeename2,
                                EMPLOYEENAME3: employeename3,
                                JOBNO: document.getElementById("txt_copydiagramjobnothursday").value,
                                DATEINPUT: dateinput,
                                DATERK: daterk,
                                DATEPRESENT: datepresent,
                                DATEWORKING: dateworking,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn,
                                VEHICLETYPE: vehicletype,
                                MATERIALTYPE: materialtype,
                                GORETURN: goreturn,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load,
                                ROUTE: route,
                                UNIT: copydiagramunit,
                                ROUNDAMOUNT: roundamount,
                                DN: dn,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame2").value,
                                BILLING: billing,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Thursday Planing', '<?= $result_seLogin['PersonCode'] ?>');

                            }
                        });
                    }
                    if (chk_copydiagramfriday.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid,
                                STARTDATE: copydiagramdatestart,
                                ENDDATE: copydiagramdateend,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame,
                                JOBSTART: jobstart,
                                CLUSTER: cluster,
                                JOBEND: jobend,
                                EMPLOYEENAME1: employeename1,
                                EMPLOYEENAME2: employeename2,
                                EMPLOYEENAME3: employeename3,
                                JOBNO: document.getElementById("txt_copydiagramjobnofriday").value,
                                DATEINPUT: dateinput,
                                DATERK: daterk,
                                DATEPRESENT: datepresent,
                                DATEWORKING: dateworking,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn,
                                VEHICLETYPE: vehicletype,
                                MATERIALTYPE: materialtype,
                                GORETURN: goreturn,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load,
                                ROUTE: route,
                                UNIT: copydiagramunit,
                                ROUNDAMOUNT: roundamount,
                                DN: dn,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame2").value,
                                BILLING: billing,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Friday Planing', '<?= $result_seLogin['PersonCode'] ?>');


                            }
                        });
                    }
                    if (chk_copydiagramsaturday.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid,
                                STARTDATE: copydiagramdatestart,
                                ENDDATE: copydiagramdateend,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame,
                                JOBSTART: jobstart,
                                CLUSTER: cluster,
                                JOBEND: jobend,
                                EMPLOYEENAME1: employeename1,
                                EMPLOYEENAME2: employeename2,
                                EMPLOYEENAME3: employeename3,
                                JOBNO: document.getElementById("txt_copydiagramjobnosaturday").value,
                                DATEINPUT: dateinput,
                                DATERK: daterk,
                                DATEPRESENT: datepresent,
                                DATEWORKING: dateworking,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn,
                                VEHICLETYPE: vehicletype,
                                MATERIALTYPE: materialtype,
                                GORETURN: goreturn,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load,
                                ROUTE: route,
                                UNIT: copydiagramunit,
                                ROUNDAMOUNT: roundamount,
                                DN: dn,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame2").value,
                                BILLING: billing,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Saturday Planing', '<?= $result_seLogin['PersonCode'] ?>');

                            }
                        });
                    }
                    if (chk_copydiagramsunday.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid,
                                STARTDATE: copydiagramdatestart,
                                ENDDATE: copydiagramdateend,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame,
                                JOBSTART: jobstart,
                                CLUSTER: cluster,
                                JOBEND: jobend,
                                EMPLOYEENAME1: employeename1,
                                EMPLOYEENAME2: employeename2,
                                EMPLOYEENAME3: employeename3,
                                JOBNO: document.getElementById("txt_copydiagramjobnosunday").value,
                                DATEINPUT: dateinput,
                                DATERK: daterk,
                                DATEPRESENT: datepresent,
                                DATEWORKING: dateworking,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn,
                                VEHICLETYPE: vehicletype,
                                MATERIALTYPE: materialtype,
                                GORETURN: goreturn,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load,
                                ROUTE: route,
                                UNIT: copydiagramunit,
                                ROUNDAMOUNT: roundamount,
                                DN: dn,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame2").value,
                                BILLING: billing,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {

                                save_logprocess('Planing', 'Save Sunday Planing', '<?= $result_seLogin['PersonCode'] ?>');
                            }
                        });
                    }
                    alert('บันทึกข้อมูลเรียบร้อย');
                    window.location.reload();
                }
            }
            function save_copydiagram()
            {
                var dateworking = "";
                var daterk = "";
                var datevlin = "";
                var datevlout = "";
                var dealerin = "";
                var datereturn = "";
                var vehicletype = "";
                var materialtype = "";
                var employeename1 = "";
                var employeename2 = "";
                var employeename3 = "";
                var thainame = "";
                var goreturn = "";
                var worktype = "";
                var load = "";
                var route = "";
                var cluster = "";
                var jobstart = "";
                var jobend = "";
                var copydiagramunit = "";
                var roundamount = document.getElementById("txt_roundamount").value;
                var dn = "";
                var billing = "";


                dn = "";


                var vehicletransportplanid = '';
                if (document.getElementById("txt_copydiagramvehicletransportplanid").value == '')
                {
                    vehicletransportplanid = '';
                } else
                {
                    vehicletransportplanid = document.getElementById("txt_copydiagramvehicletransportplanid").value;
                }

                var copydiagramdatestart = document.getElementById("txt_copydiagramdatestart").value;
                var copydiagramdateend = document.getElementById("txt_copydiagramdateend").value;





                copydiagramunit = document.getElementById("txt_copydiagramunit").value;






                if (vehicletransportplanid == '')
                {
                    employeename1 = document.getElementById("txt_copydiagramemployeename1").value;
                    employeename2 = document.getElementById("txt_copydiagramemployeename2").value;

                    employeename3 = document.getElementById("txt_copydiagramemployeename3").value;


                    thainame = document.getElementById("txt_copydiagramthainame").value;
                    if (chk_copydiagramdaterk.checked == true) {
                        daterk = document.getElementById("txt_copydiagramdaterk2").value;

                    } else
                    {
                        daterk = document.getElementById("txt_copydiagramdaterk").value;

                    }
                    if (chk_copydiagramdatevlin.checked == true) {
                        datevlin = document.getElementById("txt_copydiagramdatevlin2").value;

                    } else
                    {
                        datevlin = document.getElementById("txt_copydiagramdatevlin").value;

                    }
                    if (chk_copydiagramdatevlout.checked == true) {
                        datevlout = document.getElementById("txt_copydiagramdatevlout2").value;

                    } else
                    {
                        datevlout = document.getElementById("txt_copydiagramdatevlout").value;

                    }
                    if (chk_copydiagramdatedealerin.checked == true) {
                        dealerin = document.getElementById("txt_copydiagramdatedealerin2").value;

                    } else
                    {
                        dealerin = document.getElementById("txt_copydiagramdatedealerin").value;

                    }
                    if (chk_copydiagramdatereturn.checked == true) {
                        datereturn = document.getElementById("txt_copydiagramdatereturn2").value;

                    } else
                    {
                        datereturn = document.getElementById("txt_copydiagramdatereturn").value;

                    }
                } else
                {
                    employeename1 = document.getElementById("txt_copydiagramemployeenameupd1").value;
                    employeename2 = document.getElementById("txt_copydiagramemployeenameupd2").value;
                    thainame = document.getElementById("txt_copydiagramthainameupd").value;
                    if (chk_copydiagramdatevlinupd.checked == true) {
                        daterk = document.getElementById("txt_copydiagramdaterkupd2").value;
                    } else
                    {
                        daterk = document.getElementById("txt_copydiagramdaterkupd").value;

                    }
                    alert(daterk);
                    if (chk_copydiagramdatevlinupd.checked == true) {
                        datevlin = document.getElementById("txt_copydiagramdatevlinupd2").value;
                    } else
                    {
                        datevlin = document.getElementById("txt_copydiagramdatevlinupd").value;

                    }
                    if (chk_copydiagramdatevloutupd.checked == true) {
                        datevlout = document.getElementById("txt_copydiagramdatevloutupd2").value;
                    } else
                    {
                        datevlout = document.getElementById("txt_copydiagramdatevloutupd").value;
                    }
                    if (chk_copydiagramdatedealerinupd.checked == true) {
                        dealerin = document.getElementById("txt_copydiagramdatedealerinupd2").value;
                    } else
                    {
                        dealerin = document.getElementById("txt_copydiagramdatedealerinupd").value;
                    }
                    if (chk_copydiagramdatereturnupd.checked == true) {
                        datereturn = document.getElementById("txt_copydiagramdatereturnupd2").value;
                    } else
                    {
                        datereturn = document.getElementById("txt_copydiagramdatereturnupd").value;
                    }
                }



                //var jobstartrcc = $('#txt_copydiagramjobstart11').val().toString();


                cluster = document.getElementById("txt_copydiagramcluster").value;
                jobstart = $('#txt_copydiagramjobstart11').val().toString();
                jobend = document.getElementById("txt_copydiagramjobend").value;

                // alert(cluster);



                var dateinput = document.getElementById("txt_copydiagramdateinput").value;
                var datepresent = document.getElementById("txt_copydiagramdatepresent").value;




                if (checknull_copydiagram(vehicletransportplanid)) {

                    dateworking = document.getElementById("txt_copydiagramdaterk").value;

                    if (chk_copydiagrammonday.checked == true) {
                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid,
                                STARTDATE: copydiagramdatestart,
                                ENDDATE: copydiagramdateend,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame,
                                JOBSTART: jobstart,
                                CLUSTER: cluster,
                                JOBEND: jobend,
                                EMPLOYEENAME1: employeename1,
                                EMPLOYEENAME2: employeename2,
                                EMPLOYEENAME3: employeename3,
                                JOBNO: document.getElementById("txt_copydiagramjobnomonday").value,
                                DATEINPUT: dateinput,
                                DATERK: daterk,
                                DATEPRESENT: datepresent,
                                DATEWORKING: dateworking,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn,
                                VEHICLETYPE: vehicletype,
                                MATERIALTYPE: materialtype,
                                GORETURN: goreturn,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load,
                                ROUTE: route,
                                UNIT: copydiagramunit,
                                ROUNDAMOUNT: roundamount,
                                DN: dn,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame2").value,
                                BILLING: billing,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'
                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Monday Planing', '<?= $result_seLogin['PersonCode'] ?>');
                            }
                        });
                    }
                    if (chk_copydiagramtuesday.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid,
                                STARTDATE: copydiagramdatestart,
                                ENDDATE: copydiagramdateend,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame,
                                JOBSTART: jobstart,
                                CLUSTER: cluster,
                                JOBEND: jobend,
                                EMPLOYEENAME1: employeename1,
                                EMPLOYEENAME2: employeename2,
                                EMPLOYEENAME3: employeename3,
                                JOBNO: document.getElementById("txt_copydiagramjobnotuesday").value,
                                DATEINPUT: dateinput,
                                DATERK: daterk,
                                DATEPRESENT: datepresent,
                                DATEWORKING: dateworking,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn,
                                VEHICLETYPE: vehicletype,
                                MATERIALTYPE: materialtype,
                                GORETURN: goreturn,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load,
                                ROUTE: route,
                                UNIT: copydiagramunit,
                                ROUNDAMOUNT: roundamount,
                                DN: dn,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame2").value,
                                BILLING: billing,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Tuesday Planing', '<?= $result_seLogin['PersonCode'] ?>');

                            }
                        });
                    }
                    if (chk_copydiagramwednesday.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid,
                                STARTDATE: copydiagramdatestart,
                                ENDDATE: copydiagramdateend,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame,
                                JOBSTART: jobstart,
                                CLUSTER: cluster,
                                JOBEND: jobend,
                                EMPLOYEENAME1: employeename1,
                                EMPLOYEENAME2: employeename2,
                                EMPLOYEENAME3: employeename3,
                                JOBNO: document.getElementById("txt_copydiagramjobnowednesday").value,
                                DATEINPUT: dateinput,
                                DATERK: daterk,
                                DATEPRESENT: datepresent,
                                DATEWORKING: dateworking,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn,
                                VEHICLETYPE: vehicletype,
                                MATERIALTYPE: materialtype,
                                GORETURN: goreturn,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load,
                                ROUTE: route,
                                UNIT: copydiagramunit,
                                ROUNDAMOUNT: roundamount,
                                DN: dn,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame2").value,
                                BILLING: billing,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Wednesday Planing', '<?= $result_seLogin['PersonCode'] ?>');

                            }
                        });
                    }
                    if (chk_copydiagramthursday.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid,
                                STARTDATE: copydiagramdatestart,
                                ENDDATE: copydiagramdateend,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame,
                                JOBSTART: jobstart,
                                CLUSTER: cluster,
                                JOBEND: jobend,
                                EMPLOYEENAME1: employeename1,
                                EMPLOYEENAME2: employeename2,
                                EMPLOYEENAME3: employeename3,
                                JOBNO: document.getElementById("txt_copydiagramjobnothursday").value,
                                DATEINPUT: dateinput,
                                DATERK: daterk,
                                DATEPRESENT: datepresent,
                                DATEWORKING: dateworking,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn,
                                VEHICLETYPE: vehicletype,
                                MATERIALTYPE: materialtype,
                                GORETURN: goreturn,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load,
                                ROUTE: route,
                                UNIT: copydiagramunit,
                                ROUNDAMOUNT: roundamount,
                                DN: dn,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame2").value,
                                BILLING: billing,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Thursday Planing', '<?= $result_seLogin['PersonCode'] ?>');

                            }
                        });
                    }
                    if (chk_copydiagramfriday.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid,
                                STARTDATE: copydiagramdatestart,
                                ENDDATE: copydiagramdateend,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame,
                                JOBSTART: jobstart,
                                CLUSTER: cluster,
                                JOBEND: jobend,
                                EMPLOYEENAME1: employeename1,
                                EMPLOYEENAME2: employeename2,
                                EMPLOYEENAME3: employeename3,
                                JOBNO: document.getElementById("txt_copydiagramjobnofriday").value,
                                DATEINPUT: dateinput,
                                DATERK: daterk,
                                DATEPRESENT: datepresent,
                                DATEWORKING: dateworking,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn,
                                VEHICLETYPE: vehicletype,
                                MATERIALTYPE: materialtype,
                                GORETURN: goreturn,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load,
                                ROUTE: route,
                                UNIT: copydiagramunit,
                                ROUNDAMOUNT: roundamount,
                                DN: dn,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame2").value,
                                BILLING: billing,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Friday Planing', '<?= $result_seLogin['PersonCode'] ?>');

                            }
                        });
                    }
                    if (chk_copydiagramsaturday.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid,
                                STARTDATE: copydiagramdatestart,
                                ENDDATE: copydiagramdateend,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame,
                                JOBSTART: jobstart,
                                CLUSTER: cluster,
                                JOBEND: jobend,
                                EMPLOYEENAME1: employeename1,
                                EMPLOYEENAME2: employeename2,
                                EMPLOYEENAME3: employeename3,
                                JOBNO: document.getElementById("txt_copydiagramjobnosaturday").value,
                                DATEINPUT: dateinput,
                                DATERK: daterk,
                                DATEPRESENT: datepresent,
                                DATEWORKING: dateworking,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn,
                                VEHICLETYPE: vehicletype,
                                MATERIALTYPE: materialtype,
                                GORETURN: goreturn,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load,
                                ROUTE: route,
                                UNIT: copydiagramunit,
                                ROUNDAMOUNT: roundamount,
                                DN: dn,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame2").value,
                                BILLING: billing,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {

                                save_logprocess('Planing', 'Save Saturday Planing', '<?= $result_seLogin['PersonCode'] ?>');
                            }
                        });
                    }
                    if (chk_copydiagramsunday.checked == true) {

                        $.ajax({
                            type: 'post',
                            url: 'meg_data.php',
                            data: {
                                txt_flg: "save_copydiagramvehicletransportplan",
                                VEHICLETRANSPORTPLANID: vehicletransportplanid,
                                STARTDATE: copydiagramdatestart,
                                ENDDATE: copydiagramdateend,
                                CUSTOMERCODE: '<?= $_GET['customercode'] ?>',
                                COMPANYCODE: '<?= $_GET['companycode'] ?>',
                                THAINAME: thainame,
                                JOBSTART: jobstart,
                                CLUSTER: cluster,
                                JOBEND: jobend,
                                EMPLOYEENAME1: employeename1,
                                EMPLOYEENAME2: employeename2,
                                EMPLOYEENAME3: employeename3,
                                JOBNO: document.getElementById("txt_copydiagramjobnosunday").value,
                                DATEINPUT: dateinput,
                                DATERK: daterk,
                                DATEPRESENT: datepresent,
                                DATEWORKING: dateworking,
                                DATEVLIN: datevlin,
                                DATEVLOUT: datevlout,
                                DATEDEALERIN: dealerin,
                                DATERETURN: datereturn,
                                VEHICLETYPE: vehicletype,
                                MATERIALTYPE: materialtype,
                                GORETURN: goreturn,
                                WORKTYPE: '<?= $_GET['worktype'] ?>',
                                LOAD: load,
                                ROUTE: route,
                                UNIT: copydiagramunit,
                                ROUNDAMOUNT: roundamount,
                                DN: dn,
                                CARRYTYPE: '<?= $_GET['carrytype'] ?>',
                                THAINAME2: document.getElementById("txt_copydiagramthainame2").value,
                                BILLING: billing,
                                CREATEBY: '<?= $result_seEmployee["PersonCode"] ?>'

                            },
                            success: function () {
                                save_logprocess('Planing', 'Save Sunday Planing', '<?= $result_seLogin['PersonCode'] ?>');

                            }
                        });
                    }
                    alert('บันทึกข้อมูลเรียบร้อย');
                    window.location.reload();
                }
            }

            function save_copyjob() {

                var JOBNO = document.getElementById("txt_jobno").value;
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "save_copyjobvehicletransportplan", JOBNO: JOBNO, ROWSAMOUNT: document.getElementById("txt_rowsamount").value
                    },
                    success: function () {

                        window.location.reload();
                    }
                });



            }
            function select_copyjob(jobno, jobstrat, jobend, startdate) {
                // alert(jobno);
                // alert(jobstrat);
                // alert(jobend);
                // alert(startdate);
                document.getElementById("title_copyjob").innerHTML = '<b>Copy Job เส้นทาง21 : ' + jobstrat + '-' + jobend + '</b>';
                document.getElementById("txt_startdatejobcopy").value = startdate;
                document.getElementById("txt_jobno").value = jobno;
            }

            function select_vehicletransportplanid(vehicletransportplanid, jobstrat, jobend) {

                $(document).ready(function () {

                    document.getElementById("title").innerHTML = '<b>เส้นทาง : ' + jobstrat + '-' + jobend + '</b>';
                    document.getElementById("txt_vehicletransportplanid").value = vehicletransportplanid;
                    document.getElementById("txt_route").value = jobstrat + '-' + jobend;
                });
                showupdate_vehicletransportdocument(vehicletransportplanid);
                showupdate_vehicletransportactual(vehicletransportplanid);
            }

        </script>
        <script>
            $('#exampleModal').on('show', function () {
            })
        </script>
        <script language="JavaScript">
            document.onkeyup = function (e) {
                if (e.ctrlKey && e.which == 67) {

                }
            };
        </script>

        <script>

            function change_textboxdate()
            {
                if (chk_copydiagramdaterk.checked == true) {
                    document.getElementById("txt_copydiagramdaterk2").style.display = '';
                    document.getElementById("txt_copydiagramdaterk").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdaterk2").style.display = 'none';
                    document.getElementById("txt_copydiagramdaterk").style.display = '';
                }
                if (chk_copydiagramdatevlin.checked == true) {
                    document.getElementById("txt_copydiagramdatevlin2").style.display = '';
                    document.getElementById("txt_copydiagramdatevlin").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdatevlin2").style.display = 'none';
                    document.getElementById("txt_copydiagramdatevlin").style.display = '';
                }
                if (chk_copydiagramdatevlout.checked == true) {
                    document.getElementById("txt_copydiagramdatevlout2").style.display = '';
                    document.getElementById("txt_copydiagramdatevlout").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdatevlout2").style.display = 'none';
                    document.getElementById("txt_copydiagramdatevlout").style.display = '';
                }
                if (chk_copydiagramdatedealerin.checked == true) {

                    document.getElementById("txt_copydiagramdatedealerin2").style.display = '';
                    document.getElementById("txt_copydiagramdatedealerin").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdatedealerin2").style.display = 'none';
                    document.getElementById("txt_copydiagramdatedealerin").style.display = '';
                }
                if (chk_copydiagramdatereturn.checked == true) {
                    document.getElementById("txt_copydiagramdatereturn2").style.display = '';
                    document.getElementById("txt_copydiagramdatereturn").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdatereturn2").style.display = 'none';
                    document.getElementById("txt_copydiagramdatereturn").style.display = '';
                }
            }
            function change_textboxdateshn()
            {
                if (chk_copydiagramdaterkshn.checked == true) {
                    document.getElementById("txt_copydiagramdaterk2shn").style.display = '';
                    document.getElementById("txt_copydiagramdaterkshn").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdaterk2shn").style.display = 'none';
                    document.getElementById("txt_copydiagramdaterkshn").style.display = '';
                }
                if (chk_copydiagramdatevlinshn.checked == true) {
                    document.getElementById("txt_copydiagramdatevlin2shn").style.display = '';
                    document.getElementById("txt_copydiagramdatevlinshn").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdatevlin2shn").style.display = 'none';
                    document.getElementById("txt_copydiagramdatevlinshn").style.display = '';
                }
                if (chk_copydiagramdatevloutshn.checked == true) {
                    document.getElementById("txt_copydiagramdatevlout2shn").style.display = '';
                    document.getElementById("txt_copydiagramdatevloutshn").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdatevlout2shn").style.display = 'none';
                    document.getElementById("txt_copydiagramdatevloutshn").style.display = '';
                }
                if (chk_copydiagramdatedealerinshn.checked == true) {

                    document.getElementById("txt_copydiagramdatedealerin2shn").style.display = '';
                    document.getElementById("txt_copydiagramdatedealerinshn").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdatedealerin2shn").style.display = 'none';
                    document.getElementById("txt_copydiagramdatedealerinshn").style.display = '';
                }
                if (chk_copydiagramdatereturnshn.checked == true) {
                    document.getElementById("txt_copydiagramdatereturn2shn").style.display = '';
                    document.getElementById("txt_copydiagramdatereturnshn").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdatereturn2shn").style.display = 'none';
                    document.getElementById("txt_copydiagramdatereturnshn").style.display = '';
                }
            }
            function change_textboxdate21()
            {
                if (chk_copydiagramdaterk21.checked == true) {
                    document.getElementById("txt_copydiagramdaterk221").style.display = '';
                    document.getElementById("txt_copydiagramdaterk21").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdaterk221").style.display = 'none';
                    document.getElementById("txt_copydiagramdaterk21").style.display = '';
                }
                if (chk_copydiagramdatevlin21.checked == true) {
                    document.getElementById("txt_copydiagramdatevlin221").style.display = '';
                    document.getElementById("txt_copydiagramdatevlin21").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdatevlin221").style.display = 'none';
                    document.getElementById("txt_copydiagramdatevlin21").style.display = '';
                }
                if (chk_copydiagramdatevlout21.checked == true) {
                    document.getElementById("txt_copydiagramdatevlout221").style.display = '';
                    document.getElementById("txt_copydiagramdatevlout21").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdatevlout221").style.display = 'none';
                    document.getElementById("txt_copydiagramdatevlout21").style.display = '';
                }
                if (chk_copydiagramdatedealerin21.checked == true) {

                    document.getElementById("txt_copydiagramdatedealerin221").style.display = '';
                    document.getElementById("txt_copydiagramdatedealerin21").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdatedealerin221").style.display = 'none';
                    document.getElementById("txt_copydiagramdatedealerin21").style.display = '';
                }
                if (chk_copydiagramdatereturn21.checked == true) {
                    document.getElementById("txt_copydiagramdatereturn221").style.display = '';
                    document.getElementById("txt_copydiagramdatereturn21").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdatereturn221").style.display = 'none';
                    document.getElementById("txt_copydiagramdatereturn21").style.display = '';
                }
            }
            function change_textboxdate22()
            {
                if (chk_copydiagramdaterk22.checked == true) {
                    document.getElementById("txt_copydiagramdaterk222").style.display = '';
                    document.getElementById("txt_copydiagramdaterk22").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdaterk222").style.display = 'none';
                    document.getElementById("txt_copydiagramdaterk22").style.display = '';
                }
                if (chk_copydiagramdatevlin22.checked == true) {
                    document.getElementById("txt_copydiagramdatevlin222").style.display = '';
                    document.getElementById("txt_copydiagramdatevlin22").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdatevlin222").style.display = 'none';
                    document.getElementById("txt_copydiagramdatevlin22").style.display = '';
                }
                if (chk_copydiagramdatevlout22.checked == true) {
                    document.getElementById("txt_copydiagramdatevlout222").style.display = '';
                    document.getElementById("txt_copydiagramdatevlout22").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdatevlout222").style.display = 'none';
                    document.getElementById("txt_copydiagramdatevlout22").style.display = '';
                }
                if (chk_copydiagramdatedealerin22.checked == true) {

                    document.getElementById("txt_copydiagramdatedealerin222").style.display = '';
                    document.getElementById("txt_copydiagramdatedealerin22").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdatedealerin222").style.display = 'none';
                    document.getElementById("txt_copydiagramdatedealerin22").style.display = '';
                }
                if (chk_copydiagramdatereturn22.checked == true) {
                    document.getElementById("txt_copydiagramdatereturn222").style.display = '';
                    document.getElementById("txt_copydiagramdatereturn22").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdatereturn222").style.display = 'none';
                    document.getElementById("txt_copydiagramdatereturn22").style.display = '';
                }
            }
            function change_textboxdate21_sh()
            {
                if (chk_copydiagramdaterk21_sh.checked == true) {
                    document.getElementById("txt_copydiagramdaterk221_sh").style.display = '';
                    document.getElementById("txt_copydiagramdaterk21_sh").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdaterk221_sh").style.display = 'none';
                    document.getElementById("txt_copydiagramdaterk21_sh").style.display = '';
                }
                if (chk_copydiagramdatevlin21_sh.checked == true) {
                    document.getElementById("txt_copydiagramdatevlin221_sh").style.display = '';
                    document.getElementById("txt_copydiagramdatevlin21_sh").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdatevlin221_sh").style.display = 'none';
                    document.getElementById("txt_copydiagramdatevlin21_sh").style.display = '';
                }
                if (chk_copydiagramdatevlout21_sh.checked == true) {
                    document.getElementById("txt_copydiagramdatevlout221_sh").style.display = '';
                    document.getElementById("txt_copydiagramdatevlout21_sh").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdatevlout221_sh").style.display = 'none';
                    document.getElementById("txt_copydiagramdatevlout21_sh").style.display = '';
                }
                if (chk_copydiagramdatedealerin21_sh.checked == true) {

                    document.getElementById("txt_copydiagramdatedealerin221_sh").style.display = '';
                    document.getElementById("txt_copydiagramdatedealerin21_sh").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdatedealerin221_sh").style.display = 'none';
                    document.getElementById("txt_copydiagramdatedealerin21_sh").style.display = '';
                }
                if (chk_copydiagramdatereturn21_sh.checked == true) {
                    document.getElementById("txt_copydiagramdatereturn221_sh").style.display = '';
                    document.getElementById("txt_copydiagramdatereturn21_sh").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdatereturn221_sh").style.display = 'none';
                    document.getElementById("txt_copydiagramdatereturn21_sh").style.display = '';
                }
            }
            function change_textboxdate22_sh()
            {
                if (chk_copydiagramdaterk22_sh.checked == true) {
                    document.getElementById("txt_copydiagramdaterk222_sh").style.display = '';
                    document.getElementById("txt_copydiagramdaterk22_sh").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdaterk222_sh").style.display = 'none';
                    document.getElementById("txt_copydiagramdaterk22_sh").style.display = '';
                }
                if (chk_copydiagramdatevlin22_sh.checked == true) {
                    document.getElementById("txt_copydiagramdatevlin222_sh").style.display = '';
                    document.getElementById("txt_copydiagramdatevlin22_sh").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdatevlin222_sh").style.display = 'none';
                    document.getElementById("txt_copydiagramdatevlin22_sh").style.display = '';
                }
                if (chk_copydiagramdatevlout22_sh.checked == true) {
                    document.getElementById("txt_copydiagramdatevlout222_sh").style.display = '';
                    document.getElementById("txt_copydiagramdatevlout22_sh").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdatevlout222_sh").style.display = 'none';
                    document.getElementById("txt_copydiagramdatevlout22_sh").style.display = '';
                }
                if (chk_copydiagramdatedealerin22_sh.checked == true) {

                    document.getElementById("txt_copydiagramdatedealerin222_sh").style.display = '';
                    document.getElementById("txt_copydiagramdatedealerin22_sh").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdatedealerin222_sh").style.display = 'none';
                    document.getElementById("txt_copydiagramdatedealerin22_sh").style.display = '';
                }
                if (chk_copydiagramdatereturn22_sh.checked == true) {
                    document.getElementById("txt_copydiagramdatereturn222_sh").style.display = '';
                    document.getElementById("txt_copydiagramdatereturn22_sh").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdatereturn222_sh").style.display = 'none';
                    document.getElementById("txt_copydiagramdatereturn22_sh").style.display = '';
                }
            }
            function change_textboxdate31()
            {
                if (chk_copydiagramdaterk31.checked == true) {
                    document.getElementById("txt_copydiagramdaterk231").style.display = '';
                    document.getElementById("txt_copydiagramdaterk31").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdaterk231").style.display = 'none';
                    document.getElementById("txt_copydiagramdaterk31").style.display = '';
                }
                if (chk_copydiagramdatevlin31.checked == true) {
                    document.getElementById("txt_copydiagramdatevlin231").style.display = '';
                    document.getElementById("txt_copydiagramdatevlin31").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdatevlin231").style.display = 'none';
                    document.getElementById("txt_copydiagramdatevlin31").style.display = '';
                }
                if (chk_copydiagramdatevlout31.checked == true) {
                    document.getElementById("txt_copydiagramdatevlout231").style.display = '';
                    document.getElementById("txt_copydiagramdatevlout31").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdatevlout231").style.display = 'none';
                    document.getElementById("txt_copydiagramdatevlout31").style.display = '';
                }
                if (chk_copydiagramdatedealerin31.checked == true) {

                    document.getElementById("txt_copydiagramdatedealerin231").style.display = '';
                    document.getElementById("txt_copydiagramdatedealerin31").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdatedealerin231").style.display = 'none';
                    document.getElementById("txt_copydiagramdatedealerin31").style.display = '';
                }
                if (chk_copydiagramdatereturn31.checked == true) {
                    document.getElementById("txt_copydiagramdatereturn231").style.display = '';
                    document.getElementById("txt_copydiagramdatereturn31").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdatereturn231").style.display = 'none';
                    document.getElementById("txt_copydiagramdatereturn31").style.display = '';
                }
            }
            function change_textboxdate32()
            {
                if (chk_copydiagramdaterk32.checked == true) {
                    document.getElementById("txt_copydiagramdaterk232").style.display = '';
                    document.getElementById("txt_copydiagramdaterk32").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdaterk232").style.display = 'none';
                    document.getElementById("txt_copydiagramdaterk32").style.display = '';
                }
                if (chk_copydiagramdatevlin32.checked == true) {
                    document.getElementById("txt_copydiagramdatevlin232").style.display = '';
                    document.getElementById("txt_copydiagramdatevlin32").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdatevlin232").style.display = 'none';
                    document.getElementById("txt_copydiagramdatevlin32").style.display = '';
                }
                if (chk_copydiagramdatevlout32.checked == true) {
                    document.getElementById("txt_copydiagramdatevlout232").style.display = '';
                    document.getElementById("txt_copydiagramdatevlout32").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdatevlout232").style.display = 'none';
                    document.getElementById("txt_copydiagramdatevlout32").style.display = '';
                }
                if (chk_copydiagramdatedealerin32.checked == true) {

                    document.getElementById("txt_copydiagramdatedealerin232").style.display = '';
                    document.getElementById("txt_copydiagramdatedealerin32").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdatedealerin232").style.display = 'none';
                    document.getElementById("txt_copydiagramdatedealerin32").style.display = '';
                }
                if (chk_copydiagramdatereturn32.checked == true) {
                    document.getElementById("txt_copydiagramdatereturn232").style.display = '';
                    document.getElementById("txt_copydiagramdatereturn32").style.display = 'none';
                } else
                {
                    document.getElementById("txt_copydiagramdatereturn232").style.display = 'none';
                    document.getElementById("txt_copydiagramdatereturn32").style.display = '';
                }
            }
            function show_timepresentupd(data)
            {
                if (chk_copydiagramdatevlinupd.checked == true) {
                    var rs = (parseInt(data.substr(11, 2)) - 1) + data.substr(13, 5);
                    document.getElementById("txt_copydiagramdatepresentupd").value = rs;
                } else
                {
                    var rs = parseInt(data.substring(0, 2)) - 1;
                    rs = rs + data.substring(2, 5);
                    document.getElementById("txt_copydiagramdatepresentupd").value = rs;
                }
            }
            function show_timepresentshn(data)
            {

                if (chk_copydiagramdaterkshn.checked == true) {

                    // if (data.substr(11, 2) == '00')
                    // {
                    //     var rs = '23' + data.substr(13, 5);
                    //     document.getElementById("txt_copydiagramdatepresentshn").value = rs;
                    // } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                    // {
                    //     var rs = parseInt(data.substr(11, 2)) - 1;
                    //     rs = rs + data.substr(13, 5);
                    //     document.getElementById("txt_copydiagramdatepresentshn").value = rs;
                    // } else
                    // {
                    //     var rs = parseInt(data.substr(11, 2)) - 1;
                    //     rs = rs + data.substr(13, 5);
                    //     document.getElementById("txt_copydiagramdatepresentshn").value = rs;
                    // }

                    if (document.getElementById("txt_copydiagramjobstartshn").value == "GW" ){
                            //GW -1 ชั่วโมง 
                            // alert("งานSH กดข้ามวันต้นทาง GW");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(1, 'hours').format('YYYY/MM/DD HH:mm');
                            
                            document.getElementById("txt_copydiagramdatepresentshn").value = newDateTime;

                      
                            
                        }else if (document.getElementById("txt_copydiagramjobstartshn").value == "BP" || document.getElementById("txt_copydiagramjobstartshn").value == "BP(STOCK48RAI)"
                        || document.getElementById("txt_copydiagramjobstartshn").value == "BP25RAI" || document.getElementById("txt_copydiagramjobstartshn").value == "SW" 
                        || document.getElementById("txt_copydiagramjobstartshn").value == "SP"){
                            // BP,BP(STOCK48RAI),BP25RAI,SW,SP -2  ชั่วโมง  
                            // alert("งานSH กดข้ามวันต้นทาง BP,BP(STOCK48RAI),BP25RAI,SW,SP");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(2, 'hours').format('YYYY/MM/DD HH:mm');
                    
                        document.getElementById("txt_copydiagramdatepresentshn").value = newDateTime;
                            
                           
                        }else if (document.getElementById("txt_copydiagramjobstartshn").value == "SR" || document.getElementById("txt_copydiagramjobstartshn").value == "TAC"
                        || document.getElementById("txt_copydiagramjobstartshn").value == "Lenso" || document.getElementById("txt_copydiagramjobstartshn").value == "LCB"){
                            // SR,TAC,Lenso,LCB -3   ชั่วโมง
                            // alert("งานSH กดข้ามวันต้นทาง BP,BP(STOCK48RAI),BP25RAI,SW,SP");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(3, 'hours').format('YYYY/MM/DD HH:mm');
                    
                        document.getElementById("txt_copydiagramdatepresentshn").value = newDateTime;  
                            
                        }else{
                            // อื่นๆไม่ลบชั่วโมง  
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(0, 'hours').format('YYYY/MM/DD HH:mm');
                        
                            document.getElementById("txt_copydiagramdatepresentshn").value = newDateTime;

                        }

                } else
                {



                    if ('<?= $_GET['worktype'] ?>' == 'sh')
                    {
                        
                        if (data.substring(0, 2) == '00')
                        {
                            var rs = '23' + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresentshn").value = rs;
                        } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                        {
                            var rs = parseInt(data.substring(0, 2)) - 1;
                            rs = rs + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresentshn").value = rs;
                        } else
                        {

                            var rs = parseInt(data.substring(0, 2)) - 1;
                            rs = rs + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresentshn").value = rs;
                        }
                    } else
                    {
                        if (document.getElementById("txt_copydiagramjobstartshn").value == "GW")
                        {
                            if (data.substring(0, 2) == '00')
                            {
                                var rs = '23' + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresentshn").value = rs;
                            } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                            {
                                var rs = parseInt(data.substring(0, 2)) - 1;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresentshn").value = rs;
                            } else
                            {
                                var rs = parseInt(data.substring(0, 2)) - 1;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresentshn").value = rs;
                            }
                        } else if (document.getElementById("txt_copydiagramjobstartshn").value == "BP" || document.getElementById("txt_copydiagramjobstartshn").value == "BP25"
                        || document.getElementById("txt_copydiagramjobstartshn").value == "BP25RAI" || document.getElementById("txt_copydiagramjobstartshn").value == "SP"
                        || document.getElementById("txt_copydiagramjobstartshn").value == "SW" || document.getElementById("txt_copydiagramjobstartshn").value == "BP(STOCK48RAI)")
                        {

                            if (data.substring(0, 2) == '00')
                            {
                                var rs = '23' + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresentshn").value = rs;
                            } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                            {
                                var rs = parseInt(data.substring(0, 2)) - 2;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresentshn").value = rs;
                            } else
                            {
                                var rs = parseInt(data.substring(0, 2)) - 2;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresentshn").value = rs;
                            }
                        } else if (document.getElementById("txt_copydiagramjobstartshn").value == "SR" || document.getElementById("txt_copydiagramjobstartshn").value == "TAC")
                        {

                            if (data.substring(0, 2) == '00')
                            {
                                var rs = '23' + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresentshn").value = rs;
                            } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                            {
                                var rs = parseInt(data.substring(0, 2)) - 3;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresentshn").value = rs;
                            } else
                            {
                                var rs = parseInt(data.substring(0, 2)) - 3;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresentshn").value = rs;
                            }
                        } else
                        {


                            var rs = parseInt(data.substring(0, 2)) - document.getElementById("txt_beforpersentothshn").value;
                            rs = rs + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresentshn").value = rs;


                        }
                    }

                }
            }
            function show_timepresent(data)
            {
                // alert(data);
                // กรณีกดข้ามวัน
                if (chk_copydiagramdaterk.checked == true) {
                   // alert("ข้ามวัน1");
                    // if (data.substr(11, 2) == '00')
                    // {
                    //     var rs = '23' + data.substr(13, 5);
                    //     document.getElementById("txt_copydiagramdatepresent").value = rs;
                    // } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                    // {
                    //     var rs = parseInt(data.substr(11, 2)) - 1;
                    //     rs = rs + data.substr(13, 5);
                    //     document.getElementById("txt_copydiagramdatepresent").value = rs;
                    // } else
                    // {
                    //     var rs = parseInt(data.substr(11, 2)) - 1;
                    //     rs = rs + data.substr(13, 5);
                    //     document.getElementById("txt_copydiagramdatepresent").value = rs;
                    // }
                    
                    // var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                    // alert(datechk);
                    // var startDateTime = datechk;
                    // var startDateTime = '09-07-2021 00:00'
                    // alert(startDateTime);
                    // var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(1, 'hours').format('YYYY/MM/DD HH:mm');
                    // alert(newDateTime);
                    // document.getElementById("txt_copydiagramdatepresent").value = newDateTime;

                    //วางแผนงานSH 
                    if ('<?= $_GET['worktype'] ?>' == 'sh')
                    {   
                            // alert("งานSH กดข้ามวัน");
                        if (document.getElementById("txt_copydiagramjobstart").value == "GW" ){
                            //GW -1 ชั่วโมง 
                            // alert("งานSH กดข้ามวันต้นทาง GW");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(1, 'hours').format('YYYY/MM/DD HH:mm');
                            
                            document.getElementById("txt_copydiagramdatepresent").value = newDateTime;

                      
                            
                        }else if (document.getElementById("txt_copydiagramjobstart").value == "BP" || document.getElementById("txt_copydiagramjobstart").value == "BP(STOCK48RAI)"
                        || document.getElementById("txt_copydiagramjobstart").value == "BP25RAI" || document.getElementById("txt_copydiagramjobstart").value == "SW" 
                        || document.getElementById("txt_copydiagramjobstart").value == "SP"){
                            // BP,BP(STOCK48RAI),BP25RAI,SW,SP -2  ชั่วโมง  
                            // alert("งานSH กดข้ามวันต้นทาง BP,BP(STOCK48RAI),BP25RAI,SW,SP");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(2, 'hours').format('YYYY/MM/DD HH:mm');
                    
                        document.getElementById("txt_copydiagramdatepresent").value = newDateTime;
                            
                           
                        }else if (document.getElementById("txt_copydiagramjobstart").value == "SR" || document.getElementById("txt_copydiagramjobstart").value == "TAC"
                        || document.getElementById("txt_copydiagramjobstart").value == "Lenso" || document.getElementById("txt_copydiagramjobstart").value == "LCB"){
                            // SR,TAC,Lenso,LCB -3   ชั่วโมง
                            // alert("งานSH กดข้ามวันต้นทาง BP,BP(STOCK48RAI),BP25RAI,SW,SP");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(3, 'hours').format('YYYY/MM/DD HH:mm');
                    
                        document.getElementById("txt_copydiagramdatepresent").value = newDateTime;  
                            
                        }else{
                            // อื่นๆไม่ลบชั่วโมง  
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(0, 'hours').format('YYYY/MM/DD HH:mm');
                        
                            document.getElementById("txt_copydiagramdatepresent").value = newDateTime;

                        }
                        
                    } else
                    {

                        //วางแผนงาน NM OR SH(N) กดข้ามวัน
                        if (document.getElementById("txt_copydiagramjobstart11").value == "GW")
                        {
                            // alert("งานSH กดข้ามวันต้นทาง GW");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(1, 'hours').format('YYYY/MM/DD HH:mm');
                        
                            document.getElementById("txt_copydiagramdatepresent").value = newDateTime;

                        } else if (document.getElementById("txt_copydiagramjobstart11").value == "BP" || document.getElementById("txt_copydiagramjobstart11").value == "BP25"
                        || document.getElementById("txt_copydiagramjobstart11").value == "BP25RAI" || document.getElementById("txt_copydiagramjobstart11").value == "SW" 
                        || document.getElementById("txt_copydiagramjobstart11").value == "SP")
                        {
                            // BP,BP(STOCK48RAI),BP25RAI,SW,SP -2    
                            // alert("งานSH กดข้ามวันต้นทาง BP,BP(STOCK48RAI),BP25RAI,SW,SP");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(2, 'hours').format('YYYY/MM/DD HH:mm');
                        
                            document.getElementById("txt_copydiagramdatepresent").value = newDateTime;

                        } else if (document.getElementById("txt_copydiagramjobstart11").value == "SR" || document.getElementById("txt_copydiagramjobstart11").value == "TAC"
                         || document.getElementById("txt_copydiagramjobstart11").value == "LCB" )
                        {
                            // SR,TAC,Lenso,LCB -3   
                            // alert("งานSH กดข้ามวันต้นทาง BP,BP(STOCK48RAI),BP25RAI,SW,SP");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(3, 'hours').format('YYYY/MM/DD HH:mm');
                        
                            document.getElementById("txt_copydiagramdatepresent").value = newDateTime;

                        } else
                        {
                            // อื่นๆไม่ลบชั่วโมง  
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(0, 'hours').format('YYYY/MM/DD HH:mm');
                        
                            document.getElementById("txt_copydiagramdatepresent").value = newDateTime;
                            


                        }
                    }    
                } else
                {

                    // alert(2); 
                    //วางแผนSH
                    if ('<?= $_GET['worktype'] ?>' == 'sh')
                    {   
                        if (document.getElementById("txt_copydiagramjobstart").value == "GW"){

                                if (data.substring(0, 2) == '00')
                            {
                                var rs = '23' + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent").value = rs;
                            } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                            {
                                var rs = parseInt(data.substring(0, 2)) - 1;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent").value = rs;
                            } else
                            {

                                var rs = parseInt(data.substring(0, 2)) - 1;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent").value = rs;
                            }

                        }else if (document.getElementById("txt_copydiagramjobstart").value == "BP" || document.getElementById("txt_copydiagramjobstart").value == "BP(STOCK48RAI)"
                        || document.getElementById("txt_copydiagramjobstart").value == "BP25RAI" || document.getElementById("txt_copydiagramjobstart").value == "SW" 
                        || document.getElementById("txt_copydiagramjobstart").value == "SP"){
                            
                            if (data.substring(0, 2) == '00')
                            {
                                var rs = '23' + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent").value = rs;
                            } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                            {
                                var rs = parseInt(data.substring(0, 2)) - 2;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent").value = rs;
                            } else
                            {
                                var rs = parseInt(data.substring(0, 2)) - 2;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent").value = rs;
                            }
                        }else if (document.getElementById("txt_copydiagramjobstart").value == "SR" || document.getElementById("txt_copydiagramjobstart").value == "TAC"
                        || document.getElementById("txt_copydiagramjobstart").value == "Lenso" || document.getElementById("txt_copydiagramjobstart").value == "LCB"){
                            
                            if (data.substring(0, 2) == '00')
                            {
                                var rs = '23' + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent").value = rs;
                            } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                            {
                                var rs = parseInt(data.substring(0, 2)) - 3;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent").value = rs;
                            } else
                            {
                                var rs = parseInt(data.substring(0, 2)) - 3;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent").value = rs;
                            }
                        }else{
                                if (data.substring(0, 2) == '00')
                            {
                                var rs = '23' + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent").value = rs;
                            } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                            {
                                var rs = parseInt(data.substring(0, 2)) - 1;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent").value = rs;
                            } else
                            {

                                var rs = parseInt(data.substring(0, 2)) - 1;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent").value = rs;
                            } 
                        } //else close
                        
                    } else
                    {


                        if (document.getElementById("txt_copydiagramjobstart11").value == "GW")
                        {
                            if (data.substring(0, 2) == '00')
                            {
                                var rs = '23' + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent").value = rs;
                            } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                            {
                                var rs = parseInt(data.substring(0, 2)) - 1;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent").value = rs;
                            } else
                            {
                                var rs = parseInt(data.substring(0, 2)) - 1;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent").value = rs;
                            }
                            // alert('GW');
                        } else if (document.getElementById("txt_copydiagramjobstart11").value == "BP" || document.getElementById("txt_copydiagramjobstart11").value == "BP25"
                        || document.getElementById("txt_copydiagramjobstart11").value == "BP25RAI" || document.getElementById("txt_copydiagramjobstart11").value == "SW" 
                        || document.getElementById("txt_copydiagramjobstart11").value == "SP")
                        {

                            if (data.substring(0, 2) == '00')
                            {
                                var rs = '23' + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent").value = rs;
                            } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                            {
                                var rs = parseInt(data.substring(0, 2)) - 2;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent").value = rs;
                            } else
                            {
                                var rs = parseInt(data.substring(0, 2)) - 2;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent").value = rs;
                            }
                            // alert('BP');
                        } else if (document.getElementById("txt_copydiagramjobstart11").value == "SR" || document.getElementById("txt_copydiagramjobstart11").value == "TAC"
                         || document.getElementById("txt_copydiagramjobstart11").value == "LCB" )
                        {

                            if (data.substring(0, 2) == '00')
                            {
                                var rs = '23' + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent").value = rs;
                            } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                            {
                                var rs = parseInt(data.substring(0, 2)) - 3;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent").value = rs;
                            } else
                            {
                                var rs = parseInt(data.substring(0, 2)) - 3;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent").value = rs;
                            }
                            // alert('SR');
                        } else
                        {

                            // alert('OTH');
                            var rs = parseInt(data.substring(0, 2)) - document.getElementById("txt_beforpersentoth").value;
                            rs = rs + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresent").value = rs;


                        }
                    }

                }
            }
            function show_timepresent21(data)
            {

                if (chk_copydiagramdaterk21.checked == true) {

                    // if (data.substr(11, 2) == '00')
                    // {
                    //     var rs = '23' + data.substr(13, 5);
                    //     document.getElementById("txt_copydiagramdatepresent21").value = rs;
                    // } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                    // {
                    //     var rs = parseInt(data.substr(11, 2)) - 1;
                    //     rs = rs + data.substr(13, 5);
                    //     document.getElementById("txt_copydiagramdatepresent21").value = rs;
                    // } else
                    // {
                    //     var rs = parseInt(data.substr(11, 2)) - 1;
                    //     rs = rs + data.substr(13, 5);
                    //     document.getElementById("txt_copydiagramdatepresent21").value = rs;
                    // }

                    // กรณีกดข้ามวัน
                    //วางแผนงานSH
                    // alert("ข้ามวัน2");
                    if ('<?= $_GET['worktype'] ?>' == 'sh')
                    {   
                            // alert("งานSH กดข้ามวัน");
                        if (document.getElementById("txt_copydiagramjobstart21").value == "GW"){
                            //GW -1 ชั่วโมง 
                            // alert("งานSH กดข้ามวันต้นทาง GW");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(1, 'hours').format('YYYY/MM/DD HH:mm');
                            
                            document.getElementById("txt_copydiagramdatepresent21").value = newDateTime;

                      
                            
                        }else if (document.getElementById("txt_copydiagramjobstart21").value == "BP" || document.getElementById("txt_copydiagramjobstart21").value == "BP(STOCK48RAI)"
                        || document.getElementById("txt_copydiagramjobstart21").value == "BP25RAI" || document.getElementById("txt_copydiagramjobstart21").value == "SW" 
                        || document.getElementById("txt_copydiagramjobstart21").value == "SP"){
                            // BP,BP(STOCK48RAI),BP25RAI,SW,SP -2  ชั่วโมง  
                            // alert("งานSH กดข้ามวันต้นทาง BP,BP(STOCK48RAI),BP25RAI,SW,SP");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(2, 'hours').format('YYYY/MM/DD HH:mm');
                    
                        document.getElementById("txt_copydiagramdatepresent21").value = newDateTime;
                            
                           
                        }else if (document.getElementById("txt_copydiagramjobstart21").value == "SR" || document.getElementById("txt_copydiagramjobstart21").value == "TAC"
                        || document.getElementById("txt_copydiagramjobstart21").value == "Lenso" || document.getElementById("txt_copydiagramjobstart21").value == "LCB"){
                            // SR,TAC,Lenso,LCB -3   ชั่วโมง
                            // alert("งานSH กดข้ามวันต้นทาง BP,BP(STOCK48RAI),BP25RAI,SW,SP");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(3, 'hours').format('YYYY/MM/DD HH:mm');
                    
                        document.getElementById("txt_copydiagramdatepresent21").value = newDateTime;  
                            
                        }else{
                            // อื่นๆไม่ลบชั่วโมง  
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(0, 'hours').format('YYYY/MM/DD HH:mm');
                        
                            document.getElementById("txt_copydiagramdatepresent21").value = newDateTime;

                        }
                        
                    } else
                    {

                        //วางแผนงาน NM OR SH(N) กดข้ามวัน
                        if (document.getElementById("txt_copydiagramjobstart21").value == "GW")
                        {
                            // alert("งานSH กดข้ามวันต้นทาง GW");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(1, 'hours').format('YYYY/MM/DD HH:mm');
                        
                        document.getElementById("txt_copydiagramdatepresent21").value = newDateTime;

                        } else if (document.getElementById("txt_copydiagramjobstart21").value == "BP" || document.getElementById("txt_copydiagramjobstart21").value == "BP25"
                        || document.getElementById("txt_copydiagramjobstart21").value == "BP25RAI" || document.getElementById("txt_copydiagramjobstart21").value == "SW" 
                        || document.getElementById("txt_copydiagramjobstart21").value == "SP")
                        {
                            // BP,BP(STOCK48RAI),BP25RAI,SW,SP -2    
                            // alert("งานSH กดข้ามวันต้นทาง BP,BP(STOCK48RAI),BP25RAI,SW,SP");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(2, 'hours').format('YYYY/MM/DD HH:mm');
                        
                            document.getElementById("txt_copydiagramdatepresent21").value = newDateTime;

                        } else if (document.getElementById("txt_copydiagramjobstart21").value == "SR" || document.getElementById("txt_copydiagramjobstart21").value == "TAC"
                         || document.getElementById("txt_copydiagramjobstart21").value == "LCB" )
                        {
                            // SR,TAC,Lenso,LCB -3   
                            // alert("งานSH กดข้ามวันต้นทาง BP,BP(STOCK48RAI),BP25RAI,SW,SP");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(3, 'hours').format('YYYY/MM/DD HH:mm');
                        
                            document.getElementById("txt_copydiagramdatepresent21").value = newDateTime;

                        } else
                        {
                            // อื่นๆไม่ลบชั่วโมง  
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(0, 'hours').format('YYYY/MM/DD HH:mm');
                        
                            document.getElementById("txt_copydiagramdatepresent21").value = newDateTime;
                            


                        }
                    }  //else close

                } else
                {



                    if ('<?= $_GET['worktype'] ?>' == 'sh')
                    {
                        if (data.substring(0, 2) == '00')
                        {
                            var rs = '23' + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresent21").value = rs;
                        } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                        {
                            var rs = parseInt(data.substring(0, 2)) - 1;
                            rs = rs + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresent21").value = rs;
                        } else
                        {

                            var rs = parseInt(data.substring(0, 2)) - 1;
                            rs = rs + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresent21").value = rs;
                        }
                    } else
                    {

                        if (document.getElementById("txt_copydiagramjobstart21").value == "GW")
                        {
                            if (data.substring(0, 2) == '00')
                            {
                                var rs = '23' + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent21").value = rs;
                            } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                            {
                                var rs = parseInt(data.substring(0, 2)) - 1;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent21").value = rs;
                            } else
                            {
                                var rs = parseInt(data.substring(0, 2)) - 1;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent21").value = rs;
                            }
                        } else if (document.getElementById("txt_copydiagramjobstart21").value == "BP" || document.getElementById("txt_copydiagramjobstart21").value == "BP25"
                        || document.getElementById("txt_copydiagramjobstart21").value == "BP25RAI" || document.getElementById("txt_copydiagramjobstart21").value == "SW"
                        || document.getElementById("txt_copydiagramjobstart21").value == "SP")
                        {
                            if (data.substring(0, 2) == '00')
                            {
                                var rs = '23' + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent21").value = rs;
                            } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                            {
                                var rs = parseInt(data.substring(0, 2)) - 2;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent21").value = rs;
                            } else
                            {
                                var rs = parseInt(data.substring(0, 2)) - 2;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent21").value = rs;
                            }
                        } else if (document.getElementById("txt_copydiagramjobstart21").value == "SR" || document.getElementById("txt_copydiagramjobstart21").value == "TAC"
                        || document.getElementById("txt_copydiagramjobstart21").value == "LCB" || document.getElementById("txt_copydiagramjobstart21").value == "Lenso" )
                        {

                            if (data.substring(0, 2) == '00')
                            {
                                var rs = '23' + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent21").value = rs;
                            } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                            {
                                var rs = parseInt(data.substring(0, 2)) - 3;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent21").value = rs;
                            } else
                            {
                                var rs = parseInt(data.substring(0, 2)) - 3;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent21").value = rs;
                            }
                        } else
                        {


                            var rs = parseInt(data.substring(0, 2)) - document.getElementById("txt_beforpersentoth21").value;
                            rs = rs + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresent21").value = rs;


                        }
                    }

                }
            }
            function show_timepresent22(data)
            {
                if (chk_copydiagramdaterk22.checked == true) {

                    // if (data.substr(11, 2) == '00')
                    // {
                    //     var rs = '23' + data.substr(13, 5);

                    //     document.getElementById("txt_copydiagramdatepresent22").value = rs;
                    // } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                    // {
                    //     var rs = parseInt(data.substr(11, 2)) - 1;
                    //     rs = rs + data.substr(13, 5);
                    //     document.getElementById("txt_copydiagramdatepresent22").value = rs;
                    // } else
                    // {
                    //     var rs = parseInt(data.substr(11, 2)) - 1;
                    //     rs = rs + data.substr(13, 5);
                    //     document.getElementById("txt_copydiagramdatepresent22").value = rs;
                    // }

                    // กรณีกดข้ามวัน
                    //วางแผนงานSH
                    // alert("ข้ามวัน2");
                    if ('<?= $_GET['worktype'] ?>' == 'sh')
                    {   
                            // alert("งานSH กดข้ามวัน");
                        if (document.getElementById("txt_copydiagramjobstart22").value == "GW"){
                            //GW -1 ชั่วโมง 
                            // alert("งานSH กดข้ามวันต้นทาง GW");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(1, 'hours').format('YYYY/MM/DD HH:mm');
                            
                            document.getElementById("txt_copydiagramdatepresent22").value = newDateTime;

                      
                            
                        }else if (document.getElementById("txt_copydiagramjobstart22").value == "BP" || document.getElementById("txt_copydiagramjobstart22").value == "BP(STOCK48RAI)"
                        || document.getElementById("txt_copydiagramjobstart22").value == "BP25RAI" || document.getElementById("txt_copydiagramjobstart22").value == "SW" 
                        || document.getElementById("txt_copydiagramjobstart22").value == "SP"){
                            // BP,BP(STOCK48RAI),BP25RAI,SW,SP -2  ชั่วโมง  
                            // alert("งานSH กดข้ามวันต้นทาง BP,BP(STOCK48RAI),BP25RAI,SW,SP");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(2, 'hours').format('YYYY/MM/DD HH:mm');
                    
                        document.getElementById("txt_copydiagramdatepresent22").value = newDateTime;
                            
                           
                        }else if (document.getElementById("txt_copydiagramjobstart22").value == "SR" || document.getElementById("txt_copydiagramjobstart22").value == "TAC"
                        || document.getElementById("txt_copydiagramjobstart22").value == "Lenso" || document.getElementById("txt_copydiagramjobstart22").value == "LCB"){
                            // SR,TAC,Lenso,LCB -3   ชั่วโมง
                            // alert("งานSH กดข้ามวันต้นทาง BP,BP(STOCK48RAI),BP25RAI,SW,SP");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(3, 'hours').format('YYYY/MM/DD HH:mm');
                    
                        document.getElementById("txt_copydiagramdatepresent22").value = newDateTime;  
                            
                        }else{
                            // อื่นๆไม่ลบชั่วโมง  
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(0, 'hours').format('YYYY/MM/DD HH:mm');
                        
                            document.getElementById("txt_copydiagramdatepresent22").value = newDateTime;

                        }
                        
                    } else
                    {

                        //วางแผนงาน NM OR SH(N) กดข้ามวัน
                        if (document.getElementById("txt_copydiagramjobstart22").value == "GW")
                        {
                            // alert("งานSH กดข้ามวันต้นทาง GW");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(1, 'hours').format('YYYY/MM/DD HH:mm');
                        
                        document.getElementById("txt_copydiagramdatepresent22").value = newDateTime;

                        } else if (document.getElementById("txt_copydiagramjobstart22").value == "BP" || document.getElementById("txt_copydiagramjobstart22").value == "BP25"
                        || document.getElementById("txt_copydiagramjobstart22").value == "BP25RAI" || document.getElementById("txt_copydiagramjobstart22").value == "SW" 
                        || document.getElementById("txt_copydiagramjobstart22").value == "SP")
                        {
                            // BP,BP(STOCK48RAI),BP25RAI,SW,SP -2    
                            // alert("งานSH กดข้ามวันต้นทาง BP,BP(STOCK48RAI),BP25RAI,SW,SP");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(2, 'hours').format('YYYY/MM/DD HH:mm');
                        
                            document.getElementById("txt_copydiagramdatepresent22").value = newDateTime;

                        } else if (document.getElementById("txt_copydiagramjobstart22").value == "SR" || document.getElementById("txt_copydiagramjobstart22").value == "TAC"
                         || document.getElementById("txt_copydiagramjobstart22").value == "LCB" )
                        {
                            // SR,TAC,Lenso,LCB -3   
                            // alert("งานSH กดข้ามวันต้นทาง BP,BP(STOCK48RAI),BP25RAI,SW,SP");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(3, 'hours').format('YYYY/MM/DD HH:mm');
                        
                            document.getElementById("txt_copydiagramdatepresent22").value = newDateTime;

                        } else
                        {
                            // อื่นๆไม่ลบชั่วโมง  
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(0, 'hours').format('YYYY/MM/DD HH:mm');
                        
                            document.getElementById("txt_copydiagramdatepresent22").value = newDateTime;
                            


                        }
                    }  //else close


                } else
                {



                    if ('<?= $_GET['worktype'] ?>' == 'sh')
                    {
                        if (data.substring(0, 2) == '00')
                        {
                            var rs = '23' + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresent22").value = rs;
                        } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                        {
                            var rs = parseInt(data.substring(0, 2)) - 1;
                            rs = rs + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresent22").value = rs;
                        } else
                        {

                            var rs = parseInt(data.substring(0, 2)) - 1;
                            rs = rs + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresent22").value = rs;
                        }
                    } else
                    {
                        if (document.getElementById("txt_copydiagramjobstart22").value == "GW")
                        {
                            if (data.substring(0, 2) == '00')
                            {
                                var rs = '23' + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent22").value = rs;
                            } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                            {
                                var rs = parseInt(data.substring(0, 2)) - 1;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent22").value = rs;
                            } else
                            {
                                var rs = parseInt(data.substring(0, 2)) - 1;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent22").value = rs;
                            }
                        } else if (document.getElementById("txt_copydiagramjobstart22").value == "BP" || document.getElementById("txt_copydiagramjobstart22").value == "BP25"
                        || document.getElementById("txt_copydiagramjobstart22").value == "BP25RAI" || document.getElementById("txt_copydiagramjobstart22").value == "SW"
                        || document.getElementById("txt_copydiagramjobstart22").value == "SP")
                        {
                            if (data.substring(0, 2) == '00')
                            {
                                var rs = '23' + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent22").value = rs;
                            } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                            {
                                var rs = parseInt(data.substring(0, 2)) - 2;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent22").value = rs;
                            } else
                            {
                                var rs = parseInt(data.substring(0, 2)) - 2;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent22").value = rs;
                            }
                        } else if (document.getElementById("txt_copydiagramjobstart22").value == "SR" || document.getElementById("txt_copydiagramjobstart22").value == "TAC"
                        || document.getElementById("txt_copydiagramjobstart22").value == "LCB" || document.getElementById("txt_copydiagramjobstart22").value == "Lenso")
                        {

                            if (data.substring(0, 2) == '00')
                            {
                                var rs = '23' + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent22").value = rs;
                            } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                            {
                                var rs = parseInt(data.substring(0, 2)) - 3;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent22").value = rs;
                            } else
                            {
                                var rs = parseInt(data.substring(0, 2)) - 3;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent22").value = rs;
                            }
                        } else
                        {


                            var rs = parseInt(data.substring(0, 2)) - document.getElementById("txt_beforpersentoth22").value;
                            rs = rs + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresent22").value = rs;


                        }
                    }

                }
            }




            function show_timepresent21_sh(data)
            {
                
                if (chk_copydiagramdaterk21_sh.checked == true) {

                    // if (data.substr(11, 2) == '00')
                    // {
                    //     var rs = '23' + data.substr(13, 5);
                    //     document.getElementById("txt_copydiagramdatepresent21_sh").value = rs;
                    // } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                    // {
                    //     var rs = parseInt(data.substr(11, 2)) - 1;
                    //     rs = rs + data.substr(13, 5);
                    //     document.getElementById("txt_copydiagramdatepresent21_sh").value = rs;
                    // } else
                    // {
                    //     var rs = parseInt(data.substr(11, 2)) - 1;
                    //     rs = rs + data.substr(13, 5);
                    //     document.getElementById("txt_copydiagramdatepresent21_sh").value = rs;
                    // }

                    // กรณีกดข้ามวัน
                    //วางแผนงานSH
                    // alert("ข้ามวัน2");
                    if ('<?= $_GET['worktype'] ?>' == 'sh')
                    {   
                            // alert("งานSH กดข้ามวัน");
                        if (document.getElementById("txt_copydiagramjobstart21_sh").value == "GW"){
                            //GW -1 ชั่วโมง 
                            // alert("งานSH กดข้ามวันต้นทาง GW");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(1, 'hours').format('YYYY/MM/DD HH:mm');
                            
                            document.getElementById("txt_copydiagramdatepresent21_sh").value = newDateTime;

                      
                            
                        }else if (document.getElementById("txt_copydiagramjobstart21_sh").value == "BP" || document.getElementById("txt_copydiagramjobstart21_sh").value == "BP(STOCK48RAI)"
                        || document.getElementById("txt_copydiagramjobstart21_sh").value == "BP25RAI" || document.getElementById("txt_copydiagramjobstart21_sh").value == "SW" 
                        || document.getElementById("txt_copydiagramjobstart21_sh").value == "SP"){
                            // BP,BP(STOCK48RAI),BP25RAI,SW,SP -2  ชั่วโมง  
                            // alert("งานSH กดข้ามวันต้นทาง BP,BP(STOCK48RAI),BP25RAI,SW,SP");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(2, 'hours').format('YYYY/MM/DD HH:mm');
                    
                        document.getElementById("txt_copydiagramdatepresent21_sh").value = newDateTime;
                            
                           
                        }else if (document.getElementById("txt_copydiagramjobstart21_sh").value == "SR" || document.getElementById("txt_copydiagramjobstart21_sh").value == "TAC"
                        || document.getElementById("txt_copydiagramjobstart21_sh").value == "Lenso" || document.getElementById("txt_copydiagramjobstart21_sh").value == "LCB"){
                            // SR,TAC,Lenso,LCB -3   ชั่วโมง
                            // alert("งานSH กดข้ามวันต้นทาง BP,BP(STOCK48RAI),BP25RAI,SW,SP");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(3, 'hours').format('YYYY/MM/DD HH:mm');
                    
                        document.getElementById("txt_copydiagramdatepresent21_sh").value = newDateTime;  
                            
                        }else{
                            // อื่นๆไม่ลบชั่วโมง  
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(0, 'hours').format('YYYY/MM/DD HH:mm');
                        
                            document.getElementById("txt_copydiagramdatepresent21_sh").value = newDateTime;

                        }
                        
                    } else
                    {

                        //วางแผนงาน NM OR SH(N) กดข้ามวัน
                        if (document.getElementById("txt_copydiagramjobstart21_sh").value == "GW")
                        {
                            // alert("งานSH กดข้ามวันต้นทาง GW");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(1, 'hours').format('YYYY/MM/DD HH:mm');
                        
                        document.getElementById("txt_copydiagramdatepresent21_sh").value = newDateTime;

                        } else if (document.getElementById("txt_copydiagramjobstart21_sh").value == "BP" || document.getElementById("txt_copydiagramjobstart21_sh").value == "BP25"
                        || document.getElementById("txt_copydiagramjobstart21_sh").value == "BP25RAI" || document.getElementById("txt_copydiagramjobstart21_sh").value == "SW" 
                        || document.getElementById("txt_copydiagramjobstart21_sh").value == "SP")
                        {
                            // BP,BP(STOCK48RAI),BP25RAI,SW,SP -2    
                            // alert("งานSH กดข้ามวันต้นทาง BP,BP(STOCK48RAI),BP25RAI,SW,SP");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(2, 'hours').format('YYYY/MM/DD HH:mm');
                        
                            document.getElementById("txt_copydiagramdatepresent21_sh").value = newDateTime;

                        } else if (document.getElementById("txt_copydiagramjobstart21_sh").value == "SR" || document.getElementById("txt_copydiagramjobstart21_sh").value == "TAC"
                         || document.getElementById("txt_copydiagramjobstart21_sh").value == "LCB" )
                        {
                            // SR,TAC,Lenso,LCB -3   
                            // alert("งานSH กดข้ามวันต้นทาง BP,BP(STOCK48RAI),BP25RAI,SW,SP");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(3, 'hours').format('YYYY/MM/DD HH:mm');
                        
                            document.getElementById("txt_copydiagramdatepresent21_sh").value = newDateTime;

                        } else
                        {
                            // อื่นๆไม่ลบชั่วโมง  
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(0, 'hours').format('YYYY/MM/DD HH:mm');
                        
                            document.getElementById("txt_copydiagramdatepresent21_sh").value = newDateTime;
                            


                        }
                    }  //else close

                } else
                {



                    /*if ('<?//= $_GET['worktype'] ?>' == 'sh')
                     {
                     if (data.substring(0, 2) == '00')
                     {
                     var rs = '23' + data.substring(2, 5);
                     document.getElementById("txt_copydiagramdatepresent21_sh").value = rs;
                     } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                     {
                     var rs = parseInt(data.substring(0, 2)) - 1;
                     rs = rs + data.substring(2, 5);
                     document.getElementById("txt_copydiagramdatepresent21_sh").value = rs;
                     } else
                     {
                     
                     var rs = parseInt(data.substring(0, 2)) - 1;
                     rs = rs + data.substring(2, 5);
                     document.getElementById("txt_copydiagramdatepresent21_sh").value = rs;
                     }
                     } else
                     {*/
                    if (document.getElementById("txt_copydiagramjobstart21_sh").value == "GW")
                    {
                        if (data.substring(0, 2) == '00')
                        {
                            var rs = '23' + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresent21_sh").value = rs;
                        } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                        {
                            var rs = parseInt(data.substring(0, 2)) - 1;
                            rs = rs + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresent21_sh").value = rs;
                        } else
                        {
                            var rs = parseInt(data.substring(0, 2)) - 1;
                            rs = rs + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresent21_sh").value = rs;
                        }

                    } else if (document.getElementById("txt_copydiagramjobstart21_sh").value == "BP" || document.getElementById("txt_copydiagramjobstart21_sh").value == "BP25"
                    || document.getElementById("txt_copydiagramjobstart21_sh").value == "BP25RAI" || document.getElementById("txt_copydiagramjobstart21_sh").value == "SW"
                    || document.getElementById("txt_copydiagramjobstart21_sh").value == "SP" || document.getElementById("txt_copydiagramjobstart21_sh").value == "BP(STOCK48RAI)")
                    {

                        if (data.substring(0, 2) == '00')
                        {
                            var rs = '23' + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresent21_sh").value = rs;
                        } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                        {
                            var rs = parseInt(data.substring(0, 2)) - 2;
                            rs = rs + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresent21_sh").value = rs;
                        } else
                        {
                            var rs = parseInt(data.substring(0, 2)) - 2;
                            rs = rs + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresent21_sh").value = rs;
                        }
                    } else if (document.getElementById("txt_copydiagramjobstart21_sh").value == "SR" || document.getElementById("txt_copydiagramjobstart21_sh").value == "TAC"
                    || document.getElementById("txt_copydiagramjobstart21_sh").value == "Lenso" || document.getElementById("txt_copydiagramjobstart21_sh").value == "LCB" )
                    {

                        if (data.substring(0, 2) == '00')
                        {
                            var rs = '23' + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresent21_sh").value = rs;
                        } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                        {
                            var rs = parseInt(data.substring(0, 2)) - 3;
                            rs = rs + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresent21_sh").value = rs;
                        } else
                        {
                            var rs = parseInt(data.substring(0, 2)) - 3;
                            rs = rs + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresent21_sh").value = rs;
                        }
                    } else
                    {


                        var rs = parseInt(data.substring(0, 2)) - document.getElementById("txt_beforpersentoth21_sh").value;
                        rs = rs + data.substring(2, 5);
                        document.getElementById("txt_copydiagramdatepresent21_sh").value = rs;


                    }
                    //}

                }
            }
            function show_timepresent22_sh(data)
            {
                if (chk_copydiagramdaterk22_sh.checked == true) {

                    // if (data.substr(11, 2) == '00')
                    // {
                    //     var rs = '23' + data.substr(13, 5);

                    //     document.getElementById("txt_copydiagramdatepresent22_sh").value = rs;
                    // } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                    // {
                    //     var rs = parseInt(data.substr(11, 2)) - 1;
                    //     rs = rs + data.substr(13, 5);
                    //     document.getElementById("txt_copydiagramdatepresent22_sh").value = rs;
                    // } else
                    // {
                    //     var rs = parseInt(data.substr(11, 2)) - 1;
                    //     rs = rs + data.substr(13, 5);
                    //     document.getElementById("txt_copydiagramdatepresent22_sh").value = rs;
                    // }
                    
                    // กรณีกดข้ามวัน
                    //วางแผนงานSH
                    // alert("ข้ามวัน2");
                    if ('<?= $_GET['worktype'] ?>' == 'sh')
                    {   
                            // alert("งานSH กดข้ามวัน");
                        if (document.getElementById("txt_copydiagramjobstart22_sh").value == "GW"){
                            //GW -1 ชั่วโมง 
                            // alert("งานSH กดข้ามวันต้นทาง GW");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(1, 'hours').format('YYYY/MM/DD HH:mm');
                            
                            document.getElementById("txt_copydiagramdatepresent22_sh").value = newDateTime;

                      
                            
                        }else if (document.getElementById("txt_copydiagramjobstart22_sh").value == "BP" || document.getElementById("txt_copydiagramjobstart22_sh").value == "BP(STOCK48RAI)"
                        || document.getElementById("txt_copydiagramjobstart22_sh").value == "BP25RAI" || document.getElementById("txt_copydiagramjobstart22_sh").value == "SW" 
                        || document.getElementById("txt_copydiagramjobstart22_sh").value == "SP"){
                            // BP,BP(STOCK48RAI),BP25RAI,SW,SP -2  ชั่วโมง  
                            // alert("งานSH กดข้ามวันต้นทาง BP,BP(STOCK48RAI),BP25RAI,SW,SP");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(2, 'hours').format('YYYY/MM/DD HH:mm');
                    
                        document.getElementById("txt_copydiagramdatepresent22_sh").value = newDateTime;
                            
                           
                        }else if (document.getElementById("txt_copydiagramjobstart22_sh").value == "SR" || document.getElementById("txt_copydiagramjobstart22_sh").value == "TAC"
                        || document.getElementById("txt_copydiagramjobstart22_sh").value == "Lenso" || document.getElementById("txt_copydiagramjobstart22_sh").value == "LCB"){
                            // SR,TAC,Lenso,LCB -3   ชั่วโมง
                            // alert("งานSH กดข้ามวันต้นทาง BP,BP(STOCK48RAI),BP25RAI,SW,SP");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(3, 'hours').format('YYYY/MM/DD HH:mm');
                    
                        document.getElementById("txt_copydiagramdatepresent22_sh").value = newDateTime;  
                            
                        }else{
                            // อื่นๆไม่ลบชั่วโมง  
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(0, 'hours').format('YYYY/MM/DD HH:mm');
                        
                            document.getElementById("txt_copydiagramdatepresent22_sh").value = newDateTime;

                        }
                        
                    } else
                    {

                        //วางแผนงาน NM OR SH(N) กดข้ามวัน
                        if (document.getElementById("txt_copydiagramjobstart22_sh").value == "GW")
                        {
                            // alert("งานSH กดข้ามวันต้นทาง GW");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(1, 'hours').format('YYYY/MM/DD HH:mm');
                        
                        document.getElementById("txt_copydiagramdatepresent22_sh").value = newDateTime;

                        } else if (document.getElementById("txt_copydiagramjobstart22_sh").value == "BP" || document.getElementById("txt_copydiagramjobstart22_sh").value == "BP25"
                        || document.getElementById("txt_copydiagramjobstart22_sh").value == "BP25RAI" || document.getElementById("txt_copydiagramjobstart22_sh").value == "SW" 
                        || document.getElementById("txt_copydiagramjobstart22_sh").value == "SP")
                        {
                            // BP,BP(STOCK48RAI),BP25RAI,SW,SP -2    
                            // alert("งานSH กดข้ามวันต้นทาง BP,BP(STOCK48RAI),BP25RAI,SW,SP");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(2, 'hours').format('YYYY/MM/DD HH:mm');
                        
                            document.getElementById("txt_copydiagramdatepresent22_sh").value = newDateTime;

                        } else if (document.getElementById("txt_copydiagramjobstart22_sh").value == "SR" || document.getElementById("txt_copydiagramjobstart22_sh").value == "TAC"
                         || document.getElementById("txt_copydiagramjobstart22_sh").value == "LCB" )
                        {
                            // SR,TAC,Lenso,LCB -3   
                            // alert("งานSH กดข้ามวันต้นทาง BP,BP(STOCK48RAI),BP25RAI,SW,SP");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(3, 'hours').format('YYYY/MM/DD HH:mm');
                        
                            document.getElementById("txt_copydiagramdatepresent22_sh").value = newDateTime;

                        } else
                        {
                            // อื่นๆไม่ลบชั่วโมง  
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(0, 'hours').format('YYYY/MM/DD HH:mm');
                        
                            document.getElementById("txt_copydiagramdatepresent22_sh").value = newDateTime;
                            


                        }
                    }  //else close

                } else
                {



                    /*if ('<?//= $_GET['worktype'] ?>' == 'sh')
                     {
                     if (data.substring(0, 2) == '00')
                     {
                     var rs = '23' + data.substring(2, 5);
                     document.getElementById("txt_copydiagramdatepresent22_sh").value = rs;
                     } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                     {
                     var rs = parseInt(data.substring(0, 2)) - 1;
                     rs = rs + data.substring(2, 5);
                     document.getElementById("txt_copydiagramdatepresent22_sh").value = rs;
                     } else
                     {
                     
                     var rs = parseInt(data.substring(0, 2)) - 1;
                     rs = rs + data.substring(2, 5);
                     document.getElementById("txt_copydiagramdatepresent22_sh").value = rs;
                     }
                     } else
                     {*/
                    if (document.getElementById("txt_copydiagramjobstart22_sh").value == "GW")
                    {
                        if (data.substring(0, 2) == '00')
                        {
                            var rs = '23' + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresent22_sh").value = rs;
                        } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                        {
                            var rs = parseInt(data.substring(0, 2)) - 1;
                            rs = rs + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresent22_sh").value = rs;
                        } else
                        {
                            var rs = parseInt(data.substring(0, 2)) - 1;
                            rs = rs + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresent22_sh").value = rs;
                        }
                    } else if (document.getElementById("txt_copydiagramjobstart22_sh").value == "BP" || document.getElementById("txt_copydiagramjobstart22_sh").value == "BP25"
                    || document.getElementById("txt_copydiagramjobstart22_sh").value == "BP25RAI" || document.getElementById("txt_copydiagramjobstart22_sh").value == "SW"
                    || document.getElementById("txt_copydiagramjobstart22_sh").value == "SP" || document.getElementById("txt_copydiagramjobstart22_sh").value == "BP(STOCK48RAI)")
                    {
                        if (data.substring(0, 2) == '00')
                        {
                            var rs = '23' + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresent22_sh").value = rs;
                        } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                        {
                            var rs = parseInt(data.substring(0, 2)) - 2;
                            rs = rs + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresent22_sh").value = rs;
                        } else
                        {
                            var rs = parseInt(data.substring(0, 2)) - 2;
                            rs = rs + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresent22_sh").value = rs;
                        }
                    } else if (document.getElementById("txt_copydiagramjobstart22_sh").value == "SR" || document.getElementById("txt_copydiagramjobstart22_sh").value == "TAC"
                    || document.getElementById("txt_copydiagramjobstart22_sh").value == "Lenso" || document.getElementById("txt_copydiagramjobstart22_sh").value == "LCB")
                    {

                        if (data.substring(0, 2) == '00')
                        {
                            var rs = '23' + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresent22_sh").value = rs;
                        } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                        {
                            var rs = parseInt(data.substring(0, 2)) - 3;
                            rs = rs + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresent22_sh").value = rs;
                        } else
                        {
                            var rs = parseInt(data.substring(0, 2)) - 3;
                            rs = rs + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresent22_sh").value = rs;
                        }
                    } else
                    {


                        var rs = parseInt(data.substring(0, 2)) - document.getElementById("txt_beforpersentoth22_sh").value;
                        rs = rs + data.substring(2, 5);
                        document.getElementById("txt_copydiagramdatepresent22_sh").value = rs;


                    }
                    //}

                }
            }





            function show_timepresent31(data)
            {
                if (chk_copydiagramdaterk31.checked == true) {

                    // if (data.substr(11, 2) == '00')
                    // {
                    //     var rs = '23' + data.substr(13, 5);
                    //     document.getElementById("txt_copydiagramdatepresent31").value = rs;
                    // } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                    // {
                    //     var rs = parseInt(data.substr(11, 2)) - 1;
                    //     rs = rs + data.substr(13, 5);
                    //     document.getElementById("txt_copydiagramdatepresent31").value = rs;
                    // } else
                    // {
                    //     var rs = parseInt(data.substr(11, 2)) - 1;
                    //     rs = rs + data.substr(13, 5);
                    //     document.getElementById("txt_copydiagramdatepresent31").value = rs;
                    // }
                    
                    // กรณีกดข้ามวัน
                    //วางแผนงานSH
                    // alert("ข้ามวัน2");
                    if ('<?= $_GET['worktype'] ?>' == 'sh')
                    {   
                            // alert("งานSH กดข้ามวัน");
                        if (document.getElementById("txt_copydiagramjobstart31").value == "GW"){
                            //GW -1 ชั่วโมง 
                            // alert("งานSH กดข้ามวันต้นทาง GW");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(1, 'hours').format('YYYY/MM/DD HH:mm');
                            
                            document.getElementById("txt_copydiagramdatepresent31").value = newDateTime;

                      
                            
                        }else if (document.getElementById("txt_copydiagramjobstart31").value == "BP" || document.getElementById("txt_copydiagramjobstart31").value == "BP(STOCK48RAI)"
                        || document.getElementById("txt_copydiagramjobstart31").value == "BP25RAI" || document.getElementById("txt_copydiagramjobstart31").value == "SW" 
                        || document.getElementById("txt_copydiagramjobstart31").value == "SP"){
                            // BP,BP(STOCK48RAI),BP25RAI,SW,SP -2  ชั่วโมง  
                            // alert("งานSH กดข้ามวันต้นทาง BP,BP(STOCK48RAI),BP25RAI,SW,SP");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(2, 'hours').format('YYYY/MM/DD HH:mm');
                    
                        document.getElementById("txt_copydiagramdatepresent31").value = newDateTime;
                            
                           
                        }else if (document.getElementById("txt_copydiagramjobstart31").value == "SR" || document.getElementById("txt_copydiagramjobstart31").value == "TAC"
                        || document.getElementById("txt_copydiagramjobstart31").value == "Lenso" || document.getElementById("txt_copydiagramjobstart31").value == "LCB"){
                            // SR,TAC,Lenso,LCB -3   ชั่วโมง
                            // alert("งานSH กดข้ามวันต้นทาง BP,BP(STOCK48RAI),BP25RAI,SW,SP");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(3, 'hours').format('YYYY/MM/DD HH:mm');
                    
                        document.getElementById("txt_copydiagramdatepresent31").value = newDateTime;  
                            
                        }else{
                            // อื่นๆไม่ลบชั่วโมง  
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(0, 'hours').format('YYYY/MM/DD HH:mm');
                        
                            document.getElementById("txt_copydiagramdatepresent31").value = newDateTime;

                        }
                        
                    } else
                    {

                        //วางแผนงาน NM OR SH(N) กดข้ามวัน
                        if (document.getElementById("txt_copydiagramjobstart31").value == "GW")
                        {
                            // alert("งานSH กดข้ามวันต้นทาง GW");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(1, 'hours').format('YYYY/MM/DD HH:mm');
                        
                        document.getElementById("txt_copydiagramdatepresent31").value = newDateTime;

                        } else if (document.getElementById("txt_copydiagramjobstart31").value == "BP" || document.getElementById("txt_copydiagramjobstart31").value == "BP25"
                        || document.getElementById("txt_copydiagramjobstart31").value == "BP25RAI" || document.getElementById("txt_copydiagramjobstart31").value == "SW" 
                        || document.getElementById("txt_copydiagramjobstart31").value == "SP")
                        {
                            // BP,BP(STOCK48RAI),BP25RAI,SW,SP -2    
                            // alert("งานSH กดข้ามวันต้นทาง BP,BP(STOCK48RAI),BP25RAI,SW,SP");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(2, 'hours').format('YYYY/MM/DD HH:mm');
                        
                            document.getElementById("txt_copydiagramdatepresent31").value = newDateTime;

                        } else if (document.getElementById("txt_copydiagramjobstart31").value == "SR" || document.getElementById("txt_copydiagramjobstart31").value == "TAC"
                         || document.getElementById("txt_copydiagramjobstart31").value == "LCB" )
                        {
                            // SR,TAC,Lenso,LCB -3   
                            // alert("งานSH กดข้ามวันต้นทาง BP,BP(STOCK48RAI),BP25RAI,SW,SP");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(3, 'hours').format('YYYY/MM/DD HH:mm');
                        
                            document.getElementById("txt_copydiagramdatepresent31").value = newDateTime;

                        } else
                        {
                            // อื่นๆไม่ลบชั่วโมง  
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(0, 'hours').format('YYYY/MM/DD HH:mm');
                        
                            document.getElementById("txt_copydiagramdatepresent31").value = newDateTime;
                            


                        }
                    }  //else close


                } else
                {



                    if ('<?= $_GET['worktype'] ?>' == 'sh')
                    {
                        // alert('SH/NM1');
                        if (document.getElementById("txt_copydiagramjobstart31").value == "GW"){
                            if (data.substring(0, 2) == '00')
                            {
                                var rs = '23' + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent31").value = rs;
                            } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                            {
                                var rs = parseInt(data.substring(0, 2)) - 1;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent31").value = rs;
                            } else
                            {

                                var rs = parseInt(data.substring(0, 2)) - 1;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent31").value = rs;
                            }
                        }else if(document.getElementById("txt_copydiagramjobstart31").value == "BP" || document.getElementById("txt_copydiagramjobstart31").value == "BP25"
                        || document.getElementById("txt_copydiagramjobstart31").value == "BP25RAI" || document.getElementById("txt_copydiagramjobstart31").value == "SP"
                        || document.getElementById("txt_copydiagramjobstart31").value == "SW" || document.getElementById("txt_copydiagramjobstart31").value == "BP(STOCK48RAI)"){

                            if (data.substring(0, 2) == '00')
                            {
                                var rs = '23' + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent31").value = rs;
                            } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                            {
                                var rs = parseInt(data.substring(0, 2)) - 2;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent31").value = rs;
                            } else
                            {
                                var rs = parseInt(data.substring(0, 2)) - 2;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent31").value = rs;
                            }
                        }else if(document.getElementById("txt_copydiagramjobstart31").value == "SR" || document.getElementById("txt_copydiagramjobstart31").value == "TAC"
                        || document.getElementById("txt_copydiagramjobstart31").value == "Lenso" || document.getElementById("txt_copydiagramjobstart31").value == "LCB"){

                            if (data.substring(0, 2) == '00')
                            {
                                var rs = '23' + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent31").value = rs;
                            } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                            {
                                var rs = parseInt(data.substring(0, 2)) - 3;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent31").value = rs;
                            } else
                            {
                                var rs = parseInt(data.substring(0, 2)) - 3;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent31").value = rs;
                            }
                        }else {
                            var rs = parseInt(data.substring(0, 2)) - document.getElementById("txt_beforpersentoth31").value;
                            rs = rs + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresent31").value = rs;
                        }
                        
                    } else
                    {
                        if (document.getElementById("txt_copydiagramjobstart31").value == "GW")
                        {
                            if (data.substring(0, 2) == '00')
                            {
                                var rs = '23' + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent31").value = rs;
                            } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                            {
                                var rs = parseInt(data.substring(0, 2)) - 1;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent31").value = rs;
                            } else
                            {
                                var rs = parseInt(data.substring(0, 2)) - 1;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent31").value = rs;
                            }
                        } else if (document.getElementById("txt_copydiagramjobstart31").value == "BP" || document.getElementById("txt_copydiagramjobstart31").value == "BP25"
                        || document.getElementById("txt_copydiagramjobstart31").value == "BP25RAI" || document.getElementById("txt_copydiagramjobstart31").value == "SP"
                        || document.getElementById("txt_copydiagramjobstart31").value == "SW" || document.getElementById("txt_copydiagramjobstart31").value == "BP(STOCK48RAI)")
                        {
                            if (data.substring(0, 2) == '00')
                            {
                                var rs = '23' + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent31").value = rs;
                            } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                            {
                                var rs = parseInt(data.substring(0, 2)) - 2;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent31").value = rs;
                            } else
                            {
                                var rs = parseInt(data.substring(0, 2)) - 2;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent31").value = rs;
                            }
                        } else if (document.getElementById("txt_copydiagramjobstart31").value == "SR" || document.getElementById("txt_copydiagramjobstart31").value == "TAC"
                        || document.getElementById("txt_copydiagramjobstart31").value == "Lenso")
                        {

                            if (data.substring(0, 2) == '00')
                            {
                                var rs = '23' + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent31").value = rs;
                            } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                            {
                                var rs = parseInt(data.substring(0, 2)) - 3;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent31").value = rs;
                            } else
                            {
                                var rs = parseInt(data.substring(0, 2)) - 3;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent31").value = rs;
                            }
                        } else
                        {


                            var rs = parseInt(data.substring(0, 2)) - document.getElementById("txt_beforpersentoth31").value;
                            rs = rs + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresent31").value = rs;


                        }
                    }

                }
            }
            function show_timepresent32(data)
            {
                if (chk_copydiagramdaterk32.checked == true) {

                    // if (data.substr(11, 2) == '00')
                    // {
                    //     var rs = '23' + data.substr(13, 5);

                    //     document.getElementById("txt_copydiagramdatepresent32").value = rs;
                    // } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                    // {
                    //     var rs = parseInt(data.substr(11, 2)) - 1;
                    //     rs = rs + data.substr(13, 5);
                    //     document.getElementById("txt_copydiagramdatepresent32").value = rs;
                    // } else
                    // {
                    //     var rs = parseInt(data.substr(11, 2)) - 1;
                    //     rs = rs + data.substr(13, 5);
                    //     document.getElementById("txt_copydiagramdatepresent32").value = rs;
                    // }

                    // กรณีกดข้ามวัน
                    //วางแผนงานSH
                    // alert("ข้ามวัน2");
                    if ('<?= $_GET['worktype'] ?>' == 'sh')
                    {   
                            // alert("งานSH กดข้ามวัน");
                        if (document.getElementById("txt_copydiagramjobstart32").value == "GW"){
                            //GW -1 ชั่วโมง 
                            // alert("งานSH กดข้ามวันต้นทาง GW");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(1, 'hours').format('YYYY/MM/DD HH:mm');
                            
                            document.getElementById("txt_copydiagramdatepresent32").value = newDateTime;

                      
                            
                        }else if (document.getElementById("txt_copydiagramjobstart32").value == "BP" || document.getElementById("txt_copydiagramjobstart32").value == "BP(STOCK48RAI)"
                        || document.getElementById("txt_copydiagramjobstart32").value == "BP25RAI" || document.getElementById("txt_copydiagramjobstart32").value == "SW" 
                        || document.getElementById("txt_copydiagramjobstart32").value == "SP"){
                            // BP,BP(STOCK48RAI),BP25RAI,SW,SP -2  ชั่วโมง  
                            // alert("งานSH กดข้ามวันต้นทาง BP,BP(STOCK48RAI),BP25RAI,SW,SP");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(2, 'hours').format('YYYY/MM/DD HH:mm');
                    
                            document.getElementById("txt_copydiagramdatepresent32").value = newDateTime;
                            
                           
                        }else if (document.getElementById("txt_copydiagramjobstart32").value == "SR" || document.getElementById("txt_copydiagramjobstart32").value == "TAC"
                        || document.getElementById("txt_copydiagramjobstart32").value == "Lenso" || document.getElementById("txt_copydiagramjobstart32").value == "LCB"){
                            // SR,TAC,Lenso,LCB -3   ชั่วโมง
                            // alert("งานSH กดข้ามวันต้นทาง BP,BP(STOCK48RAI),BP25RAI,SW,SP");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(3, 'hours').format('YYYY/MM/DD HH:mm');
                    
                            document.getElementById("txt_copydiagramdatepresent32").value = newDateTime;  
                            
                        }else{
                            // อื่นๆไม่ลบชั่วโมง  
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(0, 'hours').format('YYYY/MM/DD HH:mm');
                        
                            document.getElementById("txt_copydiagramdatepresent32").value = newDateTime;

                        }
                        
                    } else
                    {

                        //วางแผนงาน NM OR SH(N) กดข้ามวัน
                        if (document.getElementById("txt_copydiagramjobstart32").value == "GW")
                        {
                            // alert("งานSH กดข้ามวันต้นทาง GW");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(1, 'hours').format('YYYY/MM/DD HH:mm');
                        
                        document.getElementById("txt_copydiagramdatepresent32").value = newDateTime;

                        } else if (document.getElementById("txt_copydiagramjobstart32").value == "BP" || document.getElementById("txt_copydiagramjobstart32").value == "BP25"
                        || document.getElementById("txt_copydiagramjobstart32").value == "BP25RAI" || document.getElementById("txt_copydiagramjobstart32").value == "SW" 
                        || document.getElementById("txt_copydiagramjobstart32").value == "SP")
                        {
                            // BP,BP(STOCK48RAI),BP25RAI,SW,SP -2    
                            // alert("งานSH กดข้ามวันต้นทาง BP,BP(STOCK48RAI),BP25RAI,SW,SP");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(2, 'hours').format('YYYY/MM/DD HH:mm');
                        
                            document.getElementById("txt_copydiagramdatepresent32").value = newDateTime;

                        } else if (document.getElementById("txt_copydiagramjobstart32").value == "SR" || document.getElementById("txt_copydiagramjobstart32").value == "TAC"
                         || document.getElementById("txt_copydiagramjobstart32").value == "LCB" )
                        {
                            // SR,TAC,Lenso,LCB -3   
                            // alert("งานSH กดข้ามวันต้นทาง BP,BP(STOCK48RAI),BP25RAI,SW,SP");   
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(3, 'hours').format('YYYY/MM/DD HH:mm');
                        
                            document.getElementById("txt_copydiagramdatepresent32").value = newDateTime;

                        } else
                        {
                            // อื่นๆไม่ลบชั่วโมง  
                            var datechk = moment(data).format('DD-MM-YYYY HH:mm');
                            var startDateTime = datechk;
                            var newDateTime = moment(startDateTime, "DD-MM-YYYY HH:mm").subtract(0, 'hours').format('YYYY/MM/DD HH:mm');
                        
                            document.getElementById("txt_copydiagramdatepresent32").value = newDateTime;
                            


                        }
                    }  //else close

                } else
                {



                    if ('<?= $_GET['worktype'] ?>' == 'sh')
                    {
                        if (document.getElementById("txt_copydiagramjobstart32").value == "GW") {
                            if (data.substring(0, 2) == '00')
                            {
                                var rs = '23' + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent32").value = rs;
                            } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                            {
                                var rs = parseInt(data.substring(0, 2)) - 1;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent32").value = rs;
                            } else
                            {

                                var rs = parseInt(data.substring(0, 2)) - 1;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent32").value = rs;
                            }    
                        }else if(document.getElementById("txt_copydiagramjobstart32").value == "BP" || document.getElementById("txt_copydiagramjobstart32").value == "BP25"
                        || document.getElementById("txt_copydiagramjobstart32").value == "BP25RAI" || document.getElementById("txt_copydiagramjobstart32").value == "SP"
                        || document.getElementById("txt_copydiagramjobstart32").value == "SW" || document.getElementById("txt_copydiagramjobstart32").value == "BP(STOCK48RAI)"){
                            if (data.substring(0, 2) == '00')
                            {
                                var rs = '23' + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent32").value = rs;
                            } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                            {
                                var rs = parseInt(data.substring(0, 2)) - 2;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent32").value = rs;
                            } else
                            {
                                var rs = parseInt(data.substring(0, 2)) - 2;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent32").value = rs;
                            }
                        }else if(document.getElementById("txt_copydiagramjobstart32").value == "SR" || document.getElementById("txt_copydiagramjobstart32").value == "TAC"
                        || document.getElementById("txt_copydiagramjobstart32").value == "Lenso" || document.getElementById("txt_copydiagramjobstart32").value == "LCB"){
                            if (data.substring(0, 2) == '00')
                            {
                                var rs = '23' + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent32").value = rs;
                            } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                            {
                                var rs = parseInt(data.substring(0, 2)) - 3;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent32").value = rs;
                            } else
                            {
                                var rs = parseInt(data.substring(0, 2)) - 3;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent32").value = rs;
                            }
                        }else{
                                var rs = parseInt(data.substring(0, 2)) - document.getElementById("txt_beforpersentoth32").value;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent32").value = rs;
                        }
                        
                    } else
                    {
                        if (document.getElementById("txt_copydiagramjobstart32").value == "GW")
                        {
                            if (data.substring(0, 2) == '00')
                            {
                                var rs = '23' + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent32").value = rs;
                            } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                            {
                                var rs = parseInt(data.substring(0, 2)) - 1;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent32").value = rs;
                            } else
                            {
                                var rs = parseInt(data.substring(0, 2)) - 1;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent32").value = rs;
                            }
                        } else if (document.getElementById("txt_copydiagramjobstart32").value == "BP" || document.getElementById("txt_copydiagramjobstart32").value == "BP25"
                        || document.getElementById("txt_copydiagramjobstart32").value == "BP25RAI" || document.getElementById("txt_copydiagramjobstart32").value == "SP"
                        || document.getElementById("txt_copydiagramjobstart32").value == "SW" || document.getElementById("txt_copydiagramjobstart32").value == "BP(STOCK48RAI)")
                        {
                            if (data.substring(0, 2) == '00')
                            {
                                var rs = '23' + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent32").value = rs;
                            } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                            {
                                var rs = parseInt(data.substring(0, 2)) - 2;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent32").value = rs;
                            } else
                            {
                                var rs = parseInt(data.substring(0, 2)) - 2;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent32").value = rs;
                            }
                        } else if (document.getElementById("txt_copydiagramjobstart32").value == "SR" || document.getElementById("txt_copydiagramjobstart32").value == "TAC"
                        || document.getElementById("txt_copydiagramjobstart32").value == "Lenso")
                        {

                            if (data.substring(0, 2) == '00')
                            {
                                var rs = '23' + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent32").value = rs;
                            } else if (parseInt(data.substring(0, 2)) == '01' || parseInt(data.substring(0, 2)) == '02' || parseInt(data.substring(0, 2)) == '03' || parseInt(data.substring(0, 2)) == '04' || parseInt(data.substring(0, 2)) == '05' || parseInt(data.substring(0, 2)) == '06' || parseInt(data.substring(0, 2)) == '07' || parseInt(data.substring(0, 2)) == '08' || parseInt(data.substring(0, 2)) == '09')
                            {
                                var rs = parseInt(data.substring(0, 2)) - 3;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent32").value = rs;
                            } else
                            {
                                var rs = parseInt(data.substring(0, 2)) - 3;
                                rs = rs + data.substring(2, 5);
                                document.getElementById("txt_copydiagramdatepresent32").value = rs;
                            }
                        } else
                        {


                            var rs = parseInt(data.substring(0, 2)) - document.getElementById("txt_beforpersentoth32").value;
                            rs = rs + data.substring(2, 5);
                            document.getElementById("txt_copydiagramdatepresent32").value = rs;


                        }
                    }

                }
            }
        </script>
        <script language="JavaScript">


            function onDelete()
            {
                if (confirm('ยืนยันการลบข้อมูล ?') == true)
                {
                    return true;
                } else
                {
                    return false;
                }
            }
        </script>
    </body>


</html>
<?php
sqlsrv_close($conn);
?>
