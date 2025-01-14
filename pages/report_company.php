
<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$condition1 = " AND (a.USERNAME ='" . $_SESSION["USERNAME"] . "' AND a.PASSWORD = '" . $_SESSION["PASSWORD"] . "') AND a.ACTIVESTATUS = 1";
$sql_seLogin = "{call megRoleaccount_v2(?,?)}";
$params_seLogin = array(
    array('select_roleaccount', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_seLogin = sqlsrv_query($conn, $sql_seLogin, $params_seLogin);
$result_seLogin = sqlsrv_fetch_array($query_seLogin, SQLSRV_FETCH_ASSOC);

if ($_GET['id1'] != "") {
    $condition1 = " AND a.MENUID = " . $_GET['id1'];
    $sql_getMenu = "{call megMenu_v2(?,?)}";
    $params_getMenu = array(
        array('select_menu', SQLSRV_PARAM_IN),
        array($condition1, SQLSRV_PARAM_IN)
    );
    $query_getMenu = sqlsrv_query($conn, $sql_getMenu, $params_getMenu);
    $result_getMenu = sqlsrv_fetch_array($query_getMenu, SQLSRV_FETCH_ASSOC);
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
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
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
        <input type="text" class="form-control" id="txt_companycode" name="txt_companycode" style="display: none">
        <div id="wrapper">
            <div class="modal fade" id="modal_datecompany" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="width: 40%">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="row">
                                <div class="col-lg-5">
                                    <h5 class="modal-title" id="title_copydiagram"><b>เลือก <u>เดือน/ปี</u> ในการแสดงข้อมูล</b></h5>
                                </div>

                            </div>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-lg-6">
                                    <label>เดือน/ปี :</label>
                                    <input type="text" class="form-control dateen" id="txt_datestart" name="txt_datestart" autocomplete="off">
                                </div>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" onclick="select_companycompensationexcel_1()">EXCEL(Summary) <i class="fa fa-file-excel-o"></i></button>
                            <button type="button" class="btn btn-primary" onclick="select_companycompensationexcel_2()">EXCEL(Detail) <i class="fa fa-file-excel-o"></i></button>
                            <button type="button" class="btn btn-primary" onclick="select_companycompensation_1()">PDF(Summary) <i class="fa fa-file-pdf-o"></i></button>
                            <!--<button type="button" class="btn btn-primary" onclick="select_companycompensation_2()">PDF(Detail) <i class="fa fa-file-pdf-o"></i></button>-->
                        </div>

                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal_datecompany2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="width: 40%">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="row">
                                <div class="col-lg-5">
                                    <h5 class="modal-title" id="title_copydiagram"><b>เลือก <u>วัน/เดือน/ปี</u> ในการแสดงข้อมูล</b></h5>
                                </div>

                            </div>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-lg-6">
                                    <label>วันที่เริ่มต้น :</label>
                                    <input type="text" onchange="datetodate();" class="form-control dateen2" id="txt_datestart2" name="txt_datestart2" autocomplete="off">
                                </div>
                                <div class="col-lg-6">
                                    <label>วันที่สิ้นสุด :</label>
                                    <input type="text" class="form-control dateen2" id="txt_dateend2" name="txt_dateend2" autocomplete="off">
                                </div>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" onclick="excel_reportcompanycompensation3()">EXCEL <i class="fa fa-print"></i></button>

                        </div>

                    </div>
                </div>
            </div>
            <div class="modal fade" id="modal_datecompany3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="width: 40%">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="row">
                                <div class="col-lg-5">
                                    <h5 class="modal-title" id="title_copydiagram"><b>เลือก <u>เดือน/ปี</u> ในการแสดงข้อมูล</b></h5>
                                </div>

                            </div>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-lg-6">
                                    <label>เดือน/ปี :</label>
                                    <input type="text" class="form-control dateen" id="txt_datestart3" name="txt_datestart3" autocomplete="off">
                                </div>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" onclick="excel_reportcompanycompensation2()">EXCEL <i class="fa fa-print"></i></button>

                        </div>

                    </div>
                </div>
            </div>    
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

                        <h2 class="page-header"><i class="fa fa-truck"></i>
                            บริษัท

                        </h2>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color: #e7e7e7">

                                <?php
                                echo "บริษัท";
                                $link = "<a href='report_companyamata.php?type=report'>บริษัท</a>";
                                $_SESSION["link"] = $link;
                                ?>
                            </div>
                            <!-- /.panel-heading -->

                            <div class="panel-body">
                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>ชื่อบริษัท</th>

                                                <th style="text-align: center">ข้อมูลย่อย</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $condition2 = ($_GET['area'] == 'gateway') ? " AND Company_Code IN ('RRC','RATC','RCC')" : " AND Company_Code IN ('RKS','RKR','RKL','RTC','RTD','RIT')";


                                            $sql_seComp = "{call megCompany_v2(?,?)}";
                                            $params_seComp = array(
                                                array('select_company', SQLSRV_PARAM_IN),
                                                array($condition2, SQLSRV_PARAM_IN)
                                            );


                                            $query_seComp = sqlsrv_query($conn, $sql_seComp, $params_seComp);
                                            while ($result_seComp = sqlsrv_fetch_array($query_seComp, SQLSRV_FETCH_ASSOC)) {
                                                ?>
                                                <tr class="odd gradeX">
                                                    <td><?= $result_seComp['Company_NameT'] ?></td>
                                                    <td style="text-align: center"><div class="btn-group">
                                                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                                                <i class="fa fa-chevron-down"></i>
                                                            </button>
                                                            <ul class="dropdown-menu slidedown">
                                                                <li>
                                                                    <a href="#" data-toggle="modal" data-target="#modal_datecompany" onclick="modal_companycompensation('<?= $result_seComp['Company_Code'] ?>')" >
                                                                        รายงานค่าเที่ยวรายบริษัท
                                                                    </a>
                                                                </li>
                                                                <?php
                                                                if ($result_seComp['Company_Code'] == 'RRC') {
                                                                    ?>
                                                                    <li>
                                                                        <a href="#" data-toggle="modal" data-target="#modal_datecompany2" onclick="modal_companycompensation('<?= $result_seComp['Company_Code'] ?>')">
                                                                            รายงานค่าเที่ยว (GMT/TTAST)
                                                                        </a>
                                                                    </li>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <?php
                                                                if ($result_seComp['Company_Code'] == 'RCC' || $result_seComp['Company_Code'] == 'RATC') {
                                                                    ?>
                                                                    <li>
                                                                        <a href="report_employee8.php?area=gateway" >
                                                                            รายงานค่าเที่ยว (เบี้ยเลี้ยง/อาหาร)
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#" data-toggle="modal" data-target="#modal_datecompany3" onclick="modal_companycompensation('<?= $result_seComp['Company_Code'] ?>')">
                                                                            รายงานค่าเที่ยว (LOADS)
                                                                        </a>
                                                                    </li>
                                                                    <?php
                                                                }
                                                                ?>




                                                            </ul>
                                                        </div></td>



                                                </tr>

                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
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
        <script>
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
                                                                            function datetodate()
                                                                            {
                                                                                document.getElementById('txt_dateend2').value = document.getElementById('txt_datestart2').value;

                                                                            }
                                                                            $(function () {
                                                                                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                                // กรณีใช้แบบ input
                                                                                $(".dateen").datetimepicker({
                                                                                    timepicker: false,
                                                                                    format: 'm/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                                                                    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


                                                                                });
                                                                            });
                                                                            $(function () {
                                                                                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                                                                                // กรณีใช้แบบ input
                                                                                $(".dateen2").datetimepicker({
                                                                                    timepicker: false,
                                                                                    format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                                                                    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


                                                                                });
                                                                            });
                                                                            function select_companycompensation_1()
                                                                            {
                                                                                save_logprocess('Report', 'PDF รายงานค่าเที่ยว(Summary)(RRC)', '<?= $result_seLogin['PersonCode'] ?>');
                                                                                var datestart = document.getElementById('txt_datestart').value;

                                                                                var companycode = document.getElementById('txt_companycode').value;

                                                                                window.open('pdf_companycompensationgw_1.php?companycode=' + companycode + '&datestart=' + datestart, '_blank');
                                                                            }
                                                                            function select_companycompensation_2()
                                                                            {
                                                                                var datestart = document.getElementById('txt_datestart').value;

                                                                                var companycode = document.getElementById('txt_companycode').value;

                                                                                window.open('pdf_companycompensationgw_2.php?companycode=' + companycode + '&datestart=' + datestart, '_blank');
                                                                            }

                                                                            function select_companycompensationexcel_1()
                                                                            {
                                                                                save_logprocess('Report', 'Excel รายงานค่าเที่ยว(Summary)(RRC)', '<?= $result_seLogin['PersonCode'] ?>');
                                                                                var datestart = document.getElementById('txt_datestart').value;

                                                                                var companycode = document.getElementById('txt_companycode').value;

                                                                                window.open('excel_reportcompanycompensationgw_1.php?companycode=' + companycode + '&datestart=' + datestart, '_blank');
                                                                            }
                                                                            function select_companycompensationexcel_2()
                                                                            {
                                                                                save_logprocess('Report', 'Excel รายงานค่าเที่ยว(Detail)(RRC)', '<?= $result_seLogin['PersonCode'] ?>');
                                                                                var datestart = document.getElementById('txt_datestart').value;

                                                                                var companycode = document.getElementById('txt_companycode').value;

                                                                                window.open('excel_reportcompanycompensationgw_2.php?companycode=' + companycode + '&datestart=' + datestart, '_blank');
                                                                            }

                                                                            function excel_reportcompanycompensation2()
                                                                            {
                                                                                var datestart = document.getElementById('txt_datestart3').value;
                                                                                var companycode = document.getElementById('txt_companycode').value;

                                                                                window.open('excel_reportcompanycompensationgw2.php?companycode=' + companycode + '&datestart=' + datestart, '_blank');
                                                                            }
                                                                            function excel_reportcompanycompensation3()
                                                                            {
                                                                                save_logprocess('Report', 'Excel รายงานค่าเที่ยว (GMT/TTAST)(RRC)', '<?= $result_seLogin['PersonCode'] ?>');
                                                                                var datestart = document.getElementById('txt_datestart2').value;
                                                                                var dateend = document.getElementById('txt_dateend2').value;
                                                                                var companycode = document.getElementById('txt_companycode').value;

                                                                                window.open('excel_reportcompanycompensationgw3.php?companycode=' + companycode + '&datestart=' + datestart + '&dateend=' + dateend, '_blank');
                                                                            }
                                                                            function modal_companycompensation(companycode)
                                                                            {
                                                                                document.getElementById('txt_companycode').value = companycode;
                                                                            }
                                                                            $(document).ready(function () {
                                                                                $('#dataTables-example').DataTable({
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
