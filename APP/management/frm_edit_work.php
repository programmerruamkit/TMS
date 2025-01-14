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
                                        <h6 class="m-0 font-weight-bold text-light">Work</h6>
                                    </div>

                                    <?php
                                    $n = 1;
                                    $name = $_COOKIE['RK_USER_NAME'];
                                    $table = "[RKADB_TABLE_WORK] W, [RKADB_TABLE_ORDER] O";
                                    $value = "*";
                                    if($_COOKIE['RK_USER_TYPE'] != 'ADMIN'){
                                        $condition = "WHERE W.[WORK_ORDER] = O.[ORDER_ID] AND W.[ITEM_STATUS] = 1 AND W.[WORK_BY] = '$name'";
                                    }else{
                                        $condition = "WHERE W.[WORK_ORDER] = O.[ORDER_ID] AND W.[ITEM_STATUS] = 1";
                                    }
                                    $para = set_stored_para("SELECT", $table, $value, $condition);
                                    $qry = db_query_stored($oop->rkadb, $oop->sp1, $para);
                                    ?>

                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                <thead class="bg-dark text-light">
                                                    <tr>
                                                        <td>#</td> <td>เลขที่เอกสาร</td> <td>รหัสเครื่อง</td> <td>เรื่อง</td> <td>ผู้แจ้ง</td> <td>สถานะ</td> <td>-</td>
                                                        <?php if($_COOKIE['RK_USER_TYPE'] == 'ADMIN'){echo "<td>ผู้ดำเนินงาน</td>";}?>
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
                                                        echo '<td>' . $bag->CREATE_BY . '</td>';
                                                        echo '<td>' . work_status_name($bag->WORK_STATUS) . '</td>';
                                                        echo '<td><center>' . "<form method='POST' action='$oop->appmanagement/frm_edit_work.php'><button class='btn btn-info btn-circle' type='submit' name='order_item' value='$bag->ORDER_ID'><i class='fas fa-edit'></i></button></form>" . '</td>';
                                                        if($_COOKIE['RK_USER_TYPE'] == 'ADMIN'){echo "<td>".$bag->WORK_BY."</td>";}
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

                        <?php if ($_POST['order_item'] != '' || $_GET['order_item'] != '') { ?>
                            <?php
                            if ($_POST['order_item'] != '') {
                                $oid = $_POST['order_item'];
                                $condition = "WHERE O.[ORDER_ID] = '$oid' AND W.[WORK_ORDER] = O.[ORDER_ID]";
                            }
                            if ($_GET['order_item'] != '') {
                                $oid = $_GET['order_item'];
                                $condition = "WHERE O.[ORDER_CODE] = '$oid' AND W.[WORK_ORDER] = O.[ORDER_ID]";
                            }
                            $value = "*";
                            $table = "[RKADB_TABLE_WORK] W, [RKADB_TABLE_ORDER] O";
                            $para = set_stored_para("SELECT", $table, $value, $condition);
                            $qry = db_query_stored($oop->rkadb, $oop->sp1, $para);
                            $bag = sqlsrv_fetch_object($qry);
                            ?>

                            <div class="row">

                                <div class="col-xl-12 col-lg-12">
                                    <div class="card shadow mb-4">
                                        <!-- Card Header - Dropdown -->
                                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-dark">
                                            <h6 class="m-0 font-weight-bold text-light">Work Information</h6>
                                            <div class="dropdown no-arrow">
                                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                                    <div class="dropdown-header">Head Menu:</div>
                                                    <a class="dropdown-item" href="#">Menu 1</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Card Body -->
                                        <div class="card-body">
                                            <form method="POST" enctype="multipart/form-data" action="<?=$oop->sql?>" onsubmit="return conf_send_data()">
                                                <input type="hidden" name="select_type" value="Management">
                                                <input type="hidden" name="sub_type" value="Edit">
                                                <input type="hidden" name="work_id" value="<?= $bag->WORK_ID ?>">
                                                <input type="hidden" name="order_id" value="<?= $bag->ORDER_ID ?>">
                                                <a href="#OrderDoc" class="d-block card-header py-3 bg-dark" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="OrderDoc">
                                                    <h6 class="m-0 font-weight-bold text-light">Order Detail</h6>
                                                </a>
                                                <!-- Card Content - Collapse -->
                                                <div class="collapse show" id="OrderDoc">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">ผู้แจ้งงาน</span>
                                                                    </div>
                                                                    <input class='form-control' type="text" value="<?= $bag->CREATE_BY ?>" readonly>
                                                                </div>
                                                            </div> 
                                                            <div class="col-lg-6">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">แจ้งงาน</span>
                                                                    </div>
                                                                    <input class='form-control' type="text" value="<?= $bag->ORDER_NAME ?>" readonly>
                                                                </div>
                                                            </div> 
                                                            <div class="col-lg-6">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">บริษัท</span>
                                                                    </div>
                                                                    <input class='form-control' type="text" value="<?= select_once_data($oop->rkadb, $oop->sp1, $oop->tbcompany, "C_NAME_T", "WHERE [C_ID] = '$bag->COMPANY_ID'") ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">เลขอุปกรณ์</span>
                                                                    </div>
                                                                    <input class='form-control' type="text" value="<?= $bag->ORDER_EQ ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">สถานที่</span>
                                                                    </div>
                                                                    <input class='form-control' type="text" value="<?= $bag->LOCATION_NAME ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">หน่วยงาน</span>
                                                                    </div>
                                                                    <input class='form-control' type="text" value="<?= $bag->DEPARTMENT_NAME ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">รายละเอียด</span>
                                                                    </div>
                                                                    <textarea class="form-control" rows="4" readonly><?= $bag->ORDER_DETAIL ?></textarea>
                                                                </div>
                                                            </div>
                                                            <?php if($bag->ORDER_FILE != ''){?>
                                                            <div class="col-lg-12">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">File</span>
                                                                    </div>
                                                                    <a class='form-control btn btn-block btn-outline-primary' href="<?= "/app/file/requirement/".$bag->ORDER_FILE?>" target="_blank">เอกสารแนบ</a>
                                                                </div>
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>

                                                <div class="card shadow mb-4">
                                                    <div class="card-header py-3 bg-dark">
                                                        <h6 class="m-0 font-weight-bold text-light">Work Action Detail</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">ผลการดำเนินงาน</span>
                                                                    </div>
                                                                    <select class="form-control" name="work_status" required>
                                                                        <option value="1" <?php if($bag->WORK_STATUS == 1){echo 'selected';}?>>ดำเนินการเรียบร้อยแล้ว</option>
                                                                        <option value="2" <?php if($bag->WORK_STATUS == 2){echo 'selected';}?>>ไม่สามารถดำเนินงานได้</option>
                                                                        <option value="3" <?php if($bag->WORK_STATUS == 3){echo 'selected';}?>>เสีย/ซ่อม/รออะไหล่</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">File</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" name="work_file" accept=".png, .jpg, .jpeg">
                                                                        <label class="custom-file-label" for="customFile">เอกสารแนบ...</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">รายละเอียดการดำเนินงาน</span>
                                                                    </div>
                                                                    <textarea class="form-control" rows="4" name="work_detail" required><?=$bag->WORK_DETAIL?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <button type="submit" class="btn btn-success btn-block">Action</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Content Row -->
                            </div>

                        <?php } ?>
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

    </body>
    </html>
    <?php
} else {
    header("refresh: 0; url=$oop->apphome/page_error.php");
    exit(0);
}
?>