<?php
$page_title = "IT REQUIREMENT";
if (require_once '../../application.php') {
    if ($_GET['type'] == 'detail') {
        $o_id = $_GET['data'];
        $qry = select_all_data($rki->conn, $rki->stmanagement, $rki->tborder, "*", "WHERE ORDER_ID = $o_id");
        $item = sqlsrv_fetch_object($qry);
        ?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">รายละเอียดงานแจ้งซ่อม</h4>
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
                        <input class='form-control' type="text" id='order_status' name='order_status' value="<?= order_status_name($item->ORDER_STATUS) ?>" readonly>
                    </div> 
                </div>
                <div class="col-lg-6">
                    <div class="input-group w3-margin-bottom"><span class="input-group-addon">รูปภาพแนบ</span>
                        <form id="open_pic" name="open_pic" method="post" action="<?=$rki->appitr."/pages/show_pic.php"?>" target="_blank">
                        <input type="hidden" id="order_pic" name="order_pic" value="<?=$rki->file."/ITRORDER/".$item->ORDER_PIC?>">
                        <button type="submit" class="btn btn-info" ><span class="fa fa-search"></span></button>
                        </form>
                    </div> 
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <?php if ($item->ORDER_STATUS == 0) { ?>
                <form id="add_order" name="add_order" method="post" action="/RKAPP/TOOL/sql/sql_order_data.php" onsubmit="return conf_send_data('del')">
                    <input type="hidden" id='selection' name='selection' value="del">
                    <input type="hidden" id='order_id' name='order_id' value="<?= $item->ORDER_ID ?>">
                    <button type="submit" class="btn btn-danger" ><span class="fa fa-trash-o"></span></button>
                </form>
                <hr>
            <?php } ?>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        <?php
    }
}
?>

