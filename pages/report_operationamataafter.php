<!DOCTYPE html>
<?php
session_start();
ini_set('max_execution_time', 300);
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$condition1 = "  AND a.PersonID = '" . $_SESSION["EMPLOYEEID"] . "'";
$sql_seEmployee = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmployee = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
$result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC);

$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_afterdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

$condiCompany = " AND Company_Code = '" . $_GET['companycode'] . "'";
$sql_seCompany = "{call megCompany_v2(?,?)}";
$params_seCompany = array(
    array('select_company', SQLSRV_PARAM_IN),
    array($condiCompany, SQLSRV_PARAM_IN)
);
$query_seCompany = sqlsrv_query($conn, $sql_seCompany, $params_seCompany);
$result_seCompany = sqlsrv_fetch_array($query_seCompany, SQLSRV_FETCH_ASSOC);
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

        <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="js/jquery.form.min.js"></script>


        <link href="style/style.css" rel="stylesheet" type="text/css">

    </head>

    <body >



        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

            <div class="navbar-header" >
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../pages/index.php"><font style="color: #000;font-size: 14px"><img src="../images/logo.ico" height="30"> <strong>Transport Management System</strong></font></a>
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




        <div class="row" >
            <div class="col-lg-12" style="text-align: right">



                <input class="btn btn-default" type="button" style="background-color: red;border:solid 2px white" id="btn_srquotation" name="btn_srquotation" value=""> * แจ้งเตือนข้อมูล ไม่พบราคาขนส่ง  

            </div>
        </div>
        <div class="row">

            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color: #e7e7e7">
                        <div class="row">

                            <div class="col-lg-6">

                                <?php
                                $meg = 'รายงานตัวตรวจร่างกายย้อนหลัง';




                                echo "<a href='index.php?type=report'>หน้าหลัก</a>  / " . $meg;
                                $link = "<a href='index.php?type=report'>หน้าหลัก</a> ";
                                $_SESSION["link"] = $link;
                                ?>
                            </div>
                            <!-- /.panel-heading -->

                            <div class="col-lg-6 text-right">
                                <?= $result_seCompany['Company_NameT'] ?>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">

                        <div class="row">

                            <div class="col-md-2" >
                                <label>บริษัท</label>
                                <select class="form-control"  id="cb_company" name="cb_company" >

                                    <option value = "RKR">ร่วมกิจรุ่งเรือง (1993)</option>
                                    <option value = "RKL">ร่วมกิจรุ่งเรือง โลจิสติคส์</option>
                                    <option value = "RKS">ร่วมกิจรุ่งเรือง เซอร์วิส</option>
                                </select>
                            </div>
                            <div class="col-lg-2">

                                <div class="form-group">
                                    <label>ค้นหาตามช่วงวันที่</label>
                                    <input class="form-control dateen" readonly="" onchange="datetodate();" style="background-color: #f080802e" id="txt_datestart" name="txt_datestart" value="<?= $result_getDate['SYSDATE']; ?>" placeholder="วันที่เริ่มต้น">

                                </div>

                            </div>
                            <div class="col-lg-2">
                                <label>&nbsp;</label>
                                <div class="form-group">
                                    <input type="text" class="form-control dateen" readonly="" style="background-color: #f080802e" id="txt_dateend" name="txt_dateend" placeholder="วันที่สิ้นสุด" value="<?= $result_getDate['SYSDATE']; ?>">

                                </div>
                            </div>


                            <div class="col-lg-2">
                                <label>&nbsp;</label>
                                <div class="form-group">
                                    <button class="btn btn-default"  onclick="select_operationamataafter();">ค้นหา <li class="fa fa-search"></li></button>
                                </div>

                            </div>



                        </div>
                        <div class="row">

                            <div class="col-md-2" >&nbsp;</div>
                        </div>
                        <div id="datadef">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    ตารางตรวจเท็งโกะย้อนหลัง
                                                </div>



                                            </div>
                                        </div>
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">

                                            <div class="tab-content">
                                                <div class="row">
                                                    <div class="col-md-12" >&nbsp;</div>
                                                </div>

                                                <div class="row">

                                                    <div class="col-md-12" >
                                                        <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">


                                                            <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                                <thead>
                                                                    <tr>

                                                                        <th style="text-align: center;width:5%" >จัดการ</th>



                                                                        <th style="text-align: center;width:15%">เลขที่งาน</th>
                                                                        <th style="text-align: center;width:10%">ทะเบียน/ชื่อรถ</th>

                                                                        <th style="text-align: center;width:15%">พนักงาน(1)</th>
                                                                        <th style="text-align: center;width:15%">พนักงาน(2)</th>

                                                                        <th style="text-align: center;width:10%">ต้นทาง</th>
                                                                        <th style="text-align: center;width:10%">ปลายทาง</th>

                                                                        <th style="text-align: center;width:5%">รายงานตัว</th>

                                                                        <th style="text-align: center;width:5%">เข้าวีแอล</th>
                                                                        <th style="text-align: center;width:5%">ออกวีแอล</th>

                                                                        <th style="text-align: center;width:5%">เข้าดีลเลอร์</th>
                                                                        <th style="text-align: center;width:5%">กลับบริษัท</th>





                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    <?php
                                                                    $sql_seOps = "{call megVehicletransportplan_v2(?,?,?,?)}";

                                                                    $condOps1 = " AND a.COMPANYCODE = 'RKR'";
                                                                    //$condOps2 = " AND (a.STATUSNUMBER = 'O' OR a.STATUSNUMBER = 'L')";
                                                                    $condOps2 = "";
                                                                    $condOps3 = " AND CONVERT(DATE,a.DATEVLIN) = CONVERT(DATE,DATEADD(DAY,-1,GETDATE()))";
                                                                    $params_seOps = array(
                                                                        array('select_datevehicletransportplanorderbydate', SQLSRV_PARAM_IN),
                                                                        array($condOps1, SQLSRV_PARAM_IN),
                                                                        array($condOps2, SQLSRV_PARAM_IN),
                                                                        array($condOps3, SQLSRV_PARAM_IN)
                                                                    );



                                                                    $i = 1;
                                                                    $query_seOps = sqlsrv_query($conn, $sql_seOps, $params_seOps);
                                                                    while ($result_seOps = sqlsrv_fetch_array($query_seOps, SQLSRV_FETCH_ASSOC)) {
                                                                        ?>


                                                                        <tr <?php
                                                                        if ($result_seOps['ACTUALPRICE'] == '' || $result_seOps['ACTUALPRICE'] == '0.00') {
                                                                            ?>
                                                                                style="color: red"
                                                                                <?php
                                                                            }
                                                                            ?>>


                                                                            <td style="text-align: center">
                                                                                <div class="btn-group">
                                                                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                                                                        <i class="fa fa-chevron-down"></i>
                                                                                    </button>
                                                                                    <ul class="dropdown-menu slidedown">
                                                                                        <?php
                                                                                        if ($result_seOps['ACTUALPRICE'] != "") {
                                                                                            ?>
                                                                                            <li>
                                                                                                <a tabindex="-1" href='#' onclick="save_tenkomaster('<?= $result_seOps['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_seOps['EMPLOYEECODE1'] ?>', '1')" ><?= $result_seOps['EMPLOYEENAME1'] ?></a>
                                                                                            </li>
                                                                                            <li>
                                                                                                <a tabindex="-1" href='#' onclick="save_tenkomaster('<?= $result_seOps['VEHICLETRANSPORTPLANID'] ?>', '<?= $result_seOps['EMPLOYEECODE2'] ?>', '2')" ><?= $result_seOps['EMPLOYEENAME2'] ?></a>
                                                                                            </li>


                                                                                            <?php
                                                                                        } else {
                                                                                            ?>
                                                                                            <li>-</li>
                                                                                            <?php
                                                                                        }
                                                                                        ?>







                                                                                    </ul>
                                                                                </div>

                                                                            </td>




                                                                            <td ><?= $result_seOps['JOBNO'] ?></td>

                                                                            <td ><?= $result_seOps['THAINAME'] ?></td>
                                                                            <td ><?= $result_seOps['EMPLOYEENAME1'] ?></td>
                                                                            <td ><?= $result_seOps['EMPLOYEENAME2'] ?></td>
                                                                            <td><?= $result_seOps['JOBSTART'] ?></td>
                                                                            <td><?= $result_seOps['JOBEND'] ?></td>
                                                                            <td><?= $result_seOps['DATEPRESENT'] ?></td>
                                                                            <td><?= $result_seOps['DATEVLIN'] ?></td>
                                                                            <td><?= $result_seOps['DATEVLOUT'] ?></td>
                                                                            <td><?= $result_seOps['DATEDEALERIN'] ?></td>
                                                                            <td><?= $result_seOps['DATERETURN'] ?></td>




                                                                        </tr>
                                                                        <?php
                                                                        $i++;
                                                                    }
                                                                    ?>

                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </div>

                                                    <!-- /.panel-body -->
                                                </div>





                                            </div>
                                        </div>
                                        <!-- /.panel-body -->
                                    </div>
                                    <!-- /.panel -->
                                </div>

                            </div>
                        </div>
                        <div id="datasr"></div>
                        <!-- /.panel -->
                    </div>
                </div>
            </div>




        <!--<script src="../vendor/jquery/jquery.min.js"></script>-->
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

            <script type="text/javascript">

                                                                                                    function save_tenkomaster(vehicletransportplanid, employeecode, statusemp)
                                                                                                    {

                                                                                                        $.ajax({
                                                                                                            type: 'post',
                                                                                                            url: 'meg_data.php',
                                                                                                            data: {
                                                                                                                txt_flg: "save_tenkomasterpast", tenkomasterid: '', vehicletransportplanid: vehicletransportplanid, changeka: '',
                                                                                                                remark1: '', remark2: '', status: '1', officer: '<?= $result_seEmployee["nameT"] ?>'

                                                                                                            },
                                                                                                            success: function () {
                                                                                                                if (statusemp == '1')
                                                                                                                {
                                                                                                                    window.open('meg_tenkodocument_affter.php?vehicletransportplanid=' + vehicletransportplanid + '&employeecode1=' + employeecode, '_blank');
                                                                                                                } else
                                                                                                                {
                                                                                                                    window.open('meg_tenkodocument_affter.php?vehicletransportplanid=' + vehicletransportplanid + '&employeecode2=' + employeecode, '_blank');
                                                                                                                }

                                                                                                            }
                                                                                                        });

                                                                                                    }

                                                                                                    function datetodate()
                                                                                                    {
                                                                                                        document.getElementById('txt_dateend').value = document.getElementById('txt_datestart').value;

                                                                                                    }
                                                                                                    function select_operationamataafter()
                                                                                                    {

                                                                                                        $.ajax({
                                                                                                            url: 'meg_data.php',
                                                                                                            type: 'POST',
                                                                                                            data: {
                                                                                                                txt_flg: "select_operationtenkoamataafter", companycode: document.getElementById("cb_company").value, datestart: document.getElementById('txt_datestart').value, dateend: document.getElementById('txt_dateend').value
                                                                                                            },
                                                                                                            success: function (rs) {

                                                                                                                document.getElementById("datadef").innerHTML = "";
                                                                                                                document.getElementById("datasr").innerHTML = rs;
                                                                                                                $('#dataTables-example1').DataTable({
                                                                                                                    responsive: true
                                                                                                                });

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
                                                                                                            maxDate: new Date(new Date().setDate(new Date().getDate() + -1))

                                                                                                        });
                                                                                                    });




                                                                                                    $(document).ready(function () {
                                                                                                        $('#dataTables-example1').DataTable({
                                                                                                            responsive: true
                                                                                                        });

                                                                                                    });
            </script>

    </body>

</html>
<?php
sqlsrv_close($conn);
?>
