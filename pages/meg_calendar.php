<?php

date_default_timezone_set("Asia/Bangkok");

header("Content-type:text/json; charset=UTF-8");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
require_once("../class/meg_function.php");
$conn = connect("RTMS");


$conditiionVehicletransportplan1 = "";
$conditiionVehicletransportplan2 = "";
$conditiionVehicletransportplan3 = "";
$sql_seVehicletransportplan = "{call megVehicletransportplan_v2(?,?,?,?)}";
$params_seVehicletransportplan = array(
    array('select_datevehicletransportplan', SQLSRV_PARAM_IN),
    array($conditiionVehicletransportplan1, SQLSRV_PARAM_IN),
    array($conditiionVehicletransportplan2, SQLSRV_PARAM_IN),
    array($conditiionVehicletransportplan3, SQLSRV_PARAM_IN)
);

$query_seVehicletransportplan = sqlsrv_query($conn, $sql_seVehicletransportplan, $params_seVehicletransportplan);
while ($result_seVehicletransportplan = sqlsrv_fetch_array($query_seVehicletransportplan)) {
   

    if ($result_seVehicletransportplan['STATUSNUMBER'] == "1") {
        $color = "#31B0D5";
    }

    if ($result_seVehicletransportplan['STATUSNUMBER'] == "2") {
        $color = "#EC971F";
    }

    if ($result_seVehicletransportplan['STATUSNUMBER'] == "3") {
        $color = "#D9534F";
    }

    if ($result_seVehicletransportplan['STATUSNUMBER'] == "4") {
        $color = "#449D44";
    }

    if ($result_seVehicletransportplan['STATUSNUMBER'] == "5") {
        $color = "#BA55D3";
    }



    $json_data[] = array(
        "title" => ' (ทะเบียน : ' . $result_seVehicletransportplan['VEHICLEREGISNUMBER1'] . ')',
        "start" => $result_seVehicletransportplan['DATEPRESENT'],
        "end" => $result_seVehicletransportplan['DATEPRESENT'],
        "url"=>"meg_employee3_2ins.php?vehicletransportplanid=".$result_seVehicletransportplan['VEHICLETRANSPORTPLANID'],
        "color"=>$color,
    );
}

$json = json_encode($json_data);


echo $json;
?>