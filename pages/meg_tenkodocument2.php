<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");



$sql_seSystime = "{call megGetdate_v2(?)}";
$params_seSystime = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_seSystime = sqlsrv_query($conn, $sql_seSystime, $params_seSystime);
$result_seSystime = sqlsrv_fetch_array($query_seSystime, SQLSRV_FETCH_ASSOC);


$conditionPlain = " AND a.VEHICLETRANSPORTPLANID = '" . $_GET['vehicletransportplanid'] . "'";
$sql_sePlain = "{call megVehicletransportplan_v2(?,?)}";
$params_sePlain = array(
    array('select_vehicletransportplan', SQLSRV_PARAM_IN),
    array($conditionPlain, SQLSRV_PARAM_IN)
);
$query_sePlain = sqlsrv_query($conn, $sql_sePlain, $params_sePlain);
$result_sePlain = sqlsrv_fetch_array($query_sePlain, SQLSRV_FETCH_ASSOC);





$conditionDir2 = "  AND a.PersonCode = '" . $result_sePlain["EMPLOYEECODE2"] . "'";
$sql_seDir2 = "{call megEmployeeEHR_v2(?,?)}";
$params_seDir2 = array(
    array('select_employee', SQLSRV_PARAM_IN),
    array($conditionDir2, SQLSRV_PARAM_IN)
);
$query_seDir2 = sqlsrv_query($conn, $sql_seDir2, $params_seDir2);
$result_seDir2 = sqlsrv_fetch_array($query_seDir2, SQLSRV_FETCH_ASSOC);



$condition1 = "  AND a.PersonID = '" . $_SESSION["EMPLOYEEID"] . "'";
$sql_seEmployee = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmployee = array(
    array('select_employee', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
$result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC);




$conditionTenkomaster_temp = " AND VEHICLETRANSPORTPLANID = '" . $_GET['vehicletransportplanid'] . "'";
$sql_seTenkomaster_temp = "{call megVehicletransportplan_v2(?,?,?,?)}";
$params_seTenkomaster_temp = array(
    array('select_vehicletransporttenko', SQLSRV_PARAM_IN),
    array($conditionTenkomaster_temp, SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seTenkomaster_temp = sqlsrv_query($conn, $sql_seTenkomaster_temp, $params_seTenkomaster_temp);
$result_seTenkomaster_temp = sqlsrv_fetch_array($query_seTenkomaster_temp, SQLSRV_FETCH_ASSOC);





$conditionTenkobefore2 = " AND a.TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "' AND a.TENKOMASTERDIRVERCODE = '" . $_GET['employeecode2'] . "'";
$sql_seTenkobefore2 = "{call megEdittenkobefore_v2(?,?,?)}";
$params_seTenkobefore2 = array(
    array('select_tenkobefore', SQLSRV_PARAM_IN),
    array($conditionTenkobefore2, SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seTenkobefore2 = sqlsrv_query($conn, $sql_seTenkobefore2, $params_seTenkobefore2);
$result_seTenkobefore2 = sqlsrv_fetch_array($query_seTenkobefore2, SQLSRV_FETCH_ASSOC);
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
            .chat-panel .panel-body {
                height: 100%;
            }

            html,body {   
                padding: 0;   
                margin: 0;   
                width: 100%;   
                height: 100%;             
            }   
            #overlay {   
                position: absolute;  
                top: 0px;   
                left: 0px;  
                background: #ccc;   
                width: 100%;   
                height: 100%;   
                opacity: .75;   
                filter: alpha(opacity=75);   
                -moz-opacity: .75;  
                z-index: 999;  
                background: #fff url(http://i.imgur.com/KUJoe.gif) 50% 50% no-repeat;
            }   
            .main-contain{
                position: absolute;  
                top: 0px;   
                left: 0px;  
                width: 100%;   
                height: 100%;   
                overflow: hidden;
            }

        </style>
    </head>
    <body>
        <div id="overlay"></div> 
        <div class="main-contain">
            <div class="modal fade" id="modal_tenkorestremark" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="width: 40%">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="row">
                                <div class="col-lg-5">
                                    <h5 class="modal-title" ><b>ช่วงเวลาการพักผ่อน</b></h5>
                                </div>

                            </div>
                        </div>
                        <div class="modal-body">




                            <div class="row">
                                <div class="col-lg-6">
                                    <label>เวลาเริ่มพักผ่อน  </label>
                                    <input type="text" autocomplete="off"   class="form-control datetimeen" id="txt_startrest" name="txt_startrest">

                                </div>
                                <div class="col-lg-6">
                                    <label>เวลาตื่นพักผ่อน  </label>
                                    <input type="text" autocomplete="off"   class="form-control datetimeen" id="txt_endrest" name="txt_endrest">

                                </div>

                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="save_tenkorestremark()">บันทึก</button>
                        </div>





                    </div>
                </div>
            </div>
            <div class="modal fade" id="modal_tenkosleeptimeremark" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="width: 40%">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="row">
                                <div class="col-lg-5">
                                    <h5 class="modal-title" ><b>ช่วงเวลาการนอน</b></h5>
                                </div>

                            </div>
                        </div>
                        <div class="modal-body">




                            <div class="row">
                                <div class="col-lg-6">
                                    <label>เวลาเริ่มนอน  </label>
                                    <input type="text" autocomplete="off"   class="form-control datetimeen" id="txt_startsleep" name="txt_startsleep">

                                </div>
                                <div class="col-lg-6">
                                    <label>เวลาตื่นนอน  </label>
                                    <input type="text" autocomplete="off"   class="form-control datetimeen" id="txt_endsleep" name="txt_endsleep">

                                </div>

                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> ปิด</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="save_tenkosleeptimeremark()">บันทึก</button>
                        </div>





                    </div>
                </div>
            </div>
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

                            <h5 class="page-header">

                                เอกสารเท็งโกะ


                            </h5>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <?php
                    if ($_GET['vehicletransportplanid'] != '') {
                        ?>
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">
    <?php
    $conditionTenkomaster = " AND a.TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "'";
    $sql_seTenkomaster = "{call megEdittenkomaster_v2(?,?)}";
    $params_seTenkomaster = array(
        array('select_tenkomaster', SQLSRV_PARAM_IN),
        array($conditionTenkomaster, SQLSRV_PARAM_IN)
    );
    $query_seTenkomaster = sqlsrv_query($conn, $sql_seTenkomaster, $params_seTenkomaster);
    $result_seTenkomaster = sqlsrv_fetch_array($query_seTenkomaster, SQLSRV_FETCH_ASSOC);


    echo 'เลขที่เท็งโกะ : ' . $result_seTenkomaster_temp['TENKOMASTERID'];
    ?>
                                        &emsp;<input type="checkbox" id="chk_dayone" name="chk_dayone" style="transform: scale(2)">&emsp;: <font style="color: red"><u><i> กรณี "เท็งโกะเลิกงาน->เท็งโกะเริ่มงาน" ในวันเดียวกัน</u></i></font>
                                    </div>
                                    <div class="panel-body">

                                        <div class="row" >

    <?php
    $sql_seBeforeresult1 = "{call megEdittenkobefore_v2(?,?,?)}";
    $params_seBeforeresult1 = array(
        array('select_beforeresult', SQLSRV_PARAM_IN),
        array($result_seTenkomaster_temp['TENKOMASTERID'], SQLSRV_PARAM_IN),
        array($result_seTenkomaster_temp['TENKOMASTERDIRVERCODE1'], SQLSRV_PARAM_IN)
    );
    $query_seBeforeresult1 = sqlsrv_query($conn, $sql_seBeforeresult1, $params_seBeforeresult1);
    $result_seBeforeresult1 = sqlsrv_fetch_array($query_seBeforeresult1, SQLSRV_FETCH_ASSOC);


    $sql_seBeforeresult2 = "{call megEdittenkobefore_v2(?,?,?)}";
    $params_seBeforeresult2 = array(
        array('select_beforeresult', SQLSRV_PARAM_IN),
        array($result_seTenkomaster_temp['TENKOMASTERID'], SQLSRV_PARAM_IN),
        array($result_seTenkomaster_temp['TENKOMASTERDIRVERCODE2'], SQLSRV_PARAM_IN)
    );
    $query_seBeforeresult2 = sqlsrv_query($conn, $sql_seBeforeresult2, $params_seBeforeresult2);
    $result_seBeforeresult2 = sqlsrv_fetch_array($query_seBeforeresult2, SQLSRV_FETCH_ASSOC);


    $sql_seBeforecheck1 = "{call megEdittenkobefore_v2(?,?,?)}";
    $params_seBeforecheck1 = array(
        array('select_beforecheck', SQLSRV_PARAM_IN),
        array($result_seTenkomaster_temp['TENKOMASTERID'], SQLSRV_PARAM_IN),
        array($result_seTenkomaster_temp['TENKOMASTERDIRVERCODE1'], SQLSRV_PARAM_IN)
    );
    $query_seBeforecheck1 = sqlsrv_query($conn, $sql_seBeforecheck1, $params_seBeforecheck1);
    $result_seBeforecheck1 = sqlsrv_fetch_array($query_seBeforecheck1, SQLSRV_FETCH_ASSOC);



    $sql_seBeforecheck2 = "{call megEdittenkobefore_v2(?,?,?)}";
    $params_seBeforecheck2 = array(
        array('select_beforecheck', SQLSRV_PARAM_IN),
        array($result_seTenkomaster_temp['TENKOMASTERID'], SQLSRV_PARAM_IN),
        array($result_seTenkomaster_temp['TENKOMASTERDIRVERCODE2'], SQLSRV_PARAM_IN)
    );
    $query_seBeforecheck2 = sqlsrv_query($conn, $sql_seBeforecheck2, $params_seBeforecheck2);
    $result_seBeforecheck2 = sqlsrv_fetch_array($query_seBeforecheck2, SQLSRV_FETCH_ASSOC);



    $sql_seTransportresult1 = "{call megEdittenkotransport_v2(?,?,?)}";
    $params_seTransportresult1 = array(
        array('select_transportresult', SQLSRV_PARAM_IN),
        array($result_seTenkomaster_temp['TENKOMASTERID'], SQLSRV_PARAM_IN),
        array($result_seTenkomaster_temp['TENKOMASTERDIRVERCODE1'], SQLSRV_PARAM_IN)
    );
    $query_seTransportresult1 = sqlsrv_query($conn, $sql_seTransportresult1, $params_seTransportresult1);
    $result_seTransportresult1 = sqlsrv_fetch_array($query_seTransportresult1, SQLSRV_FETCH_ASSOC);





    $sql_seTransportresult2 = "{call megEdittenkotransport_v2(?,?,?)}";
    $params_seTransportresult2 = array(
        array('select_transportresult', SQLSRV_PARAM_IN),
        array($result_seTenkomaster_temp['TENKOMASTERID'], SQLSRV_PARAM_IN),
        array($result_seTenkomaster_temp['TENKOMASTERDIRVERCODE2'], SQLSRV_PARAM_IN)
    );
    $query_seTransportresult2 = sqlsrv_query($conn, $sql_seTransportresult2, $params_seTransportresult2);
    $result_seTransportresult2 = sqlsrv_fetch_array($query_seTransportresult2, SQLSRV_FETCH_ASSOC);


    $sql_seTransportcheck1 = "{call megEdittenkotransport_v2(?,?,?)}";
    $params_seTransportcheck1 = array(
        array('select_transportcheck', SQLSRV_PARAM_IN),
        array($result_seTenkomaster_temp['TENKOMASTERID'], SQLSRV_PARAM_IN),
        array($result_seTenkomaster_temp['TENKOMASTERDIRVERCODE1'], SQLSRV_PARAM_IN)
    );
    $query_seTransportcheck1 = sqlsrv_query($conn, $sql_seTransportcheck1, $params_seTransportcheck1);
    $result_seTransportcheck1 = sqlsrv_fetch_array($query_seTransportcheck1, SQLSRV_FETCH_ASSOC);



    $sql_seTransportcheck2 = "{call megEdittenkotransport_v2(?,?,?)}";
    $params_seTransportcheck2 = array(
        array('select_transportcheck', SQLSRV_PARAM_IN),
        array($result_seTenkomaster_temp['TENKOMASTERID'], SQLSRV_PARAM_IN),
        array($result_seTenkomaster_temp['TENKOMASTERDIRVERCODE2'], SQLSRV_PARAM_IN)
    );
    $query_seTransportcheck2 = sqlsrv_query($conn, $sql_seTransportcheck2, $params_seTransportcheck2);
    $result_seTransportcheck2 = sqlsrv_fetch_array($query_seTransportcheck2, SQLSRV_FETCH_ASSOC);


    $sql_seAfterresult1 = "{call megEdittenkoafter_v2(?,?,?)}";
    $params_seAfterresult1 = array(
        array('select_afterresult', SQLSRV_PARAM_IN),
        array($result_seTenkomaster_temp['TENKOMASTERID'], SQLSRV_PARAM_IN),
        array($result_seTenkomaster_temp['TENKOMASTERDIRVERCODE1'], SQLSRV_PARAM_IN)
    );
    $query_seAfterresult1 = sqlsrv_query($conn, $sql_seAfterresult1, $params_seAfterresult1);
    $result_seAfterresult1 = sqlsrv_fetch_array($query_seAfterresult1, SQLSRV_FETCH_ASSOC);


    $sql_seAfterresult2 = "{call megEdittenkoafter_v2(?,?,?)}";
    $params_seAfterresult2 = array(
        array('select_afterresult', SQLSRV_PARAM_IN),
        array($result_seTenkomaster_temp['TENKOMASTERID'], SQLSRV_PARAM_IN),
        array($result_seTenkomaster_temp['TENKOMASTERDIRVERCODE2'], SQLSRV_PARAM_IN)
    );
    $query_seAfterresult2 = sqlsrv_query($conn, $sql_seAfterresult2, $params_seAfterresult2);
    $result_seAfterresult2 = sqlsrv_fetch_array($query_seAfterresult2, SQLSRV_FETCH_ASSOC);


    $sql_seAftercheck1 = "{call megEdittenkoafter_v2(?,?,?)}";
    $params_seAftercheck1 = array(
        array('select_aftercheck', SQLSRV_PARAM_IN),
        array($result_seTenkomaster_temp['TENKOMASTERID'], SQLSRV_PARAM_IN),
        array($result_seTenkomaster_temp['TENKOMASTERDIRVERCODE1'], SQLSRV_PARAM_IN)
    );
    $query_seAftercheck1 = sqlsrv_query($conn, $sql_seAftercheck1, $params_seAftercheck1);
    $result_seAftercheck1 = sqlsrv_fetch_array($query_seAftercheck1, SQLSRV_FETCH_ASSOC);


    $sql_seAftercheck2 = "{call megEdittenkoafter_v2(?,?,?)}";
    $params_seAftercheck2 = array(
        array('select_aftercheck', SQLSRV_PARAM_IN),
        array($result_seTenkomaster_temp['TENKOMASTERID'], SQLSRV_PARAM_IN),
        array($result_seTenkomaster_temp['TENKOMASTERDIRVERCODE2'], SQLSRV_PARAM_IN)
    );
    $query_seAftercheck2 = sqlsrv_query($conn, $sql_seAftercheck2, $params_seAftercheck2);
    $result_seAftercheck2 = sqlsrv_fetch_array($query_seAftercheck2, SQLSRV_FETCH_ASSOC);
    ?>

                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>เปลี่ยนกะ</label>
                                                    <select class="form-control" id="cb_changeka" name="cb_changeka">
    <?php
    switch ($result_seTenkomaster['TENKOMASTERKA']) {
        case 'เปลี่ยนกะกลางวัน': {
                ?>
                                                                    <option value = "" >ไม่เปลี่ยนกะ</option>
                                                                    <option value = "เปลี่ยนกะกลางวัน" selected="">เปลี่ยนกะกลางวัน</option>
                                                                    <option value = "เปลี่ยนกะกลางคืน" >เปลี่ยนกะกลางคืน</option>

                <?php
            }
            break;
        case 'เปลี่ยนกะกลางคืน': {
                ?>
                                                                    <option value = "" >ไม่เปลี่ยนกะ</option>
                                                                    <option value = "เปลี่ยนกะกลางวัน" >เปลี่ยนกะกลางวัน</option>
                                                                    <option value = "เปลี่ยนกะกลางคืน" selected="">เปลี่ยนกะกลางคืน</option>

                <?php
            }
            break;


        default : {
                ?>
                                                                    <option value = "" >ไม่เปลี่ยนกะ</option>
                                                                    <option value = "เปลี่ยนกะกลางวัน" >เปลี่ยนกะกลางวัน</option>
                                                                    <option value = "เปลี่ยนกะกลางคืน" >เปลี่ยนกะกลางคืน</option>

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
                                                    <label>สถานะ</label>

                                                    <select  class="form-control" id="cb_status" name="cb_status">

    <?php
    $selected = "SELECTED";

    switch ($result_seTenkomaster['ACTIVESTATUS']) {
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
                                                                    <option value="1" >ใช้งาน</option>
                                                                    <option value = "0">ไม่ใช้งาน</option>

                <?php
            }
            break;
    }
    ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>เป้าหมายการวิ่งงานวันนี้</label>
                                                    <div class="dropdown bootstrap-select show-tick form-control">
    <?php
    $chktarget1 = ($result_seTenkomaster['TENKOTARGET1'] == '1') ? "checked" : "";
    $chktarget2 = ($result_seTenkomaster['TENKOTARGET2'] == '1') ? "checked" : "";
    $chktarget3 = ($result_seTenkomaster['TENKOTARGET3'] == '1') ? "checked" : "";
    $chktarget4 = ($result_seTenkomaster['TENKOTARGET4'] == '1') ? "checked" : "";
    $chktarget5 = ($result_seTenkomaster['TENKOTARGET5'] == '1') ? "checked" : "";
    $chktarget6 = ($result_seTenkomaster['TENKOTARGET6'] == '1') ? "checked" : "";
    $chktarget7 = ($result_seTenkomaster['TENKOTARGET7'] == '1') ? "checked" : "";
    ?>
                                                        <input type="checkbox" id="chk_target1" <?= $chktarget1 ?>> -ขับเว้นระยะห่าง 3 วิ <br>
                                                        <input type="checkbox" id="chk_target2" <?= $chktarget2 ?>> -ควบคุมพวงมาลัยให้คงที่ <br>
                                                        <input type="checkbox" id="chk_target3" <?= $chktarget3 ?>> -ให้ใช้ความเร็วต่ำขณะผ่านที่ชุมชน <br>
                                                        <input type="checkbox" id="chk_target4" <?= $chktarget4 ?>> -ง่วงไม่ฝืนขับ <br>
                                                        <input type="checkbox" id="chk_target5" <?= $chktarget5 ?>> -ปฎิบัติงานตามขั้นตอน <br>
                                                        <input type="checkbox" id="chk_target6" <?= $chktarget6 ?>> -ขับขี่ตามกฎจราจร <br>
                                                        <input type="checkbox" id="chk_target7" <?= $chktarget7 ?>> -พบสิ่งผิดปกติให้ หยุด-เรียก-รอ <br>


                                                    </div>
                                                </div>
                                            </div>


                                        </div>


                                        <div class="row" >
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>รายละเอียดงาน (เท็งโกะก่อนเริ่มงาน ข้อ 12.)</label><label></label>
                                                    <textarea class="form-control" autocomplete="off" rows="4" id="txt_remark1" name="txt_remark1" ><?= $result_seTenkomaster['TENKOMASTERREMARKBEFORE'] ?></textarea>

                                                </div>
                                            </div>




                                        </div>




                                        <!-- /.row (nested) -->
                                    </div>
                                    <div class="panel-footer">


                                        <input type="button" onclick="save_tenkomasterdriver('<?= $result_seTenkomaster_temp['TENKOMASTERID'] ?>');" name="btnSend" id="btnSend" value="บันทึกข้อมูล" class="btn btn-primary">


                                    </div>
                                    <!-- /.panel-body -->
                                </div>
                                <!-- /.panel -->
                            </div>
                            <!-- /.col-lg-12 -->
                            <div class="col-lg-5">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        เลขที่ JOB : <?= $result_sePlain['JOBNO'] ?>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row" >
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>ต้นทาง : <?= $result_sePlain['JOBSTART'] ?></label>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" >
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>โซน : <?= $result_sePlain['CLUSTER'] ?></label>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" >
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>ปลายทาง : <?= $result_sePlain['JOBEND'] ?></label>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" >
                                            <div class="col-lg-12">
                                                <table class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align: center"><input type="button" onclick="commit()" class="btn btn-success" value="Commit"></th>
                                                            <th colspan="2" style="text-align: center">ก่อนเริ่มงาน</th>
                                                            <th colspan="2" style="text-align: center">ระหว่างทาง</th>
                                                            <th colspan="2" style="text-align: center">เลิกงาน</th>
                                                        </tr>
                                                        <tr>

                                                            <th style="text-align: center">พขร.</th>
                                                            <th style="text-align: center">ตรวจสอบ</th>
                                                            <th style="text-align: center">ผลตรวจ</th>
                                                            <th style="text-align: center">ตรวจสอบ</th>
                                                            <th style="text-align: center">ผลตรวจ</th>
                                                            <th style="text-align: center">ตรวจสอบ</th>
                                                            <th style="text-align: center">ผลตรวจ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>

                                                            <td><a href="meg_tenkodocument1.php?vehicletransportplanid=<?= $_GET['vehicletransportplanid'] ?>&employeecode1=<?= $result_seTenkomaster_temp['TENKOMASTERDIRVERCODE1'] ?>"><?= $result_sePlain['EMPLOYEENAME1'] ?>(1)</a></td>
                                                            <td style="text-align: center">

    <?php
    if ($result_seBeforecheck1['TENKOBEFORECHECK'] == "1") {
        ?>
                                                                    <span class="glyphicon glyphicon-ok" id="icon_beforecheckok1" style="color: green"></span>
                                                                    <span class="glyphicon glyphicon-remove" id="icon_beforecheckno1" style="display: none;color: red"></span>
        <?php
    } else {
        ?>
                                                                    <span class="glyphicon glyphicon-remove" id="icon_beforecheckno1" style="color: red"></span>
                                                                    <span class="glyphicon glyphicon-ok" id="icon_beforecheckok1" style="display: none;color: green"></span>
        <?php
    }
    ?></td>
                                                            <td style="text-align: center">


    <?php
    if ($result_seBeforeresult1['TENKOBEFORERESULT'] == "1") {
        ?>
                                                                    <span class="glyphicon glyphicon-ok" id="icon_beforeresultok1" style="color: green"></span>
                                                                    <span class="glyphicon glyphicon-remove" id="icon_beforeresultno1" style="display: none;color: red"></span>
        <?php
    } else {
        ?>
                                                                    <span class="glyphicon glyphicon-remove" id="icon_beforeresultno1" style="color: red"></span>
                                                                    <span class="glyphicon glyphicon-ok" id="icon_beforeresultok1" style="display: none;color: green"></span>
        <?php
    }
    ?></td><td style="text-align: center">

                                                                <?php
                                                                if ($result_seTransportcheck1['TENKOTRANSPORTCHECK'] == "1") {
                                                                    ?>
                                                                    <span class="glyphicon glyphicon-ok" id="icon_transportcheckok1" style="color: green"></span>
                                                                    <span class="glyphicon glyphicon-remove" id="icon_transportcheckno1" style="display: none;color: red"></span>
        <?php
    } else {
        ?>
                                                                    <span class="glyphicon glyphicon-remove" id="icon_transportcheckno1" style="color: red"></span>
                                                                    <span class="glyphicon glyphicon-ok" id="icon_transportcheckok1" style="display: none;color: green"></span>
        <?php
    }
    ?></td>
                                                            <td style="text-align: center">
                                                                <?php
                                                                if ($result_seTransportresult1['TENKOTRANSPORTRESULT'] == '1') {
                                                                    ?>
                                                                    <span class="glyphicon glyphicon-ok" id="icon_transportrsok1" style="color: green"></span>
                                                                    <span class="glyphicon glyphicon-remove" id="icon_transportrsno1" style="display: none;color: red"></span>
        <?php
    } else {
        ?>
                                                                    <span class="glyphicon glyphicon-remove" id="icon_transportrsno1" style="color: red"></span>
                                                                    <span class="glyphicon glyphicon-ok" id="icon_transportrsok1" style="display: none;color: green"></span>

        <?php
    }
    ?></td>
                                                            <td style="text-align: center">

    <?php
    if ($result_seAftercheck1['TENKOAFTERCHECK'] == "1") {
        ?>
                                                                    <span class="glyphicon glyphicon-ok" id="icon_afftercheckok1" style="color: green"></span>
                                                                    <span class="glyphicon glyphicon-remove" id="icon_afftercheckno1" style="display: none;color: red"></span>
        <?php
    } else {
        ?>
                                                                    <span class="glyphicon glyphicon-remove" id="icon_afftercheckno1" style="color: red"></span>
                                                                    <span class="glyphicon glyphicon-ok" id="icon_afftercheckok1" style="display: none;color: green"></span>
        <?php
    }
    ?></td>
                                                            <td style="text-align: center">


    <?php
    if ($result_seAfterresult1['TENKOAFTERRESULT'] == "1") {
        ?>
                                                                    <span class="glyphicon glyphicon-ok" id="icon_affterresultok1" style="color: green"></span>
                                                                    <span class="glyphicon glyphicon-remove" id="icon_affterresultno1" style="display: none;color: red"></span>
        <?php
    } else {
        ?>
                                                                    <span class="glyphicon glyphicon-remove" id="icon_affterresultno1" style="color: red"></span>
                                                                    <span class="glyphicon glyphicon-ok" id="icon_affterresultok1" style="display: none;color: green"></span>
        <?php
    }
    ?></td>
                                                        </tr>
                                                                <?php
                                                                if ($result_sePlain['EMPLOYEENAME2'] != "") { /// พขร คนที่ 2
                                                                    ?>
                                                            <tr>
                                                                <td><a href="meg_tenkodocument1.php?vehicletransportplanid=<?= $_GET['vehicletransportplanid'] ?>&employeecode2=<?= $result_seTenkomaster_temp['TENKOMASTERDIRVERCODE2'] ?>"><?= $result_sePlain['EMPLOYEENAME2'] ?>(2)</a></td>
                                                                <td style="text-align: center"><?php
                                                    if ($result_seBeforecheck2['TENKOBEFORECHECK'] == "1") {
                                                        ?>
                                                                        <span class="glyphicon glyphicon-ok" id="icon_beforecheckok2" style="color: green"></span>
                                                                        <span class="glyphicon glyphicon-remove" id="icon_beforecheckno2" style="display: none;color: red"></span>
            <?php
        } else {
            ?>
                                                                        <span class="glyphicon glyphicon-remove" id="icon_beforecheckno2" style="color: red"></span>
                                                                        <span class="glyphicon glyphicon-ok" id="icon_beforecheckok2" style="display: none;color: green"></span>
            <?php
        }
        ?></td>
                                                                <td style="text-align: center"><?php
                                                                    if ($result_seBeforeresult2['TENKOBEFORERESULT'] == "1") {
                                                                        ?>
                                                                        <span class="glyphicon glyphicon-ok" id="icon_beforeresultok2" style="color: green"></span>
                                                                        <span class="glyphicon glyphicon-remove" id="icon_beforeresultno2" style="display: none;color: red"></span>
            <?php
        } else {
            ?>
                                                                        <span class="glyphicon glyphicon-remove" id="icon_beforeresultno2" style="color: red"></span>
                                                                        <span class="glyphicon glyphicon-ok" id="icon_beforeresultok2" style="display: none;color: green"></span>
            <?php
        }
        ?></td>
                                                                <td style="text-align: center">
                                                                    <?php
                                                                    if ($result_seTransportcheck2['TENKOTRANSPORTCHECK'] == "1") {
                                                                        ?>
                                                                        <span class="glyphicon glyphicon-ok" id="icon_transportcheckok2" style="color: green"></span>
                                                                        <span class="glyphicon glyphicon-remove" id="icon_transportcheckno2" style="display: none;color: red"></span>
            <?php
        } else {
            ?>
                                                                        <span class="glyphicon glyphicon-remove" id="icon_transportcheckno2" style="color: red"></span>
                                                                        <span class="glyphicon glyphicon-ok" id="icon_transportcheckok2" style="display: none;color: green"></span>
            <?php
        }
        ?></td>
                                                                <td style="text-align: center"><?php
                                                                    if ($result_seTransportresult2['TENKOTRANSPORTRESULT'] == '1') {
                                                                        ?>

                                                                        <span class="glyphicon glyphicon-ok" id="icon_transportrsok2" style="color: green"></span>
                                                                        <span class="glyphicon glyphicon-remove" id="icon_transportrsno2" style="display: none;color: red"></span>
            <?php
        } else {
            ?>
                                                                        <span class="glyphicon glyphicon-remove" id="icon_transportrsno2" style="color: red"></span>
                                                                        <span class="glyphicon glyphicon-ok" id="icon_transportrsok2" style="display: none;color: green"></span>

            <?php
        }
        ?></td>

                                                                <td style="text-align: center"><?php
                                                            if ($result_seAftercheck2['TENKOAFTERCHECK'] == "1") {
                                                                ?>
                                                                        <span class="glyphicon glyphicon-ok" id="icon_afftercheckok2" style="color: green"></span>
                                                                        <span class="glyphicon glyphicon-remove" id="icon_afftercheckno2" style="display: none;color: red"></span>
            <?php
        } else {
            ?>
                                                                        <span class="glyphicon glyphicon-remove" id="icon_afftercheckno2" style="color: red"></span>
                                                                        <span class="glyphicon glyphicon-ok" id="icon_afftercheckok2" style="display: none;color: green"></span>
            <?php
        }
        ?></td>
                                                                <td style="text-align: center"><?php
                                                                    if ($result_seAfterresult2['TENKOAFTERRESULT'] == "1") {
                                                                        ?>
                                                                        <span class="glyphicon glyphicon-ok" id="icon_affterresultok2" style="color: green"></span>
                                                                        <span class="glyphicon glyphicon-remove" id="icon_affterresultno2" style="display: none;color: red"></span>
            <?php
        } else {
            ?>
                                                                        <span class="glyphicon glyphicon-remove" id="icon_affterresultno2" style="color: red"></span>
                                                                        <span class="glyphicon glyphicon-ok" id="icon_affterresultok2" style="display: none;color: green"></span>
            <?php
        }
        ?></td>
                                                            </tr>
                                                                    <?php
                                                                }
                                                                ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>



                                </div>
                                <!-- /.col-lg-4 -->
                            </div>



                        </div>


                        <div class="row" >
                            <div class="col-lg-12">
                                &nbsp;

                            </div>
                        </div>


                        <div class="row" >
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">

                                        <div class="row" >
                                            <div class="col-lg-2">
                                                ตารางตรวจเท็งโกะ
                                            </div>
    <?php
    $emp = $_GET['employeecode2'];
    if ($emp != "") {
        ?>


                                                <div class="col-lg-10 text-right">

                                                                                                                                                                                                                                                                                                                                                                                <a href="pdf_reportemployee4_1.php?employeecode=<?= $emp ?>&tenkomasterid=<?= $result_seTenkomaster_temp['TENKOMASTERID'] ?>&vehicletransportplanid=<?= $_GET['vehicletransportplanid'] ?>"  target ="_blank" class="btn btn-default">พิมพ์เอกสารเท็งโกะ 1 <li class="fa fa-print"></li></a>&nbsp;&nbsp;<!--<a href="pdf_reportemployee4_2.php?vehicletransportplanid=<?//= $_GET['vehicletransportplanid'] ?>"  target ="_blank"  class="btn btn-default">พิมพ์เอกสารเท็งโกะ 2 <li class="fa fa-print"></li></a>-->
                                                </div>
        <?php
    }
    ?>
                                        </div>
                                    </div>
                                    <!-- /.panel-heading -->
                                    <div class="panel-body">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-pills">


                                            <li class="active"><a href="#tenko1" data-toggle="tab">เท็งโกะก่อนเริ่มงาน</a></li>
                                            <li><a href="#tenko2" data-toggle="tab">เท็งโกะระหว่างทาง</a>



                                            </li>
    <?php
    if (($result_sePlain['STATUSNUMBER'] != '1' || $result_sePlain['STATUS'] == 'แผนงานเปิดงาน') ||
            ($result_sePlain['STATUSNUMBER'] != '2' || $result_sePlain['STATUS'] == 'แผนงานปิดงาน') ||
            ($result_sePlain['STATUSNUMBER'] != 'T' || $result_sePlain['STATUS'] == 'แผนงานรอปิดงาน')) {
        ?>
                                                <li><a href="#tenko3" data-toggle="tab">เท็งโกะเลิกงาน</a>
                                                <?php
                                            } else {
                                                ?>
                                                <li><a href="#" data-toggle="tab">เท็งโกะเลิกงาน</a>
                                                    <?php
                                                }
                                                ?>

                                            </li>
                                            <li><a href="#tenko4" data-toggle="tab">จุดเสี่ยงระหว่างเส้นทางขนส่ง</a>
                                            </li>
                                            <li><a href="#tenko5" data-toggle="tab">แผนที่</a>
                                            </li>
                                            <li><a href="#tenko6" data-toggle="tab">ตรวจสอบการฝ่าฝืนระบบ GPS</a>
                                            </li>



                                        </ul>

                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <p>&nbsp;</p>
    <?php
    if ($_GET['employeecode2'] != "") {

        $sql_seChktenkorest = "SELECT DATEDIFF(HOUR,
                                                                        (SELECT TOP 1 MODIFIEDDATE FROM [dbo].[TENKOAFTER] WHERE [TENKOMASTERDIRVERCODE] = '" . $_GET['employeecode2'] . "' ORDER BY [MODIFIEDDATE]  DESC)
                                                                        ,(SELECT GETDATE()))  AS 'TENKORESTDATA'";
        $query_seChktenkorest = sqlsrv_query($conn, $sql_seChktenkorest, $params_seChktenkorest);
        $result_seChktenkorest = sqlsrv_fetch_array($query_seChktenkorest, SQLSRV_FETCH_ASSOC);
        //edit_tenkobeforetxt1($result_seChktenkorest['TENKORESTDATA'], 'TENKORESTDATA', $result_seTenkobefore['TENKOBEFOREID']);
        //editTenkobefore('edit_tenkobefore', $result_seTenkobefore['TENKOBEFOREID'], 'TENKORESTDATA', $result_seChktenkorest['TENKORESTDATA']);
        //editTenkobefore('edit_tenkobefore', $result_seTenkobefore['TENKOBEFOREID'], 'TENKORESTRESULT', 1);
        $RS_TENKORESTDATA = ($result_seChktenkorest['TENKORESTDATA'] > 24) ? '24' : $result_seChktenkorest['TENKORESTDATA'];


        $sql_seTenkorest = "{call megEdittenkobefore_v2(?,?)}";
        $params_seTenkorest = array(
            array('select_tenkorest', SQLSRV_PARAM_IN),
            array($employeecode2, SQLSRV_PARAM_IN)
        );
        $query_seTenkorest = sqlsrv_query($conn, $sql_seTenkorest, $params_seTenkorest);
        $result_seTenkorest = sqlsrv_fetch_array($query_seTenkorest, SQLSRV_FETCH_ASSOC);
        ?>

                                                <div class="tab-pane fade in active" id="tenko1">


        <?php
        $conditionTenkobefore = " AND a.TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "' AND a.TENKOMASTERDIRVERCODE = '" . $_GET['employeecode2'] . "'";
        $sql_seTenkobefore = "{call megEdittenkobefore_v2(?,?,?)}";
        $params_seTenkobefore = array(
            array('select_tenkobefore', SQLSRV_PARAM_IN),
            array($conditionTenkobefore, SQLSRV_PARAM_IN),
            array('', SQLSRV_PARAM_IN)
        );
        $query_seTenkobefore = sqlsrv_query($conn, $sql_seTenkobefore, $params_seTenkobefore);
        $result_seTenkobefore = sqlsrv_fetch_array($query_seTenkobefore, SQLSRV_FETCH_ASSOC);


        $conditionTenkoafters = " AND TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "' AND TENKOMASTERDIRVERCODE = '" . $_GET['employeecode2'] . "'";
        $sql_seTenkoafters = "{call megEdittenkoafter_v2(?,?,?)}";
        $params_seTenkoafters = array(
            array('select_tenkoafter', SQLSRV_PARAM_IN),
            array($conditionTenkoafters, SQLSRV_PARAM_IN),
            array('', SQLSRV_PARAM_IN)
        );
        $query_seTenkoafters = sqlsrv_query($conn, $sql_seTenkoafters, $params_seTenkoafters);
        $result_seTenkoafters = sqlsrv_fetch_array($query_seTenkoafters, SQLSRV_FETCH_ASSOC);

        $sql_seTenkobeforerest = "SELECT DATEDIFF(HOUR,CONVERT(DATETIME,'" . $result_seTenkoafters['CREATEDATE'] . "',103),CONVERT(DATETIME,GETDATE())) AS AMOUNTREST FROM [dbo].[TENKOAFTER]
                                                    WHERE TENKOMASTERDIRVERCODE = '" . $result_seTenkobefore['TENKOMASTERDIRVERCODE'] . "'
                                                    AND TENKOAFTERID = (SELECT MAX(TENKOAFTERID) FROM [dbo].[TENKOAFTER] WHERE TENKOMASTERDIRVERCODE = '" . $result_seTenkobefore['TENKOMASTERDIRVERCODE'] . "')";
        $query_seTenkobeforerest = sqlsrv_query($conn, $sql_seTenkobeforerest, $params_seTenkobeforerest);
        $result_seTenkobeforerest = sqlsrv_fetch_array($query_seTenkobeforerest, SQLSRV_FETCH_ASSOC);







        $check11 = ($result_seTenkobefore['TENKOBEFOREGREETCHECK'] == '1') ? "checked" : "";
        $check12 = ($result_seTenkobefore['TENKOUNIFORMCHECK'] == '1') ? "checked" : "";
        $check13 = ($result_seTenkobefore['TENKOBODYCHECK'] == '1') ? "checked" : "";
        //if ($result_sePlain['COMPANYCODE'] == 'RKR' || $result_sePlain['COMPANYCODE'] == 'RKL' || $result_sePlain['COMPANYCODE'] == 'RKS') {
        $check14 = ($result_seTenkobefore['TENKORESTCHECK'] == '1' || $result_seTenkobefore['TENKORESTDATA'] > 7) ? "checked" : "";
        $rs141 = ($result_seTenkobefore['TENKORESTDATA'] > 7) ? "checked" : "";
        $rs140 = ($result_seTenkobefore['TENKORESTDATA'] < 8) ? "checked" : "";
        //}
        //else
        //{
        //    $check14 = ($result_seTenkobefore['TENKORESTCHECK'] == '1' || $RS_TENKORESTDATA > 7) ? "checked" : "";
        //    $rs141 = ($RS_TENKORESTDATA > 7) ? "checked" : "";
        //    $rs140 = ($RS_TENKORESTDATA < 8) ? "checked" : "";
        //}
        $check15 = ($result_seTenkobefore['TENKOSLEEPTIMECHECK'] == '1') ? "checked" : "";
        $check16 = ($result_seTenkobefore['TENKOTEMPERATURECHECK'] == '1') ? "checked" : "";
        $check17 = ($result_seTenkobefore['TENKOPRESSURECHECK'] == '1') ? "checked" : "";
        $check18 = ($result_seTenkobefore['TENKOALCOHOLCHECK'] == '1') ? "checked" : "";
        $check19 = ($result_seTenkobefore['TENKOWORRYCHECK'] == '1') ? "checked" : "";
        $check110 = ($result_seTenkobefore['TENKODAILYTRAILERCHECK'] == '1') ? "checked" : "";
        $check111 = ($result_seTenkobefore['TENKOCARRYCHECK'] == '1') ? "checked" : "";
        $check112 = ($result_seTenkobefore['TENKOJOBDETAILCHECK'] == '1') ? "checked" : "";
        $check113 = ($result_seTenkobefore['TENKOLOADINFORMCHECK'] == '1') ? "checked" : "";
        $check114 = ($result_seTenkobefore['TENKOAIRINFORMCHECK'] == '1') ? "checked" : "";
        $check115 = ($result_seTenkobefore['TENKOYOKOTENCHECK'] == '1') ? "checked" : "";
        $check116 = ($result_seTenkobefore['TENKOCHIMOLATORCHECK'] == '1') ? "checked" : "";
        $check117 = ($result_seTenkobefore['TENKOTRANSPORTCHECK'] == '1') ? "checked" : "";
        $check118 = ($result_seTenkobefore['TENKOAFTERGREETCHECK'] == '1') ? "checked" : "";
        $check119 = ($result_seTenkobefore['TENKOOXYGENCHECK'] == '1') ? "checked" : "";

        $rs111 = ($result_seTenkobefore['TENKOBEFOREGREETRESULT'] == '1') ? "checked" : "";
        $rs121 = ($result_seTenkobefore['TENKOUNIFORMRESULT'] == '1') ? "checked" : "";
        $rs131 = ($result_seTenkobefore['TENKOBODYRESULT'] == '1') ? "checked" : "";
        $rs151 = ($result_seTenkobefore['TENKOSLEEPTIMERESULT'] == '1') ? "checked" : "";
        $rs161 = ($result_seTenkobefore['TENKOTEMPERATURERESULT'] == '1') ? "checked" : "";
        $rs171 = ($result_seTenkobefore['TENKOPRESSURERESULT'] == '1') ? "checked" : "";
        $rs181 = ($result_seTenkobefore['TENKOALCOHOLRESULT'] == '1') ? "checked" : "";
        $rs191 = ($result_seTenkobefore['TENKOWORRYRESULT'] == '1') ? "checked" : "";
        $rs1101 = ($result_seTenkobefore['TENKODAILYTRAILERRESULT'] == '1') ? "checked" : "";
        $rs1111 = ($result_seTenkobefore['TENKOCARRYRESULT'] == '1') ? "checked" : "";
        $rs1121 = ($result_seTenkobefore['TENKOJOBDETAILRESULT'] == '1') ? "checked" : "";
        $rs1131 = ($result_seTenkobefore['TENKOLOADINFORMRESULT'] == '1') ? "checked" : "";
        $rs1141 = ($result_seTenkobefore['TENKOAIRINFORMRESULT'] == '1') ? "checked" : "";
        $rs1151 = ($result_seTenkobefore['TENKOYOKOTENRESULT'] == '1') ? "checked" : "";
        $rs1161 = ($result_seTenkobefore['TENKOCHIMOLATORRESULT'] == '1') ? "checked" : "";
        $rs1171 = ($result_seTenkobefore['TENKOTRANSPORTRESULT'] == '1') ? "checked" : "";
        $rs1181 = ($result_seTenkobefore['TENKOAFTERGREETRESULT'] == '1') ? "checked" : "";
        $rs1191 = ($result_seTenkobefore['TENKOOXYGENRESULT'] == '1') ? "checked" : "";

        $rs110 = ($result_seTenkobefore['TENKOBEFOREGREETRESULT'] == '0' || $result_seTenkobefore['TENKOBEFOREGREETRESULT'] == '') ? "checked" : "";
        $rs120 = ($result_seTenkobefore['TENKOUNIFORMRESULT'] == '0' || $result_seTenkobefore['TENKOUNIFORMRESULT'] == '') ? "checked" : "";
        $rs130 = ($result_seTenkobefore['TENKOBODYRESULT'] == '0' || $result_seTenkobefore['TENKOBODYRESULT'] == '') ? "checked" : "";


        $rs150 = ($result_seTenkobefore['TENKOSLEEPTIMERESULT'] == '0' || $result_seTenkobefore['TENKOSLEEPTIMERESULT'] == '') ? "checked" : "";
        $rs160 = ($result_seTenkobefore['TENKOTEMPERATURERESULT'] == '0' || $result_seTenkobefore['TENKOTEMPERATURERESULT'] == '') ? "checked" : "";
        $rs170 = ($result_seTenkobefore['TENKOPRESSURERESULT'] == '0' || $result_seTenkobefore['TENKOPRESSURERESULT'] == '') ? "checked" : "";
        $rs180 = ($result_seTenkobefore['TENKOALCOHOLRESULT'] == '0' || $result_seTenkobefore['TENKOALCOHOLRESULT'] == '') ? "checked" : "";
        $rs190 = ($result_seTenkobefore['TENKOWORRYRESULT'] == '0' || $result_seTenkobefore['TENKOWORRYRESULT'] == '') ? "checked" : "";
        $rs1100 = ($result_seTenkobefore['TENKODAILYTRAILERRESULT'] == '0' || $result_seTenkobefore['TENKODAILYTRAILERRESULT'] == '') ? "checked" : "";
        $rs1110 = ($result_seTenkobefore['TENKOCARRYRESULT'] == '0' || $result_seTenkobefore['TENKOCARRYRESULT'] == '') ? "checked" : "";
        $rs1120 = ($result_seTenkobefore['TENKOJOBDETAILRESULT'] == '0' || $result_seTenkobefore['TENKOJOBDETAILRESULT'] == '') ? "checked" : "";
        $rs1130 = ($result_seTenkobefore['TENKOLOADINFORMRESULT'] == '0' || $result_seTenkobefore['TENKOLOADINFORMRESULT'] == '') ? "checked" : "";
        $rs1140 = ($result_seTenkobefore['TENKOAIRINFORMRESULT'] == '0' || $result_seTenkobefore['TENKOAIRINFORMRESULT'] == '') ? "checked" : "";
        $rs1150 = ($result_seTenkobefore['TENKOYOKOTENRESULT'] == '0' || $result_seTenkobefore['TENKOYOKOTENRESULT'] == '') ? "checked" : "";
        $rs1160 = ($result_seTenkobefore['TENKOCHIMOLATORRESULT'] == '0' || $result_seTenkobefore['TENKOCHIMOLATORRESULT'] == '') ? "checked" : "";
        $rs1170 = ($result_seTenkobefore['TENKOTRANSPORTRESULT'] == '0' || $result_seTenkobefore['TENKOTRANSPORTRESULT'] == '') ? "checked" : "";
        $rs1180 = ($result_seTenkobefore['TENKOAFTERGREETRESULT'] == '0' || $result_seTenkobefore['TENKOAFTERGREETRESULT'] == '') ? "checked" : "";
        $rs1190 = ($result_seTenkobefore['TENKOOXYGENRESULT'] == '0' || $result_seTenkobefore['TENKOOXYGENRESULT'] == '') ? "checked" : "";
        ?>

                                                    <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
                                                        <thead>
                                                            <tr>


                                                                <th  colspan="7" ><font style="color: green">พนักงานขับรถ : นาย <?= $result_seTenkomaster['TENKOMASTERDIRVERNAME2'] ?></font></th>


                                                                <th width="65">เจ้าหน้าที่</th>
                                                                <th width="144" ><?= $result_seEmployee["nameT"] ?></th>
                                                                <th width="40">พขร.</th>
                                                                <th width="144" ><?= $result_seTenkomaster['TENKOMASTERDIRVERNAME2'] ?></th>
                                                            </tr>
                                                            <tr>
                                                                <th width="40" rowspan="2"  style="width: 40px;text-align: center">ข้อ</th>
                                                                <th width="280" rowspan="2" style="width: 200px;text-align: center">หัวข้อ</th>
                                                                <th width="92" rowspan="2" style="width: 20px;text-align: center">ช่องตรวจสอบ</th>
                                                                <th colspan="2" rowspan="2" style="width: 400px;text-align: center">เกณฑ์การตัดสิน</th>
                                                                <th colspan="2" style="width: 80px;text-align: center">ผล</th>
                                                                <th colspan="4" style="text-align: center" rowspan="2">รายเอียดและการแนะนำ</th>
                                                            </tr>
                                                            <tr>
                                                                <th width="40" style="width: 40px;text-align: center" >ปกติ</th>
                                                                <th width="49" style="width: 40px;text-align: center" >ผิดปกติ</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td style="text-align: center">1</td>
                                                                <td>การทักทายก่อนเริ่มเท็งโกะ</td>
                                                                <td style="text-align: center"><input type="checkbox" <?= $check11 ?>  id="chk_11" name="chk_11"  style="transform: scale(2)"/></td>
                                                                <td colspan="2" >ทักทายอย่างมีชีวิตชีวา</td>
                                                                <td style="text-align: center"><input type="checkbox" <?= $rs111 ?> style="transform: scale(2)" id="chk_rs111" name="chk_rs111" onchange="edit_rs111()"/></td>
                                                                <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs110 ?> style="transform: scale(2)" id="chk_rs110" name="chk_rs110" onchange="edit_rs110()"/></td>
                                                                <td colspan="4" ><input type="text" id="txt_remark11" name="txt_remark11" class="form-control" value="<?= $result_seTenkobefore['TENKOBEFOREGREETREMARK'] ?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center">2</td>
                                                                <td>ตรวจเซ็คยูนิฟอร์ม</td>
                                                                <td style="text-align: center"><input type="checkbox" <?= $check12 ?> id="chk_12" name="chk_12"  style="transform: scale(2)"/></td>
                                                                <td colspan="2">สวมชุดที่สะอาด ไม่ใส่เครื่องประดับที่อาจทำให้เกิดรอย</td>
                                                                <td style="text-align: center"><input type="checkbox" <?= $rs121 ?> style="transform: scale(2)" id="chk_rs121" name="chk_rs121" onchange="edit_rs121()"/></td>
                                                                <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs120 ?> style="transform: scale(2)" id="chk_rs120" name="chk_rs120" onchange="edit_rs120()"/></td>
                                                                <td colspan="4"  ><input type="text" id="txt_remark12" name="txt_remark12" class="form-control" value="<?= $result_seTenkobefore['TENKOUNIFORMREMARK'] ?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center">3</td>
                                                                <td>ตรวจสอบสภาพร่างกาย</td>
                                                                <td style="text-align: center"><input type="checkbox" <?= $check13 ?> id="chk_13" name="chk_13"  style="transform: scale(2)"/></td>
                                                                <td colspan="2">สุขภาพร่างกายแข็งแรงดี</td>
                                                                <td style="text-align: center"><input type="checkbox" <?= $rs131 ?> style="transform: scale(2)" id="chk_rs131" name="chk_rs131" onchange="edit_rs131()"/></td>
                                                                <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs130 ?> style="transform: scale(2)" id="chk_rs130" name="chk_rs130" onchange="edit_rs130()"/></td>
                                                                <td colspan="4"  ><input type="text" id="txt_remark13" name="txt_remark13" class="form-control" value="<?= $result_seTenkobefore['TENKOBODYREMARK'] ?>"></td>
                                                            </tr>

                                                            <tr>
                                                                <td style="text-align: center">4</td>
                                                                <td>ตรวจสอบระยะการพักผ่อน</td>
                                                                <td style="text-align: center"><input type="checkbox"  <?= $check14 ?> id="chk_14" name="chk_14"  style="transform: scale(2)"/></td>
                                                                <td>ตั้งแต่ 8 ชั่วโมง</td>


                                                                <td><input type="text" readonly="" class="form-control"  id="txt_rs14" name="txt_rs14" value="<?= $result_seTenkobefore['TENKORESTDATA'] ?>" ></td>

                                                                <td style="text-align: center"><input disabled="" type="checkbox" <?= $rs141 ?> style="transform: scale(2)" id="chk_rs141" name="chk_rs141" onchange="edit_rs141()"/></td>
                                                                <td style="text-align: center"><input disabled="" type="checkbox" disabled="" <?= $rs140 ?> style="transform: scale(2)" id="chk_rs140" name="chk_rs140" onchange="edit_rs140()"/></td>
                                                                <td colspan="4" >


                                                                    <input type="text" id="txt_remark14" name="txt_remark14" class="form-control" value="<?= $result_seTenkobefore['TENKORESTREMARK'] ?>" style="display: none">
                                                                    <input type="button"  data-toggle="modal"  data-target="#modal_tenkorestremark" id="btn_remark14" name="btn_remark14" class="btn btn-default" value="<?= $result_seTenkobefore['TENKORESTREMARK'] ?>">

                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td rowspan="2" style="text-align: center">5</td>
                                                                <td rowspan="2">ตรวจสอบชั่วโมงการนอนหลับ</td>
                                                                <td rowspan="2" style="text-align: center"><input disabled="" type="checkbox" <?= $check15 ?> id="chk_15" name="chk_15"  style="transform: scale(2)"/></td>
                                                                <td>การนอนปกติ ตั้งแต่ 6 ชั่วโมงขึ้นไป</td>
                                                                <!--<td><input type="text"
                                                                           onKeyUp="if (isNaN(this.value)) {
                                                                                       alert('กรุณากรอกตัวเลข');
                                                                                       this.value = '0';
                                                                                   } else {
                                                                                       edit_tenkobeforetxt2(this.value, 'TENKOSLEEPTIMEDATA_AFTER6H', '<?//= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                                   }"
                                                                           class="form-control" id="txt_rs151" name="txt_rs151" value="<?//= $result_seTenkobefore['TENKOSLEEPTIMEDATA_AFTER6H'] ?>"></td>-->
                                                                <td><input readonly="" type="text" class="form-control" id="txt_rs151" name="txt_rs151" value="<?= $result_seTenkobefore['TENKOSLEEPTIMEDATA_AFTER6H'] ?>"></td>
                                                                <td rowspan="2" style="text-align: center"><input disabled="" type="checkbox" <?= $rs151 ?> style="transform: scale(2)" id="chk_rs151" name="chk_rs151" onchange="edit_rs151()"/></td>
                                                                <td rowspan="2" style="text-align: center"><input disabled="" type="checkbox" <?= $rs150 ?> style="transform: scale(2)" id="chk_rs150" name="chk_rs150" onchange="edit_rs150()"/></td>
                                                                <!--<td colspan="4" rowspan="2" contenteditable="true" onkeyup="edit_tenkobefore(this, 'TENKOSLEEPTIMEREMARK', '<?//= $result_seTenkobefore['TENKOBEFOREID'] ?>')"><?//= $result_seTenkobefore['TENKOSLEEPTIMEREMARK'] ?></td>-->
                                                                <td colspan="4" rowspan="2" >
                                                                    <input type="text" id="txt_remark15" name="txt_remark15" class="form-control" value="<?= $result_seTenkobefore['TENKOSLEEPTIMEREMARK'] ?>" style="display: none">
                                                                    <input type="button"  data-toggle="modal"  data-target="#modal_tenkosleeptimeremark" id="btn_remark15" name="btn_remark15" class="btn btn-default" value="<?= $result_seTenkobefore['TENKOSLEEPTIMEREMARK'] ?>">


                                                                </td>

                                                            </tr>


                                                            <tr>
                                                                <td>การนอนเพิ่ม (กะกลางคืน) ตั้งแต่ 4.5 ชั่วโมงขึ้นไป</td>

                                                                <td><input type="text" class="form-control" id="txt_rs152" name="txt_rs152"
                                                                           onKeyUp="if (isNaN(this.value)) {
                                                                                       alert('กรุณากรอกตัวเลข');
                                                                                       this.value = '0';
                                                                                   } else {
                                                                                       edit_tenkobeforetxt3()
                                                                                   }"
                                                                           value="<?= $result_seTenkobefore['TENKOSLEEPTIMEDATA_ADD45H'] ?>"></td>
                                                            </tr>


        <?php
        if ($result_sePlain['COMPANYCODE'] == 'RKS' || $result_sePlain['COMPANYCODE'] == 'RKR' || $result_sePlain['COMPANYCODE'] == 'RKL') {
            ?>
                                                                <tr>
                                                                    <td style="text-align: center">6</td>
                                                                    <td>ตรวจเช็คอุณหภูมิ</td>
                                                                    <td style="text-align: center"><input disabled="" type="checkbox" id="chk_16" <?= $check16 ?> name="chk_16"  style="transform: scale(2)"/></td>
                                                                    <td>ต่ำกว่า 37 องศา</td>
                                                                    <td><input type="text" class="form-control" id="txt_rs16" name="txt_rs16" value="<?= $result_seTenkobefore['TENKOTEMPERATUREDATA'] ?>"
                                                                               onKeyUp="if (isNaN(this.value)) {
                                                                                           alert('กรุณากรอกตัวเลข');
                                                                                           this.value = '0';
                                                                                       } else {
                                                                                           edit_tenkobeforetxt4(this.value, 'TENKOTEMPERATUREDATA', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                                       }"
                                                                               ></td>
                                                                    <td style="text-align: center"><input disabled="" type="checkbox" <?= $rs161 ?> style="transform: scale(2)" id="chk_rs161" name="chk_rs161" onchange="edit_rs161()"/></td>
                                                                    <td style="text-align: center"><input disabled="" type="checkbox" <?= $rs160 ?> style="transform: scale(2)" id="chk_rs160" name="chk_rs160" onchange="edit_rs160()"/></td>
                                                                    <td colspan="4"  ><input type="text" id="txt_remark16" name="txt_remark16" class="form-control" value="<?= $result_seTenkobefore['TENKOTEMPERATUREREMARK'] ?>"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td rowspan="3" style="text-align: center">7</td>
                                                                    <td rowspan="3">วัดความดัน</td>
                                                                    <td rowspan="3" style="text-align: center"><input disabled="" type="checkbox" <?= $check17 ?> id="chk_17" name="chk_17"  style="transform: scale(2)"/></td>
                                                                    <td>บน : 90-140</td>
                                                                    <td><input type="text" class="form-control" id="txt_rs171" name="txt_rs171" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_90160'] ?>"
                                                                               onKeyUp="if (isNaN(this.value)) {
                                                                                           alert('กรุณากรอกตัวเลข');
                                                                                           this.value = '';
                                                                                       } else {
                                                                                           edit_tenkobeforetxt5()
                                                                                       }"
                                                                               ><input type="text" class="form-control" id="txt_rs171_2" name="txt_rs171_2" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_90160_2'] ?>"
                                                                               onKeyUp="if (isNaN(this.value)) {
                                                                                           alert('กรุณากรอกตัวเลข');
                                                                                           this.value = '';
                                                                                       } else {
                                                                                           edit_tenkobeforetxt5_2(this.value, 'TENKOPRESSUREDATA_90160_2', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                                       }"
                                                                               ><input type="text" class="form-control" id="txt_rs171_3" name="txt_rs171_3" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_90160_3'] ?>"
                                                                               onKeyUp="if (isNaN(this.value)) {
                                                                                           alert('กรุณากรอกตัวเลข');
                                                                                           this.value = '';
                                                                                       } else {
                                                                                           edit_tenkobeforetxt5_3(this.value, 'TENKOPRESSUREDATA_90160_3', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                                       }"
                                                                               ></td>
                                                                    <td rowspan="3" style="text-align: center"><input disabled="" type="checkbox" <?= $rs171 ?> style="transform: scale(2)" id="chk_rs171" name="chk_rs171" onchange="edit_rs171()"/></td>
                                                                    <td rowspan="3" style="text-align: center"><input disabled="" type="checkbox" <?= $rs170 ?> style="transform: scale(2)" id="chk_rs170" name="chk_rs170" onchange="edit_rs170()"/></td>
                                                                    <td colspan="4" rowspan="2" ><input type="text" id="txt_remark17" name="txt_remark17" class="form-control" value="<?= $result_seTenkobefore['TENKOPRESSUREREMARK'] ?>"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>ล่าง : 60-90</td>
                                                                    <td><input type="text" class="form-control" id="txt_rs172" name="txt_rs172" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_60100'] ?>"
                                                                               onKeyUp="if (isNaN(this.value)) {
                                                                                           alert('กรุณากรอกตัวเลข');
                                                                                           this.value = '';
                                                                                       } else {
                                                                                           edit_tenkobeforetxt6()
                                                                                       }"
                                                                               ><input type="text" class="form-control" id="txt_rs172_2" name="txt_rs172_2" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_60100_2'] ?>"
                                                                               onKeyUp="if (isNaN(this.value)) {
                                                                                           alert('กรุณากรอกตัวเลข');
                                                                                           this.value = '';
                                                                                       } else {
                                                                                           edit_tenkobeforetxt6_2()
                                                                                       }"
                                                                               ><input type="text" class="form-control" id="txt_rs172_3" name="txt_rs172_3" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_60100_3'] ?>"
                                                                               onKeyUp="if (isNaN(this.value)) {
                                                                                           alert('กรุณากรอกตัวเลข');
                                                                                           this.value = '';
                                                                                       } else {
                                                                                           edit_tenkobeforetxt6_3()
                                                                                       }"
                                                                               ></td>

                                                                </tr>
                                                                <tr>
                                                                    <td>อัตราการเต้นหัวใจ : 60-90 ครั้ง</td>
                                                                    <td><input type="text" class="form-control" id="txt_rs173" name="txt_rs173" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_60110'] ?>"
                                                                               onKeyUp="if (isNaN(this.value)) {
                                                                                           alert('กรุณากรอกตัวเลข');
                                                                                           this.value = '';
                                                                                       } else {
                                                                                           edit_tenkobeforetxt20()
                                                                                       }"
                                                                               ><input type="text" class="form-control" id="txt_rs173_2" name="txt_rs173_2" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_60110_2'] ?>"
                                                                               onKeyUp="if (isNaN(this.value)) {
                                                                                           alert('กรุณากรอกตัวเลข');
                                                                                           this.value = '';
                                                                                       } else {
                                                                                           edit_tenkobeforetxt20_2()
                                                                                       }"
                                                                               ><input type="text" class="form-control" id="txt_rs173_3" name="txt_rs173_3" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_60110_3'] ?>"
                                                                               onKeyUp="if (isNaN(this.value)) {
                                                                                           alert('กรุณากรอกตัวเลข');
                                                                                           this.value = '';
                                                                                       } else {
                                                                                           edit_tenkobeforetxt20_3()
                                                                                       }"
                                                                               ></td>

                                                                </tr>
            <?php
        } else {
            ?>
                                                                <tr>
                                                                    <td style="text-align: center">6</td>
                                                                    <td>ตรวจเช็คอุณหภูมิ</td>
                                                                    <td style="text-align: center"><input disabled="" type="checkbox" id="chk_16" <?= $check16 ?> name="chk_16"  style="transform: scale(2)"/></td>
                                                                    <td>ต่ำกว่า 38 องศา</td>
                                                                    <td><input type="text" class="form-control" id="txt_rs16" name="txt_rs16" value="<?= $result_seTenkobefore['TENKOTEMPERATUREDATA'] ?>"
                                                                               onKeyUp="if (isNaN(this.value)) {
                                                                                           alert('กรุณากรอกตัวเลข');
                                                                                           this.value = '0';
                                                                                       } else {
                                                                                           edit_tenkobeforetxt4(this.value, 'TENKOTEMPERATUREDATA', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                                       }"
                                                                               ></td>
                                                                    <td style="text-align: center"><input disabled="" type="checkbox" <?= $rs161 ?> style="transform: scale(2)" id="chk_rs161" name="chk_rs161" onchange="edit_rs161()"/></td>
                                                                    <td style="text-align: center"><input disabled="" type="checkbox" <?= $rs160 ?> style="transform: scale(2)" id="chk_rs160" name="chk_rs160" onchange="edit_rs160()"/></td>
                                                                    <td colspan="4" ><input type="text" id="txt_remark16" name="txt_remark16" class="form-control" value="<?= $result_seTenkobefore['TENKOTEMPERATUREREMARK'] ?>"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td rowspan="2" style="text-align: center">7</td>
                                                                    <td rowspan="2">วัดความดัน</td>
                                                                    <td rowspan="2" style="text-align: center"><input disabled="" type="checkbox" <?= $check17 ?> id="chk_17" name="chk_17" style="transform: scale(2)"/></td>
                                                                    <td>บน : 90-160</td>
                                                                    <td><input type="text" class="form-control" id="txt_rs171" name="txt_rs171" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_90160'] ?>"
                                                                               onKeyUp="if (isNaN(this.value)) {
                                                                                           alert('กรุณากรอกตัวเลข');
                                                                                           this.value = '';
                                                                                       } else {
                                                                                           edit_tenkobeforetxt5(this.value, 'TENKOPRESSUREDATA_90160', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                                       }"
                                                                               ><input type="text" class="form-control" id="txt_rs171_2" name="txt_rs171_2" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_90160_2'] ?>"
                                                                               onKeyUp="if (isNaN(this.value)) {
                                                                                           alert('กรุณากรอกตัวเลข');
                                                                                           this.value = '';
                                                                                       } else {
                                                                                           edit_tenkobeforetxt5_2(this.value, 'TENKOPRESSUREDATA_90160_2', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                                       }"
                                                                               ><input type="text" class="form-control" id="txt_rs171_3" name="txt_rs171_3" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_90160_3'] ?>"
                                                                               onKeyUp="if (isNaN(this.value)) {
                                                                                           alert('กรุณากรอกตัวเลข');
                                                                                           this.value = '';
                                                                                       } else {
                                                                                           edit_tenkobeforetxt5_3(this.value, 'TENKOPRESSUREDATA_90160_3', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                                       }"
                                                                               ></td>
                                                                    <td rowspan="2" style="text-align: center"><input disabled="" type="checkbox" <?= $rs171 ?> style="transform: scale(2)" id="chk_rs171" name="chk_rs171" onchange="edit_rs171()"/></td>
                                                                    <td rowspan="2" style="text-align: center"><input disabled="" type="checkbox" <?= $rs170 ?> style="transform: scale(2)" id="chk_rs170" name="chk_rs170" onchange="edit_rs170()"/></td>
                                                                    <td colspan="4" rowspan="2" onkeyup="edit_tenkobefore(this, 'TENKOPRESSUREREMARK', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')"><input type="text" id="txt_remark17" name="txt_remark17" class="form-control" value="<?= $result_seTenkobefore['TENKOPRESSUREREMARK'] ?>"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>ล่าง : 60-90</td>
                                                                    <td><input type="text" class="form-control" id="txt_rs172" name="txt_rs172" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_60100'] ?>"
                                                                               onKeyUp="if (isNaN(this.value)) {
                                                                                           alert('กรุณากรอกตัวเลข');
                                                                                           this.value = '';
                                                                                       } else {
                                                                                           edit_tenkobeforetxt6(this.value, 'TENKOPRESSUREDATA_60100', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                                       }"
                                                                               ><input type="text" class="form-control" id="txt_rs172_2" name="txt_rs172_2" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_60100_2'] ?>"
                                                                               onKeyUp="if (isNaN(this.value)) {
                                                                                           alert('กรุณากรอกตัวเลข');
                                                                                           this.value = '';
                                                                                       } else {
                                                                                           edit_tenkobeforetxt6_2(this.value, 'TENKOPRESSUREDATA_60100_2', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                                       }"
                                                                               ><input type="text" class="form-control" id="txt_rs172_3" name="txt_rs172_3" value="<?= $result_seTenkobefore['TENKOPRESSUREDATA_60100_3'] ?>"
                                                                               onKeyUp="if (isNaN(this.value)) {
                                                                                           alert('กรุณากรอกตัวเลข');
                                                                                           this.value = '';
                                                                                       } else {
                                                                                           edit_tenkobeforetxt6_3(this.value, 'TENKOPRESSUREDATA_60100_3', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                                       }"
                                                                               >
                                                                        <input type="text" style="display: none" id="txt_rs173" name="txt_rs173">
                                                                        <input type="text" style="display: none" id="txt_rs173_2" name="txt_rs173">
                                                                        <input type="text" style="display: none" id="txt_rs173_3" name="txt_rs173">
                                                                    </td>

                                                                </tr>

            <?php
        }
        ?>
                                                            <tr>
                                                                <td style="text-align: center">8</td>
                                                                <td>ตรวจเช็คแอลกอฮอล์</td>
                                                                <td style="text-align: center"><input disabled="" type="checkbox" id="chk_18" <?= $check18 ?> name="chk_18"  style="transform: scale(2)"/></td>
                                                                <td>[0]</td>
                                                                <td><input type="text" class="form-control" id="txt_rs18" name="txt_rs18" value="<?= $result_seTenkobefore['TENKOALCOHOLDATA'] ?>"
                                                                           onKeyUp="if (isNaN(this.value)) {
                                                                                       alert('กรุณากรอกตัวเลข');
                                                                                       this.value = '0';
                                                                                   } else {
                                                                                       edit_tenkobeforetxt7(this.value, 'TENKOALCOHOLDATA', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                                   }"
                                                                           ></td>

                                                                <td style="text-align: center"><input disabled="" type="checkbox" <?= $rs181 ?> style="transform: scale(2)" id="chk_rs181" name="chk_rs181" onchange="edit_rs181()"/></td>
                                                                <td style="text-align: center"><input disabled="" type="checkbox" <?= $rs180 ?> style="transform: scale(2)" id="chk_rs180" name="chk_rs180" onchange="edit_rs180()"/></td>
                                                                <td colspan="4"   ><input type="text" id="txt_remark18" name="txt_remark18" class="form-control" value="<?= $result_seTenkobefore['TENKOALCOHOLREMARK'] ?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center">9</td>
                                                                <td>สอบถามเรื่องกังวลใจ</td>
                                                                <td style="text-align: center"><input type="checkbox" <?= $check19 ?> id="chk_19" name="chk_19"  style="transform: scale(2)"/></td>
                                                                <td colspan="2">ไม่มีเรื่องกังวลใจ</td>
                                                                <td style="text-align: center"><input type="checkbox" <?= $rs191 ?> style="transform: scale(2)" id="chk_rs191" name="chk_rs191" onchange="edit_rs191()"/></td>
                                                                <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs190 ?> style="transform: scale(2)" id="chk_rs190" name="chk_rs190" onchange="edit_rs190()"/></td>
                                                                <td colspan="4"   ><input type="text" id="txt_remark19" name="txt_remark19" class="form-control" value="<?= $result_seTenkobefore['TENKOWORRYREMARK'] ?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center">10</td>
                                                                <td>ใบตรวจเทรลเลอร์ประจำวัน</td>
                                                                <td style="text-align: center"><input type="checkbox" <?= $check110 ?> id="chk_110" name="chk_110"  style="transform: scale(2)"/></td>
                                                                <td colspan="2">ไม่มีหัวข้อผิดปกติ</td>
                                                                <td style="text-align: center"><input type="checkbox" <?= $rs1101 ?> style="transform: scale(2)" id="chk_rs1101" name="chk_rs1101" onchange="edit_rs1101()"/></td>
                                                                <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs1100 ?> style="transform: scale(2)" id="chk_rs1100" name="chk_rs1100" onchange="edit_rs1100()"/></td>
                                                                <td colspan="4"  ><input type="text" id="txt_remark110" name="txt_remark110" class="form-control" value="<?= $result_seTenkobefore['TENKODAILYTRAILERREMARK'] ?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center">11</td>
                                                                <td>ตรวจสอบของที่พกพา</td>
                                                                <td style="text-align: center"><input type="checkbox" <?= $check111 ?> id="chk_111" name="chk_111" style="transform: scale(2)"/></td>
                                                                <td colspan="2">พก3ใบนี้ ใบขับขี่ - TLEP - Trailer</td>
                                                                <td style="text-align: center"><input type="checkbox" <?= $rs1111 ?> style="transform: scale(2)" id="chk_rs1111" name="chk_rs1111" onchange="edit_rs1111()"/></td>
                                                                <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs1110 ?> style="transform: scale(2)" id="chk_rs1110" name="chk_rs1110" onchange="edit_rs1110()"/></td>
                                                                <td colspan="4"   ><input type="text" id="txt_remark111" name="txt_remark111" class="form-control" value="<?= $result_seTenkobefore['TENKOCARRYREMARK'] ?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center">12</td>
                                                                <td>ตรวจสอบรายละเอียดการทำงาน</td>
                                                                <td style="text-align: center"><input type="checkbox" <?= $check112 ?> id="chk_112" name="chk_112"  style="transform: scale(2)"/></td>
                                                                <td colspan="2">เข้าใจเส้นทาง จุดพักรถ รูปแบบการขับขี่ ความสำคัญในการส่งรถ</td>
                                                                <td style="text-align: center"><input type="checkbox" <?= $rs1121 ?> style="transform: scale(2)" id="chk_rs1121" name="chk_rs1121" onchange="edit_rs1121()"/></td>
                                                                <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs1120 ?> style="transform: scale(2)" id="chk_rs1120" name="chk_rs1120" onchange="edit_rs1120()"/></td>
                                                                <td colspan="4"  ><input type="text" id="txt_remark112" name="txt_remark112" class="form-control" value="<?= $result_seTenkobefore['TENKOJOBDETAILREMARK'] ?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center">13</td>
                                                                <td>แจ้งสภาพถนน</td>
                                                                <td style="text-align: center"><input type="checkbox" <?= $check113 ?> id="chk_113" name="chk_113"  style="transform: scale(2)"/></td>
                                                                <td colspan="2">เข้าใจเนื้อหาที่แจ้ง</td>
                                                                <td style="text-align: center"><input type="checkbox" <?= $rs1131 ?> style="transform: scale(2)" id="chk_rs1131" name="chk_rs1131" onchange="edit_rs1131()"/></td>
                                                                <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs1130 ?> style="transform: scale(2)" id="chk_rs1130" name="chk_rs1130" onchange="edit_rs1130()"/></td>
                                                                <td colspan="4"   ><input type="text" id="txt_remark113" name="txt_remark113" class="form-control" value="<?= $result_seTenkobefore['TENKOLOADINFORMREMARK'] ?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center">14</td>
                                                                <td>แจ้งสภาพอากาศ</td>
                                                                <td style="text-align: center"><input type="checkbox" <?= $check114 ?> id="chk_114" name="chk_114"  style="transform: scale(2)"/></td>
                                                                <td colspan="2">เข้าใจเนื้อหาที่แจ้ง</td>
                                                                <td style="text-align: center"><input type="checkbox" <?= $rs1141 ?> style="transform: scale(2)" id="chk_rs1141" name="chk_rs1141" onchange="edit_rs1141()"/></td>
                                                                <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs1140 ?> style="transform: scale(2)" id="chk_rs1140" name="chk_rs1140" onchange="edit_rs1140()"/></td>
                                                                <td colspan="4"   ><input type="text" id="txt_remark114" name="txt_remark114" class="form-control" value="<?= $result_seTenkobefore['TENKOAIRINFORMREMARK'] ?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center">15</td>
                                                                <td>แจ้งเรื่องโยโกะเด็น</td>
                                                                <td style="text-align: center"><input type="checkbox" <?= $check115 ?> id="chk_115" name="chk_115"  style="transform: scale(2)"/></td>
                                                                <td colspan="2">เข้าใจเนื้อหาที่แจ้ง</td>
                                                                <td style="text-align: center"><input type="checkbox" <?= $rs1151 ?> style="transform: scale(2)" id="chk_rs1151" name="chk_rs1151" onchange="edit_rs1151()"/></td>
                                                                <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs1150 ?> style="transform: scale(2)" id="chk_rs1150" name="chk_rs1150" onchange="edit_rs1150()"/></td>
                                                                <td colspan="4"   ><input type="text" id="txt_remark115" name="txt_remark115" class="form-control" value="<?= $result_seTenkobefore['TENKOYOKOTENREMARK'] ?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center">16</td>
                                                                <td>ตรวจสอบเป้าหมายการขับขี่จากเครื่องชิมูเลเตอร์</td>
                                                                <td style="text-align: center"><input type="checkbox" <?= $check116 ?> id="chk_116" name="chk_116"  style="transform: scale(2)"/></td>
                                                                <td colspan="2">ตรวจสอบกันทั้งสองฝ่าย</td>
                                                                <td style="text-align: center"><input type="checkbox" <?= $rs1161 ?> style="transform: scale(2)" id="chk_rs1161" name="chk_rs1161" onchange="edit_rs1161()"/></td>
                                                                <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs1160 ?> style="transform: scale(2)" id="chk_rs1160" name="chk_rs1160" onchange="edit_rs1160()"/></td>
                                                                <td colspan="4" ><input type="text" id="txt_remark116" name="txt_remark116" class="form-control" value="<?= $result_seTenkobefore['TENKOCHIMOLATORREMARK'] ?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center">17</td>
                                                                <td>สามารถวิ่งงานได้หรือไม่</td>
                                                                <td style="text-align: center"><input type="checkbox" <?= $check117 ?> id="chk_117" name="chk_117" style="transform: scale(2)"/></td>
                                                                <td colspan="2">ไม่มีข้อบกพร่องต่อการวิ่งงาน</td>
                                                                <td style="text-align: center"><input type="checkbox" <?= $rs1171 ?> style="transform: scale(2)" id="chk_rs1171" name="chk_rs1171" onchange="edit_rs1171()"/></td>
                                                                <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs1170 ?> style="transform: scale(2)" id="chk_rs1170" name="chk_rs1170" onchange="edit_rs1170()"/></td>
                                                                <td colspan="4" ><input type="text" id="txt_remark117" name="txt_remark117" class="form-control" value="<?= $result_seTenkobefore['TENKOTRANSPORTREMARK'] ?>"></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center">18</td>
                                                                <td>การทักทายหลังทำเท็งโกะเสร็จ</td>
                                                                <td style="text-align: center"><input type="checkbox" <?= $check118 ?> id="chk_118" name="chk_118"  style="transform: scale(2)"/></td>
                                                                <td colspan="2">ทักทายอย่างมีชีวิตชีวา</td>
                                                                <td style="text-align: center"><input type="checkbox" <?= $rs1181 ?> style="transform: scale(2)" id="chk_rs1181" name="chk_rs1181" onchange="edit_rs1181()"/></td>
                                                                <td style="text-align: center"><input type="checkbox" disabled="" <?= $rs1180 ?> style="transform: scale(2)" id="chk_rs1180" name="chk_rs1180" onchange="edit_rs1180()"/></td>
                                                                <td colspan="4" ><input type="text" id="txt_remark118" name="txt_remark118" class="form-control" value="<?= $result_seTenkobefore['TENKOAFTERGREETREMARK'] ?>"></td>
                                                            </tr>

                                                            <tr>
                                                                <td rowspan="2" style="text-align: center">***</td>
                                                                <td rowspan="2">ตรวจเช็คออกซิเจนเลือด</td>
                                                                <td rowspan="2" style="text-align: center"><input disabled="" type="checkbox" <?= $check119 ?> id="chk_119" name="chk_119"  style="transform: scale(2)"/></td>
                                                                <td></td>
                                                                <td><input type="text"
                                                                           onKeyUp="if (isNaN(this.value)) {
                                                                                       alert('กรุณากรอกตัวเลข');
                                                                                       this.value = '0';
                                                                                   } else {
                                                                                       edit_tenkobeforetxt8(this.value, 'TENKOOXYGENDATA', '<?= $result_seTenkobefore['TENKOBEFOREID'] ?>')
                                                                                   }"
                                                                           class="form-control" id="txt_rs19" name="txt_rs19" value="<?= $result_seTenkobefore['TENKOOXYGENDATA'] ?>"></td>
                                                                <td rowspan="2" style="text-align: center"><input disabled="" type="checkbox" <?= $rs1191 ?> style="transform: scale(2)" id="chk_rs1191" name="chk_rs1191" onchange="edit_rs1191()"/></td>
                                                                <td rowspan="2" style="text-align: center"><input disabled="" type="checkbox" <?= $rs1190 ?> style="transform: scale(2)" id="chk_rs1190" name="chk_rs1190" onchange="edit_rs1190()"/></td>
                                                                <td colspan="4" rowspan="2"  ><input type="text" id="txt_remark119" name="txt_remark119" class="form-control" value="<?= $result_seTenkobefore['TENKOOXYGENREMARK'] ?>"></td>

                                                            </tr>




                                                        </tbody>
                                                        <!--<tfoot>
                                                            <tr>
                                                                <td>
                                                                    <input type="button" class="btn btn-primary" onclick="before_checknull()" value="ตรวจสอบ">
                                                                </td>

                                                            </tr>
                                                        </tfoot>
                                                        -->
                                                    </table>
                                                </div>

                                                <div class="tab-pane fade" id="tenko2">


                                                    <div class="panel-body">
                                                        <!-- Nav tabs -->
                                                        <ul class="nav nav-tabs">
                                                            <li class="active"><a href="#day1" data-toggle="tab"><?= $result_seTenkomaster['DATEINPUT_F1'] ?></a>
                                                            </li>
        <?php
        if ($result_sePlain['COMPANYCODE'] == 'RRC') {
            ?>
                                                                <li><a href="#day2" data-toggle="tab"><?= $result_seTenkomaster['DATEINPUT_F2'] ?></a>
                                                                <?php
                                                            } else {
                                                                if ($result_sePlain['CUSTOMERCODE'] == 'SKB' || $result_sePlain['CUSTOMERCODE'] == 'TTT' || $result_sePlain['CUSTOMERCODE'] == 'GMT' || $result_sePlain['CUSTOMERCODE'] == 'TTASTCS') {
                                                                    ?>
                                                                    <li><a href="#day2" data-toggle="tab"><?= $result_seTenkomaster['DATEINPUT_F2'] ?></a>

                                                                    </li>
                                                                    <li><a href="#day3" data-toggle="tab"><?= $result_seTenkomaster['DATEINPUT_F3'] ?></a>
                                                                    </li>
                                                                    <li><a href="#day4" data-toggle="tab"><?= $result_seTenkomaster['DATEINPUT_F4'] ?></a>
                                                                    </li>
                                                                    <li><a href="#day5" data-toggle="tab"><?= $result_seTenkomaster['DATEINPUT_F5'] ?></a>
                                                                    </li>
                <?php
            }
        }
        ?>
                                                        </ul>

                                                        <!-- Tab panes -->
                                                        <div class="tab-content">
                                                            <div class="tab-pane fade in active" id="day1">
        <?php
        $conditionTenkotransport11 = " AND TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "' AND TENKOMASTERDIRVERCODE = '" . $_GET['employeecode2'] . "' ";
        $conditionTenkotransport12 = " AND CONVERT(DATE,TENKOTRANSPORTDATE) = CONVERT(DATE,'" . $result_seTenkomaster['DATEINPUT_F1'] . "',103)";
        $sql_seTenkotransport1 = "{call megEdittenkotransport_v2(?,?,?)}";
        $params_seTenkotransport1 = array(
            array('select_tenkotransport', SQLSRV_PARAM_IN),
            array($conditionTenkotransport11, SQLSRV_PARAM_IN),
            array($conditionTenkotransport12, SQLSRV_PARAM_IN)
        );
        $query_seTenkotransport1 = sqlsrv_query($conn, $sql_seTenkotransport1, $params_seTenkotransport1);
        $result_seTenkotransport1 = sqlsrv_fetch_array($query_seTenkotransport1, SQLSRV_FETCH_ASSOC);


        $rs1d1 = ($result_seTenkotransport1['TENKOLOADRESTCHECK'] == '1') ? "checked" : "";
        $rs2d1 = ($result_seTenkotransport1['TENKOBODYSLEEPYCHECK'] == '1') ? "checked" : "";
        $rs3d1 = ($result_seTenkotransport1['TENKOCARNEWCHECK'] == '1') ? "checked" : "";
        $rs4d1 = ($result_seTenkotransport1['TENKOTRAILERCHECK'] == '1') ? "checked" : "";
        $rs5d1 = ($result_seTenkotransport1['TENKOROADCHECK'] == '1') ? "checked" : "";
        $rs6d1 = ($result_seTenkotransport1['TENKOAIRCHECK'] == '1') ? "checked" : "";
        $rs7d1 = ($result_seTenkotransport1['TENKOSLEEPYCHECK'] == '1') ? "checked" : "";
        ?>
                                                                <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
                                                                    <thead>
                                                                        <tr>

                                                                            <th colspan="6" ><font style="color: green">พนักงานขับรถ : นาย <?= $result_seTenkomaster['TENKOMASTERDIRVERNAME2'] ?></font></th>
                                                                            <th colspan="2" style="text-align: center;">เจ้าหน้าที่เท็งโกะก่อนเริ่มงาน</th>
                                                                            <th style="text-align: center;"><?= $result_seTenkotransport1["CREATEBY"] ?></th>
                                                                            <th colspan="2" style="text-align: center;">เจ้าหน้าที่เท็งโกะปฎิบัติงาน</th>
                                                                            <th style="text-align: center;"><?= $result_seEmployee["nameT"] ?></th>
                                                                        </tr>
                                                                        <tr>

                                                                            <th colspan="12">เจ้าหน้าที่โทรไปไม่พบสิ่งผิดปกติ : <font style="color: red">0</font>  | พนักงานขับรถโทรมาไม่พบสิ่งผิดปกติ : <font style="color: red">1</font> | พบสิ่งผิดปกติ : <font style="color: red">x</font></th>
                                                                        </tr>
                                                                        <tr>

                                                                            <th rowspan="4" style="text-align: center;">ข้อ</th>
                                                                            <th rowspan="4" style="text-align: center;">หัวข้อ</th>
                                                                            <th rowspan="4" style="text-align: center;">ช่องตรวจ</th>
                                                                            <th rowspan="4" style="text-align: center;">เกณฑ์การตัดสิน</th>
                                                                            <th rowspan="2" style="text-align: center;"><p>โทรช่วง </p>
                                                                                <p>00:01 - 23:59</p></th>
                                                                            <th colspan="6" style="text-align: center">Night Call Check</th>
                                                                            <th rowspan="4"style="text-align: center;">รายละเอียดการแนะนำของเจ้าหน้าที่</th>
                                                                        </tr>
                                                                        <tr>

                                                                            <th style="text-align: center;">ครั้งที่ 1</th>
                                                                            <th style="text-align: center;">ครั้งที่ 2</th>
                                                                            <th style="text-align: center;">ครั้งที่ 3</th>
                                                                            <th style="text-align: center;">ครั้งที่ 4</th>
                                                                            <th style="text-align: center;">ครั้งที่ 5</th>
                                                                            <th style="text-align: center;">ครั้งที่ 6</th>
                                                                        </tr>
                                                                        <tr>

                                                                            <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME0', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control timeen" id="txt_time0" name="txt_time0" value="<?= $result_seTenkotransport1['TENKOTIME0'] ?>"></th>
                                                                            <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME1', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control timeen" id="txt_time1" name="txt_time1" value="<?= $result_seTenkotransport1['TENKOTIME1'] ?>"></th>
                                                                            <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME2', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control timeen" id="txt_time2" name="txt_time2" value="<?= $result_seTenkotransport1['TENKOTIME2'] ?>"></th>
                                                                            <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME3', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control timeen" id="txt_time3" name="txt_time3" value="<?= $result_seTenkotransport1['TENKOTIME3'] ?>"></th>
                                                                            <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME4', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control timeen" id="txt_time4" name="txt_time4" value="<?= $result_seTenkotransport1['TENKOTIME4'] ?>"></th>
                                                                            <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME5', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control timeen" id="txt_time5" name="txt_time5" value="<?= $result_seTenkotransport1['TENKOTIME5'] ?>"></th>
                                                                            <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME6', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control timeen" id="txt_time6" name="txt_time6" value="<?= $result_seTenkotransport1['TENKOTIME6'] ?>"></th>
                                                                        </tr>
                                                                        <tr>

                                                                            <th style="text-align: center;">ผล</th>
                                                                            <th style="text-align: center;">ผล</th>
                                                                            <th style="text-align: center;">ผล</th>
                                                                            <th style="text-align: center;">ผล</th>
                                                                            <th style="text-align: center;">ผล</th>
                                                                            <th style="text-align: center;">ผล</th>
                                                                            <th style="text-align: center;">ผล</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="text-align: center">1</td>
                                                                            <td>เส้นทางที่กำหนด - จุดพัก</td>
                                                                            <td style="text-align: center"><input type="checkbox" <?= $rs1d1 ?> onchange="edit_check1d1('TENKOLOADRESTCHECK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" style="transform: scale(2)" id="chk_1d1" name="chk_1d1" /></td>
                                                                            <td>เส้นทาง จุดพักที่กำหนด</td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT0', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT0" name="TXT_TENKOLOADRESTRESULT0" value="<?= $result_seTenkotransport1['TENKOLOADRESTRESULT0'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT0', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT0" name="TXT_TENKOBODYSLEEPYRESULT0" value="<?= $result_seTenkotransport1['TENKOBODYSLEEPYRESULT0'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT0', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT0" name="TXT_TENKOCARNEWRESULT0" value="<?= $result_seTenkotransport1['TENKOCARNEWRESULT0'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT0', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT0" name="TXT_TENKOTRAILERRESULT0" value="<?= $result_seTenkotransport1['TENKOTRAILERRESULT0'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT0', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOROADRESULT0" name="TXT_TENKOROADRESULT0" value="<?= $result_seTenkotransport1['TENKOROADRESULT0'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT0', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT0" name="TXT_TENKOAIRRESULT0" value="<?= $result_seTenkotransport1['TENKOAIRRESULT0'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT0', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT0" name="TXT_TENKOSLEEPYRESULT0" value="<?= $result_seTenkotransport1['TENKOSLEEPYRESULT0'] ?>"></td>
                                                                            <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOLOADRESTREMARK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')"><?= $result_seTenkotransport1['TENKOLOADRESTREMARK'] ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="text-align: center">2</td>
                                                                            <td>ตรวจร่างกาย - อาการง่วง</td>
                                                                            <td style="text-align: center"><input type="checkbox" <?= $rs2d1 ?> onchange="edit_check2d1('TENKOBODYSLEEPYCHECK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" style="transform: scale(2)"  id="chk_2d1" name="chk_2d1"/></td>
                                                                            <td>วิธีการพูดคุยต้องร่าเริง</td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT1', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT1" name="TXT_TENKOLOADRESTRESULT1" value="<?= $result_seTenkotransport1['TENKOLOADRESTRESULT1'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT1', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT1" name="TXT_TENKOBODYSLEEPYRESULT1" value="<?= $result_seTenkotransport1['TENKOBODYSLEEPYRESULT1'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT1', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT1" name="TXT_TENKOCARNEWRESULT1" value="<?= $result_seTenkotransport1['TENKOCARNEWRESULT1'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT1', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT1" name="TXT_TENKOTRAILERRESULT1" value="<?= $result_seTenkotransport1['TENKOTRAILERRESULT1'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT1', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOROADRESULT1" name="TXT_TENKOROADRESULT1" value="<?= $result_seTenkotransport1['TENKOROADRESULT1'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT1', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT1" name="TXT_TENKOAIRRESULT1" value="<?= $result_seTenkotransport1['TENKOAIRRESULT1'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT1', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT1" name="TXT_TENKOSLEEPYRESULT1" value="<?= $result_seTenkotransport1['TENKOSLEEPYRESULT1'] ?>"></td>
                                                                            <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOBODYSLEEPYREMARK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')"><?= $result_seTenkotransport1['TENKOBODYSLEEPYREMARK'] ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="text-align: center">3</td>
                                                                            <td>ตรวจรถใหม่ (เฉพาะหยุดรถ)</td>
                                                                            <td style="text-align: center"><input type="checkbox" <?= $rs3d1 ?> onchange="edit_check3d1('TENKOCARNEWCHECK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" style="transform: scale(2)"  id="chk_3d1" name="chk_3d1"/></td>
                                                                            <td>มีการรายงานเกี่ยวกับรถใหม่ว่ามีสิ่งผิดปกติหรือไม่</td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT2', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT2" name="TXT_TENKOLOADRESTRESULT2" value="<?= $result_seTenkotransport1['TENKOLOADRESTRESULT2'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT2', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT2" name="TXT_TENKOBODYSLEEPYRESULT2" value="<?= $result_seTenkotransport1['TENKOBODYSLEEPYRESULT2'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT2', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT2" name="TXT_TENKOCARNEWRESULT2" value="<?= $result_seTenkotransport1['TENKOCARNEWRESULT2'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT2', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT2" name="TXT_TENKOTRAILERRESULT2" value="<?= $result_seTenkotransport1['TENKOTRAILERRESULT2'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT2', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOROADRESULT2" name="TXT_TENKOROADRESULT2" value="<?= $result_seTenkotransport1['TENKOROADRESULT2'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT2', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT2" name="TXT_TENKOAIRRESULT2" value="<?= $result_seTenkotransport1['TENKOAIRRESULT2'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT2', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT2" name="TXT_TENKOSLEEPYRESULT2" value="<?= $result_seTenkotransport1['TENKOSLEEPYRESULT2'] ?>"></td>
                                                                            <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOCARNEWREMARK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')"><?= $result_seTenkotransport1['TENKOCARNEWREMARK'] ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="text-align: center">4</td>
                                                                            <td>ตรวจเทรลเลอร์</td>
                                                                            <td style="text-align: center"><input type="checkbox" <?= $rs4d1 ?> onchange="edit_check4d1('TENKOTRAILERCHECK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" style="transform: scale(2)"  id="chk_4d1" name="chk_4d1"/></td>
                                                                            <td>ระหว่างวิ่งงานไม่มีสิ่งผิดปกติ</td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT3', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT3" name="TXT_TENKOLOADRESTRESULT3" value="<?= $result_seTenkotransport1['TENKOLOADRESTRESULT3'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT3', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT3" name="TXT_TENKOBODYSLEEPYRESULT3" value="<?= $result_seTenkotransport1['TENKOBODYSLEEPYRESULT3'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT3', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT3" name="TXT_TENKOCARNEWRESULT3" value="<?= $result_seTenkotransport1['TENKOCARNEWRESULT3'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT3', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT3" name="TXT_TENKOTRAILERRESULT3" value="<?= $result_seTenkotransport1['TENKOTRAILERRESULT3'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT3', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOROADRESULT3" name="TXT_TENKOROADRESULT3" value="<?= $result_seTenkotransport1['TENKOROADRESULT3'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT3', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT3" name="TXT_TENKOAIRRESULT3" value="<?= $result_seTenkotransport1['TENKOAIRRESULT3'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT3', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT3" name="TXT_TENKOSLEEPYRESULT3" value="<?= $result_seTenkotransport1['TENKOSLEEPYRESULT3'] ?>"></td>
                                                                            <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOTRAILERREMARK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')"><?= $result_seTenkotransport1['TENKOTRAILERREMARK'] ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="text-align: center">5</td>
                                                                            <td>ตรวจสภาพถนน</td>
                                                                            <td style="text-align: center"><input type="checkbox" <?= $rs5d1 ?> onchange="edit_check5d1('TENKOROADCHECK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" style="transform: scale(2)"  id="chk_5d1" name="chk_5d1"/></td>
                                                                            <td>รายงานสภาพถนน</td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT4', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT4" name="TXT_TENKOLOADRESTRESULT4" value="<?= $result_seTenkotransport1['TENKOLOADRESTRESULT4'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT4', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT4" name="TXT_TENKOBODYSLEEPYRESULT4" value="<?= $result_seTenkotransport1['TENKOBODYSLEEPYRESULT4'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT4', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT4" name="TXT_TENKOCARNEWRESULT4" value="<?= $result_seTenkotransport1['TENKOCARNEWRESULT4'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT4', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT4" name="TXT_TENKOTRAILERRESULT4" value="<?= $result_seTenkotransport1['TENKOTRAILERRESULT4'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT4', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOROADRESULT4" name="TXT_TENKOROADRESULT4" value="<?= $result_seTenkotransport1['TENKOROADRESULT4'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT4', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT4" name="TXT_TENKOAIRRESULT0" value="<?= $result_seTenkotransport1['TENKOAIRRESULT4'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT4', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT4" name="TXT_TENKOSLEEPYRESULT4" value="<?= $result_seTenkotransport1['TENKOSLEEPYRESULT4'] ?>"></td>
                                                                            <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOROADREMARK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')"><?= $result_seTenkotransport1['TENKOROADREMARK'] ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="text-align: center">6</td>
                                                                            <td>ตรวจสภาพอากาศ (ใช้ที่ปัดน้ำฝนระดับ 3 ให้หยุดรถ)</td>
                                                                            <td style="text-align: center"><input type="checkbox" <?= $rs6d1 ?> onchange="edit_check6d1('TENKOAIRCHECK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" style="transform: scale(2)"  id="chk_6d1" name="chk_6d1"/></td>
                                                                            <td>รายงานสภาพอากาศ1</td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT5', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT5" name="TXT_TENKOLOADRESTRESULT5" value="<?= $result_seTenkotransport1['TENKOLOADRESTRESULT5'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT5', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT5" name="TXT_TENKOBODYSLEEPYRESULT5" value="<?= $result_seTenkotransport1['TENKOBODYSLEEPYRESULT5'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT5', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT5" name="TXT_TENKOCARNEWRESULT5" value="<?= $result_seTenkotransport1['TENKOCARNEWRESULT5'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT5', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT5" name="TXT_TENKOTRAILERRESULT5" value="<?= $result_seTenkotransport1['TENKOTRAILERRESULT5'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT5', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOROADRESULT5" name="TXT_TENKOROADRESULT5" value="<?= $result_seTenkotransport1['TENKOROADRESULT5'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT5', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT5" name="TXT_TENKOAIRRESULT5" value="<?= $result_seTenkotransport1['TENKOAIRRESULT5'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT5', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT5" name="TXT_TENKOSLEEPYRESULT5" value="<?= $result_seTenkotransport1['TENKOSLEEPYRESULT5'] ?>"></td>
                                                                            <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOAIRREMARK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')"><?= $result_seTenkotransport1['TENKOAIRREMARK'] ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="text-align: center">7</td>
                                                                            <td>ตรวจสอบอาการง่วงและย้ำให้ระมัดระวัง</td>
                                                                            <td style="text-align: center"><input type="checkbox" <?= $rs7d1 ?> onchange="edit_check7d1('TENKOSLEEPYCHECK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" style="transform: scale(2)" id="chk_7d1" name="chk_7d1" /></td>
                                                                            <td>สภาพที่สามารถวิ่งงานต่อได้</td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT6', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT6" name="TXT_TENKOLOADRESTRESULT6" value="<?= $result_seTenkotransport1['TENKOLOADRESTRESULT6'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT6', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT6" name="TXT_TENKOBODYSLEEPYRESULT6" value="<?= $result_seTenkotransport1['TENKOBODYSLEEPYRESULT6'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT6', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT6" name="TXT_TENKOCARNEWRESULT6" value="<?= $result_seTenkotransport1['TENKOCARNEWRESULT6'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT6', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT6" name="TXT_TENKOTRAILERRESULT6" value="<?= $result_seTenkotransport1['TENKOTRAILERRESULT6'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT6', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOROADRESULT6" name="TXT_TENKOROADRESULT6" value="<?= $result_seTenkotransport1['TENKOROADRESULT6'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT6', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT6" name="TXT_TENKOAIRRESULT6" value="<?= $result_seTenkotransport1['TENKOAIRRESULT6'] ?>"></td>
                                                                            <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT6', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT6" name="TXT_TENKOSLEEPYRESULT6" value="<?= $result_seTenkotransport1['TENKOSLEEPYRESULT6'] ?>"></td>
                                                                            <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOSLEEPYREMARK', '<?= $result_seTenkotransport1['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F1'] ?>')"><?= $result_seTenkotransport1['TENKOSLEEPYREMARK'] ?></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>

                                                            </div>
        <?php
        if ($result_sePlain['CUSTOMERCODE'] == 'SKB' || $result_sePlain['CUSTOMERCODE'] == 'TTT' || $result_sePlain['CUSTOMERCODE'] == 'GMT' || $result_sePlain['CUSTOMERCODE'] == 'TTAST') {
            ?>
                                                                <div class="tab-pane" id="day2">
                                                                <?php
                                                                $conditionTenkotransport21 = " AND TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "' AND TENKOMASTERDIRVERCODE = '" . $_GET['employeecode2'] . "' ";
                                                                $conditionTenkotransport22 = " AND CONVERT(DATE,TENKOTRANSPORTDATE) = CONVERT(DATE,'" . $result_seTenkomaster['DATEINPUT_F2'] . "',103)";
                                                                $sql_seTenkotransport2 = "{call megEdittenkotransport_v2(?,?,?)}";
                                                                $params_seTenkotransport2 = array(
                                                                    array('select_tenkotransport', SQLSRV_PARAM_IN),
                                                                    array($conditionTenkotransport21, SQLSRV_PARAM_IN),
                                                                    array($conditionTenkotransport22, SQLSRV_PARAM_IN)
                                                                );
                                                                $query_seTenkotransport2 = sqlsrv_query($conn, $sql_seTenkotransport2, $params_seTenkotransport2);
                                                                $result_seTenkotransport2 = sqlsrv_fetch_array($query_seTenkotransport2, SQLSRV_FETCH_ASSOC);

                                                                $rs1d2 = ($result_seTenkotransport2['TENKOLOADRESTCHECK'] == '1') ? "checked" : "";
                                                                $rs2d2 = ($result_seTenkotransport2['TENKOBODYSLEEPYCHECK'] == '1') ? "checked" : "";
                                                                $rs3d2 = ($result_seTenkotransport2['TENKOCARNEWCHECK'] == '1') ? "checked" : "";
                                                                $rs4d2 = ($result_seTenkotransport2['TENKOTRAILERCHECK'] == '1') ? "checked" : "";
                                                                $rs5d2 = ($result_seTenkotransport2['TENKOROADCHECK'] == '1') ? "checked" : "";
                                                                $rs6d2 = ($result_seTenkotransport2['TENKOAIRCHECK'] == '1') ? "checked" : "";
                                                                $rs7d2 = ($result_seTenkotransport2['TENKOSLEEPYCHECK'] == '1') ? "checked" : "";
                                                                ?>
                                                                    <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
                                                                        <thead>
                                                                            <tr>

                                                                                <th colspan="6" ><font style="color: green">พนักงานขับรถ : นาย <?= $result_seTenkomaster['TENKOMASTERDIRVERNAME2'] ?></font></th>
                                                                                <th colspan="2" style="text-align: center;">เจ้าหน้าที่เท็งโกะก่อนเริ่มงาน</th>
                                                                                <th style="text-align: center;"><?= $result_seTenkotransport1["CREATEBY"] ?></th>
                                                                                <th colspan="2" style="text-align: center;">เจ้าหน้าที่เท็งโกะปฎิบัติงาน</th>
                                                                                <th style="text-align: center;"><?= $result_seEmployee["nameT"] ?></th>
                                                                            </tr>
                                                                            <tr>

                                                                                <th colspan="12">เจ้าหน้าที่โทรไปไม่พบสิ่งผิดปกติ : <font style="color: red">0</font>  | พนักงานขับรถโทรมาไม่พบสิ่งผิดปกติ : <font style="color: red">1</font> | พบสิ่งผิดปกติ : <font style="color: red">x</font></th>
                                                                            </tr>
                                                                            <tr>

                                                                                <th rowspan="4" style="text-align: center;">ข้อ</th>
                                                                                <th rowspan="4" style="text-align: center;">หัวข้อ</th>
                                                                                <th rowspan="4" style="text-align: center;">ช่องตรวจ</th>
                                                                                <th rowspan="4" style="text-align: center;">เกณฑ์การตัดสิน</th>
                                                                                <th rowspan="2" style="text-align: center;"><p>โทรช่วง </p>
                                                                                    <p>00:01 - 23:59</p></th>
                                                                                <th colspan="6" style="text-align: center">Night Call Check</th>
                                                                                <th rowspan="4"style="text-align: center;">รายละเอียดการแนะนำของเจ้าหน้าที่</th>
                                                                            </tr>
                                                                            <tr>

                                                                                <th style="text-align: center;">ครั้งที่ 1</th>
                                                                                <th style="text-align: center;">ครั้งที่ 2</th>
                                                                                <th style="text-align: center;">ครั้งที่ 3</th>
                                                                                <th style="text-align: center;">ครั้งที่ 4</th>
                                                                                <th style="text-align: center;">ครั้งที่ 5</th>
                                                                                <th style="text-align: center;">ครั้งที่ 6</th>
                                                                            </tr>
                                                                            <tr>

                                                                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME0', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control timeen" id="txt_time0" name="txt_time0" value="<?= $result_seTenkotransport2['TENKOTIME0'] ?>"></th>
                                                                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME1', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control timeen" id="txt_time1" name="txt_time1" value="<?= $result_seTenkotransport2['TENKOTIME1'] ?>"></th>
                                                                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME2', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control timeen" id="txt_time2" name="txt_time2" value="<?= $result_seTenkotransport2['TENKOTIME2'] ?>"></th>
                                                                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME3', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control timeen" id="txt_time3" name="txt_time3" value="<?= $result_seTenkotransport2['TENKOTIME3'] ?>"></th>
                                                                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME4', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control timeen" id="txt_time4" name="txt_time4" value="<?= $result_seTenkotransport2['TENKOTIME4'] ?>"></th>
                                                                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME5', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control timeen" id="txt_time5" name="txt_time5" value="<?= $result_seTenkotransport2['TENKOTIME5'] ?>"></th>
                                                                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME6', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control timeen" id="txt_time6" name="txt_time6" value="<?= $result_seTenkotransport2['TENKOTIME6'] ?>"></th>
                                                                            </tr>
                                                                            <tr>

                                                                                <th style="text-align: center;">ผล</th>
                                                                                <th style="text-align: center;">ผล</th>
                                                                                <th style="text-align: center;">ผล</th>
                                                                                <th style="text-align: center;">ผล</th>
                                                                                <th style="text-align: center;">ผล</th>
                                                                                <th style="text-align: center;">ผล</th>
                                                                                <th style="text-align: center;">ผล</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="text-align: center">1</td>
                                                                                <td>เส้นทางที่กำหนด - จุดพัก</td>
                                                                                <td style="text-align: center"><input type="checkbox" <?= $rs1d2 ?> onchange="edit_check1d2('TENKOLOADRESTCHECK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" style="transform: scale(2)" id="chk_1d2" name="chk_1d2" /></td>
                                                                                <td>เส้นทาง จุดพักที่กำหนด</td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT0', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT0" name="TXT_TENKOLOADRESTRESULT0" value="<?= $result_seTenkotransport2['TENKOLOADRESTRESULT0'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT0', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT0" name="TXT_TENKOBODYSLEEPYRESULT0" value="<?= $result_seTenkotransport2['TENKOBODYSLEEPYRESULT0'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT0', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT0" name="TXT_TENKOCARNEWRESULT0" value="<?= $result_seTenkotransport2['TENKOCARNEWRESULT0'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT0', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT0" name="TXT_TENKOTRAILERRESULT0" value="<?= $result_seTenkotransport2['TENKOTRAILERRESULT0'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT0', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOROADRESULT0" name="TXT_TENKOROADRESULT0" value="<?= $result_seTenkotransport2['TENKOROADRESULT0'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT0', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT0" name="TXT_TENKOAIRRESULT0" value="<?= $result_seTenkotransport2['TENKOAIRRESULT0'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT0', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT0" name="TXT_TENKOSLEEPYRESULT0" value="<?= $result_seTenkotransport2['TENKOSLEEPYRESULT0'] ?>"></td>
                                                                                <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOLOADRESTREMARK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')"><?= $result_seTenkotransport2['TENKOLOADRESTREMARK'] ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="text-align: center">2</td>
                                                                                <td>ตรวจร่างกาย - อาการง่วง</td>
                                                                                <td style="text-align: center"><input type="checkbox" <?= $rs2d2 ?> onchange="edit_check2d2('TENKOBODYSLEEPYCHECK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" style="transform: scale(2)"  id="chk_2d2" name="chk_2d2"/></td>
                                                                                <td>วิธีการพูดคุยต้องร่าเริง</td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT1', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT1" name="TXT_TENKOLOADRESTRESULT1" value="<?= $result_seTenkotransport2['TENKOLOADRESTRESULT1'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT1', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT1" name="TXT_TENKOBODYSLEEPYRESULT1" value="<?= $result_seTenkotransport2['TENKOBODYSLEEPYRESULT1'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT1', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT1" name="TXT_TENKOCARNEWRESULT1" value="<?= $result_seTenkotransport2['TENKOCARNEWRESULT1'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT1', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT1" name="TXT_TENKOTRAILERRESULT1" value="<?= $result_seTenkotransport2['TENKOTRAILERRESULT1'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT1', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOROADRESULT1" name="TXT_TENKOROADRESULT1" value="<?= $result_seTenkotransport2['TENKOROADRESULT1'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT1', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT1" name="TXT_TENKOAIRRESULT1" value="<?= $result_seTenkotransport2['TENKOAIRRESULT1'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT1', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT1" name="TXT_TENKOSLEEPYRESULT1" value="<?= $result_seTenkotransport2['TENKOSLEEPYRESULT1'] ?>"></td>
                                                                                <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOBODYSLEEPYREMARK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')"><?= $result_seTenkotransport2['TENKOBODYSLEEPYREMARK'] ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="text-align: center">3</td>
                                                                                <td>ตรวจรถใหม่ (เฉพาะหยุดรถ)</td>
                                                                                <td style="text-align: center"><input type="checkbox" <?= $rs3d2 ?> onchange="edit_check3d2('TENKOCARNEWCHECK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" style="transform: scale(2)"  id="chk_3d2" name="chk_3d2"/></td>
                                                                                <td>มีการรายงานเกี่ยวกับรถใหม่ว่ามีสิ่งผิดปกติหรือไม่</td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT2', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT2" name="TXT_TENKOLOADRESTRESULT2" value="<?= $result_seTenkotransport2['TENKOLOADRESTRESULT2'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT2', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT2" name="TXT_TENKOBODYSLEEPYRESULT2" value="<?= $result_seTenkotransport2['TENKOBODYSLEEPYRESULT2'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT2', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT2" name="TXT_TENKOCARNEWRESULT2" value="<?= $result_seTenkotransport2['TENKOCARNEWRESULT2'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT2', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT2" name="TXT_TENKOTRAILERRESULT2" value="<?= $result_seTenkotransport2['TENKOTRAILERRESULT2'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT2', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOROADRESULT2" name="TXT_TENKOROADRESULT2" value="<?= $result_seTenkotransport2['TENKOROADRESULT2'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT2', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT2" name="TXT_TENKOAIRRESULT2" value="<?= $result_seTenkotransport2['TENKOAIRRESULT2'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT2', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT2" name="TXT_TENKOSLEEPYRESULT2" value="<?= $result_seTenkotransport2['TENKOSLEEPYRESULT2'] ?>"></td>
                                                                                <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOCARNEWREMARK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')"><?= $result_seTenkotransport2['TENKOCARNEWREMARK'] ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="text-align: center">4</td>
                                                                                <td>ตรวจเทรลเลอร์</td>
                                                                                <td style="text-align: center"><input type="checkbox" <?= $rs4d2 ?> onchange="edit_check4d2('TENKOTRAILERCHECK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" style="transform: scale(2)"  id="chk_4d2" name="chk_4d2"/></td>
                                                                                <td>ระหว่างวิ่งงานไม่มีสิ่งผิดปกติ</td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT3', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT3" name="TXT_TENKOLOADRESTRESULT3" value="<?= $result_seTenkotransport2['TENKOLOADRESTRESULT3'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT3', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT3" name="TXT_TENKOBODYSLEEPYRESULT3" value="<?= $result_seTenkotransport2['TENKOBODYSLEEPYRESULT3'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT3', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT3" name="TXT_TENKOCARNEWRESULT3" value="<?= $result_seTenkotransport2['TENKOCARNEWRESULT3'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT3', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT3" name="TXT_TENKOTRAILERRESULT3" value="<?= $result_seTenkotransport2['TENKOTRAILERRESULT3'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT3', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOROADRESULT3" name="TXT_TENKOROADRESULT3" value="<?= $result_seTenkotransport2['TENKOROADRESULT3'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT3', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT3" name="TXT_TENKOAIRRESULT3" value="<?= $result_seTenkotransport2['TENKOAIRRESULT3'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT3', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT3" name="TXT_TENKOSLEEPYRESULT3" value="<?= $result_seTenkotransport2['TENKOSLEEPYRESULT3'] ?>"></td>
                                                                                <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOTRAILERREMARK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')"><?= $result_seTenkotransport2['TENKOTRAILERREMARK'] ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="text-align: center">5</td>
                                                                                <td>ตรวจสภาพถนน</td>
                                                                                <td style="text-align: center"><input type="checkbox" <?= $rs5d2 ?> onchange="edit_check5d2('TENKOROADCHECK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" style="transform: scale(2)"  id="chk_5d2" name="chk_5d2"/></td>
                                                                                <td>รายงานสภาพถนน</td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT4', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT4" name="TXT_TENKOLOADRESTRESULT4" value="<?= $result_seTenkotransport2['TENKOLOADRESTRESULT4'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT4', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT4" name="TXT_TENKOBODYSLEEPYRESULT4" value="<?= $result_seTenkotransport2['TENKOBODYSLEEPYRESULT4'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT4', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT4" name="TXT_TENKOCARNEWRESULT4" value="<?= $result_seTenkotransport2['TENKOCARNEWRESULT4'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT4', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT4" name="TXT_TENKOTRAILERRESULT4" value="<?= $result_seTenkotransport2['TENKOTRAILERRESULT4'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT4', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOROADRESULT4" name="TXT_TENKOROADRESULT4" value="<?= $result_seTenkotransport2['TENKOROADRESULT4'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT4', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT4" name="TXT_TENKOAIRRESULT0" value="<?= $result_seTenkotransport2['TENKOAIRRESULT4'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT4', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT4" name="TXT_TENKOSLEEPYRESULT4" value="<?= $result_seTenkotransport2['TENKOSLEEPYRESULT4'] ?>"></td>
                                                                                <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOROADREMARK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')"><?= $result_seTenkotransport2['TENKOROADREMARK'] ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="text-align: center">6</td>
                                                                                <td>ตรวจสภาพอากาศ (ใช้ที่ปัดน้ำฝนระดับ 3 ให้หยุดรถ)</td>
                                                                                <td style="text-align: center"><input type="checkbox" <?= $rs6d2 ?> onchange="edit_check6d2('TENKOAIRCHECK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" style="transform: scale(2)"  id="chk_6d2" name="chk_6d2"/></td>
                                                                                <td>รายงานสภาพอากาศ2</td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT5', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT5" name="TXT_TENKOLOADRESTRESULT5" value="<?= $result_seTenkotransport2['TENKOLOADRESTRESULT5'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT5', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT5" name="TXT_TENKOBODYSLEEPYRESULT5" value="<?= $result_seTenkotransport2['TENKOBODYSLEEPYRESULT5'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT5', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT5" name="TXT_TENKOCARNEWRESULT5" value="<?= $result_seTenkotransport2['TENKOCARNEWRESULT5'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT5', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT5" name="TXT_TENKOTRAILERRESULT5" value="<?= $result_seTenkotransport2['TENKOTRAILERRESULT5'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT5', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOROADRESULT5" name="TXT_TENKOROADRESULT5" value="<?= $result_seTenkotransport2['TENKOROADRESULT5'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT5', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT5" name="TXT_TENKOAIRRESULT5" value="<?= $result_seTenkotransport2['TENKOAIRRESULT5'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT5', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT5" name="TXT_TENKOSLEEPYRESULT5" value="<?= $result_seTenkotransport2['TENKOSLEEPYRESULT5'] ?>"></td>
                                                                                <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOAIRREMARK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')"><?= $result_seTenkotransport2['TENKOAIRREMARK'] ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="text-align: center">7</td>
                                                                                <td>ตรวจสอบอาการง่วงและย้ำให้ระมัดระวัง</td>
                                                                                <td style="text-align: center"><input type="checkbox" <?= $rs7d2 ?> onchange="edit_check7d2('TENKOSLEEPYCHECK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" style="transform: scale(2)" id="chk_7d2" name="chk_7d2" /></td>
                                                                                <td>สภาพที่สามารถวิ่งงานต่อได้</td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT6', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT6" name="TXT_TENKOLOADRESTRESULT6" value="<?= $result_seTenkotransport2['TENKOLOADRESTRESULT6'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT6', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT6" name="TXT_TENKOBODYSLEEPYRESULT6" value="<?= $result_seTenkotransport2['TENKOBODYSLEEPYRESULT6'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT6', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT6" name="TXT_TENKOCARNEWRESULT6" value="<?= $result_seTenkotransport2['TENKOCARNEWRESULT6'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT6', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT6" name="TXT_TENKOTRAILERRESULT6" value="<?= $result_seTenkotransport2['TENKOTRAILERRESULT6'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT6', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOROADRESULT6" name="TXT_TENKOROADRESULT6" value="<?= $result_seTenkotransport2['TENKOROADRESULT6'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT6', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT6" name="TXT_TENKOAIRRESULT6" value="<?= $result_seTenkotransport2['TENKOAIRRESULT6'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT6', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT6" name="TXT_TENKOSLEEPYRESULT6" value="<?= $result_seTenkotransport2['TENKOSLEEPYRESULT6'] ?>"></td>
                                                                                <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOSLEEPYREMARK', '<?= $result_seTenkotransport2['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F2'] ?>')"><?= $result_seTenkotransport2['TENKOSLEEPYREMARK'] ?></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>

                                                                </div>
                                                                <div class="tab-pane" id="day3">
            <?php
            $conditionTenkotransport31 = " AND TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "' AND TENKOMASTERDIRVERCODE = '" . $_GET['employeecode2'] . "' ";
            $conditionTenkotransport32 = " AND CONVERT(DATE,TENKOTRANSPORTDATE) = CONVERT(DATE,'" . $result_seTenkomaster['DATEINPUT_F3'] . "',103)";
            $sql_seTenkotransport3 = "{call megEdittenkotransport_v2(?,?,?)}";
            $params_seTenkotransport3 = array(
                array('select_tenkotransport', SQLSRV_PARAM_IN),
                array($conditionTenkotransport31, SQLSRV_PARAM_IN),
                array($conditionTenkotransport32, SQLSRV_PARAM_IN)
            );
            $query_seTenkotransport3 = sqlsrv_query($conn, $sql_seTenkotransport3, $params_seTenkotransport3);
            $result_seTenkotransport3 = sqlsrv_fetch_array($query_seTenkotransport3, SQLSRV_FETCH_ASSOC);

            $rs1d3 = ($result_seTenkotransport3['TENKOLOADRESTCHECK'] == '1') ? "checked" : "";
            $rs2d3 = ($result_seTenkotransport3['TENKOBODYSLEEPYCHECK'] == '1') ? "checked" : "";
            $rs3d3 = ($result_seTenkotransport3['TENKOCARNEWCHECK'] == '1') ? "checked" : "";
            $rs4d3 = ($result_seTenkotransport3['TENKOTRAILERCHECK'] == '1') ? "checked" : "";
            $rs5d3 = ($result_seTenkotransport3['TENKOROADCHECK'] == '1') ? "checked" : "";
            $rs6d3 = ($result_seTenkotransport3['TENKOAIRCHECK'] == '1') ? "checked" : "";
            $rs7d3 = ($result_seTenkotransport3['TENKOSLEEPYCHECK'] == '1') ? "checked" : "";
            ?>
                                                                    <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
                                                                        <thead>
                                                                            <tr>

                                                                                <th colspan="6" ><font style="color: green">พนักงานขับรถ : นาย <?= $result_seTenkomaster['TENKOMASTERDIRVERNAME2'] ?></font></th>
                                                                                <th colspan="2" style="text-align: center;">เจ้าหน้าที่เท็งโกะก่อนเริ่มงาน</th>
                                                                                <th style="text-align: center;"><?= $result_seTenkotransport1["CREATEBY"] ?></th>
                                                                                <th colspan="2" style="text-align: center;">เจ้าหน้าที่เท็งโกะปฎิบัติงาน</th>
                                                                                <th style="text-align: center;"><?= $result_seEmployee["nameT"] ?></th>
                                                                            </tr>
                                                                            <tr>

                                                                                <th colspan="12">เจ้าหน้าที่โทรไปไม่พบสิ่งผิดปกติ : <font style="color: red">0</font>  | พนักงานขับรถโทรมาไม่พบสิ่งผิดปกติ : <font style="color: red">1</font> | พบสิ่งผิดปกติ : <font style="color: red">x</font></th>
                                                                            </tr>
                                                                            <tr>

                                                                                <th rowspan="4" style="text-align: center;">ข้อ</th>
                                                                                <th rowspan="4" style="text-align: center;">หัวข้อ</th>
                                                                                <th rowspan="4" style="text-align: center;">ช่องตรวจ</th>
                                                                                <th rowspan="4" style="text-align: center;">เกณฑ์การตัดสิน</th>
                                                                                <th rowspan="2" style="text-align: center;"><p>โทรช่วง </p>
                                                                                    <p>00:01 - 23:59</p></th>
                                                                                <th colspan="6" style="text-align: center">Night Call Check</th>
                                                                                <th rowspan="4"style="text-align: center;">รายละเอียดการแนะนำของเจ้าหน้าที่</th>
                                                                            </tr>
                                                                            <tr>

                                                                                <th style="text-align: center;">ครั้งที่ 1</th>
                                                                                <th style="text-align: center;">ครั้งที่ 2</th>
                                                                                <th style="text-align: center;">ครั้งที่ 3</th>
                                                                                <th style="text-align: center;">ครั้งที่ 4</th>
                                                                                <th style="text-align: center;">ครั้งที่ 5</th>
                                                                                <th style="text-align: center;">ครั้งที่ 6</th>
                                                                            </tr>
                                                                            <tr>

                                                                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME0', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control timeen" id="txt_time0" name="txt_time0" value="<?= $result_seTenkotransport3['TENKOTIME0'] ?>"></th>
                                                                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME1', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control timeen" id="txt_time1" name="txt_time1" value="<?= $result_seTenkotransport3['TENKOTIME1'] ?>"></th>
                                                                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME2', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control timeen" id="txt_time2" name="txt_time2" value="<?= $result_seTenkotransport3['TENKOTIME2'] ?>"></th>
                                                                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME3', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control timeen" id="txt_time3" name="txt_time3" value="<?= $result_seTenkotransport3['TENKOTIME3'] ?>"></th>
                                                                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME4', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control timeen" id="txt_time4" name="txt_time4" value="<?= $result_seTenkotransport3['TENKOTIME4'] ?>"></th>
                                                                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME5', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control timeen" id="txt_time5" name="txt_time5" value="<?= $result_seTenkotransport3['TENKOTIME5'] ?>"></th>
                                                                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME6', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control timeen" id="txt_time6" name="txt_time6" value="<?= $result_seTenkotransport3['TENKOTIME6'] ?>"></th>
                                                                            </tr>
                                                                            <tr>

                                                                                <th style="text-align: center;">ผล</th>
                                                                                <th style="text-align: center;">ผล</th>
                                                                                <th style="text-align: center;">ผล</th>
                                                                                <th style="text-align: center;">ผล</th>
                                                                                <th style="text-align: center;">ผล</th>
                                                                                <th style="text-align: center;">ผล</th>
                                                                                <th style="text-align: center;">ผล</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="text-align: center">1</td>
                                                                                <td>เส้นทางที่กำหนด - จุดพัก</td>
                                                                                <td style="text-align: center"><input type="checkbox" <?= $rs1d3 ?> onchange="edit_check1d3('TENKOLOADRESTCHECK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" style="transform: scale(2)" id="chk_1d3" name="chk_1d3" /></td>
                                                                                <td>เส้นทาง จุดพักที่กำหนด</td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT0', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT0" name="TXT_TENKOLOADRESTRESULT0" value="<?= $result_seTenkotransport3['TENKOLOADRESTRESULT0'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT0', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT0" name="TXT_TENKOBODYSLEEPYRESULT0" value="<?= $result_seTenkotransport3['TENKOBODYSLEEPYRESULT0'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT0', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT0" name="TXT_TENKOCARNEWRESULT0" value="<?= $result_seTenkotransport3['TENKOCARNEWRESULT0'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT0', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT0" name="TXT_TENKOTRAILERRESULT0" value="<?= $result_seTenkotransport3['TENKOTRAILERRESULT0'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT0', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOROADRESULT0" name="TXT_TENKOROADRESULT0" value="<?= $result_seTenkotransport3['TENKOROADRESULT0'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT0', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT0" name="TXT_TENKOAIRRESULT0" value="<?= $result_seTenkotransport3['TENKOAIRRESULT0'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT0', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT0" name="TXT_TENKOSLEEPYRESULT0" value="<?= $result_seTenkotransport3['TENKOSLEEPYRESULT0'] ?>"></td>
                                                                                <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOLOADRESTREMARK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')"><?= $result_seTenkotransport3['TENKOLOADRESTREMARK'] ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="text-align: center">2</td>
                                                                                <td>ตรวจร่างกาย - อาการง่วง</td>
                                                                                <td style="text-align: center"><input type="checkbox" <?= $rs2d3 ?> onchange="edit_check2d3('TENKOBODYSLEEPYCHECK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" style="transform: scale(2)"  id="chk_2d3" name="chk_2d3"/></td>
                                                                                <td>วิธีการพูดคุยต้องร่าเริง</td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT1', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT1" name="TXT_TENKOLOADRESTRESULT1" value="<?= $result_seTenkotransport3['TENKOLOADRESTRESULT1'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT1', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT1" name="TXT_TENKOBODYSLEEPYRESULT1" value="<?= $result_seTenkotransport3['TENKOBODYSLEEPYRESULT1'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT1', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT1" name="TXT_TENKOCARNEWRESULT1" value="<?= $result_seTenkotransport3['TENKOCARNEWRESULT1'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT1', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT1" name="TXT_TENKOTRAILERRESULT1" value="<?= $result_seTenkotransport3['TENKOTRAILERRESULT1'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT1', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOROADRESULT1" name="TXT_TENKOROADRESULT1" value="<?= $result_seTenkotransport3['TENKOROADRESULT1'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT1', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT1" name="TXT_TENKOAIRRESULT1" value="<?= $result_seTenkotransport3['TENKOAIRRESULT1'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT1', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT1" name="TXT_TENKOSLEEPYRESULT1" value="<?= $result_seTenkotransport3['TENKOSLEEPYRESULT1'] ?>"></td>
                                                                                <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOBODYSLEEPYREMARK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')"><?= $result_seTenkotransport3['TENKOBODYSLEEPYREMARK'] ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="text-align: center">3</td>
                                                                                <td>ตรวจรถใหม่ (เฉพาะหยุดรถ)</td>
                                                                                <td style="text-align: center"><input type="checkbox" <?= $rs3d3 ?> onchange="edit_check3d3('TENKOCARNEWCHECK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" style="transform: scale(2)"  id="chk_3d3" name="chk_3d3"/></td>
                                                                                <td>มีการรายงานเกี่ยวกับรถใหม่ว่ามีสิ่งผิดปกติหรือไม่</td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT2', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT2" name="TXT_TENKOLOADRESTRESULT2" value="<?= $result_seTenkotransport3['TENKOLOADRESTRESULT2'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT2', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT2" name="TXT_TENKOBODYSLEEPYRESULT2" value="<?= $result_seTenkotransport3['TENKOBODYSLEEPYRESULT2'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT2', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT2" name="TXT_TENKOCARNEWRESULT2" value="<?= $result_seTenkotransport3['TENKOCARNEWRESULT2'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT2', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT2" name="TXT_TENKOTRAILERRESULT2" value="<?= $result_seTenkotransport3['TENKOTRAILERRESULT2'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT2', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOROADRESULT2" name="TXT_TENKOROADRESULT2" value="<?= $result_seTenkotransport3['TENKOROADRESULT2'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT2', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT2" name="TXT_TENKOAIRRESULT2" value="<?= $result_seTenkotransport3['TENKOAIRRESULT2'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT2', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT2" name="TXT_TENKOSLEEPYRESULT2" value="<?= $result_seTenkotransport3['TENKOSLEEPYRESULT2'] ?>"></td>
                                                                                <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOCARNEWREMARK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')"><?= $result_seTenkotransport3['TENKOCARNEWREMARK'] ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="text-align: center">4</td>
                                                                                <td>ตรวจเทรลเลอร์</td>
                                                                                <td style="text-align: center"><input type="checkbox" <?= $rs4d3 ?> onchange="edit_check4d3('TENKOTRAILERCHECK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" style="transform: scale(2)"  id="chk_4d3" name="chk_4d3"/></td>
                                                                                <td>ระหว่างวิ่งงานไม่มีสิ่งผิดปกติ</td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT3', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT3" name="TXT_TENKOLOADRESTRESULT3" value="<?= $result_seTenkotransport3['TENKOLOADRESTRESULT3'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT3', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT3" name="TXT_TENKOBODYSLEEPYRESULT3" value="<?= $result_seTenkotransport3['TENKOBODYSLEEPYRESULT3'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT3', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT3" name="TXT_TENKOCARNEWRESULT3" value="<?= $result_seTenkotransport3['TENKOCARNEWRESULT3'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT3', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT3" name="TXT_TENKOTRAILERRESULT3" value="<?= $result_seTenkotransport3['TENKOTRAILERRESULT3'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT3', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOROADRESULT3" name="TXT_TENKOROADRESULT3" value="<?= $result_seTenkotransport3['TENKOROADRESULT3'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT3', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT3" name="TXT_TENKOAIRRESULT3" value="<?= $result_seTenkotransport3['TENKOAIRRESULT3'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT3', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT3" name="TXT_TENKOSLEEPYRESULT3" value="<?= $result_seTenkotransport3['TENKOSLEEPYRESULT3'] ?>"></td>
                                                                                <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOTRAILERREMARK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')"><?= $result_seTenkotransport3['TENKOTRAILERREMARK'] ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="text-align: center">5</td>
                                                                                <td>ตรวจสภาพถนน</td>
                                                                                <td style="text-align: center"><input type="checkbox" <?= $rs5d3 ?> onchange="edit_check5d3('TENKOROADCHECK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" style="transform: scale(2)"  id="chk_5d3" name="chk_5d3"/></td>
                                                                                <td>รายงานสภาพถนน</td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT4', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT4" name="TXT_TENKOLOADRESTRESULT4" value="<?= $result_seTenkotransport3['TENKOLOADRESTRESULT4'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT4', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT4" name="TXT_TENKOBODYSLEEPYRESULT4" value="<?= $result_seTenkotransport3['TENKOBODYSLEEPYRESULT4'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT4', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT4" name="TXT_TENKOCARNEWRESULT4" value="<?= $result_seTenkotransport3['TENKOCARNEWRESULT4'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT4', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT4" name="TXT_TENKOTRAILERRESULT4" value="<?= $result_seTenkotransport3['TENKOTRAILERRESULT4'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT4', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOROADRESULT4" name="TXT_TENKOROADRESULT4" value="<?= $result_seTenkotransport3['TENKOROADRESULT4'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT4', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT4" name="TXT_TENKOAIRRESULT0" value="<?= $result_seTenkotransport3['TENKOAIRRESULT4'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT4', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT4" name="TXT_TENKOSLEEPYRESULT4" value="<?= $result_seTenkotransport3['TENKOSLEEPYRESULT4'] ?>"></td>
                                                                                <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOROADREMARK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')"><?= $result_seTenkotransport3['TENKOROADREMARK'] ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="text-align: center">6</td>
                                                                                <td>ตรวจสภาพอากาศ (ใช้ที่ปัดน้ำฝนระดับ 3 ให้หยุดรถ)</td>
                                                                                <td style="text-align: center"><input type="checkbox" <?= $rs6d3 ?> onchange="edit_check6d3('TENKOAIRCHECK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" style="transform: scale(2)"  id="chk_6d3" name="chk_6d3"/></td>
                                                                                <td>รายงานสภาพอากาศ3</td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT5', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT5" name="TXT_TENKOLOADRESTRESULT5" value="<?= $result_seTenkotransport3['TENKOLOADRESTRESULT5'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT5', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT5" name="TXT_TENKOBODYSLEEPYRESULT5" value="<?= $result_seTenkotransport3['TENKOBODYSLEEPYRESULT5'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT5', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT5" name="TXT_TENKOCARNEWRESULT5" value="<?= $result_seTenkotransport3['TENKOCARNEWRESULT5'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT5', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT5" name="TXT_TENKOTRAILERRESULT5" value="<?= $result_seTenkotransport3['TENKOTRAILERRESULT5'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT5', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOROADRESULT5" name="TXT_TENKOROADRESULT5" value="<?= $result_seTenkotransport3['TENKOROADRESULT5'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT5', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT5" name="TXT_TENKOAIRRESULT5" value="<?= $result_seTenkotransport3['TENKOAIRRESULT5'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT5', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT5" name="TXT_TENKOSLEEPYRESULT5" value="<?= $result_seTenkotransport3['TENKOSLEEPYRESULT5'] ?>"></td>
                                                                                <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOAIRREMARK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')"><?= $result_seTenkotransport3['TENKOAIRREMARK'] ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="text-align: center">7</td>
                                                                                <td>ตรวจสอบอาการง่วงและย้ำให้ระมัดระวัง</td>
                                                                                <td style="text-align: center"><input type="checkbox" <?= $rs7d3 ?> onchange="edit_check7d3('TENKOSLEEPYCHECK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" style="transform: scale(2)" id="chk_7d3" name="chk_7d3" /></td>
                                                                                <td>สภาพที่สามารถวิ่งงานต่อได้</td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT6', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT6" name="TXT_TENKOLOADRESTRESULT6" value="<?= $result_seTenkotransport3['TENKOLOADRESTRESULT6'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT6', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT6" name="TXT_TENKOBODYSLEEPYRESULT6" value="<?= $result_seTenkotransport3['TENKOBODYSLEEPYRESULT6'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT6', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT6" name="TXT_TENKOCARNEWRESULT6" value="<?= $result_seTenkotransport3['TENKOCARNEWRESULT6'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT6', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT6" name="TXT_TENKOTRAILERRESULT6" value="<?= $result_seTenkotransport3['TENKOTRAILERRESULT6'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT6', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOROADRESULT6" name="TXT_TENKOROADRESULT6" value="<?= $result_seTenkotransport3['TENKOROADRESULT6'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT6', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT6" name="TXT_TENKOAIRRESULT6" value="<?= $result_seTenkotransport3['TENKOAIRRESULT6'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT6', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT6" name="TXT_TENKOSLEEPYRESULT6" value="<?= $result_seTenkotransport3['TENKOSLEEPYRESULT6'] ?>"></td>
                                                                                <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOSLEEPYREMARK', '<?= $result_seTenkotransport3['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F3'] ?>')"><?= $result_seTenkotransport3['TENKOSLEEPYREMARK'] ?></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>

                                                                </div>
                                                                <div class="tab-pane" id="day4">
            <?php
            $conditionTenkotransport41 = " AND TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "' AND TENKOMASTERDIRVERCODE = '" . $_GET['employeecode2'] . "' ";
            $conditionTenkotransport42 = " AND CONVERT(DATE,TENKOTRANSPORTDATE) = CONVERT(DATE,'" . $result_seTenkomaster['DATEINPUT_F4'] . "',103)";
            $sql_seTenkotransport4 = "{call megEdittenkotransport_v2(?,?,?)}";
            $params_seTenkotransport4 = array(
                array('select_tenkotransport', SQLSRV_PARAM_IN),
                array($conditionTenkotransport41, SQLSRV_PARAM_IN),
                array($conditionTenkotransport42, SQLSRV_PARAM_IN)
            );
            $query_seTenkotransport4 = sqlsrv_query($conn, $sql_seTenkotransport4, $params_seTenkotransport4);
            $result_seTenkotransport4 = sqlsrv_fetch_array($query_seTenkotransport4, SQLSRV_FETCH_ASSOC);

            $rs1d4 = ($result_seTenkotransport4['TENKOLOADRESTCHECK'] == '1') ? "checked" : "";
            $rs2d4 = ($result_seTenkotransport4['TENKOBODYSLEEPYCHECK'] == '1') ? "checked" : "";
            $rs3d4 = ($result_seTenkotransport4['TENKOCARNEWCHECK'] == '1') ? "checked" : "";
            $rs4d4 = ($result_seTenkotransport4['TENKOTRAILERCHECK'] == '1') ? "checked" : "";
            $rs5d4 = ($result_seTenkotransport4['TENKOROADCHECK'] == '1') ? "checked" : "";
            $rs6d4 = ($result_seTenkotransport4['TENKOAIRCHECK'] == '1') ? "checked" : "";
            $rs7d4 = ($result_seTenkotransport4['TENKOSLEEPYCHECK'] == '1') ? "checked" : "";
            ?>
                                                                    <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
                                                                        <thead>
                                                                            <tr>

                                                                                <th colspan="6" ><font style="color: green">พนักงานขับรถ : นาย <?= $result_seTenkomaster['TENKOMASTERDIRVERNAME2'] ?></font></th>
                                                                                <th colspan="2" style="text-align: center;">เจ้าหน้าที่เท็งโกะก่อนเริ่มงาน</th>
                                                                                <th style="text-align: center;"><?= $result_seTenkotransport1["CREATEBY"] ?></th>
                                                                                <th colspan="2" style="text-align: center;">เจ้าหน้าที่เท็งโกะปฎิบัติงาน</th>
                                                                                <th style="text-align: center;"><?= $result_seEmployee["nameT"] ?></th>
                                                                            </tr>
                                                                            <tr>

                                                                                <th colspan="12">เจ้าหน้าที่โทรไปไม่พบสิ่งผิดปกติ : <font style="color: red">0</font>  | พนักงานขับรถโทรมาไม่พบสิ่งผิดปกติ : <font style="color: red">1</font> | พบสิ่งผิดปกติ : <font style="color: red">x</font></th>
                                                                            </tr>
                                                                            <tr>

                                                                                <th rowspan="4" style="text-align: center;">ข้อ</th>
                                                                                <th rowspan="4" style="text-align: center;">หัวข้อ</th>
                                                                                <th rowspan="4" style="text-align: center;">ช่องตรวจ</th>
                                                                                <th rowspan="4" style="text-align: center;">เกณฑ์การตัดสิน</th>
                                                                                <th rowspan="2" style="text-align: center;"><p>โทรช่วง </p>
                                                                                    <p>00:01 - 23:59</p></th>
                                                                                <th colspan="6" style="text-align: center">Night Call Check</th>
                                                                                <th rowspan="4"style="text-align: center;">รายละเอียดการแนะนำของเจ้าหน้าที่</th>
                                                                            </tr>
                                                                            <tr>

                                                                                <th style="text-align: center;">ครั้งที่ 1</th>
                                                                                <th style="text-align: center;">ครั้งที่ 2</th>
                                                                                <th style="text-align: center;">ครั้งที่ 3</th>
                                                                                <th style="text-align: center;">ครั้งที่ 4</th>
                                                                                <th style="text-align: center;">ครั้งที่ 5</th>
                                                                                <th style="text-align: center;">ครั้งที่ 6</th>
                                                                            </tr>
                                                                            <tr>

                                                                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME0', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control timeen" id="txt_time0" name="txt_time0" value="<?= $result_seTenkotransport4['TENKOTIME0'] ?>"></th>
                                                                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME1', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control timeen" id="txt_time1" name="txt_time1" value="<?= $result_seTenkotransport4['TENKOTIME1'] ?>"></th>
                                                                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME2', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control timeen" id="txt_time2" name="txt_time2" value="<?= $result_seTenkotransport4['TENKOTIME2'] ?>"></th>
                                                                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME3', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control timeen" id="txt_time3" name="txt_time3" value="<?= $result_seTenkotransport4['TENKOTIME3'] ?>"></th>
                                                                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME4', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control timeen" id="txt_time4" name="txt_time4" value="<?= $result_seTenkotransport4['TENKOTIME4'] ?>"></th>
                                                                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME5', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control timeen" id="txt_time5" name="txt_time5" value="<?= $result_seTenkotransport4['TENKOTIME5'] ?>"></th>
                                                                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME6', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control timeen" id="txt_time6" name="txt_time6" value="<?= $result_seTenkotransport4['TENKOTIME6'] ?>"></th>
                                                                            </tr>
                                                                            <tr>

                                                                                <th style="text-align: center;">ผล</th>
                                                                                <th style="text-align: center;">ผล</th>
                                                                                <th style="text-align: center;">ผล</th>
                                                                                <th style="text-align: center;">ผล</th>
                                                                                <th style="text-align: center;">ผล</th>
                                                                                <th style="text-align: center;">ผล</th>
                                                                                <th style="text-align: center;">ผล</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="text-align: center">1</td>
                                                                                <td>เส้นทางที่กำหนด - จุดพัก</td>
                                                                                <td style="text-align: center"><input type="checkbox" <?= $rs1d4 ?> onchange="edit_check1d4('TENKOLOADRESTCHECK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" style="transform: scale(2)" id="chk_1d4" name="chk_1d4" /></td>
                                                                                <td>เส้นทาง จุดพักที่กำหนด</td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT0', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT0" name="TXT_TENKOLOADRESTRESULT0" value="<?= $result_seTenkotransport4['TENKOLOADRESTRESULT0'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT0', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT0" name="TXT_TENKOBODYSLEEPYRESULT0" value="<?= $result_seTenkotransport4['TENKOBODYSLEEPYRESULT0'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT0', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT0" name="TXT_TENKOCARNEWRESULT0" value="<?= $result_seTenkotransport4['TENKOCARNEWRESULT0'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT0', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT0" name="TXT_TENKOTRAILERRESULT0" value="<?= $result_seTenkotransport4['TENKOTRAILERRESULT0'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT0', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOROADRESULT0" name="TXT_TENKOROADRESULT0" value="<?= $result_seTenkotransport4['TENKOROADRESULT0'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT0', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT0" name="TXT_TENKOAIRRESULT0" value="<?= $result_seTenkotransport4['TENKOAIRRESULT0'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT0', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT0" name="TXT_TENKOSLEEPYRESULT0" value="<?= $result_seTenkotransport4['TENKOSLEEPYRESULT0'] ?>"></td>
                                                                                <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOLOADRESTREMARK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')"><?= $result_seTenkotransport4['TENKOLOADRESTREMARK'] ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="text-align: center">2</td>
                                                                                <td>ตรวจร่างกาย - อาการง่วง</td>
                                                                                <td style="text-align: center"><input type="checkbox" <?= $rs2d4 ?> onchange="edit_check2d4('TENKOBODYSLEEPYCHECK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" style="transform: scale(2)"  id="chk_2d4" name="chk_2d4"/></td>
                                                                                <td>วิธีการพูดคุยต้องร่าเริง</td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT1', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT1" name="TXT_TENKOLOADRESTRESULT1" value="<?= $result_seTenkotransport4['TENKOLOADRESTRESULT1'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT1', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT1" name="TXT_TENKOBODYSLEEPYRESULT1" value="<?= $result_seTenkotransport4['TENKOBODYSLEEPYRESULT1'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT1', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT1" name="TXT_TENKOCARNEWRESULT1" value="<?= $result_seTenkotransport4['TENKOCARNEWRESULT1'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT1', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT1" name="TXT_TENKOTRAILERRESULT1" value="<?= $result_seTenkotransport4['TENKOTRAILERRESULT1'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT1', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOROADRESULT1" name="TXT_TENKOROADRESULT1" value="<?= $result_seTenkotransport4['TENKOROADRESULT1'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT1', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT1" name="TXT_TENKOAIRRESULT1" value="<?= $result_seTenkotransport4['TENKOAIRRESULT1'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT1', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT1" name="TXT_TENKOSLEEPYRESULT1" value="<?= $result_seTenkotransport4['TENKOSLEEPYRESULT1'] ?>"></td>
                                                                                <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOBODYSLEEPYREMARK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')"><?= $result_seTenkotransport4['TENKOBODYSLEEPYREMARK'] ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="text-align: center">3</td>
                                                                                <td>ตรวจรถใหม่ (เฉพาะหยุดรถ)</td>
                                                                                <td style="text-align: center"><input type="checkbox" <?= $rs3d4 ?> onchange="edit_check3d4('TENKOCARNEWCHECK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" style="transform: scale(2)"  id="chk_3d4" name="chk_3d4"/></td>
                                                                                <td>มีการรายงานเกี่ยวกับรถใหม่ว่ามีสิ่งผิดปกติหรือไม่</td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT2', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT2" name="TXT_TENKOLOADRESTRESULT2" value="<?= $result_seTenkotransport4['TENKOLOADRESTRESULT2'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT2', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT2" name="TXT_TENKOBODYSLEEPYRESULT2" value="<?= $result_seTenkotransport4['TENKOBODYSLEEPYRESULT2'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT2', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT2" name="TXT_TENKOCARNEWRESULT2" value="<?= $result_seTenkotransport4['TENKOCARNEWRESULT2'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT2', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT2" name="TXT_TENKOTRAILERRESULT2" value="<?= $result_seTenkotransport4['TENKOTRAILERRESULT2'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT2', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOROADRESULT2" name="TXT_TENKOROADRESULT2" value="<?= $result_seTenkotransport4['TENKOROADRESULT2'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT2', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT2" name="TXT_TENKOAIRRESULT2" value="<?= $result_seTenkotransport4['TENKOAIRRESULT2'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT2', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT2" name="TXT_TENKOSLEEPYRESULT2" value="<?= $result_seTenkotransport4['TENKOSLEEPYRESULT2'] ?>"></td>
                                                                                <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOCARNEWREMARK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')"><?= $result_seTenkotransport4['TENKOCARNEWREMARK'] ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="text-align: center">4</td>
                                                                                <td>ตรวจเทรลเลอร์</td>
                                                                                <td style="text-align: center"><input type="checkbox" <?= $rs4d4 ?> onchange="edit_check4d4('TENKOTRAILERCHECK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" style="transform: scale(2)"  id="chk_4d4" name="chk_4d4"/></td>
                                                                                <td>ระหว่างวิ่งงานไม่มีสิ่งผิดปกติ</td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT3', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT3" name="TXT_TENKOLOADRESTRESULT3" value="<?= $result_seTenkotransport4['TENKOLOADRESTRESULT3'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT3', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT3" name="TXT_TENKOBODYSLEEPYRESULT3" value="<?= $result_seTenkotransport4['TENKOBODYSLEEPYRESULT3'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT3', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT3" name="TXT_TENKOCARNEWRESULT3" value="<?= $result_seTenkotransport4['TENKOCARNEWRESULT3'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT3', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT3" name="TXT_TENKOTRAILERRESULT3" value="<?= $result_seTenkotransport4['TENKOTRAILERRESULT3'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT3', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOROADRESULT3" name="TXT_TENKOROADRESULT3" value="<?= $result_seTenkotransport4['TENKOROADRESULT3'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT3', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT3" name="TXT_TENKOAIRRESULT3" value="<?= $result_seTenkotransport4['TENKOAIRRESULT3'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT3', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT3" name="TXT_TENKOSLEEPYRESULT3" value="<?= $result_seTenkotransport4['TENKOSLEEPYRESULT3'] ?>"></td>
                                                                                <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOTRAILERREMARK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')"><?= $result_seTenkotransport4['TENKOTRAILERREMARK'] ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="text-align: center">5</td>
                                                                                <td>ตรวจสภาพถนน</td>
                                                                                <td style="text-align: center"><input type="checkbox" <?= $rs5d4 ?> onchange="edit_check5d4('TENKOROADCHECK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" style="transform: scale(2)"  id="chk_5d4" name="chk_5d4"/></td>
                                                                                <td>รายงานสภาพถนน</td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT4', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT4" name="TXT_TENKOLOADRESTRESULT4" value="<?= $result_seTenkotransport4['TENKOLOADRESTRESULT4'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT4', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT4" name="TXT_TENKOBODYSLEEPYRESULT4" value="<?= $result_seTenkotransport4['TENKOBODYSLEEPYRESULT4'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT4', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT4" name="TXT_TENKOCARNEWRESULT4" value="<?= $result_seTenkotransport4['TENKOCARNEWRESULT4'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT4', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT4" name="TXT_TENKOTRAILERRESULT4" value="<?= $result_seTenkotransport4['TENKOTRAILERRESULT4'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT4', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOROADRESULT4" name="TXT_TENKOROADRESULT4" value="<?= $result_seTenkotransport4['TENKOROADRESULT4'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT4', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT4" name="TXT_TENKOAIRRESULT0" value="<?= $result_seTenkotransport4['TENKOAIRRESULT4'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT4', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT4" name="TXT_TENKOSLEEPYRESULT4" value="<?= $result_seTenkotransport4['TENKOSLEEPYRESULT4'] ?>"></td>
                                                                                <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOROADREMARK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')"><?= $result_seTenkotransport4['TENKOROADREMARK'] ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="text-align: center">6</td>
                                                                                <td>ตรวจสภาพอากาศ (ใช้ที่ปัดน้ำฝนระดับ 3 ให้หยุดรถ)</td>
                                                                                <td style="text-align: center"><input type="checkbox" <?= $rs6d4 ?> onchange="edit_check6d4('TENKOAIRCHECK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" style="transform: scale(2)"  id="chk_6d4" name="chk_6d4"/></td>
                                                                                <td>รายงานสภาพอากาศ4</td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT5', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT5" name="TXT_TENKOLOADRESTRESULT5" value="<?= $result_seTenkotransport4['TENKOLOADRESTRESULT5'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT5', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT5" name="TXT_TENKOBODYSLEEPYRESULT5" value="<?= $result_seTenkotransport4['TENKOBODYSLEEPYRESULT5'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT5', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT5" name="TXT_TENKOCARNEWRESULT5" value="<?= $result_seTenkotransport4['TENKOCARNEWRESULT5'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT5', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT5" name="TXT_TENKOTRAILERRESULT5" value="<?= $result_seTenkotransport4['TENKOTRAILERRESULT5'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT5', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOROADRESULT5" name="TXT_TENKOROADRESULT5" value="<?= $result_seTenkotransport4['TENKOROADRESULT5'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT5', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT5" name="TXT_TENKOAIRRESULT5" value="<?= $result_seTenkotransport4['TENKOAIRRESULT5'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT5', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT5" name="TXT_TENKOSLEEPYRESULT5" value="<?= $result_seTenkotransport4['TENKOSLEEPYRESULT5'] ?>"></td>
                                                                                <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOAIRREMARK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')"><?= $result_seTenkotransport4['TENKOAIRREMARK'] ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="text-align: center">7</td>
                                                                                <td>ตรวจสอบอาการง่วงและย้ำให้ระมัดระวัง</td>
                                                                                <td style="text-align: center"><input type="checkbox" <?= $rs7d4 ?> onchange="edit_check7d4('TENKOSLEEPYCHECK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" style="transform: scale(2)" id="chk_7d4" name="chk_7d4" /></td>
                                                                                <td>สภาพที่สามารถวิ่งงานต่อได้</td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT6', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT6" name="TXT_TENKOLOADRESTRESULT6" value="<?= $result_seTenkotransport4['TENKOLOADRESTRESULT6'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT6', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT6" name="TXT_TENKOBODYSLEEPYRESULT6" value="<?= $result_seTenkotransport4['TENKOBODYSLEEPYRESULT6'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT6', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT6" name="TXT_TENKOCARNEWRESULT6" value="<?= $result_seTenkotransport4['TENKOCARNEWRESULT6'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT6', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT6" name="TXT_TENKOTRAILERRESULT6" value="<?= $result_seTenkotransport4['TENKOTRAILERRESULT6'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT6', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOROADRESULT6" name="TXT_TENKOROADRESULT6" value="<?= $result_seTenkotransport4['TENKOROADRESULT6'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT6', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT6" name="TXT_TENKOAIRRESULT6" value="<?= $result_seTenkotransport4['TENKOAIRRESULT6'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT6', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT6" name="TXT_TENKOSLEEPYRESULT6" value="<?= $result_seTenkotransport4['TENKOSLEEPYRESULT6'] ?>"></td>
                                                                                <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOSLEEPYREMARK', '<?= $result_seTenkotransport4['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F4'] ?>')"><?= $result_seTenkotransport4['TENKOSLEEPYREMARK'] ?></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>

                                                                </div>
                                                                <div class="tab-pane" id="day5">
            <?php
            $conditionTenkotransport51 = " AND TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "' AND TENKOMASTERDIRVERCODE = '" . $_GET['employeecode2'] . "' ";
            $conditionTenkotransport52 = " AND CONVERT(DATE,TENKOTRANSPORTDATE) = CONVERT(DATE,'" . $result_seTenkomaster['DATEINPUT_F5'] . "',103)";
            $sql_seTenkotransport5 = "{call megEdittenkotransport_v2(?,?,?)}";
            $params_seTenkotransport5 = array(
                array('select_tenkotransport', SQLSRV_PARAM_IN),
                array($conditionTenkotransport51, SQLSRV_PARAM_IN),
                array($conditionTenkotransport52, SQLSRV_PARAM_IN)
            );
            $query_seTenkotransport5 = sqlsrv_query($conn, $sql_seTenkotransport5, $params_seTenkotransport5);
            $result_seTenkotransport5 = sqlsrv_fetch_array($query_seTenkotransport5, SQLSRV_FETCH_ASSOC);

            $rs1d5 = ($result_seTenkotransport5['TENKOLOADRESTCHECK'] == '1') ? "checked" : "";
            $rs2d5 = ($result_seTenkotransport5['TENKOBODYSLEEPYCHECK'] == '1') ? "checked" : "";
            $rs3d5 = ($result_seTenkotransport5['TENKOCARNEWCHECK'] == '1') ? "checked" : "";
            $rs4d5 = ($result_seTenkotransport5['TENKOTRAILERCHECK'] == '1') ? "checked" : "";
            $rs5d5 = ($result_seTenkotransport5['TENKOROADCHECK'] == '1') ? "checked" : "";
            $rs6d5 = ($result_seTenkotransport5['TENKOAIRCHECK'] == '1') ? "checked" : "";
            $rs7d5 = ($result_seTenkotransport5['TENKOSLEEPYCHECK'] == '1') ? "checked" : "";
            ?>
                                                                    <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
                                                                        <thead>
                                                                            <tr>

                                                                                <th colspan="6" ><font style="color: green">พนักงานขับรถ : นาย <?= $result_seTenkomaster['TENKOMASTERDIRVERNAME2'] ?></font></th>
                                                                                <th colspan="2" style="text-align: center;">เจ้าหน้าที่เท็งโกะก่อนเริ่มงาน</th>
                                                                                <th style="text-align: center;"><?= $result_seTenkotransport1["CREATEBY"] ?></th>
                                                                                <th colspan="2" style="text-align: center;">เจ้าหน้าที่เท็งโกะปฎิบัติงาน</th>
                                                                                <th style="text-align: center;"><?= $result_seEmployee["nameT"] ?></th>
                                                                            </tr>
                                                                            <tr>

                                                                                <th colspan="12">เจ้าหน้าที่โทรไปไม่พบสิ่งผิดปกติ : <font style="color: red">0</font>  | พนักงานขับรถโทรมาไม่พบสิ่งผิดปกติ : <font style="color: red">1</font> | พบสิ่งผิดปกติ : <font style="color: red">x</font></th>
                                                                            </tr>
                                                                            <tr>

                                                                                <th rowspan="4" style="text-align: center;">ข้อ</th>
                                                                                <th rowspan="4" style="text-align: center;">หัวข้อ</th>
                                                                                <th rowspan="4" style="text-align: center;">ช่องตรวจ</th>
                                                                                <th rowspan="4" style="text-align: center;">เกณฑ์การตัดสิน</th>
                                                                                <th rowspan="2" style="text-align: center;"><p>โทรช่วง </p>
                                                                                    <p>00:01 - 23:59</p></th>
                                                                                <th colspan="6" style="text-align: center">Night Call Check</th>
                                                                                <th rowspan="4"style="text-align: center;">รายละเอียดการแนะนำของเจ้าหน้าที่</th>
                                                                            </tr>
                                                                            <tr>

                                                                                <th style="text-align: center;">ครั้งที่ 1</th>
                                                                                <th style="text-align: center;">ครั้งที่ 2</th>
                                                                                <th style="text-align: center;">ครั้งที่ 3</th>
                                                                                <th style="text-align: center;">ครั้งที่ 4</th>
                                                                                <th style="text-align: center;">ครั้งที่ 5</th>
                                                                                <th style="text-align: center;">ครั้งที่ 6</th>
                                                                            </tr>
                                                                            <tr>

                                                                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME0', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control timeen" id="txt_time0" name="txt_time0" value="<?= $result_seTenkotransport5['TENKOTIME0'] ?>"></th>
                                                                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME1', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control timeen" id="txt_time1" name="txt_time1" value="<?= $result_seTenkotransport5['TENKOTIME1'] ?>"></th>
                                                                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME2', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control timeen" id="txt_time2" name="txt_time2" value="<?= $result_seTenkotransport5['TENKOTIME2'] ?>"></th>
                                                                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME3', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control timeen" id="txt_time3" name="txt_time3" value="<?= $result_seTenkotransport5['TENKOTIME3'] ?>"></th>
                                                                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME4', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control timeen" id="txt_time4" name="txt_time4" value="<?= $result_seTenkotransport5['TENKOTIME4'] ?>"></th>
                                                                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME5', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control timeen" id="txt_time5" name="txt_time5" value="<?= $result_seTenkotransport5['TENKOTIME5'] ?>"></th>
                                                                                <th style="text-align: center"><input type="text" onchange="edit_tenkotransporttime(this.value, 'TENKOTIME6', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control timeen" id="txt_time6" name="txt_time6" value="<?= $result_seTenkotransport5['TENKOTIME6'] ?>"></th>
                                                                            </tr>
                                                                            <tr>

                                                                                <th style="text-align: center;">ผล</th>
                                                                                <th style="text-align: center;">ผล</th>
                                                                                <th style="text-align: center;">ผล</th>
                                                                                <th style="text-align: center;">ผล</th>
                                                                                <th style="text-align: center;">ผล</th>
                                                                                <th style="text-align: center;">ผล</th>
                                                                                <th style="text-align: center;">ผล</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="text-align: center">1</td>
                                                                                <td>เส้นทางที่กำหนด - จุดพัก</td>
                                                                                <td style="text-align: center"><input type="checkbox" <?= $rs1d5 ?> onchange="edit_check1d5('TENKOLOADRESTCHECK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" style="transform: scale(2)" id="chk_1d5" name="chk_1d5" /></td>
                                                                                <td>เส้นทาง จุดพักที่กำหนด</td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT0', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT0" name="TXT_TENKOLOADRESTRESULT0" value="<?= $result_seTenkotransport5['TENKOLOADRESTRESULT0'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT0', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT0" name="TXT_TENKOBODYSLEEPYRESULT0" value="<?= $result_seTenkotransport5['TENKOBODYSLEEPYRESULT0'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT0', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT0" name="TXT_TENKOCARNEWRESULT0" value="<?= $result_seTenkotransport5['TENKOCARNEWRESULT0'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT0', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT0" name="TXT_TENKOTRAILERRESULT0" value="<?= $result_seTenkotransport5['TENKOTRAILERRESULT0'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT0', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOROADRESULT0" name="TXT_TENKOROADRESULT0" value="<?= $result_seTenkotransport5['TENKOROADRESULT0'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT0', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT0" name="TXT_TENKOAIRRESULT0" value="<?= $result_seTenkotransport5['TENKOAIRRESULT0'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT0', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT0" name="TXT_TENKOSLEEPYRESULT0" value="<?= $result_seTenkotransport5['TENKOSLEEPYRESULT0'] ?>"></td>
                                                                                <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOLOADRESTREMARK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')"><?= $result_seTenkotransport5['TENKOLOADRESTREMARK'] ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="text-align: center">2</td>
                                                                                <td>ตรวจร่างกาย - อาการง่วง</td>
                                                                                <td style="text-align: center"><input type="checkbox" <?= $rs2d5 ?> onchange="edit_check2d5('TENKOBODYSLEEPYCHECK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" style="transform: scale(2)"  id="chk_2d5" name="chk_2d5"/></td>
                                                                                <td>วิธีการพูดคุยต้องร่าเริง</td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT1', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT1" name="TXT_TENKOLOADRESTRESULT1" value="<?= $result_seTenkotransport5['TENKOLOADRESTRESULT1'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT1', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT1" name="TXT_TENKOBODYSLEEPYRESULT1" value="<?= $result_seTenkotransport5['TENKOBODYSLEEPYRESULT1'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT1', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT1" name="TXT_TENKOCARNEWRESULT1" value="<?= $result_seTenkotransport5['TENKOCARNEWRESULT1'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT1', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT1" name="TXT_TENKOTRAILERRESULT1" value="<?= $result_seTenkotransport5['TENKOTRAILERRESULT1'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT1', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOROADRESULT1" name="TXT_TENKOROADRESULT1" value="<?= $result_seTenkotransport5['TENKOROADRESULT1'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT1', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT1" name="TXT_TENKOAIRRESULT1" value="<?= $result_seTenkotransport5['TENKOAIRRESULT1'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT1', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT1" name="TXT_TENKOSLEEPYRESULT1" value="<?= $result_seTenkotransport5['TENKOSLEEPYRESULT1'] ?>"></td>
                                                                                <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOBODYSLEEPYREMARK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')"><?= $result_seTenkotransport5['TENKOBODYSLEEPYREMARK'] ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="text-align: center">3</td>
                                                                                <td>ตรวจรถใหม่ (เฉพาะหยุดรถ)</td>
                                                                                <td style="text-align: center"><input type="checkbox" <?= $rs3d5 ?> onchange="edit_check3d5('TENKOCARNEWCHECK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" style="transform: scale(2)"  id="chk_3d5" name="chk_3d5"/></td>
                                                                                <td>มีการรายงานเกี่ยวกับรถใหม่ว่ามีสิ่งผิดปกติหรือไม่</td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT2', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT2" name="TXT_TENKOLOADRESTRESULT2" value="<?= $result_seTenkotransport5['TENKOLOADRESTRESULT2'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT2', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT2" name="TXT_TENKOBODYSLEEPYRESULT2" value="<?= $result_seTenkotransport5['TENKOBODYSLEEPYRESULT2'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT2', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT2" name="TXT_TENKOCARNEWRESULT2" value="<?= $result_seTenkotransport5['TENKOCARNEWRESULT2'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT2', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT2" name="TXT_TENKOTRAILERRESULT2" value="<?= $result_seTenkotransport5['TENKOTRAILERRESULT2'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT2', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOROADRESULT2" name="TXT_TENKOROADRESULT2" value="<?= $result_seTenkotransport5['TENKOROADRESULT2'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT2', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT2" name="TXT_TENKOAIRRESULT2" value="<?= $result_seTenkotransport5['TENKOAIRRESULT2'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT2', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT2" name="TXT_TENKOSLEEPYRESULT2" value="<?= $result_seTenkotransport5['TENKOSLEEPYRESULT2'] ?>"></td>
                                                                                <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOCARNEWREMARK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')"><?= $result_seTenkotransport5['TENKOCARNEWREMARK'] ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="text-align: center">4</td>
                                                                                <td>ตรวจเทรลเลอร์</td>
                                                                                <td style="text-align: center"><input type="checkbox" <?= $rs4d5 ?> onchange="edit_check4d5('TENKOTRAILERCHECK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" style="transform: scale(2)"  id="chk_4d5" name="chk_4d5"/></td>
                                                                                <td>ระหว่างวิ่งงานไม่มีสิ่งผิดปกติ</td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT3', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT3" name="TXT_TENKOLOADRESTRESULT3" value="<?= $result_seTenkotransport5['TENKOLOADRESTRESULT3'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT3', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT3" name="TXT_TENKOBODYSLEEPYRESULT3" value="<?= $result_seTenkotransport5['TENKOBODYSLEEPYRESULT3'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT3', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT3" name="TXT_TENKOCARNEWRESULT3" value="<?= $result_seTenkotransport5['TENKOCARNEWRESULT3'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT3', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT3" name="TXT_TENKOTRAILERRESULT3" value="<?= $result_seTenkotransport5['TENKOTRAILERRESULT3'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT3', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOROADRESULT3" name="TXT_TENKOROADRESULT3" value="<?= $result_seTenkotransport5['TENKOROADRESULT3'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT3', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT3" name="TXT_TENKOAIRRESULT3" value="<?= $result_seTenkotransport5['TENKOAIRRESULT3'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT3', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT3" name="TXT_TENKOSLEEPYRESULT3" value="<?= $result_seTenkotransport5['TENKOSLEEPYRESULT3'] ?>"></td>
                                                                                <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOTRAILERREMARK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')"><?= $result_seTenkotransport5['TENKOTRAILERREMARK'] ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="text-align: center">5</td>
                                                                                <td>ตรวจสภาพถนน</td>
                                                                                <td style="text-align: center"><input type="checkbox" <?= $rs5d5 ?> onchange="edit_check5d5('TENKOROADCHECK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" style="transform: scale(2)"  id="chk_5d5" name="chk_5d5"/></td>
                                                                                <td>รายงานสภาพถนน</td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT4', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT4" name="TXT_TENKOLOADRESTRESULT4" value="<?= $result_seTenkotransport5['TENKOLOADRESTRESULT4'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT4', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT4" name="TXT_TENKOBODYSLEEPYRESULT4" value="<?= $result_seTenkotransport5['TENKOBODYSLEEPYRESULT4'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT4', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT4" name="TXT_TENKOCARNEWRESULT4" value="<?= $result_seTenkotransport5['TENKOCARNEWRESULT4'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT4', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT4" name="TXT_TENKOTRAILERRESULT4" value="<?= $result_seTenkotransport5['TENKOTRAILERRESULT4'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT4', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOROADRESULT4" name="TXT_TENKOROADRESULT4" value="<?= $result_seTenkotransport5['TENKOROADRESULT4'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT4', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT4" name="TXT_TENKOAIRRESULT0" value="<?= $result_seTenkotransport5['TENKOAIRRESULT4'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT4', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT4" name="TXT_TENKOSLEEPYRESULT4" value="<?= $result_seTenkotransport5['TENKOSLEEPYRESULT4'] ?>"></td>
                                                                                <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOROADREMARK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')"><?= $result_seTenkotransport5['TENKOROADREMARK'] ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="text-align: center">6</td>
                                                                                <td>ตรวจสภาพอากาศ (ใช้ที่ปัดน้ำฝนระดับ 3 ให้หยุดรถ)</td>
                                                                                <td style="text-align: center"><input type="checkbox" <?= $rs6d5 ?> onchange="edit_check6d5('TENKOAIRCHECK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" style="transform: scale(2)"  id="chk_6d5" name="chk_6d5"/></td>
                                                                                <td>รายงานสภาพอากาศ5</td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT5', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT5" name="TXT_TENKOLOADRESTRESULT5" value="<?= $result_seTenkotransport5['TENKOLOADRESTRESULT5'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT5', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT5" name="TXT_TENKOBODYSLEEPYRESULT5" value="<?= $result_seTenkotransport5['TENKOBODYSLEEPYRESULT5'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT5', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT5" name="TXT_TENKOCARNEWRESULT5" value="<?= $result_seTenkotransport5['TENKOCARNEWRESULT5'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT5', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT5" name="TXT_TENKOTRAILERRESULT5" value="<?= $result_seTenkotransport5['TENKOTRAILERRESULT5'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT5', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOROADRESULT5" name="TXT_TENKOROADRESULT5" value="<?= $result_seTenkotransport5['TENKOROADRESULT5'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT5', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT5" name="TXT_TENKOAIRRESULT5" value="<?= $result_seTenkotransport5['TENKOAIRRESULT5'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT5', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT5" name="TXT_TENKOSLEEPYRESULT5" value="<?= $result_seTenkotransport5['TENKOSLEEPYRESULT5'] ?>"></td>
                                                                                <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOAIRREMARK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')"><?= $result_seTenkotransport5['TENKOAIRREMARK'] ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="text-align: center">7</td>
                                                                                <td>ตรวจสอบอาการง่วงและย้ำให้ระมัดระวัง</td>
                                                                                <td style="text-align: center"><input type="checkbox" <?= $rs7d5 ?> onchange="edit_check7d5('TENKOSLEEPYCHECK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" style="transform: scale(2)" id="chk_7d5" name="chk_7d5" /></td>
                                                                                <td>สภาพที่สามารถวิ่งงานต่อได้</td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOLOADRESTRESULT6', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOLOADRESTRESULT6" name="TXT_TENKOLOADRESTRESULT6" value="<?= $result_seTenkotransport5['TENKOLOADRESTRESULT6'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOBODYSLEEPYRESULT6', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOBODYSLEEPYRESULT6" name="TXT_TENKOBODYSLEEPYRESULT6" value="<?= $result_seTenkotransport5['TENKOBODYSLEEPYRESULT6'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOCARNEWRESULT6', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOCARNEWRESULT6" name="TXT_TENKOCARNEWRESULT6" value="<?= $result_seTenkotransport5['TENKOCARNEWRESULT6'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOTRAILERRESULT6', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOTRAILERRESULT6" name="TXT_TENKOTRAILERRESULT6" value="<?= $result_seTenkotransport5['TENKOTRAILERRESULT6'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOROADRESULT6', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOROADRESULT6" name="TXT_TENKOROADRESULT6" value="<?= $result_seTenkotransport5['TENKOROADRESULT6'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOAIRRESULT6', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOAIRRESULT6" name="TXT_TENKOAIRRESULT6" value="<?= $result_seTenkotransport5['TENKOAIRRESULT6'] ?>"></td>
                                                                                <td><input type="text" onchange="editvalue_tenkotransport(this.value, 'TENKOSLEEPYRESULT6', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')" class="form-control" id="TXT_TENKOSLEEPYRESULT6" name="TXT_TENKOSLEEPYRESULT6" value="<?= $result_seTenkotransport5['TENKOSLEEPYRESULT6'] ?>"></td>
                                                                                <td contenteditable="true" onkeyup="edit_tenkotransport(this, 'TENKOSLEEPYREMARK', '<?= $result_seTenkotransport5['TENKOTRANSPORTID'] ?>', '<?= $result_seTenkomaster['DATEINPUT_F5'] ?>')"><?= $result_seTenkotransport5['TENKOSLEEPYREMARK'] ?></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>

                                                                </div>
            <?php
        }
        ?>
                                                        </div>
                                                    </div>
                                                </div>

        <?php
        $conditionTenkoafter = " AND TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "' AND TENKOMASTERDIRVERCODE = '" . $_GET['employeecode2'] . "'";
        $sql_seTenkoafter = "{call megEdittenkoafter_v2(?,?,?)}";
        $params_seTenkoafter = array(
            array('select_tenkoafter', SQLSRV_PARAM_IN),
            array($conditionTenkoafter, SQLSRV_PARAM_IN),
            array('', SQLSRV_PARAM_IN)
        );
        $query_seTenkoafter = sqlsrv_query($conn, $sql_seTenkoafter, $params_seTenkoafter);
        $result_seTenkoafter = sqlsrv_fetch_array($query_seTenkoafter, SQLSRV_FETCH_ASSOC);

        $chk31 = ($result_seTenkoafter['TENKOBEFOREGREETCHECK'] == '1') ? "checked" : "";
        $chk32 = ($result_seTenkoafter['TENKOUNIFORMCHECK'] == '1') ? "checked" : "";
        $chk33 = ($result_seTenkoafter['TENKOBODYCHECK'] == '1') ? "checked" : "";
        $chk34 = ($result_seTenkoafter['TENKOALCOHOLCHECK'] == '1') ? "checked" : "";
        $chk35 = ($result_seTenkoafter['TENKOCARNEWCHECK'] == '1') ? "checked" : "";
        $chk36 = ($result_seTenkoafter['TENKOTRAILERCHECK'] == '1') ? "checked" : "";
        $chk37 = ($result_seTenkoafter['TENKORISKYCHECK'] == '1') ? "checked" : "";
        $chk38 = ($result_seTenkoafter['TENKOAIRCHECK'] == '1') ? "checked" : "";
        $chk39 = ($result_seTenkoafter['TENKOPATTERNDRIVERCHECK'] == '1') ? "checked" : "";
        $chk310 = ($result_seTenkoafter['TENKODAILYDRIVERCHECK'] == '1') ? "checked" : "";
        $chk311 = ($result_seTenkoafter['TENKOHIYARIHATTOCHECK'] == '1') ? "checked" : "";
        $chk312 = ($result_seTenkoafter['TENKOYOKOTENCHECK'] == '1') ? "checked" : "";
        $chk313 = ($result_seTenkoafter['TENKOAFTERGREETCHECK'] == '1') ? "checked" : "";

        $rs311 = ($result_seTenkoafter['TENKOBEFOREGREETRESULT'] == '1') ? "checked" : "";
        $rs321 = ($result_seTenkoafter['TENKOUNIFORMRESULT'] == '1') ? "checked" : "";
        $rs331 = ($result_seTenkoafter['TENKOBODYRESULT'] == '1') ? "checked" : "";
        $rs341 = ($result_seTenkoafter['TENKOALCOHOLRESULT'] == '1') ? "checked" : "";
        $rs351 = ($result_seTenkoafter['TENKOCARNEWRESULT'] == '1') ? "checked" : "";
        $rs361 = ($result_seTenkoafter['TENKOTRAILERRESULT'] == '1') ? "checked" : "";
        $rs371 = ($result_seTenkoafter['TENKORISKYRESULT'] == '1') ? "checked" : "";
        $rs381 = ($result_seTenkoafter['TENKOAIRRESULT'] == '1') ? "checked" : "";
        $rs391 = ($result_seTenkoafter['TENKOPATTERNDRIVERRESULT'] == '1') ? "checked" : "";
        $rs3101 = ($result_seTenkoafter['TENKODAILYDRIVERRESULT'] == '1') ? "checked" : "";
        $rs3111 = ($result_seTenkoafter['TENKOHIYARIHATTORESULT'] == '1') ? "checked" : "";
        $rs3121 = ($result_seTenkoafter['TENKOYOKOTENRESULT'] == '1') ? "checked" : "";
        $rs3131 = ($result_seTenkoafter['TENKOAFTERGREETRESULT'] == '1') ? "checked" : "";

        $rs310 = ($result_seTenkoafter['TENKOBEFOREGREETRESULT'] == '0') ? "checked" : "";
        $rs320 = ($result_seTenkoafter['TENKOUNIFORMRESULT'] == '0') ? "checked" : "";
        $rs330 = ($result_seTenkoafter['TENKOBODYRESULT'] == '0') ? "checked" : "";
        $rs340 = ($result_seTenkoafter['TENKOALCOHOLRESULT'] == '0') ? "checked" : "";
        $rs350 = ($result_seTenkoafter['TENKOCARNEWRESULT'] == '0') ? "checked" : "";
        $rs360 = ($result_seTenkoafter['TENKOTRAILERRESULT'] == '0') ? "checked" : "";
        $rs370 = ($result_seTenkoafter['TENKORISKYRESULT'] == '0') ? "checked" : "";
        $rs380 = ($result_seTenkoafter['TENKOAIRRESULT'] == '0') ? "checked" : "";
        $rs390 = ($result_seTenkoafter['TENKOPATTERNDRIVERRESULT'] == '0') ? "checked" : "";
        $rs3100 = ($result_seTenkoafter['TENKODAILYDRIVERRESULT'] == '0') ? "checked" : "";
        $rs3110 = ($result_seTenkoafter['TENKOHIYARIHATTORESULT'] == '0') ? "checked" : "";
        $rs3120 = ($result_seTenkoafter['TENKOYOKOTENRESULT'] == '0') ? "checked" : "";
        $rs3130 = ($result_seTenkoafter['TENKOAFTERGREETRESULT'] == '0') ? "checked" : "";
        ?>
                                                <div class="tab-pane fade" id="tenko3">
                                                    <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
                                                        <thead>
                                                            <tr>

                                                                <th colspan="6" ><font style="color: green">พนักงานขับรถ : นาย <?= $result_seTenkomaster['TENKOMASTERDIRVERNAME2'] ?></font></th>
                                                                <th colspan="2" style="text-align: center;">เจ้าหน้าที่เท็งโกะก่อนเริ่มงาน</th>
                                                                <th style="text-align: center;"><?= $result_seTenkotransport1["CREATEBY"] ?></th>
                                                                <th colspan="2" style="text-align: center;">เจ้าหน้าที่เท็งโกะปฎิบัติงาน</th>
                                                                <th style="text-align: center;"><?= $result_seEmployee["nameT"] ?></th>
                                                            </tr>
                                                            <tr>
                                                                <th rowspan="2" style="text-align: center;">ข้อ</th>
                                                                <th rowspan="2" style="text-align: center;">หัวข้อ</th>
                                                                <th rowspan="2" style="text-align: center;">ช่องตรวจสอบ</th>
                                                                <th rowspan="2" style="text-align: center;">เกณฑ์การตัดสิน</th>
                                                                <th colspan="2" style="text-align: center;">ผล</th>
                                                                <th colspan="4" rowspan="2" style="text-align: center;">รายละเอียดและการแนะนำ</th>
                                                            </tr>
                                                            <tr>
                                                                <th style="text-align: center;">ปกติ</th>
                                                                <th style="text-align: center;">ไม่ปกติ</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td style="text-align: center">1</td>
                                                                <td>การทักทายก่อนเริ่มเท็งโกะ</td>
                                                                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk31 ?> onchange="edit_check31('TENKOBEFOREGREETCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')" id="chk_31" name="chk_31"/></td>
                                                                <td>ทักทายอย่างมีชีวิตชีวา</td>
                                                                <td style="text-align:center"><input type="checkbox" <?= $rs311 ?> style="transform: scale(2)" id="chk_rs311" name="chk_rs311" onchange="edit_rs311('TENKOBEFOREGREETRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                                                                <td style="text-align:center"><input type="checkbox" <?= $rs310 ?> style="transform: scale(2)" id="chk_rs310" name="chk_rs310" onchange="edit_rs310('TENKOBEFOREGREETRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                                                                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKOBEFOREGREETREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKOBEFOREGREETREMARK'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center">2</td>
                                                                <td>ตรวจเช็คยูนิฟอร์ม</td>
                                                                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk32 ?> onchange="edit_check32('TENKOUNIFORMCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')" id="chk_32" name="chk_32"/></td>
                                                                <td>ไม่มีคราบสกปรก</td>
                                                                <td style="text-align:center"><input type="checkbox" <?= $rs321 ?> style="transform: scale(2)" id="chk_rs321" name="chk_rs321" onchange="edit_rs321('TENKOUNIFORMRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                                                                <td style="text-align:center"><input type="checkbox" <?= $rs320 ?> style="transform: scale(2)" id="chk_rs320" name="chk_rs320" onchange="edit_rs320('TENKOUNIFORMRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                                                                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKOUNIFORMREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKOUNIFORMREMARK'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center">3</td>
                                                                <td>ตรวจสภาพร่างกาย</td>
                                                                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk33 ?> onchange="edit_check33('TENKOBODYCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')" id="chk_33" name="chk_33"/></td>
                                                                <td>สภาพร่างกายแข็งแรงดี</td>
                                                                <td style="text-align:center"><input type="checkbox" <?= $rs331 ?> style="transform: scale(2)" id="chk_rs331" name="chk_rs331" onchange="edit_rs331('TENKOBODYRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                                                                <td style="text-align:center"><input type="checkbox" <?= $rs330 ?> style="transform: scale(2)" id="chk_rs330" name="chk_rs330" onchange="edit_rs330('TENKOBODYRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                                                                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKOBODYREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKOBODYREMARK'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center">4</td>
                                                                <td>ตรวจเช็คแอลกอฮอล์</td>
                                                                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk34 ?> onchange="edit_check34('TENKOALCOHOLCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')" id="chk_34" name="chk_34"/></td>
                                                                <td>[0]</td>
                                                                <td style="text-align:center"><input type="checkbox" <?= $rs341 ?> style="transform: scale(2)" id="chk_rs341" name="chk_rs341" onchange="edit_rs341('TENKOALCOHOLRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                                                                <td style="text-align:center"><input type="checkbox"  <?= $rs340 ?> style="transform: scale(2)" id="chk_rs340" name="chk_rs340" onchange="edit_rs340('TENKOALCOHOLRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                                                                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKOALCOHOLREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKOALCOHOLREMARK'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center">5</td>
                                                                <td>มีความผิดปกติกับรถใหม่หรือไม่</td>
                                                                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk35 ?> onchange="edit_check35('TENKOCARNEWCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')" id="chk_35" name="chk_35"/></td>
                                                                <td>รายงานสิ่งผิดปกติของรถใหม่ว่ามีหรือไม่</td>
                                                                <td style="text-align:center"><input type="checkbox" <?= $rs351 ?> style="transform: scale(2)" id="chk_rs351" name="chk_rs351" onchange="edit_rs351('TENKOCARNEWRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                                                                <td style="text-align:center"><input type="checkbox" <?= $rs350 ?> style="transform: scale(2)" id="chk_rs350" name="chk_rs350" onchange="edit_rs350('TENKOCARNEWRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                                                                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKOCARNEWREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKOCARNEWREMARK'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center">6</td>
                                                                <td>ความผิดปกติของรถเทรลเลอร์</td>
                                                                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk36 ?> onchange="edit_check36('TENKOTRAILERCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')" id="chk_36" name="chk_36"/></td>
                                                                <td>รายงานสิ่งผิดปรติของเทรลเลอร์ว่ามีหรือไม่</td>
                                                                <td style="text-align:center"><input type="checkbox" <?= $rs361 ?> style="transform: scale(2)" id="chk_rs361" name="chk_rs361" onchange="edit_rs361('TENKOTRAILERRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                                                                <td style="text-align:center"><input type="checkbox" <?= $rs360 ?> style="transform: scale(2)" id="chk_rs360" name="chk_rs360" onchange="edit_rs360('TENKOTRAILERRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                                                                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKOTRAILERREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKOTRAILERREMARK'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center">7</td>
                                                                <td>จุดเสี่ยงระหว่างเส้นทางการขนส่ง(ล่าง)</td>
                                                                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk37 ?> onchange="edit_check37('TENKORISKYCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')" id="chk_37" name="chk_37"/></td>
                                                                <td>รายงานว่ามีจุดเปลี่ยนแปลงที่ผิดปกติหรือไม่</td>
                                                                <td style="text-align:center"><input type="checkbox" <?= $rs371 ?> style="transform: scale(2)" id="chk_rs371" name="chk_rs371" onchange="edit_rs371('TENKORISKYRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                                                                <td style="text-align:center"><input type="checkbox" <?= $rs370 ?> style="transform: scale(2)" id="chk_rs370" name="chk_rs370" onchange="edit_rs370('TENKORISKYRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                                                                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKORISKYREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKORISKYREMARK'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center">8</td>
                                                                <td>ตรวจสอบสภาพอากาศ</td>
                                                                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk38 ?> onchange="edit_check38('TENKOAIRCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')" id="chk_38" name="chk_38"/></td>
                                                                <td>รายงานสภาพอากาศ6</td>
                                                                <td style="text-align:center"><input type="checkbox" <?= $rs381 ?> style="transform: scale(2)" id="chk_rs381" name="chk_rs381" onchange="edit_rs381('TENKOAIRRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                                                                <td style="text-align:center"><input type="checkbox" <?= $rs380 ?> style="transform: scale(2)" id="chk_rs380" name="chk_rs380" onchange="edit_rs380('TENKOAIRRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                                                                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKOAIRREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKOAIRREMARK'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center">9</td>
                                                                <td>ตรวจสอบรูปแบบการขับขี่</td>
                                                                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk39 ?> onchange="edit_check39('TENKOPATTERNDRIVERCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')" id="chk_39" name="chk_39"/></td>
                                                                <td>รายงานรูปแบบการขับขี่</td>
                                                                <td style="text-align:center"><input type="checkbox" <?= $rs391 ?> style="transform: scale(2)" id="chk_rs391" name="chk_rs391" onchange="edit_rs391('TENKOPATTERNDRIVERRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                                                                <td style="text-align:center"><input type="checkbox" <?= $rs390 ?> style="transform: scale(2)" id="chk_rs390" name="chk_rs390" onchange="edit_rs390('TENKOPATTERNDRIVERRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                                                                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKOPATTERNDRIVERREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKOPATTERNDRIVERREMARK'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center">10</td>
                                                                <td>ตรวจสอบข้อมูลการขับขี่ประจำวันจาก GPS เรคคอร์ด(ล่าง)</td>
                                                                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk310 ?> onchange="edit_check310('TENKODAILYDRIVERCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"  id="chk_310" name="chk_310"/></td>
                                                                <td>หัวข้อฝ่าฝืนเป็น [0]</td>
                                                                <td style="text-align:center"><input type="checkbox" <?= $rs3101 ?> style="transform: scale(2)" id="chk_rs3101" name="chk_rs3101" onchange="edit_rs3101('TENKODAILYDRIVERRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                                                                <td style="text-align:center"><input type="checkbox" <?= $rs3100 ?> style="transform: scale(2)" id="chk_rs3100" name="chk_rs3100" onchange="edit_rs3100('TENKODAILYDRIVERRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                                                                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKODAILYDRIVERREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKODAILYDRIVERREMARK'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center">11</td>
                                                                <td>ฮิยาริฮัตโตะนอกเหนือจากข้อ 7.</td>
                                                                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk311 ?> onchange="edit_check311('TENKOHIYARIHATTOCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')" id="chk_311" name="chk_311"/></td>
                                                                <td>เหตุการณ์ที่ตกใจและเกือบเกิดอุบัติเหตุ</td>
                                                                <td style="text-align:center"><input type="checkbox" <?= $rs3111 ?> style="transform: scale(2)" id="chk_rs3111" name="chk_rs3111" onchange="edit_rs3111('TENKOHIYARIHATTORESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                                                                <td style="text-align:center"><input type="checkbox" <?= $rs3110 ?> style="transform: scale(2)" id="chk_rs3110" name="chk_rs3110" onchange="edit_rs3110('TENKOHIYARIHATTORESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                                                                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKOHIYARIHATTOREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKOHIYARIHATTOREMARK'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center">12</td>
                                                                <td>แจ้งเรื่องโยโกะเต็น/แนะนำวิธีการจัดสรรชั่วโมงนอนหลับ</td>
                                                                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk312 ?> onchange="edit_check312('TENKOYOKOTENCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')" id="chk_312" name="chk_312"/></td>
                                                                <td>เข้าใจเนื้อหาและวิธีการต่างๆที่แจ้งไป</td>
                                                                <td style="text-align:center"><input type="checkbox" <?= $rs3121 ?> style="transform: scale(2)" id="chk_rs3121" name="chk_rs3121" onchange="edit_rs3121('TENKOYOKOTENRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                                                                <td style="text-align:center"><input type="checkbox" <?= $rs3120 ?> style="transform: scale(2)" id="chk_rs3120" name="chk_rs3120" onchange="edit_rs3120('TENKOYOKOTENRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                                                                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKOYOKOTENREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKOYOKOTENREMARK'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center">13</td>
                                                                <td>การทักทายหลังทำเท็งโกะเสร็จ</td>
                                                                <td style="text-align:center"><input type="checkbox" style="transform: scale(2)" <?= $chk313 ?> onchange="edit_check313('TENKOAFTERGREETCHECK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')" id="chk_313" name="chk_313"/></td>
                                                                <td>ทักทายอย่างมีชีวิตชีวา</td>
                                                                <td style="text-align:center"><input type="checkbox" <?= $rs3131 ?> style="transform: scale(2)" id="chk_rs3131" name="chk_rs3131" onchange="edit_rs3131('TENKOAFTERGREETRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                                                                <td style="text-align:center"><input type="checkbox" <?= $rs3130 ?> style="transform: scale(2)" id="chk_rs3130" name="chk_rs3130" onchange="edit_rs3130('TENKOAFTERGREETRESULT', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"/></td>
                                                                <td colspan="4" contenteditable="true" onkeyup="edit_tenkoafter(this, 'TENKOAFTERGREETREMARK', '<?= $result_seTenkoafter['TENKOAFTERID'] ?>')"><?= $result_seTenkoafter['TENKOAFTERGREETREMARK'] ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
        <?php
        if ($result_sePlain['COMPANYCODE'] == 'RRC' || $result_sePlain['COMPANYCODE'] == 'RCC' || $result_sePlain['COMPANYCODE'] == 'RATC') {
            $conditionTenkorisky = " AND TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "' AND TENKOMASTERDIRVERCODE = '" . $_GET['employeecode2'] . "'";
            $sql_seTenkorisky = "{call megEdittenkorisky_v2(?,?,?)}";
            $params_seTenkorisky = array(
                array('select_tenkorisky', SQLSRV_PARAM_IN),
                array($conditionTenkorisky, SQLSRV_PARAM_IN),
                array('', SQLSRV_PARAM_IN)
            );
            $query_seTenkorisky = sqlsrv_query($conn, $sql_seTenkorisky, $params_seTenkorisky);
            $result_seTenkorisky = sqlsrv_fetch_array($query_seTenkorisky, SQLSRV_FETCH_ASSOC);

            $rs411 = ($result_seTenkorisky['TENKORISKYBPRESULT'] == '1') ? "checked" : "";
            $rs421 = ($result_seTenkorisky['TENKORISKYSRRESULT'] == '1') ? "checked" : "";
            $rs431 = ($result_seTenkorisky['TENKORISKYGWRESULT'] == '1') ? "checked" : "";
            $rs441 = ($result_seTenkorisky['TENKORISKYOTH1RESULT'] == '1') ? "checked" : "";
            $rs451 = ($result_seTenkorisky['TENKORISKYBRANCHRESULT'] == '1') ? "checked" : "";
            $rs461 = ($result_seTenkorisky['TENKOWIRERESULT'] == '1') ? "checked" : "";
            $rs471 = ($result_seTenkorisky['TENKOLOADRESULT'] == '1') ? "checked" : "";
            $rs481 = ($result_seTenkorisky['TENKOTRAILERPARKINGRESULT'] == '1') ? "checked" : "";
            $rs491 = ($result_seTenkorisky['TENKOCARNEWPARKINGRESULT'] == '1') ? "checked" : "";
            $rs4101 = ($result_seTenkorisky['TENKORISKYOTH2RESULT'] == '1') ? "checked" : "";


            $rs410 = ($result_seTenkorisky['TENKORISKYBPRESULT'] == '0') ? "checked" : "";
            $rs420 = ($result_seTenkorisky['TENKORISKYSRRESULT'] == '0') ? "checked" : "";
            $rs430 = ($result_seTenkorisky['TENKORISKYGWRESULT'] == '0') ? "checked" : "";
            $rs440 = ($result_seTenkorisky['TENKORISKYOTH1RESULT'] == '0') ? "checked" : "";
            $rs450 = ($result_seTenkorisky['TENKORISKYBRANCHRESULT'] == '0') ? "checked" : "";
            $rs460 = ($result_seTenkorisky['TENKOWIRERESULT'] == '0') ? "checked" : "";
            $rs470 = ($result_seTenkorisky['TENKOLOADRESULT'] == '0') ? "checked" : "";
            $rs480 = ($result_seTenkorisky['TENKOTRAILERPARKINGRESULT'] == '0') ? "checked" : "";
            $rs490 = ($result_seTenkorisky['TENKOCARNEWPARKINGRESULT'] == '0') ? "checked" : "";
            $rs4100 = ($result_seTenkorisky['TENKORISKYOTH2RESULT'] == '0') ? "checked" : "";
            ?>
                                                    <div class="tab-pane fade" id="tenko4">
                                                        <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
                                                            <thead>
                                                                <tr>

                                                                    <th colspan="6" ><font style="color: green">พนักงานขับรถ : นาย <?= $result_seTenkomaster['TENKOMASTERDIRVERNAME2'] ?></font></th>
                                                                </tr>
                                                                <tr>
                                                                    <th style="text-align: center">ข้อ</th>
                                                                    <th style="text-align: center" colspan="2">หัวข้อ</th>
                                                                    <th colspan="2" style="text-align: center">สิ่งผิดปกติ</th>
                                                                    <th style="text-align: center">รายละเอียดสิ่งผิดปกติ</th>
                                                                </tr>
                                                                <tr>
                                                                    <th style="text-align: center">&nbsp;</th>
                                                                    <th style="text-align: center" colspan="2">&nbsp;</th>
                                                                    <th style="text-align: center">มี</th>
                                                                    <th style="text-align: center">ไม่มี</th>
                                                                    <th style="text-align: center">&nbsp;</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                <tr>
                                                                    <td rowspan="4" style="text-align: center">1</td>
                                                                    <td rowspan="4">ในยาร์ด</td>
                                                                    <td>บ้านโพธิ์</td>
                                                                    <td style="text-align: center"><input type="checkbox" <?= $rs411 ?> onchange="edit_rs411('TENKORISKYBPRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"  style="transform: scale(2)" id="chk_rs411" name="chk_rs411" /></td>
                                                                    <td style="text-align: center"><input type="checkbox" <?= $rs410 ?> onchange="edit_rs410('TENKORISKYBPRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs410" name="chk_rs410" /></td>
                                                                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKORISKYBPREMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKORISKYBPREMARK'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>สำโรง</td>
                                                                    <td style="text-align: center"><input type="checkbox" <?= $rs421 ?> onchange="edit_rs421('TENKORISKYSRRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs421" name="chk_rs421" /></td>
                                                                    <td style="text-align: center"><input type="checkbox" <?= $rs420 ?>  onchange="edit_rs420('TENKORISKYSRRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs420" name="chk_rs420" /></td>
                                                                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKORISKYSRREMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKORISKYSRREMARK'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>เกตุเวย์</td>
                                                                    <td style="text-align: center"><input type="checkbox" <?= $rs431 ?> onchange="edit_rs431('TENKORISKYGWRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs431" name="chk_rs431" /></td>
                                                                    <td style="text-align: center"><input type="checkbox" <?= $rs430 ?> onchange="edit_rs430('TENKORISKYGWRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs430" name="chk_rs430" /></td>
                                                                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKORISKYGWREMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKORISKYGWREMARK'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>อื่นๆ</td>
                                                                    <td style="text-align: center"><input type="checkbox" <?= $rs441 ?> onchange="edit_rs441('TENKORISKYOTH1RESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" style="transform: scale(2)" id="chk_rs441" name="chk_rs441" /></td>
                                                                    <td style="text-align: center"><input type="checkbox" <?= $rs440 ?> onchange="edit_rs440('TENKORISKYOTH1RESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" style="transform: scale(2)" id="chk_rs440" name="chk_rs440" /></td>
                                                                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKORISKYOTH1REMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKORISKYOTH1REMARK'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td rowspan="3" style="text-align: center">2</td>
                                                                    <td rowspan="3">บนถนน</td>
                                                                    <td>กิ่งไม้</td>
                                                                    <td style="text-align: center"><input type="checkbox" <?= $rs451 ?> onchange="edit_rs451('TENKORISKYBRANCHRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs451" name="chk_rs451" /></td>
                                                                    <td style="text-align: center"><input type="checkbox" <?= $rs450 ?> onchange="edit_rs450('TENKORISKYBRANCHRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs450" name="chk_rs450" /></td>
                                                                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKORISKYBRANCHREMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKORISKYBRANCHREMARK'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>สายไฟ</td>
                                                                    <td style="text-align: center"><input type="checkbox" <?= $rs461 ?> onchange="edit_rs461('TENKOWIRERESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs461" name="chk_rs461" /></td>
                                                                    <td style="text-align: center"><input type="checkbox" <?= $rs460 ?> onchange="edit_rs460('TENKOWIRERESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs460" name="chk_rs460" /></td>
                                                                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKOWIREREMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKOWIREREMARK'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>สภาพถนน,ก่อสร้าง</td>
                                                                    <td style="text-align: center"><input type="checkbox" <?= $rs471 ?> onchange="edit_rs471('TENKOLOADRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs471" name="chk_rs471" /></td>
                                                                    <td style="text-align: center"><input type="checkbox" <?= $rs470 ?> onchange="edit_rs470('TENKOLOADRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs470" name="chk_rs470" /></td>
                                                                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKOLOADREMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKOLOADREMARK'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td rowspan="3" style="text-align: center">3</td>
                                                                    <td rowspan="3">ตัวแทนจำหน่ย</td>
                                                                    <td>จุดจอดเทรลเลอร์</td>
                                                                    <td style="text-align: center"><input type="checkbox" <?= $rs481 ?> onchange="edit_rs481('TENKOTRAILERPARKINGRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs481" name="chk_rs481" /></td>
                                                                    <td style="text-align: center"><input type="checkbox" <?= $rs480 ?> onchange="edit_rs480('TENKOTRAILERPARKINGRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs480" name="chk_rs480" /></td>
                                                                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKOTRAILERPARKINGREMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKOTRAILERPARKINGREMARK'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>พื้นที่รับรถใหม่</td>
                                                                    <td style="text-align: center"><input type="checkbox" <?= $rs491 ?> onchange="edit_rs491('TENKOCARNEWPARKINGRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs491" name="chk_rs491" /></td>
                                                                    <td style="text-align: center"><input type="checkbox" <?= $rs490 ?> onchange="edit_rs490('TENKOCARNEWPARKINGRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs490" name="chk_rs490" /></td>
                                                                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKOCARNEWPARKINGREMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKOCARNEWPARKINGREMARK'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>อื่นๆ</td>
                                                                    <td style="text-align: center"><input type="checkbox" <?= $rs4101 ?> onchange="edit_rs4101('TENKORISKYOTH2RESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs4101" name="chk_rs4101" /></td>
                                                                    <td style="text-align: center"><input type="checkbox" <?= $rs4100 ?> onchange="edit_rs4100('TENKORISKYOTH2RESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs4100" name="chk_rs4100" /></td>
                                                                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKORISKYOTH2REMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKORISKYOTH2REMARK'] ?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
            <?php
        } else if ($result_sePlain['COMPANYCODE'] == 'RKR' || $result_sePlain['COMPANYCODE'] == 'RKS' || $result_sePlain['COMPANYCODE'] == 'RKL') {
            $conditionTenkorisky = " AND TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "' AND TENKOMASTERDIRVERCODE = '" . $_GET['employeecode2'] . "'";
            $sql_seTenkorisky = "{call megEdittenkorisky_v2(?,?,?)}";
            $params_seTenkorisky = array(
                array('select_tenkorisky', SQLSRV_PARAM_IN),
                array($conditionTenkorisky, SQLSRV_PARAM_IN),
                array('', SQLSRV_PARAM_IN)
            );
            $query_seTenkorisky = sqlsrv_query($conn, $sql_seTenkorisky, $params_seTenkorisky);
            $result_seTenkorisky = sqlsrv_fetch_array($query_seTenkorisky, SQLSRV_FETCH_ASSOC);

            $rs451 = ($result_seTenkorisky['TENKORISKYBRANCHRESULT'] == '1') ? "checked" : "";
            $rs461 = ($result_seTenkorisky['TENKOWIRERESULT'] == '1') ? "checked" : "";
            $rs471 = ($result_seTenkorisky['TENKOLOADRESULT'] == '1') ? "checked" : "";
            $rs451_h = ($result_seTenkorisky['TENKORISKYBRANCHRESULT_H'] == '1') ? "checked" : "";
            $rs461_h = ($result_seTenkorisky['TENKOWIRERESULT_H'] == '1') ? "checked" : "";
            $rs471_h = ($result_seTenkorisky['TENKOLOADRESULT_H'] == '1') ? "checked" : "";



            $rs450 = ($result_seTenkorisky['TENKORISKYBRANCHRESULT'] == '0') ? "checked" : "";
            $rs460 = ($result_seTenkorisky['TENKOWIRERESULT'] == '0') ? "checked" : "";
            $rs470 = ($result_seTenkorisky['TENKOLOADRESULT'] == '0') ? "checked" : "";
            $rs450_h = ($result_seTenkorisky['TENKORISKYBRANCHRESULT_H'] == '0') ? "checked" : "";
            $rs460_h = ($result_seTenkorisky['TENKOWIRERESULT_H'] == '0') ? "checked" : "";
            $rs470_h = ($result_seTenkorisky['TENKOLOADRESULT_H'] == '0') ? "checked" : "";
            ?>
                                                    <div class="tab-pane fade" id="tenko4">
                                                        <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
                                                            <thead>
                                                                <tr>

                                                                    <th colspan="7" ><font style="color: green">พนักงานขับรถ : นาย <?= $result_seTenkomaster['TENKOMASTERDIRVERNAME2'] ?></font></th>
                                                                </tr>
                                                                <tr>
                                                                    <th style="text-align: center">ข้อ</th>
                                                                    <th style="text-align: center" >หัวข้อ</th>
                                                                    <th colspan="2" style="text-align: center">สิ่งผิดปกติ</th>
                                                                    <th colspan="2" style="text-align: center">ฮิยาริฮัตโตะ</th>
                                                                    <th style="text-align: center">รายละเอียดสิ่งผิดปกติ</th>
                                                                </tr>
                                                                <tr>
                                                                    <th style="text-align: center">&nbsp;</th>
                                                                    <th style="text-align: center">&nbsp;</th>
                                                                    <th style="text-align: center">มี</th>
                                                                    <th style="text-align: center">ไม่มี</th>
                                                                    <th style="text-align: center">มี</th>
                                                                    <th style="text-align: center">ไม่มี</th>
                                                                    <th style="text-align: center">&nbsp;</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>


                                                                <tr>
                                                                    <td style="text-align: center">1</td>

                                                                    <td>กิ่งไม้</td>
                                                                    <td style="text-align: center"><input type="checkbox" <?= $rs451 ?> onchange="edit_rs451('TENKORISKYBRANCHRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs451" name="chk_rs451" /></td>
                                                                    <td style="text-align: center"><input type="checkbox" <?= $rs450 ?> onchange="edit_rs450('TENKORISKYBRANCHRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs450" name="chk_rs450" /></td>
                                                                    <td style="text-align: center"><input type="checkbox" <?= $rs451_h ?> onchange="edit_rs451_h('TENKORISKYBRANCHRESULT_H', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"  style="transform: scale(2)" id="chk_rs451_h" name="chk_rs451_h" /></td>
                                                                    <td style="text-align: center"><input type="checkbox" <?= $rs450_h ?> onchange="edit_rs450_h('TENKORISKYBRANCHRESULT_H', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs450_h" name="chk_rs450_h" /></td>
                                                                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKORISKYBRANCHREMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKORISKYBRANCHREMARK'] ?></td>

                                                                </tr>
                                                                <tr>
                                                                    <td style="text-align: center">2</td>
                                                                    <td>สายไฟ</td>
                                                                    <td style="text-align: center"><input type="checkbox" <?= $rs461 ?> onchange="edit_rs461('TENKOWIRERESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs461" name="chk_rs461" /></td>
                                                                    <td style="text-align: center"><input type="checkbox" <?= $rs460 ?> onchange="edit_rs460('TENKOWIRERESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs460" name="chk_rs460" /></td>
                                                                    <td style="text-align: center"><input type="checkbox" <?= $rs461_h ?> onchange="edit_rs461_h('TENKOWIRERESULT_H', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"  style="transform: scale(2)" id="chk_rs461_h" name="chk_rs461_h" /></td>
                                                                    <td style="text-align: center"><input type="checkbox" <?= $rs460_h ?> onchange="edit_rs460_h('TENKOWIRERESULT_H', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs460_h" name="chk_rs460_h" /></td>
                                                                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKOWIREREMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKOWIREREMARK'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="text-align: center">3</td>
                                                                    <td>สภาพถนน,ก่อสร้าง</td>
                                                                    <td style="text-align: center"><input type="checkbox" <?= $rs471 ?> onchange="edit_rs471('TENKOLOADRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs471" name="chk_rs471" /></td>
                                                                    <td style="text-align: center"><input type="checkbox" <?= $rs470 ?> onchange="edit_rs470('TENKOLOADRESULT', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs470" name="chk_rs470" /></td>
                                                                    <td style="text-align: center"><input type="checkbox" <?= $rs471_h ?> onchange="edit_rs471_h('TENKOLOADRESULT_H', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"  style="transform: scale(2)" id="chk_rs471_h" name="chk_rs471_h" /></td>
                                                                    <td style="text-align: center"><input type="checkbox" <?= $rs470_h ?> onchange="edit_rs470_h('TENKOLOADRESULT_H', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')" style="transform: scale(2)" id="chk_rs470_h" name="chk_rs470_h" /></td>
                                                                    <td contenteditable="true" onkeyup="edit_tenkorisky(this, 'TENKOLOADREMARK', '<?= $result_seTenkorisky['TENKORISKYID'] ?>')"><?= $result_seTenkorisky['TENKOLOADREMARK'] ?></td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </div>
            <?php
        }
        ?>
                                                <div class="tab-pane fade" id="tenko5">
                                                    <!--
                                                    <form method=post action="meg_uploadimage.php" enctype="multipart/form-data">
                                                        <div class="row" >
                                                            <div class="col-lg-2">
                                                                รูปภาพที่ 1.<input type="file" class="form-control" name="pix1" id="pix1">

                                                            </div>
                                                            <div class="col-lg-2">
                                                                รูปภาพที่ 2.<input type="file" class="form-control" name="pix2" id="pix2">

                                                            </div>
                                                            <div class="col-lg-2">
                                                                รูปภาพที่ 3.<input type="file" class="form-control" name="pix3" id="pix3">
                                                                <input type="text" style="display: none" class="form-control" name="employeecode2" id="employeecode2" value="<?= $_GET['employeecode2'] ?>">
                                                                <input type="text" style="display: none" class="form-control" name="vehicletransportplanid" id="vehicletransportplanid" value="<?= $_GET['vehicletransportplanid'] ?>">
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <br>
                                                                <input type="submit" name="btnSend" id="btnSend" value="อัพโหลดรูปภาพ" class="btn btn-primary">
                                                            </div>
                                                            <div class="col-lg-4"></div>
                                                        </div>

                                                    -->



                                                    <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
                                                        <thead>

                                                            <tr>

                                                                <th colspan="6" ><font style="color: green">พนักงานขับรถ : นาย <?= $result_seTenkomaster['TENKOMASTERDIRVERNAME2'] ?></font></th>

                                                            </tr>

                                                        </thead>
                                                        <tbody>

                                                            <tr>
                                                                <td style="text-align: center">
                                                                    &nbsp;
                                                                </td>
                                                                <td style="text-align: center" >
                                                                    <img src="../images/noimage.jpg" width="200"/>
                                                                </td>
                                                                <td style="text-align: center">
                                                                    <img src="../images/noimage.jpg" width="200"/>
                                                                </td>
                                                                <td style="text-align: center">
                                                                    <img src="../images/noimage.jpg" width="200"/>
                                                                </td>
                                                                <td style="text-align: center">
                                                                    <img src="../images/noimage.jpg" width="200"/>
                                                                </td>
                                                                <td style="text-align: center">
                                                                    <img src="../images/noimage.jpg" width="200"/>
                                                                </td>
                                                                <!--<td width="20%" style="text-align:center">
                                                                    <img src="../upload_imagemap/<?//= $_GET['vehicletransportplanid'] . $_GET['employeecode2'] ?>1.jpg" width="200"/>

                                                                </td>
                                                                <td width="20%" style="text-align:center">
                                                                    <img src="../upload_imagemap/<?//= $_GET['vehicletransportplanid'] . $_GET['employeecode2'] ?>2.jpg" width="200"/>

                                                                </td>
                                                                <td width="20%" style="text-align:center">
                                                                    <img src="../upload_imagemap/<?//= $_GET['vehicletransportplanid'] . $_GET['employeecode2'] ?>3.jpg" width="200"/>

                                                                </td>
                                                                <td width="20%" style="text-align:center">
                                                                    <img src="../upload_imagemap/<?//= $_GET['vehicletransportplanid'] . $_GET['employeecode2'] ?>4.jpg" width="200"/>

                                                                </td>
                                                                <td width="20%" style="text-align:center">
                                                                    <img src="../upload_imagemap/<?//= $_GET['vehicletransportplanid'] . $_GET['employeecode2'] ?>5.jpg" width="200"/>

                                                                </td>
                                                                -->
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <!--</form>-->
                                                </div>
        <?php
        $conditionTenkogps = " AND TENKOMASTERID = '" . $result_seTenkomaster_temp['TENKOMASTERID'] . "' AND TENKOMASTERDIRVERCODE = '" . $_GET['employeecode2'] . "'";
        $sql_seTenkogps = "{call megEdittenkogps_v2(?,?,?)}";
        $params_seTenkogps = array(
            array('select_tenkogps', SQLSRV_PARAM_IN),
            array($conditionTenkogps, SQLSRV_PARAM_IN),
            array('', SQLSRV_PARAM_IN)
        );
        $query_seTenkogps = sqlsrv_query($conn, $sql_seTenkogps, $params_seTenkogps);
        $result_seTenkogps = sqlsrv_fetch_array($query_seTenkogps, SQLSRV_FETCH_ASSOC);
        ?>
                                                <div class="tab-pane fade" id="tenko6">
                                                    <table  width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
                                                        <thead>

                                                            <tr>

                                                                <th colspan="5" ><font style="color: green">พนักงานขับรถ : นาย <?= $result_seTenkomaster['TENKOMASTERDIRVERNAME2'] ?></font></th>
                                                            </tr>
                                                            <tr>
                                                                <th style="text-align: center;">ข้อ</th>
                                                                <th style="text-align: center;">หัวข้อ</th>
                                                                <th style="text-align: center;">จำนวน</th>
                                                                <th style="text-align: center;">รายละเอียดการชี้แนะ</th>
                                                                <th style="text-align: center;">ลายเซ็น พขร.</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td style="text-align: center;">1</td>
                                                                <td>ความเร็วเกินกำหนด</td>
                                                                <td contenteditable="true" onkeyup="edit_tenkogps(this, 'TENKOGPSSPEEDOVERAMOUNT', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"><?= $result_seTenkogps['TENKOGPSSPEEDOVERAMOUNT'] ?></td>
                                                                <td contenteditable="true" onkeyup="edit_tenkogps(this, 'TENKOGPSSPEEDOVERREMARK', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"><?= $result_seTenkogps['TENKOGPSSPEEDOVERREMARK'] ?></td>
                                                                <td contenteditable="true" onkeyup="edit_tenkogps(this, 'TENKOGPSSPEEDOVERDIRVER', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"><?= $result_seTenkogps['TENKOGPSSPEEDOVERDIRVER'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center;">2</td>
                                                                <td>เบรคกระทันหัน</td>
                                                                <td contenteditable="true" onkeyup="edit_tenkogps(this, 'TENKOGPSBRAKEAMOUNT', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"><?= $result_seTenkogps['TENKOGPSBRAKEAMOUNT'] ?></td>
                                                                <td contenteditable="true" onkeyup="edit_tenkogps(this, 'TENKOGPSBRAKEREMARK', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"><?= $result_seTenkogps['TENKOGPSBRAKEREMARK'] ?></td>
                                                                <td contenteditable="true" onkeyup="edit_tenkogps(this, 'TENKOGPSBRAKEDIRVER', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"><?= $result_seTenkogps['TENKOGPSBRAKEDIRVER'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center;">3</td>
                                                                <td>รอบเครื่องเกินกำหนด</td>
                                                                <td contenteditable="true" onkeyup="edit_tenkogps(this, 'TENKOGPSSPEEDMACHINEAMOUNT', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"><?= $result_seTenkogps['TENKOGPSSPEEDMACHINEAMOUNT'] ?></td>
                                                                <td contenteditable="true" onkeyup="edit_tenkogps(this, 'TENKOGPSSPEEDMACHINEREMARK', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"><?= $result_seTenkogps['TENKOGPSSPEEDMACHINEREMARK'] ?></td>
                                                                <td contenteditable="true" onkeyup="edit_tenkogps(this, 'TENKOGPSSPEEDMACHINEDIRVER', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"><?= $result_seTenkogps['TENKOGPSSPEEDMACHINEDIRVER'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center;">4</td>
                                                                <td>วิ่งนอกเส้นทาง</td>
                                                                <td contenteditable="true" onkeyup="edit_tenkogps(this, 'TENKOGPSOUTLINEAMOUNT', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"><?= $result_seTenkogps['TENKOGPSOUTLINEAMOUNT'] ?></td>
                                                                <td contenteditable="true" onkeyup="edit_tenkogps(this, 'TENKOGPSOUTLINEREMARK', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"><?= $result_seTenkogps['TENKOGPSOUTLINEREMARK'] ?></td>
                                                                <td contenteditable="true" onkeyup="edit_tenkogps(this, 'TENKOGPSOUTLINEDIRVER', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"><?= $result_seTenkogps['TENKOGPSOUTLINEDIRVER'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: center;">5</td>
                                                                <td>ขับรถต่อเนื่อง 4 ชม.</td>
                                                                <td contenteditable="true" onkeyup="edit_tenkogps(this, 'TENKOGPSCONTINUOUSAMOUNT', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"><?= $result_seTenkogps['TENKOGPSCONTINUOUSAMOUNT'] ?></td>
                                                                <td contenteditable="true" onkeyup="edit_tenkogps(this, 'TENKOGPSCONTINUOUSREMARK', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"><?= $result_seTenkogps['TENKOGPSCONTINUOUSREMARK'] ?></td>
                                                                <td contenteditable="true" onkeyup="edit_tenkogps(this, 'TENKOGPSCONTINUOUSDIRVER', '<?= $result_seTenkogps['TENKOGPSID'] ?>')"><?= $result_seTenkogps['TENKOGPSCONTINUOUSDIRVER'] ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>


        <?php
    }
    ?>
                                        </div>
                                    </div>
                                    <!-- /.panel-body -->
                                </div>
                                <!-- /.panel -->
                            </div>

                        </div>
    <?php
}
?>


                </div>

            </div>
<?php
if ($_GET['companycode'] == 'RCC') {
    $job = select_jobautocomplatestartgetway('megVehicletransportprice_v2', 'select_from', " AND COMPANYCODE = '" . $_GET['companycode'] . "'");
} else if ($_GET['companycode'] == 'RATC') {
    $job = select_jobautocomplatestartgetway('megVehicletransportprice_v2', 'select_from', " AND COMPANYCODE = '" . $_GET['companycode'] . "'");
} else {
    $job = select_jobautocomplatestartgetway('megVehicletransportprice_v2', 'select_from', " AND COMPANYCODE = '" . $_GET['companycode'] . "'");
}
if ($_GET['companycode'] == 'RRC' || $_GET['companycode'] == 'RCC' || $_GET['companycode'] == 'RATC') {
    $thainame = select_carautocomplate('megVehicleinfo_v2', 'selectcond_vehicleinfo', " AND a.THAINAME != '-' AND (a.ENGNAME  LIKE '%R-%' OR a.ENGNAME  LIKE '%RA-%'", " OR a.THAINAME LIKE '%ดินแดง%'  OR a.THAINAME  LIKE '%อุทัยธานี%'  OR a.THAINAME  LIKE '%คลองเขื่อน%'  ", " OR a.THAINAME LIKE '%RP-%' OR a.THAINAME  LIKE '%สวนผึ้ง%' OR a.THAINAME  LIKE '%ด่านช้าง%'", " OR a.ENGNAME LIKE '%Khao Chamao%' OR a.ENGNAME LIKE '%Kerry%' OR a.ENGNAME LIKE '%Chaloem Prakiat%')");
} else {
    $thainame = select_vehiclenumberautocomplate('megVehicleinfo_v2', 'select_vehicleinfo', '');
}
$jobrccend = select_jobautocomplateendgetway('megVehicletransportprice_v2', 'select_to', '');


$emp = select_empautocomplate('megEmployeeEHR_v2', 'select_employee', " ");
$cluster = select_clusterautocomplate('megVehicletransportprice_v2', 'select_cluster', '');
?>


 <!--<script src="../vendor/jquery/jquery.min.js"></script>-->
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







        </div>
    </body>

    <script>


                                                            $(function () {
                                                                $("#overlay").fadeOut();
                                                                $(".main-contain").removeClass("main-contain");


                                                            });


                                                            function save_tenkorestremark()
                                                            {
                                                                var employeecode = '';

                                                                employeecode = '<?= $result_seTenkobefore2['TENKOBEFOREID'] ?>';

                                                                $.ajax({
                                                                    type: 'post',
                                                                    url: 'meg_data.php',
                                                                    data: {
                                                                        txt_flg: "select_resttime2", startrest: document.getElementById('txt_startrest').value, endrest: document.getElementById('txt_endrest').value
                                                                    },
                                                                    success: function (rs) {



                                                                        document.getElementById('txt_rs14').value = rs;
                                                                        if (document.getElementById("txt_rs14").value != "")
                                                                        {

                                                                            if (document.getElementById("txt_rs14").value.substring(0, 2) < 8)
                                                                            {
                                                                                document.getElementById("chk_rs140").checked = true;
                                                                                document.getElementById("chk_rs141").checked = false;
                                                                            } else
                                                                            {
                                                                                document.getElementById("chk_rs141").checked = true;
                                                                                document.getElementById("chk_rs140").checked = false;
                                                                            }


                                                                            document.getElementById("chk_14").checked = true;
                                                                        } else
                                                                        {
                                                                            document.getElementById("chk_14").checked = false;
                                                                            document.getElementById("chk_rs140").checked = true;
                                                                            document.getElementById("chk_rs141").checked = false;
                                                                        }




                                                                        $.ajax({
                                                                            url: 'meg_data.php',
                                                                            type: 'POST',
                                                                            data: {
                                                                                txt_flg: "edit_tenkobefore", editableObj: document.getElementById('txt_startrest').value + ' : ' + document.getElementById('txt_endrest').value, ID: employeecode, fieldname: 'TENKORESTREMARK'
                                                                            },
                                                                            success: function () {

                                                                                document.getElementById('txt_remark14').value = document.getElementById('txt_startrest').value + ' : ' + document.getElementById('txt_endrest').value;
                                                                                document.getElementById('btn_remark14').value = document.getElementById('txt_startrest').value + ' : ' + document.getElementById('txt_endrest').value;
                                                                            }
                                                                        });
                                                                    }
                                                                });
                                                            }
                                                            function save_tenkosleeptimeremark()
                                                            {
                                                                var employeecode = '';

                                                                employeecode = '<?= $result_seTenkobefore2['TENKOBEFOREID'] ?>';

                                                                $.ajax({
                                                                    type: 'post',
                                                                    url: 'meg_data.php',
                                                                    data: {
                                                                        txt_flg: "select_resttime", startsleep: document.getElementById('txt_startsleep').value, endsleep: document.getElementById('txt_endsleep').value
                                                                    },
                                                                    success: function (rs) {



                                                                        document.getElementById('txt_rs151').value = rs;
                                                                        if (document.getElementById("txt_rs151").value != "")
                                                                        {

                                                                            if (document.getElementById("txt_rs151").value.substring(0, 2) < 6)
                                                                            {
                                                                                document.getElementById("chk_rs150").checked = true;
                                                                                document.getElementById("chk_rs151").checked = false;
                                                                            } else
                                                                            {
                                                                                document.getElementById("chk_rs151").checked = true;
                                                                                document.getElementById("chk_rs150").checked = false;
                                                                            }


                                                                            document.getElementById("chk_15").checked = true;
                                                                        } else
                                                                        {
                                                                            document.getElementById("chk_15").checked = false;
                                                                            document.getElementById("chk_rs150").checked = true;
                                                                            document.getElementById("chk_rs151").checked = false;
                                                                        }




                                                                        $.ajax({
                                                                            url: 'meg_data.php',
                                                                            type: 'POST',
                                                                            data: {
                                                                                txt_flg: "edit_tenkobefore", editableObj: document.getElementById('txt_startsleep').value + ' : ' + document.getElementById('txt_endsleep').value, ID: employeecode, fieldname: 'TENKOSLEEPTIMEREMARK'
                                                                            },
                                                                            success: function () {

                                                                                document.getElementById('txt_remark15').value = document.getElementById('txt_startsleep').value + ' : ' + document.getElementById('txt_endsleep').value;
                                                                                document.getElementById('btn_remark15').value = document.getElementById('txt_startsleep').value + ' : ' + document.getElementById('txt_endsleep').value;
                                                                            }
                                                                        });
                                                                    }
                                                                });
                                                            }
                                                            function commit()
                                                            {


                                                                rs_checkdirverbefore2();
                                                                rs_resultdirverbefore2();
                                                                rs_checkdirvertransport2();
                                                                rs_checkdirveraffter2();




                                                            }
                                                            function select_cluster()
                                                            {
                                                                $('.selectpicker').on('changed.bs.select', function () {
                                                                    document.getElementById('txt_copydiagramcluster').value = $(this).val();
                                                                    select_jobend();
                                                                });
                                                            }
                                                            function select_clusterskb()
                                                            {
                                                                $('.selectpicker').on('changed.bs.select', function () {
                                                                    document.getElementById('txt_copydiagramclusterskb').value = $(this).val();
                                                                    select_jobendskb();
                                                                });
                                                            }
                                                            function select_jobend()
                                                            {

                                                                var copydiagramthainame = document.getElementById("txt_copydiagramthainame").value;
                                                                var copydiagramjobstart = document.getElementById("cb_copydiagramjobstart").value;
                                                                $.ajax({
                                                                    type: 'post',
                                                                    url: 'meg_data.php',
                                                                    data: {
                                                                        txt_flg: "show_copydiagramjobend", cluster: document.getElementById('txt_copydiagramcluster').value, copydiagramthainame: copydiagramthainame, copydiagramjobstart: copydiagramjobstart
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
                                                            function select_jobendskb()
                                                            {

                                                                var copydiagramthainameskb = document.getElementById("txt_copydiagramthainameskb").value;
                                                                var copydiagramjobstartskb = document.getElementById("cb_copydiagramjobstartskb").value;
                                                                $.ajax({
                                                                    type: 'post',
                                                                    url: 'meg_data.php',
                                                                    data: {
                                                                        txt_flg: "show_copydiagramjobendskb", cluster: document.getElementById('txt_copydiagramclusterskb').value, copydiagramthainameskb: copydiagramthainameskb, copydiagramjobstartskb: copydiagramjobstartskb
                                                                    },
                                                                    success: function (rs) {

                                                                        document.getElementById("data_copydiagramjobendskbsr").innerHTML = rs;
                                                                        document.getElementById("data_copydiagramjobendskbdef").innerHTML = "";
                                                                        $("#cb_copydiagramjobendskb").html(rs).selectpicker('refresh');
                                                                        $('.selectpicker').on('changed.bs.select', function () {
                                                                            document.getElementById('txt_copydiagramjobendskb').value = $(this).val();
                                                                        });
                                                                    }
                                                                });
                                                            }
                                                            var txt_copydiagramjobstart = [<?= $job ?>];
                                                            $("#txt_copydiagramjobstart").autocomplete({
                                                                source: [txt_copydiagramjobstart]
                                                            });
                                                            var txt_copydiagramjobstartskb = [<?= $job ?>];
                                                            $("#txt_copydiagramjobstartskb").autocomplete({
                                                                source: [txt_copydiagramjobstartskb]
                                                            });
                                                            var txt_copydiagramthainame = [<?= $thainame ?>];
                                                            $("#txt_copydiagramthainame").autocomplete({
                                                                source: [txt_copydiagramthainame]
                                                            });
                                                            var txt_copydiagramthainameskb = [<?= $thainame ?>];
                                                            $("#txt_copydiagramthainameskb").autocomplete({
                                                                source: [txt_copydiagramthainameskb]
                                                            });
                                                            var txt_copydiagramthainamedenso = [<?= $thainame ?>];
                                                            $("#txt_copydiagramthainamedenso").autocomplete({
                                                                source: [txt_copydiagramthainamedenso]
                                                            });
                                                            //if ('<?//= $result_seTenkobeforerest['AMOUNTREST'] ?>' < 8 || '<?//= $result_seTenkobeforerest['AMOUNTREST'] ?>' > 1000)
                                                            //{
                                                            //document.getElementById('chk_rs141').checked = false;
                                                            //document.getElementById('chk_rs140').checked = true;
                                                            //document.getElementById('txt_rs14').value = '0';
                                                            //}
                                                            //else
                                                            //{
                                                            //document.getElementById('chk_rs141').checked = true;
                                                            //document.getElementById('chk_rs140').checked = false;
                                                            //}


                                                            function edit_chkvehicletransportjobendtemp(ID1, editableObj, fieldname, vehicletransportplanid)
                                                            {

                                                                if (document.getElementById(ID1).checked == true) {


                                                                    $.ajax({
                                                                        url: 'meg_data.php',
                                                                        type: 'POST',
                                                                        data: {
                                                                            txt_flg: "edit_vehicletransportjobendtemp", ID1: ID1, fieldname: fieldname, editableObj: '1', vehicletransportplanid: vehicletransportplanid
                                                                        },
                                                                        success: function () {

                                                                            //alert(rs);
                                                                        }
                                                                    });
                                                                } else
                                                                {
                                                                    $.ajax({
                                                                        url: 'meg_data.php',
                                                                        type: 'POST',
                                                                        data: {
                                                                            txt_flg: "edit_vehicletransportjobendtemp", ID1: ID1, fieldname: fieldname, editableObj: '0', vehicletransportplanid: vehicletransportplanid
                                                                        },
                                                                        success: function () {

                                                                            //window.location.reload();
                                                                        }
                                                                    });
                                                                }



                                                            }
                                                            function select_remark2()
                                                            {
                                                                $('.selectpicker').on('changed.bs.select', function () {
                                                                    document.getElementById('txt_remark2').value = $(this).val();
                                                                });
                                                            }

                                                            /* function before_checknull()
                                                             {
                                                             if( chk_11.checked == false)
                                                             {
                                                             alert('กรุณาตรวจสอบ การทักทายก่อนเริ่มเท็งโกะ');
                                                             document.getElementById('chk_11').focus();
                                                             }
                                                             else if( chk_12.checked == false)
                                                             {
                                                             alert('กรุณาตรวจสอบ ตรวจเซ็คยูนิฟอร์ม');
                                                             document.getElementById('chk_12').focus();
                                                             }
                                                             else if( chk_13.checked == false)
                                                             {
                                                             alert('กรุณาตรวจสอบ ตรวจสอบสภาพร่างกาย');
                                                             document.getElementById('chk_13').focus();
                                                             }
                                                             else if(document.getElementById('txt_rs14').value == '')
                                                             {
                                                             alert('กรุณาตรวจสอบ ตรวจสอบระยะการพักผ่อน');
                                                             document.getElementById('ตั้งแต่ 8 ชั่วโมง').focus();
                                                             }
                                                             
                                                             
                                                             else if(document.getElementById('txt_rs151').value == '')
                                                             {
                                                             alert('กรุณาตรวจสอบ การนอนปกติ ตั้งแต่ 6 ชั่วโมงขึ้นไป');
                                                             document.getElementById('txt_rs151').focus();
                                                             }
                                                             else if(document.getElementById('txt_rs152').value == '')
                                                             {
                                                             alert('กรุณาตรวจสอบ การนอนเพิ่ม (กะกลางคืน) ตั้งแต่ 4.5 ชั่วโมงขึ้นไป');
                                                             document.getElementById('txt_rs152').focus();
                                                             }
                                                             
                                                             
                                                             else if(document.getElementById('txt_rs16').value == '')
                                                             {
                                                             alert('กรุณาตรวจสอบ ต่ำกว่า 37 องศา');
                                                             document.getElementById('txt_rs16').focus();
                                                             }
                                                             
                                                             if(document.getElementById('txt_rs171').value == '')
                                                             {
                                                             alert('กรุณาตรวจสอบ บน : 90-150');
                                                             document.getElementById('txt_rs171').focus();
                                                             }
                                                             else if(document.getElementById('txt_rs172').value == '')
                                                             {
                                                             alert('กรุณาตรวจสอบ ล่าง : 60-100');
                                                             document.getElementById('txt_rs172').focus();
                                                             }
                                                             
                                                             
                                                             else if(document.getElementById('txt_rs18').value == '')
                                                             {
                                                             alert('กรุณาตรวจสอบ ตรวจเช็คแอลกอฮอล์');
                                                             document.getElementById('txt_rs18').focus();
                                                             }
                                                             else if( chk_19.checked == false)
                                                             {
                                                             alert('กรุณาตรวจสอบ สอบถามเรื่องกังวลใจ');
                                                             document.getElementById('chk_19').focus();
                                                             }
                                                             else if( chk_110.checked == false)
                                                             {
                                                             alert('กรุณาตรวจสอบ ใบตรวจเทรลเลอร์ประจำวัน');
                                                             document.getElementById('chk_110').focus();
                                                             }
                                                             else if( chk_111.checked == false)
                                                             {
                                                             alert('กรุณาตรวจสอบ ตรวจสอบของที่พกพา');
                                                             document.getElementById('chk_111').focus();
                                                             }else if( chk_112.checked == false)
                                                             {
                                                             alert('กรุณาตรวจสอบ ตรวจสอบรายละเอียดการทำงาน');
                                                             document.getElementById('chk_112').focus();
                                                             }
                                                             else if( chk_113.checked == false)
                                                             {
                                                             alert('กรุณาตรวจสอบ แจ้งสภาพถนน');
                                                             document.getElementById('chk_113').focus();
                                                             }
                                                             else if( chk_114.checked == false)
                                                             {
                                                             alert('กรุณาตรวจสอบ แจ้งสภาพอากาศ');
                                                             document.getElementById('chk_114').focus();
                                                             }
                                                             else if( chk_115.checked == false)
                                                             {
                                                             alert('กรุณาตรวจสอบ แจ้งเรื่องโยโกะเด็น');
                                                             document.getElementById('chk_115').focus();
                                                             }
                                                             else if( chk_116.checked == false)
                                                             {
                                                             alert('กรุณาตรวจสอบ ตรวจสอบเป้าหมายการขับขี่จากเครื่องชิมูเลเตอร์');
                                                             document.getElementById('chk_116').focus();
                                                             }
                                                             else if( chk_117.checked == false)
                                                             {
                                                             alert('กรุณาตรวจสอบ สามารถวิ่งงานได้หรือไม่');
                                                             document.getElementById('chk_117').focus();
                                                             }
                                                             else if( chk_118.checked == false)
                                                             {
                                                             alert('กรุณาตรวจสอบ การทักทายหลังทำเท็งโกะเสร็จ');
                                                             document.getElementById('chk_118').focus();
                                                             }
                                                             else if(document.getElementById('txt_rs19').value == '')
                                                             {
                                                             alert('กรุณาตรวจสอบ ตรวจเช็คออกซิเจนเลือด');
                                                             document.getElementById('txt_rs19').focus();
                                                             }
                                                             
                                                             
                                                             
                                                             else if(chk_rs111.checked == false && chk_rs110.checked == false)
                                                             {
                                                             alert('ผลตรวจการทักทายก่อนเริ่มเท็งโกะ');
                                                             }
                                                             else if(chk_rs121.checked == false && chk_rs120.checked == false)
                                                             {
                                                             alert('ผลตรวจเซ็คยูนิฟอร์ม');
                                                             }
                                                             else if(chk_rs131.checked == false && chk_rs130.checked == false)
                                                             {
                                                             alert('ผลตรวจสอบสภาพร่างกาย');
                                                             }
                                                             else if(chk_rs141.checked == false && chk_rs140.checked == false)
                                                             {
                                                             alert('ผลตรวจสอบระยะการพักผ่อน');
                                                             }
                                                             else if(chk_rs151.checked == false && chk_rs150.checked == false)
                                                             {
                                                             alert('ผลตรวจสอบชั่วโมงการนอนหลับ');
                                                             else if(chk_rs161.checked == false && chk_rs160.checked == false)
                                                             {
                                                             alert('ผลตรวจเช็คอุณหภูมิ');
                                                             }
                                                             else if(chk_rs171.checked == false && chk_rs170.checked == false)
                                                             {
                                                             alert('ผลตรวจวัดความดัน');
                                                             }
                                                             else if(chk_rs181.checked == false && chk_rs180.checked == false)
                                                             {
                                                             alert('ผลตรวจเช็คแอลกอฮอล์');
                                                             }
                                                             else if(chk_rs191.checked == false && chk_rs190.checked == false)
                                                             {
                                                             alert('ผลตรวจสอบถามเรื่องกังวลใจ');
                                                             }
                                                             else if(chk_rs1101.checked == false && chk_rs1100.checked == false)
                                                             {
                                                             alert('ผลตรวจใบตรวจเทรลเลอร์ประจำวัน');
                                                             }
                                                             else if(chk_rs1111.checked == false && chk_rs1110.checked == false)
                                                             {
                                                             alert('ผลตรวจสอบของที่พกพา');
                                                             }
                                                             else if(chk_rs1121.checked == false && chk_rs1120.checked == false)
                                                             {
                                                             alert('ผลตรวจสอบรายละเอียดการทำงาน');
                                                             }
                                                             else if(chk_rs1131.checked == false && chk_rs1130.checked == false)
                                                             {
                                                             alert('ผลตรวจแจ้งสภาพถนน');
                                                             }
                                                             else if(chk_rs1141.checked == false && chk_rs1140.checked == false)
                                                             {
                                                             alert('ผลตรวจแจ้งสภาพอากาศ');
                                                             }
                                                             else if(chk_rs1151.checked == false && chk_rs1150.checked == false)
                                                             {
                                                             alert('ผลตรวจแจ้งเรื่องโยโกะเด็น');
                                                             }
                                                             else if(chk_rs1161.checked == false && chk_rs1160.checked == false)
                                                             {
                                                             alert('ผลตรวจสอบเป้าหมายการขับขี่จากเครื่องชิมูเลเตอร์');
                                                             }
                                                             else if(chk_rs1171.checked == false && chk_rs1170.checked == false)
                                                             {
                                                             alert('ผลตรวจสามารถวิ่งงานได้หรือไม่');
                                                             }
                                                             else if(chk_rs1181.checked == false && chk_rs1180.checked == false)
                                                             {
                                                             alert('ผลตรวจการทักทายหลังทำเท็งโกะเสร็จ');
                                                             }
                                                             else if(chk_rs1191.checked == false && chk_rs1190.checked == false)
                                                             {
                                                             alert('ผลตรวจเช็คออกซิเจนเลือด');
                                                             }
                                                             
                                                             
                                                             
                                                             
                                                             
                                                             
                                                             }
                                                             */


                                                            $(function () {
                                                                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ. // กรณีใช้แบบ input
                                                                $(".timeen").datetimepicker({
                                                                    datepicker: false,
                                                                    format: 'H:i',
                                                                    //mask: '29:59',
                                                                    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                });
                                                            });
                                                            

                                                            function edit_vehicletransportplan(editableObj, fieldname, ID)
                                                            {
                                                                $.ajax({
                                                                    url: 'meg_data.php',
                                                                    type: 'POST',
                                                                    data: {
                                                                        txt_flg: "edit_vehicletransportplan", editableObj: editableObj, ID: ID, fieldname: fieldname
                                                                    },
                                                                    success: function () {

                                                                    }
                                                                });
                                                            }
                                                            function rs_checkdirverbefore2()
                                                            {
                                                                if (
                                                                        chk_11.checked == true
                                                                        && chk_12.checked == true
                                                                        && chk_13.checked == true
                                                                        && document.getElementById('txt_rs14').value != ""
                                                                        && document.getElementById('txt_rs151').value != ""
                                                                        && document.getElementById('txt_rs16').value != ""
                                                                        && document.getElementById('txt_rs171').value != ""
                                                                        && document.getElementById('txt_rs172').value != ""
                                                                        && document.getElementById('txt_rs18').value != ""
                                                                        && chk_19.checked == true
                                                                        && chk_110.checked == true
                                                                        && chk_111.checked == true
                                                                        && chk_112.checked == true
                                                                        && chk_113.checked == true
                                                                        && chk_114.checked == true
                                                                        && chk_115.checked == true
                                                                        && chk_116.checked == true
                                                                        && chk_117.checked == true
                                                                        && chk_118.checked == true
                                                                        && document.getElementById('txt_rs19').value != ""
                                                                        )
                                                                {
                                                                    document.getElementById('icon_beforecheckok2').style.display = "";
                                                                    document.getElementById('icon_beforecheckno2').style.display = "none";
                                                                    if ('<?= $result_sePlain['STATUSNUMBER'] ?>' == 'O' || '<?= $result_sePlain['STATUSNUMBER'] ?>' == 'L')
                                                                    {
                                                                        edit_vehicletransportplan('แผนงานตรวจร่างกายเรียบร้อย', 'STATUS', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                        edit_vehicletransportplan('P', 'STATUSNUMBER', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                    }
                                                                } else
                                                                {
                                                                    document.getElementById('icon_beforecheckok2').style.display = "none";
                                                                    document.getElementById('icon_beforecheckno2').style.display = "";
                                                                    if ('<?= $result_sePlain['STATUSNUMBER'] ?>' == 'O' || '<?= $result_sePlain['STATUSNUMBER'] ?>' == 'L')
                                                                    {

                                                                        edit_vehicletransportplan('แผนงานยังไม่ถึงเวลารายงาน', 'STATUS', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                        edit_vehicletransportplan('O', 'STATUSNUMBER', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                    }
                                                                }



                                                            }

                                                            
                                                            function rs_resultdirverbefore2()
                                                            {
                                                                if (
                                                                        chk_rs111.checked == true
                                                                        && chk_rs121.checked == true
                                                                        && chk_rs131.checked == true
                                                                        && document.getElementById('txt_rs14').value.substring(0, 2) > 7
                                                                        //&& document.getElementById('txt_rs151').value >= 6
                                                                        && document.getElementById('txt_rs16').value < 37
                                                                        && (document.getElementById('txt_rs171').value >= 90 && document.getElementById('txt_rs171').value <= 160)
                                                                        && (document.getElementById('txt_rs172').value >= 60 && document.getElementById('txt_rs172').value <= 100)
                                                                        && document.getElementById('txt_rs18').value == 0
                                                                        && chk_rs191.checked == true
                                                                        && chk_rs1101.checked == true
                                                                        && chk_rs1111.checked == true
                                                                        && chk_rs1121.checked == true
                                                                        && chk_rs1131.checked == true
                                                                        && chk_rs1141.checked == true
                                                                        && chk_rs1151.checked == true
                                                                        && chk_rs1161.checked == true
                                                                        && chk_rs1171.checked == true
                                                                        && chk_rs1181.checked == true
                                                                        && document.getElementById('txt_rs19').value != ""
                                                                        )
                                                                {
                                                                    document.getElementById('icon_beforeresultok2').style.display = "";
                                                                    document.getElementById('icon_beforeresultno2').style.display = "none";
                                                                    if ('<?= $result_sePlain['STATUSNUMBER'] ?>' == 'O' || '<?= $result_sePlain['STATUSNUMBER'] ?>' == 'L')
                                                                    {
                                                                        edit_vehicletransportplan('แผนงานตรวจร่างกายเรียบร้อย', 'STATUS', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                        edit_vehicletransportplan('P', 'STATUSNUMBER', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                    }
                                                                } else
                                                                {
                                                                    document.getElementById('icon_beforeresultok2').style.display = "none";
                                                                    document.getElementById('icon_beforeresultno2').style.display = "";
                                                                    if ('<?= $result_sePlain['STATUSNUMBER'] ?>' == 'O' || '<?= $result_sePlain['STATUSNUMBER'] ?>' == 'L')
                                                                    {
                                                                        edit_vehicletransportplan('แผนงานยังไม่ถึงเวลารายงาน', 'STATUS', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                        edit_vehicletransportplan('O', 'STATUSNUMBER', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                    }
                                                                }
                                                            }

                                                            
                                                            function rs_checkdirvertransport2()
                                                            {
                                                                if (
                                                                        chk_1d1.checked == true
                                                                        && chk_2d1.checked == true
                                                                        && chk_3d1.checked == true
                                                                        && chk_4d1.checked == true
                                                                        && chk_5d1.checked == true
                                                                        && chk_6d1.checked == true
                                                                        && chk_7d1.checked == true

                                                                        )
                                                                {
                                                                    edit_vehicletransportplan('แผนงานรอปิดงาน', 'STATUS', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                    edit_vehicletransportplan('T', 'STATUSNUMBER', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                    document.getElementById('icon_transportcheckok2').style.display = "";
                                                                    document.getElementById('icon_transportcheckno2').style.display = "none";
                                                                } else
                                                                {
                                                                    edit_vehicletransportplan('แผนงานเปิดงาน', 'STATUS', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                    edit_vehicletransportplan('1', 'STATUSNUMBER', '<?= $_GET['vehicletransportplanid'] ?>');
                                                                    document.getElementById('icon_transportcheckok2').style.display = "none";
                                                                    document.getElementById('icon_transportcheckno2').style.display = "";
                                                                }
                                                            }
                                                            
                                                            function rs_checkdirveraffter2()
                                                            {
                                                                if (
                                                                        chk_31.checked == true
                                                                        && chk_32.checked == true
                                                                        && chk_33.checked == true
                                                                        && chk_34.checked == true
                                                                        && chk_35.checked == true
                                                                        && chk_36.checked == true
                                                                        && chk_37.checked == true
                                                                        && chk_38.checked == true
                                                                        && chk_39.checked == true
                                                                        && chk_310.checked == true
                                                                        && chk_311.checked == true
                                                                        && chk_312.checked == true
                                                                        && chk_313.checked == true

                                                                        )
                                                                {

                                                                    document.getElementById('icon_afftercheckok2').style.display = "";
                                                                    document.getElementById('icon_afftercheckno2').style.display = "none";
                                                                } else
                                                                {

                                                                    document.getElementById('icon_afftercheckok2').style.display = "none";
                                                                    document.getElementById('icon_afftercheckno2').style.display = "";
                                                                }
                                                            }


                                                            
                                                            function rs_resultdirveraffter2()
                                                            {
                                                                if (
                                                                        chk_rs311.checked == true
                                                                        && chk_rs321.checked == true
                                                                        && chk_rs331.checked == true
                                                                        && chk_rs341.checked == true
                                                                        && chk_rs351.checked == true
                                                                        && chk_rs361.checked == true
                                                                        && chk_rs371.checked == true
                                                                        && chk_rs381.checked == true
                                                                        && chk_rs391.checked == true
                                                                        && chk_rs3101.checked == true
                                                                        && chk_rs3111.checked == true
                                                                        && chk_rs3121.checked == true
                                                                        && chk_rs3131.checked == true

                                                                        )
                                                                {

                                                                    document.getElementById('icon_affterresultok2').style.display = "";
                                                                    document.getElementById('icon_affterresultno2').style.display = "none";
                                                                } else
                                                                {

                                                                    document.getElementById('icon_affterresultok2').style.display = "none";
                                                                    document.getElementById('icon_affterresultno2').style.display = "";
                                                                }
                                                            }

                                                            function edit_vehicletransportplanactualpresent(ID)
                                                            {

                                                                $.ajax({
                                                                    url: 'meg_data.php',
                                                                    type: 'POST',
                                                                    data: {
                                                                        txt_flg: "edit_vehicletransportplan", ID: ID, fieldname: 'DATEPRESENT', editableObj: 'GETDATE()'
                                                                    },
                                                                    success: function () {


                                                                    }
                                                                });
                                                            }
                                                            function update_vehicletransportplanjob(rootno, statusnumber)
                                                            {
                                                                //edit_vehicletransportplanactualpresent(rootno);
                                                                $.ajax({
                                                                    type: 'post',
                                                                    url: 'meg_data.php',
                                                                    data: {
                                                                        txt_flg: "edit_vehicletransportplanjob", rootno: rootno, statusnumber: statusnumber
                                                                    },
                                                                    success: function () {

                                                                        window.location.href = "report_customertenko.php";
                                                                    }
                                                                });
                                                            }


                                                            function edit_rs411(fieldname, ID) {
                                                                if (chk_rs411.checked == true)
                                                                {
                                                                    edit_tenkoriskychk('1', fieldname, ID);
                                                                    document.getElementById('chk_rs410').checked = false;
                                                                    document.getElementById('chk_rs411').disabled = true;
                                                                    document.getElementById('chk_rs410').disabled = false;
                                                                } else
                                                                {
                                                                    edit_tenkoriskychk('', fieldname, ID);
                                                                    document.getElementById('chk_rs411').disabled = false;
                                                                    document.getElementById('chk_rs410').disabled = true;
                                                                }

                                                            }
                                                            function edit_rs421(fieldname, ID) {
                                                                if (chk_rs421.checked == true)
                                                                {
                                                                    edit_tenkoriskychk('1', fieldname, ID);
                                                                    document.getElementById('chk_rs420').checked = false;
                                                                    document.getElementById('chk_rs421').disabled = true;
                                                                    document.getElementById('chk_rs420').disabled = false;
                                                                } else
                                                                {
                                                                    edit_tenkoriskychk('', fieldname, ID);
                                                                    document.getElementById('chk_rs421').disabled = false;
                                                                    document.getElementById('chk_rs420').disabled = true;
                                                                }

                                                            }
                                                            function edit_rs431(fieldname, ID) {
                                                                if (chk_rs431.checked == true)
                                                                {
                                                                    edit_tenkoriskychk('1', fieldname, ID);
                                                                    document.getElementById('chk_rs430').checked = false;
                                                                    document.getElementById('chk_rs431').disabled = true;
                                                                    document.getElementById('chk_rs430').disabled = false;
                                                                } else
                                                                {
                                                                    edit_tenkoriskychk('', fieldname, ID);
                                                                    document.getElementById('chk_rs431').disabled = false;
                                                                    document.getElementById('chk_rs430').disabled = true;
                                                                }

                                                            }
                                                            function edit_rs441(fieldname, ID) {
                                                                if (chk_rs441.checked == true)
                                                                {
                                                                    edit_tenkoriskychk('1', fieldname, ID);
                                                                    document.getElementById('chk_rs440').checked = false;
                                                                    document.getElementById('chk_rs441').disabled = true;
                                                                    document.getElementById('chk_rs440').disabled = false;
                                                                } else
                                                                {
                                                                    edit_tenkoriskychk('', fieldname, ID);
                                                                    document.getElementById('chk_rs441').disabled = false;
                                                                    document.getElementById('chk_rs440').disabled = true;
                                                                }

                                                            }
                                                            function edit_rs451(fieldname, ID) {
                                                                if (chk_rs451.checked == true)
                                                                {
                                                                    edit_tenkoriskychk('1', fieldname, ID);
                                                                    document.getElementById('chk_rs450').checked = false;
                                                                    document.getElementById('chk_rs451').disabled = true;
                                                                    document.getElementById('chk_rs450').disabled = false;
                                                                } else
                                                                {
                                                                    edit_tenkoriskychk('', fieldname, ID);
                                                                    document.getElementById('chk_rs451').disabled = false;
                                                                    document.getElementById('chk_rs450').disabled = true;
                                                                }

                                                            }
                                                            function edit_rs451_h(fieldname, ID) {
                                                                if (chk_rs451_h.checked == true)
                                                                {
                                                                    edit_tenkoriskychk('1', fieldname, ID);
                                                                    document.getElementById('chk_rs450_h').checked = false;
                                                                    document.getElementById('chk_rs451_h').disabled = true;
                                                                    document.getElementById('chk_rs450_h').disabled = false;
                                                                } else
                                                                {
                                                                    edit_tenkoriskychk('', fieldname, ID);
                                                                    document.getElementById('chk_rs451_h').disabled = false;
                                                                    document.getElementById('chk_rs450_h').disabled = true;
                                                                }

                                                            }
                                                            function edit_rs461(fieldname, ID) {
                                                                if (chk_rs461.checked == true)
                                                                {
                                                                    edit_tenkoriskychk('1', fieldname, ID);
                                                                    document.getElementById('chk_rs460').checked = false;
                                                                    document.getElementById('chk_rs461').disabled = true;
                                                                    document.getElementById('chk_rs460').disabled = false;
                                                                } else
                                                                {
                                                                    edit_tenkoriskychk('', fieldname, ID);
                                                                    document.getElementById('chk_rs461').disabled = false;
                                                                    document.getElementById('chk_rs460').disabled = true;
                                                                }

                                                            }
                                                            function edit_rs461_h(fieldname, ID) {
                                                                if (chk_rs461_h.checked == true)
                                                                {
                                                                    edit_tenkoriskychk('1', fieldname, ID);
                                                                    document.getElementById('chk_rs460_h').checked = false;
                                                                    document.getElementById('chk_rs461_h').disabled = true;
                                                                    document.getElementById('chk_rs460_h').disabled = false;
                                                                } else
                                                                {
                                                                    edit_tenkoriskychk('', fieldname, ID);
                                                                    document.getElementById('chk_rs461_h').disabled = false;
                                                                    document.getElementById('chk_rs460_h').disabled = true;
                                                                }

                                                            }
                                                            function edit_rs471(fieldname, ID) {
                                                                if (chk_rs471.checked == true)
                                                                {
                                                                    edit_tenkoriskychk('1', fieldname, ID);
                                                                    document.getElementById('chk_rs470').checked = false;
                                                                    document.getElementById('chk_rs471').disabled = true;
                                                                    document.getElementById('chk_rs470').disabled = false;
                                                                } else
                                                                {
                                                                    edit_tenkoriskychk('', fieldname, ID);
                                                                    document.getElementById('chk_rs471').disabled = false;
                                                                    document.getElementById('chk_rs470').disabled = true;
                                                                }

                                                            }
                                                            function edit_rs471_h(fieldname, ID) {
                                                                if (chk_rs471_h.checked == true)
                                                                {
                                                                    edit_tenkoriskychk('1', fieldname, ID);
                                                                    document.getElementById('chk_rs470_h').checked = false;
                                                                    document.getElementById('chk_rs471_h').disabled = true;
                                                                    document.getElementById('chk_rs470_h').disabled = false;
                                                                } else
                                                                {
                                                                    edit_tenkoriskychk('', fieldname, ID);
                                                                    document.getElementById('chk_rs471_h').disabled = false;
                                                                    document.getElementById('chk_rs470_h').disabled = true;
                                                                }

                                                            }
                                                            function edit_rs481(fieldname, ID) {
                                                                if (chk_rs481.checked == true)
                                                                {
                                                                    edit_tenkoriskychk('1', fieldname, ID);
                                                                    document.getElementById('chk_rs480').checked = false;
                                                                    document.getElementById('chk_rs481').disabled = true;
                                                                    document.getElementById('chk_rs480').disabled = false;
                                                                } else
                                                                {
                                                                    edit_tenkoriskychk('', fieldname, ID);
                                                                    document.getElementById('chk_rs481').disabled = false;
                                                                    document.getElementById('chk_rs480').disabled = true;
                                                                }

                                                            }
                                                            function edit_rs491(fieldname, ID) {
                                                                if (chk_rs491.checked == true)
                                                                {
                                                                    edit_tenkoriskychk('1', fieldname, ID);
                                                                    document.getElementById('chk_rs490').checked = false;
                                                                    document.getElementById('chk_rs491').disabled = true;
                                                                    document.getElementById('chk_rs490').disabled = false;
                                                                } else
                                                                {
                                                                    edit_tenkoriskychk('', fieldname, ID);
                                                                    document.getElementById('chk_rs491').disabled = false;
                                                                    document.getElementById('chk_rs490').disabled = true;
                                                                }

                                                            }
                                                            function edit_rs4101(fieldname, ID) {
                                                                if (chk_rs4101.checked == true)
                                                                {
                                                                    edit_tenkoriskychk('1', fieldname, ID);
                                                                    document.getElementById('chk_rs4100').checked = false;
                                                                    document.getElementById('chk_rs4101').disabled = true;
                                                                    document.getElementById('chk_rs4100').disabled = false;
                                                                } else
                                                                {
                                                                    edit_tenkoriskychk('', fieldname, ID);
                                                                    document.getElementById('chk_rs4101').disabled = false;
                                                                    document.getElementById('chk_rs4100').disabled = true;
                                                                }

                                                            }
                                                            function edit_rs410(fieldname, ID) {
                                                                if (chk_rs410.checked == true)
                                                                {
                                                                    edit_tenkoriskychk('0', fieldname, ID);
                                                                    document.getElementById('chk_rs411').checked = false;
                                                                    document.getElementById('chk_rs411').disabled = false;
                                                                    document.getElementById('chk_rs410').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoriskychk('', fieldname, ID);
                                                                    document.getElementById('chk_rs411').disabled = true;
                                                                    document.getElementById('chk_rs410').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs420(fieldname, ID) {
                                                                if (chk_rs420.checked == true)
                                                                {
                                                                    edit_tenkoriskychk('0', fieldname, ID);
                                                                    document.getElementById('chk_rs421').checked = false;
                                                                    document.getElementById('chk_rs421').disabled = false;
                                                                    document.getElementById('chk_rs420').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoriskychk('', fieldname, ID);
                                                                    document.getElementById('chk_rs421').disabled = true;
                                                                    document.getElementById('chk_rs420').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs430(fieldname, ID) {
                                                                if (chk_rs430.checked == true)
                                                                {
                                                                    edit_tenkoriskychk('0', fieldname, ID);
                                                                    document.getElementById('chk_rs431').checked = false;
                                                                    document.getElementById('chk_rs431').disabled = false;
                                                                    document.getElementById('chk_rs430').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoriskychk('', fieldname, ID);
                                                                    document.getElementById('chk_rs431').disabled = true;
                                                                    document.getElementById('chk_rs430').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs440(fieldname, ID) {
                                                                if (chk_rs440.checked == true)
                                                                {
                                                                    edit_tenkoriskychk('0', fieldname, ID);
                                                                    document.getElementById('chk_rs441').checked = false;
                                                                    document.getElementById('chk_rs441').disabled = false;
                                                                    document.getElementById('chk_rs440').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoriskychk('', fieldname, ID);
                                                                    document.getElementById('chk_rs441').disabled = true;
                                                                    document.getElementById('chk_rs440').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs450(fieldname, ID) {
                                                                if (chk_rs450.checked == true)
                                                                {
                                                                    edit_tenkoriskychk('0', fieldname, ID);
                                                                    document.getElementById('chk_rs451').checked = false;
                                                                    document.getElementById('chk_rs451').disabled = false;
                                                                    document.getElementById('chk_rs450').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoriskychk('', fieldname, ID);
                                                                    document.getElementById('chk_rs451').disabled = true;
                                                                    document.getElementById('chk_rs450').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs450_h(fieldname, ID) {
                                                                if (chk_rs450_h.checked == true)
                                                                {
                                                                    edit_tenkoriskychk('0', fieldname, ID);
                                                                    document.getElementById('chk_rs451_h').checked = false;
                                                                    document.getElementById('chk_rs451_h').disabled = false;
                                                                    document.getElementById('chk_rs450_h').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoriskychk('', fieldname, ID);
                                                                    document.getElementById('chk_rs451_h').disabled = true;
                                                                    document.getElementById('chk_rs450_h').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs460(fieldname, ID) {
                                                                if (chk_rs460.checked == true)
                                                                {
                                                                    edit_tenkoriskychk('0', fieldname, ID);
                                                                    document.getElementById('chk_rs461').checked = false;
                                                                    document.getElementById('chk_rs461').disabled = false;
                                                                    document.getElementById('chk_rs460').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoriskychk('', fieldname, ID);
                                                                    document.getElementById('chk_rs461').disabled = true;
                                                                    document.getElementById('chk_rs460').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs460_h(fieldname, ID) {
                                                                if (chk_rs460_h.checked == true)
                                                                {
                                                                    edit_tenkoriskychk('0', fieldname, ID);
                                                                    document.getElementById('chk_rs461_h').checked = false;
                                                                    document.getElementById('chk_rs461_h').disabled = false;
                                                                    document.getElementById('chk_rs460_h').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoriskychk('', fieldname, ID);
                                                                    document.getElementById('chk_rs461_h').disabled = true;
                                                                    document.getElementById('chk_rs460_h').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs470(fieldname, ID) {
                                                                if (chk_rs470.checked == true)
                                                                {
                                                                    edit_tenkoriskychk('0', fieldname, ID);
                                                                    document.getElementById('chk_rs471').checked = false;
                                                                    document.getElementById('chk_rs471').disabled = false;
                                                                    document.getElementById('chk_rs470').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoriskychk('', fieldname, ID);
                                                                    document.getElementById('chk_rs471').disabled = true;
                                                                    document.getElementById('chk_rs470').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs470_h(fieldname, ID) {
                                                                if (chk_rs470_h.checked == true)
                                                                {
                                                                    edit_tenkoriskychk('0', fieldname, ID);
                                                                    document.getElementById('chk_rs471_h').checked = false;
                                                                    document.getElementById('chk_rs471_h').disabled = false;
                                                                    document.getElementById('chk_rs470_h').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoriskychk('', fieldname, ID);
                                                                    document.getElementById('chk_rs471_h').disabled = true;
                                                                    document.getElementById('chk_rs470_h').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs480(fieldname, ID) {
                                                                if (chk_rs480.checked == true)
                                                                {
                                                                    edit_tenkoriskychk('0', fieldname, ID);
                                                                    document.getElementById('chk_rs481').checked = false;
                                                                    document.getElementById('chk_rs481').disabled = false;
                                                                    document.getElementById('chk_rs480').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoriskychk('', fieldname, ID);
                                                                    document.getElementById('chk_rs481').disabled = true;
                                                                    document.getElementById('chk_rs480').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs490(fieldname, ID) {
                                                                if (chk_rs490.checked == true)
                                                                {
                                                                    edit_tenkoriskychk('0', fieldname, ID);
                                                                    document.getElementById('chk_rs491').checked = false;
                                                                    document.getElementById('chk_rs491').disabled = false;
                                                                    document.getElementById('chk_rs490').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoriskychk('', fieldname, ID);
                                                                    document.getElementById('chk_rs491').disabled = true;
                                                                    document.getElementById('chk_rs490').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs4100(fieldname, ID) {
                                                                if (chk_rs4100.checked == true)
                                                                {
                                                                    edit_tenkoriskychk('0', fieldname, ID);
                                                                    document.getElementById('chk_rs4101').checked = false;
                                                                    document.getElementById('chk_rs4101').disabled = false;
                                                                    document.getElementById('chk_rs4100').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoriskychk('', fieldname, ID);
                                                                    document.getElementById('chk_rs4101').disabled = true;
                                                                    document.getElementById('chk_rs4100').disabled = false;
                                                                }

                                                            }








                                                            function edit_rs311(fieldname, ID) {
                                                                if (chk_rs311.checked == true)
                                                                {

                                                                    edit_tenkoafterchk('1', fieldname, ID);
                                                                    document.getElementById('chk_rs310').checked = false;
                                                                    document.getElementById('chk_rs310').disabled = false;
                                                                    document.getElementById('chk_rs311').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                    document.getElementById('chk_rs310').disabled = true;
                                                                    document.getElementById('chk_rs311').disabled = false;
                                                                }

                                                                rs_resultdirveraffter2();


                                                            }

                                                            function edit_rs321(fieldname, ID) {
                                                                if (chk_rs321.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('1', fieldname, ID);
                                                                    document.getElementById('chk_rs320').checked = false;
                                                                    document.getElementById('chk_rs320').disabled = false;
                                                                    document.getElementById('chk_rs321').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                    document.getElementById('chk_rs320').disabled = true;
                                                                    document.getElementById('chk_rs321').disabled = false;
                                                                }

                                                                rs_resultdirveraffter2();

                                                            }
                                                            function edit_rs331(fieldname, ID) {
                                                                if (chk_rs331.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('1', fieldname, ID);
                                                                    document.getElementById('chk_rs330').checked = false;
                                                                    document.getElementById('chk_rs330').disabled = false;
                                                                    document.getElementById('chk_rs331').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                    document.getElementById('chk_rs330').disabled = true;
                                                                    document.getElementById('chk_rs331').disabled = false;
                                                                }

                                                                rs_resultdirveraffter2();

                                                            }
                                                            function edit_rs341(fieldname, ID) {
                                                                if (chk_rs341.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('1', fieldname, ID);
                                                                    document.getElementById('chk_rs340').checked = false;
                                                                    document.getElementById('chk_rs340').disabled = false;
                                                                    document.getElementById('chk_rs341').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                    document.getElementById('chk_rs340').disabled = true;
                                                                    document.getElementById('chk_rs341').disabled = false;
                                                                }

                                                                rs_resultdirveraffter2();

                                                            }
                                                            function edit_rs351(fieldname, ID) {
                                                                if (chk_rs351.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('1', fieldname, ID);
                                                                    document.getElementById('chk_rs350').checked = false;
                                                                    document.getElementById('chk_rs350').disabled = false;
                                                                    document.getElementById('chk_rs351').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                    document.getElementById('chk_rs350').disabled = true;
                                                                    document.getElementById('chk_rs351').disabled = false;
                                                                }

                                                                rs_resultdirveraffter2();

                                                            }
                                                            function edit_rs361(fieldname, ID) {
                                                                if (chk_rs361.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('1', fieldname, ID);
                                                                    document.getElementById('chk_rs360').checked = false;
                                                                    document.getElementById('chk_rs360').disabled = false;
                                                                    document.getElementById('chk_rs361').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                    document.getElementById('chk_rs360').disabled = true;
                                                                    document.getElementById('chk_rs361').disabled = false;
                                                                }

                                                                rs_resultdirveraffter2();

                                                            }
                                                            function edit_rs371(fieldname, ID) {
                                                                if (chk_rs371.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('1', fieldname, ID);
                                                                    document.getElementById('chk_rs370').checked = false;
                                                                    document.getElementById('chk_rs370').disabled = false;
                                                                    document.getElementById('chk_rs371').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                    document.getElementById('chk_rs370').disabled = true;
                                                                    document.getElementById('chk_rs371').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs381(fieldname, ID) {
                                                                if (chk_rs381.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('1', fieldname, ID);
                                                                    document.getElementById('chk_rs380').checked = false;
                                                                    document.getElementById('chk_rs380').disabled = false;
                                                                    document.getElementById('chk_rs381').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                    document.getElementById('chk_rs380').disabled = true;
                                                                    document.getElementById('chk_rs381').disabled = false;
                                                                }

                                                                rs_resultdirveraffter2();

                                                            }
                                                            function edit_rs391(fieldname, ID) {
                                                                if (chk_rs391.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('1', fieldname, ID);
                                                                    document.getElementById('chk_rs390').checked = false;
                                                                    document.getElementById('chk_rs390').disabled = false;
                                                                    document.getElementById('chk_rs391').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                    document.getElementById('chk_rs390').disabled = true;
                                                                    document.getElementById('chk_rs391').disabled = false;
                                                                }

                                                                rs_resultdirveraffter2();

                                                            }
                                                            function edit_rs3101(fieldname, ID) {
                                                                if (chk_rs3101.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('1', fieldname, ID);
                                                                    document.getElementById('chk_rs3100').checked = false;
                                                                    document.getElementById('chk_rs3100').disabled = false;
                                                                    document.getElementById('chk_rs3101').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                    document.getElementById('chk_rs3100').disabled = true;
                                                                    document.getElementById('chk_rs3101').disabled = false;
                                                                }

                                                                rs_resultdirveraffter2();

                                                            }
                                                            function edit_rs3111(fieldname, ID) {
                                                                if (chk_rs3111.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('1', fieldname, ID);
                                                                    document.getElementById('chk_rs3110').checked = false;
                                                                    document.getElementById('chk_rs3110').disabled = false;
                                                                    document.getElementById('chk_rs3111').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                    document.getElementById('chk_rs3110').disabled = true;
                                                                    document.getElementById('chk_rs3111').disabled = false;
                                                                }

                                                                rs_resultdirveraffter2();

                                                            }
                                                            function edit_rs3121(fieldname, ID) {
                                                                if (chk_rs3121.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('1', fieldname, ID);
                                                                    document.getElementById('chk_rs3120').checked = false;
                                                                    document.getElementById('chk_rs3120').disabled = false;
                                                                    document.getElementById('chk_rs3121').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                    document.getElementById('chk_rs3120').disabled = true;
                                                                    document.getElementById('chk_rs3121').disabled = false;
                                                                }

                                                                rs_resultdirveraffter2();

                                                            }
                                                            function edit_rs3131(fieldname, ID) {
                                                                if (chk_rs3131.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('1', fieldname, ID);
                                                                    document.getElementById('chk_rs3130').checked = false;
                                                                    document.getElementById('chk_rs3130').disabled = false;
                                                                    document.getElementById('chk_rs3131').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                    document.getElementById('chk_rs3130').disabled = true;
                                                                    document.getElementById('chk_rs3131').disabled = false;
                                                                }

                                                                rs_resultdirveraffter2();

                                                            }



                                                            function edit_rs310(fieldname, ID) {
                                                                if (chk_rs310.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('0', fieldname, ID);
                                                                    document.getElementById('chk_rs311').checked = false;
                                                                    document.getElementById('chk_rs311').disabled = false;
                                                                    document.getElementById('chk_rs310').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                    document.getElementById('chk_rs311').disabled = true;
                                                                    document.getElementById('chk_rs310').disabled = false;
                                                                }

                                                                rs_resultdirveraffter2();

                                                            }

                                                            function edit_rs320(fieldname, ID) {
                                                                if (chk_rs320.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('0', fieldname, ID);
                                                                    document.getElementById('chk_rs321').checked = false;
                                                                    document.getElementById('chk_rs321').disabled = false;
                                                                    document.getElementById('chk_rs320').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                    document.getElementById('chk_rs321').disabled = true;
                                                                    document.getElementById('chk_rs320').disabled = false;
                                                                }

                                                                rs_resultdirveraffter2();

                                                            }
                                                            function edit_rs330(fieldname, ID) {
                                                                if (chk_rs330.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('0', fieldname, ID);
                                                                    document.getElementById('chk_rs331').checked = false;
                                                                    document.getElementById('chk_rs331').disabled = false;
                                                                    document.getElementById('chk_rs330').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                    document.getElementById('chk_rs331').disabled = true;
                                                                    document.getElementById('chk_rs330').disabled = false;
                                                                }

                                                                rs_resultdirveraffter2();

                                                            }
                                                            function edit_rs340(fieldname, ID) {
                                                                if (chk_rs340.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('0', fieldname, ID);
                                                                    document.getElementById('chk_rs341').checked = false;
                                                                    document.getElementById('chk_rs341').disabled = false;
                                                                    document.getElementById('chk_rs340').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                    document.getElementById('chk_rs341').disabled = true;
                                                                    document.getElementById('chk_rs340').disabled = false;
                                                                }

                                                                rs_resultdirveraffter2();

                                                            }
                                                            function edit_rs350(fieldname, ID) {
                                                                if (chk_rs350.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('0', fieldname, ID);
                                                                    document.getElementById('chk_rs351').checked = false;
                                                                    document.getElementById('chk_rs351').disabled = false;
                                                                    document.getElementById('chk_rs350').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                    document.getElementById('chk_rs351').disabled = true;
                                                                    document.getElementById('chk_rs350').disabled = false;
                                                                }

                                                                rs_resultdirveraffter2();

                                                            }
                                                            function edit_rs360(fieldname, ID) {
                                                                if (chk_rs360.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('0', fieldname, ID);
                                                                    document.getElementById('chk_rs361').checked = false;
                                                                    document.getElementById('chk_rs361').disabled = false;
                                                                    document.getElementById('chk_rs360').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                    document.getElementById('chk_rs361').disabled = true;
                                                                    document.getElementById('chk_rs360').disabled = false;
                                                                }

                                                                rs_resultdirveraffter2();

                                                            }
                                                            function edit_rs370(fieldname, ID) {
                                                                if (chk_rs370.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('0', fieldname, ID);
                                                                    document.getElementById('chk_rs371').checked = false;
                                                                    document.getElementById('chk_rs371').disabled = false;
                                                                    document.getElementById('chk_rs370').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                    document.getElementById('chk_rs371').disabled = true;
                                                                    document.getElementById('chk_rs370').disabled = false;
                                                                }

                                                                rs_resultdirveraffter2();

                                                            }
                                                            function edit_rs380(fieldname, ID) {
                                                                if (chk_rs380.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('0', fieldname, ID);
                                                                    document.getElementById('chk_rs381').checked = false;
                                                                    document.getElementById('chk_rs381').disabled = false;
                                                                    document.getElementById('chk_rs380').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                    document.getElementById('chk_rs381').disabled = true;
                                                                    document.getElementById('chk_rs380').disabled = false;
                                                                }

                                                                rs_resultdirveraffter2();

                                                            }
                                                            function edit_rs390(fieldname, ID) {
                                                                if (chk_rs390.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('0', fieldname, ID);
                                                                    document.getElementById('chk_rs391').checked = false;
                                                                    document.getElementById('chk_rs391').disabled = false;
                                                                    document.getElementById('chk_rs390').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                    document.getElementById('chk_rs391').disabled = true;
                                                                    document.getElementById('chk_rs390').disabled = false;
                                                                }

                                                                rs_resultdirveraffter2();

                                                            }
                                                            function edit_rs3100(fieldname, ID) {
                                                                if (chk_rs3100.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('0', fieldname, ID);
                                                                    document.getElementById('chk_rs3101').checked = false;
                                                                    document.getElementById('chk_rs3101').disabled = false;
                                                                    document.getElementById('chk_rs3100').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                    document.getElementById('chk_rs3101').disabled = true;
                                                                    document.getElementById('chk_rs3100').disabled = false;
                                                                }

                                                                rs_resultdirveraffter2();

                                                            }
                                                            function edit_rs3110(fieldname, ID) {
                                                                if (chk_rs3110.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('0', fieldname, ID);
                                                                    document.getElementById('chk_rs3111').checked = false;
                                                                    document.getElementById('chk_rs3111').disabled = false;
                                                                    document.getElementById('chk_rs3110').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                    document.getElementById('chk_rs3111').disabled = true;
                                                                    document.getElementById('chk_rs3110').disabled = false;
                                                                }

                                                                rs_resultdirveraffter2();

                                                            }
                                                            function edit_rs3120(fieldname, ID) {
                                                                if (chk_rs3120.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('0', fieldname, ID);
                                                                    document.getElementById('chk_rs3121').checked = false;
                                                                    document.getElementById('chk_rs3121').disabled = false;
                                                                    document.getElementById('chk_rs3120').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                    document.getElementById('chk_rs3121').disabled = true;
                                                                    document.getElementById('chk_rs3120').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs3130(fieldname, ID) {
                                                                if (chk_rs3130.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('0', fieldname, ID);
                                                                    document.getElementById('chk_rs3131').checked = false;
                                                                    document.getElementById('chk_rs3131').disabled = false;
                                                                    document.getElementById('chk_rs3130').disabled = true;
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                    document.getElementById('chk_rs3131').disabled = true;
                                                                    document.getElementById('chk_rs3130').disabled = false;
                                                                }

                                                                rs_resultdirveraffter2();

                                                            }

                                                            function edit_check31(fieldname, ID) {
                                                                if (chk_31.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('1', fieldname, ID);
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                }


                                                            }
                                                            function edit_check32(fieldname, ID) {
                                                                if (chk_32.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('1', fieldname, ID);
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                }


                                                            }
                                                            function edit_check33(fieldname, ID) {
                                                                if (chk_33.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('1', fieldname, ID);
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                }


                                                            }
                                                            function edit_check34(fieldname, ID) {
                                                                if (chk_34.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('1', fieldname, ID);
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                }


                                                            }
                                                            function edit_check35(fieldname, ID) {
                                                                if (chk_35.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('1', fieldname, ID);
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                }


                                                            }
                                                            function edit_check36(fieldname, ID) {
                                                                if (chk_36.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('1', fieldname, ID);
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                }


                                                            }
                                                            function edit_check37(fieldname, ID) {
                                                                if (chk_37.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('1', fieldname, ID);
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                }


                                                            }
                                                            function edit_check38(fieldname, ID) {
                                                                if (chk_38.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('1', fieldname, ID);
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                }


                                                            }
                                                            function edit_check39(fieldname, ID) {
                                                                if (chk_39.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('1', fieldname, ID);
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                }


                                                            }
                                                            function edit_check310(fieldname, ID) {
                                                                if (chk_310.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('1', fieldname, ID);
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                }


                                                            }
                                                            function edit_check311(fieldname, ID) {
                                                                if (chk_311.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('1', fieldname, ID);
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                }


                                                            }
                                                            function edit_check312(fieldname, ID) {
                                                                if (chk_312.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('1', fieldname, ID);
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                }

                                                            }
                                                            function edit_check313(fieldname, ID) {
                                                                if (chk_313.checked == true)
                                                                {
                                                                    edit_tenkoafterchk('1', fieldname, ID);
                                                                } else
                                                                {
                                                                    edit_tenkoafterchk('', fieldname, ID);
                                                                }


                                                            }


                                                            function edit_check1d1(fieldname, ID, tenkotransportdate) {
                                                                if (chk_1d1.checked == true)
                                                                {

                                                                    edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                                } else
                                                                {
                                                                    edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                                }

                                                            }
                                                            function edit_check2d1(fieldname, ID, tenkotransportdate) {
                                                                if (chk_2d1.checked == true)
                                                                {
                                                                    edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                                } else
                                                                {
                                                                    edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                                }


                                                            }
                                                            function edit_check3d1(fieldname, ID, tenkotransportdate) {
                                                                if (chk_3d1.checked == true)
                                                                {
                                                                    edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                                } else
                                                                {
                                                                    edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                                }

                                                            }
                                                            function edit_check4d1(fieldname, ID, tenkotransportdate) {
                                                                if (chk_4d1.checked == true)
                                                                {
                                                                    edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                                } else
                                                                {
                                                                    edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                                }

                                                            }
                                                            function edit_check5d1(fieldname, ID, tenkotransportdate) {
                                                                if (chk_5d1.checked == true)
                                                                {
                                                                    edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                                } else
                                                                {
                                                                    edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                                }

                                                            }
                                                            function edit_check6d1(fieldname, ID, tenkotransportdate) {
                                                                if (chk_6d1.checked == true)
                                                                {
                                                                    edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                                } else
                                                                {
                                                                    edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                                }

                                                            }
                                                            function edit_check7d1(fieldname, ID, tenkotransportdate) {
                                                                if (chk_7d1.checked == true)
                                                                {
                                                                    edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                                } else
                                                                {
                                                                    edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                                }


                                                            }


                                                            function edit_check1d2(fieldname, ID, tenkotransportdate) {
                                                                if (chk_1d2.checked == true)
                                                                {
                                                                    edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                                } else
                                                                {
                                                                    edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                                }

                                                            }
                                                            function edit_check2d2(fieldname, ID, tenkotransportdate) {
                                                                if (chk_2d2.checked == true)
                                                                {
                                                                    edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                                } else
                                                                {
                                                                    edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                                }


                                                            }
                                                            function edit_check3d2(fieldname, ID, tenkotransportdate) {
                                                                if (chk_3d2.checked == true)
                                                                {
                                                                    edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                                } else
                                                                {
                                                                    edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                                }

                                                            }
                                                            function edit_check4d2(fieldname, ID, tenkotransportdate) {
                                                                if (chk_4d2.checked == true)
                                                                {
                                                                    edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                                } else
                                                                {
                                                                    edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                                }

                                                            }
                                                            function edit_check5d2(fieldname, ID, tenkotransportdate) {
                                                                if (chk_5d2.checked == true)
                                                                {
                                                                    edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                                } else
                                                                {
                                                                    edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                                }

                                                            }
                                                            function edit_check6d2(fieldname, ID, tenkotransportdate) {
                                                                if (chk_6d2.checked == true)
                                                                {
                                                                    edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                                } else
                                                                {
                                                                    edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                                }

                                                            }
                                                            function edit_check7d2(fieldname, ID, tenkotransportdate) {
                                                                if (chk_7d2.checked == true)
                                                                {
                                                                    edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                                } else
                                                                {
                                                                    edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                                }


                                                            }



                                                            function edit_check1d3(fieldname, ID, tenkotransportdate) {
                                                                if (chk_1d3.checked == true)
                                                                {
                                                                    edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                                } else
                                                                {
                                                                    edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                                }

                                                            }
                                                            function edit_check2d3(fieldname, ID, tenkotransportdate) {
                                                                if (chk_2d3.checked == true)
                                                                {
                                                                    edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                                } else
                                                                {
                                                                    edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                                }


                                                            }
                                                            function edit_check3d3(fieldname, ID, tenkotransportdate) {
                                                                if (chk_3d3.checked == true)
                                                                {
                                                                    edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                                } else
                                                                {
                                                                    edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                                }

                                                            }
                                                            function edit_check4d3(fieldname, ID, tenkotransportdate) {
                                                                if (chk_4d3.checked == true)
                                                                {
                                                                    edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                                } else
                                                                {
                                                                    edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                                }

                                                            }
                                                            function edit_check5d3(fieldname, ID, tenkotransportdate) {
                                                                if (chk_5d3.checked == true)
                                                                {
                                                                    edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                                } else
                                                                {
                                                                    edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                                }

                                                            }
                                                            function edit_check6d3(fieldname, ID, tenkotransportdate) {
                                                                if (chk_6d3.checked == true)
                                                                {
                                                                    edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                                } else
                                                                {
                                                                    edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                                }

                                                            }
                                                            function edit_check7d3(fieldname, ID, tenkotransportdate) {
                                                                if (chk_7d3.checked == true)
                                                                {
                                                                    edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                                } else
                                                                {
                                                                    edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                                }


                                                            }





                                                            function edit_check1d4(fieldname, ID, tenkotransportdate) {
                                                                if (chk_1d4.checked == true)
                                                                {
                                                                    edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                                } else
                                                                {
                                                                    edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                                }

                                                            }
                                                            function edit_check2d4(fieldname, ID, tenkotransportdate) {
                                                                if (chk_2d4.checked == true)
                                                                {
                                                                    edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                                } else
                                                                {
                                                                    edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                                }


                                                            }
                                                            function edit_check3d4(fieldname, ID, tenkotransportdate) {
                                                                if (chk_3d4.checked == true)
                                                                {
                                                                    edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                                } else
                                                                {
                                                                    edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                                }

                                                            }
                                                            function edit_check4d4(fieldname, ID, tenkotransportdate) {
                                                                if (chk_4d4.checked == true)
                                                                {
                                                                    edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                                } else
                                                                {
                                                                    edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                                }

                                                            }
                                                            function edit_check5d4(fieldname, ID, tenkotransportdate) {
                                                                if (chk_5d4.checked == true)
                                                                {
                                                                    edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                                } else
                                                                {
                                                                    edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                                }

                                                            }
                                                            function edit_check6d4(fieldname, ID, tenkotransportdate) {
                                                                if (chk_6d4.checked == true)
                                                                {
                                                                    edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                                } else
                                                                {
                                                                    edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                                }

                                                            }
                                                            function edit_check7d4(fieldname, ID, tenkotransportdate) {
                                                                if (chk_7d4.checked == true)
                                                                {
                                                                    edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                                } else
                                                                {
                                                                    edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                                }


                                                            }






                                                            function edit_check1d5(fieldname, ID, tenkotransportdate) {
                                                                if (chk_1d5.checked == true)
                                                                {
                                                                    edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                                } else
                                                                {
                                                                    edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                                }

                                                            }
                                                            function edit_check2d5(fieldname, ID, tenkotransportdate) {
                                                                if (chk_2d5.checked == true)
                                                                {
                                                                    edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                                } else
                                                                {
                                                                    edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                                }


                                                            }
                                                            function edit_check3d5(fieldname, ID, tenkotransportdate) {
                                                                if (chk_3d5.checked == true)
                                                                {
                                                                    edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                                } else
                                                                {
                                                                    edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                                }

                                                            }
                                                            function edit_check4d5(fieldname, ID, tenkotransportdate) {
                                                                if (chk_4d5.checked == true)
                                                                {
                                                                    edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                                } else
                                                                {
                                                                    edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                                }

                                                            }
                                                            function edit_check5d5(fieldname, ID, tenkotransportdate) {
                                                                if (chk_5d5.checked == true)
                                                                {
                                                                    edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                                } else
                                                                {
                                                                    edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                                }

                                                            }
                                                            function edit_check6d5(fieldname, ID, tenkotransportdate) {
                                                                if (chk_6d5.checked == true)
                                                                {
                                                                    edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                                } else
                                                                {
                                                                    edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                                }

                                                            }
                                                            function edit_check7d5(fieldname, ID, tenkotransportdate) {
                                                                if (chk_7d5.checked == true)
                                                                {
                                                                    edit_tenkotransportchk('1', fieldname, ID, tenkotransportdate);
                                                                } else
                                                                {
                                                                    edit_tenkotransportchk('', fieldname, ID, tenkotransportdate);
                                                                }


                                                            }






                                                            function edit_rs110() {

                                                                if (chk_rs110.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs111').checked = false;
                                                                    document.getElementById('chk_rs110').disabled = true;
                                                                    document.getElementById('chk_rs111').disabled = false;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs110').disabled = false;
                                                                    document.getElementById('chk_rs111').disabled = true;
                                                                }

                                                            }
                                                            function edit_rs120() {
                                                                if (chk_rs120.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs121').checked = false;
                                                                    document.getElementById('chk_rs120').disabled = true;
                                                                    document.getElementById('chk_rs121').disabled = false;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs121').disabled = true;
                                                                    document.getElementById('chk_rs120').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs130() {
                                                                if (chk_rs130.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs131').checked = false;
                                                                    document.getElementById('chk_rs130').disabled = true;
                                                                    document.getElementById('chk_rs131').disabled = false;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs131').disabled = true;
                                                                    document.getElementById('chk_rs130').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs140() {
                                                                if (chk_rs140.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs141').checked = false;
                                                                    document.getElementById('chk_rs140').disabled = true;
                                                                    document.getElementById('chk_rs141').disabled = false;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs141').disabled = true;
                                                                    document.getElementById('chk_rs140').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs150() {
                                                                if (chk_rs150.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs151').checked = false;
                                                                    document.getElementById('chk_rs150').disabled = true;
                                                                    document.getElementById('chk_rs151').disabled = false;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs151').disabled = true;
                                                                    document.getElementById('chk_rs150').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs160() {
                                                                if (chk_rs160.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs161').checked = false;
                                                                    document.getElementById('chk_rs160').disabled = true;
                                                                    document.getElementById('chk_rs161').disabled = false;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs161').disabled = true;
                                                                    document.getElementById('chk_rs160').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs170() {
                                                                if (chk_rs170.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs171').checked = false;
                                                                    document.getElementById('chk_rs170').disabled = true;
                                                                    document.getElementById('chk_rs171').disabled = false;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs171').disabled = true;
                                                                    document.getElementById('chk_rs170').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs180() {
                                                                if (chk_rs180.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs181').checked = false;
                                                                    document.getElementById('chk_rs180').disabled = true;
                                                                    document.getElementById('chk_rs181').disabled = false;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs181').disabled = true;
                                                                    document.getElementById('chk_rs180').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs190() {
                                                                if (chk_rs190.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs191').checked = false;
                                                                    document.getElementById('chk_rs190').disabled = true;
                                                                    document.getElementById('chk_rs191').disabled = false;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs191').disabled = true;
                                                                    document.getElementById('chk_rs190').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs1100() {
                                                                if (chk_rs1100.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs1101').checked = false;
                                                                    document.getElementById('chk_rs1100').disabled = true;
                                                                    document.getElementById('chk_rs1101').disabled = false;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs1101').disabled = true;
                                                                    document.getElementById('chk_rs1100').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs1110() {
                                                                if (chk_rs1110.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs1111').checked = false;
                                                                    document.getElementById('chk_rs1110').disabled = true;
                                                                    document.getElementById('chk_rs1111').disabled = false;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs1111').disabled = true;
                                                                    document.getElementById('chk_rs1110').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs1120() {
                                                                if (chk_rs1120.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs1121').checked = false;
                                                                    document.getElementById('chk_rs1120').disabled = true;
                                                                    document.getElementById('chk_rs1121').disabled = false;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs1121').disabled = true;
                                                                    document.getElementById('chk_rs1120').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs1130() {
                                                                if (chk_rs1130.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs1131').checked = false;
                                                                    document.getElementById('chk_rs1130').disabled = true;
                                                                    document.getElementById('chk_rs1131').disabled = false;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs1131').disabled = true;
                                                                    document.getElementById('chk_rs1130').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs1140() {
                                                                if (chk_rs1140.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs1141').checked = false;
                                                                    document.getElementById('chk_rs1140').disabled = true;
                                                                    document.getElementById('chk_rs1141').disabled = false;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs1141').disabled = true;
                                                                    document.getElementById('chk_rs1140').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs1150() {
                                                                if (chk_rs1150.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs1151').checked = false;
                                                                    document.getElementById('chk_rs1150').disabled = true;
                                                                    document.getElementById('chk_rs1151').disabled = false;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs1151').disabled = true;
                                                                    document.getElementById('chk_rs1150').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs1160() {
                                                                if (chk_rs1160.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs1161').checked = false;
                                                                    document.getElementById('chk_rs1160').disabled = true;
                                                                    document.getElementById('chk_rs1161').disabled = false;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs1161').disabled = true;
                                                                    document.getElementById('chk_rs1160').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs1170() {
                                                                if (chk_rs1170.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs1171').checked = false;
                                                                    document.getElementById('chk_rs1170').disabled = true;
                                                                    document.getElementById('chk_rs1171').disabled = false;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs1171').disabled = true;
                                                                    document.getElementById('chk_rs1170').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs1180() {
                                                                if (chk_rs1180.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs1181').checked = false;
                                                                    document.getElementById('chk_rs1180').disabled = true;
                                                                    document.getElementById('chk_rs1181').disabled = false;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs1181').disabled = true;
                                                                    document.getElementById('chk_rs1180').disabled = false;
                                                                }


                                                            }
                                                            function edit_rs1190() {
                                                                if (chk_rs1190.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs1191').checked = false;
                                                                    document.getElementById('chk_rs1190').disabled = true;
                                                                    document.getElementById('chk_rs1191').disabled = false;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs1191').disabled = true;
                                                                    document.getElementById('chk_rs1190').disabled = false;
                                                                }


                                                            }
                                                            function edit_rs111() {
                                                                if (chk_rs111.checked == true)
                                                                {


                                                                    document.getElementById('chk_rs110').checked = false;
                                                                    document.getElementById('chk_rs110').disabled = false;
                                                                    document.getElementById('chk_rs111').disabled = true;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs110').disabled = true;
                                                                    document.getElementById('chk_rs111').disabled = false;
                                                                }


                                                            }
                                                            function edit_rs121() {
                                                                if (chk_rs121.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs120').checked = false;
                                                                    document.getElementById('chk_rs120').disabled = false;
                                                                    document.getElementById('chk_rs121').disabled = true;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs120').disabled = true;
                                                                    document.getElementById('chk_rs121').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs131() {
                                                                if (chk_rs131.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs130').checked = false;
                                                                    document.getElementById('chk_rs130').disabled = false;
                                                                    document.getElementById('chk_rs131').disabled = true;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs130').disabled = true;
                                                                    document.getElementById('chk_rs131').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs141() {
                                                                if (chk_rs141.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs140').checked = false;
                                                                    document.getElementById('chk_rs140').disabled = false;
                                                                    document.getElementById('chk_rs141').disabled = true;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs140').disabled = true;
                                                                    document.getElementById('chk_rs141').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs151() {
                                                                if (chk_rs151.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs150').checked = false;
                                                                    document.getElementById('chk_rs150').disabled = false;
                                                                    document.getElementById('chk_rs151').disabled = true;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs150').disabled = true;
                                                                    document.getElementById('chk_rs151').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs161() {
                                                                if (chk_rs161.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs160').checked = false;
                                                                    document.getElementById('chk_rs160').disabled = false;
                                                                    document.getElementById('chk_rs161').disabled = true;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs160').disabled = true;
                                                                    document.getElementById('chk_rs161').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs171() {
                                                                if (chk_rs171.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs170').checked = false;
                                                                    document.getElementById('chk_rs170').disabled = false;
                                                                    document.getElementById('chk_rs171').disabled = true;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs170').disabled = true;
                                                                    document.getElementById('chk_rs171').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs181() {
                                                                if (chk_rs181.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs180').checked = false;
                                                                    document.getElementById('chk_rs180').disabled = false;
                                                                    document.getElementById('chk_rs181').disabled = true;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs180').disabled = true;
                                                                    document.getElementById('chk_rs181').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs191() {
                                                                if (chk_rs191.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs190').checked = false;
                                                                    document.getElementById('chk_rs190').disabled = false;
                                                                    document.getElementById('chk_rs191').disabled = true;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs190').disabled = true;
                                                                    document.getElementById('chk_rs191').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs1101() {
                                                                if (chk_rs1101.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs1100').checked = false;
                                                                    document.getElementById('chk_rs1100').disabled = false;
                                                                    document.getElementById('chk_rs1101').disabled = true;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs1100').disabled = true;
                                                                    document.getElementById('chk_rs1101').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs1111() {
                                                                if (chk_rs1111.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs1110').checked = false;
                                                                    document.getElementById('chk_rs1110').disabled = false;
                                                                    document.getElementById('chk_rs1111').disabled = true;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs1110').disabled = true;
                                                                    document.getElementById('chk_rs1111').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs1121() {
                                                                if (chk_rs1121.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs1120').checked = false;
                                                                    document.getElementById('chk_rs1120').disabled = false;
                                                                    document.getElementById('chk_rs1121').disabled = true;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs1120').disabled = true;
                                                                    document.getElementById('chk_rs1121').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs1131() {
                                                                if (chk_rs1131.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs1130').checked = false;
                                                                    document.getElementById('chk_rs1130').disabled = false;
                                                                    document.getElementById('chk_rs1131').disabled = true;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs1130').disabled = true;
                                                                    document.getElementById('chk_rs1131').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs1141() {
                                                                if (chk_rs1141.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs1140').checked = false;
                                                                    document.getElementById('chk_rs1140').disabled = false;
                                                                    document.getElementById('chk_rs1141').disabled = true;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs1140').disabled = true;
                                                                    document.getElementById('chk_rs1141').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs1151() {
                                                                if (chk_rs1151.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs1150').checked = false;
                                                                    document.getElementById('chk_rs1150').disabled = false;
                                                                    document.getElementById('chk_rs1151').disabled = true;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs1150').disabled = true;
                                                                    document.getElementById('chk_rs1151').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs1161() {
                                                                if (chk_rs1161.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs1160').checked = false;
                                                                    document.getElementById('chk_rs1160').disabled = false;
                                                                    document.getElementById('chk_rs1161').disabled = true;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs1160').disabled = true;
                                                                    document.getElementById('chk_rs1161').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs1171() {
                                                                if (chk_rs1171.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs1170').checked = false;
                                                                    document.getElementById('chk_rs1170').disabled = false;
                                                                    document.getElementById('chk_rs1171').disabled = true;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs1170').disabled = true;
                                                                    document.getElementById('chk_rs1171').disabled = false;
                                                                }

                                                            }
                                                            function edit_rs1181() {
                                                                if (chk_rs1181.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs1180').checked = false;
                                                                    document.getElementById('chk_rs1180').disabled = false;
                                                                    document.getElementById('chk_rs1181').disabled = true;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs1180').disabled = true;
                                                                    document.getElementById('chk_rs1181').disabled = false;
                                                                }


                                                            }
                                                            function edit_rs1191() {
                                                                if (chk_rs1191.checked == true)
                                                                {

                                                                    document.getElementById('chk_rs1190').checked = false;
                                                                    document.getElementById('chk_rs1190').disabled = false;
                                                                    document.getElementById('chk_rs1191').disabled = true;
                                                                } else
                                                                {

                                                                    document.getElementById('chk_rs1190').disabled = true;
                                                                    document.getElementById('chk_rs1191').disabled = false;
                                                                }


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


            });
        });
    </script>
    <script>
        function edit_tenkoriskychk(editableObj, fieldname, ID)
        {

            $.ajax({
                url: 'meg_data.php',
                type: 'POST',
                data: {
                    txt_flg: "edit_tenkorisky", editableObj: editableObj, ID: ID, fieldname: fieldname
                },
                success: function () {

                }
            });
        }
        function edit_tenkoafterchk(editableObj, fieldname, ID)
        {

            $.ajax({
                url: 'meg_data.php',
                type: 'POST',
                data: {
                    txt_flg: "edit_tenkoafter", editableObj: editableObj, ID: ID, fieldname: fieldname
                },
                success: function () {

                }
            });
        }
        function rs_rsdirvertransport1()
        {
            if (
                    document.getElementById("TXT_TENKOLOADRESTRESULT0").value == 'x'
                    || document.getElementById("TXT_TENKOLOADRESTRESULT1").value == 'x'
                    || document.getElementById("TXT_TENKOLOADRESTRESULT2").value == 'x'
                    || document.getElementById("TXT_TENKOLOADRESTRESULT3").value == 'x'
                    || document.getElementById("TXT_TENKOLOADRESTRESULT4").value == 'x'
                    || document.getElementById("TXT_TENKOLOADRESTRESULT5").value == 'x'
                    || document.getElementById("TXT_TENKOLOADRESTRESULT6").value == 'x'
                    || document.getElementById("TXT_TENKOBODYSLEEPYRESULT0").value == 'x'
                    || document.getElementById("TXT_TENKOBODYSLEEPYRESULT1").value == 'x'
                    || document.getElementById("TXT_TENKOBODYSLEEPYRESULT2").value == 'x'
                    || document.getElementById("TXT_TENKOBODYSLEEPYRESULT3").value == 'x'
                    || document.getElementById("TXT_TENKOBODYSLEEPYRESULT4").value == 'x'
                    || document.getElementById("TXT_TENKOBODYSLEEPYRESULT5").value == 'x'
                    || document.getElementById("TXT_TENKOBODYSLEEPYRESULT6").value == 'x'
                    || document.getElementById("TXT_TENKOCARNEWRESULT0").value == 'x'
                    || document.getElementById("TXT_TENKOCARNEWRESULT1").value == 'x'
                    || document.getElementById("TXT_TENKOCARNEWRESULT2").value == 'x'
                    || document.getElementById("TXT_TENKOCARNEWRESULT3").value == 'x'
                    || document.getElementById("TXT_TENKOCARNEWRESULT4").value == 'x'
                    || document.getElementById("TXT_TENKOCARNEWRESULT5").value == 'x'
                    || document.getElementById("TXT_TENKOCARNEWRESULT6").value == 'x'
                    || document.getElementById("TXT_TENKOTRAILERRESULT0").value == 'x'
                    || document.getElementById("TXT_TENKOTRAILERRESULT1").value == 'x'
                    || document.getElementById("TXT_TENKOTRAILERRESULT2").value == 'x'
                    || document.getElementById("TXT_TENKOTRAILERRESULT3").value == 'x'
                    || document.getElementById("TXT_TENKOTRAILERRESULT4").value == 'x'
                    || document.getElementById("TXT_TENKOTRAILERRESULT5").value == 'x'
                    || document.getElementById("TXT_TENKOTRAILERRESULT6").value == 'x'
                    || document.getElementById("TXT_TENKOROADRESULT0").value == 'x'
                    || document.getElementById("TXT_TENKOROADRESULT1").value == 'x'
                    || document.getElementById("TXT_TENKOROADRESULT2").value == 'x'
                    || document.getElementById("TXT_TENKOROADRESULT3").value == 'x'
                    || document.getElementById("TXT_TENKOROADRESULT4").value == 'x'
                    || document.getElementById("TXT_TENKOROADRESULT5").value == 'x'
                    || document.getElementById("TXT_TENKOROADRESULT6").value == 'x'
                    || document.getElementById("TXT_TENKOAIRRESULT0").value == 'x'
                    || document.getElementById("TXT_TENKOAIRRESULT1").value == 'x'
                    || document.getElementById("TXT_TENKOAIRRESULT2").value == 'x'
                    || document.getElementById("TXT_TENKOAIRRESULT3").value == 'x'
                    || document.getElementById("TXT_TENKOAIRRESULT4").value == 'x'
                    || document.getElementById("TXT_TENKOAIRRESULT5").value == 'x'
                    || document.getElementById("TXT_TENKOAIRRESULT6").value == 'x'
                    || document.getElementById("TXT_TENKOSLEEPYRESULT0").value == 'x'
                    || document.getElementById("TXT_TENKOSLEEPYRESULT1").value == 'x'
                    || document.getElementById("TXT_TENKOSLEEPYRESULT2").value == 'x'
                    || document.getElementById("TXT_TENKOSLEEPYRESULT3").value == 'x'
                    || document.getElementById("TXT_TENKOSLEEPYRESULT4").value == 'x'
                    || document.getElementById("TXT_TENKOSLEEPYRESULT5").value == 'x'
                    || document.getElementById("TXT_TENKOSLEEPYRESULT6").value == 'x'

                    || document.getElementById("TXT_TENKOLOADRESTRESULT0").value == ''
                    || document.getElementById("TXT_TENKOLOADRESTRESULT1").value == ''
                    || document.getElementById("TXT_TENKOLOADRESTRESULT2").value == ''
                    || document.getElementById("TXT_TENKOLOADRESTRESULT3").value == ''
                    || document.getElementById("TXT_TENKOLOADRESTRESULT4").value == ''
                    || document.getElementById("TXT_TENKOLOADRESTRESULT5").value == ''
                    || document.getElementById("TXT_TENKOLOADRESTRESULT6").value == ''
                    || document.getElementById("TXT_TENKOBODYSLEEPYRESULT0").value == ''
                    || document.getElementById("TXT_TENKOBODYSLEEPYRESULT1").value == ''
                    || document.getElementById("TXT_TENKOBODYSLEEPYRESULT2").value == ''
                    || document.getElementById("TXT_TENKOBODYSLEEPYRESULT3").value == ''
                    || document.getElementById("TXT_TENKOBODYSLEEPYRESULT4").value == ''
                    || document.getElementById("TXT_TENKOBODYSLEEPYRESULT5").value == ''
                    || document.getElementById("TXT_TENKOBODYSLEEPYRESULT6").value == ''
                    || document.getElementById("TXT_TENKOCARNEWRESULT0").value == ''
                    || document.getElementById("TXT_TENKOCARNEWRESULT1").value == ''
                    || document.getElementById("TXT_TENKOCARNEWRESULT2").value == ''
                    || document.getElementById("TXT_TENKOCARNEWRESULT3").value == ''
                    || document.getElementById("TXT_TENKOCARNEWRESULT4").value == ''
                    || document.getElementById("TXT_TENKOCARNEWRESULT5").value == ''
                    || document.getElementById("TXT_TENKOCARNEWRESULT6").value == ''
                    || document.getElementById("TXT_TENKOTRAILERRESULT0").value == ''
                    || document.getElementById("TXT_TENKOTRAILERRESULT1").value == ''
                    || document.getElementById("TXT_TENKOTRAILERRESULT2").value == ''
                    || document.getElementById("TXT_TENKOTRAILERRESULT3").value == ''
                    || document.getElementById("TXT_TENKOTRAILERRESULT4").value == ''
                    || document.getElementById("TXT_TENKOTRAILERRESULT5").value == ''
                    || document.getElementById("TXT_TENKOTRAILERRESULT6").value == ''
                    || document.getElementById("TXT_TENKOROADRESULT0").value == ''
                    || document.getElementById("TXT_TENKOROADRESULT1").value == ''
                    || document.getElementById("TXT_TENKOROADRESULT2").value == ''
                    || document.getElementById("TXT_TENKOROADRESULT3").value == ''
                    || document.getElementById("TXT_TENKOROADRESULT4").value == ''
                    || document.getElementById("TXT_TENKOROADRESULT5").value == ''
                    || document.getElementById("TXT_TENKOROADRESULT6").value == ''
                    || document.getElementById("TXT_TENKOAIRRESULT0").value == ''
                    || document.getElementById("TXT_TENKOAIRRESULT1").value == ''
                    || document.getElementById("TXT_TENKOAIRRESULT2").value == ''
                    || document.getElementById("TXT_TENKOAIRRESULT3").value == ''
                    || document.getElementById("TXT_TENKOAIRRESULT4").value == ''
                    || document.getElementById("TXT_TENKOAIRRESULT5").value == ''
                    || document.getElementById("TXT_TENKOAIRRESULT6").value == ''
                    || document.getElementById("TXT_TENKOSLEEPYRESULT0").value == ''
                    || document.getElementById("TXT_TENKOSLEEPYRESULT1").value == ''
                    || document.getElementById("TXT_TENKOSLEEPYRESULT2").value == ''
                    || document.getElementById("TXT_TENKOSLEEPYRESULT3").value == ''
                    || document.getElementById("TXT_TENKOSLEEPYRESULT4").value == ''
                    || document.getElementById("TXT_TENKOSLEEPYRESULT5").value == ''
                    || document.getElementById("TXT_TENKOSLEEPYRESULT6").value == ''


                    )
            {

                document.getElementById('icon_transportrsno1').style.display = "";
                document.getElementById('icon_transportrsok1').style.display = "none";
            } else
            {

                document.getElementById('icon_transportrsno1').style.display = "none";
                document.getElementById('icon_transportrsok1').style.display = "";
            }
        }



        function edit_tenkobeforetxt1()
        {
            if (document.getElementById("txt_rs14").value != "")
            {
                if (document.getElementById("txt_rs14").value.substring(0, 2) < 8)
                {
                    document.getElementById("chk_rs140").checked = true;
                    document.getElementById("chk_rs141").checked = false;
                } else
                {
                    document.getElementById("chk_rs141").checked = true;
                    document.getElementById("chk_rs140").checked = false;
                }
                document.getElementById("chk_14").checked = true;
            } else
            {
                document.getElementById("chk_14").checked = false;
                document.getElementById("chk_rs140").checked = true;
                document.getElementById("chk_rs141").checked = false;
            }

        }
        function edit_tenkobeforetxt2()
        {


            if (document.getElementById("txt_rs151").value != "")
            {
                if (document.getElementById("cb_changeka").value != "")
                {

                    if (document.getElementById("txt_rs151").value < 6)
                    {
                        document.getElementById("chk_rs150").checked = true;
                        document.getElementById("chk_rs151").checked = false;
                    } else
                    {
                        document.getElementById("chk_rs151").checked = true;
                        document.getElementById("chk_rs150").checked = false;
                    }
                } else
                {
                    if (document.getElementById("txt_rs151").value < 6)
                    {

                        document.getElementById("chk_rs150").checked = true;
                        document.getElementById("chk_rs151").checked = false;
                    } else
                    {

                        document.getElementById("chk_rs151").checked = true;
                        document.getElementById("chk_rs150").checked = false;
                    }
                }

                document.getElementById("chk_15").checked = true;
            } else
            {
                document.getElementById("chk_15").checked = false;
                document.getElementById("chk_rs150").checked = true;
                document.getElementById("chk_rs151").checked = false;
            }



        }
        function edit_tenkobeforetxt3()
        {



            if (document.getElementById("txt_rs152").value != '')
            {


                if (document.getElementById("txt_rs152").value.substring(0, 2) > 4)
                {

                    document.getElementById("chk_rs151").checked = true;
                    document.getElementById("chk_rs150").checked = false;
                } else
                {
                    if (document.getElementById("txt_rs152").value.substring(0, 2) != '0')
                    {
                        document.getElementById("chk_rs151").checked = false;
                        document.getElementById("chk_rs150").checked = true;
                    } else
                    {

                        document.getElementById("chk_rs151").checked = true;
                        document.getElementById("chk_rs150").checked = false;
                    }
                }
                document.getElementById("chk_15").checked = true;
            } else
            {
                document.getElementById("chk_15").checked = false;
                document.getElementById("chk_rs150").checked = true;
                document.getElementById("chk_rs151").checked = false;
            }




        }
        function edit_tenkobeforetxt4()
        {



            if (document.getElementById("txt_rs16").value != "")
            {
<?php
if ($result_sePlain['COMPANYCODE'] == 'RKS' || $result_sePlain['COMPANYCODE'] == 'RKR' || $result_sePlain['COMPANYCODE'] == 'RKL') {
    ?>
                    if (document.getElementById("txt_rs16").value >= 37)
                    {
                        document.getElementById("chk_rs160").checked = true;
                        document.getElementById("chk_rs161").checked = false;
                    } else
                    {
                        document.getElementById("chk_rs161").checked = true;
                        document.getElementById("chk_rs160").checked = false;
                    }
    <?php
} else {
    ?>
                    if (document.getElementById("txt_rs16").value >= 38)
                    {
                        document.getElementById("chk_rs160").checked = true;
                        document.getElementById("chk_rs161").checked = false;
                    } else
                    {
                        document.getElementById("chk_rs161").checked = true;
                        document.getElementById("chk_rs160").checked = false;
                    }
    <?php
}
?>
                document.getElementById("chk_16").checked = true;
            } else
            {
                document.getElementById("chk_16").checked = false;
                document.getElementById("chk_rs160").checked = true;
                document.getElementById("chk_rs161").checked = false;
            }





        }
        function edit_tenkobeforetxt5()
        {






            if (document.getElementById("txt_rs171").value != "")
            {
<?php
if ($result_sePlain['COMPANYCODE'] == 'RKS' || $result_sePlain['COMPANYCODE'] == 'RKR' || $result_sePlain['COMPANYCODE'] == 'RKL') {
    ?>
                    if ((document.getElementById("txt_rs171").value >= 90 && document.getElementById("txt_rs171").value <= 140 && document.getElementById("txt_rs172").value >= 60 && document.getElementById("txt_rs172").value <= 100) && (document.getElementById('txt_rs173').value > 54 && document.getElementById('txt_rs173').value < 101))
                    {

                        document.getElementById("chk_rs170").checked = false;
                        document.getElementById("chk_rs171").checked = true;
                    } else
                    {

                        document.getElementById("chk_rs171").checked = false;
                        document.getElementById("chk_rs170").checked = true;
                    }
    <?php
} else {
    ?>
                    if ((document.getElementById("txt_rs171").value >= 90 && document.getElementById("txt_rs171").value <= 160 && document.getElementById("txt_rs172").value >= 60 && document.getElementById("txt_rs172").value <= 100))
                    {

                        document.getElementById("chk_rs170").checked = false;
                        document.getElementById("chk_rs171").checked = true;
                    } else
                    {

                        document.getElementById("chk_rs171").checked = false;
                        document.getElementById("chk_rs170").checked = true;
                    }
    <?php
}
?>
                document.getElementById("chk_17").checked = true;
            } else
            {
                document.getElementById("chk_17").checked = false;
                document.getElementById("chk_rs170").checked = true;
                document.getElementById("chk_rs171").checked = false;
            }



        }
        function edit_tenkobeforetxt5_2()
        {




            if (document.getElementById("txt_rs171_2").value != "")
            {
<?php
if ($result_sePlain['COMPANYCODE'] == 'RKS' || $result_sePlain['COMPANYCODE'] == 'RKR' || $result_sePlain['COMPANYCODE'] == 'RKL') {
    ?>
                    if ((document.getElementById("txt_rs171_2").value >= 90 && document.getElementById("txt_rs171_2").value <= 160 && document.getElementById("txt_rs172_2").value >= 60 && document.getElementById("txt_rs172_2").value <= 100) && (document.getElementById('txt_rs173_2').value > 54 && document.getElementById('txt_rs173_2').value < 101))
                    {

                        document.getElementById("chk_rs170").checked = false;
                        document.getElementById("chk_rs171").checked = true;
                    } else
                    {

                        document.getElementById("chk_rs171").checked = false;
                        document.getElementById("chk_rs170").checked = true;
                    }
    <?php
} else {
    ?>
                    if ((document.getElementById("txt_rs171_2").value >= 90 && document.getElementById("txt_rs171_2").value <= 160 && document.getElementById("txt_rs172_2").value >= 60 && document.getElementById("txt_rs172_2").value <= 100))
                    {

                        document.getElementById("chk_rs170").checked = false;
                        document.getElementById("chk_rs171").checked = true;
                    } else
                    {

                        document.getElementById("chk_rs171").checked = false;
                        document.getElementById("chk_rs170").checked = true;
                    }
    <?php
}
?>
                document.getElementById("chk_17").checked = true;
            } else
            {
                document.getElementById("chk_17").checked = false;
                document.getElementById("chk_rs170").checked = true;
                document.getElementById("chk_rs171").checked = false;
            }



        }
        function edit_tenkobeforetxt5_3()
        {






            if (document.getElementById("txt_rs171_3").value != "")
            {

                if ((document.getElementById("txt_rs171_2").value >= 90 && document.getElementById("txt_rs171_2").value <= 140 && document.getElementById("txt_rs172_2").value >= 60 && document.getElementById("txt_rs172_2").value <= 90) && (document.getElementById('txt_rs173_2').value > 59 && document.getElementById('txt_rs173_2').value < 101))
                {

                    document.getElementById("chk_rs170").checked = false;
                    document.getElementById("chk_rs171").checked = true;
                } else
                {

                    document.getElementById("chk_rs171").checked = false;
                    document.getElementById("chk_rs170").checked = true;
                }
                document.getElementById("chk_17").checked = true;
            } else
            {
                document.getElementById("chk_17").checked = false;
                document.getElementById("chk_rs170").checked = true;
                document.getElementById("chk_rs171").checked = false;
            }



        }
        function edit_tenkobeforetxt6()
        {


            if (document.getElementById("txt_rs172").value != "")
            {
<?php
if ($result_sePlain['COMPANYCODE'] == 'RKS' || $result_sePlain['COMPANYCODE'] == 'RKR' || $result_sePlain['COMPANYCODE'] == 'RKL') {
    ?>
                    if ((document.getElementById("txt_rs171").value >= 90 && document.getElementById("txt_rs171").value <= 140) && (document.getElementById("txt_rs172").value >= 60 && document.getElementById("txt_rs172").value <= 90) && (document.getElementById('txt_rs173').value > 59 && document.getElementById('txt_rs173').value < 101))
                    {
                        document.getElementById("chk_rs170").checked = false;
                        document.getElementById("chk_rs171").checked = true;
                    } else
                    {
                        document.getElementById("chk_rs171").checked = false;
                        document.getElementById("chk_rs170").checked = true;
                    }
    <?php
} else {
    ?>
                    if ((document.getElementById("txt_rs171").value >= 90 && document.getElementById("txt_rs171").value <= 140) && (document.getElementById("txt_rs172").value >= 60 && document.getElementById("txt_rs172").value <= 90))
                    {
                        document.getElementById("chk_rs170").checked = false;
                        document.getElementById("chk_rs171").checked = true;
                    } else
                    {
                        document.getElementById("chk_rs171").checked = false;
                        document.getElementById("chk_rs170").checked = true;
                    }
    <?php
}
?>
                document.getElementById("chk_17").checked = true;
            } else
            {
                document.getElementById("chk_17").checked = false;
                document.getElementById("chk_rs170").checked = true;
                document.getElementById("chk_rs171").checked = false;
            }




        }
        function edit_tenkobeforetxt6_2()
        {




            if (document.getElementById("txt_rs171_2").value != "")
            {
<?php
if ($result_sePlain['COMPANYCODE'] == 'RKS' || $result_sePlain['COMPANYCODE'] == 'RKR' || $result_sePlain['COMPANYCODE'] == 'RKL') {
    ?>
                    if ((document.getElementById("txt_rs171_2").value >= 90 && document.getElementById("txt_rs171_2").value <= 140 && document.getElementById("txt_rs172_2").value >= 60 && document.getElementById("txt_rs172_2").value <= 90) && (document.getElementById('txt_rs173_2').value > 59 && document.getElementById('txt_rs173_2').value < 101))
                    {

                        document.getElementById("chk_rs170").checked = false;
                        document.getElementById("chk_rs171").checked = true;
                    } else
                    {

                        document.getElementById("chk_rs171").checked = false;
                        document.getElementById("chk_rs170").checked = true;
                    }
    <?php
} else {
    ?>
                    if ((document.getElementById("txt_rs171_2").value >= 90 && document.getElementById("txt_rs171_2").value <= 140 && document.getElementById("txt_rs172_2").value >= 60 && document.getElementById("txt_rs172_2").value <= 90))
                    {

                        document.getElementById("chk_rs170").checked = false;
                        document.getElementById("chk_rs171").checked = true;
                    } else
                    {

                        document.getElementById("chk_rs171").checked = false;
                        document.getElementById("chk_rs170").checked = true;
                    }
    <?php
}
?>
                document.getElementById("chk_17").checked = true;
            } else
            {
                document.getElementById("chk_17").checked = false;
                document.getElementById("chk_rs170").checked = true;
                document.getElementById("chk_rs171").checked = false;
            }



        }
        function edit_tenkobeforetxt6_3()
        {




            if (document.getElementById("txt_rs171_3").value != "")
            {

                if ((document.getElementById("txt_rs171_3").value >= 90 && document.getElementById("txt_rs171_3").value <= 140 && document.getElementById("txt_rs172_3").value >= 60 && document.getElementById("txt_rs172_3").value <= 90) && (document.getElementById('txt_rs173_3').value > 59 && document.getElementById('txt_rs173_3').value < 101))
                {

                    document.getElementById("chk_rs170").checked = false;
                    document.getElementById("chk_rs171").checked = true;
                } else
                {

                    document.getElementById("chk_rs171").checked = false;
                    document.getElementById("chk_rs170").checked = true;
                }
                document.getElementById("chk_17").checked = true;
            } else
            {
                document.getElementById("chk_17").checked = false;
                document.getElementById("chk_rs170").checked = true;
                document.getElementById("chk_rs171").checked = false;
            }


        }
        function edit_tenkobeforetxt20()
        {



            if (document.getElementById("txt_rs172").value != "")
            {

                if ((document.getElementById("txt_rs171").value >= 90 && document.getElementById("txt_rs171").value <= 140) && (document.getElementById("txt_rs172").value >= 60 && document.getElementById("txt_rs172").value <= 90) && (document.getElementById('txt_rs173').value > 59 && document.getElementById('txt_rs173').value < 101))
                {
                    document.getElementById("chk_rs170").checked = false;
                    document.getElementById("chk_rs171").checked = true;
                } else
                {
                    document.getElementById("chk_rs171").checked = false;
                    document.getElementById("chk_rs170").checked = true;
                }
                document.getElementById("chk_17").checked = true;
            } else
            {
                document.getElementById("chk_17").checked = false;
                document.getElementById("chk_rs170").checked = true;
                document.getElementById("chk_rs171").checked = false;
            }




        }
        function edit_tenkobeforetxt20_2()
        {



            if (document.getElementById("txt_rs171_2").value != "")
            {

                if ((document.getElementById("txt_rs171_2").value >= 90 && document.getElementById("txt_rs171_2").value <= 140 && document.getElementById("txt_rs172_2").value >= 60 && document.getElementById("txt_rs172_2").value <= 90) && (document.getElementById('txt_rs173_2').value > 59 && document.getElementById('txt_rs173_2').value < 101))
                {

                    document.getElementById("chk_rs170").checked = false;
                    document.getElementById("chk_rs171").checked = true;
                } else
                {

                    document.getElementById("chk_rs171").checked = false;
                    document.getElementById("chk_rs170").checked = true;
                }
                document.getElementById("chk_17").checked = true;
            } else
            {
                document.getElementById("chk_17").checked = false;
                document.getElementById("chk_rs170").checked = true;
                document.getElementById("chk_rs171").checked = false;
            }


        }
        function edit_tenkobeforetxt20_3()
        {



            if (document.getElementById("txt_rs171_3").value != "")
            {

                if ((document.getElementById("txt_rs171_2").value >= 90 && document.getElementById("txt_rs171_2").value <= 140 && document.getElementById("txt_rs172_2").value >= 60 && document.getElementById("txt_rs172_2").value <= 90) && (document.getElementById('txt_rs173_2').value > 59 && document.getElementById('txt_rs173_2').value < 101))
                {

                    document.getElementById("chk_rs170").checked = false;
                    document.getElementById("chk_rs171").checked = true;
                } else
                {

                    document.getElementById("chk_rs171").checked = false;
                    document.getElementById("chk_rs170").checked = true;
                }
                document.getElementById("chk_17").checked = true;
            } else
            {
                document.getElementById("chk_17").checked = false;
                document.getElementById("chk_rs170").checked = true;
                document.getElementById("chk_rs171").checked = false;
            }



        }
        function edit_tenkobeforetxt7()
        {


            if (document.getElementById("txt_rs18").value != "")
            {
                if (document.getElementById("txt_rs18").value != '0')
                {
                    document.getElementById("chk_rs180").checked = true;
                    document.getElementById("chk_rs181").checked = false;
                } else
                {
                    document.getElementById("chk_rs181").checked = true;
                    document.getElementById("chk_rs180").checked = false;
                }
                document.getElementById("chk_18").checked = true;
            } else
            {
                document.getElementById("chk_18").checked = false;
                document.getElementById("chk_rs180").checked = true;
                document.getElementById("chk_rs181").checked = false;
            }



        }
        function edit_tenkobeforetxt8()
        {


            if (document.getElementById("txt_rs19").value != "")
            {
                if (document.getElementById("txt_rs19").value > 95 && document.getElementById("txt_rs19").value < 100)
                {

                    document.getElementById("chk_rs1191").checked = true;
                    document.getElementById("chk_rs1190").checked = false;
                    document.getElementById("chk_119").checked = true;
                }
            } else
            {

                document.getElementById("chk_119").checked = false;
                document.getElementById("chk_rs1190").checked = true;
                document.getElementById("chk_rs1191").checked = false;
            }




        }




        function edit_tenkogps(editableObj, fieldname, ID)
        {
            var dataedit = editableObj.innerHTML;
            $.ajax({
                url: 'meg_data.php',
                type: 'POST',
                data: {
                    txt_flg: "edit_tenkogps", editableObj: dataedit, ID: ID, fieldname: fieldname
                },
                success: function () {

                }
            });
        }
        function edit_tenkorisky(editableObj, fieldname, ID)
        {
            var dataedit = editableObj.innerHTML;
            $.ajax({
                url: 'meg_data.php',
                type: 'POST',
                data: {
                    txt_flg: "edit_tenkorisky", editableObj: dataedit, ID: ID, fieldname: fieldname
                },
                success: function () {

                }
            });
        }
        function edit_tenkoafter(editableObj, fieldname, ID)
        {
            var dataedit = editableObj.innerHTML;
            $.ajax({
                url: 'meg_data.php',
                type: 'POST',
                data: {
                    txt_flg: "edit_tenkoafter", editableObj: dataedit, ID: ID, fieldname: fieldname
                },
                success: function () {

                }
            });
        }


        function edit_tenkotransportchk(editableObj, fieldname, ID, tenkotransportdate)
        {

            $.ajax({
                url: 'meg_data.php',
                type: 'POST',
                data: {
                    txt_flg: "edit_tenkotransport", editableObj: editableObj, ID: ID, fieldname: fieldname, tenkotransportdate: tenkotransportdate, updateby: '<?= $result_seEmployee["PersonCode"] ?>'
                },
                success: function () {


                }
            });
        }
        function edit_tenkotransporttime(editableObj, fieldname, ID, tenkotransportdate)
        {

            $.ajax({
                url: 'meg_data.php',
                type: 'POST',
                data: {
                    txt_flg: "edit_tenkotransport", editableObj: editableObj, ID: ID, fieldname: fieldname, tenkotransportdate: tenkotransportdate, updateby: '<?= $result_seEmployee["PersonCode"] ?>'
                },
                success: function () {

                }
            });
        }
        function edit_tenkotransport(editableObj, fieldname, ID, tenkotransportdate)
        {

            var dataedit = editableObj.innerHTML;
            $.ajax({
                url: 'meg_data.php',
                type: 'POST',
                data: {
                    txt_flg: "edit_tenkotransport", editableObj: dataedit, ID: ID, fieldname: fieldname, tenkotransportdate: tenkotransportdate, updateby: '<?= $result_seEmployee["PersonCode"] ?>'
                },
                success: function () {

                }
            });
        }

        function editvalue_tenkotransport(editableObj, fieldname, ID, tenkotransportdate)
        {

            /* alert(editableObj);
             alert(fieldname);
             alert(ID);
             alert(tenkotransportdate); */

            $.ajax({
                url: 'meg_data.php',
                type: 'POST',
                data: {
                    txt_flg: "edit_tenkotransport", editableObj: editableObj, ID: ID, fieldname: fieldname, tenkotransportdate: tenkotransportdate, updateby: '<?= $result_seEmployee["PersonCode"] ?>'
                },
                success: function () {

                    rs_rsdirvertransport1();
                }
            });
        }
        function save_tenkomasterdriver(tenkomasterid)
        {

            var vehicleregisnumber = "";
            var jobstart = "";
            var jobend1 = "";
            var jobend2 = "";
            var dayone = "";
            var target1 = "";
            var target2 = "";
            var target3 = "";
            var target4 = "";
            var target5 = "";
            var target6 = "";
            var target7 = "";
            var vehicletransportplanid = '<?= $_GET['vehicletransportplanid'] ?>';
            var changeka = document.getElementById('cb_changeka').value;
            var status = document.getElementById('cb_status').value;
            var remark1 = document.getElementById('txt_remark1').value;
            //var remark2 = document.getElementById('txt_remark2').value;








            if (chk_dayone.checked == true) {
                dayone = "1";
            }
            if (chk_target1.checked == true) {
                target1 = "1";
            } else
            {
                target1 = "0";
            }
            if (chk_target2.checked == true) {
                target2 = "1";
            } else
            {
                target2 = "0";
            }
            if (chk_target3.checked == true) {
                target3 = "1";
            } else
            {
                target3 = "0";
            }
            if (chk_target4.checked == true) {
                target4 = "1";
            } else
            {
                target4 = "0";
            }
            if (chk_target5.checked == true) {
                target5 = "1";
            } else
            {
                target5 = "0";
            }
            if (chk_target6.checked == true) {
                target6 = "1";
            } else
            {
                target6 = "0";
            }
            if (chk_target7.checked == true) {
                target7 = "1";
            } else
            {
                target7 = "0";
            }



            $.ajax({
                type: 'post',
                url: 'meg_data.php',
                data: {
                    txt_flg: "update_tenkomasterdriver",
                    tenkomasterid: tenkomasterid,
                    vehicletransportplanid: vehicletransportplanid,
                    changeka: changeka,
                    status: status,
                    remark1: remark1,
                    remark2: '',
                    vehicleregisnumber: vehicleregisnumber,
                    jobstart: jobstart,
                    jobend1: jobend1,
                    jobend2: jobend2,
                    dayone: dayone,
                    target1: target1,
                    target2: target2,
                    target3: target3,
                    target4: target4,
                    target5: target5,
                    target6: target6,
                    target7: target7

                },
                success: function (response) {
                    if ('<?= $_GET['employeecode2'] ?>' != '')
                    {
                        edit_tenkobefore2();
                    } else
                    {

                        window.location.reload();

                    }

                }
            });
        }


        function edit_tenkobefore2()
        {
            var TENKOBEFOREGREETCHECK = (chk_11.checked == true) ? '1' : '';
            var TENKOUNIFORMCHECK = (chk_12.checked == true) ? '1' : '';
            var TENKOBODYCHECK = (chk_13.checked == true) ? '1' : '';
            var TENKORESTCHECK = (chk_14.checked == true) ? '1' : '';
            var TENKOSLEEPTIMECHECK = (chk_15.checked == true) ? '1' : '';
            var TENKOTEMPERATURECHECK = (chk_16.checked == true) ? '1' : '';
            var TENKOPRESSURECHECK = (chk_17.checked == true) ? '1' : '';
            var TENKOALCOHOLCHECK = (chk_18.checked == true) ? '1' : '';
            var TENKOWORRYCHECK = (chk_19.checked == true) ? '1' : '';
            var TENKODAILYTRAILERCHECK = (chk_110.checked == true) ? '1' : '';
            var TENKOCARRYCHECK = (chk_111.checked == true) ? '1' : '';
            var TENKOJOBDETAILCHECK = (chk_112.checked == true) ? '1' : '';
            var TENKOLOADINFORMCHECK = (chk_113.checked == true) ? '1' : '';
            var TENKOAIRINFORMCHECK = (chk_114.checked == true) ? '1' : '';
            var TENKOYOKOTENCHECK = (chk_115.checked == true) ? '1' : '';
            var TENKOCHIMOLATORCHECK = (chk_116.checked == true) ? '1' : '';
            var TENKOTRANSPORTCHECK = (chk_117.checked == true) ? '1' : '';
            var TENKOAFTERGREETCHECK = (chk_118.checked == true) ? '1' : '';
            var TENKOOXYGENCHECK = (chk_119.checked == true) ? '1' : '';
            var TENKOBEFOREGREETRESULT = (chk_rs111.checked == true) ? '1' : '';
            var TENKOUNIFORMRESULT = (chk_rs121.checked == true) ? '1' : '';
            var TENKOBODYRESULT = (chk_rs131.checked == true) ? '1' : '';
            var TENKORESTRESULT = (chk_rs141.checked == true) ? '1' : '';
            var TENKOSLEEPTIMERESULT = (chk_rs151.checked == true) ? '1' : '';
            var TENKOTEMPERATURERESULT = (chk_rs161.checked == true) ? '1' : '';
            var TENKOPRESSURERESULT = (chk_rs171.checked == true) ? '1' : '';
            var TENKOALCOHOLRESULT = (chk_rs181.checked == true) ? '1' : '';
            var TENKOWORRYRESULT = (chk_rs191.checked == true) ? '1' : '';
            var TENKODAILYTRAILERRESULT = (chk_rs1101.checked == true) ? '1' : '';
            var TENKOCARRYRESULT = (chk_rs1111.checked == true) ? '1' : '';
            var TENKOJOBDETAILRESULT = (chk_rs1121.checked == true) ? '1' : '';
            var TENKOLOADINFORMRESULT = (chk_rs1131.checked == true) ? '1' : '';
            var TENKOAIRINFORMRESULT = (chk_rs1141.checked == true) ? '1' : '';
            var TENKOYOKOTENRESULT = (chk_rs1151.checked == true) ? '1' : '';
            var TENKOCHIMOLATORRESULT = (chk_rs1161.checked == true) ? '1' : '';
            var TENKOTRANSPORTRESULT = (chk_rs1171.checked == true) ? '1' : '';
            var TENKOAFTERGREETRESULT = (chk_rs1181.checked == true) ? '1' : '';
            var TENKOOXYGENRESULT = (chk_rs1191.checked == true) ? '1' : '';
            var TENKOBEFOREGREETREMARK = document.getElementById('txt_remark11').value;
            var TENKOUNIFORMREMARK = document.getElementById('txt_remark12').value;
            var TENKOBODYREMARK = document.getElementById('txt_remark13').value;
            var TENKORESTREMARK = document.getElementById('txt_remark14').value;
            var TENKOSLEEPTIMEREMARK = document.getElementById('txt_remark15').value;
            var TENKOTEMPERATUREREMARK = document.getElementById('txt_remark16').value;
            var TENKOPRESSUREREMARK = document.getElementById('txt_remark17').value;
            var TENKOALCOHOLREMARK = document.getElementById('txt_remark18').value;
            var TENKOWORRYREMARK = document.getElementById('txt_remark19').value;
            var TENKODAILYTRAILERREMARK = document.getElementById('txt_remark110').value;
            var TENKOCARRYREMARK = document.getElementById('txt_remark111').value;
            var TENKOJOBDETAILREMARK = document.getElementById('txt_remark112').value;
            var TENKOLOADINFORMREMARK = document.getElementById('txt_remark113').value;
            var TENKOAIRINFORMREMARK = document.getElementById('txt_remark114').value;
            var TENKOYOKOTENREMARK = document.getElementById('txt_remark115').value;
            var TENKOCHIMOLATORREMARK = document.getElementById('txt_remark116').value;
            var TENKOTRANSPORTREMARK = document.getElementById('txt_remark117').value;
            var TENKOAFTERGREETREMARK = document.getElementById('txt_remark118').value;
            var TENKOOXYGENREMARK = document.getElementById('txt_remark119').value;
            var TENKORESTDATA = document.getElementById('txt_rs14').value;
            var TENKOSLEEPTIMEDATA_AFTER6H = document.getElementById('txt_rs151').value;
            var TENKOSLEEPTIMEDATA_ADD45H = document.getElementById('txt_rs152').value;
            var TENKOTEMPERATUREDATA = document.getElementById('txt_rs16').value;
            var TENKOPRESSUREDATA_90160 = document.getElementById('txt_rs171').value;
            var TENKOPRESSUREDATA_90160_2 = document.getElementById('txt_rs171_2').value;
            var TENKOPRESSUREDATA_90160_3 = document.getElementById('txt_rs171_3').value;
            var TENKOPRESSUREDATA_60100 = document.getElementById('txt_rs172').value;
            var TENKOPRESSUREDATA_60100_2 = document.getElementById('txt_rs172_2').value;
            var TENKOPRESSUREDATA_60100_3 = document.getElementById('txt_rs172_3').value;
            var TENKOPRESSUREDATA_60110 = document.getElementById('txt_rs173').value;
            var TENKOPRESSUREDATA_60110_2 = document.getElementById('txt_rs173_2').value;
            var TENKOPRESSUREDATA_60110_3 = document.getElementById('txt_rs173_3').value;
            var TENKOALCOHOLDATA = document.getElementById('txt_rs18').value;
            var TENKOOXYGENDATA = document.getElementById('txt_rs19').value;
            var employeecode = '';

            employeecode = '<?= $result_seTenkobefore2['TENKOBEFOREID'] ?>';



            $.ajax({
                url: 'meg_data.php',
                type: 'POST',
                data: {
                    txt_flg: "edit_tenkobefore2",
                    ID: employeecode,
                    TENKOBEFOREGREETCHECK: TENKOBEFOREGREETCHECK,
                    TENKOUNIFORMCHECK: TENKOUNIFORMCHECK,
                    TENKOBODYCHECK: TENKOBODYCHECK,
                    TENKORESTCHECK: TENKORESTCHECK,
                    TENKOSLEEPTIMECHECK: TENKOSLEEPTIMECHECK,
                    TENKOTEMPERATURECHECK: TENKOTEMPERATURECHECK,
                    TENKOPRESSURECHECK: TENKOPRESSURECHECK,
                    TENKOALCOHOLCHECK: TENKOALCOHOLCHECK,
                    TENKOWORRYCHECK: TENKOWORRYCHECK,
                    TENKODAILYTRAILERCHECK: TENKODAILYTRAILERCHECK,
                    TENKOCARRYCHECK: TENKOCARRYCHECK,
                    TENKOJOBDETAILCHECK: TENKOJOBDETAILCHECK,
                    TENKOLOADINFORMCHECK: TENKOLOADINFORMCHECK,
                    TENKOAIRINFORMCHECK: TENKOAIRINFORMCHECK,
                    TENKOYOKOTENCHECK: TENKOYOKOTENCHECK,
                    TENKOCHIMOLATORCHECK: TENKOCHIMOLATORCHECK,
                    TENKOTRANSPORTCHECK: TENKOTRANSPORTCHECK,
                    TENKOAFTERGREETCHECK: TENKOAFTERGREETCHECK,
                    TENKOOXYGENCHECK: TENKOOXYGENCHECK,
                    TENKOBEFOREGREETRESULT: TENKOBEFOREGREETRESULT,
                    TENKOUNIFORMRESULT: TENKOUNIFORMRESULT,
                    TENKOBODYRESULT: TENKOBODYRESULT,
                    TENKORESTRESULT: TENKORESTRESULT,
                    TENKOSLEEPTIMERESULT: TENKOSLEEPTIMERESULT,
                    TENKOTEMPERATURERESULT: TENKOTEMPERATURERESULT,
                    TENKOPRESSURERESULT: TENKOPRESSURERESULT,
                    TENKOALCOHOLRESULT: TENKOALCOHOLRESULT,
                    TENKOWORRYRESULT: TENKOWORRYRESULT,
                    TENKODAILYTRAILERRESULT: TENKODAILYTRAILERRESULT,
                    TENKOCARRYRESULT: TENKOCARRYRESULT,
                    TENKOJOBDETAILRESULT: TENKOJOBDETAILRESULT,
                    TENKOLOADINFORMRESULT: TENKOLOADINFORMRESULT,
                    TENKOAIRINFORMRESULT: TENKOAIRINFORMRESULT,
                    TENKOYOKOTENRESULT: TENKOYOKOTENRESULT,
                    TENKOCHIMOLATORRESULT: TENKOCHIMOLATORRESULT,
                    TENKOTRANSPORTRESULT: TENKOTRANSPORTRESULT,
                    TENKOAFTERGREETRESULT: TENKOAFTERGREETRESULT,
                    TENKOOXYGENRESULT: TENKOOXYGENRESULT,
                    TENKOBEFOREGREETREMARK: TENKOBEFOREGREETREMARK,
                    TENKOUNIFORMREMARK: TENKOUNIFORMREMARK,
                    TENKOBODYREMARK: TENKOBODYREMARK,
                    TENKORESTREMARK: TENKORESTREMARK,
                    TENKOSLEEPTIMEREMARK: TENKOSLEEPTIMEREMARK,
                    TENKOTEMPERATUREREMARK: TENKOTEMPERATUREREMARK,
                    TENKOPRESSUREREMARK: TENKOPRESSUREREMARK,
                    TENKOALCOHOLREMARK: TENKOALCOHOLREMARK,
                    TENKOWORRYREMARK: TENKOWORRYREMARK,
                    TENKODAILYTRAILERREMARK: TENKODAILYTRAILERREMARK,
                    TENKOCARRYREMARK: TENKOCARRYREMARK,
                    TENKOJOBDETAILREMARK: TENKOJOBDETAILREMARK,
                    TENKOLOADINFORMREMARK: TENKOLOADINFORMREMARK,
                    TENKOAIRINFORMREMARK: TENKOAIRINFORMREMARK,
                    TENKOYOKOTENREMARK: TENKOYOKOTENREMARK,
                    TENKOCHIMOLATORREMARK: TENKOCHIMOLATORREMARK,
                    TENKOTRANSPORTREMARK: TENKOTRANSPORTREMARK,
                    TENKOAFTERGREETREMARK: TENKOAFTERGREETREMARK,
                    TENKOOXYGENREMARK: TENKOOXYGENREMARK,
                    TENKORESTDATA: TENKORESTDATA,
                    TENKOSLEEPTIMEDATA_AFTER6H: TENKOSLEEPTIMEDATA_AFTER6H,
                    TENKOSLEEPTIMEDATA_ADD45H: TENKOSLEEPTIMEDATA_ADD45H,
                    TENKOTEMPERATUREDATA: TENKOTEMPERATUREDATA,
                    TENKOPRESSUREDATA_90160: TENKOPRESSUREDATA_90160,
                    TENKOPRESSUREDATA_90160_2: TENKOPRESSUREDATA_90160_2,
                    TENKOPRESSUREDATA_90160_3: TENKOPRESSUREDATA_90160_3,
                    TENKOPRESSUREDATA_60100: TENKOPRESSUREDATA_60100,
                    TENKOPRESSUREDATA_60100_2: TENKOPRESSUREDATA_60100_2,
                    TENKOPRESSUREDATA_60100_3: TENKOPRESSUREDATA_60100_3,
                    TENKOPRESSUREDATA_60110: TENKOPRESSUREDATA_60110,
                    TENKOPRESSUREDATA_60110_2: TENKOPRESSUREDATA_60110_2,
                    TENKOPRESSUREDATA_60110_3: TENKOPRESSUREDATA_60110_3,
                    TENKOALCOHOLDATA: TENKOALCOHOLDATA,
                    TENKOOXYGENDATA: TENKOOXYGENDATA
                },
                success: function (rs) {

                    window.location.reload();
                    alert(rs);


                }
            });
        }






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
    </script>
    <script>
        $(function () {
            $('[data-toggle="popover"]').popover({
                html: true,
                content: function () {
                    return $('#popover-content').html();
                }
            });
        }
        )
    </script>
</html>


<?php
sqlsrv_close($conn);
?>
