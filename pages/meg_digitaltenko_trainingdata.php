
<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

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
        <!--<link href="../dist/css/sb-admin-2.css" rel="stylesheet">-->
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">
        <link href="../js/bootstrap-datepicker.css" rel="stylesheet">

    </head>
    <style>
    h1 {
        text-align: center;
        text-transform: uppercase;
        color: #F94F05;
        text-decoration: overline;
        text-decoration: underline;
        text-shadow: 2px 2px #F9DA05;
        font-size:40px;
        }
    </style>
    <body>
    
    
        <div id="wrapper">
            <!-- <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

                <div class="navbar-header" >
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php"><font style="color: #000;font-size: 14px"><img src="../images/logo.ico" height="30"> <strong>Transport Management System</strong></font></a>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">

                            <li><a href="meg_logout.php"><i class="fa fa-sign-out fa-fw"></i> ออกจากระบบ</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav> -->

            <div id="page-wrapper" >
                <div class="row">
                    <div class="col-md-12" style="background-color: #e7e7e7">
                        <h1>TRAINING INFORMATION</h1>
                    </div>
                </div>
                <div class="row" >
                    <div class="col-lg-12">
                        <div class="well">
                        <div class="row">

                            <div class="col-lg-2">
                                <label>เลือกพนักงาน:</label>
                                <div class="dropdown bootstrap-select show-tick form-control">

                                    <select   id="txt_drivername" name="txt_drivername" class="selectpicker form-control" data-container="body" data-live-search="true" title="เลือก พนักงาน..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98" >
                                        <?php
                                        // $condiLocation1 = " AND COMPANYCODE = 'RKR' AND CUSTOMERCODE = 'TTASTSTC'";
                                        $sql_seName = "{call megEmployeeEHR_v2(?,?)}";
                                        $params_seName = array(
                                            array('select_employeeehr2', SQLSRV_PARAM_IN),
                                            array('', SQLSRV_PARAM_IN)
                                        );
                                        $query_seName = sqlsrv_query($conn, $sql_seName, $params_seName);
                                        while ($result_seName = sqlsrv_fetch_array($query_seName, SQLSRV_FETCH_ASSOC)) {
                                            ?>
                                            <option value="<?= $result_seName['PersonCode'] ?>"><?= $result_seName['nameT'] ?> (<?=$result_seName['PersonCode']?>)</option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <input class="form-control" style="display: none"   id="txt_copydiagramzone" name="txt_copydiagramzone" maxlength="500" value="" >


                                    <!-- <div class="dropdown-menu open" role="combobox">
                                        <div class="bs-searchbox">
                                            <input type="text" class="form-control" autocomplete="off" role="textbox" aria-label="Search"></div>
                                        <div class="bs-actionsbox">
                                            <div class="btn-group btn-group-sm btn-block">
                                                <button type="button" class="actions-btn bs-select-all btn btn-default">Select All</button>
                                                <button type="button" class="actions-btn bs-deselect-all btn btn-default">Deselect All</button>
                                            </div>
                                        </div>
                                        <div class="inner open" role="listbox" aria-expanded="false" tabindex="-1">
                                            <ul class="dropdown-menu inner "></ul>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                            
                            <div class="col-lg-2">
                                <label>&nbsp;</label>
                                <div class="form-group">
                                    <button type="button" class="btn btn-default" onclick="select_trainingdata();">ค้นหา <li class="fa fa-search"></li></button>
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <label>&nbsp;</label><br>
                                <a href="#" onclick="pdf_reporttrainingdata();" class="btn btn-default">รายงานข้อมูลฝึกอบรม<li class="fa fa-print"></li></a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <div class="tab-content">
                    <div class="row">
                        <div class="col-md-12">&nbsp;</div>
                    </div>


                    <!-- /.row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #e7e7e7">

                                    <div class="row">
                                        <div class="col-sm-6"><a href='index2.php'>หน้าแรก</a> / ข้อมูลฝึกอบรม</div>
                                        <!-- <div class="col-sm-6 text-right"><a target="_bank" href='meg_vehiclrinfoamata.php?vehicleinfoid=&meg=add'>เพิ่มข้อมูลรถ</a></div> --> 
                                    </div>
                                    



                                </div>
                                <!-- /.panel-heading -->

                                <div class="row">
                                        <div class="col-lg-12">
                                            <div class="panel panel-default">
                                                
                                                <!-- /.panel-heading -->

                                                <div class="panel-body">

                                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                        <div id="datadef">
                                                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
                                                                <thead>
                                                                    <tr>
                                                                    <th>ลำดับ</th>
                                                                    <!-- <th>รหัสพนักงาน</th>
                                                                    <th>ชื่อ-สกุล</th>
                                                                    <th>ตำแหน่ง</th> -->
                                                                    <th>วันที่อบรม</th>
                                                                    <th>หัวข้อการอบรม</th>
                                                                    <th>รายละเอียดเพิ่มเติม</th>
                                                                    <th>ชั่วโมงการอบรม</th>
                                                                    <th>ผู้ฝึกอบรม</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    




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

                                
                                <!-- /.panel -->
                            </div>
                        </div>
                    </div>



                </div>
            </div>

            <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
            <script src="../vendor/metisMenu/metisMenu.min.js"></script>
            <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
            <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
            <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
            <script src="../dist/js/sb-admin-2.js"></script>
            <script src="../js/jquery.datetimepicker.full.js"></script>
            <script src="../dist/js/jquery.autocomplete.js"></script>
            <script src="../dist/js/bootstrap-select.js"></script>
            <script src="../js/bootstrap-datepicker.min.js"></script>
            <script src="../js/bootstrap-datepicker.th.min.js"></script>


    </body>
    <script>

                                        function select_trainingdata()
                                        {


                                            var employeecode = document.getElementById('txt_drivername').value;
                                            // var dateend = document.getElementById('txt_dateend').value;
                                            // var companycode = document.getElementById('select_com').value;
                                            // var customercode = document.getElementById('select_cus').value;
                                            // alert(employeecode);

                                            $.ajax({
                                                type: 'post',
                                                url: 'meg_data2.php',
                                                data: {
                                                    txt_flg: "select_trainingdata", employeecode: employeecode,
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
                                       

                                        $(document).ready(function () {
                                            $('#dataTables-example').DataTable({
                                                order: [[0, "asc"]],
                                                scrollX: true,
                                                scrollY: '500px',
                                            });
                                        });

                                  
                                        function pdf_reporttrainingdata()
                                        {
                                            var employeecode = document.getElementById('txt_drivername').value;
                                            
                                            // alert(employeecode);
                                            window.open('pdf_digitaltenko_basicinfo.php?employeecode='+ employeecode, '_blank');
                                            
                                            
                                        }
    </script>
</html>
<?php
sqlsrv_close($conn);
?>
