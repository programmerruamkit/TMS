<?php 
ini_set('max_execution_time', 300);
date_default_timezone_set("Asia/Bangkok");
require_once("../../class/meg_function.php");
$conn = connect("RTMS");

$sql = "SELECT 'รหัสพนักงาน :  '+CONVERT(NVARCHAR,PersonCardID) AS 'PersonCardID',CONVERT(NVARCHAR(5),CONVERT(TIME,TimeInout),14)+'('+CASE WHEN InOutMode = 'I' THEN 'เข้า' ELSE 'ออก' END +')' AS 'TIMEINOUT' FROM [TigerWebServer].[dbo].[ZFP_TimeInOut] where PersonCardID = '060122'
AND CONVERT(DATE,[TimeInout],103) = CONVERt(DATE,GETDATE(),103)";
$params = array();
$query = sqlsrv_query($conn, $sql, $params);
$resultArray = array();

while($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
{
	array_push($resultArray,$result);
}
echo json_encode($resultArray);
	

sqlsrv_close($conn);
?>
	
	