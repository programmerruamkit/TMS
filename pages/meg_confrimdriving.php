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
    array('select_employee', SQLSRV_PARAM_IN),
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
        <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
        <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
        <!--<link href="../dist/css/sb-admin-2.css" rel="stylesheet">-->
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link href="../js/jquery.datetimepicker.css" rel="stylesheet">
        <link href="../dist/css/jquery.autocomplete.css" rel="stylesheet">
        <link href="../dist/css/bootstrap-select.css" rel="stylesheet">

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
                <div class="modal fade" id="modal_history" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

                </div>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading" >
                            <div class="row">&nbsp;</div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">


                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="background-color: #e7e7e7">
                                            ยืนยันการวิ่งงาน
                                        </div>
                                        <!-- /.panel-heading -->

                                        <div class="panel-body">


                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                                            <thead>


                                                                <tr>

                                                                    <th>ต้นทาง</th>
                                                                    <th>CLUSTER</th>
                                                                    <th>ปลายทาง</th>
                                                                    <th>เบอร์รถ</th>
                                                                    <?php
                                                                    if ($_SESSION["ROLENAME"] != "DRIVER") {
                                                                        ?>
                                                                        <th>พขร 1</th>
                                                                        <th>พขร 2</th>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <th>วิ่งคู่กลับ</th>
                                                                        <?php
                                                                    }
                                                                    ?>

                                                                    <th>จำนวนรถใหม่(คัน)</th>
                                                                    <th>เลข DN</th>
                                                                    <th style="text-align: center" >เลือกวิ่งงาน</th>





                                                                </tr>

                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $i = 0;
                                                                $condition1 = " AND a.VEHICLETRANSPORTPLANID = '" . $_GET['vehicletransportplanid'] . "'";
                                                                $sql_seVehicletransportplan3 = "{call megVehicletransportplan_v2(?,?,?,?)}";
                                                                $params_seVehicletransportplan3 = array(
                                                                    array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
                                                                    array($condition1, SQLSRV_PARAM_IN),
                                                                    array('', SQLSRV_PARAM_IN),
                                                                    array('', SQLSRV_PARAM_IN)
                                                                );
                                                                $query_seVehicletransportplan3 = sqlsrv_query($conn, $sql_seVehicletransportplan3, $params_seVehicletransportplan3);
                                                                while ($result_seVehicletransportplan3 = sqlsrv_fetch_array($query_seVehicletransportplan3, SQLSRV_FETCH_ASSOC)) {

                                                                    $conditionJobend = " AND VEHICLETRANSPORTPLANID ='" . $result_seVehicletransportplan3['VEHICLETRANSPORTPLANID'] . "'";
                                                                    $sql_seJobend = "{call megVehicletransportjobendtemp_v2(?,?)}";
                                                                    $params_seJobend = array(
                                                                        array('select_vehicletransportjobendtemp', SQLSRV_PARAM_IN),
                                                                        array($conditionJobend, SQLSRV_PARAM_IN)
                                                                    );
                                                                    $query_seJobend = sqlsrv_query($conn, $sql_seJobend, $params_seJobend);
                                                                    while ($result_seJobend = sqlsrv_fetch_array($query_seJobend, SQLSRV_FETCH_ASSOC)) {
                                                                        ?>
                                                                        <tr>
                                                                            <td><?= $result_seVehicletransportplan3['JOBSTART'] ?></td>
                                                                            <td>


                                                                                <div class="dropdown bootstrap-select show-tick form-control">

                                                                                    <select multiple="" onchange="select_cluster('<?=$result_seVehicletransportplan3['JOBSTART']?>')" id="cb_copydiagramcluster" name="cb_copydiagramcluster" class="selectpicker form-control" id="number-multiple" data-container="body" data-live-search="true" title="เลือก cluster..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98">
                                                                                        <?php
                                                                                        $sql_seCluster = "{call megVehicletransportprice_v2(?,?)}";
                                                                                        $params_seCluster = array(
                                                                                            array('select_cluster', SQLSRV_PARAM_IN),
                                                                                            array('', SQLSRV_PARAM_IN)
                                                                                        );
                                                                                        $query_seCluster = sqlsrv_query($conn, $sql_seCluster, $params_seCluster);
                                                                                        while ($result_seCluster = sqlsrv_fetch_array($query_seCluster, SQLSRV_FETCH_ASSOC)) {
                                                                                            
                                                                                            ?>
                                                                                            <option value="<?= $result_seCluster['CLUSTER'] ?>"><?= $result_seCluster['CLUSTER'] ?></option>
                                                                                            <?php
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                    <input class="form-control" style="display: none"  id="txt_copydiagramcluster" name="txt_copydiagramcluster" maxlength="500" value="" >


                                                                                    <div class="dropdown-menu open" role="combobox">
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
                                                                                    </div>
                                                                                </div>      
                                                                            </td>
                                                                            <td>   
                                                                                <div id="data_copydiagramjobenddef">
                                                                                    <div class="dropdown bootstrap-select show-tick form-control">

                                                                                        <select multiple="" id="cb_copydiagramjobend" name="cb_copydiagramjobend" class="selectpicker form-control" id="number-multiple" data-container="body" data-live-search="true" title="เลือก ปลายทาง..." data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" tabindex="-98">

                                                                                        </select>
                                                                                        <input class="form-control" style="display: none"  id="txt_copydiagramjobend" name="txt_copydiagramjobend" maxlength="500" value="" >


                                                                                        <div class="dropdown-menu open" role="combobox">
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
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div id="data_copydiagramjobendsr"></div>



                                                                            </td>

                                                                            <td><?= $result_seVehicletransportplan3['THAINAME'] ?></td>
                                                                            <?php
                                                                            if ($_SESSION["ROLENAME"] != "DRIVER") {
                                                                                ?>
                                                                                <td><?= $result_seVehicletransportplan3['EMPLOYEENAME1'] ?></td>
                                                                                <td><?= $result_seVehicletransportplan3['EMPLOYEENAME2'] ?></td>
                                                                                <?php
                                                                            } else {
                                                                                ?>
                                                                                <td><?= $result_seVehicletransportplan3['EMPLOYEENAME2'] ?></td>
                                                                                <?php
                                                                            }
                                                                            ?>

                                                                            <td contenteditable="true" onkeyup="edit_vehicletransportjobendtempinner(this, 'AMOUNT', '<?= $result_seJobend['VEHICLETRANSPORTJOBENDTEMPID'] ?>')"><?= $result_seJobend['AMOUNT'] ?></td>
                                                                            <td contenteditable="true" onkeyup="edit_vehicletransportjobendtempinner(this, 'DN', '<?= $result_seJobend['VEHICLETRANSPORTJOBENDTEMPID'] ?>')"><?= $result_seJobend['DN'] ?></td>

                                                                            <td style="text-align: center">
                                                                                <?php
                                                                                if ($result_seJobend['ACTIVESTATUS'] == "1") {
                                                                                    ?>
                                                                                    <input checked="" type="checkbox" id="<?= $result_seJobend['VEHICLETRANSPORTJOBENDTEMPID'] ?>"  class="form-control" style="transform: scale(2)" onchange="edit_chkvehicletransportjobendtemp('1', 'ACTIVESTATUS', '<?= $result_seJobend['VEHICLETRANSPORTJOBENDTEMPID'] ?>', '<?= $_POST['vehicletransportplanid'] ?>')">

                                                                                    <?php
                                                                                } else {
                                                                                    ?>
                                                                                    <input  type="checkbox" id="<?= $result_seJobend['VEHICLETRANSPORTJOBENDTEMPID'] ?>"  class="form-control" style="transform: scale(2)" onchange="edit_chkvehicletransportjobendtemp('0', 'ACTIVESTATUS', '<?= $result_seJobend['VEHICLETRANSPORTJOBENDTEMPID'] ?>', '<?= $_POST['vehicletransportplanid'] ?>')">
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </td>


                                                                        </tr>
                                                                        <?php
                                                                        $i++;
                                                                    }
                                                                }
                                                                ?>

                                                            </tbody>
                                                        </table>

                                                    </div>
                                                </div>

                                                <!--/.panel-body -->
                                            </div>
                                            <!--/.panel -->
                                        </div>
                                    </div>
                                </div>


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

</body>

<script>
                                                                                        function select_cluster(copydiagramjobstart)
                                                                                        {
                                                                                            $('.selectpicker').on('changed.bs.select', function () {
                                                                                                document.getElementById('txt_copydiagramcluster').value = $(this).val();
                                                                                                select_jobend(copydiagramjobstart);
                                                                                            });


                                                                                        }
                                                                                        function select_jobend(copydiagramjobstart)
                                                                                        {

                                                                                     

                                                                                            $.ajax({
                                                                                                type: 'post',
                                                                                                url: 'meg_data.php',
                                                                                                data: {
                                                                                                    txt_flg: "show_copydiagramjobend", cluster: document.getElementById('txt_copydiagramcluster').value , copydiagramjobstart: copydiagramjobstart
                                                                                                },
                                                                                                success: function (rs) {

                                                                                                    document.getElementById("data_copydiagramjobendsr").innerHTML = rs;
                                                                                                    document.getElementById("data_copydiagramjobenddef").innerHTML = "";

                                                                                                    $("#cb_copydiagramjobend").html(rs).selectpicker('refresh');
                                                                                                    $('.selectpicker').on('changed.bs.select', function () {
                                                                                                        document.getElementById('txt_copydiagramjobend').value = $(this).val();

                                                                                                    });


                                                                                                }
                                                                                            });
                                                                                        }
                                                                                        $(document).ready(function () {
                                                                                            $('#dataTables-example').DataTable({
                                                                                                responsive: true
                                                                                            });
                                                                                        });
</script>
</html>


<?php
sqlsrv_close($conn);
?>