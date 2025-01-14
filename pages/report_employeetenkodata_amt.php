
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
                                    <li class="active"><a href="#tenkodata" data-toggle="tab">รายงานเอกสารเท็งโกะ</a>
                                    </li>
                                    <li><a href="#sum_tenkotgt" data-toggle="tab">รายงาน SummaryTenko(TGT)</a>
                                    </li>
                                    <li><a href="#sum_tenkodenso" data-toggle="tab">รายงาน SummaryTenko(DENSO)</a>
                                    </li>
                                    <li><a href="#employees_pills" data-toggle="tab">รายงานข้อมูลพนักงานขับรภ</a>
                                    </li>

                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="tenkodata">
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
                                                            <label>&nbsp;</label>
                                                            <div class="form-group">
                                                                <button class="btn btn-default" onclick="select_reporttenko();">ค้นหารายงานเท็งโกะ <li class="fa fa-search"></li></button>
                                                            </div>

                                                        </div>

                                                        <!-- <div class="col-lg-4 text-right">
                                                            <label>&nbsp;</label><br>
                                                            <a href="#" onclick="pdf_reporttenko()" class="btn btn-default">พิมพ์เอกสารเท็งโกะ <li class="fa fa-print"></li></a>
                                                        </div> -->
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
                                                                                <th style="width: 45px">เลขที่งาน</th>
                                                                                <th style="width: 10px">บริษัท</th>
                                                                                <th style="width: 10px">ลูกค้า</th>
                                                                                <th style="width: 10px">ต้นทาง</th>
                                                                                <th style="width: 10px">ปลายทาง</th>
                                                                                <th style="width: 10px">พนักงานที่ 1</th>
                                                                                <th style="width: 60px">รายงาน พขร.1</th>
                                                                                <th style="width: 10px">พนักงานที่ 2</th>
                                                                                <th style="width: 60px">รายงาน พขร.2</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            // $condition2 = "AND a.Company_Code IN ('RKS','RKR','RKL')
                                                                            // AND a.PersonCode NOT IN('070117','070116','021541','021483','021300','011661','010001')
                                                                            // ORDER BY a.PersonCode ASC";
                                                                            // $condition3 = "";

                                                                            $sql_seData = "SELECT VEHICLETRANSPORTPLANID,JOBNO,COMPANYCODE,CUSTOMERCODE,JOBSTART,JOBEND,
                                                                            EMPLOYEENAME1,EMPLOYEECODE1,EMPLOYEENAME2,EMPLOYEECODE2,DATEWORKING,TENKOMASTERID
                                                                            FROM VEHICLETRANSPORTPLAN
                                                                            WHERE CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,GETDATE(),103) AND CONVERT(DATE,GETDATE(),103)
                                                                            AND COMPANYCODE IN ('RKR','RKL','RKS')
                                                                            AND (TENKOMASTERID IS NOT NULL OR TENKOMASTERID !='')";
                                                                            $params_seData = array();


                                                                            $query_seData = sqlsrv_query($conn, $sql_seData, $params_seData);
                                                                            while ($result_seData = sqlsrv_fetch_array($query_seData, SQLSRV_FETCH_ASSOC)) {


                                                                                ?>
                                                                                <tr class="odd gradeX">
                                                                                    <td><?= $result_seData['JOBNO'] ?></td>
                                                                                    <td><?= $result_seData['COMPANYCODE'] ?></td>
                                                                                    <td><?= $result_seData['CUSTOMERCODE'] ?></td>
                                                                                    <td><?= $result_seData['JOBSTART'] ?></td>
                                                                                    <td><?= $result_seData['JOBEND'] ?></td>
                                                                                    <td><?= $result_seData['EMPLOYEENAME1'] ?></td>
                                                                                    <td style="text-align: center">
                                                                                        <div class="btn-group">
                                                                                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                                                                                <i class="fa fa-chevron-down"></i>
                                                                                            </button>
                                                                                            <ul class="dropdown-menu slidedown">
                                                                                                <li>
                                                                                                    <a  data-toggle="modal"  href="#" onclick="print_dataemployee1('<?= $result_seData['EMPLOYEECODE1'] ?>','<?= $result_seData['TENKOMASTERID'] ?>','<?= $result_seData['VEHICLETRANSPORTPLANID'] ?>')">
                                                                                                        เอกสารเท็งโกะ พขร.1
                                                                                                    </a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td><?= $result_seData['EMPLOYEENAME2'] ?></td>
                                                                                    <td style="text-align: center">
                                                                                        <div class="btn-group">
                                                                                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                                                                                <i class="fa fa-chevron-down"></i>
                                                                                            </button>
                                                                                            <ul class="dropdown-menu slidedown">
                                                                                                <li>
                                                                                                    <a  data-toggle="modal"  href="#" onclick="print_dataemployee1('<?= $result_seData['EMPLOYEECODE2'] ?>','<?= $result_seData['TENKOMASTERID'] ?>','<?= $result_seData['VEHICLETRANSPORTPLANID'] ?>')">
                                                                                                        เอกสารเท็งโกะ พขร.2
                                                                                                    </a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </td>



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
                                                                <button type="button" class="btn btn-default" onclick="select_reporttenko2();">ค้นหารายงาน(TGT) <li class="fa fa-search"></li></button>
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
                                                                <button type="button" class="btn btn-default" onclick="select_reporttenko3();">ค้นหารายงาน(DENSO) <li class="fa fa-search"></li></button>
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
                                    

                                    <div class="tab-pane fade" id="employees_pills">
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
                                                                        $area1 = "AND a.Company_Code IN ('RKS','RKR','RKL') AND a.PositionNameOther ='Driver'";

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
            
            <script type="text/javascript">

                                                                                function print_dataemployee1(employeecode,tenkomasterid,vehicletransportplanid)
                                                                                {
                                                                                    // alert(employeecode);
                                                                                    // alert(tenkomasterid);
                                                                                    // alert(vehicletransportplanid);
                                                                                
                                                                                    window.open('pdf_reportemployee4_1.php?employeecode=' + employeecode + '&tenkomasterid=' + tenkomasterid + '&vehicletransportplanid=' + vehicletransportplanid, '_blank');
                                                                                
                                                                                }

                                                                                function print_dataemployee2(employeecode,tenkomasterid,vehicletransportplanid)
                                                                                {
                                                                                    // alert(employeecode);
                                                                                    // alert(tenkomasterid);
                                                                                    // alert(vehicletransportplanid);
                                                                                
                                                                                    window.open('pdf_reportemployee4_1.php?employeecode=' + employeecode + '&tenkomasterid=' + tenkomasterid + '&vehicletransportplanid=' + vehicletransportplanid, '_blank');
                                                                                
                                                                                }

                                                                                
                                                                                 
                                                                                    
                                                                                    

                                                                                    function pdf_employee4_4(employeecode)
                                                                                    {
                                                                                        save_logprocess('Report', 'Print รายงานข้อมูลพนักงานขับรภ', '<?= $result_seLogin['PersonCode'] ?>');
                                                                                        window.open('pdf_reportemployee4_4.php?employeecode=' + employeecode, '_blank');

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
                                                                                    function select_reporttenko()
                                                                                    {
                                                                                        save_logprocess('Report', 'Select รายงานเอกสารเท็งโกะ(พื้นฐาน)', '<?= $result_seLogin['PersonCode'] ?>');
                                                                                        
                                                                                        var area = "amt";
                                                                                        var datestart = document.getElementById("txt_datestart").value;
                                                                                        var dateend   = document.getElementById("txt_dateend").value;

                                                                                        $.ajax({
                                                                                            type: 'post',
                                                                                            url: 'meg_data2.php',
                                                                                            data: {
                                                                                                txt_flg: "select_reporttenko", datestart: datestart, dateend: dateend, area: area 
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
            </script>   
            <script>
                function datetodate()
                {
                    document.getElementById('txt_dateend').value = document.getElementById('txt_datestart').value;

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
