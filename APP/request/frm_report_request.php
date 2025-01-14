<?php $title_page = "Request"; ?>

<?php if (require_once '../master.php') { ?>
    <body id="page-top">

        <!-- Page Wrapper -->
        <div id="wrapper">

            <?php require_once '../menu_bar.php'; ?>

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <?php require_once '../top_bar.php'; ?>

                    <!-- Begin Page Content -->
                    <div class="container-fluid">

                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Report</h1>
                        </div>

                        <!-- Content Row -->
                        <div class="row">

                            <div class="col-xl-12 col-lg-12">
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Dropdown -->
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-dark">
                                        <h6 class="m-0 font-weight-bold text-light">Request Data Document</h6>
                                        <div class="dropdown no-arrow">
                                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                                <div class="dropdown-header">Head Menu:</div>
                                                <a class="dropdown-item" href="#">Menu 1</a>
                                                <a class="dropdown-item" href="#">Menu 2</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#">Menu 3</a>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    $n = 1;
                                    $table = "RKADB_TABLE_ORDER O, RKADB_TABLE_WORK W";
                                    $value = "*";
                                    $condition = "WHERE W.[WORK_ORDER] = O.[ORDER_ID] AND O.[ORDER_CHECK] = 1 AND O.[CREATE_BY] = '" . $_COOKIE['RK_USER_NAME'] . "'";
                                    $para = set_stored_para("SELECT", $table, $value, $condition);
                                    $qry = db_query_stored($oop->rkadb, $oop->sp1, $para);
                                    ?>

                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                <thead class="bg-dark text-light">
                                                    <tr>
                                                        <td>#</td> <td>เลขที่เอกสาร</td> <td>รหัสเครื่อง</td> <td>งาน</td> <td>สถานะ</td> <td>วันที่-เวลา แจ้ง</td> <td>วันที่-เวลา ดำเนินงาน</td> <td>พิมพ์</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    while ($bag = sqlsrv_fetch_object($qry)) {
                                                        echo '<tr>';
                                                        echo '<td>' . $n++ . '</td>';
                                                        echo '<td>' . $bag->ORDER_CODE . '</td>';
                                                        echo '<td>' . $bag->ORDER_EQ . '</td>';
                                                        echo '<td>' . $bag->ORDER_NAME . '</td>';
                                                        echo '<td><center>' . work_status_name($bag->WORK_STATUS) . '</td>';
                                                        echo '<td>' . format_datetime($bag->CREATE_DATE, 'datetime') . '</td>';
                                                        echo '<td>' . format_datetime($bag->WORK_END, 'datetime') . '</td>';
                                                        echo '<td><center>' . "<form method='POST' action='$oop->apprequest/report_request.php' target='_blank'><button class='btn btn-circle' type='submit' name='order_id' value='$bag->ORDER_ID'><i class='fas fa-print'></i></button></form>" . '</td>';
                                                        echo '</tr>';
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Content Row -->
                        </div>

                        <!-- /.container-fluid -->
                    </div>
                    <!-- End of Main Content -->

                </div>
                <!-- End of Content Wrapper -->

            </div>
            <!-- End of Page Wrapper -->

            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>

        </div>

    </body>
    </html>
    <?php
} else {
    header("refresh: 0; url=$oop->apphome/page_error.php");
    exit(0);
}
?>