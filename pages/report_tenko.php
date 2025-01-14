
<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
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
                            รายงานเท็งโก๊ะ
                        </h2>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div id="chart_stopwork" class="modal fade" role="dialog">
                    <div class="modal-dialog" style="width: 80%;">
                        <div class="modal-content">



                            <div class="panel-heading">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <i class="fa fa-bar-chart-o fa-fw"></i> กราฟสถิติการทำเท็งโก๊ะ


                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-2">

                                        <div class="form-group">
                                            <label>ค้นหาตามช่วงวันที่</label>
                                            <input class="form-control dateen" readonly="" onchange="gdatetodate();" style="background-color: #f080802e"  id="txt_gdatestart" name="txt_gdatestart" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">

                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <label>&nbsp;</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control dateen"  readonly=""  style="background-color: #f080802e" id="txt_gdateend" name="txt_gdateend" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE']; ?>">

                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <label>&nbsp;</label>
                                        <div class="form-group">
                                            <button type="button" class="btn btn-default" onclick="select_gtenko();">ค้นหา <li class="fa fa-search"></li></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="rows">
                                    <div id="gdatade">

                                        <div class="col-lg-6">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="3" style="text-align: center">สถิติเท็งโก๊ะ (ครั้ง)</th>
                                                        </tr>
                                                        <tr>

                                                            <th >ลำดับ</th>
                                                            <th >ชื่อ-นามสกุล</th>
                                                            <th >จำนวนครั้ง</th>
                                                        </tr>

                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $i = 1;
                                                        $conditionCount = "";
                                                        if ($result_getDate['SYSDATE'] != "") {

                                                            $conditionCount = " AND DATEINPUT BETWEEN convert(date,'" . $result_getDate['SYSDATE'] . "', 103) AND convert(date,'" . $result_getDate['SYSDATE'] . "', 103)";
                                                        } else {
                                                            $conditionCount = " AND DATEINPUT BETWEEN convert(date,GETDATE(), 103) AND convert(date,GETDATE(), 103)";
                                                        }
                                                        $sql_seCountstop = "{call megTenko_v2(?,?)}";
                                                        $params_seCountstop = array(
                                                            array('select_countstop', SQLSRV_PARAM_IN),
                                                            array($conditionCount, SQLSRV_PARAM_IN)
                                                        );


                                                        $query_seCountstop = sqlsrv_query($conn, $sql_seCountstop, $params_seCountstop);
                                                        while ($result_seCountstop = sqlsrv_fetch_array($query_seCountstop, SQLSRV_FETCH_ASSOC)) {

                                                            $conditionEHR2 = " AND a.PersonCode = '" . $result_seCountstop['EMPLOYEEID'] . "'";
                                                            $sql_seEHR2 = "{call megEmployeeEHR_v2(?,?)}";
                                                            $params_seEHR2 = array(
                                                                array('select_employee', SQLSRV_PARAM_IN),
                                                                array($conditionEHR2, SQLSRV_PARAM_IN)
                                                            );
                                                            $query_seEHR2 = sqlsrv_query($conn, $sql_seEHR2, $params_seEHR2);
                                                            $result_seEHR2 = sqlsrv_fetch_array($query_seEHR2, SQLSRV_FETCH_ASSOC);
                                                            ?>
                                                            <tr>
                                                                <td><?= $i ?></td>
                                                                <td><?= $result_seCountstop['EMPLOYEENAME'] ?></td>
                                                                <td><?= $result_seCountstop['y'] ?></td>
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
                                    <div id="gdatasr"></div>
                                    <div class="col-lg-6">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <i class="fa fa-bar-chart-o fa-fw"></i> กราฟสถิติเท็งโก๊ะมากสุด (ครั้ง)
                                            </div>
                                            <div class="panel-body">

                                                <div id="chart_count"></div>

                                            </div>
                                            <!-- /.panel-body -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <label>บริษัท</label><br>

                        <select class="selectpicker" multiple="" data-actions-box="true" id="cb_comp" name="cb_comp">
                            <!--<option value = "">บริษัททั้งหมด</option>-->    

                            <?php
                            $sql_seComp = "{call megCompany_v2(?,?)}";
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
                        <input class="form-control" type="hidden"  id="txt_comp" name="txt_comp" maxlength="500" value="" >

                    </div>
                    <div class="col-lg-2">
                        <?php
                        $sql_getDate = "{call megStopwork_v2(?)}";
                        $params_getDate = array(
                            array('select_getdate', SQLSRV_PARAM_IN)
                        );
                        $query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
                        $result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);
                        ?>
                        <div class="form-group">
                            <label>ค้นหาตามช่วงวันที่</label>
                            <input class="form-control dateen" readonly="" onchange="datetodate();" style="background-color: #f080802e"  id="txt_datestart" name="txt_datestart" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">

                        </div>

                    </div>
                    <div class="col-lg-2">
                        <label>&nbsp;</label>
                        <div class="form-group">
                            <input type="text" class="form-control dateen"  readonly="" style="background-color: #f080802e" id="txt_dateend" name="txt_dateend" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE']; ?>">

                        </div>
                    </div>
                    <div class="col-lg-2">
                        <label>&nbsp;</label>
                        <div class="form-group">

                            <button type="button" class="btn btn-default" onclick="select_tenko();">ค้นหา <li class="fa fa-search"></li></button>
                        </div>

                    </div>

                </div>
                <div class="row">

                    <!--<div class="col-lg-6" >
                        <label>&nbsp;</label><br>
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#chart_stopwork">สถิติเท็งโก๊ะ <li class="fa fa-bar-chart-o fa-fw"></li></button>
                    </div>-->
                    <div class="col-lg-12" style="text-align: right">
                        <label>&nbsp;</label><br>
                        <a href="#" onclick="pdf_tenko();" class="btn btn-default">พิมพ์ <li class="fa fa-print"></li></a>&nbsp;&nbsp;<button type="button" onclick="excel_tenko()" class="btn btn-default">Excel <li class="fa fa-file-excel-o"></li></button>
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
                                รายงานเท็งโก๊ะ 
                            </div>
                            <!-- /.panel-heading -->

                            <div class="panel-body">


                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                    <div id="datade">
                                        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>ชื่อผู้ขับขี่</th>
                                                    <th>ปัญหา</th>
                                                    <th>เท็งโก๊ะ</th>
                                                    <th>การแก้ไข</th>
                                                    <th>ผู้รับผิดชอบ</th>
                                                    <th>วันที่สิ้นสุด</th>
                                                    <th>สถานะ</th>


                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $condition1 = " AND a.DATEINPUT = convert(DATE, GETDATE()) ";
                                                $i = 1;
                                                $sql_seTenko = "{call megTenko_v2(?,?)}";
                                                $params_seTenko = array(
                                                    array('select_tenko', SQLSRV_PARAM_IN),
                                                    array($condition1, SQLSRV_PARAM_IN)
                                                );


                                                $query_seTenko = sqlsrv_query($conn, $sql_seTenko, $params_seTenko);
                                                while ($result_seTenko = sqlsrv_fetch_array($query_seTenko, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <tr class="odd gradeX">
                                                        <td><?= $i ?></td>
                                                        <td><?= $result_seTenko['EMPLOYEENAME'] ?></td>
                                                        <td><?= $result_seTenko['ISSUE'] ?></td>
                                                        <td><?= $result_seTenko['TENKO'] ?></td>
                                                        <td><?= $result_seTenko['REFORMATION'] ?></td>
                                                        <td><?= $result_seTenko['RESPONSIBLEPERSON'] ?></td>
                                                        <td><?= $result_seTenko['FINISHDATE'] ?></td>
                                                        <td><?= $result_seTenko['STATUS'] ?></td>

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

        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="../vendor/metisMenu/metisMenu.min.js"></script>
        <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
        <script src="../dist/js/sb-admin-2.js"></script>
        <script src="../js/jquery.datetimepicker.full.js"></script>

        <script src="../js/highcharts.js"></script>
        <script src="../js/data.js"></script>
        <script src="../js/exporting.js"></script>
        <script>
                            $(function () {
                                $.getJSON("chart_counttenko.php", function (data) {
                                    seriesData = data;
                                    $('#chart_count').highcharts({
                                        chart: {
                                            plotBackgroundColor: null,
                                            plotBorderWidth: null,
                                            plotShadow: false,
                                            type: 'pie'
                                        },
                                        title: {
                                            text: 'สรุปสถิติเท็งโก๊ะมากสุด (ครั้ง)'
                                        },
                                        tooltip: {
                                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                                        },
                                        plotOptions: {
                                            pie: {
                                                allowPointSelect: true,
                                                cursor: 'pointer',
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '<b>{point.name}</b>: {point.y} ครั้ง',
                                                    style: {
                                                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                                    }
                                                }
                                            }
                                        },
                                        series: [{
                                                name: 'จำนวน',
                                                colorByPoint: true,
                                                data: seriesData
                                            }]
                                    });
                                });
                            });
        </script>



        <script src="../dist/js/jszip.min.js"></script>
        <script src="../dist/js/dataTables.buttons.min.js"></script>
        <script src="../dist/js/buttons.html5.min.js"></script>
        <script src="../dist/js/buttons.print.min.js"></script>
        <script src="../dist/js/bootstrap-select.js"></script>

        <script src="../dist/js/jquery.autocomplete.js"></script>
        <script type="text/javascript">
                            var txt_employeename = [
<?php
$employee = "";
$sql_seEmp = "{call megStopwork_v2(?,?)}";
$params_seEmp = array(
    array('select_employee', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);
$query_seEmp = sqlsrv_query($conn, $sql_seEmp, $params_seEmp);
while ($result_seEmp = sqlsrv_fetch_array($query_seEmp, SQLSRV_FETCH_ASSOC)) {
    $employee .= "'" . $result_seEmp['NAME'] . "',";
}
echo rtrim($employee, ",");
?>
                            ];
                            $(function () {
                                $("#txt_employeename").autocomplete({
                                    source: [txt_employeename]
                                });
                            });


        </script>

       <!-- <script>
            function load_chart() {
                $("#chart_stopwork").modal();
            }
        </script>-->
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

            function select_tenko()
            {

                var comp = document.getElementById('txt_comp').value;
                var datestart = document.getElementById('txt_datestart').value;
                var dateend = document.getElementById('txt_dateend').value;
                /*if (comp == "")
                 {
                 alert('กรุณาระบุชื่อบริษัทในการค้นหาด้วย !!!');
                 } else
                 {*/
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "select_alltenko", comp: comp, datestart: datestart, dateend: dateend
                    },
                    success: function (response) {
                        if (response)
                        {
                            document.getElementById("datasr").innerHTML = response;
                            document.getElementById("datade").innerHTML = "";
                        }
                        $(document).ready(function () {
                            $('#dataTables-example').DataTable({
                                responsive: true
                            });
                        });


                    }
                });
                //}

            }
            function select_gtenko()
            {


                var datestart = document.getElementById('txt_gdatestart').value;
                var dateend = document.getElementById('txt_gdateend').value;
                /*if (comp == "")
                 {
                 alert('กรุณาระบุชื่อบริษัทในการค้นหาด้วย !!!');
                 } else
                 {*/

                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "select_gtenko", datestart: datestart, dateend: dateend
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

            function datetodate()
            {
                document.getElementById('txt_dateend').value = document.getElementById('txt_datestart').value;

            }
            function gdatetodate()
            {
                document.getElementById('txt_gdateend').value = document.getElementById('txt_gdatestart').value;

            }

            function excel_tenko()
            {
                var comp = document.getElementById('txt_comp').value;
                var datestart = document.getElementById('txt_datestart').value;
                var dateend = document.getElementById('txt_dateend').value;
                window.location.href = 'excel_tenko.php?comp=' + comp + '&datestart=' + datestart + '&dateend=' + dateend;
            }
            function pdf_tenko()
            {
                var comp = document.getElementById('txt_comp').value;
                var datestart = document.getElementById('txt_datestart').value;
                var dateend = document.getElementById('txt_dateend').value;
                window.open('pdf_tenko.php?comp=' + comp + '&datestart=' + datestart + '&dateend=' + dateend, '_blank');

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