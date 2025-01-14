<?php
$page_title = "BACK OFFICE";
$page_sub = "TYPE";
if (require_once '../../application.php') {
    if ($_SESSION['LEVEL'] == 9) {
        ?>
        <body>
            <?php require_once '../../nav_bar_menu.php'; ?>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">ADD TYPE</h1>
                    </div>
                </div>
                <div class="modal-dialog modal-lg">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <form id="add_type" name="add_type" method="post" action="/RKAPP/TOOL/sql/sql_type_data.php" onsubmit="return conf_send_data('')">
                            <div class="modal-header">
                                <h3>เพิ่มข้อมูลประเภท</h3>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid ">
                                    <input type="hidden" id='selection' name='selection' value="insert">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-group"><span class="input-group-addon">รหัส ประเภท</span>
                                                <input class='form-control' id='type_code' name='type_code' onkeyup="to_upper_str('type_code', this.value)" maxlength="6" required>
                                            </div> 
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group"><span class="input-group-addon">ชื่อของ ประเภท</span>
                                                <input class='form-control' id='type_name' name='type_name' onkeyup="" maxlength="100" required>
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
    <?php
    }
} else {
    header("refresh: 0; url=/RKAPP/");
    exit(0);
}
?>

