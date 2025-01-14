<?php $title_page = "Equipment"; ?>

<?php
if (require_once '../master.php') {
    if ($_COOKIE['RK_USER_TYPE'] == 'IT' || $_COOKIE['RK_USER_TYPE'] == 'ADMIN') {
        ?>
        <body id="page-top">

            <!-- Page Wrapper -->
            <div id="wrapper">

                <?php require_once '../menu_bar.php'; ?>

                <!-- Content Wrapper -->
                <div id="content-wrapper" class="d-flex flex-column">

                    <!-- Main Content -->
                    <div id="content">

                        <?php require_once '../top_bar.php'; ?>

                        <!-- Begin Page Content -->
                        <div class="container-fluid">

                            <!-- Page Heading -->
                            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                                <h1 class="h3 mb-0 text-gray-800">Equipment</h1>
                            </div>

                            <?php $para_type = set_stored_para("SELECT", $oop->tbtype, "[TYPE_CODE],[TYPE_NAME]", "WHERE [ITEM_STATUS] = 1 AND [TYPE_CODE] LIKE 'EQ%' ORDER BY [TYPE_CODE]"); ?>
                            <?php $qry_type = db_query_stored($oop->rkadb, $oop->sp1, $para_type); ?>

                            <div class="row">

                                <div class="col-xl-12 col-lg-12">
                                    <div class="card shadow mb-4">
                                        <!-- Card Header - Dropdown -->
                                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-dark">
                                            <h6 class="m-0 font-weight-bold text-light">Display Data Head</h6>
                                            <div class="dropdown no-arrow">
                                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                                    <div class="dropdown-header">Head Menu:</div>
                                                    <a class="dropdown-item" href="#">Menu 1</a>
                                                    <a class="dropdown-item" href="#">Menu 2</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="#CollapseName" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="CollapseName">Hide/Show</a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="collapse show" id="CollapseName">
                                            <!-- Card Body -->
                                            <div class="card-body">

                                                <div class="col-lg-6">
                                                    <form method="POST" enctype="multipart/form-data" action="<?= $oop->appequipment . "/frm_search_equipment.php" ?>">
                                                        <input type="hidden" name="search_data_by" value="dayly">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">ประเภทอุปกรณ์</span>
                                                            </div>
                                                            <select name="search_type" class="form-control">
                                                                <option value="">ทุกประเภท</option>
                                                                <?php while ($item = sqlsrv_fetch_object($qry_type)) { ?> 
                                                                    <option value="<?= $item->TYPE_CODE ?>"><?= $item->TYPE_NAME ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <div class="input-group-append">
                                                                <button class="btn btn-success" type="submit">
                                                                    <i class="fas fa-search fa-sm"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <br>
                                                <?php
                                                if ($_POST['search_type'] != '') {
                                                    $type = $_POST['search_type'];
                                                    $condition = "WHERE [ITEM_STATUS] = 1 AND [E_TYPE] = '$type' ORDER BY [E_CODE]";
                                                } else {
                                                    $condition = "WHERE [ITEM_STATUS] = 1 ORDER BY [E_CODE]";
                                                }
                                                ?>

                                                <?php $para = set_stored_para("SELECT", $oop->tbequipment, "*", $condition); ?>
                                                <?php $qry = db_query_stored($oop->rkadb, $oop->sp1, $para); ?>
                                                <?php $n = 1; ?>

                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                        <thead class="bg-dark text-light">
                                                            <tr>
                                                                <td>#</td> <td>เลขอุปกรณ์</td> <td>ชื่อรุ่น</td> <td>IP Address</td> <td>ประกัน</td> <td>สถานะ</td> <td>รูป</td>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php while ($item = sqlsrv_fetch_object($qry)) { ?> 
                                                                <tr>
                                                                    <td><?= $n++; ?></td> 
                                                                    <td><?= $item->E_CODE; ?></td> 
                                                                    <td><?= $item->E_NAME; ?></td> 
                                                                    <td><?= $item->IP_ADDRESS; ?></td> 
                                                                    <td class="text-center"><?php
                                                                        if ($oop->serverdate <= format_datetime($item->WARANTY_END, 'date')) {
                                                                            echo cover_date(format_datetime($item->WARANTY_END, 'date'));
                                                                        } else {
                                                                            echo "<span class='text-danger'><b>WARANTY END</b></span>";
                                                                        }
                                                                        ?></td>
                                                                    <td><?= equipment_status_name($item->E_STATUS); ?></td>
                                                                    <td class="text-center"><a href="<?=$oop->file."/equipment/".$item->E_PIC?>" class="btn btn-defalut" target="_blank"><i class='fas fa-file-image'></i></a></td> 
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>

                                                    </table>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>

                            </div>

                            <!-- Content Row -->
                        </div>

                        <!-- /.container-fluid -->
                    </div>
                    <!-- End of Main Content -->

                </div>
                <!-- End of Content Wrapper -->

            </div>
            <!-- End of Page Wrapper -->

            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>

        </body>
        </html>
        <?php
    } else {
        header("refresh: 0; url=/app/page_error.php");
        exit(0);
    }
}
?>