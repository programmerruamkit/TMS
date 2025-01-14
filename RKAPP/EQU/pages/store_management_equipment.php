<?php
$page_title = "EQUIPMENT";
if (require_once '../../application.php') {
    ?>
<body>
        <?php require_once '../../nav_bar_menu.php';
        if ($_SESSION['LEVEL'] >= 2) {
            ?>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">STORE EQUIPMENT</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="input-group w3-margin-bottom"><span class="input-group-addon">ประเภท</span>
                            <select class='form-control' id='type_code' name='type_code' onchange="search_data('data_display', 'search', this.value, e_code.value, '/RKAPP/EQU/pages/select_management_equipment.php'), search_data('inf_display', '', '', '', '/RKAPP/EQU/pages/select_management_equipment.php')">
                                <option value="">เลือกประเภทอุปกรณ์</option>
                                <?php $qry = select_all_data($rki->conn, $rki->stmanagement, $rki->tbtype, "*", "WHERE T_CODE LIKE 'EQ%' AND STATUS_USE = 1 ORDER BY T_CODE"); ?>
                                <?php while ($item = sqlsrv_fetch_object($qry)) { ?>
                                    <option value="<?= $item->T_CODE ?>"><?= $item->T_NAME ?></option>
                                <?php } ?>
                            </select>
                        </div> 
                    </div>
                    <div class="col-lg-6">
                        <div class="input-group w3-margin-bottom"><span class="input-group-addon">รหัส เครื่อง</span>
                            <input class='form-control' type="text" id='e_code' name='e_code' maxlength="6" placeholder="รหัสอุปกรณ์" onkeyup="search_data('data_display', 'search', type_code.value, this.value, '/RKAPP/EQU/pages/select_management_equipment.php'), search_data('inf_display', '', '', '', '/RKAPP/EQU/pages/select_management_equipment.php')">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div id="data_display">
                        
                    </div>
                </div>
                
                <div class="row">
                    <div class="w3-card" id="inf_display">
                        
                    </div>
                </div>
            </div>
        </body>
    <?php }
}
?>
