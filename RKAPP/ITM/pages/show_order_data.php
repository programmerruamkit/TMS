<?php
$page_title = "IT MANAGEMENT";
if (require_once '../../application.php') {
    if ($_SESSION['LEVEL'] >= 2) {
        ?>
        <body onload="search_data('data_display', 'select', '', '', '/RKAPP/ITM/pages/select_order_data.php')">
            <?php require_once '../../nav_bar_menu.php'; ?>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">ORDER REQUIRED</h1>
                    </div>
                </div>
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group w3-margin-bottom"><span class="input-group-addon">ประเภทงาน</span>
                                <select class='form-control' id="type_code" name="type_code" onchange="search_data('data_display', 'select', this.value, '0', '/RKAPP/ITM/pages/select_order_data.php')">
                                    <?php echo $itemlist = select_head_type($rki->conn, 'it'); ?>
                                </select>
                            </div> 
                        </div>
                    </div>

                    <div class="row">
                        <div id="data_display"></div>
                    </div>

                    <div class="row">
                        <div id="inf_display"></div>
                    </div>

                </div>
            </div>
        </body>
        <?php
    } else {
        echo '<script type="text/javascript">window.alert("สิทธิ์ไม่ได้รับอนุญาตให้ใช้งาน!!!");</script>';
        header("refresh: 0; url=/RKAPP/ITM/");
        exit(0);
    }
}
?>