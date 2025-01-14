<?php
$page_title = "EQUIPMENT";
if (require_once '../../application.php') {
    ?>
    <body>
        <?php
        require_once '../../nav_bar_menu.php';
        if ($_SESSION['LEVEL'] >= 1) {
            ?>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">DATA EQUIPMENT</h1>
                    </div>
                </div>
                <div class="modal-dialog modal-lg">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-lg-6"><h3>ข้อมูล อุปกรณ์</h3></div>
                                    <div class="col-lg-12">
                                        <?php $qry = select_all_data($rki->conn, $rki->stmanagement, $rki->tbtype, "[T_CODE],[T_NAME]", "WHERE T_CODE LIKE 'EQ%'"); ?>
                                        <div class="dropdown">
                                            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">เลือกประเภท
                                                <span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                                <li><a href="?type=">ทั้งหมด</a></li>
                                                <?php
                                                while ($type_item = sqlsrv_fetch_object($qry)) {
                                                    echo "<li><a href='?type=%$type_item->T_CODE'>$type_item->T_NAME</a></li>";
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td></td> <td>รหัสเครื่อง</td> <td>ชื่ออุปกรณ์</td> <td>วันที่นำเข้า</td> <td>หมดประกัน</td> <td>สถานะ</td>
                                            <?php
                                            if ($_SESSION['LEVEL'] >= 3) {
                                                echo "<td></td>";
                                            }
                                            ?>
                                        </tr>
                                        <?php
                                        if ($_GET['type'] != '') {
                                            $type = $_GET['type'];
                                            $condition = "PARTITION BY [E_TYPE] ORDER BY [E_ID]";
                                        } else {
                                            $type = "%";
                                            $condition = "ORDER BY [E_ID]";
                                        }
                                        if ($_GET['end'] != '') {
                                            $s = $_GET['start'];
                                            $e = $_GET['end'];
                                        } else {
                                            $s = 1;
                                            $e = 10;
                                        }
                                        $i = $s;
                                        $data_row = row_count_number($rki->conn, $rki->stmanagement, $rki->tbequipment, "[E_ID]", "WHERE [E_TYPE] LIKE '$type'");
                                        $para = set_stored_para('SELECT_ROW', $rki->tbequipment, $condition, "$s AND $e AND E_TYPE LIKE '$type' AND STATUS_USE = 1");
                                        $qry_eq = db_query_stored($rki->conn, $rki->stmanagement, $para);
                                        while ($item = sqlsrv_fetch_object($qry_eq)) {
                                            echo "<tr>";
                                            echo "<td class='w3-center'>" . $i++ . "</td>";
                                            echo "<td>" . $item->EQ_ID . "</td>";
                                            echo "<td>" . $item->E_NAME . "</td>";
                                            echo "<td>" . cover_date(format_datetime($item->E_COME, 'date')) . "</td>";
                                            echo "<td>";
                                            if ($rki->serverdate <= format_datetime($item->E_WARRANTY_END, 'date')) {
                                                echo cover_date(format_datetime($item->E_WARRANTY_END, 'date'));
                                            } else {
                                                echo "<span class='w3-text-red'><b>" . cover_date(format_datetime($item->E_WARRANTY_END, 'date')) . "</b></span>";
                                            }
                                            echo "</td>";
                                            echo "<td>" . e_status_name($item->E_STATUS) . "</td>";
                                            if ($_SESSION['LEVEL'] >= 3) {
                                                echo "<td>";
                                                ?> <button class='btn btn-danger' type='button' data-toggle='modal' data-target='#popup_modal' onclick="display_change('modal_display', 'update', <?= $item->E_ID ?>, '/RKAPP/EQU/pages/select_equipment_data.php')"><span class='fa fa-edit'></span></button> <?php
                                                echo "</td>";
                                            }
                                            echo "</tr>";
                                        }
                                        ?>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <div class="row w3-center">
                                <?= page_pagination($data_row, 10, $type) ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </body>
        <?php
    }
}
?>
