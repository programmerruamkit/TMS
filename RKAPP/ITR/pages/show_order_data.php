<?php
$page_title = "IT REQUIREMENT";
if (require_once '../../application.php') {
    ?>
    <body>
        <div id="wrapper">
            <?php require_once '../../nav_bar_menu.php'; ?>

            <div class="panel panel-yellow" id="page-wrapper">

                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">ORDER งานที่แจ้งซ่อม</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="panel-body">
                        <table class="table table-striped table-bordered table-hover" id="table_display">
                            <thead>
                                <tr>
                                    <td>รหัสเครื่อง</td> <td>แจ้งซ่อม</td> <td>วันที่แจ้ง</td> <td>สถานะ</td> <td></td>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $uid = $_SESSION['PERSON_ID']; ?>
                            <?php $qry = select_all_data($rki->conn, $rki->stmanagement, $rki->tborder, '*', "WHERE STATUS_USE = 1 AND ADD_BY = '$uid'"); ?>
                            <?php while ($item = sqlsrv_fetch_object($qry)) { ?>   
                                    <tr>
                                        <td><?= $item->EQ_ID ?></td> <td><?= $item->ORDER_NAME ?></td> <td><?= cover_date(format_datetime($item->ORDER_DATE, 'date')) ?></td> <td><?= order_status_name($item->ORDER_STATUS) ?></td> 
                                        <td class="w3-center"><button type="button" class="btn btn-info" data-toggle='modal' data-target='#popup_modal' onclick="display_change('modal_display', 'detail', <?= $item->ORDER_ID ?>, '/RKAPP/ITR/pages/select_order_data.php')"><span class="fa fa-file-o"></span></button></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <script>
            $(document).ready(function () {
                $('#table_display').DataTable({
                    responsive: true
                });
            });
        </script>
    </body>
    <?php
}
?>