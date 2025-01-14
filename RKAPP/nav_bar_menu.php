<?php if ($page_title != "Login") { ?>
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top panel panel-yellow" role="navigation" style="margin-bottom: 0">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand w3-hover-amber navbar-brand w3-yellow" href="<?= $rki->rkapp ?>">RUAMKIT IT</a>
        </div>
        <!-- /.navbar-header -->
        <!--login menu-->
        <ul class="nav navbar-top-links navbar-right">
            <!-- /.dropdown -->
            <?php if ($_SESSION['LOGIN_STATUS'] != '') { ?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <?= $_SESSION['PERSON_NAME']; ?> <?= $_SESSION['PERSON_LNAME']; ?> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <?php if ($_SESSION['LEVEL'] == 9) { ?>
                            <li><a href="<?= $rki->appback ?>"><i class="fa fa-window-maximize fa-fw"></i> Back Office</a></li>
                        <?php } ?>
                        <?php if ($_SESSION['LEVEL'] == 9) { ?>
                            <li><a href="<?= $rki->applogin . "/register/add_person_data.php" ?>"><i class="fa fa-user fa-fw"></i> Register</a></li>
                        <?php } ?>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="<?= $rki->applogin . "/pages/check_logout.php" ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
            <?php } ?>
            <li><a>วันที่ <?= cover_date($rki->serverdate); ?></a></li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->

        <?php if ($page_title != "RUAMKIT APPLICATION") { ?>
            <div class="navbar-default sidebar " role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">

                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <?php if ($page_title == "IT REQUIREMENT" && $_SESSION['LEVEL'] >= 1) { ?>
                            <li><a href="<?= $rki->appitr ?>"><i class="fa fa-home  fa-fw"></i> HOME</a></li> 
                            <li>
                                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> REQUIREMENT<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li><a href="<?= $rki->appitr . "/pages/show_order_data.php" ?>">สถานะงานแจ้ง</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> #<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li><a href="#">#</a></li>
                                    <li><a href="#">#</a></li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                        <?php } ?>
                        <?php if ($page_title == "IT MANAGEMENT") { ?>
                            <li><a href="<?= $rki->appitm ?>"><i class="fa fa-home  fa-fw"></i> HOME</a></li> 
                            <li>
                                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> MAINTENANCE<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li><a href="<?= $rki->appitm . "/pages/show_order_data.php" ?>">งานแจ้งซ่อม</a></li>
                                    <li><a href="<?= $rki->appitm . "/pages/show_work_data.php" ?>">านที่ดำเนินการ</a></li>
                                    <li><a href="<?= $rki->appitm . "/pages/report_work_data.php" ?>">รายงาน</a></li>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php if ($page_title == "EQUIPMENT") { ?>
                            <li><a href="<?= $rki->appequ ?>"><i class="fa fa-home  fa-fw"></i> HOME</a></li> 
                            <?php if ($_SESSION['LEVEL'] >= 2) { ?>
                                <li>
                                    <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> DATA EQ<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li><a href="<?= $rki->appequ . "/pages/add_equipment_data.php" ?>">เพิ่มข้อมูล</a></li>
                                        <?php if ($_SESSION['LEVEL'] >= 3) { ?>
                                            <li><a href="<?= $rki->appequ . "/pages/edit_equipment_data.php" ?>">จัดการรข้อมูล</a></li>
                                        <?php } ?>
                                        <li><a href="<?= $rki->appequ . "/pages/show_equipment_data.php" ?>">รายงาน</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> STORE<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li><a href="<?= $rki->appequ . "/pages/store_management_equipment.php" ?>">เบิกอุปกรณ์</a></li>
                                        <li><a href="#">#</a></li>
                                        <li><a href="#">#</a></li>
                                    </ul>
                                </li>
                            <?php } ?>
                        <?php } ?>
                        <?php if ($page_title == "REGISTER") { ?>
                            <li><a href="<?= $rki->appitm ?>"><i class="fa fa-home  fa-fw"></i> HOME</a></li> 
                            <li>
                                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> USER-REGIS <span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li><a href="<?= $rki->applogin . "/register/add_person_data.php" ?>">เพิ่มผู้ใช้งาน</a></li>
                                </ul>
                            </li>
                        <?php } ?>
                            <?php if ($page_title == "BACK OFFICE" && $_SESSION['LEVEL'] == 9) { ?>
                            <li><a href="<?= $rki->appback ?>"><i class="fa fa-home  fa-fw"></i> HOME</a></li> 
                            <li>
                                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> TYPE DATA <span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li><a href="<?= $rki->appback . "/TYPE/add_type_data.php" ?>">เพิ่มข้อมูล</a></li>
                                    <li><a href="<?= $rki->appback . "/TYPE/edit_type_data.php" ?>">จัดการข้อมูล</a></li>
                                </ul>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
        <?php } ?>
        <!-- /.navbar-static-side -->
    </nav>
<?php } ?>
