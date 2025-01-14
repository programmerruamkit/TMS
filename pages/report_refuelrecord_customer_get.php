<?php
    session_start();
    date_default_timezone_set("Asia/Bangkok");
    ini_set('max_execution_time', 300);
    require_once("../class/meg_function.php");
    $conn = connect("RTMS");
    $getcus="{$_GET['customercode']}";
    $sql = "SELECT DISTINCT CUSTOMERCODE FROM [dbo].[VEHICLETRANSPORTPRICE] WHERE CUSTOMERCODE IS NOT NULL AND CUSTOMERCODE != '' AND COMPANYCODE = '$getcus'";
    $query = sqlsrv_query($conn, $sql);
    $json = array();
    while($result = sqlsrv_fetch_array($query)) { 
        array_push($json, $result); 
    }
    echo json_encode($json);

    sqlsrv_close($conn);
?>
