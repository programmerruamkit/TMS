
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
ini_set('max_execution_time', 300);
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

// $condiCompany = " AND Company_Code = '" . $_GET['companycode'] . "'";
// $sql_seCompany = "{call megCompany_v2(?,?)}";
// $params_seCompany = array(
//     array('select_company', SQLSRV_PARAM_IN),
//     array($condiCompany, SQLSRV_PARAM_IN)
// );
// $query_seCompany = sqlsrv_query($conn, $sql_seCompany, $params_seCompany);
// $result_seCompany = sqlsrv_fetch_array($query_seCompany, SQLSRV_FETCH_ASSOC);

// $condiCustomer = " AND a.CUSTOMERCODE = '" . $_GET['customercode'] . "'";
// $sql_seCustomer = "{call megCustomer_v2(?,?)}";
// $params_seCustomer = array(
//     array('select_customer', SQLSRV_PARAM_IN),
//     array($condiCustomer, SQLSRV_PARAM_IN)
// );
// $query_seCustomer = sqlsrv_query($conn, $sql_seCustomer, $params_seCustomer);
// $result_seCustomer = sqlsrv_fetch_array($query_seCustomer, SQLSRV_FETCH_ASSOC);

$condition1 = "  AND a.PersonID = '" . $_SESSION["EMPLOYEEID"] . "'";
$sql_seEmployee = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmployee = array(
    array('select_employee', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
$result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC);

$month =  date("Y");
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
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">
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




        </style>

    </head>

    <body>

        <!-- <div id="wrapper"> -->

            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <?php
                include '../pages/meg_header.php';
                // include '../pages/meg_leftmenu.php';
                ?>
            </nav>

            <!-- <div id="page-wrapper" > -->
                <div class="row" >
                    <div class="col-lg-12">
                        
                        <h2 class="page-header"><i class="fa fa-file-text-o"></i>
                        รายงานข้อมูลการใบแจ้งสุขภาพตนเอง ของพนักงาน


                        </h2>
                    </div>

                    <!-- /.col-lg-12 -->
                </div>

                <div class="row" >
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="row" >
                                    <div class="col-lg-6">

                                        <a href='index2.php?type=report'>หน้าหลัก</a>/รายงานข้อมูลการใบแจ้งสุขภาพตนเอง ของพนักงาน

                                    </div>
                                    <div class="col-lg-6 text-right"></div>
                                </div>
                            </div>

                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <!-- Tab panes -->
                                <div class="tab-content">

                                <?php
                                if ($_SESSION["ROLENAME"] == 'ADMIN' || $_SESSION["ROLENAME"] == 'TENKO(AMT)' || $_SESSION["ROLENAME"] == 'TENKO(GW)') {
                                ?>
                                    <div class="row">&nbsp;</div>
                                    <b style="color:red;">*วันที่สำหรับค้นหาข้อมูลรายบุคคล (เมนูเฉพาะ ADMIN,TENKO(AMT),TENKO(GW))</b>
                                    <div class="row" >
                                        <div class="col-lg-12">
                                            <div class="well">
                                                <div class="row">


                                                    <div class="col-lg-2">

                                                        <div class="form-group">
                                                            <label>ค้นหาตามช่วงวันที่</label>
                                                            <input class="form-control dateen" readonly="" onchange="datetodatepersonal();" style="background-color: #f080802e"  id="txt_datestart_personal" name="txt_datestart_personal" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">
                                                        </div>

                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>&nbsp;</label>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control dateen"  readonly=""  style="background-color: #f080802e" id="txt_dateend_personal" name="txt_dateend_personal" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE']; ?>">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-lg-2">
                                                        <label>เลือกพนักงาน:</label>
                                                        <div class="dropdown bootstrap-select show-tick form-control">
                                                            <!-- $emp = select_empautocomplate('megEmployeeEHR_v2', 'select_employeehealth', ""); -->
                                                            <select   id="txt_drivercode" name="txt_drivercode" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก พนักงาน..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
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
                                                                    <option value="<?= $result_seName['PersonCode'] ?>"><?= $result_seName['nameT'] ?> (<?= $result_seName['PersonCode'] ?>)</option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            <input class="form-control" style="display: none"   id="txt_copydiagramzone" name="txt_copydiagramzone" maxlength="500" value="" >
                                                        </div>
                                                    </div>
                                                        
                                                    <div class="col-lg-1">
                                                        <label>&nbsp;</label>
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-default" onclick="select_selfcheckdata_personal();">ค้นหา <li class="fa fa-search"></li></button>
                                                        </div>

                                                    </div>


                                                    <!-- <div class="col-lg-2" style="text-align: left">
                                                        <label>&nbsp;</label><br>
                                                        <a href="#" onclick="excel_reporttransportcover();" class="btn btn-success  ">EXCEL <li class="fa fa-file-excel-o"></li></a>
                                                        <a href="#" onclick="pdf_reporttransportcover();" class="btn btn-danger">PDF <li class="fa fa-file-pdf-o"></li></a>

                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }else {
                                    ?>

                                    <?php
                                    }
                                    ?>
                                        
                                        <div class="row">&nbsp;</div>
                                        &nbsp;&nbsp;&nbsp;<b style="color:red;">*ค้นหาข้อมูลรายงานการแจ้งสุขภาพตนเองรายบุคคล</b>
                                        <div class="col-lg-12">
                                            <div class="well">
                                                <div class="row">

                                                    <div class="col-lg-2">
                                                        <label>เลือกเดือน</label>
                                                        <select id="select_month" name="select_month" class="form-control" >
                                                            <option value="">เลือกเดือน</option>
                                                            <option value="01/01/<?=$month?>">มกราคม</option>
                                                            <option value="01/02/<?=$month?>">กุมภาพันธ์</option>
                                                            <option value="01/03/<?=$month?>">มีนาคม</option>
                                                            <option value="01/04/<?=$month?>">เมษายน</option>
                                                            <option value="01/05/<?=$month?>">พฤษภาคม</option>
                                                            <option value="01/06/<?=$month?>">มิถุนายน</option>
                                                            <option value="01/07/<?=$month?>">กรกฎาคม</option>
                                                            <option value="01/08/<?=$month?>">สิงหาคม</option>
                                                            <option value="01/09/<?=$month?>">กันยายน</option>
                                                            <option value="01/10/<?=$month?>">ตุลาคม</option>
                                                            <option value="01/11/<?=$month?>">พฤศจิกายน</option>
                                                            <option value="01/12/<?=$month?>">ธันวาคม</option>
                                                        </select>
                                                    </div>
                                                        
                                                    <div class="col-lg-2">
                                                        <label>เลือกพนักงาน:</label>
                                                        <div class="dropdown bootstrap-select show-tick form-control">
                                                            <!-- $emp = select_empautocomplate('megEmployeeEHR_v2', 'select_employeehealth', ""); -->
                                                            <select   id="txt_drivercodereport" name="txt_drivercodereport" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก พนักงาน..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
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
                                                                    <option value="<?= $result_seName['PersonCode'] ?>"><?= $result_seName['nameT'] ?> (<?= $result_seName['PersonCode'] ?>)</option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            <input class="form-control" style="display: none"   id="txt_copydiagramzone" name="txt_copydiagramzone" maxlength="500" value="" >
                                                        </div>
                                                    </div>
                                                        
                                                    <div class="col-lg-1">
                                                        <label>&nbsp;</label>
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-default" onclick="select_reportselfcheckdata();">ค้นหา <li class="fa fa-search"></li></button>
                                                        </div>

                                                    </div>


                                                    <!-- <div class="col-lg-2" style="text-align: left">
                                                        <label>&nbsp;</label><br>
                                                        <a href="#" onclick="excel_reporttransportcover();" class="btn btn-success  ">EXCEL <li class="fa fa-file-excel-o"></li></a>
                                                        <a href="#" onclick="pdf_reporttransportcover();" class="btn btn-danger">PDF <li class="fa fa-file-pdf-o"></li></a>

                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">&nbsp;</div>
                                        &nbsp;&nbsp;&nbsp;<b style="color:red;">*วันที่สำหรับค้นหาข้อมูลในตารางข้อมูล</b>
                                        <div class="col-lg-12">
                                            <div class="well">
                                                <div class="row">


                                                    <div class="col-lg-2">

                                                        <div class="form-group">
                                                            <label>ค้นหาตามช่วงวันที่</label>
                                                            <input class="form-control dateen" readonly="" onchange="datetodate();" style="background-color: #f080802e"  id="txt_datestart" name="txt_datestart" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">
                                                        </div>

                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>&nbsp;</label>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control dateen"  readonly=""  style="background-color: #f080802e" id="txt_dateend" name="txt_dateend" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE']; ?>">
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                        
                                                    <div class="col-lg-1">
                                                        <label>&nbsp;</label>
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-default" onclick="select_selfcheckdata();">ค้นหา <li class="fa fa-search"></li></button>
                                                        </div>

                                                    </div>


                                                    <!-- <div class="col-lg-2" style="text-align: left">
                                                        <label>&nbsp;</label><br>
                                                        <a href="#" onclick="excel_reporttransportcover();" class="btn btn-success  ">EXCEL <li class="fa fa-file-excel-o"></li></a>
                                                        <a href="#" onclick="pdf_reporttransportcover();" class="btn btn-danger">PDF <li class="fa fa-file-pdf-o"></li></a>

                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                           

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading" style="background-color: #e7e7e7">
                                                    รายงานข้อมูลการใบแจ้งสุขภาพตนเอง ของพนักงาน
                                                </div>
                                                <!-- /.panel-heading -->

                                                <div class="panel-body">

                                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                        <div id="datadef">
                                                            <table  style="width: 100%;" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info">
                                                                <thead>
                                                                    <tr>
                                                                        <th>NO</th>
                                                                        <th>SELFCHECKID</th>
                                                                        <th>CREATEDATE</th>
                                                                        <th>EMPLOYEECODE</th>
                                                                        <th>EMPLOYEENAME</th>
                                                                        <th>DETAIL</th>
                                                                        <?php
                                                                        if ($_SESSION["ROLENAME"] == "ADMIN") {
                                                                        ?>
                                                                         <th>ACTIVESTATUS</th>
                                                                         <th>CONFIRMBY</th>
                                                                         <th>DATEWORKING</th>
                                                                         <th>DATEPRESENT</th>
                                                                         <th>EDIT</th>
                                                                        <?php
                                                                        }else {
                                                                        ?>
                                                                        <th>ACTIVESTATUS</th>
                                                                        <th>CONFIRMBY</th>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    // DATEWORKING ,DATEPRESENT มาจากการกดยืนยันและบันทึกข้อมูล ในหน้าการตรวจสอบของเจ้าหน้าที่
                                                                    $i = 1;
                                                                    $DATE = date("d/m/Y");

                                                                    if ($_SESSION["ROLENAME"] == "ADMIN") {

                                                                        // ถ้า ADMIN เป็นคนเข้ามาดูจะโชว์แผนงานที่ ACTIVESTATUS ='0' และ Confirm by เป็นค่า NULL หรือ ค่าว่าง ด้วย
                                                                        $sql_seSelfCheck = "SELECT SELFCHECKID,EMPLOYEECODE,EMPLOYEENAME,DATEJOBSTART,DATEWORKING,DATEPRESENT,
                                                                            CONVERT(VARCHAR(10),CREATEDATE,103) AS 'CREATEDATE',ACTIVESTATUS,CONFIRMEDBY
                                                                            FROM DRIVERSELFCHECK
                                                                            WHERE CONVERT(DATE,CREATEDATE) = CONVERT(DATE,GETDATE(),103) 
                                                                            --AND ACTIVESTATUS ='1'
                                                                            --AND CONFIRMEDBY IS NOT NULL
                                                                            ORDER BY SELFCHECKID ASC";
                                                                        $params_seSelfCheck = array();
                                                                        $query_seSelfCheck = sqlsrv_query($conn, $sql_seSelfCheck, $params_seSelfCheck);

                                                                        // หาวันที่ ทำงาน DATERK,DATEPRESENT จากแผนงาน
                                                                        $sql_seSelfCheck = "SELECT SELFCHECKID,EMPLOYEECODE,EMPLOYEENAME,DATEJOBSTART,DATEWORKING,DATEPRESENT,
                                                                            CONVERT(VARCHAR(10),CREATEDATE,103) AS 'CREATEDATE',ACTIVESTATUS,CONFIRMEDBY
                                                                            FROM DRIVERSELFCHECK
                                                                            WHERE CONVERT(DATE,CREATEDATE) = CONVERT(DATE,GETDATE(),103) 
                                                                            --AND ACTIVESTATUS ='1'
                                                                            --AND CONFIRMEDBY IS NOT NULL
                                                                            ORDER BY SELFCHECKID ASC";
                                                                        $params_seSelfCheck = array();
                                                                        $query_seSelfCheck = sqlsrv_query($conn, $sql_seSelfCheck, $params_seSelfCheck);

                                                                    }else{

                                                                        // ถ้า USER ทั่วไป เป็นคนเข้ามาดูจะโชว์แผนงานที่ ACTIVESTATUS ='0' และ Confirm by เป็นค่า NULL หรือ ค่าว่าง ด้วย
                                                                        $sql_seSelfCheck = "SELECT SELFCHECKID,EMPLOYEECODE,EMPLOYEENAME,DATEJOBSTART,DATEWORKING,DATEPRESENT,
                                                                            CONVERT(VARCHAR(10),CREATEDATE,103) AS 'CREATEDATE',ACTIVESTATUS,CONFIRMEDBY
                                                                            FROM DRIVERSELFCHECK
                                                                            WHERE CONVERT(DATE,CREATEDATE) = CONVERT(DATE,GETDATE(),103) 
                                                                            -- AND ACTIVESTATUS ='1'
                                                                            --AND CONFIRMEDBY IS NOT NULL
                                                                            ORDER BY SELFCHECKID ASC";
                                                                        $params_seSelfCheck = array();
                                                                        $query_seSelfCheck = sqlsrv_query($conn, $sql_seSelfCheck, $params_seSelfCheck);      
                                                                    }        
                                                                
                                                              

                                                                    while ($result_seSelfCheck = sqlsrv_fetch_array($query_seSelfCheck, SQLSRV_FETCH_ASSOC)) {
                                                                        ?>
                                                                        <tr>
                                                                            <td style="text-align:center"><?=$i?></td>
                                                                            <td style="text-align:center"><?=$result_seSelfCheck['SELFCHECKID']?></td>
                                                                            <td style="text-align:left"><?=$result_seSelfCheck['CREATEDATE']?></td>
                                                                            <td style="text-align:left"><?=$result_seSelfCheck['EMPLOYEECODE']?></td>
                                                                            <td style="text-align:left"><?=$result_seSelfCheck['EMPLOYEENAME']?></td>
                                                                            <td style="text-align:center"><button type="button" class="btn btn-primary" name="myBtn" id ="myBtn" data-toggle="" data-target="" onclick="checking_selfcheckdata('<?= $result_seSelfCheck['SELFCHECKID'] ?>','<?= $result_seSelfCheck['EMPLOYEECODE'] ?>','<?= $result_seSelfCheck['EMPLOYEENAME'] ?>','<?= $result_seSelfCheck['DATEJOBSTART'] ?>','<?= $result_seSelfCheck['DATEWORKING'] ?>','<?= $result_seSelfCheck['DATEPRESENT'] ?>');" >ตรวจสอบข้อมูล</button></td>

                                                                            <!--Active status , edit  และ Confirmby เห็นได้เฉพาะ Admin เท่านั้น  -->
                                                                            <?php
                                                                            if ($_SESSION["ROLENAME"] == "ADMIN") {
                                                                            ?>
                                                                                <!-- <td style="text-align:center">  <?=$result_seSelfCheck['ACTIVESTATUS']?></td> -->
                                                                                <td style="text-align:center" contenteditable="true"  onkeyup="edit_status(this,'<?= $result_seSelfCheck['SELFCHECKID'] ?>')"><?= $result_seSelfCheck['ACTIVESTATUS'] ?></td>
                                                                                <td style="text-align:center"><?=$result_seSelfCheck['CONFIRMEDBY']?></td>
                                                                                <td style="text-align:center"><input style="height:35px; width:200px" class="form-control dateen_admin" readonly=""  onchange="update_dateselfcheck_byadmin('<?=$result_seSelfCheck['SELFCHECKID']?>','DATEWORKING',this.value);"  id="txt_dateworkingconfirm" name="txt_dateworkingconfirm" value="<?= $result_seSelfCheck['DATEWORKING']; ?>" placeholder="DATEWORKING"></td>
                                                                                <td style="text-align:center"><input style="height:35px; width:200px" class="form-control dateen_admin" readonly=""  onchange="update_dateselfcheck_byadmin('<?=$result_seSelfCheck['SELFCHECKID']?>','DATEPRESENT',this.value);"  id="txt_datepresentconfirm" name="txt_datepresentconfirm" value="<?= $result_seSelfCheck['DATEPRESENT']; ?>" placeholder="DATEPRESENT"></td>
                                                                                <?php
                                                                                if ($result_seSelfCheck['ACTIVESTATUS'] == '0') {
                                                                                ?>
                                                                                    <td style="text-align:center"><button type="button" class="btn btn-primary" name="myBtn" id ="myBtn" data-toggle="" data-target="" onclick="alert('เปลี่ยน ACTIVESTATUS เป็น  1 ก่อน');" >แก้ไขข้อมูล(เฉพาะแอดมิน)</button></td>
                                                                                <?php
                                                                                }else {
                                                                                ?>
                                                                                    
                                                                                    <td style="text-align:center"><button type="button" class="btn btn-primary" name="myBtn" id ="myBtn" data-toggle="" data-target="" onclick="checking_selfcheckdata_admin('<?= $result_seSelfCheck['SELFCHECKID'] ?>','<?= $result_seSelfCheck['EMPLOYEECODE'] ?>','<?= $result_seSelfCheck['EMPLOYEENAME'] ?>','<?= $result_seSelfCheck['DATEJOBSTART'] ?>','<?= $result_seSelfCheck['DATEWORKING'] ?>','<?= $result_seSelfCheck['DATEPRESENT'] ?>');" >แก้ไขข้อมูล(เฉพาะแอดมิน)</button></td>
                                                                                <?php   
                                                                                }
                                                                                ?>
                                                                            
                                                                            <?php
                                                                            }else {
                                                                            ?>
                                                                                <td style="text-align:center"><?= $result_seSelfCheck['ACTIVESTATUS'] ?></td>
                                                                                <td style="text-align:center"><?=$result_seSelfCheck['CONFIRMEDBY']?></td>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            
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
                                </div>




                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                <!-- </div> -->
                <!-- /.row -->

            <!-- </div> -->




            <script src="../vendor/jquery/jquery.min.js"></script>
            <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
            <script src="../vendor/metisMenu/metisMenu.min.js"></script>
            <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
            <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
            <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
            <script src="../dist/js/sb-admin-2.js"></script>
            <script src="../js/jquery.datetimepicker.full.js"></script>
            <script src="../dist/js/bootstrap-select.js"></script>
            <script src="../dist/js/jquery.autocomplete.js"></script>
            <script>    
                                                            
                                                            
                                                            function update_dateselfcheck_byadmin(selfcheckid,feildname,value)
                                                            {

                                                                // alert(selfcheckid);
                                                                // alert(feildname);
                                                                // alert(value);

                                                                $.ajax({
                                                                    type: 'post',
                                                                    url: 'meg_data2.php',
                                                                    data: {
                                                                        txt_flg: "update_dateselfcheck_byadmin", selfcheckid: selfcheckid, feildname: feildname,value:value
                                                                    },
                                                                    success: function (rs) {
                                                                        // alert("ยืนยันข้อมูลเรียบร้อย");
                                                                        // alert(rs);    
                                                                        if (feildname == 'DATEPRESENT') {
                                                                            alert("ยืนยันข้อมูลเรียบร้อย");
                                                                            window.location.reload();     
                                                                        }else{

                                                                        }
                                                                        
                                                                    }
                                                                });
                                                            }

                                                            function edit_status(editableObj,selfcheckid)
                                                            {
                                                                var confirmation = confirm("ต้องการแก้ไขข้อมูล ?");
                                                                var activestatus = editableObj.innerHTML;

                                  
                                                                // alert(activestatus);
                                                                // alert(selfcheckid);
                                                               

                                                                if (confirmation) {
                                                                    // alert('แก้ไขข้อมูล');

                                                                    $.ajax({
                                                                        type: 'post',
                                                                        url: 'meg_data2.php',
                                                                        data: {
                                                                            txt_flg: "update_selfcheckstatus",selfcheckid: selfcheckid,activestatus:activestatus
                                                                        },
                                                                        success: function () {
                                                                            alert('แก้ไขข้อมูลเรียบร้อยแล้ว');
                                                                            window.location.reload();
                                                                        }
                                                                    });
                                                                }
                                                            }
                                                            function select_reportselfcheckdata()
                                                            {
                                                                // save_logprocess('Report', 'Print รายงานค่าเที่ยว(บุคคล)(AMT)', '<?= $result_seLogin['PersonCode'] ?>');
                                                                
                                                                var months = document.getElementById('select_month').value;
                                                                var employeecode = document.getElementById('txt_drivercodereport').value;
                                                               
                                                                    window.open('pdf_reportselfcheckpersondata.php?employeecode=' + employeecode + '&months=' + months, '_blank');
                                                                
                                                            }
                                                            function checking_selfcheckdata(id,employeecode,employeename,date,dateworkingchk,datepresentchk)
                                                            {
                                                                
                                                                // alert(id);
                                                                // alert(employeecode);
                                                                // alert(employeename);
                                                                // alert(date);
                                                                // alert(dateworkingchk);
                                                                // alert(datepresentchk);


                                                                $type = 'officercheck';
                                                                window.open('report_driverselfcheckdetail.php?id='+id+'&employeecode=' + employeecode+'&employeename='+employeename+'&datedriverchk='+date+'&dateworkingchk='+dateworkingchk+'&datepresentchk='+datepresentchk+'&type='+$type, '_blank');
                                                            }
                                                            function checking_selfcheckdata_admin(id,employeecode,employeename,date,dateworkingchk,datepresentchk)
                                                            {
                                                                
                                                                // alert(id);
                                                                // alert(employeecode);
                                                                // alert(employeename);
                                                                // alert(date);
                                                                // alert(dateworkingchk);
                                                                // alert(datepresentchk);

                                                                $officername = '<?=$result_seEmployee['nameT']?>';
                                                                $type = 'officercheck';
                                                                window.open('meg_selfcheckdetail.php?id='+id+'&employeecode=' + employeecode+'&employeename='+employeename+'&datedriverchk='+date+'&daterkchk='+dateworkingchk+'&datepresentchk='+datepresentchk+'&type='+$type+'&officername='+$officername, '_blank');
                                                            }    
                                                            



                                                            function select_selfcheckdata()
                                                            {

                                                                
                                                                var datestart = document.getElementById('txt_datestart').value;
                                                                var dateend = document.getElementById('txt_dateend').value;
                                                                
                                                                
                                                                // alert(datestart);
                                                                // alert(dateend);
                                                                // alert(companycode);

                                                                $.ajax({
                                                                    type: 'post',
                                                                    url: 'meg_data2.php',
                                                                    data: {
                                                                        txt_flg: "select_selfcheckdata", datestart: datestart, dateend: dateend
                                                                    },
                                                                    success: function (response) {
                                                                        if (response)
                                                                        {
                                                                            document.getElementById("datasr").innerHTML = response;
                                                                            document.getElementById("datadef").innerHTML = "";
                                                                        }
                                                                        $(document).ready(function () {
                                                                            $('#dataTables-example1').DataTable({
                                                                                responsive: true,
                                                                            });
                                                                        });

                                                                        $(function () {
                                                                            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                            // กรณีใช้แบบ input
                                                                            $(".dateen_admin").datetimepicker({
                                                                                timepicker: false,
                                                                                format: 'd/m/Y' , // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00 - 00 - 0000
                                                                                lang: 'th' // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                                // timeFormat: "HH:mm"

                                                                            }
                                                                            );
                                                                        });


                                                                            
                                                                    }
                                                                });


                                                            }

                                                            function select_selfcheckdata_personal()
                                                            {

                                                                // alert('Personal');
                                                                
                                                                var datestart = document.getElementById('txt_datestart_personal').value;
                                                                var dateend = document.getElementById('txt_dateend_personal').value;
                                                                
                                                                var employeecode = document.getElementById('txt_drivercode').value;

                                                                // alert(employeecode);

                                                                window.open('report_selfcheckpersonaldetail.php?employeecode=' + employeecode+'&datestart='+datestart+'&dateend='+dateend, '_blank');

                                                                


                                                            }

                                                            function gdatetodate()
                                                            {
                                                                document.getElementById('txt_gdateend').value = document.getElementById('txt_gdatestart').value;
                                                            }
                                                            function datetodate()
                                                            {
                                                                document.getElementById('txt_dateend').value = document.getElementById('txt_datestart').value;

                                                            }
                                                            function datetodatepersonal()
                                                            {
                                                                document.getElementById('txt_dateend_personal').value = document.getElementById('txt_datestart_personal').value;

                                                            }
                                                            $(function () {
                                                                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                // กรณีใช้แบบ input
                                                                $(".dateen").datetimepicker({
                                                                    timepicker: false,
                                                                    format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                                                    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


                                                                });
                                                            });

                                                            $(function () {
                                                                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                // กรณีใช้แบบ input
                                                                $(".dateen_admin").datetimepicker({
                                                                    timepicker: false,
                                                                    format: 'd/m/Y' , // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00 - 00 - 0000
                                                                    lang: 'th' // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                    // timeFormat: "HH:mm"

                                                                }
                                                                );
                                                            });

                                                            $(document).ready(function () {
                                                                $('#dataTables-example').DataTable({
                                                                    responsive: true,
                                                                });
                                                            });

            </script>


    </body>

</html>

<?php
sqlsrv_close($conn);
?>
