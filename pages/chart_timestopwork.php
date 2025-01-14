<?php

session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
$condition1 = "";

$sql_seCountstop = "{call megStopwork_v2(?,?)}";
$params_seCountstop = array(
    array('select_startstop', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_seCountstop = sqlsrv_query($conn, $sql_seCountstop, $params_seCountstop);
while ($result_seCountstop = sqlsrv_fetch_array($query_seCountstop, SQLSRV_FETCH_ASSOC)) {
    $result[] = $result_seCountstop;
}
echo $json = json_encode($result, JSON_NUMERIC_CHECK);
?>