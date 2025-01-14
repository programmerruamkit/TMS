<?php
$page_title = "BACK OFFICE";
$page_sub = "TYPE";
if (require_once '../../application.php') {
    if ($_SESSION['LEVEL'] >= 2) {
        ?>
        <body onload="display_change('type_display', 'select', '%', '/RKAPP/BACKOFFICE/TYPE/select_type_code.php')">
            <?php require_once '../../nav_bar_menu.php'; ?>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12"><h1 class="page-header">DATA TYPE</h1></div>
                    </div>
                </div>
                <div class="modal-dialog modal-lg">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-6"><h3>ข้อมูล ประเภท</h3></div>
                                    <div class="col-md-12">
                                        <div class="input-group w3-margin-bottom"><span class="input-group-addon">ประเภท</span>
                                            <select class='form-control' id='' name='' onchange="display_change('type_display', 'select', this.value, '/RKAPP/BACKOFFICE/TYPE/select_type_code.php')">
                                                <option value='%'>ทั้งหมด</option>
                                                <option value='EQ%'>อุปกรณ์ IT</option>
                                                <option value='IT%'>งาน IT</option>
                                            </select>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-body" id="type_display">

                        </div>

                        <div class="modal-footer">
                            <div class="row">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
        <?php
    }
} else {
    header("refresh: 0; url=/RKAPP/");
    exit(0);
}
?>