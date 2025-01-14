<?php $title_page = "Request"; ?>

<?php if (require_once '../master.php') { ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Request</h1>
                        </div>

                        <!-- Content Row -->
                        <div class="row">

                            <div class="col-xl-12 col-lg-12">
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Dropdown -->
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-dark">
                                        <h6 class="m-0 font-weight-bold text-light">Add Request</h6>
                                        <div class="dropdown no-arrow">
                                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                                <div class="dropdown-header">Head Menu:</div>
                                                <a class="dropdown-item" href="#">Menu 1</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#">Menu 2</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <div class="container-fluid">

                                            <form name="order" method="POST" enctype="multipart/form-data" action="<?= $oop->sql ?>" onsubmit="return conf_send_data()">
                                                <input type="hidden" name="select_type" value="Request">
                                                <input type="hidden" name="sub_type" value="Add">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">แจ้งงาน</span>
                                                            </div>
                                                            <?php $qry = select_all_data($oop->rkadb, $oop->sp1, $oop->tbtype, '[TYPE_CODE],[TYPE_NAME]', "WHERE [ITEM_STATUS] = 1 AND [TYPE_CODE] LIKE 'IT%' ORDER BY [TYPE_CODE]"); ?>
                                                            <select class='form-control' name='order_type' required>
                                                                <option value="">เลือกหัวข้อ</option>
                                                                <?php while ($bag = sqlsrv_fetch_object($qry)) { ?>
                                                                    <option value="<?= $bag->TYPE_CODE ?>">[<?= $bag->TYPE_NAME ?>]</option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div> 
                                                    <div class="col-lg-6">
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">บริษัท</span>
                                                            </div>
                                                            <?php $qry = select_all_data($oop->rkadb, $oop->sp1, $oop->tbcompany, '[C_ID],[C_CODE],[C_NAME_T]', 'WHERE STATUS_USE = 1 ORDER BY C_CODE'); ?>
                                                            <select class='form-control' name='order_company' required>
                                                                <option value="">เลือกบริษัท</option>
                                                                <?php while ($bag = sqlsrv_fetch_object($qry)) { ?>
                                                                    <option value="<?= $bag->C_ID ?>" <?php
                                                                    if ($_COOKIE['RK_USER_COM'] == $bag->C_ID) {
                                                                        echo 'selected';
                                                                    }
                                                                    ?>>[<?= $bag->C_CODE ?>] <?= $bag->C_NAME_T ?></option>
                                                                        <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">เลขอุปกรณ์</span>
                                                            </div>
                                                            <input class='form-control' type="text" id="order_eq" name='order_eq' placeholder="..." onkeyup="get_location_data(this.value), get_dept_data(this.value)" maxlength="10" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6" id="data_location">
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">สถานที่</span>
                                                            </div>
                                                            <input class='form-control' type="text" name='order_location' placeholder="..." maxlength="50" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6" id="data_dept">
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">หน่วยงาน</span>
                                                            </div>
                                                            <input class='form-control' type="text" id="order_dept" name='order_dept' placeholder="..." maxlength="50" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">รายละเอียด</span>
                                                            </div>
                                                            <textarea class="form-control" rows="5" name="order_detail" placeholder="..." required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">รูปอุปกรณ์</span>
                                                            </div>
                                                            <input class="form-control" type="file" name="order_file" accept=".png, .jpg, .jpeg">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <button type="submit" class="btn btn-success btn-block">SAVE</button> 
                                                        <button type="reset" class="btn btn-danger btn-block">CANCEL</button> 
                                                    </div>
                                                </div>
                                            </form>

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
        
        <script>
            function get_location_data(data) {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("data_location").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "/app/sql/page_ajax.php?type=ajax&sub_type=location&data=" + data, false);
                xmlhttp.send();
            }
            function get_dept_data(data) {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("data_dept").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "/app/sql/page_ajax.php?type=ajax&sub_type=dept&data=" + data, false);
                xmlhttp.send();
            }
        </script>
        
    </body>
    </html>
    <?php
} else {
    header("refresh: 0; url=$oop->apphome/page_error.php");
    exit(0);
}
?>