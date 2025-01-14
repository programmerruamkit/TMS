<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$condition1 = "  AND a.PersonID = '" . $_GET['employeeid'] . "'";
$sql_seEmployee = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmployee = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
$result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC);
if ($_GET['meg'] == 'edit') {
    $condition11 = " AND EMPLOYEECODE = " . $result_seEmployee['PersonCode'];
    $sql_seHeal1 = "{call megEmployeehealth_v2(?,?)}";
    $params_seHeal1 = array(
        array('select_health', SQLSRV_PARAM_IN),
        array($condition11, SQLSRV_PARAM_IN)
    );
    $query_seHeal1 = sqlsrv_query($conn, $sql_seHeal1, $params_seHeal1);
    $result_seHeal1 = sqlsrv_fetch_array($query_seHeal1, SQLSRV_FETCH_ASSOC);
}
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
                <div class="row" >
                    <div class="col-lg-12">

                        <h2 class="page-header">
                            <i class="glyphicon glyphicon-bed"></i>  
                            <?php
                            echo "ข้อมูลประวัติโรคประจำตัว";
                            ?>


                        </h2>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div id="datade_edit">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #e7e7e7">
                                    <?php
                                    $meg = ($_GET['meg'] == 'add') ? 'เพิ่มข้อมูล' : 'แก้ไขข้อมูล';

                                    echo $_SESSION["link"] . " / " . $meg;
                                    ?>
                                </div>
                                <div class="panel-body">

                                    <div class="row" >
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>โรคประจำตัว</label>
                                                <input class="form-control"  type="text" id="txt_healthissue" name="txt_healthissue" value="<?= $result_seHeal1['HEALTHISSUE'] ?>">
                                                <input class="form-control" type="text" style="display: none" readonly="" id="txt_employeeid" name="txt_employeeid" value="<?= $_GET['employeeid'] ?>">

                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>การแก้ไข</label>
                                                <input class="form-control"  id="txt_suggestion" name="txt_suggestion"  value="<?= $result_seHeal1['SUGGESTION'] ?>" >

                                            </div>

                                        </div>



                                    </div>
                                    <div class="row" >
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>คำแนะนำ</label>
                                                <textarea class="form-control" autocomplete="off" rows="3" id="txt_comment" name="txt_comment" ><?= $result_seHeal1['COMMENT'] ?></textarea>

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
                    <div class="row">
                        <div class="col-lg-12">
                            <?php
                            $buttonname = ($_GET['meg'] == 'add') ? "บันทึกข้อมูล" : "แก้ไขข้อมูล";
                            ?>
                            <input type="button" onclick="save_employeeheal('<?= $result_seHeal1['ID'] ?>');" name="btnSend" id="btnSend" value="<?= $buttonname ?>" class="btn btn-primary">




                        </div>
                    </div>
                </div>
                <div id="datasr_edit"></div>

                <div class="row" >
                    <div class="col-lg-12">
                        &nbsp;

                    </div>
                </div>


                <div class="row" >
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color: #e7e7e7">
                                <font style="font-size: 16px"><b>รายการข้อมูล : ประวัติโรคประจำตัว</b></font>                            
                            </div>
                            <div class="panel-body">
                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="datade">
                                                <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>รหัสพนักงาน</th>
                                                            <th>ชื่อ-นามสกุล</th>
                                                            <th>โรคประจำตัว</th>
                                                            <th>การแก้ไข</th>
                                                            <th>คำแนะนำ</th>
                                                            <th style="text-align: center"><a href="meg_employeeheal.php?meg=add&employeeid=<?= $_GET['employeeid'] ?>"><li class="fa fa-plus-square"></li> เพิ่มประวัติ</a></th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $condition1 = " AND EMPLOYEECODE = " . $result_seEmployee['PersonCode'];
                                                        $sql_seHeal = "{call megEmployeehealth_v2(?,?)}";
                                                        $params_seHeal = array(
                                                            array('select_health', SQLSRV_PARAM_IN),
                                                            array($condition1, SQLSRV_PARAM_IN)
                                                        );
                                                        $query_seHeal = sqlsrv_query($conn, $sql_seHeal, $params_seHeal);
                                                        while ($result_seHeal = sqlsrv_fetch_array($query_seHeal, SQLSRV_FETCH_ASSOC)) {
                                                            ?>
                                                            <tr >
                                                                <td><?= $result_seEmployee['PersonCode'] ?></td>
                                                                <td><?= $result_seEmployee['nameT'] ?></td>
                                                                <td><?= $result_seHeal['HEALTHISSUE'] ?></td>
                                                                <td><?= $result_seHeal['SUGGESTION'] ?></td>
                                                                <td><?= $result_seHeal['COMMENT'] ?></td>
                                                                <td style="text-align: center">
                                                                    <a href="meg_employeeheal.php?meg=edit&employeeid=<?= $_GET['employeeid'] ?>" title="แก้ไขข้อมูล" type="button" class="btn btn-default  btn-circle"><span class="glyphicon glyphicon-wrench"></span></a>
                                                                    <button onclick="delete_employeeheal(<?= $result_seHeal['ID'] ?>);" title="ลบข้อมูล" type="button" class="btn btn-default btn-circle"><span class="glyphicon glyphicon-remove"></span></button>

                                                                </td>
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
        <script src="../dist/js/jquery.autocomplete.js"></script>


        <script src="../dist/js/bootstrap-select.js"></script>



    </body>

    <script>
                                                                    $(document).ready(function () {
                                                                        $('#dataTables-example').DataTable({
                                                                            responsive: true
                                                                        });
                                                                    });
    </script>
    <script>
        function delete_employeeheal(healid)
        {

           
            $.ajax({
                type: 'post',
                url: 'meg_data.php',
                data: {
                    txt_flg: "delete_employeeheal", healid: healid

                },
                success: function (response) {
                    alert(response);
                    window.location.reload();
                }
            });

        }
        function save_employeeheal(healid)
        {

            var healid = healid;
            var employeecode = '<?= $result_seEmployee['PersonCode'] ?>';
            var healthissue = document.getElementById('txt_healthissue').value;
            var suggestion = document.getElementById('txt_suggestion').value;
            var comment = document.getElementById('txt_comment').value;



            $.ajax({
                type: 'post',
                url: 'meg_data.php',
                data: {
                    txt_flg: "save_health", healid: healid, employeecode: employeecode, healthissue: healthissue, suggestion: suggestion, comment: comment

                },
                success: function (response) {
                    alert(response);
                    window.location.reload();
                }
            });

        }


    </script>
</html>


<?php
sqlsrv_close($conn);
?>