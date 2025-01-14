
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
                                    <li class="active"><a href="#home-pills" data-toggle="tab">รายงานเอกสารเท็งโกะ</a>
                                    </li>
                                    <li><a href="#profile-pills" data-toggle="tab">รายงานเอกสารเท็งโกะอื่นๆ</a>
                                    </li>
                                    <li><a href="#sum_tenko" data-toggle="tab">รายงาน SummaryTenko(TGT)</a>
                                    </li>
                                    <li><a href="#employees-pills" data-toggle="tab">รายงานข้อมูลพนักงานขับรภ</a>
                                    </li>

                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
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
                                                        รายงานเอกสารเท็งโกะ
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
                                                                            <th>Job No</th>
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
                                                                                <td><?= $result_seTenkobrfore['JOBNO'] ?></td>
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
                                    <div class="tab-pane fade " id="sum_tenko">
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
                                                        <input type="text" id="txt_name"  readonly=""  name="txt_name" value="<?= $result_seEmployee['nameT'] ?>" style=" display: none">
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
                                                            <a href="#" onclick="pdf_reporttenko2()" class="btn btn-default">พิมพ์เอกสารเท็งโกะ <li class="fa fa-print"></li></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                                        รายงานเอกสารเท็งโกะ
                                                    </div>
                                                    <!-- /.panel-heading -->

                                                    <div class="panel-body">

                                                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                            <div id="data_def2">
                                                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example3" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                    <thead>
                                                                        <tr>
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
                                                                                          FROM [dbo].[TENKOMASTER] a
                                                                                          INNER JOIN [dbo].[TENKOBEFORE]  b ON b.TENKOMASTERID = a.TENKOMASTERID
                                                                                          WHERE CONVERT(DATE,b.CREATEDATE) = CONVERT(DATE,GETDATE())
                                                                                    		  AND a.JOBSTART IN ('TGT1 (Amatanakorn IE.)','TGT2 (Amatanakorn IE.)','TGT2+TGT3 (Amatanakorn IE.)','TGT3 (Amatanakorn IE.)','TGT3+TGT1 (Amatanakorn IE.)','TGT2 (Amata city chonburi)'
                                                                                          ,'TGT3 (Amata city chonburi)','TGT1 (Amata city chonburi)','TGT2 (Amata city chonburi)') ORDER BY JOBSTART ASC";
                                                                        $params_seSumTenko = array();
                                                                        $query_seSumTenko = sqlsrv_query($conn, $sql_seSumTenko, $params_seSumTenko);
                                                                        while ($result_seSumTenko = sqlsrv_fetch_array($query_seSumTenko, SQLSRV_FETCH_ASSOC)) {
                                                                            ?>
                                                                            <tr class="odd gradeX">

                                                                                <td><?= $result_seSumTenko['DATE'] ?></td>
                                                                                <td><?= $result_seSumTenko['NAME'] ?></td>
                                                                                <td><?= $result_seSumTenko['OFFICER'] ?></td>
                                                                                <td><?= $result_seSumTenko['DBP'] ?></td>
                                                                                <td><?= $result_seSumTenko['SBP'] ?></td>
                                                                                <td><?= $result_seSumTenko[''] ?></td>
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
                                                        <input type="text" name="" id="txt_area" value="<?=$_GET['area']?>" style="display:none">
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
                                                        รายงานเอกสารเท็งโกะอื่นๆ
                                                    </div>
                                                    <!-- /.panel-heading -->

                                                    <div class="panel-body">

                                                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                            <div id="data_def1">
                                                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example2" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="text-align: center">บริษัท11</th>
                                                                            <th style="text-align: center">ชื่อรถ</th>
                                                                            <th>Job No</th>
                                                                            <th>วันที่</th>
                                                                            <th style="text-align: center">ชื่อ-นามสกุล(1)</th>
                                                                            <th style="text-align: center">ชื่อ-นามสกุล(2)</th>
                                                                            <th style="text-align: center">รายงานเอกสารเท็งโกะ 2</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <!-- <?php
                                                                        $area = ($_GET['area'] == 'amata') ? " AND c.Company_Code IN ('RKS','RKR','RKL','RIT','RTD','RTC','RKB')" : " ";
                                                                        $condiTenkobefore = " AND CONVERT(DATE,a.CREATEDATE) = CONVERT(DATE,GETDATE())" . $area;

                                                                        $sql_seTenkobefore = "SELECT a.TENKOMASTERDIRVERNAME,a.TENKOMASTERDIRVERCODE,CONVERT(VARCHAR(10), a.CREATEDATE, 103) + ' '  + convert(VARCHAR(8), a.CREATEDATE, 14) AS 'CREATEDATE',
                                                                                            b.VEHICLEREGISNUMBER,a.TENKOMASTERID
                                                                                            FROM dbo.TENKOBEFORE a
                                                                                            INNER JOIN TENKOMASTER b ON a.TENKOMASTERID = b.TENKOMASTERID
                                                                                            WHERE a.ACTIVESTATUS = '1'
                                                                                            AND CONVERT(DATE,a.CREATEDATE) BETWEEN CONVERT(DATE,'" . $_POST['date_start'] . "',103) AND CONVERT(DATE,'" . $_POST['date_end'] . "',103)";

                                                                        $params_seTenkobefore = array(
                                                                            array('select_tenkomaster', SQLSRV_PARAM_IN),
                                                                            array($condiTenkobefore, SQLSRV_PARAM_IN)
                                                                        );
                                                                        $query_seTenkbefore = sqlsrv_query($conn, $sql_seTenkobefore, $params_seTenkobefore);
                                                                        while ($result_seTenkbefore = sqlsrv_fetch_array($query_seTenkbefore, SQLSRV_FETCH_ASSOC)) {
                                                                            ?>
                                                                            <tr class="odd gradeX">


                                                                                <td><?= $result_seTenkbefore['VEHICLEREGISNUMBER'] ?></td>
                                                                                <td>-</td>
                                                                                <td><?= $result_seTenkbefore['CREATEDATE'] ?></td>
                                                                                <td>
                                                                                    <?php
                                                                                    if ($result_seTenkbefore['TENKOMASTERDIRVERNAME'] != "") {
                                                                                        ?>

                                                                                        <?= $result_seTenkbefore['TENKOMASTERDIRVERNAME'] ?>
                                                                                        <div class="btn-group">
                                                                                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                                                                                <i class="fa fa-chevron-down"></i>
                                                                                            </button>
                                                                                            <ul class="dropdown-menu slidedown">

                                                                                                <li>

                                                                                                    <a href="pdf_reportemployee4_1.php?employeecode=<?= $result_seTenkbefore['TENKOMASTERDIRVERCODE'] ?>&tenkomasterid=<?= $result_seTenkbefore['TENKOMASTERID'] ?>" target="_bank">รายงานเอกสารเท็งโกะ 1</a>
                                                                                                </li>


                                                                                            </ul>
                                                                                        </div>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </td>

                                                                                <td style="text-align: center">
                                                                                    <div class="btn-group">
                                                                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                                                                            <i class="fa fa-chevron-down"></i>
                                                                                        </button>
                                                                                        <ul class="dropdown-menu slidedown">



                                                                                            <li>

                                                                                                <a href="pdf_reportemployee4_2.php?vehicletransportplanid=<?= $result_seTenkmaster['TENKOMASTERDIRVERCODE'] ?>" target="_bank">รายงานเอกสารเท็งโกะ 2</a>
                                                                                            </li>

                                                                                        </ul>
                                                                                    </div></td>



                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                        ?> -->
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

                                                                                            window.open('pdf_reportemployee4_4.php?employeecode=' + employeecode, '_blank');

                                                                                        }

                                                                                        function pdf_employeeall4_1()
                                                                                        {
                                                                                            var datestart = document.getElementById('txt_datestart1').value;
                                                                                            var dateend = document.getElementById('txt_dateend1').value;
                                                                                            var employee = document.getElementById('txt_employeename1').value;
                                                                                            var area = document.getElementById('txt_area').value;;
                                                                                            window.open('pdf_reportemployeeall4_1old.php?datestart=' + datestart + '&dateend=' + dateend + '&employee=' + employee + '&area=' + area, '_blank');

                                                                                        }
                                                                                        function pdf_reporttenko()
                                                                                        {
                                                                                            var datestart = document.getElementById('txt_datestart').value;
                                                                                            var dateend = document.getElementById('txt_dateend').value;
                                                                                            var employee = document.getElementById('txt_employeename').value;
                                                                                            var area = '<?= $_GET['area'] ?>';
                                                                                            window.open('pdf_reportemployee4_3.php?datestart=' + datestart + '&dateend=' + dateend + '&employee=' + employee + '&area=' + area, '_blank');
                                                                                        }
                                                                                        function pdf_reporttenko2()
                                                                                        {
                                                                                            var datestart = document.getElementById('txt_datestart2').value;
                                                                                            var dateend = document.getElementById('txt_dateend2').value;
                                                                                            var name = document.getElementById('txt_name').value

                                                                                            window.open('excel_sumtenko.php?datestart=' + datestart + '&dateend=' + dateend + '&name=' + name, '_blank');
                                                                                        }

                                                                                        function select_reporttenko()
                                                                                        {

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

                                                                                          var emp = document.getElementById("txt_employeename1").value;
                                                                                          var area = document.getElementById("txt_area").value;

                                                                                          // alert(emp);
                                                                                          // alert(area);

                                                                                            $.ajax({
                                                                                                type: 'post',
                                                                                                url: 'meg_data.php',
                                                                                                data: {
                                                                                                    txt_flg: "select_reporttenko1_old", date_start: document.getElementById("txt_datestart1").value, date_end: document.getElementById("txt_dateend1").value, emp: document.getElementById("txt_employeename1").value, area: area
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
