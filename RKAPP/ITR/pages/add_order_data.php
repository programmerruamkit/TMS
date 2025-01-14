<?php
$page_title = "IT REQUIREMENT";
if (require_once '../../application.php') {
    ?>
    <body>

        <div id="wrapper">
            <?php require_once '../../nav_bar_menu.php'; ?>
            
            <div class=" panel panel-yellow" id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">ADD ORDER แจ้งงานซ่อม</h1>
                    </div>
                </div>
                <form id="add_order" name="add_order" method="post" enctype="multipart/form-data" action="/RKAPP/TOOL/sql/sql_order_data.php" onsubmit="return conf_send_data()">
                    <div class="row">

                        <input type="hidden" id='selection' name='selection' value="insert">
                        <div class="col-lg-6">
                            <div class="input-group w3-margin-bottom"><span class="input-group-addon">แจ้งงาน</span>
                                <select class='form-control' id='type_code' name='type_code' required>
                                    <?php echo $itemlist = select_head_type($rki->conn, 'it'); ?>
                                </select>
                            </div> 
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group w3-margin-bottom"><span class="input-group-addon">รหัส เครื่อง</span>
                                <input class='form-control' type="text" list='eq_id' name='eq_id' maxlength="6" required>
                            </div> 
                        </div>
                        <div class="col-lg-12">
                            <div class="input-group w3-margin-bottom"><span class="input-group-addon">บริษัท</span>
                                <?php $qry = select_all_data($rki->conn, $rki->stmanagement, $rki->tbcompany, '*', 'WHERE STATUS_USE = 1 ORDER BY C_CODE'); ?>
                                <select class='form-control' id='c_id' name='c_id' required>
                                    <option value="">เลือกบริษัท</option>
                                    <?php while ($bag = sqlsrv_fetch_object($qry)) { ?>
                                        <option value="<?= $bag->C_ID ?>"><span>[<?= $bag->C_CODE ?>]</span></span> <?= $bag->C_NAME_T ?></option>
                                    <?php } ?>
                                </select>
                            </div> 
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group w3-margin-bottom"><span class="input-group-addon">สถานที่</span>
                                <input class='form-control' type="text" id='location_name' name='location_name' maxlength="50" required>
                            </div> 
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group w3-margin-bottom"><span class="input-group-addon">หน่วยงาน</span>
                                <input class='form-control' type="text" id='department_name' name='department_name' maxlength="50" required>
                            </div> 
                        </div>
                        <div class="col-lg-12">
                            <div class="input-group w3-margin-bottom"><span class="input-group-addon">รายละเอียด</span>
                                <textarea class='form-control' type="text" rows="3" id='order_detail' name='order_detail' required></textarea>
                            </div> 
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group"><span class="input-group-addon">รูปภาพประกอบ</span>
                                <input class='form-control' type="file" name="order_file" id="order_file" maxlength="100" accept=".png, .jpg, .jpeg">
                            </div> 
                        </div>

                    </div>

                    <div class="row w3-margin-top">
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" data-dismiss="modal"><span class="fa fa-save"></span> Save</button>
                            <button type="reset" class="btn btn-danger">CANCEL</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        <datalist id="eq_id">
            <?php echo $datalist = select_data_list($rki->conn, "EQ_ID", $rki->tbequipment, ''); ?>
        </datalist>
    </body>
    <?php
}
?>