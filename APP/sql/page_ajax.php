<?php
$title_page = "SQL";
if (require_once '../master.php') {
    if ($_GET['type'] == 'ajax') {
        if ($_GET['sub_type'] == 'location') {
            if ($_GET['data'] != '') {
                $e_code = $_GET['data'];
                $para = set_stored_para('select', $oop->tbequipment, "[LOCATION_NAME]", "WHERE [E_CODE] = '$e_code'");
                $qry = db_query_stored($oop->rkadb, $oop->sp1, $para);
                $item = sqlsrv_fetch_object($qry);
                if ($item->LOCATION_NAME != '') {
                    ?>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">สถานที่</span>
                        </div>
                        <input class='form-control' type="text" name='order_location' value="<?= $item->LOCATION_NAME ?>" maxlength="50" required>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">สถานที่</span>
                        </div>
                        <input class='form-control' type="text" name='order_location' placeholder="..." maxlength="50" required>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">สถานที่</span>
                    </div>
                    <input class='form-control' type="text" name='order_location' placeholder="..." maxlength="50" required>
                </div>
                <?php
            }
        } else if ($_GET['sub_type'] == 'dept') {
            if ($_GET['data'] != '') {
                $e_code = $_GET['data'];
                $para = set_stored_para('select', $oop->tbequipment, "[DEPARTMENT_NAME]", "WHERE [E_CODE] = '$e_code'");
                $qry = db_query_stored($oop->rkadb, $oop->sp1, $para);
                $item = sqlsrv_fetch_object($qry);
                if ($item->DEPARTMENT_NAME != '') {
                    ?>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">หน่วยงาน</span>
                        </div>
                        <input class='form-control' type="text" name='order_dept' value="<?= $item->DEPARTMENT_NAME ?>" maxlength="50" required>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">หน่วยงาน</span>
                        </div>
                        <input class='form-control' type="text" name='order_dept' placeholder="..." maxlength="50" required>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">หน่วยงาน</span>
                    </div>
                    <input class='form-control' type="text" name='order_dept' placeholder="..." maxlength="50" required>
                </div>
                <?php
            }
        }
    }
}
?>