<?php
$page_title = "EQUIPMENT";
if (require_once '../../application.php') {
    
    ?>
    <body>
        <?php require_once '../../nav_bar_menu.php'; if ($_SESSION['LEVEL'] >= 2) {?>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-header">ADD EQUIPMENT</h1>
                </div>
            </div>
            <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                    <form id="add_equipment" name="add_equipment" method="post" action="/RKAPP/TOOL/sql/sql_equipment_data.php" onsubmit="return conf_send_data()">
                        <div class="modal-header">
                            <h3>เพิ่มข้อมูลอุปกรณ์</h3>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid ">
                                <input type="hidden" id='selection' name='selection' value="insert">
                                <div class="row w3-margin-bottom">
                                    <div class="col-md-6">
                                        <div class="input-group"><span class="input-group-addon">ประเภท</span>
                                            <select class='form-control' id='type_code' name='type_code' onchange="" required>
                                                <option value="">เลือกประเภทอุปกรณ์</option>
                                                <?php $qry = select_all_data($rki->conn, $rki->stmanagement, $rki->tbtype, "*", "WHERE T_CODE LIKE 'EQ%' AND STATUS_USE = 1 ORDER BY T_CODE"); ?>
                                                <?php while ($item = sqlsrv_fetch_object($qry)) {?>
                                                <option value="<?=$item->T_CODE?>"><?=$item->T_NAME?></option>
                                                <?php } ?>
                                            </select>
                                        </div> 
                                    </div>
                                </div>
                                <div class="row w3-margin-bottom">
                                    <div class="col-md-6">
                                        <div class="input-group"><span class="input-group-addon">รหัส เครื่อง</span>
                                            <input class='form-control' type="text" id='eq_id' name='eq_id' maxlength="6" placeholder="รหัสอุปกรณ์ หากไม่มีให้เว้นว่าง" onkeyup="to_upper_str('eq_id', this.value)">
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group"><span class="input-group-addon">ชื่อรุ่น อุปกรณ์</span>
                                            <input class='form-control' type="text" id='e_name' name='e_name' maxlength="100" required>
                                        </div> 
                                    </div>
                                </div>
                                <div class="row w3-margin-bottom">
                                    <div class="col-md-6">
                                        <div class="input-group"><span class="input-group-addon">วันที่นำใช้</span>
                                            <input class='form-control' type="date" id='e_come' name='e_come' value="<?=$rki->serverdate?>" required>
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group"><span class="input-group-addon">ระยะเวลารับประกัน</span>
                                            <input class='form-control' type="number" id='e_warranty' name='e_warranty' min="1" max="10" value="1">
                                        </div> 
                                    </div>
                                </div>
                                <div class="row w3-margin-bottom">
                                    <div class="col-md-12">
                                        <div class="input-group"><span class="input-group-addon">ข้อมูลรายละเอียดอุปกรณ์</span>
                                            <textarea class='form-control'rows="4" id='e_detail' name='e_detail' required></textarea>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">SAVE DATA</button>
                            <button type="reset" class="btn btn-danger">CANCEL</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </body>
<?php } } ?>
