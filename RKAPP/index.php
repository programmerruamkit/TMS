<?php
$page_title = "RUAMKIT APPLICATION";
if (require_once '/application.php') {
    ?>

    <body>
        <?php require_once '/nav_bar_menu.php'; ?>

        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">RUAMKIT APPLICATION</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">

                    <?php if ($_SESSION['LEVEL'] >= 1) { ?>
                        <div class="col-lg-4">
                            <div class='panel w3-border-black'>
                                <div class='panel-heading'>
                                    <div class="row">
                                        <div class='col-xs-3'>
                                            <i class='fa fa-window-maximize fa-5x'></i>
                                        </div>
                                        <div class='col-xs-9 text-right'>
                                            <div><h2>ITR</h2></div>
                                            <div><h5>โปรแกรมแจ้งซ่อมอุปกรณ์ไอที</h5></div>
                                        </div>
                                    </div>
                                </div>
                                <a href="<?= $rki->appitr ?>">
                                    <div class='panel-footer w3-border-black w3-gray w3-hover-sand'>
                                        <span class='pull-left'>+</span>
                                        <span class='pull-right'>Go To App <i class='fa fa-arrow-circle-right'></i></span>
                                        <div class='clearfix'></div>
                                    </div>
                                </a>
                            </div>
                        </div>  
                    <?php } ?>

                    <?php if ($_SESSION['LEVEL'] >= 2 && ($_SESSION['POSITION_TYPE'] == "IT" || $_SESSION['POSITION_TYPE'] == "ADMIN")) { ?>
                        <div class="col-lg-4">
                            <div class='panel w3-border-black'>
                                <div class='panel-heading'>
                                    <div class="row">
                                        <div class='col-xs-3'>
                                            <i class='fa fa-window-maximize fa-5x'></i>
                                        </div>
                                        <div class='col-xs-9 text-right'>
                                            <div><h2>ITM</h2></div>
                                            <div><h5>โปรแกรมจัดการข้อมูลฝ่ายไอที</h5></div>
                                        </div>
                                    </div>
                                </div>
                                <a href="<?= $rki->appitm ?>">
                                    <div class='panel-footer w3-border-black w3-gray w3-hover-sand'>
                                        <span class='pull-left'>+</span>
                                        <span class='pull-right'>Go To App <i class='fa fa-arrow-circle-right'></i></span>
                                        <div class='clearfix'></div>
                                    </div>
                                </a>
                            </div>
                        </div>  
                    <?php } ?>

                    <?php if ($_SESSION['LEVEL'] >= 2 && ($_SESSION['POSITION_TYPE'] == "IT" || $_SESSION['POSITION_TYPE'] == "ADMIN")) { ?>
                        <div class="col-lg-4">
                            <div class='panel w3-border-black'>
                                <div class='panel-heading'>
                                    <div class="row">
                                        <div class='col-xs-3'>
                                            <i class='fa fa-window-maximize fa-5x'></i>
                                        </div>
                                        <div class='col-xs-9 text-right'>
                                            <div><h2>EQU</h2></div>
                                            <div><h5>โปรแกรมจัดการอุปกรณ์</h5></div>
                                        </div>
                                    </div>
                                </div>
                                <a href="<?= $rki->appequ ?>">
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

<?php } ?>