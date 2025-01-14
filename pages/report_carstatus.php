
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
        <div id="wrapper">


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
                            สถานะรถ

                        </h2>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                สถานะรถ
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#satusall" data-toggle="tab">สถานะรถ(ทั้งหมด)</a>
                                    </li>
                                    <!--<li>
                                        <a href="#satus" data-toggle="tab">สถานะรถ(แยกสถานะ)</a>
                                    </li>-->

                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="satusall">
                                        <div class="row">&nbsp;</div>
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <div class="row" >
                                                            <div class="col-lg-6">
                                                                <i class="fa fa-bell fa-truck"></i> รายการรถทั้งหมด
                                                            </div>
                                                            <div class="col-lg-6 text-right">
                                                                <a href="#" onclick="refresh()"><i class="fa fa-refresh"></i></a>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <!-- /.panel-heading -->
                                                    <div class="panel-body">
                                                        <div id="div_refreshdef">
                                                            <table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example" aria-describedby="dataTables-example_info">
                                                                <thead>
                                                                    <tr role="row">
                                                                        <th style="text-align: center">ลำดับ</th>
                                                                        <th >ชื่อรถ</th>
                                                                        <th >ทะเบียน</th>
                                                                        <th style="text-align: center">สถานะ</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $i = 1;
                                                                    $condition1 = " AND (a.THAINAME NOT LIKE '%R-%' OR a.THAINAME NOT LIKE '%RA-%' OR a.THAINAME NOT LIKE '%RP-%'";
                                                                    $condition2 = " OR a.THAINAME NOT LIKE '%คลองเขื่อน%'  OR a.THAINAME NOT LIKE '%ด่านช้าง%'  OR a.THAINAME NOT LIKE '%สวนผึ้ง%' ";
                                                                    $condition3 = " OR a.ENGNAME NOT LIKE '%ดินแดง%' OR a.ENGNAME NOT LIKE '%อุทัยธานี%' OR a.ENGNAME NOT LIKE '%Kerry%'";
                                                                    $condition4 = " OR a.THAINAME NOT LIKE '%เขาชะเมา%' OR a.THAINAME NOT LIKE '%เฉลิมพระเกียรติ%' OR a.THAINAME NOT LIKE '%P35%' )";
                                                                    $sql_infolist = "{call megVehicleinfo_v2(?,?,?,?,?)}";
                                                                    $params_infolist = array(
                                                                        array('selectcond_vehicleinfo', SQLSRV_PARAM_IN),
                                                                        array($condition1, SQLSRV_PARAM_IN),
                                                                        array($condition2, SQLSRV_PARAM_IN),
                                                                        array($condition3, SQLSRV_PARAM_IN),
                                                                        array($condition4, SQLSRV_PARAM_IN)
                                                                    );

                                                                    $query_infolist = sqlsrv_query($conn, $sql_infolist, $params_infolist);
                                                                    while ($result_infolist = sqlsrv_fetch_array($query_infolist, SQLSRV_FETCH_ASSOC)) {
                                                                        $sql_chkStatus1 = "SELECT COUNT(*) AS 'CNT' FROM [dbo].[VEHICLETRANSPORTPLAN] 
                                                                    WHERE STATUSNUMBER != '0' AND STATUSNUMBER != 'X' AND STATUSNUMBER != '2'
                                                                    AND CONVERT(DATE,DATERK,103) BETWEEN CONVERT(DATE,DATEADD(DAY,-5,GETDATE()),103) AND CONVERT(DATE,DATEADD(DAY,5,GETDATE()),103)
                                                                    AND VEHICLEREGISNUMBER1 = '" . $result_infolist['VEHICLEREGISNUMBER'] . "'
                                                                    AND VEHICLEREGISNUMBER1 NOT IN (SELECT TOP 1 VEHICLENUMBER FROM [dbo].[EMPLOYEEREPAIR] WHERE REPAIRSTATUS != 'ซ่อมเสร็จ'
                                                                    AND VEHICLENUMBER = '" . $result_infolist['VEHICLEREGISNUMBER'] . "')";
                                                                        $params_chkStatus1 = array();

                                                                        $query_chkStatus1 = sqlsrv_query($conn, $sql_chkStatus1, $params_chkStatus1);
                                                                        $result_chkStatus1 = sqlsrv_fetch_array($query_chkStatus1, SQLSRV_FETCH_ASSOC);

                                                                        $sql_chkStatus2 = "SELECT TOP 1 COUNT(*) AS 'CNT' FROM [dbo].[EMPLOYEEREPAIR] WHERE REPAIRSTATUS != 'ซ่อมเสร็จ'
                                                                    AND VEHICLENUMBER = '" . $result_infolist['VEHICLEREGISNUMBER'] . "'";
                                                                        $params_chkStatus2 = array();
                                                                        $query_chkStatus2 = sqlsrv_query($conn, $sql_chkStatus2, $params_chkStatus2);
                                                                        $result_chkStatus2 = sqlsrv_fetch_array($query_chkStatus2, SQLSRV_FETCH_ASSOC);


                                                                        if ($result_chkStatus2['CNT'] > 0) {
                                                                            $statusColor = " <font style='color: red'>กำลังซ่อม</font>";
                                                                        } else if ($result_chkStatus1['CNT'] > 0) {
                                                                            $statusColor = " <font style='color: blue'>กำลังวิ่งงาน</font>";
                                                                        } else {
                                                                            $statusColor = " <font style='color: green'>จอด</font>";
                                                                        }
                                                                        ?>
                                                                        <tr>
                                                                            <td style="text-align: center" ><?= $i ?></td>
                                                                            <td ><?= $result_infolist['THAINAME'] ?></td>
                                                                            <td ><?= $result_infolist['VEHICLEREGISNUMBER'] ?></td>
                                                                            <td style="text-align: center"><?= $statusColor ?></td>
                                                                        </tr>
    <?php
    $i++;
}
?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div id="div_refreshsr"></div>

                                                    </div>
                                                </div>
                                                <!-- /.panel-body -->

                                            </div>
                                            <div class="col-lg-4">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <div class="row" >
                                                            <div class="col-lg-6">
                                                                <i class="fa fa-bell fa-truck"></i> รายการรถที่วิ่งงานล่าสุด (10 ลำดับ)
                                                            </div>
                                                            <div class="col-lg-6 text-right">
                                                                <a href="#" onclick="refreshrun()"><i class="fa fa-refresh"></i></a>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <!-- /.panel-heading -->
                                                    <div class="panel-body">
                                                        <div id="div_refreshrundef">
                                                            <div class="list-group">
<?php
$i2 = 1;
$sql_infolist2 = "SELECT TOP 10 CONVERT(NVARCHAR(5),CONVERT(TIME,DATERK)) AS 'TIMERK',DATERK,THAINAME,JOBSTART,JOBEND,JOBNO,
                                                            DATEDIFF(MINUTE, CONVERT(DATETIME,DATERK) , CONVERT(DATETIME,GETDATE())) AS 'MINUTE'  
                                                            FROM [dbo].[VEHICLETRANSPORTPLAN] WHERE 
                                                            STATUSNUMBER != '0' AND STATUSNUMBER != 'X' AND STATUSNUMBER != '2' AND 
                                                            COMPANYCODE IN ('RKS','RKR','RKL') AND
                                                            DATEDIFF(MINUTE, CONVERT(DATETIME,GETDATE()), CONVERT(DATETIME,DATERK)) < 0
                                                            ORDER BY MINUTE ASC";
$params_infolist2 = array();

$query_infolist2 = sqlsrv_query($conn, $sql_infolist2, $params_infolist2);
while ($result_infolist2 = sqlsrv_fetch_array($query_infolist2, SQLSRV_FETCH_ASSOC)) {
    ?>

                                                                    <a href = "#" class = "list-group-item">
                                                                    <?= $i2 ?>. <u><b><?= $result_infolist2['THAINAME'] ?></b></u> (<?= $result_infolist2['JOBSTART'] ?> => <?= $result_infolist2['JOBEND'] ?>)
                                                                        <span class = "pull-right text-muted small"><em><?= $result_infolist2['TIMERK'] ?> (<?= $result_infolist2['MINUTE'] ?> นาที) </em>
                                                                        </span>
                                                                    </a>
                                                                        <?php
                                                                        $i2++;
                                                                    }
                                                                    ?>
                                                            </div>
                                                        </div>
                                                        <div id="div_refreshrunsr"></div>

                                                    </div>
                                                    <!--/.panel-body-->
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!--<div class = "tab-pane fade" id = "satus">
                                        <h4>Profile Tab</h4>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                    </div>-->

                                </div>
                            </div>
                            <!--/.panel-body-->
                        </div>
                        <!--/.panel-->
                    </div>

                </div>
            </div>
        </div>
        <script src = "../vendor/jquery/jquery.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="../vendor/metisMenu/metisMenu.min.js"></script>
        <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
        <script src="../dist/js/sb-admin-2.js"></script>
        <script src="../js/jquery.datetimepicker.full.js"></script>
        <script>
                                                                    function refresh()
                                                                    {
                                                                        $.ajax({
                                                                            type: 'post',
                                                                            url: 'meg_data.php',
                                                                            data: {
                                                                                txt_flg: "select_refresh"
                                                                            },
                                                                            success: function (response) {
                                                                                document.getElementById("div_refreshsr").innerHTML = response;
                                                                                document.getElementById("div_refreshdef").innerHTML = '';
                                                                                $(document).ready(function () {
                                                                                    $('#dataTables-example').DataTable({
                                                                                        responsive: true,
                                                                                    });
                                                                                });

                                                                            }
                                                                        });
                                                                    }
                                                                    function refreshrun()
                                                                    {
                                                                        $.ajax({
                                                                            type: 'post',
                                                                            url: 'meg_data.php',
                                                                            data: {
                                                                                txt_flg: "select_refreshrun"
                                                                            },
                                                                            success: function (response) {
                                                                                document.getElementById("div_refreshrunsr").innerHTML = response;
                                                                                document.getElementById("div_refreshrundef").innerHTML = '';


                                                                            }
                                                                        });
                                                                    }

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
