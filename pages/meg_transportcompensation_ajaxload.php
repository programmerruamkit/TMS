<?php
ob_start();
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");

// echo "โหลดข้อมูลล่าสุด : ".date("Y-m-d H:i:s");

// $realVHCTPPID = $_POST["mySort"];
$realVHCTPPID = $_GET["mySort"];
// echo '<br>';
// echo $realVHCTPPID; 

$check1 = "SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) as OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = ? AND OSGS_TY = '1'";
$paramscheck1 = array($realVHCTPPID);
$querycheck1 = sqlsrv_query( $conn, $check1, $paramscheck1);
$resultcheck1 = sqlsrv_fetch_array($querycheck1, SQLSRV_FETCH_ASSOC);
$check2 = "SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) as OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = ? AND OSGS_TY = '2'";
$paramscheck2 = array($realVHCTPPID);
$querycheck2 = sqlsrv_query( $conn, $check2, $paramscheck2);
$resultcheck2 = sqlsrv_fetch_array($querycheck2, SQLSRV_FETCH_ASSOC);
$check3 = "SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) as OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = ? AND OSGS_TY = '3'";
$paramscheck3 = array($realVHCTPPID);
$querycheck3 = sqlsrv_query( $conn, $check3, $paramscheck3);
$resultcheck3 = sqlsrv_fetch_array($querycheck3, SQLSRV_FETCH_ASSOC);
$check4 = "SELECT SUM(ISNULL(CAST(OSGS_AM AS DECIMAL(6,2)),0)) as OSGS_AM FROM OUTSIDE_GAS_STATION WHERE OSGS_PLID = ? AND OSGS_TY = '4'";
$paramscheck4 = array($realVHCTPPID);
$querycheck4 = sqlsrv_query( $conn, $check4, $paramscheck4);
$resultcheck4 = sqlsrv_fetch_array($querycheck4, SQLSRV_FETCH_ASSOC);

$CHKAM1=$resultcheck1["OSGS_AM"];
$CHKAM2=$resultcheck2["OSGS_AM"];
$CHKAM3=$resultcheck3["OSGS_AM"];
$CHKAM4=$resultcheck4["OSGS_AM"];
if(($CHKAM1=='0')||($CHKAM1=='')){$AM1='0';}else{$AM1=$CHKAM1;}
if(($CHKAM2=='0')||($CHKAM2=='')){$AM2='0';}else{$AM2=$CHKAM2;}
if(($CHKAM3=='0')||($CHKAM3=='')){$AM3='0';}else{$AM3=$CHKAM3;}
if(($CHKAM4=='0')||($CHKAM4=='')){$AM4='0';}else{$AM4=$CHKAM4;}

// echo '<br>';
// echo 'AM1 - '.$AM1.'<br>';
// echo 'AM2 - '.$AM2.'<br>';
// echo 'AM3 - '.$AM3.'<br>';
// echo 'AM4 - '.$AM4.'<br>';

$CALOUTSIDE=($AM1+$AM2+$AM3);
// $CALOUTSIDE=($AM1+$AM2+$AM3+$AM4);

echo $CALOUTSIDE;

sqlsrv_close($conn);
?>