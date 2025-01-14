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
                            รายงานแผนงานรถเปิด


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

                                        รายงานแผนงานรถเปิด

                                    </div>
                                    <div class="col-lg-6 text-right"></div>
                                </div>
                            </div>

                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <!-- Tab panes -->
                                <div class="tab-content">

                                    <div class="row">&nbsp;</div>
                                    <div class="row" >
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
                                                    <div class="col-lg-2">
                                                        <label>&nbsp;</label>
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-default" onclick="select_reporttransportplanstc();">ค้นหา <li class="fa fa-search"></li></button>
                                                        </div>

                                                    </div>




                                                    <div class="col-lg-6" style="text-align: right">
                                                        <label>&nbsp;</label><br>
                                                        <a href="#" onclick="excel_reporttransportpalnstc();" class="btn btn-default">พิมพ์ <li class="fa fa-print"></li></a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading" style="background-color: #e7e7e7">
                                                    รายงานแผนการขนส่ง AMT
                                                </div>
                                                <!-- /.panel-heading -->

                                                <div class="panel-body">

                                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                        <div id="datadef">
                                                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                <thead>
                                                                    <tr>
                                                                        <th>NO</th>
                                                                        <th>DRIVER</th>
                                                                        <th>TRUCK</th>
                                                                        <th>VEHICLETYPE</th>
                                                                        <th>TRIP1</th>
                                                                        <th>TRIP2</th>
                                                                        <th>TRIP3</th>
                                                                        <th>TRIP4</th>
                                                                        <th>TRIP5</th>
                                                                        <th>TRIP6</th>
                                                                        <th>REMARK</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                  <?php
                                                                  $i = 1;
                                                                  $sql_seBilling = "SELECT  EMPLOYEENAME1,THAINAME,VEHICLETYPE,JOBSTART,JOBEND,
                                                                                    CONVERT(VARCHAR(8),DATEPRESENT,108) AS 'DATEPRESENT',CONVERT(VARCHAR(8),DATERK,108) AS 'DATERK',
                                                                                    CONVERT(VARCHAR(8),DATEVLIN,108) AS 'DATEVLIN',CONVERT(VARCHAR(8),DATEDEALERIN,108) AS 'DATEDEALERIN',
                                                                                    CONVERT(VARCHAR(8),DATERETURN,108) AS 'DATERETURN'
                                                                                    FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE ACTIVESTATUS = 1
                                                                                    AND COMPANYCODE IN ('RKR','RKL') AND CUSTOMERCODE IN('TTASTSTC','TTTCSTC','TTTC','TTASTCS')
                                                                                    AND CONVERT(DATE,DATEWORKING) BETWEEN CONVERT(DATE,GETDATE(),103) AND CONVERT(DATE,GETDATE(),103)
                                                                                    ORDER BY EMPLOYEENAME1 ASC";
                                                                  $params_seBilling = array();

                                                                  $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                                                                  while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                                                                    $condEmployeeehr1 = " AND (a.FnameT+' '+a.LnameT) = '" . $result_seBilling['EMPLOYEENAME1'] . "' ";
                                                                    $sql_seEmployeeehr = "{call megEmployeeEHR_v2(?,?)}";
                                                                    $params_seEmployeeehr = array(
                                                                        array('select_employeeehr2', SQLSRV_PARAM_IN),
                                                                        array($condEmployeeehr1, SQLSRV_PARAM_IN)
                                                                    );
                                                                    $query_seEmployeeehr = sqlsrv_query($conn, $sql_seEmployeeehr, $params_seEmployeeehr);
                                                                    $result_seEmployeeehr = sqlsrv_fetch_array($query_seEmployeeehr, SQLSRV_FETCH_ASSOC);
                                                                    // echo $jobend=$result_seBilling['JOBEND']; echo '<br>';
                                                                    $jobend  = $result_seBilling['JOBEND'];
                                                                    $jobendsplit = explode(",", $jobend);
                                                                    // echo $jobendsplit[0]; echo '<br>';
                                                                    // echo $jobendsplit[1]; echo '<br>';
                                                                    // echo $jobendsplit[2]; echo '<br>';
                                                                    // echo $jobendsplit[3]; echo '<br>';
                                                                  ?>

                                                                        <tr>

                                                                          <td style="text-align: center"><?= $i ?></td>
                                                                          <td><?=$result_seEmployeeehr['FnameT']?></td>
                                                                          <td><?=$result_seBilling['THAINAME']?></td>
                                                                          <td><?=$result_seBilling['VEHICLETYPE']?></td>
                                                                          <td><?=$jobendsplit[0];?></td>
                                                                          <td><?=$jobendsplit[1];?></td>
                                                                          <td><?=$jobendsplit[2];?></td>
                                                                          <td><?=$jobendsplit[3];?></td>
                                                                          <td><?=$jobendsplit[4];?></td>
                                                                          <td><?=$jobendsplit[5];?></td>
                                                                          <td><?=$result_seBilling['REMARK']?></td>


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
            <script src="../dist/js/bootstrap-select.js"></script>
            <script src="../dist/js/jquery.autocomplete.js"></script>
            <script>

                                                            function select_reporttransportplanstc()
                                                            {


                                                                var datestart = document.getElementById('txt_datestart').value;
                                                                var dateend = document.getElementById('txt_dateend').value;

                                                                // alert(datestart);
                                                                // alert(dateend);
                                                                $.ajax({
                                                                    type: 'post',
                                                                    url: 'meg_data.php',
                                                                    data: {
                                                                        txt_flg: "select_reporttransportplanstc", datestart: datestart, dateend: dateend
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
                                                                            });
                                                                        });



                                                                    }
                                                                });


                                                            }
                                                            function excel_reporttransportpalnstc()
                                                            {
                                                                var datestart = document.getElementById('txt_datestart').value;
                                                                var dateend = document.getElementById('txt_dateend').value;

                                                                // alert(dateend);
                                                                window.open('excel_stcplan.php?datestart=' + datestart + '&dateend=' + dateend, '_blank');

                                                            }
                                                            function gdatetodate()
                                                            {
                                                                document.getElementById('txt_gdateend').value = document.getElementById('txt_gdatestart').value;
                                                            }
                                                            function datetodate()
                                                            {
                                                                document.getElementById('txt_dateend').value = document.getElementById('txt_datestart').value;

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
                                                                });
                                                            });

            </script>


    </body>

</html>

<?php
sqlsrv_close($conn);
?>
