<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$sql_getDate = "{call megGetdate_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

$condition1 = "  AND a.PersonCode = '" . $_SESSION["EMPLOYEEID"] . "'";
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
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!--<link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">-->
        <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../dist/css/buttons.dataTables.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet">
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


            .popover {
                position: fixed;
                top: 0;
                left: 0;
                z-index: 1060;
                display: none;
                max-width: 276px;
                padding: 1px;
                font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
                font-size: 14px;
                font-style: normal;
                font-weight: 400;
                line-height: 1.42857143;
                text-align: left;
                text-align: start;
                text-decoration: none;
                text-shadow: none;
                text-transform: none;
                letter-spacing: normal;
                word-break: normal;
                word-spacing: normal;
                word-wrap: normal;
                white-space: normal;
                background-color: #fff;
                -webkit-background-clip: padding-box;
                background-clip: padding-box;
                border: 1px solid #ccc;
                border: 1px solid rgba(0,0,0,.2);
                border-radius: 6px;
                -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
                box-shadow: 0 5px 10px rgba(0,0,0,.2);
                line-break: auto;
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


            <div id="page-wrapper" >
                <form  name="searchform" id="searchform" method="post">
                    <div class="row" >
                        <div class="col-lg-2">

                            <h2 class="page-header"><i class="glyphicon glyphicon-user"></i>  
                                ปฏิบัติงาน

                            </h2>
                        </div>


                        <div class="col-lg-6 text-right">&nbsp;</div>
                        <div class="col-lg-2 text-right">
                            <h2 class="page-header">
                                <input type="text" name="txt_datestartsr1" id="txt_datestartsr1" readonly="" onchange="add_dateweek(this.value)"  class="form-control dateennoweek"  value="<?= $result_getDate['STARTWEEK']; ?>">
                            </h2>
                        </div>

                        <div class="col-lg-2 text-right">
                            <h2 class="page-header">
                                <input type="text" name="txt_dateendsr1" disabled=""  id="txt_dateendsr1" readonly="" class="form-control dateennoweek" value="<?= $result_getDate['ENDWEEK']; ?>">   
                            </h2>
                        </div>

                        <!--<div class="col-lg-1 text-center">
                            <h2 class="page-header">
                                <a onclick="sr_vehicletransportplan()" id="btn_datesr" name="btn_datesr" class="btn"  style="border-color: black;background-color:#fff;color: black ">ค้นหาข้อมูล</a>
                            </h2>
                        </div>
                        -->


                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->


                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #e7e7e7">

                                    <div class="row">
                                        <div class = "col-lg-2">
                                            <div class = "form-group">
                                                <button type="button" id="btn_refresh" onclick="update_jobstatus()" name="btn_refresh" class="btn"  style="border-color: white;background-color:#337ab7;color: white "><li class="fa fa-refresh"></li></button>
                                                <font style="color: #999"><a href="#" onclick="update_jobstatus()">Update สถานะ </a></font>                                        </div>
                                        </div>
                                        <div class = "col-lg-10 text-right">
                                            <div class = "form-group">
                                                <button type="button" onclick="btn_submitall()" id="btn_statusall" name="btn_statusall" class="btn"  style="border-color: #ff00ff;background-color:#fff;color: #ff00ff ">ทั้งหมด</button>
                                                <button type="button" onclick="btn_submit0()" id="btn_status0" name="btn_status0" class="btn"  style="border-color: black;background-color:#fff;color: black ">แผนงานยกเลิก</button>
                                                <button type="button" onclick="btn_submit1()" id="btn_status1" name="btn_status1" class="btn"  style="border-color: blue;background-color:#fff;color:blue  ">แผนงานยังไม่ถึงเวลารายงาน</button>
                                                <button type="button" onclick="btn_submit2()" id="btn_status2" name="btn_status2" class="btn"  style="border-color: red;background-color:#fff;color: red ">แผนงานเลยเวลารายงานตัว</button>
                                                <button type="button" onclick="btn_submit3()" id="btn_status3" name="btn_status3" class="btn"  style="border-color: #ffcb0b;background-color:#fff;color:#ffcb0b ">รายงานตัวเปิด Job เริ่มงาน</button>
                                                <button type="button" onclick="btn_submit4()" id="btn_status4" name="btn_status4" class="btn"  style="border-color: green;background-color:#fff;color:green  ">รายงานตัวกลับปิด Job งาน</button>
                                                <button type="button" onclick="btn_submit5()" id="btn_status5" name="btn_status5" class="btn"  style="border-color: #999;background-color:#fff;color:darkgray  ">ปิดงาน</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- /.panel-heading -->

                                <div class="panel-body">
                                    <?php
                                    /* $conditionstatus = " AND a.STATUSNUMBER = ''";
                                      $rs_status = "";
                                      if (isset($_POST['btn_statusall'])) {
                                      $conditionstatus = " AND a.STATUSNUMBER IN ('0','1','2','3','4','5')";
                                      $rs_status = "all";
                                      } else if (isset($_POST['btn_status0'])) {
                                      $conditionstatus = " AND a.STATUSNUMBER = '0'";
                                      $rs_status = "0";
                                      } else if (isset($_POST['btn_status1'])) {
                                      $conditionstatus = " AND a.STATUSNUMBER = '1'";
                                      $rs_status = "1";
                                      } else if (isset($_POST['btn_status2'])) {
                                      $conditionstatus = " AND a.STATUSNUMBER = '2'";
                                      $rs_status = "2";
                                      } else if (isset($_POST['btn_status3'])) {
                                      $conditionstatus = " AND a.STATUSNUMBER = '3'";
                                      $rs_status = "3";
                                      } else if (isset($_POST['btn_status4'])) {
                                      $conditionstatus = " AND a.STATUSNUMBER = '4'";
                                      $rs_status = "4";
                                      } else if (isset($_POST['btn_status5'])) {
                                      $conditionstatus = " AND a.STATUSNUMBER = '5'";
                                      $rs_status = "5";
                                      } else {
                                      $conditionstatus = " AND a.STATUSNUMBER = ''";
                                      $rs_status = "";
                                      } */
                                    ?>
                                    <div id="data_def">
                                        <ul class="nav nav-pills">
                                            <li class="active"><a href="#monday-pills" data-toggle="tab">จันทร์ <label id="lab_monday"></label></a></li>
                                            <li><a href="#tuesday-pills" data-toggle="tab">อังคาร <label id="lab_tuesday"></label></a></li>
                                            <li><a href="#wednesday-pills" data-toggle="tab">พุธ <label id="lab_wednesday"></label></a></li>
                                            <li><a href="#thursday-pills" data-toggle="tab">พฤหัสบดี <label id="lab_thursday"></label></a></li>
                                            <li><a href="#friday-pills" data-toggle="tab">ศุกร์ <label id="lab_friday"></label></a></li>
                                            <li><a href="#saturday-pills" data-toggle="tab">เสาร์ <label id="lab_saturday"></label></a></li>
                                            <li><a href="#sunday-pills" data-toggle="tab">อาทิตย์ <label id="lab_sunday"></label></a></li>
                                        </ul>

                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div class="tab-pane fade in active" id="monday-pills">
                                                <p>&nbsp;</p>
                                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                                    <?php
                                                    $conditiionMonday1 = " AND DATENAME(DW,a.DATEPRESENT) = 'Monday' ";
                                                    $conditiionMonday2 = " AND (a.DATEPRESENT BETWEEN CONVERT(datetime,'" . $result_getDate['STARTWEEK'] . "',103) AND CONVERT(datetime,'" . $result_getDate['ENDWEEK'] . "',103))";
                                                    $sql_seEmployeeMondaychk = "{call megVehicletransportplan_v2(?,?,?)}";
                                                    $params_seEmployeeMondaychk = array(
                                                        array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
                                                        array($conditiionMonday1, SQLSRV_PARAM_IN),
                                                        array($conditiionMonday2, SQLSRV_PARAM_IN)
                                                    );

                                                    $query_seEmployeeMondaychk = sqlsrv_query($conn, $sql_seEmployeeMondaychk, $params_seEmployeeMondaychk);
                                                    $result_seEmployeeMondaychk = sqlsrv_fetch_array($query_seEmployeeMondaychk, SQLSRV_FETCH_ASSOC);
                                                    ?>

                                                    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-monday" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <?php
                                                                if ($result_seEmployeeMondaychk['STATUSNUMBER'] == '1' || $result_seEmployeeMondaychk['STATUSNUMBER'] == '3' || $result_seEmployeeMondaychk['STATUSNUMBER'] == '2') {
                                                                    ?>
                                                                    <th style="text-align: center">เปิด/ปิด</th>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <th style="text-align: center;width:5%">&nbsp;</th>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <th style="text-align: center;width: 10%">เลขที่งาน</th>
                                                                <th style="text-align: center;width:5%">ลูกค้า</th>
                                                                <th style="text-align: center;width:5%">ทะเบียน</th>
                                                                <th style="text-align: center;width:10%">พนักงาน(1)</th>
                                                                <th style="text-align: center;width:10%">พนักงาน(2)</th>
                                                                <th style="text-align: center;width:10%">ต้นทาง</th>
                                                                <th style="text-align: center;width:10%">ปลายทาง</th>
                                                                <!--<th style="text-align: center;width:10%">สถานะ</th>-->
                                                                <!--<th>พขร.</th>-->
                                                                <th style="text-align: center;width:5%">ไมล์ต้น</th>
                                                                <th style="text-align: center;width:5%">ไมล์ปลาย</th>

                                                                <th style="text-align: center;width:5%">เปิดงาน</th>
                                                                <th style="text-align: center;width:5%">เข้า VL</th>
                                                                <th style="text-align: center;width:5%">ออก VL</th>
                                                                <th style="text-align: center;width:5%">เข้า DEALER</th>
                                                                <th style="text-align: center;width:5%">กลับบริษัท</th>



                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <?php
                                                            $sql_seEmployeeMonday = "{call megVehicletransportplan_v2(?,?,?)}";
                                                            $params_seEmployeeMonday = array(
                                                                array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
                                                                array($conditiionMonday1, SQLSRV_PARAM_IN),
                                                                array($conditiionMonday2, SQLSRV_PARAM_IN)
                                                            );
                                                            $i = 1;
                                                            $query_seEmployeeMonday = sqlsrv_query($conn, $sql_seEmployeeMonday, $params_seEmployeeMonday);
                                                            while ($result_seEmployeeMonday = sqlsrv_fetch_array($query_seEmployeeMonday, SQLSRV_FETCH_ASSOC)) {
                                                                ?>
                                                                <tr >

                                                                    <?php
                                                                    if ($result_seEmployeeMonday['STATUSNUMBER'] == '3') {
                                                                        ?> 
                                                                        <td style="text-align: center">
                                                                            <!--<a href='#' class='list-group-item' onclick='edit_vehicletransportplanactualpresent(<?//= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>)'>รายงานตัวตรวจร่างกาย</a><br>-->
                                                                            <a href="#"  role="button" class="btn btn-default btn-circle" data-toggle="popover" title="" data-content="
                                                                               <a href='#' onclick='save_tenkomaster(<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>)' class='list-group-item'>รายงานตัวตรวจร่างกาย</a><br>
                                                                               <a href='#' class='list-group-item' onclick='update_vehicletransportplanjob(<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>,4)'>รายงานตัวกลับ</a><br>
                                                                               <a href='#' class='list-group-item'>แจ้งหยุด</a><br>
                                                                               <a href='meg_transportplan.php?type=transportplan&meg=add&companycode=<?= $result_seEmployeeMonday['COMPANYCODE'] ?>&customercode=<?= $result_seEmployeeMonday['CUSTOMERCODE'] ?>&vehicletransportplanid=<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>' class='list-group-item'>แก้ไขงาน</a><br>
                                                                               <a href='#' class='list-group-item' onclick='update_vehicletransportplanjob(<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>,5)'>ปิดงาน</a>"><i class="fa fa-list"></i></a>
                                                                        </td>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <td style="text-align: center">
                                                                            <!--<a href='#' class='list-group-item' onclick='edit_vehicletransportplanactualpresent(<?//= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>)'>รายงานตัวตรวจร่างกาย</a><br>-->
                                                                            <a href="#"  role="button" class="btn btn-default btn-circle" data-toggle="popover" title="" data-content="
                                                                               <a href='#' onclick='save_tenkomaster(<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>)' class='list-group-item'>รายงานตัวตรวจร่างกาย</a><br>
                                                                               <a href='#' class='list-group-item'>แจ้งหยุด</a><br>
                                                                               <a href='meg_transportplan.php?type=transportplan&meg=add&companycode=<?= $result_seEmployeeMonday['COMPANYCODE'] ?>&customercode=<?= $result_seEmployeeMonday['CUSTOMERCODE'] ?>&vehicletransportplanid=<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>' class='list-group-item'>แก้ไขงาน</a><br>
                                                                               <a href='#' class='list-group-item' onclick='update_vehicletransportplanjob(<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>,5)'>ปิดงาน</a>"><i class="fa fa-list"></i></a>
                                                                        </td>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    <td 
                                                                    <?php
                                                                    switch ($result_seEmployeeMonday['STATUSNUMBER']) {
                                                                        case '0': {
                                                                                ?>
                                                                                    style="color: black"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '1': {
                                                                                    ?>
                                                                                    style="color: blue"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '2': {
                                                                                    ?>
                                                                                    style="color: red"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '3': {
                                                                                    ?>
                                                                                    style="color: #ffcb0b"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '4': {
                                                                                    ?>
                                                                                    style="color: green"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '5': {
                                                                                    ?>
                                                                                    style="color: darkgray"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            default : {
                                                                                    
                                                                                }
                                                                                break;
                                                                        }
                                                                        ?>

                                                                        ><?= $result_seEmployeeMonday['JOBNO'] ?></td>
                                                                    <td ><?= $result_seEmployeeMonday['CUSTOMERCODE'] ?></td>
                                                                    <td ><?= $result_seEmployeeMonday['VEHICLEREGISNUMBER1'] ?></td>
                                                                    <td ><?= $result_seEmployeeMonday['EMPLOYEENAME1'] ?></td>
                                                                    <td ><?= $result_seEmployeeMonday['EMPLOYEENAME2'] ?></td>
                                                                    <td><?= $result_seEmployeeMonday['JOBSTART'] ?></td>
                                                                    <td><?= $result_seEmployeeMonday['JOBEND'] ?></td>
                                                                    <!--<td><?//= $result_seEmployeeMonday['STATUS'] ?></td>-->
                                                                    <!--<td>
                                                                    <?php
                                                                    //if ($result_seEmployeeMonday['EMPLOYEENAME1'] == $_POST['employeename']) {
                                                                    ?>
                                                                            D1
                                                                    <?php
                                                                    //}
                                                                    //   if ($result_seEmployeeMonday['EMPLOYEENAME2'] == $_POST['employeename']) {
                                                                    ?>
                                                                            D2
                                                                    <?php
                                                                    //}
                                                                    //if ($result_seEmployeeMonday['EMPLOYEENAME'] == $_POST['employeename']) {
                                                                    ?>
                                                                            D3
                                                                    <?php
                                                                    //}
                                                                    //if ($result_seEmployeeMonday['EMPLOYEENAME4'] == $_POST['employeename']) {
                                                                    ?>
                                                                            D4
                                                                    <?php
                                                                    //}
                                                                    ?>
                                                                    </td>-->
                                                                    <?php
                                                                    $condMaxmileage = " AND JOBNO = '" . $result_seEmployeeMonday['JOBNO'] . "' ";
                                                                    $sql_seMaxmile = "{call megMileage_v2(?,?)}";
                                                                    $params_seMaxmile = array(
                                                                        array('select_maxmileage', SQLSRV_PARAM_IN),
                                                                        array($condMaxmileage, SQLSRV_PARAM_IN)
                                                                    );
                                                                    $query_seMaxmile = sqlsrv_query($conn, $sql_seMaxmile, $params_seMaxmile);
                                                                    $result_seMaxmile = sqlsrv_fetch_array($query_seMaxmile, SQLSRV_FETCH_ASSOC);
                                                                    ?>
                                                                    <td contenteditable="true" onblur="save_mileage(this, 'MILEAGESTART', '<?= $result_seEmployeeMonday['VEHICLEREGISNUMBER1'] ?>', '<?= $result_seEmployeeMonday['JOBNO'] ?>')"><?= $result_seMaxmile['MAXMILEAGENUMBER'] ?></td>
                                                                    <?php
                                                                    if ($result_seEmployeeMonday['STATUSNUMBER'] == '3') {
                                                                        ?>
                                                                        <td contenteditable="true" onblur="save_mileage(this, 'MILEAGEEND', '<?= $result_seEmployeeMonday['VEHICLEREGISNUMBER1'] ?>', '<?= $result_seEmployeeMonday['JOBNO'] ?>')"></td>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <td>&nbsp;</td>
                                                                        <?php
                                                                    }
                                                                    ?>


                                                                    <td><?= $result_seEmployeeMonday['TIMEWORKING'] ?></td>
                                                                    <td><?= $result_seEmployeeMonday['TIMEVLIN'] ?></td>
                                                                    <td><?= $result_seEmployeeMonday['TIMEVLOUT'] ?></td>
                                                                    <td><?= $result_seEmployeeMonday['TIMEDEALERIN'] ?></td>
                                                                    <td><?= $result_seEmployeeMonday['TIMERETURN'] ?></td>

                                                                    <?php
                                                                    /* if ($result_seEmployeeMonday['STATUSNUMBER'] == '2') {
                                                                      ?>
                                                                      <td style="text-align: center">

                                                                      <input   type="checkbox"  OnClick="if (this.checked) {
                                                                      check('<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_seEmployeeMonday['JOBNO'] ?>', '<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>', '3');
                                                                      } else {
                                                                      uncheck('<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>', '2');
                                                                      }"  id="<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>" name="<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>"  style="width: 20px" class="form-control">
                                                                      </td>
                                                                      <?php
                                                                      } else if ($result_seEmployeeMonday['STATUSNUMBER'] == '3') {
                                                                      ?>
                                                                      <td style="text-align: center">

                                                                      <input   type="checkbox"  OnClick="if (this.checked) {
                                                                      check('<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_seEmployeeMonday['JOBNO'] ?>', '<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>', '4');
                                                                      } else {
                                                                      uncheck('<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>', '3');
                                                                      }"  id="<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>" name="<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>"  style="width: 20px" class="form-control">
                                                                      </td>
                                                                      <?php
                                                                      } else if ($result_seEmployeeMonday['STATUSNUMBER'] == '1') {
                                                                      ?>
                                                                      <td style="text-align: center">
                                                                      <input   type="checkbox"  OnClick="if (this.checked) {
                                                                      check('<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_seEmployeeMonday['JOBNO'] ?>', '<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>', '3');
                                                                      } else {
                                                                      uncheck('<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>', '1');
                                                                      }"  id="<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>" name="<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>"  style="width: 20px" class="form-control">
                                                                      </td>
                                                                      <?php
                                                                      } */
                                                                    ?>


                                                                </tr>
                                                                <?php
                                                                $i++;
                                                            }
                                                            ?>

                                                        </tbody>
                                                    </table>


                                                </div>
                                            </div>






                                            <div class="tab-pane fade" id="tuesday-pills">
                                                <p>&nbsp;</p>
                                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                    <?php
                                                    $conditiionTuesday1 = " AND DATENAME(DW,a.DATEPRESENT) = 'Tuesday' ";
                                                    $conditiionTuesday2 = " AND (a.DATEPRESENT BETWEEN CONVERT(datetime,'" . $result_getDate['STARTWEEK'] . "',103) AND CONVERT(datetime,'" . $result_getDate['ENDWEEK'] . "',103))";

                                                    $sql_seEmployeeTuesdaychk = "{call megVehicletransportplan_v2(?,?)}";
                                                    $params_seEmployeeTuesdaychk = array(
                                                        array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
                                                        array($conditiionTuesday1, SQLSRV_PARAM_IN),
                                                        array($conditiionTuesday2, SQLSRV_PARAM_IN)
                                                    );

                                                    $query_seEmployeeTuesdaychk = sqlsrv_query($conn, $sql_seEmployeeTuesdaychk, $params_seEmployeeTuesdaychk);
                                                    $result_seEmployeeTuesdaychk = sqlsrv_fetch_array($query_seEmployeeTuesdaychk, SQLSRV_FETCH_ASSOC);
                                                    ?>

                                                    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-tuesday" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <?php
                                                                if ($result_seEmployeeTuesdaychk['STATUSNUMBER'] == '1' || $result_seEmployeeTuesdaychk['STATUSNUMBER'] == '3' || $result_seEmployeeTuesdaychk['STATUSNUMBER'] == '2') {
                                                                    ?>
                                                                    <th style="text-align: center">เปิด/ปิด</th>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <th style="text-align: center">&nbsp;</th>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <th style="text-align: center;width: 10%">เลขที่งาน</th>
                                                                <th style="text-align: center;width:5%">ลูกค้า</th>
                                                                <th style="text-align: center;width:5%">ทะเบียน</th>
                                                                <th style="text-align: center;width:10%">พนักงาน(1)</th>
                                                                <th style="text-align: center;width:10%">พนักงาน(2)</th>
                                                                <th style="text-align: center;width:10%">ต้นทาง</th>
                                                                <th style="text-align: center;width:10%">ปลายทาง</th>
                                                                <!--<th style="text-align: center;width:10%">สถานะ</th>-->
                                                                <!--<th>พขร.</th>-->
                                                                <th style="text-align: center;width:5%">ไมล์ต้น</th>
                                                                <th style="text-align: center;width:5%">ไมล์ปลาย</th>


                                                                <th style="text-align: center;width:5%">เปิดงาน</th>
                                                                <th style="text-align: center;width:5%">เข้า VL</th>
                                                                <th style="text-align: center;width:5%">ออก VL</th>
                                                                <th style="text-align: center;width:5%">เข้า DEALER</th>
                                                                <th style="text-align: center;width:5%">กลับบริษัท</th>


                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <?php
                                                            $sql_seEmployeeTuesday = "{call megVehicletransportplan_v2(?,?,?)}";
                                                            $params_seEmployeeTuesday = array(
                                                                array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
                                                                array($conditiionTuesday1, SQLSRV_PARAM_IN),
                                                                array($conditiionTuesday2, SQLSRV_PARAM_IN)
                                                            );
                                                            $i = 1;
                                                            $query_seEmployeeTuesday = sqlsrv_query($conn, $sql_seEmployeeTuesday, $params_seEmployeeTuesday);
                                                            while ($result_seEmployeeTuesday = sqlsrv_fetch_array($query_seEmployeeTuesday, SQLSRV_FETCH_ASSOC)) {
                                                                ?>
                                                                <tr >
                                                                    <?php
                                                                    if ($result_seEmployeeTuesday['STATUSNUMBER'] == '3') {
                                                                        ?> 
                                                                        <td style="text-align: center">
                                                                            <a href="#"  role="button" class="btn btn-default btn-circle" data-toggle="popover" title="" data-content="
                                                                               <a href='#' onclick='save_tenkomaster(<?= $result_seEmployeeTuesday['VEHICLETRANSPORTPLANID'] ?>)' class='list-group-item'>รายงานตัวตรวจร่างกาย</a><br>
                                                                               <a href='#' class='list-group-item' onclick='update_vehicletransportplanjob(<?= $result_seEmployeeTuesday['VEHICLETRANSPORTPLANID'] ?>,4)'>รายงานตัวกลับ</a><br>
                                                                               <a href='#' class='list-group-item'>แจ้งหยุด</a><br>
                                                                               <a href='meg_transportplan.php?type=transportplan&meg=add&companycode=<?= $result_seEmployeeTuesday['COMPANYCODE'] ?>&customercode=<?= $result_seEmployeeTuesday['CUSTOMERCODE'] ?>&vehicletransportplanid=<?= $result_seEmployeeTuesday['VEHICLETRANSPORTPLANID'] ?>' class='list-group-item'>แก้ไขงาน</a><br>
                                                                               <a href='#' class='list-group-item' onclick='update_vehicletransportplanjob(<?= $result_seEmployeeTuesday['VEHICLETRANSPORTPLANID'] ?>,5)'>ปิดงาน</a>"><i class="fa fa-list"></i></a>
                                                                        </td>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <td style="text-align: center">
                                                                            <a href="#"  role="button" class="btn btn-default btn-circle" data-toggle="popover" title="" data-content="
                                                                               <a href='#' onclick='save_tenkomaster(<?= $result_seEmployeeTuesday['VEHICLETRANSPORTPLANID'] ?>)' class='list-group-item'>รายงานตัวตรวจร่างกาย</a><br>
                                                                               <a href='#' class='list-group-item'>แจ้งหยุด</a><br>
                                                                               <a href='meg_transportplan.php?type=transportplan&meg=add&companycode=<?= $result_seEmployeeTuesday['COMPANYCODE'] ?>&customercode=<?= $result_seEmployeeTuesday['CUSTOMERCODE'] ?>&vehicletransportplanid=<?= $result_seEmployeeTuesday['VEHICLETRANSPORTPLANID'] ?>' class='list-group-item'>แก้ไขงาน</a><br>
                                                                               <a href='#' class='list-group-item' onclick='update_vehicletransportplanjob(<?= $result_seEmployeeTuesday['VEHICLETRANSPORTPLANID'] ?>,5)'>ปิดงาน</a>"><i class="fa fa-list"></i></a>
                                                                        </td>
                                                                        <?php
                                                                    }
                                                                    ?>






                                                                    </td>
                                                                    <td 

                                                                        <?php
                                                                        switch ($result_seEmployeeTuesday['STATUSNUMBER']) {
                                                                            case '0': {
                                                                                    ?>
                                                                                    style="color: black"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '1': {
                                                                                    ?>
                                                                                    style="color: blue"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '2': {
                                                                                    ?>
                                                                                    style="color: red"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '3': {
                                                                                    ?>
                                                                                    style="color: #ffcb0b"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '4': {
                                                                                    ?>
                                                                                    style="color: green"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '5': {
                                                                                    ?>
                                                                                    style="color: darkgray"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            default : {
                                                                                    
                                                                                }
                                                                                break;
                                                                        }
                                                                        ?>
                                                                        ><?= $result_seEmployeeTuesday['JOBNO'] ?></td>
                                                                    <td ><?= $result_seEmployeeTuesday['CUSTOMERCODE'] ?></td>
                                                                    <td ><?= $result_seEmployeeTuesday['VEHICLEREGISNUMBER1'] ?></td>
                                                                    <td ><?= $result_seEmployeeTuesday['EMPLOYEENAME1'] ?></td>
                                                                    <td ><?= $result_seEmployeeTuesday['EMPLOYEENAME2'] ?></td>
                                                                    <td><?= $result_seEmployeeTuesday['JOBSTART'] ?></td>
                                                                    <td><?= $result_seEmployeeTuesday['JOBEND'] ?></td>
                                                                    <!--<td><?//= $result_seEmployeeTuesday['STATUS'] ?></td>-->
                                                                    <!--<td>
                                                                    <?php
                                                                    //if ($result_seEmployeeTuesday['EMPLOYEENAME1'] == $_POST['employeename']) {
                                                                    ?>
                                                                            D1
                                                                    <?php
                                                                    //}
                                                                    //   if ($result_seEmployeeTuesday['EMPLOYEENAME2'] == $_POST['employeename']) {
                                                                    ?>
                                                                            D2
                                                                    <?php
                                                                    //}
                                                                    //if ($result_seEmployeeTuesday['EMPLOYEENAME'] == $_POST['employeename']) {
                                                                    ?>
                                                                            D3
                                                                    <?php
                                                                    //}
                                                                    //if ($result_seEmployeeTuesday['EMPLOYEENAME4'] == $_POST['employeename']) {
                                                                    ?>
                                                                            D4
                                                                    <?php
                                                                    //}
                                                                    ?>
                                                                    </td>-->
                                                                    <?php
                                                                    $condMaxmileage = " AND JOBNO = '" . $result_seEmployeeTuesday['JOBNO'] . "' ";
                                                                    $sql_seMaxmile = "{call megMileage_v2(?,?)}";
                                                                    $params_seMaxmile = array(
                                                                        array('select_maxmileage', SQLSRV_PARAM_IN),
                                                                        array($condMaxmileage, SQLSRV_PARAM_IN)
                                                                    );
                                                                    $query_seMaxmile = sqlsrv_query($conn, $sql_seMaxmile, $params_seMaxmile);
                                                                    $result_seMaxmile = sqlsrv_fetch_array($query_seMaxmile, SQLSRV_FETCH_ASSOC);
                                                                    ?>
                                                                    <td contenteditable="true" onblur="save_mileage(this, 'MILEAGESTART', '<?= $result_seEmployeeTuesday['VEHICLEREGISNUMBER1'] ?>', '<?= $result_seEmployeeTuesday['JOBNO'] ?>')"><?= $result_seMaxmile['MAXMILEAGENUMBER'] ?></td>
                                                                    <?php
                                                                    if ($result_seEmployeeTuesday['STATUSNUMBER'] == '3') {
                                                                        ?>
                                                                        <td contenteditable="true" onblur="save_mileage(this, 'MILEAGEEND', '<?= $result_seEmployeeTuesday['VEHICLEREGISNUMBER1'] ?>', '<?= $result_seEmployeeTuesday['JOBNO'] ?>')"></td>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <td>&nbsp;</td>
                                                                        <?php
                                                                    }
                                                                    ?>



                                                                    <td><?= $result_seEmployeeTuesday['TIMEWORKING'] ?></td>
                                                                    <td><?= $result_seEmployeeTuesday['TIMEVLIN'] ?></td>
                                                                    <td><?= $result_seEmployeeTuesday['TIMEVLOUT'] ?></td>
                                                                    <td><?= $result_seEmployeeTuesday['TIMEDEALERIN'] ?></td>
                                                                    <td><?= $result_seEmployeeTuesday['TIMERETURN'] ?></td>
                                                                    <?php
                                                                    /* if ($result_seEmployeeTuesday['STATUSNUMBER'] == '2') {
                                                                      ?>
                                                                      <td style="text-align: center">

                                                                      <input   type="checkbox"  OnClick="if (this.checked) {
                                                                      check('<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_seEmployeeTuesday['JOBNO'] ?>', '<?= $result_seEmployeeTuesday['VEHICLETRANSPORTPLANID'] ?>', '3');
                                                                      } else {
                                                                      uncheck('<?= $result_seEmployeeTuesday['VEHICLETRANSPORTPLANID'] ?>', '2');
                                                                      }"  id="<?= $result_seEmployeeTuesday['VEHICLETRANSPORTPLANID'] ?>" name="<?= $result_seEmployeeTuesday['VEHICLETRANSPORTPLANID'] ?>"  style="width: 20px" class="form-control">
                                                                      </td>
                                                                      <?php
                                                                      } else if ($result_seEmployeeTuesday['STATUSNUMBER'] == '3') {
                                                                      ?>
                                                                      <td style="text-align: center">

                                                                      <input   type="checkbox"  OnClick="if (this.checked) {
                                                                      check('<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_seEmployeeTuesday['JOBNO'] ?>', '<?= $result_seEmployeeTuesday['VEHICLETRANSPORTPLANID'] ?>', '4');
                                                                      } else {
                                                                      uncheck('<?= $result_seEmployeeTuesday['VEHICLETRANSPORTPLANID'] ?>', '3');
                                                                      }"  id="<?= $result_seEmployeeTuesday['VEHICLETRANSPORTPLANID'] ?>" name="<?= $result_seEmployeeTuesday['VEHICLETRANSPORTPLANID'] ?>"  style="width: 20px" class="form-control">
                                                                      </td>
                                                                      <?php
                                                                      } else if ($result_seEmployeeTuesday['STATUSNUMBER'] == '1') {
                                                                      ?>
                                                                      <td style="text-align: center">
                                                                      <input   type="checkbox"  OnClick="if (this.checked) {
                                                                      check('<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_seEmployeeTuesday['JOBNO'] ?>', '<?= $result_seEmployeeTuesday['VEHICLETRANSPORTPLANID'] ?>', '3');
                                                                      } else {
                                                                      uncheck('<?= $result_seEmployeeTuesday['VEHICLETRANSPORTPLANID'] ?>', '1');
                                                                      }"  id="<?= $result_seEmployeeTuesday['VEHICLETRANSPORTPLANID'] ?>" name="<?= $result_seEmployeeTuesday['VEHICLETRANSPORTPLANID'] ?>"  style="width: 20px" class="form-control">
                                                                      </td>
                                                                      <?php
                                                                      } */
                                                                    ?>


                                                                </tr>
                                                                <?php
                                                                $i++;
                                                            }
                                                            ?>

                                                        </tbody>
                                                    </table>


                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="wednesday-pills">
                                                <p>&nbsp;</p>
                                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                    <?php
                                                    $conditiionWednesday1 = " AND DATENAME(DW,a.DATEPRESENT) = 'Wednesday' ";
                                                    $conditiionWednesday2 = " AND (a.DATEPRESENT BETWEEN CONVERT(datetime,'" . $result_getDate['STARTWEEK'] . "',103) AND CONVERT(datetime,'" . $result_getDate['ENDWEEK'] . "',103))";


                                                    $sql_seEmployeeWednesdaychk = "{call megVehicletransportplan_v2(?,?,?)}";
                                                    $params_seEmployeeWednesdaychk = array(
                                                        array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
                                                        array($conditiionWednesday1, SQLSRV_PARAM_IN),
                                                        array($conditiionWednesday2, SQLSRV_PARAM_IN)
                                                    );

                                                    $query_seEmployeeWednesdaychk = sqlsrv_query($conn, $sql_seEmployeeWednesdaychk, $params_seEmployeeWednesdaychk);
                                                    $result_seEmployeeWednesdaychk = sqlsrv_fetch_array($query_seEmployeeWednesdaychk, SQLSRV_FETCH_ASSOC);
                                                    ?>

                                                    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-wednesday" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <?php
                                                                if ($result_seEmployeeWednesdaychk['STATUSNUMBER'] == '1' || $result_seEmployeeWednesdaychk['STATUSNUMBER'] == '3' || $result_seEmployeeWednesdaychk['STATUSNUMBER'] == '2') {
                                                                    ?>
                                                                    <th style="text-align: center">เปิด/ปิด</th>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <th style="text-align: center">&nbsp;</th>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <th style="text-align: center;width: 10%">เลขที่งาน</th>
                                                                <th style="text-align: center;width:5%">ลูกค้า</th>
                                                                <th style="text-align: center;width:5%">ทะเบียน</th>
                                                                <th style="text-align: center;width:10%">พนักงาน(1)</th>
                                                                <th style="text-align: center;width:10%">พนักงาน(2)</th>
                                                                <th style="text-align: center;width:10%">ต้นทาง</th>
                                                                <th style="text-align: center;width:10%">ปลายทาง</th>
                                                                <!--<th style="text-align: center;width:10%">สถานะ</th>-->
                                                                <!--<th>พขร.</th>-->
                                                                <th style="text-align: center;width:5%">ไมล์ต้น</th>
                                                                <th style="text-align: center;width:5%">ไมล์ปลาย</th>


                                                                <th style="text-align: center;width:5%">เปิดงาน</th>
                                                                <th style="text-align: center;width:5%">เข้า VL</th>
                                                                <th style="text-align: center;width:5%">ออก VL</th>
                                                                <th style="text-align: center;width:5%">เข้า DEALER</th>
                                                                <th style="text-align: center;width:5%">กลับบริษัท</th>


                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <?php
                                                            $sql_seEmployeeWednesday = "{call megVehicletransportplan_v2(?,?,?)}";
                                                            $params_seEmployeeWednesday = array(
                                                                array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
                                                                array($conditiionWednesday1, SQLSRV_PARAM_IN),
                                                                array($conditiionWednesday2, SQLSRV_PARAM_IN)
                                                            );
                                                            $i = 1;
                                                            $query_seEmployeeWednesday = sqlsrv_query($conn, $sql_seEmployeeWednesday, $params_seEmployeeWednesday);
                                                            while ($result_seEmployeeWednesday = sqlsrv_fetch_array($query_seEmployeeWednesday, SQLSRV_FETCH_ASSOC)) {
                                                                ?>
                                                                <tr >


                                                                    <?php
                                                                    if ($result_seEmployeeWednesday['STATUSNUMBER'] == '3') {
                                                                        ?> 
                                                                        <td style="text-align: center">
                                                                            <a href="#"  role="button" class="btn btn-default btn-circle" data-toggle="popover" title="" data-content="
                                                                               <a href='#' onclick='save_tenkomaster(<?= $result_seEmployeeWednesday['VEHICLETRANSPORTPLANID'] ?>)' class='list-group-item'>รายงานตัวตรวจร่างกาย</a><br>
                                                                               <a href='#' class='list-group-item' onclick='update_vehicletransportplanjob(<?= $result_seEmployeeWednesday['VEHICLETRANSPORTPLANID'] ?>,4)'>รายงานตัวกลับ</a><br>
                                                                               <a href='#' class='list-group-item'>แจ้งหยุด</a><br>
                                                                               <a href='meg_transportplan.php?type=transportplan&meg=add&companycode=<?= $result_seEmployeeWednesday['COMPANYCODE'] ?>&customercode=<?= $result_seEmployeeWednesday['CUSTOMERCODE'] ?>&vehicletransportplanid=<?= $result_seEmployeeWednesday['VEHICLETRANSPORTPLANID'] ?>' class='list-group-item'>แก้ไขงาน</a><br>
                                                                               <a href='#' class='list-group-item' onclick='update_vehicletransportplanjob(<?= $result_seEmployeeWednesday['VEHICLETRANSPORTPLANID'] ?>,5)'>ปิดงาน</a>"><i class="fa fa-list"></i></a>
                                                                        </td>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <td style="text-align: center">
                                                                            <a href="#"  role="button" class="btn btn-default btn-circle" data-toggle="popover" title="" data-content="
                                                                               <a href='#' onclick='save_tenkomaster(<?= $result_seEmployeeWednesday['VEHICLETRANSPORTPLANID'] ?>)' class='list-group-item'>รายงานตัวตรวจร่างกาย</a><br>
                                                                               <a href='#' class='list-group-item'>แจ้งหยุด</a><br>
                                                                               <a href='meg_transportplan.php?type=transportplan&meg=add&companycode=<?= $result_seEmployeeWednesday['COMPANYCODE'] ?>&customercode=<?= $result_seEmployeeWednesday['CUSTOMERCODE'] ?>&vehicletransportplanid=<?= $result_seEmployeeWednesday['VEHICLETRANSPORTPLANID'] ?>' class='list-group-item'>แก้ไขงาน</a><br>
                                                                               <a href='#' class='list-group-item' onclick='update_vehicletransportplanjob(<?= $result_seEmployeeWednesday['VEHICLETRANSPORTPLANID'] ?>,5)'>ปิดงาน</a>"><i class="fa fa-list"></i></a>
                                                                        </td>
                                                                        <?php
                                                                    }
                                                                    ?>




                                                                    <td 
                                                                    <?php
                                                                    switch ($result_seEmployeeWednesday['STATUSNUMBER']) {
                                                                        case '0': {
                                                                                ?>
                                                                                    style="color: black"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '1': {
                                                                                    ?>
                                                                                    style="color: blue"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '2': {
                                                                                    ?>
                                                                                    style="color: red"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '3': {
                                                                                    ?>
                                                                                    style="color: #ffcb0b"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '4': {
                                                                                    ?>
                                                                                    style="color: green"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '5': {
                                                                                    ?>
                                                                                    style="color: darkgray"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            default : {
                                                                                    
                                                                                }
                                                                                break;
                                                                        }
                                                                        ?> 
                                                                        ><?= $result_seEmployeeWednesday['JOBNO'] ?></td>
                                                                    <td ><?= $result_seEmployeeWednesday['CUSTOMERCODE'] ?></td>
                                                                    <td ><?= $result_seEmployeeWednesday['VEHICLEREGISNUMBER1'] ?></td>
                                                                    <td ><?= $result_seEmployeeWednesday['EMPLOYEENAME1'] ?></td>
                                                                    <td ><?= $result_seEmployeeWednesday['EMPLOYEENAME2'] ?></td>
                                                                    <td><?= $result_seEmployeeWednesday['JOBSTART'] ?></td>
                                                                    <td><?= $result_seEmployeeWednesday['JOBEND'] ?></td>
                                                                    <!--<td><?//= $result_seEmployeeWednesday['STATUS'] ?></td>-->
                                                                    <!--<td>
                                                                    <?php
                                                                    //if ($result_seEmployee['EMPLOYEENAME1'] == $_POST['employeename']) {
                                                                    ?>
                                                                            D1
                                                                    <?php
                                                                    //}
                                                                    //   if ($result_seEmployee['EMPLOYEENAME2'] == $_POST['employeename']) {
                                                                    ?>
                                                                            D2
                                                                    <?php
                                                                    //}
                                                                    //if ($result_seEmployee['EMPLOYEENAME'] == $_POST['employeename']) {
                                                                    ?>
                                                                            D3
                                                                    <?php
                                                                    //}
                                                                    //if ($result_seEmployee['EMPLOYEENAME4'] == $_POST['employeename']) {
                                                                    ?>
                                                                            D4
                                                                    <?php
                                                                    //}
                                                                    ?>
                                                                    </td>-->
                                                                    <?php
                                                                    $condMaxmileage = " AND JOBNO = '" . $result_seEmployeeWednesday['JOBNO'] . "' ";
                                                                    $sql_seMaxmile = "{call megMileage_v2(?,?)}";
                                                                    $params_seMaxmile = array(
                                                                        array('select_maxmileage', SQLSRV_PARAM_IN),
                                                                        array($condMaxmileage, SQLSRV_PARAM_IN)
                                                                    );
                                                                    $query_seMaxmile = sqlsrv_query($conn, $sql_seMaxmile, $params_seMaxmile);
                                                                    $result_seMaxmile = sqlsrv_fetch_array($query_seMaxmile, SQLSRV_FETCH_ASSOC);
                                                                    ?>
                                                                    <td contenteditable="true" onblur="save_mileage(this, 'MILEAGESTART', '<?= $result_seEmployeeWednesday['VEHICLEREGISNUMBER1'] ?>', '<?= $result_seEmployeeWednesday['JOBNO'] ?>')"><?= $result_seMaxmile['MAXMILEAGENUMBER'] ?></td>
                                                                    <?php
                                                                    if ($result_seEmployeeWednesday['STATUSNUMBER'] == '3') {
                                                                        ?>
                                                                        <td contenteditable="true" onblur="save_mileage(this, 'MILEAGEEND', '<?= $result_seEmployeeWednesday['VEHICLEREGISNUMBER1'] ?>', '<?= $result_seEmployeeWednesday['JOBNO'] ?>')"></td>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <td>&nbsp;</td>
                                                                        <?php
                                                                    }
                                                                    ?>


                                                                    <td><?= $result_seEmployeeWednesday['TIMEWORKING'] ?></td>
                                                                    <td><?= $result_seEmployeeWednesday['TIMEVLIN'] ?></td>
                                                                    <td><?= $result_seEmployeeWednesday['TIMEVLOUT'] ?></td>
                                                                    <td><?= $result_seEmployeeWednesday['TIMEDEALERIN'] ?></td>
                                                                    <td><?= $result_seEmployeeWednesday['TIMERETURN'] ?></td>
                                                                    <?php
                                                                    /*  if ($result_seEmployeeWednesday['STATUSNUMBER'] == '2') {
                                                                      ?>
                                                                      <td style="text-align: center">

                                                                      <input   type="checkbox"  OnClick="if (this.checked) {
                                                                      check('<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_seEmployeeWednesday['JOBNO'] ?>', '<?= $result_seEmployeeWednesday['VEHICLETRANSPORTPLANID'] ?>', '3');
                                                                      } else {
                                                                      uncheck('<?= $result_seEmployeeWednesday['VEHICLETRANSPORTPLANID'] ?>', '2');
                                                                      }"  id="<?= $result_seEmployeeWednesday['VEHICLETRANSPORTPLANID'] ?>" name="<?= $result_seEmployeeWednesday['VEHICLETRANSPORTPLANID'] ?>"  style="width: 20px" class="form-control">
                                                                      </td>
                                                                      <?php
                                                                      } else if ($result_seEmployeeWednesday['STATUSNUMBER'] == '3') {
                                                                      ?>
                                                                      <td style="text-align: center">

                                                                      <input   type="checkbox"  OnClick="if (this.checked) {
                                                                      check('<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_seEmployeeWednesday['JOBNO'] ?>', '<?= $result_seEmployeeWednesday['VEHICLETRANSPORTPLANID'] ?>', '4');
                                                                      } else {
                                                                      uncheck('<?= $result_seEmployeeWednesday['VEHICLETRANSPORTPLANID'] ?>', '3');
                                                                      }"  id="<?= $result_seEmployeeWednesday['VEHICLETRANSPORTPLANID'] ?>" name="<?= $result_seEmployeeWednesday['VEHICLETRANSPORTPLANID'] ?>"  style="width: 20px" class="form-control">
                                                                      </td>
                                                                      <?php
                                                                      } else if ($result_seEmployeeWednesday['STATUSNUMBER'] == '1') {
                                                                      ?>
                                                                      <td style="text-align: center">
                                                                      <input   type="checkbox"  OnClick="if (this.checked) {
                                                                      check('<?= $result_seEmployeeWednesday['JOBNO'] ?>', '<?= $result_seEmployeeWednesday['VEHICLETRANSPORTPLANID'] ?>', '3');
                                                                      } else {
                                                                      uncheck('<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_seEmployeeWednesday['VEHICLETRANSPORTPLANID'] ?>', '1');
                                                                      }"  id="<?= $result_seEmployeeWednesday['VEHICLETRANSPORTPLANID'] ?>" name="<?= $result_seEmployeeWednesday['VEHICLETRANSPORTPLANID'] ?>"  style="width: 20px" class="form-control">
                                                                      </td>
                                                                      <?php
                                                                      } */
                                                                    ?>


                                                                </tr>
                                                                <?php
                                                                $i++;
                                                            }
                                                            ?>

                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="thursday-pills">
                                                <p>&nbsp;</p>
                                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                    <?php
                                                    $conditiionThursday1 = " AND DATENAME(DW,a.DATEPRESENT) = 'Thursday' ";
                                                    $conditiionThursday2 = " AND (a.DATEPRESENT BETWEEN CONVERT(datetime,'" . $result_getDate['STARTWEEK'] . "',103) AND CONVERT(datetime,'" . $result_getDate['ENDWEEK'] . "',103))";



                                                    $sql_seEmployeeThursdaychk = "{call megVehicletransportplan_v2(?,?,?)}";
                                                    $params_seEmployeeThursdaychk = array(
                                                        array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
                                                        array($conditiionThursday1, SQLSRV_PARAM_IN),
                                                        array($conditiionThursday2, SQLSRV_PARAM_IN)
                                                    );

                                                    $query_seEmployeeThursdaychk = sqlsrv_query($conn, $sql_seEmployeeThursdaychk, $params_seEmployeeThursdaychk);
                                                    $result_seEmployeeThursdaychk = sqlsrv_fetch_array($query_seEmployeeThursdaychk, SQLSRV_FETCH_ASSOC);
                                                    ?>

                                                    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-thursday" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <?php
                                                                if ($result_seEmployeeThursdaychk['STATUSNUMBER'] == '1' || $result_seEmployeeThursdaychk['STATUSNUMBER'] == '3' || $result_seEmployeeThursdaychk['STATUSNUMBER'] == '2') {
                                                                    ?>
                                                                    <th style="text-align: center">เปิด/ปิด</th>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <th style="text-align: center">&nbsp;</th>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <th style="text-align: center;width: 10%">เลขที่งาน</th>
                                                                <th style="text-align: center;width:5%">ลูกค้า</th>
                                                                <th style="text-align: center;width:5%">ทะเบียน</th>
                                                                <th style="text-align: center;width:10%">พนักงาน(1)</th>
                                                                <th style="text-align: center;width:10%">พนักงาน(2)</th>
                                                                <th style="text-align: center;width:10%">ต้นทาง</th>
                                                                <th style="text-align: center;width:10%">ปลายทาง</th>
                                                                <!--<th style="text-align: center;width:10%">สถานะ</th>-->
                                                                <!--<th>พขร.</th>-->
                                                                <th style="text-align: center;width:5%">ไมล์ต้น</th>
                                                                <th style="text-align: center;width:5%">ไมล์ปลาย</th>

                                                                <th style="text-align: center;width:5%">เปิดงาน</th>
                                                                <th style="text-align: center;width:5%">เข้า VL</th>
                                                                <th style="text-align: center;width:5%">ออก VL</th>
                                                                <th style="text-align: center;width:5%">เข้า DEALER</th>
                                                                <th style="text-align: center;width:5%">กลับบริษัท</th>


                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <?php
                                                            $sql_seEmployeeThursday = "{call megVehicletransportplan_v2(?,?,?)}";
                                                            $params_seEmployeeThursday = array(
                                                                array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
                                                                array($conditiionThursday1, SQLSRV_PARAM_IN),
                                                                array($conditiionThursday2, SQLSRV_PARAM_IN)
                                                            );
                                                            $i = 1;
                                                            $query_seEmployeeThursday = sqlsrv_query($conn, $sql_seEmployeeThursday, $params_seEmployeeThursday);
                                                            while ($result_seEmployeeThursday = sqlsrv_fetch_array($query_seEmployeeThursday, SQLSRV_FETCH_ASSOC)) {
                                                                ?>
                                                                <tr >

                                                                    <?php
                                                                    if ($result_seEmployeeThursday['STATUSNUMBER'] == '3') {
                                                                        ?> 
                                                                        <td style="text-align: center">
                                                                            <a href="#"  role="button" class="btn btn-default btn-circle" data-toggle="popover" title="" data-content="
                                                                               <a href='#' onclick='save_tenkomaster(<?= $result_seEmployeeThursday['VEHICLETRANSPORTPLANID'] ?>)' class='list-group-item'>รายงานตัวตรวจร่างกาย</a><br>
                                                                               <a href='#' class='list-group-item' onclick='update_vehicletransportplanjob(<?= $result_seEmployeeThursday['VEHICLETRANSPORTPLANID'] ?>,4)'>รายงานตัวกลับ</a><br>
                                                                               <a href='#' class='list-group-item'>แจ้งหยุด</a><br>
                                                                               <a href='meg_transportplan.php?type=transportplan&meg=add&companycode=<?= $result_seEmployeeThursday['COMPANYCODE'] ?>&customercode=<?= $result_seEmployeeThursday['CUSTOMERCODE'] ?>&vehicletransportplanid=<?= $result_seEmployeeThursday['VEHICLETRANSPORTPLANID'] ?>' class='list-group-item'>แก้ไขงาน</a><br>
                                                                               <a href='#' class='list-group-item' onclick='update_vehicletransportplanjob(<?= $result_seEmployeeThursday['VEHICLETRANSPORTPLANID'] ?>,5)>ปิดงาน</a>"><i class="fa fa-list"></i></a>
                                                                        </td>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <td style="text-align: center">
                                                                            <a href="#"  role="button" class="btn btn-default btn-circle" data-toggle="popover" title="" data-content="
                                                                               <a href='#' onclick='save_tenkomaster(<?= $result_seEmployeeThursday['VEHICLETRANSPORTPLANID'] ?>)' class='list-group-item'>รายงานตัวตรวจร่างกาย</a><br>
                                                                               <a href='#' class='list-group-item'>แจ้งหยุด</a><br>
                                                                               <a href='meg_transportplan.php?type=transportplan&meg=add&companycode=<?= $result_seEmployeeThursday['COMPANYCODE'] ?>&customercode=<?= $result_seEmployeeThursday['CUSTOMERCODE'] ?>&vehicletransportplanid=<?= $result_seEmployeeThursday['VEHICLETRANSPORTPLANID'] ?>' class='list-group-item'>แก้ไขงาน</a><br>
                                                                               <a href='#' class='list-group-item' onclick='update_vehicletransportplanjob(<?= $result_seEmployeeThursday['VEHICLETRANSPORTPLANID'] ?>,5)>ปิดงาน</a>"><i class="fa fa-list"></i></a>
                                                                        </td>
                                                                        <?php
                                                                    }
                                                                    ?>





                                                                    <td <?php
                                                                    switch ($result_seEmployeeThursday['STATUSNUMBER']) {
                                                                        case '0': {
                                                                                ?>
                                                                                    style="color: black"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '1': {
                                                                                    ?>
                                                                                    style="color: blue"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '2': {
                                                                                    ?>
                                                                                    style="color: red"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '3': {
                                                                                    ?>
                                                                                    style="color: #ffcb0b"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '4': {
                                                                                    ?>
                                                                                    style="color: green"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '5': {
                                                                                    ?>
                                                                                    style="color: darkgray"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            default : {
                                                                                    
                                                                                }
                                                                                break;
                                                                        }
                                                                        ?> ><?= $result_seEmployeeThursday['JOBNO'] ?></td>
                                                                    <td ><?= $result_seEmployeeThursday['CUSTOMERCODE'] ?></td>
                                                                    <td ><?= $result_seEmployeeThursday['VEHICLEREGISNUMBER1'] ?></td>
                                                                    <td ><?= $result_seEmployeeThursday['EMPLOYEENAME1'] ?></td>
                                                                    <td ><?= $result_seEmployeeThursday['EMPLOYEENAME2'] ?></td>
                                                                    <td><?= $result_seEmployeeThursday['JOBSTART'] ?></td>
                                                                    <td><?= $result_seEmployeeThursday['JOBEND'] ?></td>
                                                                    <!--<td><?//= $result_seEmployeeThursday['STATUS'] ?></td>-->
                                                                    <!--<td>
                                                                    <?php
                                                                    //if ($result_seEmployee['EMPLOYEENAME1'] == $_POST['employeename']) {
                                                                    ?>
                                                                            D1
                                                                    <?php
                                                                    //}
                                                                    //   if ($result_seEmployee['EMPLOYEENAME2'] == $_POST['employeename']) {
                                                                    ?>
                                                                            D2
                                                                    <?php
                                                                    //}
                                                                    //if ($result_seEmployee['EMPLOYEENAME'] == $_POST['employeename']) {
                                                                    ?>
                                                                            D3
                                                                    <?php
                                                                    //}
                                                                    //if ($result_seEmployee['EMPLOYEENAME4'] == $_POST['employeename']) {
                                                                    ?>
                                                                            D4
                                                                    <?php
                                                                    //}
                                                                    ?>
                                                                    </td>-->
                                                                    <?php
                                                                    $condMaxmileage = " AND JOBNO = '" . $result_seEmployeeThursday['JOBNO'] . "' ";
                                                                    $sql_seMaxmile = "{call megMileage_v2(?,?)}";
                                                                    $params_seMaxmile = array(
                                                                        array('select_maxmileage', SQLSRV_PARAM_IN),
                                                                        array($condMaxmileage, SQLSRV_PARAM_IN)
                                                                    );
                                                                    $query_seMaxmile = sqlsrv_query($conn, $sql_seMaxmile, $params_seMaxmile);
                                                                    $result_seMaxmile = sqlsrv_fetch_array($query_seMaxmile, SQLSRV_FETCH_ASSOC);
                                                                    ?>
                                                                    <td contenteditable="true" onblur="save_mileage(this, 'MILEAGESTART', '<?= $result_seEmployeeThursday['VEHICLEREGISNUMBER1'] ?>', '<?= $result_seEmployeeThursday['JOBNO'] ?>')"><?= $result_seMaxmile['MAXMILEAGENUMBER'] ?></td>
                                                                    <?php
                                                                    if ($result_seEmployeeThursday['STATUSNUMBER'] == '3') {
                                                                        ?>
                                                                        <td contenteditable="true" onblur="save_mileage(this, 'MILEAGEEND', '<?= $result_seEmployeeThursday['VEHICLEREGISNUMBER1'] ?>', '<?= $result_seEmployeeThursday['JOBNO'] ?>')"></td>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <td>&nbsp;</td>
                                                                        <?php
                                                                    }
                                                                    ?>


                                                                    <td><?= $result_seEmployeeThursday['TIMEWORKING'] ?></td>
                                                                    <td><?= $result_seEmployeeThursday['TIMEVLIN'] ?></td>
                                                                    <td><?= $result_seEmployeeThursday['TIMEVLOUT'] ?></td>
                                                                    <td><?= $result_seEmployeeThursday['TIMEDEALERIN'] ?></td>
                                                                    <td><?= $result_seEmployeeThursday['TIMERETURN'] ?></td>
                                                                    <?php
                                                                    /* if ($result_seEmployeeThursday['STATUSNUMBER'] == '2') {
                                                                      ?>
                                                                      <td style="text-align: center">

                                                                      <input   type="checkbox"  OnClick="if (this.checked) {
                                                                      check('<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_seEmployeeThursday['JOBNO'] ?>', '<?= $result_seEmployeeThursday['VEHICLETRANSPORTPLANID'] ?>', '3');
                                                                      } else {
                                                                      uncheck('<?= $result_seEmployeeThursday['VEHICLETRANSPORTPLANID'] ?>', '2');
                                                                      }"  id="<?= $result_seEmployeeThursday['VEHICLETRANSPORTPLANID'] ?>" name="<?= $result_seEmployeeThursday['VEHICLETRANSPORTPLANID'] ?>"  style="width: 20px" class="form-control">
                                                                      </td>
                                                                      <?php
                                                                      } else if ($result_seEmployeeThursday['STATUSNUMBER'] == '3') {
                                                                      ?>
                                                                      <td style="text-align: center">

                                                                      <input   type="checkbox"  OnClick="if (this.checked) {
                                                                      check('<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_seEmployeeThursday['JOBNO'] ?>', '<?= $result_seEmployeeThursday['VEHICLETRANSPORTPLANID'] ?>', '4');
                                                                      } else {
                                                                      uncheck('<?= $result_seEmployeeThursday['VEHICLETRANSPORTPLANID'] ?>', '3');
                                                                      }"  id="<?= $result_seEmployeeThursday['VEHICLETRANSPORTPLANID'] ?>" name="<?= $result_seEmployeeThursday['VEHICLETRANSPORTPLANID'] ?>"  style="width: 20px" class="form-control">
                                                                      </td>
                                                                      <?php
                                                                      } else if ($result_seEmployeeThursday['STATUSNUMBER'] == '1') {
                                                                      ?>
                                                                      <td style="text-align: center">
                                                                      <input   type="checkbox"  OnClick="if (this.checked) {
                                                                      check('<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_seEmployeeThursday['JOBNO'] ?>', '<?= $result_seEmployeeThursday['VEHICLETRANSPORTPLANID'] ?>', '3');
                                                                      } else {
                                                                      uncheck('<?= $result_seEmployeeThursday['VEHICLETRANSPORTPLANID'] ?>', '1');
                                                                      }"  id="<?= $result_seEmployeeThursday['VEHICLETRANSPORTPLANID'] ?>" name="<?= $result_seEmployeeThursday['VEHICLETRANSPORTPLANID'] ?>"  style="width: 20px" class="form-control">
                                                                      </td>
                                                                      <?php
                                                                      } */
                                                                    ?>


                                                                </tr>
                                                                <?php
                                                                $i++;
                                                            }
                                                            ?>

                                                        </tbody>
                                                    </table>


                                                </div>    
                                            </div>
                                            <div class="tab-pane fade" id="friday-pills">
                                                <p>&nbsp;</p>
                                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                    <?php
                                                    $conditiionFriday1 = " AND DATENAME(DW,a.DATEPRESENT) = 'Friday' ";
                                                    $conditiionFriday2 = " AND (a.DATEPRESENT BETWEEN CONVERT(datetime,'" . $result_getDate['STARTWEEK'] . "',103) AND CONVERT(datetime,'" . $result_getDate['ENDWEEK'] . "',103))";


                                                    $sql_seEmployeeFridaychk = "{call megVehicletransportplan_v2(?,?,?)}";
                                                    $params_seEmployeeFridaychk = array(
                                                        array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
                                                        array($conditiionFriday1, SQLSRV_PARAM_IN),
                                                        array($conditiionFriday2, SQLSRV_PARAM_IN)
                                                    );

                                                    $query_seEmployeeFridaychk = sqlsrv_query($conn, $sql_seEmployeeFridaychk, $params_seEmployeeFridaychk);
                                                    $result_seEmployeeFridaychk = sqlsrv_fetch_array($query_seEmployeeFridaychk, SQLSRV_FETCH_ASSOC);
                                                    ?>

                                                    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-friday" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <?php
                                                                if ($result_seEmployeeFridaychk['STATUSNUMBER'] == '1' || $result_seEmployeeFridaychk['STATUSNUMBER'] == '3' || $result_seEmployeeFridaychk['STATUSNUMBER'] == '2') {
                                                                    ?>
                                                                    <th style="text-align: center">เปิด/ปิด</th>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <th style="text-align: center">&nbsp;</th>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <th style="text-align: center;width: 10%">เลขที่งาน</th>
                                                                <th style="text-align: center;width:5%">ลูกค้า</th>
                                                                <th style="text-align: center;width:5%">ทะเบียน</th>
                                                                <th style="text-align: center;width:10%">พนักงาน(1)</th>
                                                                <th style="text-align: center;width:10%">พนักงาน(2)</th>
                                                                <th style="text-align: center;width:10%">ต้นทาง</th>
                                                                <th style="text-align: center;width:10%">ปลายทาง</th>
                                                                <!--<th style="text-align: center;width:10%">สถานะ</th>-->
                                                                <!--<th>พขร.</th>-->
                                                                <th style="text-align: center;width:5%">ไมล์ต้น</th>
                                                                <th style="text-align: center;width:5%">ไมล์ปลาย</th>


                                                                <th style="text-align: center;width:5%">เปิดงาน</th>
                                                                <th style="text-align: center;width:5%">เข้า VL</th>
                                                                <th style="text-align: center;width:5%">ออก VL</th>
                                                                <th style="text-align: center;width:5%">เข้า DEALER</th>
                                                                <th style="text-align: center;width:5%">กลับบริษัท</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <?php
                                                            $sql_seEmployeeFriday = "{call megVehicletransportplan_v2(?,?,?)}";
                                                            $params_seEmployeeFriday = array(
                                                                array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
                                                                array($conditiionFriday1, SQLSRV_PARAM_IN),
                                                                array($conditiionFriday2, SQLSRV_PARAM_IN)
                                                            );
                                                            $i = 1;
                                                            $query_seEmployeeFriday = sqlsrv_query($conn, $sql_seEmployeeFriday, $params_seEmployeeFriday);
                                                            while ($result_seEmployeeFriday = sqlsrv_fetch_array($query_seEmployeeFriday, SQLSRV_FETCH_ASSOC)) {
                                                                ?>
                                                                <tr >


                                                                    <?php
                                                                    if ($result_seEmployeeFriday['STATUSNUMBER'] == '3') {
                                                                        ?> 
                                                                        <td style="text-align: center">
                                                                            <a href="#"  role="button" class="btn btn-default btn-circle" data-toggle="popover" title="" data-content="
                                                                               <a href='#' onclick='save_tenkomaster(<?= $result_seEmployeeFriday['VEHICLETRANSPORTPLANID'] ?>)' class='list-group-item'>รายงานตัวตรวจร่างกาย</a><br>
                                                                               <a href='#' class='list-group-item' onclick='update_vehicletransportplanjob(<?= $result_seEmployeeFriday['VEHICLETRANSPORTPLANID'] ?>,4)'>รายงานตัวกลับ</a><br>
                                                                               <a href='#' class='list-group-item'>แจ้งหยุด</a><br>
                                                                               <a href='meg_transportplan.php?type=transportplan&meg=add&companycode=<?= $result_seEmployeeFriday['COMPANYCODE'] ?>&customercode=<?= $result_seEmployeeFriday['CUSTOMERCODE'] ?>&vehicletransportplanid=<?= $result_seEmployeeFriday['VEHICLETRANSPORTPLANID'] ?>' class='list-group-item'>แก้ไขงาน</a><br>
                                                                               <a href='#' class='list-group-item' onclick='update_vehicletransportplanjob(<?= $result_seEmployeeFriday['VEHICLETRANSPORTPLANID'] ?>,3)>ปิดงาน</a>"><i class="fa fa-list"></i></a>
                                                                        </td>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <td style="text-align: center">
                                                                            <a href="#"  role="button" class="btn btn-default btn-circle" data-toggle="popover" title="" data-content="
                                                                               <a href='#' onclick='save_tenkomaster(<?= $result_seEmployeeFriday['VEHICLETRANSPORTPLANID'] ?>)' class='list-group-item'>รายงานตัวตรวจร่างกาย</a><br>
                                                                               <a href='#' class='list-group-item'>แจ้งหยุด</a><br>
                                                                               <a href='meg_transportplan.php?type=transportplan&meg=add&companycode=<?= $result_seEmployeeFriday['COMPANYCODE'] ?>&customercode=<?= $result_seEmployeeFriday['CUSTOMERCODE'] ?>&vehicletransportplanid=<?= $result_seEmployeeFriday['VEHICLETRANSPORTPLANID'] ?>' class='list-group-item'>แก้ไขงาน</a><br>
                                                                               <a href='#' class='list-group-item' onclick='update_vehicletransportplanjob(<?= $result_seEmployeeFriday['VEHICLETRANSPORTPLANID'] ?>,3)>ปิดงาน</a>"><i class="fa fa-list"></i></a>
                                                                        </td>
                                                                        <?php
                                                                    }
                                                                    ?>




                                                                    <td <?php
                                                                    switch ($result_seEmployeeFriday['STATUSNUMBER']) {
                                                                        case '0': {
                                                                                ?>
                                                                                    style="color: black"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '1': {
                                                                                    ?>
                                                                                    style="color: blue"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '2': {
                                                                                    ?>
                                                                                    style="color: red"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '3': {
                                                                                    ?>
                                                                                    style="color: #ffcb0b"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '4': {
                                                                                    ?>
                                                                                    style="color: green"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '5': {
                                                                                    ?>
                                                                                    style="color: darkgray"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            default : {
                                                                                    
                                                                                }
                                                                                break;
                                                                        }
                                                                        ?>><?= $result_seEmployeeFriday['JOBNO'] ?></td>
                                                                    <td ><?= $result_seEmployeeFriday['CUSTOMERCODE'] ?></td>
                                                                    <td ><?= $result_seEmployeeFriday['VEHICLEREGISNUMBER1'] ?></td>
                                                                    <td ><?= $result_seEmployeeFriday['EMPLOYEENAME1'] ?></td>
                                                                    <td ><?= $result_seEmployeeFriday['EMPLOYEENAME2'] ?></td>
                                                                    <td><?= $result_seEmployeeFriday['JOBSTART'] ?></td>
                                                                    <td><?= $result_seEmployeeFriday['JOBEND'] ?></td>
                                                                    <!--<td><?//= $result_seEmployeeFriday['STATUS'] ?></td>-->
                                                                    <!--<td>
                                                                    <?php
                                                                    //if ($result_seEmployee['EMPLOYEENAME1'] == $_POST['employeename']) {
                                                                    ?>
                                                                            D1
                                                                    <?php
                                                                    //}
                                                                    //   if ($result_seEmployee['EMPLOYEENAME2'] == $_POST['employeename']) {
                                                                    ?>
                                                                            D2
                                                                    <?php
                                                                    //}
                                                                    //if ($result_seEmployee['EMPLOYEENAME'] == $_POST['employeename']) {
                                                                    ?>
                                                                            D3
                                                                    <?php
                                                                    //}
                                                                    //if ($result_seEmployee['EMPLOYEENAME4'] == $_POST['employeename']) {
                                                                    ?>
                                                                            D4
                                                                    <?php
                                                                    //}
                                                                    ?>
                                                                    </td>-->
                                                                    <?php
                                                                    $condMaxmileage = " AND JOBNO = '" . $result_seEmployeeFriday['JOBNO'] . "' ";
                                                                    $sql_seMaxmile = "{call megMileage_v2(?,?)}";
                                                                    $params_seMaxmile = array(
                                                                        array('select_maxmileage', SQLSRV_PARAM_IN),
                                                                        array($condMaxmileage, SQLSRV_PARAM_IN)
                                                                    );
                                                                    $query_seMaxmile = sqlsrv_query($conn, $sql_seMaxmile, $params_seMaxmile);
                                                                    $result_seMaxmile = sqlsrv_fetch_array($query_seMaxmile, SQLSRV_FETCH_ASSOC);
                                                                    ?>
                                                                    <td contenteditable="true" onblur="save_mileage(this, 'MILEAGESTART', '<?= $result_seEmployeeFriday['VEHICLEREGISNUMBER1'] ?>', '<?= $result_seEmployeeFriday['JOBNO'] ?>')"><?= $result_seMaxmile['MAXMILEAGENUMBER'] ?></td>
                                                                    <?php
                                                                    if ($result_seEmployee['STATUSNUMBER'] == '3') {
                                                                        ?>
                                                                        <td contenteditable="true" onblur="save_mileage(this, 'MILEAGEEND', '<?= $result_seEmployeeFriday['VEHICLEREGISNUMBER1'] ?>', '<?= $result_seEmployeeFriday['JOBNO'] ?>')"></td>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <td>&nbsp;</td>
                                                                        <?php
                                                                    }
                                                                    ?>


                                                                    <td><?= $result_seEmployeeFriday['TIMEWORKING'] ?></td>
                                                                    <td><?= $result_seEmployeeFriday['TIMEVLIN'] ?></td>
                                                                    <td><?= $result_seEmployeeFriday['TIMEVLOUT'] ?></td>
                                                                    <td><?= $result_seEmployeeFriday['TIMEDEALERIN'] ?></td>
                                                                    <td><?= $result_seEmployeeFriday['TIMERETURN'] ?></td>
                                                                    <?php
                                                                    /* if ($result_seEmployee['STATUSNUMBER'] == '2') {
                                                                      ?>
                                                                      <td style="text-align: center">

                                                                      <input   type="checkbox"  OnClick="if (this.checked) {
                                                                      check('<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_seEmployeeFriday['JOBNO'] ?>', '<?= $result_seEmployeeFriday['VEHICLETRANSPORTPLANID'] ?>', '3');
                                                                      } else {
                                                                      uncheck('<?= $result_seEmployeeFriday['VEHICLETRANSPORTPLANID'] ?>', '2');
                                                                      }"  id="<?= $result_seEmployeeFriday['VEHICLETRANSPORTPLANID'] ?>" name="<?= $result_seEmployeeFriday['VEHICLETRANSPORTPLANID'] ?>"  style="width: 20px" class="form-control">
                                                                      </td>
                                                                      <?php
                                                                      } else if ($result_seEmployeeFriday['STATUSNUMBER'] == '3') {
                                                                      ?>
                                                                      <td style="text-align: center">

                                                                      <input   type="checkbox"  OnClick="if (this.checked) {
                                                                      check('<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_seEmployeeFriday['JOBNO'] ?>', '<?= $result_seEmployeeFriday['VEHICLETRANSPORTPLANID'] ?>', '4');
                                                                      } else {
                                                                      uncheck('<?= $result_seEmployeeFriday['VEHICLETRANSPORTPLANID'] ?>', '3');
                                                                      }"  id="<?= $result_seEmployeeFriday['VEHICLETRANSPORTPLANID'] ?>" name="<?= $result_seEmployeeFriday['VEHICLETRANSPORTPLANID'] ?>"  style="width: 20px" class="form-control">
                                                                      </td>
                                                                      <?php
                                                                      } else if ($result_seEmployeeFriday['STATUSNUMBER'] == '1') {
                                                                      ?>
                                                                      <td style="text-align: center">
                                                                      <input   type="checkbox"  OnClick="if (this.checked) {
                                                                      check('<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_seEmployeeFriday['JOBNO'] ?>', '<?= $result_seEmployeeFriday['VEHICLETRANSPORTPLANID'] ?>', '3');
                                                                      } else {
                                                                      uncheck('<?= $result_seEmployeeFriday['VEHICLETRANSPORTPLANID'] ?>', '1');
                                                                      }"  id="<?= $result_seEmployeeFriday['VEHICLETRANSPORTPLANID'] ?>" name="<?= $result_seEmployeeFriday['VEHICLETRANSPORTPLANID'] ?>"  style="width: 20px" class="form-control">
                                                                      </td>
                                                                      <?php
                                                                      } */
                                                                    ?>


                                                                </tr>
                                                                <?php
                                                                $i++;
                                                            }
                                                            ?>

                                                        </tbody>
                                                    </table>


                                                </div>    
                                            </div>
                                            <div class="tab-pane fade" id="saturday-pills">
                                                <p>&nbsp;</p>
                                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                    <?php
                                                    $conditiionSaturday1 = " AND DATENAME(DW,a.DATEPRESENT) = 'Saturday' ";
                                                    $conditiionSaturday2 = " AND (a.DATEPRESENT BETWEEN CONVERT(datetime,'" . $result_getDate['STARTWEEK'] . "',103) AND CONVERT(datetime,'" . $result_getDate['ENDWEEK'] . "',103))";


                                                    $sql_seEmployeeSaturdaychk = "{call megVehicletransportplan_v2(?,?,?)}";
                                                    $params_seEmployeeSaturdaychk = array(
                                                        array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
                                                        array($conditiionSaturday1, SQLSRV_PARAM_IN),
                                                        array($conditiionSaturday2, SQLSRV_PARAM_IN)
                                                    );

                                                    $query_seEmployeeSaturdaychk = sqlsrv_query($conn, $sql_seEmployeeSaturdaychk, $params_seEmployeeSaturdaychk);
                                                    $result_seEmployeeSaturdaychk = sqlsrv_fetch_array($query_seEmployeeSaturdaychk, SQLSRV_FETCH_ASSOC);
                                                    ?>

                                                    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-saturday" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <?php
                                                                if ($result_seEmployeeSaturdaychk['STATUSNUMBER'] == '1' || $result_seEmployeeSaturdaychk['STATUSNUMBER'] == '3' || $result_seEmployeeSaturdaychk['STATUSNUMBER'] == '2') {
                                                                    ?>
                                                                    <th style="text-align: center">เปิด/ปิด</th>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <th style="text-align: center">&nbsp;</th>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <th style="text-align: center;width: 10%">เลขที่งาน</th>
                                                                <th style="text-align: center;width:5%">ลูกค้า</th>
                                                                <th style="text-align: center;width:5%">ทะเบียน</th>
                                                                <th style="text-align: center;width:10%">พนักงาน(1)</th>
                                                                <th style="text-align: center;width:10%">พนักงาน(2)</th>
                                                                <th style="text-align: center;width:10%">ต้นทาง</th>
                                                                <th style="text-align: center;width:10%">ปลายทาง</th>
                                                                <!--<th style="text-align: center;width:10%">สถานะ</th>-->
                                                                <!--<th>พขร.</th>-->
                                                                <th style="text-align: center;width:5%">ไมล์ต้น</th>
                                                                <th style="text-align: center;width:5%">ไมล์ปลาย</th>

                                                                <th style="text-align: center;width:5%">เปิดงาน</th>
                                                                <th style="text-align: center;width:5%">เข้า VL</th>
                                                                <th style="text-align: center;width:5%">ออก VL</th>
                                                                <th style="text-align: center;width:5%">เข้า DEALER</th>
                                                                <th style="text-align: center;width:5%">กลับบริษัท</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <?php
                                                            $sql_seEmployeeSaturday = "{call megVehicletransportplan_v2(?,?,?)}";
                                                            $params_seEmployeeSaturday = array(
                                                                array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
                                                                array($conditiionSaturday1, SQLSRV_PARAM_IN),
                                                                array($conditiionSaturday2, SQLSRV_PARAM_IN)
                                                            );
                                                            $i = 1;
                                                            $query_seEmployeeSaturday = sqlsrv_query($conn, $sql_seEmployeeSaturday, $params_seEmployeeSaturday);
                                                            while ($result_seEmployeeSaturday = sqlsrv_fetch_array($query_seEmployeeSaturday, SQLSRV_FETCH_ASSOC)) {
                                                                ?>
                                                                <tr >
                                                                    <?php
                                                                    if ($result_seEmployeeSaturday['STATUSNUMBER'] == '3') {
                                                                        ?> 
                                                                        <td style="text-align: center">
                                                                            <a href="#"  role="button" class="btn btn-default btn-circle" data-toggle="popover" title="" data-content="
                                                                               <a href='#' onclick='save_tenkomaster(<?= $result_seEmployeeSaturday['VEHICLETRANSPORTPLANID'] ?>)' class='list-group-item'>รายงานตัวตรวจร่างกาย</a><br>
                                                                               <a href='#' class='list-group-item' onclick='update_vehicletransportplanjob(<?= $result_seEmployeeSaturday['VEHICLETRANSPORTPLANID'] ?>,4)'>รายงานตัวกลับ</a><br>
                                                                               <a href='#' class='list-group-item'>แจ้งหยุด</a><br>
                                                                               <a href='meg_transportplan.php?type=transportplan&meg=add&companycode=<?= $result_seEmployeeSaturday['COMPANYCODE'] ?>&customercode=<?= $result_seEmployeeSaturday['CUSTOMERCODE'] ?>&vehicletransportplanid=<?= $result_seEmployeeSaturday['VEHICLETRANSPORTPLANID'] ?>' class='list-group-item'>แก้ไขงาน</a><br>
                                                                               <a href='#' class='list-group-item' onclick='update_vehicletransportplanjob(<?= $result_seEmployeeSaturday['VEHICLETRANSPORTPLANID'] ?>,5)>ปิดงาน</a>"><i class="fa fa-list"></i></a>
                                                                        </td>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <td style="text-align: center">
                                                                            <a href="#"  role="button" class="btn btn-default btn-circle" data-toggle="popover" title="" data-content="
                                                                               <a href='#' onclick='save_tenkomaster(<?= $result_seEmployeeSaturday['VEHICLETRANSPORTPLANID'] ?>)' class='list-group-item'>รายงานตัวตรวจร่างกาย</a><br>
                                                                               <a href='#' class='list-group-item'>แจ้งหยุด</a><br>
                                                                               <a href='meg_transportplan.php?type=transportplan&meg=add&companycode=<?= $result_seEmployeeSaturday['COMPANYCODE'] ?>&customercode=<?= $result_seEmployeeSaturday['CUSTOMERCODE'] ?>&vehicletransportplanid=<?= $result_seEmployeeSaturday['VEHICLETRANSPORTPLANID'] ?>' class='list-group-item'>แก้ไขงาน</a><br>
                                                                               <a href='#' class='list-group-item' onclick='update_vehicletransportplanjob(<?= $result_seEmployeeSaturday['VEHICLETRANSPORTPLANID'] ?>,5)>ปิดงาน</a>"><i class="fa fa-list"></i></a>
                                                                        </td>
                                                                        <?php
                                                                    }
                                                                    ?>



                                                                    <td <?php
                                                                    switch ($result_seEmployeeSaturday['STATUSNUMBER']) {
                                                                        case '0': {
                                                                                ?>
                                                                                    style="color: black"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '1': {
                                                                                    ?>
                                                                                    style="color: blue"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '2': {
                                                                                    ?>
                                                                                    style="color: red"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '3': {
                                                                                    ?>
                                                                                    style="color: #ffcb0b"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '4': {
                                                                                    ?>
                                                                                    style="color: green"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '5': {
                                                                                    ?>
                                                                                    style="color: darkgray"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            default : {
                                                                                    
                                                                                }
                                                                                break;
                                                                        }
                                                                        ?>><?= $result_seEmployeeSaturday['JOBNO'] ?></td>
                                                                    <td ><?= $result_seEmployeeSaturday['CUSTOMERCODE'] ?></td>
                                                                    <td ><?= $result_seEmployeeSaturday['VEHICLEREGISNUMBER1'] ?></td>
                                                                    <td ><?= $result_seEmployeeSaturday['EMPLOYEENAME1'] ?></td>
                                                                    <td ><?= $result_seEmployeeSaturday['EMPLOYEENAME2'] ?></td>
                                                                    <td><?= $result_seEmployeeSaturday['JOBSTART'] ?></td>
                                                                    <td><?= $result_seEmployeeSaturday['JOBEND'] ?></td>
                                                                    <!--<td><?//= $result_seEmployeeSaturday['STATUS'] ?></td>-->
                                                                    <!--<td>
                                                                    <?php
                                                                    //if ($result_seEmployee['EMPLOYEENAME1'] == $_POST['employeename']) {
                                                                    ?>
                                                                            D1
                                                                    <?php
                                                                    //}
                                                                    //   if ($result_seEmployee['EMPLOYEENAME2'] == $_POST['employeename']) {
                                                                    ?>
                                                                            D2
                                                                    <?php
                                                                    //}
                                                                    //if ($result_seEmployee['EMPLOYEENAME'] == $_POST['employeename']) {
                                                                    ?>
                                                                            D3
                                                                    <?php
                                                                    //}
                                                                    //if ($result_seEmployee['EMPLOYEENAME4'] == $_POST['employeename']) {
                                                                    ?>
                                                                            D4
                                                                    <?php
                                                                    //}
                                                                    ?>
                                                                    </td>-->
                                                                    <?php
                                                                    $condMaxmileage = " AND JOBNO = '" . $result_seEmployeeSaturday['JOBNO'] . "' ";
                                                                    $sql_seMaxmile = "{call megMileage_v2(?,?)}";
                                                                    $params_seMaxmile = array(
                                                                        array('select_maxmileage', SQLSRV_PARAM_IN),
                                                                        array($condMaxmileage, SQLSRV_PARAM_IN)
                                                                    );
                                                                    $query_seMaxmile = sqlsrv_query($conn, $sql_seMaxmile, $params_seMaxmile);
                                                                    $result_seMaxmile = sqlsrv_fetch_array($query_seMaxmile, SQLSRV_FETCH_ASSOC);
                                                                    ?>
                                                                    <td contenteditable="true" onblur="save_mileage(this, 'MILEAGESTART', '<?= $result_seEmployeeSaturday['VEHICLEREGISNUMBER1'] ?>', '<?= $result_seEmployeeSaturday['JOBNO'] ?>')"><?= $result_seMaxmile['MAXMILEAGENUMBER'] ?></td>
                                                                    <?php
                                                                    if ($result_seEmployeeSaturday['STATUSNUMBER'] == '3') {
                                                                        ?>
                                                                        <td contenteditable="true" onblur="save_mileage(this, 'MILEAGEEND', '<?= $result_seEmployeeSaturday['VEHICLEREGISNUMBER1'] ?>', '<?= $result_seEmployeeSaturday['JOBNO'] ?>')"></td>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <td>&nbsp;</td>
                                                                        <?php
                                                                    }
                                                                    ?>


                                                                    <td><?= $result_seEmployeeSaturday['TIMEWORKING'] ?></td>
                                                                    <td><?= $result_seEmployeeSaturday['TIMEVLIN'] ?></td>
                                                                    <td><?= $result_seEmployeeSaturday['TIMEVLOUT'] ?></td>
                                                                    <td><?= $result_seEmployeeSaturday['TIMEDEALERIN'] ?></td>
                                                                    <td><?= $result_seEmployeeSaturday['TIMERETURN'] ?></td>
                                                                    <?php
                                                                    /* if ($result_seEmployeeSaturday['STATUSNUMBER'] == '2') {
                                                                      ?>
                                                                      <td style="text-align: center">

                                                                      <input   type="checkbox"  OnClick="if (this.checked) {
                                                                      check('<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_seEmployeeSaturday['JOBNO'] ?>', '<?= $result_seEmployeeSaturday['VEHICLETRANSPORTPLANID'] ?>', '3');
                                                                      } else {
                                                                      uncheck('<?= $result_seEmployeeSaturday['VEHICLETRANSPORTPLANID'] ?>', '2');
                                                                      }"  id="<?= $result_seEmployeeSaturday['VEHICLETRANSPORTPLANID'] ?>" name="<?= $result_seEmployeeSaturday['VEHICLETRANSPORTPLANID'] ?>"  style="width: 20px" class="form-control">
                                                                      </td>
                                                                      <?php
                                                                      } else if ($result_seEmployeeSaturday['STATUSNUMBER'] == '3') {
                                                                      ?>
                                                                      <td style="text-align: center">

                                                                      <input   type="checkbox"  OnClick="if (this.checked) {
                                                                      check('<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_seEmployeeSaturday['JOBNO'] ?>', '<?= $result_seEmployeeSaturday['VEHICLETRANSPORTPLANID'] ?>', '4');
                                                                      } else {
                                                                      uncheck('<?= $result_seEmployeeSaturday['VEHICLETRANSPORTPLANID'] ?>', '3');
                                                                      }"  id="<?= $result_seEmployeeSaturday['VEHICLETRANSPORTPLANID'] ?>" name="<?= $result_seEmployeeSaturday['VEHICLETRANSPORTPLANID'] ?>"  style="width: 20px" class="form-control">
                                                                      </td>
                                                                      <?php
                                                                      } else if ($result_seEmployeeSaturday['STATUSNUMBER'] == '1') {
                                                                      ?>
                                                                      <td style="text-align: center">
                                                                      <input   type="checkbox"  OnClick="if (this.checked) {
                                                                      check('<?= $result_seEmployeeMonday['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_seEmployeeSaturday['JOBNO'] ?>', '<?= $result_seEmployeeSaturday['VEHICLETRANSPORTPLANID'] ?>', '3');
                                                                      } else {
                                                                      uncheck('<?= $result_seEmployeeSaturday['VEHICLETRANSPORTPLANID'] ?>', '1');
                                                                      }"  id="<?= $result_seEmployeeSaturday['VEHICLETRANSPORTPLANID'] ?>" name="<?= $result_seEmployeeSaturday['VEHICLETRANSPORTPLANID'] ?>"  style="width: 20px" class="form-control">
                                                                      </td>
                                                                      <?php
                                                                      } */
                                                                    ?>
                                                                </tr>
                                                                <?php
                                                                $i++;
                                                            }
                                                            ?>

                                                        </tbody>
                                                    </table>


                                                </div>  
                                            </div>
                                            <div class="tab-pane fade" id="sunday-pills">
                                                <p>&nbsp;</p>
                                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                    <?php
                                                    $conditiionSunday1 = " AND DATENAME(DW,a.DATEPRESENT) = 'Sunday' ";
                                                    $conditiionSunday2 = " AND (a.DATEPRESENT BETWEEN CONVERT(datetime,'" . $result_getDate['STARTWEEK'] . "',103) AND CONVERT(datetime,'" . $result_getDate['ENDWEEK'] . "',103))";


                                                    $sql_seEmployeeSundaychk = "{call megVehicletransportplan_v2(?,?,?)}";
                                                    $params_seEmployeeSundaychk = array(
                                                        array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
                                                        array($conditiionSunday1, SQLSRV_PARAM_IN),
                                                        array($conditiionSunday2, SQLSRV_PARAM_IN)
                                                    );

                                                    $query_seEmployeeSundaychk = sqlsrv_query($conn, $sql_seEmployeeSundaychk, $params_seEmployeeSundaychk);
                                                    $result_seEmployeeSundaychk = sqlsrv_fetch_array($query_seEmployeeSundaychk, SQLSRV_FETCH_ASSOC);
                                                    ?>

                                                    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-sunday" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <?php
                                                                if ($result_seEmployeeSundaychk['STATUSNUMBER'] == '1' || $result_seEmployeeSundaychk['STATUSNUMBER'] == '3' || $result_seEmployeeSundaychk['STATUSNUMBER'] == '2') {
                                                                    ?>
                                                                    <th style="text-align: center">เปิด/ปิด</th>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <th style="text-align: center">&nbsp;</th>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <th style="text-align: center;width: 10%">เลขที่งาน</th>
                                                                <th style="text-align: center;width:5%">ลูกค้า</th>
                                                                <th style="text-align: center;width:5%">ทะเบียน</th>
                                                                <th style="text-align: center;width:10%">พนักงาน(1)</th>
                                                                <th style="text-align: center;width:10%">พนักงาน(2)</th>
                                                                <th style="text-align: center;width:10%">ต้นทาง</th>
                                                                <th style="text-align: center;width:10%">ปลายทาง</th>
                                                                <!--<th style="text-align: center;width:10%">สถานะ</th>-->
                                                                <!--<th>พขร.</th>-->
                                                                <th style="text-align: center;width:5%">ไมล์ต้น</th>
                                                                <th style="text-align: center;width:5%">ไมล์ปลาย</th>


                                                                <th style="text-align: center;width:5%">เปิดงาน</th>
                                                                <th style="text-align: center;width:5%">เข้า VL</th>
                                                                <th style="text-align: center;width:5%">ออก VL</th>
                                                                <th style="text-align: center;width:5%">เข้า DEALER</th>
                                                                <th style="text-align: center;width:5%">กลับบริษัท</th>


                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <?php
                                                            $sql_seEmployeeSunday = "{call megVehicletransportplan_v2(?,?,?)}";
                                                            $params_seEmployeeSunday = array(
                                                                array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
                                                                array($conditiionSunday1, SQLSRV_PARAM_IN),
                                                                array($conditiionSunday2, SQLSRV_PARAM_IN)
                                                            );
                                                            $i = 1;
                                                            $query_seEmployeeSunday = sqlsrv_query($conn, $sql_seEmployeeSunday, $params_seEmployeeSunday);
                                                            while ($result_seEmployeeSunday = sqlsrv_fetch_array($query_seEmployeeSunday, SQLSRV_FETCH_ASSOC)) {
                                                                ?>
                                                                <tr >



                                                                    <?php
                                                                    if ($result_seEmployeeSunday['STATUSNUMBER'] == '3') {
                                                                        ?> 
                                                                        <td style="text-align: center">
                                                                            <a href="#"  role="button" class="btn btn-default btn-circle" data-toggle="popover" title="" data-content="
                                                                               <a href='#' onclick='save_tenkomaster(<?= $result_seEmployeeSunday['VEHICLETRANSPORTPLANID'] ?>)' class='list-group-item'>รายงานตัวตรวจร่างกาย</a><br>
                                                                               <a href='#' class='list-group-item' onclick='update_vehicletransportplanjob(<?= $result_seEmployeeSunday['VEHICLETRANSPORTPLANID'] ?>,4)'>รายงานตัวกลับ</a><br>
                                                                               <a href='#' class='list-group-item'>แจ้งหยุด</a><br>
                                                                               <a href='meg_transportplan.php?type=transportplan&meg=add&companycode=<?= $result_seEmployeeSunday['COMPANYCODE'] ?>&customercode=<?= $result_seEmployeeSunday['CUSTOMERCODE'] ?>&vehicletransportplanid=<?= $result_seEmployeeSunday['VEHICLETRANSPORTPLANID'] ?>' class='list-group-item'>แก้ไขงาน</a><br>
                                                                               <a href='#' class='list-group-item' onclick='update_vehicletransportplanjob(<?= $result_seEmployeeSunday['VEHICLETRANSPORTPLANID'] ?>,5)'>ปิดงาน</a>"><i class="fa fa-list"></i></a>
                                                                        </td>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <td style="text-align: center">
                                                                            <a href="#"  role="button" class="btn btn-default btn-circle" data-toggle="popover" title="" data-content="
                                                                               <a href='#' onclick='save_tenkomaster(<?= $result_seEmployeeSunday['VEHICLETRANSPORTPLANID'] ?>)' class='list-group-item'>รายงานตัวตรวจร่างกาย</a><br>
                                                                               <a href='#' class='list-group-item'>แจ้งหยุด</a><br>
                                                                               <a href='meg_transportplan.php?type=transportplan&meg=add&companycode=<?= $result_seEmployeeSunday['COMPANYCODE'] ?>&customercode=<?= $result_seEmployeeSunday['CUSTOMERCODE'] ?>&vehicletransportplanid=<?= $result_seEmployeeSunday['VEHICLETRANSPORTPLANID'] ?>' class='list-group-item'>แก้ไขงาน</a><br>
                                                                               <a href='#' class='list-group-item' onclick='update_vehicletransportplanjob(<?= $result_seEmployeeSunday['VEHICLETRANSPORTPLANID'] ?>,5)'>ปิดงาน</a>"><i class="fa fa-list"></i></a>
                                                                        </td>
                                                                        <?php
                                                                    }
                                                                    ?>



                                                                    <td <?php
                                                                    switch ($result_seEmployeeSunday['STATUSNUMBER']) {
                                                                        case '0': {
                                                                                ?>
                                                                                    style="color: black"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '1': {
                                                                                    ?>
                                                                                    style="color: blue"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '2': {
                                                                                    ?>
                                                                                    style="color: red"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '3': {
                                                                                    ?>
                                                                                    style="color: #ffcb0b"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '4': {
                                                                                    ?>
                                                                                    style="color: green"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            case '5': {
                                                                                    ?>
                                                                                    style="color: darkgray"
                                                                                    <?php
                                                                                }
                                                                                break;
                                                                            default : {
                                                                                    
                                                                                }
                                                                                break;
                                                                        }
                                                                        ?>><?= $result_seEmployeeSunday['JOBNO'] ?></td>
                                                                    <td ><?= $result_seEmployeeSunday['CUSTOMERCODE'] ?></td>
                                                                    <td ><?= $result_seEmployeeSunday['VEHICLEREGISNUMBER1'] ?></td>
                                                                    <td ><?= $result_seEmployeeSunday['EMPLOYEENAME1'] ?></td>
                                                                    <td ><?= $result_seEmployeeSunday['EMPLOYEENAME2'] ?></td>
                                                                    <td><?= $result_seEmployeeSunday['JOBSTART'] ?></td>
                                                                    <td><?= $result_seEmployeeSunday['JOBEND'] ?></td>
                                                                    <!--<td><?//= $result_seEmployeeSunday['STATUS'] ?></td>-->
                                                                    <!--<td>
                                                                    <?php
                                                                    //if ($result_seEmployee['EMPLOYEENAME1'] == $_POST['employeename']) {
                                                                    ?>
                                                                            D1
                                                                    <?php
                                                                    //}
                                                                    //   if ($result_seEmployee['EMPLOYEENAME2'] == $_POST['employeename']) {
                                                                    ?>
                                                                            D2
                                                                    <?php
                                                                    //}
                                                                    //if ($result_seEmployee['EMPLOYEENAME'] == $_POST['employeename']) {
                                                                    ?>
                                                                            D3
                                                                    <?php
                                                                    //}
                                                                    //if ($result_seEmployee['EMPLOYEENAME4'] == $_POST['employeename']) {
                                                                    ?>
                                                                            D4
                                                                    <?php
                                                                    //}
                                                                    ?>
                                                                    </td>-->
                                                                    <?php
                                                                    $condMaxmileage = " AND JOBNO = '" . $result_seEmployeeSunday['JOBNO'] . "' ";
                                                                    $sql_seMaxmile = "{call megMileage_v2(?,?)}";
                                                                    $params_seMaxmile = array(
                                                                        array('select_maxmileage', SQLSRV_PARAM_IN),
                                                                        array($condMaxmileage, SQLSRV_PARAM_IN)
                                                                    );
                                                                    $query_seMaxmile = sqlsrv_query($conn, $sql_seMaxmile, $params_seMaxmile);
                                                                    $result_seMaxmile = sqlsrv_fetch_array($query_seMaxmile, SQLSRV_FETCH_ASSOC);
                                                                    ?>
                                                                    <td contenteditable="true" onblur="save_mileage(this, 'MILEAGESTART', '<?= $result_seEmployeeSunday['VEHICLEREGISNUMBER1'] ?>', '<?= $result_seEmployeeSunday['JOBNO'] ?>')"><?= $result_seMaxmile['MAXMILEAGENUMBER'] ?></td>
                                                                    <?php
                                                                    if ($result_seEmployeeSunday['STATUSNUMBER'] == '3') {
                                                                        ?>
                                                                        <td contenteditable="true" onblur="save_mileage(this, 'MILEAGEEND', '<?= $result_seEmployeeSunday['VEHICLEREGISNUMBER1'] ?>', '<?= $result_seEmployeeSunday['JOBNO'] ?>')"></td>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <td>&nbsp;</td>
                                                                        <?php
                                                                    }
                                                                    ?>


                                                                    <td><?= $result_seEmployeeSunday['TIMEWORKING'] ?></td>
                                                                    <td><?= $result_seEmployeeSunday['VEHICLETRANSPORTPLANID'] ?></td>
                                                                    <td><?= $result_seEmployeeSunday['TIMEVLOUT'] ?></td>
                                                                    <td><?= $result_seEmployeeSunday['TIMEDEALERIN'] ?></td>
                                                                    <td><?= $result_seEmployeeSunday['TIMERETURN'] ?></td>
                                                                    <?php
                                                                    /*  if ($result_seEmployeeSunday['STATUSNUMBER'] == '2') {
                                                                      ?>
                                                                      <td style="text-align: center">

                                                                      <input   type="checkbox"  OnClick="if (this.checked) {
                                                                      check('<?= $result_seEmployeeSunday['JOBNO'] ?>', '<?= $result_seEmployeeSunday['VEHICLETRANSPORTPLANID'] ?>', '3');
                                                                      } else {
                                                                      uncheck('<?= $result_seEmployeeSunday['VEHICLETRANSPORTPLANID'] ?>', '2');
                                                                      }"  id="<?= $result_seEmployeeSunday['VEHICLETRANSPORTPLANID'] ?>" name="<?= $result_seEmployeeSunday['VEHICLETRANSPORTPLANID'] ?>"  style="width: 20px" class="form-control">
                                                                      </td>
                                                                      <?php
                                                                      } else if ($result_seEmployeeSunday['STATUSNUMBER'] == '3') {
                                                                      ?>
                                                                      <td style="text-align: center">

                                                                      <input   type="checkbox"  OnClick="if (this.checked) {
                                                                      check('<?= $result_seEmployeeSunday['JOBNO'] ?>', '<?= $result_seEmployeeSunday['VEHICLETRANSPORTPLANID'] ?>', '4');
                                                                      } else {
                                                                      uncheck('<?= $result_seEmployeeSunday['VEHICLETRANSPORTPLANID'] ?>', '3');
                                                                      }"  id="<?= $result_seEmployeeSunday['VEHICLETRANSPORTPLANID'] ?>" name="<?= $result_seEmployeeSunday['VEHICLETRANSPORTPLANID'] ?>"  style="width: 20px" class="form-control">
                                                                      </td>
                                                                      <?php
                                                                      } else if ($result_seEmployeeSunday['STATUSNUMBER'] == '1') {
                                                                      ?>
                                                                      <td style="text-align: center">
                                                                      <input   type="checkbox"  OnClick="if (this.checked) {
                                                                      check('<?= $result_seEmployeeSunday['JOBNO'] ?>', '<?= $result_seEmployeeSunday['VEHICLETRANSPORTPLANID'] ?>', '3');
                                                                      } else {
                                                                      uncheck('<?= $result_seEmployeeSunday['VEHICLETRANSPORTPLANID'] ?>', '1');
                                                                      }"  id="<?= $result_seEmployeeSunday['VEHICLETRANSPORTPLANID'] ?>" name="<?= $result_seEmployeeSunday['VEHICLETRANSPORTPLANID'] ?>"  style="width: 20px" class="form-control">
                                                                      </td>
                                                                      <?php
                                                                      } */
                                                                    ?>


                                                                </tr>
                                                                <?php
                                                                $i++;
                                                            }
                                                            ?>

                                                        </tbody>
                                                    </table>


                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                    <div id="data_sr"></div>

                                    <!-- /.panel-body -->
                                </div>
                                <!-- /.panel -->
                            </div>
                        </div>
                    </div>
                </form>
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
    </body>

    <script>
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
                       
                                                                                window.location.href = "meg_tenkodocument.php?vehicletransportplanid=" + vehicletransportplanid;
                                                                            }
                                                                        });

                                                                    }


                                                                    function btn_submitall()
                                                                    {

                                                                        var condition1 = "";
                                                                        var condition2 = "";
                                                                        if (document.getElementById("txt_datestartsr1").value != "" && document.getElementById("txt_dateendsr1").value != "")
                                                                        {
                                                                            condition1 = " AND a.STATUSNUMBER IN ('0','1','2','3','4','5') AND ( CONVERT(DATE,DATEPRESENT) BETWEEN CONVERT(DATE,'" + document.getElementById("txt_datestartsr1").value + "',103) AND CONVERT(DATE,'" + document.getElementById("txt_dateendsr1").value + "',103))";
                                                                        } else
                                                                        {
                                                                            condition2 = " AND a.STATUSNUMBER IN ('0','1','2','3','4','5')";

                                                                        }
                                                                        $.ajax({
                                                                            url: 'meg_data.php',
                                                                            type: 'POST',
                                                                            data: {
                                                                                txt_flg: "select_vehicletransportworking", condition1: condition1, condition2: condition2
                                                                            },
                                                                            success: function (response) {
                                                                                if (response)
                                                                                {

                                                                                    document.getElementById("data_sr").innerHTML = response;
                                                                                    document.getElementById("data_def").innerHTML = "";


                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-monday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-tuesday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-wednesday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-thursday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-friday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-saturday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-sunday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
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
                                                                                    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                                                                                        $($.fn.dataTable.tables(true)).DataTable()
                                                                                                .columns.adjust()
                                                                                                .responsive.recalc();
                                                                                    });
                                                                                    $('[data-toggle="popover"]').popover({
                                                                                        html: true,
                                                                                        content: function () {
                                                                                            return $('#popover-content').html();
                                                                                        }
                                                                                    });
                                                                                }

                                                                            }
                                                                        });
                                                                        //window.location.href = 'meg_employee3.php?condition1=' + condition1 + '&condition2' + condition2;



                                                                    }

                                                                    function btn_submit0()
                                                                    {
                                                                        var condition1 = "";
                                                                        var condition2 = "";
                                                                        if (document.getElementById("txt_datestartsr1").value != "" && document.getElementById("txt_dateendsr1").value != "")
                                                                        {
                                                                            condition1 = " AND a.STATUSNUMBER = '0' AND ( CONVERT(DATE,DATEPRESENT) BETWEEN CONVERT(DATE,'" + document.getElementById("txt_datestartsr1").value + "',103) AND CONVERT(DATE,'" + document.getElementById("txt_dateendsr1").value + "',103))";
                                                                        } else
                                                                        {
                                                                            condition2 = " AND a.STATUSNUMBER = '0'";

                                                                        }
                                                                        $.ajax({
                                                                            url: 'meg_data.php',
                                                                            type: 'POST',
                                                                            data: {
                                                                                txt_flg: "select_vehicletransportworking", condition1: condition1, condition2: condition2
                                                                            },
                                                                            success: function (response) {
                                                                                if (response)
                                                                                {

                                                                                    document.getElementById("data_sr").innerHTML = response;
                                                                                    document.getElementById("data_def").innerHTML = "";

                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-monday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-tuesday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-wednesday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-thursday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-friday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-saturday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-sunday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
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
                                                                                    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                                                                                        $($.fn.dataTable.tables(true)).DataTable()
                                                                                                .columns.adjust()
                                                                                                .responsive.recalc();
                                                                                    });
                                                                                    $('[data-toggle="popover"]').popover({
                                                                                        html: true,
                                                                                        content: function () {
                                                                                            return $('#popover-content').html();
                                                                                        }
                                                                                    });
                                                                                }
                                                                            }
                                                                        });
                                                                        //window.location.href = 'meg_employee3.php?condition1=' + condition1 + '&condition2' + condition2;

                                                                    }
                                                                    function btn_submit1()
                                                                    {
                                                                        var condition1 = "";
                                                                        var condition2 = "";
                                                                        if (document.getElementById("txt_datestartsr1").value != "" && document.getElementById("txt_dateendsr1").value != "")
                                                                        {
                                                                            condition1 = " AND a.STATUSNUMBER = '1' AND ( CONVERT(DATE,DATEPRESENT) BETWEEN CONVERT(DATE,'" + document.getElementById("txt_datestartsr1").value + "',103) AND CONVERT(DATE,'" + document.getElementById("txt_dateendsr1").value + "',103))";
                                                                        } else
                                                                        {
                                                                            condition2 = " AND a.STATUSNUMBER = '1'";

                                                                        }
                                                                        $.ajax({
                                                                            url: 'meg_data.php',
                                                                            type: 'POST',
                                                                            data: {
                                                                                txt_flg: "select_vehicletransportworking", condition1: condition1, condition2: condition2
                                                                            },
                                                                            success: function (response) {
                                                                                if (response)
                                                                                {

                                                                                    document.getElementById("data_sr").innerHTML = response;
                                                                                    document.getElementById("data_def").innerHTML = "";

                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-monday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-tuesday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-wednesday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-thursday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-friday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-saturday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-sunday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
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
                                                                                    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                                                                                        $($.fn.dataTable.tables(true)).DataTable()
                                                                                                .columns.adjust()
                                                                                                .responsive.recalc();
                                                                                    });
                                                                                    $('[data-toggle="popover"]').popover({
                                                                                        html: true,
                                                                                        content: function () {
                                                                                            return $('#popover-content').html();
                                                                                        }
                                                                                    });
                                                                                }
                                                                            }
                                                                        });
                                                                        //window.location.href = 'meg_employee3.php?condition1=' + condition1 + '&condition2' + condition2;

                                                                    }
                                                                    function btn_submit2()
                                                                    {
                                                                        var condition1 = "";
                                                                        var condition2 = "";
                                                                        if (document.getElementById("txt_datestartsr1").value != "" && document.getElementById("txt_dateendsr1").value != "")
                                                                        {
                                                                            condition1 = " AND a.STATUSNUMBER = '2' AND ( CONVERT(DATE,DATEPRESENT) BETWEEN CONVERT(DATE,'" + document.getElementById("txt_datestartsr1").value + "',103) AND CONVERT(DATE,'" + document.getElementById("txt_dateendsr1").value + "',103))";
                                                                        } else
                                                                        {
                                                                            condition2 = " AND a.STATUSNUMBER = '2'";

                                                                        }
                                                                        $.ajax({
                                                                            url: 'meg_data.php',
                                                                            type: 'POST',
                                                                            data: {
                                                                                txt_flg: "select_vehicletransportworking", condition1: condition1, condition2: condition2
                                                                            },
                                                                            success: function (response) {
                                                                                if (response)
                                                                                {

                                                                                    document.getElementById("data_sr").innerHTML = response;
                                                                                    document.getElementById("data_def").innerHTML = "";

                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-monday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-tuesday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-wednesday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-thursday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-friday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-saturday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-sunday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
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
                                                                                    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                                                                                        $($.fn.dataTable.tables(true)).DataTable()
                                                                                                .columns.adjust()
                                                                                                .responsive.recalc();
                                                                                    });
                                                                                    $('[data-toggle="popover"]').popover({
                                                                                        html: true,
                                                                                        content: function () {
                                                                                            return $('#popover-content').html();
                                                                                        }
                                                                                    });
                                                                                }
                                                                            }
                                                                        });
                                                                        //window.location.href = 'meg_employee3.php?condition1=' + condition1 + '&condition2' + condition2;

                                                                    }
                                                                    function btn_submit3()
                                                                    {
                                                                        var condition1 = "";
                                                                        var condition2 = "";
                                                                        if (document.getElementById("txt_datestartsr1").value != "" && document.getElementById("txt_dateendsr1").value != "")
                                                                        {
                                                                            condition1 = " AND a.STATUSNUMBER = '3' AND ( CONVERT(DATE,DATEPRESENT) BETWEEN CONVERT(DATE,'" + document.getElementById("txt_datestartsr1").value + "',103) AND CONVERT(DATE,'" + document.getElementById("txt_dateendsr1").value + "',103))";
                                                                        } else
                                                                        {
                                                                            condition2 = " AND a.STATUSNUMBER = '3'";

                                                                        }
                                                                        $.ajax({
                                                                            url: 'meg_data.php',
                                                                            type: 'POST',
                                                                            data: {
                                                                                txt_flg: "select_vehicletransportworking", condition1: condition1, condition2: condition2
                                                                            },
                                                                            success: function (response) {
                                                                                if (response)
                                                                                {

                                                                                    document.getElementById("data_sr").innerHTML = response;
                                                                                    document.getElementById("data_def").innerHTML = "";

                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-monday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-tuesday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-wednesday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-thursday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-friday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-saturday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-sunday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
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
                                                                                    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                                                                                        $($.fn.dataTable.tables(true)).DataTable()
                                                                                                .columns.adjust()
                                                                                                .responsive.recalc();
                                                                                    });
                                                                                    $('[data-toggle="popover"]').popover({
                                                                                        html: true,
                                                                                        content: function () {
                                                                                            return $('#popover-content').html();
                                                                                        }
                                                                                    });
                                                                                }
                                                                            }
                                                                        });
                                                                        // window.location.href = 'meg_employee3.php?condition1=' + condition1 + '&condition2' + condition2;
                                                                    }
                                                                    function btn_submit4()
                                                                    {
                                                                        var condition1 = "";
                                                                        var condition2 = "";
                                                                        if (document.getElementById("txt_datestartsr1").value != "" && document.getElementById("txt_dateendsr1").value != "")
                                                                        {
                                                                            condition1 = " AND a.STATUSNUMBER  = '4' AND ( CONVERT(DATE,DATEPRESENT) BETWEEN CONVERT(DATE,'" + document.getElementById("txt_datestartsr1").value + "',103) AND CONVERT(DATE,'" + document.getElementById("txt_dateendsr1").value + "',103))";
                                                                        } else
                                                                        {
                                                                            condition2 = " AND a.STATUSNUMBER  = '4'";

                                                                        }
                                                                        $.ajax({
                                                                            url: 'meg_data.php',
                                                                            type: 'POST',
                                                                            data: {
                                                                                txt_flg: "select_vehicletransportworking", condition1: condition1, condition2: condition2
                                                                            },
                                                                            success: function (response) {
                                                                                if (response)
                                                                                {

                                                                                    document.getElementById("data_sr").innerHTML = response;
                                                                                    document.getElementById("data_def").innerHTML = "";

                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-monday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-tuesday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-wednesday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-thursday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-friday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-saturday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-sunday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
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
                                                                                    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                                                                                        $($.fn.dataTable.tables(true)).DataTable()
                                                                                                .columns.adjust()
                                                                                                .responsive.recalc();
                                                                                    });
                                                                                    $('[data-toggle="popover"]').popover({
                                                                                        html: true,
                                                                                        content: function () {
                                                                                            return $('#popover-content').html();
                                                                                        }
                                                                                    });
                                                                                }
                                                                            }
                                                                        });
                                                                        //window.location.href = 'meg_employee3.php?condition1=' + condition1 + '&condition2' + condition2;

                                                                    }
                                                                    function btn_submit5()
                                                                    {
                                                                        var condition1 = "";
                                                                        var condition2 = "";
                                                                        if (document.getElementById("txt_datestartsr1").value != "" && document.getElementById("txt_dateendsr1").value != "")
                                                                        {
                                                                            condition1 = " AND a.STATUSNUMBER = '5' AND ( CONVERT(DATE,DATEPRESENT) BETWEEN CONVERT(DATE,'" + document.getElementById("txt_datestartsr1").value + "',103) AND CONVERT(DATE,'" + document.getElementById("txt_dateendsr1").value + "',103))";
                                                                        } else
                                                                        {
                                                                            condition2 = " a.STATUSNUMBER = '5'";

                                                                        }
                                                                        $.ajax({
                                                                            url: 'meg_data.php',
                                                                            type: 'POST',
                                                                            data: {
                                                                                txt_flg: "select_vehicletransportworking", condition1: condition1, condition2: condition2
                                                                            },
                                                                            success: function (response) {
                                                                                if (response)
                                                                                {

                                                                                    document.getElementById("data_sr").innerHTML = response;
                                                                                    document.getElementById("data_def").innerHTML = "";

                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-monday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-tuesday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-wednesday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-thursday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-friday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-saturday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
                                                                                    });
                                                                                    $(document).ready(function () {
                                                                                        $('#dataTables-sunday').DataTable({
                                                                                            responsive: false,
                                                                                            scrollX: true,
                                                                                            scrollY: '500px',
                                                                                        });
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
                                                                                    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                                                                                        $($.fn.dataTable.tables(true)).DataTable()
                                                                                                .columns.adjust()
                                                                                                .responsive.recalc();
                                                                                    });
                                                                                    $('[data-toggle="popover"]').popover({
                                                                                        html: true,
                                                                                        content: function () {
                                                                                            return $('#popover-content').html();
                                                                                        }
                                                                                    });
                                                                                }
                                                                            }
                                                                        });
                                                                        //window.location.href = 'meg_employee3.php?condition1=' + condition1 + '&condition2' + condition2;

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
                                                                    function edit_vehicletransportplanactualpresent(ID)
                                                                    {

                                                                        $.ajax({
                                                                            url: 'meg_data.php',
                                                                            type: 'POST',
                                                                            data: {
                                                                                txt_flg: "edit_vehicletransportplan", ID: ID, fieldname: 'DATEPRESENT', editableObj: 'GETDATE()'
                                                                            },
                                                                            success: function () {

                                                                                window.location.reload();
                                                                            }
                                                                        });
                                                                    }
                                                                    function edit_vehicletransportplanactual(editableObj, fieldname, ID)
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
                                                                    function edit_vehicletransportplan(editableObj, fieldname, ID)
                                                                    {

                                                                        $.ajax({
                                                                            url: 'meg_data.php',
                                                                            type: 'POST',
                                                                            data: {
                                                                                txt_flg: "edit_vehicletransportplan", editableObj: editableObj.innerHTML, ID: ID, fieldname: fieldname
                                                                            },
                                                                            success: function () {

                                                                            }
                                                                        });
                                                                    }

                                                                    function update_jobstatus()
                                                                    {

                                                                        $.ajax({
                                                                            type: 'post',
                                                                            url: 'meg_data.php',
                                                                            data: {
                                                                                txt_flg: "update_jobstatus"
                                                                            },
                                                                            success: function () {
                                                                                window.location.reload();
                                                                            }
                                                                        });
                                                                    }




                                                                    function closeWin() {
                                                                        window.location.reload();
                                                                    }
                                                                    function check(id, jobno, rootno, statusnumber) {

                                                                        $.ajax({
                                                                            type: 'post',
                                                                            url: 'meg_data.php',
                                                                            data: {
                                                                                txt_flg: "select_vehicletransportplanid", jobno: jobno
                                                                            },
                                                                            success: function () {


                                                                                var r = confirm("ยืนยันการเปิดงาน ?");
                                                                                if (r == true) {
                                                                                    update_vehicletransportplanjob(rootno, statusnumber);
                                                                                    window.location.reload();
                                                                                } else {
                                                                                    document.getElementById(id).checked = false;
                                                                                }

                                                                            }

                                                                        });
                                                                    }
                                                                    function uncheck(rootno, statusnumber) {
                                                                        var r = confirm("ยืนยันการปิดงาน ?");
                                                                        if (r == true) {
                                                                            ocation.reload();
                                                                            update_vehicletransportplanjob(rootno, statusnumber);
                                                                            window.location.reload();
                                                                        } else {
                                                                            document.getElementById(rootno).checked = false;
                                                                        }

                                                                    }



                                                                    function update_vehicletransportplanjob(rootno, statusnumber)
                                                                    {

                                                                        $.ajax({
                                                                            type: 'post',
                                                                            url: 'meg_data.php',
                                                                            data: {
                                                                                txt_flg: "edit_vehicletransportplanjob", rootno: rootno, statusnumber: statusnumber
                                                                            },
                                                                            success: function () {

                                                                                window.location.reload();
                                                                            }
                                                                        });
                                                                    }

                                                                    function showdata_employee(employeecode1, employeecode2, employeename, statusnumber)
                                                                    {

                                                                        $.ajax({
                                                                            type: 'post',
                                                                            url: 'meg_data.php',
                                                                            data: {
                                                                                txt_flg: "select_vehicletransportemployee", employeecode1: employeecode1, employeecode2: employeecode2, employeename: employeename, statusnumber: statusnumber
                                                                            },
                                                                            success: function (response) {
                                                                                if (response)
                                                                                {

                                                                                    document.getElementById("datasr").innerHTML = response;
                                                                                    document.getElementById("datadef").innerHTML = "";
                                                                                }
                                                                                $(document).ready(function () {
                                                                                    $('#dataTables-example').DataTable({
                                                                                        responsive: true,
                                                                                        order: [[0, "desc"]]
                                                                                    });
                                                                                    $("#txt_dateworking").datetimepicker({
                                                                                        dateFormat: 'Y-m-d',
                                                                                        timeFormat: "HH:mm"
                                                                                    });
                                                                                    $('[data-toggle="popover"]').popover({
                                                                                        html: true,
                                                                                        content: function () {
                                                                                            return $('#popover-content').html();
                                                                                        }
                                                                                    });
                                                                                });
                                                                            }
                                                                        });
                                                                    }
                                                                    /* function showdata_employeefooter(employeecode1, employeecode2, companycode, customercode)
                                                                     {
                                                                     
                                                                     $.ajax({
                                                                     type: 'post',
                                                                     url: 'meg_data.php',
                                                                     data: {
                                                                     txt_flg: "select_vehicletransportemployeefooter", companycode: companycode, customercode: customercode, employeecode1: employeecode1, employeecode2: employeecode2
                                                                     },
                                                                     success: function (response) {
                                                                     if (response)
                                                                     {
                                                                     document.getElementById("datasrfooter").innerHTML = response;
                                                                     document.getElementById("datadeffooter").innerHTML = "";
                                                                     }
                                                                     }
                                                                     });
                                                                     }*/
                                                                    function select_companycustomer(employeecode1, employeecode2, employeename, statusnumber)
                                                                    {
                                                                        $.ajax({
                                                                            type: 'post',
                                                                            url: 'meg_data.php',
                                                                            data: {
                                                                                txt_flg: "select_companycustomer", employeename: employeename
                                                                            },
                                                                            success: function (response) {

                                                                                var result = response.split('|');
                                                                                showdata_employee(employeecode1, employeecode2, employeename, statusnumber);
                                                                                //showdata_employeefooter(employeecode1, employeecode2, result[0], result[1]);
                                                                            }
                                                                        });
                                                                    }

                                                                    function select_employee(employeecode1, employeecode2, employeename, statusnumber, vehicleregisnumber, thainame) {

                                                                        select_companycustomer(employeecode1, employeecode2, employeename, statusnumber);
                                                                        $(document).ready(function () {
                                                                            document.getElementById("employee").innerHTML = 'ทะเบียนรถ : ' + vehicleregisnumber + ' (' + thainame + ')';
                                                                            /*document.getElementById("employeeimage").innerHTML = '';
                                                                             var img = document.createElement("img");
                                                                             img.src = src;
                                                                             img.width = 100;
                                                                             img.height = 60;
                                                                             document.getElementById("employeeimage").appendChild(img);
                                                                             */
                                                                        });
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
                    document.getElementById("txt_dateendsr1").value = res[0];
                    /*document.getElementById("lab_monday").innerHTML = '(' + res[1] + ')';
                     document.getElementById("lab_tuesday").innerHTML = '(' + res[2] + ')';
                     document.getElementById("lab_wednesday").innerHTML = '(' + res[3] + ')';
                     document.getElementById("lab_thursday").innerHTML = '(' + res[4] + ')';
                     document.getElementById("lab_friday").innerHTML = '(' + res[5] + ')';
                     document.getElementById("lab_saturday").innerHTML = '(' + res[6] + ')';
                     document.getElementById("lab_sunday").innerHTML = '(' + res[7] + ')';*/

                    btn_submitall(datestart);
                }
            });
        }




    </script>
    <script>

        $(function () {
            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
            // กรณีใช้แบบ input
            $(".dateennoweek").datetimepicker({
                timepicker: false,
                format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000			
                lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                beforeShowDay: noWeekends

            });
        });
        $(function () {
            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
            // กรณีใช้แบบ input
            $(".dateen").datetimepicker({
                timepicker: false,
                format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00 - 00 - 0000
                lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


            }
            );
        });</script>
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
    <script>
        $(document).ready(function () {
            $('#dataTables-monday').DataTable({
                responsive: false,
                scrollX: true,
                scrollY: '500px',
            });
        });
        $(document).ready(function () {
            $('#dataTables-tuesday').DataTable({
                responsive: false,
                scrollX: true,
                scrollY: '500px',
            });
        });
        $(document).ready(function () {
            $('#dataTables-wednesday').DataTable({
                responsive: false,
                scrollX: true,
                scrollY: '500px',
            });
        });
        $(document).ready(function () {
            $('#dataTables-thursday').DataTable({
                responsive: false,
                scrollX: true,
                scrollY: '500px',
            });
        });
        $(document).ready(function () {
            $('#dataTables-friday').DataTable({
                responsive: false,
                scrollX: true,
                scrollY: '500px',
            });
        });
        $(document).ready(function () {
            $('#dataTables-saturday').DataTable({
                responsive: false,
                scrollX: true,
                scrollY: '500px',
            });
        });
        $(document).ready(function () {
            $('#dataTables-sunday').DataTable({
                responsive: false,
                scrollX: true,
                scrollY: '500px',
            });
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
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust()
                    .responsive.recalc();
        });
    </script>
</body>



</html>
<?php
sqlsrv_close($conn);
?>