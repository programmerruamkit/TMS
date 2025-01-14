<?php
$page_title = "BACK OFFICE";
if (require_once '../../application.php') {
    if ($_SESSION['LEVEL'] == 9) {
        $condi = $_GET['data'];
        if ($_GET['type'] == 'select' || $_GET['type'] == 'edit') {
            ?>
            <div class="container-fluid">
                <div class="row">
                    <?php $qry = select_all_data($rki->conn, $rki->stmanagement, $rki->tbtype, "*", "WHERE T_CODE LIKE '$condi' AND STATUS_USE = 1 ORDER BY T_CODE"); ?>
                    <table class="table table-hover table-bordered">
                        <tr class="w3-gray">
                            <td></td> <td>รหัสประเภท</td> <td>ชื่อประเภท</td> <td>เพิ่มข้อมูลโดย</td> 
                            <?php if ($_GET['type'] == "edit") {
                                echo "<td></td>";
                            } ?>
                        </tr>
                        <?php
                        $i = 1;
                        while ($item = sqlsrv_fetch_object($qry)) {
                            echo "<tr>";
                            echo "<td>" . $i++ . "</td>";
                            echo "<td>" . $item->T_CODE . "</td>";
                            echo "<td>" . $item->T_NAME . "</td>";
                            echo "<td>" . $item->ADD_BY . "</td>";
                            if ($_GET['type'] == "edit") {
                                echo "<td>";
                                ?> <button class='btn btn-danger' type='button' data-toggle='modal' data-target='#popup_modal' onclick="display_change('modal_display', 'update', <?= $item->T_ID ?>, '/RKAPP/BACKOFFICE/TYPE/select_type_code.php')"><span class='fa fa-edit'></span></button> <?php
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
        if ($_GET['type'] == 'update') {
            $t_id = $_GET['data'];
            ?>
            <form id="edit_type" name="edit_type" method="post" action="/RKAPP/TOOL/sql/sql_type_data.php" onsubmit="return conf_send_data('update')">
                <input type="hidden" id="selection" name="selection" value="update">
                <input type="hidden" id="type_id" name="type_id" value="<?= $t_id ?>">
                <div class="modal-header">
                    <button type="button" class="close w3-red" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">แก้ไขข้อมูล ประเภท</h4>
                </div>
                <div class="modal-body">
                    <?php
                    $qry = select_all_data($rki->conn, $rki->stmanagement, $rki->tbtype, "*", "WHERE T_ID = $t_id");
                    $item = sqlsrv_fetch_object($qry);
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group w3-margin-bottom"><span class="input-group-addon">รหัส ประเภท</span>
                                <input class='form-control' id='type_code' name='type_code' onkeyup="to_upper_str('type_code', this.value)" maxlength="6" value="<?= $item->T_CODE ?>" required>
                            </div> 
                        </div>
                        <div class="col-md-12">
                            <div class="input-group"><span class="input-group-addon">ชื่อของ ประเภท</span>
                                <input class='form-control' id='type_name' name='type_name' onkeyup="" maxlength="100" value="<?= $item->T_NAME ?>" required>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info"><span class='fa fa-edit'></span></button>
                    <button type='button' class='btn btn-danger' onclick="display_change('modal_display', 'del', <?= $item->T_ID ?>, '/RKAPP/BACKOFFICE/TYPE/select_type_code.php')"><span class='fa fa-trash-o'></span></button>
                </div>
            </form>
            <?php
        }
        if ($_GET['type'] == 'del') {
            $t_id = $_GET['data'];
            ?>
            <form id="edit_type" name="edit_type" method="post" action="/RKAPP/TOOL/sql/sql_type_data.php" onsubmit="return conf_send_data('del')">
                <input type="hidden" id="selection" name="selection" value="del">
                <input type="hidden" id="type_id" name="type_id" value="<?= $t_id ?>">
                <div class="modal-header">
                    <button type="button" class="close w3-red" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">ลบข้อมูล ประเภท</h4>
                </div>
                <div class="modal-body">
            <?php
            $qry = select_all_data($rki->conn, $rki->stmanagement, $rki->tbtype, "*", "WHERE T_ID = $t_id");
            $item = sqlsrv_fetch_object($qry);
            ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group w3-margin-bottom"><span class="input-group-addon">รหัส ประเภท</span>
                                <input class='form-control' value="<?= $item->T_CODE ?>" disabled>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type='submit' class='btn btn-danger'><span class='fa fa-trash-o'></span></button>
                </div>
            </form>
            <?php
        }
    }
} else {
    exit(0);
}
?>

