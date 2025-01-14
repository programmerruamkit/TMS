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

function insAdjust($FLG,$CONDITION1,$FIELDNAME,$EDITTABLEOBJ) {
    $conn = connect("RTMS");
    $sql = "{call megAdjust_v2(?,?,?,?)}";
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

?>


