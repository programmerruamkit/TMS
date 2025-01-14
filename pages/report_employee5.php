
<!DOCTYPE html>
<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
ini_set('max_execution_time', 300);
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
                        <h2 class="page-header">
                            <i class="glyphicon glyphicon-user"></i> ข้อมูลพนักงาน



                        </h2>




                    </div>
                    <!-- /.panel-body -->
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color: #e7e7e7">

                                <?php
                                echo "ข้อมูลพนักงาน";
                               
                                ?>
                            </div>
                            <!-- /.panel-heading -->

                            <div class="panel-body">
                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>รหัสพนักงาน</th>
                                                <th>ชื่อ-นามสกุล</th>
                                                <th>เบอร์โทรศัพท์</th>
                                                <th>อีเมลล์</th>
                                                <th style="text-align: center">ข้อมูลย่อย</th>
                                            </tr>
                                        </thead>
                                        <tbody>
<?php
$condition2 = "";
$condition3 = "";

$sql_seEmp = "{call megEmployeeEHR_v2(?,?)}";
$params_seEmp = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);


$query_seEmp = sqlsrv_query($conn, $sql_seEmp, $params_seEmp);
while ($result_seEmp = sqlsrv_fetch_array($query_seEmp, SQLSRV_FETCH_ASSOC)) {
    ?>
                                                <tr class="odd gradeX">
                                                    <td><?= $result_seEmp['PersonCode'] ?></td>
                                                    <td><?= $result_seEmp['nameT'] ?></td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td style="text-align: center">
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                                                <i class="fa fa-chevron-down"></i>
                                                            </button>
                                                            <ul class="dropdown-menu slidedown">
                                                                
                                                                <li>
                                                                    <a href="meg_employeeheal.php?meg=add&employeeid=<?= $result_seEmp['PersonID'] ?>">
                                                                        เพิ่มประวัติโรคประจำตัว
                                                                    </a>
                                                                </li>
                                                                

                                                            </ul>
                                                        </div>
                                                    </td>
                                                    


                                                </tr>

    <?php
}
?>
                                        </tbody>
                                    </table>
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

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
    <script src="../dist/js/sb-admin-2.js"></script>

    <script>
            $(document).ready(function () {
                $('#dataTables-example').DataTable({
                    responsive: true,
                    order: [[0, "desc"]]
                });
            });



            function save_tenkomasterofficer(employeecode1, tenkomasterid, companycode)
            {

                // alert(employeecode1);
                // alert(tenkomasterid);
                // alert(companycode);
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "save_tenkomasterofficer", tenkomasterid: '', vehicletransportplanid: employeecode1, changeka: '',
                        remark1: '', remark2: '', status: '1', officer: '<?= $result_seEmp["nameT"] ?>'



                    },
                    success: function (rs) {

                        // alert(rs);

                        window.open('meg_tenkodocument.php?employeecode1=' + employeecode1 + '&companycode=' + companycode + '&tenkomasterid=' + tenkomasterid, '_blank');

                    }
                });

            }
    </script>


</body>

<script>

    function delete_roleaccount(val)
    {
        var confirmation = confirm("ต้องการลบข้อมูล ?");

        if (confirmation) {
            $.ajax({
                type: 'post',
                url: 'meg_data.php',
                data: {
                    txt_flg: "delete_roleaccount", roleaccountid: val
                },
                success: function () {
                    alert('ลบข้อมูลเรียบร้อยแล้ว');
                    window.location.reload();
                }
            });
        }
    }
    function delete_role(val)
    {
        var confirmation = confirm("ต้องการลบข้อมูล ?");

        if (confirmation) {
            $.ajax({
                type: 'post',
                url: 'meg_data.php',
                data: {
                    txt_flg: "delete_role", roleid: val
                },
                success: function () {
                    alert('ลบข้อมูลเรียบร้อยแล้ว');
                    window.location.reload();
                }
            });
        }
    }
    function delete_rolemenu(val)
    {
        var confirmation = confirm("ต้องการลบข้อมูล ?");

        if (confirmation) {
            $.ajax({
                type: 'post',
                url: 'meg_data.php',
                data: {
                    txt_flg: "delete_rolemenu", rolemenuid: val
                },
                success: function () {
                    alert('ลบข้อมูลเรียบร้อยแล้ว');
                    window.location.reload();
                }
            });
        }
    }
</script>

</html>
<?php
sqlsrv_close($conn);
?>
