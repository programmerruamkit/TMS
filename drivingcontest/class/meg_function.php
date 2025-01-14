<?php

function connect($db) {
    $serverName = "203.150.29.241\SQLEXPRESS,1433";
    $userName = "sa";
    $userPassword = 'tm$wa01';
    $dbName = $db;
    $connectionInfo = array("Database" => $dbName, "UID" => $userName, "PWD" => $userPassword, "MultipleActiveResultSets" => true, "CharacterSet" => 'UTF-8');
    $conn = sqlsrv_connect($serverName, $connectionInfo);
    return $conn;
}

function insDriverregister($FLG, $CONDITION1, $DRIVINGREGISTER_FNAME, $DRIVINGREGISTER_LNAME,$DRIVINGREGISTER_AGE, $DRIVINGREGISTER_EDUCATION, $DRIVINGREGISTER_POSUTION, $DRIVINGREGISTER_EMAIL, $DRIVINGREGISTER_TEL, $DRIVINGREGISTER_COMPANY, $DRIVINGREGISTER_BUSINESSTYPE, $DRIVINGREGISTER_BUSINESSTYPETEXT, $DRIVINGREGISTE_HISTORY, $DRIVINGREGISTE_HISTORYTEXT, $ACTIVESTATUS, $REMARK) {
    $conn = connect("RTMS");
    $sql = "{call megDriverregister(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($DRIVINGREGISTER_FNAME, SQLSRV_PARAM_IN),
        array($DRIVINGREGISTER_LNAME, SQLSRV_PARAM_IN),
        array($DRIVINGREGISTER_AGE, SQLSRV_PARAM_IN),
        array($DRIVINGREGISTER_EDUCATION, SQLSRV_PARAM_IN),
        array($DRIVINGREGISTER_POSUTION, SQLSRV_PARAM_IN),
        array($DRIVINGREGISTER_EMAIL, SQLSRV_PARAM_IN),
        array($DRIVINGREGISTER_TEL, SQLSRV_PARAM_IN),
        array($DRIVINGREGISTER_COMPANY, SQLSRV_PARAM_IN),
        array($DRIVINGREGISTER_BUSINESSTYPE, SQLSRV_PARAM_IN),
        array($DRIVINGREGISTER_BUSINESSTYPETEXT, SQLSRV_PARAM_IN),
        array($DRIVINGREGISTE_HISTORY, SQLSRV_PARAM_IN),
        array($DRIVINGREGISTE_HISTORYTEXT, SQLSRV_PARAM_IN),
        array($ACTIVESTATUS,SQLSRV_PARAM_IN),
        array($REMARK, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];
}

function insDrivingadmin($FLG,$CONDITION1,$FIELDNAME,$EDITTABLEOBJ) {
    $conn = connect("RTMS");
    $sql = "{call megDriveradmin_v2(?,?,?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN),
        array($FIELDNAME, SQLSRV_PARAM_IN),
        array($EDITTABLEOBJ, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];

}

function delDrivingadmin($FLG,$CONDITION1) {
    $conn = connect("RTMS");
    $sql = "{call megDriveradmin_v2(?,?)}";
    $params = array(
        array($FLG, SQLSRV_PARAM_IN),
        array($CONDITION1, SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    sqlsrv_close($conn);
    return $result['RS'];

}
?>


