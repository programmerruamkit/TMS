
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

                        <h2 class="page-header"><i class="fa fa-truck"></i>  
                            บริษัท

                        </h2>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color: #e7e7e7">

                                <?php
                               
                                    echo "บริษัท";
                                    $link = "<a href='report_companybillingamata.php?type=report'>บริษัท</a>";
                                    $_SESSION["link"] = $link;
                               
                                ?>
                            </div>
                            <!-- /.panel-heading -->

                            <div class="panel-body">
                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                    <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>ชื่อบริษัท</th>

                                                <th style="text-align: center">เลือกลูกค้า</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>
                                                <td>ร่วมกิจรุ่งเรือง โลจิสติคส์</td>
                                               
                                                <td style="text-align: center">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                                            <i class="fa fa-chevron-down"></i>
                                                        </button>
                                                        <ul class="dropdown-menu slidedown">

                                                            <li>
                                                                <a href="report_customerbillingamata.php?type=customer&meg=report&companycode=RKL">เลือกลูกค้า</a>
                                                            </li>


                                                        </ul>
                                                    </div>

                                                </td>


                                            </tr>
                                            <tr>
                                               
                                                <td>ร่วมกิจรุ่งเรือง เซอร์วิส</td>
                                              
                                                <td style="text-align: center">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                                            <i class="fa fa-chevron-down"></i>
                                                        </button>
                                                        <ul class="dropdown-menu slidedown">

                                                            <li>
                                                                <a href="report_customerbillingamata.php?type=customer&meg=report&companycode=RKS">เลือกลูกค้า</a>
                                                            </li>


                                                        </ul>
                                                    </div>

                                                </td>


                                            </tr>
                                            <tr>
                                              
                                                <td>ร่วมกิจรุ่งเรือง (1993)</td>
                                                <td style="text-align: center">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                                            <i class="fa fa-chevron-down"></i>
                                                        </button>
                                                        <ul class="dropdown-menu slidedown">

                                                            <li>
                                                                <a href="report_customerbillingamata.php?type=customer&meg=report&companycode=RKR">เลือกลูกค้า</a>
                                                            </li>


                                                        </ul>
                                                    </div>

                                                </td>


                                            </tr>


                                        </tbody>
                                    </table>



                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
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

            <script>
                                                                $(document).ready(function () {
                                                                    $('#dataTables-example').DataTable({
                                                                        responsive: true,
                                                                        order: [[0, "desc"]]
                                                                    });
                                                                });
            </script>


    </body>
    <script>
        function delete_menu(val)
        {
            var confirmation = confirm("ต้องการลบข้อมูล ?");

            if (confirmation) {
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "delete_menu", menuid: val
                    },
                    success: function () {
                        alert('ลบข้อมูลเรียบร้อยแล้ว');
                        window.location.reload();
                    }
                });
            }
        }
    </script>
    <script>
        function delete_submenu(val)
        {
            var confirmation = confirm("ต้องการลบข้อมูล ?");

            if (confirmation) {
                $.ajax({
                    type: 'post',
                    url: 'meg_data.php',
                    data: {
                        txt_flg: "delete_submenu", submenuid: val
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