<!DOCTYPE html>
<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");



//smtpmail("wittawat_it@ruamkit.co.th","ทดสอบส่งอีเมล mail","ทดสอบส่งอีเมล mail"); ss
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
        <style>
            .navbar-default {

                border-color: #ffcb0b;
            }
            #page-wrapper {
                border-left: 1px solid #ffcb0b;
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
            <div id="page-wrapper">
                <p>&nbsp;</p>
                <form  name="saveform" id="saveform" method="post">
                    <input type="text" id="txt_vehicleinfoid" name="txt_vehicleinfoid" style="display: none" value="<?= $_GET['vehicleinfoid'] ?>">


                    <div class="row">
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>หมวดหมู่การแจ้งเตือน</label>
                                <select class="form-control" id="cb_catwarningdata" name="cb_catwarningdata">

                                    <option value="ข้อมูลประกันภัย">ข้อมูลประกันภัย</option>
                                    <option value="ข้อมูลภาษี">ข้อมูลภาษี</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">

                            <div class="form-group">
                                <label>&nbsp;</label><br>
                                <button type="button" class="btn btn-default" onclick="get_vehicle();">ค้นหา <li class="fa fa-search"></li></button>
                            </div>
                        </div>


                        <div class="col-lg-3">

                            <div class="form-group">
                                <label>อีเมลในการส่งข้อมูล</label>
                                <input type="text" class="form-control " id="txt_email"   name="txt_email" placeholder="email@email.com" value="">
                            </div>
                        </div>
                        <div class="col-lg-1" >

                            <div class="form-group">
                                <label>&nbsp;</label><br>
                                <button type="button" class="btn btn-default" name="sendemail" onclick="send_emailwarning()" id="sendemail">ส่ง Email <li class="fa fa-envelope-o "></li></button>
                            </div>
                        </div>


                    </div>
                    <?php
                    if ($_GET['type'] == "warningdata") {
                        ?>

                        <div class="row" >
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #e7e7e7">
                                        <font style="font-size: 16px"><b>รายการแจ้งเตือน</b></font>                            
                                    </div>
                                    <div class="panel-body">
                                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div id="datadef">
                                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                            <thead>
                                                                <tr>

                                                                    <th>เลขกรมธรรม์</th>
                                                                    <th>กลุ่มประกันภัย</th>
                                                                    <th>ประเภทประกันภัย</th>
                                                                    <th>เบี้ยประกันภัย</th>
                                                                    <th>วงเงินความคุ้มครองสูงสุด</th>
                                                                    <th>วันที่เริ่มคุ้มครอง</th>
                                                                    <th>วันที่สิ้นสุดความคุ้มครอง</th>
                                                                    <th>ชื่อบริษัทผู้เอาประกันภัย</th>
                                                                    <th>ชื่อนายหน้าประกันภัย</th>
                                                                    <th>ชื่อบริษัทประกันภัย</th>
                                                                    <th>หมายเหตุ</th>
                                                                    <th>สถานะ</th>
                                                                    <th>เหลือ(วัน)</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $sql_seWarning = "{call megVehicleinsured_v2(?)}";
                                                                $params_seWarning = array(
                                                                    array('get_vehicleinsuredA', SQLSRV_PARAM_IN)
                                                                );

                                                                $query_seWarning = sqlsrv_query($conn, $sql_seWarning, $params_seWarning);
                                                                while ($result_seWarning = sqlsrv_fetch_array($query_seWarning, SQLSRV_FETCH_ASSOC)) {
                                                                    ?>

                                                                    <tr>
                                                                        <td><?= $result_seWarning['POLICYNUMBER'] ?></td>
                                                                        <td><?php echo ($result_seWarning['INSUREDGROUP'] == "1") ? "ภาคสมัครใจ" : "ภาคบังคับ"; ?></td>
                                                                        <td>ประกันภัยชั้น <?= $result_seWarning['INSUREDTYPE'] ?></td>
                                                                        <td><?= $result_seWarning['PRICETOTAL'] ?></td>
                                                                        <td><?= $result_seWarning['SUMINSURED'] ?></td>
                                                                        <td><?= $result_seWarning['STARTDATE'] ?></td>
                                                                        <td><?= $result_seWarning['EXPIREDDATE'] ?></td>
                                                                        <td><?= $result_seWarning['INSUREDNAME'] ?></td>
                                                                        <td><?= $result_seWarning['BROKERNAME'] ?></td>
                                                                        <td><?= $result_seWarning['INSUREDCOMPANY'] ?></td>
                                                                        <td><?= $result_seWarning['REMARK'] ?></td>
                                                                        <td><?php echo ($result_seWarning['ACTIVESTATUS'] == "1") ? "ใช้งาน" : "ไม่ใช้งาน"; ?></td>
                                                                        <td><?= $result_seWarning['WARNINGDAY'] ?></td>

                                                                    </tr>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div id="datasr"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                    }
                    ?>
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
        <!--<script src="/../dist/js/buttons.colVis.min.js"></script>-->


        <script src="../dist/js/jquery.autocomplete.js"></script>
        <script>

                                    $(document).ready(function () {
                                        $('#dataTables-example').DataTable({
                                            responsive: true,
                                            /*dom: 'Bfrtip',
                                             buttons: [
                                             
                                             {
                                             extend: 'excelHtml5',
                                             exportOptions: {
                                             columns: ':visible'
                                             }
                                             },
                                             
                                             'colvis'
                                             ]*/
                                        });
                                    });

        </script>
        <script type="text/javascript">
            $(function () {
                $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                // กรณีใช้แบบ input
                $(".dateen").datetimepicker({
                    timepicker: false,
                    format: 'd/m/Y', // กำหนดรูปแบsบวันที่ ที่ใช้ เป็น 00-00-0000			
                    lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                });
            });


        </script>
        <script>

            var txt_email = [
<?php
$Empname1 = "";
$sql_seEmpname1 = "{call megStopwork_v2(?,?)}";
$params_seEmpname1 = array(
    array('select_employee', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seEmpname1 = sqlsrv_query($conn, $sql_seEmpname1, $params_seEmpname1);
while ($result_seEmpname1 = sqlsrv_fetch_array($query_seEmpname1, SQLSRV_FETCH_ASSOC)) {
    $Empname1 .= "'" . $result_seEmpname1['EMAILADDRESS'] . "',";
}
echo rtrim($Empname1, ",");
?>
            ];

            $(function () {
                $("#txt_email").autocomplete({
                    source: [txt_email]
                });


            });
        </script>
        <script>
            function datetodate()
            {
                document.getElementById('txt_dateend').value = document.getElementById('txt_datestart').value;

            }
            function get_vehicle()
            {
                var txt_flg = "";
                var catwarningdata = document.getElementById('cb_catwarningdata').value;
                if (catwarningdata == "ข้อมูลประกันภัย")
                {
                    txt_flg = "get_vehicleinsured"
                } else if (catwarningdata == "ข้อมูลภาษี")
                {
                    txt_flg = "get_vehicletax"
                }


                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: txt_flg, catwarningdata: catwarningdata
                    },
                    success: function (response) {
                        document.getElementById("datasr").innerHTML = response;
                        document.getElementById("datadef").innerHTML = '';


                        $('#dataTables-example').DataTable({
                            responsive: true,
                            dom: 'Bfrtip',
                            buttons: [

                                {
                                    extend: 'excelHtml5',
                                    exportOptions: {
                                        columns: ':visible'
                                    }
                                },

                                'colvis'
                            ]
                        });
                    }
                });
            }
            function send_emailwarning()
            {
                var type = document.getElementById('cb_catwarningdata').value;
                var email = document.getElementById('txt_email').value;
                var subject = "แจ้งเตือน" + type + "หมดอายุ";
                var body = "ระบบแจ้งเตือน" + type + "หมดอายุอัตโนมัติ";

                window.open('pdf_warningdata.php?type=' + type + '&email=' + email + '&subject=' + subject + '&body=' + body);

            }

        </script>

    </body>

</html>
<?php
sqlsrv_close($conn);
?>
