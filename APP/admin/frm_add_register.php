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
                                <h1 class="h3 mb-0 text-gray-800">Register</h1>
                            </div>

                            <!-- Content Row -->
                            <div class="row">

                                <div class="col-xl-12 col-lg-12">
                                    <div class="card shadow mb-4">
                                        <!-- Card Header - Dropdown -->
                                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-dark">
                                            <h6 class="m-0 font-weight-bold text-light">Search Data</h6>
                                        </div>
                                        <!-- Card Body -->
                                        <div class="card-body">
                                            <div class="container-fluid">

                                                <form method="POST" enctype="multipart/form-data" action="<?=$oop->appadmin."/frm_add_register.php"?>">
                                                    <div class="row">
                                                        <div class="input-group col-lg-3">
                                                            <input type="text" name="data_for_file" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon">
                                                            <div class="input-group-append">
                                                                <button class="btn btn-primary" type="submit">
                                                                    <i class="fas fa-search fa-sm"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Content Row -->
                            </div>

                            <?php if ($_POST['data_for_file'] != '') { ?>
                                <div class="row">

                                    <div class="col-xl-12 col-lg-12">
                                        <div class="card shadow mb-4">
                                            <!-- Card Header - Dropdown -->
                                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-dark">
                                                <h6 class="m-0 font-weight-bold text-light">Data Search</h6>
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
                                                <?php
                                                $search = $_POST['data_for_file'];
                                                $condition = "WHERE [PersonCode] LIKE '%$search%' OR [PersonCardID] LIKE '%$search%' OR [FnameT] LIKE '%$search%' OR [LnameT] LIKE '%$search%'";
                                                $para = set_stored_para("SELECT_EHR", "-", "-", $condition);
                                                $qry = db_query_stored($oop->rkadb, $oop->sp1, $para);
                                                $n = 1;
                                                ?>
                                                <div class="container-fluid">

                                                    <div class="table-responsive">
                                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                            <thead class="bg-dark text-light">
                                                                <tr>
                                                                    <td>#</td> <td>รหัส</td> <td>รหัสพนักงาน</td> <td>ชื่อ</td> <td>นามสกุล</td> <td></td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                while ($bag = sqlsrv_fetch_object($qry)) {
                                                                    echo '<tr>';
                                                                    echo '<td>' . $n++ . '</td>';
                                                                    echo '<td>' . $bag->PersonCode . '</td>';
                                                                    echo '<td>' . $bag->PersonCardID . '</td>';
                                                                    echo '<td>' . $bag->FnameT . '</td>';
                                                                    echo '<td>' . $bag->LnameT . '</td>';
                                                                    echo '<td><center>' . "<form method='POST' action='$oop->appadmin/frm_add_register.php'><button class='btn btn-success btn-circle' type='submit' name='select_data_regis' value='$bag->PersonID'>/</button></form>" . '</td>';
                                                                    echo '</tr>';
                                                                }
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
                            <?php } ?>

                            <?php if ($_POST['select_data_regis'] != '') { ?>
                                <div class="row">

                                    <div class="col-xl-12 col-lg-12">
                                        <div class="card shadow mb-4">
                                            <!-- Card Header - Dropdown -->
                                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-dark">
                                                <h6 class="m-0 font-weight-bold text-light">Information</h6>
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
                                                <?php
                                                $search = $_POST['select_data_regis'];
                                                $condition = "WHERE [PersonID] = '$search'";
                                                $para = set_stored_para("SELECT_EHR", "-", "-", $condition);
                                                $qry = db_query_stored($oop->rkadb, $oop->sp1, $para);
                                                $bag = sqlsrv_fetch_object($qry);
                                                if ($bag->SexID == 1) {
                                                    $sex = 'M';
                                                } else {
                                                    $sex = 'F';
                                                }
                                                ?>
                                                <div class="container-fluid">

                                                    <form method="POST" enctype="multipart/form-data" action="<?=$oop->sql?>" onsubmit="return conf_send_data()">
                                                        <input type="hidden" name="select_type" value="Regis">
                                                        <input type="hidden" name="sub_type" value="Add">
                                                        <input type="hidden" id="person_id" name="person_code" value="<?= $bag->PersonCode ?>">
                                                        <input type="hidden" id="company_id" name="company_id" value="<?= $bag->CompanyID ?>">
                                                        <input type="hidden" id="position_id" name="position_id" value="<?= $bag->PositionID ?>">
                                                        <input type="hidden" id='person_sex' name='person_sex' value="<?= $sex ?>">

                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">ชื่อ</span>
                                                                    </div>
                                                                    <input class='form-control' type="text" name='person_firstname' value="<?= $bag->FnameT ?>" readonly>
                                                                </div>
                                                            </div> 
                                                            <div class="col-lg-6">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">นามสกุล</span>
                                                                    </div>
                                                                    <input class='form-control' type="text" name='person_lastname' value="<?= $bag->LnameT ?>" readonly>
                                                                </div>
                                                            </div> 
                                                            <div class="col-lg-6">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">สาขา</span>
                                                                    </div>
                                                                    <select class='form-control' name='area_id' required>
                                                                        <option value="AMATA">AMATA</option>
                                                                        <option value="GATEWAY">GATEWAY</option>
                                                                    </select>
                                                                </div>
                                                            </div> 
                                                            <div class="col-lg-6">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Email</span>
                                                                    </div>
                                                                    <input class='form-control' type="email" name='person_email' placeholder="..." maxlength="100">
                                                                </div>
                                                            </div> 
                                                            <div class="col-lg-6">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Level</span>
                                                                    </div>
                                                                    <input class='form-control' type="number" name='person_level' value="1" min="1" max="9" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Type</span>
                                                                    </div>
                                                                    <select class='form-control' name='person_type'required>
                                                                        <option value="USER">User</option>
                                                                        <option value="IT">IT</option>
                                                                        <option value="ADMIN">Admin</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Picture</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" name="person_pic" accept=".png, .jpg, .jpeg">
                                                                        <label class="custom-file-label" for="customFile">รูปภาพพนักงาน..</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Username</span>
                                                                    </div>
                                                                    <input class='form-control' type="text" name='person_username' value="<?= $bag->PersonCode ?>" readonly>
                                                                </div>
                                                            </div> 
                                                            <div class="col-lg-12">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Password</span>
                                                                    </div>
                                                                    <input class='form-control' type="text" name='person_password' value="<?= $bag->PersonCode ?>" maxlength="20" required>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-12">
                                                                <button type="submit" class="btn btn-success btn-block">SAVE</button> 
                                                                <button type="submit" class="btn btn-danger btn-block">CANCEL</button> 
                                                            </div>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Content Row -->
                                </div>
                            <?php } ?>

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