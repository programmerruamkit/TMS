
<!DOCTYPE html>
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

$condition1 = " AND (a.USERNAME ='" . $_SESSION["USERNAME"] . "' AND a.PASSWORD = '" . $_SESSION["PASSWORD"] . "') AND a.ACTIVESTATUS = 1";
$sql_seLogin = "{call megRoleaccount_v2(?,?)}";
$params_seLogin = array(
    array('select_roleaccount', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_seLogin = sqlsrv_query($conn, $sql_seLogin, $params_seLogin);
$result_seLogin = sqlsrv_fetch_array($query_seLogin, SQLSRV_FETCH_ASSOC);
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
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
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
        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <?php
                include '../pages/meg_header.php';
                include '../pages/meg_leftmenu.php';
                ?>
            </nav>

            <div id="page-wrapper" >
                <div class="row" >
                    <div class="col-lg-12">

                        <h2 class="page-header"><i class="fa fa-file-text-o"></i>
                            รายงานเอกสารเท็งโกะ


                        </h2>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row" >
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">

                                <a href="index.html">หน้าหลัก</a> / <a href="meg_employee4.php?data=3">พนักงาน</a> / รายงาน

                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <!-- Nav tabs -->
                                <ul class="nav nav-pills">
                                    <li class="active"><a href="#home-pills" data-toggle="tab">รายงานเอกสารเท็งโกะ(พื้นฐาน)</a>
                                    </li>
                                    <li><a href="#sum_tenkostatus" data-toggle="tab">รายงานเอกสารเท็งโกะ(แยกสถานะ)</a>
                                    </li>
                                    <li><a href="#profile-pills" data-toggle="tab">รายงานเอกสารเท็งโกะ(มาตฐาน)</a>
                                    </li>
                                    <li><a href="#sum_tenkotgt" data-toggle="tab">รายงาน SummaryTenko(TGT)</a>
                                    </li>
                                    <li><a href="#sum_tenkodenso" data-toggle="tab">รายงาน SummaryTenko(DENSO)</a>
                                    </li>
                                    <li><a href="#employees-pills" data-toggle="tab">รายงานข้อมูลพนักงานขับรภ</a>
                                    </li>

                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane fade" id="sum_tenkostatus">
                                        <div class="row">&nbsp;</div>
                                        <div class="row" >
                                            <div class="col-lg-12">
                                                <div class="well">
                                                    <div class="row">

                                                        <div class="col-lg-2 ">
                                                            <div class="form-group">
                                                                <label>ค้นหาตามช่วงวันที่</label>
                                                                <input class="form-control dateen" id="txt_datestart4" onchange="datetodate4();" readonly="" style="background-color: #f080802e" name="txt_datestart4" value="<?= $result_getDate['SYSDATE'] ?>" placeholder="วันที่เริ่มต้น">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label>&nbsp;</label>
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control dateen" id="txt_dateend4" readonly=""  style="background-color: #f080802e" name="txt_dateend4" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE'] ?>">

                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="col-lg-2">
                                                            <label>พขร. :</label>
                                                            <input type="text"   name="txt_employeename4"  id="txt_employeename4" class="form-control">
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <label>สถานะเท็งโกะ :</label>
                                                            <select id="cb_status4" name="cb_status4" class="form-control" >
                                                                <option value="">เลือกสถานะเท็งโกะ</option>


                                                                <option value="T1">ก่อนเริ่มงาน</option>
                                                                <option value="T2">ระหว่างทาง</option>
                                                                <option value="T3">เลิกงาน</option>

                                                            </select>
                                                        </div>
                                                        <div class="col-lg-1">
                                                            <label>&nbsp;</label>
                                                            <div class="form-group">
                                                                <button class="btn btn-default" onclick="select_reporttenko4();">ค้นหา <li class="fa fa-search"></li></button>
                                                            </div>

                                                        </div>
                                                        <div class="col-lg-3 text-right">
                                                            <div class="form-group">
                                                                <label>&nbsp;</label>
                                                                <div class="form-group">
                                                                    <a href="#" onclick="pdf_reporttenko4()" class="btn btn-default">รายงานเอกสารเท็งโกะ <li class="fa fa-print"></li></a>

                                                                </div>
                                                            </div>

                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                                        รายงานเอกสารเท็งโกะ (แยกสถานะ)
                                                    </div>
                                                    <!-- /.panel-heading -->

                                                    <div class="panel-body">

                                                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                            <div id="data_def4">
                                                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example5" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="text-align: center">บริษัท</th>
                                                                            <th style="text-align: center">ชื่อรถ</th>
                                                                            <th>Job No</th>
                                                                            <th>วันที่</th>
                                                                            <th style="text-align: center">ชื่อ-นามสกุล</th>
                                                                            <th>สถานะเท็งโก๊ะ</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $area4 = ($_GET['area'] == 'amata') ? " AND a.COMPANYCODE IN ('RKS','RKR','RKL')" : " AND a.COMPANYCODE IN ('RATC','RCC','RRC')";
                                                                        $conditionPlain = " AND CONVERT(DATE,a.DATEVLIN) = CONVERT(DATE,GETDATE())" . $area4;


                                                                        $sql_sePlain = "{call megVehicletransportplan_v2(?,?)}";
                                                                        $params_sePlain = array(
                                                                            array('select_vehicletransportplan', SQLSRV_PARAM_IN),
                                                                            array($conditionPlain, SQLSRV_PARAM_IN)
                                                                        );
                                                                        $query_sePlain = sqlsrv_query($conn, $sql_sePlain, $params_sePlain);

                                                                        while ($result_sePlain = sqlsrv_fetch_array($query_sePlain, SQLSRV_FETCH_ASSOC)) {
                                                                            ?>
                                                                            <tr class="odd gradeX">

                                                                                <td><?= $result_sePlain['COMPANYCODE'] ?></td>
                                                                                <td><?= $result_sePlain['THAINAME'] ?></td>
                                                                                <td><?= $result_sePlain['JOBNO'] ?></td>
                                                                                <td><?= $result_sePlain['DATEVLIN'] ?></td>
                                                                                <td>
                                                                                    <?= $result_sePlain['EMPLOYEENAME1'] ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php
                                                                                        switch ($result_sePlain['STATUSNUMBER'])
                                                                                        {
                                                                                            case 'O':
                                                                                            {
                                                                                                echo 'เท็งโกะก่อนเริ่มงาน';
                                                                                            }
                                                                                            break;
                                                                                        case 'L':
                                                                                            {
                                                                                                echo 'เท็งโกะก่อนเริ่มงาน';
                                                                                            }
                                                                                            break;
                                                                                        case 'P':
                                                                                            {
                                                                                                echo 'เท็งโกะก่อนเริ่มงาน';
                                                                                            }
                                                                                            break;
                                                                                        case 'T':
                                                                                            {
                                                                                                echo 'เท็งโกะระหว่างทาง';
                                                                                            }
                                                                                            break;
                                                                                        case '1':
                                                                                            {
                                                                                                echo 'เท็งโกะระหว่างทาง';
                                                                                            }
                                                                                            break;
                                                                                        case '2':
                                                                                            {
                                                                                                echo 'เท็งโกะเลิกงาน';
                                                                                            }
                                                                                            break;
                                                                                        }
                                                                                    ?>
                                                                                </td>


                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div id="data_sr4"></div>

                                                        </div>


                                                        <!-- /.panel-body -->
                                                    </div>
                                                    <!-- /.panel -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade in active" id="home-pills">
                                        <div class="row">&nbsp;</div>
                                        <div class="row" >
                                            <div class="col-lg-12">
                                                <div class="well">
                                                    <div class="row">

                                                        <div class="col-lg-2 ">
                                                            <div class="form-group">
                                                                <label>ค้นหาตามช่วงวันที่</label>
                                                                <input class="form-control dateen" id="txt_datestart" onchange="datetodate();" readonly="" style="background-color: #f080802e" name="txt_datestart" value="<?= $result_getDate['SYSDATE'] ?>" placeholder="วันที่เริ่มต้น">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label>&nbsp;</label>
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control dateen" id="txt_dateend" readonly=""  style="background-color: #f080802e" name="txt_dateend" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE'] ?>">

                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label>พขร. :</label>
                                                            <input type="text"  name="txt_employeename"  id="txt_employeename" class="form-control">
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label>&nbsp;</label>
                                                            <div class="form-group">
                                                                <button class="btn btn-default" onclick="select_reporttenko();">ค้นหา <li class="fa fa-search"></li></button>
                                                            </div>

                                                        </div>

                                                        <div class="col-lg-4 text-right">
                                                            <label>&nbsp;</label><br>
                                                            <a href="#" onclick="pdf_reporttenko()" class="btn btn-default">พิมพ์เอกสารเท็งโกะ <li class="fa fa-print"></li></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                                        รายงานเอกสารเท็งโกะ (พื้นฐาน)
                                                    </div>
                                                    <!-- /.panel-heading -->

                                                    <div class="panel-body">

                                                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                            <div id="data_def">
                                                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>รหัสพนักงาน</th>
                                                                            <th>ชื่อ-นามสกุล</th>

                                                                            <th>วันที่</th>
                                                                            <th>ความดันบน</th>
                                                                            <th>ความดันล่าง</th>
                                                                            <th>แอลกอฮอล์</th>
                                                                            <th>ออกซิเจน</th>
                                                                            <th>อุณหภูมิ</th>
                                                                            <th>ตารางพักผ่อน</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $area = ($_GET['area'] == 'amata') ? " AND c.Company_Code IN ('RKS','RKR','RKL','RIT','RTD','RTC','RKB')" : " AND c.Company_Code IN ('RATC','RCC','RRC')";
                                                                        $condiTenkobefore = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE())" . $area;
                                                                        $sql_seTenkobrfore = "{call megEdittenkobefore_v2(?,?,?)}";
                                                                        $params_seTenkobrfore = array(
                                                                            array('select_tenkobefore', SQLSRV_PARAM_IN),
                                                                            array($condiTenkobefore, SQLSRV_PARAM_IN),
                                                                            array('', SQLSRV_PARAM_IN)
                                                                        );
                                                                        $query_seTenkobrfore = sqlsrv_query($conn, $sql_seTenkobrfore, $params_seTenkobrfore);
                                                                        while ($result_seTenkobrfore = sqlsrv_fetch_array($query_seTenkobrfore, SQLSRV_FETCH_ASSOC)) {
                                                                            ?>
                                                                            <tr class="odd gradeX">

                                                                                <td><?= $result_seTenkobrfore['TENKOMASTERDIRVERCODE'] ?></td>
                                                                                <td><?= $result_seTenkobrfore['TENKOMASTERDIRVERNAME'] ?></td>

                                                                                <td><?= $result_seTenkobrfore['DATEINPUT_F1'] ?></td>
                                                                                <td><?= $result_seTenkobrfore['TENKOPRESSUREDATA_90160'] ?></td>
                                                                                <td><?= $result_seTenkobrfore['TENKOPRESSUREDATA_60100'] ?></td>
                                                                                <td><?= $result_seTenkobrfore['TENKOALCOHOLDATA'] ?></td>
                                                                                <td><?= $result_seTenkobrfore['TENKOOXYGENDATA'] ?></td>
                                                                                <td><?= $result_seTenkobrfore['TENKOTEMPERATUREDATA'] ?></td>
                                                                                <td><?= $result_seTenkobrfore['TENKORESTDATA'] ?></td>



                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div id="data_sr"></div>

                                                        </div>


                                                        <!-- /.panel-body -->
                                                    </div>
                                                    <!-- /.panel -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade " id="sum_tenkotgt">
                                        <div class="row">&nbsp;</div>
                                        <div class="row" >
                                            <div class="col-lg-12">
                                                <div class="well">
                                                    <div class="row">
                                                        <?php
                                                        $condition1 = "  AND a.PersonID = '" . $_SESSION["EMPLOYEEID"] . "'";
                                                        $sql_seEmployee = "{call megEmployeeEHR_v2(?,?)}";
                                                        $params_seEmployee = array(
                                                            array('select_employeeehr2', SQLSRV_PARAM_IN),
                                                            array($condition1, SQLSRV_PARAM_IN)
                                                        );
                                                        $query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
                                                        $result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC);
                                                        ?>
                                                        <input type="text" id="txt_id"  readonly=""  name="txt_id" value="<?= $result_seEmployee['PersonCode'] ?>" style=" display:none">
                                                        <div class="col-lg-2 ">
                                                            <div class="form-group">
                                                                <label>ค้นหาตามช่วงวันที่</label>
                                                                <input class="form-control dateen" id="txt_datestart2" onchange="datetodate2();" readonly="" style="background-color: #f080802e" name="txt_datestart2" value="<?= $result_getDate['SYSDATE'] ?>" placeholder="วันที่เริ่มต้น">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label>&nbsp;</label>
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control dateen" id="txt_dateend2" readonly=""  style="background-color: #f080802e" name="txt_dateend2" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE'] ?>">

                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label>&nbsp;</label>
                                                            <div class="form-group">
                                                                <button type="button" class="btn btn-default" onclick="select_reporttenko2();">ค้นหา</button>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6 text-right">
                                                            <label>&nbsp;</label><br>
                                                            <a href="#" onclick="pdf_reporttenko2()" class="btn btn-default">พิมพ์เอกสารเท็งโกะ(TGT) <li class="fa fa-print"></li></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                                        รายงานเอกสารเท็งโกะ (TGT)
                                                    </div>
                                                    <!-- /.panel-heading -->

                                                    <div class="panel-body">

                                                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                            <div id="data_def2">
                                                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example3" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>NO.</th>
                                                                            <th>วันที่</th>
                                                                            <th>ชื่อ พนักงานขับรถ</th>
                                                                            <th>ชื่อ ผู้ตรวจสอบความพร้อม</th>
                                                                            <th>ค่าความดันบน</th>
                                                                            <th>ค่าความดันล่าง</th>
                                                                            <th>การเต้นของหัวใจ</th>
                                                                            <th>ปริมาณแอลกอฮอล์</th>
                                                                            <th>ชั่วโมงพักผ่อน</th>
                                                                            <th>อุณหภูมิ</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        // $condiTenkobefore = " AND CONVERT(DATE,a.CREATEDATE) BETWEEN CONVERT(DATE,'" . $_POST['date_start'] . "',103) AND CONVERT(DATE,'" . $_POST['date_end'] . "',103)";
                                                                        $i = 1;


                                                                        $sql_seSumTenko = "SELECT FORMAT (CONVERT(DATE,b.CREATEDATE,103),'dd-MM-yyyy') AS 'DATE',FORMAT (CONVERT(DATE,GETDATE(),103),'dd-MM-yyyy') AS 'SYSDATE'
                                                                                            ,a.JOBSTART,a.JOBEND2 ,b.TENKOMASTERDIRVERNAME AS 'NAME',b.TENKOBEFOREOFFICER AS 'OFFICER' ,b.TENKOPRESSUREDATA_60100 AS 'SBP'
                                                                                            ,b.TENKOPRESSUREDATA_90160 AS 'DBP',	 b.TENKOALCOHOLDATA AS 'ALCOHOL',b.TENKORESTDATA AS 'REST',b.TENKOTEMPERATUREDATA AS 'TEMP'
                                                                                            ,b.TENKOPRESSUREDATA_60110 AS 'HEARTRATE',c.VEHICLETRANSPORTPLANID,a.TENKOMASTERID,c.JOBNO
                                                                                            FROM [dbo].[TENKOMASTER] a
                                                                                            INNER JOIN [dbo].[TENKOBEFORE]  b ON b.TENKOMASTERID = a.TENKOMASTERID
                                                                                            INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON c.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
                                                                                            WHERE 1=1
                                                                                            AND CONVERT(DATE,c.DATEWORKING) BETWEEN CONVERT(DATE,GETDATE(),103) AND CONVERT(DATE,GETDATE(),103)
                                                                                            AND c.COMPANYCODE='RKS' AND c.CUSTOMERCODE='TGT'
                                                                                            AND b.TENKOPRESSUREDATA_60100 IS NOT NULL
                                                                                            AND b.TENKOPRESSUREDATA_90160 IS NOT NULL
                                                                                            AND b.TENKOALCOHOLDATA IS NOT NULL
                                                                                            AND b.TENKORESTDATA IS NOT NULL
                                                                                            AND b.TENKOTEMPERATUREDATA IS NOT NULL
                                                                                            AND b.TENKOPRESSUREDATA_60110 IS NOT NULL
                                                                                            ORDER BY c.DATEWORKING ASC";
                                                                        $params_seSumTenko = array();
                                                                        $query_seSumTenko = sqlsrv_query($conn, $sql_seSumTenko, $params_seSumTenko);
                                                                        while ($result_seSumTenko = sqlsrv_fetch_array($query_seSumTenko, SQLSRV_FETCH_ASSOC)) {
                                                                            ?>
                                                                            <tr class="odd gradeX">

                                                                                <td><?= $i ?></td>
                                                                                <td><?= $result_seSumTenko['DATE'] ?></td>
                                                                                <td><?= $result_seSumTenko['NAME'] ?></td>
                                                                                <td><?= $result_seSumTenko['OFFICER'] ?></td>
                                                                                <td><?= $result_seSumTenko['DBP'] ?></td>
                                                                                <td><?= $result_seSumTenko['SBP'] ?></td>
                                                                                <td><?= $result_seSumTenko['HEARTRATE'] ?></td>
                                                                                <td><?= $result_seSumTenko['ALCOHOL'] ?></td>
                                                                                <td><?= $result_seSumTenko['REST'] ?></td>
                                                                                <td><?= $result_seSumTenko['TEMP'] ?></td>

                                                                            </tr>
                                                                            <?php
                                                                            $i++;
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div id="data_sr2"></div>

                                                        </div>


                                                        <!-- /.panel-body -->
                                                    </div>
                                                    <!-- /.panel -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade " id="sum_tenkodenso">
                                        <div class="row">&nbsp;</div>
                                        <div class="row" >
                                            <div class="col-lg-12">
                                                <div class="well">
                                                    <div class="row">
                                                        <?php
                                                        $condition1 = "  AND a.PersonID = '" . $_SESSION["EMPLOYEEID"] . "'";
                                                        $sql_seEmployee = "{call megEmployeeEHR_v2(?,?)}";
                                                        $params_seEmployee = array(
                                                            array('select_employeeehr2', SQLSRV_PARAM_IN),
                                                            array($condition1, SQLSRV_PARAM_IN)
                                                        );
                                                        $query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
                                                        $result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC);
                                                        ?>
                                                        <input type="text" id="txt_id"  readonly=""  name="txt_id" value="<?= $result_seEmployee['PersonCode'] ?>" style=" display: none">
                                                        <div class="col-lg-2 ">
                                                            <div class="form-group">
                                                                <label>ค้นหาตามช่วงวันที่</label>
                                                                <input class="form-control dateen" id="txt_datestart3" onchange="datetodate3();" readonly="" style="background-color: #f080802e" name="txt_datestart3" value="<?= $result_getDate['SYSDATE'] ?>" placeholder="วันที่เริ่มต้น">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label>&nbsp;</label>
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control dateen" id="txt_dateend3" readonly=""  style="background-color: #f080802e" name="txt_dateend3" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE'] ?>">

                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label>&nbsp;</label>
                                                            <div class="form-group">
                                                                <button type="button" class="btn btn-default" onclick="select_reporttenko3();">ค้นหา</button>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6 text-right">
                                                            <label>&nbsp;</label><br>
                                                            <a href="#" onclick="pdf_reporttenko3()" class="btn btn-default">พิมพ์เอกสารเท็งโกะ(DENSO) <li class="fa fa-print"></li></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                                        รายงานเอกสารเท็งโกะ (DENSO)
                                                    </div>
                                                    <!-- /.panel-heading -->

                                                    <div class="panel-body">

                                                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                            <div id="data_def3">
                                                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example4" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>NO.</th>
                                                                            <th>วันที่</th>
                                                                            <th>ชื่อ พนักงานขับรถ</th>
                                                                            <th>ชื่อ ผู้ตรวจสอบความพร้อม</th>
                                                                            <th>ค่าความดันบน</th>
                                                                            <th>ค่าความดันล่าง</th>
                                                                            <th>การเต้นของหัวใจ</th>
                                                                            <th>ปริมาณแอลกอฮอล์</th>
                                                                            <th>ชั่วโมงพักผ่อน</th>
                                                                            <th>อุณหภูมิ</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
// $condiTenkobefore = " AND CONVERT(DATE,a.CREATEDATE) BETWEEN CONVERT(DATE,'" . $_POST['date_start'] . "',103) AND CONVERT(DATE,'" . $_POST['date_end'] . "',103)";
                                                                        $i = 1;

                                                                        $sql_seSumTenko = "SELECT FORMAT (CONVERT(DATE,b.CREATEDATE,103),'dd-MM-yyyy') AS 'DATE',FORMAT (CONVERT(DATE,GETDATE(),103),'dd-MM-yyyy') AS 'SYSDATE'
                                                                                  ,a.JOBSTART,a.JOBEND2 ,b.TENKOMASTERDIRVERNAME AS 'NAME',b.TENKOBEFOREOFFICER AS 'OFFICER' ,b.TENKOPRESSUREDATA_60100 AS 'SBP'
                                                                                  ,b.TENKOPRESSUREDATA_90160 AS 'DBP',	 b.TENKOALCOHOLDATA AS 'ALCOHOL',b.TENKORESTDATA AS 'REST',b.TENKOTEMPERATUREDATA AS 'TEMP'
                                                                                  ,b.TENKOPRESSUREDATA_60110 AS 'HEARTRATE',c.VEHICLETRANSPORTPLANID,a.TENKOMASTERID,c.JOBNO
                                                                                  FROM [dbo].[TENKOMASTER] a
                                                                                  INNER JOIN [dbo].[TENKOBEFORE]  b ON b.TENKOMASTERID = a.TENKOMASTERID
                                                                                  INNER JOIN [dbo].[VEHICLETRANSPORTPLAN] c ON c.VEHICLETRANSPORTPLANID = a.VEHICLETRANSPORTPLANID
                                                                                  WHERE 1=1
                                                                                  AND CONVERT(DATE,c.DATEWORKING) BETWEEN CONVERT(DATE,GETDATE(),103) AND CONVERT(DATE,GETDATE(),103)
                                                                                  AND c.JOBSTART IN ('DM-021','DM-022')
                                                                                  --AND b.TENKOMASTERID = '1513055'
                                                                                  ORDER BY c.DATEWORKING ASC";
                                                                        $params_seSumTenko = array();
                                                                        $query_seSumTenko = sqlsrv_query($conn, $sql_seSumTenko, $params_seSumTenko);
                                                                        while ($result_seSumTenko = sqlsrv_fetch_array($query_seSumTenko, SQLSRV_FETCH_ASSOC)) {
                                                                            ?>
                                                                            <tr class="odd gradeX">

                                                                                <td><?= $i ?></td>
                                                                                <td><?= $result_seSumTenko['DATE'] ?></td>
                                                                                <td><?= $result_seSumTenko['NAME'] ?></td>
                                                                                <td><?= $result_seSumTenko['OFFICER'] ?></td>
                                                                                <td><?= $result_seSumTenko['DBP'] ?></td>
                                                                                <td><?= $result_seSumTenko['SBP'] ?></td>
                                                                                <td><?= $result_seSumTenko['HEARTRATE'] ?></td>
                                                                                <td><?= $result_seSumTenko['ALCOHOL'] ?></td>
                                                                                <td><?= $result_seSumTenko['REST'] ?></td>
                                                                                <td><?= $result_seSumTenko['TEMP'] ?></td>

                                                                            </tr>
                                                                            <?php
                                                                            $i++;
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div id="data_sr3"></div>

                                                        </div>


                                                        <!-- /.panel-body -->
                                                    </div>
                                                    <!-- /.panel -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="profile-pills">
                                        <div class="row">&nbsp;</div>
                                        <div class="row" >
                                            <div class="col-lg-12">
                                                <div class="well">
                                                    <div class="row">

                                                        <div class="col-lg-2 ">
                                                            <div class="form-group">
                                                                <label>ค้นหาตามช่วงวันที่</label>
                                                                <input class="form-control dateen" id="txt_datestart1" onchange="datetodate1();" readonly="" style="background-color: #f080802e" name="txt_datestart" value="<?= $result_getDate['SYSDATE'] ?>" placeholder="วันที่เริ่มต้น">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label>&nbsp;</label>
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control dateen" id="txt_dateend1" readonly=""  style="background-color: #f080802e" name="txt_dateend" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE'] ?>">

                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="col-lg-2">
                                                            <label>พขร. :</label>
                                                            <input type="text"   name="txt_employeename1"  id="txt_employeename1" class="form-control">
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label>&nbsp;</label>
                                                            <div class="form-group">
                                                                <button class="btn btn-default" onclick="select_reporttenko1();">ค้นหา <li class="fa fa-search"></li></button>
                                                            </div>

                                                        </div>
                                                        <div class="col-lg-4 text-right">
                                                            <div class="form-group">
                                                                <label>&nbsp;</label>
                                                                <div class="form-group">
                                                                    <a href="#" onclick="pdf_employeeall4_1()" class="btn btn-default">รายงานเอกสารเท็งโกะ1(ทั้งหมด) <li class="fa fa-print"></li></a>

                                                                </div>
                                                            </div>

                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                                        รายงานเอกสารเท็งโกะ (มาตฐาน)
                                                    </div>
                                                    <!-- /.panel-heading -->

                                                    <div class="panel-body">

                                                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                            <div id="data_def1">
                                                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example2" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="text-align: center">บริษัท</th>
                                                                            <th style="text-align: center">ชื่อรถ</th>
                                                                            <th>Job No</th>
                                                                            <th>วันที่</th>
                                                                            <th style="text-align: center">ชื่อ-นามสกุล(1)</th>
                                                                            <th style="text-align: center">ชื่อ-นามสกุล(2)</th>
                                                                            <th style="text-align: center">รายงานเอกสารเท็งโกะ 2</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $area1 = ($_GET['area'] == 'amata') ? " AND a.TENKOMASTERCOMPANY IN ('RKS','RKR','RKL')" : " AND a.TENKOMASTERCOMPANY IN ('RATC','RCC','RRC')";
                                                                        $condiTenkomaster = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE())" . $area1;
                                                                        $sql_seTenkomaster = "{call megEdittenkomaster_v2(?,?)}";
                                                                        $params_seTenkomaster = array(
                                                                            array('select_tenkomaster', SQLSRV_PARAM_IN),
                                                                            array($condiTenkomaster, SQLSRV_PARAM_IN)
                                                                        );
                                                                        $query_seTenkmaster = sqlsrv_query($conn, $sql_seTenkomaster, $params_seTenkomaster);
                                                                        while ($result_seTenkmaster = sqlsrv_fetch_array($query_seTenkmaster, SQLSRV_FETCH_ASSOC)) {
                                                                            $conditionPlain = " AND a.VEHICLETRANSPORTPLANID = '" . $result_seTenkmaster['VEHICLETRANSPORTPLANID'] . "'";
                                                                            $sql_sePlain = "{call megVehicletransportplan_v2(?,?)}";
                                                                            $params_sePlain = array(
                                                                                array('select_vehicletransportplan', SQLSRV_PARAM_IN),
                                                                                array($conditionPlain, SQLSRV_PARAM_IN)
                                                                            );
                                                                            $query_sePlain = sqlsrv_query($conn, $sql_sePlain, $params_sePlain);
                                                                            $result_sePlain = sqlsrv_fetch_array($query_sePlain, SQLSRV_FETCH_ASSOC);
                                                                            ?>
                                                                            <tr class="odd gradeX">

                                                                                <td><?= $result_seTenkmaster['TENKOMASTERCOMPANY'] ?></td>
                                                                                <td><?= $result_seTenkmaster['TENKOMASTERVEHICLE'] ?></td>
                                                                                <td><?= $result_sePlain['JOBNO'] ?></td>
                                                                                <td><?= $result_seTenkmaster['CREATEDATE'] ?></td>
                                                                                <td>
                                                                                    <?php
                                                                                    if ($result_seTenkmaster['TENKOMASTERDIRVERNAME1'] != "") {
                                                                                        ?>
                                                                                        <?= $result_seTenkmaster['TENKOMASTERDIRVERNAME1'] ?>
                                                                                        <div class="btn-group">
                                                                                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                                                                                <i class="fa fa-chevron-down"></i>
                                                                                            </button>
                                                                                            <ul class="dropdown-menu slidedown">

                                                                                                <li>

                                                                                                    <a href="pdf_reportemployee4_1.php?employeecode=<?= $result_seTenkmaster['TENKOMASTERDIRVERCODE1'] ?>&tenkomasterid=<?= $result_seTenkmaster['TENKOMASTERID'] ?>" target="_bank">รายงานเอกสารเท็งโกะ 1</a>
                                                                                                </li>


                                                                                            </ul>
                                                                                        </div>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php
                                                                                    if ($result_seTenkmaster['TENKOMASTERDIRVERNAME2'] != "") {
                                                                                        ?>
                                                                                        <?= $result_seTenkmaster['TENKOMASTERDIRVERNAME2'] ?>
                                                                                        <div class="btn-group">
                                                                                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                                                                                <i class="fa fa-chevron-down"></i>
                                                                                            </button>
                                                                                            <ul class="dropdown-menu slidedown">

                                                                                                <li>

                                                                                                    <a href="pdf_reportemployee4_1.php?employeecode=<?= $result_seTenkmaster['TENKOMASTERDIRVERCODE2'] ?>" target="_bank">รายงานเอกสารเท็งโกะ 1</a>
                                                                                                </li>


                                                                                            </ul>
                                                                                        </div>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </td>
                                                                                <td style="text-align: center"><div class="btn-group">
                                                                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                                                                            <i class="fa fa-chevron-down"></i>
                                                                                        </button>
                                                                                        <ul class="dropdown-menu slidedown">



                                                                                            <li>

                                                                                                <a href="pdf_reportemployee4_2.php?vehicletransportplanid=<?= $result_seTenkmaster['VEHICLETRANSPORTPLANID'] ?>" target="_bank">รายงานเอกสารเท็งโกะ 2</a>
                                                                                            </li>

                                                                                        </ul>
                                                                                    </div></td>



                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div id="data_sr1"></div>

                                                        </div>


                                                        <!-- /.panel-body -->
                                                    </div>
                                                    <!-- /.panel -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="employees-pills">
                                        <div class="row">&nbsp;</div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                                        รายงานข้อมูลพนักงานขับรถ
                                                    </div>
                                                    <!-- /.panel-heading -->

                                                    <div class="panel-body">

                                                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                            <div id="data_def1">
                                                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-employees" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>รหัสพนักงาน</th>
                                                                            <th>ชื่อ-นามสกุล</th>
                                                                            <th>เบอร์โทรศัพท์</th>
                                                                            <th>อีเมลล์</th>
                                                                            <th style="text-align: center">รายงาน</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $area1 = ($_GET['area'] == 'amata') ? " AND d.Company_Code IN ('RKS','RKR','RKL') AND c.PositionNameOther ='Driver'" : " AND d.Company_Code IN ('RRC','RCC','RATC') AND c.PositionNameOther ='Driver'";

                                                                        $sql_seEmp = "{call megEmployeeEHR_v2(?,?)}";
                                                                        $params_seEmp = array(
                                                                            array('select_employeeehr2', SQLSRV_PARAM_IN),
                                                                            array($area1, SQLSRV_PARAM_IN)
                                                                        );

                                                                        /* $sql_seEmp = "{call megEmployeeEHR_v2(?,?)}";
                                                                          $params_seEmp = array(
                                                                          array('select_employee', SQLSRV_PARAM_IN),
                                                                          array('', SQLSRV_PARAM_IN)
                                                                          );
                                                                         * */

                                                                        $query_seEmp = sqlsrv_query($conn, $sql_seEmp, $params_seEmp);
                                                                        while ($result_seEmp = sqlsrv_fetch_array($query_seEmp, SQLSRV_FETCH_ASSOC)) {
                                                                            ?>
                                                                            <tr class="odd gradeX">
                                                                                <td><?= $result_seEmp['PersonCode'] ?></td>
                                                                                <td><?= $result_seEmp['nameT'] ?></td>
                                                                                <td><?= $result_seEmp['Tel'] ?></td>
                                                                                <td><?= $result_seEmp['Email'] ?></td>
                                                                                <td style="text-align: center">
                                                                                    <a href="#" onclick="pdf_employee4_4('<?= $result_seEmp['PersonCode'] ?>')" class="btn btn-default"><li class="fa fa-print"></li></a>


                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div id="data_sr1"></div>

                                                        </div>


                                                        <!-- /.panel-body -->
                                                    </div>
                                                    <!-- /.panel -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                </div>
                <!-- /.row -->

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
            <?php
            $job = '';
            if ($_GET['companycode'] == 'RRC' && $_GET['customercode'] == 'GMT') {
                $job = select_jobautocomplatestartgetway('megVehicletransportprice_v2', 'select_from', '');
            }
            if ($_GET['companycode'] == 'RRC' && $_GET['customercode'] == 'BP') {
                $job = select_jobautocomplatestartgetway('megVehicletransportprice_v2', 'select_from', '');
            }
            if ($_GET['companycode'] == 'RRC' && $_GET['customercode'] == 'TTAST') {
                $job = select_jobautocomplatestartgetway('megVehicletransportprice_v2', 'select_from', '');
            }
            if ($_GET['companycode'] == 'RRC' && $_GET['customercode'] == 'TTTC') {
                $job = select_jobautocomplatestartgetway('megVehicletransportprice_v2', 'select_from', '');
            } else if ($_GET['companycode'] == 'RCC' && $_GET['customercode'] == 'TTT') {
                $job = select_jobautocomplate('megVehicletransportprice_v2', 'select_beginjob', '');
            } else if ($_GET['companycode'] == 'RATC' && $_GET['customercode'] == 'TTT') {
                $job = select_jobautocomplate('megVehicletransportprice_v2', 'select_beginjob', '');
            }
            if ($_GET['companycode'] == 'RRC' || $_GET['companycode'] == 'RCC' || $_GET['companycode'] == 'RATC') {
                $thainame = select_carautocomplate('megVehicleinfo_v2', 'selectcond_vehicleinfo', " AND a.THAINAME != '-' AND (a.ENGNAME  LIKE '%R-%' OR a.ENGNAME  LIKE '%RA-%'", " OR a.THAINAME LIKE '%ดินแดง%'  OR a.THAINAME  LIKE '%อุทัยธานี%'  OR a.THAINAME  LIKE '%คลองเขื่อน%'  ", " OR a.THAINAME LIKE '%RP-%' OR a.THAINAME  LIKE '%สวนผึ้ง%' OR a.THAINAME  LIKE '%ด่านช้าง%'", " OR a.ENGNAME LIKE '%Khao Chamao%' OR a.ENGNAME LIKE '%Kerry%' OR a.ENGNAME LIKE '%Chaloem Prakiat%')");
            } else {
                $thainame = select_vehiclenumberautocomplate('megVehicleinfo_v2', 'select_vehicleinfo', '');
            }
            $jobrccend = select_jobautocomplateendgetway('megVehicletransportprice_v2', 'select_to', '');


            $emp = select_empautocomplate('megEmployeeEHR_v2', 'select_employeeehr2', " ");
            $cluster = select_clusterautocomplate('megVehicletransportprice_v2', 'select_cluster', '');
            ?>
            <script type="text/javascript">
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
                var txt_employeename4 = [<?= $emp ?>];
                                                                                    $("#txt_employeename4").autocomplete({
                                                                                        source: [txt_employeename4]
                                                                                    });
                                                                                    
                                                                                    var txt_employeename1 = [<?= $emp ?>];
                                                                                    $("#txt_employeename1").autocomplete({
                                                                                        source: [txt_employeename1]
                                                                                    });
                                                                                    var txt_employeename = [<?= $emp ?>];
                                                                                    $("#txt_employeename").autocomplete({
                                                                                        source: [txt_employeename]
                                                                                    });

                                                                                    function pdf_employee4_4(employeecode)
                                                                                    {
                                                                                        save_logprocess('Report', 'Print รายงานข้อมูลพนักงานขับรภ', '<?= $result_seLogin['PersonCode'] ?>');
                                                                                        window.open('pdf_reportemployee4_4.php?employeecode=' + employeecode, '_blank');

                                                                                    }

                                                                                    function pdf_employeeall4_1()
                                                                                    {
                                                                                        save_logprocess('Report', 'Print รายงานเอกสารเท็งโกะ(มาตฐาน)', '<?= $result_seLogin['PersonCode'] ?>');
                                                                                        var datestart = document.getElementById('txt_datestart1').value;
                                                                                        var dateend = document.getElementById('txt_dateend1').value;
                                                                                        var employee = document.getElementById('txt_employeename1').value;
                                                                                        var area = '<?= $_GET['area'] ?>';
                                                                                        window.open('pdf_reportemployeeall4_1.php?datestart=' + datestart + '&dateend=' + dateend + '&employee=' + employee + '&area=' + area, '_blank');

                                                                                    }
                                                                                    function pdf_reporttenko()
                                                                                    {
                                                                                        save_logprocess('Report', 'Print รายงานเอกสารเท็งโกะ(พื้นฐาน)', '<?= $result_seLogin['PersonCode'] ?>');
                                                                                        var datestart = document.getElementById('txt_datestart').value;
                                                                                        var dateend = document.getElementById('txt_dateend').value;
                                                                                        var employee = document.getElementById('txt_employeename').value;
                                                                                        var area = '<?= $_GET['area'] ?>';
                                                                                        window.open('pdf_reportemployee4_3.php?datestart=' + datestart + '&dateend=' + dateend + '&employee=' + employee + '&area=' + area, '_blank');
                                                                                    }
                                                                                    function pdf_reporttenko2()
                                                                                    {
                                                                                        save_logprocess('Report', 'Print รายงาน SummaryTenko(TGT)', '<?= $result_seLogin['PersonCode'] ?>');
                                                                                        var datestart = document.getElementById('txt_datestart2').value;
                                                                                        var dateend = document.getElementById('txt_dateend2').value;
                                                                                        var id = document.getElementById('txt_id').value

                                                                                        window.open('excel_sumtenko-tgt.php?datestart=' + datestart + '&dateend=' + dateend + '&id=' + id, '_blank');
                                                                                    }

                                                                                    function pdf_reporttenko3()
                                                                                    {
                                                                                        save_logprocess('Report', 'Print รายงาน SummaryTenko(DENSO)', '<?= $result_seLogin['PersonCode'] ?>');
                                                                                        var datestart = document.getElementById('txt_datestart3').value;
                                                                                        var dateend = document.getElementById('txt_dateend3').value;
                                                                                        var id = document.getElementById('txt_id').value

                                                                                        window.open('excel_sumtenko-denso.php?datestart=' + datestart + '&dateend=' + dateend + '&id=' + id, '_blank');
                                                                                    }
                                                                                    function pdf_reporttenko4()
                                                                                    {
                                                                                        save_logprocess('Report', 'Print รายงานเอกสารเท็งโกะ(แยกสถานะ)', '<?= $result_seLogin['PersonCode'] ?>');
                                                                                        var datestart = document.getElementById('txt_datestart').value;
                                                                                        var dateend = document.getElementById('txt_dateend').value;
                                                                                        var employee = document.getElementById('txt_employeename').value;
                                                                                        var status = document.getElementById('cb_status4').value;
                                                                                        var area = '<?= $_GET['area'] ?>';
                                                                                        window.open('pdf_reportemployee4_5.php?datestart=' + datestart + '&dateend=' + dateend + '&employee=' + employee+ '&status=' + status + '&area=' + area, '_blank');
                                                                                    }
                                                                                    function select_reporttenko()
                                                                                    {
                                                                                        save_logprocess('Report', 'Select รายงานเอกสารเท็งโกะ(พื้นฐาน)', '<?= $result_seLogin['PersonCode'] ?>');
                                                                                        $.ajax({
                                                                                            type: 'post',
                                                                                            url: 'meg_data.php',
                                                                                            data: {
                                                                                                txt_flg: "select_reporttenko", date_start: document.getElementById("txt_datestart").value, date_end: document.getElementById("txt_dateend").value, emp: document.getElementById("txt_employeename").value, area: '<?= $_GET['area'] ?>'
                                                                                            },
                                                                                            success: function (response) {

                                                                                                if (response)
                                                                                                {
                                                                                                    document.getElementById("data_sr").innerHTML = response;
                                                                                                    document.getElementById("data_def").innerHTML = "";

                                                                                                }
                                                                                                $(document).ready(function () {
                                                                                                    $('#dataTables-example').DataTable({
                                                                                                        responsive: true,
                                                                                                        order: [[0, "desc"]]
                                                                                                    });
                                                                                                });


                                                                                            }
                                                                                        });
                                                                                    }
                                                                                    function select_reporttenko1()
                                                                                    {
                                                                                        save_logprocess('Report', 'Select รายงานเอกสารเท็งโกะ(มาตฐาน)', '<?= $result_seLogin['PersonCode'] ?>');
                                                                                        $.ajax({
                                                                                            type: 'post',
                                                                                            url: 'meg_data.php',
                                                                                            data: {
                                                                                                txt_flg: "select_reporttenko1", date_start: document.getElementById("txt_datestart1").value, date_end: document.getElementById("txt_dateend1").value, emp: document.getElementById("txt_employeename1").value, area: '<?= $_GET['area'] ?>'
                                                                                            },
                                                                                            success: function (response) {

                                                                                                if (response)
                                                                                                {
                                                                                                    document.getElementById("data_sr1").innerHTML = response;
                                                                                                    document.getElementById("data_def1").innerHTML = "";

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
                                                                                    function select_reporttenko2()
                                                                                    {
                                                                                        save_logprocess('Report', 'Select รายงาน SummaryTenko(TGT)', '<?= $result_seLogin['PersonCode'] ?>');
                                                                                        // alert(document.getElementById("txt_datestart2").value);
                                                                                        // alert(document.getElementById("txt_dateend2").value);
                                                                                        $.ajax({
                                                                                            type: 'post',
                                                                                            url: 'meg_data.php',
                                                                                            data: {
                                                                                                txt_flg: "select_reporttenko2", date_start: document.getElementById("txt_datestart2").value, date_end: document.getElementById("txt_dateend2").value, emp: '', area: '<?= $_GET['area'] ?>'
                                                                                            },
                                                                                            success: function (response) {

                                                                                                if (response)
                                                                                                {
                                                                                                    document.getElementById("data_sr2").innerHTML = response;
                                                                                                    document.getElementById("data_def2").innerHTML = "";

                                                                                                }
                                                                                                $(document).ready(function () {
                                                                                                    $('#dataTables-example3').DataTable({
                                                                                                        responsive: true,
                                                                                                        order: [[0, "desc"]]
                                                                                                    });
                                                                                                });


                                                                                            }
                                                                                        });
                                                                                    }

                                                                                    function select_reporttenko3()
                                                                                    {
                                                                                        save_logprocess('Report', 'Select รายงาน SummaryTenko(DENSO)', '<?= $result_seLogin['PersonCode'] ?>');
                                                                                        // alert(document.getElementById("txt_datestart3").value);
                                                                                        // alert(document.getElementById("txt_dateend3").value);
                                                                                        $.ajax({
                                                                                            type: 'post',
                                                                                            url: 'meg_data.php',
                                                                                            data: {
                                                                                                txt_flg: "select_reporttenko3", date_start: document.getElementById("txt_datestart3").value, date_end: document.getElementById("txt_dateend3").value, emp: '', area: '<?= $_GET['area'] ?>'
                                                                                            },
                                                                                            success: function (response) {

                                                                                                if (response)
                                                                                                {
                                                                                                    document.getElementById("data_sr3").innerHTML = response;
                                                                                                    document.getElementById("data_def3").innerHTML = "";

                                                                                                }
                                                                                                $(document).ready(function () {
                                                                                                    $('#dataTables-example4').DataTable({
                                                                                                        responsive: true,
                                                                                                        order: [[0, "desc"]]
                                                                                                    });
                                                                                                });


                                                                                            }
                                                                                        });
                                                                                    }
                                                                                    function select_reporttenko4()
                                                                                    {
                                                                                        save_logprocess('Report', 'Select รายงานเอกสารเท็งโกะ(แยกสถานะ)', '<?= $result_seLogin['PersonCode'] ?>');
                                                                                        // alert(document.getElementById("txt_datestart3").value);
                                                                                        // alert(document.getElementById("txt_dateend3").value);
                                                                                        $.ajax({
                                                                                            type: 'post',
                                                                                            url: 'meg_data.php',
                                                                                            data: {
                                                                                                txt_flg: "select_reporttenko4", date_start: document.getElementById("txt_datestart4").value, date_end: document.getElementById("txt_dateend4").value, emp: '', area: '<?= $_GET['area'] ?>', status: document.getElementById("cb_status4").value
                                                                                            },
                                                                                            success: function (response) {

                                                                                                if (response)
                                                                                                {
                                                                                                    document.getElementById("data_sr4").innerHTML = response;
                                                                                                    document.getElementById("data_def4").innerHTML = "";

                                                                                                }
                                                                                                $(document).ready(function () {
                                                                                                    $('#dataTables-example5').DataTable({
                                                                                                        responsive: true,
                                                                                                        order: [[0, "desc"]]
                                                                                                    });
                                                                                                });


                                                                                            }
                                                                                        });
                                                                                    }
            </script>
            <script>
                function datetodate()
                {
                    document.getElementById('txt_dateend').value = document.getElementById('txt_datestart').value;

                }
                function datetodate1()
                {
                    document.getElementById('txt_dateend1').value = document.getElementById('txt_datestart1').value;

                }
                function datetodate2()
                {
                    document.getElementById('txt_dateend2').value = document.getElementById('txt_datestart2').value;
                    // select_reporttenko2();
                }
                function datetodate3()
                {
                    document.getElementById('txt_dateend3').value = document.getElementById('txt_datestart3').value;
                    // select_reporttenko2();
                }
                function datetodate4()
                {
                    document.getElementById('txt_dateend4').value = document.getElementById('txt_datestart4').value;
                    // select_reporttenko2();
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
                $(document).ready(function () {
                    $('#dataTables-example').DataTable({
                        responsive: true,
                        order: [[0, "desc"]]
                    });
                });
                $(document).ready(function () {
                    $('#dataTables-example2').DataTable({
                        responsive: true,
                        order: [[0, "desc"]]
                    });
                });
                $(document).ready(function () {
                    $('#dataTables-example3').DataTable({
                        responsive: true,
                        order: [[0, "desc"]]
                    });
                });
                $(document).ready(function () {
                    $('#dataTables-example4').DataTable({
                        responsive: true,
                        order: [[0, "desc"]]
                    });
                });
                $(document).ready(function () {
                    $('#dataTables-example5').DataTable({
                        responsive: true,
                        order: [[0, "desc"]]
                    });
                });
                $(document).ready(function () {
                    $('#dataTables-employees').DataTable({
                        responsive: true,
                        order: [[0, "desc"]]
                    });
                });




            </script>


    </body>

</html>
<?php
sqlsrv_close($conn);
?>
