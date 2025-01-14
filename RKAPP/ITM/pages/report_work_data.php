<?php
$page_title = "IT MANAGEMENT";
if (require_once '../../application.php') {
    if ($_SESSION['LEVEL'] >= 2 AND ( $_SESSION['POSITION_TYPE'] == 'IT' || $_SESSION['POSITION_TYPE'] == 'ADMIN')) {
        ?>
        <body>
            <?php require_once '../../nav_bar_menu.php'; ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">WORK DONE</h1>
                    </div>
                    <div class="col-lg-12">
                        
                    </div>
                    <div class="row">
                        <div class="container-fluid" >
                            <?php
                            if ($_SESSION['LEVEL'] >= 4) {
                                if ($_GET['person_id'] != '') {
                                    $uid = $_GET['person_id'];
                                } else {
                                    $uid = $_SESSION['PERSON_ID'];
                                }
                            } else {
                                $uid = $_SESSION['PERSON_ID'];
                            }
                            if ($_GET['end'] != '') {
                                $s = $_GET['start'];
                                $e = $_GET['end'];
                            } else {
                                $s = 1;
                                $e = 5;
                            }
                            $i = $s - 1;
                            $data_row = row_count_number($rki->conn, $rki->stmanagement, $rki->tbwork, "[WORK_ID]", "WHERE [WORK_BY] = $uid");
                            $para_work = set_stored_para('SELECT_ROW', $rki->tbwork, "PARTITION BY [WORK_BY] ORDER BY [WORK_ID]", "$s AND $e AND [WORK_BY] = $uid");
                            //$para_work = set_stored_para('select', $rki->tbwork, "*", "WHERE WORK_BY = $uid");
                            $qry_work = db_query_stored($rki->conn, $rki->stmanagement, $para_work);
                            ?>
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-hover">
                                        <tr class="w3-gray">
                                            <td></td> <td>[ORDER_CODE]</td> <td>[EQ_ID]</td> <td>[ORDER_NAME]</td> <td>[ADD_BY]</td> <td>[WORK_STATUS]</td> <td>[ORDER_DATE]</td> <td>[ORDER_TIME]</td> 
                                            <td>[WORK_START_DATE]</td> <td>[WORK_START_TIME]</td> <td>[WORK_END_DATE]</td> <td>[WORK_END_TIME]</td> <td></td>
                                        </tr>
                                        <?php
                                        while ($work = sqlsrv_fetch_object($qry_work)) {
                                            $i++;
                                            $para_order = set_stored_para('select', $rki->tborder, "*", "WHERE ORDER_ID = '$work->ORDER_ID'");
                                            $qry_order = db_query_stored($rki->conn, $rki->stmanagement, $para_order);
                                            while ($order = sqlsrv_fetch_object($qry_order)) {
                                                echo "<tr>";
                                                echo "<td>$i</td>";
                                                echo "<td>$order->ORDER_CODE</td>";
                                                echo "<td>$order->EQ_ID</td>";
                                                echo "<td>$order->ORDER_NAME</td>";
                                                echo "<td>" . select_once_data($rki->conn, $rki->stmanagement, $rki->tbperson, "P_FNAME", "WHERE P_ID = $order->ADD_BY") . "</td>";
                                                echo "<td>" . order_status_name($work->WORK_STATUS) . "</td>";
                                                echo "<td>" . format_datetime($order->ORDER_DATE, 'date') . "</td>";
                                                echo "<td>" . format_datetime($order->ORDER_TIME, 'time') . "</td>";
                                                echo "<td>" . format_datetime($work->WORK_START_DATE, 'date') . "</td>";
                                                echo "<td>" . format_datetime($work->WORK_START_TIME, 'time') . "</td>";
                                                echo "<td>" . format_datetime($work->WORK_END_DATE, 'date') . "</td>";
                                                echo "<td>" . format_datetime($work->WORK_END_TIME, 'time') . "</td>";
                                                ?><td><button class='btn btn-danger' type='button' data-toggle='modal' data-target='#popup_modal' onclick="display_change('modal_display', 'workdetail', <?= $work->ORDER_ID ?>, '/RKAPP/ITM/pages/select_work_data.php')">-</button></td><?php
                                                echo "</tr>";
                                            }
                                        }
                                        ?>
                                    </table>
                                </div>
                                <div class="w3-center">
                                <?php page_pagination($data_row, 5, ''); ?>
                                </div>
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

