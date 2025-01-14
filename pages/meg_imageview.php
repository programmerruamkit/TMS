<?php

date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
//$condition = " AND a.PersonID ='".$_GET['personid']."'";
$sql_seEmployee = "select data from dbo.image where id = '1'";
//$sql_seEmployee = "select personpic  FROM [203.150.225.30].[TigerE-HR].dbo.PNT_Person where personid = '76'";
$params_seEmployee = array('');
$query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
$result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC);
echo $result_seEmployee['data'];



?>
<img width="50" src="data:image/jpeg;base64,<?= base64_decode($result_seEmployee['data']) ?>">
<img width="50" src="data:image/jpeg;charset=binary;base64,<?= $result_seEmployee['data'] ?>">

