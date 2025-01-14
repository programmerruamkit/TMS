<!-- Sidebar -->
<ul class="navbar-nav bg-dark sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?=$oop->apphome?>">
        <div class="sidebar-brand-icon">
            <i><img src="<?=$oop->apphome."/picture/logo/logo-rk-sm.jpg"?>"></i>
        </div>
        <div class="sidebar-brand-text mx-3">RKAPP<sup>2</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="<?=$oop->apphome?>">
            <i class="fas fa-fw fa-home"></i>
            <span>HOME</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        <?=$title_page?> Menu
    </div>
    <?php if($title_page == 'Index'){ ?>    
    <!-- Nav Item - Charts -->
    
    <li class="nav-item">
        <a class="nav-link" href="<?=$oop->apprequest?>">
            <i class="fas fa-fw fa-edit"></i>
            <span>Request</span></a>
    </li>
    
    <?php if($_COOKIE['RK_USER_TYPE'] == 'IT' || $_COOKIE['RK_USER_TYPE'] == 'ADMIN'){ ?>
    <li class="nav-item">
        <a class="nav-link" href="<?=$oop->appmanagement?>">
            <i class="fas fa-fw fa-cog"></i>
            <span>Management</span></a>
    </li>
    
    <li class="nav-item">
        <a class="nav-link" href="<?=$oop->appequipment?>">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Equipment</span></a>
    </li>
    <?php } ?>
    
    <?php } ?>
    
    <?php if($title_page == 'Request'){ ?>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#request" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-edit"></i>
            <span>Request</span>
        </a>
        <div id="request" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Detail:</h6>
                <a class="collapse-item" href="<?=$oop->apprequest."/index.php?page=Add"?>">แจ้งคำร้อง</a>
                <a class="collapse-item" href="<?=$oop->apprequest."/index.php?page=Edit"?>">ข้อมูลคำร้อง</a>
                <a class="collapse-item" href="<?=$oop->apprequest."/index.php?page=Report"?>">รายงาน</a>
            </div>
        </div>
    </li>
    <?php } ?>
    
    <?php if($title_page == 'Management' && ($_COOKIE['RK_USER_TYPE'] == 'ADMIN' || $_COOKIE['RK_USER_TYPE'] == 'IT')){ ?>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#management" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Management</span>
        </a>
        <div id="management" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Detail:</h6>
                <a class="collapse-item" href="<?=$oop->appmanagement."/index.php?page=Order"?>">คำร้อง</a>
                <a class="collapse-item" href="<?=$oop->appmanagement."/index.php?page=Work"?>">งานที่ดำเนินการ</a>
                <a class="collapse-item" href="<?=$oop->appmanagement."/index.php?page=Report"?>">รายงาน</a>
            </div>
        </div>
    </li>
    <?php } ?>
    
    <?php if($title_page == 'Equipment' && ($_COOKIE['RK_USER_TYPE'] == 'ADMIN' || $_COOKIE['RK_USER_TYPE'] == 'IT')){ ?>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#equipment" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Equipment</span>
        </a>
        <div id="equipment" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Detail:</h6>
                <a class="collapse-item" href="<?=$oop->appequipment."/index.php?page=Data"?>">ข้อมูลอุปกรณ์</a>
                <a class="collapse-item" href="<?=$oop->appequipment."/index.php?page=Manage"?>">จัดการอุปกรณ์</a>
                <a class="collapse-item" href="<?=$oop->appequipment."/index.php?page=Report"?>">รายงาน</a>
            </div>
        </div>
    </li>
    <?php } ?>
    
    <?php if($_COOKIE['RK_USER_LEVEL'] >= 9 && $_COOKIE['RK_USER_TYPE'] == 'ADMIN'){ ?>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#adminmenu" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-sign"></i>
            <span>Admin</span>
        </a>
        <div id="adminmenu" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Detail:</h6>
                <a class="collapse-item" href="<?=$oop->appadmin."/index.php?page=Type"?>">Type Data</a>
                <a class="collapse-item" href="<?=$oop->appadmin."/index.php?page=Regis"?>">Register</a>
            </div>
        </div>
    </li>
    <?php } ?>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

</ul>
<!-- End of Sidebar -->