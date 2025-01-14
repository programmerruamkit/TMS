<?php $title_page = "Equipment"; ?>

<?php
if (require_once '../master.php') {
    if ($_COOKIE['RK_USER_TYPE'] == 'IT' || $_COOKIE['RK_USER_TYPE'] == 'ADMIN') {
        ?>
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
                                <h1 class="h3 mb-0 text-gray-800">Equipment</h1>
                            </div>

                            <!-- Content Row -->
                            <div class="row">

                                <div class="col-xl-12 col-lg-12">
                                    <div class="card shadow mb-4">
                                        <!-- Card Header - Dropdown -->
                                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-dark">
                                            <h6 class="m-0 font-weight-bold text-light">Add Equipment</h6>
                                            <div class="dropdown no-arrow">
                                                <a class="dropdown-toggle" href="#AddEquipment" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="AddEquipment">
                                                    <i class="fas fa-bars fa-sm fa-fw text-gray-400"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <?php $para_type = set_stored_para("SELECT", $oop->tbtype, "[TYPE_CODE],[TYPE_NAME]", "WHERE [ITEM_STATUS] = 1 AND [TYPE_CODE] LIKE 'EQ%' ORDER BY [TYPE_CODE]"); ?>
                                        <?php $qry_type = db_query_stored($oop->rkadb, $oop->sp1, $para_type); ?>

                                        <div class="collapse" id="AddEquipment">
                                            <!-- Card Body -->
                                            <div class="card-body">
                                                <form method="POST" enctype="multipart/form-data" action="<?= $oop->sql ?>" onsubmit="return conf_send_data()">
                                                    <input type="hidden" name="select_type" value="Equipment">
                                                    <input type="hidden" name="sub_type" value="Add">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">ประเภท</span>
                                                                </div>
                                                                <select class='form-control' type="text" name='e_type' required>
                                                                    <option value="">ระบุประเภท</option>
                                                                    <?php while ($item_type = sqlsrv_fetch_object($qry_type)) { ?> 
                                                                        <option value="<?= $item_type->TYPE_CODE ?>"><?= $item_type->TYPE_NAME ?></option>
        <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">เลขอุปกรณ์</span>
                                                                </div>
                                                                <input class='form-control' type="text" id="e_code" name="e_code" placeholder="..." maxlength="10" required autofocus>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">เลขทรัพย์สิน</span>
                                                                </div>
                                                                <input class='form-control' type="text" name='ac_code' placeholder="..." maxlength="10">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">ชื่อรุ่น</span>
                                                                </div>
                                                                <input class='form-control' type="text" name='e_name' placeholder="..." maxlength="100" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">ราคา</span>
                                                                </div>
                                                                <input class='form-control' type="number" name='e_price' placeholder="0.00">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">รูปอุปกรณ์</span>
                                                                </div>
                                                                <input class="form-control" type="file" name="e_pic" accept=".png, .jpg, .jpeg">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">วันที่นำเข้า</span>
                                                                </div>
                                                                <input class='form-control' type="date" name='e_comein' value="<?= $oop->serverdate; ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">ระยะเวลาประกัน/เดือน</span>
                                                                </div>
                                                                <input class='form-control' type="number" name='waranty' value="12" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">รายละเอียด</span>
                                                                </div>
                                                                <textarea class="form-control" rows="4" name="e_detail" placeholder="..." required></textarea>
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
                                            <h6 class="m-0 font-weight-bold text-light">Equipment</h6>
                                            <div class="dropdown no-arrow">
                                                <a class="dropdown-toggle" href="#ShowData" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="ShowData">
                                                    <i class="fas fa-bars fa-sm fa-fw text-gray-400"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <?php $para = set_stored_para("SELECT", $oop->tbequipment, "[E_ID],[E_CODE],[E_NAME],[E_TYPE],[E_STATUS]", "WHERE [ITEM_STATUS] = 1"); ?>
                                        <?php $qry = db_query_stored($oop->rkadb, $oop->sp1, $para); ?>
                                        <?php $n = 1; ?>

                                        <div class="collapse show" id="ShowData">
                                            <!-- Card Body -->
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                        <thead class="bg-dark text-light">
                                                            <tr>
                                                                <td>#</td> <td>เลขอุปกรณ์</td> <td>ชื่อรุ่น</td> <td>ประเภท</td> <td>สถานะ</td> <td>-</td> <td>-</td> <?php if($_COOKIE['RK_USER_TYPE'] == 'ADMIN' || $_COOKIE['RK_USER_LEVEL'] >= 5){echo "<td>-</td>";}?>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php while ($item = sqlsrv_fetch_object($qry)) { ?> 
                                                            <tr>
                                                                <td><?= $n++; ?></td> <td><?= $item->E_CODE; ?></td> <td><?= $item->E_NAME; ?></td> <td><?= select_type_name($oop->rkadb, $item->E_TYPE); ?></td> <td><?= equipment_status_name($item->E_STATUS); ?></td> 
                                                                <td><center><form method="POST" action="<?= $oop->appequipment . "/frm_manage_equipment.php" ?>"><button class="btn btn-circle btn-outline-info" type="submit" name="manage_equipment" value="<?= $item->E_ID; ?>"><i class='fas fa-check-square'></i></button></form></center></td>
                                                                <td><center><form method="POST" action="<?= $oop->appequipment . "/frm_manage_equipment.php" ?>"><button class="btn btn-circle btn-outline-danger" type="submit" name="edit_equipment" value="<?= $item->E_ID; ?>"><i class='fas fa-edit'></i></button></form></center></td>
                                                                <?php if($_COOKIE['RK_USER_TYPE'] == 'ADMIN' || $_COOKIE['RK_USER_LEVEL'] >= 5){?><td><center><form method="POST" action="<?= $oop->appequipment . "/frm_manage_equipment.php" ?>"><button class="btn btn-circle btn-outline-danger" type="submit" name="del_equipment" value="<?= $item->E_ID; ?>"><i class='fas fa-trash'></i></button></form></center></td><?php }?>
                                                            </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                                <?php if ($_POST['manage_equipment'] != '') { ?>
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="card shadow mb-4">
                                            <!-- Card Header - Dropdown -->
                                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-dark">
                                                <h6 class="m-0 font-weight-bold text-light">Manage Equipment</h6>
                                            </div>

                                            <?php $e_id = $_POST['manage_equipment']; ?>
                                            <?php $para = set_stored_para("SELECT", $oop->tbequipment, "*", "WHERE [ITEM_STATUS] = 1 AND [E_ID] = '$e_id'"); ?>
                                            <?php $qry = db_query_stored($oop->rkadb, $oop->sp1, $para); ?>
                                            <?php $item = sqlsrv_fetch_object($qry); ?>

                                            <!-- Card Body -->
                                            <div class="card-body">
                                                <form method="POST" enctype="multipart/form-data" action="<?= $oop->sql ?>" onsubmit="return conf_send_data()">
                                                    <input type="hidden" name="select_type" value="Equipment">
                                                    <input type="hidden" name="sub_type" value="Manage">
                                                    <input type="hidden" name="e_id" value="<?= $item->E_ID ?>">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">เลขอุปกรณ์</span>
                                                                </div>
                                                                <input class='form-control' type="text" value="<?= $item->E_CODE ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">ชื่อรุ่น</span>
                                                                </div>
                                                                <input class='form-control' type="text" value="<?= $item->E_NAME ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">บริษัท</span>
                                                                </div>
                                                                <?php $para_com = set_stored_para("SELECT", $oop->tbcompany, "[C_ID],[C_NAME_T]", "WHERE [STATUS_USE] = 1"); ?>
                                                                <?php $qry_com = db_query_stored($oop->rkadb, $oop->sp1, $para_com); ?>
                                                                <select class="form-control" name="company_id" required>
                                                                    <option value="">ระบุบริษัท</option>
                                                                    <?php while ($item_com = sqlsrv_fetch_object($qry_com)) { ?> 
                                                                        <option value="<?= $item_com->C_ID ?>" <?php
                                                                        if ($item->COMPANY_ID == $item_com->C_ID) {
                                                                            echo "selected";
                                                                        }
                                                                        ?>><?= $item_com->C_NAME_T ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">สถานที่</span>
                                                                </div>
                                                                <input class="form-control" type="text" name="location" placeholder="..." maxlength="50" value="<?= $item->LOCATION_NAME ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">หน่วยงาน</span>
                                                                </div>
                                                                <input class="form-control" type="text" name="department" placeholder="..." maxlength="50" value="<?= $item->DEPARTMENT_NAME ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">จุดติดตั้ง</span>
                                                                </div>
                                                                <input class="form-control" type="text" name="point" placeholder="..." maxlength="50" value="<?= $item->POINT_NAME ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">IP ADDRESS</span>
                                                                </div>
                                                                <input class="form-control" type="text" name="ip" placeholder="..." maxlength="16" value="<?= $item->IP_ADDRESS ?>">
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

                                <?php } else if ($_POST['edit_equipment'] != '') { ?>
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="card shadow mb-4">
                                            <!-- Card Header - Dropdown -->
                                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-dark">
                                                <h6 class="m-0 font-weight-bold text-light">Edit Equipment</h6>
                                                <div class="dropdown no-arrow">
                                                    <a class="dropdown-toggle" href="#EditEquipment" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="EditEquipment">
                                                        <i class="fas fa-bars fa-sm fa-fw text-gray-400"></i>
                                                    </a>
                                                </div>
                                            </div>

                                            <?php $e_id = $_POST['edit_equipment']; ?>
                                            <?php $para = set_stored_para("SELECT", $oop->tbequipment, "*", "WHERE [ITEM_STATUS] = 1 AND [E_ID] = '$e_id'"); ?>
                                            <?php $qry = db_query_stored($oop->rkadb, $oop->sp1, $para); ?>
                                            <?php $item = sqlsrv_fetch_object($qry); ?>
                                            <?php $para_type = set_stored_para("SELECT", $oop->tbtype, "[TYPE_CODE],[TYPE_NAME]", "WHERE [ITEM_STATUS] = 1 AND [TYPE_CODE] LIKE 'EQ%' ORDER BY [TYPE_CODE]"); ?>
                                            <?php $qry_type = db_query_stored($oop->rkadb, $oop->sp1, $para_type); ?>

                                            <div class="collapse show" id="EditEquipment">
                                                <!-- Card Body -->
                                                <div class="card-body">
                                                    <form method="POST" enctype="multipart/form-data" action="<?= $oop->sql ?>" onsubmit="return conf_send_data()">
                                                        <input type="hidden" name="select_type" value="Equipment">
                                                        <input type="hidden" name="sub_type" value="Edit">
                                                        <input type="hidden" name="e_id" value="<?= $item->E_ID ?>">
                                                        <input type="hidden" name="e_pic" value="<?= $item->E_PIC ?>">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">ประเภท</span>
                                                                    </div>
                                                                    <select class='form-control' type="text" name='e_type' required>
                                                                        <?php while ($item_type = sqlsrv_fetch_object($qry_type)) { ?> 
                                                                            <option value="<?= $item_type->TYPE_CODE ?>" <?php
                                                                            if ($item->E_TYPE == $item_type->TYPE_CODE) {
                                                                                echo "selected";
                                                                            }
                                                                            ?>><?= $item_type->TYPE_NAME ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">เลขอุปกรณ์</span>
                                                                    </div>
                                                                    <input class='form-control' type="text" name="e_code" value="<?= $item->E_CODE ?>" maxlength="10" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">เลขทรัพย์สิน</span>
                                                                    </div>
                                                                    <input class='form-control' type="text" name='ac_code' value="<?= $item->AC_CODE ?>" maxlength="10">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">ชื่อรุ่น</span>
                                                                    </div>
                                                                    <input class='form-control' type="text" name='e_name' value="<?= $item->E_NAME ?>" maxlength="100" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">ราคา</span>
                                                                    </div>
                                                                    <input class='form-control' type="number" name='e_price' value="<?= $item->E_PRICE ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">รูปอุปกรณ์</span>
                                                                    </div>
                                                                    <input class="form-control btn" type="file" name="e_pic" accept=".png, .jpg, .jpeg">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">วันที่นำเข้า</span>
                                                                    </div>
                                                                    <input class='form-control' type="date" name='e_comein' value="<?= format_datetime($item->E_COMEIN, 'date') ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">ระยะเวลาประกัน/เดือน</span>
                                                                    </div>
                                                                    <input class='form-control' type="number" name='waranty' value="12" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">รายละเอียด</span>
                                                                    </div>
                                                                    <textarea class="form-control" rows="4" name="e_detail" required><?= $item->E_DETAIL ?></textarea>
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
                                <?php } else if ($_POST['del_equipment'] != '') { ?>
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="card shadow mb-4">
                                            <!-- Card Header - Dropdown -->
                                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-dark">
                                                <h6 class="m-0 font-weight-bold text-light">Delete Equipment</h6>
                                                <div class="dropdown no-arrow">
                                                    <a class="dropdown-toggle" href="#DelEquipment" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="DelEquipment">
                                                        <i class="fas fa-bars fa-sm fa-fw text-gray-400"></i>
                                                    </a>
                                                </div>
                                            </div>

                                            <?php $e_id = $_POST['del_equipment']; ?>
                                            <?php $para = set_stored_para("SELECT", $oop->tbequipment, "[E_STATUS]", "WHERE [E_ID] = '$e_id'"); ?>
                                            <?php $qry = db_query_stored($oop->rkadb, $oop->sp1, $para); ?>
                                            <?php $item = sqlsrv_fetch_object($qry); ?>

                                            <div class="collapse show" id="DelEquipment">
                                                <!-- Card Body -->
                                                <div class="card-body">
                                                    <form method="POST" enctype="multipart/form-data" action="<?= $oop->sql ?>" onsubmit="return conf_send_data()">
                                                        <input type="hidden" name="select_type" value="Equipment">
                                                        <input type="hidden" name="sub_type" value="Del">
                                                        <input type="hidden" name="e_id" value="<?= $e_id ?>">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">สถานะ</span>
                                                                    </div>
                                                                    <select class='form-control' name='e_status' required>
                                                                        <option value="">ระบุสถานะ</option>
                                                                        <option value="2">ซ่อม/รอซ่อม</option>
                                                                        <option value="3">สำรอง</option>
                                                                        <option value="4">เสีย/จำหน่าย/ยกเลิกใช้งาน</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <button type="submit" class="btn btn-success btn-block">SAVE</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                            <!-- Content Row -->
                        </div>

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
        header("refresh: 0; url=/app/page_error.php");
        exit(0);
    }
}
?>