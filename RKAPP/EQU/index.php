<?php
$page_title = "EQUIPMENT";
if (require_once '../application.php') {
    ?>
    <body>
        <?php require_once '../nav_bar_menu.php'; ?>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-header">EQUIPMENT APPLICATION</h1>
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
                                            <div><h2>Data</h2></div>
                                            <div><h5>ข้อมูลอุปกรณ์</h5></div>
                                        </div>
                                    </div>
                                </div>
                                <a href="/RKAPP/EQU/pages/show_equipment_data.php">
                                    <div class='panel-footer w3-border-black w3-gray w3-hover-sand'>
                                        <span class='pull-left'>+</span>
                                        <span class='pull-right'>Go To App <i class='fa fa-arrow-circle-right'></i></span>
                                        <div class='clearfix'></div>
                                    </div>
                                </a>
                            </div>
                        </div>  
                    <?php } ?>
                    <?php if ($_SESSION['LEVEL'] >= 2) { ?>
                        <div class="col-lg-4">
                            <div class='panel w3-border-black'>
                                <div class='panel-heading'>
                                    <div class="row">
                                        <div class='col-xs-3'>
                                            <i class='fa fa-window-maximize fa-5x'></i>
                                        </div>
                                        <div class='col-xs-9 text-right'>
                                            <div><h2>Add</h2></div>
                                            <div><h5>เพิ่มข้อมูลอุปกรณ์</h5></div>
                                        </div>
                                    </div>
                                </div>
                                <a href="/RKAPP/EQU/pages/add_equipment_data.php">
                                    <div class='panel-footer w3-border-black w3-gray w3-hover-sand'>
                                        <span class='pull-left'>+</span>
                                        <span class='pull-right'>Go To App <i class='fa fa-arrow-circle-right'></i></span>
                                        <div class='clearfix'></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($_SESSION['LEVEL'] >= 3) { ?>
                        <div class="col-lg-4">
                            <div class='panel w3-border-black'>
                                <div class='panel-heading'>
                                    <div class="row">
                                        <div class='col-xs-3'>
                                            <i class='fa fa-window-maximize fa-5x'></i>
                                        </div>
                                        <div class='col-xs-9 text-right'>
                                            <div><h2>Edit</h2></div>
                                            <div><h5>แก้ไขข้อมูลอุปกรณ์</h5></div>
                                        </div>
                                    </div>
                                </div>
                                <a href="/RKAPP/EQU/pages/edit_equipment_data.php">
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