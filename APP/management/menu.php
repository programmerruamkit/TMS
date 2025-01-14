<?php $title_page = "Management"; ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Management</h1>
                        </div>

                        <!-- Content Row -->
                        <div class="row">

                            <div class="col-xl-12 col-lg-12">
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Dropdown -->
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-dark">
                                        <h6 class="m-0 font-weight-bold text-light">Menu</h6>
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
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <div class="row">

                                            <!-- Card Example -->
                                            <div class="col-xl-3 col-md-6 mb-4">
                                                <div class="card border-left-success shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <a href="<?=$oop->appmanagement."/index.php?page=Order"?>">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"></div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">คำร้อง (<?=count_order($oop->rkadb, $oop->sp1)?>)</div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-list fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Card Example -->
                                            <div class="col-xl-3 col-md-6 mb-4">
                                                <div class="card border-left-warning shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <a href="<?=$oop->appmanagement."/index.php?page=Work"?>">
                                                            <div class="row no-gutters align-items-center">
                                                                <div class="col mr-2">
                                                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1"></div>
                                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">งานที่ดำเนินการ</div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <i class="fas fa-edit fa-2x text-gray-300"></i>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Card Example -->
                                            <div class="col-xl-3 col-md-6 mb-4">
                                                <div class="card border-left-danger shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <a href="<?=$oop->appmanagement."/index.php?page=Report"?>">
                                                            <div class="row no-gutters align-items-center">
                                                                <div class="col mr-2">
                                                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1"></div>
                                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">รายงานการดำเนินงาน</div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <i class="fas fa-print fa-2x text-gray-300"></i>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

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

