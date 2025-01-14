<?php
$page_title = "EQUIPMENT";
if (require_once '../../application.php') {
    if ($_SESSION['LEVEL'] >= 1) {
        $condi = $_GET['data'];
        if ($_GET['type'] == 'select' || $_GET['type'] == 'edit') {
            ?>
            <div class="container-fluid">
                <div class="row">
                    <table class="table table-bordered">
                        <tr>
                            <td></td> <td>รหัสเครื่อง</td> <td>ชื่ออุปกรณ์</td> <td>วันที่นำเข้า</td> <td>หมดประกัน</td> <td>สถานะ</td>
                            <?php
                            if ($_GET['type'] == 'edit' && $_SESSION['LEVEL'] >= 3) {
                                echo "<td></td>";
                            }
                            ?>
                        </tr>
                        <?php
                        $i = 1;
                        $qry = select_all_data($rki->conn, $rki->stmanagement, $rki->tbequipment, "*", "WHERE [E_TYPE] LIKE '%$condi' AND STATUS_USE = 1 ORDER BY [E_CODE]");
                        while ($item = sqlsrv_fetch_object($qry)) {
                            echo "<tr>";
                            echo "<td>" . $i++ . "</td>";
                            echo "<td>" . $item->EQ_ID . "</td>";
                            echo "<td>" . $item->E_NAME . "</td>";
                            echo "<td>" . cover_date(format_datetime($item->E_COME, 'date')) . "</td>";
                            echo "<td>";
                            if ($rki->serverdate <= format_datetime($item->E_WARRANTY_END, 'date')) {
                                echo cover_date(format_datetime($item->E_WARRANTY_END, 'date'));
                            } else {
                                echo "<span class='w3-text-red'><b>" . cover_date(format_datetime($item->E_WARRANTY_END, 'date')) . "</b></span>";
                            }
                            echo "</td>";
                            echo "<td>" . e_status_name($item->E_STATUS) . "</td>";
                            if ($_GET['type'] == "edit" && $_SESSION['LEVEL'] >= 3) {
                                echo "<td>";
                                ?> <button class='btn btn-danger' type='button' data-toggle='modal' data-target='#popup_modal' onclick="display_change('modal_display', 'update', <?= $item->E_ID ?>, '/RKAPP/EQU/pages/select_equipment_data.php')"><span class='fa fa-edit'></span></button> <?php
                                echo "</td>";
                            }
                            echo "</tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>
            <?php
        }
        if ($_GET['type'] == 'update' && $_SESSION['LEVEL'] >= 3) {
            $e_id = $_GET['data'];
            ?>
            <form id="edit_equipment" name="edit_equipment" method="post" action="/RKAPP/TOOL/sql/sql_equipment_data.php" onsubmit="return conf_send_data('update')">
                <input type="hidden" id="selection" name="selection" value="update">
                <input type="hidden" id="e_id" name="e_id" value="<?= $e_id ?>">
                <div class="modal-header">
                    <button type="button" class="close w3-red" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">แก้ไขข้อมูล อุปกรณ์</h4>
                </div>
                <div class="modal-body">
                    <?php
                    $qry = select_all_data($rki->conn, $rki->stmanagement, $rki->tbequipment, "*", "WHERE E_ID = $e_id");
                    $item = sqlsrv_fetch_object($qry);
                    ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group w3-margin-bottom"><span class="input-group-addon">ประเภท</span>
                                <select class='form-control' id='type_code' name='type_code' onchange="" required>
                                    <?php $qry_type = select_all_data($rki->conn, $rki->stmanagement, $rki->tbtype, "*", "WHERE T_CODE LIKE 'EQ%' AND STATUS_USE = 1 ORDER BY T_CODE"); ?>
                                    <?php while ($item_type = sqlsrv_fetch_object($qry_type)) { ?>
                                        <option value="<?= $item_type->T_CODE ?>" <?php if ($item->E_TYPE == $item_type->T_CODE) { ?> selected <?php } ?> > <?= $item_type->T_NAME ?></option>
                                    <?php } ?>
                                </select>
                            </div> 
                        </div>
                        <div class="col-md-12">
                            <div class="input-group w3-margin-bottom"><span class="input-group-addon">รหัสเครื่อง อุปกรณ์</span>
                                <input class='form-control' type="text" id='eq_id' name='eq_id' onkeyup="to_upper_str('eq_id', this.value)" maxlength="6" value="<?= $item->EQ_ID ?>" required>
                            </div> 
                        </div>
                        <div class="col-md-12">
                            <div class="input-group w3-margin-bottom"><span class="input-group-addon">ชื่อ อุปกรณ์</span>
                                <input class='form-control' type="text" id='e_name' name='e_name' onkeyup="" maxlength="100" value="<?= $item->E_NAME ?>" required>
                            </div> 
                        </div>
                        <div class="col-md-12">
                            <div class="input-group w3-margin-bottom"><span class="input-group-addon">วันที่นำใช้</span>
                                <input class='form-control' type="date" id='e_come' name='e_come' value="<?= format_datetime($item->E_COME,'date') ?>" required>
                            </div> 
                        </div>
                        <div class="col-md-12">
                            <div class="input-group w3-margin-bottom"><span class="input-group-addon">ระยะเวลารับประกัน</span>
                                <input class='form-control' type="text" id='e_warranty' name='e_warranty' value="<?= $item->E_WARRANTY ?>" required>
                            </div> 
                        </div>
                        <div class="col-md-12">
                            <div class="input-group w3-margin-bottom"><span class="input-group-addon">รายละเอียด</span>
                                <textarea class='form-control' id='e_detail' name='e_detail' required><?= $item->E_DETAIL ?></textarea>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info"><span class='fa fa-edit'></span></button>
                    <?php if ($_SESSION['LEVEL'] == 9) {?>
                    <a href="/RKAPP/TOOL/sql/sql_equipment_data.php?selection=del&data=<?=$e_id?>"></a>
                        <button type='button' class='btn btn-danger'><span class='fa fa-trash-o'></span></button>
                    <?php } ?>
                </div>
            </form>
            <?php
        }
    }
} else {
    header("refresh: 0; url=/RKAPP/");
    exit(0);
}
?>