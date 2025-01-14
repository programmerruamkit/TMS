<?php
$page_title = "REGISTER";
if (require_once '../../application.php') {
    if ($_SESSION['LEVEL'] == 9) {
        ?>
        <body>
            <?php require_once '../../nav_bar_menu.php'; ?>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">REGISTER</h1>
                    </div>
                </div>

                <div class="container-fluid ">
                        <div class="row">
                            <input type="hidden" id='selection' name='selection' value="insert">
                            <div class="col-lg-6">
                                <div class="input-group"><span class="input-group-addon">ค้นหาพนักงาน</span>
                                    <input type="text" class="form-control" placeholder="Search" id="search" name="search">
                                    <div class="input-group-btn">
                                        <button class="btn btn-info" type="button" onclick="display_change('data_display', 'search', search.value, '/RKAPP/LOGIN/register/select_person_data.php')">
                                            <i class="glyphicon glyphicon-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="modal-body" id="data_display">
                            </div>
                        </div>
                        <div class="row modal-footer">
                        </div>
                </div>

            </div>
        </body>
        <?php
    } else {
        echo '<script type="text/javascript">window.alert("สิทธิ์ไม่ได้รับอนุญาตให้ใช้งาน!!!");</script>';
        header("refresh: 0; url=/RKAPP/");
        exit(0);
    }
} else {
    header("refresh: 0; url=/RKAPP/");
    exit(0);
}
?>

