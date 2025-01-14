
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

                        <h2 class="page-header"><i class="fa fa-user"></i>
                            สถานะพนักงานขับรถ

                        </h2>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                สถานะพนักงานขับรถ
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#satusarea" data-toggle="tab">พนักงานขับรถ (อยู่ในพื้นที่)</a>
                                    </li>
                                    <li>
                                        <a href="#satusnotarea" data-toggle="tab">พนักงานขับรถ (ไม่อยู่ในพื้นที่)</a>
                                    </li>


                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="satusarea">
                                        <div class="row">&nbsp;</div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <div class="row" >
                                                            <div class="col-lg-6">
                                                                <i class="fa fa-user"></i> รายการพนักงานขับรถทั้งหมด
                                                            </div>
                                                            <div class="col-lg-6 text-right">
                                                                <a href="#" onclick="refresh1()"><i class="fa fa-refresh"></i></a>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <!-- /.panel-heading -->
                                                    <div class="panel-body">
                                                        <div id="satusareadef">
                                                            <table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example" aria-describedby="dataTables-example_info" style="width: 100%">
                                                                <thead>
                                                                    <tr role="row">
                                                                        <th style="text-align: center">ลำดับ</th>
                                                                        <th >รหัสพนักงานขับรถ</th>
                                                                        <th >ชื่อพนักงานขับรถ</th>
                                                                        <th style="text-align: center">สถานะ</th> 
                                                                    </tr>
                                                                </thead>

                                                                <tbody>
                                                                    <?php
                                                                    $i = 1;



                                                                    $sql_seEmp = "SELECT DISTINCT EMPLOYEECODE,EMPLOYEENAME FROM (
                                                                        SELECT EMPLOYEECODE1 AS 'EMPLOYEECODE',EMPLOYEENAME1 AS 'EMPLOYEENAME',DATEVLIN,COMPANYCODE FROM [dbo].[VEHICLETRANSPORTPLAN] 
                                                                        UNION
                                                                        SELECT EMPLOYEECODE2 AS 'EMPLOYEECODE',EMPLOYEENAME2 AS 'EMPLOYEENAME',DATEVLIN,COMPANYCODE FROM [dbo].[VEHICLETRANSPORTPLAN] 
                                                                        ) AS A WHERE EMPLOYEECODE IS NOT NULL AND EMPLOYEECODE != ''
                                                                        AND CONVERT(DATE,DATEVLIN,103) BETWEEN CONVERT(DATE,DATEADD(DAY,-30,GETDATE())) AND CONVERT(DATE,GETDATE(),103)
                                                                        AND EMPLOYEECODE NOT IN 
                                                                        (SELECT DISTINCT EMPLOYEECODE FROM (
                                                                        SELECT EMPLOYEECODE1 AS 'EMPLOYEECODE' FROM [VEHICLETRANSPORTPLAN] WHERE CONVERT(DATE,DATEPRESENT,103) = CONVERT(DATE,GETDATE(),103)
                                                                        UNION
                                                                        SELECT EMPLOYEECODE2 AS 'EMPLOYEECODE' FROM [VEHICLETRANSPORTPLAN] WHERE CONVERT(DATE,DATEPRESENT,103) = CONVERT(DATE,GETDATE(),103)
                                                                        ) AS A WHERE EMPLOYEECODE IS NOT NULL AND EMPLOYEECODE != '') AND COMPANYCODE IN ('RKS','RKR','RKL')";
                                                                    $params_seEmp = array();
                                                                    $query_seEmp = sqlsrv_query($conn, $sql_seEmp, $params_seEmp);
                                                                    while ($result_seEmp = sqlsrv_fetch_array($query_seEmp, SQLSRV_FETCH_ASSOC)) {
                                                                        ?>
                                                                        <tr role="row">
                                                                            <td style="text-align: center"><?= $i ?></td>
                                                                            <td ><?= $result_seEmp['EMPLOYEECODE'] ?></td>
                                                                            <td ><?= $result_seEmp['EMPLOYEENAME'] ?></td>
                                                                            <td style="text-align: center">อยุในพื้นที่</td>
                                                                        </tr>
                                                                        <?php
                                                                        $i++;
                                                                    }
                                                                    ?>
                                                                </tbody>

                                                            </table>
                                                        </div>
                                                        <div id="satusareasr"></div>

                                                    </div>
                                                </div>
                                                <!-- /.panel-body -->

                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="satusnotarea">
                                        <div class="row">&nbsp;</div>
                                        <div class="row" >
                                            <div class="col-lg-3">
                                                <select id="" name="" class="form-control"  title="เลือกสถานะ..." onchange="select_driving(this.value)">
                                                    <option value="หยุด">หยุด</option>
                                                    <option value="วิ่งงาน">วิ่งงาน</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">&nbsp;</div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <div class="row" >
                                                            <div class="col-lg-6">
                                                                <i class="fa fa-user"></i> รายการพนักงานขับรถทั้งหมด
                                                            </div>
                                                           
                                                        </div>

                                                    </div>
                                                    <!-- /.panel-heading -->

                                                    <div class="panel-body">

                                                        <div class="row" >
                                                            <div class="col-lg-12">
                                                                <div id="satusareadef2">
                                                                    <table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example2" aria-describedby="dataTables-example_info" style="width: 100%">
                                                                        <thead>
                                                                            <tr role="row">
                                                                                <th style="text-align: center">ลำดับ</th>
                                                                                <th >รหัสพนักงานขับรถ</th>
                                                                                <th >ชื่อพนักงานขับรถ</th>
                                                                                <th style="text-align: center">สถานะ</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $i = 1;



                                                                            $sql_seEmp2 = "SELECT a.PersonCardID,b.FnameT,b.LnameT  FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut] a
                                                                        INNER JOIN [203.150.225.30].[TigerE-HR].dbo.PNT_Person b ON a.PersonCardID=b.PersonCardID
                                                                        WHERE  a.InOutMode != 'I' 
                                                                        AND CONVERT(DATE,a.Timeinout,103) = CONVERT(DATE,GETDATE(),103) 
                                                                        AND a.PersonCardID NOT IN
                                                                        (SELECT DISTINCT EMPLOYEECODE FROM (
                                                                        SELECT EMPLOYEECODE1 AS 'EMPLOYEECODE' FROM [VEHICLETRANSPORTPLAN] WHERE CONVERT(DATE,GETDATE(),103) BETWEEN CONVERT(DATE,DATERK,103)  AND CONVERT(DATE,DATERETURN,103) 
                                                                        UNION
                                                                        SELECT EMPLOYEECODE2 AS 'EMPLOYEECODE' FROM [VEHICLETRANSPORTPLAN] WHERE CONVERT(DATE,GETDATE(),103) BETWEEN CONVERT(DATE,DATERK,103)  AND CONVERT(DATE,DATERETURN,103) 
                                                                        ) AS A WHERE EMPLOYEECODE IS NOT NULL AND EMPLOYEECODE != '')
                                                                        ORDER BY a.Timeinout ASC";
                                                                            $params_seEmp2 = array();
                                                                            $query_seEmp2 = sqlsrv_query($conn, $sql_seEmp2, $params_seEmp2);
                                                                            while ($result_seEmp2 = sqlsrv_fetch_array($query_seEmp2, SQLSRV_FETCH_ASSOC)) {
                                                                                ?>
                                                                                <tr role="row">
                                                                                    <td style="text-align: center"><?= $i ?></td>
                                                                                    <td ><?= $result_seEmp2['PersonCardID'] ?></td>
                                                                                    <td ><?= $result_seEmp2['FnameT'] ?> <?= $result_seEmp2['LnameT'] ?></td>
                                                                                    <td style="text-align: center">หยุด</td>
                                                                                </tr>
                                                                                <?php
                                                                                $i++;
                                                                            }
                                                                            ?>
                                                                        </tbody>

                                                                    </table>
                                                                </div>
                                                                <div id="satusareasr2"></div>
                                                            </div>
                                                        </div>



                                                    </div>

                                                </div>
                                            </div>
                                            <!-- /.panel-body -->

                                        </div>

                                    </div>
                                </div>
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
                                                                    function refresh1()
                                                                    {
                                                                        $.ajax({
                                                                            type: 'post',
                                                                            url: 'meg_data.php',
                                                                            data: {
                                                                                txt_flg: "select_manrefresh1"
                                                                            },
                                                                            success: function (response) {
                                                                                document.getElementById("satusareasr").innerHTML = response;
                                                                                document.getElementById("satusareadef").innerHTML = '';
                                                                                $(document).ready(function () {
                                                                                    $('#dataTables-example').DataTable({
                                                                                        responsive: true,
                                                                                    });
                                                                                });

                                                                            }
                                                                        });
                                                                    }
                                                                    
                                                                    function select_driving(data)
                                                                    {
                                                                        $.ajax({
                                                                            type: 'post',
                                                                            url: 'meg_data.php',
                                                                            data: {
                                                                                txt_flg: "select_driving",data:data
                                                                            },
                                                                            success: function (response) {
                                                                                 document.getElementById("satusareasr2").innerHTML = response;
                                                                                document.getElementById("satusareadef2").innerHTML = '';
                                                                                $(document).ready(function () {
                                                                                    $('#dataTables-example2').DataTable({
                                                                                        responsive: true,
                                                                                    });
                                                                                });

                                                                            }
                                                                        });
                                                                    }


                                                                    $(document).ready(function () {
                                                                        $('#dataTables-example').DataTable({
                                                                            responsive: true,
                                                                        });
                                                                        $('#dataTables-example2').DataTable({
                                                                            responsive: true,
                                                                        });

                                                                    });
    </script>
</body>

</html>
<?php
sqlsrv_close($conn);
?>
