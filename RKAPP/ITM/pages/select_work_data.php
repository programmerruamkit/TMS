<?php
$page_title = "IT MANAGEMENT";
if (require_once '../../application.php') {
    if ($_SESSION['LEVEL'] >= 2) {
        if ($_GET['selection'] == 'select') {
            $type = $_GET['type'];
            ?> <table class="table"><tr><td>รหัสเครื่อง</td> <td>เลขที่แจ้ง</td> <td>หัวข้อแจ้ง</td> <td>วันที่แจ้ง</td> <td>ชื่อผู้แจ้ง</td> <td></td></tr> <?php
            $uid = $_SESSION['PERSON_ID'];
            $condition = "WHERE (WORK_BY = '$uid') AND STATUS_USE = 1 AND WORK_STATUS = 1";
            $qry = select_all_data($rki->conn, $rki->stmanagement, $rki->tbwork, "ORDER_ID", $condition);
            while ($wo_id = sqlsrv_fetch_object($qry)) {
                $condition = "WHERE ((ORDER_ID = '$wo_id->ORDER_ID') AND ORDER_CODE LIKE '$type%') AND STATUS_USE = 1 AND ORDER_STATUS = 1 ORDER BY ORDER_DATE";
                $qry_o = select_all_data($rki->conn, $rki->stmanagement, $rki->tborder, "*", $condition);
                while ($item = sqlsrv_fetch_object($qry_o)) {
                    ?><tr><td><?= $item->EQ_ID ?></td> <td><?= $item->ORDER_CODE ?></td> <td><?= $item->ORDER_NAME ?></td> <td><?= cover_date(format_datetime($item->ORDER_DATE, 'date')) ?></td>
                            <td><?= select_once_data($rki->conn, $rki->stmanagement, $rki->tbperson, "P_FNAME", "WHERE P_ID = '$item->ADD_BY'"); ?></td>
                            <td><button type="button" class="btn btn-info" data-toggle='modal' data-target='#popup_modal' onclick="display_change('modal_display', 'detail', <?= $item->ORDER_ID ?>, '/RKAPP/ITM/pages/select_work_data.php')"><span class="fa fa-file-o"></span></button></td></tr><?php
                    }
                }
                ?></table><?php
                    } else if ($_GET['type'] == 'detail') {
                        $o_id = $_GET['data'];
                        $qry = select_all_data($rki->conn, $rki->stmanagement, $rki->tborder, "*", "WHERE ORDER_ID = $o_id");
                        $item = sqlsrv_fetch_object($qry);
                        ?>
            <form id="update_work" name="update_work" method="post" action="/RKAPP/TOOL/sql/sql_itm_data.php" onsubmit="return conf_send_data('update')">
                <div class="modal-header">
                    <button type="button" class="close w3-red" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title page-header">รายละเอียดงานแจ้งซ่อม</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group w3-margin-bottom"><span class="input-group-addon">เลขที่เอกสาร</span>
                                <input class='form-control' type="text" id='order_code' name='order_code' value="<?= $item->ORDER_CODE ?>" readonly>
                            </div> 
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group w3-margin-bottom"><span class="input-group-addon">รหัสเครื่อง</span>
                                <input class='form-control' type="text" id='eq_id' name='eq_id' value="<?= $item->EQ_ID ?>" readonly>
                            </div> 
                        </div>
                        <div class="col-lg-12">
                            <div class="input-group w3-margin-bottom"><span class="input-group-addon">เรื่อง</span>
                                <input class='form-control' type="text" id='order_name' name='order_name' value="<?= $item->ORDER_NAME ?>" readonly>
                            </div> 
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group w3-margin-bottom"><span class="input-group-addon">สถานที่</span>
                                <input class='form-control' type="text" id='location_name' name='location_name' value="<?= $item->LOCATION_NAME ?>" readonly>
                            </div> 
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group w3-margin-bottom"><span class="input-group-addon">หน่วยงาน</span>
                                <input class='form-control' type="text" id='department_name' name='department_name' value="<?= $item->DEPARTMENT_NAME ?>" readonly>
                            </div> 
                        </div>
                        <div class="col-lg-12">
                            <div class="input-group w3-margin-bottom"><span class="input-group-addon">รายละเอียด</span>
                                <textarea class='form-control' type="text" id='order_detail' name='order_detail' readonly>
                                    <?= $item->ORDER_DETAIL ?>
                                </textarea>
                            </div> 
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group w3-margin-bottom"><span class="input-group-addon">วันที่แจ้ง</span>
                                <input class='form-control' type="text" id='order_date' name='order_date' value="<?= cover_date(format_datetime($item->ORDER_DATE, 'date')) ?>" readonly>
                            </div> 
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group w3-margin-bottom"><span class="input-group-addon">สถานะ</span>
                                <select class='form-control' id='order_status' name='order_status' required="">
                                    <option value="">เลือกการดำเนินงาน</option>
                                    <option value="2">ดำเนินการเรียบร้อยแล้ว</option>
                                    <option value="3">ไม่สามารถดำเนินงานได้</option>
                                    <option value="4">เสีย/ซ่อม/รออะไหล่</option>
                                </select>
                            </div> 
                        </div>
                        <div class="col-lg-12">
                            <div class="input-group w3-margin-bottom"><span class="input-group-addon">รายละเอียดการดำเนินงาน</span>
                                <textarea class='form-control' type="text" id='work_remark' name='work_remark' ></textarea>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="selection" name="selection" value="update">
                    <input type="hidden" id="order_id" name="order_id" value="<?= $item->ORDER_ID ?>">
                    <button type="submit" class="btn btn-success"><span class="fa fa-file-o"> บันทึกการดำเนินงาน</span></button>
                </div>
            </form>
            <?php
        } else if ($_GET['type'] == 'workdetail') {
            ?>
            <div class="modal-header">
                <button type="button" class="close w3-red" data-dismiss="modal">&times;</button>
                <h4 class="modal-title page-header">รายละเอียดงานแจ้งซ่อม</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="input-group w3-margin-bottom"><span class="input-group-addon">เลขที่เอกสาร</span>
                            <input class='form-control' type="text" id='order_code' name='order_code' value="" readonly>
                        </div> 
                    </div>
                    <div class="col-lg-6">
                        <div class="input-group w3-margin-bottom"><span class="input-group-addon">รหัสเครื่อง</span>
                            <input class='form-control' type="text" id='eq_id' name='eq_id' value="" readonly>
                        </div> 
                    </div>
                    <div class="col-lg-12">
                        <div class="input-group w3-margin-bottom"><span class="input-group-addon">เรื่อง</span>
                            <input class='form-control' type="text" id='order_name' name='order_name' value="" readonly>
                        </div> 
                    </div>
                    <div class="col-lg-6">
                        <div class="input-group w3-margin-bottom"><span class="input-group-addon">สถานที่</span>
                            <input class='form-control' type="text" id='location_name' name='location_name' value="" readonly>
                        </div> 
                    </div>
                    <div class="col-lg-6">
                        <div class="input-group w3-margin-bottom"><span class="input-group-addon">หน่วยงาน</span>
                            <input class='form-control' type="text" id='department_name' name='department_name' value="" readonly>
                        </div> 
                    </div>
                    <div class="col-lg-12">
                        <div class="input-group w3-margin-bottom"><span class="input-group-addon">รายละเอียด</span>
                            <textarea class='form-control' type="text" id='order_detail' name='order_detail' readonly></textarea>
                        </div> 
                    </div>
                    <div class="col-lg-6">
                        <div class="input-group w3-margin-bottom"><span class="input-group-addon">วันที่แจ้ง</span>
                            <input class='form-control' type="text" id='order_date' name='order_date' value="" readonly>
                        </div> 
                    </div>
                    <div class="col-lg-6">
                        <div class="input-group w3-margin-bottom"><span class="input-group-addon">สถานะ</span>
                            <input class='form-control' type="text" id='order_status' name='order_status' value="" readonly>
                        </div> 
                    </div>
                    <div class="col-lg-12">
                        <div class="input-group w3-margin-bottom"><span class="input-group-addon">รายละเอียดการดำเนินงาน</span>
                            <textarea class='form-control' type="text" id='work_remark' name='work_remark' readonly></textarea>
                        </div> 
                    </div>
                </div>
            </div>
            <?php
        }
    }
} else {
    
}
?>

