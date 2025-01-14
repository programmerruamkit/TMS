<?php
$page_title = "BACK OFFICE";
if (require_once '../application.php') {
    if ($_SESSION['LEVEL'] == 9) {
        ?>

        <body>
            <?php require_once '../nav_bar_menu.php'; ?>

            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">ADMIN APPLICATION</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        $qry = select_data($rki->conn, $rki->tbapplication, 'A_STATUS = 0');
                        while ($bag = sqlsrv_fetch_object($qry)) {
                            ?>
                            <div class="col-lg-4">
                                <div class='panel w3-border-black'>
                                    <div class='panel-heading'>
                                        <div class="row">
                                            <div class='col-xs-3'>
                                                <i class='fa fa-window-maximize fa-5x'></i>
                                            </div>
                                            <div class='col-xs-9 text-right'>
                                                <div><h2><?= $bag->A_NAMEE; ?></h2></div>
                                                <div><h5><?= $bag->A_NAMET; ?></h5></div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="<?= $bag->A_PARTAPP ?>">
                                        <div class='panel-footer w3-border-black w3-gray w3-hover-sand'>
                                            <span class='pull-left'>+</span>
                                            <span class='pull-right'>Go To App <i class='fa fa-arrow-circle-right'></i></span>
                                            <div class='clearfix'></div>
                                        </div>
                                    </a>
                                </div>
                            </div>                    
                        <?php } ?>
                    </div>
                </div>
            </div>
        </body>

    <?php
    } else {
        echo '<script type="text/javascript">window.alert("สิทธิ์ในการใช้งานของ User ไม่สามารถใช้งานโปรแกรมนี้ได้");</script>';
        header("refresh: 1; url=/RKAPP/");
        exit(0);
    }
}
?>