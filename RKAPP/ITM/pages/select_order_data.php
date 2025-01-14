<?php
$page_title = "IT MANAGEMENT";
if (require_once '../../application.php') {
    if ($_SESSION['LEVEL'] >= 2) {
        if ($_GET['selection'] == 'select') {
            $type_code = $_GET['type'];
            $condition = "WHERE (ORDER_TYPE LIKE '%$type_code') AND STATUS_USE = 1 AND ORDER_STATUS = 0 ORDER BY ORDER_DATE";
            $qry = select_all_data($rki->conn, $rki->stmanagement, $rki->tborder, "*", $condition);
            ?>
            <table class="table">
                <tr>
                    <td>เลขที่เครื่อง</td> <td>หัวข้อแจ้ง</td> <td>วันที่แจ้ง</td> <td>สถานะ</td> <td>สถานที่</td> <td>หน่วยงาน</td> <td>บริษัท</td> <td>ผู้ร้องขอ</td>
                </tr>
                <?php
                while ($item = sqlsrv_fetch_object($qry)) {
                    ?>
                    <tr>
                        <td><?= $item->EQ_ID ?></td> <td><?= $item->ORDER_NAME ?></td> <td><?= cover_date(format_datetime($item->ORDER_DATE, 'date')) ?></td> 
                        <td><?= order_status_name($item->ORDER_STATUS) ?></td> 
                        <td><?= $item->LOCATION_NAME ?></td> <td><?= $item->DEPARTMENT_NAME ?></td> <td><?= select_once_data($rki->conn, $rki->stmanagement, $rki->tbcompany, "C_NAME_T", "WHERE C_ID = '$item->COMPANY_ID'") ?></td>
                        <td><?= select_once_data($rki->conn, $rki->stmanagement, $rki->tbperson, "P_FNAME", "WHERE P_ID = '$item->ADD_BY'"); ?></td>
                        <td class="w3-center"><button type="button" class="btn btn-info" data-toggle='modal' data-target='#popup_modal' onclick="display_change('modal_display', 'detail', <?= $item->ORDER_ID ?>, '/RKAPP/ITM/pages/select_order_data.php')"><span class="fa fa-file-o"></span></button></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <?php
        } else if ($_GET['type'] == 'detail') {
            $o_id = $_GET['data'];
            $qry = select_all_data($rki->conn, $rki->stmanagement, $rki->tborder, "*", "WHERE ORDER_ID = $o_id");
            $item = sqlsrv_fetch_object($qry);
            ?>
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
                <button type="button" class="btn btn-info" data-target='#popup_modal' onclick="display_change('modal_display', 'open', <?= $item->ORDER_ID ?>, '/RKAPP/ITM/pages/select_order_data.php')"><span class="fa fa-file-o"> ดำเนินงาน</span></button>
                <button type="button" class="btn btn-danger" data-target='#popup_modal' onclick="display_change('modal_display', 'del', <?= $item->ORDER_ID ?>, '/RKAPP/ITM/pages/select_order_data.php')"><span class="fa fa-file-o"> ยกเลิกงาน</span></button>
            </div>
            <?php
        } else if ($_GET['type'] == 'del') {
            $o_id = $_GET['data'];
            $qry = select_all_data($rki->conn, $rki->stmanagement, $rki->tborder, "*", "WHERE ORDER_ID = $o_id");
            $item = sqlsrv_fetch_object($qry);
            ?>
            <form id="del_order" name="del_order" method="post" action="/RKAPP/TOOL/sql/sql_itm_data.php" onsubmit="return conf_send_data('del')">
                <div class="modal-header">
                    <button type="button" class="close w3-red" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title page-header">ยกเลิกงานแจ้งซ่อม</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="input-group w3-margin-bottom"><span class="input-group-addon">สาเหตุที่ยกเลิก</span>
                                <textarea class='form-control' rows="4" id="work_remark" name="work_remark" required></textarea>
                            </div>  
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id='selection' name='selection' value="del">
                    <input type="hidden" id='order_id' name='order_id' value="<?= $item->ORDER_ID ?>">
                    <input type="hidden" id='eq_id' name='eq_id' value="<?= $item->EQ_ID ?>">
                    <button type="submit" class="btn btn-danger" ><span class="fa fa-trash-o"></span></button>
                </div>
            </form>
            <?php
        } else if ($_GET['type'] == 'open') {
            $o_id = $_GET['data'];
            $qry = select_all_data($rki->conn, $rki->stmanagement, $rki->tborder, "*", "WHERE ORDER_ID = $o_id");
            $item = sqlsrv_fetch_object($qry);
            ?>
            <form id="add_work" name="add_work" method="post" action="/RKAPP/TOOL/sql/sql_itm_data.php" onsubmit="return conf_send_data()">
                <div class="modal-header">
                    <button type="button" class="close w3-red" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title page-header">รับคำร้องงานแจ้งซ่อม</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <?php if ($_SESSION['LEVEL'] >= 4) { ?>
                            <div class="col-lg-12">
                                <div class="input-group w3-margin-bottom"><span class="input-group-addon">ผู้ดำเนินงาน</span>
                                    <select class='form-control' type="text" id='add_by' name='add_by' required>
                                        <option value="">เลือกพนักงานที่ต้องการมอบงาน</option>
                                        <?php get_user_it_name($rki->conn, $rki->stmanagement); ?>
                                    </select>
                                </div> 
                            </div>
                        <?php } else { ?>
                            <div class="col-lg-12">
                                <div class="input-group w3-margin-bottom"><span class="input-group-addon">ผู้ดำเนินงาน</span>
                                    <select class='form-control' type="text" id='add_by' name='add_by'>
                                        <option value="<?=$_SESSION['PERSON_ID'];?>"><?=$_SESSION['PERSON_NAME'];?> <?=$_SESSION['PERSON_LNAME'];?></option>
                                    </select>
                                </div> 
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id='selection' name='selection' value="insert">
                    <input type="hidden" id='order_id' name='order_id' value="<?= $item->ORDER_ID ?>">
                    <input type="hidden" id='eq_id' name='eq_id' value="<?= $item->EQ_ID ?>">
                    <button type="submit" class="btn btn-success" ><span class="fa fa-pencil"> ดำเนินงาน</span></button>
                </div>
            </form>
            <?php
        }
    }
}
?>
