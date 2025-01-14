<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");

Update_Time_Data('update'); // อัพเดทฐานข้อมูล ทุกครั้งที่เปิดหน้านี้

$condEmp = "  AND a.PersonCode = '" . $_SESSION["EMPLOYEEID"] . "'";
$sql_seEmp = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmp = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($condEmp, SQLSRV_PARAM_IN)
);
$query_seEmp = sqlsrv_query($conn, $sql_seEmp, $params_seEmp);
$result_seEmp = sqlsrv_fetch_array($query_seEmp, SQLSRV_FETCH_ASSOC);
?>
<html lang="en">
    <head>
        <link rel="shortcut icon" href="../images/logo.ico" />
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
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
            .popover-content {
                padding: 10px 10px;
                width: 200px;
            }
            .nav>li>a {
                position: relative;
                display: block;
                padding: 14px 30px;
            </style>
        </head>
        <body>
            <div id="wrapper">
                <!-- Navigation -->
                <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <?php
                    if (!isset($_SESSION["USERNAME"]) || !isset($_SESSION["PASSWORD"])) {
                        header("location:meg_login.php?data=" . $_GET['data']);
                    }
                    ?>
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="index.html"><font style="color: #666"><img src="../images/logo.png" height="30"> <strong>กลุ่มร่วมกิจรุ่งเรือง</strong></font></a> 
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
                    </nav>



                    <div class="row">

                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" >

                                    <div class="row">&nbsp;</div>
                                    <div class="row">
                                        <div class="col-md-3" >
                                            <select class="form-control"  id="cb_srtype" name="cb_srtype" onchange="select_employee2();">

                                                <?php
                                                $sql_seComp = "{call megCompany_v2(?,?)}";
                                                $params_seComp = array(
                                                    array('select_company', SQLSRV_PARAM_IN),
                                                    array('', SQLSRV_PARAM_IN)
                                                );
                                                $query_seComp = sqlsrv_query($conn, $sql_seComp, $params_seComp);
                                                while ($result_seComp = sqlsrv_fetch_array($query_seComp, SQLSRV_FETCH_ASSOC)) {
                                                    ?>
                                                    <option value = "<?= $result_seComp['Company_Code'] ?>"><?= $result_seComp['Company_NameT'] ?></option> 
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group input-group">

                                                <input type="text"  name="txt_search"  id="txt_search" class="form-control" onchange="select_employee2();" >
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" id="btnSearch" type="button" onclick="select_employee2();"><i class="fa fa-search"></i>
                                                    </button>
                                                </span>
                                            </div>

                                        </div>
                                        <div class="col-lg-6" style="text-align: right">



                                            <input class="btn btn-default" type="button" style="background-color: red;border:solid 2px white" id="btn_srquotation" name="btn_srquotation" value=""> * แจ้งเตือนข้อมูล ไม่พบราคาขนส่ง  

                                        </div>

                                    </div>

                                </div>


                                <div class="panel-body">
                                    <div class="col-md-6">
                                        <a href="index.html">หน้าหลัก</a> / พนักงาน
                                    </div>
                                    <div class="row" id="loading">

                                    </div>
                                    <div class="row" id="list-data">
                                        <div class="col-md-12 text-right">&nbsp;</div>


                                    </div>


                                </div>

                                <!-- /.row (nested) -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

            </div>

            <!-- Modal -->
            <?php $nowdt = date("Y-m-d"); ?>
            <div id="modalData" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="row">
                                <div class="col-lg-6"><h3 id="pname_display"></h3></div>
                                <div class="col-lg-3 text-right">
                                    <label for="ds1">จาก วันที่</label><input type="text" class="form-control dateen" id='ds1' name='ds1' value="<?= $nowdt; ?>" onchange="reloadPage(pID.value, pName.value, ds1.value, ds2.value)">
                                </div>
                                <div class="col-lg-3 text-right">
                                    <label for="ds2">ถึง วันที่</label><input type="text" class="form-control dateen" id='ds2' name='ds2' value="<?= $nowdt; ?>" onchange="reloadPage(pID.value, pName.value, ds1.value, ds2.value)">
                                </div>
                            </div>
                        </div>
                        <div class="modal-body" id="ModalDisplay">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="CloseWindows()">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Modal-->

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
            <script src="../dist/js/jquery.autocomplete.js"></script>

        </body>
        <script type="text/javascript">

                                function save_tenkomasterofficer(vehicletransportplanid)
                                {

                                    $.ajax({
                                        type: 'post',
                                        url: 'meg_data.php',
                                        data: {
                                            txt_flg: "save_tenkomasterofficer", tenkomasterid: '', vehicletransportplanid: vehicletransportplanid, changeka: '',
                                            remark1: '', remark2: '', status: '1', officer: '<?= $result_seEmp["nameT"] ?>'

                                        },
                                        success: function () {

                                            window.open('meg_tenkodocument.php?employeecode1=' + vehicletransportplanid, '_blank');

                                        }
                                    });

                                }
                                function save_tenkomaster(vehicletransportplanid)
                                {

                                    $.ajax({
                                        type: 'post',
                                        url: 'meg_data.php',
                                        data: {
                                            txt_flg: "save_tenkomaster", tenkomasterid: '', vehicletransportplanid: vehicletransportplanid, changeka: '',
                                            remark1: '', remark2: '', status: '1', officer: '<?= $result_seEmp["nameT"] ?>'

                                        },
                                        success: function () {


                                            window.open('meg_tenkodocument.php?vehicletransportplanid=' + vehicletransportplanid, '_blank');

                                        }
                                    });

                                }


                                function select_employee2()
                                {


                                    var srtype = document.getElementById("cb_srtype").value;
                                    var search = document.getElementById("txt_search").value;
                                    $.ajax({
                                        type: 'post',
                                        url: 'meg_searchemployee6.php',
                                        data: {
                                            srtype: srtype, search: search, positiondirver: '', positionofficer: ''
                                        },
                                        success: function (response) {
                                            if (response)
                                            {

                                                document.getElementById("list-data").innerHTML = "";
                                                document.getElementById("loading").innerHTML = response;
                                                $('[data-toggle="popover"]').popover({
                                                    html: true,
                                                    content: function () {
                                                        return $('#popover-content').html();
                                                    }
                                                });
                                            }



                                        }
                                    });

                                }
        </script> 

    </html>

    <?php
    sqlsrv_close($conn);
    ?>