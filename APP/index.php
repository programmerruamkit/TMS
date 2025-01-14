<?php $title_page = "Index"; ?>
<?php
if (require 'master.php') {
    ?>
    <body id="page-top">

        <!-- Page Wrapper -->
        <div id="wrapper">

            <?php require_once 'menu_bar.php'; ?>

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <?php require_once 'top_bar.php'; ?>

                    <!-- Begin Page Content -->
                    <div class="container-fluid">

                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Home</h1>
                            <a href="" class="d-none d-sm-inline-block btn btn-sm btn-dark shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                        </div>

                        <!-- Content Row -->
                        <div class="row">

                            <div class="col-xl-12 col-lg-12">
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Dropdown -->
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-dark">
                                        <h6 class="m-0 font-weight-bold text-light">MENU</h6>
                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <div class="container-fluid">
                                            <div class="row">

                                                <!-- Earnings (Monthly) Card Example -->
                                                <div class="col-xl-3 col-md-6 mb-4">
                                                    <div class="card border-left-success shadow h-100 py-2">
                                                        <div class="card-body">
                                                            <a href="<?=$oop->apprequest."/index.php?page=Add"?>">
                                                                <div class="row no-gutters align-items-center">
                                                                    <div class="col mr-2">
                                                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"></div>
                                                                        <div class="h5 mb-0 font-weight-bold text-gray-800">แจ้งคำร้อง</div>
                                                                    </div>
                                                                    <div class="col-auto">
                                                                        <i class="fas fa-file fa-2x text-gray-300"></i>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <?php if($_COOKIE['RK_USER_TYPE'] == 'IT' || $_COOKIE['RK_USER_TYPE'] == 'ADMIN'){ ?>
                                                <div class="col-xl-3 col-md-6 mb-4">
                                                    <div class="card border-left-warning shadow h-100 py-2">
                                                        <div class="card-body">
                                                            <a href="<?=$oop->appmanagement."/index.php?page=Order"?>">
                                                                <div class="row no-gutters align-items-center">
                                                                    <div class="col mr-2">
                                                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"></div>
                                                                        <div class="h5 mb-0 font-weight-bold text-gray-800">คำร้อง (<?= count_order($oop->rkadb, $oop->sp1) ?>)</div>
                                                                    </div>
                                                                    <div class="col-auto">
                                                                        <i class="fas fa-list fa-2x text-gray-300"></i>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Content Row -->

                        </div>
                        <!-- /.container-fluid -->

                        <?php include 'calendar/calendar.php'; ?>

                    </div>
                    <!-- End of Main Content -->

                    <!-- Footer -->
                    <footer class="sticky-footer bg-white">
                        <div class="container my-auto">
                            <div class="copyright text-center my-auto">
                                <span>Copyright &copy; RKAPP 2019</span>
                            </div>
                        </div>
                    </footer>
                    <!-- End of Footer -->

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
    header("refresh: 0; url=/app/page_error.php");
    exit(0);
}
?>
