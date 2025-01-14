
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
                            รายงานข้อมูลการรายงานตัวเฉพาะพนักงานที่กักตัว (Quarantine)
                        </h2>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row" >
                    <div class="col-lg-12">
                        <div class="panel-body">

                            <div class="tab-content">
                                <!-- ///////////////////////////////////////////////////////////////////////// -->

                            </div> 
                        </div>

                        <div class="row" >
                            <div class="col-lg-12">
                                <div class="well">
                                    <div class="row">

                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>ค้นหาข้อมูลตามช่วงวันที</label><br><br>
                                                <input class="form-control dateen" style="background-color: #f080802e"  id="txt_datestart_month" name="txt_datestart_month" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">

                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="dropdown bootstrap-select show-tick form-control">
                                                <label>เลือกพนักงาน</label><font style="color: red">* หมายเหตุ กรณีต้องการเลือกพนักงานทั้งหมด ให้กด<b>"เลือกทั้งหมด"</b></font>
                                                <select multiple=""  id="select_employee" name="select_employee" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก พนักงาน" data-hide-disabled="true" data-actions-box="false" data-virtual-scroll="false" tabindex="-98" >
                                                    <option value="all">เลือกทั้งหมด</option>
                                                    <option value="021487">มงคล คมกล้า</option>
                                                    <option value="070141">สมชาย รัตนะวงศวัต</option>
                                                    <option value="080755">อนุรักษ์ พลเภา</option>
                                                    <option value="090298">วะนิดา  ไชยเสริม</option>
                                                    <option value="040479">วรวิทย์  คุณเจริญ</option>
                                                    <option value="090056">มงคล บุญยืน</option>
                                                    <option value="040896">กนกวรรณ บริบูรณ์</option>
                                                    <option value="050107">อุเทน อมากรัมย์</option>
                                                    <option value="040634">ธยาดา พ่วงมาลี</option>
                                                    <option value="040763">จักรกริช  ภางาม</option>
                                                    <option value="090280">กิตติพันธ์ คำตา</option>
                                                    <option value="050099">อภิวัฒน์ เมรสนัด</option>
                                                    <option value="090199">บุญหลาย สิงห์จานุสงค์</option>
                                                    <option value="040789">เสกสรรค์  จีแจ่ม</option>
                                                    <option value="040721">ประดิษฐ์ รุ่งเป้า</option>
                                                    <option value="090015">ณรงค์  อยู่เทียม</option>
                                                    <option value="050039">เกษม  ปันพรหมราช</option>
                                                    <option value="040559">จรัส  อยู่เทียม</option>
                                                    <option value="060179">อิสระ หาญมาก</option>
                                                    <option value="090341">ศิวพงษ์ กตเวทิตาธรรม</option>
                                                    <option value="050115">กฤษฎ์  แก้วสกุล</option>
                                                    <option value="040745">ดำรงค์เดช สุขคี้</option>
                                                    <option value="060248">ณัฐวุฒิ เกาะกาเหนือ</option>
                                                    <option value="040836">สนั่น  อะโนวัน</option>
                                                    <option value="090252">อำนาจ  ชาวดร</option>
                                                    <option value="090004">สมหมาย  สนนอก</option>
                                                    <option value="070220">มงคล กมลรัตน์</option>
                                                    <option value="020724">นรินทร์ พิลึก</option>
                                                    <option value="011688">ศรัญญู แสงสว่าง</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="dropdown bootstrap-select show-tick form-control">
                                                <label>เลือกพื้นที่</label><font style="color: red">* หมายเหตุ กรณีเลือกพนักงานเป็น <br><b>"เลือกทั้งหมด"</b>ให้เลือกพื้นที่ในการค้นหาด้วย </font>
                                                <select  id="select_area" name="select_area" class="selectpicker form-control" data-container="body" data-live-search="false" title="เลือกพื้นที่" data-hide-disabled="true" data-actions-box="false" data-virtual-scroll="false" tabindex="-98" >
                                                    <option value="AMT">อมตะ</option>
                                                    <option value="GW">เกตเวย์</option>
                                                </select>
                                                
                                            </div>
                                        </div>
                                        

                                        <div class="col-lg-4 text-right" >
                                            <label>&nbsp;</label><br>
                                            <br>
                                            <a href="#" onclick="select_excelfcheckinquarantine();" title="Excel" class="btn btn-default">รายงาน (Excel) <li class="fa fa-file-excel-o" ></li></a>
                                            <a href="#" onclick="select_pdfcheckinquarantine();" title="PDF" class="btn btn-default">รายงาน (PDF) <li class="fa fa-file-pdf-o" ></li></a>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- END 2 -->
                        </div>

                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
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
                                                    $(".dateen1").datetimepicker({
                                                        timepicker: true,
                                                        format: 'd/m/Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                                                        lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.


                                                    });
                                                });




                                                function select_excelfcheckinquarantine()
                                                {
                                                    var employeecode = document.getElementById('select_employee').value;
                                                    var datestart = document.getElementById('txt_datestart_month').value;
                                                    var area = document.getElementById('select_area').value;

                                                    // alert(employeecode);
                                                    if (employeecode == 'all') {
                                                        window.open('excel_reportcheckin_quarantineall.php?datestart=' + datestart + '&area=' + area , '_blank');
                                                    }else{
                                                        window.open('excel_reportcheckin_quarantineperson.php?datestart=' + datestart + '&employeecode=' + employeecode, '_blank');
                                                    }
                                                }

                                                function select_pdfcheckinquarantine()
                                                {
                                                    // var department = document.getElementById('select_department_month').value;
                                                    // var section = document.getElementById('select_section_month').value;
                                                    var employeecode = document.getElementById('select_employee').value;
                                                    var datestart = document.getElementById('txt_datestart_month').value;
                                                    var area = document.getElementById('select_area').value;
                                                    // alert(employeecode);
                                                    if (employeecode == 'all') {
                                                        window.open('pdf_reportcheckin_quarantineall.php?datestart=' + datestart + '&area=' + area  , '_blank');
                                                    }else{
                                                        window.open('pdf_reportcheckin_quarantineperson.php?datestart=' + datestart + '&employeecode=' + employeecode, '_blank');
                                                    }
                                                        

                                                

                                                }












                                                $(document).ready(function () {
                                                    $('#dataTables-example').DataTable({
                                                        responsive: true,
                                                    });
                                                });

                                                $(document).ready(function () {
                                                    $('#dataTables-example1').DataTable({
                                                        responsive: true,
                                                    });
                                                });



        </script>


    </body>

</html>
<?php
sqlsrv_close($conn);
?>
