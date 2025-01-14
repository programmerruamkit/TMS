<?php
$page_title = "IT REQUIREMENT";
if (require_once '../application.php') {
    ?>
    <body>
        <div id="wrapper">
            <?php require_once '../nav_bar_menu.php'; ?>
            <div class="container ">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">IT REQUIREMENT</h1>
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
                                                <div><h2>Order</h2></div>
                                                <div><h5>แจ้งซ่อม</h5></div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="/RKAPP/ITR/pages/add_order_data.php">
                                        <div class='panel-footer w3-border-black w3-gray w3-hover-sand'>
                                            <span class='pull-left'>+</span>
                                            <span class='pull-right'>Go To App <i class='fa fa-arrow-circle-right'></i></span>
                                            <div class='clearfix'></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class='panel w3-border-black'>
                                    <div class='panel-heading'>
                                        <div class="row">
                                            <div class='col-xs-3'>
                                                <i class='fa fa-window-maximize fa-5x'></i>
                                            </div>
                                            <div class='col-xs-9 text-right'>
                                                <div><h2>Requirement</h2></div>
                                                <div><h5>งานแจ้งซ่อม</h5></div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="/RKAPP/ITR/pages/show_order_data.php">
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
        </div>
  
    </body>
    <?php
}
?>

