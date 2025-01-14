<?php

/* --CONNECTION DATABASE */

function db_connect($dbhost, $dbname, $dbuser, $dbpass) {
    $coninfo = array("Database" => $dbname, "UID" => $dbuser, "PWD" => $dbpass, "MultipleActiveResultSets" => true, "CharacterSet" => 'UTF-8');
    $conn = sqlsrv_connect($dbhost, $coninfo);

    if ($conn) {
        return $conn;
    } else {
        die(print_r(sqlsrv_errors(), true));
        return 0;
    }
}

/* QUERY SQL STATEMENT BY STORED MS-SQL */

function db_query_stored($conn, $sto, $para) {
    $var_qry = sqlsrv_query($conn, $sto, $para);

    if ($var_qry === false) {
        return false;
    } else {
        return $var_qry;
    }
    db_close($conn);
}

/* QUERY SQL STATEMENT */

function db_query($conn, $sql) {
    $var_qry = sqlsrv_query($conn, $sql);

    if ($var_qry === false) {
        return false;
    } else {
        return $var_qry;
    }
    db_close($conn);
}

/* SET STORED PARAMITER MS-SQL */

function set_stored_para($selection, $table, $value, $condition) {
    $var_para = array(
        array($selection, SQLSRV_PARAM_IN),
        array($table, SQLSRV_PARAM_IN),
        array($value, SQLSRV_PARAM_IN),
        array($condition, SQLSRV_PARAM_IN)
    );
    return $var_para;
}

/* CALL STORED MS-SQL */

function call_stored($sto) {
    $var_sto = "{call " . $sto . "(?,?,?,?)}";
    return $var_sto;
}

/* DISCONNECTION DATABASE */

function db_close($conn) {
    sqlsrv_close($conn);
}

?>