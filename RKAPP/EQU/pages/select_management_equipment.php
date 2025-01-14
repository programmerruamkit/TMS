<?php
$page_title = "EQUIPMENT";
if (require_once '../../application.php') {
    if ($_SESSION['LEVEL'] >= 3) {
        if ($_GET['selection'] == 'search') {
            $name = "%".$_GET['name'];
            $type = $_GET['type'];
            $i = 1;
            $value = "*";
            $condition = "WHERE (EQ_ID LIKE '$name') AND E_TYPE LIKE '%$type' AND STATUS_USE = 1";
            $qry = select_all_data($rki->conn, $rki->stmanagement, $rki->tbequipment, $value, $condition);
            echo "<table class='table table-bordered'><tr><td></td><td>รหัสอุปกรณ์</td><td>รหัสเครื่อง</td><td>ชื่ออุปกรณ์</td><td>สถานะ</td><td></td></tr>";
            while ($item = sqlsrv_fetch_object($qry)) {
                ?>
                <tr>
                    <td><?= $i ?></td> <td><?= $item->E_CODE ?></td> <td><?= $item->EQ_ID ?></td> <td><?= $item->E_NAME ?></td> <td><?= e_status_name($item->E_STATUS) ?></td> 
                    <td><button id="<?= $i ?>" name="<?= $i ?>" class="btn btn-default" value="<?= $item->E_ID ?>" onclick="search_data('data_display', 'select', '', this.value, '/RKAPP/EQU/pages/select_management_equipment.php')"><span class='fa fa-edit'></span></button></td>
                </tr>
                <?php
                $i++;
            }
        } else if ($_GET['selection'] == 'select') {
            $id = $_GET['name'];
            $value = "*";
            $condition = "WHERE E_ID = $id";
            $qry = select_all_data($rki->conn, $rki->stmanagement, $rki->tbequipment, $value, $condition);
            $item = sqlsrv_fetch_object($qry);
            ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">INFORMATION</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="input-group w3-margin-bottom"><span class="input-group-addon">รหัสอุปกรณ์</span>
                            <input class='form-control' type="text" value="<?= $item->E_CODE ?>" readonly>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-group w3-margin-bottom"><span class="input-group-addon">รหัสเครื่อง</span>
                            <input class='form-control' type="text" value="<?= $item->EQ_ID ?>" readonly>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-group w3-margin-bottom"><span class="input-group-addon">ชื่อรุ่นอุปกรณ์</span>
                            <input class='form-control' type="text" value="<?= $item->E_NAME ?>" readonly>
                        </div>
                    </div>
                </div>
                <form id="management_equipment" name="management_equipment" method="post" action="/RKAPP/TOOL/sql/sql_equipment_data.php" onsubmit="return conf_send_data('update')">
                    <input type="hidden" id="selection" name="selection" value="store">
                    <input type="hidden" id="e_id" name="e_id" value="<?= $item->E_ID ?>">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="input-group w3-margin-bottom"><span class="input-group-addon">สถานะ</span>
                                <select class='form-control' name="e_status" id="e_status" required>
                                    <option value="0" <?php if ($item->E_STATUS == 0) {
                echo 'selected';
            } ?>>ยังไม่ได้ใช้งาน</option>
                                    <option value="1" <?php if ($item->E_STATUS == 1) {
                echo 'selected';
            } ?>>ใช้งาน</option>
                                    <option value="2" <?php if ($item->E_STATUS == 2) {
                echo 'selected';
            } ?>>ซ่อม</option>
                                    <option value="3" <?php if ($item->E_STATUS == 3) {
                echo 'selected';
            } ?>>สำรอง</option>
                                    <option value="4" <?php if ($item->E_STATUS == 4) {
                echo 'selected';
            } ?>>เสีย/จำหน่าย</option>
                                    <option value="5" <?php if ($item->E_STATUS == 5) {
                echo 'selected';
            } ?>>รอซ่อม/ยกเลิกใช้งาน</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group w3-margin-bottom"><span class="input-group-addon">สถานที่</span>
                                <input class='form-control' type="text" id="location_name" name="location_name" maxlength="50" value="<?= $item->LOCATION_NAME ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group w3-margin-bottom"><span class="input-group-addon">หน่วยงาน</span>
                                <input class='form-control' type="text" id="department_name" name="department_name" maxlength="50" value="<?= $item->DEPARTMENT_NAME ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="input-group w3-margin-bottom"><span class="input-group-addon">รายละเอียดการใช้งาน</span>
                                <textarea class='form-control' rows="3" id="e_remark" name="e_remark" required><?= $item->E_REMARK ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer row">
                        <button type="submit" class="btn btn-success"><span class='fa fa-edit'></span> DATA SAVE</button>
                    </div>
                </form>
            </div>
            <?php
        }
    } else {
        echo '<script type="text/javascript">window.alert("สิทธิ์ไม่ได้รับอนุญาต!!!");</script>';
        header("refresh: 0; url=/RKAPP/EQU/pages/store_management_equipment.php");
        exit(0);
    }
} else {
    header("refresh: 0; url=/RKAPP/");
    exit(0);
}
?>

