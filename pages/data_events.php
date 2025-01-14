<?php

require_once("../class/meg_function.php");
$conn = connect("RTMS");

$sql_seVehicletransportplan = "{call megVehicletransportplan_v2(?,?,?,?)}";
$params_seVehicletransportplan = array(
    array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN),
    array('', SQLSRV_PARAM_IN)
);

$query_seVehicletransportplan = sqlsrv_query($conn, $sql_seVehicletransportplan, $params_seVehicletransportplan);



while ($row = sqlsrv_fetch_object($query_seVehicletransportplan)) {




    $json_data[] = array(
        "title" => $row->THAINAME,
        "start" => $row->DATEPRESENT,
        "end" => $row->DATEPRESENT,
        "url"=>"show2.php?id=".$row->VEHICLETRANSPORTPLANID,
    );
}

$json = json_encode($json_data);

if (isset($_GET['callback']) && $_GET['callback'] != "") {
    echo $_GET['callback'] . "(" . $json . ");";
} else {
    echo $json;
}
?>  