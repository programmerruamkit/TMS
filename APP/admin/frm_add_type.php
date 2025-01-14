<?php $title_page = "Admin"; ?>

<?php if (require_once '../master.php') { ?>
    <?php if ($_COOKIE['RK_USER_LEVEL'] >= 9) { ?>
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
                                <h1 class="h3 mb-0 text-gray-800">Type</h1>
                            </div>

                            <!-- Content Row -->
                            <div class="row">

                                <div class="col-xl-12 col-lg-12">
                                    <div class="card shadow mb-4">
                                        <!-- Card Header - Dropdown -->
                                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-dark">
                                            <h6 class="m-0 font-weight-bold text-light">Add Type Data</h6>
                                        </div>
                                        <!-- Card Body -->
                                        <div class="card-body">
                                            <div class="container-fluid">

                                                <form method="POST" enctype="multipart/form-data" action="<?=$oop->sql?>">
                                                    <input type="hidden" name="select_type" value="Type">
                                                    <input type="hidden" name="sub_type" value="Add">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">รหัส</span>
                                                                </div>
                                                                <input class='form-control' type="text" name='type_code' placeholder="..." maxlength="10" required autofocus>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">ชื่อรหัส</span>
                                                                </div>
                                                                <input class='form-control' type="text" name='type_name' placeholder="..." maxlength="100" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <button type="submit" class="btn btn-success btn-block">SAVE</button> 
                                                            <button type="reset" class="btn btn-danger btn-block">CANCEL</button> 
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lg-12">
                                    <div class="card shadow mb-4">
                                        <!-- Card Header - Dropdown -->
                                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-dark">
                                            <h6 class="m-0 font-weight-bold text-light">All Data Type</h6>
                                            <div class="dropdown no-arrow">
                                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                                    <div class="dropdown-header">Head Menu:</div>
                                                    <a class="dropdown-item" href="#TypeData" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="TypeData">Hide/Show</a>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="collapse show" id="TypeData">
                                        <!-- Card Body -->
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                    <thead class="bg-dark text-light">
                                                        <tr>
                                                            <td>#</td> <td>รหัส</td> <td>ชื่อรหัส</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            echo table_type_data($oop->rkadb, $oop->sp1)
                                                        ?>
                                                    </tbody>
                                                </table>
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
} else {
    header("refresh: 0; url=$oop->apphome/page_error.php");
    exit(0);
}
?>