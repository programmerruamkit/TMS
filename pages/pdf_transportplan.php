<?php
date_default_timezone_set("Asia/Bangkok");
ini_set('max_execution_time', 300);
require_once("../class/meg_function.php");
$conn = connect("RTMS");
?>
<style>
    body{
        font-family: "Garuda";
    }
</style>

<table width="100%" id="bg-table"  style="border-collapse: collapse;font-size:10;margin-top:8px;">
    <tr style="border:1px solid #000;padding:4px;">
        <td colspan="4" style="border-right:1px solid #000;padding:4px;text-align:center;" >&nbsp;</td>
        <td colspan="144" style="border-right:1px solid #000;padding:4px;text-align:center;" >Monday</td>
        <td colspan="144" style="border-right:1px solid #000;padding:4px;text-align:center;" >Monday</td>

    </tr>
    <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;" >ลำดับ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;" >Triler</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;" >Route</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;" >Driver</td>

        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >05:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >06:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >07:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >08:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >09:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >10:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >11:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >12:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >13:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >14:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >15:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >16:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >17:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >18:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >19:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >20:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >21:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >22:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >23:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >00:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >01:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >02:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >03:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >04:00</td>

        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >05:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >06:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >07:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >08:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >09:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >10:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >11:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >12:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >13:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >14:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >15:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >16:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >17:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >18:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >19:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >20:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >21:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >22:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >23:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >00:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >01:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >02:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >03:00</td>
        <td colspan="6" style="border-right:1px solid #000;padding:4px;text-align:center;" >04:00</td>
    </tr>
    <?php
    $sql_seVehicletransportplanreport = "{call megVehicletransportplanreport_v2(?,?)}";
    $params_seVehicletransportplanreport = array(
        array("select_vehicletransportplanreport", SQLSRV_PARAM_IN),
        array("", SQLSRV_PARAM_IN)
    );
    $query_seVehicletransportplanreport = sqlsrv_query($conn, $sql_seVehicletransportplanreport, $params_seVehicletransportplanreport);
    while ($result_seVehicletransportplanreport = sqlsrv_fetch_array($query_seVehicletransportplanreport, SQLSRV_FETCH_ASSOC)) {
        ?>
        <tr style="border:1px solid #000;padding:4px;">
            <?php
            $Checkdatem0500 = "";
            $result_seDatepresentm0500 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "05:00", "05:09");
            $result_seDatevlintm0500 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "05:09");
            $result_seDaterestm010500 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "05:09");
            $result_seDaterestm020500 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "05:09");
            $result_seDaterestm030500 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "05:09");
            $result_seDaterestm040500 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "05:09");
            $result_seDaterestm050500 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "05:09");
            $result_seDaterestm060500 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "05:09");
            $result_seDaterestm070500 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "05:09");
            $result_seDaterestm080500 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "05:09");
            $result_seDaterestm090500 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "05:09");
            $result_seDaterestm100500 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "05:09");
            $result_seDatedealerinm100500 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "05:09");
            $result_seDaterestm110500 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "05:09");
            $result_seDaterestm120500 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "05:09");
            $result_seDaterestm130500 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "05:09");
            $result_seDaterestm140500 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "05:09");
            $result_seDaterestm150500 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "05:09");
            $result_seDaterestm160500 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "05:09");
            $result_seDaterestm170500 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "05:09");
            $result_seDaterestm180500 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "05:09");
            $result_seDaterestm190500 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "05:09");
            $result_seDaterestm200500 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "05:09");
            if ($result_seDatepresentm0500 > 0) {
                $Checkdatem0500 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlintm0500 > 0) {
                $Checkdatem0500 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm010500 > 0) {
                $Checkdatem0500 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm020500 > 0) {
                $Checkdatem0500 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm030500 > 0) {
                $Checkdatem0500 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm040500 > 0) {
                $Checkdatem0500 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm050500 > 0) {
                $Checkdatem0500 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm060500 > 0) {
                $Checkdatem0500 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm070500 > 0) {
                $Checkdatem0500 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm080500 > 0) {
                $Checkdatem0500 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm090500 > 0) {
                $Checkdatem0500 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm100500 > 0) {
                $Checkdatem0500 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            }else if ($result_seDatedealerinm100500 > 0) {
                $Checkdatem0500 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm110500 > 0) {
                $Checkdatem0500 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm120500 > 0) {
                $Checkdatem0500 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm130500 > 0) {
                $Checkdatem0500 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm140500 > 0) {
                $Checkdatem0500 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm150500 > 0) {
                $Checkdatem0500 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm160500 > 0) {
                $Checkdatem0500 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm170500 > 0) {
                $Checkdatem0500 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm180500 > 0) {
                $Checkdatem0500 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm190500 > 0) {
                $Checkdatem0500 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm200500 > 0) {
                $Checkdatem0500 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem0500 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }

            $Checkdatem0510 = "";
            $result_seDatepresent0510 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "05:10", "05:19");
            $result_seDatevlint0510 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "05:19");
            $result_seDaterestm010510 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "05:19");
            $result_seDaterestm020510 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "05:19");
            $result_seDaterestm030510 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "05:19");
            $result_seDaterestm040510 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "05:19");
            $result_seDaterestm050510 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "05:19");
            $result_seDaterestm060510 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "05:19");
            $result_seDaterestm070510 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "05:19");
            $result_seDaterestm080510 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "05:19");
            $result_seDaterestm090510 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "05:19");
            $result_seDaterestm100510 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "05:19");
            $result_seDatedealerinm100510 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "05:19");
            $result_seDaterestm110510 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "05:19");
            $result_seDaterestm120510 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "05:19");
            $result_seDaterestm130510 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "05:19");
            $result_seDaterestm140510 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "05:19");
            $result_seDaterestm150510 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "05:19");
            $result_seDaterestm160510 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "05:19");
            $result_seDaterestm170510 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "05:19");
            $result_seDaterestm180510 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "05:19");
            $result_seDaterestm190510 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "05:19");
            $result_seDaterestm200510 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "05:19");
            if ($result_seDatepresent0510 > 0) {
                $Checkdatem0510 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint0510 > 0) {
                $Checkdatem0510 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm010510 > 0) {
                $Checkdatem0510 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm020510 > 0) {
                $Checkdatem0510 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm030510 > 0) {
                $Checkdatem0510 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm040510 > 0) {
                $Checkdatem0510 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm050510 > 0) {
                $Checkdatem0510 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm060510 > 0) {
                $Checkdatem0510 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm070510 > 0) {
                $Checkdatem0510 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm080510 > 0) {
                $Checkdatem0510 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm090510 > 0) {
                $Checkdatem0510 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDatedealerinm100510 > 0) {
                $Checkdatem0510 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm110510 > 0) {
                $Checkdatem0510 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm120510 > 0) {
                $Checkdatem0510 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm130510 > 0) {
                $Checkdatem0510 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm140510 > 0) {
                $Checkdatem0510 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm150510 > 0) {
                $Checkdatem0510 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm160510 > 0) {
                $Checkdatem0510 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm170510 > 0) {
                $Checkdatem0510 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm180510 > 0) {
                $Checkdatem0510 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm190510 > 0) {
                $Checkdatem0510 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm200510 > 0) {
                $Checkdatem0510 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            } else {
                $Checkdatem0510 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }
            $Checkdatem0520 = "";
            $result_seDatepresent0520 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "05:20", "05:29");
            $result_seDatevlint0520 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "05:29");
            $result_seDaterestm010520 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "05:29");
            $result_seDaterestm020520 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "05:29");
            $result_seDaterestm030520 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "05:29");
            $result_seDaterestm040520 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "05:29");
            $result_seDaterestm050520 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "05:29");
            $result_seDaterestm060520 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "05:29");
            $result_seDaterestm070520 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "05:29");
            $result_seDaterestm080520 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "05:29");
            $result_seDaterestm090520 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "05:29");
            $result_seDaterestm100520 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "05:29");
            $result_seDatedealerinm100520 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "05:29");
            $result_seDaterestm110520 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "05:29");
            $result_seDaterestm120520 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "05:29");
            $result_seDaterestm130520 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "05:29");
            $result_seDaterestm140520 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "05:29");
            $result_seDaterestm150520 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "05:29");
            $result_seDaterestm160520 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "05:29");
            $result_seDaterestm170520 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "05:29");
            $result_seDaterestm180520 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "05:29");
            $result_seDaterestm190520 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "05:29");
            $result_seDaterestm200520 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "05:29");
            if ($result_seDatepresent0520 > 0) {
                $Checkdatem0520 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint0520 > 0) {
                $Checkdatem0520 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm010520 > 0) {
                $Checkdatem0520 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm0205200 > 0) {
                $Checkdatem0520 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm030520 > 0) {
                $Checkdatem0520 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm040520 > 0) {
                $Checkdatem0520 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm050520 > 0) {
                $Checkdatem0520 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm060520 > 0) {
                $Checkdatem0520 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm070520 > 0) {
                $Checkdatem0520 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm080520 > 0) {
                $Checkdatem0520 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm090520 > 0) {
                $Checkdatem0520 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm100520 > 0) {
                $Checkdatem0520 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            } else if ($result_seDatedealerinm100520 > 0) {
                $Checkdatem0520 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm110520 > 0) {
                $Checkdatem0520 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm120520 > 0) {
                $Checkdatem0520 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm130520 > 0) {
                $Checkdatem0520 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm140520 > 0) {
                $Checkdatem0520 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm150520 > 0) {
                $Checkdatem0520 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm160520 > 0) {
                $Checkdatem0520 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm170520 > 0) {
                $Checkdatem0520 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm180520 > 0) {
                $Checkdatem0520 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm190520 > 0) {
                $Checkdatem0520 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm200520 > 0) {
                $Checkdatem0520 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem0520 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }

            $Checkdatem0530 = "";
            $result_seDatepresent0530 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "05:30", "05:39");
            $result_seDatevlint0530 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "05:39");
            $result_seDaterestm010530 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "05:39");
            $result_seDaterestm020530 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "05:39");
            $result_seDaterestm030530 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "05:39");
            $result_seDaterestm040530 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "05:39");
            $result_seDaterestm050530 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "05:39");
            $result_seDaterestm060530 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "05:39");
            $result_seDaterestm070530 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "05:39");
            $result_seDaterestm080530 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "05:39");
            $result_seDaterestm090530 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "05:39");
            $result_seDaterestm100530 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "05:39");
            $result_seDatedealerinm100530 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "05:39");
            $result_seDaterestm110530 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "05:39");
            $result_seDaterestm120530 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "05:39");
            $result_seDaterestm130530 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "05:39");
            $result_seDaterestm140530 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "05:39");
            $result_seDaterestm150530 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "05:39");
            $result_seDaterestm160530 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "05:39");
            $result_seDaterestm170530 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "05:39");
            $result_seDaterestm180530 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "05:39");
            $result_seDaterestm190530 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "05:39");
            $result_seDaterestm200530 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "05:39");
            if ($result_seDatepresent0530 > 0) {
                $Checkdatem0530 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint0530 > 0) {
                $Checkdatem0530 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm010530 > 0) {
                $Checkdatem0530 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm020530 > 0) {
                $Checkdatem0530 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm030530 > 0) {
                $Checkdatem0530 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm040530 > 0) {
                $Checkdatem0530 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm050530 > 0) {
                $Checkdatem0530 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm060530 > 0) {
                $Checkdatem0530 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm070530 > 0) {
                $Checkdatem0530 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm080530 > 0) {
                $Checkdatem0530 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm090530 > 0) {
                $Checkdatem0530 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm100530 > 0) {
                $Checkdatem0530 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            } else if ($result_seDatedealerinm100530 > 0) {
                $Checkdatem0530 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm110530 > 0) {
                $Checkdatem0530 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm120530 > 0) {
                $Checkdatem0530 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm130530 > 0) {
                $Checkdatem0530 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm140530 > 0) {
                $Checkdatem0530 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm150530 > 0) {
                $Checkdatem0530 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm160530 > 0) {
                $Checkdatem0530 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm170530 > 0) {
                $Checkdatem0530 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm180530 > 0) {
                $Checkdatem0530 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm190530 > 0) {
                $Checkdatem0530 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm200530 > 0) {
                $Checkdatem0530 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem0530 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }
            $Checkdatem0540 = "";
            $result_seDatepresent0540 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "05:40", "05:49");
            $result_seDatevlint0540 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "05:49");
            $result_seDaterestm010540 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "05:49");
            $result_seDaterestm020540 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "05:49");
            $result_seDaterestm030540 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "05:49");
            $result_seDaterestm040540 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "05:49");
            $result_seDaterestm050540 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "05:49");
            $result_seDaterestm060540 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "05:49");
            $result_seDaterestm070540 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "05:49");
            $result_seDaterestm080540 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "05:49");
            $result_seDaterestm090540 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "05:49");
            $result_seDaterestm100540 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "05:49");
            $result_seDatedealerinm100540 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "05:49");
            $result_seDaterestm110540 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "05:49");
            $result_seDaterestm120540 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "05:49");
            $result_seDaterestm130540 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "05:49");
            $result_seDaterestm140540 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "05:49");
            $result_seDaterestm150540 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "05:49");
            $result_seDaterestm160540 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "05:49");
            $result_seDaterestm170540 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "05:49");
            $result_seDaterestm180540 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "05:49");
            $result_seDaterestm190540 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "05:49");
            $result_seDaterestm200540 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "05:49");
            if ($result_seDatepresent0540 > 0) {
                $Checkdatem0540 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint0540 > 0) {
                $Checkdatem0540 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm010540 > 0) {
                $Checkdatem0540 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm0205400 > 0) {
                $Checkdatem0540 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm030540 > 0) {
                $Checkdatem0540 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm040540 > 0) {
                $Checkdatem0540 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm050540 > 0) {
                $Checkdatem0540 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm060540 > 0) {
                $Checkdatem0540 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm070540 > 0) {
                $Checkdatem0540 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm080540 > 0) {
                $Checkdatem0540 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm090540 > 0) {
                $Checkdatem0540 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm100540 > 0) {
                $Checkdatem0540 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            } else if ($result_seDatedealerinm100540 > 0) {
                $Checkdatem0540 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm110540 > 0) {
                $Checkdatem0540 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm120540 > 0) {
                $Checkdatem0540 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm130540 > 0) {
                $Checkdatem0540 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm140540 > 0) {
                $Checkdatem0540 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm150540 > 0) {
                $Checkdatem0540 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm160540 > 0) {
                $Checkdatem0540 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm170540 > 0) {
                $Checkdatem0540 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm180540 > 0) {
                $Checkdatem0540 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm190540 > 0) {
                $Checkdatem0540 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm200540 > 0) {
                $Checkdatem0540 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem0540 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }

            $Checkdatem0550 = "";
            $result_seDatepresent0550 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "05:50", "05:59");
            $result_seDatevlint0550 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "05:59");
            $result_seDaterestm010550 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "05:59");
            $result_seDaterestm020550 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "05:59");
            $result_seDaterestm030550 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "05:59");
            $result_seDaterestm040550 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "05:59");
            $result_seDaterestm050550 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "05:59");
            $result_seDaterestm060550 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "05:59");
            $result_seDaterestm070550 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "05:59");
            $result_seDaterestm080550 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "05:59");
            $result_seDaterestm090550 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "05:59");
            $result_seDaterestm100550 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "05:59");
            $result_seDatedealerinm100550 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "05:59");
            $result_seDaterestm110550 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "05:59");
            $result_seDaterestm120550 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "05:59");
            $result_seDaterestm130550 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "05:59");
            $result_seDaterestm140550 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "05:59");
            $result_seDaterestm150550 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "05:59");
            $result_seDaterestm160550 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "05:59");
            $result_seDaterestm170550 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "05:59");
            $result_seDaterestm180550 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "05:59");
            $result_seDaterestm190550 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "05:59");
            $result_seDaterestm200550 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "05:59");
            if ($result_seDatepresent0550 > 0) {
                $Checkdatem0550 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint0550 > 0) {
                $Checkdatem0550 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm010550 > 0) {
                $Checkdatem0550 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm020550 > 0) {
                $Checkdatem0550 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm030550 > 0) {
                $Checkdatem0550 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm040550 > 0) {
                $Checkdatem0550 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm050550 > 0) {
                $Checkdatem0550 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm060550 > 0) {
                $Checkdatem0550 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm070550 > 0) {
                $Checkdatem0550 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm080550 > 0) {
                $Checkdatem0550 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm090550 > 0) {
                $Checkdatem0550 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm100550 > 0) {
                $Checkdatem0550 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            } else if ($result_seDatedealerinm100550 > 0) {
                $Checkdatem0550 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm110550 > 0) {
                $Checkdatem0550 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm120550 > 0) {
                $Checkdatem0550 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm130550 > 0) {
                $Checkdatem0550 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm140550 > 0) {
                $Checkdatem0550 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm150550 > 0) {
                $Checkdatem0550 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm160550 > 0) {
                $Checkdatem0550 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm170550 > 0) {
                $Checkdatem0550 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm180550 > 0) {
                $Checkdatem0550 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm190550 > 0) {
                $Checkdatem0550 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm200550 > 0) {
                $Checkdatem0550 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem0550 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }
            
            $Checkdatem0600 = "";
            $result_seDatepresentm0600 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "06:00", "06:09");
            $result_seDatevlintm0600 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "06:09");
            $result_seDaterestm010600 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "06:09");
            $result_seDaterestm020600 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "06:09");
            $result_seDaterestm030600 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "06:09");
            $result_seDaterestm040600 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "06:09");
            $result_seDaterestm050600 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "06:09");
            $result_seDaterestm060600 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "06:09");
            $result_seDaterestm070600 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "06:09");
            $result_seDaterestm080600 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "06:09");
            $result_seDaterestm090600 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "06:09");
            $result_seDaterestm100600 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "06:09");
            $result_seDatedealerinm100600 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "06:09");
            $result_seDaterestm110600 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "06:09");
            $result_seDaterestm120600 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "06:09");
            $result_seDaterestm130600 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "06:09");
            $result_seDaterestm140600 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "06:09");
            $result_seDaterestm150600 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "06:09");
            $result_seDaterestm160600 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "06:09");
            $result_seDaterestm170600 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "06:09");
            $result_seDaterestm180600 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "06:09");
            $result_seDaterestm190600 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "06:09");
            $result_seDaterestm200600 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "06:09");
            if ($result_seDatepresentm0600 > 0) {
                $Checkdatem0600 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlintm0600 > 0) {
                $Checkdatem0600 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm010600 > 0) {
                $Checkdatem0600 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm020600 > 0) {
                $Checkdatem0600 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm030600 > 0) {
                $Checkdatem0600 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm040600 > 0) {
                $Checkdatem0600 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm050600 > 0) {
                $Checkdatem0600 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm060600 > 0) {
                $Checkdatem0600 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm070600 > 0) {
                $Checkdatem0600 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm080600 > 0) {
                $Checkdatem0600 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm090600 > 0) {
                $Checkdatem0600 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm100600 > 0) {
                $Checkdatem0600 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            }else if ($result_seDatedealerinm100600 > 0) {
                $Checkdatem0600 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm110600 > 0) {
                $Checkdatem0600 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm120600 > 0) {
                $Checkdatem0600 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm130600 > 0) {
                $Checkdatem0600 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm140600 > 0) {
                $Checkdatem0600 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm150600 > 0) {
                $Checkdatem0600 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm160600 > 0) {
                $Checkdatem0600 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm170600 > 0) {
                $Checkdatem0600 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm180600 > 0) {
                $Checkdatem0600 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm190600 > 0) {
                $Checkdatem0600 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm200600 > 0) {
                $Checkdatem0600 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem0600 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }

            $Checkdatem0610 = "";
            $result_seDatepresent0610 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "06:10", "06:19");
            $result_seDatevlint0610 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "06:19");
            $result_seDaterestm010610 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "06:19");
            $result_seDaterestm020610 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "06:19");
            $result_seDaterestm030610 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "06:19");
            $result_seDaterestm040610 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "06:19");
            $result_seDaterestm050610 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "06:19");
            $result_seDaterestm060610 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "06:19");
            $result_seDaterestm070610 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "06:19");
            $result_seDaterestm080610 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "06:19");
            $result_seDaterestm090610 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "06:19");
            $result_seDaterestm100610 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "06:19");
            $result_seDatedealerinm100610 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "06:19");
            $result_seDaterestm110610 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "06:19");
            $result_seDaterestm120610 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "06:19");
            $result_seDaterestm130610 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "06:19");
            $result_seDaterestm140610 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "06:19");
            $result_seDaterestm150610 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "06:19");
            $result_seDaterestm160610 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "06:19");
            $result_seDaterestm170610 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "06:19");
            $result_seDaterestm180610 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "06:19");
            $result_seDaterestm190610 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "06:19");
            $result_seDaterestm200610 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "06:19");
            if ($result_seDatepresent0610 > 0) {
                $Checkdatem0610 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint0610 > 0) {
                $Checkdatem0610 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm010610 > 0) {
                $Checkdatem0610 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm020610 > 0) {
                $Checkdatem0610 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm030610 > 0) {
                $Checkdatem0610 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm040610 > 0) {
                $Checkdatem0610 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm050610 > 0) {
                $Checkdatem0610 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm060610 > 0) {
                $Checkdatem0610 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm070610 > 0) {
                $Checkdatem0610 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm080610 > 0) {
                $Checkdatem0610 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm090610 > 0) {
                $Checkdatem0610 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDatedealerinm100610 > 0) {
                $Checkdatem0610 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm110610 > 0) {
                $Checkdatem0610 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm120610 > 0) {
                $Checkdatem0610 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm130610 > 0) {
                $Checkdatem0610 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm140610 > 0) {
                $Checkdatem0610 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm150610 > 0) {
                $Checkdatem0610 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm160610 > 0) {
                $Checkdatem0610 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm170610 > 0) {
                $Checkdatem0610 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm180610 > 0) {
                $Checkdatem0610 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm190610 > 0) {
                $Checkdatem0610 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm200610 > 0) {
                $Checkdatem0610 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            } else {
                $Checkdatem0610 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }
            $Checkdatem0620 = "";
            $result_seDatepresent0620 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "06:20", "06:29");
            $result_seDatevlint0620 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "06:29");
            $result_seDaterestm010620 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "06:29");
            $result_seDaterestm020620 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "06:29");
            $result_seDaterestm030620 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "06:29");
            $result_seDaterestm040620 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "06:29");
            $result_seDaterestm050620 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "06:29");
            $result_seDaterestm060620 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "06:29");
            $result_seDaterestm070620 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "06:29");
            $result_seDaterestm080620 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "06:29");
            $result_seDaterestm090620 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "06:29");
            $result_seDaterestm100620 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "06:29");
            $result_seDatedealerinm100620 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "06:29");
            $result_seDaterestm110620 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "06:29");
            $result_seDaterestm120620 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "06:29");
            $result_seDaterestm130620 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "06:29");
            $result_seDaterestm140620 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "06:29");
            $result_seDaterestm150620 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "06:29");
            $result_seDaterestm160620 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "06:29");
            $result_seDaterestm170620 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "06:29");
            $result_seDaterestm180620 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "06:29");
            $result_seDaterestm190620 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "06:29");
            $result_seDaterestm200620 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "06:29");
            if ($result_seDatepresent0620 > 0) {
                $Checkdatem0620 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint0620 > 0) {
                $Checkdatem0620 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm010620 > 0) {
                $Checkdatem0620 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm0205200 > 0) {
                $Checkdatem0620 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm030620 > 0) {
                $Checkdatem0620 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm040620 > 0) {
                $Checkdatem0620 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm050620 > 0) {
                $Checkdatem0620 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm060620 > 0) {
                $Checkdatem0620 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm070620 > 0) {
                $Checkdatem0620 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm080620 > 0) {
                $Checkdatem0620 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm090620 > 0) {
                $Checkdatem0620 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm100620 > 0) {
                $Checkdatem0620 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            } else if ($result_seDatedealerinm100620 > 0) {
                $Checkdatem0620 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm110620 > 0) {
                $Checkdatem0620 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm120620 > 0) {
                $Checkdatem0620 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm130620 > 0) {
                $Checkdatem0620 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm140620 > 0) {
                $Checkdatem0620 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm150620 > 0) {
                $Checkdatem0620 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm160620 > 0) {
                $Checkdatem0620 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm170620 > 0) {
                $Checkdatem0620 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm180620 > 0) {
                $Checkdatem0620 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm190620 > 0) {
                $Checkdatem0620 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm200620 > 0) {
                $Checkdatem0620 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem0620 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }

            $Checkdatem0630 = "";
            $result_seDatepresent0630 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "06:30", "06:39");
            $result_seDatevlint0630 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "06:39");
            $result_seDaterestm010630 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "06:39");
            $result_seDaterestm020630 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "06:39");
            $result_seDaterestm030630 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "06:39");
            $result_seDaterestm040630 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "06:39");
            $result_seDaterestm050630 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "06:39");
            $result_seDaterestm060630 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "06:39");
            $result_seDaterestm070630 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "06:39");
            $result_seDaterestm080630 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "06:39");
            $result_seDaterestm090630 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "06:39");
            $result_seDaterestm100630 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "06:39");
            $result_seDatedealerinm100630 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "06:39");
            $result_seDaterestm110630 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "06:39");
            $result_seDaterestm120630 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "06:39");
            $result_seDaterestm130630 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "06:39");
            $result_seDaterestm140630 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "06:39");
            $result_seDaterestm150630 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "06:39");
            $result_seDaterestm160630 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "06:39");
            $result_seDaterestm170630 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "06:39");
            $result_seDaterestm180630 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "06:39");
            $result_seDaterestm190630 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "06:39");
            $result_seDaterestm200630 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "06:39");
            if ($result_seDatepresent0630 > 0) {
                $Checkdatem0630 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint0630 > 0) {
                $Checkdatem0630 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm010630 > 0) {
                $Checkdatem0630 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm020630 > 0) {
                $Checkdatem0630 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm030630 > 0) {
                $Checkdatem0630 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm040630 > 0) {
                $Checkdatem0630 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm050630 > 0) {
                $Checkdatem0630 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm060630 > 0) {
                $Checkdatem0630 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm070630 > 0) {
                $Checkdatem0630 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm080630 > 0) {
                $Checkdatem0630 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm090630 > 0) {
                $Checkdatem0630 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm100630 > 0) {
                $Checkdatem0630 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            } else if ($result_seDatedealerinm100630 > 0) {
                $Checkdatem0630 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm110630 > 0) {
                $Checkdatem0630 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm120630 > 0) {
                $Checkdatem0630 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm130630 > 0) {
                $Checkdatem0630 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm140630 > 0) {
                $Checkdatem0630 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm150630 > 0) {
                $Checkdatem0630 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm160630 > 0) {
                $Checkdatem0630 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm170630 > 0) {
                $Checkdatem0630 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm180630 > 0) {
                $Checkdatem0630 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm190630 > 0) {
                $Checkdatem0630 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm200630 > 0) {
                $Checkdatem0630 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem0630 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }
            $Checkdatem0640 = "";
            $result_seDatepresent0640 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "06:40", "06:49");
            $result_seDatevlint0640 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "06:49");
            $result_seDaterestm010640 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "06:49");
            $result_seDaterestm020640 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "06:49");
            $result_seDaterestm030640 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "06:49");
            $result_seDaterestm040640 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "06:49");
            $result_seDaterestm050640 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "06:49");
            $result_seDaterestm060640 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "06:49");
            $result_seDaterestm070640 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "06:49");
            $result_seDaterestm080640 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "06:49");
            $result_seDaterestm090640 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "06:49");
            $result_seDaterestm100640 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "06:49");
            $result_seDatedealerinm100640 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "06:49");
            $result_seDaterestm110640 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "06:49");
            $result_seDaterestm120640 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "06:49");
            $result_seDaterestm130640 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "06:49");
            $result_seDaterestm140640 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "06:49");
            $result_seDaterestm150640 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "06:49");
            $result_seDaterestm160640 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "06:49");
            $result_seDaterestm170640 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "06:49");
            $result_seDaterestm180640 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "06:49");
            $result_seDaterestm190640 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "06:49");
            $result_seDaterestm200640 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "06:49");
            if ($result_seDatepresent0640 > 0) {
                $Checkdatem0640 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint0640 > 0) {
                $Checkdatem0640 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm010640 > 0) {
                $Checkdatem0640 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm0205400 > 0) {
                $Checkdatem0640 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm030640 > 0) {
                $Checkdatem0640 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm040640 > 0) {
                $Checkdatem0640 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm050640 > 0) {
                $Checkdatem0640 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm060640 > 0) {
                $Checkdatem0640 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm070640 > 0) {
                $Checkdatem0640 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm080640 > 0) {
                $Checkdatem0640 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm090640 > 0) {
                $Checkdatem0640 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm100640 > 0) {
                $Checkdatem0640 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            } else if ($result_seDatedealerinm100640 > 0) {
                $Checkdatem0640 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm110640 > 0) {
                $Checkdatem0640 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm120640 > 0) {
                $Checkdatem0640 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm130640 > 0) {
                $Checkdatem0640 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm140640 > 0) {
                $Checkdatem0640 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm150640 > 0) {
                $Checkdatem0640 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm160640 > 0) {
                $Checkdatem0640 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm170640 > 0) {
                $Checkdatem0640 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm180640 > 0) {
                $Checkdatem0640 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm190640 > 0) {
                $Checkdatem0640 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm200640 > 0) {
                $Checkdatem0640 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem0640 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }

            $Checkdatem0650 = "";
            $result_seDatepresent0650 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "06:50", "06:59");
            $result_seDatevlint0650 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "06:59");
            $result_seDaterestm010650 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "06:59");
            $result_seDaterestm020650 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "06:59");
            $result_seDaterestm030650 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "06:59");
            $result_seDaterestm040650 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "06:59");
            $result_seDaterestm050650 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "06:59");
            $result_seDaterestm060650 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "06:59");
            $result_seDaterestm070650 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "06:59");
            $result_seDaterestm080650 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "06:59");
            $result_seDaterestm090650 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "06:59");
            $result_seDaterestm100650 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "06:59");
            $result_seDatedealerinm100650 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "06:59");
            $result_seDaterestm110650 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "06:59");
            $result_seDaterestm120650 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "06:59");
            $result_seDaterestm130650 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "06:59");
            $result_seDaterestm140650 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "06:59");
            $result_seDaterestm150650 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "06:59");
            $result_seDaterestm160650 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "06:59");
            $result_seDaterestm170650 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "06:59");
            $result_seDaterestm180650 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "06:59");
            $result_seDaterestm190650 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "06:59");
            $result_seDaterestm200650 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "06:59");
            if ($result_seDatepresent0650 > 0) {
                $Checkdatem0650 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint0650 > 0) {
                $Checkdatem0650 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm010650 > 0) {
                $Checkdatem0650 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm020650 > 0) {
                $Checkdatem0650 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm030650 > 0) {
                $Checkdatem0650 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm040650 > 0) {
                $Checkdatem0650 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm050650 > 0) {
                $Checkdatem0650 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm060650 > 0) {
                $Checkdatem0650 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm070650 > 0) {
                $Checkdatem0650 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm080650 > 0) {
                $Checkdatem0650 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm090650 > 0) {
                $Checkdatem0650 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm100650 > 0) {
                $Checkdatem0650 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            } else if ($result_seDatedealerinm100650 > 0) {
                $Checkdatem0650 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm110650 > 0) {
                $Checkdatem0650 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm120650 > 0) {
                $Checkdatem0650 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm130650 > 0) {
                $Checkdatem0650 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm140650 > 0) {
                $Checkdatem0650 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm150650 > 0) {
                $Checkdatem0650 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm160650 > 0) {
                $Checkdatem0650 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm170650 > 0) {
                $Checkdatem0650 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm180650 > 0) {
                $Checkdatem0650 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm190650 > 0) {
                $Checkdatem0650 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm200650 > 0) {
                $Checkdatem0650 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem0650 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }
            
            
             $Checkdatem0700 = "";
            $result_seDatepresentm0700 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "07:00", "07:09");
            $result_seDatevlintm0700 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "07:09");
            $result_seDaterestm010700 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "07:09");
            $result_seDaterestm020700 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "07:09");
            $result_seDaterestm030700 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "07:09");
            $result_seDaterestm040700 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "07:09");
            $result_seDaterestm050700 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "07:09");
            $result_seDaterestm060700 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "07:09");
            $result_seDaterestm070700 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "07:09");
            $result_seDaterestm080700 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "07:09");
            $result_seDaterestm090700 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "07:09");
            $result_seDaterestm100700 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "07:09");
            $result_seDatedealerinm100700 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "07:09");
            $result_seDaterestm110700 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "07:09");
            $result_seDaterestm120700 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "07:09");
            $result_seDaterestm130700 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "07:09");
            $result_seDaterestm140700 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "07:09");
            $result_seDaterestm150700 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "07:09");
            $result_seDaterestm160700 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "07:09");
            $result_seDaterestm170700 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "07:09");
            $result_seDaterestm180700 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "07:09");
            $result_seDaterestm190700 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "07:09");
            $result_seDaterestm200700 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "07:09");
            if ($result_seDatepresentm0700 > 0) {
                $Checkdatem0700 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlintm0700 > 0) {
                $Checkdatem0700 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm010700 > 0) {
                $Checkdatem0700 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm020700 > 0) {
                $Checkdatem0700 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm030700 > 0) {
                $Checkdatem0700 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm040700 > 0) {
                $Checkdatem0700 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm050700 > 0) {
                $Checkdatem0700 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm060700 > 0) {
                $Checkdatem0700 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm070700 > 0) {
                $Checkdatem0700 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm080700 > 0) {
                $Checkdatem0700 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm090700 > 0) {
                $Checkdatem0700 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm100700 > 0) {
                $Checkdatem0700 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            }else if ($result_seDatedealerinm100700 > 0) {
                $Checkdatem0700 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm110700 > 0) {
                $Checkdatem0700 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm120700 > 0) {
                $Checkdatem0700 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm130700 > 0) {
                $Checkdatem0700 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm140700 > 0) {
                $Checkdatem0700 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm150700 > 0) {
                $Checkdatem0700 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm160700 > 0) {
                $Checkdatem0700 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm170700 > 0) {
                $Checkdatem0700 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm180700 > 0) {
                $Checkdatem0700 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm190700 > 0) {
                $Checkdatem0700 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm200700 > 0) {
                $Checkdatem0700 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem0700 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }

            $Checkdatem0710 = "";
            $result_seDatepresent0710 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "07:10", "07:19");
            $result_seDatevlint0710 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "07:19");
            $result_seDaterestm010710 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "07:19");
            $result_seDaterestm020710 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "07:19");
            $result_seDaterestm030710 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "07:19");
            $result_seDaterestm040710 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "07:19");
            $result_seDaterestm050710 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "07:19");
            $result_seDaterestm060710 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "07:19");
            $result_seDaterestm070710 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "07:19");
            $result_seDaterestm080710 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "07:19");
            $result_seDaterestm090710 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "07:19");
            $result_seDaterestm100710 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "07:19");
            $result_seDatedealerinm100710 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "07:19");
            $result_seDaterestm110710 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "07:19");
            $result_seDaterestm120710 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "07:19");
            $result_seDaterestm130710 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "07:19");
            $result_seDaterestm140710 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "07:19");
            $result_seDaterestm150710 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "07:19");
            $result_seDaterestm160710 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "07:19");
            $result_seDaterestm170710 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "07:19");
            $result_seDaterestm180710 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "07:19");
            $result_seDaterestm190710 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "07:19");
            $result_seDaterestm200710 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "07:19");
            if ($result_seDatepresent0710 > 0) {
                $Checkdatem0710 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint0710 > 0) {
                $Checkdatem0710 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm010710 > 0) {
                $Checkdatem0710 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm020710 > 0) {
                $Checkdatem0710 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm030710 > 0) {
                $Checkdatem0710 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm040710 > 0) {
                $Checkdatem0710 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm050710 > 0) {
                $Checkdatem0710 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm060710 > 0) {
                $Checkdatem0710 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm070710 > 0) {
                $Checkdatem0710 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm080710 > 0) {
                $Checkdatem0710 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm090710 > 0) {
                $Checkdatem0710 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDatedealerinm100710 > 0) {
                $Checkdatem0710 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm110710 > 0) {
                $Checkdatem0710 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm120710 > 0) {
                $Checkdatem0710 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm130710 > 0) {
                $Checkdatem0710 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm140710 > 0) {
                $Checkdatem0710 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm150710 > 0) {
                $Checkdatem0710 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm160710 > 0) {
                $Checkdatem0710 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm170710 > 0) {
                $Checkdatem0710 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm180710 > 0) {
                $Checkdatem0710 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm190710 > 0) {
                $Checkdatem0710 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm200710 > 0) {
                $Checkdatem0710 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            } else {
                $Checkdatem0710 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }
            $Checkdatem0720 = "";
            $result_seDatepresent0720 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "07:20", "07:29");
            $result_seDatevlint0720 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "07:29");
            $result_seDaterestm010720 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "07:29");
            $result_seDaterestm020720 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "07:29");
            $result_seDaterestm030720 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "07:29");
            $result_seDaterestm040720 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "07:29");
            $result_seDaterestm050720 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "07:29");
            $result_seDaterestm060720 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "07:29");
            $result_seDaterestm070720 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "07:29");
            $result_seDaterestm080720 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "07:29");
            $result_seDaterestm090720 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "07:29");
            $result_seDaterestm100720 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "07:29");
            $result_seDatedealerinm100720 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "07:29");
            $result_seDaterestm110720 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "07:29");
            $result_seDaterestm120720 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "07:29");
            $result_seDaterestm130720 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "07:29");
            $result_seDaterestm140720 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "07:29");
            $result_seDaterestm150720 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "07:29");
            $result_seDaterestm160720 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "07:29");
            $result_seDaterestm170720 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "07:29");
            $result_seDaterestm180720 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "07:29");
            $result_seDaterestm190720 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "07:29");
            $result_seDaterestm200720 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "07:29");
            if ($result_seDatepresent0720 > 0) {
                $Checkdatem0720 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint0720 > 0) {
                $Checkdatem0720 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm010720 > 0) {
                $Checkdatem0720 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm0205200 > 0) {
                $Checkdatem0720 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm030720 > 0) {
                $Checkdatem0720 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm040720 > 0) {
                $Checkdatem0720 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm050720 > 0) {
                $Checkdatem0720 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm060720 > 0) {
                $Checkdatem0720 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm070720 > 0) {
                $Checkdatem0720 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm080720 > 0) {
                $Checkdatem0720 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm090720 > 0) {
                $Checkdatem0720 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm100720 > 0) {
                $Checkdatem0720 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            } else if ($result_seDatedealerinm100720 > 0) {
                $Checkdatem0720 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm110720 > 0) {
                $Checkdatem0720 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm120720 > 0) {
                $Checkdatem0720 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm130720 > 0) {
                $Checkdatem0720 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm140720 > 0) {
                $Checkdatem0720 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm150720 > 0) {
                $Checkdatem0720 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm160720 > 0) {
                $Checkdatem0720 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm170720 > 0) {
                $Checkdatem0720 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm180720 > 0) {
                $Checkdatem0720 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm190720 > 0) {
                $Checkdatem0720 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm200720 > 0) {
                $Checkdatem0720 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem0720 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }

            $Checkdatem0730 = "";
            $result_seDatepresent0730 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "07:30", "07:39");
            $result_seDatevlint0730 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "07:39");
            $result_seDaterestm010730 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "07:39");
            $result_seDaterestm020730 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "07:39");
            $result_seDaterestm030730 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "07:39");
            $result_seDaterestm040730 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "07:39");
            $result_seDaterestm050730 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "07:39");
            $result_seDaterestm060730 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "07:39");
            $result_seDaterestm070730 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "07:39");
            $result_seDaterestm080730 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "07:39");
            $result_seDaterestm090730 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "07:39");
            $result_seDaterestm100730 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "07:39");
            $result_seDatedealerinm100730 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "07:39");
            $result_seDaterestm110730 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "07:39");
            $result_seDaterestm120730 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "07:39");
            $result_seDaterestm130730 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "07:39");
            $result_seDaterestm140730 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "07:39");
            $result_seDaterestm150730 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "07:39");
            $result_seDaterestm160730 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "07:39");
            $result_seDaterestm170730 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "07:39");
            $result_seDaterestm180730 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "07:39");
            $result_seDaterestm190730 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "07:39");
            $result_seDaterestm200730 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "07:39");
            if ($result_seDatepresent0730 > 0) {
                $Checkdatem0730 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint0730 > 0) {
                $Checkdatem0730 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm010730 > 0) {
                $Checkdatem0730 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm020730 > 0) {
                $Checkdatem0730 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm030730 > 0) {
                $Checkdatem0730 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm040730 > 0) {
                $Checkdatem0730 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm050730 > 0) {
                $Checkdatem0730 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm060730 > 0) {
                $Checkdatem0730 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm070730 > 0) {
                $Checkdatem0730 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm080730 > 0) {
                $Checkdatem0730 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm090730 > 0) {
                $Checkdatem0730 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm100730 > 0) {
                $Checkdatem0730 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            } else if ($result_seDatedealerinm100730 > 0) {
                $Checkdatem0730 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm110730 > 0) {
                $Checkdatem0730 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm120730 > 0) {
                $Checkdatem0730 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm130730 > 0) {
                $Checkdatem0730 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm140730 > 0) {
                $Checkdatem0730 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm150730 > 0) {
                $Checkdatem0730 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm160730 > 0) {
                $Checkdatem0730 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm170730 > 0) {
                $Checkdatem0730 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm180730 > 0) {
                $Checkdatem0730 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm190730 > 0) {
                $Checkdatem0730 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm200730 > 0) {
                $Checkdatem0730 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem0730 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }
            $Checkdatem0740 = "";
            $result_seDatepresent0740 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "07:40", "07:49");
            $result_seDatevlint0740 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "07:49");
            $result_seDaterestm010740 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "07:49");
            $result_seDaterestm020740 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "07:49");
            $result_seDaterestm030740 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "07:49");
            $result_seDaterestm040740 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "07:49");
            $result_seDaterestm050740 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "07:49");
            $result_seDaterestm060740 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "07:49");
            $result_seDaterestm070740 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "07:49");
            $result_seDaterestm080740 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "07:49");
            $result_seDaterestm090740 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "07:49");
            $result_seDaterestm100740 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "07:49");
            $result_seDatedealerinm100740 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "07:49");
            $result_seDaterestm110740 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "07:49");
            $result_seDaterestm120740 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "07:49");
            $result_seDaterestm130740 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "07:49");
            $result_seDaterestm140740 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "07:49");
            $result_seDaterestm150740 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "07:49");
            $result_seDaterestm160740 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "07:49");
            $result_seDaterestm170740 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "07:49");
            $result_seDaterestm180740 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "07:49");
            $result_seDaterestm190740 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "07:49");
            $result_seDaterestm200740 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "07:49");
            if ($result_seDatepresent0740 > 0) {
                $Checkdatem0740 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint0740 > 0) {
                $Checkdatem0740 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm010740 > 0) {
                $Checkdatem0740 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm0205400 > 0) {
                $Checkdatem0740 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm030740 > 0) {
                $Checkdatem0740 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm040740 > 0) {
                $Checkdatem0740 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm050740 > 0) {
                $Checkdatem0740 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm060740 > 0) {
                $Checkdatem0740 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm070740 > 0) {
                $Checkdatem0740 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm080740 > 0) {
                $Checkdatem0740 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm090740 > 0) {
                $Checkdatem0740 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm100740 > 0) {
                $Checkdatem0740 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            } else if ($result_seDatedealerinm100740 > 0) {
                $Checkdatem0740 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm110740 > 0) {
                $Checkdatem0740 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm120740 > 0) {
                $Checkdatem0740 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm130740 > 0) {
                $Checkdatem0740 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm140740 > 0) {
                $Checkdatem0740 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm150740 > 0) {
                $Checkdatem0740 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm160740 > 0) {
                $Checkdatem0740 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm170740 > 0) {
                $Checkdatem0740 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm180740 > 0) {
                $Checkdatem0740 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm190740 > 0) {
                $Checkdatem0740 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm200740 > 0) {
                $Checkdatem0740 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem0740 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }

            $Checkdatem0750 = "";
            $result_seDatepresent0750 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "07:50", "07:59");
            $result_seDatevlint0750 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "07:59");
            $result_seDaterestm010750 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "07:59");
            $result_seDaterestm020750 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "07:59");
            $result_seDaterestm030750 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "07:59");
            $result_seDaterestm040750 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "07:59");
            $result_seDaterestm050750 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "07:59");
            $result_seDaterestm060750 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "07:59");
            $result_seDaterestm070750 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "07:59");
            $result_seDaterestm080750 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "07:59");
            $result_seDaterestm090750 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "07:59");
            $result_seDaterestm100750 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "07:59");
            $result_seDatedealerinm100750 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "07:59");
            $result_seDaterestm110750 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "07:59");
            $result_seDaterestm120750 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "07:59");
            $result_seDaterestm130750 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "07:59");
            $result_seDaterestm140750 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "07:59");
            $result_seDaterestm150750 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "07:59");
            $result_seDaterestm160750 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "07:59");
            $result_seDaterestm170750 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "07:59");
            $result_seDaterestm180750 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "07:59");
            $result_seDaterestm190750 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "07:59");
            $result_seDaterestm200750 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "07:59");
            if ($result_seDatepresent0750 > 0) {
                $Checkdatem0750 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint0750 > 0) {
                $Checkdatem0750 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm010750 > 0) {
                $Checkdatem0750 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm020750 > 0) {
                $Checkdatem0750 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm030750 > 0) {
                $Checkdatem0750 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm040750 > 0) {
                $Checkdatem0750 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm050750 > 0) {
                $Checkdatem0750 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm060750 > 0) {
                $Checkdatem0750 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm070750 > 0) {
                $Checkdatem0750 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm080750 > 0) {
                $Checkdatem0750 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm090750 > 0) {
                $Checkdatem0750 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm100750 > 0) {
                $Checkdatem0750 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            } else if ($result_seDatedealerinm100750 > 0) {
                $Checkdatem0750 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm110750 > 0) {
                $Checkdatem0750 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm120750 > 0) {
                $Checkdatem0750 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm130750 > 0) {
                $Checkdatem0750 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm140750 > 0) {
                $Checkdatem0750 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm150750 > 0) {
                $Checkdatem0750 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm160750 > 0) {
                $Checkdatem0750 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm170750 > 0) {
                $Checkdatem0750 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm180750 > 0) {
                $Checkdatem0750 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm190750 > 0) {
                $Checkdatem0750 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm200750 > 0) {
                $Checkdatem0750 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem0750 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }
            
            
            
            $Checkdatem0800 = "";
            $result_seDatepresentm0800 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "08:00", "08:09");
            $result_seDatevlintm0800 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "08:09");
            $result_seDaterestm010800 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "08:09");
            $result_seDaterestm020800 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "08:09");
            $result_seDaterestm030800 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "08:09");
            $result_seDaterestm040800 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "08:09");
            $result_seDaterestm050800 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "08:09");
            $result_seDaterestm060800 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "08:09");
            $result_seDaterestm070800 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "08:09");
            $result_seDaterestm080800 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "08:09");
            $result_seDaterestm090800 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "08:09");
            $result_seDaterestm100800 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "08:09");
            $result_seDatedealerinm100800 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "08:09");
            $result_seDaterestm110800 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "08:09");
            $result_seDaterestm120800 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "08:09");
            $result_seDaterestm130800 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "08:09");
            $result_seDaterestm140800 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "08:09");
            $result_seDaterestm150800 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "08:09");
            $result_seDaterestm160800 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "08:09");
            $result_seDaterestm170800 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "08:09");
            $result_seDaterestm180800 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "08:09");
            $result_seDaterestm190800 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "08:09");
            $result_seDaterestm200800 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "08:09");
            if ($result_seDatepresentm0800 > 0) {
                $Checkdatem0800 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlintm0800 > 0) {
                $Checkdatem0800 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm010800 > 0) {
                $Checkdatem0800 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm020800 > 0) {
                $Checkdatem0800 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm030800 > 0) {
                $Checkdatem0800 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm040800 > 0) {
                $Checkdatem0800 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm050800 > 0) {
                $Checkdatem0800 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm060800 > 0) {
                $Checkdatem0800 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm070800 > 0) {
                $Checkdatem0800 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm080800 > 0) {
                $Checkdatem0800 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm090800 > 0) {
                $Checkdatem0800 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm100800 > 0) {
                $Checkdatem0800 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            }else if ($result_seDatedealerinm100800 > 0) {
                $Checkdatem0800 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm110800 > 0) {
                $Checkdatem0800 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm120800 > 0) {
                $Checkdatem0800 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm130800 > 0) {
                $Checkdatem0800 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm140800 > 0) {
                $Checkdatem0800 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm150800 > 0) {
                $Checkdatem0800 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm160800 > 0) {
                $Checkdatem0800 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm170800 > 0) {
                $Checkdatem0800 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm180800 > 0) {
                $Checkdatem0800 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm190800 > 0) {
                $Checkdatem0800 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm200800 > 0) {
                $Checkdatem0800 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem0800 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }

            $Checkdatem0810 = "";
            $result_seDatepresent0810 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "08:10", "08:19");
            $result_seDatevlint0810 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "08:19");
            $result_seDaterestm010810 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "08:19");
            $result_seDaterestm020810 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "08:19");
            $result_seDaterestm030810 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "08:19");
            $result_seDaterestm040810 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "08:19");
            $result_seDaterestm050810 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "08:19");
            $result_seDaterestm060810 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "08:19");
            $result_seDaterestm070810 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "08:19");
            $result_seDaterestm080810 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "08:19");
            $result_seDaterestm090810 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "08:19");
            $result_seDaterestm100810 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "08:19");
            $result_seDatedealerinm100810 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "08:19");
            $result_seDaterestm110810 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "08:19");
            $result_seDaterestm120810 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "08:19");
            $result_seDaterestm130810 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "08:19");
            $result_seDaterestm140810 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "08:19");
            $result_seDaterestm150810 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "08:19");
            $result_seDaterestm160810 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "08:19");
            $result_seDaterestm170810 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "08:19");
            $result_seDaterestm180810 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "08:19");
            $result_seDaterestm190810 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "08:19");
            $result_seDaterestm200810 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "08:19");
            if ($result_seDatepresent0810 > 0) {
                $Checkdatem0810 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint0810 > 0) {
                $Checkdatem0810 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm010810 > 0) {
                $Checkdatem0810 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm020810 > 0) {
                $Checkdatem0810 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm030810 > 0) {
                $Checkdatem0810 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm040810 > 0) {
                $Checkdatem0810 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm050810 > 0) {
                $Checkdatem0810 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm060810 > 0) {
                $Checkdatem0810 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm070810 > 0) {
                $Checkdatem0810 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm080810 > 0) {
                $Checkdatem0810 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm090810 > 0) {
                $Checkdatem0810 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDatedealerinm100810 > 0) {
                $Checkdatem0810 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm110810 > 0) {
                $Checkdatem0810 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm120810 > 0) {
                $Checkdatem0810 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm130810 > 0) {
                $Checkdatem0810 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm140810 > 0) {
                $Checkdatem0810 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm150810 > 0) {
                $Checkdatem0810 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm160810 > 0) {
                $Checkdatem0810 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm170810 > 0) {
                $Checkdatem0810 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm180810 > 0) {
                $Checkdatem0810 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm190810 > 0) {
                $Checkdatem0810 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm200810 > 0) {
                $Checkdatem0810 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            } else {
                $Checkdatem0810 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }
            $Checkdatem0820 = "";
            $result_seDatepresent0820 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "08:20", "08:29");
            $result_seDatevlint0820 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "08:29");
            $result_seDaterestm010820 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "08:29");
            $result_seDaterestm020820 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "08:29");
            $result_seDaterestm030820 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "08:29");
            $result_seDaterestm040820 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "08:29");
            $result_seDaterestm050820 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "08:29");
            $result_seDaterestm060820 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "08:29");
            $result_seDaterestm070820 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "08:29");
            $result_seDaterestm080820 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "08:29");
            $result_seDaterestm090820 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "08:29");
            $result_seDaterestm100820 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "08:29");
            $result_seDatedealerinm100820 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "08:29");
            $result_seDaterestm110820 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "08:29");
            $result_seDaterestm120820 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "08:29");
            $result_seDaterestm130820 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "08:29");
            $result_seDaterestm140820 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "08:29");
            $result_seDaterestm150820 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "08:29");
            $result_seDaterestm160820 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "08:29");
            $result_seDaterestm170820 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "08:29");
            $result_seDaterestm180820 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "08:29");
            $result_seDaterestm190820 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "08:29");
            $result_seDaterestm200820 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "08:29");
            if ($result_seDatepresent0820 > 0) {
                $Checkdatem0820 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint0820 > 0) {
                $Checkdatem0820 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm010820 > 0) {
                $Checkdatem0820 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm0205200 > 0) {
                $Checkdatem0820 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm030820 > 0) {
                $Checkdatem0820 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm040820 > 0) {
                $Checkdatem0820 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm050820 > 0) {
                $Checkdatem0820 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm060820 > 0) {
                $Checkdatem0820 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm070820 > 0) {
                $Checkdatem0820 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm080820 > 0) {
                $Checkdatem0820 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm090820 > 0) {
                $Checkdatem0820 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm100820 > 0) {
                $Checkdatem0820 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            } else if ($result_seDatedealerinm100820 > 0) {
                $Checkdatem0820 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm110820 > 0) {
                $Checkdatem0820 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm120820 > 0) {
                $Checkdatem0820 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm130820 > 0) {
                $Checkdatem0820 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm140820 > 0) {
                $Checkdatem0820 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm150820 > 0) {
                $Checkdatem0820 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm160820 > 0) {
                $Checkdatem0820 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm170820 > 0) {
                $Checkdatem0820 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm180820 > 0) {
                $Checkdatem0820 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm190820 > 0) {
                $Checkdatem0820 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm200820 > 0) {
                $Checkdatem0820 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem0820 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }

            $Checkdatem0830 = "";
            $result_seDatepresent0830 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "08:30", "08:39");
            $result_seDatevlint0830 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "08:39");
            $result_seDaterestm010830 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "08:39");
            $result_seDaterestm020830 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "08:39");
            $result_seDaterestm030830 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "08:39");
            $result_seDaterestm040830 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "08:39");
            $result_seDaterestm050830 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "08:39");
            $result_seDaterestm060830 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "08:39");
            $result_seDaterestm070830 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "08:39");
            $result_seDaterestm080830 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "08:39");
            $result_seDaterestm090830 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "08:39");
            $result_seDaterestm100830 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "08:39");
            $result_seDatedealerinm100830 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "08:39");
            $result_seDaterestm110830 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "08:39");
            $result_seDaterestm120830 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "08:39");
            $result_seDaterestm130830 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "08:39");
            $result_seDaterestm140830 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "08:39");
            $result_seDaterestm150830 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "08:39");
            $result_seDaterestm160830 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "08:39");
            $result_seDaterestm170830 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "08:39");
            $result_seDaterestm180830 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "08:39");
            $result_seDaterestm190830 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "08:39");
            $result_seDaterestm200830 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "08:39");
            if ($result_seDatepresent0830 > 0) {
                $Checkdatem0830 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint0830 > 0) {
                $Checkdatem0830 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm010830 > 0) {
                $Checkdatem0830 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm020830 > 0) {
                $Checkdatem0830 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm030830 > 0) {
                $Checkdatem0830 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm040830 > 0) {
                $Checkdatem0830 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm050830 > 0) {
                $Checkdatem0830 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm060830 > 0) {
                $Checkdatem0830 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm070830 > 0) {
                $Checkdatem0830 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm080830 > 0) {
                $Checkdatem0830 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm090830 > 0) {
                $Checkdatem0830 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm100830 > 0) {
                $Checkdatem0830 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            } else if ($result_seDatedealerinm100830 > 0) {
                $Checkdatem0830 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm110830 > 0) {
                $Checkdatem0830 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm120830 > 0) {
                $Checkdatem0830 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm130830 > 0) {
                $Checkdatem0830 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm140830 > 0) {
                $Checkdatem0830 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm150830 > 0) {
                $Checkdatem0830 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm160830 > 0) {
                $Checkdatem0830 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm170830 > 0) {
                $Checkdatem0830 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm180830 > 0) {
                $Checkdatem0830 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm190830 > 0) {
                $Checkdatem0830 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm200830 > 0) {
                $Checkdatem0830 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem0830 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }
            $Checkdatem0840 = "";
            $result_seDatepresent0840 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "08:40", "08:49");
            $result_seDatevlint0840 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "08:49");
            $result_seDaterestm010840 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "08:49");
            $result_seDaterestm020840 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "08:49");
            $result_seDaterestm030840 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "08:49");
            $result_seDaterestm040840 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "08:49");
            $result_seDaterestm050840 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "08:49");
            $result_seDaterestm060840 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "08:49");
            $result_seDaterestm070840 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "08:49");
            $result_seDaterestm080840 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "08:49");
            $result_seDaterestm090840 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "08:49");
            $result_seDaterestm100840 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "08:49");
            $result_seDatedealerinm100840 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "08:49");
            $result_seDaterestm110840 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "08:49");
            $result_seDaterestm120840 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "08:49");
            $result_seDaterestm130840 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "08:49");
            $result_seDaterestm140840 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "08:49");
            $result_seDaterestm150840 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "08:49");
            $result_seDaterestm160840 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "08:49");
            $result_seDaterestm170840 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "08:49");
            $result_seDaterestm180840 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "08:49");
            $result_seDaterestm190840 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "08:49");
            $result_seDaterestm200840 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "08:49");
            if ($result_seDatepresent0840 > 0) {
                $Checkdatem0840 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint0840 > 0) {
                $Checkdatem0840 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm010840 > 0) {
                $Checkdatem0840 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm0205400 > 0) {
                $Checkdatem0840 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm030840 > 0) {
                $Checkdatem0840 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm040840 > 0) {
                $Checkdatem0840 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm050840 > 0) {
                $Checkdatem0840 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm060840 > 0) {
                $Checkdatem0840 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm070840 > 0) {
                $Checkdatem0840 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm080840 > 0) {
                $Checkdatem0840 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm090840 > 0) {
                $Checkdatem0840 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm100840 > 0) {
                $Checkdatem0840 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            } else if ($result_seDatedealerinm100840 > 0) {
                $Checkdatem0840 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm110840 > 0) {
                $Checkdatem0840 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm120840 > 0) {
                $Checkdatem0840 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm130840 > 0) {
                $Checkdatem0840 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm140840 > 0) {
                $Checkdatem0840 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm150840 > 0) {
                $Checkdatem0840 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm160840 > 0) {
                $Checkdatem0840 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm170840 > 0) {
                $Checkdatem0840 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm180840 > 0) {
                $Checkdatem0840 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm190840 > 0) {
                $Checkdatem0840 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm200840 > 0) {
                $Checkdatem0840 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem0840 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }

            $Checkdatem0850 = "";
            $result_seDatepresent0850 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "08:50", "08:59");
            $result_seDatevlint0850 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "08:59");
            $result_seDaterestm010850 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "08:59");
            $result_seDaterestm020850 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "08:59");
            $result_seDaterestm030850 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "08:59");
            $result_seDaterestm040850 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "08:59");
            $result_seDaterestm050850 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "08:59");
            $result_seDaterestm060850 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "08:59");
            $result_seDaterestm070850 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "08:59");
            $result_seDaterestm080850 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "08:59");
            $result_seDaterestm090850 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "08:59");
            $result_seDaterestm100850 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "08:59");
            $result_seDatedealerinm100850 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "08:59");
            $result_seDaterestm110850 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "08:59");
            $result_seDaterestm120850 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "08:59");
            $result_seDaterestm130850 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "08:59");
            $result_seDaterestm140850 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "08:59");
            $result_seDaterestm150850 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "08:59");
            $result_seDaterestm160850 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "08:59");
            $result_seDaterestm170850 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "08:59");
            $result_seDaterestm180850 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "08:59");
            $result_seDaterestm190850 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "08:59");
            $result_seDaterestm200850 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "08:59");
            if ($result_seDatepresent0850 > 0) {
                $Checkdatem0850 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint0850 > 0) {
                $Checkdatem0850 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm010850 > 0) {
                $Checkdatem0850 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm020850 > 0) {
                $Checkdatem0850 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm030850 > 0) {
                $Checkdatem0850 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm040850 > 0) {
                $Checkdatem0850 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm050850 > 0) {
                $Checkdatem0850 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm060850 > 0) {
                $Checkdatem0850 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm070850 > 0) {
                $Checkdatem0850 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm080850 > 0) {
                $Checkdatem0850 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm090850 > 0) {
                $Checkdatem0850 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm100850 > 0) {
                $Checkdatem0850 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            } else if ($result_seDatedealerinm100850 > 0) {
                $Checkdatem0850 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm110850 > 0) {
                $Checkdatem0850 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm120850 > 0) {
                $Checkdatem0850 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm130850 > 0) {
                $Checkdatem0850 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm140850 > 0) {
                $Checkdatem0850 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm150850 > 0) {
                $Checkdatem0850 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm160850 > 0) {
                $Checkdatem0850 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm170850 > 0) {
                $Checkdatem0850 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm180850 > 0) {
                $Checkdatem0850 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm190850 > 0) {
                $Checkdatem0850 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm200850 > 0) {
                $Checkdatem0850 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem0850 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }
            
            
            
            $Checkdatem0900 = "";
            $result_seDatepresentm0900 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "09:00", "09:09");
            $result_seDatevlintm0900 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "09:09");
            $result_seDaterestm010900 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "09:09");
            $result_seDaterestm020900 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "09:09");
            $result_seDaterestm030900 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "09:09");
            $result_seDaterestm040900 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "09:09");
            $result_seDaterestm050900 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "09:09");
            $result_seDaterestm060900 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "09:09");
            $result_seDaterestm070900 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "09:09");
            $result_seDaterestm080900 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "09:09");
            $result_seDaterestm090900 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "09:09");
            $result_seDaterestm100900 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "09:09");
            $result_seDatedealerinm100900 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "09:09");
            $result_seDaterestm110900 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "09:09");
            $result_seDaterestm120900 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "09:09");
            $result_seDaterestm130900 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "09:09");
            $result_seDaterestm140900 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "09:09");
            $result_seDaterestm150900 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "09:09");
            $result_seDaterestm160900 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "09:09");
            $result_seDaterestm170900 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "09:09");
            $result_seDaterestm180900 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "09:09");
            $result_seDaterestm190900 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "09:09");
            $result_seDaterestm200900 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "09:09");
            if ($result_seDatepresentm0900 > 0) {
                $Checkdatem0900 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlintm0900 > 0) {
                $Checkdatem0900 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm010900 > 0) {
                $Checkdatem0900 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm020900 > 0) {
                $Checkdatem0900 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm030900 > 0) {
                $Checkdatem0900 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm040900 > 0) {
                $Checkdatem0900 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm050900 > 0) {
                $Checkdatem0900 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm060900 > 0) {
                $Checkdatem0900 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm070900 > 0) {
                $Checkdatem0900 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm080900 > 0) {
                $Checkdatem0900 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm090900 > 0) {
                $Checkdatem0900 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm100900 > 0) {
                $Checkdatem0900 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            }else if ($result_seDatedealerinm100900 > 0) {
                $Checkdatem0900 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm110900 > 0) {
                $Checkdatem0900 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm120900 > 0) {
                $Checkdatem0900 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm130900 > 0) {
                $Checkdatem0900 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm140900 > 0) {
                $Checkdatem0900 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm150900 > 0) {
                $Checkdatem0900 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm160900 > 0) {
                $Checkdatem0900 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm170900 > 0) {
                $Checkdatem0900 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm180900 > 0) {
                $Checkdatem0900 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm190900 > 0) {
                $Checkdatem0900 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm200900 > 0) {
                $Checkdatem0900 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem0900 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }

            $Checkdatem0910 = "";
            $result_seDatepresent0910 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "09:10", "09:19");
            $result_seDatevlint0910 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "09:19");
            $result_seDaterestm010910 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "09:19");
            $result_seDaterestm020910 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "09:19");
            $result_seDaterestm030910 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "09:19");
            $result_seDaterestm040910 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "09:19");
            $result_seDaterestm050910 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "09:19");
            $result_seDaterestm060910 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "09:19");
            $result_seDaterestm070910 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "09:19");
            $result_seDaterestm080910 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "09:19");
            $result_seDaterestm090910 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "09:19");
            $result_seDaterestm100910 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "09:19");
            $result_seDatedealerinm100910 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "09:19");
            $result_seDaterestm110910 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "09:19");
            $result_seDaterestm120910 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "09:19");
            $result_seDaterestm130910 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "09:19");
            $result_seDaterestm140910 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "09:19");
            $result_seDaterestm150910 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "09:19");
            $result_seDaterestm160910 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "09:19");
            $result_seDaterestm170910 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "09:19");
            $result_seDaterestm180910 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "09:19");
            $result_seDaterestm190910 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "09:19");
            $result_seDaterestm200910 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "09:19");
            if ($result_seDatepresent0910 > 0) {
                $Checkdatem0910 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint0910 > 0) {
                $Checkdatem0910 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm010910 > 0) {
                $Checkdatem0910 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm020910 > 0) {
                $Checkdatem0910 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm030910 > 0) {
                $Checkdatem0910 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm040910 > 0) {
                $Checkdatem0910 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm050910 > 0) {
                $Checkdatem0910 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm060910 > 0) {
                $Checkdatem0910 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm070910 > 0) {
                $Checkdatem0910 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm080910 > 0) {
                $Checkdatem0910 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm090910 > 0) {
                $Checkdatem0910 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDatedealerinm100910 > 0) {
                $Checkdatem0910 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm110910 > 0) {
                $Checkdatem0910 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm120910 > 0) {
                $Checkdatem0910 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm130910 > 0) {
                $Checkdatem0910 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm140910 > 0) {
                $Checkdatem0910 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm150910 > 0) {
                $Checkdatem0910 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm160910 > 0) {
                $Checkdatem0910 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm170910 > 0) {
                $Checkdatem0910 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm180910 > 0) {
                $Checkdatem0910 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm190910 > 0) {
                $Checkdatem0910 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm200910 > 0) {
                $Checkdatem0910 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            } else {
                $Checkdatem0910 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }
            $Checkdatem0920 = "";
            $result_seDatepresent0920 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "09:20", "09:29");
            $result_seDatevlint0920 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "09:29");
            $result_seDaterestm010920 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "09:29");
            $result_seDaterestm020920 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "09:29");
            $result_seDaterestm030920 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "09:29");
            $result_seDaterestm040920 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "09:29");
            $result_seDaterestm050920 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "09:29");
            $result_seDaterestm060920 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "09:29");
            $result_seDaterestm070920 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "09:29");
            $result_seDaterestm080920 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "09:29");
            $result_seDaterestm090920 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "09:29");
            $result_seDaterestm100920 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "09:29");
            $result_seDatedealerinm100920 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "09:29");
            $result_seDaterestm110920 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "09:29");
            $result_seDaterestm120920 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "09:29");
            $result_seDaterestm130920 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "09:29");
            $result_seDaterestm140920 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "09:29");
            $result_seDaterestm150920 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "09:29");
            $result_seDaterestm160920 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "09:29");
            $result_seDaterestm170920 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "09:29");
            $result_seDaterestm180920 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "09:29");
            $result_seDaterestm190920 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "09:29");
            $result_seDaterestm200920 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "09:29");
            if ($result_seDatepresent0920 > 0) {
                $Checkdatem0920 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint0920 > 0) {
                $Checkdatem0920 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm010920 > 0) {
                $Checkdatem0920 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm0205200 > 0) {
                $Checkdatem0920 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm030920 > 0) {
                $Checkdatem0920 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm040920 > 0) {
                $Checkdatem0920 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm050920 > 0) {
                $Checkdatem0920 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm060920 > 0) {
                $Checkdatem0920 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm070920 > 0) {
                $Checkdatem0920 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm080920 > 0) {
                $Checkdatem0920 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm090920 > 0) {
                $Checkdatem0920 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm100920 > 0) {
                $Checkdatem0920 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            } else if ($result_seDatedealerinm100920 > 0) {
                $Checkdatem0920 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm110920 > 0) {
                $Checkdatem0920 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm120920 > 0) {
                $Checkdatem0920 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm130920 > 0) {
                $Checkdatem0920 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm140920 > 0) {
                $Checkdatem0920 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm150920 > 0) {
                $Checkdatem0920 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm160920 > 0) {
                $Checkdatem0920 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm170920 > 0) {
                $Checkdatem0920 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm180920 > 0) {
                $Checkdatem0920 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm190920 > 0) {
                $Checkdatem0920 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm200920 > 0) {
                $Checkdatem0920 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem0920 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }

            $Checkdatem0930 = "";
            $result_seDatepresent0930 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "09:30", "09:39");
            $result_seDatevlint0930 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "09:39");
            $result_seDaterestm010930 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "09:39");
            $result_seDaterestm020930 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "09:39");
            $result_seDaterestm030930 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "09:39");
            $result_seDaterestm040930 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "09:39");
            $result_seDaterestm050930 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "09:39");
            $result_seDaterestm060930 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "09:39");
            $result_seDaterestm070930 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "09:39");
            $result_seDaterestm080930 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "09:39");
            $result_seDaterestm090930 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "09:39");
            $result_seDaterestm100930 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "09:39");
            $result_seDatedealerinm100930 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "09:39");
            $result_seDaterestm110930 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "09:39");
            $result_seDaterestm120930 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "09:39");
            $result_seDaterestm130930 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "09:39");
            $result_seDaterestm140930 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "09:39");
            $result_seDaterestm150930 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "09:39");
            $result_seDaterestm160930 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "09:39");
            $result_seDaterestm170930 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "09:39");
            $result_seDaterestm180930 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "09:39");
            $result_seDaterestm190930 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "09:39");
            $result_seDaterestm200930 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "09:39");
            if ($result_seDatepresent0930 > 0) {
                $Checkdatem0930 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint0930 > 0) {
                $Checkdatem0930 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm010930 > 0) {
                $Checkdatem0930 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm020930 > 0) {
                $Checkdatem0930 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm030930 > 0) {
                $Checkdatem0930 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm040930 > 0) {
                $Checkdatem0930 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm050930 > 0) {
                $Checkdatem0930 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm060930 > 0) {
                $Checkdatem0930 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm070930 > 0) {
                $Checkdatem0930 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm080930 > 0) {
                $Checkdatem0930 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm090930 > 0) {
                $Checkdatem0930 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm100930 > 0) {
                $Checkdatem0930 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            } else if ($result_seDatedealerinm100930 > 0) {
                $Checkdatem0930 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm110930 > 0) {
                $Checkdatem0930 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm120930 > 0) {
                $Checkdatem0930 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm130930 > 0) {
                $Checkdatem0930 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm140930 > 0) {
                $Checkdatem0930 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm150930 > 0) {
                $Checkdatem0930 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm160930 > 0) {
                $Checkdatem0930 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm170930 > 0) {
                $Checkdatem0930 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm180930 > 0) {
                $Checkdatem0930 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm190930 > 0) {
                $Checkdatem0930 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm200930 > 0) {
                $Checkdatem0930 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem0930 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }
            $Checkdatem0940 = "";
            $result_seDatepresent0940 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "09:40", "09:49");
            $result_seDatevlint0940 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "09:49");
            $result_seDaterestm010940 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "09:49");
            $result_seDaterestm020940 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "09:49");
            $result_seDaterestm030940 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "09:49");
            $result_seDaterestm040940 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "09:49");
            $result_seDaterestm050940 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "09:49");
            $result_seDaterestm060940 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "09:49");
            $result_seDaterestm070940 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "09:49");
            $result_seDaterestm080940 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "09:49");
            $result_seDaterestm090940 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "09:49");
            $result_seDaterestm100940 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "09:49");
            $result_seDatedealerinm100940 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "09:49");
            $result_seDaterestm110940 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "09:49");
            $result_seDaterestm120940 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "09:49");
            $result_seDaterestm130940 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "09:49");
            $result_seDaterestm140940 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "09:49");
            $result_seDaterestm150940 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "09:49");
            $result_seDaterestm160940 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "09:49");
            $result_seDaterestm170940 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "09:49");
            $result_seDaterestm180940 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "09:49");
            $result_seDaterestm190940 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "09:49");
            $result_seDaterestm200940 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "09:49");
            if ($result_seDatepresent0940 > 0) {
                $Checkdatem0940 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint0940 > 0) {
                $Checkdatem0940 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm010940 > 0) {
                $Checkdatem0940 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm0205400 > 0) {
                $Checkdatem0940 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm030940 > 0) {
                $Checkdatem0940 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm040940 > 0) {
                $Checkdatem0940 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm050940 > 0) {
                $Checkdatem0940 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm060940 > 0) {
                $Checkdatem0940 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm070940 > 0) {
                $Checkdatem0940 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm080940 > 0) {
                $Checkdatem0940 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm090940 > 0) {
                $Checkdatem0940 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm100940 > 0) {
                $Checkdatem0940 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            } else if ($result_seDatedealerinm100940 > 0) {
                $Checkdatem0940 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm110940 > 0) {
                $Checkdatem0940 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm120940 > 0) {
                $Checkdatem0940 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm130940 > 0) {
                $Checkdatem0940 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm140940 > 0) {
                $Checkdatem0940 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm150940 > 0) {
                $Checkdatem0940 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm160940 > 0) {
                $Checkdatem0940 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm170940 > 0) {
                $Checkdatem0940 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm180940 > 0) {
                $Checkdatem0940 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm190940 > 0) {
                $Checkdatem0940 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm200940 > 0) {
                $Checkdatem0940 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem0940 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }

            $Checkdatem0950 = "";
            $result_seDatepresent0950 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "09:50", "09:59");
            $result_seDatevlint0950 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "09:59");
            $result_seDaterestm010950 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "09:59");
            $result_seDaterestm020950 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "09:59");
            $result_seDaterestm030950 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "09:59");
            $result_seDaterestm040950 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "09:59");
            $result_seDaterestm050950 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "09:59");
            $result_seDaterestm060950 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "09:59");
            $result_seDaterestm070950 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "09:59");
            $result_seDaterestm080950 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "09:59");
            $result_seDaterestm090950 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "09:59");
            $result_seDaterestm100950 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "09:59");
            $result_seDatedealerinm100950 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "09:59");
            $result_seDaterestm110950 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "09:59");
            $result_seDaterestm120950 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "09:59");
            $result_seDaterestm130950 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "09:59");
            $result_seDaterestm140950 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "09:59");
            $result_seDaterestm150950 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "09:59");
            $result_seDaterestm160950 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "09:59");
            $result_seDaterestm170950 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "09:59");
            $result_seDaterestm180950 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "09:59");
            $result_seDaterestm190950 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "09:59");
            $result_seDaterestm200950 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "09:59");
            if ($result_seDatepresent0950 > 0) {
                $Checkdatem0950 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint0950 > 0) {
                $Checkdatem0950 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm010950 > 0) {
                $Checkdatem0950 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm020950 > 0) {
                $Checkdatem0950 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm030950 > 0) {
                $Checkdatem0950 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm040950 > 0) {
                $Checkdatem0950 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm050950 > 0) {
                $Checkdatem0950 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm060950 > 0) {
                $Checkdatem0950 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm070950 > 0) {
                $Checkdatem0950 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm080950 > 0) {
                $Checkdatem0950 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm090950 > 0) {
                $Checkdatem0950 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm100950 > 0) {
                $Checkdatem0950 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            } else if ($result_seDatedealerinm100950 > 0) {
                $Checkdatem0950 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm110950 > 0) {
                $Checkdatem0950 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm120950 > 0) {
                $Checkdatem0950 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm130950 > 0) {
                $Checkdatem0950 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm140950 > 0) {
                $Checkdatem0950 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm150950 > 0) {
                $Checkdatem0950 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm160950 > 0) {
                $Checkdatem0950 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm170950 > 0) {
                $Checkdatem0950 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm180950 > 0) {
                $Checkdatem0950 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm190950 > 0) {
                $Checkdatem0950 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm200950 > 0) {
                $Checkdatem0950 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem0950 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }
            
            
            $Checkdatem1000 = "";
            $result_seDatepresentm1000 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "10:00", "10:09");
            $result_seDatevlintm1000 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "10:09");
            $result_seDaterestm011000 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "10:09");
            $result_seDaterestm021000 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "10:09");
            $result_seDaterestm031000 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "10:09");
            $result_seDaterestm041000 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "10:09");
            $result_seDaterestm051000 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "10:09");
            $result_seDaterestm061000 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "10:09");
            $result_seDaterestm071000 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "10:09");
            $result_seDaterestm081000 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "10:09");
            $result_seDaterestm091000 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "10:09");
            $result_seDaterestm101000 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "10:09");
            $result_seDatedealerinm101000 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "10:09");
            $result_seDaterestm111000 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "10:09");
            $result_seDaterestm121000 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "10:09");
            $result_seDaterestm131000 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "10:09");
            $result_seDaterestm141000 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "10:09");
            $result_seDaterestm151000 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "10:09");
            $result_seDaterestm161000 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "10:09");
            $result_seDaterestm171000 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "10:09");
            $result_seDaterestm181000 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "10:09");
            $result_seDaterestm191000 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "10:09");
            $result_seDaterestm201000 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "10:09");
            if ($result_seDatepresentm1000 > 0) {
                $Checkdatem1000 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlintm1000 > 0) {
                $Checkdatem1000 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm011000 > 0) {
                $Checkdatem1000 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm021000 > 0) {
                $Checkdatem1000 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm031000 > 0) {
                $Checkdatem1000 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm041000 > 0) {
                $Checkdatem1000 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm051000 > 0) {
                $Checkdatem1000 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm061000 > 0) {
                $Checkdatem1000 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm071000 > 0) {
                $Checkdatem1000 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm081000 > 0) {
                $Checkdatem1000 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm091000 > 0) {
                $Checkdatem1000 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm101000 > 0) {
                $Checkdatem1000 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            }else if ($result_seDatedealerinm101000 > 0) {
                $Checkdatem1000 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm111000 > 0) {
                $Checkdatem1000 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm121000 > 0) {
                $Checkdatem1000 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm131000 > 0) {
                $Checkdatem1000 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm141000 > 0) {
                $Checkdatem1000 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm151000 > 0) {
                $Checkdatem1000 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm161000 > 0) {
                $Checkdatem1000 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm171000 > 0) {
                $Checkdatem1000 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm181000 > 0) {
                $Checkdatem1000 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm191000 > 0) {
                $Checkdatem1000 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm201000 > 0) {
                $Checkdatem1000 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem1000 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }

            $Checkdatem1010 = "";
            $result_seDatepresent1010 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "10:10", "10:19");
            $result_seDatevlint1010 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "10:19");
            $result_seDaterestm011010 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "10:19");
            $result_seDaterestm021010 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "10:19");
            $result_seDaterestm031010 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "10:19");
            $result_seDaterestm041010 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "10:19");
            $result_seDaterestm051010 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "10:19");
            $result_seDaterestm061010 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "10:19");
            $result_seDaterestm071010 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "10:19");
            $result_seDaterestm081010 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "10:19");
            $result_seDaterestm091010 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "10:19");
            $result_seDaterestm101010 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "10:19");
            $result_seDatedealerinm101010 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "10:19");
            $result_seDaterestm111010 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "10:19");
            $result_seDaterestm121010 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "10:19");
            $result_seDaterestm131010 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "10:19");
            $result_seDaterestm141010 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "10:19");
            $result_seDaterestm151010 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "10:19");
            $result_seDaterestm161010 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "10:19");
            $result_seDaterestm171010 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "10:19");
            $result_seDaterestm181010 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "10:19");
            $result_seDaterestm191010 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "10:19");
            $result_seDaterestm201010 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "10:19");
            if ($result_seDatepresent1010 > 0) {
                $Checkdatem1010 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint1010 > 0) {
                $Checkdatem1010 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm011010 > 0) {
                $Checkdatem1010 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm021010 > 0) {
                $Checkdatem1010 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm031010 > 0) {
                $Checkdatem1010 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm041010 > 0) {
                $Checkdatem1010 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm051010 > 0) {
                $Checkdatem1010 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm061010 > 0) {
                $Checkdatem1010 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm071010 > 0) {
                $Checkdatem1010 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm081010 > 0) {
                $Checkdatem1010 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm091010 > 0) {
                $Checkdatem1010 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDatedealerinm101010 > 0) {
                $Checkdatem1010 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm111010 > 0) {
                $Checkdatem1010 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm121010 > 0) {
                $Checkdatem1010 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm131010 > 0) {
                $Checkdatem1010 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm141010 > 0) {
                $Checkdatem1010 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm151010 > 0) {
                $Checkdatem1010 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm161010 > 0) {
                $Checkdatem1010 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm171010 > 0) {
                $Checkdatem1010 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm181010 > 0) {
                $Checkdatem1010 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm191010 > 0) {
                $Checkdatem1010 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm201010 > 0) {
                $Checkdatem1010 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            } else {
                $Checkdatem1010 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }
            $Checkdatem1020 = "";
            $result_seDatepresent1020 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "10:20", "10:29");
            $result_seDatevlint1020 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "10:29");
            $result_seDaterestm011020 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "10:29");
            $result_seDaterestm021020 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "10:29");
            $result_seDaterestm031020 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "10:29");
            $result_seDaterestm041020 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "10:29");
            $result_seDaterestm051020 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "10:29");
            $result_seDaterestm061020 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "10:29");
            $result_seDaterestm071020 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "10:29");
            $result_seDaterestm081020 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "10:29");
            $result_seDaterestm091020 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "10:29");
            $result_seDaterestm101020 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "10:29");
            $result_seDatedealerinm101020 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "10:29");
            $result_seDaterestm111020 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "10:29");
            $result_seDaterestm121020 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "10:29");
            $result_seDaterestm131020 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "10:29");
            $result_seDaterestm141020 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "10:29");
            $result_seDaterestm151020 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "10:29");
            $result_seDaterestm161020 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "10:29");
            $result_seDaterestm171020 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "10:29");
            $result_seDaterestm181020 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "10:29");
            $result_seDaterestm191020 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "10:29");
            $result_seDaterestm201020 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "10:29");
            if ($result_seDatepresent1020 > 0) {
                $Checkdatem1020 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint1020 > 0) {
                $Checkdatem1020 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm011020 > 0) {
                $Checkdatem1020 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm0205200 > 0) {
                $Checkdatem1020 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm031020 > 0) {
                $Checkdatem1020 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm041020 > 0) {
                $Checkdatem1020 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm051020 > 0) {
                $Checkdatem1020 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm061020 > 0) {
                $Checkdatem1020 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm071020 > 0) {
                $Checkdatem1020 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm081020 > 0) {
                $Checkdatem1020 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm091020 > 0) {
                $Checkdatem1020 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm101020 > 0) {
                $Checkdatem1020 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            } else if ($result_seDatedealerinm101020 > 0) {
                $Checkdatem1020 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm111020 > 0) {
                $Checkdatem1020 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm121020 > 0) {
                $Checkdatem1020 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm131020 > 0) {
                $Checkdatem1020 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm141020 > 0) {
                $Checkdatem1020 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm151020 > 0) {
                $Checkdatem1020 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm161020 > 0) {
                $Checkdatem1020 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm171020 > 0) {
                $Checkdatem1020 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm181020 > 0) {
                $Checkdatem1020 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm191020 > 0) {
                $Checkdatem1020 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm201020 > 0) {
                $Checkdatem1020 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem1020 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }

            $Checkdatem1030 = "";
            $result_seDatepresent1030 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "10:30", "10:39");
            $result_seDatevlint1030 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "10:39");
            $result_seDaterestm011030 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "10:39");
            $result_seDaterestm021030 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "10:39");
            $result_seDaterestm031030 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "10:39");
            $result_seDaterestm041030 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "10:39");
            $result_seDaterestm051030 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "10:39");
            $result_seDaterestm061030 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "10:39");
            $result_seDaterestm071030 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "10:39");
            $result_seDaterestm081030 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "10:39");
            $result_seDaterestm091030 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "10:39");
            $result_seDaterestm101030 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "10:39");
            $result_seDatedealerinm101030 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "10:39");
            $result_seDaterestm111030 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "10:39");
            $result_seDaterestm121030 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "10:39");
            $result_seDaterestm131030 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "10:39");
            $result_seDaterestm141030 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "10:39");
            $result_seDaterestm151030 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "10:39");
            $result_seDaterestm161030 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "10:39");
            $result_seDaterestm171030 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "10:39");
            $result_seDaterestm181030 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "10:39");
            $result_seDaterestm191030 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "10:39");
            $result_seDaterestm201030 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "10:39");
            if ($result_seDatepresent1030 > 0) {
                $Checkdatem1030 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint1030 > 0) {
                $Checkdatem1030 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm011030 > 0) {
                $Checkdatem1030 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm021030 > 0) {
                $Checkdatem1030 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm031030 > 0) {
                $Checkdatem1030 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm041030 > 0) {
                $Checkdatem1030 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm051030 > 0) {
                $Checkdatem1030 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm061030 > 0) {
                $Checkdatem1030 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm071030 > 0) {
                $Checkdatem1030 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm081030 > 0) {
                $Checkdatem1030 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm091030 > 0) {
                $Checkdatem1030 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm101030 > 0) {
                $Checkdatem1030 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            } else if ($result_seDatedealerinm101030 > 0) {
                $Checkdatem1030 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm111030 > 0) {
                $Checkdatem1030 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm121030 > 0) {
                $Checkdatem1030 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm131030 > 0) {
                $Checkdatem1030 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm141030 > 0) {
                $Checkdatem1030 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm151030 > 0) {
                $Checkdatem1030 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm161030 > 0) {
                $Checkdatem1030 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm171030 > 0) {
                $Checkdatem1030 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm181030 > 0) {
                $Checkdatem1030 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm191030 > 0) {
                $Checkdatem1030 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm201030 > 0) {
                $Checkdatem1030 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem1030 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }
            $Checkdatem1040 = "";
            $result_seDatepresent1040 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "10:40", "10:49");
            $result_seDatevlint1040 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "10:49");
            $result_seDaterestm011040 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "10:49");
            $result_seDaterestm021040 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "10:49");
            $result_seDaterestm031040 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "10:49");
            $result_seDaterestm041040 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "10:49");
            $result_seDaterestm051040 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "10:49");
            $result_seDaterestm061040 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "10:49");
            $result_seDaterestm071040 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "10:49");
            $result_seDaterestm081040 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "10:49");
            $result_seDaterestm091040 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "10:49");
            $result_seDaterestm101040 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "10:49");
            $result_seDatedealerinm101040 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "10:49");
            $result_seDaterestm111040 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "10:49");
            $result_seDaterestm121040 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "10:49");
            $result_seDaterestm131040 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "10:49");
            $result_seDaterestm141040 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "10:49");
            $result_seDaterestm151040 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "10:49");
            $result_seDaterestm161040 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "10:49");
            $result_seDaterestm171040 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "10:49");
            $result_seDaterestm181040 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "10:49");
            $result_seDaterestm191040 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "10:49");
            $result_seDaterestm201040 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "10:49");
            if ($result_seDatepresent1040 > 0) {
                $Checkdatem1040 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint1040 > 0) {
                $Checkdatem1040 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm011040 > 0) {
                $Checkdatem1040 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm0205400 > 0) {
                $Checkdatem1040 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm031040 > 0) {
                $Checkdatem1040 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm041040 > 0) {
                $Checkdatem1040 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm051040 > 0) {
                $Checkdatem1040 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm061040 > 0) {
                $Checkdatem1040 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm071040 > 0) {
                $Checkdatem1040 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm081040 > 0) {
                $Checkdatem1040 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm091040 > 0) {
                $Checkdatem1040 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm101040 > 0) {
                $Checkdatem1040 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            } else if ($result_seDatedealerinm101040 > 0) {
                $Checkdatem1040 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm111040 > 0) {
                $Checkdatem1040 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm121040 > 0) {
                $Checkdatem1040 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm131040 > 0) {
                $Checkdatem1040 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm141040 > 0) {
                $Checkdatem1040 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm151040 > 0) {
                $Checkdatem1040 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm161040 > 0) {
                $Checkdatem1040 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm171040 > 0) {
                $Checkdatem1040 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm181040 > 0) {
                $Checkdatem1040 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm191040 > 0) {
                $Checkdatem1040 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm201040 > 0) {
                $Checkdatem1040 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem1040 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }

            $Checkdatem1050 = "";
            $result_seDatepresent1050 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "10:50", "10:59");
            $result_seDatevlint1050 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "10:59");
            $result_seDaterestm011050 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "10:59");
            $result_seDaterestm021050 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "10:59");
            $result_seDaterestm031050 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "10:59");
            $result_seDaterestm041050 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "10:59");
            $result_seDaterestm051050 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "10:59");
            $result_seDaterestm061050 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "10:59");
            $result_seDaterestm071050 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "10:59");
            $result_seDaterestm081050 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "10:59");
            $result_seDaterestm091050 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "10:59");
            $result_seDaterestm101050 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "10:59");
            $result_seDatedealerinm101050 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "10:59");
            $result_seDaterestm111050 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "10:59");
            $result_seDaterestm121050 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "10:59");
            $result_seDaterestm131050 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "10:59");
            $result_seDaterestm141050 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "10:59");
            $result_seDaterestm151050 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "10:59");
            $result_seDaterestm161050 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "10:59");
            $result_seDaterestm171050 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "10:59");
            $result_seDaterestm181050 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "10:59");
            $result_seDaterestm191050 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "10:59");
            $result_seDaterestm201050 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "10:59");
            if ($result_seDatepresent1050 > 0) {
                $Checkdatem1050 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint1050 > 0) {
                $Checkdatem1050 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm011050 > 0) {
                $Checkdatem1050 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm021050 > 0) {
                $Checkdatem1050 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm031050 > 0) {
                $Checkdatem1050 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm041050 > 0) {
                $Checkdatem1050 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm051050 > 0) {
                $Checkdatem1050 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm061050 > 0) {
                $Checkdatem1050 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm071050 > 0) {
                $Checkdatem1050 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm081050 > 0) {
                $Checkdatem1050 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm091050 > 0) {
                $Checkdatem1050 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm101050 > 0) {
                $Checkdatem1050 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            } else if ($result_seDatedealerinm101050 > 0) {
                $Checkdatem1050 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm111050 > 0) {
                $Checkdatem1050 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm121050 > 0) {
                $Checkdatem1050 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm131050 > 0) {
                $Checkdatem1050 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm141050 > 0) {
                $Checkdatem1050 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm151050 > 0) {
                $Checkdatem1050 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm161050 > 0) {
                $Checkdatem1050 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm171050 > 0) {
                $Checkdatem1050 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm181050 > 0) {
                $Checkdatem1050 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm191050 > 0) {
                $Checkdatem1050 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm201050 > 0) {
                $Checkdatem1050 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem1050 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }
            
            
            
            $Checkdatem1100 = "";
            $result_seDatepresentm1100 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "11:00", "11:09");
            $result_seDatevlintm1100 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "11:09");
            $result_seDaterestm011100 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "11:09");
            $result_seDaterestm021100 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "11:09");
            $result_seDaterestm031100 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "11:09");
            $result_seDaterestm041100 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "11:09");
            $result_seDaterestm051100 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "11:09");
            $result_seDaterestm061100 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "11:09");
            $result_seDaterestm071100 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "11:09");
            $result_seDaterestm081100 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "11:09");
            $result_seDaterestm091100 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "11:09");
            $result_seDaterestm101100 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "11:09");
            $result_seDatedealerinm101100 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "11:09");
            $result_seDaterestm111100 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "11:09");
            $result_seDaterestm121100 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "11:09");
            $result_seDaterestm131100 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "11:09");
            $result_seDaterestm141100 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "11:09");
            $result_seDaterestm151100 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "11:09");
            $result_seDaterestm161100 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "11:09");
            $result_seDaterestm171100 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "11:09");
            $result_seDaterestm181100 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "11:09");
            $result_seDaterestm191100 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "11:09");
            $result_seDaterestm201100 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "11:09");
            if ($result_seDatepresentm1100 > 0) {
                $Checkdatem1100 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlintm1100 > 0) {
                $Checkdatem1100 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm011100 > 0) {
                $Checkdatem1100 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm021100 > 0) {
                $Checkdatem1100 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm031100 > 0) {
                $Checkdatem1100 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm041100 > 0) {
                $Checkdatem1100 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm051100 > 0) {
                $Checkdatem1100 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm061100 > 0) {
                $Checkdatem1100 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm071100 > 0) {
                $Checkdatem1100 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm081100 > 0) {
                $Checkdatem1100 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm091100 > 0) {
                $Checkdatem1100 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm101100 > 0) {
                $Checkdatem1100 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            }else if ($result_seDatedealerinm101100 > 0) {
                $Checkdatem1100 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm111100 > 0) {
                $Checkdatem1100 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm121100 > 0) {
                $Checkdatem1100 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm131100 > 0) {
                $Checkdatem1100 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm141100 > 0) {
                $Checkdatem1100 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm151100 > 0) {
                $Checkdatem1100 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm161100 > 0) {
                $Checkdatem1100 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm171100 > 0) {
                $Checkdatem1100 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm181100 > 0) {
                $Checkdatem1100 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm191100 > 0) {
                $Checkdatem1100 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm201100 > 0) {
                $Checkdatem1100 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem1100 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }

            $Checkdatem1110 = "";
            $result_seDatepresent1110 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "11:10", "11:19");
            $result_seDatevlint1110 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "11:19");
            $result_seDaterestm011110 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "11:19");
            $result_seDaterestm021110 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "11:19");
            $result_seDaterestm031110 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "11:19");
            $result_seDaterestm041110 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "11:19");
            $result_seDaterestm051110 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "11:19");
            $result_seDaterestm061110 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "11:19");
            $result_seDaterestm071110 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "11:19");
            $result_seDaterestm081110 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "11:19");
            $result_seDaterestm091110 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "11:19");
            $result_seDaterestm101110 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "11:19");
            $result_seDatedealerinm101110 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "11:19");
            $result_seDaterestm111110 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "11:19");
            $result_seDaterestm121110 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "11:19");
            $result_seDaterestm131110 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "11:19");
            $result_seDaterestm141110 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "11:19");
            $result_seDaterestm151110 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "11:19");
            $result_seDaterestm161110 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "11:19");
            $result_seDaterestm171110 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "11:19");
            $result_seDaterestm181110 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "11:19");
            $result_seDaterestm191110 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "11:19");
            $result_seDaterestm201110 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "11:19");
            if ($result_seDatepresent1110 > 0) {
                $Checkdatem1110 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint1110 > 0) {
                $Checkdatem1110 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm011110 > 0) {
                $Checkdatem1110 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm021110 > 0) {
                $Checkdatem1110 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm031110 > 0) {
                $Checkdatem1110 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm041110 > 0) {
                $Checkdatem1110 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm051110 > 0) {
                $Checkdatem1110 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm061110 > 0) {
                $Checkdatem1110 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm071110 > 0) {
                $Checkdatem1110 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm081110 > 0) {
                $Checkdatem1110 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm091110 > 0) {
                $Checkdatem1110 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDatedealerinm101110 > 0) {
                $Checkdatem1110 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm111110 > 0) {
                $Checkdatem1110 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm121110 > 0) {
                $Checkdatem1110 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm131110 > 0) {
                $Checkdatem1110 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm141110 > 0) {
                $Checkdatem1110 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm151110 > 0) {
                $Checkdatem1110 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm161110 > 0) {
                $Checkdatem1110 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm171110 > 0) {
                $Checkdatem1110 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm181110 > 0) {
                $Checkdatem1110 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm191110 > 0) {
                $Checkdatem1110 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm201110 > 0) {
                $Checkdatem1110 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            } else {
                $Checkdatem1110 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }
            $Checkdatem1120 = "";
            $result_seDatepresent1120 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "11:20", "11:29");
            $result_seDatevlint1120 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "11:29");
            $result_seDaterestm011120 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "11:29");
            $result_seDaterestm021120 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "11:29");
            $result_seDaterestm031120 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "11:29");
            $result_seDaterestm041120 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "11:29");
            $result_seDaterestm051120 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "11:29");
            $result_seDaterestm061120 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "11:29");
            $result_seDaterestm071120 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "11:29");
            $result_seDaterestm081120 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "11:29");
            $result_seDaterestm091120 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "11:29");
            $result_seDaterestm101120 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "11:29");
            $result_seDatedealerinm101120 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "11:29");
            $result_seDaterestm111120 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "11:29");
            $result_seDaterestm121120 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "11:29");
            $result_seDaterestm131120 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "11:29");
            $result_seDaterestm141120 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "11:29");
            $result_seDaterestm151120 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "11:29");
            $result_seDaterestm161120 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "11:29");
            $result_seDaterestm171120 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "11:29");
            $result_seDaterestm181120 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "11:29");
            $result_seDaterestm191120 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "11:29");
            $result_seDaterestm201120 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "11:29");
            if ($result_seDatepresent1120 > 0) {
                $Checkdatem1120 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint1120 > 0) {
                $Checkdatem1120 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm011120 > 0) {
                $Checkdatem1120 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm0205200 > 0) {
                $Checkdatem1120 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm031120 > 0) {
                $Checkdatem1120 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm041120 > 0) {
                $Checkdatem1120 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm051120 > 0) {
                $Checkdatem1120 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm061120 > 0) {
                $Checkdatem1120 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm071120 > 0) {
                $Checkdatem1120 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm081120 > 0) {
                $Checkdatem1120 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm091120 > 0) {
                $Checkdatem1120 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm101120 > 0) {
                $Checkdatem1120 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            } else if ($result_seDatedealerinm101120 > 0) {
                $Checkdatem1120 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm111120 > 0) {
                $Checkdatem1120 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm121120 > 0) {
                $Checkdatem1120 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm131120 > 0) {
                $Checkdatem1120 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm141120 > 0) {
                $Checkdatem1120 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm151120 > 0) {
                $Checkdatem1120 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm161120 > 0) {
                $Checkdatem1120 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm171120 > 0) {
                $Checkdatem1120 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm181120 > 0) {
                $Checkdatem1120 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm191120 > 0) {
                $Checkdatem1120 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm201120 > 0) {
                $Checkdatem1120 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem1120 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }

            $Checkdatem1130 = "";
            $result_seDatepresent1130 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "11:30", "11:39");
            $result_seDatevlint1130 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "11:39");
            $result_seDaterestm011130 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "11:39");
            $result_seDaterestm021130 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "11:39");
            $result_seDaterestm031130 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "11:39");
            $result_seDaterestm041130 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "11:39");
            $result_seDaterestm051130 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "11:39");
            $result_seDaterestm061130 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "11:39");
            $result_seDaterestm071130 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "11:39");
            $result_seDaterestm081130 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "11:39");
            $result_seDaterestm091130 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "11:39");
            $result_seDaterestm101130 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "11:39");
            $result_seDatedealerinm101130 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "11:39");
            $result_seDaterestm111130 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "11:39");
            $result_seDaterestm121130 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "11:39");
            $result_seDaterestm131130 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "11:39");
            $result_seDaterestm141130 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "11:39");
            $result_seDaterestm151130 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "11:39");
            $result_seDaterestm161130 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "11:39");
            $result_seDaterestm171130 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "11:39");
            $result_seDaterestm181130 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "11:39");
            $result_seDaterestm191130 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "11:39");
            $result_seDaterestm201130 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "11:39");
            if ($result_seDatepresent1130 > 0) {
                $Checkdatem1130 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint1130 > 0) {
                $Checkdatem1130 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm011130 > 0) {
                $Checkdatem1130 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm021130 > 0) {
                $Checkdatem1130 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm031130 > 0) {
                $Checkdatem1130 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm041130 > 0) {
                $Checkdatem1130 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm051130 > 0) {
                $Checkdatem1130 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm061130 > 0) {
                $Checkdatem1130 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm071130 > 0) {
                $Checkdatem1130 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm081130 > 0) {
                $Checkdatem1130 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm091130 > 0) {
                $Checkdatem1130 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm101130 > 0) {
                $Checkdatem1130 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            } else if ($result_seDatedealerinm101130 > 0) {
                $Checkdatem1130 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm111130 > 0) {
                $Checkdatem1130 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm121130 > 0) {
                $Checkdatem1130 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm131130 > 0) {
                $Checkdatem1130 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm141130 > 0) {
                $Checkdatem1130 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm151130 > 0) {
                $Checkdatem1130 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm161130 > 0) {
                $Checkdatem1130 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm171130 > 0) {
                $Checkdatem1130 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm181130 > 0) {
                $Checkdatem1130 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm191130 > 0) {
                $Checkdatem1130 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm201130 > 0) {
                $Checkdatem1130 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem1130 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }
            $Checkdatem1140 = "";
            $result_seDatepresent1140 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "11:40", "11:49");
            $result_seDatevlint1140 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "11:49");
            $result_seDaterestm011140 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "11:49");
            $result_seDaterestm021140 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "11:49");
            $result_seDaterestm031140 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "11:49");
            $result_seDaterestm041140 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "11:49");
            $result_seDaterestm051140 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "11:49");
            $result_seDaterestm061140 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "11:49");
            $result_seDaterestm071140 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "11:49");
            $result_seDaterestm081140 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "11:49");
            $result_seDaterestm091140 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "11:49");
            $result_seDaterestm101140 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "11:49");
            $result_seDatedealerinm101140 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "11:49");
            $result_seDaterestm111140 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "11:49");
            $result_seDaterestm121140 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "11:49");
            $result_seDaterestm131140 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "11:49");
            $result_seDaterestm141140 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "11:49");
            $result_seDaterestm151140 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "11:49");
            $result_seDaterestm161140 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "11:49");
            $result_seDaterestm171140 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "11:49");
            $result_seDaterestm181140 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "11:49");
            $result_seDaterestm191140 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "11:49");
            $result_seDaterestm201140 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "11:49");
            if ($result_seDatepresent1140 > 0) {
                $Checkdatem1140 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint1140 > 0) {
                $Checkdatem1140 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm011140 > 0) {
                $Checkdatem1140 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm0205400 > 0) {
                $Checkdatem1140 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm031140 > 0) {
                $Checkdatem1140 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm041140 > 0) {
                $Checkdatem1140 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm051140 > 0) {
                $Checkdatem1140 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm061140 > 0) {
                $Checkdatem1140 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm071140 > 0) {
                $Checkdatem1140 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm081140 > 0) {
                $Checkdatem1140 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm091140 > 0) {
                $Checkdatem1140 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm101140 > 0) {
                $Checkdatem1140 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            } else if ($result_seDatedealerinm101140 > 0) {
                $Checkdatem1140 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm111140 > 0) {
                $Checkdatem1140 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm121140 > 0) {
                $Checkdatem1140 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm131140 > 0) {
                $Checkdatem1140 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm141140 > 0) {
                $Checkdatem1140 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm151140 > 0) {
                $Checkdatem1140 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm161140 > 0) {
                $Checkdatem1140 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm171140 > 0) {
                $Checkdatem1140 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm181140 > 0) {
                $Checkdatem1140 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm191140 > 0) {
                $Checkdatem1140 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm201140 > 0) {
                $Checkdatem1140 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem1140 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }

            $Checkdatem1150 = "";
            $result_seDatepresent1150 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "11:50", "11:59");
            $result_seDatevlint1150 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "11:59");
            $result_seDaterestm011150 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "11:59");
            $result_seDaterestm021150 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "11:59");
            $result_seDaterestm031150 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "11:59");
            $result_seDaterestm041150 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "11:59");
            $result_seDaterestm051150 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "11:59");
            $result_seDaterestm061150 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "11:59");
            $result_seDaterestm071150 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "11:59");
            $result_seDaterestm081150 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "11:59");
            $result_seDaterestm091150 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "11:59");
            $result_seDaterestm101150 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "11:59");
            $result_seDatedealerinm101150 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "11:59");
            $result_seDaterestm111150 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "11:59");
            $result_seDaterestm121150 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "11:59");
            $result_seDaterestm131150 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "11:59");
            $result_seDaterestm141150 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "11:59");
            $result_seDaterestm151150 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "11:59");
            $result_seDaterestm161150 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "11:59");
            $result_seDaterestm171150 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "11:59");
            $result_seDaterestm181150 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "11:59");
            $result_seDaterestm191150 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "11:59");
            $result_seDaterestm201150 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "11:59");
            if ($result_seDatepresent1150 > 0) {
                $Checkdatem1150 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint1150 > 0) {
                $Checkdatem1150 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm011150 > 0) {
                $Checkdatem1150 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm021150 > 0) {
                $Checkdatem1150 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm031150 > 0) {
                $Checkdatem1150 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm041150 > 0) {
                $Checkdatem1150 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm051150 > 0) {
                $Checkdatem1150 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm061150 > 0) {
                $Checkdatem1150 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm071150 > 0) {
                $Checkdatem1150 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm081150 > 0) {
                $Checkdatem1150 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm091150 > 0) {
                $Checkdatem1150 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm101150 > 0) {
                $Checkdatem1150 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            } else if ($result_seDatedealerinm101150 > 0) {
                $Checkdatem1150 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm111150 > 0) {
                $Checkdatem1150 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm121150 > 0) {
                $Checkdatem1150 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm131150 > 0) {
                $Checkdatem1150 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm141150 > 0) {
                $Checkdatem1150 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm151150 > 0) {
                $Checkdatem1150 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm161150 > 0) {
                $Checkdatem1150 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm171150 > 0) {
                $Checkdatem1150 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm181150 > 0) {
                $Checkdatem1150 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm191150 > 0) {
                $Checkdatem1150 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm201150 > 0) {
                $Checkdatem1150 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem1150 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }
            
            
            
            
             $Checkdatem1200 = "";
            $result_seDatepresentm1200 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "12:00", "12:09");
            $result_seDatevlintm1200 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "12:09");
            $result_seDaterestm011200 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "12:09");
            $result_seDaterestm021200 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "12:09");
            $result_seDaterestm031200 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "12:09");
            $result_seDaterestm041200 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "12:09");
            $result_seDaterestm051200 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "12:09");
            $result_seDaterestm061200 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "12:09");
            $result_seDaterestm071200 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "12:09");
            $result_seDaterestm081200 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "12:09");
            $result_seDaterestm091200 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "12:09");
            $result_seDaterestm101200 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "12:09");
            $result_seDatedealerinm101200 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "12:09");
            $result_seDaterestm111200 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "12:09");
            $result_seDaterestm121200 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "12:09");
            $result_seDaterestm131200 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "12:09");
            $result_seDaterestm141200 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "12:09");
            $result_seDaterestm151200 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "12:09");
            $result_seDaterestm161200 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "12:09");
            $result_seDaterestm171200 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "12:09");
            $result_seDaterestm181200 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "12:09");
            $result_seDaterestm191200 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "12:09");
            $result_seDaterestm201200 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "12:09");
            if ($result_seDatepresentm1200 > 0) {
                $Checkdatem1200 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlintm1200 > 0) {
                $Checkdatem1200 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm011200 > 0) {
                $Checkdatem1200 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm021200 > 0) {
                $Checkdatem1200 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm031200 > 0) {
                $Checkdatem1200 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm041200 > 0) {
                $Checkdatem1200 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm051200 > 0) {
                $Checkdatem1200 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm061200 > 0) {
                $Checkdatem1200 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm071200 > 0) {
                $Checkdatem1200 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm081200 > 0) {
                $Checkdatem1200 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm091200 > 0) {
                $Checkdatem1200 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm101200 > 0) {
                $Checkdatem1200 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            }else if ($result_seDatedealerinm101200 > 0) {
                $Checkdatem1200 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm111200 > 0) {
                $Checkdatem1200 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm121200 > 0) {
                $Checkdatem1200 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm131200 > 0) {
                $Checkdatem1200 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm141200 > 0) {
                $Checkdatem1200 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm151200 > 0) {
                $Checkdatem1200 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm161200 > 0) {
                $Checkdatem1200 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm171200 > 0) {
                $Checkdatem1200 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm181200 > 0) {
                $Checkdatem1200 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm191200 > 0) {
                $Checkdatem1200 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm201200 > 0) {
                $Checkdatem1200 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem1200 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }

            $Checkdatem1210 = "";
            $result_seDatepresent1210 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "12:10", "12:19");
            $result_seDatevlint1210 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "12:19");
            $result_seDaterestm011210 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "12:19");
            $result_seDaterestm021210 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "12:19");
            $result_seDaterestm031210 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "12:19");
            $result_seDaterestm041210 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "12:19");
            $result_seDaterestm051210 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "12:19");
            $result_seDaterestm061210 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "12:19");
            $result_seDaterestm071210 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "12:19");
            $result_seDaterestm081210 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "12:19");
            $result_seDaterestm091210 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "12:19");
            $result_seDaterestm101210 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "12:19");
            $result_seDatedealerinm101210 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "12:19");
            $result_seDaterestm111210 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "12:19");
            $result_seDaterestm121210 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "12:19");
            $result_seDaterestm131210 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "12:19");
            $result_seDaterestm141210 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "12:19");
            $result_seDaterestm151210 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "12:19");
            $result_seDaterestm161210 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "12:19");
            $result_seDaterestm171210 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "12:19");
            $result_seDaterestm181210 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "12:19");
            $result_seDaterestm191210 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "12:19");
            $result_seDaterestm201210 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "12:19");
            if ($result_seDatepresent1210 > 0) {
                $Checkdatem1210 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint1210 > 0) {
                $Checkdatem1210 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm011210 > 0) {
                $Checkdatem1210 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm021210 > 0) {
                $Checkdatem1210 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm031210 > 0) {
                $Checkdatem1210 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm041210 > 0) {
                $Checkdatem1210 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm051210 > 0) {
                $Checkdatem1210 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm061210 > 0) {
                $Checkdatem1210 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm071210 > 0) {
                $Checkdatem1210 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm081210 > 0) {
                $Checkdatem1210 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm091210 > 0) {
                $Checkdatem1210 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDatedealerinm101210 > 0) {
                $Checkdatem1210 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm111210 > 0) {
                $Checkdatem1210 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm121210 > 0) {
                $Checkdatem1210 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm131210 > 0) {
                $Checkdatem1210 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm141210 > 0) {
                $Checkdatem1210 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm151210 > 0) {
                $Checkdatem1210 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm161210 > 0) {
                $Checkdatem1210 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm171210 > 0) {
                $Checkdatem1210 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm181210 > 0) {
                $Checkdatem1210 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm191210 > 0) {
                $Checkdatem1210 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm201210 > 0) {
                $Checkdatem1210 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            } else {
                $Checkdatem1210 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }
            $Checkdatem1220 = "";
            $result_seDatepresent1220 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "12:20", "12:29");
            $result_seDatevlint1220 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "12:29");
            $result_seDaterestm011220 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "12:29");
            $result_seDaterestm021220 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "12:29");
            $result_seDaterestm031220 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "12:29");
            $result_seDaterestm041220 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "12:29");
            $result_seDaterestm051220 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "12:29");
            $result_seDaterestm061220 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "12:29");
            $result_seDaterestm071220 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "12:29");
            $result_seDaterestm081220 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "12:29");
            $result_seDaterestm091220 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "12:29");
            $result_seDaterestm101220 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "12:29");
            $result_seDatedealerinm101220 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "12:29");
            $result_seDaterestm111220 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "12:29");
            $result_seDaterestm121220 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "12:29");
            $result_seDaterestm131220 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "12:29");
            $result_seDaterestm141220 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "12:29");
            $result_seDaterestm151220 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "12:29");
            $result_seDaterestm161220 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "12:29");
            $result_seDaterestm171220 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "12:29");
            $result_seDaterestm181220 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "12:29");
            $result_seDaterestm191220 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "12:29");
            $result_seDaterestm201220 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "12:29");
            if ($result_seDatepresent1220 > 0) {
                $Checkdatem1220 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint1220 > 0) {
                $Checkdatem1220 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm011220 > 0) {
                $Checkdatem1220 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm0205200 > 0) {
                $Checkdatem1220 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm031220 > 0) {
                $Checkdatem1220 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm041220 > 0) {
                $Checkdatem1220 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm051220 > 0) {
                $Checkdatem1220 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm061220 > 0) {
                $Checkdatem1220 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm071220 > 0) {
                $Checkdatem1220 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm081220 > 0) {
                $Checkdatem1220 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm091220 > 0) {
                $Checkdatem1220 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm101220 > 0) {
                $Checkdatem1220 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            } else if ($result_seDatedealerinm101220 > 0) {
                $Checkdatem1220 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm111220 > 0) {
                $Checkdatem1220 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm121220 > 0) {
                $Checkdatem1220 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm131220 > 0) {
                $Checkdatem1220 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm141220 > 0) {
                $Checkdatem1220 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm151220 > 0) {
                $Checkdatem1220 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm161220 > 0) {
                $Checkdatem1220 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm171220 > 0) {
                $Checkdatem1220 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm181220 > 0) {
                $Checkdatem1220 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm191220 > 0) {
                $Checkdatem1220 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm201220 > 0) {
                $Checkdatem1220 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem1220 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }

            $Checkdatem1230 = "";
            $result_seDatepresent1230 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "12:30", "12:39");
            $result_seDatevlint1230 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "12:39");
            $result_seDaterestm011230 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "12:39");
            $result_seDaterestm021230 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "12:39");
            $result_seDaterestm031230 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "12:39");
            $result_seDaterestm041230 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "12:39");
            $result_seDaterestm051230 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "12:39");
            $result_seDaterestm061230 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "12:39");
            $result_seDaterestm071230 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "12:39");
            $result_seDaterestm081230 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "12:39");
            $result_seDaterestm091230 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "12:39");
            $result_seDaterestm101230 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "12:39");
            $result_seDatedealerinm101230 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "12:39");
            $result_seDaterestm111230 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "12:39");
            $result_seDaterestm121230 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "12:39");
            $result_seDaterestm131230 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "12:39");
            $result_seDaterestm141230 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "12:39");
            $result_seDaterestm151230 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "12:39");
            $result_seDaterestm161230 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "12:39");
            $result_seDaterestm171230 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "12:39");
            $result_seDaterestm181230 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "12:39");
            $result_seDaterestm191230 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "12:39");
            $result_seDaterestm201230 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "12:39");
            if ($result_seDatepresent1230 > 0) {
                $Checkdatem1230 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint1230 > 0) {
                $Checkdatem1230 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm011230 > 0) {
                $Checkdatem1230 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm021230 > 0) {
                $Checkdatem1230 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm031230 > 0) {
                $Checkdatem1230 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm041230 > 0) {
                $Checkdatem1230 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm051230 > 0) {
                $Checkdatem1230 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm061230 > 0) {
                $Checkdatem1230 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm071230 > 0) {
                $Checkdatem1230 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm081230 > 0) {
                $Checkdatem1230 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm091230 > 0) {
                $Checkdatem1230 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm101230 > 0) {
                $Checkdatem1230 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            } else if ($result_seDatedealerinm101230 > 0) {
                $Checkdatem1230 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm111230 > 0) {
                $Checkdatem1230 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm121230 > 0) {
                $Checkdatem1230 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm131230 > 0) {
                $Checkdatem1230 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm141230 > 0) {
                $Checkdatem1230 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm151230 > 0) {
                $Checkdatem1230 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm161230 > 0) {
                $Checkdatem1230 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm171230 > 0) {
                $Checkdatem1230 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm181230 > 0) {
                $Checkdatem1230 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm191230 > 0) {
                $Checkdatem1230 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm201230 > 0) {
                $Checkdatem1230 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem1230 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }
            $Checkdatem1240 = "";
            $result_seDatepresent1240 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "12:40", "12:49");
            $result_seDatevlint1240 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "12:49");
            $result_seDaterestm011240 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "12:49");
            $result_seDaterestm021240 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "12:49");
            $result_seDaterestm031240 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "12:49");
            $result_seDaterestm041240 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "12:49");
            $result_seDaterestm051240 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "12:49");
            $result_seDaterestm061240 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "12:49");
            $result_seDaterestm071240 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "12:49");
            $result_seDaterestm081240 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "12:49");
            $result_seDaterestm091240 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "12:49");
            $result_seDaterestm101240 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "12:49");
            $result_seDatedealerinm101240 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "12:49");
            $result_seDaterestm111240 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "12:49");
            $result_seDaterestm121240 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "12:49");
            $result_seDaterestm131240 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "12:49");
            $result_seDaterestm141240 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "12:49");
            $result_seDaterestm151240 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "12:49");
            $result_seDaterestm161240 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "12:49");
            $result_seDaterestm171240 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "12:49");
            $result_seDaterestm181240 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "12:49");
            $result_seDaterestm191240 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "12:49");
            $result_seDaterestm201240 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "12:49");
            if ($result_seDatepresent1240 > 0) {
                $Checkdatem1240 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint1240 > 0) {
                $Checkdatem1240 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm011240 > 0) {
                $Checkdatem1240 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm0205400 > 0) {
                $Checkdatem1240 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm031240 > 0) {
                $Checkdatem1240 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm041240 > 0) {
                $Checkdatem1240 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm051240 > 0) {
                $Checkdatem1240 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm061240 > 0) {
                $Checkdatem1240 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm071240 > 0) {
                $Checkdatem1240 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm081240 > 0) {
                $Checkdatem1240 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm091240 > 0) {
                $Checkdatem1240 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm101240 > 0) {
                $Checkdatem1240 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            } else if ($result_seDatedealerinm101240 > 0) {
                $Checkdatem1240 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm111240 > 0) {
                $Checkdatem1240 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm121240 > 0) {
                $Checkdatem1240 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm131240 > 0) {
                $Checkdatem1240 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm141240 > 0) {
                $Checkdatem1240 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm151240 > 0) {
                $Checkdatem1240 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm161240 > 0) {
                $Checkdatem1240 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm171240 > 0) {
                $Checkdatem1240 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm181240 > 0) {
                $Checkdatem1240 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm191240 > 0) {
                $Checkdatem1240 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm201240 > 0) {
                $Checkdatem1240 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem1240 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }

            $Checkdatem1250 = "";
            $result_seDatepresent1250 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "12:50", "12:59");
            $result_seDatevlint1250 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "12:59");
            $result_seDaterestm011250 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "12:59");
            $result_seDaterestm021250 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "12:59");
            $result_seDaterestm031250 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "12:59");
            $result_seDaterestm041250 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "12:59");
            $result_seDaterestm051250 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "12:59");
            $result_seDaterestm061250 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "12:59");
            $result_seDaterestm071250 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "12:59");
            $result_seDaterestm081250 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "12:59");
            $result_seDaterestm091250 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "12:59");
            $result_seDaterestm101250 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "12:59");
            $result_seDatedealerinm101250 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "12:59");
            $result_seDaterestm111250 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "12:59");
            $result_seDaterestm121250 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "12:59");
            $result_seDaterestm131250 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "12:59");
            $result_seDaterestm141250 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "12:59");
            $result_seDaterestm151250 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "12:59");
            $result_seDaterestm161250 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "12:59");
            $result_seDaterestm171250 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "12:59");
            $result_seDaterestm181250 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "12:59");
            $result_seDaterestm191250 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "12:59");
            $result_seDaterestm201250 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "12:59");
            if ($result_seDatepresent1250 > 0) {
                $Checkdatem1250 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint1250 > 0) {
                $Checkdatem1250 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm011250 > 0) {
                $Checkdatem1250 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm021250 > 0) {
                $Checkdatem1250 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm031250 > 0) {
                $Checkdatem1250 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm041250 > 0) {
                $Checkdatem1250 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm051250 > 0) {
                $Checkdatem1250 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm061250 > 0) {
                $Checkdatem1250 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm071250 > 0) {
                $Checkdatem1250 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm081250 > 0) {
                $Checkdatem1250 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm091250 > 0) {
                $Checkdatem1250 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm101250 > 0) {
                $Checkdatem1250 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            } else if ($result_seDatedealerinm101250 > 0) {
                $Checkdatem1250 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm111250 > 0) {
                $Checkdatem1250 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm121250 > 0) {
                $Checkdatem1250 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm131250 > 0) {
                $Checkdatem1250 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm141250 > 0) {
                $Checkdatem1250 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm151250 > 0) {
                $Checkdatem1250 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm161250 > 0) {
                $Checkdatem1250 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm171250 > 0) {
                $Checkdatem1250 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm181250 > 0) {
                $Checkdatem1250 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm191250 > 0) {
                $Checkdatem1250 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm201250 > 0) {
                $Checkdatem1250 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem1250 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }
            
            
            
             $Checkdatem1300 = "";
            $result_seDatepresentm1300 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "13:00", "13:09");
            $result_seDatevlintm1300 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "13:09");
            $result_seDaterestm011300 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "13:09");
            $result_seDaterestm021300 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "13:09");
            $result_seDaterestm031300 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "13:09");
            $result_seDaterestm041300 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "13:09");
            $result_seDaterestm051300 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "13:09");
            $result_seDaterestm061300 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "13:09");
            $result_seDaterestm071300 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "13:09");
            $result_seDaterestm081300 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "13:09");
            $result_seDaterestm091300 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "13:09");
            $result_seDaterestm101300 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "13:09");
            $result_seDatedealerinm101300 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "13:09");
            $result_seDaterestm111300 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "13:09");
            $result_seDaterestm121300 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "13:09");
            $result_seDaterestm131300 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "13:09");
            $result_seDaterestm141300 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "13:09");
            $result_seDaterestm151300 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "13:09");
            $result_seDaterestm161300 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "13:09");
            $result_seDaterestm171300 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "13:09");
            $result_seDaterestm181300 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "13:09");
            $result_seDaterestm191300 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "13:09");
            $result_seDaterestm201300 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "13:09");
            if ($result_seDatepresentm1300 > 0) {
                $Checkdatem1300 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlintm1300 > 0) {
                $Checkdatem1300 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm011300 > 0) {
                $Checkdatem1300 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm021300 > 0) {
                $Checkdatem1300 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm031300 > 0) {
                $Checkdatem1300 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm041300 > 0) {
                $Checkdatem1300 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm051300 > 0) {
                $Checkdatem1300 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm061300 > 0) {
                $Checkdatem1300 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm071300 > 0) {
                $Checkdatem1300 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm081300 > 0) {
                $Checkdatem1300 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm091300 > 0) {
                $Checkdatem1300 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm101300 > 0) {
                $Checkdatem1300 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            }else if ($result_seDatedealerinm101300 > 0) {
                $Checkdatem1300 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm111300 > 0) {
                $Checkdatem1300 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm121300 > 0) {
                $Checkdatem1300 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm131300 > 0) {
                $Checkdatem1300 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm141300 > 0) {
                $Checkdatem1300 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm151300 > 0) {
                $Checkdatem1300 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm161300 > 0) {
                $Checkdatem1300 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm171300 > 0) {
                $Checkdatem1300 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm181300 > 0) {
                $Checkdatem1300 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm191300 > 0) {
                $Checkdatem1300 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm201300 > 0) {
                $Checkdatem1300 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem1300 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }

            $Checkdatem1310 = "";
            $result_seDatepresent1310 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "13:10", "13:19");
            $result_seDatevlint1310 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "13:19");
            $result_seDaterestm011310 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "13:19");
            $result_seDaterestm021310 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "13:19");
            $result_seDaterestm031310 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "13:19");
            $result_seDaterestm041310 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "13:19");
            $result_seDaterestm051310 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "13:19");
            $result_seDaterestm061310 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "13:19");
            $result_seDaterestm071310 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "13:19");
            $result_seDaterestm081310 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "13:19");
            $result_seDaterestm091310 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "13:19");
            $result_seDaterestm101310 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "13:19");
            $result_seDatedealerinm101310 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "13:19");
            $result_seDaterestm111310 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "13:19");
            $result_seDaterestm121310 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "13:19");
            $result_seDaterestm131310 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "13:19");
            $result_seDaterestm141310 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "13:19");
            $result_seDaterestm151310 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "13:19");
            $result_seDaterestm161310 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "13:19");
            $result_seDaterestm171310 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "13:19");
            $result_seDaterestm181310 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "13:19");
            $result_seDaterestm191310 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "13:19");
            $result_seDaterestm201310 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "13:19");
            if ($result_seDatepresent1310 > 0) {
                $Checkdatem1310 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint1310 > 0) {
                $Checkdatem1310 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm011310 > 0) {
                $Checkdatem1310 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm021310 > 0) {
                $Checkdatem1310 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm031310 > 0) {
                $Checkdatem1310 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm041310 > 0) {
                $Checkdatem1310 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm051310 > 0) {
                $Checkdatem1310 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm061310 > 0) {
                $Checkdatem1310 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm071310 > 0) {
                $Checkdatem1310 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm081310 > 0) {
                $Checkdatem1310 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm091310 > 0) {
                $Checkdatem1310 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDatedealerinm101310 > 0) {
                $Checkdatem1310 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm111310 > 0) {
                $Checkdatem1310 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm121310 > 0) {
                $Checkdatem1310 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm131310 > 0) {
                $Checkdatem1310 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm141310 > 0) {
                $Checkdatem1310 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm151310 > 0) {
                $Checkdatem1310 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm161310 > 0) {
                $Checkdatem1310 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm171310 > 0) {
                $Checkdatem1310 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm181310 > 0) {
                $Checkdatem1310 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm191310 > 0) {
                $Checkdatem1310 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm201310 > 0) {
                $Checkdatem1310 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            } else {
                $Checkdatem1310 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }
            $Checkdatem1320 = "";
            $result_seDatepresent1320 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "13:20", "13:29");
            $result_seDatevlint1320 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "13:29");
            $result_seDaterestm011320 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "13:29");
            $result_seDaterestm021320 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "13:29");
            $result_seDaterestm031320 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "13:29");
            $result_seDaterestm041320 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "13:29");
            $result_seDaterestm051320 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "13:29");
            $result_seDaterestm061320 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "13:29");
            $result_seDaterestm071320 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "13:29");
            $result_seDaterestm081320 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "13:29");
            $result_seDaterestm091320 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "13:29");
            $result_seDaterestm101320 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "13:29");
            $result_seDatedealerinm101320 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "13:29");
            $result_seDaterestm111320 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "13:29");
            $result_seDaterestm121320 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "13:29");
            $result_seDaterestm131320 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "13:29");
            $result_seDaterestm141320 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "13:29");
            $result_seDaterestm151320 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "13:29");
            $result_seDaterestm161320 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "13:29");
            $result_seDaterestm171320 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "13:29");
            $result_seDaterestm181320 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "13:29");
            $result_seDaterestm191320 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "13:29");
            $result_seDaterestm201320 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "13:29");
            if ($result_seDatepresent1320 > 0) {
                $Checkdatem1320 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint1320 > 0) {
                $Checkdatem1320 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm011320 > 0) {
                $Checkdatem1320 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm0205200 > 0) {
                $Checkdatem1320 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm031320 > 0) {
                $Checkdatem1320 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm041320 > 0) {
                $Checkdatem1320 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm051320 > 0) {
                $Checkdatem1320 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm061320 > 0) {
                $Checkdatem1320 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm071320 > 0) {
                $Checkdatem1320 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm081320 > 0) {
                $Checkdatem1320 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm091320 > 0) {
                $Checkdatem1320 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm101320 > 0) {
                $Checkdatem1320 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            } else if ($result_seDatedealerinm101320 > 0) {
                $Checkdatem1320 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm111320 > 0) {
                $Checkdatem1320 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm121320 > 0) {
                $Checkdatem1320 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm131320 > 0) {
                $Checkdatem1320 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm141320 > 0) {
                $Checkdatem1320 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm151320 > 0) {
                $Checkdatem1320 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm161320 > 0) {
                $Checkdatem1320 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm171320 > 0) {
                $Checkdatem1320 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm181320 > 0) {
                $Checkdatem1320 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm191320 > 0) {
                $Checkdatem1320 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm201320 > 0) {
                $Checkdatem1320 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem1320 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }

            $Checkdatem1330 = "";
            $result_seDatepresent1330 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "13:30", "13:39");
            $result_seDatevlint1330 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "13:39");
            $result_seDaterestm011330 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "13:39");
            $result_seDaterestm021330 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "13:39");
            $result_seDaterestm031330 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "13:39");
            $result_seDaterestm041330 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "13:39");
            $result_seDaterestm051330 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "13:39");
            $result_seDaterestm061330 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "13:39");
            $result_seDaterestm071330 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "13:39");
            $result_seDaterestm081330 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "13:39");
            $result_seDaterestm091330 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "13:39");
            $result_seDaterestm101330 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "13:39");
            $result_seDatedealerinm101330 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "13:39");
            $result_seDaterestm111330 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "13:39");
            $result_seDaterestm121330 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "13:39");
            $result_seDaterestm131330 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "13:39");
            $result_seDaterestm141330 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "13:39");
            $result_seDaterestm151330 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "13:39");
            $result_seDaterestm161330 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "13:39");
            $result_seDaterestm171330 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "13:39");
            $result_seDaterestm181330 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "13:39");
            $result_seDaterestm191330 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "13:39");
            $result_seDaterestm201330 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "13:39");
            if ($result_seDatepresent1330 > 0) {
                $Checkdatem1330 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint1330 > 0) {
                $Checkdatem1330 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm011330 > 0) {
                $Checkdatem1330 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm021330 > 0) {
                $Checkdatem1330 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm031330 > 0) {
                $Checkdatem1330 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm041330 > 0) {
                $Checkdatem1330 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm051330 > 0) {
                $Checkdatem1330 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm061330 > 0) {
                $Checkdatem1330 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm071330 > 0) {
                $Checkdatem1330 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm081330 > 0) {
                $Checkdatem1330 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm091330 > 0) {
                $Checkdatem1330 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm101330 > 0) {
                $Checkdatem1330 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            } else if ($result_seDatedealerinm101330 > 0) {
                $Checkdatem1330 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm111330 > 0) {
                $Checkdatem1330 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm121330 > 0) {
                $Checkdatem1330 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm131330 > 0) {
                $Checkdatem1330 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm141330 > 0) {
                $Checkdatem1330 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm151330 > 0) {
                $Checkdatem1330 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm161330 > 0) {
                $Checkdatem1330 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm171330 > 0) {
                $Checkdatem1330 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm181330 > 0) {
                $Checkdatem1330 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm191330 > 0) {
                $Checkdatem1330 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm201330 > 0) {
                $Checkdatem1330 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem1330 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }
            $Checkdatem1340 = "";
            $result_seDatepresent1340 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "13:40", "13:49");
            $result_seDatevlint1340 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "13:49");
            $result_seDaterestm011340 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "13:49");
            $result_seDaterestm021340 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "13:49");
            $result_seDaterestm031340 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "13:49");
            $result_seDaterestm041340 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "13:49");
            $result_seDaterestm051340 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "13:49");
            $result_seDaterestm061340 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "13:49");
            $result_seDaterestm071340 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "13:49");
            $result_seDaterestm081340 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "13:49");
            $result_seDaterestm091340 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "13:49");
            $result_seDaterestm101340 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "13:49");
            $result_seDatedealerinm101340 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "13:49");
            $result_seDaterestm111340 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "13:49");
            $result_seDaterestm121340 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "13:49");
            $result_seDaterestm131340 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "13:49");
            $result_seDaterestm141340 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "13:49");
            $result_seDaterestm151340 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "13:49");
            $result_seDaterestm161340 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "13:49");
            $result_seDaterestm171340 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "13:49");
            $result_seDaterestm181340 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "13:49");
            $result_seDaterestm191340 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "13:49");
            $result_seDaterestm201340 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "13:49");
            if ($result_seDatepresent1340 > 0) {
                $Checkdatem1340 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint1340 > 0) {
                $Checkdatem1340 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm011340 > 0) {
                $Checkdatem1340 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm0205400 > 0) {
                $Checkdatem1340 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm031340 > 0) {
                $Checkdatem1340 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm041340 > 0) {
                $Checkdatem1340 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm051340 > 0) {
                $Checkdatem1340 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm061340 > 0) {
                $Checkdatem1340 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm071340 > 0) {
                $Checkdatem1340 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm081340 > 0) {
                $Checkdatem1340 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm091340 > 0) {
                $Checkdatem1340 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm101340 > 0) {
                $Checkdatem1340 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            } else if ($result_seDatedealerinm101340 > 0) {
                $Checkdatem1340 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm111340 > 0) {
                $Checkdatem1340 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm121340 > 0) {
                $Checkdatem1340 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm131340 > 0) {
                $Checkdatem1340 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm141340 > 0) {
                $Checkdatem1340 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm151340 > 0) {
                $Checkdatem1340 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm161340 > 0) {
                $Checkdatem1340 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm171340 > 0) {
                $Checkdatem1340 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm181340 > 0) {
                $Checkdatem1340 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm191340 > 0) {
                $Checkdatem1340 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm201340 > 0) {
                $Checkdatem1340 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR20</td>';
            }else {
                $Checkdatem1340 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }

            $Checkdatem1350 = "";
            $result_seDatepresent1350 = dateCheck($result_seVehicletransportplanreport['DATEPRESENT'], "Monday", "13:50", "13:59");
            $result_seDatevlint1350 = dateCheck($result_seVehicletransportplanreport['DATEVLIN'], "Monday", $result_seVehicletransportplanreport['TIMEVLIN'], "13:59");
            $result_seDaterestm011350 = dateCheck($result_seVehicletransportplanreport['RESTDTE_01'], "Monday", $result_seVehicletransportplanreport['TIMEREST01'], "13:59");
            $result_seDaterestm021350 = dateCheck($result_seVehicletransportplanreport['RESTDTE_02'], "Monday", $result_seVehicletransportplanreport['TIMEREST02'], "13:59");
            $result_seDaterestm031350 = dateCheck($result_seVehicletransportplanreport['RESTDTE_03'], "Monday", $result_seVehicletransportplanreport['TIMEREST03'], "13:59");
            $result_seDaterestm041350 = dateCheck($result_seVehicletransportplanreport['RESTDTE_04'], "Monday", $result_seVehicletransportplanreport['TIMEREST04'], "13:59");
            $result_seDaterestm051350 = dateCheck($result_seVehicletransportplanreport['RESTDTE_05'], "Monday", $result_seVehicletransportplanreport['TIMEREST05'], "13:59");
            $result_seDaterestm061350 = dateCheck($result_seVehicletransportplanreport['RESTDTE_06'], "Monday", $result_seVehicletransportplanreport['TIMEREST06'], "13:59");
            $result_seDaterestm071350 = dateCheck($result_seVehicletransportplanreport['RESTDTE_07'], "Monday", $result_seVehicletransportplanreport['TIMEREST07'], "13:59");
            $result_seDaterestm081350 = dateCheck($result_seVehicletransportplanreport['RESTDTE_08'], "Monday", $result_seVehicletransportplanreport['TIMEREST08'], "13:59");
            $result_seDaterestm091350 = dateCheck($result_seVehicletransportplanreport['RESTDTE_09'], "Monday", $result_seVehicletransportplanreport['TIMEREST09'], "13:59");
            $result_seDaterestm101350 = dateCheck($result_seVehicletransportplanreport['RESTDTE_10'], "Monday", $result_seVehicletransportplanreport['TIMEREST10'], "13:59");
            $result_seDatedealerinm101350 = dateCheck($result_seVehicletransportplanreport['DATEDEALERIN'], "Monday", $result_seVehicletransportplanreport['TIMEDEALERIN'], "13:59");
            $result_seDaterestm111350 = dateCheck($result_seVehicletransportplanreport['RESTDTE_11'], "Monday", $result_seVehicletransportplanreport['TIMEREST11'], "13:59");
            $result_seDaterestm121350 = dateCheck($result_seVehicletransportplanreport['RESTDTE_12'], "Monday", $result_seVehicletransportplanreport['TIMEREST12'], "13:59");
            $result_seDaterestm131350 = dateCheck($result_seVehicletransportplanreport['RESTDTE_13'], "Monday", $result_seVehicletransportplanreport['TIMEREST13'], "13:59");
            $result_seDaterestm141350 = dateCheck($result_seVehicletransportplanreport['RESTDTE_14'], "Monday", $result_seVehicletransportplanreport['TIMEREST14'], "13:59");
            $result_seDaterestm151350 = dateCheck($result_seVehicletransportplanreport['RESTDTE_15'], "Monday", $result_seVehicletransportplanreport['TIMEREST15'], "13:59");
            $result_seDaterestm161350 = dateCheck($result_seVehicletransportplanreport['RESTDTE_16'], "Monday", $result_seVehicletransportplanreport['TIMEREST16'], "13:59");
            $result_seDaterestm171350 = dateCheck($result_seVehicletransportplanreport['RESTDTE_17'], "Monday", $result_seVehicletransportplanreport['TIMEREST17'], "13:59");
            $result_seDaterestm181350 = dateCheck($result_seVehicletransportplanreport['RESTDTE_18'], "Monday", $result_seVehicletransportplanreport['TIMEREST18'], "13:59");
            $result_seDaterestm191350 = dateCheck($result_seVehicletransportplanreport['RESTDTE_19'], "Monday", $result_seVehicletransportplanreport['TIMEREST19'], "13:59");
            $result_seDaterestm201350 = dateCheck($result_seVehicletransportplanreport['RESTDTE_20'], "Monday", $result_seVehicletransportplanreport['TIMEREST20'], "13:59");
            if ($result_seDatepresent1350 > 0) {
                $Checkdatem1350 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#85C1E9;">TENKO</td>';
            } else if ($result_seDatevlint1350 > 0) {
                $Checkdatem1350 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#ff9900;">LOADING</td>';
            } else if ($result_seDaterestm011350 > 0) {
                $Checkdatem1350 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR01</td>';
            } else if ($result_seDaterestm021350 > 0) {
                $Checkdatem1350 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR02</td>';
            } else if ($result_seDaterestm031350 > 0) {
                $Checkdatem1350 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR03</td>';
            } else if ($result_seDaterestm041350 > 0) {
                $Checkdatem1350 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR04</td>';
            } else if ($result_seDaterestm051350 > 0) {
                $Checkdatem1350 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR05</td>';
            } else if ($result_seDaterestm061350 > 0) {
                $Checkdatem1350 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR06</td>';
            } else if ($result_seDaterestm071350 > 0) {
                $Checkdatem1350 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR07</td>';
            } else if ($result_seDaterestm081350 > 0) {
                $Checkdatem1350 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR08</td>';
            } else if ($result_seDaterestm091350 > 0) {
                $Checkdatem1350 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR09</td>';
            } else if ($result_seDaterestm101350 > 0) {
                $Checkdatem1350 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR10</td>';
            } else if ($result_seDatedealerinm101350 > 0) {
                $Checkdatem1350 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">UNLOADING</td>';
            } else if ($result_seDaterestm111350 > 0) {
                $Checkdatem1350 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR11</td>';
            } else if ($result_seDaterestm121350 > 0) {
                $Checkdatem1350 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR12</td>';
            } else if ($result_seDaterestm131350 > 0) {
                $Checkdatem1350 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR13</td>';
            } else if ($result_seDaterestm141350 > 0) {
                $Checkdatem1350 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR14</td>';
            } else if ($result_seDaterestm151350 > 0) {
                $Checkdatem1350 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR15</td>';
            } else if ($result_seDaterestm161350 > 0) {
                $Checkdatem1350 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR16</td>';
            } else if ($result_seDaterestm171350 > 0) {
                $Checkdatem1350 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR17</td>';
            } else if ($result_seDaterestm181350 > 0) {
                $Checkdatem1350 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR18</td>';
            } else if ($result_seDaterestm191350 > 0) {
                $Checkdatem1350 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">RESR19</td>';
            } else if ($result_seDaterestm201350 > 0) {
                $Checkdatem1350 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;background-color:#AED6F1;">'.$result_seVehicletransportplanreport['TIMEVLIN'].'</td>';
            }else {
                $Checkdatem1350 = '<td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>';
            }
            ?>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;" ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;" >RRR</td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;" ></td>
            <td style="border-right:1px solid #000;padding:4px;text-align:center;" >&nbsp;</td>
            <?= $Checkdatem0500 ?>
            <?= $Checkdatem0510 ?>
            <?= $Checkdatem0520 ?>
            <?= $Checkdatem0530 ?>
            <?= $Checkdatem0540 ?>
            <?= $Checkdatem0550 ?>
            <?= $Checkdatem0600 ?>
            <?= $Checkdatem0610 ?>
            <?= $Checkdatem0620 ?>
            <?= $Checkdatem0630 ?>
            <?= $Checkdatem0640 ?>
            <?= $Checkdatem0650 ?>
            <?= $Checkdatem0700 ?>
            <?= $Checkdatem0710 ?>
            <?= $Checkdatem0720 ?>
            <?= $Checkdatem0730 ?>
            <?= $Checkdatem0740 ?>
            <?= $Checkdatem0750 ?>
            <?= $Checkdatem0800 ?>
            <?= $Checkdatem0810 ?>
            <?= $Checkdatem0820 ?>
            <?= $Checkdatem0830 ?>
            <?= $Checkdatem0840 ?>
            <?= $Checkdatem0850 ?>
            <?= $Checkdatem0900 ?>
            <?= $Checkdatem0910 ?>
            <?= $Checkdatem0920 ?>
            <?= $Checkdatem0930 ?>
            <?= $Checkdatem0940 ?>
            <?= $Checkdatem0950 ?>
            <?= $Checkdatem1000 ?>
            <?= $Checkdatem1010 ?>
            <?= $Checkdatem1020 ?>
            <?= $Checkdatem1030 ?>
            <?= $Checkdatem1040 ?>
            <?= $Checkdatem1050 ?>
            <?= $Checkdatem1100 ?>
            <?= $Checkdatem1110 ?>
            <?= $Checkdatem1120 ?>
            <?= $Checkdatem1130 ?>
            <?= $Checkdatem1140 ?>
            <?= $Checkdatem1150 ?>
            <?= $Checkdatem1200 ?>
            <?= $Checkdatem1210 ?>
            <?= $Checkdatem1220 ?>
            <?= $Checkdatem1230 ?>
            <?= $Checkdatem1240 ?>
            <?= $Checkdatem1250 ?>
            <?= $Checkdatem1300 ?>
            <?= $Checkdatem1310 ?>
            <?= $Checkdatem1320 ?>
            <?= $Checkdatem1330 ?>
            <?= $Checkdatem1340 ?>
            <?= $Checkdatem1350 ?>

        </tr>
        <?php
    }
    ?>
</table>

<?php
sqlsrv_close($conn);
?>

