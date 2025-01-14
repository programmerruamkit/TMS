<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
$condition1 = " AND a.EMPLOYEEID =" . $_SESSION["EMPLOYEEID"];
$sql_seEmp = "{call megStopwork_v2(?,?)}";
$params_seEmp = array(
    array('select_employee', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_seEmp = sqlsrv_query($conn, $sql_seEmp, $params_seEmp);
$result_seEmp = sqlsrv_fetch_array($query_seEmp, SQLSRV_FETCH_ASSOC);


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
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">


        <link href="../dist/css/buttons.dataTables.min.css" rel="stylesheet">
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">

        <style>

            .navbar-default {

                border-color: #ffcb0b;
            }
            #page-wrapper {

                border-left: 1px solid #ffcb0b;
            }



            /*.bootstrap-select > .dropdown-toggle {
                width: 325px;
            }*/
        </style>

    </head>

    <body >
        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <?php
                include '../pages/meg_header.php';
                include '../pages/meg_leftmenu.php';
                ?>
            </nav>

            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="page-header"><i class="fa fa-file-text-o"></i> 
                            รายงานขอแจ้งหยุดรถ
                        </h2>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>


                <div class="row">

                    <div class="col-lg-2">
                        <label>บริษัท</label><br>

                        <select class="selectpicker" multiple="" data-actions-box="true" id="cb_comp" name="cb_comp">
                            <!--<option value = "">บริษัททั้งหมด</option>-->    

                            <?php
                            $sql_seComp = "{call megCompanyEHR_v2(?,?)}";
                            $params_seComp = array(
                                array('select_company', SQLSRV_PARAM_IN),
                                array('', SQLSRV_PARAM_IN)
                            );
                            $query_seComp = sqlsrv_query($conn, $sql_seComp, $params_seComp);
                            while ($result_seComp = sqlsrv_fetch_array($query_seComp, SQLSRV_FETCH_ASSOC)) {
                                ?>
                                <option value = "<?= $result_seComp['Company_Code'] ?>"><?= $result_seComp['Company_Code'] ?> <?= $result_seComp['Company_NameT'] ?></option> 
                                <?php
                            }
                            ?>
                        </select>
                        <input class="form-control" style="display: none"  id="txt_comp" name="txt_comp" maxlength="500" value="" >

                    </div>
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
                    <div class="col-lg-2">
                        <label>&nbsp;</label>
                        <div class="form-group">
                            <button type="button" class="btn btn-default" onclick="select_stopwork();">ค้นหา <li class="fa fa-search"></li></button>
                        </div>

                    </div>
                    <!--<div class="col-lg-3" >
                        <label>ชื่อผู้แจ้ง</label>
                        <div class="form-group">
                            <input type="text"  name="txt_employeename"  id="txt_employeename" class="form-control" onblur="chg_employee(this.value)">
                            <input type="hidden"  name="txt_employeeid"  id="txt_employeeid" class="form-control">
                        </div>
                    </div>
                    -->

                </div>
                <div class="row">

                    <div class="col-lg-6" >
                        <label>&nbsp;</label><br>
                        <!--<a href="#" onclick="pdf_chartstopwork();" class="btn btn-default">สถิติการขอหยุดรถ <li class="fa fa-print"></li></a>-->
                    </div>
                    <div class="col-lg-6" style="text-align: right">
                        <label>&nbsp;</label><br>
                        <a href="#" onclick="pdf_stopwork(1);" class="btn btn-default">พิมพ์ 1 <li class="fa fa-print"></li></a>&nbsp;&nbsp;<a href="#" onclick="pdf_stopwork(2);" class="btn btn-default">พิมพ์ 2 <li class="fa fa-print"></li></a>&nbsp;&nbsp;<button type="button" onclick="excel_stopwork()" class="btn btn-default">Excel <li class="fa fa-file-excel-o"></li></button>
                    </div>
                </div>
                <div class="row" >
                    <div class="col-lg-12">
                        &nbsp;

                    </div>
                </div>
                <div class="row">

                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                รายงานขอแจ้งหยุดรถ
                            </div>
                            <!-- /.panel-heading -->

                            <div class="panel-body">


                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                    <div id="datade">
                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>รหัสพนักงาน</th>
                                                    <th>ชื่อ-สกุล(พขร.)</th>
                                                    <th>กระบวนการหยุด</th>
                                                    <th>เหตุผล</th>
                                                    <th>ประเภทรถ</th>
                                                    <th>สถานะรถ</th>
                                                    <th>ทะเบียนรถ</th>
                                                    <th>เบอร์รถ/ชื่อรถ</th>
                                                    <th>จุดจอด</th>
                                                    <th>เวลาที่เริ่มหยุด</th>
                                                    <th>เวลาที่หยุดเสร็จ</th>
                                                    <th>เวลา Tenko</th>
                                                    <th>วันที่</th>
                                                    <th>งานที่รับเที่ยวที่ 1</th>
                                                    <th>เวลาที่รับเที่ยวที่ 1</th>
                                                    <th>งานที่รับเที่ยวที่ 2</th>
                                                    <th>เวลาที่รับเที่ยวที่ 2</th>
                                                    <th>เลขใบส่งสินค้า</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $condition1 = " AND a.DATEINPUT = convert(DATE, GETDATE()) ";
                                                $sql_seStopwork = "{call megStopwork_v2(?,?)}";
                                                $params_seStopwork = array(
                                                    array('select_stopwork', SQLSRV_PARAM_IN),
                                                    array($condition1, SQLSRV_PARAM_IN)
                                                );
                                                $query_seStopwork = sqlsrv_query($conn, $sql_seStopwork, $params_seStopwork);
                                                while ($result_seStopwork = sqlsrv_fetch_array($query_seStopwork, SQLSRV_FETCH_ASSOC)) {

                                                  
                                                    ?>
                                                    <tr class="odd gradeX">
                                                        <td><?= $result_seStopwork['EMPLOYEEID'] ?></td>
                                                        <td><?= $result_seStopwork['EMPLOYEENAME'] ?></td>
                                                        <td><?= $result_seStopwork['STOPPROCESS'] ?></td>
                                                        <td><?= $result_seStopwork['REASON'] ?></td>
                                                        <td><?= $result_seStopwork['VEHICLETYPEDESC'] ?></td>
                                                        <td><?= $result_seStopwork['CARSTATUS'] ?></td>
                                                        <td><?= $result_seStopwork['VEHICLEREGISNUMBER'] ?></td>
                                                        <td><?= $result_seStopwork['THAINAME'] ?></td>
                                                        <td><?= $result_seStopwork['PARKINGN'] ?></td>
                                                        <td><?= $result_seStopwork['STARTTIME'] ?></td>
                                                        <td><?= $result_seStopwork['STOPTIME'] ?></td>
                                                        <td><?= $result_seStopwork['TENKOTIME'] ?></td>
                                                        <td><?= $result_seStopwork['DATEINPUT'] ?></td>
                                                        <td><?= $result_seStopwork['JOBINPUT'] ?></td>
                                                        <td><?= $result_seStopwork['TIMEINPUT'] ?></td>
                                                        <td><?= $result_seStopwork['JOBINPUT2'] ?></td>
                                                        <td><?= $result_seStopwork['TIMEINPUT2'] ?></td>
                                                        <td><?= $result_seStopwork['PRODUCTNUMBER'] ?></td>

                                                    </tr>
                                                    <?php
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

        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="../vendor/metisMenu/metisMenu.min.js"></script>
        <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
        <script src="../dist/js/sb-admin-2.js"></script>
        <script src="../js/jquery.datetimepicker.full.js"></script>

        <script src="../dist/js/jszip.min.js"></script>
        <script src="../dist/js/dataTables.buttons.min.js"></script>
        <script src="../dist/js/buttons.html5.min.js"></script>
        <script src="../dist/js/buttons.print.min.js"></script>
        <script src="../dist/js/bootstrap-select.js"></script>
        <script src="../dist/js/jquery.autocomplete.js"></script>

        <script>
                            function chg_employee(val)
                            {
                                $.ajax({
                                    type: 'post',
                                    url: 'meg_data.php',
                                    data: {
                                        txt_flg: "se_employeename", txt_employeename: val
                                    },
                                    success: function (response) {
                                        if (response)
                                        {
                                            document.getElementById("txt_employeeid").value = response;
                                        }
                                    }
                                });

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
        <script type="text/javascript">
            $('.selectpicker').on('changed.bs.select', function () {
                document.getElementById('txt_comp').value = $(this).val();

            });
        </script>
        <script type="text/javascript">
            function excel_stopwork()
            {
                var comp = document.getElementById('txt_comp').value;
                var datestart = document.getElementById('txt_datestart').value;
                var dateend = document.getElementById('txt_dateend').value;
                window.location.href = 'excel_stopwork1.php?comp=' + comp + '&datestart=' + datestart + '&dateend=' + dateend;
            }
            function select_stopwork()
            {

                var comp = document.getElementById('txt_comp').value;
                var datestart = document.getElementById('txt_datestart').value;
                var dateend = document.getElementById('txt_dateend').value;

                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "select_allstopwork", comp: comp, datestart: datestart, dateend: dateend
                    },
                    success: function (response) {
                        if (response)
                        {
                            document.getElementById("datasr").innerHTML = response;
                            document.getElementById("datade").innerHTML = "";
                        }
                        $(document).ready(function () {
                            $('#dataTables-example').DataTable({
                                responsive: true,
                                "order": [[12, "desc"]]
                            });
                        });


                    }
                });
                //}

            }
            function select_gstopwork()
            {


                var datestart = document.getElementById('txt_gdatestart').value;
                var dateend = document.getElementById('txt_gdateend').value;
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "select_gstopwork", datestart: datestart, dateend: dateend
                    },
                    success: function (response) {
                        if (response)
                        {
                            document.getElementById("gdatasr").innerHTML = response;
                            document.getElementById("gdatade").innerHTML = "";

                        }


                    }
                });
                //}

            }
        </script>
        <script type="text/javascript">

            function gdatetodate()
            {
                document.getElementById('txt_gdateend').value = document.getElementById('txt_gdatestart').value;
            }
            function datetodate()
            {
                document.getElementById('txt_dateend').value = document.getElementById('txt_datestart').value;

            }
            function pdf_stopwork(type)
            {
                //var comp = document.getElementById('cb_comp').value;
                var comp = document.getElementById('txt_comp').value;
                //var employeename = document.getElementById('txt_employeename').value;
                var employeename = '<?= $result_seEmp["NAME"] ?>';
                var datestart = document.getElementById('txt_datestart').value;
                var dateend = document.getElementById('txt_dateend').value;
                if (type == 1)
                {
                    window.open('pdf_stopwork1.php?comp=' + comp + '&datestart=' + datestart + '&dateend=' + dateend, '_blank');
                } else
                {
                    window.open('pdf_stopwork2.php?comp=' + comp + '&employeename=' + employeename + '&datestart=' + datestart + '&dateend=' + dateend, '_blank');
                }

            }
            function pdf_chartstopwork()
            {
                var comp = document.getElementById('txt_comp').value;
                var employeename = '<?= $result_seEmp["NAME"] ?>';
                var datestart = document.getElementById('txt_datestart').value;
                var dateend = document.getElementById('txt_dateend').value;
                window.open('pdf_chartstopwork.php?comp=' + comp + '&employeename=' + employeename + '&datestart=' + datestart + '&dateend=' + dateend, '_blank');
            }

        </script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').DataTable({
                    responsive: true
                });
            });
        </script>

    </body>

</html>
<?php
sqlsrv_close($conn);
?>