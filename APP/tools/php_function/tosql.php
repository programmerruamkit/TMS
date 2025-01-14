<?php

/* SELECT ALL DATA COLUMN */

function select_once_data($conn, $sto, $table, $value, $condition) {
    $para = set_stored_para('select', $table, $value, $condition);
    $qry = db_query_stored($conn, $sto, $para);
    $item = sqlsrv_fetch_object($qry);
    return $item->$value;
    db_close($conn);
}

/* GET DATE TIME FROM SERVER */

function set_datetime_server($conn, $selection) {
    if ($selection == 'date') {
        $sql = "SELECT CONVERT(DATE,GETDATE()) AS DATAITEM";
    }
    if ($selection == 'time') {
        $sql = "SELECT CONVERT(TIME,GETDATE()) AS DATAITEM";
    }
    if ($selection == 'datetime') {
        $sql = "SELECT GETDATE() AS DATAITEM";
    }
    $qry = db_query($conn, $sql);
    while ($bag = sqlsrv_fetch_object($qry)) {
        return format_datetime($bag->DATAITEM, $selection);
    }
    db_close($conn);
}

function re_check_data($conn, $sto, $table, $condition) {
    $para = set_stored_para('select', $table, '*', $condition);
    $qry = db_query_stored($conn, $sto, $para);
    if ($bag = sqlsrv_fetch_object($qry)) {
        return true;
    } else {
        return false;
    }
    db_close($conn);
}

function select_all_data($conn, $sto, $table, $value, $condition) {
    $para = set_stored_para('select', $table, $value, $condition);
    $qry = db_query_stored($conn, $sto, $para);
    if ($qry == false) {
        return false;
    } else {
        return $qry;
    }
    db_close($conn);
}

function get_max_id($conn, $sto, $table, $value, $condition) {
    $para = set_stored_para("MAXID", $table, $value, $condition);
    $qry = db_query_stored($conn, $sto, $para);
    if ($bag = sqlsrv_fetch_object($qry)) {
        $item = sprintf("%04d", substr($bag->MAXID, -3) + 1);
    } else {
        $item = sprintf("%04d", 1);
    }
    return $item;
    db_close($conn);
}

function select_type_name($conn, $data) {
    $sql = "SELECT [TYPE_NAME] FROM [RKADB_TABLE_TYPE] WHERE [TYPE_CODE] = '$data'";
    $qry = db_query($conn, $sql);
    $bag = sqlsrv_fetch_object($qry);
    return $bag->TYPE_NAME;
    db_close($conn);
}

function select_data_list($conn, $table, $value, $condition) {
    $sql = "SELECT $value FROM $table WHERE ITEM_STATUS = 1 ORDER BY E_CODE";
    $item = "";

    $qry = db_query($conn, $sql);
    while ($bag = sqlsrv_fetch_object($qry)) {
        $item .= "<option value='$bag->$value'>";
    }
    return $item;
    db_close($conn);
}

function count_order($conn, $sto) {
    $value = "[ORDER_ID]";
    $condition = "WHERE [ORDER_STATUS] = 0 AND [ITEM_STATUS] = 1";
    $para = set_stored_para('COUNT', "RKADB_TABLE_ORDER", $value, $condition);
    $qry = db_query_stored($conn, $sto, $para);
    $bag = sqlsrv_fetch_object($qry);
    return $bag->COUNT_NUMBER;
    db_close($conn);
}

function get_user_it_name($conn, $sto) {
    $para = set_stored_para('SELECT', "TB_RKUSER_LOGINDATA", "P_ID", "WHERE [POSITION_TYPE] = 'IT'");
    $qry = db_query_stored($conn, $sto, $para);
    while ($bag = sqlsrv_fetch_object($qry)) {
        $para = set_stored_para('SELECT', "TB_RKDATA_PERSONDATA", "P_ID,P_FNAME,P_LNAME", "WHERE [P_ID] = '$bag->P_ID'");
        $qry_p = db_query_stored($conn, $sto, $para);
        while ($bag_p = sqlsrv_fetch_object($qry_p)) {
            echo "<option value='$bag_p->P_ID'>$bag_p->P_FNAME $bag_p->P_LNAME</option>";
        }
    }
}

function row_count_number($conn, $sto, $table, $value, $condition) {
    $para = set_stored_para('ROW', $table, $value, $condition);
    $qry = db_query_stored($conn, $sto, $para);
    while ($bag = sqlsrv_fetch_object($qry)) {
        $item = $bag->ROW_ID;
    }
    return $item;
}

function table_type_data($conn, $sp) {
    $item = '';
    $n = 1;
    $para = set_stored_para("SELECT", "RKADB_TABLE_TYPE", "[TYPE_CODE],[TYPE_NAME]", "WHERE [ITEM_STATUS] = 1 ORDER BY [TYPE_CODE]");
    $qry = db_query_stored($conn, $sp, $para);
    while ($bag = sqlsrv_fetch_object($qry)) {
        $item .= '<tr>';
        $item .= '<td>' . $n++ . '</td>';
        $item .= '<td>' . $bag->TYPE_CODE . '</td>';
        $item .= '<td>' . $bag->TYPE_NAME . '</td>';
        $item .= '</tr>';
    }
    return $item;
}

function person_email_data($conn, $sto, $name) {
    $para = set_stored_para('select', "RKADB_TABLE_PERSON", "PERSON_EMAIL", "WHERE ([PERSON_FIRST_NAME]+' '+[PERSON_LAST_NAME]) = '$name'");
    $qry = db_query_stored($conn, $sto, $para);
    $item = sqlsrv_fetch_object($qry);
    return $item->PERSON_EMAIL;
    db_close($conn);
}
?>

