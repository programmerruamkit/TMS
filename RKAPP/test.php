<?php
if (require_once '/application.php') {
    $data_row = row_count_number($rki->conn, $rki->stmanagement, $rki->tborder, "[ORDER_ID]", "");
    $row = 10; // กำหนด จำนวนรายการที่แสดงในแต่ละหน้า
    $s = $_GET['start'];
    $e = $_GET['end'];
}
?>

<table class="table">
    <tr>
        <td bgcolor="#CCCCCC">NAME</td>
    </tr>
    <tr>
        <?php
        $para = set_stored_para('SELECT_ROW', $rki->tborder, "[ORDER_ID]", "$s AND $e");
        $qry = db_query_stored($rki->conn, $rki->stmanagement, $para);
        while ($item = sqlsrv_fetch_object($qry)) {
            ?>
        <tr>
            <td bgcolor="#F2F2F2"><?= $item->ORDER_NAME ?></td>
        </tr>  
    <?php } ?>
</table>

<?php echo $item = page_pagination($data_row, $row); ?>